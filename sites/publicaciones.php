
<?php  
        $vigencia = new usuarioRelacional();
        if(isset($_SESSION["userid"]))
        {
        $event = new evento();
        $resp = $vigencia->EventosVigentesPorUsuario($_SESSION['userid']); 
        
        $misEventos = $event->EventosPorRealizarPorIdProductora($_SESSION["userid"]);
        $folder = (string)$_SESSION["userid"];
?>
<div class="content-publicarevent">
                                 <div class="item-publicar">
                                    <div class="title-publicarevent">Mis eventos</div>
                                 </div>
                                <div class="item-publicar">   
                                    <div id="info-mostrar">
                                    ¿Que obtienes al publicar un evento? 
                                    Findbreak te reembolsa dinero en tu cuenta dependiendo de la cantidad de visitas que tiene tu evento
                                    <a href="#">ver tabla de premios!</a>
                                    </div>
                                </div>
    <div class="list boxscroll">
        
                           <?php 
                           
                           
                          foreach($resp as $idEventosRelacional){
                                $dcto = $event->findforid($idEventosRelacional);  
                                $url = 'images/productoras/'.$folder.'/'.$dcto['fotos'][0];  
                                $realizacion = $event->formatoFecha($dcto['fecha_muestra'], $dcto['hora_inicio']);
                                $cantidadComentarios = $event->verCantidadComentarios($dcto['_id']);
                                $textoComentario = '';
                                if($cantidadComentarios == 0){
                                    $textoComentario = 'Se el primero en comentar!';
                                }elseif($cantidadComentarios == 1){
                                    $textoComentario = 'Un comentario';
                                }else{
                                    $textoComentario = '<span class="bold">'.$cantidadComentarios.'</span> Comentarios';
                                }
                                   
                               ?> 
                                <div class="item-publicar">   
                                   <div class="content-eventpublicar">  
                                       <div style="background-image: url(<?=$url?>);background-size:cover" class="foto-event-pubicar"></div>
                                       <a href="/findbreak/break/<?= $dcto['hash']?>" class="nombre-event-pubicar title-publicarevent"><?= $dcto['nombre']?></a>

                                           <div class="info-eventcerca infot-eventpublicar">
                                                           <div class="item-infocerca">
                                                               
                                                               <div id="fechaevent" class="resp-cuando"><?php echo $realizacion['fecha']?></div>
                                                           </div>
                                                            <div class="item-infocerca">
                                                                    <div id="horaevent" class="resp-cuando"><?php echo $realizacion['hora']?> hrs.</div>
                                                           </div>
                                                           <div class="item-infocerca">
                                                                
                                                                <div id="dondeevent" class="resp-cuando"><?php echo $dcto['direccion'];?></div>
                                                            </div>
                                                            
                                                            
                                                            
                                                            <div class="item-infocerca">
                                                                <div id="visitavent-prof" class="info-event-item resp-cuando">
                                                                   <div>Visto por <span class="bold"><?php echo $dcto['visitas'];?></span></div>
                                                                   <div id="comentaevent-prof"><span class="bold"><?php echo $textoComentario ?></span></div>
                                                                   <input type="hidden" id="totalComent" value="70">
                                                               </div>  
                                                           </div>
                                                           <!--<div class="botonitemcerca botonblue">Ver comentarios</div>-->
                                                           <a href="/findbreak/editar-evento/<?= $dcto['_id']?>" class="editarEvento botongreen">Editar</a>
                                            </div>
                                       
                                     </div>
                                 </div>
                          <?php 
                          }?>
                                
      </div>
   </div>

        
<?php 


        }
        else
        {
            header("location:/findbreak/login");
            
        }
?>