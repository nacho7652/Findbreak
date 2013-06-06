<?php
        session_start();
        require_once '../DAL/connect.php';
        require_once '../DAL/evento.php';
        require_once '../DAL/usuario.php';
        require_once '../DAL/establecimiento.php';
        require_once '../DAL/comentario.php';
      if(!empty($_POST["search-event-cit"]))
    {
                    $evento = new evento();
                    $popular = $evento->findpopular(3);
                    $html = '';
                    $limite = 3;
                    foreach ($popular as $item){
                        if($limite > 0){
                            $html.= '<div data-id="'.$item['_id'].'" class="item-event-citar">
                                                   <div style="background-image:url(http://images.ak.instagram.com/profiles/profile_144600501_75sq_1364906070.jpg)" class="item-evento-foto"></div>
                                                   <div class="item-evento-name">'.$item['hash'].'</div>
                                               </div>';
                            $limite--;
                        }
                    }
                    
                    echo $html;
            
            
    }
      if(isset($_REQUEST['mostrar-coment-cerca'])){
        $idEvento = $_REQUEST['idevento'];
        $hashevent = $_REQUEST['hashevent'];
        $comentarioEvent = new comentario();
        $event = new evento();
        $listcoment = '';
        if(isset($_SESSION['userid'])){ 
            $listcoment.= '<div  class="coments">';
            $listcoment.= '  <input type="hidden" id="idevent" value="'.$idEvento.'"/>';
            $listcoment.= '  <input type="hidden" id="hashevent" value="'.$hashevent.'"/>';
            $listcoment.= '  <div class="input-transcom">';
            $listcoment.= '     <div class="hash">'.$hashevent.'</div>';
            $listcoment.= '     <div id="overcoment">';
            $listcoment.= '     <textarea class="textoajustable" id="coment"></textarea>';
            $listcoment.= '  </div>
                                <div id="replica"></div>
                            </div>
                            <div class="showfocuscom">
                                <div class="divcitar">@</div>
                                <div class="amigosCitar"></div>
                                <input type="button" class="botonblue" id="btn-comentar" value="Comentar" />
                            </div>

                </div>';
           }
          else{ //si no esta logueado no puedo comentar 
                 $listcoment.= '<div  class="coments-nolog">
                     <input type="hidden" id="idevent" value="'.$idEvento.'"/>
                     <input type="hidden" id="hashevent" value="'.$hashevent.'"/>
                    <div class="advert mjscoment">
                        Para comentar el evento debes <a class="login-hover login-hover-com" href="#">Iniciar sesión</a> ó
                        <a class="paracoment" id="login-fb" href="">
                            <div id="loginbtn-fb"></div>
                            <div class="txtfb">Ingresar con Facebook</div>
                        </a>
                    </div>
                </div>';
           } 
         $listcoment = '';
         $listcoment.= '<div class="list boxscroll">';
          $listcoment = '';      
                $theObjId = new MongoId($idEvento);
                $comentarios = $comentarioEvent->findforid($theObjId);
                $numComent = 0;
                foreach($comentarios as $dcto){
                     
                     $realizacion = $comentarioEvent->verFecha($dcto['fechaMuestra']);
                     $useridComent = $dcto['_userId'];
                
                    $listcoment.= '<div data-num="'.$numComent.'" class="itemcoment">
                               <div class="line"></div>
                               <div class="bloq1"></div>
                               <div class="bloq2">
                                   <a href="/findbreak/!'.$dcto['username'].'" class="nomusercom tit-gray">'.$dcto['userName'].'</a>
                                   <div class="comentuser">

                                        
                                                                      '.$dcto['comentario'].'

                                   </div>
                               </div>
                               <div class="bloq3">

                                   <div class="hacecuant">
                                       '.$realizacion.'
                                   </div>';
                         
                        if(isset($_SESSION['userid'])){
                            if($useridComent == $_SESSION['userid']){
                                $listcoment.= ' <div data-id="'.$dcto['_id'].'" id="delcoment" class="aparececom">Eliminar</div>';
           
                                    }else{
                                       $listcoment.= ' <div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
                                      }
                             }else{
                                 $listcoment.= '<div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
                              }
                           
                        $listcoment.= '</div>
                       </div>';

                        $numComent++;
                 
                 }
                $cantidadComentarios = $event->verCantidadComentarios($idEvento);
                $comentRestantes = $cantidadComentarios - $numComent; //ultimo = limit
                if($comentRestantes > 0){
                     $listcoment.= '<a  href="#" class="leermas-coment readmorecoment">Ver más comentarios</a>';
                  } 
           //  $listcoment.= '</div>';
             
             echo $listcoment;
        }
        if(isset($_REQUEST['search-space'])){
            $event = new evento();
            $eventpopular = $event->findpopular(4);
            $hayevents = false;
             $primero = 0;
             $cuadroevento = '<div class="title-search-item">Populares</div>';
            foreach($eventpopular as $dcto)
            {
                $hayevents = true;
                $classPrimero = '';
                if($primero == 0){
                    $primero = 1;
                    $classPrimero = 'itemCitarSelected';
                }
                $cuadroevento.= 
                '<a href="/findbreak/break/'.(string)$dcto['_id'].'" target="_blank" class="'.$classPrimero.' item-search item-search-event">
                   <div class="foto-item-search"></div>
                   <div class="name-item-search tit-gray">'.$dcto["nombre"].'</div>
                   <div style="display:none" class="id-item-search">'.$dcto["_id"].'</div>
                </a>';
                
            }
            $re = array('hay'=>$hayevents,'re'=>$cuadroevento);
            echo json_encode($re);
        }
        
        if(isset($_POST['search-ini'])){
        //EVENTOS 
             $texto = $_POST['busqueda'];
            
             $cuadroevento = '';
             
             $evento = new evento();
             $coincidenciaevento = $evento->filtrar($texto);
             $hayevents = false;
             $primero = 0;
             
             foreach($coincidenciaevento as $dcto)
            {
                $hayevents = true;
                $classPrimero = '';
                if($primero == 0){
                    $primero = 1;
                    $classPrimero = 'itemCitarSelected';
                }
                $cuadroevento.= 
                '<a href="/findbreak/break/'.(string)$dcto['_id'].'" target="_blank" class="'.$classPrimero.' item-search item-search-event">
                   <div class="foto-item-search"></div>
                   <div class="name-item-search tit-gray">'.$dcto["nombre"].'</div>
                   <div style="display:none" class="id-item-search">'.$dcto["_id"].'</div>
                </a>';
                
            }
            $re = array('hay'=>$hayevents,'re'=>$cuadroevento);
            echo json_encode($re);
    }
    
       function eventoscernanos($eventsNears){
           $cont = 0; //cantidad de eventos encontrados para mostrarlos en el mapa
            //$listevents = '<div class="eventsnear">';
            $listevents = '';
            $infodiv = '';
            $e = new evento();
            $arreglo = array();
             foreach ($eventsNears as $dcto){
                        //Con esta info. el mapa de google muestra los pines
                         $infodiv = $infodiv.'<div id="info'.$cont.'">'.$dcto['direccion']."+".$dcto['fotos'][0]."+".
                                $dcto['loc'][0]."+".$dcto['loc'][1].'</div>'."\n";
                         $cont++;
                       //----0----   
                       

                     //   $mongotime = New Mongodate(strtotime($realtime));
                        $folder = (string)$dcto['producido_por']['_id'];
                        $url = '../images/productoras/'.$folder.'/'.$dcto['fotos'][0];
                       // $listevents.= '<div data-id="'.$dcto['_id'].'" data-hash="'.$dcto['hash'].'" class="item-eventcerca">';
                        $listevents.= '
                                           
                          <div class="event-left" style="background-image:url('.$url.'); background-size: cover"></div>
                                 <div class="num-event"></div>';
                                  $nombreLink = str_replace(' ', '-', $dcto['nombre']);
                                  $realizacion = $e->formatoFecha($dcto['fecha_muestra'], $dcto['hora_inicio'],1);
                                  $cantidadComentarios = $e->verCantidadComentarios($dcto['_id']);
                                    $textoComentario = '';
                                    if($cantidadComentarios == 0){
                                        $textoComentario = 'Se el primero en comentar!';
                                    }elseif($cantidadComentarios == 1){
                                        $textoComentario = 'Un comentario';
                                    }else{
                                        $textoComentario = '<span class="bold">'.$cantidadComentarios.'</span> Comentarios';
                                    }
                                  $listevents.= '   <a target="_blank" href="/findbreak/break/'.$dcto['_id'].'" class="tit-eventcerca" >'.$dcto['nombre'].'</a>
                                                       <div class="info-eventcerca info-eventcercawhte">
                                                           <div class="item-infocerca">
                                                               
                                                               <div id="fechaevent" class="resp-cuando">'.$realizacion['fecha'].'</div>
                                                           </div>
                                                            <div class="item-infocerca">
                                                                    <div id="horaevent" class="resp-cuando">'.$realizacion['hora'].' hrs.</div>
                                                           </div>
                                                           <div class="item-infocerca">
                                                                
                                                                <div id="dondeevent" class="resp-cuando">'.$dcto['direccion'].'</div>
                                                            </div>
                                                            
                                                            
                                                            
                                                            <div class="item-infocerca">
                                                                <div id="visitavent-prof" class="info-event-item resp-cuando">
                                                                   <div>Visto por <span class="bold">'.$dcto['visitas'].'</span></div>
                                                                   <div id="comentaevent-prof">'.$textoComentario.'</div>
                                                                   <input type="hidden" id="totalComent" value="'.$cantidadComentarios.'"/>
                                                               </div>  
                                                           </div>
                                                           <div class="botonitemcerca botonblue">Ver comentarios</div>
                                                        
                                                      </div>
                                                     
                                                 '; 
                                     $infoEventCerca = '
                                                           <div class="item-infocerca">
                                                               
                                                               <div id="fechaevent" class="resp-cuando">'.$realizacion['fecha'].'</div>
                                                           </div>
                                                            <div class="item-infocerca">
                                                                    <div id="horaevent" class="resp-cuando">'.$realizacion['hora'].' hrs.</div>
                                                           </div>
                                                           <div class="item-infocerca">
                                                                
                                                                <div id="dondeevent" class="resp-cuando">'.$dcto['direccion'].'</div>
                                                            </div>
                                                            
                                                            
                                                            
                                                            <div class="item-infocerca">
                                                                <div id="visitavent-prof" class="info-event-item resp-cuando">
                                                                   <div>Visto por <span class="bold">'.$dcto['visitas'].'</span></div>
                                                                   <div id="comentaevent-prof">'.$textoComentario.'</div>
                                                                   <input type="hidden" id="totalComent" value="'.$cantidadComentarios.'"/>
                                                               </div>  
                                                           </div>
                                                           <div class="botonitemcerca botonblue">Ver comentarios</div>';
                                 $tagsHidden = '';
                                                    foreach ($dcto['tags'] as $tags){

                                                            $tagsHidden.= $tags;
                                                            $tagsHidden.= ',';
                                                    }
                                                $listevents.= '</div>';                              
                          $arreglo[] = array('id'=>(string)$dcto['_id'],
                                             'hash'=>$dcto['hash'],
                                             'event-right'=>$listevents,
                                             'info'=>$infoEventCerca,
                                             'tags'=>$tagsHidden,
                                             'nombre'=>$dcto['nombre']);  
                    }
                    //$listevents.= '</div>';
                    $infodiv.= '<div id="number">'.$cont.'</div>';
                    $arr = array('listevents'=>$listevents,
                                 'infodiv'=>$infodiv,
                                 'arreglo'=>$arreglo);
                    return $arr;
       }
       function eventoscernanos5($eventsNears){
            $cont = 0; //cantidad de eventos encontrados para mostrarlos en el mapa
            //$listevents = '<div class="eventsnear">';
            $listevents = '';
            $listevents2 = '';
            $todos = '';
            $arreglo = array();
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
                        $listevents.= '<div data-id="'.$dcto['_id'].'" data-hash="'.$dcto['hash'].'" class="item-eventcerca">';
                        $listevents.= '<div class="barra"></div>
                                            <div class="event-right">
                                                        <div class="event-left" style="background-image:url('.$url.'); background-size: cover"></div>
                                                         <div class="num-event"></div>';
                                  $nombreLink = str_replace(' ', '-', $dcto['nombre']);
                                  $realizacion = $e->formatoFecha($dcto['fecha_muestra'], $dcto['hora_inicio'],1);
                                  $cantidadComentarios = $e->verCantidadComentarios($dcto['_id']);
                                    $textoComentario = '';
                                    if($cantidadComentarios == 0){
                                        $textoComentario = 'Se el primero en comentar!';
                                    }elseif($cantidadComentarios == 1){
                                        $textoComentario = 'Un comentario';
                                    }else{
                                        $textoComentario = '<span class="bold">'.$cantidadComentarios.'</span> Comentarios';
                                    }
                                  $listevents.= '   <a target="_blank" href="/findbreak/break/'.$dcto['_id'].'" class="tit-eventcerca" >'.$dcto['nombre'].'</a>
                                                       <div class="info-eventcerca info-eventcercawhte">
                                                           <div class="item-infocerca">
                                                               
                                                               <div id="fechaevent" class="resp-cuando">'.$realizacion['fecha'].'</div>
                                                           </div>
                                                            <div class="item-infocerca">
                                                                    <div id="horaevent" class="resp-cuando">'.$realizacion['hora'].' hrs.</div>
                                                           </div>
                                                           <div class="item-infocerca">
                                                                
                                                                <div id="dondeevent" class="resp-cuando">'.$dcto['direccion'].'</div>
                                                            </div>
                                                            
                                                            
                                                            
                                                            <div class="item-infocerca">
                                                                <div id="visitavent-prof" class="info-event-item resp-cuando">
                                                                   <div>Visto por <span class="bold">'.$dcto['visitas'].'</span></div>
                                                                   <div id="comentaevent-prof">'.$textoComentario.'</div>
                                                                   <input type="hidden" id="totalComent" value="'.$cantidadComentarios.'"/>
                                                               </div>  
                                                           </div>
                                                           <div class="botonitemcerca botonblue">Ver comentarios</div>
                                                        
                                                      </div>
                                                     
                                                 ';     
                          $listevents.= '</div>';
//                                        $listevents.= '<div class="tags-hidden">';
//                                        foreach ($dcto['tags'] as $tags){
//                                             
//                                                $listevents.= $tags;
//                                                $listevents.= ',';
//                                        }
//                                        $listevents.= '</div>';
                                      
                                        //PARTE 2
                                        
                                          $listevents2='</div></div><div class="coment-cerca">';
                                            //aca
                                                    if(isset($_SESSION['userid'])){ 
                                                            $listevents2.= '<div  class="coments">';
                                                            $listevents2.= '  <input type="hidden" id="idevent" value="'.$dcto['_id'].'"/>';
                                                            $listevents2.= '  <input type="hidden" id="hashevent" value="'.$dcto['hash'].'"/>';
                                                            $listevents2.= '  <div class="input-transcom">';
                                                            $listevents2.= '     <div class="hash">'.$dcto['hash'].'</div>';
                                                            $listevents2.= '     <div id="overcoment">';
                                                            $listevents2.= '     <textarea class="textoajustable" id="coment"></textarea>';
                                                            $listevents2.= '  </div>
                                                                                <div id="replica"></div>
                                                                            </div>
                                                                            <div class="showfocuscom">
                                                                                <div class="divcitar">@</div>
                                                                                <div class="amigosCitar"></div>
                                                                                <input type="button" class="botonblue" id="btn-comentar" value="Comentar" />
                                                                            </div>

                                                                </div>';
                                                           }
                                                          else{ //si no esta logueado no puedo comentar 
                                                                 $listevents2.= '<div  class="coments-nolog">
                                                                     <input type="hidden" id="idevent" value="'.$dcto['_id'].'"/>
                                                                     <input type="hidden" id="hashevent" value="'.$dcto['hash'].'"/>
                                                                    <div class="advert mjscoment">
                                                                        Para comentar el evento debes <a class="login-hover login-hover-com" href="#">Iniciar sesión</a> ó
                                                                        <a class="paracoment" id="login-fb" href="">
                                                                            <div id="loginbtn-fb"></div>
                                                                            <div class="txtfb">Ingresar con Facebook</div>
                                                                        </a>
                                                                    </div>
                                                                </div>';
                                                           } 
                                          $listevents2.= '<div  class="list boxscroll">';
                                                            

                                          $listevents2.= '</div>';   
                                         //fin aca     
                                        $listevents2.='</div>';
                                        
                          $listevents2.= '</div>'; 
                          $arreglo[] = array('parte1'=>$listevents,'parte2'=>$listevents2);
                          $todos.=$listevents.$listevents2;
                    }
                    $listevents.= '</div>';
                   $infodiv.= '<div id="number">'.$cont.'</div>';
                    
                    
                    $arr = array('listevents'=>$todos,
                                 'arreglo'=>$arreglo,
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
            $arreglo =  $arr['arreglo'];
            //$number = $arr['number'];
            $resp = array("infodiv"=>$infodiv,
                          "listevents"=>$listevents,
                          "arreglo"=>$arreglo
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
            $fechas = explode(',', $fec);  
            $fechMongo = array();
            for($i=0; $i<count($fechas); $i++){
                $fechMongo[] = new MongoDate(strtotime($fec.' 23:59:59')); 
            }
           // $fechMongo = new MongoDate(strtotime($fec.' 23:59:59')); 
            $tag = $_POST["tagsevent"];
            $lat = $_POST["lat"];
            $lng = $_POST["lng"];
            $desc = $_POST['descripcionevent'];
            $urltwitter = $_POST['urltwitter'];
            $urlfacebook = $_POST['urlface'];
            
            
            $evento = new evento();
                                    
            echo $evento->insertar($idproductora, $nombreproductora, $nom, $dir, $arrayfotos, $fechas, $fechMongo,$hor, $tag, $lat, $lng, $desc,$urlfacebook,$urltwitter);
        }
        
        
        
?>
