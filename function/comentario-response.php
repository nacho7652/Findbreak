<?php
    require_once 'DAL/comentario.php';   
    
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
    
    if(isset($_POST['comentevent'])){
        session_start();
        $userId = $_SESSION['userid'];
        $userName = $_SESSION['username'];
        $comentario = $_POST['comentario'];
        $evenId = $_POST['evenId'];
        $comentarios = new comentario();
        $comentarios->guardarComentarioEvento($comentario,$userId,$evenId,$userName);
         $respuesta = array("exito"=>"funciono");
        $re = json_encode($respuesta);
        echo $re;      
    }
?>
