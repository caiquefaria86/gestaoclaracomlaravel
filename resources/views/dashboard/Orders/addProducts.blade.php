@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-3">
            <h3>Escolha os produtos abaixo</h3>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#">Escolha dos produtos</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Financeiro</a>
                        </li>
                      </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12 m-3">
                    <h4>Cliente : {{$client->name}}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h3>Produtos</h3>
                    <p>Selecione os produtos vendido para o(a) cliente.</p>
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">Cod</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Qtd/Estoque</th>
                            <th scope="col">Valor/Venda/unit.</th>
                            <th scope="col">Qtd/vendida</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{$product->codproduct}}</th>
                                <td>{{$product->name}}</td>
                                <td>{{$product->qtd}}</td>
                                <td>R$ {{number_format($product->price, 2,',','.')}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Qtd vendida
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @for ($i = 1; $i <= $product->qtd; $i++)
                                            <a class="dropdown-item" href="{{route('dashboard.addCart', ['productId'=>$product->codproduct, 'qtd'=>$i])}}">{{$i}}</a>
                                        @endfor
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                      </table>
                </div>
            </div>
              
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                Próxima >
            </button>
        </div>
    </div>
</div>

  

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-12 bg-ligth">
                    <h4>Produtos selecionados</h4>
                    <hr>
                </div>
                @if ($cart)
                    <div class="col-12">
                        <table class="table table-striped border my-2">
                            <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">qtd</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">ações</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($cart as $c)
                                    <tr>
                                        <td>{{$c['name']}}</td>
                                        <td>{{$c['qtd']}}</td>
                                        @php
                                            $subTotal = $c['price'] * $c['qtd'];
                                            $total += $subTotal;
                                        @endphp
                                        <td>R$ {{number_format($c['price'],2,',','.')}}</td>
                                        <td>R$ {{number_format($subTotal,2,',','.')}}</td>
                                        <td>
                                            <a href="{{route('dashboard.cart.remove', ['productId'=> $c->codproduct])}}" class="btn btn-sm btn-danger">Remover</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="float-right">Total:</td>
                                    <td colspan="1">{{number_format($total,2,',','.')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="col-12">
                        <table class="table table-striped border my-2">
                            <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Preço</th>
                                <th scope="col">qtd</th>
                                <th scope="col">ações</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum produto selecionado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
                
                
            </div>
            <div class="clearfix">
                <button type="button" class="btn btn-transparent float-left m-3" data-dismiss="modal">Adicionar mais produtos</button>
                <a type="button" href="{{route('dashboard.venda.create', ['clientId'=> $client->id])}}" class="btn btn-success float-right m-3">Etapa Pagamento ></a>
            </div>
        </div>
        </div>

      </div>
    </div>
  </div>
  
@endsection