@extends('adminlte::page')

@section('title', 'Virtual-Pub | feed')

@section('content_header')

@stop

@section('content')
<div class="col-sm-12 col-md-6">

    @foreach($posts as $post)
    <div class="col-sm-12">
        <!-- Box Comment -->
        <div class="box box-widget">
            <div class="box-header with-border">
                <div class="user-block">
                    @if($post->userimg != null)
                    <img class="img-circle" src="{{$post->userimg}}" alt="User Image">
                    @else
                    <img class="img-circle" src="{{ asset('images/avatar-placeholder.svg') }}" alt="User Image">
                    @endif
                    <span class="username"><a href="{{ route('profile.show', $post->userId) }}">{{$post->nome}}</a></span>
                    <span class="description">Publicado em {{$post->data}}</span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                        <i class="fa fa-circle-o"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                
                <div class="box-body">
                    @php
            if (file_exists(public_path('postimages/'.$post->id.'.jpg'))) {
                $foto = '../postimages/'.$post->id.'.jpg';
                echo "<center><img class='img-responsive pad' src='$foto' alt='Photo'></center>";
            } else {
                echo "";
            }
            @endphp

            <p>{{$post->desc}}</p>
            @include('laravelLikeComment::like', ['like_item_id' => $post->id])
        </div>

        <div class="box-box-comments ">
            <a class="btn btn-primary" role="button" target="_blank" href="{{route('posts.show', $post->id)}}">visualiza comentários</a>
        </div>

        <div class="box-footer"></div>

        </div>
<!-- /.box -->
    </div>
@endforeach
</div>

<div class="col-sm-12 col-md-4">
        @foreach($cerveja as $c)
        <div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-body box-profile">
                    @php
                    if (file_exists(public_path('fotos/'.$c->id.'.jpg'))) {
                    $foto = '../fotos/'.$c->id.'.jpg';
                    } else {
                    $foto = '../images/beer-placeholder.svg';
                    }
                    @endphp
                    <img class="profile-user-img img-responsive" src="{{$foto}}" alt="{{$c->nome}}">
                    <h3 class="profile-username text-center">{{$c->nome}}</h3>
                    @if($c->fabricante_name != null)
                    <a href="{{route('users.show', $c->fabricante->id)}}">
                      <p class="text-muted text-center">{{$c->fabricante->fabricante_name}}</p>
                    </a>
                    @else
                    <p>desconhecido</p>
                    @endif
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $c->averageRating }}" data-size="xs" disabled="">
                        </li>
                    
                    </ul>
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item text-center">
                        <a type="button" href="{{ route('cervejas.show', $c->id)}}" class="btn btn-success centered">Mais Informações</a>
                      </li>
                      <li class="list-group-item text-center">
                        @if(Auth::user()->favoritas()->where('cerveja_id', $c->id)->first())
          <form style="display: inline-block"method="post" action="{{route('cerveja.desfazer', $c->id)}}" onsubmit="return confirm('Quer realmente desfazer?')">   
              {{ csrf_field() }}
              <button type="submit"class="btn bg-teal-active centered"> favoritada </button>
          </form>
          @else
            <form style="display: inline-block"method="post" action="{{route('cerveja.favoritar', $c->id)}}" onsubmit="return confirm('Deseja fazoritar esta cerveja?')">   
                {{ csrf_field() }}
                <button type="submit"class="btn bg-navy centered"> favoritar </button>
            </form>
          @endif
                      </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
</div>
@stop
@section('js')
<script>
    $("#input-id").rating();
    $("#my-toggle-button").controlSidebar(options);
</script>
@stop