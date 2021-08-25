<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $cart = session()->has('cart') ? session()->get('cart') : [];

        return view('dashboard.cart.index', ['cart' => $cart]);
    }
    public function addCart($productId, $qtd)
    {
        // dd($productId, $qtd);

        $product = Product::where('codproduct', $productId)->first();
        $product->qtd = $qtd;

        if(session()->has('cart')):
            $products = session()->get('cart');

            $productIds = array_column($products, 'codproduct');

            if(in_array($productId, $productIds)):

                $products = $this->productIncrement($product['codproduct'], $qtd, $products);

                session()->put('cart', $products);
            else:
                session()->push('cart', $product);
            endif;
        else:
            session()->push('cart', $product);
        endif;

        return back()->with('success','Produto adicionado no carrinho da cliente');
    }

    public function remove($productId)
    {
        if(!session()->has('cart')):
            return redirect()->route('dashboard.cart.index')->with('error','Carrinho não inexistente');
        endif;

        $products = session()->get('cart');

        $products = array_filter($products, function($line) use ($productId){
            return $line['codproduct'] != $productId;
        });

        session()->put('cart', $products);
        return back();
    }

    private function productIncrement($productId, $qtd, $product)
    {
        $products = array_map(function($line) use ($productId, $qtd){

            if($productId == $line['codproduct']):
                $line['qtd'] += $qtd;
            endif;

            return $line; 
        }, $product);

        return $products;
    }
    
}
