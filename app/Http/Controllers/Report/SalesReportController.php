<?php

namespace App\Http\Controllers\Report;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesReportController extends Controller
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index($mes, $ano, $qtdpg)
    {
        $user = auth()->user();

        $sumOrders = $this->order::where('user_id', $user->id)
                                    ->whereMonth('date', $mes)
                                    ->whereYear('date', $ano)
                                    ->sum('valor');

        $countOrders = $this->order::where('user_id', $user->id)
                                    ->whereMonth('date', $mes)
                                    ->whereYear('date', $ano)
                                    ->count('valor');

        $ticketMedio = $sumOrders / $countOrders;

        $allFormPayment = $this->order::where('user_id', $user->id)
                                    ->whereMonth('date', $mes)
                                    ->whereYear('date', $ano)
                                    ->sum('valor');

        //recupera os valores totais de cada forma de pagaento
        $FormDinheiro = $this->order::where('user_id', $user->id)->where('meansofpayment', 'dinheiro')->whereMonth('date', $mes)->whereYear('date', $ano)->sum('valor');
        $FormPromissoria = $this->order::where('user_id', $user->id)->where('meansofpayment', 'promissoria')->whereMonth('date', $mes)->whereYear('date', $ano)->sum('valor');
        $FormCredito = $this->order::where('user_id', $user->id)->where('meansofpayment', 'credito')->whereMonth('date', $mes)->whereYear('date', $ano)->sum('valor');
        $FormDebito = $this->order::where('user_id', $user->id)->where('meansofpayment', 'debito')->whereMonth('date', $mes)->whereYear('date', $ano)->sum('valor');

        $porcDinheiro = $this->calcFormPayment($FormDinheiro, $allFormPayment);
        $porcPromissoria = $this->calcFormPayment($FormPromissoria, $allFormPayment);
        $porcCredito = $this->calcFormPayment($FormCredito, $allFormPayment);
        $porcDebito = $this->calcFormPayment($FormDebito, $allFormPayment);


        $clients = auth()->user()->clients()->get();

        // dd($clients);
        $sales = $this->order::whereMonth('date', $mes)
                        ->whereYear('date', $ano)
                        ->where('user_id', $user->id)
                        ->paginate($qtdpg);
        
                        // dd($sales);
        return view('dashboard.relatorios.vendas', [

            'porcCredito'   => $porcCredito,
            'porcDebito'    => $porcDebito,
            'porcPromissoria' => $porcPromissoria,
            'porcDinheiro'  => $porcDinheiro,
            'ticketMedio'   => $ticketMedio,
            'countOrders'   => $countOrders,
            'sumOrders'     =>  $sumOrders,
            'sales'         =>  $sales,
            'clients'       =>  $clients
            
        ]);
    }

    private function calcFormPayment($v1, $vtotal)
    {
        $valor = ($v1 / $vtotal) * 100;
        
        return $valor;
    }

}
