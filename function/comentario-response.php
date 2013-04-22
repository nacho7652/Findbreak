<?php
    require_once '../DAL/connect.php';
    require_once '../DAL/evento.php';
    require_once '../DAL/comentario.php';
    date_default_timezone_set("Chile/Continental");
    if(isset($_POST['vercomentario'])){
        session_start();
        require_once '../DAL/usuario.php';
        $usuario = new usuario();
        $evento = new evento();
        $id = $_POST['id'];
        $comentarios = new comentario();
        $comentarios->revisado($id, $_SESSION['userid']);
        $coment = $comentarios->findcomentarioforid($id);
        $event = $evento->findforid($coment['_eventId']);
        $quienCito = $usuario->findforid($coment['_userId']);
        $cuerpo = '<div class="divmencionevent">';
        $cuerpo.= '<div class="foto-event"></div>';//$event['foto'][0]
        $cuerpo.= '<div class="tit title-event">'.$event['nombre'].'</div>';
        $cuerpo.= '<div class="bloq2msj"><div class="itemcomentmsj">';
        $cuerpo.=   '<div style="background: url('.$quienCito['foto'].')" class="bloq1"></div>';
        $cuerpo.=   '<div class="bloq2msjinner">';
        $cuerpo.=       '<div class="nomusercom tit">'.$quienCito['nombre'].'</div>';
        $cuerpo.=       '<div class="comentuser">'.$coment['comentario'].'</div>';
        $cuerpo.=   '</div>';
        $cuerpo.= '<div class="bloq3msjinner">';
        $realizacion = $comentarios->verFecha($coment['fechaMuestra']);
        $cuerpo.=    '<div class="hacecuant">'.$realizacion.'</div>';
        $cuerpo.= '</div></div></div></div>';
        
        $theObjId = new MongoId($coment['_eventId']);
        $todosComent = $comentarios->findUltimoscoment($theObjId, 3);
        $html = '<div class="otroscoment">
                   <div class="tit titotros">Últimos comentarios</div>';
        foreach ($todosComent as $dcto){
            $useridComent = $dcto['_userId'];
            $realizacion = $comentarios->verFecha($dcto['fechaMuestra']);
            $html.='<div class="itemcoment">
                        <div class="line"></div>
                        <div class="bloq1"></div>
                        <div class="bloq2">
                            
                            <div class="nomusercom tit">'.$dcto['userName'].'</div>
                            <div class="comentuser"><a href="#" class="hashlink">'.$event['hash'].'</a>
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
        }
        $html.='</div>';
        $re = $cuerpo.$html;  
        echo $re;
    }
    
    
    if(isset($_POST['delcoment'])){
        $dataid = $_POST['dataid'];
        $comentarios = new comentario();
        echo $comentarios->eliminar($dataid);     
    }
    
    if(isset($_POST['comentest'])){
        session_start();
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $comentario = $_POST['comentario'];
        $estaId = $_POST['estaId'];
        $comentarios = new comentario();
        $comentarios->guardarComentarioEstablecimiento($comentario, $userId, $estaId, $userName);
         $respuesta = array("exito"=>"funciono");
        $re = json_encode($respuesta);
        echo $re;      
    }
    
    if(isset($_REQUEST['comentevent'])){
        session_start();
       
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $comentario = $_REQUEST['comentario'];
        $evenId = $_REQUEST['eventId'];
        $hashevent = $_REQUEST['hashevent'];
        $menciones = $_REQUEST['menciones'];
        $nombreevent = $_REQUEST['nombreevent'];
        $comentarios = new comentario();
        $fecha = date('Y-m-d H:i:s');
        //$comentarioEscapado = str_replace('&nbsp;', ' ', $comentario);
        $comentarios->guardarComentarioEvento($comentario,$userId,$evenId,$userName, $fecha, $menciones,$nombreevent );
        
        //cargar comentarios
        $theObjId = new MongoId($evenId);
        $todosComent = $comentarios->findforid($theObjId);
        $html = '';
        foreach ($todosComent as $dcto){
            $useridComent = $dcto['_userId'];
            $realizacion = $comentarios->verFecha($dcto['fechaMuestra']);
            $html.='<div class="itemcoment">
                        <div class="line"></div>
                        <div class="bloq1"></div>
                        <div class="bloq2">
                            
                            <div class="nomusercom tit">'.$dcto['userName'].'</div>
                            <div class="comentuser"><a href="#" class="hashlink">'.$hashevent.'</a>
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
        }
        
        echo $html;      
    }
?>                    