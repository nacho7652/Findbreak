


<div class="content-cerca">
    <div class="first-partevent">
        <div class="divevents">
                     <div class="title"> 
                          <div class="text-cerca"> EVENTOS CERCA TUYO </div>

                          <div class="input-textparent2">
                            <input type="text" value="BUSCA LO QUE QUIERAS..." id="search-near" class="input-transf"/>
                            <input id="boton-buscarcerca" type="button" class="sprites" />
                          </div> 
                          <div class="input-textparent3">
                            <input type="text" value="UBICACIÓN ACTUAL" id="search-location" class="input-transf"/>
                            <input id="boton-location" type="button" class="sprites loc-activado" />
                          </div>
                      </div>
               
            <div class="list-maps">
              <div class="loading-events tit">Buscando eventos...</div>
              <div class="loading-events no-resultados">No hay carrete cerca de la ubicacion, prueba con otra dirección...</div>
                <div class="inner-list-maps">
                    
                    <?php $j=0; for($i=0; $i<=5; $i++){?> 
                       <div class="content-eventcerca event-none" id="item-eventcerca<?=$i?>">  
                         <div data-id="518d0c174de8b45810000000" data-hash="#RoosterEnChile2013" class="item-eventcerca">
                                            <div class="barra"></div>
                                            <div class="event-right">
                                                        <div class="event-left" style="background-image:url(../images/productoras/238928932389892/foto1.jps); background-size: cover"></div>
                                                         <div class="num-event"></div>   
                                                        <a target="_blank" href="/findbreak/break/518d0c174de8b45810000000" class="tit-eventcerca">Rooster en chile pico</a>
                                                       <div class="info-eventcerca info-eventcercawhte">
                                                           <div class="item-infocerca">
                                                               
                                                               <div id="fechaevent" class="resp-cuando">Miercoles, 20 de Mayo del 2013</div>
                                                           </div>
                                                            <div class="item-infocerca">
                                                                    <div id="horaevent" class="resp-cuando">22:00:00 hrs.</div>
                                                           </div>
                                                           <div class="item-infocerca">
                                                                
                                                                <div id="dondeevent" class="resp-cuando">Santa Sofia #2092</div>
                                                            </div>
                                                            
                                                            
                                                            
                                                            <div class="item-infocerca">
                                                                <div id="visitavent-prof" class="info-event-item resp-cuando">
                                                                   <div>Visto por <span class="bold">181</span></div>
                                                                   <div id="comentaevent-prof"><span class="bold">70</span> Comentarios</div>
                                                                   <input type="hidden" id="totalComent" value="70">
                                                               </div>  
                                                           </div>
                                                           <div class="botonitemcerca botonblue">Ver comentarios</div>
                                                        
                                                      </div>
                                                      
                                                        <div class="tags-hidden">quilicura,carrete,</div>
                                                    
                                            </div>
                                            
                                            <div class="coment-cerca">
                                               <?php if(!isset($_SESSION['userid'])){?>
                                                    <div class="cuadrocoment">
                                                        <div class="coments-nolog">
                                                            <input type="hidden" id="idevent" value="518d0c174de8b45810000000">
                                                            <input type="hidden" id="hashevent" value="#RoosterEnChile2013">
                                                           <div class="advert mjscoment">
                                                               Para comentar el evento debes <a class="login-hover login-hover-com" href="#">Iniciar sesión</a> ó
                                                               <a class="paracoment login-fb login-face" href="">
                                                                   <div id="loginbtn-fb"></div>
                                                                   <div class="txtfb">Ingresar con Facebook</div>
                                                               </a>
                                                           </div>
                                                        </div>
                                                    </div>
                                                <?php }else{?>
                                                     <div class="cuadrocoment coments">  
                                                         <input type="hidden" id="idevent" value="518d0c944de8b48419000000">  
                                                         <input type="hidden" id="hashevent" value="#BosterEnChile2013">  
                                                         <div class="input-transcom">     
                                                             <div class="hash">#BosterEnChile2013</div>     
                                                             <div id="overcoment">     
                                                                <textarea class="textoajustable" id="coment"></textarea>  
                                                             </div>
                                                             <div id="replica"></div>
                                                         </div>
                                                        <div class="showfocuscom" style="display: block;">
                                                            <div class="divcitar">@</div>
                                                            <div class="amigosCitar" style="display: none;"></div>
                                                            <input type="button" class="botonblue" id="btn-comentar" value="Comentar">
                                                        </div>

                                                      </div>
                                                <?php }?>
                                                <div class="list boxscroll">

                                                </div>
                                                
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
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> Cargamos la API de Google Maps
    <script type="text/javascript" src="/findbreak/js/maps.js"></script>
    
 