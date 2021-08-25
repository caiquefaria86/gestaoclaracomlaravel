<?php

namespace App\Http\Controllers\Report;

use App\Models\Financial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinancialController extends Controller
{
    private $financial;

    public function __construct(Financial $financial)
    {
        $this->financial = $financial;
    }

    public function index($mes = null, $ano = null, $qtdpg = null)
    {
       
        $user = auth()->user();
        
        if($qtdpg == null)
            //senão passado o valor de qtd por pagina o default é 50
            $qtdpg = 50;
        if($mes == null)
            //senão passado o valor de mes o default é o mes atual
            $mes = date('m');
        if($ano == null)
            //senão passado o valor de ano o default é o mes atual
            $ano = date('Y');

        // dd($mes, $ano, $qtdpg);

        $financials = $this->financial::where('user_id', $user->id)
                                    ->whereMonth('duedate', $mes)
                                    ->whereYear('duedate', $ano)
                                    ->paginate($qtdpg);

        $sumAllParcels = $this->financial::where('user_id', $user->id)
                                    ->whereMonth('duedate', $mes)
                                    ->whereYear('duedate', $ano)
                                    ->sum('valor');

        $sumAllParcelsOpen = $this->financial::where('user_id', $user->id)
                                    ->whereMonth('duedate', $mes)
                                    ->whereYear('duedate', $ano)
                                    ->where('status', 0)
                                    ->sum('valor');

        $sumAllParcelsPg = $this->financial::where('user_id', $user->id)
                                    ->whereMonth('duedate', $mes)
                                    ->whereYear('duedate', $ano)
                                    ->where('status', 1)
                                    ->sum('valor');

        $overdueAmountMonth = $this->financial::where('user_id', $user->id)
                                    ->whereMonth('duedate', $mes)
                                    ->whereYear('duedate', $ano)
                                    ->where('duedate','<', date('Y-m-d'))
                                    ->where('status', 0)
                                    ->sum('valor');

        // calcula a porcentagem de inadimplencia do mes
        $lateMonthPorc = ($overdueAmountMonth / $sumAllParcels) * 100;

        $valorAllReceive = $this->financial::where('user_id', $user->id)
                                            ->where('status', 0)
                                            ->sum('valor');
        // soma do valor atrazado do mes buscado
        $valorAllReceiveLate = $this->financial::where('user_id', $user->id)
                                            ->where('status', 0)
                                            ->where('duedate','<', date('Y-m-d'))
                                            ->sum('valor');

        //se o valor atrazado for zero corrige o bug de divizão por zero 
        $valorAllReceiveLate == 0 ? $porcAllReceive = 0 : $porcAllReceive = ($valorAllReceiveLate / $valorAllReceive ) * 100;

        // define o nome do mes referente ao mes
        setlocale(LC_TIME, 'pt-br.UTF-8');                                              
        $nameMes = strftime('%B', mktime(0, 0, 0, $mes));
        

        return view('dashboard.relatorios.financeiros', [
            'porcAllReceive'        => $porcAllReceive,
            'valorAllReceive'       => $valorAllReceive,
            'valorAllReceiveLate'   => $valorAllReceiveLate,
            'lateMonthPorc'         => $lateMonthPorc,
            'overdueAmountMonth'    => $overdueAmountMonth,
            'sumAllParcelsPg'       => $sumAllParcelsPg,
            'sumAllParcelsOpen'     => $sumAllParcelsOpen,
            'financials'            => $financials,
            'sumAllParcels'         => $sumAllParcels,
            'mes'                   => $mes,
            'nameMes'               => $nameMes,
            'ano'                   => $ano              
        ]);
    }

    public function baixar(Request $request, $idParcela)
    {
        // dd($idParcela, $request->all());
        // "valor" => "33,33"
        // "datapagamento" => "2021-07-21"
        // "vp" => "33.33"
        $data = $request->all();
        $user = auth()->user();
        $dataBanco = $this->financial::where('id', $idParcela)->first();

        $valor = str_replace(',','.', $data['valor']);
        
        if($valor == $data['vp']):
            // dd('valor igual');
            $this->financial::where('id', $idParcela)
                        ->update(['status' => true, 'payment' => $data['datapagamento']]);
            
            $feedback = "Parcela dada baixa com sucesso!";

        elseif($valor < $data['vp']):
            //atualiaza o valor da parcela, e dá baixa
            //cria uma nova parcela com as informações anteriores e com o valor da direfença
            $valorUpdate = ($valor - $data['vp']) *-1;

            $this->financial::where('id', $idParcela)
                        ->update([
                            'status' => true,
                            'payment' => $data['datapagamento'],
                            'valor' =>  $valor
                        ]);
    
            //user_id 	client_id 	valor 	duedate 	payment 	process 	status

            $np = new Financial();
            $np->user_id        = $user->id; 
            $np->client_id      = $dataBanco['client_id'];
            $np->valor          = $valorUpdate;
            $np->duedate        = $dataBanco['duedate'];
            $np->process        = $dataBanco['process'];
            $np->status         = false;
            $np->save();
            
            
            $feedback = "O valor pago foi menor que o valor da parcela, foi dado baixa no valor pago e criado uma nova com a diferença";

        elseif($valor > $data['vp']):
            $this->financial::where('id', $idParcela)
                        ->update(['status' => true, 'payment' => $data['datapagamento']]);
            
            $feedback = "Parcela dada baixa com sucesso!";
        endif;

        return redirect()->back()->with('success', $feedback);
    }


    public function destroy($idParcela)
    {
        $setParcela = Financial::find($idParcela);
        $setParcela->delete();

        return back()->with('success', 'Parcela deletada com sucesso!');
    }
}
