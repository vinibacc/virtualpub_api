@extends('adminlte::page')

@section('title', 'Virtual-Pub | Foto Publicação')

@section('content_header')
<h2> publicar foto</h2>
@stop

@section('content')

<div class='col-sm-11'></div>
<div class='col-sm-1'>
    <a href='{{route('posts.index')}}' class='btn btn-primary' 
       role='button'> Voltar </a>
</div>

@if ($errors->any())
<div class="col-sm-12">
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
</div>
@endif    



<div class='col-sm-12'>
    <form method="post" action="{{route('posts.store.foto')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$reg->id}}">
        <div class="col-sm-3" style="text-align: center">
            @php
            if (file_exists(public_path('postimages/'.$reg->id.'.jpg'))) {
                $foto = '/postimages/'.$reg->id.'.jpg';
            } else {
                $foto = '/images/avatar-placeholder.svg';
            }
            @endphp
            {!!"<img src=$foto id='imagem' height='150' width='200' alt='Foto'>"!!}
            <p>
                <div class="form-group">
                    <label for="foto"> Foto </label>
                    <input type="file" id="foto" name="foto" onchange="previewFile()" class="form-control">
                </div>
            </p>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>   
</div> 

<script>
function previewFile() {
    var preview = document.getElementById('imagem');
    var file    = document.getElementById('foto').files[0];
    var reader  = new FileReader();
    
    reader.onloadend = function() {
        preview.src = reader.result;
    };
    
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }    
}
   
</script>


@endsection