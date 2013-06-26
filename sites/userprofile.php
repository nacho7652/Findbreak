<?php 
    
      require_once '/DAL/connect.php';
      require_once '/DAL/evento.php';
      require_once '/DAL/comentario.php';
      require_once '/DAL/usuario.php';
      $usuario = new usuario();
      $partid = explode('!', $_GET['id']);
      $usernameUrl = $partid[1];
      $usuariofound = $usuario->findforusername($usernameUrl);
      $userid = $usuariofound['_id'];
      $comentarioUser = new comentario();
      $event = new evento();
      $eventfound = $event->findforid('516aed144de8b4a003000003');
      $folder = (string)$eventfound['producido_por']['_id'];
      $url = '../images/productoras/'.$folder.'/'.$eventfound['fotos'][0];
?>
<div class="more-fotos">
                
</div>

<div class="parte-left-parent">
            <div class="part-left divtrans2">
                    <div class="part-left-right">
                      
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
                       
                                <?php 
                                        $realizacion = $event->formatoFecha($eventfound['fecha_muestra'], $eventfound['hora_inicio']);
                                        $cantidadComentariosUser = $usuario->verCantidadComentarios($userid);
//                                        $textoComentario = '';
//                                        if($cantidadComentarios == 0){
//                                            $textoComentario = 'Se el primero en comentar!';
//                                        }elseif($cantidadComentarios == 1){
//                                            $textoComentario = 'Un comentario';
//                                        }else{
//                                            $textoComentario = '<span class="bold">'.$cantidadComentarios.'</span> Comentarios';
//                                        }
                                    ?>
                        <?php 
                        if(isset($_SESSION['userid'])){
                            if($_SESSION['userid'] == $userid)//mostrar mis recomendaciones
                             { ?>
                                <div class="titlediv">Actividades sugeridas</div>
                                    <div class="boxscroll boxscrollEvents">
                                                        <!--<div class="eventsfavo">-->
                                                            <?php 
                                //                          if(isset($_SESSION['userid'])){
                                                        //$pop = $event->findpopular(4);
                                                        if(count($usuariofound['tags_buscados']) > 0){
                                                        $pop = $usuario->verEventosFavoritos($usuariofound['tags_buscados']);
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

                                                        } }?>
                                                    <!--</div>-->
                                </div>
                        
                   <?php }
                   
                   }else{
                        ?>
                               no logged
                        
                        <?php }?>
                    </div>

                    <div class="part-left-cent">
                            <div class="titlediv">Lo más comentado del momento</div>
                                    <div class="boxscroll boxscrollEvents">
                                                        <!--<div class="eventsfavo">-->
                                                            <?php 
                                //                          if(isset($_SESSION['userid'])){
                                                        //$pop = $event->findpopular(4);
                                                        if(count($usuariofound['tags_buscados']) > 0){
                                                        $pop = $usuario->verEventosFavoritos($usuariofound['tags_buscados']);
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

                                                        } }?>
                                                    <!--</div>-->
                                </div>
                    </div>


             </div>
    
   
    
    <div class="part-bottom">
        <div class="publicidad-media"></div>      
    </div>
</div>
<div class="parte-der">
    <div class="part-right divtrans2">
          <div class="foto-user" style="background-size: cover; background-image: url(<?php echo $usuariofound['foto'] ?>)"></div>
          <div class="bloque-info info-event-item">
              <div class="title-user tit-gray"><?php echo ucwords($usuariofound['nombre']) ?></div>
              <div class="username">@<?= $usuariofound['username']?></div>
              <div class="info-num">
                    <div class="item-info-num">
                        <div class="topinfo">Comentarios</div>
                        <div id="totalComent" class="num-topinfo"><?= $cantidadComentariosUser?></div>
                    </div>
                    <div class="item-info-num">
                        <div class="topinfo">Seguidores</div>
                        <div class="topinfo">PUBLICACIONES DEL USUARIO?</div>
                        <div class="num-topinfo">
                            <?php if(isset($usuariofound['seguidores']))
                                        echo count($usuariofound['seguidores']);
                                   else
                                       echo 0;
                            ?>
                        
                        </div>
                    </div>
                    <div class="item-info-num item-info-num2">
                        <div class="topinfo">Siguiendo</div>
                        <div class="num-topinfo">
                            <?php if(isset($usuariofound['siguiendo']))
                                        echo count($usuariofound['siguiendo']);
                                   else
                                       echo 0;
                            ?>
                        
                        </div>
                    </div>
              </div>
              <div class="info-num moreinfouser"></div>
          </div>
          <!--<div class="tit tit1">Comenta el evento</div>-->
       
          <div class="part-right divtrans3">
                 <?php if(isset($_SESSION['userid'])){ 
                         if($_SESSION['userid'] == $userid)
                         {
                     ?>
                 
                            <div  class="coments">
                                <input type="hidden" id="iduser" value="<?php echo $userid ?>"/>
        <!--                        <input type="hidden" id="hashevent" value="<?ph//p echo $eventfound['hash'] ?>"/>-->
                                <div class="input-transcom">
                                    <!--<div class="hash"><?php //echo $eventfound['hash']?></div>-->
                                    <textarea id="hasheventos" class="hash" placeholder="menciona a un evento #"></textarea>
                                    <div class="eventosCitar"></div>


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
                                 <input type="button" class="botonblue" id="btn-comentar-puser" value="Comentar" />
                                </div>

                            </div>
                    <?php }
                    
                    }
                      else{ //si no esta logueado no puedo comentar ?>  
                    <div  class="coments-nolog">
                         <input type="hidden" id="idevent" value="<?php echo $_GET['id'] ?>"/>
                         <input type="hidden" id="hashevent" value="<?php echo '#'.$eventfound['hash'] ?>"/>
                        <div class="advert mjscoment">
                            Para comentar el evento debes <a class="login-hover login-hover-com" href="#">Iniciar sesión</a> ó
                            <a class="paracoment login-face login-fb" href="<?php echo ''; ?>">
                                <div id="loginbtn-fb"></div>
                                <div class="txtfb">Ingresar con Facebook</div>
                            </a>
                        </div>
                    </div>
                     <?php } ?>
         
        <div class="list boxscroll">
            
                <?php 
                
                $comentarios = $comentarioUser->verMisComentarios($userid);
                $numComent = 0;
                foreach($comentarios as $dcto){
                     
                     $realizacion = $comentarioUser->verFecha($dcto['fechaMuestra']);
                     $useridComent = $dcto['_userId'];
                ?>
                <div data-num="<?= $numComent ?>" class="itemcoment">
                    <div class="line"></div>
                    <div class="bloq1" style="background: url('<?php echo $usuariofound['foto']?>') no-repeat"></div>
                    <div class="bloq2">
                        <div class="titu-usercom">
                            <a href="/findbreak/!<?php echo $dcto['userName']?>" class="nomusercom tit-gray"><?php echo $dcto['nombreUsuario'] ?></a>
                            <spam class="username usernamecom">@<?php echo $dcto['userName']?></spam>
                        </div>
                        <div class="comentuser">
                            
<!--                              <a href="/findbreak/break/<?php //echo $dcto['_eventId'];?>" class="hashlink"><?php //echo $eventfound['hash']?></a>-->
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
                $comentRestantes = $cantidadComentariosUser - $numComent; //ultimo = limit
                
                if($comentRestantes > 0){
                ?>
                
                <a  href="#" class="leermas-comentuser readmorecoment">Ver más comentarios</a>
                <?php } ?>
            </div>
          </div>
    </div>
   
</div>
<div class="publicidad-large"></div>
<script type="text/javascript" src="js/userprofile.js"></script>
 