<?php

/*
  notif. 1 = menciones
  notf. 2 = seguidores
  notf. 3 = evento comprado
 */
require_once 'usuarioRelacional.php';
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
    public function verCantidadComentarios($id){
         $theObjId = new MongoId($id); 
         return $this->db->comentariosEvento->find(array("_userId" => $theObjId))->count();
     }
    public function verCantidadPublicaciones($id){
         $theObjId = new MongoId($id); 
         return $this->db->evento->find(array("producido_por._id" => $theObjId))->count();
     }
     public function guardarDenuncia($userid, $evento, $denuncia, $fecha){
                   // $idM = new MongoId($aquien['_id']);   
                    $denuncias = array(
                        "usuario"=>$userid,
                        "evento"=>$evento,
                        "denuncia"=>$denuncia,
                        "fechaMongo"=>$fecha,
                        "revisado"=>0
                      );
                    $this->db->denuncias->insert($denuncias);
             
    }
     
    public function guardarNotificacion2($quien, $aquien, $fechaMongo, $fecha){
                   // $idM = new MongoId($aquien['_id']);   
                    $noti2 = array(
                        "quien"=>$quien['_id'],
                        "aquien"=>$aquien['_id'],
                        "tipo"=>2,
                        "fechaMongo"=>$fechaMongo,
                        "fechaMuestra"=>$fecha,
                        "estado"=>0
                      );
                    $this->db->notificaciones->insert($noti2);
             
    }
     public function guardarNotificacion3($quien, $aquien,$evento,$fechaMongo, $fecha){
                    $idM1 = new MongoId($quien);
                    $idM2 = new MongoId($aquien);
                    $noti3 = array(
                        "quien"=>$idM1,
                        "aquien"=>$idM2,
                        "evento"=>$evento,
                        "tipo"=>3,
                        "fechaMongo"=>$fechaMongo,
                        "fechaMuestra"=>$fecha,
                        "estado"=>0
                      );
                    $this->db->notificaciones->insert($noti3);
             
    }
    public function verNotificaciones($id){
        $idM = new MongoId($id);                   //516e9e314de8b4180d000003
        $mencionesFound = $this->db->notificaciones->find( array("aquien"=>$idM))->sort(array("fechaMongo" => -1 ));
        return $mencionesFound;
    }
    public function verMenciones($id){
        $idM = new MongoId($id);
        $mencionesFound = $this->db->comentariosEvento->find( array("mencionados.id"=>$idM))->sort(array("fechaMongo" => -1 ));;
        return $mencionesFound;
    }
    public function ultimaFechaDenuncia($id, $idEvento){
        $idM = new MongoId($id);
        return $this->db->denuncias->find( array("usuario"=>$id,"evento"=>$idEvento ))->sort(array("fechaMongo" => -1 ))->limit(1);
    }


    public function findFriend($buscador)
    {
        
        $buscador = trim(strtolower($buscador));
        $words = explode(" ", $buscador);
        $result = array();
        for($i=0 ; $i < count($words); $i++){
           $nombre =  array("nombre" => new MongoRegex("/".$words[$i]."/")); // '%rock%'
           $result[]= $nombre;
//           
           $apellido =  array("username" => new MongoRegex("/".$words[$i]."/")); // '%rock%'
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
                                      )->limit(4);
    }
    public function findFriendCitar($buscador)
    {
        
        $buscador = trim(strtolower($buscador));
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
        $passEncript = md5($pass);
        $result = $this->db->usuario->findOne(array("email"=>$mail,"clave"=>$passEncript ));
        return $result;
         //this->db->$coll->find(array("nombre"=>"LOLAPALUSA", "direccion"=>"San carlos #294"))
    }
    
    public function loginFace($mail)
    {
        
        $result = $this->db->usuario->findOne(array("email_face"=>$mail ));
        return $result;
         //this->db->$coll->find(array("nombre"=>"LOLAPALUSA", "direccion"=>"San carlos #294"))
    }
    
     public function findforid($id){
         $theObjId = new MongoId($id); 
         return $this->db->usuario->findOne(array("_id" => $theObjId));
     }
     
     public function findforusername($username){
         return $this->db->usuario->findOne(array("username" => $username));
     }
     public function comprobarClave($clave){
         $clave = md5($clave);
         return $this->db->usuario->findOne(array("clave" => $clave));
     }
     public function findforemail($email){
          
         return $this->db->usuario->findOne(array("email" => $email));
     }
     public function verFoto($id){
         return $this->db->usuario->findOne(array("_id" => $id), array("foto" => 1));
         //return $this->db->usuario->find(array("_id" => $id),array("foto" => 1));
     }
     public function comprobarUserFace($id){
         return $this->db->usuario->findOne(array("_id" => $id), array("userface" => 1));
         //return $this->db->usuario->find(array("_id" => $id),array("foto" => 1));
     }
     public function reemplazarFoto($userid,$fotoGr)
     { 
        $_SESSION['foto'] = "images/productoras/".$_SESSION['userid']."/".$fotoGr;
        return $this->db->usuario->update( array("_id"=>$userid), array('$set'=> array("foto"=>"images/productoras/".$_SESSION['userid']."/".$fotoGr) ));   
     }
     public function modificar($id, $username, $nombre, $mail){ 
//         $theObjId = new MongoId($id); 
        return $this->db->usuario->update(array("_id" => $id), 
                                          array(
                                            '$set'=> array("nombre"=>$nombre,
                                                           "email"=>$mail,
                                                           "username"=>$username      
                                                            )
                                          ));
    
     }
//      private function modificarEnOtrosDctos($id, $username, $nombre, $mail){ 
////         $theObjId = new MongoId($id); 
//         
//         return $this->db->usuario->update(array('siguiendo._id'=>$id), 
//                                          array(
//                                            '$set'=> array("siguiendo.$.nombre"=>$nombre
//                                                            )
//                                          ));
////         return $this->db->usuario->update(array('seguidores.$._id'=>$theObjId), 
////                                          array(
////                                            '$set'=> array("seguidores.$.nombre"=>$nombre
////                                                            )
////                                          ));
//    
//     }
      public function verUserName($id){
         return $this->db->usuario->findOne(array("_id" => $id), array("username" => 1));
         //return $this->db->usuario->find(array("_id" => $id),array("foto" => 1));
     }
     public function verNombre($id){
         return $this->db->usuario->findOne(array("_id" => $id), array("nombre" => 1));
         //return $this->db->usuario->find(array("_id" => $id),array("foto" => 1));
     }
    public function dejarDeSeguir($quien, $aquien)
    {
        $aquien = new MongoId($aquien);
        $this->db->notificaciones->remove(array("tipo" => 2,"quien" => $quien,"aquien" => $aquien));
        return $this->db->usuario->update( array("_id"=>$quien), array('$pull'=> array("siguiendo"=>(array("_id"=>($aquien))))   ));
    }
    public function eliminarSeguidor($quien, $aquien)
    {
       $aquien = new MongoId($aquien);
        
        return $this->db->usuario->update( array("_id"=>$aquien), array('$pull'=> array("seguidores"=>(array("_id"=>($quien))))   ));
    }
    public function agregarSeguidor($quien, $aquien)
    {
        $aquienId = new MongoId($aquien['_id']);
        $user = array(
            "_id"=> $aquienId
        );
        
        return $this->db->usuario->update( array("_id"=>$quien['_id']), array('$push'=> array("siguiendo"=>($user))   )    );
        
    }
    public function agregarSiguiendo($quien, $aquien)
    {
        $aquienId = new MongoId($aquien['_id']);
        $user = array(
            "_id"=> $quien['_id']
        );
        
        return $this->db->usuario->update( array("_id"=>$aquienId), array('$push'=> array("seguidores"=>($user))   )    );
        
    }
    
    public function comprobarSiLoSigo($quien, $aquien)//solicitud pendientes
    {
        $aquien = new MongoId($aquien);
        $quien = new MongoId($quien);
        return   $this->db->usuario->findOne( array("siguiendo._id"=>$aquien, "_id"=>$quien));
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
    
    public function insertar($name, $username, $mail, $pass){ 
         $passEncript = md5($pass);
         $user = array(
            "nombre" => $name,
            "username"=>$username,
            "email" => $mail,
            "email_face" => $mail,
            "user_face" => 0,
            "clave" => $passEncript,
             "tags_buscados" => array(),
             "historial_eventos" => array(),
            "fecha_registro" => $this->hoy(),
            "foto"=>'/findbreak/images/user-default.png'   
        );
         
         $emailRepetido = $this->findforemail($mail);
           if($emailRepetido != "" || $emailRepetido != null)
           {
               return -5; //REPETIDO
           }
           else { 
               $re = $this->db->usuario->insert($user); 
               $usuariorelacional = new usuarioRelacional();
               $usuariorelacional->insertarUsuarioRelacional((string)$user['_id'], $name, 0);
               mkdir('../images/productoras/'.(string)$user['_id'],0777);
               return $user;
          }
         
     }                          //$user_profile['first_name'], $user_profile['last_name'], $user_profile['email'], '',$user_profile['picture'],$user_profile['username']);
     public function insertarFB($name, $mail,$pass, $foto, $username){ 
         $user = array(
            "nombre" => $name,
            "username"=>$username,
            "email" => $mail,
            "email_face" => $mail,
            "user_face" => 1,
            "clave" => $pass,
            "tags_buscados" => array(),
            "historial_eventos" => array(),
            "fecha_registro" => $this->hoy(),
            "foto" => $foto
        );
         
         $emailRepetido = $this->findforemail($mail);
           if($emailRepetido != "" || $emailRepetido != null)
           {
               return -5; //REPETIDO
           }
           else{ 
               $re = $this->db->usuario->insert($user); 
               $usuariorelacional = new usuarioRelacional();
               $usuariorelacional->insertarUsuarioRelacional((string)$user['_id'], $name, 0);
               mkdir('C:/wamp/www/findbreak/images/productoras/'.(string)$user['_id'],0777);
               return $user;
          }
         
     }
     public function updatePhoto($userid, $photo){ 
         return $this->db->usuario->update(array("_id"=>$userid),array('$set'=>array("foto"=>$photo))); 
     }
    public function updateClave($userid, $clave){ 
         $clave = md5($clave);
         
         return $this->db->usuario->update(array("_id"=>$userid),array('$set'=>array("clave"=>$clave))); 
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
}
   ?>  
