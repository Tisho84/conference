<div class="col-md text-center">
    <label>{{ trans('static.fill-fields') }}</label>
</div>
<div class="form-group">
    <label for="category_id">{{ trans('static.category') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="title">{{ trans('static.title') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::text("title", null, ['class' => 'form-control', 'id' => 'title', 'placeholder' => trans('static.title')]) !!}
</div>
<div class="form-group">
    <label for="description">{{ trans('static.description') }}</label>
    {!! Form::textarea("description", null, ['class' => 'form-control ', 'id' => 'description', 'placeholder' => trans('static.description')]) !!}
</div>
<div class="form-group" title="{{ trans('static.separated') }}">
    <label for="authors">{{ trans('static.authors') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::text("authors", null, ['class' => 'form-control', 'id' => 'authors', 'placeholder' => trans('static.authors') . ' ' . trans('static.separated')]) !!}
</div>
<div class="form-group">
    <label for="paper">{{ trans('static.file') }}
        @if (isset($paper) && $paper)
            <span>({{ trans('messages.upload-file') }})</span>
        @else
            <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
        @endif
    </label>
    {!! Form::file("paper", null, ['class' => 'form-control', 'id' => 'paper', 'placeholder' => trans('static.file')]) !!}
</div>

<div class="form-group">
    <div class="text-center">
        <a href="{{ action('PaperController@index', [$department->keyword]) }}" class="btn btn-theme">{{ trans('static.menu-back') }}</a>
        <button type="submit" class="btn btn-theme">{{ trans('static.save') }}</button>
    </div>
</div>