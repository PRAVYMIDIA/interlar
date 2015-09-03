<div class="barra-top">
  <img src="{!!'/assets/site/images/logo_aricanduva_top.png' !!}">
</div>

<div class="rectangle-3" style="background-color: #FFFFFF;">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 row">
        <div class="col-md-3 col-xs-12">
          <a href="/"><img class="img-responsive" src="/assets/site/images/logo_shopping_interlar_aricanduva.png" /></a>
        </div>
        <div class="col-md-6 col-xs-12" id="bloco-menu">
          <nav class="navbar navbar-default navbar-custom">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>Ambientes </strong><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      @foreach($ambientes as $id=>$ambiente)
                      <li> <a href="#" ambiente="{{$id }}" class="bt_ambiente_topo">{{$ambiente}}</a> </li>
                      @endforeach
                      
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>Produtos </strong><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      @foreach($tipos as $id=>$tipo)
                      <li> <a href="#" tipo="{{$id }}" class="bt_tipo_topo">{{$tipo}}</a> </li>
                      @endforeach
                    </ul>
                  </li>                  
                  <li><a href="{!! URL::to('loja') !!}"><strong>Lojas</strong></a></li>
                  <li><a href="/localizacao"><strong>Localização</strong></a></li>
                </ul>

              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
        </div>
        <div class="col-md-3 col-xs-12" style="margin-top: 30px;">
          <div class="form-group has-feedback" style="margin-top: 5px;">
            {!! Form::open(array('url'=>'/busca','method'=>'get','id'=>'form-busca')) !!}
            <input type="search" class="form-control" id="termo" value="{{ isset($termo)?$termo:null }}" name="termo" placeholder="Encontre a melhor oferta">
            <span class="glyphicon glyphicon-search form-control-feedback"></span>
            {!! Form::close() !!}
          </div>
        </div>

      </div>
    </div>
  </div>

</div> <!-- /.rectangle-3 -->
