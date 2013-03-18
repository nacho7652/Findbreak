
<div class="content-home">
    <div class="first-partevent">
        <div class="divevents">
            <div class="title"> Eventos cercanos a tu ubicación !</div>
            
            <div class="list-maps">
              <div class="loading-events">Loading...</div>
                <div class="inner-list-maps"></div>
            </div>
        </div>
        <article>
            <div id='map_canvas' style='width:100%; height:400px;'></div><!--Esta capa har� de elemento contenedor del mapa-->
        </article>
        <div class="event-hidden">
           
        </div>
    </div>
    <div class="second-partevent">
        <div class="hor horiz1">
            <div class="divseventspop">
             <div class="title"> Eventos más populares!</div>
                <div class="list-events-pop">
                </div>
            </div>
        </div>
        <div class="hor horiz2">
            
            <div class="divseventsord">
                 <div class="title"> Eventos próximos!</div>
                <div class="list-events-ord">
                </div>
            </div>
            
        </div>
        <div class="hor horiz3">
            <div class="divseventsfavo">
                 <div class="title"> Eventos recomendados para ti!</div>
                <div class="list-events-favo">
                </div>
            </div>
            <?php 
            
            if(isset($_SESSION['userid'])){?>
                    <div class="divseventsfavo">
                         <div class="title"> Eventos visitados recientemente</div>
                        <div class="list-events-hist">
                            <div class="eventsfavo">
                                <?php 
                                require_once 'DAL/usuario.php';
                                $user = new usuario();
                                $eventshistorial = $user->verHitorial($_SESSION['userid']);
                                $cont = 0;
                                $historial = array_reverse($eventshistorial['historial_eventos']);
                                foreach($historial as $dcto){
                                    if($cont == 5){
                                        break;
                                    }
                                    $url = '../images/productoras/'.$dcto['producido_por'].'/'.$dcto['foto'];
                                ?>
                                <div class="item-event">   
                                     <div style="background-image:url(<?php echo $url?>); background-size: cover" class="foto-event"></div>
                                     <div class="info-event">
                                        <a class="tittle-event" target="_blank" href="../evento/<?php echo $dcto['_id'];?>"><?php echo $dcto['nombre']; ?></a> 
                                         <!--<div class="productora-event">
                                            Producido por: productora
                                        </div>-->
                                    </div>
                                </div>
                                <?php 
                                $cont++;
                                } ?>
                            </div>
                        </div>
                    </div>
            <?php }?>
        </div>
<!--    
        
        <div class="divseventsright">   
           <div class="divseventsfavo">
                 <div class="title"> Eventos recomendados para ti!</div>
                <div class="list-events-favo">
                    <div class="item-event">
                        <div class="foto-event"></div>
                        <div class="tittle-event"></div>
                    </div>
                </div>
            </div>

            <div class="divseventsord">
                 <div class="title"> Eventos próximos!</div>
                <div class="list-events-ord">
                    <div class="item-event">
                        <div class="foto-event"></div>
                        <div class="tittle-event"></div>
                    </div>
                </div>
            </div>
        </div>-->
        
    </div>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> <!--Cargamos la API de Google Maps-->
    <script type="text/javascript" src="js/maps.js"></script>
</div>