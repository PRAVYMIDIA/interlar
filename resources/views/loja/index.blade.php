@extends('site')
@section('title') Home :: @parent @stop
@section('content')
      <div class="row">
        <div class="col-lg-12">
          <div class="banner-faixa-top">
            <p class="text-center banner-faixa-top-text">APROVEITE NOSSAS OFERTAS! DESCONTOS INCRÍVEIS DE ATÉ 70% SOMENTE NESTE FINAL DE SEMANA, NÃO PERCA!</p>
          </div>
        </div>
      </div> <!-- /. row -->

      <div class="row">
          <div class="col-sm-12 col-md-8">
            <div class="form-group has-feedback">
              <input type="text" class="form-control" id="buscalojanome" placeholder="Buscar pelo nome da loja">
              <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="form-group has-feedback">
              <input type="text" class="form-control" id="buscalojasegmento" placeholder="Buscar pelo segmento">
              <span class="glyphicon glyphicon glyphicon-triangle-bottom form-control-feedback"></span>
            </div>            
          </div>          

      </div>

      <div class="row">
        <div class="col-lg-12">
          
            @foreach($lojas as $item)
                <div class="col-sm-6 col-md-4" style="text-align: center;">
                  <div class="row" style="text-align: center; padding: 10px;">
                    <img src="{{{'images/loja/'.$item->id.'/'.$item->imagem}}}" alt="..." width="205" height="60">
                  </div>
                  <div class="row">
                    <span style="color: #666666;font-style: bold;">{{{$item->nome}}}</span>
                  </div>
                  <div class="row">
                    <span style="color: #cccccc;">{{{$item->descricao}}}</span>
                  </div>
                  <div class="row" style="margin-top: 7px;">
                    <span style="color: #666666;">{{{$item->localizacao}}}</span>
                  </div>
                </div>
            @endforeach
          
        </div> <!-- /. row -->
      </div> <!-- /. row -->

@endsection

@section('scripts')
    @parent
    <script>

    </script>
@endsection
@stop      	