<div class="panel-body">
    {!! HTML::script('/js/jquery.chained.remote.min.js') !!}
    @include('layouts.partials.messages.errors')
    <div class="centered text-center">
        <h3>{{ trans($title) }}</h3>
    </div>
    @if ($systemAdmin)
        <div class="form-group">
            <label for="department_id">{{ trans('admin.department') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::select('department_id', $departments, null, ['class' => 'form-control', 'id' => 'department']) !!}
        </div>
    @else
        {!! Form::hidden('department_id', auth()->user()->department_id) !!}
    @endif
    <div class="form-group">
        <label for="category_id">{{ trans('static.category') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
        {!! Form::select('category_id', $systemAdmin && isset($force) && $force == false ? [trans('static.select')] : $categories, null, ['class' => 'form-control', 'id' => 'category']) !!}
    </div>
    <div class="form-group">
        <label for="reviewer">{{ trans('static.reviewer') }}</label>
        {!! Form::select('reviewer_id', $systemAdmin && isset($force) && $force == false ? [trans('static.select')] : $reviewers, null, ['class' => 'form-control', 'id' => 'reviewer']) !!}
        <label>{{ trans('static.reviewer-text') }}</label>
    </div>
    <div class="form-group">
        <label for="user_id">{{ trans('static.uploader') }}</label><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
        {!! Form::select('user_id', $systemAdmin && isset($force) && $force == false ? [trans('static.select')] : $authors, null, ['class' => 'form-control', 'id' => 'author']) !!}
    </div>
    <div class="form-group">
        <label for="status_id">{{ trans('static.status') }}</label>
        {!! Form::select('status_id', $statuses, null, ['class' => 'form-control']) !!}
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
        <label for="payment_description">{{ trans('static.invoice-description') }}</label>
        {!! Form::textarea("payment_description", null, ['class' => 'form-control ', 'id' => 'payment_description', 'placeholder' => trans('static.invoice-description')]) !!}
    </div>
    <div class="form-group">
        <label for="payment_source">{{ trans('static.invoice-source') }}
            @if (isset($paper) && $paper->payment_source)
                <span>({{ trans('messages.upload-file') }})</span>
            @endif
        </label>
        {!! Form::file("payment_source", null, ['class' => 'form-control', 'id' => 'payment_source', 'placeholder' => trans('static.invoice-source')]) !!}
    </div>
    @include('layouts.partials.button', ['button' => trans('static.save') ])
    <script>
        $("#category").remoteChained({
            parents : "#department",
            url : "<?php echo route('department_categories')?>"
        });

        $('#author').remoteChained({
            parents : "#department",
            url : "<?php echo route('department_authors')?>"
        });

        $('#reviewer').remoteChained({
            parents: '#category',
            url: "<?php echo route('category_reviewers')?>",
            depends : "#department"
        });
    </script>
</div>

