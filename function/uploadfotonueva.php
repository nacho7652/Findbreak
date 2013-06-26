<?php
    session_start();
    $re = false;
    $name = $_FILES['images-evento-nueva']['name'];
    $partes = explode(".", $name);
    $ext = $partes[count($partes) - 1 ];       
    $fec = date('d-m-y');
    $partesfecha = explode("-", $fec);
    $fec = $partesfecha[2].$partesfecha[1].$partesfecha[0];
    $hor = time();
    $ran = rand(0, 100);
    $nameconcateGr = $fec.'-'.$hor.'-'.$ran.'_gr.'.$ext;
    $folder = (string)$_SESSION['userid'];
    $url = '../images/productoras/'.$folder.'/'.$nameconcateGr;
    $re = move_uploaded_file($_FILES['images-evento-nueva']['tmp_name'],$url);//pego la foto de prueba
    chmod($url, 0777);
    echo json_encode(array("exito"=>$re, 
                            "nombrefotoGr"=> $nameconcateGr));
?>