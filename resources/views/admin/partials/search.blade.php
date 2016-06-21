{!! HTML::script('/js/jquery.chained.remote.min.js') !!}
{!! Form::open(['method' => 'GET', 'url' => $search_url, 'class' => 'form-inline'])  !!}
    <div class="search-form row">
        @if (in_array('name', $search))
            <div class="form-group">
                <label for="name">{{ trans('static.name') }}:</label>
                {!! Form::text('name', request('name'), ['class' => 'form-control', 'id' => 'name']) !!}
            </div>
        @endif
        @if (in_array('title', $search))
            <div class="form-group">
                <label for="title">{{ trans('static.title') }}:</label>
                {!! Form::text('title', request('title'), ['class' => 'form-control', 'id' => 'title']) !!}
            </div>
        @endif
        @if ($systemAdmin && in_array('department', $search))
            <div class="form-group">
                <label for="department_id">{{ trans('admin.department') }}:</label>
                {!! Form::select('department_id', $departments, request('department_id'), ['class' => 'form-control', 'id' => 'department']) !!}
            </div>
        @endif
        @if (in_array('email', $search))
            <div class="form-group">
                <label for="email">{{ trans('static.email') }}:</label>
                {!! Form::text('email', request('email'), ['class' => 'form-control', 'id' => 'email']) !!}
            </div>
        @endif
        @if (in_array('category', $search))
            <div class="form-group">
                <label for="category_id">{{ trans('static.category') }}:</label>
                {!! Form::select('category_id', $systemAdmin && isset($force) && $force == false ? [trans('static.select')] : $categories, null, ['class' => 'form-control', 'id' => 'category']) !!}
            </div>
        @endif
        @if (in_array('status', $search))
            <div class="form-group">
                <label for="status_id">{{ trans('static.status') }}:</label>
                {!! Form::select('status_id', $statuses, (int)request('status_id'), ['class' => 'form-control']) !!}
            </div>
        @endif
        @if (in_array('type', $search))
            <div class="form-group">
                <label for="user_type_id">{{ trans('admin.user-type') }}:</label>
                {!! Form::select('user_type_id', $types, (int)request('user_type_id'), ['class' => 'form-control']) !!}
            </div>
        @endif
        @if (in_array('active', $search))
            <div class="form-group">
                <label for="active">{{ trans('admin.active') }}:</label>
                {!! Form::select('active', [ 0 => '', 1 => trans('static.no'), 2 => trans('static.yes')], (int)request('active'), ['class' => 'form-control']) !!}
            </div>
        @endif
        @if (in_array('date', $search))
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
        @endif
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