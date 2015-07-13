@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') Produtos :: @parent @stop

{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            Produtos
            <div class="pull-right">
                <div class="pull-right">
                    <a href="{{{ URL::to('admin/produto/create') }}}"
                       class="btn btn-sm  btn-primary iframe"><span
                                class="glyphicon glyphicon-plus-sign"></span> {{
					trans("admin/modal.new") }}</a>
                </div>
            </div>
        </h3>
    </div>

    <table id="table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Valor Promo.</th>
            <th>Parcelas</th>
            <th>Imagem</th>
            <th>Criado em</th>
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
                "columns": [

                    {data: '0',  "orderable": true, "searchable":true, name:'produtos.nome'},
                    {data: '1', "orderable": true, "searchable":true, name:'produtos_tipos.nome'},
                    {data: '2', "orderable": true, "searchable":true, name:'produtos.valor'},
                    {data: '3', "orderable": true, "searchable":true, name:'produtos.valor_promocional'},
                    {data: '4', "orderable": true, "searchable":true, name:'produtos.parcelas'},
                    {data: '5', "orderable": false, "searchable":false, name:'produtos.imagem'},
                    {data: '6', "orderable": false, "searchable":true, name:'produtos.created_at'},
                    {data: '7', "orderable": false, "searchable":false},
                ],
                "ajax": "{{ URL::to('admin/produto/data/') }}",
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
           /* $("#table tbody").sortable({
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
                    $.getJSON("{{ URL::to('admin/produto/reorder') }}", {
                        list: navigationList
                    }, function (data) {
                    });
                }
            });*/
        });
    </script>
@stop
