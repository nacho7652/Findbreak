<?php  

require_once('recaptchalib.php');

    if(isset($_REQUEST['vercaptcha'])){
        $privatekey = "6LdvkeYSAAAAAJCoqn0YR2WqMVR-SPLVfykJm8AO";
        $ans = 0;
        $resp = recaptcha_check_answer ($privatekey,
                                    $_SERVER["REMOTE_ADDR"],
                                    $_POST["recaptcha_challenge_field"],
                                    $_POST["recaptcha_response_field"]);
         if (!$resp->is_valid) {
             $ans = 0;
          } 
          else {
              $ans = 1;
          }
          echo $ans;
     }
?>
