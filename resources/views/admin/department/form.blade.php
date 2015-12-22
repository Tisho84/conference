<div class="panel-body">
    @include('layouts.partials.messages.errors')
    <div class="mt text-center">
        <label>{{ trans($title) }}</label>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="keyword">{{ trans('admin.keyword') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("keyword", null, ['class' => 'form-control', 'id' => 'keyword', 'placeholder' => trans('admin.keyword')]) !!}
        </div>
        <div class="form-group">
            <label for="url">{{ trans('admin.url') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("url", null, ['class' => 'form-control', 'id' => 'url', 'placeholder' => trans('admin.url')]) !!}
        </div>
        <div class="form-group">
            <label for="image">{{ trans('admin.image') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::file("image", null, ['class' => 'form-control', 'id' => 'image', 'placeholder' => trans('admin.image')]) !!}
        </div>
        <div class="form-group">
            <label for="mainColor">{{ trans('admin.main-color') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("theme_background_color", null, ['class' => 'form-control colorpick', 'colorpicker' => 'hex', 'id' => 'mainColor', 'placeholder' => trans('admin.main-color')]) !!}
        </div>
        <div class="form-group">
            <label for="textColor">{{ trans('admin.text-color') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("theme_color", null, ['class' => 'form-control colorpick', 'colorpicker' => 'hex', 'id' => 'textColor', 'placeholder' => trans('admin.text-color')]) !!}
        </div>
        <div class="form-group">
            <label for="sort">{{  trans('admin.sort') }}</label>
            {!! Form::text('sort', null, ['class' => 'form-control', 'id' => 'sort', 'placeholder' => trans('admin.sort')]) !!}
        </div>
        <div class="form-group">
            {!! buildActive() !!}
        </div>
        @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
            <div class="form-group">
                <label for="name{{ $short }}">{{ trans('admin.name') . '(' . $locale['native'] . ')' }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                {!! Form::text("name_" . $short, null, ['class' => 'form-control', 'id' => 'name' . $short, 'placeholder' => trans('admin.name')]) !!}
            </div>
            <div class="form-group">
                <label for="title{{ $short }}">{{ trans('admin.title') . '(' . $locale['native'] . ')' }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                {!! Form::text("title_" . $short, null, ['class' => 'form-control', 'id' => 'title' . $short, 'placeholder' => trans('admin.title')]) !!}
            </div>
            <div class="form-group">
                <label for="description{{ $short }}">{{ trans('admin.description') . '(' . $locale['native'] . ')' }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                {!! Form::textarea("description_" . $short, null, ['class' => 'form-control ', 'id' => 'description' . $short, 'placeholder' => trans('admin.description')]) !!}
            </div>
        @endforeach
        @include('layouts.partials.button', ['button' => trans('static.save') ])
    </div>
</div>