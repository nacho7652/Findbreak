
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
                                    <div class="title-publicarevent">Edita información de tu anuncio: <?= $evento['nombre']?></div>
                                 </div>
                                
                                 
                        
                                
                                <div class="item-publicar">
                                     <div class="nombre-publicarevent">Agrega o cambia tus fotos</div>
<!--                                     <input type="file" id="images" name="images[]"/>
-->                                     <div class="foto-publicarevent">
                                            <?php for($i=0; $i< count($evento['fotos']); $i++){ 
                                                      $url = 'images/productoras/'.$folder.'/'.$evento['fotos'][$i]['gr']; 
                                                      $url2 = 'images/productoras/'.$folder.'/'.$evento['fotos'][$i]['pe'];
                                                ?>
                                                   <div  style="background-image: url(<?= $url ?>); background-size:cover; background-position: 0px 0px;" class="coverfile-galerias" data-cant="<?= $i?>">
                                                        <input type="file" id="images-evento-upd" data-num="<?= $i ?>" name="images-evento-upd" class="fotonoticia-galerias" />
                                                        <?php if($i!=0){?>
                                                            <a data-numero="<?= $i?>" data-urlsin="<?= 'images/productoras/'.$folder ?>" data-url2="<?= $url2 ?>" data-nombre2="<?= $evento['fotos'][$i]['pe'] ?>" data-url="<?= $url ?>" data-nombre="<?= $evento['fotos'][$i]['gr'] ?>" class="borrarFotoEvento delfoto" href="#">borrar</a>
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
                                    <div class="nombre-publicarevent">Nombre del anuncio</div>
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
                                        <div class="content-mensaje">* Ingresa al menos una palabra para que tus anuncios sean encontrados.</div>
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

                                    <div class="nombre-publicarevent msj-peqeno">¿No encuentras la palabra que quieres? <a class="mostrar-agre-tag" href="">Agrégala aquí!</a></div>
                                      <div class="divmostrar-agre-tag">
                                        <input class="field-publicarevent field-publicarevent-s2 " type="text" id="nuevo-tag"/>
                                        <input type="button" id="nuevo-tag-btn" value="Agregar nueva palabra" class="botongreen"/>
                                      </div>
                                  
                                 
                                </div>
                                
    
                                
                                
                                
    
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Descripción</div>
                                 <textarea placeholder="Detalla la información de tu anuncio, fechas, horas, precios, ubicacion, etc" class="field-publicarevent obligatorio" rows="4" cols="50" id="descripcion-event" name="descripcion-event"><?=$evento['descripcion']?></textarea>
                                 <div class="mensaje-error error-obligatorio">
                                        <div class="content-mensaje">* Ingresa una drescripción</div>
                                 </div>
                                </div>
    
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Sitio web oficial</div>
                                  <input value="<?= $evento['sitio_web']?>" placeholder="http://www.tusitioweb.com" class="field-publicarevent" type="text" id="sitioevento" name="sitioevento"/>
                                </div>
    
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Dirección de Facebook</div>
                                  <input value="<?= $evento['redes'][0]?>" placeholder="http://www.facebook.com/event/tusitio" class="field-publicarevent" type="text" id="urlfacebook" name="url-face"/>
                                </div>
                                
                                <div class="item-publicar">
                                  <div class="nombre-publicarevent">Dirección de Twitter</div>
                                  <input value="<?= $evento['redes'][1]?>" placeholder="http://www.twitter.com/tusitio" class="field-publicarevent" type="text" id="urltwitter" name="url-twitter"/>
                                </div>
                                
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Dirección Youtube</div>
                                 <input value="<?= $evento['redes'][2]?>" placeholder="http://www.youtube.com/tusitio" class="field-publicarevent" type="text" id="urlyoutube" name="url-youtube"/>
                                </div>
                                
                                
                                
                                    
                                
                                 <div class="item-publicar">
                                 
                                
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
