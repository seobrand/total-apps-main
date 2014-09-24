<?php session_start();

/* $user_id = "newtest1";
 $password = "123123";
$url='http://www.seobranddev.com/totalapps/superadmin/apis/api'*/
$user_id = "Universal-mgr";
$password = "aa011698";

/*########################
 NOTE TO AGENTS:
You must edit the above three lines to reflect your credentials in order to make this script work.
#########################*/
//http://www.seobranddev.com/totalapps/superadmin/merchants/api
class TransactionEngine
{
	var $_PostURL;
	var $_ValueArray;
	var $DebugMSG='';
	function TransactionEngine($url='http://total-apps.net/superadmin/apis/fullapi')
	{
		$this->_PostURL=$url;
		$this->_ValueArray=array();
	}

	function SetVar ($var,$val)
	{
		$this->_ValueArray[$var]=$val;
	}
	function Perform()
	{
		$req='';
		while (list ($key, $val) = each ($this->_ValueArray)) {
			$req.=urlencode($key).'='.urlencode($val).'&';
		}
		$req=substr($req, 0, -1);
		$this->DebugMSG.=$this->_PostURL."\r\n";
		$this->DebugMSG.=$req."\r\n";
			
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_PostURL);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_CAPATH, 'ca-cert-bundle.pem');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 250);

		$Responseobj	=	curl_exec($ch);	
		//var_dump($Responseobj);die;	
        curl_close ($ch);		
        return $Responseobj;
	}

}

$response = "";
$responseMessage = "";
$owner_partnership_percent_total = 0;
if(isset($_POST['merchantName'])){
	if($_SESSION['captcha'] != trim($_POST['captcha_val'])){
		die ("The CAPTCHA wasn't entered correctly. Go back and try it again." );
	}
	$owner_partnership_percent = $_POST['OwnerElement'];
	for($i=1;$i<=$owner_partnership_percent;$i++){
		$owner_partnership_percent_total = $owner_partnership_percent_total + $_POST['ownership'.$i];
	}
	if($owner_partnership_percent_total<50){
		$responseMessage = "Total ownership percent must be equal or greater than 50%.";
	}
		
	if($responseMessage==''){
		$tx=new TransactionEngine();
		$tx->SetVar('username', $user_id);
		$tx->SetVar('password', $password);
		// Perform Transaction
		if(is_array($_POST)){
			foreach($_POST as $key => $value){
				if($key=='output'){
					$tx->SetVar($key, stripslashes($value));
				}else{
					$tx->SetVar($key, $value);
				}
			}
		}
		
		$Responseobj = $tx->Perform();
		$Response = json_decode(json_encode((array)simplexml_load_string($Responseobj)),1);	
		
		if($Response === false){
			$response = "Failure";
			$responseMessage = 'Curl error: ' . curl_error($ch);	
		}elseif($Response['response_message'] == "Failure"){
			$response = $Response['response_message'];
			$responseMessage = $Response['Failure_msg'];	
		}elseif($Response['response_message'] == "Success"){
			$response = $Response['response_message'];
			$responseMessage = $Response['Success_msg'];	
		}
	}
}


?>

