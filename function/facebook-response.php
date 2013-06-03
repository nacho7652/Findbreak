<?php
require 'facebook.php';


    // Create our Application instance (replace this with your appId and secret).
    $facebook = new Facebook(array(
      'appId'  => '127844714081862',
      'secret' => '31e9ae856c9c4ca6435db7a6ffcaaa27',
    ));

    // Get User ID
    $user = $facebook->getUser();

    if ($user) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $_SESSION['userprofile'] = $facebook->api('/me'); 
        //echo "<script type=\"text/javascript\">alert(".$user_profile.")</script>";
        //$_SESSION['user'] = null;
      } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
        //$user_profile = -1;
      }
    }
   
    // Login or logout url will be needed depending on current user state.
    $params = array(
            'scope' => 'email,user_birthday,user_location,publish_stream,offline_access',
            'redirect_uri' => 'http://localhost/findbreak/cerca'
    );
    $loginUrl = $facebook->getLoginUrl($params);
    //header("location:/mooff/home");
    
if(isset($_GET['logout'])){
        session_destroy();
        $user = null;
        header("location:/findbreak/cerca");
    }

?>
