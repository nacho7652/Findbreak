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
            $_SESSION['username'] = $encontrado['nombre'];
            if(isset($encontrado['foto'])){
                $_SESSION['foto'] = $encontrado['foto'];
            }else{
                $_SESSION['foto'] = -1;
            }
            
            $userid = $_SESSION['userid'];
            $username = $_SESSION['username'];
            $foto = $_SESSION['foto'];
            $_SESSION['usertype'] = 1;
            $usertype = $_SESSION['usertype'];
        }else{
            require_once '../DAL/productora.php';
            $prod = new productora();
            $encontrado = $prod->login($mail, $pass);
            if(isset($encontrado['_id'])){ //Si es productora 

                    $exito = true;
                    session_start();
                    $_SESSION['userid'] = $encontrado['_id'];
                    $_SESSION['username'] = $encontrado['nombre'];
                    if(isset($encontrado['foto'])){
                        $_SESSION['foto'] = $encontrado['foto'];
                    }else{
                        $_SESSION['foto'] = -1;
                    }

                $userid = $_SESSION['userid'];
                $username = $_SESSION['username'];
                $foto = $_SESSION['foto'];
                $_SESSION['usertype'] = 2;
                $usertype = $_SESSION['usertype'];
            }
        }
        
        
        
        
        
        $respuesta = array("exito"=>$exito,
                           "userid"=>(string)$userid,
                           "username"=> $username,
                           "foto"=> $foto,
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
