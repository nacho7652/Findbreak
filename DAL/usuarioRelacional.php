<?php
    require_once 'relacional/connect_relacional.php';
    

class usuarioRelacional {
    private $conect;
    function __construct() {
        $this->conect = new connect_relacional();
    }
    function __destruct() {
        $this->conect->desconectarse();
    }
    public function insertarUsuarioRelacional($idMongo, $nombre, $saldo){
        if($this->conect->conectarse()){
            $query = "INSERT INTO usuario VALUES('','$idMongo', '$nombre', '$saldo') ";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    public function GuardarEvento($idMongo, $nombre, $precio){
        if($this->conect->conectarse()){
            $query = "INSERT INTO evento VALUES('','$idMongo', '$nombre', '$precio') ";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    public function EliminarEvento($idMongo){
        if($this->conect->conectarse()){
            $query = "DELETE FROM evento WHERE _id = '$idMongo' ";
            $re = mysql_query($query);
            $query2 = "DELETE FROM evento_usuario WHERE id_evento = '$idMongo' ";
            mysql_query($query2);
            return $re;
        }else{
            return -5;
        }
    }
    public function GuardarEvento_____Usuario($idMongoEvento,$idMongoUsuario, $valor_compra,$piso,$pafindbreak){
        if($this->conect->conectarse()){
            $query = "INSERT INTO evento_usuario VALUES('','$idMongoEvento','$idMongoUsuario', 1, '$valor_compra', $piso ,$pafindbreak) ";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    public function DisminuirSaldo($id){
        if($this->conect->conectarse()){
            
            $query = "UPDATE usuario SET saldo = saldo - 500 WHERE _id = '$id'";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    public function PagoVisitas($idUsuario){
        if($this->conect->conectarse()){
            
            $query = "UPDATE usuario SET saldo = saldo + 1000 WHERE _id = '$idUsuario'";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    public function PagoCompraEvento($dinero, $idUsuario){
        if($this->conect->conectarse()){
            
            $query = "UPDATE usuario SET saldo = saldo+'$dinero' WHERE _id = '$idUsuario'";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    public function ValidarSaldo($id){
        if($this->conect->conectarse()){
            $query = "select saldo from usuario where _id='$id'";
            $result = mysql_query($query);
            $saldo = 0;
            while($re = mysql_fetch_array($result)){
                $saldo = $re[0];
            }
            return $saldo;
        }else{
            return -5;
        }
    }
    
    public function VerPiso($idUsuario, $idEvento){
        if($this->conect->conectarse()){
            $query = "select piso1 from evento_usuario where id_evento='$idEvento' and id_usuario='$idUsuario'";
            $result = mysql_query($query);
            $saldo = 0;
            while($re = mysql_fetch_array($result)){
                $saldo = $re[0];
            }
            return $saldo;
        }else{
            return -5;
        }
    }
    
    
    public function VerVigenciaYProducidoPor($idUsuario, $idEvento){
        if($this->conect->conectarse()){
            $query = "select vigencia from evento_usuario where id_evento='$idEvento' and id_usuario='$idUsuario'";
            $result = mysql_query($query);
            $saldo = 0;
            while($re = mysql_fetch_array($result)){
                $saldo = $re[0];
            }
            return $saldo;
        }else{
            return -5;
        }
    }
    public function VerUltimoProductocidoPorVigencia($idEvento){
        if($this->conect->conectarse()){
            $query = "select id_usuario from evento_usuario where id_evento='$idEvento' and vigencia='1'";
            $result = mysql_query($query);
            $saldo = 0;
            while($re = mysql_fetch_array($result)){
                $saldo = $re[0];
            }
            return $saldo;
        }else{
            return -5;
        }
    }
    
    
    
    
    public function VerPrecioEvento($idUsuario, $idEvento){
        if($this->conect->conectarse()){
            $query = "select valor_compra from evento_usuario where id_evento='$idEvento' and id_usuario='$idUsuario'";
            $result = mysql_query($query);
            $saldo = 0;
            while($re = mysql_fetch_array($result)){
                $saldo = $re[0];
            }
            return $saldo;
        }else{
            return -5;
        }
    }
    
    public function CambiarPiso($idUsuario, $idEvento){
        if($this->conect->conectarse()){
            
            $query = "UPDATE evento_usuario SET piso1 = piso1+1 where id_evento='$idEvento' and id_usuario='$idUsuario'";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    
    public function CambiarVigencia($producidoPorIdUsuario, $idEvento){
        if($this->conect->conectarse()){
            
            $query = "UPDATE evento_usuario SET vigencia = 0 where id_evento='$idEvento' and id_usuario='$producidoPorIdUsuario'";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    
    
    public function EventosVigentesPorUsuario($idUsuario){
        if($this->conect->conectarse()){
            $query = "select id_evento from evento_usuario where id_usuario='$idUsuario' and vigencia=1";
            $result = mysql_query($query);
            $eventos = array();
            while($re = mysql_fetch_array($result)){
                $eventos[]= $re[0];
            }
            return $eventos;
        }else{
            return -5;
        }
    }
//    public function buscarEventoParaComprar($idevento){
//        if($this->conect->conectarse()){
//            $query = "select * from evento_usuario where _id='$idevento'";
//            $result = mysql_query($query);
//            $evento;
//            while($re = mysql_fetch_array($result)){
//                $evento = $re['_id'];
//            }
//            return $saldo;
//        }else{
//            return -5;
//        }
//    }
    public function borrarFotoAntiguas($id){
        if($this->conect->conectarse()){
            $query = "SELECT FOTO_PQ, FOTO_GR FROM NOTICIA WHERE ID = $id";
            $result = mysql_query($query);
            $fotoPq = '';
            $fotoGr = '';
            while($re = mysql_fetch_array($result)){
               $fotoPq = $re[0];
               $fotoGr = $re[1];
            }
            $urlPq = '../images/news/'.$fotoPq;
            $urlGr = '../images/news/'.$fotoGr;
            unlink($urlPq);
            unlink($urlGr);
            return true;
        }else{
            return -5;
        }
    }
    
     public function borrar($id){
        if($this->conect->conectarse()){
            $this->borrarFotoAntiguas($id);
            $query = "DELETE FROM NOTICIA WHERE ID = $id";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    
    public function verPorCreador($idUser){
        if($this->conect->conectarse()){
            $query = "SELECT * FROM NOTICIA WHERE ID_USUARIO = $idUser ORDER BY ID DESC";
            $result = mysql_query($query);
            $noticias = array();
            while($re = mysql_fetch_array($result)){
                $noticias[] = array( "id"=>$re[0],
                                     "fotoPq"=>$re[2], 
                                     "fotoGr"=>$re[3],
                                     "titulo"=>$re[4],
                                     "contenido"=>$re[5]
                                    );
            }
            return $noticias;
        }else{
            return -5;
        }
    }
    
    public function verUltimas(){
        if($this->conect->conectarse()){
            $query = "SELECT * FROM NOTICIA ORDER BY ID DESC LIMIT 0,5";
            $result = mysql_query($query);
            $noticias = array();
            while($re = mysql_fetch_array($result)){
                $noticias[] = array( "id"=>$re[0],
                                     "fotoPq"=>$re[2], 
                                     "fotoGr"=>$re[3],
                                     "titulo"=>$re[4],
                                     "contenido"=>$re[5]
                                    );
            }
            return $noticias;
        }else{
            return -5;
        }
    }
    public function verTodas(){
        if($this->conect->conectarse()){
            $query = "SELECT * FROM NOTICIA ORDER BY ID DESC";
            $result = mysql_query($query);
            $noticias = array();
            while($re = mysql_fetch_array($result)){
                $noticias[] = array( "id"=>$re[0],
                                     "fotoPq"=>$re[2], 
                                     "fotoGr"=>$re[3],
                                     "titulo"=>$re[4],
                                     "contenido"=>$re[5]
                                    );
            }
            return $noticias;
        }else{
            return -5;
        }
    }
     public function filtrar($texto){
        if($this->conect->conectarse()){
            $query = "SELECT * FROM NOTICIA WHERE TITULO LIKE '%$texto%' ORDER BY ID DESC";
            $result = mysql_query($query);
            $noticias = array();
            while($re = mysql_fetch_array($result)){
                $noticias[] = array( "id"=>$re[0],
                                     "fotoPq"=>$re[2], 
                                     "fotoGr"=>$re[3],
                                     "titulo"=>$re[4],
                                     "contenido"=>$re[5]
                                    );
            }
            return $noticias;
        }else{
            return -5;
        }
    }
}

?>
