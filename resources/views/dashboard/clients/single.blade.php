@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Cliente</h2>
            <hr>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="dados-tab" data-toggle="tab" href="#dados" role="tab" aria-controls="dados" aria-selected="true">Dados Cadastrais</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="financeiro-tab" data-toggle="tab" href="#financeiro" role="tab" aria-controls="financeiro" aria-selected="false">Financeiro</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="historico-tab" data-toggle="tab" href="#historico" role="tab" aria-controls="historico" aria-selected="false">Historico</a>
                </li>
            </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active border-right border-bottom border-left" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                        <div class="row my-3">
                            <div class="col-2 text-right">Nome:</div>
                            <div class="col-4 text-left">{{$client['name']}}</div>
                            <div class="col-2 text-right">Apelido:</div>
                            <div class="col-4">{{$client['nickname']}}</div>
                        </div>
                        <div class="row my-3">
                            <div class="col-2 text-right">Telefone:</div>
                            <div class="col-4 text-left">{{$client['celphone']}}</div>
                            <div class="col-2 text-right">Email:</div>
                            <div class="col-4">{{$client['email']}}</div>
                        </div>
                        <div class="row my-3">
                            <div class="col-2 text-right">Rua:</div>
                            <div class="col-4 text-left">{{$client['street']}}</div>
                            <div class="col-2 text-right">Nº:</div>
                            <div class="col-4">{{$client['number']}}</div>
                        </div>
                        <div class="row my-3">
                            <div class="col-2 text-right">Bairro:</div>
                            <div class="col-4 text-left">{{$client['district']}}</div>
                            <div class="col-2 text-right">Cidade:</div>
                            <div class="col-4">{{$client['city']}}</div>
                        </div>
                    </div>
                    <div class="tab-pane fade border-right border-bottom border-left" id="financeiro" role="tabpanel" aria-labelledby="financeiro-tab">
                        <div class="row text-center">
                            <h4 class="p-4">Financeiro do cliente</h4>
                        </div>
                        <div class="row p-2">
                            <div class="col">
                                {{-- # 	Valor 	Vencimento 	Status 	Processo 	Ação --}}
                                <table class="table mt-5 border">
                                    <thead>
                                      <tr>
                                        <th scope="col">Baixa</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Data Venc.</th>
                                        <th scope="col">Processo</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Editar/Excluir</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($financials as $f)
                                        <tr>
                                            <th>
                                                @if ($f->status)
                                                    <button class="btn btn-success">
                                                        <span class="fas fa-check-circle"></span>
                                                    </button>
                                                @else
                                                    <button class="btn btn-info" data-toggle="modal" data-target="#darbaixa{{$f->id}}">
                                                        <span class="fas fa-arrow-alt-circle-down"></span>
                                                    </button>
                                                @endif
                                            </th>
                                            <td>R$ {{number_format($f->valor, 2,',','.')}} </td>
                                            <td> {{date("d/m/Y", strtotime($f->duedate))}}</td>
                                            <td> {{$f->process}}</td>
                                            <td>
                                                @if ($f->status)
                                                    <span class="badge badge-success py-1 px-3">Pago</span>
                                                @else
                                                    <span class="badge badge-warning py-1 px-3">Em Aberto</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <button type="submit" class="btn btn-info btn-sm mr-3" data-toggle="modal" data-target="#editar{{$f->id}}">
                                                        <span class="fas fa-edit"></span>
                                                    </button>
                            
                                                    <form action="{{route('dashboard.report.financial.destroy', ['idParcela' => $f->id])}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash text-white"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                          </tr>
                            
                                            <!-- Modal Dar baixa -->
                                            <div class="modal fade" id="darbaixa{{$f->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Dar Baixa</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row px-3">
                                                            Id Parcela : #{{$f->id}}
                                                        </div>
                                                        <div class="row px-3">
                                                            Status : @if ($f->status)
                                                                Pago
                                                            @else
                                                                Em Aberto
                                                            @endif
                                                        </div>
                                                        <div class="row px-3">
                                                            Data Vencimento : {{date("d/m/Y", strtotime($f->duedate))}}
                                                        </div>
                                                        <div class="row px-3">
                                                            Valor : R$ {{number_format($f->valor, 2,',','.')}}
                                                        </div>
                                                        <hr>
                                                        <form action="{{route('dashboard.report.financial.baixar',['idParcela'=> $f->id])}}" method="post">
                                                            @csrf
                                                            <div class="row mt-3">
                                                                <div class="col-6">
                                                                    <label>Valor R$</label>
                                                                    <input type="text" class="form-control" name="valor" value="{{number_format($f->valor, 2,',','.')}}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label>Pagamento dia:</label>
                                                                    <input type="date" class="form-control" name="datapagamento" value="{{date('Y-m-d')}}">
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                    <input type="hidden" name="vp" value="{{$f->valor}}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-success">Dar Baixa</button>
                                                    </div>
                                                </form>
                                                </div>
                                                </div>
                                            </div>
                            
                                            <!-- Modal Editar-->
                                            <div class="modal fade" id="editar{{$f->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Editar Parcela</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('dashboard.report.financial.baixar',['idParcela'=> $f->id])}}" method="post">
                                                            @csrf
                                                            <div class="row mt-1">
                                                                <div class="col-6">
                                                                    <label>Valor</label>
                                                                    <input type="text" class="form-control" name="valor" value="{{number_format($f->valor, 2,',','.')}}">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label>Vencimento dia:</label>
                                                                    <input type="date" class="form-control" name="datapagamento" value="{{$f->duedate}}">
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <input type="hidden" name="vp" value="{{$f->valor}}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                                                    </div>
                                                </form>
                                                </div>
                                                </div>
                                            </div>
                              
                                        @endforeach
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade border-right border-bottom border-left" id="historico" role="tabpanel" aria-labelledby="historico-tab">
                        <div class="row">
                            <h4 class="p-4 text-center">Histórico de Compra</h4>
                        </div>
                        <div class="row">
                            {{-- id 	user_id 	client_id 	order_id 	name 	price 	qtd --}}
                            <div class="col">
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Qtd</th>
                                        <th scope="col">Preço</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp

                                        @forelse ($orderProducts as $op)
                                            <tr>
                                                @php
                                                    $subTotal = $op->qtd * $op->price;
                                                @endphp
                                                <th scope="row">{{$op->id}}</th>
                                                <td>{{$op->name}}</td>
                                                <td>{{date("d/m/Y", strtotime($op->date))}}</td>
                                                <td>{{$op->qtd}}</td>
                                                <td>R$ {{number_format($op->price, 2,',','.')}} </td>
                                            </tr>
                                            @php
                                                $total = $subTotal + $total;
                                            @endphp
                                        @empty
                                            <p>Cliente sem hitorico</p>
                                        @endforelse
                                        <tr>
                                            <td colspan="3"> Este cliente já comprou de você:</td>
                                            <td>R$ {{number_format($total, 2,',','.')}}</td>
                                        </tr>
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
@endsection