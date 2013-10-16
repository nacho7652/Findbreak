<?php
       header('Content-type: application/json');
       session_start();
       require_once '../DAL/connect.php';
       require_once '../DAL/evento.php';
       if(isset($_REQUEST['findeventspop'])){
            $event = new evento();
            $eventpopular = $event->findpopular();
            $data = '';
            foreach ($eventpopular as $dcto){
                $data.= "nombre : ".$dcto['nombre']."<br>";
                $data.= "dirección : ".$dcto['direccion']."<br>";
                $data.= "visitas : ".$dcto['visitas']."<br><br><br>";
            }
            $re = array("eventospop"=>$data);
            echo $_REQUEST['jsoncallback'] . '(' . json_encode($re) . ');';
       }
       
       if(isset($_REQUEST['findeventsprox'])){
            $event = new evento();
            $eventprox = $event->eventosPorRealizar(1);
            $data2 = '';
            foreach ($eventprox as $dcto){
                $data2.= "nombre : ".$dcto['nombre']."<br>";
                $data2.= "dirección : ".$dcto['direccion']."<br><br><br>";
            }
            
            $re = array(
                        "eventosprox"=>$data2
                        );
           // echo $_REQUEST['jsoncallback'] . '(' . json_encode($re) . ');';
            echo $data2;
       }
       //BOGOTES TITANIUM
       if(isset($_REQUEST['findnear2'])){
            $lat = $_REQUEST['lat'];
            $long = $_REQUEST['lng'];
            $event = new evento();
            
            $eventsNears = $event->findnear((float)$lat, (float)$long);
			$resp = array();
			$cont = 0;
            foreach($eventsNears as $dcto)//TABULA PO BIGOTE ¬¬
		   {
		         $cont++;
		         $resp[] = array(
                                        "lat"=>$dcto['loc'][0],
                                        "lon"=>$dcto['loc'][1],
                                        "nombre"=>$dcto['nombre'],
										"id"=>$dcto['_id'],
										"dir"=>$dcto['direccion'],
										"fecha"=>$dcto['fecha_muestra'],
                                        );
	           }
                    $respuesta = array("cont"=>$cont,
                                       "event"=>$resp
                                       );
            echo json_encode($respuesta);
       }
	   
	   if(isset($_GET['eventprofile']))
	   {
			$id = $_REQUEST['id'];
			//$respuesta = array("id"=>$id);
			//echo json_encode($respuesta);
			$event = new evento();
			$eventprofile = $event->findforid($id);
			$resp = json_encode($eventprofile);
			echo $resp;
	   }
       
?>
