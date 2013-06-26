<?php 
      require_once '/DAL/connect.php';
      require_once '/DAL/evento.php';
      require_once '/DAL/comentario.php';
      require_once '/DAL/usuario.php';
    
      $usuario = new usuario();
      $comentarioEvent = new comentario();
      $event = new evento();
      $eventfound = $event->findforhash($_GET['id']);
      $pagar = new usuarioRelacional();
      $visitasEvento = $eventfound['visitas'];
      $folder = (string)$eventfound['producido_por']['_id'];
      $url = '../images/productoras/'.$folder.'/'.$eventfound['fotos'][0];
      
        if(isset($_SESSION["ultimoAcceso"]))//después de la primera vez
        {    
            $inicio = $_SESSION["ultimoAcceso"];
            $ahora = time();
            $duracion = $ahora - $inicio; //tiempo transcurrido en segundos
            $tiempoTranscurrido =  (int)$duracion/3600; //en hora /3600
            if($tiempoTranscurrido >= 1) //10 minutos = puede sumarse
            {
             $_SESSION["ultimoAcceso"] = time();//refresco la hora ke entro
             $event->sumarvisita($eventfound['_id']); // sumar visita y se guardo la hora de cuando entró
             $visitasEvento++;
            }
        }
        if(isset($_SESSION['username'])){  
            if(!isset($_SESSION['vi'.(string)$eventfound['_id']])) //la primera vez solamente
            {
                $_SESSION['vi'.(string)$eventfound['_id']] = 1;
                $_SESSION["ultimoAcceso"] = time();
                $userid = $_SESSION['userid'];
                $tags = $eventfound['tags'];
                $re = $usuario->guardarTagsBuscados($userid, $tags);
                $re2 = $usuario->guardarHistorial($eventfound['_id'], $eventfound['fotos'][0], $eventfound['nombre'],$eventfound['producido_por']['_id'],$userid);
                $event->sumarvisita($eventfound['_id']); // sumar visita y se guardo la hora de cuando entró
                $visitasEvento++;
            }
        }
?>
<div class="more-fotos">
    
                
                <div style="background: blueviolet">
                    PRECIO:
                <?php 
                 echo $pagar->VerPrecioEvento($pagar->VerUltimoProductocidoPorVigencia($eventfound['_id']), $eventfound['_id']);
                ?>
                </div> <?php
                if(!empty($_SESSION['userid']))
                {
                if($pagar->VerVigenciaYProducidoPor($_SESSION['userid'], $eventfound['_id']) == 1 )
                {
                    ?> 
                        <div style="color: blanchedalmond">
                        Esté evento fue publicado por ti.
                        Deseas MODIFICAR alguna informacion? 
                        </div>
                            <input type="button" id="boton-editar" value="Editar">
                        <?php
                        
                        //PISOS 
                        if( $visitasEvento < 12000  && $pagar->VerPiso($_SESSION['userid'], $eventfound['_id']) == 1  ) // && PISO igual 1 [consulta a bd]
                        {
                                ?>    
                                    <div style="background: floralwhite ; "> Estas en el piso 1, te faltan <?php echo 12000-$visitasEvento ?> visitas para los 990 pesos :) </div>
                               <?php
                        }
                        if( $visitasEvento >= 12000  && $pagar->VerPiso($_SESSION['userid'], $eventfound['_id']) == 1  ) // && PISO igual 1 [consulta a bd]
                        {
                                $pagar->CambiarPiso($_SESSION['userid'], $eventfound['_id']);
                                $pagar->PagoVisitas(990, $_SESSION['userid']); //Esto depende del piso, en este caso piso 1
                                ?>    
                                    <div style="background: floralwhite ; width:66px ;"> Estas en el piso 2, te faltan <?php echo 24000-$visitasEvento ?> visitas para los 1390 pesos :) </div>
                               <?php
                        }
                        if( $visitasEvento >= 24000  && $pagar->VerPiso($_SESSION['userid'], $eventfound['_id']) == 2  ) // && PISO igual 1 [consulta a bd]
                        {
                                $pagar->CambiarPiso($_SESSION['userid'], $eventfound['_id']);
                                $pagar->PagoVisitas(1390, $_SESSION['userid']); 
                                ?>    
                                    <div style="background: floralwhite ; width:66px ;"> Estas en el piso 3, te faltan <?php echo 48000-$visitasEvento ?> visitas para los 2990 pesos :) </div>
                               <?php
                        }
                        //FALTAN AGREGAR MAS PISOS
//                        
//                        
//                        
//                        
//                        
//                        
//                        
//                        
                        
                }
                else
                {
                    
                    ?> 
                        
                                    <div id="comprar-evento"  data-idevent='<?php echo $eventfound['_id']?>' data-idproducido='<?php echo $pagar->VerUltimoProductocidoPorVigencia($eventfound['_id'])?>' style="background: floralwhite ; width:66px ;">  Comprar evento </div>  
                        <?php
                }
                }
                
                
                   $fotos = $eventfound['fotos'];
                   
                   if(count($eventfound['fotos']) >= 1){
                       for($i=0; $i<count($eventfound['fotos']) ; $i++){
                           
                           $url = '/findbreak/images/productoras/'.$folder.'/'.$fotos[$i];
//                           $url = 'http://cdn.lifeboxset.com/wp-content/uploads/2010/09/millencolin-flyer.jpg';
                           ?>
                       <div class="foto-event-small" style="background-size: cover; background-image: url(<?php echo $url ?>)"></div>
                <?php
                     }
                   }
               ?>
</div>

<div class="parte-left-parent">
            <div class="part-left divtrans">
                    <div class="part-left-right">
                        <div class="foto-event" style="background-size: cover; background-image: url(<?php echo trim($url) ?>)"></div>
<!--                        <div class="info-num">
                            <div class="item-info-num">
                                <div class="topinfo">Visitas</div>
                                <div class="num-topinfo">1000</div>
                            </div>
                            <div class="item-info-num item-info-num2">
                                <div class="topinfo">Comentarios</div>
                                <div class="num-topinfo">50</div>
                            </div>
                        </div>-->
                    </div>

                    <div class="part-left-cent">
                        <div class="title-event tit"><?php echo $eventfound['nombre']; ?></div>
                        <div class="inner-eveninfo info-eventcerca">
                                <?php 
                                        $realizacion = $event->formatoFecha($eventfound['fecha_muestra'], $eventfound['hora_inicio']);
                                        $cantidadComentarios = $event->verCantidadComentarios($eventfound['_id']);
                                        $textoComentario = '';
                                        if($cantidadComentarios == 0){
                                            $textoComentario = 'Se el primero en comentar!';
                                        }elseif($cantidadComentarios == 1){
                                            $textoComentario = 'Un comentario';
                                        }else{
                                            $textoComentario = '<span class="bold">'.$cantidadComentarios.'</span> Comentarios';
                                        }
                                    ?>

                                <div id="fechaevent-prof" class="info-event-item"><?php echo $realizacion['fecha']?></div>
                                <div id="horaevent-prof" class="info-event-item"><?php echo $realizacion['hora']?> hrs.</div>
                                <div id="dondeevent-prof" class="info-event-item"><?php  echo $eventfound['direccion'];?></div>     
                                <div id="precioevent-prof" class="info-event-item"><?php echo $eventfound['precio']?></div>
                                <div id="precioevent-prof" class="info-event-item"><?php echo $pagar->VerUltimoProductocidoPorVigencia($eventfound['_id']) ?></div>
                                <div id="visitavent-prof" class="info-event-item">
                                    <div>Visto por <span class="bold"><?php echo $visitasEvento?></span></div>
                                    <div id="comentaevent-prof"><?php echo $textoComentario?> </div>
                                    <input type="hidden" id="totalComent" value="<?= $cantidadComentarios?>"/>
                                </div>

                        </div>
                    </div>

                    <div class="part-left-lf">
                        <div id="icondescrip"></div>
                        <?php 
                                $c = 0;
                                foreach(str_word_count($eventfound['descripcion'],1) as $w){
                                    $c+= strlen($w);
                                }
                        ?>
                        <div class="descripcion-event"><?php echo nl2br($eventfound['descripcion'])?></div>
                        <div class="leer-masevent">
                            <?php 
                                    if($c > 300)//alcanza en todo el cuadro
                                  {
                                       echo '<a href="#" class="readmore">Leer más...</a>';
                                  }
                            ?>
                        </div>
                        <div class="masinfo-event"></div>
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
    
    <div class="part-bottom">
        <div class="publicidad-media"></div>      
    </div>
</div>
<div class="parte-der">
    <div class="part-right divtrans">
         <!--<div class="tit tit1">Comenta el evento</div>-->
        <?php if(isset($_SESSION['userid'])){ ?>
        <div  class="coments">
            <input type="hidden" class="idevent" value="<?php echo $eventfound['_id'] ?>"/>
            <input type="hidden" id="hashevent" value="<?php echo '#'.$eventfound['hash'] ?>"/>
            <div class="input-transcom">
                <div class="hash"><?php echo '#'.$eventfound['hash']?></div>
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
             <input type="button" class="botonblue" id="btn-comentar" value="Comentar" />
            </div>
            
        </div>
        <?php }
          else{ //si no esta logueado no puedo comentar ?>  
        <div  class="coments-nolog">
             <input type="hidden" id="idevent" value="<?php echo $_GET['id'] ?>"/>
             <input type="hidden" id="hashevent" value="<?php echo '#'.$eventfound['hash'] ?>"/>
            <div class="advert mjscoment">
                Para comentar el evento debes <a class="login-hover login-hover-com" href="#">Iniciar sesión</a> ó
                <a class="paracoment login-face login-fb" href="<?php echo '#'; ?>">
                    <div id="loginbtn-fb"></div>
                    <div class="txtfb">Ingresar con Facebook</div>
                </a>
            </div>
        </div>
         <?php } ?>
         
        <div class="list boxscroll">
            
                <?php 
                
                $comentarios = $comentarioEvent->findforid($eventfound['_id']);
                $numComent = 0;
                foreach($comentarios as $dcto){
                 
                     $userFoto = $usuario->verFoto($dcto['_userId']);
                     $realizacion = $comentarioEvent->verFecha($dcto['fechaMuestra']);
                     $useridComent = $dcto['_userId'];
//                     $mostrarHash = '';
//                     if(isset($dcto['eventos_mencionados']) != null){
//                        $mencionado = $comentarioEvent->verCitaEvento( $eventfound['_id'], $dcto['eventos_mencionados']);
//                        if(!$mencionado)
//                         $mostrarHash = $eventfound['_id'];
//                     }
                ?>
                <div data-num="<?= $numComent ?>" class="itemcoment">
                    <div class="line"></div>
                    <div class="bloq1" style="background: url('<?php echo $userFoto['foto']?>') no-repeat"></div>
                    <div class="bloq2">
                        <div class="titu-usercom">
                            <a href="/findbreak/!<?php echo $dcto['userName']?>" class="nomusercom tit-gray"><?php echo $dcto['nombreUsuario'] ?></a>
                            <spam class="username usernamecom">@<?php echo $dcto['userName']?></spam>
                        </div> 
                        <div class="comentuser">
<!--                            
                              <a href="/findbreak/break/<?php //echo $dcto['_eventId'];?>" class="hashlink"><?php//s echo $mostrarHash?></a>-->
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
            
                <?php $numComent++;}
                $comentRestantes = $cantidadComentarios - $numComent; //ultimo = limit
                if($comentRestantes > 0){
                ?>
                
                <a  href="#" class="leermas-coment readmorecoment">Ver más comentarios</a>
                <?php } ?>
            </div>
         
    </div>
    
    <div id="list-similares" class="part-right divtrans">
        <div class="titlediv">Actividades similares</div>
        <div class="boxscroll boxscrollEvents">
                            <!--<div class="eventsfavo">-->
                                <?php 
//                                if(isset($_SESSION['userid'])){
                                $similares = $event->similares('$idNo', $eventfound['tags'],5);
                                foreach($similares as $dcto){
                                    $realizacion = $event->formatoFecha($dcto['fecha_muestra'], $dcto['hora_inicio'], 1);
                                        $cantidadComentarios = $event->verCantidadComentarios($dcto['_id']);
                                        $textoComentario = '';
                                        if($cantidadComentarios == 0){
                                            $textoComentario = 'Se el primero en comentar!';
                                        }elseif($cantidadComentarios == 1){
                                            $textoComentario = 'Un comentario';
                                        }else{
                                            $textoComentario = '<span class="bold">'.$cantidadComentarios.'</span> Comentarios';
                                        }
                                    
                                   // $url = '../images/productoras/'.$dcto['producido_por'].'/'.$dcto['foto'];
                                ?>
                                <div class="item-event">   
                                     <div style="background-image:url(<?php echo $url?>); background-size: cover" class="foto-event-peq"></div>
                                     <div class="info-event">
                                        <a class="tittle-event tit" target="_blank" href="/findbreak/break/<?php echo $dcto['hash'];?>"><?php echo $dcto['nombre']; ?></a> 
                                        <div class="inner-eventpeq">  
                                            <div id="fechaevent-prof" class="info-event-item"><?php echo $realizacion['fecha']?></div>                                           
                                            
                                         </div>
                                        <div id="visitavent-prof" class="info-event-item">
                                                <div><span class="bold"><?php echo $dcto['visitas']?></span></div>
                                               
                                            </div>
                                    </div>
                                </div>
                                <?php 
                                
                                } ?>
                            <!--</div>-->
        </div>
    </div>

     <div id="list-similares" class="part-right divtrans">
        <div class="titlediv">Actividades más visitadas</div>
        <div class="boxscroll boxscrollEvents">
                            <!--<div class="eventsfavo">-->
                                <?php 
//                                if(isset($_SESSION['userid'])){
                                $pop = $event->findpopular(4);
                                foreach($pop as $dcto){
                                    $realizacion = $event->formatoFecha($dcto['fecha_muestra'], $dcto['hora_inicio'], 1);
                                        $cantidadComentarios = $event->verCantidadComentarios($dcto['_id']);
                                        $textoComentario = '';
                                        if($cantidadComentarios == 0){
                                            $textoComentario = 'Se el primero en comentar!';
                                        }elseif($cantidadComentarios == 1){
                                            $textoComentario = 'Un comentario';
                                        }else{
                                            $textoComentario = '<span class="bold">'.$cantidadComentarios.'</span> Comentarios';
                                        }
                                    
                                   // $url = '../images/productoras/'.$dcto['producido_por'].'/'.$dcto['foto'];
                                ?>
                                <div class="item-event">   
                                     <div style="background-image:url(<?php echo $url?>); background-size: cover" class="foto-event-peq"></div>
                                     <div class="info-event">
                                        <a class="tittle-event tit" target="_blank" href="/findbreak/break/<?php echo $dcto['hash'];?>"><?php echo $dcto['nombre']; ?></a> 
                                        <div class="inner-eventpeq">  
                                            <div id="fechaevent-prof" class="info-event-item"><?php echo $realizacion['fecha']?></div>                                           
                                            
                                         </div>
                                        <div id="visitavent-prof" class="info-event-item">
                                                <div><span class="bold"><?php echo $dcto['visitas']?></span></div>
                                               
                                            </div>
                                    </div>
                                </div>
                                <?php 
                                
                                } ?>
                            <!--</div>-->
        </div>
    </div>
</div>
<div class="publicidad-large"></div>





<?php 
    $loc = $eventfound['loc'];
?>
  
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> <!--Cargamos la API de Google Maps-->
 <script type="text/javascript" src="js/evento.js"></script>
 
 
<input id="lat-event" type="hidden" value="<?php echo $loc[0] //lat ?>"/>
<input id="lng-event" type="hidden" value="<?php echo $loc[1] //lng ?>"/>
<div class="est-hidden">
   
</div>
