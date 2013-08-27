<?php
if(isset($_REQUEST['mailBienvenida'])){
    $nombre = $_REQUEST['nombre'];
    $para = $_REQUEST['para'];
    $cuerpo = mailBienvenida($nombre);
    $re = email($para,  'Bienvenido a Nowsup',$cuerpo);
    if($re)
        echo "si";
     else
       echo "no";
}
if(isset($_REQUEST['email'])){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $fono = $_POST['asunto'];
    $msj = $_POST['msj'];
    $re = email($nombre, $email,$fono,$msj);
    if($re)
        echo "si";
        else
         echo "no";
}
function email($para, $asunto, $cuerpo){
	 $headers = "MIME-Version: 1.0\r\n"; 
	 $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        // $para = "sebastian.lagos@gmail.com";
	 $re =  mail($para,$asunto,$cuerpo,$headers);
         return $re;
}

//Mail de bienvenida
function mailBienvenida($nombre){
     $hora = getdate(time());
     if($hora["minutes"] < 10 && $hora["minutes"] != 0)
       $hora["minutes"] = "0".$hora["minutes"];

     $horaReal = $hora["hours"]. ":" . $hora["minutes"];
             
    $html = '<html><head></head><body><table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="ecxbodyTable" style="border-collapse:collapse;padding:0;background-color:#F2F2F2;height:100% !important;width:100% !important;">
                <tbody><tr>
                    <td align="center" valign="top" id="ecxbodyCell" style="border-collapse:collapse;padding:0;border-top:0;height:100% !important;width:100% !important;">
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
                            <tbody>
                            <tr>
                                <td align="center" valign="top" style="border-collapse:collapse;">
                                    
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ecxtemplateHeader" style="border-collapse:collapse;background-color:#FFFFFF;border-top:0;border-bottom:0;">
                                        <tbody><tr>
                                            <td align="center" valign="top" style="border-collapse:collapse;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="600" class="ecxtemplateContainer" style="border-collapse:collapse;">
                                                    <tbody><tr>
                                                        <td valign="top" class="ecxheaderContainer" style="padding-top:10px;padding-right:18px;padding-bottom:10px;padding-left:18px;border-collapse:collapse;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnImageBlock" style="border-collapse:collapse;">
    <tbody class="ecxmcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px;border-collapse:collapse;" class="ecxmcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="ecxmcnImageContentContainer" style="border-collapse:collapse;">
                        <tbody><tr>
                            <td class="ecxmcnImageContent" valign="top" style="padding-right:9px;padding-left:9px;padding-top: 0px;padding-bottom:0;border-collapse:collapse;">
                                
<a href="http://www.nowsup.com" title="" class="" style="word-wrap:break-word !important;" target="_blank">
                                                                       <img align="left" alt="" src="http://www.nowsup.com/images/top-mail.png" width="564" style="max-width:817px;padding-bottom:0;display:inline !important;vertical-align:bottom;border:0;line-height:100%;text-decoration:none;height:auto !important;" class="ecxmcnImage">     
                                    </a>

                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="border-collapse:collapse;">
                                    
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ecxtemplateBody" style="border-collapse:collapse;background-color:#FFFFFF;border-top:0;border-bottom:0;">
                                        <tbody><tr>
                                            <td align="center" valign="top" style="border-collapse:collapse;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="600" class="ecxtemplateContainer" style="border-collapse:collapse;">
                                                    <tbody><tr>
                                                        <td valign="top" class="ecxbodyContainer" style="padding-top:10px;padding-right:18px;padding-bottom:10px;padding-left:18px;border-collapse:collapse;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnTextBlock" style="border-collapse:collapse;">
    <tbody class="ecxmcnTextBlockOuter">
        <tr>
            <td valign="top" class="ecxmcnTextBlockInner" style="border-collapse:collapse;">

                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="ecxmcnTextContentContainer" style="border-collapse:collapse;">
                    <tbody><tr>

                        <td valign="top" class="ecxmcnTextContent" style="padding-top:9px;padding-right:18px;padding-bottom:9px;padding-left:18px;border-collapse:collapse;color:#606060;font-family:Helvetica;font-size:15px;line-height:150%;text-align:left;">

 
                            <h1 style="display:block;font-family: Helvetica;font-size: 24px;font-style:normal;font-weight:bold;line-height:125%;letter-spacing: -1px;text-align:left;color: #3165BD;">!Bienvenido a Nowsup! Entérate de lo que sucede a tu alrededor</h1>
<br><b>'.$nombre.':</b><br>
<br>Te damos la Bienvenida a Nowsup, la nueva red social que te mostrará todo lo que está ocurriendo a tu alrededor.<br>
<br>Ingresa al sitio web para enterarte de todo lo que está ocurriendo en tu ciudad, los eventos deportivos, fiestas, ventas de celulares, cosas perdidas y mucho más.<br>
<br>
¿Quieres publicar algo?<br>
Visita <a href="http://www.nowsup.com" style="color: #3A55AC;font-weight:normal;text-decoration:underline;word-wrap:break-word !important;" target="_blank">Nowsup.com</a> y publica gratis el anuncio que tú quieras ! y compártelo con tus amigos. <br>
<br>
<a style="text-decoration: none;
margin: 12px 1px 0px 193px;
font-size: 15px;
display: block;
width: 143px;
border-radius: 2px;
text-align: center;
float: left;
padding: 8px 14px;
text-shadow: 0 1px 2px rgba(0,0,0,0.25);
background-repeat: repeat-x;
border: 1px solid rgba(65, 115, 169, 0.34);
border: 1px solid rgba(65, 169, 94, 0);
background: rgba(48, 160, 38, 1);
background: -webkit-linear-gradient(top,rgba(118, 194, 47, 1), rgba(48, 160, 38, 1));
color: #FFF;
border: 1px solid rgba(48, 156, 39, 1);
border-top-color: rgba(77, 184, 67, 1);
border-bottom-color: rgba(41, 134, 33, 1);"
href="http://www.nowsup.com/publicar">PUBLICAR GRATIS</a>
<br>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnDividerBlock" style="border-collapse:collapse;">
    <tbody class="ecxmcnDividerBlockOuter">
        <tr>
            <td class="ecxmcnDividerBlockInner" style="padding:18px;border-collapse:collapse;">
                <table class="ecxmcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top-width:1px;border-top-style:solid;border-top-color: rgba(21, 58, 138, 0.36);border-collapse:collapse;">
                    <tbody><tr>
                        
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table>
<a href="http://www.nowsup.com" title="" class="" style="word-wrap:break-word !important;" target="_blank">                                                            
<img align="left" alt="" src="http://www.nowsup.com/images/body-mail.PNG" width="564" style="max-width:1271px;padding-bottom:0;display:inline !important;vertical-align:bottom;border:0;line-height:100%;text-decoration:none;height:auto !important;margin-left: 19px;" class="ecxmcnImage" http:="" www.nowsup.com="" images=""><table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnButtonBlock" style="border-collapse:collapse;">
</a>  
    <tbody class="ecxmcnButtonBlockOuter">
        <tr>
            <td style="padding-top:0;padding-right:18px;padding-bottom:18px;padding-left:18px;border-collapse:collapse;" valign="top" align="center" class="ecxmcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="ecxmcnButtonContentContainer" style="border-top-left-radius:5px;border-top-right-radius:5px;border-bottom-right-radius:5px;border-bottom-left-radius:5px;background-color:#1B8B5B;border-collapse:collapse;">
                    <tbody>
                        <tr>
                            
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnDividerBlock" style="border-collapse:collapse;">
    <tbody class="ecxmcnDividerBlockOuter">
        <tr>
            <td class="ecxmcnDividerBlockInner" style="padding:18px;border-collapse:collapse;">
                <table class="ecxmcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top-width:1px;border-top-style:solid;border-top-color: rgba(34, 87, 155, 0.4);border-collapse:collapse;">
                    <tbody><tr>
                        <td style="border-collapse:collapse;">
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnFollowBlock" style="border-collapse:collapse;">
    <tbody class="ecxmcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px;border-collapse:collapse;" class="ecxmcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnFollowContentContainer" style="border-collapse:collapse;">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;border-collapse:collapse;">
            <table border="0" cellpadding="0" cellspacing="0" class="ecxmcnFollowContent" style="border-collapse:collapse;">
                <tbody><tr>
                    <td valign="top" style="padding-top:9px;padding-right:9px;padding-left:9px;border-collapse:collapse;display: none;">



                                <table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                    <tbody><tr>
                                        <td valign="top" style="padding-right:10px;padding-bottom:9px;border-collapse:collapse;" class="ecxmcnFollowContentItemContainer">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnFollowContentItem" style="border-collapse:collapse;">
                                                <tbody><tr>
                                                    <td align="left" valign="middle" style="padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:9px;border-collapse:collapse;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse:collapse;">
                                                            <tbody><tr>

                                                                    <td align="center" valign="middle" width="18" class="ecxmcnFollowIconContent" style="border-collapse:collapse;">
                                                                    </td>


                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>




                                <table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                    <tbody><tr>
                                        <td valign="top" style="padding-right:10px;padding-bottom:9px;border-collapse:collapse;" class="ecxmcnFollowContentItemContainer">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnFollowContentItem" style="border-collapse:collapse;">
                                                <tbody><tr>
                                                    <td align="left" valign="middle" style="padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:9px;border-collapse:collapse;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse:collapse;">
                                                            <tbody><tr>

                                                                    <td align="center" valign="middle" width="18" class="ecxmcnFollowIconContent" style="border-collapse:collapse;">
                                                                    </td>


                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>




                                <table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                    <tbody><tr>
                                        <td valign="top" style="padding-right:0;padding-bottom:9px;border-collapse:collapse;" class="ecxmcnFollowContentItemContainer">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnFollowContentItem" style="border-collapse:collapse;">
                                                <tbody><tr>
                                                    <td align="left" valign="middle" style="padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:9px;border-collapse:collapse;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse:collapse;">
                                                            <tbody><tr>

                                                                    <td align="center" valign="middle" width="18" class="ecxmcnFollowIconContent" style="border-collapse:collapse;">
                                                                    </td>


                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>


                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="border-collapse:collapse;">
                                    
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ecxtemplateFooter" style="border-collapse:collapse;background-color: #124191;border-top:0;border-bottom:0;">
                                        <tbody><tr>
                                            <td align="center" valign="top" style="border-collapse:collapse;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="600" class="ecxtemplateContainer" style="border-collapse:collapse;">
                                                    <tbody><tr>
                                                        <td valign="top" class="ecxfooterContainer" style="padding-top:10px;padding-right:18px;padding-bottom:10px;padding-left:18px;border-collapse:collapse;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="ecxmcnTextBlock" style="border-collapse:collapse;">
    <tbody class="ecxmcnTextBlockOuter">
        <tr>
            <td valign="top" class="ecxmcnTextBlockInner" style="border-collapse:collapse;">

                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="ecxmcnTextContentContainer" style="border-collapse:collapse;">
                    <tbody><tr>

                        <td valign="top" class="ecxmcnTextContent" style="padding-top:9px;padding-right:18px;padding-bottom:9px;padding-left:18px;border-collapse:collapse;color: #fff;font-family:Helvetica;font-size:11px;line-height:125%;text-align:left;">

                            <em>Copyright © 2013 Nowsup.com, All rights reserved.</em><br>
                            <em>Enviado a las '.$horaReal.' hrs.</em>
<br>
<br>
<br>
&nbsp;&nbsp;&nbsp; &nbsp;<br>
<br>
<br>

                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                        </tbody></table>
                        
                    </td>
                </tr>
            </tbody></table></body></html>';
    return utf8_decode($html);
}
?>
