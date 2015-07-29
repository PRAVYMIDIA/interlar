@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') Contato :: @parent @stop

{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            Contato
            
        </h3>
    </div>

    <table id="table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Nome</th>
            <th width="10%">Qtd. Respostas</th>
            <th width="10%">Meio</th>
            <th>Enviada em</th>
            <th width="10%">Aceita publicidade</th>
            <th width="10%">{{ trans("admin/admin.action") }}</th>
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
                "ajax": "{{ URL::to('admin/contato/data/') }}",
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
                    $.getJSON("{{ URL::to('admin/contato/reorder') }}", {
                        list: navigationList
                    }, function (data) {
                    });
                }
            });*/
        });
    </script>
@stop
