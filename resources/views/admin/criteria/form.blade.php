<div class="panel-body">
    @include('layouts.partials.messages.errors')
    <div class="mt text-center">
        <label>{{ trans($title) }}</label>
    </div>
    @if ($systemAdmin)
        <div class="form-group">
            <label for="department_id">{{ trans('admin.department') }}</label>
            {!! Form::select('department_id', $departments, null, ['class' => 'form-control']) !!}
        </div>
    @endif
    @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
        <div class="form-group">
            <label for="{{ $short }}">{{ trans('admin.title') . '(' . $locale['native'] . ')' }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("title_" . $short, null, ['class' => 'form-control', 'id' => $short, 'placeholder' => trans('admin.title')]) !!}
        </div>
    @endforeach
    <div class="form-group">
        <label for="type_id">{{ trans('static.field-type') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
        {!! Form::select('type_id', $types, null, ['class' => 'form-control']) !!}
    </div>
        <div class="form-group">
            <label for="required">{{ trans('static.is-required') }}</label>
            {!! Form::select('required', selectBoolean(), null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label for="visible">{{ trans('static.is-visible') }}</label>
            {!! Form::select('visible', selectBoolean(), null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label for="admin">{{ trans('static.admin-criteria') }}</label>
            {!! Form::select('admin', selectBoolean(), null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
        <label for="sort">{{ trans('admin.sort') }}</label>
        {!! Form::text('sort', null, ['class' => 'form-control', 'id' => 'sort', 'placeholder' => trans('admin.sort')]) !!}
    </div>
    @include('layouts.partials.button', ['button' => trans('static.save') ])
</div>