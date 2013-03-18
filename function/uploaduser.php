<?php
    session_start();
    $re = false;
    $nameconcate = '';
    foreach($_FILES['images']['error'] as $key => $error){
        if($error == UPLOAD_ERR_OK){
            $name = $_FILES['images']['name'][$key];
            $partes = explode(".", $name);
            $ext = $partes[count($partes) - 1 ];
            $mailuser = $_SESSION['mailuser'];
            $partesmail = explode("@", $mailuser);
            $mail = $partesmail[0];
            $fec = date('d-m-y');
            $partesfecha = explode("-", $fec);
            $fec = $partesfecha[2].$partesfecha[1].$partesfecha[0];
            $hor = time();
            $ran = rand(0, 100);
            $nameconcate = $fec.'-'.$hor.'-'.$ran.$mail.'.'.$ext;
           
            $url = '../images/users/'.$mail;
            $nameconcate = $url.'/'.$nameconcate;
            mkdir($url,777);
            $re = move_uploaded_file($_FILES['images']['tmp_name'][$key], $nameconcate);
            chmod($url, 777);
            echo json_encode(array("exito"=>$re, "nombrefoto"=> $nameconcate));
        }
      
    }
      
?>