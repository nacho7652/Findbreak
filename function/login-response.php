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

if(isset($_POST['forgot'])){
    require_once '../DAL/connect.php';
    require_once '../DAL/usuario.php';
    $username = $_POST['username'];
    $resp = 0;
    $usuario = new usuario();
    $encontrado = $usuario->findforusername($username);
    if(isset($encontrado['_id']))
    {
        $resp=1;
        $clave = rand(2000,10000).$encontrado['username'];
        $usuario->updateClave($encontrado['_id'], $clave);
        $headers = "From: no-reply Nowsup <no-reply@nowsup.com>\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$headers .= "Content-Transfer-Encoding: 8bit\r\n";
        $body = "Tu nueva contraseña es : ".$clave;
        mail($encontrado['email'], 'Nowsup - Recuperacion de clave', $body, $headers);
    }
    echo $resp;
}

if(isset($_POST['logout'])){
    session_start();
    session_destroy();
    echo 1;
}
?>
