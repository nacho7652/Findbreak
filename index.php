<?php 
     define(UBICACION, 'nuevo');
     if(isset($_COOKIE["ubicacion"]) == 'si'){//si ya acepto
      define(UBICACION, 'antiguo');
      $styleTutorial = 'style="display:none"';
    }else{//debe mostrar el mensaje
      $styleTutorial = 'style="display:block"';
    }
    session_start();
    define(PATH, '/');
    //define(PATH, '/nowsup/');
    date_default_timezone_set("Chile/Continental");
    require_once 'function/place.php';
    require_once 'DAL/connect.php';
    require_once 'DAL/usuario.php';
    require_once 'DAL/evento.php';
    require_once 'DAL/comentario.php';
    require_once 'DAL/relacional/connect_relacional.php';
    require_once('function/recaptchalib.php');
    $publickey = "6LdvkeYSAAAAAHc8lhTvB8s8_NXUZTYhTohyLihE";
    $usuariorelacional = new usuarioRelacional();
//    include_once ('function/facebook-response.php');
    $contsol=0;
    
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
        
        <meta property="og:type" content="article">
<meta property="og:site_name" content="Nowsup">
<meta property="og:description" content="<?= $page_description?>">
<meta property="og:locale" content="es_ES">
<meta property="og:image" content="http://www.nowsup.com/images/favicon.png">
<meta name="language" content="es">
<meta name="Description" content="<?= $page_description?>">
<meta name="Keywords" content="nowsup, fiestas, entretención, carrete, eventos, salir, encontrar, red social">

        <link rel="shortcut icon" href="images/favicon.png">
        <link rel="apple-touch-icon" href="images/favicon.png">
        <title><?= $page_title ?></title>
        <meta name="description" content="<?= $page_description ?>">
        <link rel="stylesheet" href="css/movil.css"  type="text/css" media="handheld, only screen and (max-device-width: 480px)" />
        <link rel="stylesheet" href="css/stylebase.css" type="text/css" media="screen and (min-width: 481px)" >
<!--        <link rel="stylesheet" href="css/style.css">-->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/stylelanding.css">
        <link rel="stylesheet" href="css/style-encuesta.css">
        <link rel="stylesheet" type="text/css" href="css/datepick.css"> 
        
        <meta charset="utf-8">
        
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/datepick.js"></script>
         <script src="js/face.js"></script>
		<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-35265113-1']);
			_gaq.push(['_trackPageview']);
	
			 (function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

		</script>
    </head>
     
     <body>
         <!--para redes sociales-->
                    <?php 
                    if($page_site=='cerca')
                    {
                        
                    ?>
         <div class="content-redes-sociales">
             <div class="fix-face fix-redes"></div>
             <div class="fix-twitter fix-redes"></div>
             <div class="fix-google fix-redes"></div>
                    <div class="redes-sociales">
                                                       <div class="fb-like" data-href="http://www.nowsup.com" data-send="false" data-width="380" data-show-faces="true" data-font="arial" data-colorscheme="light"></div>

                                                      <!--<b cond='data:blog.pageType == &quot;item&quot;'>-->
                                                       <script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'> 
                                                       </script>
                                                       <a href='http://www.nowsup.com' name='fb_share' type='button_count' >Compartir</a>

                                                       <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.nowsup.com" data-hashtags="nowsup">Tweet</a>
                                                       <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                    <!--</b>-->
                                      <!--redes sociales-->
                                      <!-- Inserta esta etiqueta donde quieras que aparezca Botón +1. -->
                                        
                                      <div class="g-plusone" data-size="medium" data-annotation="none"></div>
                                        <!-- Inserta esta etiqueta después de la última etiqueta de Botón +1. -->
                                        <script type="text/javascript">
                                            window.___gcfg = {lang: 'es'};
                                            (function() {
                                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                            po.src = 'https://apis.google.com/js/plusone.js';
                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                            })();
                                        </script>
                                     
                    </div>
         </div>
         
                <?php } ?> 
        <div <?= $styleTutorial?> id="allbackground">
            
        </div>
        <div id="coverall">
            <div class="innercal">
                <div class="cerrar"></div>
                <div id="caloader">
                </div>
            </div>
        </div>
       <?php 
      
       //MENSAJES DE EVENTO
       $stiloMensaje = '';
       $mensajeEvento = '';
       
       if(isset($_REQUEST['evento-msj']) && $_REQUEST['evento-msj'] == 'success'){
            $stiloMensaje = 'style="display:block"';
            $mensajeEvento = 'Anuncio publicado con éxito :)';
       }
       if(isset($_REQUEST['evento-msj']) && $_REQUEST['evento-msj'] == 'success-upd'){
            $stiloMensaje = 'style="display:block"';
            $mensajeEvento = 'Anuncio modificado con éxito :)';
       }
       if(isset($_REQUEST['evento-msj']) && $_REQUEST['evento-msj'] == 'saldo'){
            $stiloMensaje = 'style="display:block"';
            $mensajeEvento = 'No tienes saldo suficiente, recarga tu cuenta
                
            <div>Opciones -> Cargar cuenta</div>    

            ';       
       }
       //FIN DE MENSAJES DE EVENTO
       
       //MENSAJES TRANSACCIÓN
       if(isset($_SESSION['valorDeCarga']) && $_SESSION['valorDeCarga']  != -1){
            if(isset($_REQUEST['tran-msj']) && $_REQUEST['tran-msj'] == 'tran-cancel'){
                 $stiloMensaje = 'style="display:block"';
                 $valorDeCarga = $_SESSION['valorDeCarga'];
                 
                 $mensajeEvento = 'Haz cargado en tu cuenta $'.$valorDeCarga;
                 $usuariorelacional->PagoCompraEvento($valorDeCarga, $_SESSION['userid']);
                 $_SESSION['valorDeCarga'] = -1;
            }
            if(isset($_REQUEST['tran-msj']) && $_REQUEST['tran-msj'] == 'tran-success'){
                 $stiloMensaje = 'style="display:block"';
                 $valorDeCarga = $_SESSION['valorDeCarga'];
                 $mensajeEvento = 'Haz cargado en tu cuaaaaenta $'.$valorDeCarga;
                 $_SESSION['valorDeCarga'] = -1;
            }
       }
       //FIN DE MENSAJES TRANSACCIÓN
        
        
?>
        <div id="covermsj" <?= $stiloMensaje?>>
            <div class="innermsj">
                <!--<div class="cerrar"></div>-->
                <div id="calmsj">
                    <?= $mensajeEvento?>
                   
                </div>
            </div>
        </div>
        <?php if($page_site != 'inicio'){?>
        <div id="top">
            <div id="content-top">
                <div class="top-left">
                    <?php if($page_site != 'cerca'){?>
                        <a href=<?= PATH?>mapa>
                            <div class="logoper"></div>
                            <div class="logo"></div>
                        </a>
                    <?php }?>
                </div>
                
                <div class="top-center">
                    
                    <!--<div id="hover-response">-->
                     <?php if($page_site != 'cerca'){?>
                        <div class="input-textparent1">
                            <input placeholder="Busca lo que quieras" type="text" id="search" class="input-transf">
                            <input id="boton-buscar" type="button" class="sprites" />
                        </div>
                    <?php }else{ ?>
                        <a href="http://www.nowsup.com/publicar" class=" boton-publicar">Publicar !</a>
                        
                    <?php }
                     ?>
                        <div id="response-friend" >
                                
                        </div>    
                    <!--</div>-->
                                               
                    
                </div>
                 <div class="top-right">
                                       
                            <?php
                            if($page_site != 'cerca'){//salga en todos los sites menos en cerca
                               echo '<a href="http://www.nowsup.com/publicar" class=" boton-publicar2">Publicar !</a>'; 
                            }else{//salga en el cerca
                                echo '<a href="#" class="explicacion-mapa explicacion-mapa-style">¿Cómo funciona Nowsup?</a>';
                            }
                            if(isset($_SESSION['userprofile']) != null){//apreté el boton y se creo mi usuario
                                $us = new usuario();
                                $user_profile = $_SESSION['userprofile'];
                                $comp = $us->loginFace($user_profile['email']);
                               
                                if($comp!=null)
                                {
                                   
                                   $_SESSION['userid'] = $comp['_id'];
                                   $_SESSION['username'] = $comp['username'];
                                   $_SESSION['nombre'] = $comp['nombre'];
                                   if($comp['foto'] == PATH.'images/user-default.png')
                                   {
                                      $us->updatePhoto($comp['_id'], $user_profile['picture']);
                                      $_SESSION['foto']=$user_profile['picture'];
                                      
                                   }
                                   else
                                   {
                                       $_SESSION['foto'] = $comp['foto'];
                                   }
                                   $_SESSION['usertype'] = 1;
                                }else{
                                  
                                   $hola = $us->insertarFB($user_profile['name'], $user_profile['email'], '',$user_profile['picture'],$user_profile['username']);
                                   $_SESSION['userid'] = $hola['_id'];
                                   $_SESSION['username'] = $hola['username'];
                                   $_SESSION['nombre'] = $hola['nombre'];
                                   $_SESSION['foto'] = $hola['foto'];
                                   $_SESSION['usertype'] = 1;
                                  
                                }
                            }

                           
                            if(empty($_SESSION['userid'])){?>
                               <div id="login">

                                   <a href="" class="login-hover">
                                       Iniciar sesion
                                   </a>
                                   <div class="login-cont cualquierDiv"> 
                                      <input   type="text" placeholder="Correo electronico" id="mail">
                                      <input type="password" placeholder="Contraseña" id="pass">
                                      <a href="#" class="botonblue" id="boton-login">Entrar</a>
                                      
                                       <a class="loginface-top login-face login-fb"  href="#<?php //echo $loginUrl; ?>">
                                            <div id="loginbtn-fb"></div>
                                            <div class="txtfb">Ingresar con Facebook</div>
                                        </a>
                                      <a href="#" id="forgot-pass" class="popup-forgot">¿ Olvidó su contraseña ?</a>
                                      <!--<fb:login-button show-faces="false" width="200" max-rows="1"></fb:login-button>-->
                                   </div>
                                   <?php 
                                   
//                                   if(isset($user_profile) != null){
//                                       echo $user_profile['email'];
//                                       
//                                       } ?> 
                                   <a href="#" class="registrate popup-registrate">Registrate</a>
                                   <a href="#" class="productora-registro">¿Deseas publicar?</a>
                               </div>
                 
                               <?php }else{//ESTA LOGEADO?>

                               <div id="user-login"> 
                                   

                                   
                                   <?php //echo $user_profile;
                                         $usertype = $_SESSION['usertype'];
                                         if($usertype == 1){
                                             $usuario = new usuario();
                                             
                                             $notificaciones = $usuario->verNotificaciones($_SESSION['userid']);
                                             //$re = $usuario->unirNotificaciones($menciones, $seguiArr, null);
                                            // echo count($seguiArr);
                                            // echo count((array)$menciones);
                                             
                                             $comentarioEvent = new comentario();
                                             $evento = new evento();
//                                             $solicitud = $usuario->VerSolicitudes($_SESSION['userid']);
                                             $divMenciones = '';
                                            
                                             foreach($notificaciones as $not)
                                             {  
//                                                 print_r($not);
                                                 $clase = '';
                                                 if($not['estado'] == 0){
                                                     $clase = 'norevi';
                                                     $contsol++;
                                                 }
                                                 if($not['tipo'] == 1){
                                                        $realizacion = $comentarioEvent->verFecha($not['fechaMuestra']);
                                                        $user = $usuario->findforid($not['quien']);
                                                       
                                                        //ver nombre(s) y foto(s) de los eventos mencionados
                                                        
                                                        if($not['idEventos'] != null){//si mencionó evento
                                                            $fotosNombres = $evento->verEventosMencionados($not['idEventos']);
                                                            $divMenciones.='<div id="'.$not['_id'].'" class="'.$clase.' item-solicitud-friend not1"> 
                                                                               <div style="background-image:url('.$user['foto']['pe'].')" class="item-friends-userpic"></div>
                                                                               <div class="item-friends-msj">
                                                                                   <div class="item-friends-username tit-gray">'.$user['nombre'].'</div>';
                                                                                   if(count($not['idEventos']) == 1){
                                                                                       $divMenciones.='<span class="msjmencion">te ha mencionado en el evento</span>';
                                                                                   }  else {
                                                                                       $divMenciones.='<span class="msjmencion">te ha mencionado en los eventos</span>';   
                                                                                   }
                                                                           $divMenciones.='
                                                                                   <span class="tit-gray msjmencion msjeventonom">'.$fotosNombres['nombre'].' </span>
                                                                               </div>
                                                                               <div class="item-friends-eventpic">
                                                                                '.$fotosNombres['fotos'].'
                                                                               </div>
                                                                               <div class="bloq3">
                                                                                   <div class="hacecuant">'.$realizacion.'</div>
                                                                               </div>
                                                                               ';

                                                            $divMenciones.=   '</div>';
                                                        }else{
                                                            
                                                            $divMenciones.='<div id="'.$not['_id'].'" class="'.$clase.' item-solicitud-friend not1"> 
                                                                               <div style="background-image:url('.$user['foto'].')" class="item-friends-userpic"></div>
                                                                               <div class="item-friends-msj">
                                                                                   <div class="item-friends-username tit-gray">'.$user['nombre'].'</div>
                                                                                   <span class="msjmencion">te ha mencionado en un comentario</span>
                                                                                   
                                                                               </div>
                                                                               
                                                                               <div class="bloq3">
                                                                                   <div class="hacecuant">'.$realizacion.'</div>
                                                                               </div>
                                                                               ';

                                                            $divMenciones.=   '</div>';
                                                        }
                                                 } 
                                                 if($not['tipo'] == 2){
                                                        $realizacion = $comentarioEvent->verFecha($not['fechaMuestra']);
                                                        $user = $usuario->findforid($not['quien']);
                                                        $divMenciones.='<div id="'.$not['_id'].'" class="'.$clase.' item-solicitud-friend not2 item-search-friend"> 
                                                                           <div style="background-image:url('.$user['foto']['pe'].')" class="item-friends-userpic"></div>
                                                                           <div class="item-friends-msj">
                                                                               <div class="item-friends-username tit-gray">'.$user['nombre'].'</div>
                                                                               <span class="msjmencion">te ha seguido.</span>
                                                                               
                                                                           </div>
                                                                           
                                                                           <div class="bloq3">
                                                                               <div class="hacecuant">'.$realizacion.'</div>
                                                                           </div>
                                                                           <div style="display:none" class="id-item-search">'.$user['_id'].'</div>
                                                                           ';

                                                        $divMenciones.=   '</div>';
                                                 }   
                                                 if($not['tipo'] == 3){
                                                        $realizacion = $comentarioEvent->verFecha($not['fechaMuestra']);
                                                        $user = $usuario->findforid($not['aquien']);
                                                        //$evento = $evento->findforid($not['evento']['_id']);
                                                        $url = $evento->verFoto($not['evento']);
                                                        $hashevent = $evento->verUrl($not['evento']);
                                                        $nombreevent = $evento->verNombre($not['evento']);
                                                        $divMenciones.='<a href="'.PATH.'break/'.$hashevent['hash'].'" id="'.$not['_id'].'" class="'.$clase.' item-solicitud-friend item-search-friend"> 
                                                                           <div style="background-image:url('.$user['foto']['pe'].')" class="item-friends-userpic"></div>
                                                                  
                                                                            
                                                                            <div class="item-friends-msj">
                                                                                   <div class="item-friends-username tit-gray">'.$user['nombre'].'</div>
                                                                                   <span class="msjmencion">!FELICITACIONES! Tu evento: </span>
                                                                                   <span class="tit-gray msjmencion msjeventonom">'.$nombreevent['nombre'].' </span>
                                                                                   <span class="msjmencion">Llegó a '.$not['visitas'].' visitas !, se han cargado <span class="tit-gray">$1.000 en tu cuenta :)</span></span>
                                                                               </div>
                                                                               <div class="item-friends-eventpic">
                                                                                <div style="background-image:url('.$url.')" class="itemfoto-eve"></div>
                                                                               </div>
                                                                           <div class="bloq3">
                                                                               <div class="hacecuant">'.$realizacion.'</div>
                                                                           </div>
                                                                           <div style="display:none" class="id-item-search">'.$user['_id'].'</div>
                                                                           ';

                                                        $divMenciones.=   '</a>';
                                                 } 
                                                 if($not['tipo'] == 4){
                                                        $realizacion = $comentarioEvent->verFecha($not['fechaMuestra']);
                                                        $user = $usuario->findforid($not['aquien']);
                                                        //si estamos en el mapa
                                                        $claseNoti = '';
                                                        if($page_site == 'cerca'){
                                                            $claseNoti = 'explicacion-mapa';
                                                        }
                                                        $divMenciones.='<div id="'.$not['_id'].'" class="'.$clase.' not4 '.$claseNoti.' item-solicitud-friend item-search-friend"> 
                                                                           <div style="background-image:url('.$user['foto']['pe'].')" class="item-friends-userpic"></div>
                                                                  
                                                                            
                                                                            <div class="item-friends-msj">
                                                                                   <div class="item-friends-username tit-gray">'.ucwords($user['nombre']).'</div>
                                                                                   <span class="msjmencion tit-gray">!Bienvenido a Nowsup :)! </span>
                                                                                   <span class="tit-gray msjmencion msjeventonom">haz click aquí para empezar</span>
                                                                               </div>
                                                                               
                                                                           <div class="bloq3">
                                                                               <div class="hacecuant">'.$realizacion.'</div>
                                                                           </div>
                                                                           <div style="display:none" class="id-item-search">'.$user['_id'].'</div>
                                                                           ';

                                                        $divMenciones.=   '</div>';
                                                 } 
                                                 
                                                 
                                             }
//                                             if($contsol == 0){
//                                                     $divMenciones = '<div class="nohaycoinci"> No tienes notificaciones :)</div>';
//                                             }
                                          
                                   ?>
                                        
                                       
                                  
                                      
                                        <div class="option noti-friend sprites">
                                            <div class="content-option ">
                                                <?php if($contsol > 0){?>
                                                    <span id="cant-solicitud">
                                                          <?= $contsol?>
                                                    </span>
                                                <?php }?>
                                            </div>
                                            
                                        </div>
                                        <div id="show-solicitud" class="boxscroll" style="display:none">
                                                
                                                <?php echo $divMenciones ?> 
                                        </div>
<!--                                        <div class="option publicar-est">
                                            <div class="content-option ">
                                                + est
                                            </div>
                                            
                                        </div>-->
<!--                                        <div class="option content-option-last cerrar">
                                            <form action="#" method="POST">
                                              <input type="submit" name="cerrarsession" value="-C" class="content-option "/>
                                            </form>
                                         </div>-->
                                         <a href="<?= PATH?>mapa"  class="option ">
                                            <div id="optionhome"  class="content-option">
                                                Mapa
                                            </div>
                                        </a>

                                        <a href="<?= PATH?>!<?php echo $_SESSION['username']?>" class="option user-name" >
                                             <div class="content-option">
                                                 <?php echo $_SESSION['username'] ?>
                                             </div>
                                        </a>
                                         <a style="background: url('<?php echo $_SESSION['foto']['pe']?>') no-repeat" href="<?= PATH?>!<?php echo $_SESSION['username']?>" class="option user-photo">
                                 
                                        </a>

                                         <div class="option  menu">
                                            <div class="content-option content-option-last sprites">
                                                
                                            </div>
                                        </div>
                                         
                                        <div class="groupoption">
                                                <a class="itemgroup-option itemgroup-option last" href="<?= PATH?>publicar">Publicar !</a>
                                                <a href="<?= PATH?>editar-user/!<?=$_SESSION['username']?>"id="editar-info" class="itemgroup-option last">
                                                    Editar mi perfil
                                                </a>
<!--                                                <div class="itemgroup-option itemgroup-option last">
                                                  Saldo:<?php 
                                                  
                                               //   echo $usuariorelacional->ValidarSaldo($_SESSION['userid']);
                                                  
                                                  ?>
                                                </div>-->
<!--                                                <div id="cargar-cuenta" class="itemgroup-option last">
                                                    Cargar cuenta
                                                    <?php 
//                                                        if(isset($_POST['price']) != null && is_numeric($_POST['price'])){//si llega la plata
//                                                              $_SESSION['valorDeCarga'] =  $_REQUEST['price'];  
//                                                               //echo $_SESSION['valorDeCarga'];
//                                                               header('location:https://www.mercadopago.com/mlc/buybutton?acc_id=6030853&url_cancel="http://localhost/findbreak/cerca/tran-cancel?item_id=222&name=CARGAR CUENTA FINDBREAK&currency=CHI&url_process=http://localhost/findbreak/cerca&url_succesfull=http://localhost/findbreak/!'.$_SESSION['username'].'/tran-success&url_post=1&shipping_cost=&enc=NJKVVWpx1581SmPvti51BuYh8dU%3D&extraPar=&price='.$_REQUEST['price']);
//                                                        }
                                                        
                                                    ?>
                                                    <form id="mercagoPago" action="/findbreak/cerca" method="POST">
                                                        Monto debe ser mayor a 950: <input type="text" name="price" id="price"> 
                                    
                                                    </form>
                                                </div>-->
                                                <a href="<?= PATH?>publicaciones" id="mis-publicaciones" class="itemgroup-option last">
                                                    Mis publicaciones
                                                </a>
                                                <div id="boton-logout" class="itemgroup-option last">
                                                    Salir
                                                </div>
                   
                                        </div> 
                                   
                                   
                                   <?php }if($usertype == 2){?>

                                       
                                   <?php }?>
                               </div>
                               <?php } ?>
                     
<!--                     <div id="info-publicar" class="botongreen"> 
                         Publicar
                     </div>-->
                     <div id="info-mostrar" style="display:none">  
                         <div class="content-infomostrar">
                             Publica un evento y obtén todos los beneficios que te bindra Nowsup
                             
                         </div>
                         <div class="option-infomostrar">
                                <?php 

                                    if(isset($_SESSION["userid"])) //estoy logeado
                                    {
                                       ?> <a href="<?= PATH?>publicar" >click aquí</a> <?php
                                    }
                                    else
                                    {                          
                                 ?>
            <!--                        <a href="/findbreak/login" >regístrate / login</a>-->
                                        <a class="login-hover login-msj" href="#">Iniciar sesión</a> / 
                                        <a class="registrate registro-msj" href="#">Regístrate</a>
                                        
                                    <?php
                                    }
                                    ?>
                         </div>
                     </div>
                 </div>
                
              
                
        </div><!--content top-->
        
       </div><!-- top-->
       <?php }?>
       
        
           <?php if($page_site != 'cerca' && $page_site != 'inicio'){?>
                <div class="menutop">
                    <div class="btnslide"></div>
                </div>
           <?php } ?>
            
        <div id="body" <?= $page_class ?>>
            
            
             
            
           
           
            
            <div  <?= $page_class_near ?>>
                 <?php include_once('sites/'.$page_site.'.php'); ?>
            </div>
            <?php if($page_site == "landing"){ ?>
                <div class="info-landing">
                    <div class="content-infolanding">
                            <div class="button-usuario button-rol">
                                <div id="text-usuario" class="text-rol">¿Quieres salir? </div>
                                <div id="fondouser" ></div>
                                
                            </div>
                            <div class="button-productora button-rol">
                                 <div id="text-productora" class="text-rol">¿Cómo publicar?</div>
                                 <div id="fondoproductora"></div>
                                
                            </div>
                            <div class="button-proveedor button-rol">
                                <div id="text-proveedor" class="text-rol">¿Encontrar trabajo?</div>
                                <div id="fondoproveedor" ></div>
                                
                            </div>
                            <div class="button-establecimiento button-rol">
                                <div id="text-establecimiento" class="text-rol">¿Qué lugares hay?</div>
                                <div id="fondoestablecimiento"></div>
                                
                            </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if($page_site != 'cerca'){?>
            <footer id="bottom">
<!--                <p class="textbottom">
                    Estudiantes de Inacap Desarrolladores del proyecto Findbreak - Fonos: 652 213 55 / 541 67 51 / 546 28 51 -
                    <span class="emailbottom">info@findbreak.com</span>
                </p>-->
            </footer>
       <?php } ?>
         <script src="js/jquery.nicescroll.min.js"></script>
         <script type="text/javascript" src="js/upload.js"></script>
         <script type="text/javascript" src="js/script.js"></script>
         <script type="text/javascript" src="js/autoresize.js"></script>
         <script type="text/javascript" src="js/menciones.js"></script>
        <script type="text/javascript" src="js/publicar_evento.js"></script>
        
        <script>
            $(document).ready(function() {

                  //var nice = $("html").niceScroll();  // The document page (body)
//             $('body .boxscroll').on({
//                    click: function() {
//                      event.preventDefault();
//                      console.log('item clicked');
//                    },
//                    mouseenter: function() {
//                      console.log('enter!');
//                    }
//             });
//             $('body').delegate('.boxscroll','',function(){
//                 
//             })

                    //esta es la funcion normal
                       $(".boxscroll").niceScroll({cursorborder:"rgba(185, 184, 184, 0.83)",cursorcolor:"rgba(185, 184, 184, 0.83)",boxzoom:false, cursorwidth:9}).cursor.css({"right":"3px"}); // MAC like scrollbar; // First scrollable DIV
                 
              // Customizable cursor
              // $("#boxscroll").niceScroll({touchbehavior:false,cursorcolor:"#00F",cursoropacitymax:0.7,cursorwidth:11,cursorborder:"1px solid #2848BE",cursorborderradius:"8px"}).cursor.css({"background-image":"url(img/mac6scroll.png)"}); // MAC like scrollbar

          //    $("#boxscroll").niceScroll("#contentscroll2",{cursorcolor:"#F00",cursoropacitymax:0.7,boxzoom:true,touchbehavior:true});  // Second scrollable DIV
          //    $("#boxframe").niceScroll("#boxscroll3",{cursorcolor:"#0F0",cursoropacitymax:0.7,boxzoom:true});  // This is an IFrame (iPad compatible)
          //	
          //    $("#boxscroll4").niceScroll("#boxscroll4 .wrapper",{boxzoom:true});  // hw acceleration enabled when using wrapper

            });
          </script>

<!--         <script type="text/javascript" src="js/jquery.cycle.all.latest.js"></script>
          <script type="text/javascript">
            $(document).ready(function() {
                $('.slideshow').cycle({
                            fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
                    });
            });
        </script>-->
        
    </body>
    <script type="text/javascript">
//        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
//        var disqus_shortname = 'findbreak'; // required: replace example with your forum shortname
//
//        /* * * DON'T EDIT BELOW THIS LINE * * */
//        (function () {
//            var s = document.createElement('script'); s.async = true;
//            s.type = 'text/javascript';
//            s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
//            (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
//        }());
     </script>
    
     
</html>
