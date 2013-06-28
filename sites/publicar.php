
<?php  

        if(isset($_SESSION["userid"]))
        {
?>
<form id="guardarevento-form" method="POST" action="/findbreak/uploadevento" name="formularioevento" enctype="multipart/form-data">
<input type="hidden" name="guardarevento"/>
<div class="content-publicarevent">
                                 <div class="item-publicar">
                                    <div class="title-publicarevent">¿Quieres publicar un evento?</div>
                                 </div>
                                <div class="item-publicar">   
                                    <div id="info-mostrar">
                                    ¿Que obtienes al publicar un evento? 
                                    Findbreak te reembolsa dinero en tu cuenta dependiendo de la cantidad de visitas que tiene tu evento
                                    <a href="#">ver tabla de premios!</a>
                                    </div>
                                </div>
                                 
                        
                                
                                <div class="item-publicar">
                                     <div class="nombre-publicarevent">Selecciona fotos para tu evento, la primera será la principal</div>
<!--                                     <input type="file" id="images" name="images[]"/>
-->                                     <div class="foto-publicarevent">
                                            <?php for($i=1; $i<=5; $i++){ ?>
                                                   <div class="coverfile-galerias" data-cant="<?= $i?>">
                                                        <input type="file"  id="images-galerias" name="images-galerias<?= $i?>" class="fotonoticia-galerias"/>
                                                    </div>
                                            <?php }?>
                                       </div>
                                </div>
                                
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Nombre</div>
                                    <input class="field-publicarevent obligatorio" type="text" id="nom-event" name="nom-event"/>
                                    <div class="mensaje-error error-obligatorio">
                                        <div class="content-mensaje">* Debes ingresar el nombre</div>
                                    </div>
                                </div>
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Hashtag</div>
                                    <div class="hashInput">#</div><input placeholder="HashTagDeTuEvento" class="field-publicarevent field-publicarevent-m obligatorio" type="text" id="hash-event" name="hash-event"/>
                                    <div class="mensaje-error error-hashtag"></div>
                                    <div class="username-corr hashtag-corr"></div>
                                    <div class="hashtag-incorr"></div>
                                    
                                    <div class="mensaje-error error-obligatorio mensaje-m">
                                        <div class="content-mensaje">* Debes ingresar el hashtag</div>
                                    </div>
                                </div>
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">¿Dónde? *Escribe la dirección y compruébala en el mapa</div>
                                    <input class="field-publicarevent obligatorio" placeholder="Ej: Calle #246, Comuna, Ciudad" type="text" id="addresEvent" name="addresEvent"/> </br>
                                    <input type="button" id="comprobar-event" value="Comprobar dirección" class="botongreen"/>
                                    <div class="map_evento" id="map_canvas" style="width:800px; height:250px;"></div>
                                    <div class="mensaje-error error-obligatorio">
                                        <div class="content-mensaje">* Debes indicar la dirección</div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Fecha(s) del evento (yyyy-mm-dd)</div>
                                 <input type="text" class="field-publicarevent field-publicarevent-m obligatorio" id="date-event" name="date-event"/>
                                 <div class="mensaje-error error-obligatorio mensaje-m">
                                        <div class="content-mensaje ">* Debes ingresar una fecha</div>
                                 </div>
                                </div>
                                
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Hora de inicio(22:00)</div>
                                 <input placeholder="22" class="field-publicarevent field-publicarevent-s obligatorio" type="text" id="hour-event" name="hour-event"/>
                                 <div class="dospuntos"></div>
                                 <input placeholder="05" class="field-publicarevent field-publicarevent-s obligatorio" type="text" id="minute-event" name="minute-event"/>
                                 <div class="mensaje-error error-obligatorio mensaje-m">
                                        <div class="content-mensaje">* Debes ingresar la hora de inicio</div>
                                 </div>
                                </div>
                                
    
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Agrega las palabras claves para que encuentren tu evento</div>
                                    <input type="text" class="obligatorio" id="tags-hidden" name="tags-hidden"/>
                                    <div class="mensaje-error error-obligatorio mensaje-tags">
                                        <div class="content-mensaje">* Ingresa al menos una palabra clave</div>
                                    </div>
                                    <div class="content-tags">
                                           <?php 
                                           $evento = new evento();
                                           $tags = $evento->verTags();
                                           foreach($tags as $dcto){
                                           ?>
                                               <div class="tag-elegir tag-noselected"><?=$dcto['nombre']?></div>

                                           <?php }?>

                                       </div>  

                                    <div class="nombre-publicarevent msj-peqeno">¿No encuentras una palabra que deseas? <a class="mostrar-agre-tag" href="">Agrégala aquí!</a></div>
                                      <div class="divmostrar-agre-tag">
                                        <input class="field-publicarevent field-publicarevent-s2 " type="text" id="nuevo-tag"/>
                                        <input type="button" id="nuevo-tag-btn" value="Agregar nueva palabra" class="botongreen"/>
                                      </div>
                                  
                                 
                                </div>
                                
    
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Precio</div>
                                    <input placeholder="$5.000 pesos / entrada liberada" class="obligatorio field-publicarevent field-publicarevent-m " type="text" id="precio-event" name="precio-event"/>
                                    <div class="mensaje-error error-obligatorio mensaje-m">
                                        <div class="content-mensaje">* Debes ingresar el precio</div>
                                    </div>
                                </div>
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Establecimiento a realizar</div>
                                    <input placeholder="Ej: Estadio Nacional" class="field-publicarevent field-publicarevent-m " type="text" id="establecimiento-event" name="establecimiento-event"/>
                                    
                                </div>
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Puntos de venta</div>
                                    <?php  
                                       
                                      $puntosDeVenta = $evento->verPuntosVenta();
                                      $numPunto = 1;
                                        foreach($puntosDeVenta as $dcto){
                                        ?>
                                            <div class="item-puntoventa">
                                                <input class=" checkpunto " type="checkbox" id="establecimiento-event" name="puntosventa-event<?= $numPunto?>"/>
                                                <div class="nombre-publicarevent msj-peqeno nombre-puntoventa"><?= $dcto['nombre']?></div>
                                                <input placeholder="<?= $dcto['web']?>/tuEntrada" class="field-publicarevent field-publicarevent-m url-puntosventa" type="text" id="linkentrada-<?= $numPunto?>" name="linkentrada-<?= $numPunto?>"/>
                                                <div class="opcional msj-peqeno">Opcional</div>
                                            </div>
                                    <?php $numPunto++;}?>
                                    <!--<input placeholder="Ej: Estadio Nacional" class="field-publicarevent field-publicarevent-m " type="text" id="establecimiento-event" name="establecimiento-event"/>-->
                                </div>
    
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Descripción</div>
                                 <textarea placeholder="Detalla la información de tu evento" class="field-publicarevent obligatorio" rows="4" cols="50" id="descripcion-event" name="descripcion-event"></textarea>
                                 <div class="mensaje-error error-obligatorio">
                                        <div class="content-mensaje">* Ingresa una drescripción</div>
                                 </div>
                                </div>
    
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Sitio web oficial del evento</div>
                                  <input placeholder="http://www.tuevento.com" class="field-publicarevent" type="text" id="sitioevento" name="sitioevento"/>
                                </div>
    
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Facebook del evento</div>
                                  <input placeholder="http://www.facebook.com/event/tuevento" class="field-publicarevent" type="text" id="urlfacebook" name="url-face"/>
                                </div>
                                
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Twitter del evento</div>
                                  <input placeholder="http://www.twitter.com/tuevento" class="field-publicarevent" type="text" id="urltwitter" name="url-twitter"/>
                                </div>
                                
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">URL Youtube del evento</div>
                                 <input placeholder="http://www.youtube.com/tuevento" class="field-publicarevent" type="text" id="urlyoutube" name="url-youtube"/>
                                </div>
                                
                                
                                
                                    
                                
                                 <div class="item-publicar">
                                 
                                 <button id="btnSubmit" style="display: none;">Subir archivo</button>
                                  <input type="button" class="botongreen" id="guardarevento" value="Publicar"/>
                                 </div>
                                <input type="hidden" class="lat-event" name="lat-event"/>
                                <input type="hidden" class="lng-event" name="lng-event"/>
      </div>
</form>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="/findbreak/js/maps.js"></script>
<?php 


        }
        else
        {
            header("location:/findbreak/login");
            
        }
?>