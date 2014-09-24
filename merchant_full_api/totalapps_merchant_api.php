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

function whoisProperties($domain)
{
	$username = '26b7797aa09acc222c7629f63d124673';
	$password = 'india123';
	$template = 'http://api.robowhois.com/whois/DOMAIN/properties';
	 
	// Initializing curl
	$ch = curl_init();

	// Configuring curl options
	curl_setopt($ch, CURLOPT_URL, str_replace('DOMAIN', $domain, $template));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERAGENT, 'PHP/' . phpversion());
	 
	// Getting JSON result as string
	$response = curl_exec($ch);

	// Decode the JSON response into an Array
	$result = json_decode($response, true);
	$res = '';
	foreach($result as $key => $val) {
		if(is_array($val)){
			$res .= "[{$key}] = ";
			foreach($val as $key1 => $val1) {
				if(is_array($val1)){
					$res .= "[{$key1}] = ";
					foreach($val1 as $key2 => $val2) {
						if($key2 == "disclaimer") continue;
						if(is_array($val2)){
							$res .= "[{$key2}] = ";
							foreach($val2 as $key3 => $val3) {
								if(is_array($val3)){
									$res .= "[{$key3}] = ";
									foreach($val3 as $key4 => $val4) {
										$res .= "[{$key4}] = {$val4}";
									}
								}else{
									$res .=  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[{$key3}] = {$val3}";
								}

								$res .=  "<br />";
							}
						}else{
							$res .=  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[{$key2}] = {$val2}";
						}

						$res .=  "<br />";
					}
				}else{
					$res .=  "&nbsp;&nbsp;&nbsp;[{$key1}] = {$val1}";
				}
				$res .=  "<br />";
			}
		}else{
			$res .=  "[{$key}] = {$val}";
		}
		$res .=  "<br />";
	}//end foreach

	return $res;
}

function get_domain($url)
{
	$pieces = parse_url($url);
	if($pieces['scheme'] != 'https' && $pieces['scheme'] != 'http'){
		$url = "http://".$url;
	}
	$pieces = parse_url($url);
	$domain = isset($pieces['host']) ? $pieces['host'] : '';
	if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
		return $regs['domain'];
	}
	return false;
}

function xverifyresponse($posturl){
$note = '';
 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $posturl);
        curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_CAPATH, 'ca-cert-bundle.pem');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 250);
		$Response=curl_exec($ch);
		
		$xml = simplexml_load_string($Response);
		
		//print_r($xml);
		
		 foreach($xml as $key => $val) {
			 
			   $note .=  "[{$key}] = {$val}";
			 if(is_object($val)){
				foreach($val as $key1 => $val1) {
					 $note .= "[{$key1}] = {$val1}";
				}
			 }
			 $note .=  "<br>";
			  
		}

return $note;
}



class TransactionEngine
{
	var $_PostURL;
	var $_ValueArray;
	var $DebugMSG='';
	function TransactionEngine($url='http://total-apps.net/superadmin/apis/fullapi_totalapss')
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
	
	extract($_POST);
		$response = "Failure";
		$responseMessage ="The CAPTCHA wasn't entered correctly. Go back and try it again.";
	
	
	}else{
	
	$owner_partnership_percent = $_POST['OwnerElement'];
	for($i=1;$i<=$owner_partnership_percent;$i++){
		$owner_partnership_percent_total = $owner_partnership_percent_total + $_POST['ownership'.$i];
	}
	if($owner_partnership_percent_total<50){
		extract($_POST);
		$response = "Failure";
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
		$note = '';
		
		
		$postemailurl = "http://www.xverify.com/services/emails/verify/?email=".trim($_POST['contactEmail'])."&type=xml&apikey=1000172-2AAEBBA7";
$note .= xverifyresponse($postemailurl);
$postphoneurl = "http://www.xverify.com/services/phone/verify/?phone=".trim($_POST['contactPhone'])."&type=xml&apikey=1000172-2AAEBBA7&phonetype=phone&secret_key=S350QNAF";
$note .= "<br>";
$note .= xverifyresponse($postphoneurl);





$web_name = trim($_POST['merchantURL']);
if($web_name == 'Company Website'){
	$web_name = '';
}
if($web_name != ''){
	$web_url_domain = get_domain($web_name);
	$note .= whoisProperties($web_url_domain);
}


		
		$tx->SetVar('note', $note);
		
		$Responseobj = $tx->Perform();
		$Response = json_decode(json_encode((array)simplexml_load_string($Responseobj)),1);	
		
		if($Response === false){
			$response = "Failure";
			$responseMessage = 'Curl error: ' . curl_error($ch);	
		}elseif($Response['response_message'] == "Failure"){
		extract($_POST);
			$response = $Response['response_message'];
			$responseMessage = $Response['Failure_msg'];	
		}elseif($Response['response_message'] == "Success"){
			unset($_POST);
			$response = $Response['response_message'];
			$responseMessage = $Response['Success_msg'];	
		}
	}
	
	}
}


?>

