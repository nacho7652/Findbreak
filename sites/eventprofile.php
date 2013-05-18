<?php 
    
      require_once '/DAL/connect.php';
      require_once '/DAL/evento.php';
      require_once '/DAL/comentario.php';
      $comentarioEvent = new comentario();
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
<div class="more-fotos">
                <?php 
                   $fotos = $eventfound['fotos'];
                   $primero = 0;
                   if(count($eventfound['fotos']) > 1){
                       for($i=0; $i<count($eventfound['fotos']) ; $i++){
                           if($primero == 0){
                               $primero = 1;
                               $url = 'background-size: cover; background-image: url(http://3.bp.blogspot.com/-BDrt8UjnTis/TVq6Yzct59I/AAAAAAAAAZg/9dH2MauSfhk/s1600/millencolin_4.jpg);width: 170px;';
                           echo ' <div class="foto-event-small" style="'.$url.'"></div>';
                               
                           }else{
                          // $url = '../images/productoras/'.$folder.'/'.$eventfound['fotos'][$i+1];
                           $url = 'http://cdn.lifeboxset.com/wp-content/uploads/2010/09/millencolin-flyer.jpg';
                           ?>
                       <div class="foto-event-small" style="background-size: cover; background-image: url(<?php echo $url ?>)"></div>
                <?php
                     }}
                   }
               ?>
</div>

<div class="parte-left-parent">
            <div class="part-left divtrans">
                    <div class="part-left-right">
                        <div class="foto-event" style="background-size: cover; background-image: url(<?php echo $url ?>)"></div>
                        <div class="info-num">
                            <div class="item-info-num">
                                <div class="topinfo">Visitas</div>
                                <div class="num-topinfo">1000</div>
                            </div>
                            <div class="item-info-num item-info-num2">
                                <div class="topinfo">Comentarios</div>
                                <div class="num-topinfo">50</div>
                            </div>
                        </div>
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
                                <div id="visitavent-prof" class="info-event-item"><?php echo $eventfound['visitas']?> visitas</div>

                        </div>
                    </div>

                    <div class="part-left-lf">

                    </div>


             </div>
    
    <div class="cercanos">
            <!--<div class="tit tit1">Establecimientos cercanos al evento</div>-->
           <div id='map_establecimientos' style='width:100%; height:175px;'></div>
            <div id="list-establec">




            </div>

            
            <div class="description-event">
                <?php echo $eventfound['descripcion']; ?>
            </div>
            <div class="title-coment-event">Comentarios</div>
    </div>
    
    <div class="part-bottom divtrans">
   
        




    </div>
</div>
<div class="parte-der">
    <div class="part-right divtrans">
         <!--<div class="tit tit1">Comenta el evento</div>-->
        <?php if(isset($_SESSION['userid'])){ ?>
        <div  class="coments">
            <input type="hidden" id="idevent" value="<?php echo $eventfound['_id'] ?>"/>
            <input type="hidden" id="hashevent" value="<?php echo $eventfound['hash'] ?>"/>
            <div class="input-transcom">
                <div class="hash"><?php echo $eventfound['hash']?></div>
                <div id="overcoment">
                  <textarea class="textoajustable" id="coment"></textarea>
                </div>
<!--                <div id="citasHidden"></div>
                <div class="citasHiddenReservas"></div>-->
                <div id="replica"></div>
            </div>
            <div class="showfocuscom">
             <div class="divcitar">@</div>
             <div class="amigosCitar"></div>
             <input type="button" class="botongreen" id="btn-comentar" value="Comentar" />
            </div>
            
        </div>
        <?php }
          else{ //si no esta logueado no puedo comentar ?>  
        <div  class="coments-nolog">
            <div class="advert mjscoment">
                Para comentar el evento debes <a class="login-hover login-hover-com" href="#">Iniciar sesión</a> ó
                <a class="paracoment" id="login-fb" href="<?php echo ''; ?>">
                    <div id="loginbtn-fb"></div>
                    <div class="txtfb">Ingresar con Facebook</div>
                </a>
            </div>
        </div>
         <?php } ?>
         
        <div class="list boxscroll">
                <?php 
                $comentarios = $comentarioEvent->findforid($eventfound['_id']);
                foreach($comentarios as $dcto){
                     $realizacion = $comentarioEvent->verFecha($dcto['fechaMuestra']);
                     $useridComent = $dcto['_userId'];
                ?>
                <div class="itemcoment">
                    <div class="line"></div>
                    <div class="bloq1"></div>
                    <div class="bloq2">
                        <a href="/findbreak/!#<?php echo $dcto['_userId']?>" class="nomusercom tit-gray"><?php echo $dcto['userName'] ?></a>
                        <div class="comentuser">
                            
                              <a href="/findbreak/break/<?php echo $dcto['_eventId'];?>" class="hashlink"><?php echo $eventfound['hash']?></a>
                                                           <?php echo $dcto['comentario'] ?>

                        </div>
                    </div>
                    <div class="bloq3">
                        
                        <div class="hacecuant">
                            <?php echo $realizacion;
                            ?>
                        </div>
                        <?php 
                        if(isset($_SESSION['userid'])){
                            if($useridComent == $_SESSION['userid']){?>
                                <div data-id="<?php echo $dcto['_id'];?>" id="delcoment" class="aparececom">Eliminar</div>
           
                            <?php }else{?>
                                <div data-id="<?php echo $dcto['_id'];?>" id="compartircoment" class="aparececom">Compartir</div>
                            <?php }
                             }else{?>
                                <div data-id="<?php echo $dcto['_id'];?>" id="compartircoment" class="aparececom">Compartir</div>
                          <?php }?>
                           
                    </div>
                </div>
                <?php }?>
            </div>
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