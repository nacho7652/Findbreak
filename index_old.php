<?php 
    require_once 'function/place.php';
    require_once 'DAL/connect.php';
    require_once 'DAL/insert.php';
    $insert = new insert();
   // $escrito = "ads rock";
       // $words = explode(" ", $escrito);
        
       // $result = array();
       // $result =  array("tags" => new MongoRegex("/hard/"), "tags2" => new MongoRegex("/hard/") ); // no funciona
      // $result = array(array("tags" => new MongoRegex("/hard/")),array("tags" => new MongoRegex("/toca/")));
       
        //$result+=  array("tags" => new MongoRegex("/".$words[1]."/"));
//        for($i=0 ; $i < count($words); $i++){
//           $tags =  array("tags" => new MongoRegex("/".$words[$i]."/"));
//           $result[]= $tags;
//        }
//       echo count($result);
//        print_r($result[1]);
//     $insert = new insert();
    // echo $insert->borrar("evento");
//
//    $db = $insert->getDb();
//    $db->evento->ensureIndex(array('loc' => '2d'));
    
//    $evento = array(
//            "nombre" => "SESATION",
//            "direccion" => "RIESCO",
//            "foto" => "foto.jpg",
//            "fecha_realizacion" => new MongoDate(strtotime("20-09-2012")),
//            "estado"=> "pendiente",
//            "tags" => array("blnco", "musical" ,"electronica"),
//            "loc"=> array(-5.96605, -3.6845454)
//        );
////   
//   $re = $insert->save($evento, "evento");//documento, collection
//   echo $re;
   $buscador = "rock";
    $eventos = $insert->findnear();
    if(count($eventos) > 0){
        foreach ($eventos as $dcto){
            echo "</br></br></br>".$dcto["loc"][0]."".$dcto["nombre"].",  ".$dcto["loc"][1]."</br></br></br>------------------------";
        }
    }else{
        echo "</br></br>no hay";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--        <link rel="shortcut icon" href="images/favicon.png">
        <link rel="apple-touch-icon" href="images/favicon.png">-->
        <title><?= $page_title ?></title>
        <meta name="description" content="<?= $page_description ?>">
        <link rel="stylesheet" href="css/stylebase.css">
        <link rel="stylesheet" href="css/style.css">
        <meta charset="utf-8">
       
    </head>
    <body>
        <div id="coverall">
            <div class="innercal">
                <div class="cerrar"></div>
                <div id="caloader">
                </div>
            </div>
        </div>
        <div id="top">
            <div class="explicacion">
                <h3 class="tituloexplicacion">FINDBREAK | <span>Sondeo Productoras</span></h3>
                <p>Por favor, dedique [2] minutos a completar este pequeño sondeo, la información que nos proporcione nos será muy útil para conocer mejor a nuestros visitantes.
                    Sus respuestas serán tratadas de forma confidencial y no serán utilizadas para ningún propósito distinto a la investigación llevada a cabo por <b>FINDBREAK</b>.
                </p>
            </div>
            <div class="linea"></div>
        </div>
        <div id="body" <?= $page_class ?>>
            <div class="inner">
                 <?php include_once('sites/'.$page_site.'.php'); ?>
            </div>
            
        </div>
        
        <footer id="bottom">
            <p class="textbottom">
                Estudiantes de Inacap Desarrolladores del proyecto Findbreak - Fonos: 652 213 55 / 541 67 51 / 546 28 51 -
                <span class="emailbottom">info@findbreak.com</span>
            </p>
        </footer>
         <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
         <script type="text/javascript" src="js/script.js"></script>
         <script type="text/javascript" src="js/jquery.cycle.all.latest.js"></script>
          <script type="text/javascript">
            $(document).ready(function() {
                $('.slideshow').cycle({
                            fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
                    });
            });
        </script>
        <script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
        <script type="text/javascript" src="highslide/highslide.config.js" charset="utf-8"></script>
        <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
        <!--[if lt IE 7]>
        <link rel="stylesheet" type="text/css" href="highslide/highslide-ie6.css" />
        <![endif]-->

        
    </body>
</html>
