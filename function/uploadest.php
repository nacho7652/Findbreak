<?php
    session_start();
    $re = false;
    $nameconcate = '';
    $cantimg = 0;
    $nombresfoto = array();
    foreach($_FILES['images']['error'] as $key => $error){
        if($error == UPLOAD_ERR_OK){
            $name = $_FILES['images']['name'][$key];
            $partes = explode(".", $name);
            $ext = $partes[count($partes) - 1 ];
            $idproductora = (string)$_SESSION['userid'];
            $fec = date('d-m-y');
            $partesfecha = explode("-", $fec);
            $fec = $partesfecha[2].$partesfecha[1].$partesfecha[0];
            $hor = time();
            $ran = rand(0, 100);
            $nameconcate = $fec.'-'.$hor.'-'.$ran.$idproductora.$cantimg++.'.'.$ext;
            $url = '../images/establecimientos/'.$nameconcate;
            $re = move_uploaded_file($_FILES['images']['tmp_name'][$key], $url);
            chmod($url, 777);
            $nombresfoto[] = $nameconcate;
        }
      
    }
    echo json_encode(array("exito"=>$re, "nombresfoto"=> $nombresfoto));
      
?>