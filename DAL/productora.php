<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario
 *
 * @author Daniel
 */
class productora {
    
    private $db;
    function __construct() {
        $conn = new connect();
        $this->db = $conn->getDB();
    }
    
    public function login($mail, $pass)
    {  
        $result = $this->db->productora->findOne(array("email"=>$mail,"clave"=>$pass ));
        return $result;
         //this->db->$coll->find(array("nombre"=>"LOLAPALUSA", "direccion"=>"San carlos #294"))
    }
    
     public function findforid($id){
         $theObjId = new MongoId($id); 
         return $this->db->productora->findOne(array("_id" => $theObjId));
     }
     public function hoy(){
         $a = date('Y-m-d H:i:s'); // date("d-m-Y H:i:s");
         $hoy = new MongoDate(strtotime($a));
         return $hoy;
     }
     
     public function insertar($name, $mail, $pass){ 
         $user = array(
            "nombre" => $name,
            "email" => $mail,
            "clave" => $pass,
             "cantidad_publicacion" => 0,
            "fecha_registro" => $this->hoy()
             
        );
         
       
         return $this->db->productora->insert($user);        
     }
}

?>
