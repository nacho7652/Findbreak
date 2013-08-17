<?php
//    require_once 'function/escalar.php';

//     header("location:http://nowsup.com/publicar");
     
    require_once 'DAL/evento.php';
    require_once 'DAL/usuario.php';
    require_once 'DAL/relacional/connect_relacional.php';
    require_once 'function/escalar.php';
   
    if(isset($_REQUEST['guardarevento'])){
         
            //foto1.jps, foto2.jpg
            $evento = new evento();  
            $rutasFotos = array();
            $re1 = true;$re2 = true;$re3 = true;$re4 = true;$re5 = true;
            if($_FILES['images-galerias1']['name'] != '' ){
                $exito1 = subir($_FILES['images-galerias1']['name'], $_FILES['images-galerias1']['tmp_name']);
                $rutasFotos[]= array('gr'=>trim($exito1['fotoGr']), 'pe'=>trim($exito1['fotoPe']));
                $re1 = $exito1['re'];
            }
            if($_FILES['images-galerias2']['name'] != ''  ){
                $exito2 = subir($_FILES['images-galerias2']['name'], $_FILES['images-galerias2']['tmp_name']);
                $rutasFotos[]= array('gr'=>trim($exito2['fotoGr']), 'pe'=>trim($exito2['fotoPe']));
                $re2 = $exito2['re'];
            }
            if($_FILES['images-galerias3']['name'] != '' ){
                $exito3 = subir($_FILES['images-galerias3']['name'], $_FILES['images-galerias3']['tmp_name']);
                $rutasFotos[]= array('gr'=>trim($exito3['fotoGr']), 'pe'=>trim($exito3['fotoPe']));
                $re3 = $exito3['re'];
            }
            if($_FILES['images-galerias4']['name'] != '' ){
                $exito4 = subir($_FILES['images-galerias4']['name'], $_FILES['images-galerias4']['tmp_name']);
                $rutasFotos[]= array('gr'=>trim($exito4['fotoGr']), 'pe'=>trim($exito4['fotoPe']));
                $re4 = $exito4['re'];
            }
            if($_FILES['images-galerias5']['name'] != '' ){
                $exito5 = subir($_FILES['images-galerias5']['name'], $_FILES['images-galerias5']['tmp_name']);
                $rutasFotos[]= array('gr'=>trim($exito5['fotoGr']), 'pe'=>trim($exito5['fotoPe']));
                $re5 = $exito5['re'];
            }
            
            //datos
            $idproductora = $_SESSION['userid'];
            $nombreproductora = $_SESSION['username'];;
            $nom = trim($_REQUEST['nom-event']);//
            $dir = trim($_REQUEST['addresEvent']);//
            $arrayfotos = $rutasFotos;//
            $fec =  trim($_REQUEST['date-event']);//
            $formatoHora = $_REQUEST['hour-event'].':'.$_REQUEST['minute-event'].':00';
            $hor = $formatoHora;//
            $hor = explode(',', $hor);
            $fechString = $fec;   
            $fechas = explode(',', $fec);  
            $fechMongo = array();
            for($i=0; $i<count($fechas); $i++){
                $fechMongo[] = new MongoDate(strtotime($fechas[$i])); 
            }
            $tag = strtolower(trim($_REQUEST['tags-hidden']));//
            $lat = $_REQUEST['lat-event'];//
            $lng = $_REQUEST['lng-event'];//
            $precio = trim($_REQUEST['precio-event']);//
            $desc = trim($_REQUEST['descripcion-event']);//
            $urltwitter = trim($_REQUEST['url-twitter']);//
            $urlfacebook = trim($_REQUEST['url-face']);//
            //nuevo
            $video = trim($_REQUEST['url-youtube']);//
            
            $hashtag = trim($_REQUEST['hash-event']);
            $establecimiento = array('id'=>'-1',
                                     'nombre'=>trim($_REQUEST['establecimiento-event']),
                                     'direccion'=>'-1');//
            $puntosDeVenta = $evento->verPuntosVenta();
            $numPunto = 1;
            $puntosGuardar = array();
            foreach($puntosDeVenta as $dcto){
                if(isset($_REQUEST["puntosventa-event".$numPunto])){
                    $linkEntrada = -1;
                    if(isset($_REQUEST["linkentrada-".$numPunto])){
                        $linkEntrada = $_REQUEST["linkentrada-".$numPunto];
                    }
                    $punto = array('id'=>$dcto['_id'],
                                    'nombre'=>$dcto['nombre'],
                                    'web'=>$dcto['web'],
                                    'link_entrada'=>$linkEntrada);
                    $puntosGuardar[] = $punto;
                }
                $numPunto++;
            }
//            $puntosDeVenta = array( array('id'=>'232323',
//                                          'nombre'=>'Ticket Master',
//                                          'web'=>'http://www.google.cl'),
//                                    array('id'=>'232323',
//                                          'nombre'=>'Ticket Master',
//                                          'web'=>'http://www.google.cl') //
//                                   );
            $sitioWeb = trim($_REQUEST["sitioevento"]); //
            $dondeComprar = '-1';//demás
            
                                
            
            $usuariorelacional = new usuarioRelacional();
            $saldo = $usuariorelacional->ValidarSaldo($_SESSION['userid']);
            $guardar=0;
            if($saldo >= 0)
            {
                //$usuariorelacional->DisminuirSaldo($_SESSION['userid']);
//                 $comprobar = $evento->buscarPorLatLong($lat, $lng);
//                
//                if(isset($comprobar["_id"]))
//                {
                
                    $guardar = $evento->insertar($idproductora, $nombreproductora,$nom , $dir, $arrayfotos, $tag, $lat, $lng, $desc,$urlfacebook,$urltwitter,
                                   $video, $sitioWeb,$hashtag);
//                }
//                else
//                {
//                    $lng+= 119999;
//                    $lat+= 118911;
//                    $guardar = $evento->insertar($idproductora, $nombreproductora, $nom, $dir, $arrayfotos, $tag, $lat, $lng, $desc,$urlfacebook,$urltwitter,
//                                   $video, $sitioWeb,$hashtag);
//                    
//                }
              
            }
            else
            {
                $result = false;
            
            }
            
        
        if($guardar==1){
            header("location:http://www.nowsup.com/break/".$hashtag."/success");
        }else{
             header("location:http://www.nowsup.com/publicar");
        }
    }
    if(isset($_REQUEST['editarusuario'])){
        
        $usuario = new usuario();
        $userid = $_SESSION['userid'];
        $foto = $usuario->verFoto($userid);
        $userface = $usuario->comprobarUserFace($userid);
        $numUserFce = $userface['userface'];//face = 1 / nada = 0
        
        if($_FILES['fotousuario']['name'] != '' ){//llega foto
                    unlink($foto['foto']['gr']);
                    unlink($foto['foto']['pe']);
                    $exito1 = subir($_FILES['fotousuario']['name'], $_FILES['fotousuario']['tmp_name']);
                    $re1 = $usuario->reemplazarFoto($userid, $exito1['fotoGr'], $exito1['fotoPe']);
            }
        $nombre = trim($_REQUEST['nombreuser']);
        $username = trim($_REQUEST['username']);
        $mail = trim($_REQUEST['email']);
        $resp = $usuario->modificar($userid, $username, $nombre, $mail);
        $_SESSION['username'] = $username;
        header("location:/findbreak/editar-user/!".$username."");
    }
    if(isset($_REQUEST['editarevento'])){
            
            $evento = new evento();  
            $idEvento = $_REQUEST['idevent'];
            $fotosActuales = $evento->verFotos($idEvento);
            $producidoPor = $evento->verProductora($idEvento);
            $urlFotos = 'images/anuncios';
            //fotos
            $re1 = true;$re2 = true;$re3 = true;$re4 = true;$re5 = true;
            if($_FILES['images-evento-nueva0']['name'] != '' ){
                 if(isset($fotosActuales['fotos'][0])){//reemplazar
                    $foto0 = $fotosActuales['fotos'][0];
                    $urlBorrar = $urlFotos.'/'.$foto0['gr'];//gr
                    $urlBorrarPe = $urlFotos.'/'.$foto0['pe'];//pe
                    $exito1 = subir($_FILES['images-evento-nueva0']['name'], $_FILES['images-evento-nueva0']['tmp_name']);
                    $rePe =$evento->reemplazarFoto($idEvento, $urlBorrarPe, $exito1['fotoPe'],0,'pe');
                    $re1 = $evento->reemplazarFoto($idEvento, $urlBorrar, $exito1['fotoGr'],0,'gr');
                 }else{
                     $exito1 = subir($_FILES['images-evento-nueva0']['name'], $_FILES['images-evento-nueva0']['tmp_name']);
                     $re1 = $evento->nuevaFoto($idEvento, $exito1['fotoGr'], $exito1['fotoPe']);
                 }
            }
            if($_FILES['images-evento-nueva1']['name'] != ''){
                if(isset($fotosActuales['fotos'][1])){//reemplazar
                    $foto1 = $fotosActuales['fotos'][1];
                    $urlBorrar = $urlFotos.'/'.$foto1['gr'];
                    $urlBorrarPe = $urlFotos.'/'.$foto1['pe'];//pe
                    $exito2 = subir($_FILES['images-evento-nueva1']['name'], $_FILES['images-evento-nueva1']['tmp_name']);
                    $rePe =$evento->reemplazarFoto($idEvento, $urlBorrarPe, $exito2['fotoPe'],1,'pe');
                    $re2 = $evento->reemplazarFoto($idEvento, $urlBorrar, $exito2['fotoGr'],1,'gr');
                }else{//nueva
                    $exito2 = subir($_FILES['images-evento-nueva1']['name'], $_FILES['images-evento-nueva1']['tmp_name']);
                    $re2 = $evento->nuevaFoto($idEvento, $exito2['fotoGr'], $exito2['fotoPe']);
                }
            }
            if($_FILES['images-evento-nueva2']['name'] != ''){
                if(isset($fotosActuales['fotos'][2])){//reemplazar
                    $foto2 = $fotosActuales['fotos'][2];
                    $urlBorrar = $urlFotos.'/'.$foto2['gr'];
                    $urlBorrarPe = $urlFotos.'/'.$foto2['pe'];//pe
                    $exito3 = subir($_FILES['images-evento-nueva2']['name'], $_FILES['images-evento-nueva2']['tmp_name']);
                    $rePe =$evento->reemplazarFoto($idEvento, $urlBorrarPe, $exito3['fotoPe'],2,'pe');
                    $re3 = $evento->reemplazarFoto($idEvento, $urlBorrar, $exito3['fotoGr'],2,'gr');
                }else{//nueva
                    $exito3 = subir($_FILES['images-evento-nueva2']['name'], $_FILES['images-evento-nueva2']['tmp_name']);
                    $re3 = $evento->nuevaFoto($idEvento, $exito3['fotoGr'], $exito3['fotoPe']);
                }
            }
            if($_FILES['images-evento-nueva3']['name'] != ''){
                if(isset($fotosActuales['fotos'][3])){//reemplazar
                    $foto3 = $fotosActuales['fotos'][3];
                    $urlBorrar = $urlFotos.'/'.$foto3['gr'];
                    $urlBorrarPe = $urlFotos.'/'.$foto3['pe'];//pe
                    $exito4 = subir($_FILES['images-evento-nueva3']['name'], $_FILES['images-evento-nueva3']['tmp_name']);
                    $rePe =$evento->reemplazarFoto($idEvento, $urlBorrarPe, $exito4['fotoPe'],3,'pe');
                    $re4 = $evento->reemplazarFoto($idEvento, $urlBorrar, $exito4['fotoGr'],3,'gr');
                }else{//nueva
                    $exito4 = subir($_FILES['images-evento-nueva3']['name'], $_FILES['images-evento-nueva3']['tmp_name']);
                    $re4 = $evento->nuevaFoto($idEvento, $exito4['fotoGr'], $exito4['fotoPe']);
                }
            }
            if($_FILES['images-evento-nueva4']['name'] != ''){
                if(isset($fotosActuales['fotos'][4])){//reemplazar
                    $foto4 = $fotosActuales['fotos'][4];
                    $urlBorrar = $urlFotos.'/'.$foto4['gr'];
                    $urlBorrarPe = $urlFotos.'/'.$foto4['pe'];//pe
                    $nombreBorrar = $foto4[0];
                    $nombreBorrarPe = $foto4[1];
                    $exito5 = subir($_FILES['images-evento-nueva4']['name'], $_FILES['images-evento-nueva4']['tmp_name']);
                    $rePe =$evento->reemplazarFoto($idEvento, $urlBorrarPe, $nombreBorrarPe, $exito5['fotoPe'],4,'pe');
                    $re5 = $evento->reemplazarFoto($idEvento, $urlBorrar, $nombreBorrar, $exito5['fotoGr'],4,'gr');
                }else{//nueva
                    $exito5 = subir($_FILES['images-evento-nueva4']['name'], $_FILES['images-evento-nueva4']['tmp_name']);
                    $re5 = $evento->nuevaFoto($idEvento, $exito5['fotoGr'], $exito5['fotoPe']);
                }
            }
            //fin fotos
            //datos
            
            $idproductora = $_SESSION['userid'];
            $nombreproductora = $_SESSION['username'];;
            $nom = trim($_REQUEST['nom-event']);//
            $dir = trim($_REQUEST['addresEvent']);//
            $arrayfotos = $rutasFotos;//
            $fec =  trim($_REQUEST['date-event']);//
            $formatoHora = $_REQUEST['hour-event'].':'.$_REQUEST['minute-event'].':00';
            $hor = $formatoHora;//
            $hor = explode(',', $hor);
            $fechString = $fec;   
            $fechas = explode(',', $fec);  
            $fechMongo = array();
            for($i=0; $i<count($fechas); $i++){
                $fechMongo[] = new MongoDate(strtotime($fechas[$i])); 
            }
            $tag = strtolower(trim($_REQUEST['tags-hidden']));//
            $lat = $_REQUEST['lat-event'];//
            $lng = $_REQUEST['lng-event'];//
            $precio = trim($_REQUEST['precio-event']);//
            $desc = trim($_REQUEST['descripcion-event']);//
            $urltwitter = trim($_REQUEST['url-twitter']);//
            $urlfacebook = trim($_REQUEST['url-face']);//
            //nuevo
            $video= trim($_REQUEST['url-youtube']);//
            $hashtag = trim($_REQUEST['hash-event']);
            $establecimiento = array('id'=>'-1',
                                     'nombre'=>trim($_REQUEST['establecimiento-event']),
                                     'direccion'=>'-1');//
            $puntosDeVenta = $evento->verPuntosVenta();
            $numPunto = 1;
            $puntosGuardar = array();
            foreach($puntosDeVenta as $dcto){
                if(isset($_REQUEST["puntosventa-event".$numPunto])){
                    $linkEntrada = -1;
                    if(isset($_REQUEST["linkentrada-".$numPunto])){
                        $linkEntrada = $_REQUEST["linkentrada-".$numPunto];
                    }
                    $punto = array('id'=>$dcto['_id'],
                                    'nombre'=>$dcto['nombre'],
                                    'web'=>$dcto['web'],
                                    'link_entrada'=>$linkEntrada);
                    $puntosGuardar[] = $punto;
                }
                $numPunto++;
            }
//            $puntosDeVenta = array( array('id'=>'232323',
//                                          'nombre'=>'Ticket Master',
//                                          'web'=>'http://www.google.cl'),
//                                    array('id'=>'232323',
//                                          'nombre'=>'Ticket Master',
//                                          'web'=>'http://www.google.cl') //
//                                   );
            $sitioWeb = trim($_REQUEST["sitioevento"]); //
            $dondeComprar = '-1';//demás
            $guardar = $evento->modificar($idEvento, $nom, $dir,$tag, $lat, $lng, $desc,$urlfacebook,$urltwitter,$video);
            
            //fin datos
        if($guardar==1){
//            header("location:/findbreak/publicar/success-upd");
            header("location:/break/".$hashtag."/success");
        }else{
             header("location:/publicar/saldo");
        }
    }
    function subir($name, $temp){
        
        $re = false;
        $resultEscalar = false;
        $resultEscalarGr = false;
        $nameconcate = '';
        //$userid = $_SESSION['userid'];
        
        $partes = explode(".", $name);
        $ext = $partes[count($partes) - 1 ];       
        $fec = date('d-m-y');
        $partesfecha = explode("-", $fec);
        $fec = $partesfecha[2].$partesfecha[1].$partesfecha[0];
        $hor = time();
        $ran = rand(0, 100);

        $nameconcate = $fec.'-'.$hor.'-'.$ran.'_pe.'.$ext;
        $nameconcateGr = $fec.'-'.$hor.'-'.$ran.'_gr.'.$ext;
    //    $url = $urluser."/".$nameconcate;

        $fotoRedimensionar = "./images/pruebas/".$nameconcate;
        $fotoFinalPq = "./images/anuncios/".$nameconcate;
        $fotoFinalGr = "./images/anuncios/".$nameconcateGr;

        $re = move_uploaded_file($temp,$fotoRedimensionar);//pego la foto de prueba
        //$fotoFinalSmall = "../fotos/dentistas/small_".$nombre_foto;
        if($re){//si copio correctamente
           $resultEscalar = cuadrar($fotoRedimensionar, $fotoFinalPq, 60, 60); //pequeña
           $resultEscalarGr = escalar($fotoRedimensionar, $fotoFinalGr, 800, 500); //grande
           //ELIMINAR LA FOTO ANTIGUA 
           unlink($fotoRedimensionar);
        }

        chmod($fotoFinalPq, 0755);
        chmod($fotoFinalGr, 0755);
        $resp = array("re"=>$re,"fotoGr"=>$nameconcateGr, "fotoPe"=>$nameconcate);
        return $resp;
    }
   
?>