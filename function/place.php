<?php
  $place = empty($_GET['place']) ? 'mapa' : $_GET['place'];
  $page_class_near = 'class="inner"';
  switch ($place){
      case 'inicio': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'inicio';
                   $page_class = 'inicio';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
      //editar-usuario
      case 'editar-usuario': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'editarusuario';
                   $page_class = 'publicar';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
      case 'editar-evento': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'editarevento';
                   $page_class = 'publicar';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
     case 'publicar': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'publicar';
                   $page_class = 'publicar';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
     case 'publicaciones': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'publicaciones';
                   $page_class = 'publicaciones';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
     case 'login': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'login';
                   $page_class = 'login';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
      case 'mapa': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'cerca';
                   $page_class = 'cerca';
                   $page_class_near = 'class="inner inner-near"';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
      case 'perfilest': 
                   $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'perfilest';
                   $page_class = 'perfilest';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
      case 'home': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'home';
                   $page_class = 'home';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
    case 'userprofile': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'userprofile';
                   $page_class = 'perfiluser';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
    case 'eventprofile': $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'eventprofile';
                   $page_class = 'eventprofile';
                   $page_description = "Entérate de lo que sucede a tu alrededor";
                   break;
    case 'productora':
                   $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'productoraprofile';
                   $page_class = 'productora';
                   $page_description = "";
                   break;//productoraprofile
     case 'encuesta':
                   $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'encuesta';
                   $page_class = 'encuesta';
                   $page_description = "";
                   break;
     case 'landing':
                   $page_title = 'Nowsup - Entérate de lo que sucede a tu alrededor';
                   $page_site = 'landing';
                   $page_class = 'landing';
                   $page_description = "";
                   break;
      case 'uploadevento':
                   $page_title = 'Subiendo evento';
                   $page_site = 'uploadevento';
                   $page_class = 'uploadevento';
                   $page_description = "";
                   break;
      case 'search': if( isset($_POST['direccion']) != '' && isset($_POST['evento'] ) != '' ){
                    $page_title = 'Search';
                    $page_site = 'search';
                    $page_class= 'search';
                    $page_description = "";
                    }else{
                        header('location: /test/');
                    }
                    break;

      default : $page_title = '404';
                $page_site = '404';
                
  }
  
  $description = empty($_GET['description']) ? 'Nowsup - Entérate de lo que sucede a tu alrededor' : $_GET['description'];
  $page_class = empty($page_class) ? '' : 'class="'.$page_class.'"';
  
