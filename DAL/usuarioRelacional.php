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
    public function DisminuirSaldo($id){
        if($this->conect->conectarse()){
            
            $query = "UPDATE usuario SET saldo = saldo - 500 WHERE _id = '$id'";
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
