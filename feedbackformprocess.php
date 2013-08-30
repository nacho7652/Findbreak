<?php
/**
 * 
 * URL: www.freecontactform.com
 * 
 * Version: Feedback Form Free V1
 * 
 * Copyright (c) 2013 Stuart Cochrane
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 * Note: This is NOT the same code as the PRO version
 * 
 */


/*
required.add('Name','NOT_EMPTY','Name');
required.add('Email','EMAIL','Email');
required.add('Subject','NOT_EMPTY','Subject');
required.add('Message','NOT_EMPTY','Message');
required.add('AntiSpam','NOT_EMPTY','Anti-Spam Question');
*/

if(isset($_POST['Email'])) {
	
	include 'feedbackformsettings.php';
	
	function died($error) {
		echo "Sorry, but there were error(s) found with the form you submitted. ";
		echo "These errors appear below.<br /><br />";
		echo $error."<br /><br />";
		echo "Please go back and fix these errors.<br /><br />";
		die();
	}
	
	if(!isset($_POST['Email']) ||
		!isset($_POST['Subject']) ||
		!isset($_POST['Message'])		
		) {
		died('Sorry, there appears to be a problem with your form submission.');		
	}
	
	$email_from = $_POST['Email']; // required
	$subject = $_POST['Subject']; // required
	$comments = $_POST['Message']; // required
	
	$error_message = "";
	
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(preg_match($email_exp,$email_from)==0) {
  	$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
  if(strlen($comments) < 2) {
  	$error_message .= 'The Message you entered do not appear to be valid.<br />';
  }
  
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
	$email_message = "Form details below.\r\n";
	
	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:");
	  return str_replace($bad,"",$string);
	}
	
	$email_message .= "Subject: ".clean_string($subject)."\r\n";
	$email_message .= "Email: ".clean_string($email_from)."\r\n";
	$email_message .= "Message: ".clean_string($comments)."\r\n";
	
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($email_to, $email_subject." - $subject", $email_message, $headers);
header("Location:http://www.nowsup.com");
?>
<script>location.replace('<?php echo $thankyou;?>')</script>
<?php
}
die();
?>