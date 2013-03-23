<?php
    require_once 'DAL/connect.php';
    class comentario{
        private $db;
        function __construct() {
            $conn = new connect();
            $this->db = $conn->getDB();
        }
        
        public function guardarComentarioEvento($comentario,$userId,$eventId,$userName) {         
            $fechaMongo = new MongoDate(strtotime(date('Y-m-d H:i:s')));
            $fechaMuestra = date('Y-m-d H:i:s');
            $coment = array(
                "_userId"=>$userId,
                "_eventId"=>$eventId,
                "userName"=>$userName,
                "comentario"=>$comentario,
                "fechaMongo"=>$fechaMongo,
                "fechaMuestra"=>$fechaMuestra
            );
            return $this->db->comentariosEvento->insert($coment);           
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
