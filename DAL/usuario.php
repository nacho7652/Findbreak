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
class usuario {
    
    private $db;
    function __construct() {
        $conn = new connect();
        $this->db = $conn->getDB();
    }
    
    public function findFriend($buscador)
    {
        $buscador = strtolower($buscador);
        $words = explode(" ", $buscador);
        $result = array();
        for($i=0 ; $i < count($words); $i++){
           $nombre =  array("nombre" => new MongoRegex("/".$words[$i]."/")); // '%rock%'
           $result[]= $nombre;
//           
           $apellido =  array("apellido" => new MongoRegex("/".$words[$i]."/")); // '%rock%'
           $result[]= $apellido;
        }
        return $this->db->usuario->find(array('$or' => $result//
//                                                      array(
//                                                            //$result
//                                                           array("nombre" => new MongoRegex("/D/"))
////                                                            array("tags" => new MongoRegex("/lsls/")),
////                                                            array("tags" => new MongoRegex("/asc/"))
//                                                          )
                                           )
                                      )->limit(5);
    }
    
    public function login($mail, $pass)
    {
        
        $result = $this->db->usuario->findOne(array("email"=>$mail,"clave"=>$pass ));
        return $result;
         //this->db->$coll->find(array("nombre"=>"LOLAPALUSA", "direccion"=>"San carlos #294"))
    }
    
     public function findforid($id){
         $theObjId = new MongoId($id); 
         return $this->db->usuario->findOne(array("_id" => $theObjId));
     }
     
       public function SaveRequest($solicitante, $solicitado, $nombre_solicitado, $nombre_solicitante){
        //findbreak->evento->insert($documento);
           $solicitado = new MongoId($solicitado);
           $solicitante = new MongoId($solicitante);
           $solicitud = array ( 
             "solicitado"=>array("_id"=>$solicitado, "nombre"=>$nombre_solicitado),
             "solicitante"=>array("_id"=>$solicitante, "nombre"=>$nombre_solicitante),
             "estado"=>0
           );
        return $this->db->solicitud_amigos->save($solicitud);
    }
    
    
    public function solicitudPendientes($idSolicitado)//solicitud pendientes
    {
        $idSolicitado = new MongoId($idSolicitado);
       // $solicitante = new MongoId($solicitante);
      //  return $this->db->solicitud_amigos->findOne(array("solicitado._id"=>$solicitante, "solicitante._id"=> $idSolicitado));//Sirve
        
        $uno = $this->db->usuario->findOne(array("siguiendo._id"=>$solicitante, "solicitante._id"=> $idSolicitado));
        if(empty($uno))
        {
            return $this->db->solicitud_amigos->findOne(array("solicitado._id"=>$idSolicitado, "solicitante._id"=> $solicitante));
        }
        else
        {
            return $this->db->solicitud_amigos->findOne(array("solicitado._id"=>$solicitante, "solicitante._id"=> $idSolicitado));
        }
    }
    
    
    public function VerSolicitudes($idUsuario)
    {
        $idUsuario = new MongoId($idUsuario);
        //$this->db->evento->find(array("loc"=>array(50,33))); 
          //SELECT * FROM evento WHERE nombre = "LOLAPALUSA" AND direccion = "San carlos #294"
    //this->db->$coll->find(array("nombre"=>"LOLAPALUSA", "direccion"=>"San carlos #294"));
               return $this->db->solicitud_amigos->find(array( "solicitado._id"=>$idUsuario, "estado"=>0));

    }
    
    public function AceptarSolicitud($idSolicitud)
    {
        //estado=1 SON AMIGOS 
        //$this->db->contacto->update($criterio,array('$set'=>array($cal)));
        $MonId = new MongoId($idSolicitud);
        $sol_enc = $this->db->solicitud_amigos->findOne(array( "_id"=>$MonId));
        
        $this->db->solicitud_amigos->update(array("_id"=>$MonId),array('$set'=> array("estado"=>1)));
        $usuario = new usuario();
        $usuario->AgregarAmigosSolicitud1($sol_enc["solicitado"], $sol_enc["solicitante"]);
        $usuario->AgregarAmigosSolicitud2($sol_enc["solicitante"], $sol_enc["solicitado"]);
        
        
    }
    public function RechazarSolicitud( $idSolicitud)
    {
        $MonId = new MongoId($idSolicitud);
        $this->db->solicitud_amigos->remove(array("_id"=>$MonId));
    }
    
    public function AgregarAmigosSolicitud1($nom1, $nom2)
    {
        $user = array(
            "_id"=> $nom2['_id'],
            "nombre"=> $nom2['nombre']
        );
        
        $this->db->usuario->update( array("_id"=>$nom1['_id']), array('$push'=> array("amigos"=>($user))   )    );
        
    }
    public function AgregarAmigosSolicitud2($nom2, $nom1)
    {
        $user = array(
            "_id"=> $nom1['_id'],
            "nombre"=> $nom1['nombre']
        );
        $this->db->usuario->update( array("_id"=>$nom2['_id']), array('$push'=> array("amigos"=>($user))   )    );
        
    }
      public function diferencia($fechahoy, $fechaold){//diferencia de fechas en dias
         
        $itemold = explode("-", $fechaold);
        $itemhoy = explode("-", $fechahoy);
        $diaold = $itemold[0];
        $mesold = $itemold[1];
        $anoold = $itemold[2];

        $diahoy = $itemhoy[0];
        $meshoy = $itemhoy[1];
        $anohoy = $itemhoy[2];
        $dias_diferencia = 0;
        
        //calculo timestam de las dos fechas 
        $timestamp1 = mktime(0,0,0,$mesold,$diaold,$anoold); 
        $timestamp2 = mktime(4,12,0,$meshoy,$diahoy,$anohoy); 

        //resto a una fecha la otra 
        $segundos_diferencia = $timestamp1 - $timestamp2; 
        //echo $segundos_diferencia; 

        //convierto segundos en días 
        $dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 

        //obtengo el valor absoulto de los días (quito el posible signo negativo) 
        $dias_diferencia = abs($dias_diferencia); 

        //quito los decimales a los días de diferencia 
        $dias_diferencia = floor($dias_diferencia); 
        
        return $dias_diferencia;

        
//        if( $anoold < $anohoy){//si me meti al otro año
//            $difanos = $anohoy - $anoold;
//            $diastrans = $diastrans + 365 * $difanos;
//        }
//        if( $mesold <  $meshoy)//si me meto el primero de enero y depues el primero de febrero
//        {  
//            $difmes = $meshoy - $mesold;
//            $diastrans = $diastrans + 30 * $difmes;
//        }
//        if( $diaold <  $diahoy)//si me meto el primero de enero y depues el primero de febrero
//        {  
//            $difdia = $diahoy - $diaold;
//            $diastrans = $diastrans + $difdia;
//        }
                
//        }elseif($anioA == $anioT){//si estoy en el mismo año
//            if($mesA < $mesT){
//                $meses = $mesT - $mesA;
//            }elseif ($mesA == $mesT) {
//                $meses = 0;
//            }
//            
//        }
//        
//        if($diaA < $diaT){
//                    $dias = $diaT - $diaA;
//                }elseif($diaA > $diaT){
//                    $dias = 30 - ($diaA - $diaT);
//                    $meses--;
//                }else{//mismo dia
//                    $dias = 0;
//                }
       return $diastrans;
    }
    
     public function guardarTagsBuscados($userid, $tags){
        
        //ver si existe un dcto de userid
         $dcto = $this->db->tags_buscados->findOne(array("userid"=>$userid));
         $tagfound = array();
         if(isset($dcto['_id'])){//si ya tiene un dcto con sus registros de inteligencia ACTUALIZO
                      
                      for($i = 0; $i<count($tags); $i++){
                        //si existe el tag le sumo
                        $tagfound = $this->db->tags_buscados->findOne( array("tags.tag"=>$tags[$i], "userid"=>$userid));
                        if(isset($tagfound['tags'])){
                            $this->db->tags_buscados->update(array("userid"=>$userid, "tags.tag"=>$tags[$i]), array('$inc'=>array("tags.$.cantidad"=>1)));
//                            $fechaold = $tagfound['tags'][$i];
//                            if($tagfound[$i]['tags.fecha']=="")
//                                {
//                                
//                                }
                             for($x=0; $x<count($tagfound['tags']); $x++){
                                 if($tags[$i] == $tagfound['tags'][$x]['tag']){
                                      $fechaold = $tagfound['tags'][$x]['fecha'];
                                      $fechahoy = date('d-m-y');
                                      $trans = $this->diferencia($fechahoy, $fechaold);
                                      if($trans > 0)
                                      {
                                          $this->db->tags_buscados->update(array("userid"=>$userid, "tags.tag"=>$tags[$i]), array('$inc'=>array("tags.$.dias_trans"=>$trans)));
                                          $this->db->tags_buscados->update(array("userid"=>$userid, "tags.tag"=>$tags[$i]), array('$set'=>array("tags.$.fecha"=>$fechahoy)));
                                      }
                                 }
                             }   
                             
                        }else{//si no, lo creo
                        $fechahoy = date('d-m-y');
                        $newtag = array(
                                        "tag"=>$tags[$i],
                                        "cantidad"=>1,
                                        "dias_trans"=>1,
                                        "fecha"=>$fechahoy,
                                        "agregado"=>0
                            );
                        
                        $this->db->tags_buscados->update(array("userid"=>$userid),array('$addToSet'=>array("tags"=>$newtag)));
                        }//else

                      }
         }else{//creo un documento nuevo con sus tags buscados
              $newtags = array();
                for($i = 0; $i<count($tags); $i++){
                $fechahoy = date('d-m-y');
                //$fecha = new MongoDate(strtotime($fechahoy));
                $newtag = array(
                "tag"=>$tags[$i],
                "cantidad"=>1,
                "dias_trans"=>1,
                "fecha"=>$fechahoy,
                "agregado"=>0
                );
                $newtags[] = $newtag;

                }


                $eventos_buscados = array(
                "userid"=> $userid,
                "tags"=>$newtags
                );
                return $this->db->tags_buscados->insert($eventos_buscados);
                
         }
         $this->actualizarDias($dcto, $userid);//llamo para actualizar dias
         $this->ingresarTagFavorito($dcto,$userid);//llamo al verificar recurrencia
    }
    
     public function ingresarTagFavorito($dcto,$userid)//Ingresar tag favorito
    {
       
        for($x=0; $x<count($dcto['tags']); $x++)//dcto es el documento tags_buscados
        {
            $cant = $dcto['tags'][$x]['cantidad'];
            $dias = $dcto['tags'][$x]['dias_trans'];
            $tag = $dcto['tags'][$x]['tag'];
            $div = $cant/$dias;
            $fechaold = $dcto['tags'][$x]['fecha'];
            $fechahoy = date('d-m-y');
            $dias_inac = $this->diferencia($fechahoy, $fechaold);
        //            $user = $this->db->usuario->findOne(array('_id'=>$userid,'tags_buscados'=>$tag));
        //            if(isset($user['tags_buscados']))
            if($dcto['tags'][$x]['agregado'] == 0)
                    if($div > 0.1 && $cant > 3)//si cumple con el tag se convierte en favorito
                    {
                        $tagfavorito = array(
                            "tag"=>$tag,
                            "dias_inact"=>$dias_inac
                        );

                        $this->db->usuario->update(array("_id"=>$userid),array('$push'=>array("tags_buscados"=>$tagfavorito)));
                        $this->db->tags_buscados->update(array("userid"=>$userid, "tags.tag"=>$tag), array('$set'=>array("tags.$.agregado"=>1)));

                        
                    }
        }
    }
     public function guardarHistorial($idEvento, $fotoEvento, $nombreEvento, $producidoPor, $userid){
       if($idEvento != null){
            
            $fecha = date('Y-m-d H:i:s'); // date("d-m-Y H:i:s");
            $now = new MongoDate(strtotime($fecha));
            $user = $this->db->usuario->findOne(array("_id" => $userid));
            //$eventhistorial = $this->db->usuario->findOne(array("_id" => $userid, "historial_eventos._id" => $idEvento));
            $allhistorial = $user['historial_eventos'];
            $entro = false;
          
           if(count($allhistorial) > 0){//tiene eventos n el historial
               foreach ($allhistorial as $dcto){
      //         if(!$entro && isset($dcto['fecha'])){
                     if($dcto['_id'] == $idEvento){
                         $entro = true;
                         return $this->db->usuario->update( array("_id" => $userid,  "historial_eventos._id" => $idEvento), array('$set'=>array("historial_eventos.$.fecha"=>$now)));


                     }//else{
                        

                     //}
             //  }
           }
                $entro = true;
                         $historial_docto = array("_id"=>$idEvento,
                                                "nombre"=>$nombreEvento,
                                                "foto"=>$fotoEvento,
                                                "producido_por"=>$producidoPor,
                                                "fecha"=>$now);
                         return $this->db->usuario->update( array("_id" => $userid), array('$push'=>array("historial_eventos"=>$historial_docto))); 
              
           }else{//primera vez
                $entro = true;
             $historial_docto = array("_id"=>$idEvento,
                                    "nombre"=>$nombreEvento,
                                    "foto"=>$fotoEvento,
                                    "producido_por"=>$producidoPor,
                                    "fecha"=>$now);
             return $this->db->usuario->update( array("_id" => $userid), array('$push'=>array("historial_eventos"=>$historial_docto))); 

           }
           
       }// null
     //}
     
     }
     public function verHitorial($userid){
         return $this->db->usuario->findOne(array("_id" => $userid), array("historial_eventos" => 1));
     }
     
    
    public function actualizarDias($dcto,$userid)//actualizar dias inactividad de tags
    {
        $user = $this->db->usuario->findOne(array('_id'=>$userid));
        if(isset($user['tags_buscados'])){//si tengo tags buscados agregados en el documento usuario
            $fechahoy = date('d-m-y');
            for($x=0;$x<count($dcto['tags']);$x++)
            {
                $tag = $dcto['tags'][$x]['tag'];
                $fechaold = $dcto['tags'][$x]['fecha'];
                for($i=0;$i<count($user['tags_buscados']);$i++)
                {
                    $tagFav = $user['tags_buscados'][$i]['tag'];
                    if($tag == $tagFav)
                    {                  
                            $dias_trans = $this->diferencia($fechahoy, $fechaold);
                            if(strtotime($fechaold)==  strtotime($fechahoy))
                            {
                                $dias_trans = "0";
                            }
                            $this->db->usuario->update(array("_id"=>$userid,"tags_buscados.tag"=>$tag), array('$set'=>array("tags_buscados.$.dias_inact"=>$dias_trans)));
                    }

                }
            }
        }
    }
    
    public function hoy(){
         $a = date('Y-m-d 00:00:00'); // date("d-m-Y H:i:s");
         $hoy = new MongoDate(strtotime($a));
         return $hoy;
     }
     
    public function verEventosFavoritos($tagsfavoritos){
        $result = array();
        for($i=0 ; $i < count($tagsfavoritos); $i++){
           $tags =  array("tags" => new MongoRegex("/".$tagsfavoritos[$i]['tag']."/")); // '%rock%'
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
                                      );
    }
     
     public function insertar($name, $apellido, $mail, $pass){ 
         $user = array(
            "nombre" => $name,
            "apellido" => $apellido,
            "email" => $mail,
            "clave" => $pass,
             "amigos" => array(),
             "tags_buscados" => array(),
             "historial_eventos" => array(),
            "fecha_registro" => $this->hoy()
             
        );
         return $this->db->usuario->insert($user);        
     }
     
     public function modificarfoto($name, $apellido, $mail, $pass){ 
         $user = array(
            "nombre" => $name,
            "apellido" => $apellido,
            "email" => $mail,
            "clave" => $pass,
            
            "fecha_registro" => $this->hoy()
             
        );
         return $this->db->usuario->insert($user);        
     }
    
}//fin class

?>
