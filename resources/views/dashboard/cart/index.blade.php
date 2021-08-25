@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 bg-ligth">
                <h3>Produtos selecionado</h3>
                <hr>
            </div>
            @if ($cart)
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Produto</th>
                        <th scope="col">Preço</th>
                        <th scope="col">qtd</th>
                        <th scope="col">ações</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $c)
                            <tr>
                                <td>{{$c['name']}}</td>
                                <td>{{$c['price']}}</td>
                                <td>{{$c['qtd']}}</td>
                                <td>
                                    <a href="{{route('dashboard.cart.remove', ['productId'=> $c->codproduct])}}" class="btn btn-sm btn-danger">Remover</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            @else
                
            @endif
            
            </div>
        </div>
    </div>
@endsection