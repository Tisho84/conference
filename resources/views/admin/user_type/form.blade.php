<div class="panel-body">
    @include('layouts.partials.messages.errors')
    <div class="mt text-center">
        <label>{{ trans($title) }}</label>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="title">{{  trans('admin.title') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'placeholder' => trans('admin.title')]) !!}
        </div>
        <div class="form-group">
            <label for="access">{{  trans('admin.access') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::select('access[]', $access, isset($selectedAccess) ? $selectedAccess: null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'style' => 'width: 100%;']) !!}
        </div>
        <div class="form-group">
            <label for="sort">{{  trans('admin.sort') }}</label>
            {!! Form::text('sort', null, ['class' => 'form-control', 'id' => 'sort', 'placeholder' => trans('admin.sort')]) !!}
        </div>
        <div class="form-group">
            {!! buildActive() !!}
        </div>
        @include('layouts.partials.button', ['button' => trans('static.save') ])
    </div>
</div>