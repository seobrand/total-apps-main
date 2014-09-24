<?php
session_start();


$content = 'pushkar';
$email='pushkersoni@gmail.com';
$to='pushkar@planetwebsolution.com';

$subject = "Alaska Powder Descents:";

		
			
$headers  =  "From:".$email."\r\n".'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
var_dump(mail($to, $subject, $content, $headers));
echo '<div style="color;position:absolute">Enquiry Successfully Sent</div>';
				 

				
 ?>
