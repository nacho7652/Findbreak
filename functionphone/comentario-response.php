<?php
    require_once '../DAL/connect.php';
    require_once '../DAL/evento.php';
    require_once '../DAL/comentario.php';
    date_default_timezone_set("Chile/Continental");
    
    if(isset($_REQUEST['vercomentario'])){
		$comentario = new comentario();
		$resp = array();
		$id = $_REQUEST['id'];
		$cont = 0;
		$com = $comentario->verMisComentarios($id,10);
//		$cont = count($com);
//                $a = '';
//                foreach($com as $dcto){
//                    $a.='comentario: '.$dcto['comentario'];
//                }
//		$resp = array("cont"=>$cont,
//					  "comentarios"=>$a);
                foreach($com as $dcto)//TABULA PO BIGOTE ¬¬
		   {
		         $cont++;
		         $resp[] = array(
                                        "username"=>$dcto['userName'],
                                        "com"=>$dcto['comentario'],
										"fecha"=>$dcto['fechaMuestra']
                                        );
	           }
                    $respuesta = array("contador"=>$cont,
                                       "eventos"=>$resp
                                       );
            echo json_encode($respuesta);
//        echo json_encode($resp);
    }  
?>                    