@extends('layouts.dashboard')
@section('content')
<div class="container mt-3">
    <div class="row bg-white shadow-sm border">
        <div class="col-3 py-4 px-2">
           <div class="row">
               <div class="col-4">
                   <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
                </div>
               <div class="col-4">
                   Todos os clientes
               </div>
               <div class="col-4">
                   {{$countClients}}
               </div>
           </div>
        </div>
        <div class="col-3 py-4 px-2">
            <div class="row">
                <div class="col-4">
                    <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
                </div>
                <div class="col-4">
                    Prev. de Receb.
                </div>
                <div class="col-4">
                    R$ {{number_format($sumAllParcelsMonth, 2,',','.')}}
                </div>
            </div>
        </div>
        <div class="col-3 py-4 px-2">
            <div class="row">
                <div class="col-4">
                    <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
                </div>
                <div class="col-4">
                    Total Estoque
                </div>
                <div class="col-4">
                    R$ {{number_format($countTotalProducts, 2,',','.')}}
                </div>
            </div>
        </div>
        <div class="col-3 py-4 px-2">
            <div class="row">
                <div class="col-4">
                    <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
                </div>
                <div class="col-4">
                    % Inad. Geral
                </div>
                <div class="col-4">
                    20,52%
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-5">
        <div class="col-4 text-center"><a href="{{route('dashboard.clients.create')}}" class="btn btn-primary btn-lg px-4 py-2">+ Clientes</a></div>
        <div class="col-4 text-center"><a href="{{route('dashboard.products.index')}}" class="btn btn-primary btn-lg px-4 py-2">+ Estoque</a></div>
        <div class="col-4 text-center"><a href="{{route('dashboard.venda.index')}}" class="btn btn-primary btn-lg px-4 py-2">+ Vendas</a></div>
    </div>

    <div class="row mt-5 mx-auto">
        <div class="col-5 border bg-white shadow-sm p-3 rounded mx-auto">
            <h4>Ultimos clientes adicionados <a href="{{route('dashboard.clients.index')}}" class="btn text-primary border-primary">Todos</a></h4>
            <div class="p-1">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Telefone</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($lastClients as $client )
                        <tr>
                            <th scope="row">{{$client->id}}</th>
                            <td>{{$client->name}}</td>
                            <td>{{$client->celphone}}</td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
        <div class="col-5 border bg-white shadow-sm p-3 rounded mx-auto">
            <h4>Gráfico de venda</h4>
            <div class="p-1">
                asd
            </div>
        </div>
    </div>

    <div class="row mt-5 mx-auto">
        <div class="col-11 border bg-white shadow-sm p-3 rounded mx-auto">
            <h4>Ultimos aniversários do mês</h4>
            <div class="p-1">
                asdsa
            </div>
        </div>
    </div>
@endsection

