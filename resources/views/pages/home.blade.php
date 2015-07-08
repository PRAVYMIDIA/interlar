@extends('site')
@section('title') Home :: @parent @stop
@section('content')
      <div class="row">
        <div class="col-lg-12">
          @if($banner)
            <div onclick="document.location='{{ $banner->url }}';" style="cursor:pointer;">
            @if(strlen($banner->html) )
              {!! $banner->html !!}
            @else
              <img class="img-responsive img-thumbnail center-block" title="imagem atual" src="/images/banner/{{$banner->id.'/'.$banner->imagem }}" alt="banner">
            @endif
            </div>
          @endif
        </div>
      </div> <!-- /. row -->

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
                          <li> <a href="javascript:void(0)">Mesas</a> </li>
                          <li> <a href="javascript:void(0)">Cadeiras</a> </li>
                          <li> <a href="javascript:void(0)">Planejados</a> </li>
                          <li> <a href="javascript:void(0)">Sofas</a> </li>
                          <li> <a href="javascript:void(0)">Poltronas</a> </li>
                          <li> <a href="javascript:void(0)">Racks</a> </li>
                        </ul>
                      </li>
                      <li class="init-arrow-down"> <a href="javascript:void(0)"> <span class="gw-menu-text">Lojas</span> <b></b> </a>
                        <ul class="gw-submenu">
                          <li> <a href="javascript:void(0)">Diratelli</a> </li>
                          <li> <a href="javascript:void(0)">Interlinea</a> </li>
                          <li> <a href="javascript:void(0)">Italínea</a> </li>
                          <li> <a href="javascript:void(0)">Lojas Fenicia</a> </li>
                          <li> <a href="javascript:void(0)">Momento Design</a> </li>
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
                <li role="presentation" class="active"><a href="#">Ambientes</a></li>
                @foreach($ambientes as $id=>$ambiente)
                <li role="presentation" class="{{set_active('ambiente/'.str_slug($ambiente, '-').'*')}}-item"> <a href="/ambientes/{{str_slug($ambiente, '-').'/'. $id }}">{{$ambiente}}</a> </li>
                @endforeach
                
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 hidden-xs">
              <ul class="nav nav-pills nav-stacked" style="margin-top:15px;">
                <li role="presentation" class="active"><a href="#">Produtos</a></li>
                @foreach($tipos as $id=>$tipo)
                <li role="presentation" class="{{set_active('tipo/'.str_slug($tipo, '-').'*')}}-item"> <a href="/tipos/{{str_slug($tipo, '-').'/'. $id }}">{{$tipo}}</a> </li>
                @endforeach
                
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 hidden-xs">
              <ul class="nav nav-pills nav-stacked" style="margin-top:15px;">
                <li role="presentation" class="active"><a href="#">Lojas</a></li>
                @foreach($lojas as $id=>$loja)
                <li role="presentation" class="{{set_active('loja/'.str_slug($loja, '-').'*')}}-item"> <a href="/lojas/{{str_slug($loja, '-').'/'. $id }}">{{$loja}}</a> </li>
                @endforeach
              </ul>
            </div>
          </div>
          <br />
        </div> <!-- /. col-lg-3 -->
        <div class="col-lg-9">
          <div class="row" id="bloco_produtos">
            
           
          </div>
          <div class="row">
            <span class="col-md-4 col-md-offset-4">
              <button type="button" class="btn btn-default btn-block" id="btn_carrega_mais_produtos" onclick="carregaProdutos();">Carregar mais produtos</button>
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

          if(next_page){

            carregaLoading();

            $.ajax({
              url: next_page,
            })
            .done(function(retorno) {
              next_page = retorno.next_page_url;
              if(!next_page){
                $('#btn_carrega_mais_produtos').hide('fast');
              }
              fechaLoading();
              html = Mustache.to_html(template_produtos, retorno);
              $('#bloco_produtos').append(html);
              $('.item-produto').show('fast',function(){
                $('.tag-parcela').show('slow');
              });
            })
            .fail(function() {
              fechaLoading();
            });

          }
        }

        $(document).ready(function() {
          
          carregaProdutos();
          
          
        });

        
    </script>
@endsection
@stop
