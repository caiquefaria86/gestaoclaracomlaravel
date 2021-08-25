@if(Session::has('success'))

    <div class="modal fade" id="modal-success" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content text-center">
                <div class="py-5 bg-success">
                    <i class="far fa-check-circle fa-5x text-white"></i>
                </div>
                <h2 class="py-2 text-success ">Ótimo!</h2>
                <br>
                <p class="text-success py-2"> {{Session::get('success')}}</p>

            <div class="col-12 text-center p-2"><button type="button" class="btn btn-success btn-sm px-5 py-1" data-dismiss="modal">Fechar</button></div>
            
        </div>
        </div>
    </div>
    

<script type="text/javascript">
  $('#modal-success').modal('show')
</script>
@endif

@if(Session::has('error'))

    <div class="modal fade" id="modal-error" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content text-center">
                <div class="py-5 bg-danger">
                    <i class="fas fa-exclamation-circle fa-5x text-white"></i>
                </div>
                <h2 class="py-2 text-danger ">Ops!</h2>
                <br>
                <p class="text-danger py-2"> {{Session::get('error')}}</p>

            <div class="col-12 text-center p-2"><button type="button" class="btn btn-danger btn-sm px-5 py-1" data-dismiss="modal">Fechar</button></div>
            
        </div>
        </div>
    </div>
    

<script type="text/javascript">
  $('#modal-error').modal('show')
</script>
@endif

  
  
{{-- 
@if ($message = Session::get('error'))

<div class="alert alert-danger alert-block">

    <button type="button" class="close" data-dismiss="alert">×</button>    

    <strong>{{ $message }}</strong>

</div>

@endif

    --}}

@if ($message = Session::get('warning'))

<div class="alert alert-warning alert-block">

    <button type="button" class="close" data-dismiss="alert">×</button>    

    <strong>{{ $message }}</strong>

</div>

@endif

   

@if ($message = Session::get('info'))

<div class="alert alert-info alert-block">

    <button type="button" class="close" data-dismiss="alert">×</button>    

    <strong>{{ $message }}</strong>

</div>

@endif

  

@if ($errors->any())

<div class="alert alert-danger">

    <button type="button" class="close" data-dismiss="alert">×</button>    

    Please check the form below for errors

</div>

@endif
