<?php
session_start();
$otp_secret = !empty($_SESSION['otp_secret']) ? $_SESSION['otp_secret'] : NULL;
if ( !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
   // TODO santization & validation
   $name = $_POST['email'];
   $secret = base32_encode($name);
   $_SESSION['otp_secret'] = $secret;
   $otpauth =  "otpauth://totp/OjamboShow:{$name}?secret={$secret}&issuer=OjamboShow&algorithm=SHA256&digits=6&period=30";
   shell_exec("qrencode -s 5 -o qrcode.png '{$otpauth}'");
   echo <<<HTML
   <img src="qrcode.png" alt="2FA Qr Code" />
   <p>Scan the QR code and open your OTP Client for Two-Factor aunthectiation (2FA)</p>
      <form action="form.php" method="POST">
         <input type="text" name="otp" placeholder="Enter Your Code" />
         <input type="submit" value="Submit" />
      </form> 
   HTML;
} elseif ( !empty($_POST['otp']) ) { 
   // TODO sanitization & validation
   $encoded = shell_exec("oathtool --totp=sha256 --base32 {$otp_secret}");
   if ($encoded == $_POST['otp']) {
      echo "You have successfully logged in";
   } else {
      echo "Try again";
   }     
} else {
   echo "Try again";
}
// Function By Anonymous 2018-01-03 04:42 https://www.php.net/manual/en/function.base-convert.php#122221
function base32_encode($d)
{
   list($t, $b, $r) = array("ABCDEFGHIJKLMNOPQRSTUVWXYZ234567", "", "");

   foreach(str_split($d) as $c)
       $b = $b . sprintf("%08b", ord($c));

   foreach(str_split($b, 5) as $c)
       $r = $r . $t[bindec($c)];

   return($r);
}
?>