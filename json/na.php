<?php
if(isset($_POST['popup-user'])){
         session_start();
         require_once '../DAL/connect.php';  
         require_once '../DAL/usuario.php';                                     ///AGREGAR AMIGOS CHAO
         $apellUser = ucwords($userFound['apellido']);
         $buttonFriend = '<div id="send-req" class="button-friend">Seguir</div>';
         //si está logeado buscar las posibles solicitudes
         
         if(!empty($_SESSION['userid'])) //si está logeado
         {            //<div id="send-req" class="button-friend">'.$valueButton.'</div>
                $solicitante = $_SESSION['userid'];
                if($solicitante == new MongoId($idSolicitado)){//si me busco a mi mismo
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
?>
