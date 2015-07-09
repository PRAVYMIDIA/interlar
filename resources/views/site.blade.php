<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title') Interlar @show</title>
    @section('meta_keywords')
        <meta name="keywords" content="your, awesome, keywords, here"/>
    @show @section('meta_author')
        <meta name="author" content="Jon Doe"/>
    @show @section('meta_description')
        <meta name="description"
              content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei."/>
    @show

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- CSS Site -->
    <link rel="stylesheet" href="assets/site/css/siteinterlar.css">
    <!-- CSS Leftnavi -->
    <link rel="stylesheet" type="text/css" href="assets/site/css/bs_leftnavi.css">

    @yield('styles')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">
</head>
<body>
@include('partials.top')

@include('flash::message')
<div class="container">
    <div class="row">
          @if($banner)
            <div onclick="document.location='{{ $banner->url }}';" style="cursor:pointer;">
            @if(strlen($banner->html) )
              {!! $banner->html !!}
            @else
              <img class="img-responsive img-thumbnail center-block" title="imagem atual" src="/images/banner/{{$banner->id.'/'.$banner->imagem }}" alt="banner">
            @endif
            </div>
          @endif
      </div> <!-- /. row -->
@yield('content')
</div>
@include('partials.footer')

<!-- Scripts -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>    

<script src="assets/site/js/bs_leftnavi.js"></script>

<script>
    $('#flash-overlay-modal').modal();
    $('div.alert').not('.alert-danger').delay(3000).slideUp(300);

    // Ajax loaders
            
    function carregaLoading(){
        $('body').append('<div class="loader"></div>');
    }

    function fechaLoading(){
        $('.loader').hide('fast', function() {
            $(this).remove();
        });
    }

    var pagina_exibicao_produtos = {{ isset($produto_grade)?1:0}};

    var v_termo = '{{ isset($termo)?$termo:null }}';
    var v_ambiente = {{ isset($ambiente_id)?($ambiente_id?$ambiente_id:'null'):'null' }};
    var v_tipo = {{ isset($tipo_id)?($tipo_id?$tipo_id:'null'):'null' }};

    $(document).ready(function() {
        $('#emailnewsletter').bind('keypress', function(e) {
            var code = e.keyCode || e.which;
            if(code == 13) { //Enter keycode
             salvaNewsletter();
            }
        });

        $('#termo').bind('keypress', function(e) {
            var code = e.keyCode || e.which;
            if(code == 13) { //Enter keycode
             $(this).closest('form').submit();
            }
        }); 

        $('#enviaNewsletterEmail').click(function() {
            salvaNewsletter();
        });

        $('.bt_ambiente').click(function(e) {
            e.preventDefault();
            filtraProdutosPorAmbiente( $(this).attr('ambiente') );
        }); 
        $('.bt_tipo').click(function(e) {
            e.preventDefault();
            filtraProdutosPorTipo( $(this).attr('tipo') );
        });  
    });

    function filtraProdutosPorAmbiente (filtro_id) {
        v_ambiente = filtro_id;
        next_page = '/produtos/data';
        $('.menu_ambientes').removeClass('active-item');
        $('#item_ambiente_'+filtro_id).addClass('active-item');
        if(pagina_exibicao_produtos){
            carregaProdutos();
        }else{
            document.location = '/?ambiente='+v_ambiente;
        }
    }

    function filtraProdutosPorTipo (filtro_id) {
        v_tipo = filtro_id;
        next_page = '/produtos/data';
        $('.menu_tipos').removeClass('active-item');
        $('#item_tipo_'+filtro_id).addClass('active-item');
        if(pagina_exibicao_produtos){
            carregaProdutos();
        }else{
            document.location = '/?tipo='+v_ambiente;
        }
    }

    function validateEmail(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
    }

    function salvaNewsletter(){

        var v_email = $('#emailnewsletter').val();
        var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
        if (!validateEmail(v_email))
        {
            alert('Por favor coloque um e-mail válido.');
            return false;
        }
        carregaLoading();
        $.ajax({
            url: '/emails/salvar',
            type: 'POST',
            dataType: 'json',
            data: {_token: '{{{ csrf_token() }}}', email:v_email},
        })
        .done(function(retorno) {
            fechaLoading();
            if(retorno.erro){
                $('#emailnewsletter').parent().addClass('has-error');
                $('#emailnewsletter').val('Houve algum erro ao salvar seu e-mail.');

                setTimeout(function() {
                   $('#emailnewsletter').val(''); 
                   $('#emailnewsletter').parent().removeClass('has-error');
                }, 5000);
            }else{
                $('#emailnewsletter').val('E-Mail salvo com sucesso!');
                $('#emailnewsletter').parent().addClass('has-success');
            }
            setTimeout(function() {
               $('#emailnewsletter').parent().removeClass('has-success');
               $('#emailnewsletter').val(''); 
            }, 5000);
        })
        .fail(function() {
            fechaLoading();
                $('#emailnewsletter').parent().addClass('has-error');
            $('#emailnewsletter').val('Houve algum erro ao salvar seu e-mail.');
            setTimeout(function() {
               $('#emailnewsletter').val(''); 
               $('#emailnewsletter').parent().removeClass('has-error');
            }, 5000);
        });
        
    }  
</script>

@yield('scripts')

</body>
</html>
