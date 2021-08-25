<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Financial;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clients = auth()->user()->clients()->paginate(15);

        return view('dashboard.Orders.index', ['clients' => $clients]);
    }

    public function addProducts($clientId)
    {

        $products = auth()->user()->products()->get();
        //passa todas as infos para abrir o cart dentro da pg
        $cart = session()->has('cart') ? session()->get('cart') : [];

        $client = Client::find($clientId);
        return view(
            'dashboard.Orders.addProducts',
            [
                'client'    => $client,
                'products'  => $products,
                'cart' => $cart
            ]
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($clientId)
    {
        $cart = session()->has('cart') ? session()->get('cart') : [];

        $client = Client::find($clientId);

        return view('dashboard.Orders.create', [
            'cart' => $cart,
            'client' => $client
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();

        $user = auth()->user();

        // recupera os produtos do carrinho
        $products = session()->get('cart');
        $qtdProductsRequest = count($products);

        // salva a venda na tabela orders
        $order = $user->orders()->create($data);

        // recupera o codigo do pedido inserido acima
        $order_id = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();

        // faz o loop para atualizar a quantidade de produtos
        // Adiciona na tablela orders_product
        for ($i = 0; $i < $qtdProductsRequest; $i++):

            // echo ($products[$i]);

            // var_dump($products[$i]['codproduct']);
            $productData = Product::where('codproduct', $products[$i]['codproduct'])->first();
            // dd($productData);
            $qtdData = $productData->qtd;
            $qtdUpdate = $qtdData - $products[$i]['qtd'];

            // se a qtd atualizada, dor 0 ou menos ele deleta do banco, ou atualiza
            if ($qtdUpdate <= 0) :
                Product::where('id', '=', $products[$i]['id'])->delete();
            else :
                Product::where('codproduct', $products[$i]['codproduct'])->update(['qtd' => $qtdUpdate]);
            endif;


            // inserção dos produtos na tabelar orders_product
            $product = new OrderProduct();
            $product->user_id =    $user->id;
            $product->client_id =  $data['client_id'];
            $product->order_id =   $order_id->id;
            $product->name =       $products[$i]['name'];
            $product->price =      $products[$i]['price'];
            $product->qtd =        $products[$i]['qtd'];
            $product->date =       $data['date'];
            $product->save();
        endfor;

        // user_id 	client_id 	valor 	duedate 	payment 	process 	status 

        // "_token" => "q1BWzLbUwb6bhlG16989Z8YG5Z6thrwPS6VsuTiA"
        // "date" => "2021-07-19"
        // "valor" => "150"
        // "meansofpayment" => "promissoria"
        // "numberofinstallment" => "2"
        // "client_id" => "5"

        $meansofpayment = $data['meansofpayment'];

        switch ($meansofpayment):
            case 'promissoria':
                // for($r=1; $r <= $data['numberofinstallment']; $r++):
                //     $f = new Financial();
                //     $f->user_id         = $user->id;
                //     $f->client_id       = $data['client_id'];
                //     $f->valor           = $data['valor'];
                //     $f->duedate         = $data['date'] ;
                //     $f->payment         = $data['date'] ;
                //     $f->process         = ;
                //     $f->status          = true;
                //     $f->save();
                // endfor;
                return redirect()->route(
                    'dashboard.venda.addParcelas',
                    [
                        'clientId' => $data['client_id'],
                        'valor' => $data['valor'],
                        'qtd' => $data['numberofinstallment']
                    ]
                );

                break;

            case 'dinheiro':
                $f = new Financial();
                $f->user_id         = $user->id;
                $f->client_id       = $data['client_id'];
                $f->valor           = $data['valor'];
                $f->duedate         = $data['date'];
                $f->payment         = $data['date'];
                $f->process         = "Dinheiro";
                $f->status          = true;
                $f->save();
                break;

            case 'debito':
                $f = new Financial();
                $f->user_id         = $user->id;
                $f->client_id       = $data['client_id'];
                $f->valor           = $data['valor'];
                $f->duedate         = $data['date'];
                $f->payment         = $data['date'];
                $f->process         = "Cartão de Débito";
                $f->status          = true;
                $f->save();
                break;

            case 'credito':
                $f = new Financial();
                $f->user_id         = $user->id;
                $f->client_id       = $data['client_id'];
                $f->valor           = $data['valor'];
                $f->duedate         = $data['date'];
                $f->payment         = $data['date'];
                $f->process         = "Cartão de Crédito";
                $f->status          = true;
                $f->save();
                break;
        endswitch;
        return redirect()->route('dashboard.venda.index')->with('success', 'Venda cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}


// SQLSTATE[22007]: Invalid datetime format: 1366
// Incorrect integer value: 'Qtd Parcela' for column `db_gestao`.`orders`.`numberofinstallment`at row 1 
// (SQL: insert into `orders` (`date`, `valor`, `meansofpayment`, `numberofinstallment`, `client_id`, `user_id`, `updated_at`, `created_at`) values
// (2021-07-19, 150, dinheiro, Qtd Parcela, 5, 2, 2021-07-19 20:57:15, 2021-07-19 20:57:15)) 
