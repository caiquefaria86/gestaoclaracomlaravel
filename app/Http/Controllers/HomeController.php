<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Financial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($mes = null, $ano = null)
    {
       
        $user = auth()->user();
        
        if($mes == null)
            //senão passado o valor de mes o default é o mes atual
            $mes = date('m');
        if($ano == null)
            //senão passado o valor de ano o default é o mes atual
            $ano = date('Y');

        // dd($mes, $ano, $qtdpg);

        $user = auth()->user();
        $countClients = Client::where('user_id', $user->id)
                                    ->count('id');

        $sumAllParcelsMonth = Financial::where('user_id', $user->id)
                                    ->whereMonth('duedate', $mes)
                                    ->whereYear('duedate', $ano)
                                    ->where('status', 0)
                                    ->sum('valor');

        $countTotalProducts = Product::where('user_id', $user->id)
                                    ->where('qtd','>', 0)
                                    ->sum('price');
        $lastClients = Client::where('user_id', $user->id)
                                    ->orderBy('id', 'desc')
                                    ->limit(5)
                                    ->get();


        // dd($lastClients);


        return view('dashboard.home.index', [
            'user'                  => $user,
            'countClients'          => $countClients,
            'sumAllParcelsMonth'    => $sumAllParcelsMonth,
            'countTotalProducts'    => $countTotalProducts,
            'lastClients'           => $lastClients
            
        ]);
    }
}
