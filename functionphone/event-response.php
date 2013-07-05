<?php
       session_start();
       require_once '../DAL/connect.php';
       require_once '../DAL/evento.php';
       if(isset($_REQUEST['findnear2'])){
            $lat = $_REQUEST['lat'];
            $long = $_REQUEST['lng'];
            $event = new evento();
            
            $eventsNears = $event->findnear((float)$lat, (float)$long);
			$resp = array();
			$cont = 0;
            foreach($eventsNears as $dcto)
			{
				$cont++;
				$resp[] = array("lat"=>$dcto['loc'][0],
                          "lon"=>$dcto['loc'][1],
                          "nombre"=>$dcto['nombre'],
						  "id"=>$dcto['_id']
                         );
			}
			$respuesta = array("cont"=>$cont,
							   "event"=>$resp
							   );
            echo json_encode($respuesta);
       }
	   
	   if(isset($_GET['profie']))
	   {
			$id = $_REQUEST['id'];
			$respuesta = array("id"=>$id);
			echo json_encode($respuesta);
			//$event = new evento();
			//$eventprofile = $event->findforid($id);
			//$resp = json_encode($eventprofile);
			//echo $resp;
	   }
       
?>
