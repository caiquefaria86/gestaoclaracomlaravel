@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Relatorio Financeiro</h2>
        </div>
    </div>

    <div class="row mx-auto">
        <div class="col-md-4 border border-dark rounded-lg text-center mr-2">
            <div class="row">
                <div class="col">
                    <p>Previsão de recebimento</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>R$ {{number_format($sumAllParcels, 2,',','.') }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Em Aberto: </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>R$ {{number_format($sumAllParcelsOpen, 2,',','.') }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Valor Recebido este mês:</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>R$ {{number_format($sumAllParcelsPg, 2,',','.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 border border-dark rounded-lg text-center">
            <div class="row">
                <div class="col">
                    <p>Inadimplência mês : {{$nameMes}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>R$ {{number_format($overdueAmountMonth, 2,',','.') }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>% de inadimplência:</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>{{number_format($lateMonthPorc, 2,',','.') }} %</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p><button type="submit" class="btn btn-danger">Ver todos os vencidos</button></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 border border-dark rounded-lg text-center ml-2">
            <div class="row">
                <div class="col">
                    <p>Valor total a receber (todos os meses)</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>R$ {{number_format($valorAllReceive, 2,',','.') }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>% de Inadimplência Geral(totos os meses)</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>{{number_format($porcAllReceive, 2,',','.') }} %</h4>
                </div>
            </div>
        </div>
    </div>
   
    <table class="table mt-5 border">
        <thead>
          <tr>
            <th scope="col">Baixa</th>
            <th scope="col">Nome</th>
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

                <td> {{$f->client->name}} </td>
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
      <div class="row">
          <div class="col-12">
              {{$financials->links()}}
          </div>
      </div>
@endsection

