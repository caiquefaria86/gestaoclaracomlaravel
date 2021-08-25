@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Relatorio de Vendas</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 border text-center">
            <div class="row">
                <div class="col">
                    <p>Total de venda</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>R$ {{number_format($sumOrders, 2, ',','.')}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 border text-center">
            <div class="row">
                <div class="col">
                    <p>Quantidade de venda</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>{{number_format($countOrders, 0, ',','.')}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 border text-center">
            <div class="row">
                <div class="col">
                    <p>Ticket Médio</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>R$ {{number_format($ticketMedio, 2, ',','.')}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 border text-center">
            <div class="row">
                <div class="col">
                    <p>Formas de Pagamentos</p>
                </div>
            </div>
            <div class="row">
                <small><span><strong>Dinheiro</strong> - {{number_format($porcDinheiro, 2,',','.')}}%</span></small>
                <small><span><strong>Cartão de Crédito</strong> - {{number_format($porcCredito, 2,',','.')}}%</span></small>
                <small><span><strong>Cartão de Débito</strong> - {{number_format($porcDebito, 2,',','.')}}%</span></small>
                <small><span><strong>Promissória</strong> - {{number_format($porcPromissoria, 2,',','.')}}%</span></small>

            </div>
        </div>
    </div>

    
    <table class="table mt-5">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Valor</th>
            <th scope="col">Forma de Pagamento</th>
            <th scope="col">Data</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($sales as $s)
            <tr>
                <th scope="row"> {{$s->id}} </th>
                <td> {{$s->client->name}} </td>
                <td>R$ {{number_format($s->valor, 2,',','.')}} </td>
                <td> {{$s->meansofpayment}} </td>
                <td> {{date("d/m/Y", strtotime($s->date))}}</td>
              </tr>
            @endforeach
          
        </tbody>
      </table>
      <div class="row">
          <div class="col-12">
              {{$sales->links()}}
          </div>
      </div>
@endsection

