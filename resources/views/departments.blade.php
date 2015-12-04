<!DOCTYPE html>
<html lang="en">
    @include('layouts.partials.head')
    <body>
    <div id="page" class="container-fluid">
        <div class="header container-fluid">
            <div class="row">
                <div class="col-lg-1">
                    {{--section must come from here--}}
                    <ul class="nav navbar-nav language-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                <span class="glyphicon glyphicon-globe" aria-hidden="true"></span><span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a rel="alternate" hreflang="{{$localeCode}}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                            {!! $properties['native'] !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    {{--section ends--}}
                </div>
                <div class="col-lg-10">
                    <h1>{{ trans('static.title') }}</h1>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
        <div class="conference-slider container-fluid">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        {!! HTML::image(asset('images/w-slide-11.jpg')) !!}
                    </div>
                    <div class="item">
                        {!! HTML::image(asset('images/w-slide-12.jpg')) !!}
                    </div>
                    <div class="item">
                        {!! HTML::image(asset('images/w-slide-13.jpg')) !!}
                    </div>
                    <div class="item">
                        {!! HTML::image(asset('images/w-slide-14.jpg')) !!}
                    </div>
                </div>
            </div>

        </div>
        <div class="conference-departments container-fluid">
            <p>{{ trans('static.select-dept') }}</p>
            <div class="row row-department">
            @foreach ($departments as $k => $department)
                <div class="col-lg-6">
                    <p class="department-name">{!! $department->langs->first()['name'] !!}</p>
                    <a href="{{ LaravelLocalization::setLocale() . '/' . $department->keyword }}">
                        {!! HTML::image(asset('images/' . $department->image), $department->langs->first()['name'], ['class' => 'img-responsive']) !!}
                    </a>
                </div>
                @if ($k % 2 == 1 && $k + 1 != count($departments))
                    </div><div class="row row-department">
                @endif
            @endforeach
            </div>
        </div>
        <div class="footer container-fluid">
            <p>{{ trans('static.footer') }}</p>
        </div>
    </div>

    {!! HTML::script('/js/all.js') !!}
    <script type="text/javascript">
        $(function(){
            $('.carousel').carousel({
                interval: 3000,
                cycle: true
            });
        });
    </script>
    </body>
</html>
