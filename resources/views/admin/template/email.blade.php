@extends('admin.master')

@section('content')
    {!! HTML::script('/js/jquery.chained.remote.min.js') !!}
    {!! Form::open(['method' => 'post', 'url' => action('Admin\EmailTemplateController@postEmail') ]) !!}
        <div class="panel-body">
            @include('layouts.partials.messages.errors')
            <div class="centered text-center">
                <h3>{!! trans('static.send-email') !!}</h3>
            </div>
            <div class="row">
                <div class="col-sm10 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    @if ($systemAdmin)
                        <div class="form-group">
                            <label for="department_id">{{ trans('admin.department') }}</label>
                            {!! Form::select('department_id', $departments, session()->get('department_filter_id') ? : 0, ['class' => 'form-control', 'id' => 'department']) !!}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="user_type">{{ trans('admin.user-type') }}</label>
                        {!! Form::select('user_type', $user_types, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="users">{{ trans('admin.users') }}</label>
                        {!! Form::select('users[]', $users, null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'users']) !!}
                    </div>
                    <div class="form-group">
                        <label for="template_id">{{ trans('static.templates') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                        {!! Form::select('template_id', $templates, null, ['class' => 'form-control', 'id' => 'template']) !!}
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.partials.button', ['button' => trans('static.save') ])
        <script>
            $("#users").remoteChained({
                parents : "#department",
                url : "<?php echo route('department_users')?>"
            });

            $('#template').remoteChained({
                parents : "#department",
                url : "<?php echo route('department_templates')?>"
            });
        </script>
    {!! Form::close() !!}
@stop
