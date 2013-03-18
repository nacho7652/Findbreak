<?php
require_once 'DAL/connect.php';
class contacto{
    private $db;
    function __construct() {
        $conn = new connect();
        $this->db = $conn->getDB();
    }
    
    public function registrar($fecha,$id_pro,$nom_pro,$email_pro,$id_event,$nom_event,$id_prove,$nom_prove,$tel_prove){
       $contac = array(
           "fecha"=>$fecha,
           "prodctora"=>(object)array(
               "id_productora"=>$id_pro,
               "nombre"=>$nom_pro,
               "evento"=>(object)array(
                   "id_event"=>$id_event,
                   "nom_event"=>$nom_event
                                        ),
               "calificacion"=>"",
               "contactado"=>"no",
               "comentario"=>""
               ),
           "proveedor"=>(object)array(
               "id_prove"=>$id_prove,
               "nom_prove"=>$nom_prove,
               "telefonos"=>$tel_prove,
               "calificacion"=>"",
               "contactado"=>"no",
               "comentario"=>""
           )
           );
           $this->db->contacto->save($contac);
    }
    
    public function califcarProductora($calif,$id_doc,$coment)
    {
        $cal = array(
            "productora.$.calificacion"=>$calif,
            "productora.$.contactado"=>"si",
            "productora.$.comentario"=>$coment
        );
        $MonId = new MongoId($id_doc);
        $criterio =  array("_id" => $MonId);
        $this->db->contacto->update($criterio,array('$set'=>array($cal)));
    }
    
    public function califcarProveedor($calif,$id_doc,$coment)
    {
        $cal = array(
            "proveedor.$.calificacion"=>$calif,
            "proveedor.$.contactado"=>"si",
            "proveedor.$.comentario"=>$coment
        );
        $MonId = new MongoId($id_doc);
        $criterio =  array("_id" => $MonId);
        $this->db->contacto->update($criterio,array('$set'=>array($cal)));
    }
    
    public function buscarCalificacionesProductora($id_Produc)
    {
        return $this->db->contacto->find(array("id_productora"=>$id_Produc, "contactado"=>"no"));
    }
    
    public function buscarCalificacionesProveedor($id_Provee)
    {
        return $this->db->contacto->find(array("id_prove"=>$id_Provee, "contactado"=>"no"));
    }
}
?>
