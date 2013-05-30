
<?php  

        if(isset($_SESSION["userid"]))
        {
?>

<div class="content-publicarevent">
                                 <div class="item-publicarevent">
                                    <div class="title-publicarevent">Crear nuevo evento</div>
                                 </div>
                                 
                        
                                
                                <div class="item-publicarevent">
                                     <div class="nombre-publicarevent">Foto (Máx 3 fotos)</div>
                                     <input type="file" id="images" name="images[]"/>
                                     <div class="foto-publicarevent"></div>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Nombre</div>
                                 <input class="field-publicarevent" type="text" id="nom-event" name="nom-event"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">¿Dónde?</div>
                                 <input placeholder="Ej: Calle #246, Comuna, Ciudad" type="text" id="addresEvent" name="addresEvent"/> </br>
                                 <div id="map_evento" style="width:250px; height:250px; display: none;"></div>
                                 <input type="button" id="comprobar-event" value="Comprobar"/>
                                </div>
                                
                                
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Fecha (dd-mm-yy)</div>
                                 <input type="date" id="date-event" name="date-event"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Hora (22:00)</div>
                                 <input type="time" id="hour-event" name="hour-event"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">URL FB</div>
                                 <input type="text" id="urlfacebook" name="url-face"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">URL Twitter</div>
                                 <input type="text" id="urltwitter" name="url-twitter"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Tags (rock fiesta)</div>
                                 <textarea rows="4" cols="50" id="tags-event" name="tags-event"></textarea>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Descripción</div>
                                 <textarea rows="4" cols="50" id="descripcion-event" name="descripcion-event"></textarea>
                                </div>
                                
                                
                                
                                    
                                
                                 <div class="item-publicarevent">
                                 
                                 <button id="btnSubmit" style="display: none;">Subir archivo</button>
                                  <input type="submit" class="botonguardar" id="guardarevento" value="Guardar"/>
                                 </div>
                                <input type="hidden" class="Lat" name="lat"/>
                                <input type="hidden" class="Lng" name="lng"/>
                               </div>
<?php 


        }
        else
        {
            header("location:/findbreak/login");
            
        }
?>