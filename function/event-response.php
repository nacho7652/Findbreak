<?php
        session_start();
        require_once '../DAL/connect.php';
        require_once '../DAL/evento.php';
        require_once '../DAL/usuario.php';
        require_once '../DAL/establecimiento.php';
        require_once '../DAL/comentario.php';
        require_once '../DAL/usuarioRelacional.php';
        require_once 'allfunction.php';
        
        
        if(!empty($_REQUEST['mismoLugar']))
        {
            $event = new evento(); 
            $lat = -33.5434941;
            $lng =  -70.59482120000001;       
            $re = $event->comprobarMismoLugar($lat, $lng);
            echo count(iterator_to_array($re));
        }
        if(!empty($_REQUEST['ano']))
        {
            $event = new evento();
            $nombre = $_REQUEST['nombre'];
            $direccion = $_REQUEST['direccion'];  
            $lat = $_REQUEST['lat'];
            $lng = $_REQUEST['lng'];
            for($i=0; $i<1000; $i++)
             $re = $event->insertarFacil_ano(1, 'nombre_prueba', 'username_prueba', $nombre+$i, $direccion, $lat, $lng);
            echo $re;
            
        }
        if(!empty($_REQUEST['guardar-facil']))
        {
            $event = new evento();
            $nombre = $_REQUEST['nombre'];
            $direccion = $_REQUEST['direccion'];  
            $lat = $_REQUEST['lat'];
            $lng = $_REQUEST['lng'];
            $latLng = $lat.'_'.$lng;
            $re = $event->insertarFacil($_SESSION['userid'], $_SESSION['nombre'], $_SESSION['username'], $nombre, $direccion, $lat, $lng, $latLng);
            echo $re;
            
        }
        //price
        if(!empty($_REQUEST['denuncia-evento']))
        {
            $idEvento = $_REQUEST['evento'];
            $nomUser = $_REQUEST['user'];
            $iduser = $_SESSION['userid'];
            $resp = new usuarioRelacional();
            $para  = 'nacho1593@hotmail.com'.', '; // atención a la coma
            $para .= 'skumblue@live.cl'.', ';
            $para .= 'danitow@live.cl';
            $headers = "From: Denuncia <denuncia@nowsup.com>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "Content-Transfer-Encoding: 8bit\r\n";
            $usuario = new usuario();
            $evento = new evento();
            $comentario = $_REQUEST['comentario'];
            $fecha = date('Y-m-d H:i:s');
            $fechaMongo = new MongoDate(strtotime($fecha));
            $compfecha = $usuario->ultimaFechaDenuncia($iduser, $idEvento);
            $ultimaFecha = null;
            $body = "La publicación: ".$idEvento;
            $body .= "</br>ha sido denunciado por: ".$comentario;
            $body .= "</br>por el usuario: ".$nomUser;
            $body .= "</br>desde la ip: ".$evento->getIP();
            $body .= "</br>el día: ".date('d-m-Y');
            $body .= "</br>a las: ".date('H:i:s');
            foreach($compfecha as $key){
                $ultimaFecha = $key['fechaMongo'];
            }
            
            $re = 0;
            if($ultimaFecha == null){//se puede
                $usuario->guardarDenuncia($nomUser,$idEvento, $comentario,date('d-m-Y'), date('H:i:s'), $evento->getIP());
                mail($para, 'Denuncia', $body, $headers);
                $re = 1;
            }else{
                if(strtotime($ultimaFecha) == strtotime($fechaMongo))
                {
                    $re = -1;
                }
                else 
                {

                    $usuario->guardarDenuncia($nomUser,$idEvento, $comentario,date('d-m-Y'), date('H:i:s'), $evento->getIP());
                    mail($para, 'Denuncia', $body, $headers);
                    $re = 1;
                }
            }
            echo $re;
//            if($resp->ValidarSaldo($_SESSION['userid']) >= $resp->VerPrecioEvento($idProducidoPor, $idEvento))
//            {
//                $resp->CambiarVigencia($idProducidoPor, $idEvento);
//                $precioEvent = $resp->VerPrecioEvento($idProducidoPor, $idEvento);
//                $pafindbreak = $precioEvent*0.2;
//                $RestarSaldoUsuario = $precioEvent;
//                $SumarSaldoAUsuario = $precioEvent-$pafindbreak;
//                $resp->PagoCompraEvento($SumarSaldoAUsuario, $idProducidoPor);
//                $resp->PagoCompraEvento(-1*$RestarSaldoUsuario, $_SESSION['userid']);
//                $resp->GuardarEvento_____Usuario($idEvento, $_SESSION['userid'], ($precioEvent+($precioEvent/2)), $resp->VerPiso($idProducidoPor, $idEvento), $pafindbreak);
//                //notificar
//                $nombre_id_event = $evento->verNombre($idEvento);
//                $fecha = date('Y-m-d H:i:s');
//                $fechaMongo = new MongoDate(strtotime($fecha));
//                $usuario->guardarNotificacion3($_SESSION['userid'], $idProducidoPor,$nombre_id_event, $fechaMongo, $fecha);
//                echo "ok";
//            }
//            else
//                echo "SALDO INSUFICIENTE";
           // $eventoR->GuardarEvento_____Usuario($idMongoEvento, $_SESSION['userid'], $valor_compra, $piso);
            
        }
        
 //modificarFotos=1&idEvento='+idEvento+"&urlBorrar="+url+"&nombreBorrar="+nombre+"&fotoGr="+fotoGr
   if(!empty($_REQUEST['modificarFotos']))
        {
            $evento = new evento();
            $idEvento = $_REQUEST['idEvento'];
            $urlBorrar = $_REQUEST['urlBorrar'];
            $nombreBorrar = $_REQUEST['nombreBorrar'];
            $fotoGr = $_REQUEST['fotoGr'];
            $re = $evento->reemplazarFoto($idEvento, $urlBorrar, $nombreBorrar, $fotoGr);
            echo $re;
        }  
   if(!empty($_REQUEST['eliminarFoto']))
        {
            $evento = new evento();
            $idEvento = $_REQUEST['idEvento'];
            $urlBorrar = $_REQUEST['urlBorrar'];
            $urlBorrarPe = $_REQUEST['urlBorrarPe'];
            $nombreBorrar = $_REQUEST['nombreBorrar'];
            $nombreBorrarPe = $_REQUEST['nombreBorrarPe'];
            $numero = $_REQUEST['numero'];
            
            $re = $evento->eliminarFoto($idEvento, $urlBorrar, $nombreBorrar,$numero,'gr');//gr
            $rePe = $evento->eliminarFoto($idEvento, $urlBorrarPe, $nombreBorrarPe,$numero,'pe');//pe
            echo $re;
        }  
   if(!empty($_REQUEST['delEvento']))
        {
            $evento = new evento();
            $idEvento = $_REQUEST['dataid'];
            $re = $evento->eliminar($idEvento);
            echo $re;
        }  
 //delEvento
        if(!empty($_REQUEST['nuevaFoto']))
        {
            $evento = new evento();
            $idEvento = $_REQUEST['idEvento'];
            $fotoGr = $_REQUEST['fotoGr'];
            $re = $evento->nuevaFoto($idEvento, $fotoGr);
            $urlSinImg = 'images/usuarios';
            $resp = array('re'=>$re, 'urlSinImg'=>$urlSinImg);
            echo json_encode($resp);
        } 
  if(!empty($_REQUEST["comprobarHashTag"])){
        $evento = new evento();
        $conEspacios = $_REQUEST['conEspacios'];
        //palabras en mayusculas
        $palabras = explode(" ", $conEspacios);
        $juntos = '';
        for($i=0; $i<count($palabras); $i++){
            $mayusPal = ucwords($palabras[$i]);
            $juntos.=$mayusPal;
        }
//        $enmayusculas = ucwords($juntos);
        
        $hashLimpio = clearDir($juntos,false);//lo limpio
        $hashmin = strtolower($hashLimpio);//lo paso a min
        $re = $evento->comprobarHashTag($hashmin);//compruebo en contra del hashtag en min
 
        if($re == null){//se puede
            $final = array('re'=>1,'limpio'=>$hashLimpio);
            echo json_encode($final);
        }else{
            $final = array('re'=>-1,'limpio'=>$hashLimpio);
            echo json_encode($final);
        }   
    }
    if(!empty($_REQUEST["comprobarHashTag2"])){
        $evento = new evento();
        $sinEspacios = $_REQUEST['sinEspacios'];
        $hashLimpio = clearDir($sinEspacios,false);//lo limpio
        $hashmin = strtolower($hashLimpio);//lo paso a min
        $re = $evento->comprobarHashTag($hashmin);//compruebo en contra del hashtag en min
 
        if($re == null){//se puede
            $final = array('re'=>1,'limpio'=>$hashLimpio);
            echo json_encode($final);
        }else{
            $final = array('re'=>-1,'limpio'=>$hashLimpio);
            echo json_encode($final);
        }   
    }
   if(!empty($_REQUEST["nuevotag"])){
       $evento = new evento();
       $nombre = $_REQUEST['nombre'];
       echo $evento->agregarTag($nombre);
            
    }
    if(!empty($_REQUEST["buscartag"])){
       $evento = new evento();
       $nombre = $_REQUEST['nombre'];
       $encontrados =  $evento->buscarTagPorCoincidencia($nombre);
       $re = '';
       $hay = 0;
       foreach($encontrados as $dcto){
            $hay = 1;
            $re.= '<div class="item-search nombres-tag tit-gray">'.$dcto['nombre'].'</div>';
       }
       
       if($hay == 1){
           echo $re;
       }else{
           echo '<div class="item-search nombres-tag tit-gray tagNuevo">'.$nombre.'</div>';
       }
    }
    if(!empty($_POST["search-event-cit"])){
                    $evento = new evento();
                    $popular = $evento->findpopular(3);
                    $html = '';
                    $limite = 3;
                    foreach ($popular as $item){
                        if($limite > 0){
                            $html.= '<div data-id="'.$item['_id'].'" class="item-event-citar">
                                                   <div style="background-image:url(http://images.ak.instagram.com/profiles/profile_144600501_75sq_1364906070.jpg)" class="item-evento-foto"></div>
                                                   <div class="item-evento-name">#'.$item['hash'].'</div>
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
        $usuario = new usuario();
        $event = new evento();
//        $listcoment = '';
//        if(isset($_SESSION['userid'])){ 
//            $listcoment.= '<div  class="coments">';
//            $listcoment.= '  <input type="hidden" class="idevent" value="'.$idEvento.'"/>';
//            $listcoment.= '  <input type="hidden" class="hashevent" value="'.$hashevent.'"/>
//                             <input type="hidden" class="nombreevent" value="'.$hashevent.'"/>';
//            $listcoment.= '  <div class="input-transcom">';
//            $listcoment.= '     <div class="hash">#'.$hashevent.'</div>';
//            $listcoment.= '     <div id="overcoment">';
//            $listcoment.= '     <textarea class="textoajustable" id="coment"></textarea>';
//            $listcoment.= '  </div>
//                                <div id="replica"></div>
//                            </div>
//                            <div class="showfocuscom">
//                                <div class="divcitar">@</div>
//                                <div class="amigosCitar"></div>
//                                <input type="button" class="botonblue btn-comentar-cerca" value="Comentar" />
//                            </div>
//
//                </div>';
//           }
//          else{ //si no esta logueado no puedo comentar 
//                 $listcoment.= '<div  class="coments-nolog">
//                     <input type="hidden" class="idevent" value="'.$idEvento.'"/>
//                     <input type="hidden" class="hashevent" value="'.$hashevent.'"/>
//                    <div class="advert mjscoment">
//                        Para comentar el evento debes <a class="login-hover login-hover-com" href="#">Iniciar sesión</a> ó
//                        <a class="paracoment login-fb login-face" href="">
//                            <div id="loginbtn-fb"></div>
//                            <div class="txtfb">Ingresar con Facebook</div>
//                        </a>
//                    </div>
//                </div>';
//           } 
//         $listcoment = '';
//         $listcoment.= '<div class="list boxscroll">';
          $listcoment = '';      
                $theObjId = new MongoId($idEvento);
                $comentarios = $comentarioEvent->findforid($theObjId);
                $numComent = 0;
                foreach($comentarios as $dcto){
                     $userFoto = $usuario->verFoto($dcto['_userId']);
                     $realizacion = $comentarioEvent->verFecha($dcto['fechaMuestra']);
                     $useridComent = $dcto['_userId'];
                
                    $listcoment.= '<div data-num="'.$numComent.'" class="itemcoment">
                               <div class="line"></div>
                               <div class="bloq1" style="background:url('.$userFoto['foto']['pe'].')"></div>
                               <div class="bloq2">
                                <div class="titu-usercom">
                                    <a href="/findbreak/!'.$dcto['userName'].'" class="nomusercom tit-gray">'.$dcto['nombreUsuario'].'</a>
                                    <spam class="username usernamecom">@'.$dcto['userName'].'</spam>
                                </div>
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
                     $listcoment.= '<a  href="#" class="leermas-comentcerca readmorecoment">Ver más comentarios</a>';
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
                $fotoEvento = $evento->verFoto($dcto['_id']);
                $cuadroevento.= 
                '<a href="/findbreak/break/'.$dcto['hash'].'" target="_blank" class="'.$classPrimero.' item-search item-search-event">
                   <div style="background:url('.$fotoEvento.'); background-size:cover"  class="foto-item-search"></div>
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
                $fotoEvento = $evento->verFoto($dcto['_id']);
                $cuadroevento.= 
                '<a href="/findbreak/break/'.$dcto['hash'].'" target="_blank" class="'.$classPrimero.' item-search item-search-event">
                   <div style="background:url('.$fotoEvento.'); background-size:cover" class="foto-item-search"></div>
                   <div class="name-item-search tit-gray">'.$dcto["nombre"].'</div>
                   <div style="display:none" class="id-item-search">'.$dcto["_id"].'</div>
                </a>';
                
            }
            $re = array('hay'=>$hayevents,'re'=>$cuadroevento);
            echo json_encode($re);
    }

       function verNote($hash, $fotos, $nombre, $mismo_lugar, $lat_lng){
            $event = new evento(); 
            $note = '<div id="infoWindow">';
            if($mismo_lugar > 0){
                $anuncios = $event->comprobarMismoLugar2($lat_lng);
                    foreach ($anuncios as $dctos){
                        $note.= '<div class="item-info">
                                            <a href="/break/'.$dctos['hash'].'">
                                                <img class="fotopin" src="'.$dctos['fotos'][0]['pe'].'" />
                                                <string class="tit-gray titpin">'.$dctos['nombre'].'</strong>
                                            </a>
                                 </div>';
                    }

                }else{
                    $note = '<div class="item-info">
                                            <a href="/break/'.$hash.'">
                                                <img class="fotopin" src="'.$fotos[0]['pe'].'" />
                                                <string class="tit-gray titpin">'.$nombre.'</strong>
                                            </a>
                                 </div>';
                }
            $note.= '</div>';
            return $note;
            
        }
       function eventoscernanos($eventsNears){
           $cont = 0; //cantidad de eventos encontrados para mostrarlos en el mapa
            //$listevents = '<div class="eventsnear">';
            $listevents = '';
            $infodiv = '';
            $e = new evento();
            $arreglo = array();
             foreach ($eventsNears as $dcto){
                    $folder = (string)$dcto['producido_por']['_id'];
                        $url = 'background:url(/images/anuncios/'.$dcto['fotos'][0]['gr'].'); background-size: cover';
                        $urlPe = '/images/anuncios/'.$dcto['fotos'][0]['pe'];
                        //Con esta info. el mapa de google muestra los pines
                         $note = verNote($dcto['hash'], $dcto['fotos'], $dcto['nombre'], $dcto['mismo_lugar'], $dcto['lat_lng']);
                         $infodiv = $infodiv.'<div id="info'.$cont.'">'.$dcto['nombre']."+".$dcto['fotos'][0]['gr']."+".
                                $dcto['loc'][0]."+".$dcto['loc'][1]."+".$urlPe."+".$dcto['hash'].'</div>'."\n";
                         $cont++;
                       //----0----   

                                  $nombreLink = str_replace(' ', '-', $dcto['nombre']);
                                  
                                  $cantidadComentarios = $e->verCantidadComentarios($dcto['_id']);
                                    $textoComentario = '';
                                    if($cantidadComentarios == 0){
                                        $textoComentario = 'Se el primero en comentar!';
                                    }elseif($cantidadComentarios == 1){
                                        $textoComentario = 'Un comentario';
                                    }else{
                                        $textoComentario = '<span class="bold">'.$cantidadComentarios.'</span> Comentarios';
                                    }
                                    $size = 100;
                                    $str = $dcto['descripcion'];
                                    // substr se usa para cortar la cadena y trim para eliminar el posible espacio del final para que no quede "ultima palabra(espacio)..."
                                    $str = trim(substr($str, 0, $size));
                                    if(strlen($dcto['descripcion']) > 100)
                                    $str .= '<span >...</span>';
                                  
                                     $infoEventCerca = '<div style="'.$url.'" class="event-left"></div>
                                                           <div class="item-infocerca">
                                                                
                                                                <div id="dondeevent" class="resp-cuando">'.$dcto['direccion'].'</div>
                                                                <a id="verEnMapa'.$cont.'" href="#" class="verEnMapa">Ver en mapa</a> 
                                                                <input type="hidden" value="'.$dcto['loc'][0].'" class="latHidden"/>
                                                                <input type="hidden" value="'.$dcto['loc'][1].'" class="lngHidden"/>
                                                            </div>
                                                            
                                                            
                                                            
                                                            <div class="item-infocerca">
                                                                <div class="item-visita">
                                                                    <div id="visitavent-prof"></div>
                                                                    <span>Visto por </span>
                                                                    <span class="bold">'.$dcto['visitas'].'</span>
                                                                </div>
                                                                <div class="item-visita">
                                                                    <div id="comentaevent-prof"></div>
                                                                    <div class="textoComentario">'.$textoComentario.'</div>
                                                                    <input type="hidden" id="totalComent" value="'.$cantidadComentarios.'">
                                                                </div>
                                                           </div>
                                                           <div class="item-infocerca">
                                                                <div class="descripcion-cerca">
                                                                    '.$str.'
                                                                </div>
                                                           </div>
                                                           
                                                           <a href="http://www.nowsup.com/break/'.$dcto['hash'].'" class="botonitem-vermas botongreen">Ver más</a>
                                                           <div class="botonitemcerca botonblue">Ver comentarios</div>
                                                            <div class="verRuta">¿Cómo llegar?</div>';
                                 $tagsHidden = '';
                                                    foreach ($dcto['tags'] as $tags){

                                                            $tagsHidden.= $tags;
                                                            $tagsHidden.= ',';
                                                    }
                                                                 
                          $arreglo[] = array('id'=>(string)$dcto['_id'],
                                             'hash'=>$dcto['hash'],
                                             'info'=>$infoEventCerca,
                                             'tags'=>$tagsHidden,
                                             'foto'=>$url,
                                             'lat'=>$dcto['loc'][0],
                                             'lng'=>$dcto['loc'][1],
                                             'nombre'=>$dcto['nombre'],
                                             'verificacion'=>$dcto['verificacion'],
                                             'note'=>$note
                                  );  
                    }
                    //$listevents.= '</div>';
                    $infodiv.= '<div id="number">'.$cont.'</div>';
                    $arr = array('listevents'=>$listevents,
                                 'infodiv'=>$infodiv,
                                 'arreglo'=>$arreglo);
                    return $arr;
       }
       /*
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
                        $listevents.= '<div data-id="'.$dcto['_id'].'"  style="background-image:url('.$url.'); background-size: cover" data-hash="'.$dcto['hash'].'" class="item-eventcerca">';
                        $listevents.= '<div class="barra"></div>
                                            <div class="event-right">
                                                        
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
                                  $listevents.= '   <a target="_blank" href="/findbreak/break/'.$dcto['hash'].'" class="tit-eventcerca" >'.$dcto['nombre'].'</a>
                                                       <div class="info-eventcerca info-eventcercawhte">
                                                           <div class="event-left" style="background-image:url('.$url.'); background-size: cover"></div>
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
                                                            $listevents2.= '  <input type="hidden" class="idevent" value="'.$dcto['_id'].'"/>';
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
                                                                     <input type="hidden" class="idevent" value="'.$dcto['_id'].'"/>
                                                                     <input type="hidden" id="hashevent" value="'.$dcto['hash'].'"/>
                                                                    <div class="advert mjscoment">
                                                                        Para comentar el evento debes <a class="login-hover login-hover-com" href="#">Iniciar sesión</a> ó
                                                                        <a class="paracoment login-fb login-face"  href="">
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
        */
       if(isset($_REQUEST['findnear2'])){
            $lat = $_REQUEST['lat'];
            $long = $_REQUEST['lng'];
            $event = new evento();
            
            $eventsNears = $event->findnear((float)$lat, (float)$long);
            $arr = eventoscernanos($eventsNears);
            $infodiv = $arr['infodiv'];//información para que el mapa lea y muestre los pines con eventos
            $listevents = $arr['listevents'];
            $verif = $arr['verificacion'];
            $arreglo =  $arr['arreglo'];
            
            
            //$number = $arr['number'];
            $resp = array("infodiv"=>$infodiv,
                          "listevents"=>$listevents,
                          "arreglo"=>$arreglo
                         );
            echo json_encode($resp);
       }
       //findnear-eventos
       if(isset($_REQUEST['findnear-eventos'])){
            $q = $_REQUEST['q'];
            $event = new evento();
            $q = trim(strtolower($q));
            $eventsNears = $event->filtrar($q, 10);
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
       
//       if(isset($_REQUEST['findnear'])){
//            $lat = $_REQUEST['lat'];
//            $long = $_REQUEST['lng'];
//            $event = new evento();
//            
//            $eventsNears = $event->findnear((float)$lat, (float)$long);
//            $arr = eventoscernanos($eventsNears);
//            $infodiv = $arr['infodiv'];//información para que el mapa lea y muestre los pines con eventos
//            $listevents = $arr['listevents'];
//            
//            $eventpopular = $event->findpopular();
//            $listeventspop = eventospopulares($eventpopular);
//            
//            $eventsporfecha = $event->eventosPorRealizarOrderFecha(1);
//            $listeventsporfecha = eventosRealizadosPorFecha($eventsporfecha);
//           // $listeventsporfecha = $event->eventosPorRealizarOrderFecha();
//            
//                    $listeventsfavo = '';
//                    /*EVENTOS FAVORITOS*/
//                     if(isset($_SESSION['userid'])){
//                        $userid = $_SESSION['userid'];
//                        
//                        $usuario = new usuario();
//                        $usuariofound = $usuario->findforid($userid);
//                        if(count($usuariofound['tags_buscados']) > 0){
//                            $tagsfavoritos = $usuariofound['tags_buscados'];
//                            $eventsfavo = $usuario->verEventosFavoritos($tagsfavoritos);
//                            //for
//                            $listeventsfavo = eventosfavoritos($eventsfavo);     
//                        }
//                     }else{
//                         
//                     }
//
//            $resp = array("infodiv"=>$infodiv,
//                          "listevents"=>$listevents,
//                          "listeventspop"=>$listeventspop,
//                          "listeventsfavo"=>$listeventsfavo,
//                          "listeventsporfecha"=>$listeventsporfecha
//                         );
//            echo json_encode($resp);
//        }
       /* 
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
        */
        
        
?>
