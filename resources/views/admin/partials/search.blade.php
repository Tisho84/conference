{!! HTML::script('/js/jquery.chained.remote.min.js') !!}
{!! Form::open(['method' => 'GET', 'url' => action('Admin\PaperController@index'), 'class' => 'form-inline'])  !!}
    <div class="search-form">
        <div class="form-group">
            <label for="title">{{ trans('static.title') }}:</label>
            {!! Form::text('title', request('title'), ['class' => 'form-control', 'id' => 'title']) !!}
        </div>
        @if ($systemAdmin)
            <div class="form-group">
                <label for="department_id">{{ trans('admin.department') }}:</label>
                {!! Form::select('department_id', $departments, request('department_id'), ['class' => 'form-control', 'id' => 'department']) !!}
            </div>
        @endif
        <div class="form-group">
            <label for="category_id">{{ trans('static.category') }}:</label>
            {!! Form::select('category_id', $systemAdmin && isset($force) && $force == false ? [trans('static.select')] : $categories, null, ['class' => 'form-control', 'id' => 'category']) !!}
        </div>
        <div class="form-group">
            <label for="status_id">{{ trans('static.status') }}:</label>
            {!! Form::select('status_id', $statuses, (int)request('status_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label for="from">{{ trans('static.from') }}:</label>
            <div class="input-group date" data-provide="datepicker">
                {!! Form::text('from', request('from'), ['class' => 'form-control']) !!}
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
            <label for="to">{{ trans('static.to') }}:</label>
            <div class="input-group date" data-provide="datepicker">
                {!! Form::text('to', request('to'), ['class' => 'form-control']) !!}
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
        <div class="form-group pull-right">
            <button type="submit" class="btn btn-default">{{ trans('static.search') }}</button>
        </div>
    </div>
{!! Form::close() !!}
<script>
    $("#category").remoteChained({
        parents : "#department",
        url : "<?php echo route('department_categories')?>"
    });
</script>