@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Novo Cliente</h2>
            <hr>
            <form method="POST" action="{{ route('dashboard.clients.store') }}">
                @csrf
                <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="name" placeholder="Nome completo">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="nickname" placeholder="apelido">
                </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                    <input type="text" class="form-control" name="celphone" placeholder="celular">
                    </div>
                    <div class="col">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4">
                    <input type="text" class="form-control" name="street" placeholder="Rua">
                    </div>
                    <div class="col-1">
                    <input type="text" class="form-control" name="number" placeholder="nº">
                    </div>
                    <div class="col-3">
                    <input type="text" class="form-control" name="district" placeholder="Bairro">
                    </div>
                    <div class="col-4">
                    <input type="text" class="form-control" name="city" placeholder="Cidade">
                    </div>                        
                </div>
                <div class="row mt-3 text-center">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
@endsection