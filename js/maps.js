$(document).ready(function(){
    //path = '/nowsup/';
    path = '/';
    localizame();
     
    var popupNew;
    var latitud;
    var longitud;
    var map;
    var manualLocation = false;
    var editarEvento = $('#addresEvent').val();
    if(editarEvento != undefined)//estoy en editar
    {
         geolocalizarManual(editarEvento)   
    }

  function cargarMapa(nombreMapa) {
//           alert('lat: '+latitud)
//           alert('long: '+longitud)
            var latlon = new google.maps.LatLng(latitud,longitud); /* Creamos un punto con nuestras coordenadas */
            var myOptions = {
                scrollwheel: false,
                zoom: 12,
                center: latlon, /* Definimos la posicion del mapa con el punto */
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.BOTTOM_CENTER
                },
                panControl: true,
                panControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE,
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
//                scaleControl: true,
//                scaleControlOptions: {
//                    position: google.maps.ControlPosition.TOP_LEFT
//                },
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                }
            };/*Configuramos una serie de opciones como el zoom del mapa y el tipo. */
            
            
            map = new google.maps.Map($("#"+nombreMapa).get(0), myOptions); /*Creamos el mapa y lo situamos en su capa */
            
            var coorMarcador = new google.maps.LatLng(latitud,longitud); /*Un nuevo punto con nuestras coordenadas para el marcador (flecha) */
            var marcador = new google.maps.Marker({
				/*Creamos un marcador*/
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: map, /* Lo vinculamos a nuestro mapa */
                title: "Estoy aquí !" 
            });
  }
 function comprobarnavegador() {
        /* Variables para cada navegador, la funcion indexof() si no encuentra la cadena devuelve -1, 
        las variables se quedaran sin valor si la funcion indexof() no ha encontrado la cadena. */
        var is_safari = navigator.userAgent.toLowerCase().indexOf('safari/') > -1;
        var is_chrome= navigator.userAgent.toLowerCase().indexOf('chrome/') > -1;
        var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox/') > -1;
        var is_ie = navigator.userAgent.toLowerCase().indexOf('msie ') > -1;

        /* Detectando  si es Safari, vereis que en esta condicion preguntaremos por chrome ademas, esto es porque el 
        la cadena de texto userAgent de Safari es un poco especial y muy parecida a chrome debido a que los dos navegadores
        usan webkit. */

        if (is_safari && !is_chrome ) {
            $('.paso0-tutorial .mapa-explic1').css('top','420px');
            $('.paso0-tutorial .mapa-explic1').css('left','195px');
            $('.paso0-tutorial .flecha-mapa').css('top','386px');
            $('.paso0-tutorial .flecha-mapa').css('left','584px');
            $('.paso0-tutorial .flecha-mapa').css('background','url(/images/flecha.png) no-repeat 0px 1px');        
        }else{

        //Detectando si es Chrome
            if (is_chrome ) {
                $('.paso0-tutorial .mapa-explic1').css('top','47px');
                $('.paso0-tutorial .mapa-explic1').css('left','203px');
                $('.paso0-tutorial .flecha-mapa').css('background','url(/images/flecha.png) no-repeat 0px -150px'); 
                
            }else{
                 if (is_firefox ) {
                     $('.paso0-tutorial .flecha-mapa').css('background','url(/images/flecha.png) no-repeat 2px -149px'); 
                     $('.paso0-tutorial .mapa-explic1').css('top','155px');
                     $('.paso0-tutorial .mapa-explic1').css('left','532px');
                     $('.paso0-tutorial .flecha-mapa').css('top','142px');
                     $('.paso0-tutorial .flecha-mapa').css('left','349px');
                 }else{
                     if (is_ie ) {
                        $('.paso0-tutorial .mapa-explic1').css('top','480px');
                        $('.paso0-tutorial .mapa-explic1').css('left','303px');
                        $('.paso0-tutorial .flecha-mapa').css('top','461px');
                        $('.paso0-tutorial .flecha-mapa').css('left','680px');
                        $('.paso0-tutorial .flecha-mapa').css('background','url(/images/flecha.png) no-repeat 0px -76px');
                    }else{
                        $('.paso0-tutorial .mapa-explic1').css('top','255px');
                        $('.paso0-tutorial .mapa-explic1').css('left','532px');
                        $('.paso0-tutorial .flecha-mapa').css('top','222px');
                        $('.paso0-tutorial .flecha-mapa').css('left','349px');
                        $('.paso0-tutorial .flecha-mapa').css('background','url(/images/flecha.png) no-repeat 2px -149px'); 
                    }
                 }
            }
        }
        //Detectando si es Firefox
       

        //Detectando Cualquier version de IE
        
    }           
 function localizame() {   
            if (navigator.geolocation) { /* Si el navegador tiene geolocalizacion */
                comprobarnavegador();
                navigator.geolocation.getCurrentPosition(coordenadas, errores);
            }else{
                geolocalizarPorTags('');
            }
        }
function errores(err) {
            /*Controlamos los posibles errores */
            if (err.code == 0) {
              //alert("Oops! Algo ha salido mal");
              geolocalizarPorTags('');
            }
            if (err.code == 1) {
              //alert("Oops! No has aceptado compartir tu posici�n");
              geolocalizarPorTags('');
            }
            if (err.code == 2) {
              // alert("Oops! No se puede obtener la posici�n actual");
              geolocalizarPorTags('');
            }
            if (err.code == 3) {
              //alert("Oops! Hemos superado el tiempo de espera");
              geolocalizarPorTags('');
            }
        }        
function coordenadas(position) {
            //post a guardar la cookie si no existe      
            $.post('/function/users-response.php', {'cookie-ubicacion':1},
                    function(){
                        $('.paso').removeClass('paso-selected')
                        $('.paso0-tutorial, .paso2-tutorial, .paso3-tutorial').fadeOut(300, function(){
                                $('.paso0-tutorial').css('display','none');
                                $('.paso2-tutorial').css('display','none');
                                $('.paso3-tutorial').css('display','none');
                                $('#paso1').addClass('paso-selected')
                                $('.paso1-tutorial').fadeIn(300);
                             
                        });    
                    }, "html");
            latitud = position.coords.latitude; /*Guardamos nuestra latitud*/
            longitud = position.coords.longitude;
            geolocalizar();
        }

function geolocalizar(){
        DeletePrintStore();
        var geocoder = new google.maps.Geocoder();
        var address = latitud+","+longitud;//$("#direHidden").val()+', Chile';
//        alert(latitud +" , "+ longitud);
        cargarMapa('map_canvas');
        geocoder.geocode({'address': address}, geocodeResult);
}
function geolocalizarManual(address){
   
         manualLocation = true;
         DeletePrintStore();
         var geocoder = new google.maps.Geocoder();
         geocoder.geocode({'address': address}, geocodeResult);      
}

function geolocalizarPorTags(){
     desactivarLocation();
     DeletePrintStore();
     var geocoder = new google.maps.Geocoder();
     geocoder.geocode({'address': latitud+','+longitud}, geocodeResultPorTags);      
}
    function geocodeResultPorTags(results, status) {  
        if (status == 'OK' && results.length > 0) {
            var lat = map.getCenter().lat();
            var lng = map.getCenter().lng();
            latitud = lat;
            longitud = lng;
            
            //return false;
//        alert(lat); alert(lng); 
            $.ajax({
                data: "findnear-eventos=1&q="+$('#search-location').val(),
                type: "POST",
                dataType: "json",
                url: path+"function/event-response.php",
                success: function(data){
                   $('.loading-events').hide();
                   $('.event-hidden').html(data.infodiv);
                   var numberOfCase = parseInt($('#number').text());
                   
                    if(numberOfCase == 0){
                        
                        $('.tipoBusqueda').html('relacionados con <b>'+$('#search-location').val()+'</b>');
                        $('.inner-list-maps').hide();
                        $('.no-resultados').show();
                        return false;
                    }else{
                        if($('#search-location').val() == ''){
                          $('.tipoBusqueda').html('<b>más populares</b>');  
                        }else{
                          $('.tipoBusqueda').html('relacionados con <b>'+$('#search-location').val()+'</b>');
                        }
                        $('.inner-list-maps').show();
                        $('.no-resultados').hide();
                    }        
                 var infoDiv = "";
                 var tokens;
                 var cont = 1;
                 $('.event-none').hide();
//                 alert(numberOfCase)
                 latitud = data.arreglo[0]['lat'];
                 longitud = data.arreglo[0]['lng'];
                 cargarMapa('map_canvas');
                 for(var i=0;i<numberOfCase;i++){
                     
                    id = data.arreglo[i]['id'];
                    hash = data.arreglo[i]['hash'];
                    //html = data.arreglo[i]['event-right'];
                    infoCerca = data.arreglo[i]['info'];//$infoEventCerca
                    tagshidden = data.arreglo[i]['tags'];
                    nombre = data.arreglo[i]['nombre'];
                    foto = data.arreglo[i]['foto'];
                    
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('data-id',id);
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('data-hash',hash);
                   $('#item-eventcerca'+i).find('.info-eventcerca').html(infoCerca);
                   $('#item-eventcerca'+i).find('.hash').html('#'+hash);
                   $('#item-eventcerca'+i).find('.tags-hidden').html(tagshidden);
                   $('#item-eventcerca'+i).find('.tit-eventcerca').html(nombre); //
                   $('#item-eventcerca'+i).find('.tit-eventcerca').attr("href",path+"break/"+hash);
                   $('#item-eventcerca'+i).find('.idevent').val(id);
                   $('#item-eventcerca'+i).find('.hashevent').val(hash);
                   $('#item-eventcerca'+i).find('.nombreevent').val(nombre);
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('style',foto);
                   $('#item-eventcerca'+i).find('.event-left').attr('style',foto);
                   $('#item-eventcerca'+i).show();
                   infoDiv = $('#info'+i).text();	 
                   tokens = infoDiv.split("+");
                   
                   var note="";
                   var name = tokens[0];
                   var address = tokens[1];
                       lat = parseFloat(tokens[2]); 	 
                       lng = parseFloat(tokens[3]);
                   //var distance = parseFloat(tokens[4]); 
   
                   var PointMaps = new google.maps.LatLng(lat, lng);
                   var markerNew = new google.maps.Marker({
                       position: PointMaps
                       , map: map
                       , title: name
                       //, icon: '<div style="width:35px; height:40px; background:url("/findbreak/images/marker5.png")">1</div>'
                       , icon: 'http://gmaps-samples.googlecode.com/svn/trunk/markers/red/marker'+cont+'.png'
                       
                   });
                   //nota es el recuadro que sale en grande cuando se hace click en la clinica
                   note = '<div id="infoWindow" style=""><p><strong>'+name+'</strong></div>';
                   
                   

                   
                 PrintStore(map,markerNew,note,lat,lng,name, address, cont);  	   
                 cont++; 
                }
                //esconder los eventos tipo que no se usan
                
          	   map.setZoom(12); //13
//                   clickdentista();//IMPORTANTE
//                   clickPaginador();//para activar la function cuando se carga el DOM
//                   clickDetalleAtencion();
//                   clickBotonIr();//activar el desea tomar la hora ?
              }
            });
          
          }else{ //buscar los eventos
        	$('.inner-list-maps').hide();
                $('.no-resultados').show();
                return false;
                
        }  
    }
    
    function geocodeResult(results, status) {
       
        if (status == 'OK' && results.length > 0) {
            //si modificó la direccion manual
            if(manualLocation){
                       
                        
                        var mapOptions = {
                            zoom: 12,
                            center: results[0].geometry.location,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            scrollwheel: false,
                            mapTypeControl: false,
                            mapTypeControlOptions: {
                                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                                position: google.maps.ControlPosition.BOTTOM_CENTER
                            },
                            panControl: true,
                            panControlOptions: {
                                position: google.maps.ControlPosition.RIGHT_BOTTOM
                            },
                            zoomControl: true,
                            zoomControlOptions: {
                                style: google.maps.ZoomControlStyle.LARGE,
                                position: google.maps.ControlPosition.RIGHT_TOP
                            },
                            streetViewControl: true,
                            streetViewControlOptions: {
                                position: google.maps.ControlPosition.RIGHT_TOP
                            }
                        };
                        map = new google.maps.Map($("#map_canvas").get(0), mapOptions);
                        map.fitBounds(results[0].geometry.viewport);
                        var markerOptions = {position: results[0].geometry.location}
                        var marker = new google.maps.Marker(markerOptions);
                        marker.setMap(map);
            
        }
            var lat = map.getCenter().lat();
            var lng = map.getCenter().lng();
            latitud = lat;
            longitud = lng;
            if(guardarEvento){
           
                $('.lat-event').val(lat);
                $('.lng-event').val(lng);
                return false;
            }
            if($('#anuncioAgregado').val() != ''){
               
                $('#search-near').val($('#anuncioAgregado').val())
                geolocalizarManual($('#anuncioAgregado').val()); 
                $('#anuncioAgregado').val('');
                return false;
           }
            //return false;
//        alert(lat); alert(lng); 
            
            $.ajax({
                data: "findnear2=1&lat="+lat+"&lng="+lng,
                type: "POST",
                dataType: "json",
                url: path+"function/event-response.php",
                success: function(data){
              
                   $('.loading-events').hide();
                   $('.event-hidden').html(data.infodiv);
                   var numberOfCase = parseInt($('#number').text());
                   
                    if(numberOfCase == 0){
                        
//                        geolocalizarPorTags();
//                        return false;         
                        $('.tipoBusqueda').html('cerca de <b>'+$('#search-near').val()+'</b>');
                        $('.inner-list-maps').hide();
                        $('.no-resultados').show();
                        return false;
                    }else{
                        
                        if(geolocation){
                            geolocation = false;
                            $('.tipoBusqueda').html('cerca de <b>mi ubicación actual</b>');
                            $('#search-location').val('');

                        }else{
                            if(manualLocation){
                               
                                $('.tipoBusqueda').html('cerca de <b>'+$('#search-near').val()+'</b>');
                                manualLocation = false;
                            }
                        }
                        $('.inner-list-maps').show();
                        $('.no-resultados').hide();
                    }        
                 var infoDiv = "";
                 var tokens;
                 var cont = 1;
                 for(var i=0;i<numberOfCase;i++){
                     
                    id = data.arreglo[i]['id'];
                    hash = data.arreglo[i]['hash'];
                    //html = data.arreglo[i]['event-right'];
                    infoCerca = data.arreglo[i]['info'];//$infoEventCerca
//                    alert(infoCerca)
                    tagshidden = data.arreglo[i]['tags'];
                    nombre = data.arreglo[i]['nombre'];
                    foto = data.arreglo[i]['foto'];
                    verif = data.arreglo[i]['verificacion'];
                   note = data.arreglo[i]['note'];
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('data-id',id);
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('data-hash',hash);
                   $('#item-eventcerca'+i).find('.info-eventcerca').html(infoCerca);
                   $('#item-eventcerca'+i).find('.hash').html('#'+hash);
                   $('#item-eventcerca'+i).find('.tags-hidden').html(tagshidden);
                   $('#item-eventcerca'+i).find('.tit-eventcerca').html(nombre); //
                   $('#item-eventcerca'+i).find('.tit-eventcerca').attr("href",path+"break/"+hash);
                   $('#item-eventcerca'+i).find('.idevent').val(id);
                   $('#item-eventcerca'+i).find('.hashevent').val(hash);
                   $('#item-eventcerca'+i).find('.nombreevent').val(nombre);
                   $('#item-eventcerca'+i).show();
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('style',foto);
                   
                   infoDiv = $('#info'+i).text();	 
                   tokens = infoDiv.split("+");
                   
                   
                   var name = tokens[0];
                   var address = tokens[1];
                       lat = parseFloat(tokens[2]); 	 
                       lng = parseFloat(tokens[3]);
                       fotoPe = tokens[4];
                       hash = tokens[5];
                   //var distance = parseFloat(tokens[4]); 
   
                   var PointMaps = new google.maps.LatLng(lat, lng);
                       if(verif==0 || verif == null)
                           {
                      
                                   var markerNew = new google.maps.Marker({
                                   position: PointMaps
                                   , map: map
                                   , title: name
                                   //, icon: '<div style="width:35px; height:40px; background:url("/findbreak/images/marker5.png")">1</div>'

                                   , icon: 'http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/marker'+cont+'.png'
                               })
                           }
                           else
                               {
                                   if(verif==1)
                                       {
                                           var markerNew = new google.maps.Marker({
                                                position: PointMaps
                                                , map: map
                                                , title: name
                                                //, icon: '<div style="width:35px; height:40px; background:url("/findbreak/images/marker5.png")">1</div>'

                                                , icon: 'http://gmaps-samples.googlecode.com/svn/trunk/markers/red/marker'+cont+'.png'
                                            })
                                       }
                                       else
                                           {
                                               if(verif==2)
                                                   {
                                                       var markerNew = new google.maps.Marker({
                                                            position: PointMaps
                                                            , map: map
                                                            , title: name
                                                            //, icon: '<div style="width:35px; height:40px; background:url("/findbreak/images/marker5.png")">1</div>'

                                                            , icon: 'http://gmaps-samples.googlecode.com/svn/trunk/markers/green/marker'+cont+'.png'
                                                        })
                                                   }
                                           }
                               }
//                  
                   PrintStore(map,markerNew,note,lat,lng,name, address, cont);  	   
                   cont++;
                 
                 
                }
                //esconder los eventos tipo que no se usan
                
          	   map.setZoom(12); //13
//                   clickdentista();//IMPORTANTE
//                   clickPaginador();//para activar la function cuando se carga el DOM
//                   clickDetalleAtencion();
//                   clickBotonIr();//activar el desea tomar la hora ?
              }
            });
          
          }else{ //buscar los eventos
                geolocalizarPorTags();
                return false;
                
        }  
    }
    

    function PrintStore(map,marker,note,lat,lng,name, address, cont){
       $('#storeresp').append('<div id="storeinformation" style="border-bottom:1px solid #c4c3c3">'+
    		                     '<image style="float:left;margin:-10px 10px 0px 0px;width:15px;height:25px" src="http://gmaps-samples.googlecode.com/svn/trunk/markers/red/marker'+cont+'.png">'+
    		                     '<h6><a id="storezoom'+cont+'" href="#" onclick="return false;">'+name+'</a><a id="linkdetails'+cont+'" href="#" onclick="return false;" style="float:right">(ver detalles +)</a></h6>'+
    		                    '<div id="storedetails'+cont+'" style="display:none;"><p>'+address+'</p></div>'+  
                              '</div>');

       var Link = document.getElementById("linkdetails"+cont);
       var Store = document.getElementById("storedetails"+cont);
       var Zoom = document.getElementById("storezoom"+cont);
      // var popupNew;
       
	   $(Link).click(function() {
         $(Store).toggle(300,function(){
          if($(Link).text()=="(ver detalles +)")	 
        	$(Link).text("(ver detalles -)");
          else
          	$(Link).text("(ver detalles +)");  
         });         
	   });
	   
//	   $('#body').delegate('#contmaps'+cont,'click',function(){
        //     $(window).scrollTop(0);
        //		map.setCenter(new google.maps.LatLng(lat,lng));
        //        if(popupNew){
        //              popupNew.close();
        //        }
        //        popupNew = new google.maps.InfoWindow();
        //        popupNew.setContent(note);
        //        popupNew.open(map, marker);		
        // 	    map.setZoom(13);
//	   });
	   $('#body').delegate('#verEnMapa'+cont,'click',function(){
                lat = $(this).parent().find('.latHidden').val();//borrar ruta anterior
                lng = $(this).parent().find('.lngHidden').val();
                map.setCenter(new google.maps.LatLng(lat,lng));
                if(popupNew){
                      popupNew.close();
                }
               
                popupNew = new google.maps.InfoWindow();
                popupNew.setContent(note);
                popupNew.open(map, marker);		
                map.setZoom(13);
                return false;
                //cargarMapa();
            })
	   
       google.maps.event.addListener(marker, 'click', function(){
        
           if(popupNew){
              popupNew.close();
           }
           popupNew = new google.maps.InfoWindow();
           popupNew.setContent(note);
           popupNew.open(map, this);
           map.setZoom(13);
       });
	   
	   
    }
    
   function DeletePrintStore(){
	   $('div').remove('#storeinformation');
   }
   
   //cuando el usuario escriba una dirección en el buscador
   $('#search-location').keypress(function(e){
       if(e.keyCode == 13){
           desactivarLocation()
           //geolocalizarManual($(this).val())
            geolocalizarPorTags($(this).val())
       }
   })
   $('#search-near').keypress(function(e){
       if(e.keyCode == 13){
           desactivarLocation()
           geolocalizarManual($(this).val())
       }
   })
   
   $('#boton-buscarcerca').click(function(e){
       desactivarLocation()
       geolocalizarPorTags($('#search-location').val())
   })
   //cuando quiere location automática
   $('#boton-location').hover(function(){
        $('.mensaje-location').fadeIn(200);
    });
    $('#boton-location').mouseleave(function(){
        $('.mensaje-location').fadeOut(200);
    });
   function desactivarLocation(){
           $('.mensaje-location').fadeOut(200,function(){
               $('.mensaje-location').html('Usar tu ubicación actual');
           });
           $('#boton-location').removeClass('loc-activado');
           $('#boton-location').addClass('loc-desactivado');
           
   }
   function activarLocation(){
           $('#search-near').val('')
           $('.mensaje-location').html('Usando tu ubicación actual');
           $('.mensaje-location').fadeIn(200);
           $('#boton-location').removeClass('loc-desactivado');
           $('#boton-location').addClass('loc-activado');     
   }
   geolocation = false;
   $('#boton-location, #boton-location-tut').click(function(){
            activarLocation();
            manualLocation = false;
            geolocation = true;
            localizame();
   })
   
   //guardar evento
   guardarEvento = false;
   $('#addresEvent').keyup(function(e){
       if(e.keyCode == 13){
            guardarEvento = true;
            direccionEvento = $('#addresEvent').val();
            if(direccionEvento == ''){
                direccionEvento = 'Santiago de Chile'
            }
            geolocalizarManual(direccionEvento);
       }
   })
   $('#comprobar-event').click(function(){
       guardarEvento = true;
        direccionEvento = $('#addresEvent').val();
        if(direccionEvento == ''){
            direccionEvento = 'Santiago de Chile'
        }
        geolocalizarManual(direccionEvento);
  })
  //fin guardar evento
 
  //FACIL
  $('.equis-facil').click(function(){
      $('.publicar-facil').animate({
                         'top': "-190px" 
                     }, 500, function() {
                           $('.mensaje-abajo').fadeIn(300);
                           $('#guardarevento-facil').fadeOut(300)
                           $('#popup-login').hide();
                  });
                     
                     
  })
  $('#mostrar-facil').click(function(){
      $('.publicar-facil').animate({
                         'top': "57px" 
                     }, 500, function() {
                           $('.mensaje-abajo').fadeOut(300);
                           $('#guardarevento-facil').fadeIn(300)
                           $('#nombre-facil').focus();
                  });
                     
                     
  })
   $('#coverall').delegate('#guardarusuario-facil','click',function()
  {
       if(!validarCorreo($('#correo-usuario').val())){
           $('.todosloscampos .content-mensaje').html('Correo electrónico inválido');
           $('.todosloscampos').show();
     
           return false;
       }
   
       if(comprobarCampos()){
           $('.todosloscampos .content-mensaje').html('Debes completar todos los campos');
           $('.todosloscampos').show();
           return false;
       }else{
           $('.todosloscampos').hide();
       }
     
       if(usernameCorrecto == false){
           return false;
       }
      
        var nomeuser = $('#nombre-usuario').val();
        var username = $('#user-name').val();
        var correousuario = $('#correo-usuario').val();
        var claveusuario = $('#clave-usuario').val();
//        alert("adads"); return;
                        $.ajax({
                                 dataType:"html",
                                 url : path+'function/users-response.php',
                                 type : 'POST',
                                 data : "guardaruser=1&nomuser="+nomeuser+"&username="+username+"&correousuario="+correousuario+"&claveusuario="+claveusuario, 
                                 success : function(res){                      
                                     //modificar la foto con el mail
                                    
                                     if(res == 1){
                                          $.ajax({
                                                    type: "POST",
                                                    dataType: "html",
                                                    url: path+"function/send.php",
                                                    data: "mailBienvenida=1&para="+correousuario+"&nombre="+nomeuser
                                                  
                                                })
                                          $.ajax({
                          
                                                                type: "POST",
                                                                dataType: "JSON",
                                                                url: path+"function/login-response.php",
                                                                data: "login=1&mail="+correousuario+"&pass="+claveusuario,
                                                                success : function (data)
                                                                {  
                                                                    if(data.exito)
                                                                        { 
                                                                            if(data.usertype == 1){
                                      //                                          alert('entro :)')
                                                                              //ya validado que los campos NO estén vacios
                                                                              nombre = $('#nombre-facil').val();
                                                                              direccion = $('#direccion-facil').val();
                                      //                                        alert(latitud)
                                      //                                        alert(longitud)
                                                                              $.post('/function/event-response.php', {'guardar-facil':1,'nombre':nombre,'direccion':direccion,'lat':latitud,'lng':longitud},
                                                                                          function(data){
                                                                                                      window.location.reload();
                                                                                          }, "html");

                                                                            }   
                                                                        }
                                                                }
                                                            })
                                                                           }else
                                                                              if(res == -5){
                                                                                  $('.todosloscampos .content-mensaje').html("Lo sentimos, esta cuenta ya existe. ¿Te gustaría reclamar esta dirección de correo electrónico?");
                                                                                   $('.todosloscampos').show();
                                                                               }
                                                                        }//success                
                              });
      
  })
   $('#guardarevento-facil').click(function(e){
        if(trim($('#direccion-facil').val()) != '' && trim($('#nombre-facil').val()) != '' ){
            $.post('/function/users-response.php', {'comprobar-login':1},
                                                    function(data){
                                                                if(data == 1){
                                                                         nombre = $('#nombre-facil').val();
                                                                        direccion = $('#direccion-facil').val();
                                //                                        alert(latitud)
                                //                                        alert(longitud)
                                                                        $.post('/function/event-response.php', {'guardar-facil':1,'nombre':nombre,'direccion':direccion,'lat':latitud,'lng':longitud},
                                                                                    function(data){

                                                                                                 geolocalizarManual(direccion) 
                                                                                                  anuncioListo();
                                                                                    }, "html");
                                                                }else{
                                                                    $('.popup-login').fadeIn(300);
                                                                    $('#mail-facil').focus();
                                                                }
                                                    }, "html");
        }
   });
          $("#boton-login-facil").click(function(){
       
          //var textoAmigo = $('#amigo').val();
          var mail = $('.popup-login #mail-facil').val();
          var pass = $('.popup-login #pass-facil').val();
          
          if(mail=="" || pass=="")
              {
                  loader('Email o contraseña no son válidos');
              }
              else
                  {
                      
                      $.ajax({
                          
                          type: "POST",
                          dataType: "JSON",
                          url: path+"function/login-response.php",
                          data: "login=1&mail="+mail+"&pass="+pass,
                          success : function (data)
                          {  
                              if(data.exito)
                                  { 
                                      if(data.usertype == 1){
//                                          alert('entro :)')
                                        //ya validado que los campos NO estén vacios
                                        nombre = $('#nombre-facil').val();
                                        direccion = $('#direccion-facil').val();
//                                        alert(latitud)
//                                        alert(longitud)
                                        $.post('/function/event-response.php', {'guardar-facil':1,'nombre':nombre,'direccion':direccion,'lat':latitud,'lng':longitud},
                                                    function(data){
                                                                window.location.reload();
                                                    }, "html");
                                        
                                      }   
                                  }
                          }
                      })
                  }
              
          
          
      })
    $('body').delegate('.login-face-facil','click',function(event){
        event.preventDefault();
       
        fb.login(function(){ 
            if (fb.logged) 
            {
//                alert(fb.user.name)
//                alert(fb.user.first_name)
//                alert(fb.user.last_name)
//                alert(fb.user.username)
//                alert(fb.user.email)
//                alert(fb.user.picture)
               if(fb.user.name == 'undefined'){
                   loader('Intenta nuevamente en un momento :(')
                   return false;
               }
               $.ajax({
                      type:"GET",
                      dataType:"html",
                      url:path+"function/facebook-response.php",
                      data:"login=1&name="+fb.user.name+"&first_name="+fb.user.first_name+"&last_name="+fb.user.last_name+"&username="+fb.user.username+"&email="+fb.user.email+"&picture="+fb.user.picture,
                      success:function(data)
                      {
                          if(data == 1)//nuevo
                              {
                                  $.ajax({
                                                    type: "POST",
                                                    dataType: "html",
                                                    url: path+"function/send.php",
                                                    data: "mailBienvenida=1&para="+fb.user.email+"&nombre="+fb.user.first_name
                                                  
                                                })
                              }
                                        nombre = $('#nombre-facil').val();
                                        direccion = $('#direccion-facil').val();
//                                        alert(latitud)
//                                        alert(longitud)
//                                        alert(nombre)
//                                        alert(direccion)
                                        $.post('/function/event-response.php', {'guardar-facil':1,'nombre':nombre,'direccion':direccion,'lat':latitud,'lng':longitud},
                                                    function(data){
//                                                        alert(data)
                                                                 window.location.reload();
                                                    }, "html");
                              
                      }
                  }); 
            }else{
                loader('no login facebook :(')
            }
        })
    })

   function geolocalizarFacil(){
        getGeo();
        geolocation = true;
        $('#search-near').val($('#direccion-facil').val())
        localizame();
        activarLocation();
        $('#comprobar-geo').fadeOut(300);
   }
   $('#comprobar-geo').click(function(e){
       geolocalizarFacil();
   });
   $('#direccion-facil').keyup(function(e){
            if(trim($('#direccion-facil').val()) == ''){
                 
                  $('#comprobarDireFacil').fadeOut(300);
                  $('#comprobar-geo').fadeIn(300);
              }else{
                  $('#comprobarDireFacil').fadeIn(300);
                  $('#comprobar-geo').fadeOut(300);
              }
   });
    $('#direccion-facil').keypress(function(e){
      
       if(e.keyCode == 13){
           if(trim($('#direccion-facil').val()) != ''){
                desactivarLocation()
                manualLocation = true;
                $('#search-near').val($('#direccion-facil').val())
                geolocalizarManual($(this).val())
           }else{
               geolocalizarFacil();
               return false;
           }
       }
   })
   $('#comprobarDireFacil').click(function(e){
           desactivarLocation()
           manualLocation = true;
           $('#search-near').val($('#direccion-facil').val())
           geolocalizarManual($('#direccion-facil').val())
   })
   
   
function getGeo(){

if (navigator && navigator.geolocation) {
   navigator.geolocation.getCurrentPosition(geoOK, geoKO);
} else {
   geoMaxmind();
}

}

function geoOK(position) {
showLatLong(position.coords.latitude, position.coords.longitude);
}


function geoMaxmind() {
showLatLong(geoip_latitude(), geoip_longitude());
}

function geoKO(err) {
if (err.code == 1) {
error('El usuario ha denegado el permiso para obtener informacion de ubicacion.');
} else if (err.code == 2) {
error('Tu ubicacion no se puede determinar.');
} else if (err.code == 3) {
error('TimeOut.')
} else {
error('No sabemos que pasÃ³ pero ocurrio un error.');
}
}

function showLatLong(lat, longi) {
var geocoder = new google.maps.Geocoder();
var yourLocation = new google.maps.LatLng(lat, longi);
geocoder.geocode({ 'latLng': yourLocation },processGeocoder);

}
function processGeocoder(results, status){

if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
    $('#direccion-facil').val(results[0].formatted_address);
} else {
    error('Google no retorno resultado alguno.');
}
} else {
error("Geocoding fallo debido a : " + status);
}
}
function error(msg) {
alert(msg);
}
  //FIN FACIL

//   $('#search-near').keyup(function(e){
//       if(e.keyCode != 32){
//       var texto = $(this).val().split(' ');
//      
//        if(texto.length == 1){
//            buscar($(this).val())
//        }else{
//            buscarFrase(texto)
//        }
//       }
////       if(e.keyCode == 13){
////            buscar($(this).val())
////       }
//   })
   
//   function buscar(texto){
//	var eventos = $(".item-eventcerca");
//	texto        = texto.toLowerCase();
//	eventos.show();
//       
//        eventos.each(function(){
//            //for por cada palabra del b
//               var tags = $(this).find('.tags-hidden').html();
//               var tagsArr = tags.split(",");
//               var cumple = false;
//               for(var i=0;i<tagsArr.length;i++){
//                   
//                    //alert(tagsArr[i])
//                   
//                    var contenido = tagsArr[i];
//                     if(contenido != ''){
//                       // alert( 'tags: '+contenido+ ' textos: '+texto)
//                        contenido     = contenido.toLowerCase();
//                        var index     = contenido.indexOf(texto);
////                        alert(tagsArr[i])
////                        alert(texto)
//                       // alert(index)
//                        if(index == 0){
//                          //  alert('cumple')
//                            cumple = true;
//                        }
//                    }
//               }
//               
//               if(!cumple){
//                        $(this).hide();
//                }          
//        })
//    }
//    function buscarFrase(texto){
//        
//	var eventos = $(".item-eventcerca");
//	
//	eventos.show();
//       
//        eventos.each(function(){
//            //for por cada palabra del b
//            //alert(texto.length)
//            var cumple = false;
//            for(var j=0; j<texto.length; j++){
//               var textoBuscar        = texto[j].toLowerCase();
//               //alert(textoBuscar)
//               var tags = $(this).find('.tags-hidden').html();
//               var tagsArr = tags.split(",");
//               
//               for(var i=0;i<tagsArr.length;i++){
//                   
//                    //alert(tagsArr[i])
//                   
//                    var contenido = tagsArr[i];
//                     if(contenido != ''){
////                        alert( 'tags: '+contenido+ ' textos: '+textoBuscar)
//                        contenido     = contenido.toLowerCase();
//                        var index     = contenido.indexOf(textoBuscar);
////                        alert(tagsArr[i])
////                        alert(texto)
////                        alert(index)
//                        if(index == 0){
////                            alert('cumple')
//                            cumple = true;
//                        }
//                    }
//               }
//                   
//           }
//           
//               if(!cumple){
//                       // alert('la escondo')
//                        $(this).hide();
//                } 
//        })
//    }
    //ruta
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        
        function initialize() {
          directionsDisplay = new google.maps.DirectionsRenderer();
          directionsDisplay.setMap(map);
          directionsDisplay.setPanel(document.getElementById('directions-panel'));  
        }
    function calcRoute(latEvento, lngEvento, rutaType) {
            initialize();
  //        alert(latitud)
  //        alert(longitud)
        //var selectedMode = document.getElementById('mode').value;
        var start = new google.maps.LatLng(latitud,longitud);
        var end = new google.maps.LatLng(latEvento,lngEvento);
        var request = {
          origin: start,
          destination: end,
          travelMode: google.maps.TravelMode[rutaType]
         // travelMode: google.maps.TravelMode[selectedMode]
        };
         directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          }
          else{
              switch(status){
                  case google.maps.DirectionsStatus.NOT_FOUND: 
                       alert('al menos una de las ubicaciones especificadas en el origen, el destino o los hitos de la solicitud no se pudo codificar de forma geográfica');
                       break;
                  case google.maps.DirectionsStatus.ZERO_RESULTS: 
                       alert('no se pudo encontrar ninguna ruta entre el origen y el destino');
                       break;
                  case google.maps.DirectionsStatus.MAX_WAYPOINTS_EXCEEDED: 
                       alert('El número máximo de hitos permitido es ocho, además del origen y del destino');
                       break;
                  case google.maps.DirectionsStatus.INVALID_REQUEST: 
                       alert('rror son las solicitudes que no incluyen un origen o un destino, o las solicitudes de transporte público que incluyen hitos.');
                       break;
                  case google.maps.DirectionsStatus.OVER_QUERY_LIMIT: 
                       alert('ndica que la página web ha enviado demasiadas solicitudes dentro del período de tiempo permitido');
                       break;
                  case google.maps.DirectionsStatus.REQUEST_DENIED: 
                       alert('indica que no se permite el uso del servicio de rutas en la página web.');
                       break;
                  case google.maps.DirectionsStatus.UNKNOWN_ERROR: 
                       alert('indica que no se ha podido procesar una solicitud de rutas debido a un error del servidor. Puede que la solicitud se realice correctamente si lo intentas de nuevo.');
                       break;
              }       
          }
      });
      
    }
    $('body').delegate('.equis-rutas','click',function(){
        $('#directions-panel').html('');
        cerrarRuta();
    });
    //google.maps.event.addDomListener(window, 'load', initialize);
function mostrarRuta(){
      $('#allbackground-rutas').css('top','0px');
      $('html').css('overflow-y','hidden')
}
function cerrarRuta(){
      $('#allbackground-rutas').css('top','-5000px');
      $('html').css('overflow-y','scroll');
      $('.ruta-type').each(function(){ 
          $(this).attr('checked',false);
      })
      $('#radio_driving').attr('checked',true);
}
var latR;
var lngR;
$('body').delegate('.verRuta','click',function(){
    cargarMapa('map_canvas_ruta');
    lat = $(this).parent().find('.latHidden').val();//borrar ruta anterior
    lng = $(this).parent().find('.lngHidden').val();
    latR = lat;
    lngR = lng;
//    alert(lng);alert(lat);//return false;
    calcRoute(lat,lng, 'DRIVING');
    mostrarRuta();
})
$('body').delegate('.ruta-type','change',function(){
    rutaType = $(this).attr('data-value');
    cargarMapa('map_canvas_ruta');
    $('#directions-panel').html('');
    calcRoute(latR,lngR, rutaType)
})
$('#verEplicacionRuta').click(function(){
    if($('#directions-panel').is(':visible')){
        $('#directions-panel').hide();
        $(this).html('Ver explicación');
    }else{
        $('#directions-panel').show();
        $(this).html('Ocultar explicación');
    }
    return false;
})
//fin ruta
 
    function trim(cadena){
// USO: Devuelve un string como el parámetro cadena pero quitando los espacios en blanco de los bordes.
        var retorno=cadena.replace(/^\s+/g,'');
        retorno=retorno.replace(/\s+$/g,'');
        return retorno;
        }
    function validarCorreo(correo){
         var expre = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
         if(expre.test(correo)){
             return true;
         }else{
             return false;
         }
  }
  usernameCorrecto = false;
  function comprobarCampos(){
          error = false;
          $('.item-publicar input').each(function(){
              valor = $(this).val();
              if(trim(valor) == ""){
                  error = true;
              }
          })
          return error;
      }
});
 
