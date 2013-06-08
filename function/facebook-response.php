<?php
require 'facebook.php';


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
      echo "ok"; 
    }
    
if(isset($_GET['logout'])){
        session_destroy();
//        $user = null;
    }

?>