<?php
if(isset($_POST['feedback'])){
    $mail = $_POST['mail'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];
    $para  = 'nacho1593@hotmail.com'.', '; // atención a la coma
    $para .= 'skumblue@live.cl'.', ';
    $para .= 'danitow@live.cl';
    $resp = 0;
    $headers = "From: Feedback <feedback@nowsup.com>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n";
    $body = "El mail ".$mail;
    $body .= "</br>tiene un(a) ".$asunto;
    $body .= "</br>su ".$asunto. " es : ";
    $body .= "</br>".$mensaje;
    if(mail($para, 'Feedback', $body, $headers))
    {
        $resp=1;
    }
    echo $resp;
}
?>
