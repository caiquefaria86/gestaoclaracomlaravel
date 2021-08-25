@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 bg-ligth">
                <a class="btn btn-success m-3" href="clientes/novo">Novo cliente</a>
                <hr>
            </div>
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Apelido</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <th scope="row">{{$client->id}}</th>
                            <td>{{$client->name}}</td>
                            <td>{{$client->nickname}}</td>
                            <td>{{$client->celphone}}</td>
                            <td>
                                <div class="row">
                                    <a href="#" class="btn btn-info btn-sm mr-3">Editar</a>
                                    <form action="{{route('dashboard.clients.destroy', ['client' => $client->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input class="btn btn-danger btn-sm" type="submit" value="Delete">
                                    </form>
                                </div>
                            </td>
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