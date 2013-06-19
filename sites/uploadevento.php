<?php
//    require_once 'function/escalar.php';
    require_once 'DAL/evento.php';
    require_once 'DAL/relacional/connect_relacional.php';
   
    if(isset($_REQUEST['guardarevento'])){
            //foto1.jps, foto2.jpg
            $evento = new evento();  
            $rutasFotos = '';
            $re1 = true;$re2 = true;$re3 = true;$re4 = true;$re5 = true;
            if($_FILES['images-galerias1']['error'] == UPLOAD_ERR_OK ){
                $exito1 = subir($_FILES['images-galerias1']['name'], $_FILES['images-galerias1']['tmp_name']);
                $rutasFotos.= trim($exito1['fotoGr']);
                $re1 = $exito1['re'];
            }
            if($_FILES['images-galerias2']['error'] == UPLOAD_ERR_OK ){
                $exito2 = subir($_FILES['images-galerias2']['name'], $_FILES['images-galerias2']['tmp_name']);
                $rutasFotos.= trim(','.$exito2['fotoGr']);
                $re2 = $exito2['re'];
            }
            if($_FILES['images-galerias3']['error'] == UPLOAD_ERR_OK){
                $exito3 = subir($_FILES['images-galerias3']['name'], $_FILES['images-galerias3']['tmp_name']);
                $rutasFotos.= trim(','.$exito3['fotoGr']);
                $re3 = $exito3['re'];
            }
            if($_FILES['images-galerias4']['error'] == UPLOAD_ERR_OK){
                $exito4 = subir($_FILES['images-galerias4']['name'], $_FILES['images-galerias4']['tmp_name']);
                $rutasFotos.= trim(','.$exito4['fotoGr']);
                $re4 = $exito4['re'];
            }
            if($_FILES['images-galerias5']['error'] == UPLOAD_ERR_OK){
                $exito5 = subir($_FILES['images-galerias5']['name'], $_FILES['images-galerias5']['tmp_name']);
                $rutasFotos.= trim(','.$exito5['fotoGr']);
                $re5 = $exito5['re'];
            }
            
            
            if($re1 && $re2 && $re3 && $re4 && $re5){
                $result = true;
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
            
                                
            //
            $usuariorelacional = new usuarioRelacional();
            $saldo = $usuariorelacional->ValidarSaldo($_SESSION['userid']);
            if($saldo >= 500)
            {
                $usuariorelacional->DisminuirSaldo($_SESSION['userid']);
              $guardar = $evento->insertar($idproductora, $nombreproductora, $nom, $dir, $arrayfotos, $fechString, $fechMongo,$hor, $tag, $lat, $lng, $desc,$urlfacebook,$urltwitter,
                                   $video, $establecimiento, $precio, $puntosGuardar, $sitioWeb, $dondeComprar,$hashtag);
            }
            else
            {
                $result = false;
            
            }
            
            //fin datos
        if($result && $guardar==1){
            header("location:/findbreak/publicar/success");
        }else{
             header("location:/findbreak/publicar/saldo");
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

//        $nameconcate = $userid.$fec.'-'.$hor.'-'.$ran.'_pe.'.$ext;
        $nameconcateGr = $fec.'-'.$hor.'-'.$ran.'_gr.'.$ext;
    //    $url = $urluser."/".$nameconcate;

//        $fotoRedimensionar = "images/pruebas/".$nameconcate;
//        $fotoFinalPq = "images/gallery/".$nameconcate;
        $fotoFinalGr = "images/productoras/".$_SESSION['userid']."/".$nameconcateGr;

        $re = move_uploaded_file($temp,$fotoFinalGr);//pego la foto de prueba
        //$fotoFinalSmall = "../fotos/dentistas/small_".$nombre_foto;
//        if($re){//si copio correctamente
//           $resultEscalar = cuadrar($fotoRedimensionar, $fotoFinalPq, 152, 152); //pequeña
//           $resultEscalarGr = escalar($fotoRedimensionar, $fotoFinalGr, 800, 500); //grande
//           //ELIMINAR LA FOTO ANTIGUA 
//           unlink($fotoRedimensionar);
//        }

        //chmod($fotoFinalPq, 0755);
        chmod($fotoFinalGr, 0755);
        $resp = array("re"=>$re,"fotoGr"=>$nameconcateGr);
        return $resp;
    }
?>