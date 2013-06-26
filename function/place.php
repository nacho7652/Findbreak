<?php
  $place = empty($_GET['place']) ? 'inicio' : $_GET['place'];
  $page_class_near = 'class="inner"';
  switch ($place){
      case 'inicio': $page_title = 'Findbreak';
                   $page_site = 'inicio';
                   $page_class = 'inicio';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
      case 'editar-evento': $page_title = 'Findbreak';
                   $page_site = 'editarevento';
                   $page_class = 'publicar';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
     case 'publicar': $page_title = 'Findbreak';
                   $page_site = 'publicar';
                   $page_class = 'publicar';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
     case 'publicaciones': $page_title = 'Findbreak';
                   $page_site = 'publicaciones';
                   $page_class = 'publicaciones';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
     case 'login': $page_title = 'Findbreak';
                   $page_site = 'login';
                   $page_class = 'login';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
      case 'cerca': $page_title = 'Findbreak';
                   $page_site = 'cerca';
                   $page_class = 'cerca';
                   $page_class_near = 'class="inner inner-near"';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
      case 'perfilest': 
                   $page_title = 'Findbreak';
                   $page_site = 'perfilest';
                   $page_class = 'perfilest';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
      case 'home': $page_title = 'Findbreak';
                   $page_site = 'home';
                   $page_class = 'home';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
    case 'userprofile': $page_title = 'Findbreak';
                   $page_site = 'userprofile';
                   $page_class = 'perfiluser';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
    case 'eventprofile': $page_title = 'Findbreak';
                   $page_site = 'eventprofile';
                   $page_class = 'eventprofile';
                   $page_description = "Encuentra un quiebre a tu rutina";
                   break;
    case 'productora':
                   $page_title = 'Productora';
                   $page_site = 'productoraprofile';
                   $page_class = 'productora';
                   $page_description = "";
                   break;//productoraprofile
     case 'encuesta':
                   $page_title = 'Productora';
                   $page_site = 'encuesta';
                   $page_class = 'encuesta';
                   $page_description = "";
                   break;
     case 'landing':
                   $page_title = 'Landing';
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
  
  $description = empty($_GET['description']) ? 'Encuentra un quiebre a tu rutina' : $_GET['description'];
  $page_class = empty($page_class) ? '' : 'class="'.$page_class.'"';
  
