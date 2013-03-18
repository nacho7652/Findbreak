$(document).ready(function(){
    

var lat = $('#lat-est').val();
var lng = $('#lng-est').val();
//alert(lat); alert(lng)
var map;
 buscar();
 
function buscar(){
    //Obtiene la coordenadas con respecto a la dirección
    var addresEvent =  lat+','+lng;
   // alert(addresEvent)
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({'address': addresEvent}, geocodeResult);
    function geocodeResult(results, status) {
            if (status == 'OK' && results.length > 0) {
            lat = parseFloat(results[0].geometry.location.lat()).toFixed(6);
            lng = parseFloat(results[0].geometry.location.lng()).toFixed(6);
            $('.Lat').val(lat);
            $('.Lng').val(lng);
            $('#map_establecimientos').css("display","block");
            cargarMapaEvento();            
    }} 
    //Fin de la obtención de las coordenadas con respecto a la dirección	
} 


function cargarMapaEvento(){
 
var latlon = new google.maps.LatLng(lat,lng); /* Creamos un punto con nuestras coordenadas */
            var myOptions = {
                zoom: 14,
                center: latlon, /* Definimos la posicion del mapa con el punto */
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };/*Configuramos una serie de opciones como el zoom del mapa y el tipo. */
            map = new google.maps.Map($("#map_establecimientos").get(0), myOptions); /*Creamos el mapa y lo situamos en su capa */
            var coorMarcador = new google.maps.LatLng(lat,lng); /*Un nuevo punto con nuestras coordenadas para el marcador (flecha) */
                
            var marcador = new google.maps.Marker({
				/*Creamos un marcador*/
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: map /* Lo vinculamos a nuestro mapa */
            });
}

});

