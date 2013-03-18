<?php
class insert {
    private $db;
    function __construct() {
        $conn = new connect();
        $this->db = $conn->getDB();
    }
    
    public function getDb() {
        return $this->db;
    }

    public function save($documento, $coll){
        //findbreak->evento->insert($documento);
        return $this->db->$coll->insert($documento);
    }
    
    public function find($coll){
        return $this->db->$coll->find();//ej: findbreak->evento.find();
    }
    //near
    /*
     SELECT *,
              ( 3959 * acos( cos( radians('".$lat."') )".
                "* cos( radians( lat ) ) * cos( radians( lng ) - radians('".$lng."') ) + 
                 sin( radians('".$lat."') ) * sin( radians( lat ) ) ) 
              ) 
                 AS distance 
                 
                FROM eventos HAVING distance < '".$radius."'
     */
    public function findnear(){
        //php = $cursor = $coats->find(Array('latLong' => Array('$near' => $latLong)))->limit(10);
        //find({  loc:  { $near: [-33.5434,-70.5945], $maxDistance: 5}  }).limit(10)
         //return $this->db->evento->find('loc' => array( '$near' => array( (float)50 , (float)30 ), '$maxDistance' => 1 ));
        $km = 20 / 111.12;
        //lat, lon
       
    
        return $this->db->evento->find(Array('loc' => Array( '$near' => array(-33.5434,-70.5945),'$maxDistance' => $km  ) ))->limit(4);
        //return $this->db->evento->find(array("loc" => array('$near' => 50,30))); //array('$near' =>[50,50])
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
                                           )
                                      );
    }

    public function borrar($coll){
        return $this->db->$coll->remove();
    }


    /*SQL TO MONGO*/
    //SELECT * FROM evento
    //$this->db->$coll->find();
    
    //SELECT * FROM evento WHERE nombre = "LOLAPALUSA" AND direccion = "San carlos #294"
    //this->db->$coll->find(array("nombre"=>"LOLAPALUSA", "direccion"=>"San carlos #294")); 
    
    //SELECT * FROM evento WHERE nombre = "LOLAPALUSA"
    //$this->db->$coll->find(array("nombre"=>"LOLAPALUSA"));
    
    //SELECT * FROM evento WHERE fecha_realizacion > "14-10-12"
    //$this->db->$coll->find(array("fecha_realizacion" => array('$gt' => "14-10-12" )));
    
    //SELECT * FROM evento WHERE tags like '%hard%' or '%tocata%' or '%asc%'
    /*$this->db->evento->find(array('$or' => array(
                                                            
                                                            array("tags" => new MongoRegex("/hard/")), 
                                                            array("tags" => new MongoRegex("/tocata/"))
                                                            array("tags" => new MongoRegex("/asc/"))
                                                  )
                                           )
                                      );*/
    
    //SELECT * FROM evento WHERE fecha_realizacion > $fecha_hoy
    //$this->db->$coll->find(array("fecha_realizacion" => array('$gt' => new MongoDate(strtotime("19-09-2012")))));
    
    
    //SELECT * FROM evento WHERE lat = 50 AND lon = 50
    // $this->db->evento->find(array("loc"=>array(50,33))); 
}

?>
