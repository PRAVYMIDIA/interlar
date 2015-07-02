@extends('layouts.sidenav')

{{-- Web site Title --}}
@section('title')
    Administração :: @parent
@endsection

{{-- Styles --}}
@section('styles')
    @parent

    <link href="{{ elixir('css/admin.css') }}" rel="stylesheet">

@endsection

{{-- Sidebar --}}
@section('sidebar')
    @include('admin.partials.nav')
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

    <script src="{{ elixir('js/admin.js') }}"></script>

    {{-- Not yet a part of Elixir workflow --}}
    <script src="{{asset('assets/admin/js/bootstrap-dataTables-paging.js')}}"></script>
    <script src="{{asset('assets/admin/js/datatables.fnReloadAjax.js')}}"></script>
    <script src="{{asset('assets/admin/js/modal.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    {{-- Default admin scripts--}}
    <script type="text/javascript">
        {{-- from sb-admin-2 --}}
        $(function () {
            $('.metismenu > ul').metisMenu();
        });
        var datatable_lang = {
                              "sEmptyTable": "Nenhum registro encontrado",
                              "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                              "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                              "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                              "sInfoPostFix": "",
                              "sInfoThousands": ".",
                              "sLengthMenu": "_MENU_ resultados por página",
                              "sLoadingRecords": "Carregando...",
                              "sProcessing": "Processando...",
                              "sZeroRecords": "Nenhum registro encontrado",
                              "sSearch": "Pesquisar",
                              "oPaginate": {
                                  "sNext": "Próximo",
                                  "sPrevious": "Anterior",
                                  "sFirst": "Primeiro",
                                  "sLast": "Último"
                              },
                              "oAria": {
                                  "sSortAscending": ": Ordenar colunas de forma ascendente",
                                  "sSortDescending": ": Ordenar colunas de forma descendente"
                              }
                          };
    </script>

@endsection
