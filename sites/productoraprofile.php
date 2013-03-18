<?php 
      require_once '/DAL/connect.php';
      require_once '/DAL/productora.php';
      require_once '/DAL/evento.php';
      $prod = new productora();
      $prodFound = $prod->findforid($_GET['id']);
      
      $event = new evento();
      $events = $event->EventosPorRealizarPorIdProductora($_GET['id']);
      $eventsDone = $event->EventosDONEPorIdProductora($_GET['id']);
      $eventMorePop = $event->findpopularPorProductora($_GET['id'], 1);
       $folder = (string)$_GET['id'];
      
?>

<div class="part-left">
    <div class="title-event">Bienvenida <?php echo $prodFound['nombre']; ?></div>
    <div class="morepop">
        <div class="title-morepop">Tu evento más popular!</div>
        <?php 
        //if(count($eventMorePop) > 0)
        foreach($eventMorePop as $dcto){
             $url = '../images/productoras/'.$folder.'/'.$dcto['fotos'][0];
        ?>
        <div class="nom-pop"><?php echo $dcto['nombre'] ?> (<?php echo $dcto['visitas']; ?>) visitas</div> 
        <div style="background-image:url('<?php echo $url; ?>'); background-size: cover" class="foto-event"></div>
        
        <?php } ?>
    </div>
</div>

<div class="part-right">
    
    <div class="event-list">
        <div class="event-realizar">
            <div class="title-eventreali">Tus próximos eventos a realizar</div>
            <?php 
                   $divEvent2 = "";
                   foreach($events as $dcto)
                   {
                       
                        $url = '../images/productoras/'.$folder.'/'.$dcto['fotos'][0];
                       $divEvent2.= '<div class="item-list-event">
                                        
                                                     <div style="background-image:url('.$url.'); background-size: cover" class="foto-event"></div>
                                                     <div class="info-event">
                                                        <div class="date-event">'.$dcto['fecha_muestra'].'</div>
                                                        <a class="tittle-event" target="_blank" href="../evento/'.$dcto['_id'].'" >'.$dcto['nombre'].'</a> 
                                                        <!--<div class="productora-event">
                                                            Producido por: '.$dcto['producido_por']['nombre'].'
                                                        </div>-->
                                                    </div>
                                    </div>';
                   }
                   
                   echo $divEvent2;
                 //  echo $event['nombre'];
            
            ?>
        </div>
        
        <div class="event-done">
             <div class="title-eventdone">Tus eventos realizados</div>
            <?php 
                    
            $divEvent = "";
            
                   foreach($eventsDone as $dcto)
                   {
                       $url = '../images/productoras/'.$folder.'/'.$dcto['fotos'][0];
                       $divEvent.= '<div class="item-list-event">
                                        
                                                     <div style="background-image:url('.$url.'); background-size: cover" class="foto-event"></div>
                                                     <div class="info-event">
                                                        <div class="date-event">'.$dcto['fecha_muestra'].'</div>
                                                        <a class="tittle-event" target="_blank" href="../evento/'.$dcto['_id'].'" >'.$dcto['nombre'].'</a> 
                                                        <div class="productora-event">
                                                            Total visitas: '.$dcto['visitas'].'
                                                        </div>
                                                    </div>
                                    </div>';
                   }
                   
                   echo $divEvent;
                   
                 //  echo $event['nombre'];
            
            ?>
        
        
        </div>
     </div>
   
</div>



<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>