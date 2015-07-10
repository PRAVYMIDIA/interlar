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
            {!! Form::open(array('url'=>'/emails/vendedor','id'=>'form-contato-vendedor')) !!}
            <div class="form-group">
              <input type="text" class="form-control" name="nome" placeholder="Nome">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="celular" placeholder="Celular">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" name="email" placeholder="E-Mail">
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
        </div>
      </div>
@endsection

@section('scripts')
    @parent
    <script src="{{asset('assets/site/js/jquery.imageLens.js')}}"></script>

    <script>
      var imagem_atual = '{{ '/images/produto/'.$produto->id.'/'.$produto->imagem }}';
        

        $(document).ready(function() {

          $('#form-contato-vendedor').submit(function(event) {
                
                    event.preventDefault();
                    alert('Em desenvolvimento.');
                
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