@extends('adminlte::page')

@section('title', 'Virtual-Pub | Publicação de '.$reg->user->name)

@section('content_header')

@stop

@section('content')
    <div class="row">
            <div class="col-md-6">
                    <!-- Box Comment -->
                    <div class="box box-widget">
                      <div class="box-header with-border">
                        <div class="user-block">
                          <img class="img-circle" src="{{$reg->user->avatar}}" alt="User Image">
                          <span class="username"><a href="#">{{$reg->user->name}}</a></span>
                          <span class="description">Publicado dia {{date_format($reg->created_at, 'd/m/Y')}} às {{date_format($reg->created_at, 'H:i')}}</span>
                        </div>
                        <!-- /.user-block -->
                        <div class="box-tools">
                          <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                            <i class="fa fa-circle-o"></i></button>
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                            @php
                            if (file_exists(public_path('postimages/'.$reg->id.'.jpg'))) {
                                $foto = '../postimages/'.$reg->id.'.jpg';
                                echo "<center><img class='img-responsive pad' src='$foto' alt='Photo'></center>";
                            } else {
                                echo "";
                            }
                        @endphp
          
                        <p>{{$reg->description}}</p>
                        @include('laravelLikeComment::like', ['like_item_id' => $post->id])
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer box-comments">
                          @include('laravelLikeComment::comment', ['comment_item_id' => $post->id])
                                              
                        <!-- /.box-comment -->
                      </div>
                      <!-- /.box-footer -->
                      
                      <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                  </div>
    </div>
@stop