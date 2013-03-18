<?php
require_once '../DAL/connect.php';
require_once '../DAL/establecimiento.php';
if(isset($_POST['estnear'])){
        $lat = $_REQUEST['lat'];
        $long = $_REQUEST['lng'];
        $est = new establecimiento();
        $estCercanos = $est->findnear((float)$lat, (float)$long);
        $infodiv = "";//información para que el mapa lea y muestre los pines con eventos
        $cont = 0; //cantidad de eventos encontrados para mostrarlos en el mapa
        $listest = "";

         foreach ($estCercanos as $dcto){
                    //Con esta info. el mapa de google muestra los pines
                     $infodiv = $infodiv.'<div id="info'.$cont.'">'.$dcto['direccion']."+".$dcto['nombre']."+".
                            $dcto['loc'][0]."+".$dcto['loc'][1].'</div>'."\n";
                     $cont++;
                   //----0----   
                    $url = '../images/establecimientos/'.$dcto['fotos'][0];
                    $listest.= '<div class="item-est">';
                      $listest.= '<div class="item-fotoest" style="float:left; width:40px; height:40px;background: url('.$url.'); background-size:cover"></div>
                                  <a class="nombre-small-list" target="_blank" href="../establecimiento/'.$dcto['_id'].'" >'.$dcto['nombre'].'</a>
                                  <div class="address-small-list">'.$dcto['direccion'].'</div>';     
                    $listest.= '</div>'; 
                }
                $infodiv.= '<div id="number">'.$cont.'</div>';

        $resp = array("infodiv"=>$infodiv,
                      "listest"=>$listest);
        echo json_encode($resp);
}

    if(isset($_POST['guardarest'])){
            
         //   session_start();
            //$idproductora = (string)$_SESSION['userid'];
           // $nombreproductora = (string)$_SESSION['username'];
        
            session_start();
            $iduser = (string)$_SESSION['userid'];
            $nom = $_POST['nomevent'];
            $dir = $_POST['addresEvent'];
            $fotosnom = $_POST["nombresfoto"];
//            $fec = $_POST["dateevent"];
//            $hor = $_POST["hourevent"];
//            $fechString = $fec." ".$hor;
//            $fechMongo = new MongoDate(strtotime($fec.$hor));
            $tags = $_POST["tagsevent"];
            $lat = $_POST["lat"];
            $lng = $_POST["lng"];
            $desc = $_POST['descripcionevent'];
            $tel = $_POST['telefono'];
            $urltwitter = $_POST['urltwitter'];
            $urlfacebook = $_POST['urlface'];
             
           // $evento = new evento();
               $est = new establecimiento();
               
           echo $est->agregarEstablecimiento($nom, $dir, $fotosnom, $tags, $lat, $lng, $desc, $tel, $urltwitter, $urlfacebook, $iduser);
            //echo $evento->insertar($idproductora, $nombreproductora, $nom, $dir, $fotnom, $fechString, $fechMongo, $tag, $lat, $lng, $desc);
        }
?>
