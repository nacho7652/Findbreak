<div class="content-inicio">
     <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">
        var map;
        var latitud = -33.4499999996853;
        var longitud = -70.55000000000001; 
        $(document).ready(function() {
            cargarMapa(); /*Cuando cargue la p�gina, cargamos nuestra posici�n*/   
        });
         
        function cargarMapa() {
            var latlon = new google.maps.LatLng(latitud,longitud); /* Creamos un punto con nuestras coordenadas */
            var myOptions = {
                zoom: 12,
                center: latlon, /* Definimos la posicion del mapa con el punto */
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.BOTTOM_CENTER
                },
                panControl: false,
                panControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                zoomControl: false,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE,
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
//                scaleControl: true,
//                scaleControlOptions: {
//                    position: google.maps.ControlPosition.TOP_LEFT
//                },
                streetViewControl: false,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                }
            };/*Configuramos una serie de opciones como el zoom del mapa y el tipo. */
            map = new google.maps.Map($("#mapa-inicio").get(0), myOptions); /*Creamos el mapa y lo situamos en su capa */
            
//            var coorMarcador = new google.maps.LatLng(latitud,longitud); /*Un nuevo punto con nuestras coordenadas para el marcador (flecha) */
//                
//            var marcador = new google.maps.Marker({
//				/*Creamos un marcador*/
//                position: coorMarcador, /*Lo situamos en nuestro punto */
//                map: map, /* Lo vinculamos a nuestro mapa */
//                title: "D�nde estoy?" 
//            });
			
			/*var coorMarcador2 = new google.maps.LatLng(-33.490507,-70.61309);*/
			/*var marcador2 = new google.maps.Marker({*/
				/*Creamos un marcador*/
                /*position: coorMarcador2 ,*/ /*Lo situamos en nuestro punto */
                /*map: map,*/ /* Lo vinculamos a nuestro mapa */
                /*title: "D�nde estoy realmente?" 
            });*/
        }
    </script>
    <div class="inicio-primera">
        
        <div class="content-map-inicio">
            <div id="mapa-inicio"> 
            </div>
             <img src="/images/inicio/13.png"class="overmap">
             <div class="content-chat">
                 
             </div>
        </div>
        <!--<div class="logo-inicio"></div>-->
        <div class="txt1 txtini"> ¡Bienvenido a la nueva red social de panoramas!</div>
        <div class="txt2 txtini"> ¿Deseas buscar algo?</div>
        <div class="input-textparent-ini">
            <input placeholder="Fiestas, deporte, arte, etc." type="text" id="search-ini" class="input-transf">
            <input id="boton-buscar-ini" type="button" class="sprites" />
            <div id="eventresponse"></div>
            <!--<div id="buscarini" class="botongreen">Buscar</div>-->
            <div id="buscarini"></div>
        </div>
        
    </div>
    <div class="inicio-segunda">
        <div class="txt3 txtini-blue"> ¿Deseas buscar algún panorama cerca tuyo? </div>
        <a href="/findbreak/cerca" class="redir-cerca">
            <div class="txt4 txtini-blue">Pincha aquí</div>
            <div class="pincerca"></div>
        </a>
    </div>
</div>
<script>
    $('#search-ini').focus();
</script>