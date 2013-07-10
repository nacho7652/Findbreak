<?php
require_once 'usuarioRelacional.php';
class evento {
    private $db;
    function __construct() {
        $conn = new connect();
        $this->db = $conn->getDB();
    }
    public function findnear($lat, $long){
        //php = $cursor = $coats->find(Array('latLong' => Array('$near' => $latLong)))->limit(10);
        //find({  loc:  { $near: [50,30], $maxDistance: 5}  }).limit(10)
         //return $this->db->evento->find('loc' => array( '$near' => array( (float)50 , (float)30 ), '$maxDistance' => 1 ));
        $km = 40 / 111.12;
        //lat, lon
        $a = $this->hoy();
       // return $this->db->evento->find(Array('loc' => Array( '$near' => array($lat,$long), '$maxDistance' => $km   ), 'fecha_realizacion'=> array('$gte' => $a )   ))->limit(10);
        //return $this->db->evento->find(array("loc" => array('$near' => 50,30))); //array('$near' =>[50,50])
                return $this->db->evento->find(Array('loc' => Array( '$near' => array($lat,$long), '$maxDistance' => $km   ) , '$or' => array( array('fecha_realizacion'=> array('$gte' => $a )) )    ))->limit(10);

    }
    public function verCantidadComentarios($id){
         $theObjId = new MongoId($id); 
         //return $this->db->comentariosEvento->find(array("_eventId" => $theObjId))->count();
         return $this->db->comentariosEvento->find(array('$or' =>array(
                                                                 array("_eventId.id" => $theObjId)
                                                                      )))->count();
     }
     public function verEventosMencionados($idEventos){
         $nombres = '';
         $fotos = '';
         $foto = '';
         $cuantos = count($idEventos);
         for($i=0;$i<count($idEventos);$i++){
             $id = $idEventos[$i]['id'];
             $nombre = $this->verNombre($id);
             $nombres.= $nombre['nombre'].'<br>';
         }
         if(count($idEventos) == 1)//un evento
         {           
             $id = $idEventos[0]['id'];
             $foto = $this->verFoto($id);
             $fotos = '<div style="background:url('.$foto.') no-repeat" class="itemfoto-eve"></div>';
         }else{//tomo dos eventos 
              for($i=0;$i<count($idEventos);$i++){
                $id = $idEventos[$i]['id'];
                $foto = $this->verFoto($id);
                $fotos.= '<div style="background:url('.$foto.') no-repeat" class="itemfoto-eve-doble"></div>';
             }
         }
         $re = array('nombre'=>$nombres,'fotos'=>$fotos);
         return $re;
     }
     public function findforhash($hash){
         return $this->db->evento->findOne(array("hash" => $hash));
     }
    public function findforid($id){
         $theObjId = new MongoId($id); 
         return $this->db->evento->findOne(array("_id" => $theObjId));
     }
     public function findpopular($limit){
         $numeroPromedio = $this->promedioVisitas();
         return $this->db->evento->find(array( 'fecha_realizacion'=> array('$gte' => $this->hoy()), 'visitas'=> array('$gte' => ($numeroPromedio/2)) ))->sort(array("visitas" => -1 ))->limit($limit);
     }
      public function verFoto($id){
         $theObjId = new MongoId($id); 
         $carpeta = $this->db->evento->findOne(array("_id" => $theObjId), array("producido_por" => 1));
         $nombreFoto = $this->db->evento->findOne(array("_id" => $theObjId), array("fotos" => 1));
         $url = 'images/productoras/'.(string)$carpeta['producido_por']['_id'].'/'.$nombreFoto['fotos'][0];
         return $url;
     }
     public function verProductora($id){
         $theObjId = new MongoId($id); 
         return $this->db->evento->findOne(array("_id" => $theObjId), array("producido_por" => 1));
     }
     public function verFotos($id){
         $theObjId = new MongoId($id); 
         return $this->db->evento->findOne(array("_id" => $theObjId), array("fotos" => 1));
     }
     public function verNombre($id){
         $theObjId = new MongoId($id); 
         return $this->db->evento->findOne(array("_id" => $theObjId), array("nombre" => 1));
         //return $this->db->usuario->find(array("_id" => $id),array("foto" => 1));
     }
     public function verUrl($id){
         $theObjId = new MongoId($id); 
         return $this->db->evento->findOne(array("_id" => $theObjId), array("hash" => 1));
         //return $this->db->usuario->find(array("_id" => $id),array("foto" => 1));
     }
     public function findpopularPorProductora($idProductora, $cuando){
         if($cuando > 0){//el evento más popular por realizarse
            return $this->db->evento->find(array('producido_por._id'=>$idProductora, 'visitas' => array('$gt'=>0) ))->sort(array("visitas" => -1 ))->limit(1);  
         }else{//el evento más popular ya realizado
            return $this->db->evento->find(array('producido_por._id'=>$idProductora))->sort(array("visitas" => 1 ))->limit(1);  
 
         } 
     }
     private function promedioVisitas(){
         $eventos = $this->eventosPorRealizar(0);
         $sumVisitas = 0;
         $canEventos = 0;
         foreach ($eventos as $dcto){
             $sumVisitas+= $dcto['visitas'];
             $canEventos++;
         }
         if($canEventos == 0){
             return 0;
         }else{
         return $sumVisitas / $canEventos;
         }
     }
     public function eventosPorRealizar($cantVisitasMinimo){//eventos por realizar y que tengan mas de 0 visitas
         return $this->db->evento->find(array( 'fecha_realizacion'=> array('$gte' => $this->hoy()), 'visitas'=> array('$gt' => $cantVisitasMinimo)   ));
     }
     
     public function eventosPorRealizarOrderFecha($order){//eventos por realizar ordernar por fecha
         return $this->db->evento->find(array( 'fecha_realizacion'=> array('$gte' => $this->hoy())))->sort(array("fecha_realizacion" => $order ))->limit(5);
     }
     
     public function eventosAgregadosPorFecha($order){//eventos por realizar ordernar por fecha
         return $this->db->evento->find()->sort(array("fecha_publicacion" => $order ))->limit(5);
         
         //AGREGAR FECHA DE PUBLICACION A LOS EVENTOS
     }
     
     public function hoy(){
        
      //  $a = date('2012-11-26 23:59:59'); // date("d-m-Y H:i:s");
        $a = date('Y-m-d 00:00:00');
         $hoy = new MongoDate(strtotime($a));
        // strto
         return $hoy;
     }
     
      public function filtrar($buscador, $limit = false){
        if(!$limit){
            $limit = 4;
        }
        $buscadorSinSp = trim($buscador);
        $words = explode(" ", $buscadorSinSp);
        
        $result = array();
            for($i=0 ; $i < count($words); $i++){
                $tags =  array("tags" => new MongoRegex("/".trim($words[$i])."/")); // '%rock%'
                $result[]= $tags;
           }
        
        
        
        return $this->db->evento->find(array('$or' => $result//array($a
                                                            //$result
//                                                           array("tags" => new MongoRegex("/hard/")), 
//                                                            array("tags" => new MongoRegex("/lsls/"))
                                                            //array("tags" => new MongoRegex("/asc/"))
                                                          //)
                                              ,  'fecha_realizacion'=> array('$gte' => $this->hoy())
                                           )
                                      )->sort(array("visitas" => -1 ))->limit($limit);
    }
    
     public function similares($idNo, $words, $limit){//id, array
//        $buscadorSinSp = trim($buscador);
//        $words = explode(" ", $buscadorSinSp);
        
        $result = array();
            for($i=0 ; $i < count($words); $i++){
                $tags =  array("tags" => new MongoRegex("/".trim($words[$i])."/")); // '%rock%'
                $result[]= $tags;
           }
        
        
        
        return $this->db->evento->find(array('$or' => $result//array($a
                                                            //$result
//                                                           array("tags" => new MongoRegex("/hard/")), 
//                                                            array("tags" => new MongoRegex("/lsls/"))
                                                            //array("tags" => new MongoRegex("/asc/"))
                                                          //)
                                              ,  'fecha_realizacion'=> array('$gte' => $this->hoy())
                                           )
                                      )->limit($limit);
    }
     public function findall(){
         return $this->db->evento->find();
     }
     public function registrarVisita($idEvento){
         $ahora = time();
         $ultimaVisita = $this->verificarVisita($idEvento);
         $usuarioR = new usuarioRelacional();
         $usuario = new usuario();
         if($ultimaVisita == null){//si aun no se registra su visita
              $vistas_evento = array(
                       "evento"=>$idEvento,
                       "usuario"=>$_SESSION['userid'],
                       "hora_visita"=>$ahora
                       );
            $this->db->vistas_evento->insert($vistas_evento);
            $this->sumarvisita($idEvento);     
            $cant = $this->cantidadVisitas($idEvento);
            $cantF = $cant['visitas'];
            if($cantF%10000 == 0)
            {
                $ev = $this->findforid((string)$idEvento);
                $usuarioR->PagoVisitas((string)$ev['producido_por']['_id']);
                $fecha = date('Y-m-d H:i:s');
                $fechaMongo = new MongoDate(strtotime($fecha));
                $usuario->guardarNotificacion3($ev['producido_por']['_id'], $idEvento, $cantF, $fechaMongo, $fecha);
            }
                
             return 1;
         }else{//verifico la hora
            $inicio = $ultimaVisita["hora_visita"];
            $duracion = $ahora - $inicio; //tiempo transcurrido en segundos
            $tiempoTranscurrido =  (int)$duracion/3600; //en hora /3600
            if($tiempoTranscurrido >= 1) //10 minutos = puede sumarse
            {
                $this->db->vistas_evento->update(array("evento" => $idEvento), array('$set'=> array("hora_visita"=>$ahora)));
                $this->sumarvisita($idEvento);     
                $cant = $this->cantidadVisitas($idEvento);
                $cantF = $cant['visitas'];
                if($cantF%10000 == 0)
                {
                    $ev = $this->findforid((string)$idEvento);
                    $usuarioR->PagoVisitas((string)$ev['producido_por']['_id']);
                    $fecha = date('Y-m-d H:i:s');
                    $fechaMongo = new MongoDate(strtotime($fecha));
                    $usuario->guardarNotificacion3($ev['producido_por']['_id'], $idEvento, $cantF, $fechaMongo, $fecha);
                }
                
                
                return 1;
            }else{
                return 0;
            }
         }
         
     }
      public function verificarVisita($idEvento){
         return $this->db->vistas_evento->findOne(array('evento'=>$idEvento, 'usuario'=>$_SESSION['userid']));
     }
    public function sumarvisita($id){      
         $theObjId = new  MongoId($id);
         return $this->db->evento->update(array("_id" => $theObjId), array('$inc'=> array("visitas"=>1)));
     }
     public function cantidadVisitas($id){      
//         $theObjId = new  MongoId($id);
         return $this->db->evento->findOne(array("_id" => $id), array("visitas"=>1));
     }
     
     
     
     private function crearHash($nom){
         $arr = explode(' ', $nom);
         $hash = '';
         for($i=0; $i<count($arr); $i++){
             $hash.= ucwords($arr[$i]);
         }
         return $hash;
     }

     public function insertar($userid, $username, $nombre, $direccion, $arrayfotos, $fechaString,$fechaMongo ,$hor, $tags, $lat, $lng, $desc, $urlfb, $urltw, 
                             $video, $establecimiento, $precio, $puntosDeVenta, $sitioWeb, $dondeComprar, $hashtag){ 
         $arrtags = explode(",", $tags);
         $arrtags[] = strtolower($nombre);
//         unset($arrtags[count($arrtags)-2]);
         
         $fotos = explode(",", $arrayfotos);

         $event = array(
            "nombre" => $nombre,
            "hash" => $hashtag,//$this->crearHash($nombre),
            "hashmin"=>  strtolower($hashtag),
            "direccion" =>  $direccion,
            "fotos" => $fotos,
            "fecha_realizacion" => $fechaMongo, //para la busqueda por fechas
            "fecha_muestra" => $fechaString, //para mostrar
            "hora_inicio"=>$hor,
            "estado"=> "pendiente",
            "producido_por"=>(object)array("_id"=>$userid, "nombre"=>$username),
            "tags" => $arrtags,
            "loc"=> array((float)$lat, (float)$lng),
            "descripcion"=>  $desc,
             "visitas"=>0,
             "redes" => array($urlfb, $urltw,$video),
             "establecimiento"=> $establecimiento,
             "precio"=>$precio,
             "puntos_de_venta"=>$puntosDeVenta,
             "sitio_web"=>$sitioWeb,
             "donde_comprar"=>$dondeComprar,
             "verificacion"=>0
        );
         $re = $this->db->evento->insert($event); 
         //$eventoR = new usuarioRelacional();
        // $eventoR->GuardarEvento((string)$event['_id'], $nombre, 10000);
        // session_start();
        // $eventoR->GuardarEvento_____Usuario((string)$event['_id'], $_SESSION['userid'], 10000,1,0);
         return $re;
     }
     public function modificar($id, $username, $nombre, $direccion, $arrayfotos, $fechaString,$fechaMongo ,$hor, $tags, $lat, $lng, $desc, $urlfb, $urltw, 
                             $video, $establecimiento, $precio, $puntosDeVenta, $sitioWeb, $dondeComprar, $hashtag){ 
         $arrtags = explode(",", $tags);
         unset($arrtags[count($arrtags)-1]);
//         $arrtags[] = strtolower($nombre);
        // $db->users->update(array("b" => "q"), array('$set' => array("a" => 1)));
         $theObjId = new MongoId($id); 
         return $this->db->evento->update(array("_id" => $theObjId), 
                                          array(
                                            '$set'=> array("nombre"=>$nombre,
                                                           "direccion"=>$direccion,
                                                           "fecha_realizacion"=>$fechaMongo,
                                                           "fecha_muestra"=>$fechaString,
                                                           "hora_inicio"=>$hor,
                                                           "tags"=>$arrtags,
                                                           "loc"=>array((float)$lat, (float)$lng),
                                                           "descripcion"=>$desc,
                                                           "redes" => array($urlfb, $urltw,$video),
                                                           "establecimiento" => $establecimiento,
                                                           "precio"=>$precio,
                                                           "puntos_de_venta"=>$puntosDeVenta,
                                                           "sitio_web"=>$sitioWeb,
                                                           "donde_comprar"=>$dondeComprar
                                                           
                                                            )
                                          ));
    
     }
     public function agregarPuntosVenta($nombre, $web)
     { 
         $puntosDeVenta = array( 'nombre'=>$nombre,
                                 'web'=>$web
                                );
         return $this->db->puntos_venta->insert($puntosDeVenta);   
     }
     public function reemplazarFoto($idEvento, $urlBorrar, $nombreBorrar, $fotoGr)
     { 
        unlink($urlBorrar);
        $theObjId = new MongoId($idEvento);
      //  $this->db->tags_buscados->update(array("userid"=>$userid, "tags.tag"=>$tags[$i]), array('$set'=>array("tags.$.fecha"=>$fechahoy)));
        return $this->db->evento->update( array("_id"=>$theObjId,"fotos"=>$nombreBorrar), array('$set'=> array("fotos.$"=>$fotoGr) ));
       // $this->db->evento->update( array("_id"=>$theObjId), array('$push'=> array("fotos"=>$fotoGr) ));   
     }
     public function eliminarFoto($idEvento, $urlBorrar, $nombreBorrar)
     { 
        unlink($urlBorrar);
        $theObjId = new MongoId($idEvento);
       // return $this->db->evento->update( array("_id"=>$theObjId,"fotos"=>$nombreBorrar), array('$set'=> array("fotos.$"=>$fotoGr) ));
        return $this->db->evento->update( array("_id"=>$theObjId), array('$pull'=> array("fotos"=>$nombreBorrar) ));   
     }
      public function eliminarFotos($id){
         $theObjId = new MongoId($id); 
         $carpeta = $this->db->evento->findOne(array("_id" => $theObjId), array("producido_por" => 1));
         $todasLasFotos = $this->verFotos($id);
         for($i=0; $i< count($todasLasFotos['fotos']); $i++){
             $url = '../images/productoras/'.(string)$carpeta['producido_por']['_id'].'/'.$todasLasFotos['fotos'][$i];
             unlink($url);
         }
     }
     public function eliminar($idEvento)
     { 
        $theObjId = new MongoId($idEvento);
        $this->eliminarFotos($idEvento);
        $eventoR = new usuarioRelacional();
        $eventoR->EliminarEvento($idEvento);
       // return $this->db->evento->update( array("_id"=>$theObjId,"fotos"=>$nombreBorrar), array('$set'=> array("fotos.$"=>$fotoGr) ));
        return $this->db->evento->remove( array("_id"=>$theObjId));   
     }
     public function nuevaFoto($idEvento,$fotoGr)
     { 
        $theObjId = new MongoId($idEvento);
        return $this->db->evento->update( array("_id"=>$theObjId), array('$push'=> array("fotos"=>$fotoGr) ));   
     }
     public function verPuntosVenta()
     { 
         return $this->db->puntos_venta->find();    
     }
     public function comprobarPuntosVenta($idEvento, $idPunto)
     { 
         return $this->db->evento->findOne(array('_id'=>$idEvento, 'puntos_de_venta.id'=>$idPunto), array("puntos_de_venta" => 1));       
     }
     public function comprobarTags($idEvento, $tag)
     { 
         return $this->db->evento->findOne(array('_id'=>$idEvento, 'tags'=>$tag), array("tags" => 1));       
     }
     public function agregarTag($nombre)
     { 
         $tagdcto = array("nombre"=>$nombre);
         return $this->db->tags->insert($tagdcto);  
     }
     public function comprobarHashTag($hashmin)
     { 
         return $this->db->evento->findOne(array('hashmin'=>$hashmin));    
     }
     public function verTags()
     { 
         return $this->db->tags->find();    
     }
     public function EventosPorRealizarPorIdProductora($idProductora)
     { 
         return $this->db->evento->find(array('producido_por._id'=>$idProductora, 'fecha_realizacion'=> array('$gte' => $this->hoy()) ));    
         }
     public function EventosVigentes($idEvento) //NO SE Q ES LO DE LA FECHA.
     { 
         return $this->db->evento->find(array('_id'=>$idEvento, 'fecha_realizacion'=> array('$gte' => $this->hoy()) ));    
         }
     
     public function EventosDONEPorIdProductora($idProductora)
     {
         return $this->db->evento->find(array('producido_por._id'=>$idProductora, 'fecha_realizacion'=> array('$lt' => $this->hoy()) ))->sort(array("fecha_realizacion" => -1 ));
     }
     

     public function encod($string){
         return utf8_encode($string);   
         
     }
     
     public function formatoFecha($fecha, $hora, $cantidad = null){
         $masfechas = explode(',', $fecha);
         $formato = '';
         if(count($masfechas) == 1){
//            $datos = explode(' ', $fecha);
//            $fecha = $datos[0];

            $itemfecha = explode('-', $fecha);
            $anio = $itemfecha[0];
            $mes = $itemfecha[1];
            $dia = $itemfecha[2];
            $nombremes = '';
            switch ($mes){
                case '1': $nombremes = 'Enero'; break; 
                case '2': $nombremes = 'Febrero'; break; 
                case '3': $nombremes = 'Marzo'; break; 
                case '4': $nombremes = 'Abril'; break; 
                case '5': $nombremes = 'Mayo'; break; 
                case '6': $nombremes = 'Junio'; break; 
                case '7': $nombremes = 'Julio'; break; 
                case '8': $nombremes = 'Agosto'; break; 
                case '9': $nombremes = 'Septiembre'; break; 
                case '10': $nombremes = 'Octubre'; break; 
                case '11': $nombremes = 'Noviembre'; break; 
                case '12': $nombremes = 'Diciembre'; break; 
            }
            $formato = "El ".$dia." de ".$nombremes." del ".$anio;
         }else{//más fechas
             $formato.= "";
             $cantidadFechas = count($masfechas);
             if($cantidad != null){
                 $cantidadFechas = $cantidad;
             }
             for($i=0; $i < $cantidadFechas; $i++){
//                    $datos = explode(' ', $masfechas[$i]);
//                    $masfechas[$i] = $datos[0];

                    $itemfecha = explode('-', $masfechas[$i]);
                    $anio = $itemfecha[0];
                    $mes = $itemfecha[1];
                    $dia = $itemfecha[2];
                    //saber dia
                        $f2 = $mes.$dia.$anio;
                        $diaNumero =date("w",strtotime($f2));
                        $nombredia = '';
                        switch ($diaNumero){
                        case '1': $nombredia = 'Domingo'; break; 
                        case '2': $nombredia = 'Lunes'; break; 
                        case '3': $nombredia = 'Martes'; break; 
                        case '4': $nombredia = 'Miercoles'; break; 
                        case '5': $nombredia = 'Jueves'; break; 
                        case '6': $nombredia = 'Viernes'; break; 
                        case '7': $nombredia = 'Sábado'; break; 
                        
                    }
                    //fin saber dia
                    $nombremes = '';
                    switch ($mes){
                        case '1': $nombremes = 'Enero'; break; 
                        case '2': $nombremes = 'Febrero'; break; 
                        case '3': $nombremes = 'Marzo'; break; 
                        case '4': $nombremes = 'Abril'; break; 
                        case '5': $nombremes = 'Mayo'; break; 
                        case '6': $nombremes = 'Junio'; break; 
                        case '7': $nombremes = 'Julio'; break; 
                        case '8': $nombremes = 'Agosto'; break; 
                        case '9': $nombremes = 'Septiembre'; break; 
                        case '10': $nombremes = 'Octubre'; break; 
                        case '11': $nombremes = 'Noviembre'; break; 
                        case '12': $nombremes = 'Diciembre'; break; 
                    }
                   
                    $formato.= $dia." de ".$nombremes." del ".$anio;
                    if(isset($masfechas[$i+1]) && $cantidadFechas != 1) {
                        $formato.=" <br> ";
                    }
             }
         }
         
         $re = array('fecha'=>$formato, 'hora'=>$hora[0]);
         return $re;
     }
}

?>
