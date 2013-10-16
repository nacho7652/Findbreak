<?php
        require_once '../DAL/connect.php';
        require_once '../DAL/mapreduce_class.php';
        $clasemapreduce = new mapreduce_class();
        $re = $clasemapreduce->findnear();
        echo 'Anuncios 2 separados por verificacion, hacer el campo "latLong: -33.434398349_-19.9313013" y 
              agruparlos por tal campo<br><br><br>';
         
        $arreglo;
        $re =iterator_to_array($re);
//        print_r($re);
        foreach ($re as $dcto){

            echo 'Ubicación: '.$dcto['_id'].'<br><br>';
            print_r($dcto);
//            echo $dcto['value']['nombre'].'<br>';
//            echo $dcto['value']['direccion'].'<br>';
//            echo $dcto['value']['loc'][0].'<br>';
//            echo $dcto['value']['loc'][1].'<br>';
//            echo $dcto['value']['fecha-caducidad'].'<br>';
//            
//            
//            $documentos = explode(';', $dcto['value']);
//            foreach ($documentos as $anuncio){
//                echo 'id: '.$anuncio.'<br>--------<br>';
//                $arreglo[]= explode('+', $anuncio);
////                echo 'direccion: '.$anuncio[0].'<br>';
////                echo '<br>-----------</br>';
//            }
            
//            foreach ($dcto['value'] as $valores){
//                echo 'nombres: '.$valores.'<br>';
//
//            }
             echo '<br>-------------------------------------</br>';
        }
//        foreach ($arreglo as $dcto){
////            $arreglo = array(
////                        '_id'=>$dcto['']
////            );
////            echo ':)<br>';
////            print_r($dcto);
//            echo 'id: '.$dcto[0].'<br><br>';
//            echo 'otro: '.$dcto[1].'<br><br>';
////            $documentos = explode(';', $dcto['value']);
////            foreach ($documentos as $anuncio){
////                echo 'id: '.$anuncio.'<br>';
////                $arreglo[]= explode('+', $anuncio);
//////                echo 'direccion: '.$anuncio[0].'<br>';
//////                echo '<br>-----------</br>';
////            }
//            
////            foreach ($dcto['value'] as $valores){
////                echo 'nombres: '.$valores.'<br>';
////
////            }
//             echo '<br>-------------------------------------</br>';
//        }
        
?>
