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
    @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
        <div class="form-group">
            <label for="{{ $short }}">{{ trans('admin.title') . '(' . $locale['native'] . ')' }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("title_" . $short, null, ['class' => 'form-control', 'id' => $short, 'placeholder' => trans('admin.title')]) !!}
        </div>
        <div class="form-group">
            <label for="{{ $short }}">{{ trans('admin.description') . '(' . $locale['native'] . ')' }}</label>
            {!! Form::textarea("description_" . $short, null, ['class' => 'form-control', 'id' => $short, 'placeholder' => trans('admin.description')]) !!}
        </div>
    @endforeach
    <div class="form-group">
        {!! buildActive() !!}
    </div>
    <div class="form-group">
        <label for="sort">{{ trans('admin.sort') }}</label>
        {!! Form::text('sort', null, ['class' => 'form-control', 'id' => 'sort', 'placeholder' => trans('admin.sort')]) !!}
    </div>
    @include('layouts.partials.button', ['button' => trans('static.save') ])
</div>