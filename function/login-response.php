<?php
if(isset($_POST['login']))
{
        require_once '../DAL/connect.php';
        require_once '../DAL/usuario.php';
        $mail = $_POST['mail'];
        $pass = $_POST['pass'];
        $userid = '';
        $username = '';
        $foto = '';
        $usertype = '';
        $exito = false;
        $usuario = new usuario(); 
        $encontrado = $usuario->login($mail, $pass);
        
        if(isset($encontrado['_id'])){ //Si es usuario NORMAL, SI, NORMAL
            
            $exito = true;
            session_start();
            $_SESSION['userid'] = $encontrado['_id'];
            $_SESSION['username'] = $encontrado['username'];
            $_SESSION['nombre'] =  $encontrado['nombre'];
            $_SESSION['foto'] = $encontrado['foto'];
            $userid = $_SESSION['userid'];
            $username = $_SESSION['username'];
            $_SESSION['usertype'] = 1;
            $usertype = $_SESSION['usertype'];
        }
        $respuesta = array("exito"=>$exito,
                           "usertype"=>$usertype
                           );
        $re = json_encode($respuesta);
        echo $re;
}

if(isset($_POST['logout'])){
    session_start();
    session_destroy();
    echo 1;
}
?>
