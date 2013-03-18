<?php 
      require_once '/DAL/connect.php';
      require_once '/DAL/establecimiento.php';
      $est = new establecimiento();
      $estfound = $est->BuscarEstablecimientoPorID($_GET['id']);
      $url = '../images/establecimientos/'.$estfound['fotos'][0];
     // $respsumar = $event->sumarvisita($_GET['id']); VISITAS
//      if(isset($_SESSION['userid'])){
//          require_once '/DAL/usuario.php';
//          $userid = $_SESSION['userid'];
//          $usuario = new usuario();
//          $tags = $eventfound['tags'];
//          $re = $usuario->guardarTagsBuscados($userid, $tags);
//          echo $re;
//      }
//      
//      if(!isset($_SESSION['vi'.(string)$eventfound['_id']]))
//      {
//          $_SESSION['vi'.(string)$eventfound['_id']] = 1;
//      }
?>
<div class="part-left">
    <div class="title-event"><?php echo $estfound['nombre']; ?></div>
    <div class="foto-event" style="background-size: cover; background-image: url(<?php echo $url ?>)"></div>   
    <div class="info-event-item ">Dirección : <?php  echo $estfound['direccion'];?></div>
    <div class="info-event-item ">Fono : <?php  echo $estfound['telefono'];?></div>
    <div class="redes">
        <a class="face" href=""><img src="../images/facebook.png"/></a>
        <a class="twitt" href=""><img src="../images/twitter.png"/></a>
    </div>

</div>

<div class="part-right">
    <div class="tittle-est-near">Ubicación de <?php echo $estfound['nombre']; ?> </div>
    <div id='map_establecimientos' style='width:100%; height:400px;'></div>
<!--    <div id="list-establec">
    </div>-->
</div>
<div class="part-bottom">
    <div class="more-fotos">
            <?php 
                if(count($estfound['fotos']) > 1){
                    for($i=0; $i<count($estfound['fotos']) -1; $i++){
                        $url = '../images/establecimientos/'.$estfound['fotos'][$i+1];
                        ?>
                    <div class="foto-event-small" style="background-size: cover; background-image: url(<?php echo $url ?>)"></div>
             <?php
                  }
                }
    ?>
    </div>
    <div class="description-event">
        <?php echo utf8_encode($estfound['descripcion']); ?>
    </div>
    <div class="title-coment-event">Comentarios</div>
    <?php if(isset($_SESSION['userid'])){ //si el usuario esta logueado puedo comentar (nuevo) ?>
    <div class="coments">
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'findbreak'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

    </div>
    <?php }
      else{ //si no esta logueado no puedo comentar ?>  
    <div class="coments">Para comentar el establecimiento debes iniciar sesión</div>
     <?php } ?>
    
</div>

<?php 
    $loc = $estfound['loc'];
?>
 
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> <!--Cargamos la API de Google Maps-->
 <script type="text/javascript" src="js/establecimiento.js"></script>
 
<input id="lat-est" type="hidden" value="<?php echo $loc[0] //lat ?>"/>
<input id="lng-est" type="hidden" value="<?php echo $loc[1] //lng ?>"/>
<div class="est-hidden">
    
    
</div>