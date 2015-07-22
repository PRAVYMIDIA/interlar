@extends('site')
@section('title') 404 :: @parent @stop

@section('content')
      <div class="row text-center" style="color:#999999;">
        <br>
        <h1><strong>ERRO 404</strong></h1>
        <h1>PÁGINA NÃO ENCONTRADA</h1>
        <h4>Este conteúdo não existe ou a página já expirou</h4>
        <br>
        <br>
        <a href="/" class="btn btn-success btn-lg">Ver outras ofertas</a>
        <br>
        <br>
      </div> <!-- /. row -->

@endsection
@section('scripts')
    <script type="text/javascript">
    $(document).ready(function() {
      $('#bloco_newsletter_topo').remove();
      $('#bloco_banner').remove();
    });
    </script>
@endsection