<?php

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
                return $this->db->evento->find(Array('loc' => Array( '$near' => array($lat,$long), '$maxDistance' => $km   ) , '$or' => array( array('fecha_realizacion'=> array('$gte' => $a )) )    ))->limit(100);

    }
    public function findforid($id){
         $theObjId = new MongoId($id); 
         return $this->db->evento->findOne(array("_id" => $theObjId));
     }
     public function findpopular(){
         $numeroPromedio = $this->promedioVisitas();
         return $this->db->evento->find(array( 'fecha_realizacion'=> array('$gte' => $this->hoy()), 'visitas'=> array('$gte' => $numeroPromedio) ))->sort(array("visitas" => -1 ))->limit(4);
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
     
      public function filtrar($buscador){
        $words = explode(" ", $buscador);
        $result = array();
        for($i=0 ; $i < count($words); $i++){
           $tags =  array("tags" => new MongoRegex("/".$words[$i]."/")); // '%rock%'
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
                                      )->limit(5);
    }
    
     public function findall(){
         return $this->db->evento->find();
     }
     
    public function sumarvisita($id){
         $theObjId = new  MongoId($id);
         return $this->db->evento->update(array("_id" => $theObjId), array('$inc'=> array("visitas"=>1)));
     }
     private function crearHash($nom){
         $arr = explode(' ', $nom);
         $hash = '#';
         for($i=0; $i<count($arr); $i++){
             $hash.= ucwords($arr[$i]);
         }
         return $hash;
     }

     public function insertar($userid, $username, $nombre, $direccion, $arrayfotos, $fechaString,$fechaMongo ,$hor, $tags, $lat, $lng, $desc, $urlfb, $urltw, 
                             $video, $establecimiento, $precio, $puntosDeVenta, $sitioWeb, $dondeComprar){ 
         $arrtags = explode(" ", $tags);
         $fotos = explode(",", $arrayfotos);
         
         $event = array(
            "nombre" => $nombre,
            "hash" => $this->crearHash($nombre),
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
             "redes" => array($urlfb, $urltw),
             "video" => $video,
             "establecimiento"=> $establecimiento,
             "precio"=>$precio,
             "puntos_de_venta"=>$puntosDeVenta,
             "sitio_web"=>$sitioWeb,
             "donde_comprar"=>$dondeComprar
        );
         //MODIFICAR EVENTOS PUBLICADOS
         
         
         return $this->db->evento->insert($event);        
     }
     
     public function EventosPorRealizarPorIdProductora($idProductora)
     { 
         return $this->db->evento->find(array('producido_por._id'=>$idProductora, 'fecha_realizacion'=> array('$gte' => $this->hoy()) ));    
         }
     
     public function EventosDONEPorIdProductora($idProductora)
     {
         return $this->db->evento->find(array('producido_por._id'=>$idProductora, 'fecha_realizacion'=> array('$lt' => $this->hoy()) ))->sort(array("fecha_realizacion" => -1 ));
     }
     

     public function encod($string){
         return utf8_encode($string);   
         
     }
     
     public function formatoFecha($fecha, $hora){
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
             $formato.= "El ";
             for($i=0; $i < count($masfechas); $i++){
//                    $datos = explode(' ', $masfechas[$i]);
//                    $masfechas[$i] = $datos[0];

                    $itemfecha = explode('-', $masfechas[$i]);
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
                    $formato.= $dia." de ".$nombremes." del ".$anio;
                    if(isset($masfechas[$i+1])){
                        $formato.=", ";
                    }
             }
         }
         
         $re = array('fecha'=>$formato, 'hora'=>$hora[0]);
         return $re;
     }
}

?>