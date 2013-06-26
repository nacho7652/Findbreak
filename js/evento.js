$(document).ready(function(){
    var popupNew;
    var latitud = $('#lat-event').val();
    var longitud = $('#lng-event').val();
    var map;
    geolocalizar();
    
    //Comprar evento
    
    $('#comprar-evento').click(function(){
        
                item = $(this).parent();
                idevento = item.attr('data-idevent');
                idproducidopor = item.attr('data-idproducido');
                
         $.ajax({
                data: "comprarevento=1&idevento="+idevento+"&idproducido="+idproducidopor,
                type: "POST",
                dataType: "json",
                url: "/findbreak/function/event-response.php",
                success: function(data){
                    
                    if(data == 1)
                        {
                            alert("Saldo suficiente");
                        }
                        else
                            alert("saldo insuficiente");
                    
                }
         });
        
        
    })
    
    
    //find comprar evento dnaiel maestro
    
    
    
//      alert(lat);alert(lng)
 function geolocalizar(){
            DeletePrintStore();
            var geocoder = new google.maps.Geocoder();
            var address = latitud+","+longitud;//$("#direHidden").val()+', Chile';
            cargarMapa();
            //geocoder : es lo que busca alrededor
            geocoder.geocode({'address': address}, geocodeResult);
    }
    
  function cargarMapa() {
            var latlon = new google.maps.LatLng(latitud,longitud); /* Creamos un punto con nuestras coordenadas */
            var myOptions = {
                zoom: 13,
                center: latlon, /* Definimos la posicion del mapa con el punto */
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };/*Configuramos una serie de opciones como el zoom del mapa y el tipo. */
            map = new google.maps.Map($("#map_establecimientos").get(0), myOptions); /*Creamos el mapa y lo situamos en su capa */
            
            var coorMarcador = new google.maps.LatLng(latitud,longitud); /*Un nuevo punto con nuestras coordenadas para el marcador (flecha) */
                
            var marcador = new google.maps.Marker({
				/*Creamos un marcador*/
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: map, /* Lo vinculamos a nuestro mapa */
                title: "D�nde estoy?" 
            });
  }

   

    function geocodeResult(results, status) {
       
        if (status == 'OK' && results.length > 0) {
            var lat = map.getCenter().lat();
            var lng = map.getCenter().lng();
         //alert(lat); alert(lng); 
            $.ajax({
                data: "estnear=1&lat="+lat+"&lng="+lng,
                type: "POST",
                dataType: "json",
                url: "../function/establecimiento-response.php",
                success: function(data){
                    
                $('#list-establec').html(data.listest);
                $('.est-hidden').html(data.infodiv);
                 var numberOfCase = parseInt($('#number').text());
                 var infoDiv = "";
                 var tokens;
                 var cont = 1;

                 
                 for(var i=0;i<numberOfCase;i++){
                   infoDiv = $('#info'+i).text();	 
                   tokens = infoDiv.split("+");
                   
        	   var note="";
                   var name = tokens[1];
                   var address = tokens[0];
                   lat = parseFloat(tokens[2]); 	 
                   lng = parseFloat(tokens[3]);
                   //var distance = parseFloat(tokens[4]); 
                   var PointMaps = new google.maps.LatLng(lat, lng);
                   var markerNew = new google.maps.Marker({
                       position: PointMaps
                       , map: map
                       , title: name
                       , icon: 'http://gmaps-samples.googlecode.com/svn/trunk/markers/red/marker'+cont+'.png'
                   });
                   //nota es el recuadro que sale en grande cuando se hace click en la clinica
                   note = '<div id="infoWindow" style=""><p><strong>'+name+'</strong></div>';
                 PrintStore(map,markerNew,note,lat,lng,name, address, cont);  	   
                 cont++; 
                }
          	   map.setZoom(13); //13
              }
            });
          
       } else {
        	alert("Geocoding no tuvo éxito debido a: " + status);
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
	   
	   $('#body').delegate('#contmaps'+cont,'click',function(){
     $(window).scrollTop(0);
		map.setCenter(new google.maps.LatLng(lat,lng));
        if(popupNew){
              popupNew.close();
        }
        popupNew = new google.maps.InfoWindow();
        popupNew.setContent(note);
        popupNew.open(map, marker);		
 	    map.setZoom(13);
	   });
	   
	   
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
   
    function trim(cadena){
// USO: Devuelve un string como el parámetro cadena pero quitando los espacios en blanco de los bordes.
        var retorno=cadena.replace(/^\s+/g,'');
        retorno=retorno.replace(/\s+$/g,'');
        return retorno;
        }
});