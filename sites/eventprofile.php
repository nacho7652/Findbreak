<?php 
    
    require_once '/DAL/connect.php';
      require_once '/DAL/evento.php';
      $event = new evento();
      $eventfound = $event->findforid($_GET['id']);
      $folder = (string)$eventfound['producido_por']['_id'];
      $url = '../images/productoras/'.$folder.'/'.$eventfound['fotos'][0];
      $event->sumarvisita($_GET['id']); // sumar visita
     // if(!isset($_SESSION['vi'.(string)$eventfound['_id']]) != "") 
    //  {
            if(isset($_SESSION['userid']) && isset($_SESSION['userid']) == 1){
                require_once '/DAL/usuario.php';
                $userid = $_SESSION['userid'];
                $usuario = new usuario();
                $tags = $eventfound['tags'];
                $re = $usuario->guardarTagsBuscados($userid, $tags);
                $re2 = $usuario->guardarHistorial($eventfound['_id'], $eventfound['fotos'][0], $eventfound['nombre'],$eventfound['producido_por']['_id'],$userid);
      //          echo $re;
            }

      
          $_SESSION['vi'.(string)$eventfound['_id']] = 1;
    //  }
?>
<div class="part-left">
    <div class="title-event"><?php echo $eventfound['nombre']; ?></div>
    <div class="foto-event" style="background-size: cover; background-image: url(<?php echo $url ?>)"></div>
    <div class="inner-eveninfo info-eventcerca">
            <?php 
                    $realizacion = $event->formatoFecha($eventfound['fecha_muestra'], $eventfound['hora_inicio']);
                ?>
            <div id="fechaevent-prof" class="info-event-item"><?php echo $realizacion['fecha']?></div>
            <div id="horaevent-prof" class="info-event-item"><?php echo $realizacion['hora']?> hrs.</div>
            <div id="dondeevent-prof" class="info-event-item"><?php  echo $eventfound['direccion'];?></div>     
            <div id="precioevent-prof" class="info-event-item"><?php echo $eventfound['precio']?></div>
            <div id="horaevent-prof" class="info-event-item"><?php echo $realizacion['hora']?> hrs.</div>
            
    </div>
</div>

<div class="part-right">
    <div class="tittle-est-near">Establecimientos cercanos</div>
    <div id='map_establecimientos' style='width:100%; height:400px;'></div>
    <div id="list-establec">
        
        
        
        
    </div>
</div>
<div class="part-bottom">
    <div class="more-fotos">
        <?php 
           $fotos = $eventfound['fotos'];
           if(count($eventfound['fotos']) > 1){
               for($i=0; $i<count($eventfound['fotos']) -1; $i++){
                   $url = '../images/productoras/'.$folder.'/'.$eventfound['fotos'][$i+1];
                   ?>
               <div class="foto-event-small" style="background-size: cover; background-image: url(<?php echo $url ?>)"></div>
        <?php
             }
           }
       ?>
     </div>
    <div class="description-event">
        <?php echo $eventfound['descripcion']; ?>
    </div>
    <div class="title-coment-event">Comentarios</div>
    <?php if(isset($_SESSION['userid'])){ //si el usuario esta logueado puedo comentar (nuevo) ?>
    <div class="coments">
        <input type="hidden" id="idevent" value="<?php echo $eventfound['_id'] ?>"/>
        <textarea id="coment" rows="5" cols="50" placeholder="Comentario..."></textarea>
        <input type="button" id="btn-comentar" value="Comentar" />
<!--        <div id="disqus_thread"></div>
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
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>-->

    </div>
    <?php }
      else{ //si no esta logueado no puedo comentar ?>  
    <div class="coments">Para comentar el evento debes iniciar sesión</div>
     <?php } ?>
    
    
    </div>
</div>
<?php 
    $loc = $eventfound['loc'];
?>
 
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> <!--Cargamos la API de Google Maps-->
 <script type="text/javascript" src="js/evento.js"></script>
 
<input id="lat-event" type="hidden" value="<?php echo $loc[0] //lat ?>"/>
<input id="lng-event" type="hidden" value="<?php echo $loc[1] //lng ?>"/>
<div class="est-hidden">
    
    
</div>