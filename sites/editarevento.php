
<?php  

        if(isset($_SESSION["userid"]))
        {
        $id = $_REQUEST['id'];
        $eventoFound = new evento();
        $evento = $eventoFound->findforid($id);
        $folder = $evento["producido_por"]['_id'];
?>
<form id="editarevento-form" method="POST" action="/findbreak/uploadevento" name="formularioevento" enctype="multipart/form-data">
<input type="hidden" name="editarevento"/>
<input type="hidden" name="hash-event" value="<?= $evento['hash']?>"/>
<div class="content-publicarevent">
                                 <div class="item-publicar">
                                    <div class="title-publicarevent">Edita información de <?= $evento['nombre']?></div>
                                 </div>
                                <div class="item-publicar">   
                                    <div id="info-mostrar">
                                    ¿Que obtienes al publicar un evento? 
                                    Findbreak te reembolsa dinero en tu cuenta dependiendo de la cantidad de visitas que tiene tu evento
                                    <a href="#">ver tabla de premios!</a>
                                    </div>
                                </div>
                                 
                        
                                
                                <div class="item-publicar">
                                     <div class="nombre-publicarevent">Pincha una foto y reemplazala o agrega nuevas fotos a tu evento</div>
<!--                                     <input type="file" id="images" name="images[]"/>
-->                                     <div class="foto-publicarevent">
                                            <?php for($i=0; $i< count($evento['fotos']); $i++){ 
                                                      $url = 'images/productoras/'.$folder.'/'.$evento['fotos'][$i][0]; 
                                                      $url2 = 'images/productoras/'.$folder.'/'.$evento['fotos'][$i][1];
                                                ?>
                                                   <div  style="background-image: url(<?= $url ?>); background-size:cover; background-position: 0px 0px;" class="coverfile-galerias" data-cant="<?= $i?>">
                                                        <input type="file" id="images-evento-upd" data-num="<?= $i ?>" name="images-evento-upd" class="fotonoticia-galerias" />
                                                        <?php if($i!=0){?>
                                                            <a data-urlsin="<?= 'images/productoras/'.$folder ?>" data-url2="<?= $url2 ?>" data-nombre2="<?= $evento['fotos'][$i][1] ?>" data-url="<?= $url ?>" data-nombre="<?= $evento['fotos'][$i][0] ?>" class="borrarFotoEvento" href="#">borrar</a>
                                                        <?php }?>
                                                   </div>
                                            <?php }?>
        
    
                                            <?php for($j=$i; $j<5; $j++){ ?>
                                                   <div class="coverfile-galerias" data-cant="<?= $i?>">
                                                        <input type="file"  id="images-evento-upd" data-num="<?= $i ?>" name="images-evento-upd" class="fotonoticia-galerias"/>
                                                        <a class="borrarFotoEvento2" href="#">borrar</a>
                                                   </div>
                                            <?php }?>
                                       </div>
                                </div>
                                
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Nombre</div>
                                    <input class="field-publicarevent obligatorio" type="text" id="nom-event" name="nom-event" value="<?= $evento['nombre']?>"/>
                                    <div class="mensaje-error error-obligatorio">
                                        <div class="content-mensaje">* Debes ingresar el nombre</div>
                                    </div>
                                </div>
<!--                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Hashtag</div>
                                    <div class="hashInput">#</div><input value=" //$evento['hash']?>" placeholder="HashTagDeTuEvento" class="field-publicarevent field-publicarevent-m obligatorio" type="text" id="hash-event" name="hash-event"/>
                                    <div class="mensaje-error error-hashtag"></div>
                                    <div class="username-corr hashtag-corr"></div>
                                    <div class="hashtag-incorr"></div>
                                    
                                    <div style="display: block; background: #f6f"class="mensaje-error error-obligatorio mensaje-m">
                                        <div class="content-mensaje">* El HashTag no puede ser editado</div>
                                    </div>
                                </div>-->
                                <div class="item-publicar">
                                    
                                    <div class="nombre-publicarevent">¿Dónde? *Escribe la dirección y compruébala en el mapa</div>
                                    <input value="<?= $evento['direccion']?>" class="field-publicarevent obligatorio" placeholder="Ej: Calle #246, Comuna, Ciudad" type="text" id="addresEvent" name="addresEvent"/> </br>
                                    <input type="button" id="comprobar-event" value="Comprobar dirección" class="botongreen"/>
                                    <div class="map_evento" id="map_canvas" style="width:800px; height:250px;"></div>
                                    <div class="mensaje-error error-obligatorio">
                                        <div class="content-mensaje">* Debes indicar la dirección</div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Fecha(s) del evento (yyyy-mm-dd)</div>
                                 <input value="<?= $evento['fecha_muestra']?>" type="text" class="field-publicarevent field-publicarevent-m obligatorio" id="date-event" name="date-event"/>
                                 <div class="mensaje-error error-obligatorio mensaje-m">
                                        <div class="content-mensaje ">* Debes ingresar una fecha</div>
                                 </div>
                                </div>
                                
                                <div class="item-publicar">
                                   <?php 
                                    $hora = $evento['hora_inicio'][0];
                                    $partesHoras = explode(':', $hora);
                                   ?>
                                 <div class="nombre-publicarevent">Hora de inicio(22:00)</div>
                                 <input value="<?= $partesHoras[0]?>" placeholder="22" class="field-publicarevent field-publicarevent-s obligatorio" type="text" id="hour-event" name="hour-event"/>
                                 <div class="dospuntos"></div>
                                 <input value="<?= $partesHoras[1]?>" placeholder="05" class="field-publicarevent field-publicarevent-s obligatorio" type="text" id="minute-event" name="minute-event"/>
                                 <div class="mensaje-error error-obligatorio mensaje-m">
                                        <div class="content-mensaje">* Debes ingresar la hora de inicio</div>
                                 </div>
                                </div>
                                
    
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Agrega las palabras claves para que encuentren tu evento</div>
                                    <?php 
                                        $valueTags = '';
                                        if(count($evento['tags']) > 0){
                                            for($i=0; $i< count($evento['tags']); $i++){
                                                $valueTags.=$evento['tags'][$i].',';
                                            }
                                        }
                                    ?>
                                    <input value="<?= $valueTags?>" type="text" class="obligatorio" id="tags-hidden" name="tags-hidden"/>
                                    <div class="mensaje-error error-obligatorio mensaje-tags">
                                        <div class="content-mensaje">* Ingresa al menos una palabra clave</div>
                                    </div>
                                    <div class="content-tags">
                                           <?php 
                                           
                                           $tags = $eventoFound->verTags();
                                           
                                           foreach($tags as $dcto){ 
                                               $tagEncontrado = $eventoFound->comprobarTags($evento['_id'], $dcto['nombre']);
                                               if(count($tagEncontrado) > 0){
                                               ?>
                                                   
                                                    <div class="tag-elegir tag-selected"><?=$dcto['nombre']?></div>   
                                            <?php  }else{ ?>
                                                <div class="tag-elegir tag-noselected"><?=$dcto['nombre']?></div>  
                                   <?php    } 
                                           }?>
                                            

                                       </div>  

                                    <div class="nombre-publicarevent msj-peqeno">¿No encuentras una palabra que deseas? <a class="mostrar-agre-tag" href="">Agrégala aquí!</a></div>
                                      <div class="divmostrar-agre-tag">
                                        <input class="field-publicarevent field-publicarevent-s2 " type="text" id="nuevo-tag"/>
                                        <input type="button" id="nuevo-tag-btn" value="Agregar nueva palabra" class="botongreen"/>
                                      </div>
                                  
                                 
                                </div>
                                
    
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Precio</div>
                                    <input value="<?= $evento['precio']?>"  placeholder="$5.000 pesos / entrada liberada" class="obligatorio field-publicarevent field-publicarevent-m " type="text" id="precio-event" name="precio-event"/>
                                    <div class="mensaje-error error-obligatorio mensaje-m">
                                        <div class="content-mensaje">* Debes ingresar el precio</div>
                                    </div>
                                </div>
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Establecimiento a realizar</div>
                                    <input value="<?= $evento['establecimiento']['nombre']?>"  placeholder="Ej: Estadio Nacional" class="field-publicarevent field-publicarevent-m " type="text" id="establecimiento-event" name="establecimiento-event"/>
                                    
                                </div>
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Puntos de venta</div>
                                    <?php  
                                       
                                      $puntosDeVenta = $eventoFound->verPuntosVenta();
                                      $numPunto = 1;
                                      $estable = null;
                                        foreach($puntosDeVenta as $dcto){
                                           
                                             //comprobar establecimiento
                                            $checked = '';
                                            $urlEntrada = '';
                                            $estable = $eventoFound->comprobarPuntosVenta($evento['_id'], $dcto['_id']);
                                           
                                            if(count($estable) > 0){
                                                    $checked = 'checked="checked"';
                                                    //if(isset($estable['link_entrada']) != '')
                                                    $urlEntrada = $estable['puntos_de_venta'][0]['link_entrada'];
                                                }
//                                                    ?>
                                                        <div class="item-puntoventa">
                                                            <input <?= $checked?> class=" checkpunto " type="checkbox" id="establecimiento-event" name="puntosventa-event<?= $numPunto?>"/>
                                                            <div class="nombre-publicarevent msj-peqeno nombre-puntoventa"><?= $dcto['nombre']?></div>
                                                            <input value="<?= $urlEntrada?>" placeholder="<?= $dcto['web']?>/tuEntrada" class="field-publicarevent field-publicarevent-m url-puntosventa" type="text" id="linkentrada-<?= $numPunto?>" name="linkentrada-<?= $numPunto?>"/>
                                                            <div class="opcional msj-peqeno">Opcional</div>
                                                        </div>
                                        <?php     
                                          $numPunto++;
                                        }?>
                                    <!--<input placeholder="Ej: Estadio Nacional" class="field-publicarevent field-publicarevent-m " type="text" id="establecimiento-event" name="establecimiento-event"/>-->
                                </div>
    
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Descripción</div>
                                 <textarea placeholder="Detalla la información de tu evento" class="field-publicarevent obligatorio" rows="4" cols="50" id="descripcion-event" name="descripcion-event"><?=$evento['descripcion']?></textarea>
                                 <div class="mensaje-error error-obligatorio">
                                        <div class="content-mensaje">* Ingresa una drescripción</div>
                                 </div>
                                </div>
    
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Sitio web oficial del evento</div>
                                  <input value="<?= $evento['sitio_web']?>" placeholder="http://www.tuevento.com" class="field-publicarevent" type="text" id="sitioevento" name="sitioevento"/>
                                </div>
    
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Facebook del evento</div>
                                  <input value="<?= $evento['redes'][0]?>" placeholder="http://www.facebook.com/event/tuevento" class="field-publicarevent" type="text" id="urlfacebook" name="url-face"/>
                                </div>
                                
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Twitter del evento</div>
                                  <input value="<?= $evento['redes'][1]?>" placeholder="http://www.twitter.com/tuevento" class="field-publicarevent" type="text" id="urltwitter" name="url-twitter"/>
                                </div>
                                
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">URL Youtube del evento</div>
                                 <input value="<?= $evento['redes'][2]?>" placeholder="http://www.youtube.com/tuevento" class="field-publicarevent" type="text" id="urlyoutube" name="url-youtube"/>
                                </div>
                                
                                
                                
                                    
                                
                                 <div class="item-publicar">
                                 
                                  <button id="btnSubmit" style="display: none;">Subir archivo</button>
                                  <input type="button" class="botongreen" id="modificarevento" value="Guardar cambios"/>
                                 </div>
                                <input value="<?= $evento['loc'][0]?>" type="hidden" class="lat-event" name="lat-event"/>
                                <input value="<?= $evento['loc'][1]?>" type="hidden" class="lng-event" name="lng-event"/>
                                <input value="<?= $evento['_id']?>" type="hidden" id="idevent" name="idevent"/>
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