<?php
            require_once '../DAL/connect.php';
            require_once '../DAL/productora.php';

    
    if(!empty($_POST["guardarproductora"]))
    {
//"guardaruser=1&nomuser="+nomeuser+"&nombrefoto="+res.nombrefoto+"&apellido="+apellido+"&correousuario="+correousuario+"&claveusuario="+claveusuario, 
        $name = $_POST['nomuser'];
        $mail = $_POST['correousuario'];
        $pass = $_POST['claveusuario'];
        
        $productora = new productora();
        
        $resp = $productora->insertar(strtolower($name), strtolower($mail), $pass);
        echo $resp;
        
        
    }
            

?>
