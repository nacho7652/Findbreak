<?php
    
    if(isset($_POST['popup-user'])){
         session_start();
         require_once '../DAL/connect.php';  
         require_once '../DAL/usuario.php';                                     ///AGREGAR AMIGOS CHAO
         
         $buttonFriend = '<div id="send-req" class="button-friend">Seguir</div>';
         //si está logeado buscar las posibles solicitudes
         
         if(!empty($_SESSION['userid'])) //si está logeado
         {            //<div id="send-req" class="button-friend">'.$valueButton.'</div>
                $solicitante = $_SESSION['userid'];
                if($solicitante == new MongoId($idSolicitado))
                {//si me busco a mi mismo
                    $buttonFriend = '';//no quiero que aparesca el boton de amigos
                }else{//si busco a otra persona
                    
                    
                    //BOTON SEGUIR
                        
                    //
                        $comprobacionSolicitd = $usuario->solicitudPendientes($solicitante, $idSolicitado);
                        
                        if(isset($comprobacionSolicitd['estado'])){ //DISTINTO DE VACIO ES POR QUE MANDE LA SOLICITUD
                            //EXISTE SOLICITUD
                            if($comprobacionSolicitd['estado'] == 0){//enviada
                                $buttonFriend = '<div id="canc-req" class="button-friend">Solicitud enviada</div>';
                            }
                            if($comprobacionSolicitd['estado'] == 1){//aceptada
                                
                                $buttonFriend = '<div id="del-req" class="button-friend">Amigos</div>';
                            }
                            

               //             if($comprobacionSolicitd['estado'] == -1){//rechazada
               //                 $valueButton = '';
               //             }

                        }
                      // $buttonFriend = '<div id="send-req" class="button-friend">'.$valueButton.'</div>';
                }
         }else{//no esta logeado
                        $buttonFriend = '<div id="logeate-friend" class="button-friend">Inicia sesión</div>';
         }
         $divProfileUser = '<div class="profileuser">';
         $divProfileUser.=   '<div class="left-user">
                                <div class="pic-user"></div>
                                '.$buttonFriend.'
                              </div>
                              <div class="info-user">';
         $divProfileUser.=     '<div class="name-user">'.$nombreUser.' '.$apellUser.'</div>
                                
                               </div>';
         $amigos = $userFound['amigos'];
         if(count($amigos) > 0){//si tiene 1 o muchos amigos
            $friends = $userFound['amigos'];
            $divProfileUser.=   '<div class="friends-user"> 
                                    <div class="tittle-friends"> 
                                            Amigos de '.$nombreUser.
                                    '</div>';
            foreach($friends as $item){
                $divProfileUser.=   '<div class="item-friends-user">
                                        <div class="item-friends-userpic"></div>
                                        <div class="item-friends-username">'.ucwords($item['nombre']).'</div>
                                    </div>';
            }
             $divProfileUser.=   '</div>';
         }else{
             $divProfileUser.=   '<div class="friends-user">Sé el primer amigo de '.ucwords($userFound['nombre']).'</div>';
         }
         
         $divProfileUser.= '</div>';
        
         
         
         
         $resp = array(
                        "divProfileUser"=>$divProfileUser
                       );
         
         echo json_encode($resp);
          
    }
//    if(isset($_POST['popup-user'])){
//    
//         session_start();
//         require_once '../DAL/connect.php';  
//         require_once '../DAL/usuario.php';
//         
//        
//    }

    
    if(isset($_POST['popup-registrousuario'])){
        $divPublicar = '<div class="content-publicarevent">
                                 <div class="item-publicarevent">
                                    <div class="title-publicarevent">Registrate para disfrutar de todos los eventos</div>
                                 </div>
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Nombre</div>
                                 <input class="field-publicarevent" type="text" id="nombre-usuario" name="nom-event"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Apellido</div>
                                 <input class="field-publicarevent" type="text" id="apellido-usuario" name="nom-event"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Correo</div>
                                 <input class="field-publicarevent" type="text" id="correo-usuario" name="nom-event"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Clave</div>
                                 <input class="field-publicarevent" type="password" id="clave-usuario" name="nom-event"/>
                                </div>
                                
                                    
                                
                                 <div class="item-publicarevent">
                                 
                                 <button id="btnSubmit" style="display: none;">Subir archivo</button>
                                  <input type="submit" id="guardarusuario" class="botonguardar" value="Guardar"/>
                                 </div>
                                <input type="hidden" class="Lat" name="lat"/>
                                <input type="hidden" class="Lng" name="lng"/>
                               </div>
                               
                                ';

          echo $divPublicar;
    }
    if(isset($_POST['popup-registroproductora'])){
        $divPublicar = '<div class="content-publicarevent">
                                 <div class="item-publicarevent">
                                    <div class="title-publicarevent">Registrate para publicar tus eventos</div>
                                 </div>
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Nombre</div>
                                 <input placeholder="Nombre de tu productora" class="field-publicarevent" type="text" id="nombre-usuario" name="nom-event"/>
                                </div>

                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Correo</div>
                                 <input placeholder="correo@dominio.cl" class="field-publicarevent" type="text" id="correo-usuario" name="nom-event"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Clave</div>
                                 <input class="field-publicarevent" type="password" id="clave-usuario" name="nom-event"/>
                                </div>
                                
                                    
                                
                                 <div class="item-publicarevent">
                                 
                                 <button id="btnSubmit" style="display: none;">Subir archivo</button>
                                  <input type="submit" id="guardarproductora" class="botonguardar" value="Guardar"/>
                                 </div>
                               </div>
                               
                                ';

          echo $divPublicar;
    }
    if(isset($_POST['popup-publicarevent'])){
                $divPublicar = '<div class="content-publicarevent">
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
                               
                                ';

          echo $divPublicar;
    }
    
    if(isset($_POST['popup-publicarest']))
    {
        $divPublicar = '<div class="content-publicarevent">
                                 <div class="item-publicarevent">
                                    <div class="title-publicarevent">Agregar establecimiento</div>
                                 </div>
                                 
                        
                                
                                <div class="item-publicarevent">
                                     <div class="nombre-publicarevent">Foto</div>
                                     <div class="foto-publicarevent"></div>
                                     <input type="file" id="images" name="images"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Nombre</div>
                                 <input class="field-publicarevent" type="text" id="nom-event" name="nom-event"/>
                                </div>
                                
                              <!-- <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Email</div>
                                 <input type="text" id="email-est" name="email-est"/>
                                </div> 
                                -->
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">¿Dónde?</div>
                                 <input placeholder="Ej: Calle #246, Comuna, Ciudad" type="text" id="addresEvent" name="addresEvent"/> </br>
                                 <div id="map_evento" style="width:250px; height:250px; display: none;"></div>
                                 <input type="button" id="comprobar-event" value="Comprobar"/>
                                </div>
                                
                                
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Telefono</div>
                                 <input placeholder="02-0265468" type="text" id="telefono-est" name="telefono-name"/>
                                </div>
                               
                                
                               
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Tags</div>
                                 <textarea placeholder="comidas entretencion"  rows="4" cols="50" id="tags-event" name="tags-event"></textarea>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">Descripción</div>
                                 <textarea rows="4" cols="50" id="descripcion-event" name="descripcion-event"></textarea>
                                </div>
                                
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">URL FB</div>
                                 <input type="text" id="url-face" name="url-face"/>
                                </div>
                                
                                <div class="item-publicarevent">
                                 <div class="nombre-publicarevent">URL Twitter</div>
                                 <input type="text" id="url-twitter" name="url-twitter"/>
                                </div>
                                
                                 <div class="item-publicarevent">
                                 
                                 <button id="btnSubmit" style="display: none;">Subir archivo</button>
                                  <input type="submit" class="botonguardar" id="guardarest" value="Guardar"/>
                                 </div>
                                <input type="hidden" class="Lat" name="lat"/>
                                <input type="hidden" class="Lng" name="lng"/>
                               </div>
                                ';

          echo $divPublicar;
    }
    
?>
