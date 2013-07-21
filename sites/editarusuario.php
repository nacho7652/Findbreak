
<?php  

        if(isset($_SESSION["userid"]))
        {
        $partid = explode('!', $_GET['id']);
        $usernameUrl = $partid[1];
        $username = $usernameUrl;
        $usuariofound = new usuario();
        
        $usuario = $usuariofound->findforusername($username);
        
?>
<form id="editarusuario-form" method="POST" action="/findbreak/uploadevento" name="formulariousuario" enctype="multipart/form-data">
<input type="hidden" name="editarusuario" />
<div class="content-publicarevent">
                                 <div class="item-publicar">
                                    <div class="title-publicarevent">Edita información de tu perfil</div>
                                 </div>
                                <div class="item-publicar item-publicar-small">
                                     
<!--                                     <input type="file" id="images" name="images[]"/>
-->                                     <div class="foto-publicaruser">
                                            <?php 
                                                      $url = $usuario['foto']['gr'];  
                                                ?>
                                                   <div  style="background-image: url(<?= $url ?>); background-size:cover; background-position: 0px 0px;" class="coverfile-galerias" >
                                                        <input type="file" id="fotousuario" name="fotousuario" class="fotonoticia-galerias" />
                     
                                                   </div>
                                       </div>
                                </div>
                                <div class="item-publicar item-publicar-medium">
                                    <div class="item-editaruser">
                                        <input value="<?= $usuario['nombre']?>" id="nombreuser" name="nombreuser" type="text" class="input-edituser obligatorio"/>
                                         <div class="mensaje-error error-obligatorio">
                                            <div class="content-mensaje">* Debes ingresar el nombre</div>
                                        </div>
                                    </div>
                                    <div class="item-editaruser">
                                        <input value="<?= $usuario['username']?>" id="user-name" name="username" type="text" class="input-edituser obligatorio"/>
                                        <div class="mensaje-error error-username"></div>
                                    <div class="username-corr"></div>
                                    <div class="username-incorr"></div>
                                    <div class="mensaje-error error-obligatorio">
                                            <div class="content-mensaje">* Debes ingresar el username</div>
                                    </div>
                                    </div>
                                    <div class="item-editaruser">
                                        <input value="<?= $usuario['email']?>" id="email" name="email" type="text" class="input-edituser obligatorio"/>
                                        <div class="mensaje-error error-obligatorio">
                                            <div class="content-mensaje">* Debes ingresar el mail</div>
                                        </div>
                                    </div>
                                    <div class="bloq-special">
                                      <?php if($usuario['user_face'] == 1 && $usuario['clave'] != ''){?>
                                            <div class="nombre-publicarevent">Crea una contraseña para que ingreses con tu correo</div>
                                            <div class="item-editaruser">
                                                <input id="clave-nueva1-fb" placeholder="Nueva contraseña" type="password" class="input-edituser"/>
                                            </div>
                                            <div class="item-editaruser">
                                                <input id="clave-nueva2-fb" placeholder="Repetición de la nueva contraseña" type="password" class="input-edituser"/>
                                            </div>
    <!--                                        <div class="item-editaruser">
                                                <input type="button" class="botonblue" id="modificarclave" value="Guardar contraseña"/>
                                            </div>-->
                                        <?php }else{?>
                                                <div class="nombre-publicarevent">Cambia tu contraseña</div>
                                               <div class="item-editaruser">
                                                   <input id="clave-actual" placeholder="Contraseña actual" type="password" class="input-edituser"/>
                                               </div>
                                               <div class="item-editaruser">
                                                   <input id="clave-nueva1" placeholder="Nueva contraseña" type="password" class="input-edituser"/>
                                               </div>
                                               <div class="item-editaruser">
                                                   <input id="clave-nueva2" placeholder="Repetición de la nueva contraseña" type="password" class="input-edituser"/>
                                               </div>
       <!--                                        <div class="item-editaruser">
                                                   <input type="button" class="botonblue" id="modificarclave" value="Guardar contraseña"/>
                                               </div>-->
                                        <?php }?>
                                    </div>
                                </div>
                                
                                
                                 <div class="item-publicar">
                                 
                                  
                                  <input type="button" class="botongreen" id="editaruser" value="Guardar cambios"/>
                                 </div>
                             
      </div>
</form>
<?php 


        }
        else
        {
            header("location:/findbreak/login");
            
        }
?>