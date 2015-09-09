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
            <div class="col-xs-12 visible-xs visible-sm">

              <div class="gw-sidebar">
                <div id="gw-sidebar" class="gw-sidebar">
                  <div class="nano-content">
                    <ul class="gw-nav gw-nav-list">
                      <li class="init-arrow-down"> <a href="javascript:void(0)"> <span class="gw-menu-text"><strong>Ambientes</strong></span> <b class="gw-arrow"></b> </a>
                        <ul class="gw-submenu">
                          @foreach($ambientes as $id=>$ambiente)
                          <li class="menu_ambientes item_ambiente_{{$id}}"> <a href="#" ambiente="{{ $id }}" class="bt_ambiente">{{$ambiente}}</a> </li>
                          @endforeach

                        </ul>
                      </li>
                      <li class="init-arrow-down"> <a href="javascript:void(0)"> <span class="gw-menu-text"><strong>Produtos</strong></span> <b class="gw-arrow icon-arrow-up8"></b> </a>
                        <ul class="gw-submenu">
                          @foreach($tipos as $id=>$tipo)
                          <li class="menu_tipos item_tipo_{{$id}}"> <a href="#" tipo="{{ $id }}" class="bt_tipo">{{$tipo}}</a> </li>
                          @endforeach
                          
                        </ul>
                      </li>
                      <li class="init-arrow-down"> <a href="javascript:void(0)"> <span class="gw-menu-text"><strong>Lojas</strong></span> <b></b> </a>
                        <ul class="gw-submenu">
                          @foreach($lojas as $id=>$loja)
                          <li  class="menu_loja item_loja_{{$id}}"> <a href="#" loja="{{ $id }}" class="bt_loja">{{$loja}}</a> </li>
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
            <div class="col-sm-12 hidden-xs hidden-sm" style="padding-top: 8px;">
              <ul class="nav nav-pills nav-stacked" id="bloco_menu_ambientes">
                <li role="presentation" id="tit_bloco_menu_ambientes" class="active"><a href="#" class="titulo_filtro"><strong>Ambientes</strong></a></li>
                @foreach($ambientes as $id=>$ambiente)
                <li role="presentation" class="menu_ambientes item_ambiente_{{$id}} notmobile"> <a href="#" ambiente="{{ $id }}" class="bt_ambiente">{{$ambiente}}</a> </li>
                @endforeach
                
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 hidden-xs hidden-sm">
              <ul class="nav nav-pills nav-stacked" id="bloco_menu_produtos" style="margin-top:15px;">
                <li role="presentation" id="tit_bloco_menu_tipos" class="active"><a href="#" class="titulo_filtro"><strong>Produtos</strong></a></li>
                @foreach($tipos as $id=>$tipo)
                <li role="presentation" class="menu_tipos item_tipo_{{$id}} notmobile"> <a href="#" tipo="{{ $id }}" class="bt_tipo">{{$tipo}}</a> </li>
                @endforeach
                
              </ul>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-12 hidden-xs hidden-sm">
              <ul class="nav nav-pills nav-stacked" id="bloco_menu_lojas" style="margin-top:15px;">
                <li role="presentation" class="active" id="tit_bloco_menu_lojas"><a href="#" class="titulo_filtro"><strong>Lojas</strong></a></li>
                @foreach($lojas as $id=>$loja)
                <li role="presentation"  class="menu_loja item_loja_{{$id}} notmobile"> <a href="#" loja="{{ $id }}" class="bt_loja">{{$loja}}</a> </li>
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
          <div class="row" style="margin: 50px 0px;">
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
        var v_resolucao = screen.width;


      function ajustaVerMais(qual){
        // console.log('Chamou função ajustaVerMais()');
        // console.log(qual);
        $('.nav-stacked').each(function(index, el) {
          $(el).css({
            'height': 'auto',
            'overflow-y': 'visible'
          });
          // Verifica se este foi selecionado pra expandir ou é menor q o limite mínimo
          // console.log('Elemento:'+$(el).attr('id')+' - '+$(el).height());
            if($(el).height()< 362 || $(el).attr('id') == qual){
              // console.log('Expandido');
              $(el).css({
                'height': 'auto',
                'overflow-y': 'visible'
              });
              if($('#bt_exp_'+$(el).attr('id')).length){
                $('#bt_exp_'+$(el).attr('id')).remove();
              }
            }else{
              $(el).css({
                'height': '362px',
                'overflow-y': 'hidden'
              });
              if(! $('#bt_exp_'+$(el).attr('id')).length){
                $(el).parent().append('<button type="button" style="margin-top:5px" id="bt_exp_'+$(el).attr('id')+'" class="btn btn-block btn-default" onclick="ajustaVerMais(\''+$(el).attr('id')+'\');" >Ver Todos</button>');
              }
            }
        });
      }

        function carregaProdutos(){
          if(v_loading == 0){
            ativaDesativaMenu();
            if(next_page){
              v_loading = 1;
              carregaLoading();

              $.ajax({
                url: next_page,
                data: {termo: v_termo,ambiente_id: v_ambiente, tipo_id: v_tipo, loja_id: v_loja, ordenacao: v_ordenacao, resolucao: v_resolucao }
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
                // console.log(retorno);
                // Filtros
                $('.menu_ambientes').hide();
                $.each(retorno.ambientes, function(index, val) {
                   $('.item_ambiente_'+index).not('#ambiente_selected').show();
                });

                $('.menu_tipos').hide();
                $.each(retorno.tipos, function(index, val) {
                   $('.item_tipo_'+index).not('#tipo_selected').show();
                });

                $('.menu_loja').hide();
                $.each(retorno.lojas, function(index, val) {
                   $('.item_loja_'+index).not('#loja_selected').show();
                });

                ajustaVerMais(null);

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
