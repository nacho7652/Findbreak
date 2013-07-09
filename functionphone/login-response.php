<?php
if(isset($_REQUEST['login']))
{
        require_once '../DAL/connect.php';
        require_once '../DAL/usuario.php';
        $mail = $_REQUEST['mail'];
        $pass = $_REQUEST['pass'];
        $exito = false;
		$nom = '';
        $usuario = new usuario(); 
        $encontrado = $usuario->login($mail, $pass);
        
        if(isset($encontrado['_id'])){ //Si es usuario NORMAL, SI, NORMAL
            $exito = true;
			$nom = $encontrado['username'];
			$img = $encontrado['foto'];
			$nombre = $encontrado['nombre'];
			$cantCom = $usuario->verCantidadComentarios($encontrado['_id']);
			if(isset($encontrado['seguidores']))
			{
				$cantSeg = count($encontrado['seguidores']);
			}
			else
			{
				$cantSeg = 0;
			}
			if(isset($encontrado['siguiendo']))
			{
				$cantSig = count($encontrado['siguiendo']);
			}
			else
			{
				$cantSig = 0;
			}
			$id = (string)$encontrado['_id'];
        }
        $respuesta = array("exito"=>$exito,
                           "username"=>$nom,
						   "img"=>$img,
						   "nom"=>$nombre,
						   "cantCom"=>$cantCom,
						   "cantSeg"=>$cantSeg,
						   "cantSig"=>$cantSig,
						   "id"=>$id
                           );
        $re = json_encode($respuesta);
        echo $re;
}

if(isset($_REQUEST['logout'])){
    session_start();
    session_destroy();
    echo 1;
}
?>
