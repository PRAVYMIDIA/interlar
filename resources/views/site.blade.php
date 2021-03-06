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
    <link rel="stylesheet" href="/assets/site/css/siteinterlar.css">
    <!-- CSS Leftnavi -->
    <link rel="stylesheet" type="text/css" href="/assets/site/css/bs_leftnavi.css">

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

    <div class="row" id="bloco_banner">
          @if($banner)
            <div onclick="document.location='{{ $banner->url }}';" style="cursor:pointer; padding:0px; margin-top:14px; margin-bottom:14px;{{ $banner->bgcolor?'background-color:'.$banner->bgcolor:'' }}">
            @if(strlen($banner->html) )
              {!! $banner->html !!}
            @else
              <img class="img-responsive img-thumbnail center-block" title="imagem atual" src="/images/banner/{{$banner->id.'/'.$banner->imagem }}" alt="banner">
            @endif
            </div>
          @endif
      </div> <!-- /. row -->

    <!-- <div id="bloco_newsletter_topo" style="display:none" role="alert">
        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        <label for="email">Cadastre seu email e receba novas ofertas de produtos em promoção.</label>
        <div class="row">
            <span class="col-md-10"><input type="email" class="form-control" id="emailnewslettertopo" placeholder="Digite seu E-Mail"></span>
            <span class="col-md-2"><button type="button" id="bt_cadastra_newsletter_topo" class="btn btn-warning btn-block">Cadastrar</button></span>
        </div>
        
        
    </div> -->

@yield('content')
</div>

@include('partials.footer')

<div class="row row-centered">
    <span id="top-link-block" class="hidden col-centered">
        <a href="#top"  onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
            <img class="img-responsive" src="/img/page_up.png">
        </a>
    </span><!-- /top-link-block -->
</div>

<style type="text/css">
    #bloco_newsletter_poupup{
        background-color: #ee1d25;
        border-radius: 10px;
        padding: 10px;
        text-align: center;
    }
    /* centered columns styles */
    .row-centered {
        text-align:center;
    }
    .col-centered {
        display:inline-block;
        float:none;
        /* reset the text-align */
        text-align:left;
        /* inline-block space fix */
        margin-right:-4px;
    }

    .navbar-fixed-top + .content-container {
    	margin-top: 70px;
    }
    .content-container {
    	margin: 0 130px;
    }

    #top-link-block.affix-top {
        position: absolute; /* allows it to "slide" up into view */
        bottom: -82px; /* negative of the offset - height of link element */
        left: 10px; /* padding from the left side of the window */
    }
    #top-link-block.affix {
        position: fixed; /* keeps it on the bottom once in view */
        bottom: 18px; /* height of link element */
        right: 15px; /* padding from the left side of the window */
    }
    .btn-menu-close{
        color:#fff;
        font-family: monospace;
        text-decoration: none;
        font-style: normal;
        border-radius: 10px;
        border: solid 1px #fff;
        padding: 3px;
        height: 18px;
        width: 18px;
        text-align: center;
        margin-top: -3px;
    }
</style>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="background_poupup">
    <div class="row row-centered">
        <div id="bloco_newsletter_poupup" class="col-xs-6 col-centered" style="margin-top: 100px">
            <button onclick="fechaPoupup();" class="close" type="button" data-dismiss="alert" aria-label="Close"><span>&times;</span>&nbsp; fechar</button>
            <img class="img-responsive" src="/img/popup.jpg">
            <div class="col-md-12" style="margin-top: 10px">
                <span class="col-md-9"><input type="email" class="form-control" id="emailnewsletterpoupup" placeholder="Digite seu E-Mail"></span>
                <span class="col-md-3"><button type="button" id="bt_cadastra_newsletter_poupup" class="btn btn-default btn-block">Cadastrar</button></span>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>    

<script src="/assets/site/js/bs_leftnavi.js"></script>

<script>
    $('#flash-overlay-modal').modal();
    $('div.alert').not('.alert-danger').delay(3000).slideUp(300);
    var menu_flutuante_aberto = false;
    function menuFlutuante(){
        console.log('OPA');
        if(menu_flutuante_aberto){
            setTimeout(function(){
                $('#mMobile').removeClass('menuMobile');
            },1000);
            menu_flutuante_aberto = false;
        }else{
            $('#mMobile').addClass('menuMobile');
            menu_flutuante_aberto = true;
        }
        
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return 0;
    }

    // Ajax loaders
            
    function carregaLoading(){
        $('body').append('<div class="loader"></div>');
    }

    function fechaLoading(){
        $('.loader').hide('fast', function() {
            $(this).remove();
        });
    }
    function fechaPoupup(){
        $('#background_poupup').modal('hide');

        setCookie('newsletter', '1', 2);
    }

    function setCookie(cname, cvalue, exhours) {
        var d = new Date();
        d.setTime(d.getTime() + (exhours*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    var pagina_exibicao_produtos = {{ isset($produto_grade)?1:0}};

    var v_termo = '{{ isset($termo)?$termo:null }}';
    var v_ambiente = {{ isset($ambiente_id)?($ambiente_id?$ambiente_id:'null'):'null' }};
    var v_tipo = {{ isset($tipo_id)?($tipo_id?$tipo_id:'null'):'null' }};
    var v_loja = {{ isset($loja_id)?($loja_id?$loja_id:'null'):'null' }};
    var v_ordenacao = '{{ isset($ordenacao)?($ordenacao?$ordenacao:'null'):'null' }}';
    var v_loading = 0;

    $(document).ready(function() {

        $('#emailnewsletter').bind('keypress', function(e) {
            var code = e.keyCode || e.which;
            if(code == 13) { //Enter keycode
             salvaNewsletter();
            }
        });

        $('#form-busca').submit(function(event) {
                if(pagina_exibicao_produtos){
                    event.preventDefault();
                    next_page = '/produtos/data';
                    v_termo = $('#termo').val();
                    $('#bloco_produtos').html('');
                    carregaProdutos();
                }
        });

        $('#termo').bind('keypress', function(e) {
            var code = e.keyCode || e.which;
            if(code == 13) { //Enter keycode
             $(this).closest('form').submit();
            }
        });

        $('#termo_lupa').click(function() {
            $(this).closest('form').submit();
        });

        $('#enviaNewsletterEmail').click(function() {
            salvaNewsletter();
        });

        $('#bt_cadastra_newsletter_topo').click(function() {
            salvaNewsletter2();
        });

        $('#bt_cadastra_newsletter_poupup').click(function() {
            salvaNewsletter3();
        });

        $('.bt_ambiente').click(function(e) {
            e.preventDefault();
            filtraProdutosPorAmbiente( $(this).attr('ambiente') );
        });

         $('.bt_ambiente_topo').click(function(e) {
             e.preventDefault();
             filtraProdutosPorAmbienteTopo( $(this).attr('ambiente') );
         });

        $('.bt_tipo').click(function(e) {
            e.preventDefault();
            filtraProdutosPorTipo( $(this).attr('tipo') );
        });

        $('.bt_tipo_topo').click(function(e) {
            e.preventDefault();
            filtraProdutosPorTipoTopo( $(this).attr('tipo') );
        });

        $('.bt_loja').click(function(e) {
            e.preventDefault();
            filtraProdutosPorLojaTipo( $(this).attr('loja') );
        });

        $('.bt_ordenacao').click(function(e) {
            e.preventDefault();
            ordenaResultados( $(this).attr('ordenacao') );
        });

        var nws = getCookie('newsletter');
        if(nws ==0){
            $('#bloco_newsletter_topo').addClass('alert').addClass('alert-warning').show('fast');

            $('#background_poupup').click(function(event) {
                fechaPoupup();
            });

            $('#background_poupup').modal('show');

            $('#bloco_newsletter_poupup').click(function(event) {
                return false;
            });

        }

        if ( ($(window).height() + 100) < $(document).height() ) {
            $('#top-link-block').removeClass('hidden').affix({
                // how far to scroll down before link "slides" into view
                offset: {top:100}
            });
        }

    });

    function atualizaQueryString(){
        if (history.pushState) {
            var newurl = '';
            if(v_ambiente){
                newurl += 'ambiente='+v_ambiente;
            } 
            if(v_tipo){
                if(newurl.length > 0){
                    newurl += '&';
                }
                newurl += 'tipo='+v_tipo;
            }
            if(v_loja){
                if(newurl.length > 0){
                    newurl += '&';
                }
                newurl += 'loja='+v_loja;
            }
            if(v_termo){
                if(newurl.length > 0){
                    newurl += '&';
                }
                newurl += 'termo='+v_termo;
            }

            if(v_ordenacao!=''&&v_ordenacao&&v_ordenacao!='null'){
                if(newurl.length > 0){
                    newurl += '&';
                }
                newurl += 'ordenacao='+v_ordenacao;
            }

            if(newurl.length > 0){
                newurl = '/?'+newurl;
            }else{
                newurl = '/';
            }
            window.history.pushState({path:newurl},'',newurl);
        }
    }

    function filtraProdutosPorAmbienteTopo (filtro_id) {
            v_tipo = null;
            v_ambiente = filtro_id;

            next_page = '/produtos/data';

            if(pagina_exibicao_produtos){
                $('#bloco_produtos').html('');
                atualizaQueryString();
                carregaProdutos();
            }else{
                document.location = '/?ambiente='+v_ambiente;
            }
        }

    function filtraProdutosPorAmbiente (filtro_id) {
        if(v_ambiente != filtro_id){
            v_ambiente = filtro_id;
        }else{
            v_ambiente = null;
        }

        next_page = '/produtos/data';
        
        if(pagina_exibicao_produtos){
            $('#bloco_produtos').html('');
            atualizaQueryString();
            carregaProdutos();
        }else{
            document.location = '/?ambiente='+v_ambiente;
        }
    }

    function filtraProdutosPorTipoTopo (filtro_id) {
        v_tipo = filtro_id;

        next_page = '/produtos/data';

        if(pagina_exibicao_produtos){
            $('#bloco_produtos').html('');
            atualizaQueryString();
            carregaProdutos();
        }else{
            document.location = '/?tipo='+v_tipo;
        }
    }

    function filtraProdutosPorTipo (filtro_id) {
        if(v_tipo==filtro_id){
            v_tipo = null;
        }else{
            v_tipo = filtro_id;
        }
        next_page = '/produtos/data';
        
        if(pagina_exibicao_produtos){
            $('#bloco_produtos').html('');
            atualizaQueryString();
            carregaProdutos();
        }else{
            document.location = '/?tipo='+v_tipo;
        }
    }

    function filtraProdutosPorLojaTipo (filtro_id) {
        if(v_loja==filtro_id){
            v_loja = null;
        }else{
            v_loja = filtro_id;
        }
        next_page = '/produtos/data';
        
        if(pagina_exibicao_produtos){
            $('#bloco_produtos').html('');
            atualizaQueryString();
            carregaProdutos();
        }else{
            document.location = '/?loja='+v_loja;
        }
    }

    function ordenaResultados (ordenacao) {
        if(v_ordenacao == ordenacao){
            v_ordenacao = null;
        }else{
            v_ordenacao = ordenacao;
        }
        next_page = '/produtos/data';
        
        if(pagina_exibicao_produtos){
            $('#bloco_produtos').html('');
            atualizaQueryString();
            carregaProdutos();
        }else{
            document.location = '/?loja='+v_loja;
        }
    }

    function ativaDesativaMenu(){
        $('.remove_ordenacao').remove();
        $('.btn-menu-close').remove();
        var texto_breadcrumb = '';

        $('.menu_ambientes').removeClass('active-item').removeClass('active');
        $('#ambiente_selected').remove();
        $('.menu_ambientes.notmobile').show();
        if(v_ambiente){
            $('.item_ambiente_'+v_ambiente).addClass('active-item');
            texto_breadcrumb += '<span id="breadcrumb_txt_1">'+$('.item_ambiente_'+v_ambiente).children().html()+'</span>';
            $('.item_ambiente_'+v_ambiente).children().append('<i class="pull-right btn-menu-close" >X</i>');
            $('.item_ambiente_'+v_ambiente+'.notmobile').clone(true, true).attr('id', 'ambiente_selected').css('display', 'none').insertAfter( $('#tit_bloco_menu_ambientes') );
            setTimeout(function(){
                $('.item_ambiente_'+v_ambiente+'.notmobile').hide();
                $('#ambiente_selected').show();
            },4000);
        }

        $('.menu_tipos').removeClass('active-item').removeClass('active');
        $('#tipo_selected').remove();
        $('.menu_tipos.notmobile').show();
        if(v_tipo){
            $('.item_tipo_'+v_tipo).addClass('active-item');
            if(texto_breadcrumb.length){
                texto_breadcrumb += ' &nbsp; &gt; &nbsp; ';
            }
            texto_breadcrumb += '<span id="breadcrumb_txt_2">'+$('.item_tipo_'+v_tipo).children().html()+'</span>';
            $('.item_tipo_'+v_tipo).children().append('<i class="pull-right btn-menu-close" >X</i>');
            $('.item_tipo_'+v_tipo).first().clone(true, true).attr('id', 'tipo_selected').css('display', 'none').insertAfter( $('#tit_bloco_menu_tipos') );
            setTimeout(function(){
                $('.item_tipo_'+v_loja+'.notmobile').hide();
                $('#tipo_selected').show();
            },4000);
        }

        $('.menu_loja').removeClass('active-item').removeClass('active');
        $('#loja_selected').remove();
        $('.menu_loja.notmobile').show();
        if(v_loja){
            $('.item_loja_'+v_loja).addClass('active-item');
            if(texto_breadcrumb.length){
                texto_breadcrumb += ' &nbsp; &gt; &nbsp; ';
            }
            texto_breadcrumb += '<span id="breadcrumb_txt_3">'+$('.item_loja_'+v_loja).children().html()+'</span>';
            $('.item_loja_'+v_loja).children().append('<i class="pull-right btn-menu-close" >X</i>');
            $('.item_loja_'+v_loja).first().clone(true, true).attr('id', 'loja_selected').css('display', 'none').insertAfter( $('#tit_bloco_menu_lojas') );
            setTimeout(function(){
                $('.item_loja_'+v_loja+'.notmobile').hide();
                $('#loja_selected').show();
            },4000);

        }

        $('.bt_ordenacao').removeClass('red');
        if(v_ordenacao){
            $('#bt_ordenacao_'+v_ordenacao).addClass('red');
            $('#bt_ordenacao_'+v_ordenacao).append('<i class="glyphicon glyphicon-remove remove_ordenacao"></i>');
        }

        if(texto_breadcrumb.length > 0){
            $('#bloco_breadcrumb').html('<div class="breadcrumb_texto">'+texto_breadcrumb+'</div>');
            if($('#breadcrumb_txt_3').length){
                $('#breadcrumb_txt_3').addClass('red');
            }else{
                if($('#breadcrumb_txt_2').length){
                    $('#breadcrumb_txt_2').addClass('red');
                }else{
                    if($('#breadcrumb_txt_1').length){
                        $('#breadcrumb_txt_1').addClass('red');
                    }
                }
            }

            $('#header_produtos').show('fast');
        }else{
            $('#bloco_breadcrumb').html('');
        }
    }

    function validateEmail(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
    }

    function salvaNewsletter3(){

        var v_email = $('#emailnewsletterpoupup').val();
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
            data: { email:v_email, pagina: '{{ Request::path() }}', ambiente: v_ambiente, tipo: v_tipo},
        })
        .done(function(retorno) {
            fechaLoading();
            if(retorno.erro){

                carregaModal('Erro', retorno.erro, 'ERRO');

            }else{
                fechaPoupup();
                $('#bloco_newsletter_topo').hide('fast', function() {
                    $(this).remove();
                });

                carregaModal('Sucesso!', 'Agora você receberá todas as promoções no seu e-mail!', 'SUCESSO');

                document.cookie="newsletter=1; expires=Thu, 31 Dec {{date('Y')}} 23:59:59 UTC; path=/";
                
            }

            $('#alert_block').css({ 
                top: (($(window).height()/2)- 25)+'px',
                left: (($(window).width()/2) - 225)+'px',
            });
            
        })
        .fail(function() {
            fechaLoading();
            $('body').append('<div class="alert alert-danger alert-dismissible" id="alert_block" style="position:absolute; top:200px; left:40%;" role="alert">\
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                  <strong>Erro!</strong> Houve algum erro de conexão, por favor tente mais tarde!\
                </div>');

            $('#alert_block').css({ 
                top: (($(window).height()/2)- 25)+'px',
                left: (($(window).width()/2) - 225)+'px',
            });
        });
        
    }
    function salvaNewsletter2(){

        var v_email = $('#emailnewslettertopo').val();
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
            data: { email:v_email, pagina: '{{ Request::path() }}', ambiente: v_ambiente, tipo: v_tipo},
        })
        .done(function(retorno) {
            fechaLoading();
            if(retorno.erro){

                carregaModal('Erro', retorno.erro, 'ERRO');

            }else{
                $('#bloco_newsletter_topo').hide('fast', function() {
                    $(this).remove();
                });

                carregaModal('Sucesso', 'Agora você receberá todas as promoções no seu e-mail!', 'SUCESSO');

                document.cookie="newsletter=1; expires=Thu, 31 Dec {{date('Y')}} 23:59:59 UTC; path=/";
                
            }

            $('#alert_block').css({ 
                top: (($(window).height()/2)- 25)+'px',
                left: (($(window).width()/2) - 225)+'px',
            });
            
        })
        .fail(function() {
            fechaLoading();
            $('body').append('<div class="alert alert-danger alert-dismissible" id="alert_block" style="position:absolute; top:200px; left:40%;" role="alert">\
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                  <strong>Erro!</strong> Houve algum erro de conexão, por favor tente mais tarde!\
                </div>');
            $('#alert_block').css({ 
                top: (($(window).height()/2)- 25)+'px',
                left: (($(window).width()/2) - 225)+'px',
            });
        });
        
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
            data: { email:v_email, pagina: '{{ Request::path() }}', ambiente: v_ambiente, tipo: v_tipo},
        })
        .done(function(retorno) {
            fechaLoading();
            if(retorno.erro){
                $('#emailnewsletter').parent().addClass('has-error');
                $('#emailnewsletter').val(retorno.erro);

                setTimeout(function() {
                   $('#emailnewsletter').val(''); 
                   $('#emailnewsletter').parent().removeClass('has-error');
                }, 5000);
            }else{
                $('#emailnewsletter').val('E-Mail salvo com sucesso!');
                $('#emailnewsletter').parent().addClass('has-success');
                document.cookie="newsletter=1; expires=Thu, 31 Dec {{date('Y')}} 23:59:59 UTC; path=/";
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
    function carregaModal(title, text, type) {
        
         if (type == 'ERRO') {
            icon = 'glyphicon glyphicon-remove-circle';
            textColor = 'text-danger';
            alertColor = 'alert-danger';
            removeClassAlert = 'alert-success';
         } else if (type == 'SUCESSO') {
            icon = 'glyphicon glyphicon-ok-circle';
            textColor = 'text-success';
            alertColor = 'alert-success';
            removeClassAlert = 'alert-danger';
         } else {
            icon = 'glyphicon glyphicon-info-sign';
            textColor = 'text-danger';
            alertColor = 'alert-danger';
            removeClassAlert = 'alert-success';
         };

        $('#myModal').modal('show');
            var modal = $('#myModal');
            modal.find('.modal-title').html('<span class="' + icon + ' ' + textColor + '"></span>\
              <strong>' + title + '</strong> <br><br> ' + text);
            modal.find('.alert').addClass(alertColor).removeClass(removeClassAlert);
    }
</script>

@yield('scripts')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="alert" style="margin-bottom: 0px">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
    </div>
  </div>
</div>
</body>
</html>
