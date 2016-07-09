{!! HTML::style('/css/export.min.css') !!}
{!! HTML::script('/js/shieldui-all.min.js') !!}
{!! HTML::script('/js/jszip.min.js') !!}

<script type="text/javascript">
    jQuery(function ($) {
        $("#exportButton").click(function () {
            // parse the HTML table element having an id=exportTable
            var dataSource = shield.DataSource.create({
                data: "#exportTable",
                schema: {
                    type: "table",
                    fields: {
                        "{{ trans('static.title') }}": { type: String },
                        "{{ trans('static.category') }}": { type: String },
                        "{{ trans('static.uploader') }}": { type: String },
                        "{{ trans('static.reviewer') }}": { type: String },
                        "{{ trans('static.created-at') }}": { type: String },
                        "{{ trans('static.status') }}": { type: String }
                    }
                }
            });
            // when parsing is done, export the data to Excel
            dataSource.read().then(function (data) {
                new shield.exp.OOXMLWorkbook({
                    author: "conference",
                    worksheets: [
                        {
                            name: "Papers Table",
                            columns: [ { autoWidth: true },{ autoWidth: true },{ autoWidth: true },{ autoWidth: true },{ autoWidth: true },{ autoWidth: true } ],
                            rows: [
                                {
                                    cells: [
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "{{ trans('static.title') }}"
                                        },
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "{{ trans('static.category') }}"
                                        },
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "{{ trans('static.uploader') }}"
                                        },
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "{{ trans('static.reviewer') }}"
                                        },
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "{{ trans('static.created-at') }}"
                                        },
                                        {
                                            style: {
                                                bold: true
                                            },
                                            type: String,
                                            value: "{{ trans('static.status') }}"
                                        }
                                    ]
                                }
                            ].concat($.map(data, function(item) {
                                return {
                                    cells: [
                                        { type: String, value: item["{{ trans('static.title') }}"] },
                                        { type: String, value: item["{{ trans('static.category') }}"] },
                                        { type: String, value: item["{{ trans('static.uploader') }}"] },
                                        { type: String, value: item["{{ trans('static.reviewer') }}"] },
                                        { type: String, value: item["{{ trans('static.created-at') }}"] },
                                        { type: String, value: item["{{ trans('static.status') }}"] }
                                    ]
                                };
                            }))
                        }
                    ]
                }).saveAs({
                    fileName: "papers_excel"
                });
            });
        });
    });
</script>