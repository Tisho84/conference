<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.partials.head')
        {!! HTML::style('/css/sb-admin.css') !!}
        {!! HTML::style('/css/select2.css') !!}

        {!! HTML::script('/js/all.js') !!}
        {!! HTML::script('/js/select2.js') !!}
    </head>
    <body>
        <div id="wrapper" class="admin">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{--<a class="navbar-brand" href="index.html">SB Admin</a>--}}
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    @include('layouts.partials.language_dropdown')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu alert-dropdown">
                            <li>
                                <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">View All</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#"><i class="fa fa-fw fa-power-off"></i>{!! trans('static.menu-logout') !!}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li>{!! HTML::link(action('Admin\DepartmentController@index'), trans('admin.departments')) !!}</li>
                        <li>{!! HTML::link(action('Admin\UserTypesController@index'), trans('admin.user-types')) !!}</li>
                        <li>{!! HTML::link(action('Admin\CategoryController@index'), trans('admin.categories')) !!}</li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#account-menu">Account <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="account-menu" class="collapse">
                                <li>
                                    <a href="#">Dropdown Item</a>
                                </li>
                                <li>
                                    <a href="#">Dropdown Item</a>
                                </li>
                            </ul>

                        </li>
                        <li>
                            <a href="forms.html">Papers</a>
                        </li>
                        <li>
                            <a href="bootstrap-grid.html">Settings</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <div id="page-wrapper">
                <div class="messages">
                    @include('layouts.partials.messages.other')
                </div>
                <div class="content container-fluid">
                    <div class="panel panel-default">
                        @yield('content')
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        @yield('javascript')
        {!! HTML::script('/js/app.js') !!}
    </body>
</html>