<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.partials.head')
    </head>
    <body>
    <div id="container" class="container-fluid">
        <div id="header">
            <div class="row">
                <div class="col-lg-1">
                    <ul class="nav navbar-nav language-dropdown">
                        @include('layouts.partials.language_dropdown')
                    </ul>
                </div>
                <div class="col-lg-10">
                    <h1>{{ trans('static.title') }}</h1>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
        <div id="body" class="conference-slider">
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
            <div class="conference-departments">
                <p>{{ trans('static.select-dept') }}</p>
                <div class="row row-department">
                    @foreach ($departments as $k => $department)
                        <div class="col-lg-6">
                            <p class="department-name">{!! $department->dbLangs->get(dbTrans())->name !!}</p>
                            <a href="{{ getLangUrl($department->keyword)  }}">
                                {!! HTML::image(asset('images/' . $department->image), $department->dbLangs->get(dbTrans())->name, ['class' => 'img-responsive']) !!}
                            </a>
                        </div>
                        @if ($k % 2 == 1 && $k + 1 != count($departments))
                            </div><div class="row row-department">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div id="footer">
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
