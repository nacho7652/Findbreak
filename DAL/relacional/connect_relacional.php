<?php
require_once 'config.php';
class connect_relacional {
   
   public static function conectarse()
   {
       $conn = mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("Error de Conexion");
       mysql_select_db(DB_NAME) or die ("Verifique la Base de Datos");
       mysql_query("SET NAMES 'utf8'");
       return $conn;
   }
   public static function desconectarse()
   {
       if(connect_relacional::conectarse()){
            mysql_close();
       }
   }

}

?>
