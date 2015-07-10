@extends('site')
@section('title') Home :: @parent @stop
@section('content')
      <div class="row">
        <div class="row">
        <div class="col-sm-12 col-md-8">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="buscalojanome" placeholder="Buscar pelo nome da loja">
            <span id="btnbuscalojanome" class="glyphicon glyphicon-search form-control-feedback"></span>
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="form-group has-feedback">
            <select id="buscalojasegmento" name="buscalojasegmento" class="form-control" placeholder="Segmento" onchange="onBuscaPorSegmento(this.value);" style="color: #9C9C9C;" >
              <option value="0">Buscar por segmento</option>
              @foreach($lojastipos as $item)
              <option value="{{$item->id}}">{{$item->nome}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      </div>

      <div class="row">
        <div class="col-md-12 hidden-xs">
          <div style="text-align: center;color: #666666;font-style: bold;margin-bottom: 20px;">
            <span>Buscar pela inicial: 
              <a href="#" onclick="buscarLojas('A');">A</a> 
              <a href="#" onclick="buscarLojas('B');">B</a> 
              <a href="#" onclick="buscarLojas('C');">C</a> 
              <a href="#" onclick="buscarLojas('D');">D</a> 
              <a href="#" onclick="buscarLojas('E');">E</a> 
              <a href="#" onclick="buscarLojas('F');">F</a> 
              <a href="#" onclick="buscarLojas('G');">G</a> 
              <a href="#" onclick="buscarLojas('H');">H</a> 
              <a href="#" onclick="buscarLojas('I');">I</a> 
              <a href="#" onclick="buscarLojas('J');">J</a> 
              <a href="#" onclick="buscarLojas('K');">K</a> 
              <a href="#" onclick="buscarLojas('L');">L</a> 
              <a href="#" onclick="buscarLojas('M');">M</a> 
              <a href="#" onclick="buscarLojas('N');">N</a> 
              <a href="#" onclick="buscarLojas('O');">O</a> 
              <a href="#" onclick="buscarLojas('P');">P</a> 
              <a href="#" onclick="buscarLojas('Q');">Q</a> 
              <a href="#" onclick="buscarLojas('R');">R</a> 
              <a href="#" onclick="buscarLojas('S');">S</a> 
              <a href="#" onclick="buscarLojas('T');">T</a> 
              <a href="#" onclick="buscarLojas('U');">U</a> 
              <a href="#" onclick="buscarLojas('W');">W</a> 
              <a href="#" onclick="buscarLojas('Y');">Y</a> 
              <a href="#" onclick="buscarLojas('X');">X</a> 
              <a href="#" onclick="buscarLojas('Z');">Z</a> 
              <a href="#" onclick="buscarLojas('0');">0-9</a>
            </span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="row" id="bloco_lojas">

        </div> <!-- /. row -->

        <div class="row">
          <span class="col-md-4 col-md-offset-4">
            <button type="button" class="btn btn-default btn-block" id="btn_carrega_mais_lojas" onclick="carregaLojas();">Carregar mais Lojas</button>
          </span>
        </div>        
      </div> <!-- /. row -->

@endsection

@section('scripts')
    @parent
    <script src="{{asset('assets/site/js/mustache.js')}}"></script>
    <script src="{{asset('assets/site/js/templates.js')}}"></script>

    <script>
        var page = 1;
        var next_page = '/loja/data';

        $(document).ready(function() {
          carregaLojas();

          $('#buscalojanome').bind('keypress', function(e) {
              var code = e.keyCode || e.which;
              if(code == 13) { //Enter keycode
               buscarLojas();
              }
          });  
          $('#btnbuscalojanome').click(function() {
              buscarLojas();
          });  

        });

        function carregaLojas(){

          if(next_page){

            carregaLoading();

            $.ajax({
              url: next_page,
            })
            .done(function(retorno) {
              next_page = retorno.next_page_url;
              if(!next_page){
                $('#btn_carrega_mais_lojas').hide('fast');
              }
              fechaLoading();
              html = Mustache.to_html(template_lojas, retorno);
              $('#bloco_lojas').append(html);
            })
            .fail(function() {
              fechaLoading();
            });

          }
        }

        function buscarLojas(v_letrainicial){
          var v_nome = $('#buscalojanome').val();
          var v_segmento = $('#buscalojasegmento').val();
          /*
          if (v_nome.length < 4 && v_letrainicial == null)
          {
              alert('Por favor, informe o nome da Loja que deseja buscar!');
              return false;
          }
          */
          carregaLoading();
          $.ajax({
              url: '/loja/buscar',
              type: 'POST',
              dataType: 'json',
              data: {_token: '{{{ csrf_token() }}}', nome:v_nome, segmento:v_segmento, letrainicial:v_letrainicial},
          })
          .done(function(retorno) {
              next_page = retorno.next_page_url;
              if(retorno.total > 0){
                if(!next_page){
                  $('#btn_carrega_mais_lojas').hide('fast');
                }
                fechaLoading();
                html = Mustache.to_html(template_lojas, retorno);
                $('#bloco_lojas').html(html);

                fechaLoading();
              }
              else{
                $('#bloco_lojas').html(
                  '<div class="col-sm-12 col-md-12" style="text-align: center;">\
                    <div style="background-color: #fff;padding: 30px;style="color: #cccccc;">\
                      <span>Nenhuma Loja encontrada!</span>\
                    </div>\
                  </div>');
                  $('#btn_carrega_mais_lojas').hide('fast');
                fechaLoading();
              }
              if(retorno.erro){
                  $('#buscalojanome').parent().addClass('has-error');
                  $('#buscalojanome').val('Houve algum erro ao buscar Lojas.');

                  setTimeout(function() {
                     $('#buscalojanome').val(''); 
                     $('#buscalojanome').parent().removeClass('has-error');
                  }, 5000);
              }else{
                  //$('#buscalojanome').parent().addClass('has-success');
              }
              setTimeout(function() {
                 //$('#buscalojanome').parent().removeClass('has-success');
                 $('#buscalojanome').val(''); 
              }, 5000);
          })
          .fail(function() {
              fechaLoading();
                  $('#buscalojanome').parent().addClass('has-error');
              $('#buscalojanome').val('Houve algum erro ao buscar Lojas.');
              setTimeout(function() {
                 $('#buscalojanome').val(''); 
                 $('#buscalojanome').parent().removeClass('has-error');
              }, 5000);
          });
        }

        function onBuscaPorSegmento(segmento){
          buscarLojas();
        }
    </script>
@endsection
@stop      	