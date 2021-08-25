@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 bg-ligth">
                <h3>Clique no cliente que deseja iniciar uma venda</h3>
                <hr>
            </div>
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Apelido</th>
                        <th scope="col">Celular</th>
                      </tr>
                    </thead>
                    <tbody>
                    @forelse ($clients as $client)
                        <tr
                        style="cursor:pointer;" 
                        onclick="document.location='{{route('dashboard.venda.addProducts',['clientId'=>$client->id])}}';">
                           
                            <td>{{$client->name}}</td>
                            <td>{{$client->nickname}}</td>
                            <td>{{$client->celphone}}</td>
                        </tr>    
                    @empty
                        <p>Nenhum Cliente cadastrado</p>
                    @endforelse
                    </tbody>
                  </table>
            </div>
        </div>
        
        {{$clients->links()}}
    </div>
@endsection