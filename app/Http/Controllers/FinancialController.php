<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Financial;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function addParcelas($clientId, $valor, $qtd)
    {
        $client = Client::find($clientId);
        return view('dashboard.Orders.addparcels',
        [
            'client'=>$client,
            'valor'=> $valor,
            'qtd' => $qtd
        ]);
    }
    public function store(Request $request)
    {
        // id 	user_id 	client_id 	valor 	duedate 	payment 	process 	status 
        // dd($request->all());
        $user = auth()->user();

        $data = $request->all();
        $qtdParcels = $data['qtd'];

        for($i=1; $i <= $qtdParcels; $i++):

            $valor = str_replace(',','.',$data['valor-'.$i]);
            $process = $i.'/'.$qtdParcels;

            $f = new Financial();
            $f->user_id         = $user->id;
            $f->client_id       = $data['client_id'];
            $f->valor           = $valor;
            $f->duedate         = $data['vencimento-'.$i];
            $f->process         = $process;
            $f->status          = false;
            $f->save();
            
        endfor;
        return redirect()->route('dashboard.venda.index')
                        ->with('success','Venda cadastrada com sucesso!');
        }
}
