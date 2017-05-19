@extends('admin.master')
@section('title', 'Nueva Noticia -')
@section('content')
    <h1 class="page-header">Nueva Noticia</h1>
    @if(count($errors) > 0)
        <div class="alert alert-warning">
            <h3><span class="glyphicon glyphicon-exclamation-sign valign-top" aria-hidden="true"></span> No se ha podido
                editar el post</h3>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="form-horizontal" action="{{action('PostController@Create')}}" method="post">
        {{method_field('post')}}
        {{csrf_field()}}
        <fieldset>
            <div class="form-group">
                <label class="col-md-4 control-label" for="festival_id">Festival</label>
                <div class="col-md-4">
                    <select class="selectpicker" id="festival_id" name="festival_id" title="Festival" data-size="10"
                            data-live-search="true">
                        @foreach($festivals as $festival)
                            <option value="{{$festival->id}}">{{$festival->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">Titulo</label>
                <div class="col-md-4">
                    <input type="text" id="title" name="title" placeholder="Titulo de la noticia"
                           class="form-control input-md" title="Titulo" value="{{ old('title') }}">
                    <span class="help-block">
                        <input class="form-control input-sm" type="text" id="permalink" name="permalink"
                               title="Permalink" value="{{old('permalink') ?? 'permalink asociado al post'}}" readonly>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="lead">Encabezado</label>
                <div class="col-md-8">
                    <textarea id="lead" name="lead" placeholder="Resumen de la noticia" class="form-control input-md"
                              title="Encabezado"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="body">Cuerpo</label>
                <div class="col-md-8">
                    <textarea rows="20" id="body" name="body" placeholder="Cuerpo de la noticia"
                              class="form-control input-md" title="Cuerpo"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="save-button"> </label>
                <div class="col-md-4">
                    <button id="save-button" name="save-button" class="btn btn-success">Crear Post</button>
                </div>
            </div>
        </fieldset>
    </form>
    <script type="text/javascript">
        $(function () {
            $('#home').removeClass('active');
            $('#posts').addClass('active');
            $('input[name=title]').on('input', function () {
                $('#permalink').val(slugify($('input[name=title]').val()));
            });
            $('.selectpicker').selectpicker('val', {{ old('festival_id') }});
        });
    </script>
@endsection
