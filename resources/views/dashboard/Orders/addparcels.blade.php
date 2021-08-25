@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-3">
            <h3>Preencha as notas promissória, de acordo com a do cliente</h3>
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
            <form action="{{route('dashboard.financial.store')}}" method="post">
                @csrf

                @for ($i = 1; $i <= $qtd; $i++ )
                    <div class="row">
                        <div class="col-12 border px-2 py-4 my-2">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h4 class="px-3">
                                        @php
                                            echo $i.'/'.$qtd;
                                        @endphp
                                    </h4>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="forvalor" class="form-label">Valor </label>
                                    <input type="text" name="valor-{{$i}}" class="form-control" value="@php echo number_format($valor/$qtd,2,',','.') @endphp" id="forvalor">
                                </div>
                                <div class="col-md-6">
                                    <label for="fordata" class="form-label">Data</label>
                                    <input type="date" name="vencimento-{{$i}}" class="form-control" id="fordata">
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                <input type="hidden" name="qtd" value="{{$qtd}}">
                <input type="hidden" name="client_id" value="{{$client->id}}">
                <button class="btn btn-primary float-right" type="submit">Finalizar</button>
            </form>
              
        </div>
    </div>
</div>
@endsection