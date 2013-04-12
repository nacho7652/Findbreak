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
<div class="parte-left-parent">
            <div class="part-left divtrans">
            <div class="part-left-right">
                <div class="foto-event" style="background-size: cover; background-image: url(<?php echo $url ?>)"></div>
            </div>

            <div class="part-left-cent">
                <div class="title-event tit"><?php echo $eventfound['nombre']; ?></div>
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

            <div class="part-left-lf">

            </div>


        </div>
    
    <div class="cercanos">
            <div class="tit tit1">Establecimientos cercanos al evento</div>
           <div id='map_establecimientos' style='width:100%; height:175px;'></div>
            <div id="list-establec">




            </div>

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
    </div>
    
    <div class="part-bottom divtrans">
    <div class="tit tit1">Comenta el evento</div>
        <?php if(isset($_SESSION['userid'])){ //si el usuario esta logueado puedo comentar (nuevo) ?>
        <div class="coments">
            <input type="hidden" id="idevent" value="<?php echo $eventfound['_id'] ?>"/>
            <input id="coment" class="input-textparent1" placeholder="Comentario..."/>
            <input type="button" class="botongreen" id="btn-comentar" value="Comentar" />
        </div>
        <?php }
          else{ //si no esta logueado no puedo comentar ?>  
        <div class="coments">Para comentar el evento debes iniciar sesión</div>
         <?php } ?>
        




    </div>
</div>
<div class="parte-der">
    <div class="part-right divtrans">


    </div>
    
    <div class="part-right divtrans">


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