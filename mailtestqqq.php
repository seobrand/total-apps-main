<?php
$email_to = "zach@level2designs.com";
$email_subject = 'Testing EXIM4';
$email_message = 'This is a Test';

     $result = mail($email_to, $email_subject, $email_message, 
$headers); 
 
     if ($result) echo 'Mail accepted for delivery ';
     if (!$result) echo 'Test unsuccessful... ';
?>
