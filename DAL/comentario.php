<?php
    
    class comentario{
        private $db;
        function __construct() {
            $conn = new connect();
            $this->db = $conn->getDB();
        }
        public function revisado($id, $userid){
            $theObjId = new MongoId($id); 
            return $this->db->comentariosEvento->update(array("_id" => $theObjId, "mencionados.id" => $userid),array('$set' => array('mencionados.$.revisado' => 1)));
        }
        public function eliminar($id){
         $theObjId = new MongoId($id); 
         return $this->db->comentariosEvento->remove(array("_id" => $theObjId));
        }
        public function findcomentarioforid($id){
         $theObjId = new MongoId($id); 
         return $this->db->comentariosEvento->findOne(array("_id" => $theObjId));
        }
        public function findforid($id){
        // $theObjId = new MongoId($id); 
         return $this->db->comentariosEvento->find(array("_eventId" => $id))->sort(array("fechaMongo" => -1 ));
        }
        public function verFecha($fechaComentario){
//           $datosComentario = explode(' ', $dcto['fechaMuestra']);
//           $fechaComentario = $datosComentario[0];
//           $horaComentario = $datosComentario[1];
        $fechaAc = date('Y-m-d H:i:s');
        
        $fechaAcsinHora = explode(" ",$fechaAc);
        $datosFechaAc = explode("-",$fechaAcsinHora[0]);
        $anioA = $datosFechaAc[0];
        $mesA = $datosFechaAc[1];
        $diaA = $datosFechaAc[2];
        
        
        $fechaComsinHora = explode(" ",$fechaComentario);
        $datosFechaTe = explode("-",$fechaComsinHora[0]);
       // $datosFechaTe = explode("-",$fechaComentarioSin);
        $anioT = $datosFechaTe[0];
        $mesT = $datosFechaTe[1];
        $diaT = $datosFechaTe[2];
        
        if($anioA < $anioT){//si la caducidad es al otro aÃ±o
            $difAnio = $anioT - $anioA;
            $meses = $difAnio * 12;
            if($mesA < $mesT)//si el mes actual es menor al de caducidad
            {  
                $meses+= $mesT - $mesA;    
            }elseif ($mesA > $mesT) {
                $meses-= $mesA - $mesT;
            }
                
        }elseif($anioA == $anioT){//si estoy en el mismo aÃ±o
            if($mesA < $mesT){
                $meses = $mesT - $mesA;
            }elseif ($mesA == $mesT) {
                $meses = 0;
            }
            
        }
        
        if($diaA < $diaT){
                    $dias = $diaT - $diaA;
                }elseif($diaA > $diaT){
                    $dias = 30 - ($diaA - $diaT);
                    $meses--;
                }else{//mismo dia
                    $dias = 0;
                }
       $texto = '';
       //SI ES HOY
       if($meses == 0 && $dias == 0){
            $resta = $this->diferenciaEntreFechas($fechaComentario, $fechaAc, "MINUTOS", TRUE);
            if($resta < 60){
                if($resta == 0){
                    $texto = 'Justo ahora';
                }elseif($resta == 1){
                    $texto = 'Hace 1 minuto';
                }else{
                    $texto = 'Hace '.$resta.' minutos';
                }
            }else{
                $resta = $this->diferenciaEntreFechas($fechaComentario, $fechaAc, "HORAS", TRUE);
                if($resta == 1){
                    $texto = 'Hace una hora';
                }else{
                    $texto = 'Hace '.$resta.' horas';
                }     
            }
       }else{
           $resta = $this->diferenciaEntreFechas($fechaComentario, $fechaAc, "DIAS", TRUE);
           if($resta == 1){
               $texto = 'Hace un dia';
           }elseif($resta == 0){
               $texto = 'Hace algunas horas';
           }else{
                $texto = 'Hace '.$resta.' dias';
           }
       }       
       return $texto;   
    }
    
    function diferenciaEntreFechas($fecha_principal, $fecha_secundaria, $obtener = 'SEGUNDOS', $redondear = false){
        $f0 = strtotime($fecha_principal);
        $f1 = strtotime($fecha_secundaria);
        if ($f0 < $f1) 
        {
            $tmp = $f1; 
            $f1 = $f0; 
            $f0 = $tmp; 
         }
        $resultado = ($f0 - $f1);
        switch ($obtener) {
            default: break;
            case "MINUTOS"   :   $resultado = $resultado / 60;   break;
            case "HORAS"     :   $resultado = $resultado / 60 / 60;   break;
            case "DIAS"      :   $resultado = $resultado / 60 / 60 / 24;   break;
            case "SEMANAS"   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;
        }
        if($redondear) $resultado = round($resultado);
        return $resultado;
}
        private function transformarMenciones($menciones){
//            $puntosDeVenta = array( array('id'=>'232323',
//                                          'nombre'=>'Ticket Master',
//                                          'web'=>'http://www.google.cl'),
//                                    array('id'=>'232323',
//                                          'nombre'=>'Ticket Master',
//                                          'web'=>'http://www.google.cl')
//                                   );
            $partes = explode('-', $menciones);
            $arr = array();
            for($i=0; $i<count($partes)-1; $i++){
                $id = new MongoId($partes[$i]);
                $arr[] = array('id'=>$id,'revisado'=>0);
            }
            return $arr;
        }
        public function guardarComentarioEvento($comentario,$userId,$eventId,$userName, $fecha, $menciones) {  
            $theObjId = new MongoId($eventId);
            $fechaMongo = new MongoDate(strtotime($fecha));
            $mencionados = $this->transformarMenciones($menciones);
            $coment = array(
                "_userId"=>$userId,
                "_eventId"=>$theObjId,
                "userName"=>$userName,
                "comentario"=>$comentario,
                "fechaMongo"=>$fechaMongo,
                "fechaMuestra"=>$fecha,
                "mencionados"=>$mencionados
            );
             $this->db->comentariosEvento->insert($coment);   
            
        }
        
        public function guardarComentarioEstablecimiento($comentario,$userId,$estaId,$userName) {         
            $fechaMongo = new MongoDate(strtotime(date('Y-m-d H:i:s')));
            $fechaMuestra = date('Y-m-d H:i:s');
            $coment = array(
                "_userId"=>$userId,
                "_eventId"=>$estaId,
                "userName"=>$userName,
                "comentario"=>$comentario,
                "fechaMongo"=>$fechaMongo,
                "fechaMuestra"=>$fechaMuestra
            );
            return $this->db->comentariosEstablecimiento->insert($coment);           
        }
        
        public function guardarHashtag($hash) {
            $fecha = new MongoDate(strtotime(date('Y-m-d H:i:s')));
            $hashTagNew = array(
                "hashtag"=>$hash,
                "fecha"=>$fecha,
                "cont"=>1
            );
            return $this->db->hashtags->insert($hashTagNew);
        }
        
        
    }
?>
