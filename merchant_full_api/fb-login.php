<?php
ob_start();
 session_start();
//$mainframe->initialise();
$userfb = NULL ;
/* -----------------------------------------------------------------------------------------
   IdiotMinds - http://idiotminds.com
   -----------------------------------------------------------------------------------------
*/
$appID = "503376809757020";
$appSecret = "6c3eb729f25dd5d23244f7ba5206d018"; 
//require 'all_includes.php';
require_once ('facebook/facebook.php'); 
//define('JPATH_BASE', dirname(__FILE__));
$facebook = new Facebook(array(
		'appId'		=>  $appID,
		'secret'	=> $appSecret,
		'cookie' => true
		/*'sharedSession' => true*/
		));
//get the user facebook id		

$userfb = $facebook->getUser();

if($userfb){
	try{
		
		//get the facebook user profile data
		$user_profile = $facebook->api('/me');
		
		$_SESSION['My_profile']=$user_profile;
		
		$params = array('next' => 'http://total-apps.net/merchant_full_api/fb-logout.php');
		//logout url
		$logout =$facebook->getLogoutUrl($params);
	//	$session =& JFactory::getSession();
	//	$session->set('FBUser', $user_profile);
	
		$_SESSION['logout']=logout;
		
		//$_SESSION['FBUser']=$user_profile;
		//$_SESSION['logout']=$logout;
		
		//die(print_r($_SESSION['FBUser']));
		
	}catch(FacebookApiException $e){
		error_log($e);
		$user = NULL;
		//die("Sorryyy");
	}		
}
	
if(empty($userfb)){
	//login url	
	$loginurl = $facebook->getLoginUrl(array(
					'scope'			=> 'email,user_birthday,user_about_me,user_activities,user_education_history,user_hometown,user_interests,user_location,user_notes,user_photos,user_relationships,user_status,user_website,user_work_history',
					'redirect_uri'	=> 'http://total-apps.net/merchant_full_api/fb-login.php',
					'display'=>'popup'
					));
	
	
	header('Location: '.$loginurl);
	exit();

}
?>
<!-- after authentication close the popup -->
<script type="text/javascript">
	window.close();
</script>
<?php ob_end_flush();?>