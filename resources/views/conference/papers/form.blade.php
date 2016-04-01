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
<div class="form-group">
    <label for="authors">{{ trans('static.authors') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::text("authors", null, ['class' => 'form-control', 'id' => 'authors', 'placeholder' => trans('static.authors')]) !!}
</div>
<div class="form-group">
    <label for="paper">{{ trans('static.file') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::file("paper", null, ['class' => 'form-control', 'id' => 'paper', 'placeholder' => trans('static.file')]) !!}
</div>
@include('layouts.partials.button', ['button' => trans('static.save') ])