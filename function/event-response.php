<?php
        session_start();
        require_once '../DAL/connect.php';
        require_once '../DAL/evento.php';
        require_once '../DAL/usuario.php';
        require_once '../DAL/establecimiento.php';
        
       function eventoscernanos($eventsNears){
            $cont = 0; //cantidad de eventos encontrados para mostrarlos en el mapa
            //$listevents = '<div class="eventsnear">';
            $listevents = '';
            $infodiv = '';
            $e = new evento();
             foreach ($eventsNears as $dcto){
                        //Con esta info. el mapa de google muestra los pines
                         $infodiv = $infodiv.'<div id="info'.$cont.'">'.$dcto['direccion']."+".$dcto['fotos'][0]."+".
                                $dcto['loc'][0]."+".$dcto['loc'][1].'</div>'."\n";
                         $cont++;
                       //----0----   
                       

                     //   $mongotime = New Mongodate(strtotime($realtime));
                        $folder = (string)$dcto['producido_por']['_id'];
                        $url = '../images/productoras/'.$folder.'/'.$dcto['fotos'][0];

                                     $listevents.= '<div class="item-eventcerca">
                                                        <div class="event-right">
                                                          <div class="event-left" style="background-image:url('.$url.'); background-size: cover"></div>
                                                             <div class="num-event"></div>
                                                        </div>
                                                    </div>';
                                
                                  $listevents.= '   <a class="tit-eventcerca link" >'.$dcto['nombre'].'</a>
                                                       <div class="info-eventcerca">
                                                            <div class="item-infocerca">
                                                                <div class="preg-cuando">¿Cuándo?</div>
                                                               <div id="fechaevent" class="resp-cuando">'.$dcto['fecha_muestra'].'</div>
                                                           </div>
                                                           
                                                           <div class="item-infocerca">
                                                                <div class="preg-cuando">¿Dónde?</div>
                                                                <div id="dondeevent" class="resp-cuando">Estadio nacional #233, Santiago</div>
                                                            </div>
                                                            
                                                             <div class="item-infocerca">
                                                                <div class="preg-cuando">¿Cuánto sale?</div>
                                                                <div id="precioevent" class="resp-cuando">Gratis</div>
                                                            </div>
                                                                
                                                           
                                                        
                                                      </div>
                                                 ';     
                                        $listevents.= '</div>
                                                    </div>'; 

                    }
                    //$listevents.= '</div>';
                    $infodiv.= '<div id="number">'.$cont.'</div>';
                    $arr = array('listevents'=>$listevents,
                                 'infodiv'=>$infodiv);
                    return $arr;
       }
       
       function eventospopulares($eventpopular){
           $listeventspop = '<div class="eventspopular">';
                    foreach ($eventpopular as $dcto){

                     //   $mongotime = New Mongodate(strtotime($realtime));
                        $folder = (string)$dcto['producido_por']['_id'];
                        $url = '../images/productoras/'.$folder.'/'.$dcto['fotos'][0];

                                $listeventspop.= '<div class="item-event">';
                                  $listeventspop.= '   
                                                     <div style="background-image:url('.$url.'); background-size: cover" class="foto-event"></div>
                                                     <div class="info-event">
                                                        <div class="date-event">'.$dcto['fecha_muestra'].'</div>
                                                        <a class="tittle-event" target="_blank" href="../evento/'.$dcto['_id'].'" >'.$dcto['nombre'].'</a> 
                                                        <div class="revews-event">
                                                            Visitas: <span class="num"> '.$dcto['visitas'].' </div>
                                                        </div>
                                                    </div>


                                                 ';     
                                $listeventspop.= '</div>'; 

                    }
                    $listeventspop.= '</div>';
                    return $listeventspop;
       }
       
       function eventosfavoritos($eventsfavo){
           $listeventsfavo = '<div class="eventsfavo">';
                                foreach ($eventsfavo as $dcto){

                                 //   $mongotime = New Mongodate(strtotime($realtime));
                                    $folder = (string)$dcto['producido_por']['_id'];
                                    $url = '../images/productoras/'.$folder.'/'.$dcto['fotos'][0];;

                                            $listeventsfavo.= '<div class="item-event">';
                                              $listeventsfavo.= '   
                                                                 <div style="background-image:url('.$url.'); background-size: cover" class="foto-event"></div>
                                                                 <div class="info-event">
                                                                    <div class="date-event">'.$dcto['fecha_muestra'].'</div>
                                                                    <a class="tittle-event" target="_blank" href="../evento/'.$dcto['_id'].'" >'.$dcto['nombre'].'</a> 
                                                                     <!--<div class="productora-event">
                                                                        Producido por: '.$dcto['producido_por']['nombre'].'
                                                                    </div>-->
                                                                </div>


                                                             ';     
                                            $listeventsfavo.= '</div>'; 

                                }
                                $listeventsfavo.= '</div>';
                            //fin for
                                return $listeventsfavo;
       }
       
       function eventosRealizadosPorFecha($eventsporfecha){
            $listeventsor = '<div class="eventsord">';
                                foreach ($eventsporfecha as $dcto){

                                 //   $mongotime = New Mongodate(strtotime($realtime));
                                    $folder = (string)$dcto['producido_por']['_id'];
                                    $url = '../images/productoras/'.$folder.'/'.$dcto['fotos'][0];

                                            $listeventsor.= '<div class="item-eventord">';
                                              $listeventsor.= '   
                                                                 <div style="background-image:url('.$url.'); background-size: cover" class="foto-event"></div>
                                                                 <div class="info-event">
                                                                    <div class="date-event">'.$dcto['fecha_muestra'].'</div>
                                                                    <a class="tittle-event" target="_blank" href="../evento/'.$dcto['_id'].'" >'.$dcto['nombre'].'</a> 
                                                                    <div class="productora-event">
                                                                        Producido por: '.$dcto['producido_por']['nombre'].'
                                                                    </div>
                                                                </div>


                                                             ';     
                                            $listeventsor.= '</div>'; 

                                }
                                $listeventsor.= '</div>';
                                return $listeventsor;
       }
       
       if(isset($_REQUEST['findnear2'])){
            $lat = $_REQUEST['lat'];
            $long = $_REQUEST['lng'];
            $event = new evento();
            
            $eventsNears = $event->findnear((float)$lat, (float)$long);
            $arr = eventoscernanos($eventsNears);
            $infodiv = $arr['infodiv'];//información para que el mapa lea y muestre los pines con eventos
            $listevents = $arr['listevents'];
            
            $resp = array("infodiv"=>$infodiv,
                          "listevents"=>$listevents
                         );
            echo json_encode($resp);
       }
       
       if(isset($_REQUEST['findnear'])){
            $lat = $_REQUEST['lat'];
            $long = $_REQUEST['lng'];
            $event = new evento();
            
            $eventsNears = $event->findnear((float)$lat, (float)$long);
            $arr = eventoscernanos($eventsNears);
            $infodiv = $arr['infodiv'];//información para que el mapa lea y muestre los pines con eventos
            $listevents = $arr['listevents'];
            
            $eventpopular = $event->findpopular();
            $listeventspop = eventospopulares($eventpopular);
            
            $eventsporfecha = $event->eventosPorRealizarOrderFecha(1);
            $listeventsporfecha = eventosRealizadosPorFecha($eventsporfecha);
           // $listeventsporfecha = $event->eventosPorRealizarOrderFecha();
            
                    $listeventsfavo = '';
                    /*EVENTOS FAVORITOS*/
                     if(isset($_SESSION['userid'])){
                        $userid = $_SESSION['userid'];
                        
                        $usuario = new usuario();
                        $usuariofound = $usuario->findforid($userid);
                        if(count($usuariofound['tags_buscados']) > 0){
                            $tagsfavoritos = $usuariofound['tags_buscados'];
                            $eventsfavo = $usuario->verEventosFavoritos($tagsfavoritos);
                            //for
                            $listeventsfavo = eventosfavoritos($eventsfavo);     
                        }
                     }else{
                         
                     }

            $resp = array("infodiv"=>$infodiv,
                          "listevents"=>$listevents,
                          "listeventspop"=>$listeventspop,
                          "listeventsfavo"=>$listeventsfavo,
                          "listeventsporfecha"=>$listeventsporfecha
                         );
            echo json_encode($resp);
        }
        
        if(isset($_POST['guardarevent'])){
            
            
            $idproductora = (string)$_SESSION['userid'];
            $nombreproductora = (string)$_SESSION['username'];
            $nom = $_POST['nomevent'];
            $dir = $_POST['addresEvent'];
            $arrayfotos = $_POST["nombresfoto"];
            $fec = $_POST["dateevent"];
            $hor = $_POST["hourevent"];
            $fechString = $fec;   
            $fechMongo = new MongoDate(strtotime($fec.' 23:59:59')); 
            $tag = $_POST["tagsevent"];
            $lat = $_POST["lat"];
            $lng = $_POST["lng"];
            $desc = $_POST['descripcionevent'];
            $urltwitter = $_POST['urltwitter'];
            $urlfacebook = $_POST['urlface'];
            
            
            $evento = new evento();
                                    
            echo $evento->insertar($idproductora, $nombreproductora, $nom, $dir, $arrayfotos, $fechString, $fechMongo,$hor, $tag, $lat, $lng, $desc,$urlfacebook,$urltwitter);
        }
        
        
        
?>
