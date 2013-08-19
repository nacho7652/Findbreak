<?php
    require_once '../DAL/connect.php';
    require_once '../DAL/evento.php';
    require_once '../DAL/comentario.php';
    date_default_timezone_set("Chile/Continental");
    
     if(isset($_GET['foto'])){
         session_start();
         require_once '../DAL/usuario.php';
        $usuario = new usuario();
        $usu =  $usuario->verFoto($_SESSION['userid']);
        echo $usu['foto'];
     }
    if(isset($_POST['vercomentario'])){
        session_start();
        require_once '../DAL/usuario.php';
        $usuario = new usuario();
        $evento = new evento();
        $id = $_POST['id'];
        $comentarios = new comentario();
        $comentarios->revisado($id);//dejo la notificacion como revisada
        $not = $comentarios->findNotificacionForId($id);
        $coment = $comentarios->findcomentarioforid($not['idComentario']);
        $event = $evento->findforid($coment['_eventId']);
        $quienCito = $usuario->findforid($coment['_userId']);
      //  $fotoEvento = $evento->verFoto($coment['_eventId']);
        $cuerpo = '<div class="divmencionevent">';
       // $cuerpo.= '<div style="background: url('.$fotoEvento.'); background-size: cover" class="foto-event"></div>';//$event['foto'][0]
        $cuerpo.= '<div class="tit title-event">'.$event['nombre'].'</div>';
        $cuerpo.= '<div class="bloq2msj"><div class="itemcomentmsj">';
        $cuerpo.=   '<div style="background: url('.$quienCito['foto']['pe'].')" class="bloq1"></div>';
        $cuerpo.=   '<div class="bloq2msjinner">';
        $cuerpo.=       '<div class="nomusercom tit">'.ucwords($quienCito['nombre']).'</div>';
        $cuerpo.=       '<div class="comentuser"><a href="/break/'.$event['hash'].'" class="hashlink">'.$event['hash'].'</a>'.$coment['comentario'].'</div>';
        $cuerpo.=   '</div>';
        $cuerpo.= '<div class="bloq3msjinner">';
        $realizacion = $comentarios->verFecha($coment['fechaMuestra']);
        $cuerpo.=    '<div class="hacecuant">'.$realizacion.'</div>';
        $cuerpo.= '</div></div></div></div>';
        
        $theObjId = new MongoId($coment['_eventId']);
        $todosComent = $comentarios->findOtrasMenciones($_SESSION['userid'], 4);
//        $html = '<div class="otroscoment">
//                   <div class="tit titotros">Otras menciones</div>';
//        foreach ($todosComent as $dcto){
//            if($dcto['_id'] != $not['idComentario']){
//                $userFoto = $usuario->verFoto($dcto['_userId']);
//                $useridComent = $dcto['_userId'];
//                $realizacion = $comentarios->verFecha($dcto['fechaMuestra']);
//                $html.='<div class="itemcoment">
//                            <div class="line"></div>
//                            <div class="bloq1" style="'.$userFoto['foto'].'"></div>
//                            <div class="bloq2">
//                                
//                                <div class="titu-usercom">
//                                    <a href="/findbreak/!'.$dcto['userName'].'" class="nomusercom tit-gray">'.$dcto['nombreUsuario'].'</a>
//                                    <spam class="username usernamecom">@'.$dcto['userName'].'</spam>
//                                </div>
//                                <div class="comentuser">
//                                <!--<a href="/findbreak/break/'.$event['hash'].' " class="hashlink">'.$event['hash'].'</a>-->
//                                                        '.$dcto['comentario'].'
//                                </div>
//                            </div>
//                            <div class="bloq3">
//                                    <div class="hacecuant">
//                                        '.$realizacion.'
//                                    </div>';
//                                if($useridComent == $_SESSION['userid']){
//                                   $html.= '<div data-id="'.$dcto['_id'].'" id="delcoment" class="aparececom">Eliminar</div>';
//                               }else{
//                                   $html.= '<div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
//                               }
//                        $html.='
//                              </div>
//                          </div>';
//            }
//        }
//        $html.='</div>';
        $re = $cuerpo; //.$html  
        echo $re;
    }
    
    
    if(isset($_POST['delcoment'])){
        $dataid = $_POST['dataid'];
        $comentarios = new comentario();
        echo $comentarios->eliminar($dataid);     
    }
    
    //comenteventUser
    if(isset($_REQUEST['comenteventUser'])){
        session_start();
        $limit = $_REQUEST['ultimo'];//8
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $nombreUsuario = $_SESSION['nombre'];
        $comentario = $_REQUEST['comentario'];
        $evenId = $_REQUEST['eventId'];
        $hashevent = $_REQUEST['hashevent'];
        $nombreevent = $_REQUEST['nombreevent'];
        $comentarios = new comentario();
        $usuario = new usuario();
        $totalComent = $_REQUEST['totalComent'];//8
        
        $fecha = date('Y-m-d H:i:s');
        $comentarios->guardarComentarioEvento($comentario,$userId,$evenId,$userName,$nombreUsuario, $fecha,$nombreevent,$hashevent );
        
        //cargar comentarios
        $todosComent = $comentarios->verMisComentarios($userId);
        $html = '';
        $numComent = 0;
        foreach ($todosComent as $dcto){
            $userFoto = $usuario->verFoto($dcto['_userId']);
            $useridComent = $dcto['_userId'];
            $realizacion = $comentarios->verFecha($dcto['fechaMuestra']);
            $html.='<div data-num="'.$numComent.'" class="itemcoment">
                        <div class="line"></div>
                        <div class="bloq1"  style="background: url('.$userFoto['foto']['pe'].') no-repeat"></div>
                        <div class="bloq2">
                            <div class="titu-usercom">
                               <a href="/!'.$dcto['userName'].'" class="nomusercom tit-gray">'.ucwords($dcto['nombreUsuario']).'</a>
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
                            if($useridComent == $_SESSION['userid']){
                               $html.= '<div data-id="'.$dcto['_id'].'" id="delcoment" class="aparececom">Eliminar</div>';
                           }else{
                               $html.= '<div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
                           }
                    $html.='
                          </div>
                      </div>';
                    $numComent++;
        }
        $comentRestantes = $totalComent - $numComent;
        if($comentRestantes > 0)
         $html.='<a href="#" class="leermas-comentuser readmorecoment">Ver más comentarios</a>';
        echo $html;      
    }
    if(isset($_REQUEST['comentevent'])){
        session_start();
        $limit = $_REQUEST['ultimo'];//8
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $nombreUsuario = $_SESSION['nombre'];
        $comentario = $_REQUEST['comentario'];
        $evenId = $_REQUEST['eventId'];
        $hashevent = $_REQUEST['hashevent'];
        $nombreevent = $_REQUEST['nombreevent'];
        $comentarios = new comentario();
        $totalComent = $_REQUEST['totalComent'];//8
        $usuario = new usuario();
        $fecha = date('Y-m-d H:i:s');
        $comentarios->guardarComentarioEvento($comentario,$userId,$evenId,$userName,$nombreUsuario, $fecha,$nombreevent,$hashevent );
        
        //cargar comentarios
        $theObjId = new MongoId($evenId);
        $todosComent = $comentarios->findUltimoscoment($theObjId, 10);
        $html = '';
        $numComent = 0;
        foreach ($todosComent as $dcto){
            $useridComent = $dcto['_userId'];
            $realizacion = $comentarios->verFecha($dcto['fechaMuestra']);
            $userFoto = $usuario->verFoto($dcto['_userId']);
            $html.='<div data-num="'.$numComent.'" class="itemcoment">
                        <div class="line"></div>
                        <div class="bloq1" style="background: url('.$userFoto['foto']['pe'].') no-repeat"></div>
                        <div class="bloq2">
                            <div class="titu-usercom">
                               <a href="/!'.$dcto['userName'].'" class="nomusercom tit-gray">'.ucwords($dcto['nombreUsuario']).'</a>
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
                            if($useridComent == $_SESSION['userid']){
                               $html.= '<div data-id="'.$dcto['_id'].'" id="delcoment" class="aparececom">Eliminar</div>';
                           }else{
                               $html.= '<div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
                           }
                    $html.='
                          </div>
                      </div>';
                    $numComent++;
        }
        $comentRestantes = $totalComent - $numComent;
        if($comentRestantes > 0)
         $html.='<a href="#" class="leermas-coment readmorecoment">Ver más comentarios</a>';
        echo $html;      
    }
     if(isset($_REQUEST['vermascomentarios'])){
        session_start();       
        //cargar comentarios
        $limit = $_REQUEST['ultimo'];//10
        $evenId = $_REQUEST['eventid'];
        if(isset($_REQUEST['cerca'])){
            $vieneCerca = $_REQUEST['cerca'];
        }else{
            $vieneCerca = -1;
        }
        $hashevent = $_REQUEST['hashevent'];
        $totalComent = $_REQUEST['totalComent'];//14
        $comentRestantes = $totalComent - $limit;//14-10 = 4
        $comentarios = new comentario();
        $limit+= 5; //de a 5
        $comentRestantes = $comentRestantes - 5;
        $usuario = new usuario();
        $theObjId = new MongoId($evenId);
        $todosComent = $comentarios->findUltimoscoment($theObjId, $limit);
        $html = '';
        $numComent = 0;
        foreach ($todosComent as $dcto){
            
            $userFoto = $usuario->verFoto($dcto['_userId']);
            $useridComent = $dcto['_userId'];
            $realizacion = $comentarios->verFecha($dcto['fechaMuestra']);
            $html.='<div data-num="'.$numComent.'" class="itemcoment">
                        <div class="line"></div>
                        <div class="bloq1" style="background: url('.$userFoto['foto']['pe'].') no-repeat"></div>
                        <div class="bloq2">
                            <div class="titu-usercom">
                               <a href="/!'.$dcto['userName'].'" class="nomusercom tit-gray">'.ucwords($dcto['nombreUsuario']).'</a>
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
                                   $html.= '<div data-id="'.$dcto['_id'].'" id="delcoment" class="aparececom">Eliminar</div>';
                               }else{
                                   $html.= '<div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
                               }
                          }else{
                              $html.= '<div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
                          
                          }                   
                          
                    $html.='
                          </div>
                      </div>';
                    $numComent++;
        }
        if($vieneCerca == 1){
            if($comentRestantes > 0)
            $html.='<a  href="#" class="leermas-comentcerca readmorecoment">Ver más comentarios</a>';
        }else{
            if($comentRestantes > 0)
            $html.='<a  href="#" class="leermas-coment readmorecoment">Ver más comentarios</a>';
        }
        
        echo $html;      
    }
     if(isset($_REQUEST['vermascomentariosUser'])){
        session_start();       
        //cargar comentarios
        $limit = $_REQUEST['ultimo'];//10
        $iduser = $_REQUEST['iduser'];//USER ID
//        $hashevent = $_REQUEST['hashevent'];
        $totalComent = $_REQUEST['totalComent'];//14
        $comentRestantes = $totalComent - $limit;//14-10 = 4
        $comentarios = new comentario();
        $limit+= 5; //de a 5
        $comentRestantes = $comentRestantes - 5;
        $usuario = new usuario();
        $theObjId = new MongoId($iduser);
        $todosComent = $comentarios->verMisComentarios($theObjId);
        $html = '';
        $numComent = 0;
        foreach ($todosComent as $dcto){
            $useridComent = $dcto['_userId'];
            $realizacion = $comentarios->verFecha($dcto['fechaMuestra']);
            $userFoto = $usuario->verFoto($dcto['_userId']);
            $html.='<div data-num="'.$numComent.'" class="itemcoment">
                        <div class="line"></div>
                        <div class="bloq1" style="background: url('.$userFoto['foto']['pe'].') no-repeat"></div>
                        <div class="bloq2">
                            <div class="titu-usercom">
                               <a href="/!'.$dcto['userName'].'" class="nomusercom tit-gray">'.ucwords($dcto['nombreUsuario']).'</a>
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
                                   $html.= '<div data-id="'.$dcto['_id'].'" id="delcoment" class="aparececom">Eliminar</div>';
                               }else{
                                   $html.= '<div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
                               }
                          }else{
                              $html.= '<div data-id="'.$dcto['_id'].'" id="compartircoment" class="aparececom">Compartir</div>';
                          
                          }                   
                          
                    $html.='
                          </div>
                      </div>';
                    $numComent++;
        }
        if($comentRestantes > 0)
            $html.='<a  href="#" class="leermas-comentuser readmorecoment">Ver más comentarios</a>';
        echo $html;      
    }
?>                    