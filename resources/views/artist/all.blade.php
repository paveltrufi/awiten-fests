@extends('welcome')
@section('mainContent')
<html res="{{ App::setlocale(session('lang'))}}">
    <div id="breadcrumb">
        <div class="container hidden-xs">
            <div class="breadcrumb">
                <div class="row">
                    <div class="col-md-12">
                        <form method="get" action="{{ action('ArtistController@busquedaConParametros') }}">
                            <div class="input-group add-on btn-group">
                                <div class="col col-md-3">
                                    <input type="text" class="form-control" name="buscado"
                                           placeholder="{{trans('translate.introartist')}}">
                                </div>
                                <div class="col col-md-3">
                                    <select class="form-control" name="paginadoA">
                                        <option value="3"> 3 {{ trans('translate.pagina') }}</option>
                                        <option value="6" selected>6 {{ trans('translate.pagina') }}</option>
                                        <option value="9">9 {{ trans('translate.pagina') }}</option>
                                    </select>
                                </div>
                                <div class="col col-md-3">
                                    <select class="form-control" name="ordenado">
                                        <option value="asc" selected>{{ trans('translate.nombre') }} Asc</option>
                                        <option value="desc">{{ trans('translate.nombre') }} Desc</option>
                                    </select>
                                </div>
                                <button type="summit" class="btn btn-warning"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('deleted'))
        <h3>{{ trans('translate.artborrado') }}</h3>
    @endif
    <div class="row">
        <div class="container">
            @if(count($artists) != 0)
                <div>
                    <h1 style="background-color:rgb(0,0,0);color:white; font-weight:bold; text-align:center">
                        {{ trans('translate.artistas') }}</h1>
                </div>
            @else
                <div class="alert alert-danger">
                    <h1>{{ trans('translate.noencartistas') }}</h1>
                </div>
            @endif
        </div>
    </div>

    <ul>
        @if(count($artists) != 0)
            <div class="row">
                <div class="container">
                    <div class="center col-md-2 hidden-xs">
                        <ul class="portfolio-filter text-center">
                            <form class="text-left" method="get"
                                  action="{{ action('ArtistController@busquedaPorGenero') }}">
                                <div class="well-sm">{{ trans('translate.generos') }}</div>
                                @forelse($genres as $genre)
                                    <div class="[ form-group ]">
                                        @if(!empty(session('generos-marcados-artista')) && in_array($genre->id,session('generos-marcados-artista')))
                                            <input type="checkbox" name="{{$genre->name}}"
                                                   id="fancy-checkbox-success-{{$genre->name}}" autocomplete="off"
                                                   checked="checked" value="{{$genre->name}}"/>
                                        @else
                                            <input type="checkbox" name="{{$genre->name}}"
                                                   id="fancy-checkbox-success-{{$genre->name}}" autocomplete="off"
                                                   value="{{$genre->name}}"/>
                                        @endif
                                        <div class="[ btn-group ]">
                                            <label for="fancy-checkbox-success-{{$genre->name}}"
                                                   class="[ btn btn-success ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="fancy-checkbox-success-{{$genre->name}}"
                                                   class="[ btn btn-success active ]">
                                                {{$genre->name}}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <h2>{{ trans('translate.nogeneros') }}</h2>
                                @endforelse
                                <button type="submit" class="btn btn-warning">{{ trans('translate.busgenero') }}</button>
                            </form>
                        </ul>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="center col-md-12">
                                <div class="portfolio-items">
                                    @foreach($artists as $artist)
                                        <div class="portfolio-item col-md-4 col-sm-6">
                                            <div class="recent-work-wrap">
                                                <a href="{{action('ArtistController@Details', $artist->permalink)}}">
                                                    <img class="imagen-artista" src="{{ route('artist.image', ['permalink' => $artist->permalink, 'filename' => $artist->pathProfile]) }}">
                                                </a>
                                                <div class="overlay">
                                                    <div class="recent-work-inner">
                                                        <div class="portfolio-caption">
                                                            <h3>
                                                                <a href="/artists/{{$artist->permalink}}/details">{{$artist->name}}</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row visible-xs">
                            <div class="center col-md-12">
                                <div class="portfolio-items">
                                    @foreach($artists as $artist)
                                        <div class="portfolio-item col-md-4 col-sm-6 hidden-xs">
                                            <div class="recent-work-wrap">
                                                <a href="{{action('ArtistController@Details', $artist->permalink)}}">
                                                    <img class="imagen-artista"
                                                         src="{{ route('artist.image', ['permalink' => $artist->permalink, 'filename' => $artist->pathProfile]) }}">
                                                </a>
                                                <div class="overlay">
                                                    <div class="recent-work-inner">
                                                        <div class="portfolio-caption">
                                                            <h3>
                                                                <a href="/artist/{{$artist->permalink}}">{{$artist->name}}</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </ul>
    <div class="text-center">
        <div class="pagination pagination-lg">
            {{ $artists->links() }}
        </div>
    </div>
    @endif
@endsection