<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Birthday;
use App\Models\User;
use App\Models\Financial;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function index()
    {
        //dd(auth()->user()->name);
        // dd(auth()->user()->clients()->paginate(15));
        $clients = auth()->user()->clients()->paginate(15);


        return view('dashboard.clients.index', ['clients' => $clients]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        $data = $request->all();
        $user = auth()->user();

        $client = $user->clients()->create($data);

        //$client->create($request->all());
        return back()->with('success','Cliente salvo com sucesso!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($clientId)
    {
        $user = auth()->user();

        $client = Client::where('user_id', $user->id)
                        ->where('id', $clientId)
                        ->first()
                        ->toArray();
        // dd($client);

        $financials = Client::find($clientId)->financials()->get();

        $orderProducts = Client::find($clientId)->orderProducts()->get();

        $birthdays = Client::find($clientId)->birthdays()->get();


        // dd($birthdays);


        return view('dashboard.clients.single',[
            'financials'        => $financials,
            'client'            => $client,
            'orderProducts'     => $orderProducts,
            'birthdays'         => $birthdays
        ]);
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
    public function destroy($client)
    {
        $client = $this->client->find($client);
        $client->delete();

        return back()->with('success','Cliente excluido com sucesso!');
    }
}
