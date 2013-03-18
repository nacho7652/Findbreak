<?php
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
            $re = array("eventospop"=>$data
                        );
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
            echo $_REQUEST['jsoncallback'] . '(' . json_encode($re) . ');';
       }
       
?>
