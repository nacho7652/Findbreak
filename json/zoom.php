<?php
 
    if(isset($_REQUEST['noti-compra'])){
         session_start();
         require_once '../DAL/connect.php';  
         require_once '../DAL/usuario.php';
         require_once '../DAL/usuarioRelacional.php';
         require_once '../DAL/comentario.php';
         $idNoti = $_REQUEST['id'];
         $usuario = new comentario();
         $not3 =$usuario->findNotificacionForId($idNoti);
         $quiencompro = $not3['quien'];
         $sesion = $not3['aquien'];
         $evento = $not3['evento']['_id'];
         $ur = new usuarioRelacional();
         $valorEventoComprado = $ur->VerPrecioEventoMasCaroPorUsuario_evento($quiencompro, $evento);
         
         
         
        
        
         echo $valorEventoComprado;
        // print_r($usuario->comprobarSiLoSigo($solicitante, $idSolicitado));
    }
    if(isset($_REQUEST['popup-user'])){
         session_start();
         require_once '../DAL/connect.php';  
         require_once '../DAL/usuario.php';                                     ///AGREGAR AMIGOS CHAO
         
         $buttonFriend = '<div id="seguiramigo" class="botoncancel">Seguir</div>';
         $usuario = new usuario();
         //si está logeado buscar las posibles solicitudes
         $idSolicitado = $_REQUEST['idSolicitado'];
         if(!empty($_SESSION['userid'])) //si está logeado
         {           
                $solicitante = $_SESSION['userid'];
                if($solicitante == new MongoId($idSolicitado))
                {//si me busco a mi mismo
                    $buttonFriend = '';//no quiero que aparesca el boton de amigos
                }else{//si busco a otra persona
                        $usuarioSig = $usuario->comprobarSiLoSigo($solicitante, $idSolicitado);
                        if(isset($usuarioSig['_id'])){ //lo sigo
                             $buttonFriend = '<div id="desseguiramigo" class="botongreen">Siguiendo</div>'; 
                        }
                      // $buttonFriend = '<div id="send-req" class="button-friend">'.$valueButton.'</div>';
                }
         }else{//no esta logeado
                        $buttonFriend = '<div id="logeate-friend" class="botongreen">Inicia sesión</div>';
         }
         $usuariofound = $usuario->findforid($idSolicitado);
         $cantidadComentariosUser = $usuario->verCantidadComentarios($idSolicitado);
         $seguidores = 0;
         $siguiendo = 0;
         if(isset($usuariofound['seguidores']))
             $seguidores = count($usuariofound['seguidores']);
         
         if(isset($usuariofound['siguiendo']))
             $siguiendo = count($usuariofound['siguiendo']);
         
         $fotoUsuario = $usuariofound['foto']['pe'];
         $publicaciones = $usuario->verCantidadPublicaciones($idSolicitado);
         $divProfileUser = '<div class="profileuser">';
         $divProfileUser.=   '<div class="left-user">
                                <div style="background: url('.$fotoUsuario.'); background-size: cover" class="pic-user"></div>
                                '.$buttonFriend.'
                              </div>
                              <div class="info-user">';
         $divProfileUser.=     '
                                <div class="bloque-info info-event-item">
                                            <a href="/findbreak/!'.$usuariofound['username'].'" class="title-user tit-gray">'.ucwords($usuariofound['nombre']).'</a>
                                            <div class="username">'.$usuariofound['username'].'</div>
                                            <div class="info-num">
                                                  <div class="item-info-num">
                                                      <div class="topinfo">Comentarios</div>
                                                      <div id="totalComent" class="num-topinfo">'.$cantidadComentariosUser.'</div>
                                                  </div>
                                                  <div class="item-info-num">
                                                      <div class="topinfo">Seguidores</div>
                                                      <div class="num-topinfo">'.
                                                        $seguidores                          
                                                      .'</div>
                                                  </div>
                                                  <div class="item-info-num">
                                                      <div class="topinfo">Siguiendo</div>
                                                      <div class="num-topinfo">'.
                                                        $siguiendo                                  
                                                      .'</div>
                                                  </div>
                                                  <div class="item-info-num item-info-num2">
                                                      <div class="topinfo">Publicaciones</div>
                                                      <div class="num-topinfo">'.
                                                          $publicaciones                        
                                                      .'</div>
                                                  </div>
                                            </div>
                                            
                                        </div>
                               </div>';
//         if(isset($usuariofound['seguidores']) && count($usuariofound['seguidores']) > 0){//si tiene 1 o muchos seguidores
//            $seguidores = $usuariofound['seguidores'];
//            $divProfileUser.=   '<div class="friends-user"> 
//                                    <div class="tittle-friends"> 
//                                            Seguidores de '.$usuariofound['nombre'].
//                                    '</div>';
//            foreach($seguidores as $item){
//                $divProfileUser.=   '<div data-id="'.$item['_id'].'" class="item-friends-user">
//                                        <div style="background-image:url('.$item['foto'].')" class="item-friends-userpic"></div>
//                                        <a href="/findbreak/!#'.$item['_id'].'" class="item-friends-username">'.ucwords($item['nombre']).'</a>
//                                    </div>';
//            }
//             $divProfileUser.=   '</div>';
//         }else{
//             $divProfileUser.=   '<div class="friends-user">
//                                        <div class="mjscoment"> '.ucwords($usuariofound['nombre']).' aún no posee seguidores</div>
//                                  </div>';
//         }
         
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

    if(isset($_REQUEST['forgot-usuario'])){
        $pop = '<div class="content-registro">
                    <div class="item-publicarevent-titulo">
                          <div class="title-publicar"><div class="logo"></div></div>
                    </div>
                   <div class="item-publicar item-olvidoClave">
                      <div class="nombre-publicarevent">Escribe tu correo electrónico o nombre de usuario</div>
                      
                      <input placeholder="tucorreo@nowsup.com o nombredeusuario" class="field-publicar" type="text" id="correo-username"/>
                     
                   </div>
                   <div class="item-publicarevent-large item-botonregistro">
                  
                   <input type="submit" id="forgot-usuario" class="botongreen" value="Enviar clave a mi correo"/>
                 </div>
              </div>';
        echo $pop;
    }
    if(isset($_POST['popup-registrousuario'])){
        $divPublicar = '<div class="content-registro">
                                <div class="item-publicarevent-titulo">
                                    <div class="title-publicar"><div class="logo"></div></div>
                                 </div>
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Nombre completo</div>
                                 <input placeholder="Bastian Nicolas Toro" class="field-publicar" type="text" id="nombre-usuario" />
                                </div>
                                
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Dirección de correo electrónico</div>
                                 <input placeholder="ejemplo@findbreak.com" class="field-publicar" type="text" id="correo-usuario"/>
                                </div>
                                
                                <div class="item-publicar">
                                 <div class="nombre-publicarevent">Crea una contraseña</div>
                                 <input placeholder="******" class="field-publicar" type="password" id="clave-usuario" />
                                </div>
                                
                                <div class="item-publicar">
                                    <div class="nombre-publicarevent">Escoge tu nombre de usuario</div>
                                    <input placeholder="bastian.toro24" class="field-publicar" type="text" id="user-name"/>
                                    <div class="mensaje-error error-username"></div>
                                    <div class="username-corr"></div>
                                    <div class="username-incorr"></div>
                                </div>
                                
                                    
                                
                                 <div class="item-publicarevent-large item-botonregistro">
                                   <div class="todosloscampos mensaje-error">
                                      <div class="content-mensaje">
                                        
                                      </div>
                                   </div>
                                 
                                   <input type="submit" id="guardarusuario" class="botongreen" value="Regístrate"/>
                                 </div>
                                 
                                 <div class="item-publicarevent-large">
                                    <div class="oface txtini-blue">ó</div>
                                    <a class="loginface-top login-face login-fb"  href="#">
                                            <div id="loginbtn-fb"></div>
                                            <div class="txtfb">Regístrate con Facebook</div>
                                    </a>
                                 </div>
                                 
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
