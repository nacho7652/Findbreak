$(document).ready(function(){
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
  function cargarMapa() {
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
            
            
            map = new google.maps.Map($("#map_canvas").get(0), myOptions); /*Creamos el mapa y lo situamos en su capa */
            
            var coorMarcador = new google.maps.LatLng(latitud,longitud); /*Un nuevo punto con nuestras coordenadas para el marcador (flecha) */
            var marcador = new google.maps.Marker({
				/*Creamos un marcador*/
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: map, /* Lo vinculamos a nuestro mapa */
                title: "Estoy aquí !" 
            });
  }
            
 function localizame() {   
            if (navigator.geolocation) { /* Si el navegador tiene geolocalizacion */
                navigator.geolocation.getCurrentPosition(coordenadas, errores);
            }else{
                alert('Oops! Tu navegador no soporta geolocalizaci�n. B�jate Chrome, que es gratis!');
            }
        }
function errores(err) {
            /*Controlamos los posibles errores */
            if (err.code == 0) {
              alert("Oops! Algo ha salido mal");
            }
            if (err.code == 1) {
              alert("Oops! No has aceptado compartir tu posici�n");
            }
            if (err.code == 2) {
              alert("Oops! No se puede obtener la posici�n actual");
            }
            if (err.code == 3) {
              alert("Oops! Hemos superado el tiempo de espera");
            }
        }        
function coordenadas(position) {
            latitud = position.coords.latitude; /*Guardamos nuestra latitud*/
            longitud = position.coords.longitude;
            geolocalizar();
        }

function geolocalizar(){
        DeletePrintStore();
        var geocoder = new google.maps.Geocoder();
        var address = latitud+","+longitud;//$("#direHidden").val()+', Chile';
//        alert(latitud +" , "+ longitud);
        cargarMapa();
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
                url: "/findbreak/function/event-response.php",
                success: function(data){
                   $('.loading-events').hide();
                   $('.event-hidden').html(data.infodiv);
                   var numberOfCase = parseInt($('#number').text());
                    if(numberOfCase == 0){
                        $('.tipoBusqueda').html('cerca de <b>'+$('#search-location').val()+'</b>');
                        geolocalizarManual($('#search-location').val())
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
                 cargarMapa();
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
                   $('#item-eventcerca'+i).find('.tit-eventcerca').attr("href","/findbreak/break/"+hash);
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
                        
                        manualLocation = false;
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
            if(geolocation){
                geolocation = false;
                $('.tipoBusqueda').html('cerca de <b>mi ubicación actual</b>');
                $('#search-location').val('');
                
            }
            //return false;
//        alert(lat); alert(lng); 
            
            $.ajax({
                data: "findnear2=1&lat="+lat+"&lng="+lng,
                type: "POST",
                dataType: "json",
                url: "/findbreak/function/event-response.php",
                success: function(data){
                   
                   $('.loading-events').hide();
                   $('.event-hidden').html(data.infodiv);
                   var numberOfCase = parseInt($('#number').text());
                    if(numberOfCase == 0){
                        $('.inner-list-maps').hide();
                        $('.no-resultados').show();
                        return false;
                    }else{
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
                  //  alert(infoCerca)
                    tagshidden = data.arreglo[i]['tags'];
                    nombre = data.arreglo[i]['nombre'];
                    foto = data.arreglo[i]['foto'];
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('data-id',id);
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('data-hash',hash);
                   $('#item-eventcerca'+i).find('.info-eventcerca').html(infoCerca);
                   $('#item-eventcerca'+i).find('.hash').html('#'+hash);
                   $('#item-eventcerca'+i).find('.tags-hidden').html(tagshidden);
                   $('#item-eventcerca'+i).find('.tit-eventcerca').html(nombre); //
                   $('#item-eventcerca'+i).find('.tit-eventcerca').attr("href","/findbreak/break/"+hash);
                   $('#item-eventcerca'+i).find('.idevent').val(id);
                   $('#item-eventcerca'+i).find('.hashevent').val(hash);
                   $('#item-eventcerca'+i).find('.nombreevent').val(nombre);
                   $('#item-eventcerca'+i).show();
                   $('#item-eventcerca'+i).find('.item-eventcerca').attr('style',foto);
                   $('#item-eventcerca'+i).find('.event-left').attr('style',foto);
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
            geolocalizarPorTags($(this).val())
       }
   })
   $('#boton-buscarcerca').click(function(e){
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
           $('.mensaje-location').html('Usando tu ubicación actual');
           $('.mensaje-location').fadeIn(200);
           $('#boton-location').removeClass('loc-desactivado');
           $('#boton-location').addClass('loc-activado');     
   }
   geolocation = false;
   $('#boton-location').click(function(){
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
           
        }
    function calcRoute(latEvento, lngEvento) {
          initialize();
//        alert(latitud)
//        alert(longitud)
    var start = new google.maps.LatLng(latitud,longitud);
    var end = new google.maps.LatLng(latEvento,lngEvento);
      var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.DRIVING
      };
       directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
        }
        else{alert('No se pudo determinar el camino, prueba desde otra dirección')}
      });
    }
    function mostrarError(){
	   	if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
	     	alert("No se ha encontrado una ubicación geográfica que se corresponda con la dirección especificada.");
	   	else if (gdir.getStatus().code == G_GEO_SERVER_ERROR)
	     	alert("No se ha podido procesar correctamente la solicitud de ruta o de códigos geográficos, sin saberse el motivo exacto del fallo.");
	   	else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
	     	alert("Falta el parámetro HTTP q o no tiene valor alguno. En las solicitudes de códigos geográficos, esto significa que se ha especificado una dirección vacía.");
		else if (gdir.getStatus().code == G_GEO_BAD_KEY)
	     	alert("La clave proporcionada no es válida o no coincide con el dominio para el cual se ha indicado.");
	   	else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
	     	alert("No se ha podido analizar correctamente la solicitud de ruta.");
	   	else alert("Error desconocido.");
	   
	}
    //google.maps.event.addDomListener(window, 'load', initialize);

$('body').delegate('.verRuta','click',function(){
    cargarMapa();
    lat = $(this).parent().find('.latHidden').val();//borrar ruta anterior
    lng = $(this).parent().find('.lngHidden').val();
//    alert(lng);alert(lat);//return false;
    calcRoute(lat,lng)
})


//fin ruta
 
    function trim(cadena){
// USO: Devuelve un string como el parámetro cadena pero quitando los espacios en blanco de los bordes.
        var retorno=cadena.replace(/^\s+/g,'');
        retorno=retorno.replace(/\s+$/g,'');
        return retorno;
        }
    
});
 
