@extends('site')
@section('title') Home :: @parent @stop
@section('styles')
<style type="text/css">
.red{
  color:#ed1d24 !important;
}
.bt_ordenacao,.bt_ordenacao:link {
  color:#999999;
}
.bt_ordenacao:active{
  color:#ed1d24 !important;
}
.remove_ordenacao{
  margin-left: 10px;
}
.titulo_filtro{
  cursor: default;
}
.breadcrumb_texto{
  display: inline-block;
  padding: 6px 12px;
  margin-bottom: 0;
  font-size: 14px;
  font-weight: 400;
  line-height: 1.42857143;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
}
</style>
@stop
@section('content')
      <div class="row">
        <div class="col-lg-3">
          <div class="row">
            <div class="col-xs-12 visible-xs">

              <div class="gw-sidebar">
                <div id="gw-sidebar" class="gw-sidebar">
                  <div class="nano-content">
                    <ul class="gw-nav gw-nav-list">
                      <li class="init-arrow-down"> <a href="javascript:void(0)"> <span class="gw-menu-text">Ambientes</span> <b class="gw-arrow"></b> </a>
                        <ul class="gw-submenu">
                          @foreach($ambientes as $id=>$ambiente)
                          <li> <a href="/ambientes/{{str_slug($ambiente, '-').'/'. $id }}">{{$ambiente}}</a> </li>
                          @endforeach

                        </ul>
                      </li>
                      <li class="init-arrow-down"> <a href="javascript:void(0)"> <span class="gw-menu-text">Produtos</span> <b class="gw-arrow icon-arrow-up8"></b> </a>
                        <ul class="gw-submenu">
                          @foreach($tipos as $id=>$tipo)
                          <li> <a href="/tipos/{{str_slug($tipo, '-').'/'. $id }}">{{$tipo}}</a> </li>
                          @endforeach
                          
                        </ul>
                      </li>
                      <li class="init-arrow-down"> <a href="javascript:void(0)"> <span class="gw-menu-text">Lojas</span> <b></b> </a>
                        <ul class="gw-submenu">
                          @foreach($tipos as $id=>$tipo)
                          <li> <a href="/tipos/{{str_slug($tipo, '-').'/'. $id }}">{{$tipo}}</a> </li>
                          @endforeach
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 hidden-xs" style="padding-top: 8px;">
              <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="active"><a href="#" class="titulo_filtro">Ambientes</a></li>
                @foreach($ambientes as $id=>$ambiente)
                <li role="presentation" class="menu_ambientes" id="item_ambiente_{{$id}}"> <a href="#" ambiente="{{ $id }}" class="bt_ambiente">{{$ambiente}}</a> </li>
                @endforeach
                
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 hidden-xs">
              <ul class="nav nav-pills nav-stacked" style="margin-top:15px;">
                <li role="presentation" class="active"><a href="#" class="titulo_filtro">Produtos</a></li>
                @foreach($tipos as $id=>$tipo)
                <li role="presentation" class="menu_tipos" id="item_tipo_{{$id}}"> <a href="#" tipo="{{ $id }}" class="bt_tipo">{{$tipo}}</a> </li>
                @endforeach
                
              </ul>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-12 hidden-xs">
              <ul class="nav nav-pills nav-stacked" style="margin-top:15px;">
                <li role="presentation" class="active"><a href="#" class="titulo_filtro">Lojas</a></li>
                @foreach($lojas as $id=>$loja)
                <li role="presentation"  class="menu_loja" id="item_loja_{{$id}}"> <a href="#" loja="{{ $id }}" class="bt_loja">{{$loja}}</a> </li>
                @endforeach
              </ul>
            </div>
          </div>
          <br />
        </div> <!-- /. col-lg-3 -->
        <div class="col-lg-9">
          <div id="header_produtos" style="display:none;height: 35px;">
            <h5 style="color:#999999">
              <div id="bloco_breadcrumb" class="pull-left">
                
              </div>
              <div id="bloco_ordenacao" class="pull-right">
                Ordenar por:
                <a href="#" class="bt_ordenacao btn btn-link" ordenacao="menor_preco" id="bt_ordenacao_menor_preco">Menor Preço</a>
                <a href="#" class="bt_ordenacao btn btn-link" ordenacao="maior_preco" id="bt_ordenacao_maior_preco">Maior Preço</a>
                <a href="#" class="bt_ordenacao btn btn-link" ordenacao="visitas" id="bt_ordenacao_visitas">Mais Visitados</a>
              </div>
            </h5>
          </div>
          <div class="row" id="bloco_produtos">
            
           
          </div>
          <div class="row">
            <span class="col-md-4 col-md-offset-4">
              <button type="button" class="btn btn-default btn-block" id="btn_carrega_mais_produtos" style="display:none;" onclick="carregaProdutos();">Carregar mais produtos</button>
            </span>
          </div>
        </div> <!-- /. col-lg-9 -->
      </div> <!-- /. row -->

@endsection

@section('scripts')
    @parent
    <script src="{{asset('assets/site/js/mustache.js')}}"></script>
    <script src="{{asset('assets/site/js/templates.js')}}"></script>

    <script>
        $('#myCarousel').carousel({
            interval: 4000
        });
        var page = 1;
        var next_page = '/produtos/data';        

        function carregaProdutos(){
          if(v_loading == 0){
            ativaDesativaMenu();
            if(next_page){
              v_loading = 1;
              carregaLoading();

              $.ajax({
                url: next_page,
                data: {termo: v_termo,ambiente_id: v_ambiente, tipo_id: v_tipo, loja_id: v_loja, ordenacao: v_ordenacao }
              })
              .done(function(retorno) {
                next_page = retorno.next_page_url;
                if(!next_page){
                  $('#btn_carrega_mais_produtos').hide('fast');
                }else{
                  $('#btn_carrega_mais_produtos').show('fast');
                }
                fechaLoading();
                v_loading = 0;
                html = Mustache.to_html(template_produtos, retorno);
                $('#bloco_produtos').append(html);
                $('.item-produto').show('fast',function(){
                  $('.tag-parcela').show('slow');
                });
              })
              .fail(function() {
                fechaLoading();
                v_loading = 0;
              });

              $.ajax({
                url: '/produtos/filtro',
                data: {termo: v_termo,ambiente_id: v_ambiente, tipo_id: v_tipo, loja_id: v_loja, ordenacao: v_ordenacao }
              })
              .done(function(retorno) {
                
                if(!next_page){
                  $('#btn_carrega_mais_produtos').hide('fast');
                }else{
                  $('#btn_carrega_mais_produtos').show('fast');
                }
                console.log(retorno);
                // Filtros
                $('.menu_ambientes').hide();
                $.each(retorno.ambientes, function(index, val) {
                   $('#item_ambiente_'+index).show();
                });

                $('.menu_tipos').hide();
                $.each(retorno.tipos, function(index, val) {
                   $('#item_tipo_'+index).show();
                });

                $('.menu_loja').hide();
                $.each(retorno.lojas, function(index, val) {
                   $('#item_loja_'+index).show();
                });

              });

            }
          }
        }

        $(document).ready(function() {
          
          carregaProdutos();
          
          
        });

        
    </script>
@endsection
@stop
