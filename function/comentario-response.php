<?php
    require_once '../DAL/connect.php';
    require_once '../DAL/evento.php';
    require_once '../DAL/comentario.php';
    date_default_timezone_set("Chile/Continental");
    
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
        $comentarios = new comentario();
        $fecha = date('Y-m-d H:i:s');
        $comentarios->guardarComentarioEvento($comentario,$userId,$evenId,$userName, $fecha);
        
        //cargar comentarios
        $theObjId = new MongoId($evenId);
        $todosComent = $comentarios->findforid($theObjId);
        $html = '';
        foreach ($todosComent as $dcto){
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
                                </div>
                                <div data-id="'.$dcto['_id'].'" id="delcoment" class="aparececom">Eliminar</div>
                        </div>
                    </div>';
        }
        
        echo $html;      
    }
?>
