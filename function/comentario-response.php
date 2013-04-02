<?php
    require_once '../DAL/connect.php';
    require_once '../DAL/evento.php';
    
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
        $evenId = $_REQUEST['evenId'];
        $comentarios = new comentario();
        $comentarios->guardarComentarioEvento($comentario,$userId,$evenId,$userName);
         $respuesta = array("exito"=>"funciono");
        $re = json_encode($respuesta);
        echo $re;      
    }
?>
