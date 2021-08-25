<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;

class catalogsController extends Controller
{
    private $catalog;

    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    public function index()
    {
        $userCatalog = auth()->user()->catalogs()->paginate(15);

        // dd($userCatalog);

        return view('dashboard.catalogs.create',['catalogs' => $userCatalog]);
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
        $data = $request->all();

        $user = auth()->user();

        $catalog = $user->catalogs()->create($data);

        return back()->with('success','Produto cadastrado com sucesso!');
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
        $setProduct = Catalog::find($productId);
        // dd($product);
        $setProduct->delete();

        return back()->with('success','Produto deletado com sucesso do catalogo!');
    }
}
