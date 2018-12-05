@extends('adminlte::page')

@section('title', 'Virtual-Pub | feed')

@section('content_header')

@stop

@section('content')
<div class="row">
    @foreach($posts as $post)
        <div class="col-sm-12 col-md-8">
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
@stop
@section('js')
<script>
    $("#input-id").rating();
    $("#my-toggle-button").controlSidebar(options);
</script>
@stop