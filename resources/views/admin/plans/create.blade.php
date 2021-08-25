@extends('layouts.dashboard')
@section('content')
<main class="bg-secondary h-100 p-5 m-auto">
    <div class="bg-white p-3 border shadow">
        <h3>Criar Plano</h3>

        <div class="mt-4 border mb-2 p-3">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{route('admin.plans.new')}}">
                        @csrf
                        <div class="form-group">
                          <label>Nome Plano</label>
                          <input type="text" class="form-control border" name="name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Descrição</label>
                            <input type="text" class="form-control border" name="description" placeholder="">
                          </div>
                          <div class="form-group">
                            <label>Valor</label>
                            <input type="text" class="form-control border" name="amount" placeholder="">
                          </div>
                          <div class="form-group">
                            <label>Apelido</label>
                            <input type="text" class="form-control border" name="nickname" placeholder="">
                          </div>
                          <div class="form-group">
                            <button class="btn btn-primary btn-sm px-3 py-1 float-right" type="submit">Cadastrar</button>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection