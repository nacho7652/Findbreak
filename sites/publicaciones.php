
<?php  
        
        if(isset($_SESSION["userid"]))
        {
        $evento = new evento();
        $misEventos = $evento->EventosPorRealizarPorIdProductora($_SESSION["userid"]);
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
        
                           <?php foreach($misEventos as $dcto){
                                 
                                 $url = 'images/productoras/'.$folder.'/'.$dcto['fotos'][0];  
                                 //$url = 'images/productora/'.$_SESSION['userid'].'/'.$dcto['fotos'][0];
                               ?> 
                                <div class="item-publicar">   
                                   <div class="content-eventpublicar">  
                                       <div style="background-image: url(<?=$url?>);background-size:cover" class="foto-event-pubicar"></div>
                                       <a href="/findbreak/break/<?= $dcto['hash']?>" class="nombre-event-pubicar title-publicarevent"><?= $dcto['nombre']?></a>

                                           <div class="info-eventcerca infot-eventpublicar">
                                                           <div class="item-infocerca">
                                                               
                                                               <div id="fechaevent" class="resp-cuando">Miercoles, 20 de Mayo del 2013</div>
                                                           </div>
                                                            <div class="item-infocerca">
                                                                    <div id="horaevent" class="resp-cuando">22:00:00 hrs.</div>
                                                           </div>
                                                           <div class="item-infocerca">
                                                                
                                                                <div id="dondeevent" class="resp-cuando">Santa Sofia #2092</div>
                                                            </div>
                                                            
                                                            
                                                            
                                                            <div class="item-infocerca">
                                                                <div id="visitavent-prof" class="info-event-item resp-cuando">
                                                                   <div>Visto por <span class="bold">181</span></div>
                                                                   <div id="comentaevent-prof"><span class="bold">70</span> Comentarios</div>
                                                                   <input type="hidden" id="totalComent" value="70">
                                                               </div>  
                                                           </div>
                                                           <div class="botonitemcerca botonblue">Ver comentarios</div>
                                                           <a href="" class="editarEvento botongreen">Editar</a>
                                            </div>
                                       
                                     </div>
                                 </div>
                          <?php } ?>
                                
      </div>
   </div>

        
<?php 


        }
        else
        {
            header("location:/findbreak/login");
            
        }
?>