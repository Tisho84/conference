<div class="panel-body">
    @include('layouts.partials.messages.errors')
    <div class="mt text-center">
        <label>{{ trans($title) }}</label>
    </div>
    <div class="panel-body">
        @if ($systemAdmin)
            <div class="form-group">
                <label for="department_id">{{ trans('admin.department') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                {!! Form::select('department_id', $departments, null, ['class' => 'form-control']) !!}
            </div>
        @endif
        <div class="form-group">
            <label for="category_id">{{ trans('static.category') }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
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
        <div class="form-group">
            <label for="user_id">{{ trans('static.uploader') }}</label><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
            {!! Form::select('user_id', $authors, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label for="reviewer">{{ trans('static.reviewer') }}</label>
            {!! Form::select('reviewer_id', $reviewers, null, ['class' => 'form-control']) !!}
        </div>
        @include('layouts.partials.button', ['button' => trans('static.save') ])
    </div>
</div>

