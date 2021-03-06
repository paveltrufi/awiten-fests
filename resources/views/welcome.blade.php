<!DOCTYPE html>
<html res="{{ App::setlocale(session('lang'))}}">
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Awiten Fests</title>
</head>
<body>
<!-- Bootstrap -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" lazyload="1">
<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" lazyload="1">
<link href="{{ asset('css/animate.css') }}" rel="stylesheet" lazyload="1">
<link href="{{ asset('css/prettyPhoto.css') }}" rel="stylesheet" lazyload="1">
<link href="{{ asset('css/style.css') }}" rel="stylesheet" lazyload="1"/>

<header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target=".navbar-collapse.collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand">
                    <a href="/"><h1><span>Awiten</span>Fests</h1></a>
                        </div>
                </div>

                <div class="navbar-collapse collapse">
                    <div class="menu">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation"><a href="{{action('FestivalController@init')}}">{{ trans('translate.festivales') }}</a></li>
                            <li role="presentation"><a href="{{action('ArtistController@init')}}">{{ trans('translate.artistas') }}</a></li>
                            <li role="presentation"><a href="{{action('AdminController@AvailableEntities')}}">{{ trans('translate.admin') }}</a>
                            @if (Auth::check())
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                {{--@elseif (Auth::guest())
                                    <li><a href="{{ route('login') }}">Login</a></li>

                                    <li><a href="{{ route('register') }}">{{ trans('translate.registro') }}</a></li>--}}
                            @endif

                            <li role="presentation"><a href="{{ url('lang', ['es']) }}"><input  type="image"  src="/images/es.png"/></a>
                            <li role="presentation"><a href="{{ url('lang', ['ca']) }}"><input  type="image"  src="/images/va.png"/></a>
                            <li role="presentation"><a href="{{ url('lang', ['en']) }}"><input  type="image"  src="/images/gb.png"/></a>
                            </li>

                            {{--<div class="links">--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>


@section('mainContent')
    <section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <div class="carousel-inner">
                <div class="item active" style="background-image: url(images/festival-fondo2.jpg)">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="carousel-content" style="padding: 10px;background: rgba(0, 140, 23, 0.5);">
                                    <h2 class="animation animated-item-1">
                                        {{ trans('translate.bienvenido') }} <span style="color: #1BBD36">Awiten</span><span>Fests</span>
                                    </h2>
                                    <p class="text-danger animation animated-item-2" style="color: LawnGreen">
                                        <strong>{{ trans('translate.descubre') }}</strong>
                                    </p>

                                </div>
                            </div>

                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
    </section><!--/#main-slider-->
@show
<div class="container">
    @yield('content')

</div>
<footer>
    <div class="footer">
        <div class="container">
            <div class="social-icon">
                <div class="col-md-4">
                    <ul class="social-network">
                        <li><a href='{{action('PagesController@getContact')}}'>{{ trans('translate.contacto') }}</a></li>
                        <li><a href="#" class="fb tool-tip" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="twitter tool-tip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="gplus tool-tip" title="Google Plus"><i class="fa fa-google-plus"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4 col-md-offset-4">
                {{--<div class="copyright">
                    &copy; Company Theme. All Rights Reserved.
                    <div class="credits">
                        <!--
                            All the links in the footer should remain intact.
                            You can delete the links only if you purchased the pro version.
                            Licensing information: https://bootstrapmade.com/license/
                            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Company
                        -->
                        <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>--}}
            </div>
        </div>
        <div class="pull-right">
            <a href="#" class="scrollup"><i class="fa fa-angle-up fa-3x"></i></a>
        </div>
    </div>
</footer>
</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ URL::asset('js/jquery-2.1.1.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.prettyPhoto.js')}}"></script>
<script src="{{ URL::asset('js/jquery.isotope.min.js')}}"></script>
<script src="{{ URL::asset('js/wow.min.js')}}"></script>
<script src="{{ URL::asset('js/functions.js')}}"></script>
<!-- LazyCSSLoad -->
<script src="{{asset('js/cssrelpreload.js')}}" type="text/javascript"></script>
<script src="{{asset('js/loadCSS.js')}}" type="text/javascript"></script>
<script src="{{asset('js/onloadCSS.js')}}" type="text/javascript"></script>
</html>
