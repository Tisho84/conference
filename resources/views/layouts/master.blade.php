<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title', $department->dbLangs->get(dbTrans())->title)</title>
        @include('layouts.partials.head')
        @include('layouts.partials.style')
    </head>
    <body>
        <div id="container" class="department container-fluid">
            <div id="header">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <a href="{{ getLangUrl($department->keyword) }}">
                            {!! HTML::image(asset('images/' . $department->image), $department->dbLangs->get(dbTrans())->name, ['class' => 'img-responsive']) !!}
                        </a>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <h1>{!! $department->dbLangs->get(dbTrans())->title !!}</h1>
                    </div>
                </div>
            </div>
            <div id="body">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                @if (count(Cache::get('departments')) > 1)
                                    <li class="li-glyphicon">
                                        <a href="{{ getLangUrl() }}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
                                    </li>
                                @endif
                                <li><a href="{{ getLangUrl($department->keyword) }}">{{ trans('static.menu-home') }}</a></li>
                                @if (Auth::guest())
                                    @include('layouts.partials.menu_guest')
                                @else
                                    @include('layouts.partials.menu_user')
                                @endif
                            </ul>
                            <ul class="nav navbar-nav department-language-dropdown navbar-right">
                                @include('layouts.partials.language_dropdown')
                            </ul>

                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
                <div class="messages">
                    @include('layouts.partials.messages.other')
                </div>
                <div class="content">
                    @yield('content')
                </div>
            </div>
            <div id="footer">
                <p>© {{ $department->dbLangs->get(dbTrans())->title }}</p>
            </div>
        </div>

        @yield('javascript')
        {!! HTML::script('/js/all.js') !!}
        {!! HTML::script('/js/app.js') !!}
    </body>
</html>
