<?php
    require_once '../DAL/connect.php';
    require_once '../DAL/evento.php';
    require_once '../DAL/comentario.php';
    date_default_timezone_set("Chile/Continental");
    
    if(isset($_REQUEST['vercomentario'])){
		$comentario = new comentario();
		$resp = array();
		$id = $_REQUEST['id'];
		$cont = 0;
		$com = $comentario->verMisComentarios($id,10);
		$cont = count($com);
		$resp = array("cont"=>$cont,
					  "comentarios"=>$com);
        echo json_encode($resp);
    }  
?>                    