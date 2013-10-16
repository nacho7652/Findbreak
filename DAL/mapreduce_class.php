<?php



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of mapreduce_class

 *

 * @author Dieego

 */

class mapreduce_class {

   private $db;

    function __construct() {

        $conn = new connect();

        $this->db = $conn->getDB();

    }

    public function findnear(){

      $map2 = new MongoCode("function() {".

          "for(i=0; i< this.tags.length; i++) {".

               "emit(this.tags[i], 1); ".

          "} ".

       "} ");

       $reduce2 = new MongoCode("function(key, values) {".

          "var count = 0;

              for(i=0; i< values.length; i++) {".

               "count += values[i];".

          "} 

           return count;   

       } ");

       

//       $map = new MongoCode("function() {".

//               "emit(this.estado, this.nombre); 

//             } ");

       $map = new MongoCode("function() {".

               "emit(this.lat_lng, this); ".

       "} ");
       $reduce3 = new MongoCode("function(key, values) {".

          "var count = new Array();

              for(i=0; i< values.length; i++) {".

               "count = values[i]._id ".
          "} 

           return count;   

       } ");
       $reduce = new MongoCode("function(key, values) {".

          "var count = new Array();

              for(i=0; i< values.length; i++) {".

               "count += values[i]._id; ".

               "count += '+';".

               "count += values[i].nombre;".
               
               "count += '+';".

               "count += values[i].hash;".
               
               "count += '+';".
               
               "count += values[i].direccion;".
               
               "count += '+';".
               
               "count += values[i].fotos[0]['pe'] +'+'+ values[i].fotos[0]['gr'];".
               
               "count += ';';".

          "} 

           return count;   

       } ");

       

//       $map = new MongoCode("function() {".
//
//               "emit(this.verificacion, this); ".
//
//       "} ");
//
//       $reduce = new MongoCode("function(key, values) {".
//
//          "var count = {id: {}, direccion:{}, tags: {} };
//
//              for(i=0; i< values.length; i++) {".
//
//               "count.push({id: values[i]._id, values[i].direccion }); ".
//               
//             
//
//          "} 
//
//           return count;   
//
//       } ");


//       $map = new MongoCode("function() {".

//               "emit(this.verificacion, this.nombre); ".

//       "} ");

//       $reduce = new MongoCode("function(key, values) {".

//          "var count;

//              for(i=0; i< values.length; i++) {".

//               "count += values[i]; ".

//          "} 

//           return count;   

//       } ");

       
       $a = date("d-m-Y H:i:s");
       $hoy = new MongoDate(strtotime($a));
       (float)$lat = -33.5350000003;
       (float)$lng =  -70.6641667;
       $command = array(

                          'mapreduce' => 'evento',

                          'map' => $map,

                          'reduce' => $reduce,
                          
                          'out' => 'anuncios_ordenados5',//la feña es la polola maaaaaaaas linda de todo el universo! y la galaxia entera y me quiere muuucho!tdbdcb,

                          'query' => array('loc' => array( '$near' => array($lat,$lng), '$maxDistance' => 1000),
                                             'fecha-caducidad-mongo' => array('$gte' => $hoy ) )
                          
//                          'query' => array('loc' => array( '$near' => array($lat,$lng) ),
//                                           'fecha-caducidad-mongo'=> array('$gte' => $hoy )
//                                           )
                       );

       $this->db->command($command);
       
       $re = $this->db->SelectCollection('anuncios_ordenados5')->find();
       
       return $re;

    }

}



?>

