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
                          <a class="nav-link" href="#">Escolha dos produtos</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="#" tabindex="-1" aria-disabled="true">Financeiro</a>
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
                    <h3>Venda</h3>
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                          ver produtos
                        </a>
                    </p>
                      <div class="collapse pb-4" id="collapseExample">
                        <div class="card card-body">
                            @if ($cart)
                            <div class="col-12">
                                <table class="table table-striped border">
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
                      </div>
                </div>
            </div>
            <form action="{{route('dashboard.venda.store')}}" method="post">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input name="date" type="date" class="form-control" value="@php
                            echo date('Y-m-d');
                        @endphp">
                    </div>
                    <div class="form-group col-md-3">
                        <input name="valor" type="valor" class="form-control" placeholder="R$">
                    </div>
                    <div  class="form-group col-md-3">
                        <select name="meansofpayment" id="meiodepagamento" class="form-control">
                          <option selected>Forma de Pagamento</option>
                          <option value="dinheiro">Dinheiro</option>
                          <option value="debito">Cartão de Debito</option>
                          <option value="credito">Cartão de Crédito</option>
                          <option value="promissoria">Notas Promissória</option>
                          <option value="consumo">Consumo</option>
                        </select>
                    </div>
                    <div  class="form-group col-md-3">
                        <select name="numberofinstallment" id="meiodepagamento" class="form-control">
                          <option selected value="0">Qtd Parcela</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="client_id" value="{{$client->id}}">

                <button class="btn btn-primary float-right" type="submit">Finalizar</button>
            </form>
              
        </div>
    </div>
</div>
@endsection