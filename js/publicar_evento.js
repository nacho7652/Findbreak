$(document).ready(function(){
var lat = "";
var lng = "";
var map;
$('#caloader').delegate('#comprobar-event','click',function(){
    buscar();
})

$('#LatLng').click(function(event){
    validar(event);
})
function buscar(){
    //Obtiene la coordenadas con respecto a la dirección
    var addresEvent = $('#addresEvent').val();

    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({'address': addresEvent}, geocodeResult);
    function geocodeResult(results, status) {
    if (status == 'OK' && results.length > 0) {
    lat = parseFloat(results[0].geometry.location.lat()).toFixed(6);
    lng = parseFloat(results[0].geometry.location.lng()).toFixed(6);
    $('.Lat').val(lat);
    $('.Lng').val(lng);
    $('#map_evento').css("display","block");
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
            map = new google.maps.Map($("#map_evento").get(0), myOptions); /*Creamos el mapa y lo situamos en su capa */
            var coorMarcador = new google.maps.LatLng(lat,lng); /*Un nuevo punto con nuestras coordenadas para el marcador (flecha) */
                
            var marcador = new google.maps.Marker({
				/*Creamos un marcador*/
                position: coorMarcador, /*Lo situamos en nuestro punto */
                map: map /* Lo vinculamos a nuestro mapa */
            });
}
function validar(event){
    if($('#nom-event').val()=="")
        {
            $('#nom-evet').focus();
            alert("Ingrese nombre");
            event.preventDefault();
        }
     else
         {
           if($('#addresEvent').val()=="")
               {
                   $('#addresEvent').focus();
                   alert("Ingrese dirección");
                   event.preventDefault();
               }
               else
                   {
                       if($('#photo-event').val()=="")
                         {
                            $('#photo-event').focus();
                            alert("Ingrese foto");
                            event.preventDefault();
                         }
                         else
                             {
                                 if($('#date-event').val() =="")
                                     {
                                         $('#date-event').focus();
                                         alert("Ingrese fecha");
                                         event.preventDefault();
                                     }
                                     else
                                         {
                                             if($('#hour-event').val() == "")
                                                 {
                                                     $('#hour-event').focus();
                                                     alert("Ingrese hora");
                                                     event.preventDefault();
                                                 }
                                                 else
                                                     {
                                                         if($('#tags-event').val() == "")
                                                             {
                                                                 $('#tags-event').focus();
                                                                 alert("Ingrese tags");
                                                                 event.preventDefault();
                                                             }
                                                             else
                                                                 {
                                                                     if($('.Lat').val() == "")
                                                                         {
                                                                             alert("compruebe direccion");
                                                                             event.preventDefault();
                                                                         }
                                                                 }
                                                     }
                                         }
                             }
                   }
         }
}

});

