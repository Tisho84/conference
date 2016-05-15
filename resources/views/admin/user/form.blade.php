<div class="panel-body">
    {!! HTML::script('/js/jquery.chained.remote.min.js') !!}
    @include('layouts.partials.messages.errors')
    <div class="centered text-center">
        <h3>{{ trans($title) }}</h3>
    </div>
    @if ($systemAdmin)
        <div class="form-group">
            <label for="department_id">{{ trans('admin.department') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::select('department_id', $departments, null, ['class' => 'form-control', 'id' => 'department']) !!}
        </div>
    @endif
    @include('auth.personal_form')
    <div class="form-group">
        <label>{{ trans('admin.user-type') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
        {!! Form::select('user_type_id', $types, null, ['class' => 'form-control select2-simple', 'style' => 'width: 100%;']) !!}
    </div>
    @include('auth.profile_form')
    <div class="form-group">
        {!! buildActive() !!}
    </div>
    @include('layouts.partials.button', ['button' => trans('static.save') ])
    <script>
        $("#category").remoteChained({
            parents : "#department",
            url : "<?php echo route('department_categories', ['first' => 0])?>"
        });
    </script>
</div>