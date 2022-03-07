<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once('../../artifacts_private/initialize.php');
?>
<?php $page_title = 'Reset'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<div class="content">
<?php
$con = $db;

if(isset($_POST["email"]) && (!empty($_POST["email"]))){
   $email = $_POST["email"];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   $email = filter_var($email, FILTER_VALIDATE_EMAIL);

   if (!$email) {
      $error .="<p>Invalid email address please type a valid email address!</p>";

      } else {
         $sel_query = "SELECT * FROM `users` WHERE email='".$email."'";
         $results = mysqli_query($con,$sel_query);
         $row = mysqli_num_rows($results);
         if ($row==""){
            $error .= "<p>No user is registered with this email address!</p>";
         }
      }

   if($error!="") {
   echo "<div class='error'>".$error."</div>
   <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   
   } else {

      $expFormat = mktime(
         date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
      );
      $expDate = date("Y-m-d H:i:s",$expFormat);
      $key = md5(2418*2+$email); // original
      $addKey = substr(md5(uniqid(rand(),1)),3,10);
      $key = $key . $addKey;

      // Insert Temp Table
      mysqli_query($con,
      "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
      VALUES ('".$email."', '".$key."', '".$expDate."');");
      
      $output='<p>Dear user,</p>';
      $output.='<p>Please click on the following link to reset your password.</p>';
      $output.='<p>-------------------------------------------------------------</p>';
      $output.='<p><a href="https://artifact-minimalism.site/reset/reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">https://artifact-minimalism.site/reset/reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>'; 
      $output.='<p>-------------------------------------------------------------</p>';
      $output.='<p>Copy the link to your browser. The link will expire after 1 day.</p>';
      $output.='<p>If you did not request this reset password email, no action is needed. Your password will not be reset.</p>';   
      $output.='<p>Thanks,</p>';
      $output.='<p>Steward Goods</p>';
      $body = $output; 
      $subject = "Password Reset - artifact-minimalism.site";
      
      $email_to = $email;
      $fromserver = "jacob@stewardgoods.com"; // Originally noreply@yourwebsite.com
      require("composer/vendor/autoload.php"); // added
      $mail = new PHPMailer(TRUE);
      $mail->IsSMTP();
      $mail->Host = "mail.stewardgoods.com"; // Enter your host here
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'ssl';
      $mail->Username = "jacob@stewardgoods.com"; // Enter your email here
      $mail->Password = "N{3IIa[KpkL~"; // Enter your password here
      $mail->Port = 465; // Originally 25
      $mail->SMTPOptions = array(
         'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true
         )
      );
      $mail->IsHTML(true);
      $mail->From = "jacob@stewardgoods.com";
      $mail->FromName = "Steward Goods";
      $mail->Sender = $fromserver; // indicates ReturnPath header
      $mail->Subject = $subject;
      $mail->Body = $body;
      $mail->AddAddress($email_to);

      if(!$mail->Send()) {
         echo "Mailer Error: " . $mail->ErrorInfo;
      } else {
         echo 
            "<div class='error'>
               <p>An email has been sent to you with instructions on how to reset your password.</p>
            </div>
            <br /><br /><br />";
      }
   }
} else { ?>

<form method="post" action="" name="reset"><br /><br />
   <label><strong>Enter Your Email Address:</strong></label><br /><br />
   <input type="email" name="email" placeholder="username@email.com" />
   <br /><br />
   <input type="submit" value="Reset Password"/>
</form>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php } ?>
</div>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>