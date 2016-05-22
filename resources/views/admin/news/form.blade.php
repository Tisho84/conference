<div class="panel-body">
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 500,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | fontsizeselect | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>
    @include('layouts.partials.messages.errors')
    <div class="centered text-center">
        <h3>{{ trans($title) }}</h3>
    </div>
    @if ($systemAdmin)
        <div class="form-group">
            <label for="department_id">{{ trans('admin.department') }}</label>
            {!! Form::select('department_id', $departments, null, ['class' => 'form-control']) !!}
        </div>
    @endif
    @foreach (LaravelLocalization::getSupportedLocales() as $short => $locale)
        <div class="form-group">
            <label for="{{ $short }}">{{ trans('admin.title') . '(' . $locale['native'] . ')' }}<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
            {!! Form::text("title_" . $short, null, ['class' => 'form-control', 'id' => $short, 'placeholder' => trans('admin.title')]) !!}
        </div>
        <div class="form-group">
            <label for="{{ $short }}">{{ trans('admin.description') . '(' . $locale['native'] . ')' }}</label>
            {!! Form::textarea("description_" . $short, null, ['class' => 'form-control', 'id' => $short, 'placeholder' => trans('admin.description')]) !!}
        </div>
    @endforeach
    <div class="form-group">
        {!! buildActive() !!}
    </div>
    <div class="form-group">
        <label for="sort">{{ trans('admin.sort') }}</label>
        {!! Form::text('sort', null, ['class' => 'form-control', 'id' => 'sort', 'placeholder' => trans('admin.sort')]) !!}
    </div>
    @include('layouts.partials.button', ['button' => trans('static.save') ])
</div>