<?php

class establecimiento {
    private $db;
    function __construct() {
        $conn = new connect();
        $this->db = $conn->getDB();
    }
    public function findnear($lat, $long){
        //php = $cursor = $coats->find(Array('latLong' => Array('$near' => $latLong)))->limit(10);
        //find({  loc:  { $near: [50,30], $maxDistance: 5}  }).limit(10)
         //return $this->db->evento->find('loc' => array( '$near' => array( (float)50 , (float)30 ), '$maxDistance' => 1 ));
        $km = 5 / 111.12;
        //lat, lon
         return $this->db->establecimiento->find(Array('loc' => Array( '$near' => array($lat,$long),'$maxDistance' => $km  ) ))->limit(4);
        //return $this->db->evento->find(array("loc" => array('$near' => 50,30))); //array('$near' =>[50,50])
    }
    
    public function agregarEstablecimiento($nom,$dir,$arrayfotos,$tags,$lat,$lng,$desc,$tel,$urltwitter,$urlfacebook, $iduser)
    {
        
         $arrtags = explode(" ", $tags);
         $fotos = explode(",", $arrayfotos);
         $est = array(
             "_idUserCreator"=> $iduser,
            "nombre" => $nom,
            "direccion" => $dir,
            "fotos" => $fotos,
            "telefono" => $tel,
            "redes" => array($urltwitter, $urlfacebook),
             
            "estado"=> 0,
           
            "tags" => $arrtags,
            "loc"=> array((float)$lat, (float)$lng),
            "descripcion"=> $desc
             
         );
         
         return $this->db->establecimiento->insert($est);
        
    }
    
    public function BuscarEstablecimientoPorID($id){
         $theObjId = new MongoId($id); 
         return $this->db->establecimiento->findOne(array("_id" => $theObjId));
     }
    
     
     
     
    
}

?>