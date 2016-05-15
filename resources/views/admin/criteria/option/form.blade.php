<div class="panel-body">
    @include('layouts.partials.messages.errors')
    <div class="mt text-center">
        <label>{{ trans($title) }}</label>
    </div>
    @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
        <div class="form-group">
            <label for="{{ $short }}">{{ trans('admin.title') . '(' . $locale['native'] . ')' }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("title_" . $short, null, ['class' => 'form-control', 'id' => $short, 'placeholder' => trans('admin.title')]) !!}
        </div>
    @endforeach
    <div class="form-group">
        <label for="sort">{{ trans('admin.sort') }}</label>
        {!! Form::text('sort', null, ['class' => 'form-control', 'id' => 'sort', 'placeholder' => trans('admin.sort')]) !!}
    </div>
    @include('layouts.partials.button', ['button' => trans('static.save') ])
</div>