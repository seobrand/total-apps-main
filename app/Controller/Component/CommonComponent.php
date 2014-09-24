<?php

/**************************************************************************

 Coder  : Pushkar Soni 

 Object : Component for common functions

**************************************************************************/ 

class commonComponent extends Component {

	var $components = array('Usermgmt.UserAuth');

	var $catArr 	= array();

	/** Function to get time stamp in unix timestamp format **/

	function getTimeStamp() {

		return mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));

	}  

	/** Function to get time stamp after years

	 @param int - number of year default is 1

	 return timestamp after some year  ***/

	function getTimeStampAfterYear($years=1) {

		return mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')+$years);

	} 

	/* Function to get time stamp after some time or days or month letter */

	function getTimeStampLaterDates($days=0,$months=0,$years=0) {

		return mktime(date('H'),date('i'),date('s'),date('m')+$months,date('d')+$days,date('Y')+$years);

	}   

	/*** Create a random string

	 * @param	int $length - length of the returned number

	 * @return	string - string ***/

	function randomString($length = 8)	{

		$pass = "";

		// possible password chars.

		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",

			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",

			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");

		for($i=0 ; $i < $length ; $i++) {

			$pass .= $chars[mt_rand(0, count($chars) -1)];

		}

		return $pass;

	}

	/* Function to find time stamp according to date format */

	function timeStampByDate($date,$format= 'm-d-Y',$seprator='-') {

		$timeStamp  = '';

		$formatArr  =  preg_split("/[\s-:\/,]+/", strtolower($format)); 

		$formatArr  = array_flip($formatArr);

		$dArr 		= preg_split("/[\s-:\/,]+/", $date); 

		if(isset($dArr[0]) && isset($dArr[1]) && isset($dArr[2]) ) {

			$timeStamp = mktime(date('H'),date('i'),date('s'),$dArr[$formatArr['m']],$dArr[$formatArr['d']],$dArr[$formatArr['y']]);

		}

		return $timeStamp;

	}

	/*** Function to make a alias of any string

	 * @param	string  $data is string 

	 * @return	string - string ***/

	function makeAlias($data){

		$string_alias = trim($data);

		$string_alias = preg_replace('/\W/', ' ', $string_alias);

		// replace all white space sections with a dash

		$string_alias = preg_replace('/\ +/', '-', $string_alias);

		// trim dashes

		$string_alias = preg_replace('/\-$/', '', $string_alias);

		$string_alias = preg_replace('/^\-/', '', $string_alias);

		$string_alias = strtolower($string_alias);

		return $string_alias;

	}

	/*** function for uploading image 

	 * uploads files to the server

	 * @params:

	 *		$folder 	= the folder to upload the files e.g. 'img/files'

	 *		$formdata 	= the array containing the form files

	 *		$itemId 	= id of the item (optional) will create a new sub folder

	 * @return:	will return an array with the success of each file upload

	 */

	 

	 

	 

	function uploadFiles($folder, $formdata, $itemId = null) {

		// setup dir names absolute and relative

		$result = array();

		$folder_url = WWW_ROOT.$folder; 

		 $rel_url = $folder;

		// create the folder if it does not exist

		if(!is_dir($folder_url)) {

			mkdir($folder_url);

		}

		// if itemId is set create an item folder

		if($itemId) {

			// set new absolute folder

			$folder_url = WWW_ROOT.$folder.'/'.$itemId; 

			// set new relative folder

			$rel_url = $folder.'/'.$itemId;

			// create directory

			if(!is_dir($folder_url)) {

				mkdir($folder_url);

			}

		}

	// list of permitted file types, this is only images but documents can be added

	$permitted = array('image/gif','image/jpeg','image/jpg','image/pjpeg','image/png','image/x-png','image/tif','image/tiff');

	

	

	$file=$formdata;

	

	

	// loop through and deal with the files

	foreach($formdata as $file) {

	  

		// replace spaces with underscores

		

		$fileNaArr 		=  explode('.',$file['name']);

		

		$origFileName 	= $fileNaArr[0];

		$fileExt 		= end($fileNaArr);

		$filename 		= $this->makeAlias($origFileName).'.'.$fileExt; //str_replace(' ', '_', $file['name']);

		// assume filetype is false

		$typeOK = false;

		foreach($permitted as $type) {

			if($type == $file['type']) {

				$typeOK = true;

				break;

			}

		}



		// if file type ok upload the file

		if($typeOK) {

			// switch based on error code

			switch($file['error']) {

			  case 0:

					// create unique filename and upload file

					//ini_set('date.timezone', 'Europe/London');

					//$now      = $this->getTimeStamp();

					$now = microtime(true)*10000;

					//$filename = $this->makeAlias($filename);

					$full_url = $folder_url.'/'.$now.$filename;

					

					//$newfilepath = $now.'-'.$filename;

					$newfilepath = $filename;

					$url      = $rel_url.'/'.$newfilepath;

					$success  = move_uploaded_file($file['tmp_name'], $url);

				// if upload was successful

				if($success) {

					// save the url of the file

					$result['urls'][] = $newfilepath;

				} else {

					$result['errors'][] = "Error uploaded $filename. Please try again.";

				}

				break;

			case 3:

				// an error occured

				$result['errors'][] = "Error uploading $filename. Please try again.";

				break;

			default:

				// an error occured

				$result['errors'][] = "System error uploading $filename. Contact webmaster.";

				break;

			}

		} 

		else if($file['error'] == 4) {

			// no file was selected for upload

			$result['nofiles'][] = "No file Selected";

		} 

		else {

			// unacceptable file type

			$result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";

		}

	}

		return $result;

	}

	/* Generate n random number */

	function generateRandNum($num=1,$prefix='',$postfix='') {

		for($i=0;$i<$num;$i++) {

			$mktime = $this->getTimeStamp();

			$rand   =  rand(1000,9999);

			$randArr[] = $prefix.$mktime.$rand.$postfix; 

		} 

		return $randArr;

	}









	/* Function to get country list */

	function getCountryList() {

		APP::import('Model','Country');

		$this->Country = new Country(); 

		return $this->Country->find('list',array('fields'=>array('id','name'),'order'=>array('name')));

	}

	

	/* Function to get region/state/provinces list */

	function getRegionList($country_id) {

		APP::import('Model','Region');

		$this->Region = new Region(); 

		return $this->Region->find('list',array('conditions'=>array('country_id'=>$country_id),'fields'=>array('id','name'),'order'=>array('name')));

	}

	/* Function to get city list */

	function getCityList($region_id,$country_id='') {

		APP::import('Model','City');

		$this->City = new City();

		if($country_id) {

		  $condition = array('region_id'=>$region_id,'country_id'=>$country_id); 

		}

		else {

		  $condition = array('region_id'=>$region_id);

		} 

		return $this->City->find('list',array('conditions'=>$condition,'fields'=>array('id','name'),'order'=>array('name')));

	}

	/********* Function to get city name ************/

	function getCityName($city_id) {

		APP::import('Model','City');

		$this->City = new City();

		if($city_id) {

		  return $this->City->field('name',array('id'=>$city_id)); 

		}

	   return false;	

	}

	/********* Function to get Region/Provinces name ************/

	function getRegionName($region_id) {

		APP::import('Model','Region');

		$this->Region = new Region();

		if($region_id) {

		  return $this->Region->field('name',array('id'=>$region_id)); 

		}

	   return false;	

	}

	/********* Function to get Country name ************/

	function getCountryName($country_id) {

		APP::import('Model','Country');

		$this->Country = new Country();

		if($country_id) {

		  return $this->Country->field('name',array('id'=>$country_id)); 

		}

	   return false;	

	}

	//used

	function uploadDocuments($folder, $formdata, $itemId = null) {

		// setup dir names absolute and relative

		$folder_url = WWW_ROOT.$folder; 

		$rel_url = $folder;

		// create the folder if it does not exist

		if(!is_dir($folder_url)) {

			mkdir($folder_url);

		}

		// if itemId is set create an item folder

		if($itemId) {

			// set new absolute folder

			$folder_url = WWW_ROOT.$folder.'/'.$itemId; 

			// set new relative folder

			$rel_url = $folder.'/'.$itemId;

			// create directory

			if(!is_dir($folder_url)) {

				mkdir($folder_url);

			}

		}

	// list of permitted file types, this is only images but documents can be added

	$permitted = array('xls','xlsx','doc','docx','txt','rtf','pdf','odt');

	$permiteed_str = implode(', ', $permitted);

	// loop through and deal with the files

	//pr($formdata);

	foreach($formdata as $file) {

		// replace spaces with underscores

		$fileNaArr 		=  explode('.',$file['name']);

		$origFileName 	= $fileNaArr[0];

		$fileExt 		= end($fileNaArr);

		$filename 		= $this->makeAlias($origFileName).'.'.$fileExt; //str_replace(' ', '_', $file['name']);

		// assume filetype is false

		$typeOK = false;

		if(in_array(strtolower($fileExt),$permitted)) {

		  $typeOK = true;

		}

		/*foreach($permitted as $type) {

			if($type == $file['type']) {

				$typeOK = true;

				break;

			}

		}*/

		// if file type ok upload the file

		if($typeOK) {

			// switch based on error code

			switch($file['error']) {

			  case 0:

					// create unique filename and upload file

					//ini_set('date.timezone', 'Europe/London');

					//$now      = $this->getTimeStamp();

					$now = microtime(true)*10000;

					$filename 		= substr($this->makeAlias($origFileName),0,240).'.'.$fileExt;

					//$filename = $this->makeAlias($filename);

					$full_url = $folder_url.'/'.$filename;

					$newfilepath = $filename;

					$url      = $rel_url.'/'.$newfilepath;

					$success  = move_uploaded_file($file['tmp_name'], $url);

				// if upload was successful

				if($success) {

					// save the url of the file

					$result['urls'][] = $newfilepath;

				} else {

					$result['errors'][] = "Error uploaded $filename. Please try again.";

				}

				break;

			case 3:

				// an error occured

				$result['errors'][] = "Error uploading $filename. Please try again.";

				break;

			default:

				// an error occured

				$result['errors'][] = "System error uploading $filename. Contact webmaster.";

				break;

			}

		} 

		else if($file['error'] == 4) {

			// no file was selected for upload

			$result['nofiles'][] = "No file Selected";

		} 

		else {

			// unacceptable file type

			$result['errors'][] = "$filename cannot be uploaded. Acceptable file types: $permiteed_str.";

		}

	}

		return $result;

	}

	



	/****************** Function to get banners by category :- Pradeep Saxena******************/

	function getFrontBannerToDisplay($cacID = array()){

	 		App::import('model','Banner');

			$bannUserArr = array();

			$catIds = 0;

			if(is_array($cacID)) {

			  $bannUserArr = $cacID;

			}

			else if($bannUserArr) {

			   $bannUserArr[] = $cacID;

			}

			

			if(SHOW_AMDIN_BANNER) {

			   $bannUserArr[] = 0;

			}  

			if(is_array($bannUserArr)) {

			    $catString = implode(',',$bannUserArr);

				$this->Banner = new Banner(); 

				$bannerList = $this->Banner->find('all', array('fields' => array('Banner.id', 'Banner.line_one', 'Banner.graphic', 'Banner.hyperlink', 'Banner.active'),'order' => 'Banner.created ASC','conditions' => array('Banner.active' => 'yes', 'Banner.category_id IN ('.$catString .')'))); 

				 //pr($bannerList);//die;

				return $bannerList;

			}

			return ;

	      }	

		  

	/****************** Function to get banners by category :- Pradeep Saxena******************/

	function make_http_url($get_target_url){

	 		 

		     

				if ($get_target_url != '' && (substr($get_target_url, 0, 7) == 'http://' || substr($get_target_url, 0, 8) == 'https://'))

				 { 

					$target_url =  $get_target_url;

				}

				else

				{

					$target_url = 'http://'. $get_target_url;

				

				}

				return $target_url;

	      }	



		function limit_text( $text, $limit, $succeder='')

		 

		{

		 

		// figure out the total length of the string

		 

		if( strlen($text)>$limit )

		{

		$text = substr( $text,0,$limit );

		// lose any incomplete word at the end

		//$text = substr( $text,0,-(strlen(strrchr($text,' '))) );

		}

		

		// return the processed string

		

		return $text . $succeder;

		

		}



   /* Functioon to get all subcates ids */

     function allCateSubcatListIds($parent_id = 0,$publish=1) {

	    $this->allSubcats($parent_id ,$publish,$returnField='id');

		$arr = $this->catArr;

		$this->catArr = array();

		return $arr;

	 }

	/* Functioon to get all subcates category name with nesting */

     function allCateSubcatListNames($parent_id = 0,$publish=1) {

	    $this->allSubcats($parent_id ,$publish,$returnField='category_name');

		$arr = $this->catArr;

		$this->catArr = array();

		return $arr;

	 }

	 /* Function to get icons of file */

	 function getIconName($fileName) {

	   $extArr = explode('.',$fileName);

	   $ext = end($extArr);

	   switch(strtolower($ext)) {

	   	 case 'pdf' :

		    return 'pdf.jpg';

		 case 'xls' :

		 case 'xlsx' :

		    return 'excel.jpg';

		 case 'ppt' :

		 case 'pptx':

		     return 'power_point.jpg';	

		 case 'doc' :

		 case 'docx' :

		    return 'word.jpg';

		 case 'txt' :

		 case 'rtf' :

		    return 'txt.jpeg';

		 case 'gif' :

		 case 'jpeg' :

		 case 'jpg' :

		 case 'png' :

		    return 'thumb.jpg';

		 default :

		   return 'default.gif'; 

		    				

	   }

	 }





	/* Function to save into inbox */

	function saveInboxMessage($to_user,$to_username,$subject,$body,$from_user=0,$from_username='admin',$project_id=0) {

	//Save mail to inbox 

		$mailToInbox['from_user'] = $from_user;

		$mailToInbox['to_user']	  = $to_user; 

		$mailToInbox['from_status'] = 1;

		$mailToInbox['to_status'] = 1;

		$mailToInbox['to_username'] = $to_username;

		$mailToInbox['from_username'] = $from_username;

		$mailToInbox['message_title'] = strip_tags($subject);

		$mailToInbox['message_contents'] = $body;

		$mailToInbox['message_read'] =1;

		$mailToInbox['project_id'] =$project_id;

		$mailToInbox['admin_id'] =1;

		APP::import('Model','Message');

		$this->Message = new Message();

		$this->Message->save($mailToInbox);

	}

	/*  Save payment order */

	function saveOrder($amount,$receiver_user_id,$sender_user_id,$description,$trns_id,$payment_status='complete') {

		$orderArr['amount'] 		  = $amount;

		$orderArr['receiver_user_id'] = $receiver_user_id;

		$orderArr['sender_user_id']   = $sender_user_id;

		$orderArr['description'] 	  = $description;

		$orderArr['payment_status']   = $payment_status;

		$orderArr['transaction_id']   = $trns_id;

		APP::import('Model','Order');

		$this->Order = new Order();

		$this->Order->save($orderArr);

	}

	/* Check feed back given or not */

    function checkFeedbackStatus($shipment_id,$to_user_id) {

		APP::import('Model','Review');

		$this->Review = new Review();

		$id = $this->Review->field('Review.id',array('Review.shipment_id'=>$shipment_id,'Review.to_user_id'=>$to_user_id));

		if((int)$id) {

			$count =  $this->Review->find('count',array('conditions'=>array('Review.from_user_id'=>$to_user_id,'Review.shipment_id'=>$shipment_id)));

			return !$count;

		}

		return (int)$id;

	}

	/************** Get avg rating of any user *************/

	function userRatingReview($userId) {

		APP::import('Model','Review');

		$this->Review = new Review();

		//$arr['avgRating'] 		= $this->Review->field('AVG(Review.rating)',array('Review.to_user_id'=>$userId));

		//$arr['countReview'] 	= $this->Review->field('COUNT(Review.review)',array('Review.to_user_id'=>$userId));

		$arr = $this->Review->find('first',array('fields'=>array('COUNT(Review.review) as countReview','AVG(Review.rating) as avgRating'),'conditions'=>array('Review.to_user_id'=>$userId)));

		if(isset($arr[0]) && count($arr[0])) {

			return $arr[0];

		}

		return array('avgRating'=>'0','countReview'=>0);

	}

	/*	Convert days into month */

	function daysToMonYearFormat($days) {

	  /*  $str = '';

		if($days > 360) {

		   $str .= ($days/30).' Month ';

		   if 

		}*/

	}

	/*Fucntion to save image from live url */

	function save_image($img,$fullpath){

		$ch = curl_init ($img);

		curl_setopt($ch, CURLOPT_HEADER, 0);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);

		$rawdata=curl_exec($ch);

		curl_close ($ch);

		if(!$rawdata) {

		   return false;

		}

		if(file_exists($fullpath)){

			unlink($fullpath);

		}

		$fp = fopen($fullpath,'x');

		fwrite($fp, $rawdata);

		fclose($fp);

		return true;

		

	}

	/* Function to calculate miles between two locations */

	

	  /* Get geocoordinates or latitude and logitude of any address */

	  function getLatLon($address='') {

	     $address = trim($address);

		 $resultArr = array();

	     if($address) {

			$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . GOOGLE_MAP_KEY;

			$request_url = $base_url . "&q=" . urlencode($address);

			$xml = simplexml_load_file($request_url);

			if(!$xml){

			 return $resultArr;

			 }

		

			$status = $xml->Response->Status->code;

			if (strcmp($status, "200") == 0) {

			  // Successful geocode

			  $coordinates = $xml->Response->Placemark->Point->coordinates;

			  $coordinatesSplit = split(",", $coordinates);

			  // Format: Longitude, Latitude, Altitude

			  $resultArr['lat'] = $coordinatesSplit[1];

			  $resultArr['lng'] = $coordinatesSplit[0];

			  return $resultArr;

			} 

  		}

		return $resultArr;

	  }

	  

	 /* Get miles between latitude and longitude address */

	 /* function getDistance($geocoordinates,) {

	    $miles = ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(-122) ) + sin( radians(37) ) * sin( radians( lat ) ) ) );

	  }*/

	   function getDistance($lat1, $lng1, $lat2, $lng2, $miles = true) {

	  	 //echo M_PI;

		  $pi80 = M_PI / 180;

		  $lat1 *= $pi80;

		  $lng1 *= $pi80;

		  $lat2 *= $pi80;

		  $lng2 *= $pi80;

		  $r = 6371; // mean radius of Earth in km

		  $dlat = $lat2 - $lat1;

		  $dlng = $lng2 - $lng1;

		  $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);

		  $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

		  $km = $r * $c;

		  return ($miles ? ($km * 0.621371192) : $km);

      }

	  //Filtering any string 

	  function remove_HTML($s , $keep = '<p>' , $expand = 'script|iframe|style|noframes|select|option'){

        /**///prep the string

        $s = ' ' . $s;

       

        /**///initialize keep tag logic

        if(strlen($keep) > 0){

            $k = explode('|',$keep);

            for($i=0;$i<count($k);$i++){

                $s = str_replace('<' . $k[$i],'[{(' . $k[$i],$s);

                $s = str_replace('</' . $k[$i],'[{(/' . $k[$i],$s);

            }

        }

       

        //begin removal

        /**///remove comment blocks

        while(stripos($s,'<!--') > 0){

            $pos[1] = stripos($s,'<!--');

            $pos[2] = stripos($s,'-->', $pos[1]);

            $len[1] = $pos[2] - $pos[1] + 3;

            $x = substr($s,$pos[1],$len[1]);

            $s = str_replace($x,'',$s);

        }

       

        /**///remove tags with content between them

        if(strlen($expand) > 0){

            $e = explode('|',$expand);

            for($i=0;$i<count($e);$i++){

                while(stripos($s,'<' . $e[$i]) > 0){

                    $len[1] = strlen('<' . $e[$i]);

                    $pos[1] = stripos($s,'<' . $e[$i]);

                    $pos[2] = stripos($s,$e[$i] . '>', $pos[1] + $len[1]);

                    $len[2] = $pos[2] - $pos[1] + $len[1];

                    $x = substr($s,$pos[1],$len[2]);

                    $s = str_replace($x,'',$s);

                }

            }

        }

       

        /**///remove remaining tags

        while(stripos($s,'<') > 0){

            $pos[1] = stripos($s,'<');

            $pos[2] = stripos($s,'>', $pos[1]);

            $len[1] = $pos[2] - $pos[1] + 1;

            $x = substr($s,$pos[1],$len[1]);

            $s = str_replace($x,'',$s);

        }

       

        /**///finalize keep tag

        for($i=0;$i<count($k);$i++){

            $s = str_replace('[{(' . $k[$i],'<' . $k[$i],$s);

            $s = str_replace('[{(/' . $k[$i],'</' . $k[$i],$s);

        }

        return trim($s);

    }	

	

	

	//function to remove <script> tags

	function ScriptRemover($arr) {

		$code = '/<script[^>]*?>.*?<\/script>/si';

   		$noscript = '';

		// $data array is passed using the form field name as the key

		// have to extract the value to make the function generic			 

		$key = array_keys($arr);

		foreach($key as $key){			 

			 

			 if(!is_array($arr[$key])) {		

					$arr[$key] = preg_replace($code, $noscript, $arr[$key]);

				}

				

			else

			{

			$key1 = array_keys($arr[$key]);

			foreach($key1 as $key1)

			{

			if(!is_array($arr[$key][$key1])) {		

					$arr[$key][$key1] = preg_replace($code, $noscript, $arr[$key][$key1]);

				}		

			}			

		}

	}

	return $arr;

	}	

        

        

        /* Function to get country list */

	function getStateList() {

		APP::import('Model','State');

		$this->State = new State(); 

		echo "jtiendra";die;
		//return $this->State->find('list',array('fields'=>array('id','state_name'),'order'=>array('state_name')));

	}

        

        function getStateName($state_id) {

		APP::import('Model','State');

		$this->State = new State();

		if($state_id) {

		  return $this->State->field('statename',array('id'=>$state_id)); 

		}

	   return false;	

	}

        

        function checkSortOrder($modelName,$sort){

            APP::import('Mode',$modelName);

            $this->$modelName = new $modelName;

            $countSort = $this->$modelName->find('first',array('conditions'=>array($modelName.'.sort_order'=>$sort)));

            if($countSort>0){

                return true;

            }else{

                return false;

            }

        }

        

        

        function getStatus($status){

            if($status == 1){

                return "Yes";

            }else{

                return "No";

            }

        }

        function getStatusRev($status){

            if($status == "Yes"){

                return 1;

            }else{

                return 0;

            }

        }

		



		

		function getMerchantStatusOuter(){

			APP::import('Model','Status');

			$this->Status = new Status();

			return $this->Status->find("all",array('order'=>'Status.navigationOrder ASC','conditions'=>'Status.navigationOrder>0')); 

		}

		

		function getMerchantStatusOther(){

			APP::import('Model','Status');

			$this->Status = new Status();

			return $this->Status->find("all",array('order'=>'Status.status ASC','conditions'=>'Status.navigationOrder=0')); 

		}

		

		function getManagerIdName(){

			APP::import('Model','User');

			$this->User = new User();

			return $this->User->find("list",array('fields'=>'id,user_Name','conditions'=>'User.isManager=1')); 

			

		}

		function getProcessor(){

			APP::import('Model','User');

			$this->User = new User();

			return $this->User->find("list",array('fields'=>'id,user_Name','conditions'=>'User.isProcessor	=1')); 

			

		}

		

			function getIsonameid(){

			APP::import('Model','User');

			$this->User = new User();

			return $this->User->find("list",array('fields'=>'id,user_Name','conditions'=>'User.isIso=1')); 

			

		}

		

		function getProcessorNameById($procId){
			APP::import('Model','User');
			$this->User = new User();
			return $this->User->field('user_Name',array('User.id'=>$procId)); 
			
		}

		

		function getProcessorDoc($processorID){

			APP::import('Model','Processordoclink');

			$this->Processordoclink = new Processordoclink();

			return $this->Processordoclink->find("all",array('fields'=>'docID','conditions'=>'Processordoclink.processorID='.$processorID)); 

		}

		

		function getAgentList($status=null){
			if($status!=NULL){
				$status_cond = "UserGroupJoin.user_group_id = 20 AND User.active = ".$status ;
			}else{
				$status_cond = "UserGroupJoin.user_group_id = 20 AND User.active IN (0,1)";
			}
			
			APP::import('Model','Usermgmt.User');
			$this->User = new User();
			$options['joins'] = array(
			    array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)
				);

				// AGENT ID 20 (task id 2060 point 2)
				$options['conditions'] = array($status_cond);

				$options['fields'] = array(    
					'User.user_Name'    
				);

				$options['order'] = array(    
					'User.user_Name ASC'    
				);

				$agentList = $this->User->find('list', $options);
				return $agentList;
			}



	  function getProcessorList($status=null){
			if($status!=NULL){
				$status_cond = "UserGroupJoin.user_group_id = 23 AND User.active = ".$status ;
			}else{
				$status_cond = "UserGroupJoin.user_group_id = 23 AND User.active IN (0,1)";
			}		
			
			APP::import('Model','Usermgmt.User');
			$this->User = new User();		
			$options['joins'] = array(
			    array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)
				);

				// PROCESSOR ID 23
				$options['conditions'] = array($status_cond);
				$options['fields'] = array(    
					'User.user_Name'    
				);
				$options['order'] = array(    
					'User.user_Name ASC'  
				);

				$agentList = $this->User->find('list', $options);
				return $agentList;
		  }

		/* @author Prakash Saini
		 * @  10 jully 2013
		**/
		function getProcessorByNameList( $name_array = NULL){
			APP::import('Model','Usermgmt.User');
			$this->User = new User();
				
			$options['joins'] = array(
					array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)
			);
		
			// PROCESSOR ID 23
			$options['conditions'] = array(
					'UserGroupJoin.user_group_id' => 23,'User.active' =>'1',
			);
			if( $name_array ) {
				$options['conditions'][] = array('User.user_Name'=> $name_array);
			}
			$options['fields'] = array(
					'User.user_Name'
			);
			$options['order'] = array(
					'User.user_Name ASC'
			);
		
			$agentList = $this->User->find('list', $options);
			return $agentList;
		
		}
		
		function getAllUserList(){
			APP::import('Model','Usermgmt.User');
			$this->User = new User();
			
			
			return 	$userList = $this->User->find('list',array('fields'=>'userEmail,user_Name'));

				//return $agentList;

		}
		

		function getIsoList($status=null){
			if($status!=NULL){
				$status_cond = "UserGroupJoin.user_group_id = 22 AND User.active = ".$status ;
			}else{
				$status_cond = "UserGroupJoin.user_group_id = 22 AND User.active IN (0,1)";
			}
			
			APP::import('Model','Usermgmt.User');
			$this->User = new User();
			$options['joins'] = array(

			    array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)

				);

				// ISO ID 22 (task id 2060 point 2)

				$options['conditions'] = array($status_cond);

				$options['fields'] = array(
					'User.user_Name' 
				);

				$options['order'] = array( 
					'User.user_Name ASC'
				);

				$agentList = $this->User->find('list', $options);
				return $agentList;

			}

		

		function getManagerList($status=null){
			if($status!=NULL){
				$status_cond = "UserGroupJoin.user_group_id = 24 AND User.active = ".$status ;
			}else{
				$status_cond = "UserGroupJoin.user_group_id = 24 AND User.active IN (0,1)";
			}
			
			APP::import('Model','Usermgmt.User');
			$this->User = new User();
			$options['joins'] = array(
			    array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)
			);

				// MANAGER ID 24

				$options['conditions'] = array($status_cond);

				$options['fields'] = array(    
					'User.user_Name'    
				);

				$options['order'] = array(
					'User.user_Name ASC'  
				);

				$agentList = $this->User->find('list', $options);
				return $agentList;

		}

		

		function getReferalList($status=null){
			if($status!=NULL){
				$status_cond = "UserGroupJoin.user_group_id = 25 AND User.active = ".$status ;
			}else{
				$status_cond = "UserGroupJoin.user_group_id = 25 AND User.active IN (0,1)";
			}
			
			APP::import('Model','Usermgmt.User');
			$this->User = new User();
			$options['joins'] = array(
			    array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)
			);

				// REFERAL ID 20(task id 2060 point 2)

				$options['conditions'] = array($status_cond);

				$options['fields'] = array(
					'User.user_Name'    
				);

				$options['order'] = array( 
					'User.user_Name ASC'
				);

				$referalList = $this->User->find('list', $options);
				return $referalList;

		}


		function countRec($model){
			APP::import('Model',$model);
			$this->$model = new $model();
		 	return	count($this->$model->find("all")); 
		}

		

		function checkProcessorDOC($processorID,$docID){

			APP::import('Model','Processordoclink');

			 $this->Processordoclink = new Processordoclink();

			return	$REC=$this->Processordoclink->find("count",array('conditions'=>'processorID='.$processorID.' and docID='.$docID.'')); 

		

		}

		// Function for get Status name by status id

		function getStatusName($statusID){

			APP::import('Model','Status');

			$this->Status = new Status();

		 	$StatusName = $this->Status->find("first",array('fields'=>'status','conditions'=>'id='.$statusID.''));

			return $StatusName['Status']['status'];

		}

		

		

		

	function findgroup($procId){

				APP::import('Model','UserGroup');

					$this->UserGroup = new UserGroup();

				return	$name=$this->UserGroup->query('select name from user_groups where id="'.$procId.'"');

					

	}

	

	function fetchAllGroupName(){

		APP::import('Model','UserGroup');

		$this->UserGroup = new UserGroup();

		return	$name=$this->UserGroup->find('all',array('fields'=>'name'));

		

		

	}

	function checkUserGroup($id,$userid){
		APP::import('Model','UserGroupJoin');
		$this->UserGroupJoin = new UserGroupJoin();
		return $this->UserGroupJoin->find("count",array('conditions'=>'user_group_id='.$id.' and user_id='.$userid.'')); 
	}

	

	function permissiSet($controller,$action)
	{
		APP::import('Model','UserGroupJoin');
		$this->UserGroupJoin = new UserGroupJoin();
		return	$this->UserGroupJoin->isUserGroupAccess($controller, $action,30);

	}

	function isUserGroupAccesss($controller,$action,$userGroupId)
	{
			App::import("Model", "Usermgmt.UserGroup");
			$this->userGroupModel = new UserGroup;
			return $this->userGroupModel->isUserGroupAccess($controller, $action, $userGroupId);
	}

	function breadcrubPermission($controller,$action)
	{
		$url='';
		/*echo $controller;
		echo "<br>";
		
		echo $action;
		echo "<br>";*/
		  switch($controller)
			{
				case 'Users':
					switch($action)
					{
						case 'superadmin_search':
								return	 $url ="<strong>Users => Search  <br></strong>";
								break;
							
						case 'superadmin_index':
								return  $url ="<strong>Users => All Users  <br></strong>";
								break;
							
						case 'superadmin_viewUser':
								return  $url ="<strong>Users => View  <br></strong>";
								break;
						
						case 'superadmin_api':
								return  $url ="<strong>totalapps.net  <br></strong>";
								break;

						case 'superadmin_addUser':
								return  $url ="<strong>Users => Add User  <br></strong>";
								break;

						case 'superadmin_deleteUser':
								return  $url ="<strong>Users => All User => Delete User  <br></strong>";
								break;		

						case 'superadmin_dashboard':
								return  $url ="<strong>Dashboard<br></strong>";
								break;		
						
						case 'superadmin_role':
								return  $url ="<strong>Select Role<br></strong>";
								break;		

						 case 'superadmin_export':
								return  $url ="<strong>Users => View => Export User List  <br></strong>";
								break;

						 case 'superadmin_editUser':
								return  $url ="<strong>Users => View => Edit <br></strong>";
								break;

						case 'superadmin_doclist':
								return  $url ="<strong>Users => Docs <br></strong>";
								break;
						

						case 'superadmin_agent':
								return  $url ="<strong>Users => All Users => Edit => Agent <br></strong>";
								break;

						case 'superadmin_manager':
								return  $url ="<strong>Users => All Users => Edit => Manager <br></strong>";
								break;

						case 'superadmin_iso':
								return  $url ="<strong>Users => All Users => Edit => Iso <br></strong>";
								break;

						case 'superadmin_processor':
								return  $url ="<strong>Users => All Users => Edit => Processor <br></strong>";
								break;			

						case 'superadmin_notes':
								return  $url ="<strong>Users => All Users => Edit => Notes <br></strong>";
								break;			

						case 'superadmin_notes':
								return  $url ="<strong>Users => All Users => Edit => Notes <br></strong>";
								break;			

						case 'superadmin_logout':
								return  $url ="<strong>Logout   <br></strong>";
								break;

						case 'superadmin_accessDenied':
								return  $url ="<strong>AccessDenied<br></strong>";
								break;
						case 'superadmin_deletenotes':
								return  $url ="<strong>Users => All Users => Edit => Notes => Delete Notes <br></strong>";
								break;
						case 'superadmin_reports_permission':
							return	 $url ="<strong>Admin => Set Report Permission <br></strong>";
							break;
											

						  default :
							   break;
					}
					
				case 'Commissions':
					switch($action)
					{
						case 'superadmin_upload':
							return	 $url ="<strong>Data Upload => Commission Upload<br></strong>";
							break;							
						case 'superadmin_approve':
							return  $url ="<strong>Data Upload => Commission Approve <br></strong>";
							break;
						case 'superadmin_export':
							return  $url ="<strong>Data Upload => Commission Export <br></strong>";
							break;
						case 'superadmin_splitdataupload':
							return	 $url ="<strong>Data Upload => Split % Data Upload<br></strong>";
							break;
						case 'superadmin_splitdata_approve':
							return  $url ="<strong>Data Upload => Split % Data Approve<br></strong>";
							break;
						case 'superadmin_splitdataexport':
							return  $url ="<strong>Data Upload => Split % Data Export<br></strong>";
							break;
						case 'superadmin_agent_iso_referral_upload':
							return	 $url ="<strong>Data Upload => Agent/ISO/Referral Upload<br></strong>";
							break;
						case 'superadmin_userdata_approve':
							return  $url ="<strong>Data Upload => Agent/ISO/Referral Approve <br></strong>";
							break;
						case 'superadmin_userdataexport':
							return  $url ="<strong>Data Upload => Agent/ISO/Referral Export <br></strong>";
							break;
						case 'superadmin_missinguserdataexport':
							return  $url ="<strong>Data Upload => Missing Agent/ISO/Referral<br></strong>";
							break;						
						default :
							   break;
					}

				case 'Merchants':
					switch($action)
					{
						  case 'superadmin_addmerchant':
								return  $url ="<strong>Merchants => Add  <br></strong>";
								break;
						  case 'superadmin_search':
								return  $url ="<strong>Merchants => Search  <br></strong>";
								break;
						  case 'superadmin_viewbystatus':
								return  $url ="<strong>Pipeline  <br></strong>";
								break;
						  case 'superadmin_edit':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant <br></strong>";
								break;	
						  case 'superadmin_duplicate':
								return  $url ="<strong>Pipeline =>Merchant List => Edit Merchant  => Create Duplicate Merchant <br></strong>";
								break;
						 case 'superadmin_merchantrates':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Add Rates for Merchant <br></strong>";
								break;
						case 'superadmin_merchanttrans':
								return  $url ="<strong>Pipeline => Merchant List  => Edit Merchant  => Add Transaction for Merchant <br></strong>";
								break;
						case 'superadmin_merchantaction':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Sent E-mails To Merchant <br></strong>";
								break;
						case 'superadmin_merchantnotes':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Add Notes for Merchant<br></strong>";
								break;
						case 'superadmin_merchantdeployment':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Add Deployment for Merchant<br></strong>";
								break;							
						case 'merchantVolumeBeforeRender':
								return  $url ="<strong>Merchant volume<br></strong>";
								break;								
						case 'superadmin_deletemerchant':
								return  $url ="<strong>Delete Merchant<br></strong>";
								break;						
						case 'superadmin_merchantcommission':
								return  $url ="<strong>Merchant => Search => Edit => Commossion<br></strong>";
								break;								
						case 'superadmin_underwriting':
								return  $url ="<strong>Merchant => Search => Edit => Underwriting<br></strong>";
								break;						
						case 'superadmin_processinghistory':
								return  $url ="<strong>Merchant => Search => Edit => Processiong history<br></strong>";
								break;
						case 'superadmin_delete':
								return  $url ="<strong>Pipeline => Merchant List => Delete Merchant<br></strong>";
								break;
						case 'superadmin_deleteNote':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Delete Notes of Merchant<br></strong>";
								break;
						case 'superadmin_isolist':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant(Action to fill merchant onclick on Agent )<br></strong>";
								break;
						case 'superadmin_merchantdoc':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Doc<br></strong>";
								break;
						case 'superadmin_moreinfo':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => More Info<br></strong>";
								break;	
						case 'superadmin_appointments':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Appointments<br></strong>";
								break;	
						case 'superadmin_referrallist':
								return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Get Merchant Referral List By Ajax<br></strong>";
								break;
						case 'superadmin_contact':
							return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Company Contacts<br></strong>";
							break;
						case 'superadmin_getcontactinfo':
							return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Company Contacts => Ajax Function To Get Contact List<br></strong>";
							break;
						case 'superadmin_contactdelete':
							return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Company Contacts => Delete Contact<br></strong>";
							break;
						case 'superadmin_approved_contract_ex_date':
							return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Approved Contract<br></strong>";
							break;
						case 'superadmin_mandatory_app_field':
							return  $url ="<strong>Pipeline => Merchant List => Edit Merchant => Mandatory App Field<br></strong>";
							break;
						  default :
							   break;
					}

			

				case 'Gateways':
					switch($action)
					{
						  case 'superadmin_addgateway':
								return	 $url ="<strong>Admin => Gatway => Add / View<br></strong>";
								break;

						  case 'superadmin_editgateway':
								return  $url ="<strong>Admin => Gatway => Edit<br></strong>";
								break;

						case 'superadmin_deletegateway':
							return  $url ="<strong>Admin => Gatway => Delete</strong>";
							break;

						  default :
							   break;
					}

				case 'Accounttypes':
					switch($action)
					{
						case 'superadmin_addaccounttypes':
							return	 $url ="<strong>Admin => Merchant Account Type => Add<br></strong>";
							break;

						case 'superadmin_editaccounttypes':
							return  $url ="<strong>Admin => Merchant Account Type => Edit</strong>";
							break;

						case 'superadmin_deleteaccounttypes':
							return  $url ="<strong>Admin => Merchant Account Type => Delete<br></strong>";
							break;

						case 'superadmin_viewlist':
							return  $url ="<strong>Admin => Merchant Account Type => View<br></strong>";
							break;

						default :
							break;
					}

				case 'Statuses':
					switch($action)
					{
						case 'superadmin_addstatus':
							return	 $url ="<strong>Admin => Statuses => Add New/View<br></strong>";
							break;

						case 'superadmin_editstatus':
							return  $url ="<strong>Admin => Statuses => Edit<br></strong>";
							break;

						case 'superadmin_deletestatus':
							return  $url ="<strong>Admin => Statuses => Delete</strong>";
							break;

						default :
						   break;
					}

					

				case 'Processordocs':
					switch($action)
					{
						case 'superadmin_addprodoc':
							return	 $url ="<strong>Admin => Processor Document => Add/view<br></strong>";
							break;

						case 'superadmin_editprodoc':
							return  $url ="<strong>Admin => Processor Document => Edit<br></strong>";
							break;

						case 'superadmin_deleteprodoc':
							return  $url ="<strong>Admin => Processor Document => Delete </strong>";
							break;

						default :
							break;
					}

				case 'Accountcats':
					switch($action)
					{
						  case 'superadmin_addaccountcats':
								return	 $url ="<strong>Admin => Account Category => Add<br></strong>";
								break;

						  case 'superadmin_editaccountcats':
								return  $url ="<strong>Admin => Account Category => Edit<br></strong>";
								break;

						 case 'superadmin_deleteaccountcats':
								return  $url ="<strong>Admin => Account Category => Delete<br></strong>";
								break;

						case 'superadmin_viewlist':
								return  $url ="<strong>Admin => Account Category => View <br></strong>";
								break;

						  default :
							   break;
					}
					
				case 'Appointments':
					switch($action)
					{
					//return $action;
						  case 'superadmin_addappointment':
								return	 $url ="<strong>Admin => Appoinments => Add<br></strong>";
								break;

						  case 'superadmin_editappointment':
								return  $url ="<strong>Admin => Appoinments => Edit<br></strong>";
								break;

						 case 'superadmin_deleteAppoinment':
								return  $url ="<strong>Admin => Appoinments => Delete<br></strong>";
								break;

						case 'superadmin_delete':
								return  $url ="<strong>Dashboard => Popup => delete <br></strong>";
								break;

						  default :
							   break;
					}

					
				case 'UserGroupPermissions':
					switch($action)
					{
						  case 'superadmin_index':
								return	 $url ="<strong>Admin => Set Permission <br></strong>";
								break;

						  default :
							   break;
					}

				case 'UserGroups':
					switch($action)
					{
						  case 'superadmin_index':
								return	 $url ="<strong>Admin => All Groups <br></strong>";
								break;

						  case 'superadmin_addGroup':
								return	 $url ="<strong>Admin => Add Groups <br></strong>";
								break;

						 case 'superadmin_editGroup':
								return	 $url ="<strong>Admin => All Groups => Edit<br></strong>";
								break;

						 case 'superadmin_deleteGroup':
								return	 $url ="<strong>Admin => All Groups => Delete<br></strong>";
								break;

						  default :
							   break;
					}

				case 'Merchanttransactions':
					switch($action)
					{
						  case 'superadmin_transaction':
								return	 $url ="<strong>Admin => Transaction => Add/Edit <br></strong>";
								break;
						  case 'superadmin_transactionlist':
								return	 $url ="<strong>Admin => Transaction <br></strong>";
								break;

						 case 'superadmin_deletetransaction':
								return	 $url ="<strong>Admin => Transaction => Delete <br></strong>";
								break;
						  default :
							   break;

					}

				case 'Rates':
					switch($action)
					{
						  case 'superadmin_rate':
								return	 $url ="<strong>Admin => Rates(PRICING) => Add/Edit <br></strong>";
								break;

						  case 'superadmin_ratelist':
								return	 $url ="<strong>Admin => Rates(PRICING) <br></strong>";
								break;

						 case 'superadmin_deleterates':
								return	 $url ="<strong>Admin => Rates(PRICING) => Delete <br></strong>";
								break;

						  default :
							   break;
					}

				case 'Deployments':
					switch($action)
					{
						  case 'superadmin_deployment':
								return	 $url ="<strong>Admin => Deployment => Add/Edit <br></strong>";
								break;

						  case 'superadmin_deploymentlist':
								return	 $url ="<strong>Admin => Deployment <br></strong>";
								break;

						 case 'superadmin_deletedeployment':
								return	 $url ="<strong>Admin => Deployment => Delete <br></strong>";
								break;

						  default :
							   break;
					}

					
				case 'Documents':
					switch($action)
					{
						case 'superadmin_index':
								return	 $url ="<strong>Documents <br></strong>";
								break;
								
						case 'superadmin_listFolder':
								return	 $url ="<strong>Admin => Folder <br></strong>";
								break;
						
						case 'superadmin_createFolder':
								return	 $url ="<strong>Admin => Documents =>Add <br></strong>";
								break;
						
						case 'superadmin_editFolder':
								return	 $url ="<strong>Admin => Documents =>Edit <br></strong>";
								break;
						
						case 'superadmin_deleteFolder':
								return	 $url ="<strong>Admin => Delete Folder <br></strong>";
								break;
							
						case 'superadmin_listDocument':
								return	 $url ="<strong>Admin => Documents<br></strong>";
								break;
						
						case 'superadmin_addDocument':
								return	 $url ="<strong>Documents => add <br></strong>";
								break;
						
						case 'superadmin_editDocument':
								return	 $url ="<strong>Documents => edit <br></strong>";
								break;
							
						case 'superadmin_deleteDocument':
								return	 $url ="<strong>Documents => Delete <br></strong>";
								break;	
					
						case 'getVideo':
								return	 $url ="<strong>ajax function <br></strong>";
								break;	
						 
								
					  	default :
							   break;

					}
					
					
				case 'Residuals':
					switch($action)
					{
						  case 'superadmin_residual':
								return	 $url ="<strong>Residual<br></strong>";
								break;
					
						  default :
							   break;

					}
					
					
				case 'Businesscats':
					switch($action)
					{
						  case 'superadmin_addbusinesscategory':
								return	 $url ="<strong>Admin => Business Category => Add<br></strong>";
								break;
						 case 'superadmin_editbusinesscategory':
								return	 $url ="<strong>Admin => Business Category => Edit<br></strong>";
								break;
						 case 'superadmin_deletebusinesscategory':
								return	 $url ="<strong>Admin => Business Category => Delete<br></strong>";
								break;
						case 'superadmin_viewlist':
								return	 $url ="<strong>Admin => Business Category => View<br></strong>";
								break;

						  default :
							   break;

					}
		
			case 'Supports':
					switch($action)
					{
						  case 'superadmin_index':
								return	 $url ="<strong>Support => Totalapps.com => Add Ticket<br></strong>";
								break;							
							case 'superadmin_ticket':
								return	 $url ="<strong>Support => Totalapps.com => All Tickets<br></strong>";
								break;								
							case 'superadmin_mojopayindex':
								return	 $url ="<strong>Support => Mojopay.com => Add Ticket<br></strong>";
								break;
							case 'superadmin_mojopayticket':
								return	 $url ="<strong>Support => Mojopay.com => All Tickets<br></strong>";
								break;							
							case 'superadmin_edit_ticket_by_ajax':
								return	 $url ="<strong>Support => Totalapps.com => All Tickets => Ticket Edit Pop Box<br></strong>";
								break;							
							case 'superadmin_mojopay_edit_ticket_by_ajax':
								return	 $url ="<strong>Support => Mojopay.com => All Tickets => Ticket Edit Pop Box<br></strong>";
								break;								
							case 'superadmin_view_ticket_by_ajax':
								return	 $url ="<strong>Support => Totalapps.com => All Tickets => Ticket View Pop Box<br></strong>";
								break;
							case 'superadmin_mojopay_view_ticket_by_ajax':
								return	 $url ="<strong>Support => Mojopay.com => All Tickets => Ticket View Pop Box<br></strong>";
								break;
							case 'superadmin_addcomment':
								return	 $url ="<strong>Support => Totalapps.com => All Tickets => Submit Edit Pop Box<br></strong>";
								break;
							case 'superadmin_mojopay_addcomment':
								return	 $url ="<strong>Support => Mojopay.com => All Tickets => Submit Edit Pop Box<br></strong>";
								break;
							case 'superadmin_deleteticket':
								return	 $url ="<strong>Support => Totalapps.com => All Tickets => Delete Ticket<br></strong>";
								break;
							case 'superadmin_mojopay_deleteticket':
								return	 $url ="<strong>Support => Mojopay.com => All Tickets => Delete Ticket<br></strong>";
								break;
							case 'superadmin_referralLinks':
								return	 $url ="<strong>Admin => Landing Page For Referral<br></strong>";
								break;
							case 'superadmin_deleteReferralLink':
								return	 $url ="<strong>Admin => Landing Page For Referral => Delete Referral Link From List<br></strong>";
								break;
							case 'superadmin_manageReferralLink':
								return	 $url ="<strong>Admin => Landing Page For Referral => Manage Referral Link<br></strong>";
								break;
							case 'superadmin_removeReferralLink':
								return	 $url ="<strong>Admin => Landing Page For Referral => Remove Referral Link<br></strong>";
								break;
							case 'superadmin_manageReferralLink':
								return	 $url ="<strong>Admin => Landing Page For Referral => Manage Referral Link<br></strong>";
								break;
							case 'superadmin_submitrequest':
								return	 $url ="<strong>Support => Taboo Support Request => Submit Request<br></strong>";
								break;
							case 'superadmin_viewrequests':
								return	 $url ="<strong>Support => Taboo Support Request => View All Submit Request<br></strong>";
								break;
							case 'superadmin_ticketapproved':
								return	 $url ="<strong>Support => Taboo Support Request => Make Request As Approved or Declined<br></strong>";
								break;
							case 'superadmin_downloadticketreq':
								return	 $url ="<strong>Support => Taboo Support Request => Download Document From Request List<br></strong>";
								break;
								
						  default :
							   break;
					}
								
				case 'Reports':
					switch($action)
					{
						case 'superadmin_allreports':
								return	 $url ="<strong>Reports => All Reports<br></strong>";
								break;								
						case 'superadmin_manageraccount':
							return	 $url ="<strong>Reports => Manager Report => Manager's Processing Account<br></strong>";
								break;
						case 'superadmin_residualreport':
							return	 $url ="<strong>Reports => Residual Report<br></strong>";
								break;
						case 'superadmin_commission':
								return	 $url ="<strong>Reports => Agent/Referral/Iso Report => Commission Report<br></strong>";
								break;
						case 'superadmin_paymentsetupfees':
								return	 $url ="<strong>Reports => Other Reports => Setup Fees<br></strong>";
								break;
						case 'superadmin_processorbyvolumeoramount':
								return	 $url ="<strong>Reports => Taboo's Accounts => Accounts By Processor<br></strong>";
								break;
						case 'superadmin_processorsetupfees':
								return	 $url ="<strong>Reports => Other Reports => Processor Set Up Fees<br></strong>";
								break;
						case 'superadmin_reportprocessor2':
								return	 $url ="<strong>Reports => Other Reports => Processor Business Type<br></strong>";
								break;
						case 'superadmin_expiringcontract':
								return	 $url ="<strong>Reports => Other Reports => Expiring Contracts<br></strong>";
								break;		
						case 'superadmin_conversion':
								return	 $url ="<strong>Reports => Conversion<br></strong>";
								break;
						case 'superadmin_processor':
								return	 $url ="<strong>Reports => Processor<br></strong>";
								break;
						case 'superadmin_manager':
								return	 $url ="<strong>Reports => Manager Report => Manager's Account<br></strong>";
								break;
						case 'superadmin_iso':
								return	 $url ="<strong>Reports => Taboo's Accounts => Account By ISO<br></strong>";
								break;
						case 'superadmin_agent':
								return	 $url ="<strong>Reports => Other Reports => Agent Contacts<br></strong>";
								break;
						case 'superadmin_referal':
								return	 $url ="<strong>Users => All Users => Edit =>  Referal<br></strong>";
								break;
						case 'superadmin_businessType':
								return	 $url ="<strong>Reports => Business Type<br></strong>";
								break;
						case 'superadmin_accountbyagent':
								return	 $url ="<strong>Reports => Taboo's Accounts => Accounts By Agent<br></strong>";
								break;
						case 'superadmin_accountbyreferral':
								return	 $url ="<strong>Reports => Taboo's Accounts => Accounts By Referral<br></strong>";
								break;
						case 'superadmin_procmonthlyprocessing':
								return	 $url ="<strong>Reports => Processor Report => Processors Monthly Processing<br></strong>";
								break;
						case 'superadmin_processormatrix':
								return	 $url ="<strong>Reports => Processor Report => Processors Business Matrix<br></strong>";
								break;
						case 'superadmin_tierreport':
								return	 $url ="<strong>Reports => Processor Report => Tier Reports<br></strong>";
								break;
						case 'superadmin_tierreport':
								return	 $url ="<strong>Reports => AGENT/REFERRAL/ISO REPORT => Commission Report<br></strong>";
								break;
						case 'superadmin_monthlyprocessingvolume':
								return	 $url ="<strong>Reports => Merchant Processing Volume => Monthly Merchant Processing Volume<br></strong>";
								break;
						case 'superadmin_newbusinessgrowth':
								return	 $url ="<strong>Reports => Merchant Processing Volume => New Business Growth<br></strong>";
								break;								
						case 'superadmin_existingbusinessgrowth':
								return	 $url ="<strong>Reports => Merchant Processing Volume => Existing Business Growth<br></strong>";
								break;									
						case 'superadmin_existingwithoutnerium':
								return	 $url ="<strong>Reports => Merchant Processing Volume => Existing Business Growth(Except Nerium)<br></strong>";
								break;
						case 'superadmin_loss':
								return	 $url ="<strong>Reports => Loss<br></strong>";
								break;
						case 'superadmin_processorMatrix':
								return	 $url ="<strong>Reports => Processor Report => Processor Business Matrix<br></strong>";
								break;
						case 'superadmin_searhprocessormatrix':
							return	 $url ="<strong>Reports => Processor Report => Processor Business Matrix => Search Result<br></strong>";
							break;
						case 'superadmin_ticket':
								return $url ="<strong>Reports => Ticket<br></strong>";
								break;
						case 'superadmin_underWriting':
								return $url ="<strong>Reports => Under Writing<br></strong>";
								break;
						case 'superadmin_meritcardreport':
							return $url ="<strong>Reports => ChargeBack Report => Meritcart Chargeback Report<br></strong>";
							break;
						case 'superadmin_meritusreport':
							return $url ="<strong>Reports => ChargeBack Report => Meritus Chargeback Report<br></strong>";
							break;
						case 'superadmin_commissionreportsearch':
							return $url ="<strong>Report => Agent/Refferal/Iso Report => Commission Report => Commission Search Result<br></strong>";
							break;		
						case 'superadmin_selectedmonthreport':
							return $url ="<strong>Report => Merchant Processing Volume => Monthly Merchant Processing Volume => Search Result<br></strong>";
							break;
						  default :
							   break;
					}
			
				case 'News':
					switch($action)

					{
						  case 'superadmin_Announcement':
								return	 $url ="<strong>Admin => News & Announcement<br></strong>";
								break;
						  default :
							   break;
					}
				
				case 'Commissions':
					switch($action)
					{
						  case 'superadmin_commission':
								return	 $url ="<strong>Admin => Commission<br></strong>";
								break;
						  default :
							   break;
					}
				
				case 'EmailTemplates':
					switch($action)
						{
						  	case 'superadmin_createTemplate':
								return	 $url ="<strong>Admin => Email Template => Create<br> User => My Template => Create</strong>";
								break;								
							case 'superadmin_ajaxGetUser':
								return	 $url ="<strong>function to get all userlist using ajax</strong>";
								break;								
							case 'getTemplate':
								return	 $url ="<strong>function to get templates on ajax call</strong>";
								break;	
						  	case 'superadmin_index':
								return	 $url ="<strong>Admin => Email Template => View<br></strong>";
								break;
						  	case 'superadmin_editTemplate':
								return	 $url ="<strong>Admin => Email Template => Edit<br>User => My Template => Edit</strong>";
								break;
							case 'superadmin_delete':
								return	 $url ="<strong>Admin => Email Template =>Delete<br>User => My Template => Delete</strong>";
								break;
							case 'superadmin_templateView':
								return	 $url ="<strong>Admin => Email Template =>View<br>User => My Template => View</strong>";
								break;
							case 'superadmin_myTemplate':
								return	 $url ="<strong>User => My Template <br></strong>";
								break;
							case 'superadmin_userBlastEmail':
								return	 $url ="<strong>Admin => My User Blast Template <br></strong>";
								break;
							case 'superadmin_merchantBlastEmail':
								return	 $url ="<strong>Admin => My Merchant Blast Template <br></strong>";
								break;
							case 'superadmin_getuserbyrole':
								return	 $url ="<strong>Admin => Bulk Merchat User Aearch By Level <br></strong>";
								break;
						  	default :
							   	break;
					}
					
				case 'News':
					switch($action)
						{
						  case 'superadmin_newsList':
								return	 $url ="<strong>Admin => News => News List<br></strong>";
								break;
								
						  case 'superadmin_deleteNews':
								return	 $url ="<strong>Admin => News => Delete<br></strong>";
								break;
							
						 case 'superadmin_editNews':
								return	 $url ="<strong>Admin => News => Edit<br></strong>";
								break;
						 
						  case 'superadmin_addNews':
								return	 $url ="<strong>Admin => News => Add News<br></strong>";
								break;
								
						  default :
							   break;
					}
					
				case 'MassMerchantUpdates':
					switch($action)
					{
						case 'superadmin_merchantsearch':
							return	 $url ="<strong> Admin => Bulk Merchant Modification => Merchant Search<br></strong>";
							break;
						case 'superadmin_getuserbyajax':
							return	 $url ="<strong> Admin => Bulk Merchant Modification => Ajax User Search<br></strong>";
							break;
						case 'superadmin_approve':
							return	 $url ="<strong> Admin => Bulk Merchant Modification => Approve Data<br></strong>";
							break;
						case 'superadmin_rollback':
							return	 $url ="<strong> Admin => Bulk Merchant Modification => Rollback Merchant Data<br></strong>";
							break;								
						default :
							break;				
					}
				case 'Usercats':
					switch($action)
					{
						case 'superadmin_addusercat':
							return	 $url ="<strong> Admin => User Category => Add New Category<br></strong>";
							break;
						case 'superadmin_editusercat':
							return	 $url ="<strong> Admin => User Category => Edit Category<br></strong>";
							break;
						case 'superadmin_deleteusercat':
							return	 $url ="<strong> Admin => User Category => Delete Category <br></strong>";
							break;
						case 'superadmin_viewlist':
							return	 $url ="<strong> Admin => User Category => View Category<br></strong>";
							break;
						default :
							break;
					}

				default :
					 break;

			}

			return $url;

	}



	

	function Groupname($id)
		{
					APP::import('Model','UserGroup');
					$this->UserGroup = new UserGroup();
					$name=$this->UserGroup->find("first",array('fields'=>'name','conditions'=>'UserGroup.id="'.$id.'"')); 
					return $name['UserGroup']['name'];
		}

	function getAgentName($id)
		{
				APP::import('Model','User');
				$this->User = new User();
				$rec=$this->User->query("select users.user_Name from users,agentnotes where users.id=agentnotes.userID and agentnotes.agentNoteID='".$id."' limit 1"); 
				return $rec[0]['users']['user_Name'];
		}

	function getUserName($id)
		{
			APP::import('Model','User');
			$this->User = new User();
			$rec=$this->User->query("select users.user_Name from users where users.id='".$id."'"); 
			return $rec[0]['users']['user_Name'];
		}

	function getFolderList($userId,$userGroupId)  // folders naame list for dropdown
		{	
				APP::import('Model','Folder');
				$this->Folder = new Folder();
				
				
				return $this->Folder->find('list',array('fields'=>'Folder.id,Folder.title',
																'conditions'=>'Folder.user_group_id="'.$userGroupId.'" and Folder.user_id="'.$userId.'"','order'=>'Folder.title asc'));
				
					
		}
		
	function getFolders()  // folders naame list for navigation
		{	
				APP::import('Model','Folder');
				$this->Folder = new Folder();
					$name=$this->Folder->find('all',array('fields'=>'Folder.id,Folder.title'));
					
					pr($name);die;
		}
		
	function getFolderName($id)
		{	
				APP::import('Model','Folder');
				$this->Folder = new Folder();
				$name=$this->Folder->find('first',array('fields'=>'Folder.title','conditions'=>'Folder.id="'.$id.'"'));
				return	$name['Folder']['title'];
		}
	
	function getGroupList()
		{	
				APP::import('Model','UserGroup');
				$this->UserGroup = new UserGroup();
				return	$name=$this->UserGroup->find('list',array('fields'=>'UserGroup.id,UserGroup.name'));
		}

function getProcessorEmail($id)
		{	
			APP::import('Model','Usermgmt.User');
			$this->User = new User();
			$email=$this->User->find('first',array('fields'=>'User.userEmail','conditions'=>'User.id="'.$id.'"'));
			return $email['User']['userEmail'];
		}

		
		//get login user pipeline for dashboard
		function todayPipeline($statusID,$userID,$loginRole=null){
			$count = 0;
			$currDate = date("Y-m-d");
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count = $this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate'=>$currDate,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate'=>$currDate)));
			}
			return $count;
		}

		//function for get MTD Pipelines on dashboard
		function mtdPipeline($statusID,$userID,$loginRole=null){
			$count = 0;
			$startdayCurrMonth = date("Y-m-01");
			$tilldayCurrMonth = date("Y-m-d");
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startdayCurrMonth,'Merchantpipeline.statusToDate <='=>$tilldayCurrMonth,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startdayCurrMonth,'Merchantpipeline.statusToDate <='=>$tilldayCurrMonth)));
			}
			return $count;
		}	

		//function for get Last Month  Pipelines on dashboard
		function lastmonthPipeline($statusID,$userID,$loginRole=null){
			$count = 0;			
			/*$startdaylastMonth = date("Y-m-d", strtotime(date('m', mktime() - 31*3600*24).'/01/'.date('Y').' 00:00:00'));die;
			$enddaylastMonth = date("Y-m-31", mktime() - 31*3600*24);*/
			$startdaylastMonth = date("Y-m-01",strtotime("-1 month"));
			$enddaylastMonth = date("Y-m-31", strtotime("-1 month"));
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startdaylastMonth,'Merchantpipeline.statusToDate <='=>$enddaylastMonth,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startdaylastMonth,'Merchantpipeline.statusToDate <='=>$enddaylastMonth)));
			}
			return $count;
		}	

		//function for get YTD Pipelines on dashboard
		function ytdPipeline($statusID,$userID,$loginRole=null){
			$count = 0;
			$startytdCurrMonth = date("Y-01-01");
			//$tillytdCurrMonth = date("Y-m-31", strtotime("-2 month"));
			$tillytdCurrMonth = date("Y-m-d");
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth)));
			}
			return $count;
		}	

		//function for get Last Year Pipelines on dashboard
		function lastyearPipeline($statusID,$userID,$loginRole=null){
			$count = 0;
			$startlastyearDate = date("Y-01-01",strtotime("-1 year"));
			$tilllastyeatendDate = date("Y-12-31", strtotime("-1 year"));
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startlastyearDate,'Merchantpipeline.statusToDate <='=>$tilllastyeatendDate,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startlastyearDate,'Merchantpipeline.statusToDate <='=>$tilllastyeatendDate)));
			}
			return $count;
		}		

		//function for get LifeTime Pipelines on dashboard

		function lifetimePipeline($statusID=null,$userID=null,$loginRole=null){
			$count = 0;
			//$tilllifetimeDate = date("Y-12-31", strtotime("-2 year"));
			$tilllifetimeDate = date("Y-m-d");
			APP::import('Model','Merchant');
			$this->Merchant = new Merchant();
                        $this->Merchant->recursive = "-1";
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager' && strtolower($loginRole)!='support' && strtolower($loginRole)!='technical' && strtolower($loginRole)!='qa' && strtolower($loginRole)!='level 2 support'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count =$this->Merchant->find('count',array('fields' =>'DISTINCT Merchant.id','conditions'=>array('Merchant.statusID'=>$statusID,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager' || strtolower($loginRole)=='support' || strtolower($loginRole)=='technical' || strtolower($loginRole)=='qa' || strtolower($loginRole)=='level 2 support'){
				$count =$this->Merchant->find('count',array('fields' =>'DISTINCT Merchant.id','conditions'=>array('Merchant.statusID'=>$statusID)));
			}																		
			return $count;
			/** in elseif condition except admin and manager , all other condition are temporary in this system and will be removed in future ***/
		}	
                
                 function lifetimePipelineTest($userID=null,$loginRole=null){
			$count = 0;
			$tilllifetimeDate = date("Y-m-d");
			APP::import('Model','Merchant');
			$this->Merchant = new Merchant();
                        $this->Merchant->recursive = "-1";
                        if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager' && strtolower($loginRole)!='support' && strtolower($loginRole)!='technical' && strtolower($loginRole)!='qa' && strtolower($loginRole)!='level 2 support'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count = $this->Merchant->find('all',array('fields'=>array('count(Merchant.statusID) as count','Merchant.statusID'),'conditions'=>array('Merchant.statusID IN (1,2,3,4,9)',$condField=>$userID),'group'=>'Merchant.statusID'));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager' || strtolower($loginRole)=='support' || strtolower($loginRole)=='technical' || strtolower($loginRole)=='qa' || strtolower($loginRole)=='level 2 support'){
				$count = $this->Merchant->find('all',array('fields'=>array('count(Merchant.statusID) as count','Merchant.statusID'),'conditions'=>array('Merchant.statusID IN (1,2,3,4,9)'),'group'=>'Merchant.statusID'));
			}                        
			return $count;
			/** in elseif condition except admin and manager , all other condition are temporary in this system and will be removed in future ***/
		}
		

		

		/**

		 *  Signature to Image: A supplemental script for Signature Pad that

		 *  generates an image of the signature�s JSON output server-side using PHP.

		 *

		 *  @project ca.thomasjbradley.applications.signaturetoimage

		 *  @author Thomas J Bradley <hey@thomasjbradley.ca>

		 *  @link http://thomasjbradley.ca/lab/signature-to-image

		 *  @link http://github.com/thomasjbradley/signature-to-image

		 *  @copyright Copyright MMXI�, Thomas J Bradley

		 *  @license New BSD License

		 *  @version 1.1.0

		 */

		

		/**

		 *  Accepts a signature created by signature pad in Json format

		 *  Converts it to an image resource

		 *  The image resource can then be changed into png, jpg whatever PHP GD supports

		 *

		 *  To create a nicely anti-aliased graphic the signature is drawn 12 times it's original size then shrunken

		 *

		 *  @param string|array $json

		 *  @param array $options OPTIONAL; the options for image creation

		 *    imageSize => array(width, height)

		 *    bgColour => array(red, green, blue) | transparent

		 *    penWidth => int

		 *    penColour => array(red, green, blue)

		 *    drawMultiplier => int

		 *

		 *  @return object

		 */

		function sigJsonToImage ($json, $options = array()) {

		  $defaultOptions = array(
			'bgColour' => array(0xff, 0xff, 0xff)
			,'penWidth' => 2
			,'penColour' => array(0x14, 0x53, 0x94)
			,'drawMultiplier'=> 12
		  );
		  
		  $options = array_merge($defaultOptions, $options);
		  $img = imagecreatetruecolor($options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][1] * $options['drawMultiplier']);

		  if ($options['bgColour'] == 'transparent') {
			imagesavealpha($img, true);
			$bg = imagecolorallocatealpha($img, 0, 0, 0, 127);
		  } else {
			$bg = imagecolorallocate($img, $options['bgColour'][0], $options['bgColour'][1], $options['bgColour'][2]);
		  }
		  
		  $pen = imagecolorallocate($img, $options['penColour'][0], $options['penColour'][1], $options['penColour'][2]);
		  imagefill($img, 0, 0, $bg);
		  
		  if (is_string($json))
			$json = json_decode(stripslashes($json));		

		  foreach ($json as $v)
			$this->drawThickLine($img, $v->lx * $options['drawMultiplier'], $v->ly * $options['drawMultiplier'], $v->mx * $options['drawMultiplier'], $v->my * $options['drawMultiplier'], $pen, $options['penWidth'] * ($options['drawMultiplier'] / 2));

		  $imgDest = imagecreatetruecolor($options['imageSize'][0], $options['imageSize'][1]);
		  
		  if ($options['bgColour'] == 'transparent') {
			imagealphablending($imgDest, false);
			imagesavealpha($imgDest, true);
		  }
		  
		  imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $options['imageSize'][0], $options['imageSize'][0], $options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][0] * $options['drawMultiplier']);
		  imagedestroy($img);
		  
		  return $imgDest;
		  
		}

		

		/**

		 *  Draws a thick line

		 *  Changing the thickness of a line using imagesetthickness doesn't produce as nice of result

		 *

		 *  @param object $img

		 *  @param int $startX

		 *  @param int $startY

		 *  @param int $endX

		 *  @param int $endY

		 *  @param object $colour

		 *  @param int $thickness

		 *

		 *  @return void

		 */

		function drawThickLine ($img, $startX, $startY, $endX, $endY, $colour, $thickness) {

		  $angle = (atan2(($startY - $endY), ($endX - $startX)));

		

		  $dist_x = $thickness * (sin($angle));

		  $dist_y = $thickness * (cos($angle));

		

		  $p1x = ceil(($startX + $dist_x));

		  $p1y = ceil(($startY + $dist_y));

		  $p2x = ceil(($endX + $dist_x));

		  $p2y = ceil(($endY + $dist_y));

		  $p3x = ceil(($endX - $dist_x));

		  $p3y = ceil(($endY - $dist_y));

		  $p4x = ceil(($startX - $dist_x));

		  $p4y = ceil(($startY - $dist_y));

		

		  $array = array(0=>$p1x, $p1y, $p2x, $p2y, $p3x, $p3y, $p4x, $p4y);

		  imagefilledpolygon($img, $array, (count($array)/2), $colour);

		}



		

		#===============  Gatwayname =======================

		function getGatewayName($id)

		{	

				APP::import('Model','Gateway');

				$this->Gateway = new Gateway();

				$name=$this->Gateway->find('first',array('fields'=>'Gateway.gatewayName','conditions'=>'Gateway.id="'.$id.'"'));

				return $name['Gateway']['gatewayName'];

		}

		#===============  End =======================

		

		#===============  Account Category =======================

		function getAccountCatName($id)

		{	

				APP::import('Model','Accountcat');

				$this->Accountcat = new Accountcat();

				$name=$this->Accountcat->find('first',array('fields'=>'Accountcat.accountCategory','conditions'=>'Accountcat.id="'.$id.'"'));

				return $name['Accountcat']['accountCategory'];

		}

		#===============  End =======================

		

		

		#===============  Account Category =======================

		function getAccountType($id)

		{	

				APP::import('Model','Accounttype');

				$this->Accounttype = new Accounttype();

				$name=$this->Accounttype->find('first',array('fields'=>'Accounttype.accountType','conditions'=>'Accounttype.id="'.$id.'"'));

				return $name['Accounttype']['accountType'];

		}

		#===============  End =======================
		#===============  Business Category =======================
		
		function getBusinessCategory($id=null)		
		{
			
			APP::import('Model','Businesscat');		
			$this->Businesscat = new Businesscat();		
			$Businesscat=$this->Businesscat->find('first',array('conditions'=>array('Businesscat.id'=>$id)));
			//var_dump($Businesscat);die;
			return $Businesscat['Businesscat']['category_name'];		
		}
		
		

		

	#===============  Account Category =======================
		function getReferalUser($id)
		{	
				APP::import('Model','User');
				$this->User = new User();
				$name=$this->User->find('first',array('fields'=>'User.user_Name','conditions'=>'User.id="'.$id.'"'));
				return $name['User']['user_Name'];
		}
		#===============  End =======================
		
		#===============  Account Category =======================
		function getUserInformation($id)
		{	
				APP::import('Model','User');
				$this->User = new User();
				$UserInfo=$this->User->find('first',array('fields'=>'User.id,User.user_Name,User.userPhone,User.userEmail,User.userCompany,User.userAddress','conditions'=>'User.id="'.$id.'"','recursive'=>-1));
				return $UserInfo;
		}
		#===============  End =======================
	
		
		function getAdminTemplateTitle($id) //get admin template title
		{	
				APP::import('Model','EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
				return $this->EmailTemplate->find('list',array('fields'=>'EmailTemplate.id,EmailTemplate.title',
																'conditions'=>'EmailTemplate.user_group_id="1" and EmailTemplate.user_id!="'.$id.'"'));
		}
		
		function getUserTemplateTitle($id,$roleId) //get admin template title
		{	
				APP::import('Model','EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
				return $this->EmailTemplate->find('list',array('fields'=>'EmailTemplate.id,EmailTemplate.title',
																'conditions'=>'EmailTemplate.user_id="'.$id.'" and EmailTemplate.user_group_id="'.$roleId.'"'));
		}
		
		function getTemplatelist($userId,$groupId) //get admin template title
		{	
				APP::import('Model','EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
				
				$usrTmp=$this->EmailTemplate->find('list',array('fields'=>'EmailTemplate.id,EmailTemplate.title',
																'conditions'=>'EmailTemplate.user_group_id="'.$groupId.'" and EmailTemplate.user_id="'.$userId.'"'));
				if($roleId!='1')
				{
						$adminTmp=$this->EmailTemplate->find('list',array('fields'=>'EmailTemplate.id,EmailTemplate.title',
																'conditions'=>'EmailTemplate.user_group_id="1"'));
				}else
				{
						$adminTmp=$this->EmailTemplate->find('list',array('fields'=>'EmailTemplate.id,EmailTemplate.title',
																'conditions'=>'EmailTemplate.user_group_id="1" and EmailTemplate.user_id!="'.$userId.'"'));
				}
				
				$tmp=$usrTmp + $adminTmp;
				
				
				return	$tmp;
				
		}
		
		
		

		/************* Get Token type string of some private information *********/

		function getToken($privateStr)

		{		

				if($privateStr!=''){

					$strSuffix = '';

					$strlen = strlen($privateStr);

					for($i=1;$i<=($strlen-4);$i++){

						$strSuffix .= 'X';

					}

					return $tokenStr = $strSuffix."".substr($privateStr,-4);	

				}else{

					return $privateStr;

				}			
		}

		/**** Get Lead application for month for dashboard graph ***/
		function getLeadApplicationByMonth($monthNumber=null,$year=null,$userID=null,$loginRole=null){
			$count = 0;
			$appMonthStartDate = $year."-".$monthNumber."-01";
			$appMonthEndDate = $year."-".$monthNumber."-31";
				
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count = $this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array("Merchantpipeline.statusTo" =>1,"Merchantpipeline.statusFrom"=>0,"Merchantpipeline.statusToDate>='".$appMonthStartDate."'","Merchantpipeline.statusToDate<='".$appMonthEndDate."'",$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array("Merchantpipeline.statusTo" =>1,"Merchantpipeline.statusFrom"=>0,"Merchantpipeline.statusToDate>='".$appMonthStartDate."'","Merchantpipeline.statusToDate<='".$appMonthEndDate."'")));
			}
			return $count;
		}	

		//function for get LifeTime Pipelines Volume on dashboard Graph		
		function lifetimePipelineVolume($statusID=null,$userID=null,$loginRole=null){
			$count = 0;
			//$tilllifetimeDate = date("Y-12-31", strtotime("-2 year"));
			$tilllifetimeDate = date("Y-m-d");
			APP::import('Model','Merchant');
			$this->Merchant = new Merchant();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$getVolume = $this->Merchant->find('first',array('fields' =>'SUM(Merchant.volume) as volume','conditions'=>array('Merchant.statusID'=>$statusID,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$getVolume = $this->Merchant->find('first',array('fields' =>'SUM(Merchant.volume) as volume','conditions'=>array('Merchant.statusID'=>$statusID)));
			}
			
			return $getVolume[0]['volume'];	
			
		}
                
                function lifetimePipelineVolumeTest($statusID=null,$userID=null,$loginRole=null){
			$count = 0;
			//$tilllifetimeDate = date("Y-12-31", strtotime("-2 year"));
			$tilllifetimeDate = date("Y-m-d");
			APP::import('Model','Merchant');
			$this->Merchant = new Merchant();
                        $this->Merchant->recursive = "-1";
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
                                $getVolume = $this->Merchant->find('all',array('fields'=>array('SUM(Merchant.volume) as volume','Merchant.statusID'),'conditions'=>array('Merchant.statusID IN (1,2,3,4,9,5)',$condField=>$userID),'group'=>'Merchant.statusID'));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$getVolume = $this->Merchant->find('all',array('fields'=>array('SUM(Merchant.volume) as volume','Merchant.statusID'),'conditions'=>array('Merchant.statusID IN (1,2,3,4,9,5)'),'group'=>'Merchant.statusID'));
			}
			return $getVolume;	
			
		}
                
               
		
		//function for get YTD Pipelines Volume on dashboard Graph 5	
		function ytdPipelineVolume($statusID,$userID,$loginRole=null){
			$count = 0;
			$startytdCurrMonth = date("Y-01-01");
			$tillytdCurrMonth = date("Y-m-d");
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$getVolume =$this->Merchantpipeline->find('first',array('fields' =>'SUM(Merchant.volume) as volume','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$getVolume =$this->Merchantpipeline->find('first',array('fields' =>'SUM(Merchant.volume) as volume','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth)));
			}
			return $getVolume[0]['volume'];
		}
		
                function ytdPipelineVolumeTest($statusID,$userID,$loginRole=null){
			$count = 0;
			$startytdCurrMonth = date("Y-01-01");
			$tillytdCurrMonth = date("Y-m-d");
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$getVolume =$this->Merchantpipeline->find('first',array('fields' =>'SUM(Merchant.volume) as volume','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$getVolume =$this->Merchantpipeline->find('first',array('fields' =>'SUM(Merchant.volume) as volume','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth)));
			}
                        $getVolume = $this->Merchantpipeline->find('all',array('fields'=>array('count(Merchant.volume) as volume','Merchantpipeline.statusTo'),'conditions'=>array('Merchantpipeline.statusTo IN (1,2,3,4,9,5)'),'group'=>'Merchantpipeline.statusTo','Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth));
			return $getVolume;
		}

                
		/*** function for closed merchant meter graph ****/
		function getClosedApplication($userID=null,$loginRole=null){
			$count = 0;
			//$tilllifetimeDate = date("Y-12-31", strtotime("-2 year"));
			$tilllifetimeDate = date("Y-m-d");
			APP::import('Model','Merchant');
			$this->Merchant = new Merchant();
                        $this->Merchant->recursive = "-1";
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count = $this->Merchant->find('count',array('fields' =>'DISTINCT Merchant.id','conditions'=>array('Merchant.statusID'=>19,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$count = $this->Merchant->find('count',array('fields' =>'DISTINCT Merchant.id','conditions'=>array('Merchant.statusID'=>19)));
			}
			
			return $count;
			//return "5";
			
		}
		
		/*** function for get processing YTD Merchant for meter graph ****/
		function getProcessingYTDApplication($userID=null,$loginRole=null){
			$count = 0;
			$statusID = "5"; // processing
			$startytdCurrMonth = date("Y-01-01");
			//$tillytdCurrMonth = date("Y-m-31", strtotime("-2 month"));
			$tillytdCurrMonth = date("Y-m-d");
			APP::import('Model','Merchantpipeline');
			$this->Merchantpipeline = new Merchantpipeline();
			if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
				$condField = 'Merchant.'.strtolower($loginRole)."ID";
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth,$condField=>$userID)));
			}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
				$count =$this->Merchantpipeline->find('count',array('fields' =>'DISTINCT Merchantpipeline.merchantID','conditions'=>array('Merchantpipeline.statusTo' =>$statusID,'Merchant.statusID'=>$statusID,'Merchantpipeline.statusToDate >='=>$startytdCurrMonth,'Merchantpipeline.statusToDate <='=>$tillytdCurrMonth)));
			}
			return $count;
		
		}
		
		/**** Get total amount by month in reports ***/
		function getTotal($monthNumber=null,$year=null,$index=null){
			
			$StartDate = $year."-".$monthNumber."-01";
			$EndDate = $year."-".$monthNumber."-31";
			
			APP::import('Model','Merchant');
			$this->Merchant = new Merchant();

			if($index=='1'){
				$column = "agentSetUpFee";
			}elseif($index=='2'){
				$column = "setupfee";
			}elseif($index=='3'){
				$column = "isoFee";
			}elseif($index=='4'){
				$column = "managersetupfee";
			}else{
				$column = "setupfee";
			}
			//echo $column;die;
			$condition = "Merchant.setupFeePaidDate>='".$StartDate."' AND Merchant.setupFeePaidDate<='".$EndDate."'";
			$result = $this->Merchant->find('first',array('fields'=>array('sum(Merchant.'.$column.') as setupfee'),'conditions'=>array($condition)));
			//pr($result);die;
			return $result[0]['setupfee'];
			
		}
		
		function getMonthName($monthNumber=null){
			//echo $monthNumber;
			switch($monthNumber){
				case 1:
					return "January";
					break;
				case 2:
					return "February";
					break;
				case 3:
					return "March";
					break;
				case 4:
					return "April";
					break;
				case 5:
					return "May";
					break;
				case 6:
					return "June";
					break;
				case 7:
					return "July";
					break;
				case 8:
					return "August";
					break;
				case 9:
					return "September";
					break;
				case 10:
					return "October";
					break;
				case 11:
					return "November";
					break;
				case 12:
					return "December";
					break;
				
			}
			
		}
		
	function getProcessorBusinessType($processorID=null,$accTypeID=null){
		APP::import('Model','Businesstypeprocessorlink');
		$this->Businesstypeprocessorlink = new Businesstypeprocessorlink();
		
		$resultCount = $this->Businesstypeprocessorlink->find('count', array('conditions' => array('Businesstypeprocessorlink.user_id' => $processorID, 'Businesstypeprocessorlink.businessTypeID' => $accTypeID )));
		
		if($resultCount>0){
			return "X";
		}else{
			return "&nbsp;";
		}		
		
	}		

	function getIsoStatusVolume($agentId, $statusId, $index){
		APP::import('Model','Merchant');
		$this->Merchant = new Merchant();
		$result = $this->Merchant->find('all', array('fields' => array('Merchant.volume'),  'conditions' => array('Merchant.statusID' => $statusId, 'Merchant.isoID' => $agentId ), 'recursive' => -1));
		
		if($index == 0){
			$temp = 0;
			if(count($result)){
				foreach ($result as $key){
					$temp += $key['Merchant']['volume'];
				}
			}
			return $temp;
		}
		else{
			return count($result);
		}
	}		
	
	function getProcessorVolume($agentId, $statusId, $index){
		APP::import('Model','Merchant');
		$this->Merchant = new Merchant();
		$result = $this->Merchant->find('all', array('fields' => array('Merchant.volume'),  'conditions' => array('Merchant.statusID' => $statusId, 'Merchant.processorID' => $agentId ), 'recursive' => -1));
	
		if($index == 0){
			$temp = 0;
			if(count($result)){
				foreach ($result as $key){
					$temp += $key['Merchant']['volume'];
				}
			}
			return $temp;
		}
		else{
			return count($result);
		}
	}
	
	function getAgentVolume($agentId, $statusId, $index){
		APP::import('Model','Merchant');
		$this->Merchant = new Merchant();
		$result = $this->Merchant->find('all', array('fields' => array('Merchant.volume'),  'conditions' => array('Merchant.statusID' => $statusId, 'Merchant.agentID' => $agentId ), 'recursive' => -1));
	
		if($index == 0){
			$temp = 0;
			if(count($result)){
				foreach ($result as $key){
					$temp += $key['Merchant']['volume'];
				}
			}
			return $temp;
		}
		else{
			return count($result);
		}
	}
	
	function getReferralVolume($referralId, $statusId, $index){
		APP::import('Model','Merchant');
		$this->Merchant = new Merchant();
		$result = $this->Merchant->find('all', array('fields' => array('Merchant.statusID','count(Merchant.statusID) as count'),  'conditions' => array('Merchant.statusID IN (2,3,4,5,9)',  'Merchant.referalID' => $referralId ),'group'=>'Merchant.statusID', 'recursive' => -1));
		if($index == 0){
			$temp = 0;
			if(count($result)){
				foreach ($result as $key){
					$temp += $key['Merchant']['volume'];
				}
			}
			return $temp;
		}
		else{
			return $result;
		}
	}
	
	
	function getProcessorSetupFee($agentId, $statusId){
		APP::import('Model','Merchant');
		$this->Merchant = new Merchant();
		$result = $this->Merchant->find('all', array('fields' => array('Merchant.setupfee'),  'conditions' => array('Merchant.statusID' => $statusId, 'setupfeepaid' => 0, 'Merchant.processorID' => $agentId ), 'recursive' => -1));
	
		$temp = 0;
		if(count($result)){
			foreach ($result as $key){
				$temp += $key['Merchant']['setupfee'];
			}
		}
		return $temp;
	}
	
	function getManagerVolume($agentId, $statusId, $index){
		APP::import('Model','Merchant');
		$this->Merchant = new Merchant();
		$result = $this->Merchant->find('all', array('fields' => array('Merchant.volume'),  'conditions' => array('Merchant.statusID' => $statusId, 'Merchant.managerID' => $agentId ), 'recursive' => -1));
	
		if($index == 0){
			$temp = 0;
			if(count($result)){
				foreach ($result as $key){
					$temp += $key['Merchant']['volume'];
				}
			}
			return $temp;
		}
		else{
			return count($result);
		}
	}
	
	function getManagerAmountProcessed($agentId, $statusId, $index){
		APP::import('Model','Commission');
		$this->Commission = new Commission();
		$result = $this->Commission->find('all', array('conditions' => array('Merchant.statusID' => $statusId, 'Merchant.managerID' => $agentId)));
		if($index == 0){
			$temp = 0;
			if(count($result)){
				foreach ($result as $key){
					$temp += $key['Commission']['amount_processed'];
				}
			}
			return $temp;
		}
		else{
			return count($result);
		}
	}
	
	// check whether user is agent or not
	function isRoleAgent($userID = null){
		App::import("Model", "Usermgmt.UserGroupJoin");
		$this->UserGroupJoin = new UserGroupJoin;
		$count = $this->UserGroupJoin->find("count", array('conditions'=>array('UserGroupJoin.user_group_id'=>20,'UserGroupJoin.user_id'=>$userID)));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
	
	// get user role
	function getUserRole($userID = null){
		App::import("Model", "Usermgmt.UserGroupJoin");
		$this->UserGroupJoin = new UserGroupJoin;
		$userRole = $this->UserGroupJoin->find("all", array('conditions'=>array('UserGroupJoin.user_group_id>0','UserGroupJoin.user_id'=>$userID),'order'=>array('UserGroupJoin.user_group_id ASC')));
		return $userRole;
	}
	
	// get merchant name by MID
	function getMerchantNameByMID($mid = null){
		App::import("Model", "Merchant");
		$this->Merchant = new Merchant;
		$merchantInfo = $this->Merchant->find('first',array('fields'=>array('Merchant.id','Merchant.merchantName'),'conditions'=>array('Merchant.CID' => $mid)));		
		if(count($merchantInfo)>=1){
			return $merchantInfo;
		}else{
			return "";
		}
	}
	
	// get merchant/user information for print address by id
	function getUserNameAddress($userID = null,$userType=null){
		App::import("Model", "Merchant");
		$this->Merchant = new Merchant;
		
		App::import("Model", "Usermgmt.User");
		$this->User = new User;
		/*** get merchant information **/
		if($userType=='merchant'){
			$merchantInfo = $this->Merchant->find('first',array('fields'=>array('Merchant.merchantName','Merchant.legalAddress','Merchant.legalCity','Merchant.legalState','Merchant.legalZip'),'conditions'=>array('Merchant.id' => $userID)));
			return $merchantInfo;
		}
		/*** get user information **/
		if($userType=='referral' || $userType=='agent'){
			$this->User->recursive = 0;
			$merchantInfo = $this->User->find('first',array('fields'=>array('User.user_Name','User.userAddress','User.userAddress2','User.userCity','User.userState','User.userZip','User.userCountry'),'conditions'=>array('User.id' => $userID)));
			return $merchantInfo;
		}
	}
	
	// get Ticket id submit by user
	function getTicketSubmitByUser($userID = null,$userRoleID = null){
		App::import("Model", "Support");
		$this->Support = new Support;
		$condition = "";
		
		/** show ticket of agent(20),ISo(22),manager(),processor or referral(25) **/
		if($userRoleID=='20' || $userRoleID =='22' || $userRoleID =='23' || $userRoleID =='24' || $userRoleID =='25'){
			$condition = "Support.create_user_id=".$userID." AND Support.user_role_id=".$userRoleID;
		}else{
			$condition = "Support.create_user_id > 0";
		}
		
		
		$tickets = $this->Support->find('all',array('conditions'=>$condition));
		$ticketIDs = array();
		foreach($tickets as $ticket){
			$ticketIDs[] = $ticket['Support']['id'];
		}

		return $ticketIDs;
		
	}
	// function to get zendesk ticket status name
	function getZendeskStatusName($statusID=null){
		if($statusID==1)
			$status = 'Open';
		elseif($statusID==2)
			$status = 'Pending';
		elseif($statusID==3)
			$status = 'Solved';
		elseif($statusID==4)
			$status = 'Closed';
		else
			$status = 'New';
		
		return $status;		
	}
	
	// function to get zendesk ticket type
	function getZendeskTicketType($typeID=null){
		if($typeID==1)
			$type = 'Question';
		elseif($typeID==2)
			$type = 'Incident';
		elseif($typeID==3)
			$type = 'Problem';
		elseif($typeID==4)
			$type = 'Task';
		else
			$type = 'No Type Set';
	
		return $type;
	}
	
	// function to get zendesk ticket type
	function getStatusImage($statusID=null){
		if($statusID=='open')
			$image = 'icons/red_square.png';
		elseif($statusID=='pending')
			$image = 'icons/pending_square.png';
		elseif($statusID=='solved')
			$image = 'icons/gray_square.png';
		else
			$image = '';
		
		return $image;		
	}
	
	// function to get zendesk User Information
	function getZendeskUserInfo($userID=null){
		/*$zd = new Zendesk(ZENDESK_ACCOUNTNAME, ZENDESK_USERNAME, ZENDESK_PASSWORD);		
		// switch to JSON
		$zd->set_output(ZENDESK_OUTPUT_JSON);
		$result_user = $zd->get(ZENDESK_USERS, array('id' => $userID));				
		$zendusers = json_decode($result_user,true);	*/	
 
		   $url = "https://totalapps.zendesk.com/api/v2/users/{$userID}.json";
		 
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		   curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		   curl_setopt($ch, CURLOPT_URL, $url);
		   curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME.":".ZENDESK_PASSWORD);    
		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		   curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
		   $output = curl_exec($ch);
		   curl_close($ch);
		   $zendusers = json_decode($output,true); 
		   //echo '<pre>';print_r($zendusers);die;
		   return $zendusers[user];
	}
	
	function getZendeskUserInfoMojopay($userID=null){
		/*$zd = new Zendesk(ZENDESK_ACCOUNTNAME, ZENDESK_USERNAME, ZENDESK_PASSWORD);		
		// switch to JSON
		$zd->set_output(ZENDESK_OUTPUT_JSON);
		$result_user = $zd->get(ZENDESK_USERS, array('id' => $userID));				
		$zendusers = json_decode($result_user,true);	*/	
 
		   $url = "https://mojopay.zendesk.com/api/v2/users/{$userID}.json";
		 
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		   curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		   curl_setopt($ch, CURLOPT_URL, $url);
		   curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME_MP.":".ZENDESK_PASSWORD_MP);    
		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		   curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
		   $output = curl_exec($ch);
		   curl_close($ch);
		   $zendusers = json_decode($output,true); 
		   //echo '<pre>';print_r($zendusers);die;
		   return $zendusers[user];
	}
	// function to get zendesk Group Information
	function getZendeskGroupInfo($groupID=null){
		/*$zd = new Zendesk(ZENDESK_ACCOUNTNAME, ZENDESK_USERNAME, ZENDESK_PASSWORD);
		// switch to JSON
		$zd->set_output(ZENDESK_OUTPUT_JSON);
		$result_group = $zd->get(ZENDESK_GROUPS, array('id' => $groupID));
		$zendgroups = json_decode($result_group,true);*/
		   $url = "https://totalapps.zendesk.com/api/v2/groups/{$groupID}.json";
		 
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		   curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		   curl_setopt($ch, CURLOPT_URL, $url);
		   curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME.":".ZENDESK_PASSWORD);    
		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		   curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
		   $output = curl_exec($ch);
		   curl_close($ch);
		   $zendgroups = json_decode($output,true); 
		   //echo '<pre>';print_r($zendgroups);die;
		
		return $zendgroups['group']['name'];
	}
	
	// function to get birthday email template for merchant
	function getBirthdayEmailTemplate($templateID=null){
		App::import("Model", "EmailTemplate");
		$this->EmailTemplate = new EmailTemplate;
		$template = $this->EmailTemplate->find("first", array('conditions'=>array('EmailTemplate.id'=>$templateID)));
		
		return nl2br($template['EmailTemplate']['message']);
	}
	
	function getAccontTypeLst($templateID=null){
		
		App::import("Model", "Accounttype");
		$this->Accounttype = new Accounttype;
 	   return $ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		
	}
	
	function isProcessor($userId=null)
	{
		
		App::import("Model", "UserGroupJoin");
		$this->UserGroupJoin = new UserGroupJoin;
		return $this->UserGroupJoin->find('count',array('conditions'=>'UserGroupJoin.user_id="'.$userId.'" and UserGroupJoin.user_group_id="23"'));
	}
	
	function icalender($date = null,$subject = null,$desc = null)
	 { 
		
	  
	 }
	 
	 // function to get processor business matrix
	 function getProcessorMatrix($business_type_id=null,$processor_id=null){
	 	App::import("Model", "Businesstypeprocessorlink");
		$this->Businesstypeprocessorlink = new Businesstypeprocessorlink();
		
		$count = $this->Businesstypeprocessorlink->find('count',array('conditions'=>array('Businesstypeprocessorlink.user_id'=>$processor_id,'Businesstypeprocessorlink.businessTypeID'=>$business_type_id)));
		if($count>0){
			return "Yes";
		}else{
			return "No";
		}
	 }
	 
	 //function to display the total comission for this person under this month
	 function getUserCommissionByMonth($userID=null,$monthtime=null){
	 	
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'))
	 	);
	 	$allmerchantTotal = array();
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			)
	 	);
	 	// search parameters	 	
	 	$month = date('m',$monthtime);
	 	$condition .= " AND MONTH(Commissionlog.date)=".$month;
	 	$year = date('Y',$monthtime);
	 	$condition .= " AND YEAR(Commissionlog.date)=".$year;
	 	
	 	$condition .= " AND (Merchant.agentID  IN (".implode(",",$userID).") OR Merchant.isoID IN (".implode(",",$userID).") OR Merchant.referalID IN (".implode(",",$userID)."))";
	 	//echo $condition;die;
	 	$options['conditions'] = array($condition);
	 	$options['order'] = array('Merchant.id DESC');
	 	// task id 2060	 	
	 	$options['fields'] = array('distinct(Merchant.id),MONTH(Commissionlog.date) as month,Merchant.agentID,Merchant.referalID,Merchant.isoID,Commissionlog.*');
	 	$options['group'] = array('Merchant.id');
	 	
	 	$all_merchant = $this->Merchant->find('all', $options);      
	 	
                //pr($all_merchant);
	 	if(count($all_merchant)==0){
	 		 $allmerchantTotal = 0;
	 	}else{
	 		//pr($all_merchant);
	 		foreach($all_merchant as $merchant){ 
	 			if($merchant['Commissionlog']['iso_commission']!=0.00){
                    $allmerchantTotal[$merchant['Merchant']['isoID']][] = $merchant['Commissionlog']['iso_commission'];
                }
	 			if($merchant['Commissionlog']['referral_commission']!=0.00){
                    $allmerchantTotal[$merchant['Merchant']['referalID']][]  = $merchant['Commissionlog']['referral_commission'];
                }
	 			if($merchant['Commissionlog']['agent_commission']!=0.00){
                    $allmerchantTotal[$merchant['Merchant']['agentID']][] = $merchant['Commissionlog']['agent_commission'];
                }		
	 		}
	 		
	 		foreach($allmerchantTotal as $userid => $commission_array){
	 			$allmerchantTotal[$monthtime][$userid] = array_sum($commission_array);
	 		}
	 		
	 	}     
	 	return $allmerchantTotal;
	 }
	 
	 //function to display the total comission for this person under this month
	 function getUserCommissionBySearch($userID=null,$month=null,$year=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'))
	 	);
	 	
	 	$allmerchantTotal = 0;
	 	$total_agent_commission = 0;
	 	$total_referral_commission = 0;
	 	$total_iso_commission = 0;
	 	$total_active_account = 0;
	 	
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			)
	 	);
	 	// search parameters
	 	$condition .= " AND MONTH(Commissionlog.date)=".$month." AND YEAR(Commissionlog.date)=".$year;
	 	$condition .= " AND (Merchant.agentID=".$userID." OR Merchant.isoID=".$userID." OR Merchant.referalID=".$userID.")";
	 	//echo $condition;die;
	 	$options['conditions'] = array($condition);
	 	$options['order'] = array('Merchant.id DESC');
	 	// task id 2060 
	 	$options['fields'] = array('Merchant.id,Merchant.agentID,Merchant.referalID,Merchant.isoID,Commissionlog.*');
	 	$options['group'] = array('Merchant.id');	 	 
	 	$all_merchant = $this->Merchant->find('all', $options);
	 	
	 	if(count($all_merchant)==0){
	 		return $record = array(0,0,0,0,0);
	 	}else{
	 		foreach($all_merchant as $merchant){
	 			if($merchant['Merchant']['agentID']==$userID)
	 				$total_agent_commission += $merchant['Commissionlog']['agent_commission'];
	 			if($merchant['Merchant']['referalID']==$userID)
	 				$total_referral_commission += $merchant['Commissionlog']['referral_commission'];
	 			if($merchant['Merchant']['isoID']==$userID)
	 				$total_iso_commission += $merchant['Commissionlog']['iso_commission']; 	
	 					
	 			$allmerchantTotal = $total_agent_commission + $total_referral_commission + $total_iso_commission;
	 		}
	 		$total_active_account = count($all_merchant);
	 		return $record = array($total_active_account,$total_agent_commission,$total_referral_commission,$total_iso_commission,$allmerchantTotal);
	 	}
	 }
	 
	 //function to display agents which have had commissions in past six months.
	 function getAgentByCommission($userID=null,$month=null,$year=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'),
					  'belongsTo'=>array('Manager','Status','ProcessingMethod','Processor','Commission','ISO','Referal','Status','Agent'),
					  'hasOne' => array('Commission')
					)
	 	);
	 	
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			),
				array('table' => 'user_group_joins',
	 					'alias' => 'usergroupjoin',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.agentID = usergroupjoin.user_id',
	 					)
	 			),
				array('table' => 'users',
	 					'alias' => 'users',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'usergroupjoin.user_id = users.id',
	 					)
	 			)
	 	);
	 	// search parameters
		//date
 		$current_time = time();
		$prevsixMonthTime = strtotime(date('Y-m')." -8 month");
		$current_date = date("Y-m-d",$current_time);
		$prevsixmonth_date = date("Y-m-d",$prevsixMonthTime);
		
	 	$condition .= " AND Commissionlog.date between '".$prevsixmonth_date."' and '".$current_date ."'";
	 	$condition .= " AND usergroupjoin.user_group_id = 20";
	 	$condition .= " AND Commissionlog.agent_commission !=0";
		
	 	$options['conditions'] = array($condition);
	 	$options['fields'] = array('DISTINCT users.user_Name as agent_name','users.id as agent_id');
		$options['order'] = array('Merchant.id DESC');
		
	 	$all_merchant = $this->Merchant->find('all', $options);
		$result = array();
	 	if(count($all_merchant)==0){
	 		return $result;
	 	}else{
	 		foreach($all_merchant as $merchant){
				$result[$merchant['users']['agent_id']] = $merchant['users']['agent_name'];
	 		}
			return $result;
	 	}
	 }
	 
	//function to display Referal which have had commissions in past six months.
	 function getReferalByCommission($userID=null,$month=null,$year=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'),
					  'belongsTo'=>array('Manager','Status','ProcessingMethod','Processor','Commission','ISO','Referal','Status','Agent'),
					  'hasOne' => array('Commission')
					)
	 	);
	 	
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			),
				array('table' => 'user_group_joins',
	 					'alias' => 'usergroupjoin',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.referalID = usergroupjoin.user_id',
	 					)
	 			),
				array('table' => 'users',
	 					'alias' => 'users',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'usergroupjoin.user_id = users.id',
	 					)
	 			)
	 	);
	 	// search parameters
		
		//date
 		$current_time = time();
		$prevsixMonthTime = strtotime(date('Y-m')." -8 month");
		$current_date = date("Y-m-d",$current_time);
		$prevsixmonth_date = date("Y-m-d",$prevsixMonthTime);
		
	 	$condition .= " AND Commissionlog.date between '".$prevsixmonth_date."' and '".$current_date ."'";
	 	$condition .= " AND usergroupjoin.user_group_id = 25";
	 	$condition .= " AND Commissionlog.referral_commission !=0";

	 	$options['conditions'] = array($condition);
	 	// task id 2060
	 	$options['order'] = array('Merchant.id DESC');
	 	// task id 2060 
	 	$options['fields'] = array('DISTINCT users.user_Name as agent_name','users.id as agent_id');
	 	//$options['group'] = array('Merchant.referalID having total_agent_commission !=0');

	 	$all_merchant = $this->Merchant->find('all', $options);
		
		$result = array();
	 	if(count($all_merchant)==0){
	 		return $result;
	 	}else{
	 		foreach($all_merchant as $merchant){
				$result[$merchant['users']['agent_id']] = $merchant['users']['agent_name'];
	 		}
			return $result;
	 	}
	 }
	  
	  	 //function to display agents which have had commissions in past six months.
	 function getIsoByCommission($userID=null,$month=null,$year=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'),
					  'belongsTo'=>array('Manager','Status','ProcessingMethod','Processor','Commission','ISO','Referal','Status','Agent'),
					  'hasOne' => array('Commission')
					)
	 	);
	 	
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			),
				array('table' => 'user_group_joins',
	 					'alias' => 'usergroupjoin',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.isoID = usergroupjoin.user_id',
	 					)
	 			),
				array('table' => 'users',
	 					'alias' => 'users',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'usergroupjoin.user_id = users.id',
	 					)
	 			)
	 	);
	 	// search parameters
		
		//date
 		$current_time = time();
		$prevsixMonthTime = strtotime(date('Y-m')." -8 month");
		$current_date = date("Y-m-d",$current_time);
		$prevsixmonth_date = date("Y-m-d",$prevsixMonthTime);
		
	 	$condition .= " AND Commissionlog.date between '".$prevsixmonth_date."' and '".$current_date ."'";
	 	$condition .= " AND usergroupjoin.user_group_id = 22";
	 	$condition .= " AND Commissionlog.iso_commission !=0";

	 	$options['conditions'] = array($condition);
	 	// task id 2060
	 	$options['order'] = array('Merchant.id DESC');
	 	// task id 2060 
	 	$options['fields'] = array('DISTINCT users.user_Name as agent_name','users.id as agent_id');

	 	$all_merchant = $this->Merchant->find('all', $options);
		$result = array();
	 	if (count($all_merchant)==0) {
	 		return $result;
	 	}else{
	 		foreach($all_merchant as $merchant){
				$result[$merchant['users']['agent_id']] = $merchant['users']['agent_name'];
	 		}
			return $result;
	 	}
	 }
	 
	 //function to display the total comission for this person (Meritus) under this month for paraller as refferal
	 function getProcessorMonthlyVolumeMeritusParallel($userID=null,$monthtime=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'))
	 	);
	 	$totalsalesvolume = 0;
	 	$totalincome = 0;
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			)
	 	);
	 	// search parameters
	 	$month = date('m',$monthtime);
	 	$condition .= " AND MONTH(Commissionlog.date)=".$month;
	 	$year = date('Y',$monthtime);
	 	$condition .= " AND YEAR(Commissionlog.date)=".$year;
	 	 
	 	$condition .= " AND Merchant.processorID=".$userID;
		$condition .= " AND Merchant.referalID=874";
		
	 	$options['conditions'] = array($condition);
	 	$options['order'] = array('Merchant.id DESC');
	 	$options['fields'] = array('Merchant.id,Merchant.processorID,sum(Commissionlog.amount_processed) as amount_processed','sum(Commissionlog.totalapps_income) as totalapps_income','Commissionlog.date');
	 	$options['group'] = array('Merchant.id');
	 	
	 	$all_merchant = $this->Merchant->find('all', $options);
	 	if(count($all_merchant)==0){
	 		return $record = array(0,0,0);
	 	}else{
	 		$account_info = array();
	 		foreach($all_merchant as $merchant){
	 			$totalsalesvolume   += $merchant['0']['amount_processed'];
	 			$totalincome		+= $merchant['0']['totalapps_income'];
	 		}
	 		$total_active_account = count($all_merchant);
	 		return $record = array($total_active_account,$totalsalesvolume,$totalincome);
	 	}
	 }
	
	
	 //function to display the total comission for this person (Meritus) under this month for paraller as refferal
	 function getProcessorMonthlyVolumeMeritusNonParallel($userID=null,$monthtime=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'))
	 	);
	 	$totalsalesvolume = 0;
	 	$totalincome = 0;
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			)
	 	);
	 	// search parameters
	 	$month = date('m',$monthtime);
	 	$condition .= " AND MONTH(Commissionlog.date)=".$month;
	 	$year = date('Y',$monthtime);
	 	$condition .= " AND YEAR(Commissionlog.date)=".$year;
	 	 
	 	$condition .= " AND Merchant.processorID=".$userID;

		$condition .= " AND Merchant.referalID !=874";
	 	//echo $condition;die;
	 	$options['conditions'] = array($condition);
	 	$options['order'] = array('Merchant.id DESC');
	 	$options['fields'] = array('Merchant.id,Merchant.processorID,sum(Commissionlog.amount_processed) as amount_processed','sum(Commissionlog.totalapps_income) as totalapps_income','Commissionlog.date');
	 	$options['group'] = array('Merchant.id');
	 	
	 	$all_merchant = $this->Merchant->find('all', $options);
	 	if(count($all_merchant)==0){
	 		return $record = array(0,0,0);
	 	}else{
	 		$account_info = array();
	 		foreach($all_merchant as $merchant){
	 			$totalsalesvolume   += $merchant['0']['amount_processed'];
	 			$totalincome		+= $merchant['0']['totalapps_income'];
	 		}
	 		$total_active_account = count($all_merchant);
	 		return $record = array($total_active_account,$totalsalesvolume,$totalincome);
	 	}
	 }
	 //function to display the total comission for this person under this month
	 function getResidualReport($monthtime=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
                                array(
                                    'hasMany' => array('Commissionlog'),
                                    'belongsTo' => array('Agent','Processor','Manager','ISO','Referal','Status','ProcessingMethod'),
                                    'hasOne' => array('Commission')
                                    )
                ,false);
	 	 
	 	$total_totalapps_income = 0;
	 	$total_agent_commission = 0;
	 	$total_referral_commission = 0;
	 	$total_iso_commission = 0;
	 	$total_active_account = 0;
	 	$total_sales_volume = 0;
	 	 
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			)
	 	);
	 	// search parameters
	 	$month = date('m',$monthtime);
	 	$condition .= " AND MONTH(Commissionlog.date)=".$month;
	 	$year = date('Y',$monthtime);
	 	$condition .= " AND YEAR(Commissionlog.date)=".$year;
	 		 	
	 	//echo $condition;die;
	 	$options['conditions'] = array($condition);
	 	$options['order'] = array('Merchant.id DESC');
	 	//task id 2060 
	 	//$options['fields'] = array('Merchant.id,Merchant.agentID,Merchant.referalID,Merchant.isoID,sum(Commissionlog.agent_commission) as agent_commission','sum(Commissionlog.referral_commission) as referral_commission','sum(Commissionlog.iso_commission) as iso_commission','sum(Commissionlog.totalapps_income) as totalapps_income','sum(Commissionlog.amount_processed) as amount_processed');
	 	$options['fields'] = array('Merchant.id,Merchant.agentID,Merchant.referalID,Merchant.isoID,Commissionlog.*');
	 	$options['group'] = array('Merchant.id');
	 	$all_merchant = $this->Merchant->find('all', $options);
	 	 
	 	if(count($all_merchant)==0){
	 		return $record = array(0,0,0,0,0,0);
	 	}else{
	 		foreach($all_merchant as $merchant){
	 			$total_agent_commission += $merchant['Commissionlog']['agent_commission'];
	 			$total_referral_commission += $merchant['Commissionlog']['referral_commission'];
	 			$total_iso_commission += $merchant['Commissionlog']['iso_commission'];
	 			$total_totalapps_income += $merchant['Commissionlog']['totalapps_income'];
	 			$total_sales_volume += $merchant['Commissionlog']['amount_processed'];
	 		}
	 		$total_active_account = count($all_merchant);
	 		return $record = array($total_active_account,$total_agent_commission,$total_referral_commission,$total_iso_commission,$total_totalapps_income,$total_sales_volume);
	 	}
	 }
	
	 //function to display the total comission for this person under this month
	 function getProcessorMonthlyVolume($userID=null,$monthtime=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'))
	 	);
	 	$totalsalesvolume = 0;
	 	$totalincome = 0;
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			)
	 	);
	 	// search parameters
	 	$month = date('m',$monthtime);
	 	$condition .= " AND MONTH(Commissionlog.date)=".$month;
	 	$year = date('Y',$monthtime);
	 	$condition .= " AND YEAR(Commissionlog.date)=".$year;
	 	 
	 	$condition .= " AND Merchant.processorID=".$userID;
	 	//echo $condition;die;
	 	$options['conditions'] = array($condition);
	 	$options['order'] = array('Merchant.id DESC');
	 	$options['fields'] = array('Merchant.id,Merchant.processorID,sum(Commissionlog.amount_processed) as amount_processed','sum(Commissionlog.totalapps_income) as totalapps_income','Commissionlog.date');
	 	$options['group'] = array('Merchant.id');
	 	 
	 	$all_merchant = $this->Merchant->find('all', $options);
	 	if(count($all_merchant)==0){
	 		return $record = array(0,0,0);
	 	}else{
	 		$account_info = array();
	 		foreach($all_merchant as $merchant){
	 			$totalsalesvolume   += $merchant['0']['amount_processed'];
	 			$totalincome		+= $merchant['0']['totalapps_income'];
	 		}
	 		$total_active_account = count($all_merchant);
	 		return $record = array($total_active_account,$totalsalesvolume,$totalincome);
	 	}
	 }
	
	 function getUserList(){	 
	 	APP::import('Model','User');	 
	 	$this->User = new User();	 
	 	return $this->User->find("list",array('fields'=>'id,user_Name','conditions'=>'User.active	=1','order'=>array('User.user_Name ASC')));
	 }
	 
	 /*======= Function for getting user id from user_name in User table ======*/
	function getUserIdByName($user_Name=null){	 
	 	APP::import('Model','User');	 
	 	$this->User = new User();	 
	 	$userInfo = $this->User->find("first",array('fields'=>'User.id','conditions'=>array('User.user_Name'=>$user_Name)));
	 	return $userInfo['User']['id'];
	 } 
	 
	 function getUserAddresslist($user_id=null){	
	
	 	APP::import('Model','UserAddress');	 
	 	$this->UserAddress = new UserAddress();	 
	 	$userInfo = $this->UserAddress->find("list",array('fields'=>array('UserAddress.id','UserAddress.formname'),'conditions'=>array('UserAddress.user_id'=>$user_id)));
		return $userInfo;
	 }
	 
	 function get_applications_rec($userID,$loginRole){
	 	APP::import('Model','Status');	 
	 	$this->Status = new Status();	 
		
	 	$currDate = date("Y-m-d");
		
		// current month
		$startdayCurrMonth = date("Y-m-01");
		$tilldayCurrMonth = date("Y-m-d");
	 
	 	$startdaylastMonth = date("Y-m-01",strtotime("-1 month"));
		$enddaylastMonth = date("Y-m-31", strtotime("-1 month"));
		
		$startytdCurrMonth = date("Y-01-01");
		$tillytdCurrMonth = date("Y-m-d");
		
		$startlastyearDate = date("Y-01-01",strtotime("-1 year"));
		$tilllastyeatendDate = date("Y-12-31", strtotime("-1 year"));
		
		
	 
	 	$query='SELECT Status.id,Status.status,Status.navigationOrder';
		if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager'){
			$condField = 'Merchant.'.strtolower($loginRole)."ID";
			
			$query.='
 (SELECT COUNT(DISTINCT Merchantpipeline.merchantID) AS `count` FROM `merchantpipelines` AS `Merchantpipeline` INNER JOIN `merchants` AS `Merchant` ON (`Merchantpipeline`.`merchantID` = `Merchant`.`id`) WHERE `Merchantpipeline`.`statusTo` = 2   AND Merchant.statusID=2 AND `Merchantpipeline`.`statusToDate`="'.$currDate.'" and '.$condField.'='.$userID.')  as today, 
   
(SELECT COUNT(DISTINCT Merchantpipeline.merchantID) AS `count` FROM `merchantpipelines` AS `Merchantpipeline` INNER JOIN `merchants` AS `Merchant` ON (`Merchantpipeline`.`merchantID` = `Merchant`.`id`) WHERE `Merchantpipeline`.`statusTo` = 2   AND Merchant.statusID=2 AND `Merchantpipeline`.`statusToDate`>="'.$startdayCurrMonth.'" AND `Merchantpipeline`.`statusToDate`<="'.$tilldayCurrMonth.'"  and '.$condField.'='.$userID.')  as mtd,
 
  (SELECT COUNT(DISTINCT Merchantpipeline.merchantID) AS `count` FROM `merchantpipelines` AS `Merchantpipeline` INNER JOIN `merchants` AS `Merchant` ON (`Merchantpipeline`.`merchantID` = `Merchant`.`id`) WHERE `Merchantpipeline`.`statusTo` = 2  AND Merchant.statusID=2 AND `Merchantpipeline`.`statusToDate`>="'.$startdaylastMonth.'" AND `Merchantpipeline`.`statusToDate`<="'.$enddaylastMonth.'"  and '.$condField.'='.$userID.')  as last_month,
  
   (SELECT COUNT(DISTINCT Merchantpipeline.merchantID) AS `count` FROM `merchantpipelines` AS `Merchantpipeline` INNER JOIN `merchants` AS `Merchant` ON (`Merchantpipeline`.`merchantID` = `Merchant`.`id`) WHERE `Merchantpipeline`.`statusTo` = 2  AND Merchant.statusID=2 AND `Merchantpipeline`.`statusToDate`>="'.$startytdCurrMonth.'" AND `Merchantpipeline`.`statusToDate`<="'.$tillytdCurrMonth.'"  and '.$condField.'='.$userID.')  as ytd,
      
     (SELECT COUNT(DISTINCT Merchantpipeline.merchantID) FROM merchantpipelines AS Merchantpipeline 
	 INNER JOIN merchants AS Merchant ON (Merchantpipeline.merchantID = Merchant.id) WHERE Merchantpipeline.statusTo=2 AND Merchant.statusID=2 AND Merchantpipeline.statusToDate >="'.$startlastyearDate.'" AND Merchantpipeline.statusToDate<="'.$tilllastyeatendDate.'"  and '.$condField.'='.$userID.')  as last_year';
	 
		}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager'){
			
			$query.='
 ,(SELECT COUNT(DISTINCT Merchantpipeline.merchantID) AS `count` FROM `merchantpipelines` AS `Merchantpipeline` INNER JOIN `merchants` AS `Merchant` ON (`Merchantpipeline`.`merchantID` = `Merchant`.`id`) WHERE `Merchantpipeline`.`statusTo` =Status.id   AND Merchant.statusID=Status.id AND `Merchantpipeline`.`statusToDate`="'.$currDate.'")  as today, 
   
(SELECT COUNT(DISTINCT Merchantpipeline.merchantID) AS `count` FROM `merchantpipelines` AS `Merchantpipeline` INNER JOIN `merchants` AS `Merchant` ON (`Merchantpipeline`.`merchantID` = `Merchant`.`id`) WHERE `Merchantpipeline`.`statusTo` = Status.id  AND Merchant.statusID=Status.id  AND `Merchantpipeline`.`statusToDate`>="'.$startdayCurrMonth.'" AND `Merchantpipeline`.`statusToDate`<="'.$tilldayCurrMonth.'")  as mtd,
 
  (SELECT COUNT(DISTINCT Merchantpipeline.merchantID) AS `count` FROM `merchantpipelines` AS `Merchantpipeline` INNER JOIN `merchants` AS `Merchant` ON (`Merchantpipeline`.`merchantID` = `Merchant`.`id`) WHERE `Merchantpipeline`.`statusTo` = Status.id    AND Merchant.statusID=Status.id   AND `Merchantpipeline`.`statusToDate`>="'.$startdaylastMonth.'" AND `Merchantpipeline`.`statusToDate`<="'.$enddaylastMonth.'")  as last_month,
  
   (SELECT COUNT(DISTINCT Merchantpipeline.merchantID) AS `count` FROM `merchantpipelines` AS `Merchantpipeline` INNER JOIN `merchants` AS `Merchant` ON (`Merchantpipeline`.`merchantID` = `Merchant`.`id`) WHERE `Merchantpipeline`.`statusTo` = Status.id   AND Merchant.statusID=Status.id   AND `Merchantpipeline`.`statusToDate`>="'.$startytdCurrMonth.'" AND `Merchantpipeline`.`statusToDate`<="'.$tillytdCurrMonth.'")  as ytd,

      
     (SELECT COUNT(DISTINCT Merchantpipeline.merchantID) FROM merchantpipelines AS Merchantpipeline 
	 INNER JOIN merchants AS Merchant ON (Merchantpipeline.merchantID = Merchant.id) WHERE Merchantpipeline.statusTo=Status.id   AND Merchant.statusID=Status.id  AND Merchantpipeline.statusToDate >="'.$startlastyearDate.'" AND Merchantpipeline.statusToDate<="'.$tilllastyeatendDate.'")  as last_year';
		}
		
		
		if(strtolower($loginRole)!='admin' && strtolower($loginRole)!='manager' && strtolower($loginRole)!='support' && strtolower($loginRole)!='technical' && strtolower($loginRole)!='qa' && strtolower($loginRole)!='level 2 support'){
		
		$query.=' ,(SELECT COUNT(DISTINCT Merchantpipeline.merchantID) FROM merchantpipelines AS Merchantpipeline 
	 INNER JOIN merchants AS Merchant ON (Merchantpipeline.merchantID = Merchant.id) WHERE Merchantpipeline.statusTo=Status.id  AND Merchant.statusID=Status.id   and '.$condField.'='.$userID.' )  as last_time';
	 	}elseif(strtolower($loginRole)=='admin' || strtolower($loginRole)=='manager' || strtolower($loginRole)=='support' || strtolower($loginRole)=='technical' || strtolower($loginRole)=='qa' || strtolower($loginRole)=='level 2 support'){
			
		$query.=',(SELECT COUNT(DISTINCT Merchantpipeline.merchantID) FROM merchantpipelines AS Merchantpipeline 
	 INNER JOIN merchants AS Merchant ON (Merchantpipeline.merchantID = Merchant.id) WHERE Merchant.statusID=Status.id )  as last_time';
	 	}	
		$query.=' FROM  statuses as Status where Status.id in(1,2,3,4,5,9)';
		
		return $rec=$this->Status->query($query);
		
		
	 }
	 
	 // get admin rates
	 public function getRatesOption(){
	 	APP::import('Model','Rate');
	 	$this->Rate = new Rate();
	 	$RatesadminData = $this->Rate->find('list',array('fields'=>'adminName','conditions'=>array('Rate.userType'=>'admin')));
	 	return $RatesadminData;
	 }
	 // get admin transaction
	 public function getTransactionOption(){
	 	APP::import('Model','Merchanttransaction');
	 	$this->Merchanttransaction = new Merchanttransaction();
	 	$TransactionadminData = $this->Merchanttransaction->find('list',array('fields'=>'adminName','conditions'=>array('Merchanttransaction.userType'=>'admin')));
	 	return $TransactionadminData;
	 }
	 
	 public function getOwnerdata($merchantID =null){
	 	APP::import('Model','Owner');
	 	$this->Owner = new Owner();
		$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
			if($OwnerData){				
				$OwnerData = $this->Owner->find('all',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
				return $OwnerData;
			}
	 }
	 
	 /*
	  * Function for getting the list of user level
	  * For ticket #2000 on 09 oct 2013
	  */
	 public function GetUserLevels(){	 	
	 	App::import("Model", "Usermgmt.UserGroup");
	 	$this->UserGroup = new UserGroup; 
	 	$this->UserGroup->recursive = -1;
	 	return $userGroups = $this->UserGroup->find('list');
	 }
	 
	 /*
	  * function for get permission of report for login user
	  * created by Jitendra Pradhan
	  * created on Oct 30, 2013
	  * task id 2244
	  */
	 public function getReportPermission($userID = null){
	 	App::import("Model", "ReportPermission");
	 	$this->ReportPermission = new ReportPermission;
	 	$this->ReportPermission->recursive = -1;
	 	$report_permission = $this->ReportPermission->find('all',array('conditions'=>array('ReportPermission.user_id'=>$userID)));
	 	foreach($report_permission as $permission){
	 		$user_report_permission[] = $permission['ReportPermission']['reportlist_id'];
	 	}
	 	return $user_report_permission;
	 }
	 
	 /*
	  * function for get merchant rollback update values
	  * created by Jitendra Pradhan
	  * created on Nov 26, 2013
	  * task id 2556
	  */
	 public function getMerchantRollbackUpdateValues($merchantID = null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant;
	 	$this->Merchant->recursive = -1;
	 	$merchantRollback = $this->Merchant->find('first',array('fields'=>array( 'gatewayID' , 'accountCategory' , 'processorID' , 'isoID' , 'managerID' , 'agentID' , 'referalID' , 'statusID'),'conditions'=>array('Merchant.id'=>$merchantID)));	 	
	 	return $merchantRollback;
	 }
	 
	 
	 function getArraySumByKeys($keys = array(),$arrayList= array()){
        $sum = 0;
        foreach ($arrayList as $key => $value) {
           if(in_array($key, $keys)) {
               $sum+= $value;
            }
        }
		return $sum;
	 }
	 
	 
	//function to display the summary section for residual report monthly details
	function getResidualReportPrevTotal($monthtime=null){
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$condition = "1=1";
	 	$this->Merchant->unbindModel(
                                array(
                                    'hasMany' => array('Commissionlog'),
                                    'belongsTo' => array('Agent','Processor','Manager','ISO','Referal','Status','ProcessingMethod'),
                                   // 'hasOne' => array('Commission')
                                    )
                ,false);
	 	 
	 	$total_amount_processed_prev = 0;
	 	$total_total_revenue_prev = 0;
	 	$total_totalapps_income_prev = 0;
	 	$total_referral_commission_prev = 0;
	 	$total_iso_commission_prev = 0;
	 	$total_agent_commission_prev = 0;
	 	$total_totalapps_split_prev = 0;
	 	 
	 	$options['joins'] = array(
	 			array('table' => 'commissionlogs',
	 					'alias' => 'Commissionlog',
	 					'type' => 'inner',
	 					'conditions' => array(
	 							'Merchant.id = Commissionlog.merchantID',
	 					)
	 			)
	 	);
	 	// search parameters
	 	$month = date('m',$monthtime);
	 	$condition .= " AND MONTH(Commissionlog.date)=".$month;
	 	$year = date('Y',$monthtime);
	 	$condition .= " AND YEAR(Commissionlog.date)=".$year;
	 		 	
	 	$options['conditions'] = array($condition);
	 	$options['order'] = array('Merchant.id DESC');
	 	$options['fields'] = array('Commissionlog.amount_processed,Commissionlog.totalapps_income,Commissionlog.referral_commission,Commissionlog.iso_commission,Commissionlog.agent_commission,Commission.totalapps_split');
	 	$options['group'] = array('Merchant.id');
	 	$all_merchant = $this->Merchant->find('all', $options);
	 	 
	 	if(count($all_merchant)==0){
	 		return $record = array(0,0,0,0,0,0,0);
	 	}else{
	 		foreach($all_merchant as $merchant){
		
	 			$total_amount_processed_prev += $merchant['Commissionlog']['amount_processed'];
	 			
	 			if($merchant['Commission']['totalapps_split'] != 0){
					$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
				}else{
					$total_revenue = 0;
				}
				$total_total_revenue_prev += $total_revenue;
				$total_totalapps_income_prev += $merchant['Commissionlog']['totalapps_income'];
				$total_referral_commission_prev += $merchant['Commissionlog']['referral_commission'];
				$total_iso_commission_prev += $merchant['Commissionlog']['iso_commission'];
				$total_agent_commission_prev += $merchant['Commissionlog']['agent_commission'];
				$total_totalapps_split_prev += $merchant['Commission']['totalapps_split'];
	 		}
	 		$record = array();
	 		$record['total_amount_processed_prev'] = $total_amount_processed_prev;
	 		$record['total_total_revenue_prev'] = $total_total_revenue_prev;
	 		$record['total_totalapps_income_prev'] = $total_totalapps_income_prev;
	 		$record['total_referral_commission_prev'] = $total_referral_commission_prev;
	 		$record['total_iso_commission_prev'] = $total_iso_commission_prev;
	 		$record['total_agent_commission_prev'] = $total_agent_commission_prev;
	 		$record['total_totalapps_split_prev'] = $total_totalapps_split_prev;
	 		return $record;
	 	}
	}

	//function to display the total number of leads/monthly sales submitted by a person in past six months
	 function getAgentleadsByMonth($statusid = 0, $monthtime = null ) {
	 
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
		
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'))
	 	);
	 	
		$options = array();
		$options['joins'] = array
								(
									array
										(	
											'table' => 'merchantpipelines',
											'alias' => 'Merchantpipeline',
											'type'  => 'inner',
											'conditions' => array
														(
															'Merchant.id =  Merchantpipeline.merchantID'
														)
										),
									array
										(
											'table' => 'users',
											'alias' => 'User',
											'type'  => 'inner',
											'conditions' => array
														(
															'User.Id =  Merchant.agentID'
														)
										),
								);
			
		if( empty( $monthtime ) ) { 
	
			$first_month_time = time();
			$sixth_month_time = strtotime( date('Y-n') . " -5 month" );
			$current_date     = date( "Y-m-d", $first_month_time );
			$six_month_date   = date( "Y-m-d", $sixth_month_time );
				
			$condition = 'Merchantpipeline.statusTo = '. $statusid .' AND Merchantpipeline.statusToDate BETWEEN "'. $six_month_date .'" AND "'.$current_date .'" AND User.active=1 AND User.id != ""';
			
		 } else {
			$first_month_time = $monthtime;
			$year = date( "Y", $first_month_time );
			$month = date( "m", $first_month_time );
			
			$condition = 'Merchantpipeline.statusTo = '. $statusid .' AND MONTH(Merchantpipeline.statusToDate) = "'. $month .'" AND YEAR(Merchantpipeline.statusToDate) = "'. $year .'" AND User.active=1 AND User.id != ""';
		}
		
		$options['conditions'] = array($condition);
		$options['order'] = array('User.user_Name');
		
		//$options['fields'] = array("count( Merchantpipeline.id ) as leads, Merchant.agentID as agent , User.user_Name,   CONCAT(YEAR(Merchantpipeline.statusToDate), '-', MONTH(Merchantpipeline.statusToDate))  as date");
		$options['fields'] = array("COUNT(DISTINCT Merchantpipeline.id ) as leads, Merchant.agentID as agent , User.user_Name,   CONCAT(YEAR(Merchantpipeline.statusToDate), '-', MONTH(Merchantpipeline.statusToDate))  as date");
		$options['group'] = array('Merchant.agentID , MONTH(Merchantpipeline.statusToDate)');
		
		$agents = $this->Merchant->find('all', $options);
		//$agent_result = Set::combine($agents, '{n}.0.date', '{n}.0.leads', '{n}.User.user_Name');
		$agent_result = Set::combine($agents, '{n}.0.date', array('{0}:{1}','{n}.0.leads','{n}.Merchant.agent'), '{n}.User.user_Name');	
	 	return $agent_result;
	 } 
	 
	 
	 //function to display the total number of leads/monthly sales submitted by a person in past six months
	 function getIsoleadsByMonth($statusid = 0, $monthtime = null ) {
	 
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
		
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'))
	 	);
	 	
		$options = array();
		$options['joins'] = array
								(
									array
										(	
											'table' => 'merchantpipelines',
											'alias' => 'Merchantpipeline',
											'type'  => 'inner',
											'conditions' => array
														(
															'Merchant.id =  Merchantpipeline.merchantID'
														)
										),
									array
										(
											'table' => 'users',
											'alias' => 'User',
											'type'  => 'inner',
											'conditions' => array
														(
															'User.Id =  Merchant.isoID'
														)
										),
								);
			
		if( empty( $monthtime ) ) { 
	
			$first_month_time = time();
			$sixth_month_time = strtotime( date('Y-n') . " -5 month" );
			$current_date     = date( "Y-m-d", $first_month_time );
			$six_month_date   = date( "Y-m-d", $sixth_month_time );
				
			$condition = 'Merchantpipeline.statusTo = '. $statusid.' AND Merchantpipeline.statusToDate BETWEEN "'. $six_month_date .'" AND "'.$current_date .'" AND User.active=1 AND User.id != ""';
			
		 } else {
			$first_month_time = $monthtime;
			$year = date( "Y", $first_month_time );
			$month = date( "m", $first_month_time );
			
			$condition = 'Merchantpipeline.statusTo = '. $statusid .' AND MONTH(Merchantpipeline.statusToDate) = "'. $month .'" AND YEAR(Merchantpipeline.statusToDate) = "'. $year .'" AND User.active=1 AND User.id != ""';
		}
		
		$options['conditions'] = array($condition);
		$options['order'] = array('User.user_Name');
		
		//$options['fields'] = array("count( Merchantpipeline.id ) as leads, Merchant.isoID as agent , User.user_Name,   CONCAT(YEAR(Merchantpipeline.statusToDate), '-', MONTH(Merchantpipeline.statusToDate))  as date");
		$options['fields'] = array("COUNT(DISTINCT Merchantpipeline.id ) as leads, Merchant.isoID as agent , User.user_Name,   CONCAT(YEAR(Merchantpipeline.statusToDate), '-', MONTH(Merchantpipeline.statusToDate))  as date");
		$options['group'] = array('Merchant.isoID , MONTH(Merchantpipeline.statusToDate)');
		
		$iso = $this->Merchant->find('all', $options);
		//$agent_result = Set::combine($agents, '{n}.0.date', '{n}.0.leads', '{n}.User.user_Name');
		$iso_result = Set::combine($iso, '{n}.0.date', array('{0}:{1}','{n}.0.leads','{n}.Merchant.agent'), '{n}.User.user_Name');				
	 	return $iso_result;
	 } 

	 
	 //function to display the total number of leads/monthly sales submitted by a person in past six months
	 function getReferralleadsByMonth($statusid = 0, $monthtime=null){
	 
	 	App::import("Model", "Merchant");
	 	$this->Merchant = new Merchant();
		
	 	//find all merchant associated with user under(agent,iso,referral)
	 	$this->Merchant->unbindModel(
	 			array('hasMany' => array('Commissionlog'))
	 	);
	 	
		$options = array();
		$options['joins'] = array
								(
									array
										(	
											'table'      => 'merchantpipelines',
											'alias'      => 'Merchantpipeline',
											'type'       => 'inner',
											'conditions' => array
														(
															'Merchant.id =  Merchantpipeline.merchantID'
														)
										),
									array
										(
											'table'      => 'users',
											'alias'      => 'User',
											'type'       => 'inner',
											'conditions' => array
														(
															'User.Id =  Merchant.referalID'
														)
										),
								);
			
		if( empty( $monthtime ) ) { 
	
			$first_month_time = time();
			$sixth_month_time = strtotime( date('Y-n') . " -5 month" );
			$current_date     = date( "Y-m-d", $first_month_time );
			$six_month_date   = date( "Y-m-d", $sixth_month_time );
				
			$condition = 'Merchantpipeline.statusTo = '. $statusid .' AND Merchantpipeline.statusToDate BETWEEN "'. $six_month_date .'" AND "'.$current_date .'" AND User.active=1 AND User.id != ""';
			
		 } else {
			$first_month_time = $monthtime;
			$year = date( "Y", $first_month_time );
			$month = date( "m", $first_month_time );
			
			$condition = 'Merchantpipeline.statusTo = '. $statusid .' AND MONTH(Merchantpipeline.statusToDate) = "'. $month .'" AND YEAR(Merchantpipeline.statusToDate) = "'. $year .'" AND User.active=1 AND User.id != ""';
		}
		
		$options['conditions'] = array($condition);
		$options['order'] = array('User.user_Name');
		
		//$options['fields'] = array("COUNT( Merchantpipeline.id ) as leads, Merchant.referalID as agent , User.user_Name,   CONCAT(YEAR(Merchantpipeline.statusToDate), '-', MONTH(Merchantpipeline.statusToDate))  as date");
		$options['fields'] = array("COUNT(DISTINCT Merchantpipeline.id ) as leads, Merchant.referalID as agent , User.user_Name,   CONCAT(YEAR(Merchantpipeline.statusToDate), '-', MONTH(Merchantpipeline.statusToDate))  as date");
		$options['group'] = array('Merchant.referalID , MONTH(Merchantpipeline.statusToDate)');
		
		$referrals = $this->Merchant->find('all', $options);
		//$referral_result = Set::combine($referrals, '{n}.0.date', '{n}.0.leads', '{n}.User.user_Name');	
		$referral_result = Set::combine($referrals, '{n}.0.date', array('{0}:{1}','{n}.0.leads','{n}.Merchant.agent'), '{n}.User.user_Name');		
	 	return $referral_result;
	 }
	 /*
	  * function for get merchant add note
	  * created by Jitendra Pradhan
	  * created on Nov 26, 2013
	  * task id 2556
	  */
	 public function getMerchantAddNote($merchantID = null){
	 	//echo $merchantID;die;
	 	App::import("Model", "Merchantnote");
	 	$this->Merchantnote = new Merchantnote;
	 	//echo "herer";die;
	 	$merchantNote = $this->Merchantnote->find('first',array('fields'=>array('note'),'conditions'=>array('Merchantnote.merchantID'=>$merchantID),'order'=>array('Merchantnote.merchantNoteID ASC')));
	 	$merchantNote = Set::classicExtract($merchantNote, 'Merchantnote.note');
	 	return $merchantNote;
	 }
	 
	 /**
	* This is used to get merchants exist in taboo CRM.
	*
	* @param : $mids (array merchant id's)
	* @return : $records (merchant array with Incomplete split)
	*/
	public function getMatchedMid( $mids = Array() ) 
	{
		try {
			App::import("Model", "Merchant");
			$this->Merchant = new Merchant;
			
			## unset column header text from column.
			unset($mids[0]);
			
			## Get data for match merchant
			$this->Merchant->unbindModel(
				array(
					'belongsTo' => array('Agent','Processor','Manager','ISO','Referal','Status','ProcessingMethod'),
					'hasMany' => array('Commissionlog')
				)
				,false
			);				
			$option = array(
				'conditions' => Array('Merchant.CID' => $mids),
				'fields'     => Array(
					'Merchant.id, Merchant.CID, Merchant.merchantName, Merchant.agentID, Merchant.isoID, Merchant.referalID, Commission.agent_split,
					Commission.referral_split, Commission.iso_split, Commission.totalapps_split'
				)
			);						
			$merchantInfo = $this->Merchant->find('all', $option);
			
			return $merchantInfo;			
		}
		catch(Exception $e) {
			$e->getMessage();
		}
	}
	
	
	
	/**
	 * This is used to get user name from user table.
	 *
	 * @param : $uid (array user id's)
	 * @return : $records (merchant/ user name)
	 */
	public function getUsernameById( $userid = Array() ) 
	{
		try {
			if ( count($userid) > 0 ) {
				APP::import('Model','User');	 
				$this->User = new User();	 
				$this->User->unbindModel(
					array(
						'belongsTo' => array('ReferralLink'),
						'hasMany' => array('UserGroupJoin', 'Usercontact', 'UserAddress')
					)
					,false
				);
				
				$option = array(
					'fields'     => Array('User.id', 'User.user_Name'),
					'conditions' => Array('User.id'=>$userid)
				);
				$userInfo = $this->User->find("all", $option);
				
				return $userInfo;			
			}
		}
		catch(Exception $e) {
			$e->getMessage();
		}
	}
	
	
	 /**
	 * This is used to get colour-picker colors.
	 *
	 * @param : none
	 * @return : option elements
	 */
	public function getWebSafeColours() {
		$cs = array('00', '33', '66', '99', 'CC', 'FF');

		for($i=0; $i<6; $i++) {
			for($j=0; $j<6; $j++) {
				for($k=0; $k<3; $k++) {
					$c = $cs[$i] .$cs[$j] .$cs[$k];
					echo "<option value=\"$c\">#$c</option>\n";
				}
			}
		}
	}
	
	
	/**
	* This is used to get colour-picker colors.
	*
	* @param : none
	* @return : option elements
	*/
	public function number_round_up ( $value, $precision ) { 
		$pow = pow ( 10, $precision ); 
		return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
	} 
	
	/**
	* function for get login user iso id
	* @param : userID
	* created on Apr 02, 2014
	* task id 3899
	*/
	public function getUserIso($userID = null){
		APP::import('Model','Usermgmt.User');
		$this->User = new User();
		$userInfo = $this->User->findById($userID);
		return $userInfo['User']['idIso'];
		 
	}

}//Class end

?>
