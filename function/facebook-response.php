<?php
require 'facebook.php';
include_once '../DAL/connect.php';
include_once '../DAL/usuario.php';

    // Create our Application instance (replace this with your appId and secret).
//    $facebook = new Facebook(array(
//      'appId'  => '127844714081862',
//      'secret' => '31e9ae856c9c4ca6435db7a6ffcaaa2',
//    ));
//    // Get User ID
//    $user = $facebook->getUser();
    //var_dump($user);
//    if ($user) {
//      try {
//        // Proceed knowing you have a logged in user who's authenticated.
//        $_SESSION['userprofile'] = $facebook->api('/me'); 
//      } catch (FacebookApiException $e) {
//        error_log($e);
//        print_r($e->getMessage());
//        $user = null;
//      }
//    }
    // Login or logout url will be needed depending on current user state.
//    $params = array(
//            'scope' => 'email,user_birthday,user_location,publish_stream,offline_access',
//            'redirect_uri' => 'http://localhost/findbreak/cerca'
//    );
//    $loginUrl = $facebook->getLoginUrl($params);
    //header("location:/mooff/home");
if(isset($_GET['login']))
{
        session_start();
        $name=strtolower($_GET['name']);
        $first_name=strtolower($_GET['first_name']);
        $last_name=strtolower($_GET['last_name']);
        $username=strtolower($_GET['username']);
        $email=$_GET['email'];
        $picture=$_GET['picture'];
        $_SESSION['userprofile'] = array(
            "name"=>$name,
            "first_name"=>$first_name,
            "last_name"=>$last_name,
            "username"=>$username,
            "email"=>$email,
            "picture"=>$picture
        );
        $us = new usuario();
        $user_profile = $_SESSION['userprofile'];
        $comp = $us->loginFace($user_profile['email']);
        $nuevo = 1;
        if($comp!=null)
        {
           $nuevo = 0;
           $_SESSION['userid'] = $comp['_id'];
           $_SESSION['username'] = $comp['username'];
           $_SESSION['nombre'] = $comp['nombre'];
           if($comp['foto'] == PATH.'images/user-default.png')
           {
              $us->updatePhoto($comp['_id'], $user_profile['picture']);
              $_SESSION['foto']=$user_profile['picture'];

           }
           else
           {
               $_SESSION['foto'] = $comp['foto'];
           }
           $_SESSION['usertype'] = 1;
        }else{

           $hola = $us->insertarFB($user_profile['name'], $user_profile['email'], '',$user_profile['picture'],$user_profile['username']);
           $_SESSION['userid'] = $hola['_id'];
           $_SESSION['username'] = $hola['username'];
           $_SESSION['nombre'] = $hola['nombre'];
           $_SESSION['foto'] = $hola['foto'];
           $_SESSION['usertype'] = 1;

        }
         echo $nuevo; 
}
    
if(isset($_GET['logout'])){
        session_start();
        session_destroy();
//        $user = null;
    }

?>