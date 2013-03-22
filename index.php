<?php 
    session_start();
    date_default_timezone_set("Chile/Continental");
    require_once 'function/place.php';
    require_once 'DAL/connect.php';
    require_once 'DAL/usuario.php';
    $contsol=0;
    
    $agregarEvento = 0;
    if($agregarEvento == 1){
            require_once 'DAL/evento.php';
            $idproductora = '238928932389892';
            $nombreproductora = 'Nombre de prueba';
            $nom = 'Lolapalusa 600';
            $dir = 'Santa Sofia #2092';
            $arrayfotos = 'foto1.jps, foto2.jpg';
            $fec = '2013-03-20, 2013-03-25';
            $hor = '22:00:00, 23:15:00';
            $hor = explode(',', $hor);
            $fechString = $fec;   
            $fechas = explode(',', $fec);  
            $fechMongo = array();
            for($i=0; $i<count($fechas); $i++){
                $fechMongo[] = new MongoDate(strtotime($fechas[$i])); 
            }
            $tag = 'copete alcohol';
            $lat = '-33.542662';
            $lng = '-70.598835';
            $desc = 'adssda';
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
<!--        <link rel="shortcut icon" href="images/favicon.png">
        <link rel="apple-touch-icon" href="images/favicon.png">-->
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
        <div id="top">
            <div id="content-top">
                <div class="top-left">
                    <div class="logo"></div>
                </div>
                
                <div class="top-center">
                    <!--<div id="hover-response">-->
                        <div class="input-textparent1">
                            <input value="BUSCA TU CARRETE..." type="text" id="search" class="input-transf">
                            <input id="boton-buscar" type="button" class="sprites" />
                        </div>
                        <div id="response-friend" >

                        </div>
                    <!--</div>-->
                </div>

                 <div class="top-right">
                            <?php if(empty($_SESSION['userid'])){?>
                               <div id="login">

                                   <a href="" class="login-hover">
                                       Iniciar sesion
                                   </a>
                                   <div class="login-cont"> 
                                      <input type="text" placeholder="Correo electronico" id="mail">
                                      <input type="password" placeholder="Contraseña" id="pass">
                                      <a href="#" id="boton-login">Entrar</a>
                                   </div>
                                   
                                   <a href="#" class="registrate">Registrate</a>
                                   <a href="#" class="productora-registro">¿Deseas publicar?</a>
                               </div>
                 
                               <?php }else{//ESTA LOGEADO?>

                               <div id="user-login"> 
                                   

                                   
                                   <?php $usertype = $_SESSION['usertype'];
                                         if($usertype == 1){
                                             $usuario = new usuario();
                                             $solicitud = $usuario->VerSolicitudes($_SESSION['userid']);
                                             $divAmigos = "";
                                             foreach($solicitud as $sol)
                                             {
                                                 $contsol++;
                                                 $divAmigos.='<div id="'.$sol['_id'].'" class="item-solicitud-friend"> 
                                                                 <div class="name-solicitud">'.$sol['solicitante']['nombre'].'</div>';
                                                 $divAmigos.=   '<div class="boton-aceptar" >Aceptar</div>';
                                                 $divAmigos.=   '<div class="boton-rechazar">Rechazar</div>
                                                              </div>';
                                             }
                                   ?>
                                        <div class="option user-photo">
                                            <div class="content-option content-option-first"
                                            style="background: url('images/users/<?php echo $_SESSION['foto']?>') no-repeat">
                                            </div> 
                                        </div>
                                        <div class="option user-name" >
                                             <div class="content-option">
                                                 <?php echo $_SESSION['username'] ?>
                                             </div>
                                        </div>
                                   
                                        <div class="option noti-friend">
                                            <div class="content-option">Friends (<span id="cant-solicitud"><?php echo $contsol ?></span>)</div>
                                            
                                        </div>
                                        <div id="show-solicitud" style="display:none">
                                                
                                                <?php echo $divAmigos ?> 
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
                                         <a href="../home/"  class="option ">
                                            <div id="optionhome"  class="content-option">
                                                Home
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
       
        <div id="body" <?= $page_class ?>>
            <div class="menutop"></div>
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
                <p class="textbottom">
                    Estudiantes de Inacap Desarrolladores del proyecto Findbreak - Fonos: 652 213 55 / 541 67 51 / 546 28 51 -
                    <span class="emailbottom">info@findbreak.com</span>
                </p>
            </footer>
       <?php } ?>
         <script type="text/javascript" src="js/upload.js"></script>
         <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/publicar_evento.js"></script>
        <script src="js/jquery.nicescroll.min.js"></script>
        <script>
  $(document).ready(function() {
  
	//var nice = $("html").niceScroll();  // The document page (body)
    
    $("#boxscroll").niceScroll({cursorborder:"rgba(104, 102, 102, 0.58)",cursorcolor:"rgba(104, 102, 102, 0.58)",boxzoom:false, cursorwidth:11}); // First scrollable DIV
    
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
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'findbreak'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function () {
            var s = document.createElement('script'); s.async = true;
            s.type = 'text/javascript';
            s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
            (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
        }());
     </script>
</html>
