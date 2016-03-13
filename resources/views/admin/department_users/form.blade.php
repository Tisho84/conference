<div class="panel-body">
    @include('layouts.partials.messages.errors')
    <div class="mt text-center">
        <label>{{ trans($title) }}</label>
    </div>
    <div class="panel-body">
        {!! Form::hidden('department_id', $department->id) !!}
        @include('auth.personal_form')
        <div class="form-group">
            <label>{{ trans('admin.user-type') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::select('user_type_id', $types, null, ['class' => 'form-control select2-simple', 'style' => 'width: 100%;']) !!}
        </div>
        @include('auth.profile_form')
        @include('layouts.partials.button', ['button' => trans('static.save') ])
    </div>
</div>