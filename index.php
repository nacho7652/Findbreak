<?php 
    session_start();
    date_default_timezone_set("Chile/Continental");
    require_once 'function/place.php';
    require_once 'DAL/connect.php';
    require_once 'DAL/usuario.php';
    require_once 'DAL/comentario.php';
//    include_once ('function/facebook-response.php');
    $contsol=0;
    
    $agregarEvento = 1;
    if($agregarEvento == 0){
            require_once 'DAL/evento.php';
            $idproductora = '238928932389892';
            $nombreproductora = 'Nombre de prueba';
            $nom = 'Boster en chile 2013';
            $dir = 'Santa Sofia #2092';
            $arrayfotos = 'foto1.jps, foto2.jpg';
            $fec = '2013-06-20, 2013-06-21, 2014-06-22';
            $hor = '22:00:00, 23:15:00';
            $hor = explode(',', $hor);
            $fechString = $fec;   
            $fechas = explode(',', $fec);  
            $fechMongo = array();
            for($i=0; $i<count($fechas); $i++){
                $fechMongo[] = new MongoDate(strtotime($fechas[$i])); 
            }
            $tag = 'quilicura carrete';
            $lat = '-33.342376';
            $lng = '-70.847788';
            $desc = '$ 5.000.- por persona';
            $urltwitter = 'tw';
            $urlfacebook = 'face';  
            //nuevo
            $video = 'link de youtube';  
            $establecimiento = array('id'=>'232323',
                                     'nombre'=>'Estadio Nacional',
                                     'direccion'=>'Avenida vicuña #32');
            $precio = 'Gratis';
            $puntosDeVenta = array( array('id'=>'232323',
                                          'nombre'=>'Ticket Master',
                                          'web'=>'http://www.google.cl'),
                                    array('id'=>'232323',
                                          'nombre'=>'Ticket Master',
                                          'web'=>'http://www.google.cl')
                                   );
            $sitioWeb = 'web oficial del evento';
            $dondeComprar = 'En las boleterias del estadio nacional';
            
            $evento = new evento();                      
            echo $evento->insertar($idproductora, $nombreproductora, $nom, $dir, $arrayfotos, $fechString, $fechMongo,$hor, $tag, $lat, $lng, $desc,$urlfacebook,$urltwitter,
                                   $video, $establecimiento, $precio, $puntosDeVenta, $sitioWeb, $dondeComprar);
    }
//    if(isset($_POST['cerrarsession'])){
//        session_destroy();
//        header("location:../home/");
//    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="images/icon.png">
        <link rel="apple-touch-icon" href="images/icon.png">
        <title><?= $page_title ?></title>
        <meta name="description" content="<?= $page_description ?>">
        <link rel="stylesheet" href="css/stylebase.css">
<!--        <link rel="stylesheet" href="css/style.css">-->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/stylelanding.css">
        <link rel="stylesheet" href="css/style-encuesta.css">
        <meta charset="utf-8">
        
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
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
 
        
        <div id="allbackground">
            
        </div>
        <div id="coverall">
            <div class="innercal">
                <div class="cerrar"></div>
                <div id="caloader">
                </div>
            </div>
        </div>
        <div id="covermsj">
            <div class="innermsj">
                <!--<div class="cerrar"></div>-->
                <div id="calmsj">
                    
                </div>
            </div>
        </div>
        <?php if($page_site != 'inicio'){?>
        <div id="top">
            <div id="content-top">
                <div class="top-left">
                    <a href="/findbreak/inicio">
                        <div class="logoper"></div>
                        <div class="logo"></div>
                    </a>
                </div>
                
                <div class="top-center">
                    <!--<div id="hover-response">-->
                        <div class="input-textparent1">
                            <input value="Fiestas, deportes, arte, etc." type="text" id="search" class="input-transf">
                            <input id="boton-buscar" type="button" class="sprites" />
                        </div>
                        <div id="response-friend" >

                        </div>
                    <!--</div>-->
                </div>
                 <?php
                            ?>
                 <div class="top-right">
                            <?php
                            include_once ('function/facebook-response.php'); 
                            if(isset($user_profile) != null){//apreté el boton y se creo mi usuario
                                $us = new usuario();
                                $comp = $us->loginFace($user_profile['email']);
                                if($comp!=null)
                                {
                                   $_SESSION['userid'] = $comp['_id'];
                                   $_SESSION['username'] = $comp['nombre'];
                                  // $_SESSION['foto'] = $comp['foto'];
                                   $_SESSION['usertype'] = 1;
                                   $userid = $_SESSION['userid'];
                                   $username = $_SESSION['username'];
                                   $foto = $_SESSION['foto'];
                                   $usertype = $_SESSION['usertype'];
                                }
                                else
                                {
                                   $hola = $us->insertar($user_profile['email'], $user_profile['email'], $user_profile['email'], '','https://graph.facebook.com/'.$user.'/picture');
                                   $_SESSION['userid'] = $hola['_id'];
                                   $_SESSION['username'] = $hola['nombre'];
                                   $_SESSION['foto'] = $hola['foto'];
                                   $_SESSION['usertype'] = 1;
                                   $userid = $_SESSION['userid'];
                                   $username = $_SESSION['username'];
                                   $foto = $_SESSION['foto'];
                                   $usertype = $_SESSION['usertype'];
                                }
                            }
                           
                            if(empty($_SESSION['userid'])){?>
                               <div id="login">

                                   <a href="" class="login-hover">
                                       Iniciar sesion 2
                                   </a>
                                   <div class="login-cont"> 
                                      <input   type="text" placeholder="Correo electronico" id="mail">
                                      <input type="password" placeholder="Contraseña" id="pass">
                                      <a href="#" class="botonblue" id="boton-login">Entrar</a>
                                       <a class="loginface-top" id="login-fb" href="<?php echo $loginUrl; ?>">
                                            <div id="loginbtn-fb"></div>
                                            <div class="txtfb">Ingresar con Facebook</div>
                                        </a>
                                   </div>
                                   <?php 
                                   
//                                   if(isset($user_profile) != null){
//                                       echo $user_profile['email'];
//                                       
//                                       } ?> 
                                   <a href="#" class="registrate">Registrate</a>
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
//                                             $solicitud = $usuario->VerSolicitudes($_SESSION['userid']);
                                             $divMenciones = "";
                                            
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
                                                        $divMenciones.='<div id="'.$not['_id'].'" class="'.$clase.' item-solicitud-friend not1"> 
                                                                           <div style="background-image:url('.$user['foto'].')" class="item-friends-userpic"></div>
                                                                           <div class="item-friends-msj">
                                                                               <div class="item-friends-username tit-gray">'.$user['nombre'].'</div>
                                                                               <span class="msjmencion">te ha mencionado en el evento</span>
                                                                               <span class="tit-gray msjmencion msjeventonom">'.$not['nombreEvent'].' </span>
                                                                           </div>
                                                                           <div style="background-image:url('.$user['foto'].')" class="item-friends-eventpic"></div>
                                                                           <div class="bloq3">
                                                                               <div class="hacecuant">'.$realizacion.'</div>
                                                                           </div>
                                                                           ';

                                                        $divMenciones.=   '</div>';
                                                 } 
                                                 if($not['tipo'] == 2){
                                                        $realizacion = $comentarioEvent->verFecha($not['fechaMuestra']);
                                                        $user = $usuario->findforid($not['quien']);
                                                        $divMenciones.='<div id="'.$not['_id'].'" class="'.$clase.' item-solicitud-friend not2 item-search-friend"> 
                                                                           <div style="background-image:url('.$user['foto'].')" class="item-friends-userpic"></div>
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
                                                 
                                                 
                                                 
                                             }
                                   ?>
                                        <a href="/findbreak/!#<?php echo $_SESSION['userid']?>" class="option user-photo">
                                            <div class="content-option content-option-first"
                                            style="background: url('images/users/<?php echo $_SESSION['foto']?>') no-repeat">
                                            </div> 
                                        </a>
                                        <a href="/findbreak/!#<?php echo $_SESSION['userid']?>" class="option user-name" >
                                             <div class="content-option">
                                                 <?php echo $_SESSION['username'] ?>
                                             </div>
                                        </a>
                                   
                                        <div class="option noti-friend">
                                            <div class="content-option">Menciones (<span id="cant-solicitud"><?php echo $contsol ?></span>)</div>
                                            
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
                                         <a href="/findbreak/inicio"  class="option ">
                                            <div id="optionhome"  class="content-option">
                                                Inicio
                                            </div>
                                        </a>
                                         <div class="option  menu">
                                            <div class="content-option content-option-last">
                                                Opciones
                                            </div>
                                        </div>
                                         
                                        <div class="groupoption">
                                                <div class="itemgroup-option publicar-est">
                                                   Establecimiento nuevo
                                                </div>
                                                
                                                <div id="boton-logout" class="itemgroup-option last">
                                                    Salir
                                                </div>
                   
                                        </div>  
                                   
                                   
                                   <?php }if($usertype == 2){?>
                                    <div class="option user-photo">
                                        <div class="content-option content-option-first"
                                        style="background: url('images/users/<?php echo $_SESSION['foto']?>') no-repeat">
                                        </div> 
                                   </div>
                                   <a href="../productora/<?php echo $_SESSION['userid']; ?>" class="option user-name" >
                                        <div class="content-option">
                                            <?php echo $_SESSION['username'] ?>
                                        </div>
                                   </a>
                                        <div class="option publicar-event">
                                            <div class="content-option content-option-last">Publicar</div>
                                        </div>
                                         <div id="boton-logout" class="option content-option-last cerrar">
                                                    Salir
                                         </div>
                                       
                                   <?php }?>
                               </div>
                               <?php } ?>
                 </div>
                
              
                
        </div><!--content top-->
        
       </div><!-- top-->
       <?php }?>
       
        
           <?php if($page_site != 'cerca' && $page_site != 'inicio'){?>
                <div class="menutop">
                    <div class="btnslide"></div>
                </div>
           <?php } ?>
       
           <?php if($page_site == 'eventprofile'){?> 
            <div class="topevent">
                <div class="shadow-event"></div>
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
             $(".boxscroll").niceScroll({cursorborder:"rgb(185, 185, 185)",cursorcolor:"rgb(185, 185, 185)",boxzoom:false, cursorwidth:9}).cursor.css({"right":"3px"}); // MAC like scrollbar; // First scrollable DIV

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
