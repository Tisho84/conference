<div class="panel-body">
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
    @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
        <div class="form-group">
            <label for="{{ $short }}">{{ trans('admin.name') . '(' . $locale['native'] . ')' }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("name_" . $short, null, ['class' => 'form-control', 'id' => $short, 'placeholder' => trans('admin.name')]) !!}
        </div>
    @endforeach
    <div class="form-group">
        <label for="sort">{{ trans('admin.sort') }}</label>
        {!! Form::text('sort', null, ['class' => 'form-control', 'id' => 'sort', 'placeholder' => trans('admin.sort')]) !!}
    </div>
    <div class="form-group">
        {!! buildActive() !!}
    </div>
    @include('layouts.partials.button', ['button' => trans('static.save') ])
</div>