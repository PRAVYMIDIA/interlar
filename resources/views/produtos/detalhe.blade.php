@extends('site')
@section('title') {{$produto->nome}} :: @parent @stop
@section('content')
      <div class="row" style="margin-top:15px;">
        <div class="col-md-9">
          <h2><i onclick="history.go(-1);void(0);" class="fa fa-chevron-circle-left fa-1x"></i> {{$produto->nome}}</h2>
          <p>{!! $produto->descricao !!}</p>
        </div> <!-- /. col-md-9 -->
        <div class="col-md-3" style="font-size:16px; text-align:center;">
          <div class="thumbnail thumbnail-custom">
          @if($produto->valor)

            @if($produto->valor_promocional)
                <span style="text-decoration:line-through;">De: R$ {{$produto->valor}} </span>
                <span>por apenas: </span>
                <span>R$</span><span style="color:red; font-size:38px;">{{$produto->valor_promocional}}</span>
            @else
                <span>R$</span><span style="color:red; font-size:30px;">{{$produto->valor}}</span>
            @endif
          @else
            <h4>Sob Consulta</h4>
          @endif
          @if($produto->parcelas)
            <span style="font-size:16px; clear:both;"> em até {{ $produto->parcelas }}x s/Juros</span>
          @endif
          </div>
        </div> <!-- /. col-md-3 -->
      </div> <!-- /. row -->

      <div class="row" style="margin-top:30px;">
        <div class="col-md-9">
          <div class="row">
            <img class="thumbnail thumbnail-custom" id="imagem_principal" 
              src="{{ '/images/produto/'.$produto->id.'/'.$produto->imagemResize(870,null,90) }}" alt="{{$produto->nome}}">
          </div>
          <div class="row" style="margin-top:15px;">
            @if( count( $produto->imagens ) )
              <span class="col-md-3" id="mini_principal" style="display:none;">
                <a href="{{ '/images/produto/'.$produto->id.'/'.$produto->imagem }}" exibir="{{ '/images/produto/'.$produto->id.'/'.$produto->imagemResize(870,null,90) }}" class="thumbnail thumbnail-custom miniatura-extra"  target="_blank" title="Ver imagem em tamanho máximo">
                    <img title="imagem extra" src="{{ '/images/produto/'.$produto->id.'/'.$produto->thumb() }}" alt="Imagem">
                </a>
              </span>
              @foreach($produto->imagens as $imagem)
              <span class="col-md-3">
                <a href="/images/produto/{{$produto->id.'/'.$imagem->imagem }}" exibir="{{ '/images/produto/'.$produto->id.'/'.$imagem->imagemResize(870,null,90) }}" class="thumbnail thumbnail-custom miniatura-extra"  target="_blank" title="Ver imagem em tamanho máximo">
                    <img title="imagem extra" src="/images/produto/{{$produto->id.'/'.$imagem->thumb() }}" alt="Imagem">
                </a>
              </span>
              @endforeach
            @endif
          </div>
        </div>
        <div class="col-md-3">
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
              <textarea class="form-control" name="mensagem" placeholder="Mensagem" rows="4">

              </textarea>
            </div>
            <div class="form-group">
              <button class="btn btn-block btn-success">Enviar</button>
            </div>
            {!! Form::close() !!}
          </div>
          @if($produto->loja)
          <div class="col-md-12" style="background-color:#FFF; margin-bottom:30px; text-align:center;">
              <img title="{{ $produto->loja->nome }}" src="/images/loja/{{$produto->loja->id.'/'.$produto->loja->imagemResize(230) }}" class="thumbnail thumbnail-custom" alt="{{ $produto->loja->nome }}">
              <h3>{{ $produto->loja->nome }}</h3>
              <p>{{ $produto->loja->descricao }}</p>
              <h4>{{ $produto->loja->localizacao }}</h4>
          </div>
          @endif
        </div>
      </div>
@endsection

@section('scripts')
    @parent
    <script src="{{asset('assets/site/js/jquery.imageLens.js')}}"></script>
    <script src="{{asset('assets/site/js/jquery.mask.js')}}"></script>

    <script>
      var imagem_atual = '{{ '/images/produto/'.$produto->id.'/'.$produto->imagem }}';
        

        $(document).ready(function() {

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
                    carregaLoading();
                    var dados = jQuery( this ).serialize();

                    $.ajax({
                      url: '/contatos/vendedor',
                      type: 'POST',
                      data: dados,
                    })
                    .done(function() {
                      $('body').append('<div class="alert alert-success alert-dismissible" style="position:absolute; top: 45%; left: 30%;" role="alert">\
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
  <strong>Sucesso!</strong> Sua mensagem foi enviada, em breve entraremos em contato!\
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

            $('#mini_principal').show();

            $("#imagem_principal").one("load", function() {
                fechaLoading();
                $('#imageLens-Lens').remove();
                $('#imageLens-Image').remove();
                $("#imagem_principal").imageLens({ imageSrc: imagem_atual, lensSize: 200 });
            }).attr("src", $(this).attr('exibir'));
            
          });
          
        });

        
    </script>
@endsection
@stop
