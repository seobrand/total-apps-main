<?php 

/* -----------------------------------------------------------------------------------------
   IdiotMinds - http://idiotminds.com
   -----------------------------------------------------------------------------------------
*/
//require 'all_includes.php';
if(isset($_SESSION['User']) && !empty($_SESSION['User'])){
unset($_SESSION['User']);
unset($_SESSION['logout']);
header('Location: '.BASEURL);	
	
}

?>