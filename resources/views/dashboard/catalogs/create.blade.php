@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Adicionar Produto ao catalogo</h2>
            <hr>
            <form method="POST" action="{{ route('dashboard.catalogs.store') }}">
                @csrf
                <div class="row mt-3">
                    <div class="col-1">
                        <input type="text" class="form-control" name="code_product" placeholder="Codigo Produto">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" name="name" placeholder="Nome Produto">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control" name="unitaryValue" placeholder="Valor Unitario">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control" name="finalValue" placeholder="Valor venda">
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-success btn-sm" >Adicionar Produto</button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 bg-ligth">
            <h3>Todos os produtos já adicionados ao Catalogo</h3>
        </div>
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">valor Compra</th>
                    <th scope="col">Valor de Venda</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($catalogs as $catalog)
                    <tr>
                        <th scope="row">{{$catalog->id}}</th>
                        <td>{{$catalog->name}}</td>
                        <td>{{$catalog->unitaryValue}}</td>
                        <td>{{$catalog->finalValue}}</td>
                        <td>
                            <div class="row">
                                <form action="{{route('dashboard.catalogs.destroy', ['productId' => $catalog->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash text-white"></i></button>
                                </form>
                                <a href="#" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit text-white"></i>
                                </a>
                            </div>
                            
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>
        </div>
    </div>
    {{$catalogs->links()}}
</div>
@endsection