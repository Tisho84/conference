<div class="form-group">
    <label>{{ trans('static.rank') }}</label>
    {!! Form::select('rank_id', $ranks, null, ['class' => 'form-control select2-simple', 'style' => 'width: 100%;']) !!}
</div>
<div class="form-group">
    <label for="inputName">{{ trans('static.name') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName', 'placeholder' => trans('static.name')]) !!}
</div>
<div class="form-group">
    <label for="inputPhone">{{ trans('static.phone') }}</label>
    {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'inputPhone', 'placeholder' => trans('static.phone')]) !!}
</div>
<div class="form-group">
    <label for="inputAddress">{{ trans('static.address') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::textarea('address', null, ['class' => 'form-control', 'id' => 'inputAddress', 'placeholder' => trans('static.address'), 'rows' => 4]) !!}
</div>
<div class="form-group">
    <label for="inputInstitution">{{ trans('static.institution') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::text('institution', null, ['class' => 'form-control', 'id' => 'inputInstitution', 'placeholder' => trans('static.institution')]) !!}
</div>
<div class="form-group">
    <label for="inputCountry">{{ trans('static.country') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
    {!! Form::select('country_id', $countries, old('country_id'), ['class' => 'form-control']) !!}
</div>
@if (request('reviewer') || (isset(auth()->user()->is_reviewer) && auth()->user()->is_reviewer))
    <div class="form-group">
        <label for="inputCategories">{{ trans('static.categories') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
        {!! Form::select('categories[]', $categories, isset($selectedCategories) ? $selectedCategories : null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'style' => 'width: 100%;']) !!}
    </div>
@endif