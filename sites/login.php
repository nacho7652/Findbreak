
<div id="content-login">
    
   
    <?php  

        if(!isset($_SESSION["userid"]))
        {
    ?>
    
    Para publicar un evento debes logearte
    
    
    
                                    <input   type="text" placeholder="Correo electronico" id="mail2">
                                      <input type="password" placeholder="Contraseña" id="pass2">
                                      <a href="#" class="botonblue" id="boton-login2">Entrar</a>
                                       <a class="loginface-top" id="login-fb" href="<?php echo $loginUrl; ?>">
                                            <div id="loginbtn-fb"></div>
                                            <div class="txtfb">Ingresar con Facebook</div>
                                        </a>
    
    
                                      
                                    <?php 


        }
        else
        {
            header("location:/findbreak/publicar");
            
        }
?>
                                      
</div>