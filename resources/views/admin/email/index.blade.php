@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') Email :: @parent @stop

{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            Emails
            <div class="pull-right">
                <div class="pull-right">
                    <a href="{{{ URL::to('admin/email/listagem') }}}" target="_blank"
                       class="btn btn-sm  btn-success"><span
                                class="glyphicon glyphicon-download-alt"></span> Exportar</a>
                </div>
            </div>
        </h3>
    </div>

    <table id="table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>E-Mail</th>
            <th width="20%">Página</th>
            <th width="20%">Ambiente</th>
            <th width="15%">Produto</th>
            <th width="10%">Cadastrado em</th>
            <th width="5%">{{ trans("admin/admin.action") }}</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript">
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "sPaginationType": "bootstrap",
                "language": datatable_lang,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ URL::to('admin/email/data/') }}",
                "columns": [
                    {data: '0',  "orderable": true, "searchable":true},
                    {data: '1', "orderable": true, "searchable":true},
                    {data: '2', "orderable": true, "searchable":true},
                    {data: '3', "orderable": true, "searchable":false},
                    {data: '4', "orderable": true, "searchable":false},
                    {data: '5', "orderable": false, "searchable":false}
                ],
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        width: "98%",
                        height: "98%",
                        onClosed: function () {
                            oTable.ajax.reload();
                        }
                    });
                }
            });

            var startPosition;
            var endPosition;
            /*$("#table tbody").sortable({
                cursor: "move",
                start: function (event, ui) {
                    startPosition = ui.item.prevAll().length + 1;
                },
                update: function (event, ui) {
                    endPosition = ui.item.prevAll().length + 1;
                    var navigationList = "";
                    $('#table #row').each(function (i) {
                        navigationList = navigationList + ',' + $(this).val();
                    });
                    $.getJSON("{{ URL::to('admin/email/reorder') }}", {
                        list: navigationList
                    }, function (data) {
                    });
                }
            });*/
        });
    </script>
@stop
