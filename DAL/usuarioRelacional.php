<?php

class usuarioRelacional {
    private $conect;
    function __construct() {
        $this->conect = new connect();
    }
    function __destruct() {
        $this->conect->desconectarse();
    }
    public function guardar($idUser, $titulo, $fotoPq, $fotoGr, $contenido){
        if($this->conect->conectarse()){
            $query = "INSERT INTO NOTICIA VALUES('',$idUser, '$fotoPq', '$fotoGr', '$titulo', '$contenido') ";
            $re = mysql_query($query);
            if($re){
                $idNoticia = 0;
                $result = mysql_query("select last_insert_id();");
                   while($re1 = mysql_fetch_array($result)){
                       $idNoticia = $re1[0];
                   }
            }
            return $idNoticia;
        }else{
            return -5;
        }
    }
    public function modificarConFoto($id, $fotoPq, $fotoGr, $titulo, $contenido){
        if($this->conect->conectarse()){
            $this->borrarFotoAntiguas($id);
            $query = "UPDATE NOTICIA SET FOTO_PQ = '$fotoPq', 
                                     FOTO_GR = '$fotoGr', 
                                     TITULO = '$titulo', 
                                     CONTENIDO = '$contenido'
                                     WHERE ID = $id";
            $re = mysql_query($query);
            
            return $re;
        }else{
            return -5;
        }
    }
    public function modificarSinFoto($id,$titulo, $contenido){
        if($this->conect->conectarse()){
            $query = "UPDATE NOTICIA SET TITULO = '$titulo', 
                                     CONTENIDO = '$contenido'
                                     WHERE ID = $id";
            $re = mysql_query($query);
            
            return $re;
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
