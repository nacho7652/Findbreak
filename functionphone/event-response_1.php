<?php
       session_start();
       require_once '../DAL/connect.php';
       require_once '../DAL/evento.php';
            $event = new evento();
            $eventpopular = $event->findpopular();
            $data = '';
            foreach ($eventpopular as $dcto){
                $data.= "nombre : ".$dcto['nombre']."<br>";
                $data.= "dirección : ".$dcto['direccion']."<br>";
                $data.= "visitas : ".$dcto['visitas']."<br><br><br>";
            }
            echo $data;
?>
