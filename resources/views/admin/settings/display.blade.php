@extends('admin.master')

@section('content')
    <script type="text/javascript">
        function confirmAuto(id) {
            if (confirm("{{ trans('static.are-you-sure') }}")) {
                $.ajax({
                    url: "{{ action('Admin\SettingsController@auto') }}",
                    type: 'POST',
                    data: {'department_id': id, '_token': "{{ csrf_token() }}" },
                    success: function (response) {
                        if (response.status) {
                            alert(response.message);
                        }
                    },
                    dataType: 'json'
                });

            }
            return false;
        }

    </script>
    {!! Form::open(['method' => 'post', 'url' => action('Admin\SettingsController@save') ]) !!}
        <div class="centered text-center">
            <h3>{!! trans('static.settings') !!}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
            <div class="col-sm10 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
            @foreach ($departments as $department)
                <div class="form-group">
                    <label class="control-label">{!! trans('admin.department') . ': ' . $department->langs->first()->title !!}</label>
                    <div class="row">
                        <div class="col-sm10 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                            <div class="form-group">
                                {!! HTML::link('#', trans('static.auto'), ['class' => 'btn btn-default', 'onclick' => 'return confirmAuto(' . $department->id .')']) !!}
                            </div>
                        @foreach ($settings as $setting)
                            <div class="form-group">
                                <label>{!! $setting['title'] !!}</label>
                                @if ($setting['plain'])
                                    {!! Form::text('department[' . $department->id . '][' .$setting['key'] . ']', isset($settingsRecords[$department->id][$setting['key']]) ? (int)$settingsRecords[$department->id][$setting['key']] : 5, ['class' => 'form-control']) !!}
                                @else
                                    {!! Form::select('department[' . $department->id . '][' .$setting['key'] . ']',
                                        isset($setting['data']) ? $setting['data'][$department->id] : selectBoolean(),
                                        isset($settingsRecords[$department->id][$setting['key']]) ? (int)$settingsRecords[$department->id][$setting['key']] : 0, ['class' => 'form-control'])
                                    !!}
                                @endif
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            </div>
        </div>
        @include('layouts.partials.button', ['button' => trans('static.save') ])
    {!! Form::close() !!}
@stop
