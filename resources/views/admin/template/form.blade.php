<div class="panel-body">
    @include('admin.partials.tinymce')
    @include('layouts.partials.messages.errors')
    <div class="centered text-center">
        <h3>{{ trans($title) }}</h3>
    </div>
    @if ($systemAdmin)
        <div class="form-group">
            <label for="department_id">{{ trans('admin.department') }}</label>
            {!! Form::select('department_id', $departments, null, ['class' => 'form-control']) !!}
        </div>
    @endif
    <div class="form-group">
        <label for="name">{{ trans('static.name') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('static.name')]) !!}
    </div>
    <div class="form-group">
        <label for="subject">{{ trans('static.subject') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
        {!! Form::text('subject', null, ['class' => 'form-control', 'id' => 'subject', 'placeholder' => trans('static.subject')]) !!}
    </div>
    <div class="form-group">
        <label>{{ trans('static.available-params') . ':' }}</label>
        <div>{!! $text !!}</div>
    </div>
    <div class="form-group">
        <label for="body">{{ trans('static.body') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
        {!! Form::textarea("body", null, ['class' => 'form-control', 'id' => 'body', 'placeholder' => trans('static.body')]) !!}
    </div>
    <div class="form-group">
        <label for="system">{{ trans('static.system-template') }}</label>
        {!! Form::select('system', selectBoolean(), null, ['class' => 'form-control']) !!}
    </div>
    @include('layouts.partials.button', ['button' => trans('static.save') ])
</div>