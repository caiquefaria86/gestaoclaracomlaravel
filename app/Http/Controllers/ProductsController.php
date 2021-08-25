<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller

{
    private $product;

    public function __contruct(Product $product)
    {
        $this->product = $product;
    }


    public function index()
    {
        $userCatalog = auth()->user()->catalogs()->paginate(999);

        // dd($userCatalog);
        $userId = auth()->user()->id;
        //produtos acima da quantidade
        $userProduct = Product::where('qtd', '>', 0)
            ->where('user_id', $userId)
            ->paginate(15);

        return view('dashboard.products.create', [
            'products' => $userProduct,
            'catalogs' => $userCatalog
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            // dd($request->all());
            $id_user = auth()->user();
            // dd($id_user->id);
            $productRequest = $request->nomeproduto;
            // busca o produto na base dos catalogos
            $productData = Catalog::where('code_product', $productRequest)->orWhere('name', $productRequest)->first();
            // dd($productData->id);

            //verifica se a qtd informada é vazia e se sim seta com 1
            if (is_null($request->qtd)) :
                $request->qtd = 1;
            elseif ($request->qtd <= 0) :
                return back()->with('error', 'Não é possível adicionar quantidade zera ou negativas');
            endif;

            //se não encontrou nenhum dado no tabela catalogos, volta com erro
            if (is_null($productData)) :
                return back()->with('error', 'Produto não cadastrado em seu catálogo');
            endif;

            //verificação se já tem o produto no estoque, se sim, atualiza a quantidade
            $searchProductInData = Product::where('codproduct', $productData->code_product)->get();
            if (!is_null($searchProductInData->first())) :
                // dd('variavel diferente de null');
                $qtdUpdate = $request->qtd + $searchProductInData->first()->qtd;
                // dd($searchProductInData->first()->qtd);
                Product::where('codproduct', $productData->code_product)->update(['qtd' => $qtdUpdate]);

                return back()->with('success', 'Produto já existente, foi adicionado com sucesso!');

            endif;

            $product = new Product();
            $product->user_id =    $id_user->id;
            $product->codproduct = $productData->code_product;
            $product->name =       $productData->name;
            $product->qtd =        $request->qtd;
            $product->cost =       $productData->unitaryValue;
            $product->price =      $productData->finalValue;
            $product->save();

            return back()->with('success', 'Produto adicionado com sucesso!');
        } catch (Model $exception) {

            return back()->with('error', 'Erro ao inserir o produto ao estoque');
        }
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
    public function destroy($productId)
    {
        $setProduct = Product::find($productId);
        // dd($product);
        $setProduct->delete();

        return back()->with('success', 'Produto deletado com sucesso!');
    }
}
