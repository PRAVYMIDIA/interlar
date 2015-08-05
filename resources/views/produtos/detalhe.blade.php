@extends('site')
@section('title') {{$produto->nome}} :: @parent @stop
@section('styles')
<style type="text/css">
  .extra { /* Universal settings */
    -webkit-transition:all .4s;
    -moz-transition:all .4s;
    -ms-transition:all .4s;
    -o-transition:all .4s;
    transition:all .4s;
  }
  .extra-inactive {
      -webkit-filter:grayscale(100%);
      -moz-filter:grayscale(100%);
      -ms-filter:grayscale(100%);
      -o-filter:grayscale(100%);
      filter:grayscale(100%);
  }
  
</style>
@stop
@section('content')
      <div class="row" style="margin-top:15px;">
        <div class="col-md-9">
          <h2><i onclick="history.go(-1);void(0);" class="glyphicon glyphicon-circle-arrow-left" title="Voltar" style="color:#999999;cursor:pointer;"></i> {{$produto->nome}}</h2>
          <p>{!! $produto->descricao !!}</p>

          <div class="row">
            <img class="thumbnail thumbnail-custom img-responsive" id="imagem_principal" 
              src="{{ '/images/produto/'.$produto->id.'/'.$produto->imagemResize(870,null,90) }}" alt="{{$produto->nome}}">
          </div>
          <div class="row" style="margin-top:15px;">
            @if( count( $produto->imagens ) )
              <span class="col-md-3" id="mini_principal">
                <a href="{{ '/images/produto/'.$produto->id.'/'.$produto->imagem }}" exibir="{{ '/images/produto/'.$produto->id.'/'.$produto->imagemResize(870,null,90) }}" class="thumbnail thumbnail-custom miniatura-extra"  target="_blank" title="Ver imagem em tamanho máximo">
                    <img title="imagem extra" id="img_mini_principal" class="extra" src="{{ '/images/produto/'.$produto->id.'/'.$produto->thumb() }}" alt="Imagem">
                </a>
              </span>
              @foreach($produto->imagens as $imagem)
              <span class="col-md-3">
                <a href="/images/produto/{{$produto->id.'/'.$imagem->imagem }}" exibir="{{ '/images/produto/'.$produto->id.'/'.$imagem->imagemResize(870,null,90) }}" class="thumbnail thumbnail-custom miniatura-extra"  target="_blank" title="Ver imagem em tamanho máximo">
                    <img title="imagem extra" class="extra" src="/images/produto/{{$produto->id.'/'.$imagem->thumb() }}" alt="Imagem">
                </a>
              </span>
              @endforeach
            @endif
          </div>
        </div> <!-- /. col-md-9 -->
        <div class="col-md-3" style="font-size:16px; text-align:center;">
          <div class="thumbnail thumbnail-custom" style="margin-bottom:30px;" >
            @if($produto->valor)

              @if($produto->valor_promocional)
                  <span style="text-decoration:line-through; color:#999;">De: R$ {{$produto->valor}} </span>
                  <span>por apenas: </span>
                  <br><span>R$</span><span style="color:red; font-size:38px;">{{$produto->valor_promocional}}</span>
              @else
                  <span>R$</span><span style="color:red; font-size:30px;">{{$produto->valor}}</span>
              @endif
            @else
              <h4>Sob Consulta</h4>
            @endif
            @if($produto->parcelas)
              <br><span style="font-size:16px; clear:both;"> em até {{ $produto->parcelas }}x s/Juros</span>
            @endif
          </div>

          @if($produto->loja)
          <div class="col-md-12" style="background-color:#FFF; margin-bottom:30px; text-align:center;">
              <img title="{{ $produto->loja->nome }}" src="/images/loja/{{$produto->loja->id.'/'.$produto->loja->imagemResize(230) }}" class="thumbnail thumbnail-custom" alt="{{ $produto->loja->nome }}">
              <h3>{{ $produto->loja->nome }}</h3>
              <p>{{ $produto->loja->descricao }}</p>
              <h4>{{ $produto->loja->localizacao }}</h4>
          </div>
          @endif
          <div class="col-md-12" style="background-color:#FFF; margin-bottom:30px;">
            <h4 class="text-center" style="color:#666666;">Fale com um vendedor</h4>
            {!! Form::open(array('url'=>'/contatos/vendedor','id'=>'form-contato-vendedor')) !!}
            {!! Form::hidden('produto_id',$produto->id) !!}
            {!! Form::hidden('loja_id',NULL) !!}
            <div class="form-group">
              <input type="text" class="form-control" name="nome" placeholder="Nome" required="required">
            </div>
            <div class="form-group">
              <input type="text" class="form-control celular" name="celular" placeholder="Celular" required="required">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" name="email" placeholder="E-Mail" required="required">
            </div>
            <div class="form-group">
              <textarea class="form-control" name="mensagem" id="mensagem" placeholder="Mensagem" rows="4"></textarea>
              <span class="help-text" style="font-size:10px; text-align:left;">
                <span id="caracteres"></span> &nbsp; Caracteres restantes
              </span>
            </div>
            <div class="form-group">
              <label for="aceita_receber_mensagens" class="form-label small">
                <input type="checkbox" name="aceita_receber_mensagens" id="aceita_receber_mensagens" value="1"> Aceito receber mensagens do Complexo Aricanduva
              </label>
            </div>
            <div class="form-group">
              <button class="btn btn-block btn-success">Enviar</button>
            </div>
            {!! Form::close() !!}
          </div>

        </div> <!-- /. col-md-3 -->
      </div> <!-- /. row -->

      
@endsection

@section('scripts')
    @parent
    <script src="{{asset('assets/site/js/jquery.imageLens.js')}}"></script>
    <script src="{{asset('assets/site/js/jquery.mask.js')}}"></script>

    <script>

      var imagem_atual = '{{ '/images/produto/'.$produto->id.'/'.$produto->imagem }}';
        

        $(document).ready(function() {
          $('.extra').addClass('extra-inactive');
          $('#img_mini_principal').removeClass('extra-inactive');
          var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
          },
          spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
              }
          };

          $('.celular').mask(SPMaskBehavior, spOptions);

          $('#form-contato-vendedor').submit(function(event) {
                
                    event.preventDefault();
                    if(!$('#aceita_receber_mensagens').is(':checked')){
                      alert('É necessário aceitar receber mensagens para que o lojista consiga respondê-lo');
                      $('#aceita_receber_mensagens').focus();
                      return false;
                    }
                    carregaLoading();
                    var dados = jQuery( this ).serialize();

                    $.ajax({
                      url: '/contatos/vendedor',
                      type: 'POST',
                      data: dados,
                    })
                    .done(function() {
                      window.scrollTo(0, 0);
                      $('body').append('<div class="alert alert-success alert-dismissible" style="position:absolute; top: 35%; left: 30%;" role="alert">\
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
  <strong>Sucesso!</strong> Sua mensagem foi enviada, em breve o lojista entrará em contato!\
</div>');
                      $('#form-contato-vendedor').each(function(index, el) {
                        if($(el).attr('name')!='produto_id'){
                          el.reset();
                        }
                      });
                     
                    })
                    .fail(function() {
                      $('body').append('<div class="alert alert-danger alert-dismissible" style="position:absolute; top:200px; left:40%;" role="alert">\
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
  <strong>Erro!</strong> Houve algum problema de conexão, por favor tente mais tarde!\
</div>');
                    })
                    .always(function() {
                      fechaLoading();
                    });
                    
                
        });
          
          $("#imagem_principal").imageLens({ imageSrc: imagem_atual, lensSize: 200 });

          $('.miniatura-extra').click(function(event) {
            event.preventDefault();
            carregaLoading();
            console.log($(this).attr('exibir'));
            console.log($(this).attr('href'));

            imagem_atual = $(this).attr('href');

            $('.extra').addClass('extra-inactive');
            $(this).children().removeClass('extra-inactive');

            $("#imagem_principal").one("load", function() {
                fechaLoading();
                $('#imageLens-Lens').remove();
                $('#imageLens-Image').remove();
                $("#imagem_principal").imageLens({ imageSrc: imagem_atual, lensSize: 200 });
            }).attr("src", $(this).attr('exibir'));
            
          });
          
        });

      (function($) {
        $.fn.extend( {
          limiter: function(limit, elem) {
          $(this).on("keyup focus", function() {
              setCount(this, elem);
          });
          function setCount(src, elem) {
              var chars = src.value.length;
              if (chars > limit) {
                  src.value = src.value.substr(0, limit);
                  chars = limit;
              }
              elem.html( limit - chars );
          }
          setCount($(this)[0], elem);
            }
        });
      })(jQuery);
      var elem = $("#caracteres");
      $("#mensagem").limiter(100, elem);


        
    </script>
@endsection
@stop
