<?php
function escalar($ruta1,$ruta2,$ancho,$alto, $cuadrar = false) //ruta1 = FOTO ORIGINAL
    { 

        # se obtene la dimension y tipo de imagen 
        $datos=getimagesize ($ruta1); 

        $ancho_orig = $datos[0]; # Anchura de la imagen original 
        $alto_orig = $datos[1];    # Altura de la imagen original 
        $tipo = $datos[2]; 


        if ($tipo==1){ # GIF 
            if (function_exists("imagecreatefromgif")) 
                $img = imagecreatefromgif($ruta1); 
            else 
                return false; 
        } 
        else if ($tipo==2){ # JPG 
            if (function_exists("imagecreatefromjpeg")) 
                $img = imagecreatefromjpeg($ruta1); 
            else 
                return false; 
        } 
        else if ($tipo==3){ # PNG 
            if (function_exists("imagecreatefrompng")) 
                $img = imagecreatefrompng($ruta1); 
            else 
                return false; 
        } 
        if($tipo != 1 && $tipo != 2 && $tipo != 3){
            return false;
        }
//        if($alto_orig < $alto && $ancho_orig < $ancho){
//            return false;
//        }
        
                    

        # Se calculan las nuevas dimensiones de la imagen 
        if ($ancho_orig < $alto_orig) //vertical
            { 
//                si el ALTO original es mas pequeño significa que la imagen no necesita redimensionamiento
                if($alto_orig <= $alto){
//                    $ruta = explode("/", $ruta1);
//                    $foto = $ruta[count($ruta)-1];//saco el nombre de la foto
//                    $carpeta = "images/news/";
                    $copy =  copy($ruta1, $ruta2);
                    return $copy;
                }
                $alto_dest =$alto; 
                $ancho_dest=($alto_dest/$alto_orig)*$ancho_orig; 
            } 
        else //apaisada
            { 
                 //si el ANCHO original es mas pequeño o igual significa que la imagen no necesita redimensionamiento
                if($ancho_orig <= $ancho){
//                    $ruta = explode("/", $ruta1);
//                    $foto = $ruta[count($ruta)-1];//saco el nombre de la foto
//                    $carpeta = $ruta[0]."/".$ruta[1]."/";
                    $copy =  copy($ruta1, $ruta2);
                    return $copy; 
                }

                 $ancho_dest=$ancho; 
                 $alto_dest=($ancho_dest/$ancho_orig)*$alto_orig; 
            } 



             //redimensionar
                $img_redimensionada=@imagecreatetruecolor($ancho_dest, $alto_dest) ;
                $blanco = imagecolorallocate($img_redimensionada, 255, 255, 255);
                imagefill($img_redimensionada, 0, 0, $blanco);//img = fuente
                @imagecopyresampled($img_redimensionada, $img ,0,0,0,0,$ancho_dest, $alto_dest, $ancho_orig, $alto_orig);
                 // Crear fichero nuevo, según extensión. 
            if ($tipo==1) // GIF 
                if (function_exists("imagegif")) 
                    imagegif($img_redimensionada, $ruta2,0); //cero mayor resolucion
                else 
                    return false; 

            if ($tipo==2) // JPG 
                if (function_exists("imagejpeg")) 
                    imagejpeg($img_redimensionada, $ruta2,100);//100 mayor resolucion
                else 
                    return false; 

            if ($tipo==3)  // PNG 
                if (function_exists("imagepng")) 
                    imagepng($img_redimensionada, $ruta2,0); //0 mayor resolucion
                else 
                    return false; 


        return true; 
    } 
    
    function cuadrar($ruta1,$ruta2,$ancho,$alto) 
    { 
    
    # se obtene la dimension y tipo de imagen 
    $datos=getimagesize ($ruta1); 
     
    $ancho_orig = $datos[0]; # Anchura de la imagen original 
    $alto_orig = $datos[1];    # Altura de la imagen original 
    $tipo = $datos[2]; 
    
    
    if ($tipo==1){ # GIF 
        if (function_exists("imagecreatefromgif")) 
            $img = imagecreatefromgif($ruta1); 
        else 
            return false; 
    } 
    else if ($tipo==2){ # JPG 
        if (function_exists("imagecreatefromjpeg")) 
            $img = imagecreatefromjpeg($ruta1); 
        else 
            return false; 
    } 
    else if ($tipo==3){ # PNG 
        if (function_exists("imagecreatefrompng")) 
            $img = imagecreatefrompng($ruta1); 
        else 
            return false; 
    } 
    if($tipo != 1 && $tipo != 2 && $tipo != 3){
        return false;
    }
    if($alto_orig < $alto && $ancho_orig < $ancho){
        return false;
    }
    
    # Se calculan las nuevas dimensiones de la imagen 
    if ($ancho_orig < $alto_orig) //vertical
        { 
        //si en ancho original es mas pequeño significa que la imagen no necesita redimensionamiento
        if($ancho_orig <= $ancho){
            $copy =  copy($ruta1, $ruta2);
            return $copy;  
        }
        $ancho_dest=$ancho; 
        $alto_dest=($ancho_dest/$ancho_orig)*$alto_orig; 
        } 
    else 
        {
        //si en ancho original es mas pequeño significa que la imagen no necesita redimensionamiento
        if($alto_orig <= $alto){
            $copy =  copy($ruta1, $ruta2);
            return $copy;
        }
            $alto_dest=$alto; 
            $ancho_dest=($alto_dest/$alto_orig)*$ancho_orig; 
        } 

        
        
         //redimensionar
            $img_redimensionada=@imagecreatetruecolor($ancho_dest,$alto_dest) ;
            $blanco = imagecolorallocate($img_redimensionada, 255, 255, 255);
            imagefill($img_redimensionada, 0, 0, $blanco);//img = fuente
            @imagecopyresampled($img_redimensionada,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig);
             // Crear fichero nuevo, según extensión. 
        if ($tipo==1) // GIF 
            if (function_exists("imagegif")) 
                imagegif($img_redimensionada, $ruta2,0); //cero mayor resolucion
            else 
                return false; 

        if ($tipo==2) // JPG 
            if (function_exists("imagejpeg")) 
                imagejpeg($img_redimensionada, $ruta2,100);//100 mayor resolucion
            else 
                return false; 

        if ($tipo==3)  // PNG 
            if (function_exists("imagepng")) 
                imagepng($img_redimensionada, $ruta2,0); //0 mayor resolucion
            else 
                return false; 
            
            //cuadrar
            $cuad = $ancho;
            $img_cuadrada=@imagecreatetruecolor($cuad,$cuad);
            $blanco2 = imagecolorallocate($img_cuadrada, 255, 255, 255);
            imagefill($img_cuadrada, 0, 0, $blanco2);//img = fuente
            if($ancho_orig < $alto_orig){//vertical
                $mitad = round(($alto_dest / 2) - ($alto / 2 ));
                @imagecopyresampled($img_cuadrada,$img_redimensionada,0,0,0,$mitad,$cuad,$alto_dest,$ancho_dest,$alto_dest);
              }elseif($ancho_orig > $alto_orig){//apaisada
                $mitad = round(($ancho_dest / 2) - ($ancho / 2));
                @imagecopyresampled($img_cuadrada,$img_redimensionada,0,0,$mitad,0,$ancho_dest,$cuad,$ancho_dest,$alto_dest);
              }else{
                 @imagecopyresampled($img_cuadrada,$img_redimensionada,0,0,0,0,$ancho_dest,$cuad,$ancho_dest,$alto_dest);
            }
            
        // Crear fichero nuevo, según extensión. 
        if ($tipo==1) // GIF 
            if (function_exists("imagegif")) 
                imagegif($img_cuadrada, $ruta2,0); //cero mayor resolucion
            else 
                return false; 

        if ($tipo==2) // JPG 
            if (function_exists("imagejpeg")) 
                imagejpeg($img_cuadrada, $ruta2,100);//100 mayor resolucion
            else 
                return false; 

        if ($tipo==3)  // PNG 
            if (function_exists("imagepng")) 
                imagepng($img_cuadrada, $ruta2,0); //0 mayor resolucion
            else 
                return false; 
//            
//            
          
            
            
          //fin cuadrar  
     
          return true;
    } 
  

?>
