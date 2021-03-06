<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.partials.head')
        {!! HTML::style('/css/sb-admin.css') !!}
        {!! HTML::style('/css/select2.css') !!}
        {!! HTML::style('/css/bootstrap-datepicker.min.css') !!}

        {!! HTML::script('/js/all.js') !!}
        {!! HTML::script('/js/select2.js') !!}
    </head>
    <body>
        <div id="wrapper" class="admin">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    @if (systemAccess(100))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('static.filter-department') }}<i class="fa fa-bell"></i> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu alert-dropdown">
                                @foreach ($departmentsSelect as $id => $title)
                                    @if ((int)session('department_filter_id') == $id)
                                        <li class="active-admin">
                                    @else
                                        <li>
                                    @endif
                                        <a href="{{ route('department_filter', ['department_filter_id' => $id]) }}">{{ $title }}</a>
                                    </li>
                                @endforeach
                          </ul>
                        </li>
                    @endif

                    @include('layouts.partials.language_dropdown')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ auth()->user()->name }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('logout') }}">{!! trans('static.menu-logout') !!}</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        @if (systemAccess(10))
                            <li>{!! HTML::link(action('Admin\DepartmentController@index'), trans('admin.departments')) !!}</li>
                        @endif
                        @if (systemAccess(100))
                            <li>{!! HTML::link(action('Admin\UserTypesController@index'), trans('admin.user-types')) !!}</li>
                        @endif
                        @if (systemAccess(5))
                            <li>{!! HTML::link(action('Admin\UsersController@index'), trans('admin.users')) !!}</li>
                        @endif
                        @if (systemAccess(4))
                            <li>{!! HTML::link(action('Admin\NewsController@index'), trans('static.news')) !!}</li>
                        @endif
                        @if (systemAccess(7))
                            <li>{!! HTML::link(action('Admin\CategoryController@index'), trans('admin.categories')) !!}</li>
                        @endif
                        <li>{!! HTML::link(action('Admin\PaperController@index'), trans('static.menu-papers')) !!}</li>
                        @if (systemAccess(6))
                            <li>{!! HTML::link(action('Admin\CriteriaController@index'), trans('static.criteria')) !!}</li>
                        @endif
                        @if (systemAccess(11))
                            <li>{!! HTML::link(action('Admin\ArchiveController@index'), trans('static.archive')) !!}</li>
                        @endif
                        @if (systemAccess(3))
                            <li>{!! HTML::link(action('Admin\EmailTemplateController@index'), trans('static.templates')) !!}</li>
                            <li>{!! HTML::link(action('Admin\EmailTemplateController@getEmail'), trans('static.send-email')) !!}</li>
                        @endif
                        @if (systemAccess(8))
                            <li>{!! HTML::link(action('Admin\SettingsController@display'), trans('static.settings')) !!}</li>
                        @endif

                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <div id="page-wrapper">
                <div class="messages">
                    @include('layouts.partials.messages.other')
                </div>
                @if(isset($back) && $back)
                    <div class="admin-back pull-left">
                        <a href="{{ $back }}" class="btn btn-primary btn-sm">{{ trans('static.menu-back') }}</a>
                    </div>
                @endif
                <div class="clearfix"></div>
                <div class="content container-fluid">

                    <div class="col-sm12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        @if (isset($search) && $search)
                            @include('admin.partials.search')
                        @endif
                        <div class="panel panel-default">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        @yield('javascript')
        {!! HTML::script('/js/app.js') !!}
        {!! HTML::script('/js/bootstrap-datepicker.min.js') !!}
    </body>
</html>