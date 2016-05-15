@extends('admin.master')

@section('content')
    <div class="mt">
        <h3 class="text-center mb20">{{ $department->keyword }} {{ trans('admin.information') }}</h3>
        <form class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.keyword')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $department->keyword }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.url')}}:</label>
                <div class="col-sm-10">
                    <a href="http://{{ $department->url }}" >
                        <label class="control-label">{{ $department->url }}</label>
                    </a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.image')}}:</label>
                <div class="col-sm-10">{!! HTML::image(asset('images/' . $department->image), null, ['class' => 'img-responsive']) !!}</div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.main-color')}}:</label>
                <div class="col-sm-10"><label class="control-label background" style="background-color: {{ $department->theme_background_color }}">{{ $department->theme_background_color }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.text-color')}}:</label>
                <div class="col-sm-10"><label class="control-label background" style="background-color: {{ $department->theme_color }}">{{ $department->theme_color }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.created-at')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $department->created_at }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.updated-at')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $department->updated_at }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.sort')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ $department->sort }}</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin.active')}}:</label>
                <div class="col-sm-10"><label class="control-label">{{ boolString($department->active) }}</label></div>
            </div>

            @foreach ($department->dbLangs as $localeCode => $lang)
                <hr>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ systemTrans($localeCode) }}</label></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('admin.name')}}:</label>
                    <div class="col-sm-10"><label class="control-label">{{ $lang->name }}</label></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('admin.title')}}:</label>
                    <div class="col-sm-10"><label class="control-label">{{ $lang->title }}</label></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('admin.description')}}:</label>
                    <div class="col-sm-10"><label class="control-label">{{ $lang->description }}</label></div>
                </div>
            @endforeach
            <div class="form-group">
                <div class="text-center">
                    @include('admin.partials.back')
                </div>
            </div>
        </form>
    </div>
@endsection