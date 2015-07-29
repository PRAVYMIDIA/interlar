@extends('site')
@section('title') Localização :: @parent @stop

@section('styles')
<style type="text/css">
    #shoppingmapa {
      height: 552px;
      width: 770px;
    }
    .gm-style-iw * {
      display: block;
      width: 100%;
    }
    .gm-style-iw h4,
    .gm-style-iw p {
      margin: 0;
      padding: 0;
    }
    .gm-style-iw a {
      color: #4272db;
    }
      .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        padding: 0 11px 0 13px;
        width: 400px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        text-overflow: ellipsis;
      }

      #pac-input:focus {
        border-color: #4d90fe;
        margin-left: -1px;
        padding-left: 14px;  /* Regular padding-left + 1. */
        width: 401px;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
</style>
@stop

@section('content')
      <div class="row" style="margin-top:15px;">
        <div class="col-md-8">
          <div class="row">
            <div id="shoppingmapa"></div>
            <input id="pac-input" class="controls" type="text" placeholder="Buscar">
            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2636.274231412429!2d-46.502902088869675!3d-23.562793692109967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spt-BR!2sbr!4v1436555697265" width="770" height="552" frameborder="0" style="border:0" allowfullscreen></iframe> -->
          </div>
        </div> <!-- /. col-md-9 -->
        <div class="col-md-4" style="font-size:16px; text-align:center;">
          <div class="thumbnail thumbnail-custom"  style="color:#ccc; margin-bottom:30px;">
           
              <span style="color:#666666; font-size:18px;">Interlar Aricanduva</span><br>
              <span>Avenida Aricanduva, 5555 - Vila Matilde, <br>
                    São Paulo - SP, 03527-900, Brasil</span><br>
              <span style="color:#666666; font-size:18px;clear:both;"> Tel.: (11) 3444-2000</span>
            
          </div>


          <div class="col-md-12" style="background-color:#FFF;">
            <h4 class="text-center" style="color:#666666;">Contato</h4>
            {!! Form::open(array('url'=>'/contatos/contato','id'=>'form-contato')) !!}
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

    <script src="{{asset('assets/site/js/jquery.mask.js')}}"></script>
    <script src="http://maps.google.com/maps/api/js?libraries=places"></script>

    <script>

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

          $('#form-contato').submit(function(event) {                
              event.preventDefault();
              carregaLoading();
              var dados = jQuery( this ).serialize();

              $.ajax({
                url: '/contatos/contato',
                type: 'POST',
                data: dados,
              })
              .done(function() {
                $('body').append('<div class="alert alert-success alert-dismissible" style="position:absolute; top: 45%; left: 30%;" role="alert">\
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                  <strong>Sucesso!</strong> Sua mensagem foi enviada, em breve entraremos em contato!\
                </div>');
                $('#form-contato').each(function(index, el) {
                      el.reset();                     
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
        });

    // MAPA
    google.maps.event.addDomListener(window, 'load', init);
    var map;
    var markers = [];


    function init() {
      var mapOptions = {
        center: new google.maps.LatLng(-23.5627937, -46.5029021),
        zoom: 17,
        zoomControl: true,
        zoomControlOptions: {
          style: google.maps.ZoomControlStyle.DEFAULT,
        },
        disableDoubleClickZoom: true,
        mapTypeControl: false,
        scaleControl: false,
        scrollwheel: true,
        panControl: true,
        streetViewControl: false,
        draggable: true,
        overviewMapControl: false,
        overviewMapControlOptions: {
          opened: false,
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [{
          "featureType": "water",
          "stylers": [{
            "visibility": "on"
          }, {
            "color": "#b5cbe4"
          }]
        }, {
          "featureType": "landscape",
          "stylers": [{
            "color": "#efefef"
          }]
        }, {
          "featureType": "road.highway",
          "elementType": "geometry",
          "stylers": [{
            "color": "#83a5b0"
          }]
        }, {
          "featureType": "road.arterial",
          "elementType": "geometry",
          "stylers": [{
            "color": "#bdcdd3"
          }]
        }, {
          "featureType": "road.local",
          "elementType": "geometry",
          "stylers": [{
            "color": "#ffffff"
          }]
        }, {
          "featureType": "poi.park",
          "elementType": "geometry",
          "stylers": [{
            "color": "#e3eed3"
          }]
        }, {
          "featureType": "administrative",
          "stylers": [{
            "visibility": "on"
          }, {
            "lightness": 33
          }]
        }, {
          "featureType": "road"
        }, {
          "featureType": "poi.park",
          "elementType": "labels",
          "stylers": [{
            "visibility": "on"
          }, {
            "lightness": 20
          }]
        }, {}, {
          "featureType": "road",
          "stylers": [{
            "lightness": 20
          }]
        }],
      }
      var mapElement = document.getElementById('shoppingmapa');
      var map = new google.maps.Map(mapElement, mapOptions);
      var locations = [
        ['Interlar Aricanduva', 'Avenida Aricanduva, 5555 - Vila Matilde', 'São Paulo - SP, 03527-900, Brasil', 'undefined', 'www.aricanduva.com.br', -23.5627937, -46.5029021, 'https://mapbuildr.com/assets/img/markers/hollow-pin-green.png'],
        
      ];
      for (i = 0; i < locations.length; i++) {
        if (locations[i][1] == 'undefined') {
          description = '';
        } else {
          description = locations[i][1];
        }
        if (locations[i][2] == 'undefined') {
          telephone = '';
        } else {
          telephone = locations[i][2];
        }
        if (locations[i][3] == 'undefined') {
          email = '';
        } else {
          email = locations[i][3];
        }
        if (locations[i][4] == 'undefined') {
          web = '';
        } else {
          web = locations[i][4];
        }
        if (locations[i][7] == 'undefined') {
          markericon = '';
        } else {
          markericon = locations[i][7];
        }
        marker = new google.maps.Marker({
          icon: markericon,
          position: new google.maps.LatLng(locations[i][5], locations[i][6]),
          map: map,
          title: locations[i][0],
          desc: description,
          tel: telephone,
          email: email,
          web: web
        });
        if (web.substring(0, 7) != "http://") {
          link = "http://" + web;
        } else {
          link = web;
        }
        bindInfoWindow(marker, map, locations[i][0], description, telephone, email, web, link);
      }

      function bindInfoWindow(marker, map, title, desc, telephone, email, web, link) {
        var infoWindowVisible = (function() {
          var currentlyVisible = false;
          return function(visible) {
            if (visible !== undefined) {
              currentlyVisible = visible;
            }
            return currentlyVisible;
          };
        }());
        iw = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'click', function() {
          if (infoWindowVisible()) {
            iw.close();
            infoWindowVisible(false);
          } else {
            var html = "<div style='color:#000;background-color:#fff;padding:5px;width:150px;'><h4>" + title + "</h4><p>" + desc + "<p><p>" + telephone + "<p><a href='" + link + "'' >" + web + "<a></div>";
            iw = new google.maps.InfoWindow({
              content: html
            });
            iw.open(map, marker);
            infoWindowVisible(true);
          }
        });
        google.maps.event.addListener(iw, 'closeclick', function() {
          infoWindowVisible(false);
        });
      }
          
          // Create the search box and link it to the UI element.
      var input = /** @type {HTMLInputElement} */(
          document.getElementById('pac-input'));
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      var searchBox = new google.maps.places.SearchBox(
        /** @type {HTMLInputElement} */(input));

      // Listen for the event fired when the user selects an item from the
      // pick list. Retrieve the matching places for that item.
      google.maps.event.addListener(searchBox, 'places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }
        for (var i = 0, marker; marker = markers[i]; i++) {
          marker.setMap(null);
        }

        // For each place, get the icon, place name, and location.
        markers = [];
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
          var image = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

          // Create a marker for each place.
          var marker = new google.maps.Marker({
            map: map,
            icon: image,
            title: place.name,
            position: place.geometry.location
          });

          markers.push(marker);

          bounds.extend(place.geometry.location);
        }

        map.fitBounds(bounds);
      });

      // Bias the SearchBox results towards places that are within the bounds of the
      // current map's viewport.
      google.maps.event.addListener(map, 'bounds_changed', function() {
        var bounds = map.getBounds();
        searchBox.setBounds(bounds);
      });
    }
    </script>
@endsection
@stop
