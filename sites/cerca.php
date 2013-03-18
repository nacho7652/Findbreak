
<div class="content-cerca">
    <div class="first-partevent">
        <div class="divevents">
            <div class="title"> 
                  <div class="text-cerca"> EVENTOS CERCA TUYO</div>
                  
                  <div class="input-textparent2">
                    <input type="text" value="BUSCA LO QUE QUIERAS..." id="search-near" class="input-transf"/>
                    <input id="boton-buscarcerca" type="button" class="sprites" />
                  </div> 
                  <div class="input-textparent3">
                    <input type="text" value="¿DÓNDE ESTÁS?" id="search-location" class="input-transf"/>
                    <input id="boton-location" type="button" class="sprites loc-activado" />
                  </div>
              </div>
            <div class="list-maps">
              <div class="loading-events">Loading...</div>
                <div class="inner-list-maps">
                    
                   <?php for($i=1; $i<=7; $i++){?> 
                    <div class="item-eventcerca">
                        <div class="barra"></div>
                        
                        <div class="event-right">
                            <div class="event-left"></div>
                            <div class="num-event">#<?php echo $i?></div>
                            
                            <div class="tit-eventcerca link">Barcelona vs Real Madrid</div>
                            <div class="info-eventcerca">
                                <div class="item-infocerca">
                                     <div class="preg-cuando">¿Cuándo?</div>
                                    <div id="fechaevent" class="resp-cuando">Viernes 09 de enero</div>
                                </div>
                                
                                <div class="item-infocerca">
                                    <div class="preg-cuando">¿Dónde?</div>
                                    <div id="dondeevent" class="resp-cuando">Estadio nacional #233, Santiago</div>
                                </div>
                                
                                <div class="item-infocerca">
                                    <div class="preg-cuando">¿Cuánto sale?</div>
                                    <div id="precioevent" class="resp-cuando">Gratis</div>
                                </div>
                                
                                <div class="botongreen">Ver información</div>
                            </div>
                        </div>
                    </div>
                   
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        <div style='bottom: 0;
                    left: 0px;
                    position: fixed;
                    right: 0;
                    top: 50px;
                    z-index: 1;' id="mapView">
            <div id='map_canvas' style='width: 100%;
                                        height: 100%;
                                        overflow: hidden;
                                        position: relative;
                                        background-color: rgb(229, 227, 223);
                                        -webkit-transform: translateZ(0);'></div><!--Esta capa har� de elemento contenedor del mapa-->
        </div>
        <div class="event-hidden">
           
        </div>
    </div>
   
        
    </div>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> <!--Cargamos la API de Google Maps-->
    <script type="text/javascript" src="js/maps.js"></script>
