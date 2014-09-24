<?php //error_reporting(0);

App::uses('AppController', 'Controller');

class ApisController extends AppController {
	//var $layout = 'merchantApi';
	var $helpers = array('Html','Text','Paginator','Pdf'); //add some other helpers to controller
	var $components = array('Session','Common','Cookie','Email','RequestHandler');
	

	// Method for fill the rest merchant basic information by merchant (step 3 of pre-app request)
	public function superadmin_merchantapi($merchantID=NULL) {
		$this->layout = "onlineMerchantApi-2";
		$this->loadModel('Accounttype');
		$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		$this->set('ac_list',$ac_list);
		
		$this->loadModel('Usercat');
		$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
		$this->set('uc_list',$uc_list);

		$this->loadModel('Accountcat');
		$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.id DESC")));
		$this->set('acat_list',$acat_list);

		$this->loadModel('BusinessCategory');
		$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.navigationOrder asc")));
		$this->set('busi_cat_id',$busi_cat_id);

		$this->loadModel('User');
		$agentList =$this->Common->getAgentList();
		$this->set('agentList',$agentList);

		$procList =$this->Common->getProcessorList();
		$this->set('procList',$procList);

		$mangList = $this->Common->getManagerList();
		$this->set('mangList',$mangList);

		$isoList = $this->Common->getIsoList();
		$this->set('isoList',$isoList);

		$referalList =$this->Common->getReferalList();
		$this->set('referalList',$referalList);		
		
		$this->loadModel('Gateway');
		$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
		$this->set('gatwayList',$gatwayList);

		$this->loadModel('Merchant');
		$this->loadModel('Owner');
		$this->loadModel('Rate');
		$this->loadModel('Merchanttransaction');

		if($this->request->is('get')){
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			$RatesData = $this->Rate->find('first',array('conditions'=>array('Rate.merchantID'=>$merchantID)));
			$TransData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.merchantID'=>$merchantID)));
			$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
			if(!is_array($RatesData)){
				$this->Session->write('popup','Your Rates information is not saved!Please contact to your Agent Or Manager to save this in total-apps.com');
				$this->Session->setFlash('Your Rates information is not saved!Please contact to your Agent Or Manager to save this in total-apps.com');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
				exit;
			}elseif(!is_array($TransData)){
				$this->Session->write('popup','Your Transaction information is not saved!Please contact to your Agent Or Manager to save this in total-apps.com');
				$this->Session->setFlash('Your Transaction information is not saved!Please contact to your Agent Or Manager to save this in total-apps.com');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
				exit;
			}elseif(!is_array($OwnerData)){
				$this->Session->write('popup','Your owners/partners/officers information is not saved!Please contact to your Agent Or Manager to save this in total-apps.com');
				$this->Session->setFlash('Your owners/partners/officers information is not saved!Please contact to your Agent Or Manager to save this in total-apps.com');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
				exit;
			}else{
				$this->request->data = array_merge($MerchantData, $RatesData, $TransData);
				$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
				if($OwnerData){
					$OwnerData = $this->Owner->find('all',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
					$this->set('OwnerData',$OwnerData);
				}
				$selected_months = explode(",",$this->request->data['Merchant']['monthNames']);
				$selected_adsmethod = explode(",",$this->request->data['Merchant']['advertiseMethod']);
				$this->set('selected_months',$selected_months);
				$this->set('selected_adsmethod',$selected_adsmethod);
			}
			$count =  $this->Merchant->find('count', array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.statusID >='=>'3')));
			//$count =  $this->Merchant->find('count', array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.statusID >='=>'4')));
			if($count!=1){
				$this->Session->write('popup','Sorry,You are not eligible to open this URL as your pre-app request status is not incomplete.');
				$this->Session->setFlash('Sorry,You are not eligible to open this URL as your pre-app request status is not incomplete.');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
			}
		}else{

			$merchantID = $this->request->data['Merchant']['id'];
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			
			if($this->request->data['x']!='' && $this->request->data['y']!=''){
				// if sign is drwawing
				if($this->request->data['output']!=''){
					$img = $this->Common->sigJsonToImage($this->request->data['output'],array('imageSize' => array(235, 55)));
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					// Output to browser
					/*header('Content-Type: image/png');
					imagepng($img);*/

					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName,'name_initial'=>trim($this->request->data['name_initial'])));
					$this->Merchant->save( $data, false, array('merchantSign','name_initial'));
					// Destroy the image in memory when complete
					imagedestroy($img);

				}else{ // if sign is Text
					$img = imagecreatetruecolor(200, 30);
					$bgColour = imagecolorallocate($img, 0xff, 0xff, 0xff);
					$penColour = imagecolorallocate($img, 0x14, 0x53, 0x94);
					imagefilledrectangle($img, 0, 0, 399, 29, $bgColour);
					$text = $this->request->data['name'];
					$font = WWW_ROOT.'VLADIMIR.TTF';
					imagettftext($img, 20, 0, 10, 20, $penColour, $font, $text);
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName,'name_initial'=>trim($this->request->data['name_initial'])));
					$this->Merchant->save( $data, false, array('merchantSign','name_initial'));
					// Output to browser
					/*header('Content-Type: image/png');
					imagepng($img);*/
					imagedestroy($img);
				}

				// Pre-app request process change status processing(5) *** STEP 4 *****
				/* $this->request->data['Merchant']['statusID'] = '5';
				$processingDate = date("Y-m-d"); */
				// sent merchant to processing list (statusID = 5 for processing )
				/* $data = array('Merchant' => array('id'=>$merchantID,'statusID'=>5,'processingDate'=>$processingDate));
				$this->Merchant->save( $data, false, array('statusID','processingDate')); */
				
				// Add status update in merchant pipeline
				/* $this->loadModel('Merchantpipeline');
				$pipelineData = array();
				$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
				$pipelineData['Merchantpipeline']['statusFrom'] = 4;
				$pipelineData['Merchantpipeline']['statusTo'] = 5;
				$pipelineData['Merchantpipeline']['statusToDate'] = $processingDate;
				$this->Merchantpipeline->save($pipelineData); */
				//add merchant notes when change in status
				$this->loadModel('Merchantnote');
				$noteData = array();
				$noteData['Merchantnote']['merchantID'] = $merchantID;
				$noteData['Merchantnote']['enteredBy'] = '';
				$timestamp = CURRENTDATE;
				$noteData['Merchantnote']['timeStamp'] = $timestamp;
				$noteData['Merchantnote']['note'] = "Signature has been uploaded successfully by this merchant.";
				$this->Merchantnote->save($noteData);
				
				/** send email to manager **/
				$email = new CakeEmail("smtp");
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				$subject = "A merchant signed the application successfully.";
				$bodyText = "Hello, <br><br> Merchant ".$MerchantData['Merchant']['merchantName']." has been signed the application successfully on <a href=\"http://www.total-apps.com\">www.total-apps.com</a> at ".$timestamp.".";
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				$sendto = $MerchantData['Manager']['userEmail'];				
				if(Validation::email($sendto)){
					$email->to($sendto);
					$email->send($bodyText);
				}
				
				$this->redirect(array('controller'=>'apis','action' => "merchantpdf/".$merchantID));
				
			}

		}// end if of check data array



	}



	// Method for saving pre-app request from main website or any other referral website
	public function superadmin_api() {
		$this->layout = "merchantApi";
		$errorsArr ='';
		$api_response_xml = "";
		$errormsg = "";
		$imageUrl = Router::url('/',true);
		if(isset($_POST['companyName']) && $_POST['contactPhone']!='Contact Phone Number' && $_POST['salesVolume']!='Monthly Sales Volume'){

			$userid = $_POST['username'];
			$password = md5($_POST['password']);

			$this->loadModel('User');
			$this->loadModel('Merchant');
			
			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
			if($count>0)
			{
				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				if($_POST['referalID']==""){
					$agentID = $referralID = intval($agentInfo['User']['id']);
				}else{
					if($this->Common->isRoleAgent($_POST['referalID'])){
						$agentID = $_POST['referalID'];
					}else{
						$agentID = intval($agentInfo['User']['id']);
					}
					$referralID = intval($_POST['referalID']);
				}

				$processorID = intval($agentInfo['User']['idProcessor']);
				$isoID = intval($agentInfo['User']['idIso']);
				$managerID = intval($agentInfo['User']['idManager']);
				$this->request->data['Merchant']['merchantName'] = $_POST['companyName'];
				$this->request->data['Merchant']['merchantDBA'] = $_POST['companyName'];
				$this->request->data['Merchant']['merchantURL'] = $_POST['companySite'];
				$this->request->data['Merchant']['startDate'] = date("n/j/Y");
				$this->request->data['Merchant']['sendUpDate'] = date("n/j/Y");
				$this->request->data['Merchant']['preappDate'] = date("Y-m-d");
				$this->request->data['Merchant']['contactPhone'] = $_POST['contactPhone'];
				$this->request->data['Merchant']['contactName'] = $_POST['contactPerson'];
				$this->request->data['Merchant']['contactEmail'] = $_POST['contactEmail'];
				$this->request->data['Merchant']['statusID'] = '1'; // status 1 for preapp1 or Lead
				$this->request->data['Merchant']['accountCategory'] = intval(($_POST['businessType'] > 0)?$_POST['businessType']:'7');
				$this->request->data['Merchant']['agentID'] = $agentID;
				$this->request->data['Merchant']['processorID'] = $processorID;
				$this->request->data['Merchant']['isoID'] = $isoID;
				$this->request->data['Merchant']['managerID'] = $agentID;					
				$this->request->data['Merchant']['referalID'] = $referralID;
				$this->request->data['Merchant']['volume'] = $_POST['salesVolume'];
				$this->request->data['Merchant']['detailExplanation'] = trim(preg_replace('/\s\s+/', ' ', $_POST['services']));					
				$this->request->data['Merchant']['user_ref_id'] = "user_ref".$referralID;
				
				// task id 3512 
				if(isset($_POST['lead_from']) && $_POST['lead_from']=="http://total-apps.com/"){
					$this->request->data['Merchant']['referalID'] = "";
					$this->request->data['Merchant']['isoID'] = "";
					$this->request->data['Merchant']['agentID'] = "";
				}
				
				// task id 3532 to save form_id in taboo
				if(isset($_POST['form_id']) && $_POST['form_id']!=""){
					$this->request->data['Merchant']['form_id'] = $_POST['form_id'];
				}
				
				
				$this->Merchant->set($this->request->data);
				if(!$this->Merchant->validates())
				{
					$errorsArr = $this->Merchant->validationErrors;
				}
				if($errorsArr)
				{	
					echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Failure</response_message><Failure_msg>Please provide all field values correctly.</Failure_msg></response>';exit;
				}
				
				
				if($this->Merchant->save($this->request->data)) {
					$body ='Thank you for your interest in our company,  we value every customer  and offer impeccable services. We will be contacting you very soon.<br/> Your filling information is as follow:<br/><br/>';
					
					if($_POST['businessType']==1)
					$businessType = 'Swipe';
					elseif($_POST['businessType']==2)
					$businessType = 'MOTO';
					elseif($_POST['businessType']==3)
					$businessType = 'Internet';
					elseif($_POST['businessType']==4)
					$businessType = 'Mobile';
					elseif($_POST['businessType']==5)
					$businessType = 'Equipment';
					elseif($_POST['businessType']==6)
					$businessType = 'Gateway';
					elseif($_POST['businessType']==7)
					$businessType = 'Other';
					elseif($_POST['businessType']==8)
					$businessType = 'USB Swipe';
					elseif($_POST['businessType']==10)
					$businessType = 'PSP';
					elseif($_POST['businessType']==11)
					$businessType = 'Gift Cards';
					elseif($_POST['businessType']==12)
					$businessType = 'ACH';
					
					//email to user
					$sendto = $this->request->data['Merchant']['contactEmail'];
					$subject = "New application from www.total-apps.com";
					
					$body = '<div style="background-color:#104c79">
 <table width="100%" bgcolor="#104c79" align="center">
  <thead> 
    <tr>
    <th width="60%" bgcolor="#104c79"><img width="326" height="97" alt=" " src="https://www.total-apps.com//components/com_virtuemart/views/invoice/tmpl/images/total-logo.jpg"> </th>
    <th width="40%" bgcolor="#104c79"><br>
     <img alt=" " src="https://www.total-apps.com//components/com_virtuemart/views/invoice/tmpl/images/address.jpg">
    </th>
     </tr>
   </thead> 
 </table> 
</div>
<div style="margin: 5px 0px;">
 <table width="100%" cellspacing="0" cellpadding="0" border="0" style="">
     <tbody><tr>
      <td bgcolor="#0d5c98" style="padding:8px">
		<h4 style="margin:0;padding:0;font:22px Tahoma,Geneva,sans-serif;color:#fff">Hello '.$_POST['contactPerson'].',</h4>
      </td>
     </tr>
    </tbody></table>  
</div>
<div align="center" style="background-color:#F2F2F2">
<table cellspacing="0" cellpadding="0" border="0" style="width:50%;border-collapse:collapse;color: #000000;">';
	if($_POST['companyName']==$_POST['contactPerson']){
		$companyName='';
	}else{
		$companyName=$_POST['companyName'];
	}
	if(!empty($companyName)){ 
	$body.='<tr>
      <td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
      <p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Company Name: <u></u><u></u></span></p>
      </td>
      <td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
      <p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$_POST['companyName'].'<u></u><u></u></span></p>
      </td>
     </tr>';
	}
	$body.='<tr>
	<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
	<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Company Site: <u></u><u></u></span></p>
	</td>
	<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
	<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$_POST['companySite'].'<u></u><u></u></span></p>
	</td>
	</tr>';
	$body.='<tr>
	<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
	<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Contact Name: <u></u><u></u></span></p>
	</td>
	<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
	<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$_POST['contactPerson'].'<u></u><u></u></span></p>
	</td>
	</tr>';
	$body.='<tr>
	<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
	<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Contact Email: <u></u><u></u></span></p>
	</td>
	<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
	<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;"><a style="text-decoration:none;" href="mailto:'.$_POST['contactEmail'].'">'.$_POST['contactEmail'].'</a><u></u><u></u></span></p>
	</td>
	</tr>';
	$body.='<tr>
	<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
	<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Contact Phone: <u></u><u></u></span></p>
	</td>
	<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
	<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$_POST['contactPhone'].'<u></u><u></u></span></p>
	</td>
	</tr>';	
	if(!empty($_POST['salesVolume'])){
		$body.='<tr>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
		<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Sales Volume: <u></u><u></u></span></p>
		</td>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
		<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$_POST['salesVolume'].'<u></u><u></u></span></p>
		</td>
		</tr>';		
	}	
	if(!empty($businessType)){
		$body.='<tr>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
		<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Business Account Type: <u></u><u></u></span></p>
		</td>		
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
		<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$businessType.'<u></u><u></u></span></p>
		</td>
		</tr>';
	}	
	if(!empty($this->request->data['Merchant']['detailExplanation'])){
		$body.='<tr>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
		<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Description of product or services:<u></u><u></u></span></p>
		</td>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
		<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$this->request->data['Merchant']['detailExplanation'].'<u></u><u></u></span></p>
		</td>
		</tr>';		
	}	
	if($_POST['referalID']!=''){
		$referalname = $this->Common->getProcessorNameById($_POST['referalID']);
		$body.='<tr>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
		<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Referral\'s Name: <u></u><u></u></span></p>
		</td>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
		<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$referalname.'<u></u><u></u></span></p>
		</td>
		</tr>';		
	}
	if($_POST['referral']!=''){
		$body.='<tr>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;text-align: right;">
		<p class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">Referral:<u></u><u></u></span></p>
		</td>
		<td style="padding:6.0pt 6.0pt 6.0pt 6.0pt;background:#f2f2f2;">
		<p align="right" style="text-align:left" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;">'.$_POST['referral'].'<u></u><u></u></span></p>
		</td>
		</tr>';
	}	
	$body.='</table>
</div>
</div>
<div align="center">
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100.0%">
 <tbody><tr>
  <td style="padding:.1in 0in 1.2pt 0in">
  <p align="center" class="MsoNormal"><b><span style="font-size:24.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e">Thank you for your interest in our company <a target="_blank" href="https://www.total-apps.com/"><span style="color:#07304e">Total Apps</span></a><u></u><u></u></span></b></p>
  </td>
 </tr>
 <tr>
  <td style="padding:1.2pt 0in 1.2pt 0in">
  <p align="center" style="margin-bottom:14.5pt;text-align:center" class="MsoNormal"><b><span style="font-size:14.5pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e">Total Apps, Inc<u></u><u></u></span></b></p>
  </td>
 </tr>
 <tr>
  <td style="padding:12.0pt 0in 0in 0in">
  <p align="center" class="MsoNormal"><b><span style="font-size:18.0pt;font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e">Take a look at our other services<u></u><u></u></span></b></p>
  </td>
 </tr>
 <tr>
  <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100.0%">
   <tbody><tr>
    <td width="16%" style="width:16.0%;padding:3.0pt 3.0pt 3.0pt 3.0pt">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100.0%">
     <tbody><tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;"><a target="_blank" href="https://www.total-apps.com/shopping-cart"><span style="text-decoration:none"><img width="99" height="98" border="0" alt=" " src="https://www.total-apps.com/components/com_virtuemart/views/invoice/tmpl/images/shopping-img.jpg"></span></a><u></u><u></u></span></p>
      </td>
     </tr>
     <tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center;line-height:12.0pt" class="MsoNormal"><b><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e"><a target="_blank" href="https://www.total-apps.com/shopping-cart"><span style="color:#07304e;text-decoration:none">Shopping Cart</span></a><u></u><u></u></span></b></p>
      </td>
     </tr>
    </tbody></table>
    </td>
    <td width="16%" style="width:16.0%;padding:3.0pt 3.0pt 3.0pt 3.0pt">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100.0%">
     <tbody><tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;"><a target="_blank" href="https://www.total-apps.com/gateway"><span style="text-decoration:none"><img width="99" height="98" border="0" alt=" " src="https://www.total-apps.com/components/com_virtuemart/views/invoice/tmpl/images/gateway-img.jpg"></span></a><u></u><u></u></span></p>
      </td>
     </tr>
     <tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center;line-height:12.0pt" class="MsoNormal"><b><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e"><a target="_blank" href="https://www.total-apps.com/gateway"><span style="color:#07304e;text-decoration:none">Gateway</span></a><u></u><u></u></span></b></p>
      </td>
     </tr>
    </tbody></table>
    </td>
    <td width="16%" style="width:16.0%;padding:3.0pt 3.0pt 3.0pt 3.0pt">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100.0%">
     <tbody><tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;"><a target="_blank" href="https://www.total-apps.com/retail"><span style="text-decoration:none"><img width="99" height="98" border="0" alt=" " src="https://www.total-apps.com/components/com_virtuemart/views/invoice/tmpl/images/retail-img.jpg"></span></a><u></u><u></u></span></p>
      </td>
     </tr>
     <tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center;line-height:12.0pt" class="MsoNormal"><b><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e"><a target="_blank" href="https://www.total-apps.com/retail"><span style="color:#07304e;text-decoration:none">Retail</span></a><u></u><u></u></span></b></p>
      </td>
     </tr>
    </tbody></table>
    </td>
    <td width="16%" style="width:16.0%;padding:3.0pt 3.0pt 3.0pt 3.0pt">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100.0%">
     <tbody><tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;"><a target="_blank" href="https://www.total-apps.com/mobile-need-help"><span style="text-decoration:none"><img width="99" height="98" border="0" alt=" " src="https://www.total-apps.com/components/com_virtuemart/views/invoice/tmpl/images/mobile-img.jpg"></span></a><u></u><u></u></span></p>
      </td>
     </tr>
     <tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center;line-height:12.0pt" class="MsoNormal"><b><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e"><a target="_blank" href="https://www.total-apps.com/mobile-need-help"><span style="color:#07304e;text-decoration:none">Mobile</span></a><u></u><u></u></span></b></p>
      </td>
     </tr>
    </tbody></table>
    </td>
    <td width="16%" style="width:16.0%;padding:3.0pt 3.0pt 3.0pt 3.0pt">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100.0%">
     <tbody><tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;"><a target="_blank" href="https://www.total-apps.com/pos-systems"><span style="text-decoration:none"><img width="99" height="98" border="0" alt=" " src="https://www.total-apps.com/components/com_virtuemart/views/invoice/tmpl/images/pos-system.jpg"></span></a><u></u><u></u></span></p>
      </td>
     </tr>
     <tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center;line-height:12.0pt" class="MsoNormal"><b><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e"><a target="_blank" href="https://www.total-apps.com/pos-systems"><span style="color:#07304e;text-decoration:none">POS Systems</span></a><u></u><u></u></span></b></p>
      </td>
     </tr>
    </tbody></table>
    </td>
    <td width="16%" style="width:16.0%;padding:3.0pt 3.0pt 3.0pt 3.0pt">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100.0%">
     <tbody><tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center" class="MsoNormal"><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;"><a target="_blank" href="https://www.total-apps.com/marketing"><span style="text-decoration:none"><img width="99" height="98" border="0" alt=" " src="https://www.total-apps.com/components/com_virtuemart/views/invoice/tmpl/images/marketing.jpg"></span></a><u></u><u></u></span></p>
      </td>
     </tr>
     <tr>
      <td style="padding:3.0pt 3.0pt 3.0pt 3.0pt">
      <p align="center" style="text-align:center;line-height:12.0pt" class="MsoNormal"><b><span style="font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;;color:#07304e"><a target="_blank" href="https://www.total-apps.com/marketing"><span style="color:#07304e;text-decoration:none">Marketing</span></a><u></u><u></u></span></b></p>
      </td>
     </tr>
    </tbody></table>
    </td>
   </tr>
  </tbody></table>
  </td>
 </tr>
</tbody></table>
</div>';
					$bodyText = $body;
					$email = new CakeEmail("smtp");
					//$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));

					if($managerID!='')
						$managerEmail = $this->Common->getProcessorEmail($managerID);
					else
						$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;

					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));

					$email->to($sendto);
					//$email->bcc('4008@dothejob.org');
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					$email->send($bodyText);
					// send email to services@total-apps.com
					$email->to('services@total-apps.com');
					$email->send($bodyText);
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $this->Merchant->getLastInsertID();
					$pipelineData['Merchantpipeline']['statusFrom'] = 0;
					$pipelineData['Merchantpipeline']['statusTo'] = 1;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
					
					$this->loadModel('Merchantnote');
					$noteData['Merchantnote']['merchantID'] = $pipelineData['Merchantpipeline']['merchantID'];
					$noteData['Merchantnote']['enteredBy'] 	= $agentID;					
					$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
					//$noteData['Merchantnote']['note'] 	= $_POST['note']." on Date ".CURRENTDATE;
					$noteData['Merchantnote']['note'] 	   	= "Merchant has been added successfully on Date ".CURRENTDATE;
					$this->Merchantnote->save($noteData);	
					// send success message				
					echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Success</response_message><Success_msg>Your Information has been saved successfully.</Success_msg></response>';exit;					
				}else{
					echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Failure</response_message><Failure_msg>Database Problem! Please try again.</Failure_msg></response>';exit;
				}
			}else{
				echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Failure</response_message><Failure_msg>Your api username and password are not correct.</Failure_msg></response>';exit;
			}
		}
	}
	
	


	public function superadmin_merchantapisuccess() {
		$this->layout = "onlineMerchantApi-2";
	}

	// Method for fill the rest merchant basic information by merchant (step 3 of pre-app request)
	public function superadmin_merchantbasicinfo($merchantID=NULL) {
		$this->layout = "onlineMerchantApi-2";
		$errorsArr = '';
	
		$this->loadModel('State');
		$stateList = $this->State->find('list', array('fields'=>array("state_abrev","state_name"),'order'=>array('state_name asc')));
		$this->set('stateList',$stateList);
		
		$this->loadModel('Merchant');

		if($this->request->is('get')){
			$this->request->data = $merchantInfo = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			$this->set('id',$merchantID);
			
			$count =  $this->Merchant->find('count', array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.statusID'=>'3')));
			if($count!=1){
				$this->Session->write('popup','Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.');
				$this->Session->setFlash('Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
			}

		}elseif($this->request->is('post')){
			//pr($this->request->data);
			$merchantID = $this->request->data['Merchant']['id'];
			$this->Merchant->set($this->request->data);
			if(!$this->Merchant->validates())
			{
			 $errorsArr = $this->Merchant->validationErrors;
			}

			if($errorsArr)
			{
				$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
				$this->set('id',$merchantID);
			}

			else {
				
				$this->request->data['Merchant']['legalAddress'] = $this->request->data['Merchant']['legalAddress']."\n".$this->request->data['Merchant']['legalAddress2'];
				if($this->Merchant->save($this->request->data)) {
					$this->Session->delete('response');
					$this->redirect(array('controller'=>'apis','action' => "apiownerinfo/".$merchantID));
				}

			}//end if not error

		}// end if of check data array

	}

	function superadmin_merchantpdf($merchantID = null)
	{
		$this->layout = "onlineMerchantApi-2";
		$this->loadModel('Merchant');
		$this->loadModel('Owner');
		$this->loadModel('Rate');
		$this->loadModel('Merchanttransaction');

		if($this->request->is('get')){			
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			$RatesData = $this->Rate->find('first',array('conditions'=>array('Rate.merchantID'=>$merchantID)));
			$TransData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.merchantID'=>$merchantID)));
			$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));

			$this->request->data = array_merge($MerchantData, $RatesData, $TransData);
			$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
			if($OwnerData){
				$OwnerData = $this->Owner->find('all',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
				$this->set('OwnerData',$OwnerData);
			}

			$selected_months = explode(",",$this->request->data['Merchant']['monthNames']);
			$selected_adsmethod = explode(",",$this->request->data['Merchant']['advertiseMethod']);
			$this->set('selected_months',$selected_months);
			$this->set('selected_adsmethod',$selected_adsmethod);
			
			$count =  $this->Merchant->find('count', array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.merchantSign!=""')));
			if($count!=1){
				$this->Session->write('popup','You are not eligible to open this URL. First upload your signature to your pre-app request to open this URL.');
				$this->Session->setFlash('You are not eligible to open this URL. First upload your signature to your pre-app request to open this URL.');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
			}
			
		}
		
	}

	function superadmin_downloadpdf($merchantID = null)
	{
		// increase memory limit in PHP
		ini_set('memory_limit', '256M');
		$this->loadModel('Merchant');
		$this->loadModel('Owner');
		$this->loadModel('Rate');
		$this->loadModel('Merchanttransaction');
		$this->loadModel('MerchantSiteSurvey');
	
		if($this->request->is('get')){
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			$RatesData = $this->Rate->find('first',array('conditions'=>array('Rate.merchantID'=>$merchantID)));
			$TransData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.merchantID'=>$merchantID)));
			$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
			if($RatesData)
				$MerchantData = array_merge($MerchantData, $RatesData);
			if($TransData)
				$MerchantData = array_merge($MerchantData, $TransData);	
					
			$this->request->data = $MerchantData;
			
			$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
			if($OwnerData){
				$OwnerData = $this->Owner->find('all',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
				$this->set('OwnerData',$OwnerData);
			}
			$this->MerchantSiteSurvey->recursive = -1;
			$SiteData = $this->MerchantSiteSurvey->find('first',array('conditions'=>array('MerchantSiteSurvey.merchantID'=>$merchantID)));
			if($SiteData){				
				$this->request->data['MerchantSiteSurvey'] = $SiteData['MerchantSiteSurvey'];
			}
			
			$selected_months = explode(",",$this->request->data['Merchant']['monthNames']);
			$selected_adsmethod = explode(",",$this->request->data['Merchant']['advertiseMethod']);
			$this->set('selected_months',$selected_months);
			$this->set('selected_adsmethod',$selected_adsmethod);
				
			/* commented for download pdf without signature as stated in task #2273
			 * $count =  $this->Merchant->find('count', array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.merchantSign!=""')));
			if($count!=1){
				$this->Session->write('popup','You are not eligible to open this URL. First upload your signature to your pre-app request to open this URL.');
				$this->Session->setFlash('You are not eligible to open this URL. First upload your signature to your pre-app request to open this URL.');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
			} */
				
				
			/** params for create pdf by dompdf ***/
			//echo $merchantID;die;
			$params = array(
					'download' => true,
					'name' => $merchantID.'.pdf',
					'paperOrientation' => 'portrait',
					'paperSize' => 'sra3'
			);
			$this->set($params);
				
		}
	
	}

	public function superadmin_apiownerinfo($merchantID	 = null) {
		$this->layout = "onlineMerchantApi-2";
		$errorsArr = "";		
		$this->loadModel('Owner');
		$this->loadModel('Merchant');
		
		$this->loadModel('State');
		$stateList = $this->State->find('list', array('fields'=>array("state_abrev","state_name"),'order'=>array('state_name asc')));
		$this->set('stateList',$stateList);

		if ($this->request->is('get')) {
			$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
			if($OwnerData){
				$OwnerData = $this->Owner->find('all',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
				$this->set('OwnerData',$OwnerData);
			}

			$this->set('id',$merchantID);
			$count =  $this->Merchant->find('count', array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.statusID'=>'3')));
			
			if($count!=1){
				$this->Session->write('popup','Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.');
				$this->Session->setFlash('Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
			}
		} else {			
			$ownerCount = $this->request->data['Owner']['count'];
			$onwerpercent = 0;
			for($i=1;$i<=$ownerCount;$i++){
				$onwerpercent = $onwerpercent + $this->request->data['Owner']['ownership'.$i];
			}
			
			if($onwerpercent<50){
				$merchantID = $this->request->data['Merchant']['id'];
				$responsemessage = "Total ownership percent must be equal or greater than 50%.";
				$this->Session->write('response',$responsemessage);
				$this->redirect(array('controller'=>'apis','action' => "apiownerinfo/".$merchantID));die;
			}
			
			$this->Owner->set($this->request->data);
			if(!$this->Owner->validates())
			{
				$errorsArr = $this->Owner->validationErrors;
			}
			if($errorsArr)
			{
				$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
				$this->set('id',$merchantID);
			}else{
				$merchantID = $this->request->data['Merchant']['id'];
				// insert data in Owner
				$this->Owner->deleteAll(array('Owner.merchantID' => $merchantID), false);
				for($i=1;$i<=$ownerCount;$i++){
					$this->Owner->create();
					$this->request->data['Owner']['name'] = $this->request->data['Owner']['name'.$i];
					$this->request->data['Owner']['title'] = $this->request->data['Owner']['title'.$i];
					$this->request->data['Owner']['ownership'] = $this->request->data['Owner']['ownership'.$i];
					$this->request->data['Owner']['dob'] = $this->request->data['Owner']['dob'.$i];
					$this->request->data['Owner']['licenceNumber'] = $this->request->data['Owner']['licenceNumber'.$i];
					$this->request->data['Owner']['socialSecurityNumber'] = $this->request->data['Owner']['socialSecurityNumber'.$i];
					$this->request->data['Owner']['homeAddress'] = $this->request->data['Owner']['homeAddress'.$i];
					$this->request->data['Owner']['city'] = $this->request->data['Owner']['city'.$i];
					$this->request->data['Owner']['state'] = $this->request->data['Owner']['state'.$i];
					$this->request->data['Owner']['zip'] = $this->request->data['Owner']['zip'.$i];
					$this->request->data['Owner']['homePhone'] = $this->request->data['Owner']['homePhone'.$i];
					$this->request->data['Owner']['merchantID'] = $merchantID;
					if($this->request->data['Owner']['name']!="")
						$this->Owner->save($this->request->data);
				}
				$this->redirect(array('controller'=>'apis','action' => "apiprofileinfo/".$merchantID));

			}

		}

	}

	public function superadmin_apiprofileinfo($merchantID	 = null) {
		$this->layout = "onlineMerchantApi-2";
		$errorsArr = '';
		$this->loadModel('Merchant');
		$this->loadModel('Merchanttransaction');
		$merchantDBA = '';
		$this->Session->delete('response');
		
		if ($this->request->is('get')) {
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));			
			$TransData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.merchantID'=>$merchantID)));
			if($TransData){
				$this->request->data = array_merge($MerchantData, $TransData);				
			}else{
				$this->request->data = $MerchantData;
			}
			$this->set('id',$merchantID);
			$this->set('agentEmail',$MerchantData['Agent']['userEmail']);
			$this->set('managerEmail',$MerchantData['Manager']['userEmail']);
			$selected_months = explode(",",$MerchantData['Merchant']['monthNames']);
			$selected_adsmethod = explode(",",$MerchantData['Merchant']['advertiseMethod']);
			$this->set('selected_months',$selected_months);
			$this->set('selected_adsmethod',$selected_adsmethod);

			$count =  $this->Merchant->find('count', array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.statusID'=>'3')));

			if($count!=1){
				$this->Session->write('popup','Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.');
				$this->Session->setFlash('Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.');
				$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));
			}
			
		}else{
			$merchantID = $this->request->data['Merchant']['id'];
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			$merchantDBA = $MerchantData['Merchant']['merchantDBA'];
			$this->Merchant->set($this->request->data);
			$this->Merchanttransaction->set($this->request->data);
			if(!$this->Merchant->validates())
			{
				$errorsArr = $this->Merchant->validationErrors;
			}
			if(!$this->Merchanttransaction->validates())
			{
				$errorsArr = $this->Merchanttransaction->validationErrors;
			}
			if($errorsArr)
			{
				$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
				$this->set('id',$merchantID);
				$this->set('agentEmail',$this->request->data['Merchant']['agentEmail']);
				$this->set('managerEmail',$this->request->data['Merchant']['managerEmail']);
			}else{
				// merchant status change to 3 for incomplete list
				/* $this->request->data['Merchant']['statusID'] = '3';
				$this->request->data['Merchant']['incompleteDate'] = date('Y-m-d'); */
				$merchantID = $this->request->data['Merchant']['id'];
				if($this->request->data['Merchant']['describePolicy']!=''){
					$this->request->data['Merchant']['hasRefundPolicy'] = 'yes';
				}

				$email = new CakeEmail("smtp");
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				$subject = "Merchant Status has been changed to Incomplete";
				$bodyText = "Hello, <br> Your Merchant ".$merchantDBA." has submitted information successfully. The status of your merchant has been changed form Pre-App to Incomplete successfully. Go to your account and proceed next step for your merchant.";
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));	
								

				if($this->Merchant->save($this->request->data)) {
					//update merchant transaction values
					if(isset($this->request->data['Merchanttransaction'])){
						$this->Merchanttransaction->deleteAll(array('Merchanttransaction.merchantID' => $merchantID), false);
						$this->request->data['Merchanttransaction']['merchantID'] = $merchantID;
						$this->Merchanttransaction->save($this->request->data);
					}
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
					$pipelineData['Merchantpipeline']['statusFrom'] = 2;
					$pipelineData['Merchantpipeline']['statusTo'] = 3;
					$pipelineData['Merchantpipeline']['statusToDate'] = date('Y-m-d');
					$this->Merchantpipeline->save($pipelineData);
					//send to agent
					$sendtoagent = $this->request->data['Merchant']['agentEmail'];
					if($sendtoagent!=''){
						$email->to($sendtoagent);
						$email->send($bodyText);
					}
					//send to manager
					$sendtoman = $this->request->data['Merchant']['managerEmail'];
					if($sendtoman){
						$email->to($sendtoman);
						$email->send($bodyText);
					}

					//add merchant notes when change in status
					$this->loadModel('Merchantnote');
					$noteData = array();
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = '';
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = "Basic information and additional information of this merchant has been updated by merchant itself. Status of pre-app request for this merchant has been changed form Pre-App To Incomplete on Date ".$timestamp;
					$this->Merchantnote->save($noteData);

					$this->Session->write('popup','Merchant Profile has been updated successfully.');
					$this->Session->setFlash('Merchant Profile has been updated successfully.');
					$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:success"));

				}else {

					$this->Session->write('popup','Data save problem, Please try again.');
					$this->Session->setFlash('Data save problem, Please try again.');
					$this->redirect(array('controller'=>'apis','action' => "merchantapisuccess/message:failure"));

				}

			}

		}

	}

	public function superadmin_ownerdelete($ID =null,$merchantID=null) {
		$this->layout = "merchantApi";
		$this->loadModel('Owner');

		if($this->Owner->delete($ID))

		{

			$this->redirect(array('controller'=>'apis','action' => "apiownerinfo/".$merchantID));

		}

	}



	//-------------------------------- START----------------------------------------
	//-------------------------------- START----------------------------------------
	//-------------------------------- MOJOPAY API ---------------------------------


	// Method for saving 1st pre-app request from mojopay website
	// DONE
	public function superadmin_mojoapi() {
		$this->autoRender = false;
		$errorsArr ='';
		$imageUrl = Router::url('/',true);

		if(isset($_POST['username'])){
			$userid = $_POST['username'];
			$password = md5($_POST['password']);
			//$agentid = $_POST['agentID'];
			
			$this->loadModel('User');
			$this->loadModel('Merchant');
			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));

			if($count>0)
			{
				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				$agentID = intval($agentInfo['User']['id']);
				$processorID = intval($agentInfo['User']['idProcessor']);
				$isoID = intval($agentInfo['User']['idIso']);
				$managerID = $agentID;
				$this->request->data['Merchant']['startDate'] 		= date("n/j/Y");
				$this->request->data['Merchant']['sendUpDate'] 		= date("n/j/Y");
				$this->request->data['Merchant']['preappDate'] 		= date("Y-m-d");
				//$this->request->data['Merchant']['contactPhone'] 	= $_POST['contactPhone'];
				$this->request->data['Merchant']['contactName'] 	= $_POST['contactPerson'];
				$this->request->data['Merchant']['contactEmail'] 	= $_POST['contactEmail'];
				$this->request->data['Merchant']['statusID'] 		= '30'; // status 30 for underwriting stataus
				$this->request->data['Merchant']['agentID'] 		= $agentID;
				$this->request->data['Merchant']['processorID'] 	= 1357;
				/* $this->request->data['Merchant']['isoID'] 			= $isoID; */
				$this->request->data['Merchant']['managerID'] 		= $managerID;
				$this->request->data['Merchant']['referalID'] 		= $agentID;

				if($this->Merchant->save($this->request->data)) {
				
				
				$merchantID = $this->Merchant->getLastInsertID();
				$body ='Thank you for your interest in our company, we value every customer  and offer impeccable services. We will be contacting you very soon.<br/><br/>';
				
				$body = '<table width="600" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto; padding:15px 0 0 0;">
					<tbody><tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="top" style="height:71px;"><img width="27" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-left.gif"></td>
					<td align="left" width="310" valign="top" style=" height:71px; width:310px;"><a href="http://mojopay.com/"><img width="310" height="71" border="0" title="Logo" alt="logo" src="http://mojopay.com/templates/beez_20/images/logo.png"></a></td>
					<td align="left" width="120" valign="top" height="71"><img width="120" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/social-before.gif"></td>
					<td align="left" width="114" valign="bottom" height="71"><table width="114" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="bottom" height="71"><a href="http://www.facebook.com/"><img width="27" height="25" border="0" alt="Facebook" src="'.$imageUrl.'img/img_thanks_email/facebook.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://twitter.com/"><img width="25" height="25" border="0" alt="Twitter" src="'.$imageUrl.'img/img_thanks_email/twitter.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://www.linkedin.com/"><img width="25" height="25" border="0" alt="Linkedin" src="'.$imageUrl.'img/img_thanks_email/in.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="https://plus.google.com"><img width="25" height="25" border="0" alt="Share" src="'.$imageUrl.'img/img_thanks_email/share.gif"></a></td>
					</tr>
					</tbody></table></td>
					<td align="left" width="29" valign="top" height="71"><img width="29" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-right.gif"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<!--thank you heading start-->
					<td align="left" width="600" valign="middle" height="59" style="padding:0 0 0 56px;"><span style="font:18px Arial, Helvetica, sans-serif; color:#1e6ea0;">Thank you for your interest in our company,</span><br>
					<span style="font:12px Arial, Helvetica, sans-serif; color:#1e6ea0;">We value every customer and offer impeccable services. We will be contacting you very soon.</span></td>
					<!--thank you heading end-->
					</tr>
					<tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<!--your filling left part start-->
					<td width="27"></td>
					<!--your filling left part end-->
	
					<!--your filling mid part(contect) start-->
					<td align="left" width="542" valign="top"><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="542" valign="top" height="7"><img width="542" height="7" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-blue-top.gif"></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="22" bgcolor="#b5defe" style="background:#b5defe; padding:0 0 0 29px; font:12px Arial, Helvetica, sans-serif; color:#110d0e;">Your filling information is as follow:</td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="3"><img width="542" height="3" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-white-top.gif"></td>
					</tr>
					<tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td width="19" bgcolor="#b5defe" style="background:#b5defe;"></td>
					<td width="507" bgcolor="#fff"><table width="507" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					
					
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Name:</b> '.$this->request->data['Merchant']['contactName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Email:</b> <a style="font:12px Arial, Helvetica, sans-serif; color:#110d0e; text-decoration:none;" href="mailto:'.$this->request->data['Merchant']['contactName'].'">'.$this->request->data['Merchant']['contactEmail'].'</a></td>
					</tr>';
				$body .='<tr>
					<td height="50" bgcolor="fff" style="background:#fff;"></td>
					</tr>
					</tbody></table></td>
					<td width="16" bgcolor="#b5defe" style="background:#b5defe;"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="36"><a href="#"><img width="542" height="36" border="0" alt="pic" src="http://total-apps.net/merchant_full_api/images/test.gif"></a></td>
					</tr>
					</tbody></table></td>
	
					<!--your filling mid part(contect) end-->
	
					<!--your filling right part start-->
					<td width="31"></td>
					<!--your filling right part end-->
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td height="12"></td>
					</tr>
					
					</tbody></table>';
				
	
					//email to user
					$to=array('services@mojopay.com');
					//$to=array('2001@dothejob.org');
					$sendto = $to;
					$subject = "New application from www.mojopay.com";
					$bodyText = $body;
					$email = new CakeEmail("smtp");
					if($managerID!='')
						$managerEmail = $this->Common->getProcessorEmail($managerID);
					else
						$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;
	
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					$email->to($sendto);
					$email->send($bodyText);
				
				
				
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$lastMerchantId = $this->Merchant->getLastInsertID();
					$pipelineData['Merchantpipeline']['merchantID'] = $lastMerchantId;
					$pipelineData['Merchantpipeline']['statusFrom'] = 0;
					$pipelineData['Merchantpipeline']['statusTo'] = 30;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
					// add note
					$this->loadModel('Merchantnote');
					$this->Merchantnote->create();
					$noteData['Merchantnote']['merchantID'] = $lastMerchantId;
					$noteData['Merchantnote']['enteredBy'] 	= $agentID;
					$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
					$noteData['Merchantnote']['note'] 		= "Merchant has been added successfully on Date ".CURRENTDATE;
					$this->Merchantnote->save($noteData);
					//add another note
					$this->Merchantnote->create();
					$noteData['Merchantnote']['note'] 		= $_POST['note']." on Date ".CURRENTDATE;
					$this->Merchantnote->save($noteData);						
					
					echo $lastMerchantId;
				}
				else{
					echo 'false';
				}
			}else{
				echo 'false';
			}
		}else{
			echo 'false';
		}

	}



	// Method for saving --step1-- pre-app request from mojopay website
	// DONE
	public function superadmin_mojoapi1() {
		// username
		// password
		// agentID
		// merchantID

		// address
		// city
		// state
		// zip
		// contactPerson
		// contactPhone

		$this->autoRender = false;
		$errorsArr ='';

		if(isset($_POST['username'])){

			$userid = $_POST['username'];

			$password = md5($_POST['password']);

			//$agentid = $_POST['agentID'];



			$this->loadModel('User');
			$this->loadModel('Merchant');
			$this->loadModel('Owner');

			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));

			if($count>0 && isset($_POST['merchantID']) && $_POST['merchantID'] != '')

			{
				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				$agentid = intval($agentInfo['User']['id']);
				// Jitendra save merchant address info new code
				$this->request->data['Merchant']['id'] = $_POST['merchantID'];				
				$this->request->data['Owner']['merchantID'] = $_POST['merchantID'];

				$owner_old = $this->Owner->query("SELECT id FROM owners where merchantID = ".$_POST['merchantID']);
				if(isset($owner_old) && !empty($owner_old)){
					$this->request->data['Owner']['id'] = $owner_old[0]['owners']['id'];
				}
					
				if(isset($_POST['address'])){
					$this->request->data['Owner']['homeAddress'] = $_POST['address'];
					$this->request->data['Merchant']['legalAddress'] = $_POST['address'];
				}
				if(isset($_POST['city'])){
					$this->request->data['Owner']['city'] = $_POST['city'];
					$this->request->data['Merchant']['legalCity'] = $_POST['city'];
				}
				if(isset($_POST['state'])){
					$this->request->data['Owner']['state'] = $_POST['state'];
					$this->request->data['Merchant']['legalState'] = $_POST['state'];
				}
				if(isset($_POST['zip'])){
					$this->request->data['Owner']['zip'] = $_POST['zip'];
					$this->request->data['Merchant']['legalZip'] = $_POST['zip'];
				}	
				if(isset($_POST['contactPerson'])){
					$this->request->data['Owner']['name'] = $_POST['contactPerson'];
				}
				if(isset($_POST['contactPhone'])){
					$this->request->data['Owner']['homePhone'] = $_POST['contactPhone'];
					$this->request->data['Merchant']['contactPhone'] = $_POST['contactPhone'];
				}
				if($this->Owner->save($this->request->data) && $this->Merchant->save($this->request->data)) {
					echo $_POST['merchantID'];
				}
				else{
					echo 'false';
				}
				
				// add note
				$this->loadModel('Merchantnote');
				$noteData['Merchantnote']['merchantID'] = $_POST['merchantID'];
				$noteData['Merchantnote']['enteredBy'] 	= $agentid;
				$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
				$noteData['Merchantnote']['note'] 		= $_POST['note']." on Date ".CURRENTDATE;
				$this->Merchantnote->save($noteData);

			}else{

				echo 'false';
			}

		}else{

			echo 'false';
		}

	}




	// Method for saving --setp2-- pre-app request from mojopay website
	// DONE
	public function superadmin_mojoapi2() {
		// username
		// password
		// agentID
		// merchantID

		// merchantURL
		// volume
		// avgMonVisaVolume
		// highestTicketAmount


		// website address -- Merchant -- merchantURL
		// Estimated Monthly Volume -- Merchant -- volume
		// Average Transaction Size -- merchanttransactions -- avgMonVisaVolume
		// Maximum Transaction Size -- merchanttransactions -- highestTicketAmount
		
		$this->autoRender = false;
		$errorsArr ='';

		if(isset($_POST['username'])){

			$userid = $_POST['username'];
			$password = md5($_POST['password']);
			//$agentid = $_POST['agentID'];

			$this->loadModel('User');
			$this->loadModel('Merchanttransaction');
			$this->loadModel('Merchant');
			
			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
			if($count>0 && isset($_POST['merchantID']) && $_POST['merchantID'] != '')
			{
				$agentInfo  =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				$agentid 	= intval($agentInfo['User']['id']);
				$this->request->data['Merchant']['id'] = $_POST['merchantID'];
				$this->request->data['Merchanttransaction']['merchantID'] = $_POST['merchantID'];

				if(isset($_POST['volume'])){
					$this->request->data['Merchant']['volume'] = $_POST['volume'];
				}
				if(isset($_POST['merchantURL'])){
					$this->request->data['Merchant']['merchantURL'] = $_POST['merchantURL'];
				}
				if(isset($_POST['avgMonVisaVolume'])){
					$this->request->data['Merchanttransaction']['avgMonVisaVolume'] = $_POST['avgMonVisaVolume'];
				}
				if(isset($_POST['highestTicketAmount'])){
					$this->request->data['Merchanttransaction']['highestTicketAmount'] = $_POST['highestTicketAmount'];
				}
				//if the merchanttransactions info already exists for this merchant then update it.
				$merchanttransaction_old = $this->Merchanttransaction->query("SELECT id FROM merchanttransactions where merchantID = ".$_POST['merchantID']);
				if(isset($merchanttransaction_old)){
					$this->request->data['Merchanttransaction']['id'] = $merchanttransaction_old[0]['merchanttransactions']['id'];
				}

				if($this->Merchant->save($this->request->data) && $this->Merchanttransaction->save($this->request->data)) {
					echo $_POST['merchantID'];
				}
				else{
					echo 'false';
				}
				
				// add note
				$this->loadModel('Merchantnote');
				$noteData['Merchantnote']['merchantID'] = $_POST['merchantID'];
				$noteData['Merchantnote']['enteredBy'] 	= $agentid;
				$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
				$noteData['Merchantnote']['note'] 		= $_POST['note']." on Date ".CURRENTDATE;
				$this->Merchantnote->save($noteData);

			}else{
				echo 'false';
			}

		}else{
			echo 'false';
		}

	}






	// Method for saving --setp3-- pre-app request from mojopay website

	public function superadmin_mojoapi3() {
		// username
		// password
		// agentID
		// merchantID

		// busi_cat_id
		// merchantName
		// federalTaxId
		// accountNumber
		// transitNumber
		// socialSecurityNumber
		// dob

		// Merchant -- busi_cat_id -- What type of business do you have?
		// Merchant -- merchantName -- Business Legal Name
		// Merchant -- federalTaxId -- Tax ID (EIN)
		// Merchant -- accountNumber  -- Bank Account
		// Merchant -- transitNumber  -- Routing Number
		// Owner -- socialSecurityNumber -- Social Security Number
		// Owner -- dob -- Your Birthday



		$this->autoRender = false;
		$errorsArr ='';

		if(isset($_POST['username'])){

			$userid = $_POST['username'];
			$password = md5($_POST['password']);
			//$agentid = $_POST['agentID'];

			$this->loadModel('User');
			$this->loadModel('Owner');
			$this->loadModel('Merchant');

			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));

			if($count>0 && isset($_POST['merchantID']) && $_POST['merchantID'] != '')
			{
				
				$this->request->data['Merchant']['id'] = $_POST['merchantID'];

				if(isset($_POST['busi_cat_id'])){
					$this->request->data['Merchant']['busi_cat_id'] = $_POST['busi_cat_id'];
					//$this->request->data['Merchant']['accountCategory'] = $_POST['busi_cat_id'];
				}
				if(isset($_POST['merchantName'])){
					$this->request->data['Merchant']['merchantName'] = $_POST['merchantName'];
					$this->request->data['Merchant']['merchantDBA'] = $_POST['merchantName'];
				}
				if(isset($_POST['federalTaxId'])){
					$this->request->data['Merchant']['federalTaxId'] = $_POST['federalTaxId'];
				}				
				if(isset($_POST['accountNumber'])){
					$this->request->data['Merchant']['accountNumber'] = $_POST['accountNumber'];
				}
				if(isset($_POST['transitNumber'])){
					$this->request->data['Merchant']['transitNumber'] = $_POST['transitNumber'];
				}

				$owner_old = $this->Owner->query("SELECT id FROM owners where merchantID = ".$_POST['merchantID']);
				if(isset($owner_old)){
					$this->request->data['Owner']['id'] = $owner_old[0]['owners']['id'];
					$this->request->data['Owner']['socialSecurityNumber'] = $_POST['socialSecurityNumber'];
					$this->request->data['Owner']['dob'] = $_POST['dob'];
					if($this->Merchant->save($this->request->data) && $this->Owner->save($this->request->data)) {
						echo $_POST['merchantID'];						
					}
				}
				else{
					echo 'false';
				}
			}else{
				echo 'false';
			}
		}else{
			echo 'false';
		}
	}



	// Method for saving --setp4-- pre-app request from mojopay website

	public function superadmin_mojoapi4() {
		// username
		// password
		// agentID
		// merchantID

		$this->autoRender = false;
		$errorsArr ='';

		if(isset($_POST['username'])){

			$userid = $_POST['username'];

			$password = md5($_POST['password']);

			$agentid = $_POST['agentID'];

			$this->loadModel('User');

			$this->loadModel('Merchant');

			$count = $this->User->find('count', array('conditions'=>array("User.id" => $agentid, "User.username" => $userid, "User.password" => $password)));

			if($count>0 && isset($_POST['merchantID']) && $_POST['merchantID'] != '')
			{

				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.id" => $agentid, "User.username" => $userid, "User.password" => $password)));

				$agentID = intval($agentInfo['User']['id']);

				$processorID = intval($agentInfo['User']['idProcessor']);

				$isoID = intval($agentInfo['User']['idIso']);

				$managerID = intval($agentInfo['User']['idManager']);

				// Add status update in merchant pipeline
				$this->loadModel('Merchantpipeline');

				$pipelineData = array();

				$lastMerchantId = $_POST['merchantID'];

				$pipelineData['Merchantpipeline']['merchantID'] = $lastMerchantId;

				$pipelineData['Merchantpipeline']['statusFrom'] = 1;

				$pipelineData['Merchantpipeline']['statusTo'] = 3;

				$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");

				$this->Merchantpipeline->save($pipelineData);


				//--------------------------------------------------------------------
				//-------------EMAIL---------------START------------------------------
				//--------------------------------------------------------------------


				//email to client for the completion of the registration process (lead and preapp complete)

				$body ='Thank you for your interest in our company,  We value every customer and offer impeccable services. We will be contacting you very soon.';
				

				//email to user
				$merchant_old = $this->Merchant->query("SELECT contactEmail FROM merchants where id = ".$_POST['merchantID']);
				if(isset($merchant_old)){
					$send_to = 	$merchant_old[0]['merchants']['contactEmail'] ? $merchant_old[0]['merchants']['contactEmail'] : 'services@total-apps.com';
				}
				$sendto = $send_to;

				$subject = "New application from www.total-apps.com";

				$bodyText = $body;

				$email = new CakeEmail("smtp");
				

				if($managerID!='')
					$managerEmail = $this->Common->getProcessorEmail($managerID);
				else
					$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;


				if($managerEmail!='')
					$email->from(array($managerEmail));
				else
					$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				

				$email->to($sendto);
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				$email->send($bodyText);
				// send email to services@total-apps.com
				//$email->to('services@total-apps.com');
				$email->to('4008@dothejob.org');
				$email->send($bodyText);

				//--------------------------------------------------------------------
				//----------EMAIL--------------------END------------------------------
				//--------------------------------------------------------------------

				//$this->set('lastMerchantId',$lastMerchantId);
				echo $lastMerchantId;
			}
			else{
				echo 'false';
			}
		}else{
			echo 'false';
		}

	}
	//-------------------------------- MOJOPAY API ---------------------------------
	//-------------------------------- END ----------------------------------------
	//-------------------------------- END----------------------------------------
	
	function beforeRender() {
		parent::beforeRender();
		
		if (!empty($this->data['Merchant']['volume'])) {
			$volumeString = $this->merchantVolumeBeforeRender($this->data['Merchant']['volume']);
			$volume = str_replace("$", "", $volumeString);
			$this->request->data['Merchant']['volume'] = $volume;
			
		}
		return true;
	}
	
	public function merchantVolumeBeforeRender($volumeString) {		
		// called as CakeNumber
		App::uses('CakeNumber', 'Utility');
		return $currencyVolume = CakeNumber::currency($volumeString, 'USD');		
	}
	
	public function superadmin_contractExpirationNotification() {
		$this->autoRender=false;
		/** get merchant list whose expiration date is 45 day after **/
		$this->loadModel('Merchant');
		// Task id 3207
		$condition = "(Merchant.contract_expiration <= DATE_ADD(CURDATE(), INTERVAL 45 DAY) and Merchant.contract_expiration > CURDATE() ) AND Merchant.notify_email_count=0 AND Merchant.statusID!=28";
	
		$notify_merchant = $this->Merchant->find('all',array('conditions'=>$condition));	
		
		$date1 = strtotime($notify_merchant['Merchant']['contract_expiration']);
		$date2 = time();
		$dateDiff = $date1 - $date2;
		$fullDays = floor($dateDiff/(60*60*24));
		if($fullDays<0){
			$fullDays=15;
		}
			
		foreach($notify_merchant as $merchant){		
			$merchantID = $merchant['Merchant']['id'];
	  	 	$sendto = $merchant['Manager']['userEmail'];
			$subject = "Your Merchant contract expiring soon.";
			$body = "Hi ".$merchant['Manager']['user_Name'].",<br>a merchant assigned to you has a contract that will be expiring in 45 days from now. Please contact your merchant as soon as possible.<br/><br>Expiring contract Merchant information<br>".$merchant['Merchant']['merchantDBA']."<br>".$merchant['Merchant']['contactName']."<br>".$merchant['Merchant']['contactPhone']."<br><br><br>Thank you<br>Total-apps automated notification system";
			
			$bodyText = $body;
			$email = new CakeEmail("smtp");
			$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
			$email->emailFormat('html');
			$email->subject(strip_tags($subject));
			
			if(Validation::email($sendto)){
				$email->to($sendto);			
				if($email->send($bodyText)){
					$data = array('Merchant' => array('id'=>$merchantID,'notify_email_count'=>1,'contract_expiration'=>NULL));
					$this->Merchant->save( $data, false, array('notify_email_count'));
				}
			}
		}
		
	}
	
	public function superadmin_sendBirthdayEmail() {
		$this->autoRender=false;
		/** get merchant's first owner date of birth and send birthday email to merchant **/
		$this->loadModel('Owner');
		$condition = "Owner.dob IS NOT NULL AND Owner.dob!=''";
		$this->Owner->recursive = 2;
		$merchantdob = $this->Owner->find('all',array('fields'=>array('DISTINCT(Owner.merchantID)','Owner.dob'),'conditions'=>$condition,'group' => array('Owner.merchantID') ,'order'=>array('Owner.id DESC')));
		/* echo "<pre>";
		print_r($merchantdob); */
		$todayDate  = date('d-m');
		foreach($merchantdob as $merchant){
			$merchantID = $merchant['Owner']['merchantID'];
			$dob		= date('d-m',strtotime($merchant['Owner']['dob']));
			if($dob==$todayDate){
				$sendto 	= $merchant['Merchant']['contactEmail'];
				$subject 	= "Wish you a very happy birthday.";
				$bodyText 	= $this->Common->getBirthdayEmailTemplate($merchant['Merchant']['Manager']['email_template_id']);
				$bodyText	.= "<br/>".$merchant['Merchant']['Manager']['user_Name']."<br/>".$merchant['Merchant']['Manager']['userEmail']."<br/>".$merchant['Merchant']['Manager']['userPhone']."<br/>www.total-apps.com";
				
				$email    = new CakeEmail("smtp");
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				if(Validation::email($sendto)){
					$email->to($sendto);
					$email->send($bodyText);
				}
			}
		}
	}
	
	// Method for getting referral URL of an user
	public function superadmin_getResponseUrl($referralID = null){
		$this->layout = false;
		$this->autoRender = false;
	
		if($referralID){
			$this->loadModel('Usermgmt.User');
			$this->loadModel('ReferralLink');
			$getDefaultUrl = $this->ReferralLink->find('first', array('fields'=>array('ReferralLink.id','ReferralLink.referral_link'),'conditions'=>array("ReferralLink.id" => 1)));
			
			$this->User->unbindModel(array('hasMany' => array('UserGroupJoin')), true);
			$this->User->recursive = 2;
			$getUrl = $this->User->find('first', array('fields'=>array('User.id','User.referral_link_id'),'conditions'=>array("User.id" => $referralID)));
			
			if($getUrl['ReferralLink']['referral_link']!=""){
				$text = '<?xml version="1.0" encoding="utf-8"?>
				<post>
				<id>'.$getUrl['User']['id'].'</id>
				<referral_url>'.$getUrl['ReferralLink']['referral_link'].'</referral_url>
				</post>';
			}else{
				$text = '<?xml version="1.0" encoding="utf-8"?>
				<post>
				<id>'.$getUrl['User']['id'].'</id>
				<referral_url>'.$getDefaultUrl['ReferralLink']['referral_link'].'</referral_url>
				</post>';
			}
			
			echo $text;
			die();
		}
	}
	
	// Method for saving pre-app request from main website or any other referral website
	public function superadmin_fullapi() {
		$this->layout = "merchantApi";
		$errorsArr ='';
		$api_response_xml = "";
		$errormsg = "";
		$merchantID = "";
		$imageUrl = Router::url('/',true);
		if(isset($_POST['merchantName']) && $_POST['contactPhone']!='Contact Phone Number' && $_POST['volume']!='Monthly Sales Volume'){
			//echo $_POST['output'];die;
			$userid = $_POST['username'];
			$password = md5($_POST['password']);
	
			$this->loadModel('User');
			$this->loadModel('Merchant');
	
			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
			if($count>0)
			{
				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				if($_POST['referalID']==""){
					$agentID = intval($agentInfo['User']['id']);
				}else{
					if($this->Common->isRoleAgent($_POST['referalID'])){
						$agentID = $_POST['referalID'];
					}else{
						$agentID = intval($agentInfo['User']['id']);
					}
				}
	
				$processorID 	= intval($agentInfo['User']['idProcessor']);
				$isoID 			= intval($agentInfo['User']['idIso']);
				$managerID 		= intval($agentInfo['User']['idManager']);
				foreach($_POST as $key => $value){
					$this->request->data['Merchant'][$key] 	=	 trim($_POST[$key]);
				}
				$this->request->data['Merchant']['sendUpDate'] 		=	 date("n/j/Y");
				$this->request->data['Merchant']['preappDate'] 		=	 date("Y-m-d");
				$this->request->data['Merchant']['statusID'] 		=	 '1'; // status 1 for preapp1 or Lead
				$this->request->data['Merchant']['agentID'] 		=	 $agentID;
				$this->request->data['Merchant']['processorID'] 	=	 $processorID;
				$this->request->data['Merchant']['isoID'] 			=	 $isoID;
				$this->request->data['Merchant']['managerID'] 		=	 $agentID;
				$this->request->data['Merchant']['user_ref_id'] 	=	 "user_ref".$_POST['referalID'];
	
				$this->Merchant->set($this->request->data);
				if(!$this->Merchant->validates())
				{
					$errorsArr = $this->Merchant->validationErrors;
				}
				if($errorsArr)
				{
					echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Failure</response_message><Failure_msg>Please provide all field values correctly.</Failure_msg></response>';exit;
				}
	
				if($this->Merchant->save($this->request->data)) {
					$merchantID = $this->Merchant->getLastInsertID();
					$body ='Thank you for your interest in our company, we value every customer  and offer impeccable services. We will be contacting you very soon.<br/> Your filling information is as follow:<br/><br/>';
	
					if($_POST['businessType']==1)
					$businessType = 'Swipe';
					elseif($_POST['accountCategory']==2)
					$businessType = 'MOTO';
					elseif($_POST['accountCategory']==3)
					$businessType = 'Internet';
					elseif($_POST['accountCategory']==4)
					$businessType = 'Mobile';
					elseif($_POST['accountCategory']==5)
					$businessType = 'Equipment';
					elseif($_POST['accountCategory']==6)
					$businessType = 'Gateway';
					elseif($_POST['accountCategory']==7)
					$businessType = 'Other';
					elseif($_POST['accountCategory']==8)
					$businessType = 'USB Swipe';
					elseif($_POST['accountCategory']==10)
					$businessType = 'PSP';
					elseif($_POST['accountCategory']==11)
					$businessType = 'Gift Cards';
					elseif($_POST['accountCategory']==12)
					$businessType = 'ACH';
	
					//email to user
					$sendto = $this->request->data['Merchant']['contactEmail'];
					$subject = "New application from www.total-apps.com";
	
					$body = '<table width="600" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto; padding:15px 0 0 0;">
					<tbody><tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="top" style="height:71px;"><img width="27" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-left.gif"></td>
					<td align="left" width="310" valign="top" style=" height:71px; width:310px;"><a href="http://www.total-apps.com/"><img width="310" height="71" border="0" title="Logo" alt="logo" src="'.$imageUrl.'img/img_thanks_email/logo.jpg"></a></td>
					<td align="left" width="120" valign="top" height="71"><img width="120" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/social-before.gif"></td>
					<td align="left" width="114" valign="bottom" height="71"><table width="114" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="bottom" height="71"><a href="http://www.facebook.com/pages/Total-Appscom/247493926859"><img width="27" height="25" border="0" alt="Facebook" src="'.$imageUrl.'img/img_thanks_email/facebook.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://twitter.com/#!/search?q=%22total-apps%22"><img width="25" height="25" border="0" alt="Twitter" src="'.$imageUrl.'img/img_thanks_email/twitter.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://www.linkedin.com/company/747373"><img width="25" height="25" border="0" alt="Linkedin" src="'.$imageUrl.'img/img_thanks_email/in.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="https://plus.google.com/108566311544410849381/posts"><img width="25" height="25" border="0" alt="Share" src="'.$imageUrl.'img/img_thanks_email/share.gif"></a></td>
					</tr>
					</tbody></table></td>
					<td align="left" width="29" valign="top" height="71"><img width="29" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-right.gif"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<!--thank you heading start-->
					<td align="left" width="600" valign="middle" height="59" style="padding:0 0 0 56px;"><span style="font:18px Arial, Helvetica, sans-serif; color:#1e6ea0;">Thank you for your interest in our company,</span><br>
					<span style="font:12px Arial, Helvetica, sans-serif; color:#1e6ea0;">We value every customer and offer impeccable services. We will be contacting you very soon.</span></td>
					<!--thank you heading end-->
					</tr>
					<tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<!--your filling left part start-->
					<td width="27"></td>
					<!--your filling left part end-->
	
					<!--your filling mid part(contect) start-->
					<td align="left" width="542" valign="top"><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="542" valign="top" height="7"><img width="542" height="7" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-blue-top.gif"></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="22" bgcolor="#b5defe" style="background:#b5defe; padding:0 0 0 29px; font:12px Arial, Helvetica, sans-serif; color:#110d0e;">Your filling information is as follow:</td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="3"><img width="542" height="3" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-white-top.gif"></td>
					</tr>
					<tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td width="19" bgcolor="#b5defe" style="background:#b5defe;"></td>
					<td width="507" bgcolor="#fff"><table width="507" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Name:</b> '.$_POST['merchantName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Site:</b> '.$_POST['merchantURL'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Name:</b> '.$_POST['contactName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Email:</b> <a style="font:12px Arial, Helvetica, sans-serif; color:#110d0e; text-decoration:none;" href="mailto:'.$_POST['contactEmail'].'">'.$_POST['contactEmail'].'</a></td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Phone:</b> '.$_POST['contactPhone'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Sales Volume:</b> '.$_POST['volume'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Business/Account Type:</b> '.$businessType.' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="fff" style="background:#fff;  border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Description of product or services:</b> '.$this->request->data['Merchant']['detailExplanation'].' </td>
					</tr>';
	
					if($_POST['referalID']!=''){
						$referalname = $this->Common->getProcessorNameById($_POST['referalID']);
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral\'s Name:</b> '.$referalname.' </td>
						</tr>';
					}
					if($_POST['referral']!=''){
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral:</b> '.$_POST['referral'].' </td>
						</tr>';
					}
	
					$body .='<tr>
					<td height="50" bgcolor="fff" style="background:#fff;"></td>
					</tr>
					</tbody></table></td>
					<td width="16" bgcolor="#b5defe" style="background:#b5defe;"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="36"><a href="http://www.total-apps.com/"><img width="542" height="36" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-blue-bottom.gif"></a></td>
					</tr>
					</tbody></table></td>
	
					<!--your filling mid part(contect) end-->
	
					<!--your filling right part start-->
					<td width="31"></td>
					<!--your filling right part end-->
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td height="12"></td>
					</tr>
					<tr>
					<td align="center" width="600" valign="middle" height="33" bgcolor="#2985c0" style="background:#2985c0;"><a style="font:10px Arial, Helvetica, sans-serif; color:#fff; text-decoration:none;" href="http://www.total-apps.com/">Home  | </a> <a style="font:10px Arial, Helvetica, sans-serif; color:#fff; text-decoration:none;" href="http://www.total-apps.com/agents"> Agents  | </a> <a style="font:10px Arial, Helvetica, sans-serif; color:#fff; text-decoration:none;" href="http://www.total-apps.com/faq"> FAQ  | </a> <a style="font:10px Arial, Helvetica, sans-serif; color:#fff; text-decoration:none;" href="http://www.total-apps.com/about-us"> About Us  | </a> <a style="font:10px Arial, Helvetica, sans-serif; color:#fff; text-decoration:none;" href="http://www.total-apps.com/privacy-policy"> Privacy Policy   | </a> <a style="font:10px Arial, Helvetica, sans-serif; color:#fff; text-decoration:none;" href="http://www.total-apps.com/site-map"> Site Map   | </a> <a style="font:10px Arial, Helvetica, sans-serif; color:#fff; text-decoration:none;" href="http://www.total-apps.net/superadmin"> Referral Login  | </a> <a style="font:10px Arial, Helvetica, sans-serif; color:#fff; text-decoration:none;" href="http://www.total-apps.com/2checkout"> 2Checkout</a></td>
					</tr>
					</tbody></table>';
					$bodyText = $body;
					$email = new CakeEmail("smtp");
					//$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					if($managerID!='')
						$managerEmail = $this->Common->getProcessorEmail($managerID);
					else
						$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;
	
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					$email->to($sendto);
					//$email->bcc('4008@dothejob.org');
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					$email->send($bodyText);
					// send email to services@total-apps.com
					$email->to('services@total-apps.com');
					$email->send($bodyText);
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $this->Merchant->getLastInsertID();
					$pipelineData['Merchantpipeline']['statusFrom'] = 0;
					$pipelineData['Merchantpipeline']['statusTo'] = 1;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
	
					$this->loadModel('Merchantnote');
					$noteData['Merchantnote']['merchantID'] = $pipelineData['Merchantpipeline']['merchantID'];
					$noteData['Merchantnote']['enteredBy'] 	= $agentID;
					$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
					$noteData['Merchantnote']['note'] 		= "Merchant has been added successfully on Date ".CURRENTDATE;
					$this->Merchantnote->save($noteData);	
				}
				
				// save owner info
				if($merchantID!='' && $this->request->data['Merchant']['name1']!=''){
					$this->loadModel('Owner');
					unset($this->request->data['Merchant']);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Owner'][$key] 	=	 $value;
					}
					
					$this->Owner->set($this->request->data);
					if($this->Owner->validates())
					{	
						//insert data in Owner
						$ownerCount = $_POST['OwnerElement'];
						$this->Owner->deleteAll(array('Owner.merchantID' => $merchantID), false);
						for($i=1;$i<=$ownerCount;$i++){
							$this->Owner->create();
							$this->request->data['Owner']['name'] = $this->request->data['Owner']['name'.$i];
							$this->request->data['Owner']['title'] = $this->request->data['Owner']['title'.$i];
							$this->request->data['Owner']['ownership'] = $this->request->data['Owner']['ownership'.$i];
							$this->request->data['Owner']['dob'] = $this->request->data['Owner']['dob'.$i];
							$this->request->data['Owner']['licenceNumber'] = $this->request->data['Owner']['licenceNumber'.$i];
							$this->request->data['Owner']['socialSecurityNumber'] = $this->request->data['Owner']['socialSecurityNumber'.$i];
							$this->request->data['Owner']['homeAddress'] = $this->request->data['Owner']['homeAddress'.$i];
							$this->request->data['Owner']['city'] = $this->request->data['Owner']['city'.$i];
							$this->request->data['Owner']['state'] = $this->request->data['Owner']['state'.$i];
							$this->request->data['Owner']['zip'] = $this->request->data['Owner']['zip'.$i];
							$this->request->data['Owner']['homePhone'] = $this->request->data['Owner']['homePhone'.$i];
							$this->request->data['Owner']['merchantID'] = $merchantID;
							if($this->request->data['Owner']['name']!="")
							$this->Owner->save($this->request->data);
						}
					}
				}
				//save transaction value
				if($merchantID!='' && $_POST['highestTicketAmount']!=''){
					$this->loadModel('Merchanttransaction');
					unset($this->request->data);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Merchanttransaction'][$key] = $value;
					}
					$this->request->data['Merchanttransaction']['merchantID'] = $merchantID;
					$this->Merchanttransaction->save($this->request->data);
				}
				// pipeline status
				$status_array = array('2','3');
				$this->loadModel('Merchantpipeline');
				foreach($status_array as $value){
					$this->Merchantpipeline->create();
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
					$pipelineData['Merchantpipeline']['statusFrom'] = $value-1;
					$pipelineData['Merchantpipeline']['statusTo'] = $value;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
					//update status date in pipeline
					if($value=='2'){
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'preappDate'=>date("Y-m-d")));
						$this->Merchant->save( $data, false, array('statusID','preappDate'));
					}else{
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'incompleteDate'=>date("Y-m-d")));
						$this->Merchant->save( $data, false, array('statusID','incompleteDate'));
					}
						
				}
				// save signature
				if($_POST['output']!=''){
					//$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(350, 150)));
					$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(235, 55)));
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					imagedestroy($img);
					
					######### Resize Imgae By Jitendra Pradhan	##########								
					/*$imageInfo = getimagesize($filePath);					
					$destinationWidth = "198";
					$destinationHeight = "55";					
					// Find the intial size of the image
					$sourceWidth = $imageInfo[0];
					$sourceHeight = $imageInfo[1];
					// Create the destination for the new image
					$destination = imagecreatetruecolor($destinationWidth, $destinationHeight);					
					// Now image resize appropriately					
					$source = imagecreatefrompng($filePath);
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
					imagepng($destination, $filePath);
					// Free up memory
					imagedestroy($source);
					imagedestroy($destination);*/
					############## Resize end #############
					
					// Output to browser
					/*header('Content-Type: image/png');
					imagepng($img);*/

					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Destroy the image in memory when complete
					//imagedestroy($img);
	
				}else{ // if sign is Text
					$img = imagecreatetruecolor(350, 30);
					$bgColour = imagecolorallocate($img, 0xff, 0xff, 0xff);
					$penColour = imagecolorallocate($img, 0x14, 0x53, 0x94);
					imagefilledrectangle($img, 0, 0, 399, 29, $bgColour);
					$text = $_POST['name'];
					$font = WWW_ROOT.'VLADIMIR.TTF';
					imagettftext($img, 20, 0, 10, 20, $penColour, $font, $text);
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Output to browser
					/*header('Content-Type: image/png');
					 imagepng($img);*/
					imagedestroy($img);
				}		
				
				echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Success</response_message><Success_msg>Your Information has been saved successfully.</Success_msg></response>';exit;
	
			}
		}
	}
	
	
	
	
	// Method for saving pre-app request from totalapps.com website 
	public function superadmin_fullapi_totalapss(){
		$this->layout = "merchantApi";
		$errorsArr ='';
		$api_response_xml = "";
		$errormsg = "";
		$merchantID = "";
		$imageUrl = Router::url('/',true);
		if(isset($_POST['merchantName']) && $_POST['contactPhone']!='Contact Phone Number' && $_POST['volume']!='Monthly Sales Volume'){
			//echo $_POST['output'];die;
			$userid = $_POST['username'];
			$password = md5($_POST['password']);
	
			$this->loadModel('User');
			$this->loadModel('Merchant');
	
			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
			if($count>0)
			{
				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				if($_POST['referalID']==""){
					$agentID = intval($agentInfo['User']['id']);
				}else{
					if($this->Common->isRoleAgent($_POST['referalID'])){
						$agentID = $_POST['referalID'];
					}else{
						$agentID = intval($agentInfo['User']['id']);
					}
				}
	
				$processorID 	= intval($agentInfo['User']['idProcessor']);
				$isoID 			= intval($agentInfo['User']['idIso']);
				$managerID 		= intval($agentInfo['User']['idManager']);
				foreach($_POST as $key => $value){
					$this->request->data['Merchant'][$key] 	=	 trim($_POST[$key]);
				}
				$this->request->data['Merchant']['sendUpDate'] 		=	 date("n/j/Y");
				$this->request->data['Merchant']['preappDate'] 		=	 date("Y-m-d");
				$this->request->data['Merchant']['statusID'] 		=	 '1'; // status 1 for preapp1 or Lead
				$this->request->data['Merchant']['agentID'] 		=	 $agentID;
				$this->request->data['Merchant']['processorID'] 	=	 $processorID;
				$this->request->data['Merchant']['isoID'] 			=	 $isoID;
				$this->request->data['Merchant']['managerID'] 		=	 $agentID;
				$this->request->data['Merchant']['user_ref_id'] 	=	 "user_ref".$_POST['referalID'];
	
				$this->Merchant->set($this->request->data);
				if(!$this->Merchant->validates())
				{
					$errorsArr = $this->Merchant->validationErrors;
				}
				if($errorsArr)
				{
					echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Failure</response_message><Failure_msg>Please provide all field values correctly.</Failure_msg></response>';exit;
				}
	
				if($this->Merchant->save($this->request->data)) {
					$merchantID = $this->Merchant->getLastInsertID();
					$body ='Thank you for your interest in our company, we value every customer  and offer impeccable services. We will be contacting you very soon.<br/> Your filling information is as follow:<br/><br/>';
	
					if($_POST['businessType']==1)
					$businessType = 'Swipe';
					elseif($_POST['accountCategory']==2)
					$businessType = 'MOTO';
					elseif($_POST['accountCategory']==3)
					$businessType = 'Internet';
					elseif($_POST['accountCategory']==4)
					$businessType = 'Mobile';
					elseif($_POST['accountCategory']==5)
					$businessType = 'Equipment';
					elseif($_POST['accountCategory']==6)
					$businessType = 'Gateway';
					elseif($_POST['accountCategory']==7)
					$businessType = 'Other';
					elseif($_POST['accountCategory']==8)
					$businessType = 'USB Swipe';
					elseif($_POST['accountCategory']==10)
					$businessType = 'PSP';
					elseif($_POST['accountCategory']==11)
					$businessType = 'Gift Cards';
					elseif($_POST['accountCategory']==12)
					$businessType = 'ACH';
	
					//email to user
					
					$to=array($this->request->data['Merchant']['contactEmail']);
					$sendto = $to;
					
					//$sendto = $this->request->data['Merchant']['contactEmail'];
					$subject = "New application from www.total-apps.com";
	
					$body = '<table width="600" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto; padding:15px 0 0 0;">
					<tbody><tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="top" style="height:71px;"><img width="27" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-left.gif"></td>
					<td align="left" width="310" valign="top" style=" height:71px; width:310px;"><a href="http://www.total-apps.com/"><img width="310" height="71" border="0" title="Logo" alt="logo" src="'.$imageUrl.'img/img_thanks_email/logo.jpg"></a></td>
					<td align="left" width="120" valign="top" height="71"><img width="120" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/social-before.gif"></td>
					<td align="left" width="114" valign="bottom" height="71"><table width="114" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="bottom" height="71"><a href="http://www.facebook.com/pages/Total-Appscom/247493926859"><img width="27" height="25" border="0" alt="Facebook" src="'.$imageUrl.'img/img_thanks_email/facebook.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://twitter.com/#!/search?q=%22total-apps%22"><img width="25" height="25" border="0" alt="Twitter" src="'.$imageUrl.'img/img_thanks_email/twitter.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://www.linkedin.com/company/747373"><img width="25" height="25" border="0" alt="Linkedin" src="'.$imageUrl.'img/img_thanks_email/in.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="https://plus.google.com/108566311544410849381/posts"><img width="25" height="25" border="0" alt="Share" src="'.$imageUrl.'img/img_thanks_email/share.gif"></a></td>
					</tr>
					</tbody></table></td>
					<td align="left" width="29" valign="top" height="71"><img width="29" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-right.gif"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<!--thank you heading start-->
					<td align="left" width="600" valign="middle" height="59" style="padding:0 0 0 56px;"><span style="font:18px Arial, Helvetica, sans-serif; color:#1e6ea0;">Thank you for your interest in our company,</span><br>
					<span style="font:12px Arial, Helvetica, sans-serif; color:#1e6ea0;">We value every customer and offer impeccable services. We will be contacting you very soon.</span></td>
					<!--thank you heading end-->
					</tr>
					<tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<!--your filling left part start-->
					<td width="27"></td>
					<!--your filling left part end-->
	
					<!--your filling mid part(contect) start-->
					<td align="left" width="542" valign="top"><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="542" valign="top" height="7"><img width="542" height="7" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-blue-top.gif"></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="22" bgcolor="#b5defe" style="background:#b5defe; padding:0 0 0 29px; font:12px Arial, Helvetica, sans-serif; color:#110d0e;">Your filling information is as follow:</td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="3"><img width="542" height="3" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-white-top.gif"></td>
					</tr>
					<tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td width="19" bgcolor="#b5defe" style="background:#b5defe;"></td>
					<td width="507" bgcolor="#fff"><table width="507" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Name:</b> '.$_POST['merchantName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Site:</b> '.$_POST['merchantURL'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Name:</b> '.$_POST['contactName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Email:</b> <a style="font:12px Arial, Helvetica, sans-serif; color:#110d0e; text-decoration:none;" href="mailto:'.$_POST['contactEmail'].'">'.$_POST['contactEmail'].'</a></td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Phone:</b> '.$_POST['contactPhone'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Sales Volume:</b> '.$_POST['volume'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Business/Account Type:</b> '.$businessType.' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="fff" style="background:#fff;  border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Description of product or services:</b> '.$this->request->data['Merchant']['detailExplanation'].' </td>
					</tr>';
	
					if($_POST['referalID']!=''){
						$referalname = $this->Common->getProcessorNameById($_POST['referalID']);
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral\'s Name:</b> '.$referalname.' </td>
						</tr>';
					}
					if($_POST['referral']!=''){
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral:</b> '.$_POST['referral'].' </td>
						</tr>';
					}
	
					$body .='<tr>
					<td height="50" bgcolor="fff" style="background:#fff;"></td>
					</tr>
					</tbody></table></td>
					<td width="16" bgcolor="#b5defe" style="background:#b5defe;"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="36"><a href="http://www.total-apps.com/"><img width="542" height="36" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-blue-bottom.gif"></a></td>
					</tr>
					</tbody></table></td>
	
					<!--your filling mid part(contect) end-->
	
					<!--your filling right part start-->
					<td width="31"></td>
					<!--your filling right part end-->
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td height="12"></td>
					</tr>
					
					</tbody></table>';
					$bodyText = $body;
					$email = new CakeEmail("smtp");
					//$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					if($managerID!='')
						$managerEmail = $this->Common->getProcessorEmail($managerID);
					else
						$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;
	
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					$email->to($sendto);
					//$email->bcc('4008@dothejob.org');
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					$email->send($bodyText);
					// send email to services@total-apps.com
					$email->to('services@total-apps.com');
					$email->send($bodyText);
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $this->Merchant->getLastInsertID();
					$pipelineData['Merchantpipeline']['statusFrom'] = 0;
					$pipelineData['Merchantpipeline']['statusTo'] = 1;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
	
					$this->loadModel('Merchantnote');
					$noteData['Merchantnote']['merchantID'] = $pipelineData['Merchantpipeline']['merchantID'];
					$noteData['Merchantnote']['enteredBy'] 	= $agentID;
					$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
					//$noteData['Merchantnote']['note'] 		= "Merchant has been added successfully on Date ".CURRENTDATE;
					$noteData['Merchantnote']['note'] 	   	= $_POST['note']." on Date ".CURRENTDATE;
					$this->Merchantnote->save($noteData);	
				}
				
				// save owner info
				if($merchantID!='' && $this->request->data['Merchant']['name1']!=''){
					$this->loadModel('Owner');
					unset($this->request->data['Merchant']);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Owner'][$key] 	=	 $value;
					}
					
					$this->Owner->set($this->request->data);
					if($this->Owner->validates())
					{	
						//insert data in Owner
						$ownerCount = $_POST['OwnerElement'];
						$this->Owner->deleteAll(array('Owner.merchantID' => $merchantID), false);
						for($i=1;$i<=$ownerCount;$i++){
							$this->Owner->create();
							$this->request->data['Owner']['name'] = $this->request->data['Owner']['name'.$i];
							$this->request->data['Owner']['title'] = $this->request->data['Owner']['title'.$i];
							$this->request->data['Owner']['ownership'] = $this->request->data['Owner']['ownership'.$i];
							$this->request->data['Owner']['dob'] = $this->request->data['Owner']['dob'.$i];
							$this->request->data['Owner']['licenceNumber'] = $this->request->data['Owner']['licenceNumber'.$i];
							$this->request->data['Owner']['socialSecurityNumber'] = $this->request->data['Owner']['socialSecurityNumber'.$i];
							$this->request->data['Owner']['homeAddress'] = $this->request->data['Owner']['homeAddress'.$i];
							$this->request->data['Owner']['city'] = $this->request->data['Owner']['city'.$i];
							$this->request->data['Owner']['state'] = $this->request->data['Owner']['state'.$i];
							$this->request->data['Owner']['zip'] = $this->request->data['Owner']['zip'.$i];
							$this->request->data['Owner']['homePhone'] = $this->request->data['Owner']['homePhone'.$i];
							$this->request->data['Owner']['merchantID'] = $merchantID;
							if($this->request->data['Owner']['name']!="")
							$this->Owner->save($this->request->data);
						}
					}
				}
				//save transaction value
				if($merchantID!='' && $_POST['highestTicketAmount']!=''){
					$this->loadModel('Merchanttransaction');
					unset($this->request->data);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Merchanttransaction'][$key] = $value;
					}
					$this->request->data['Merchanttransaction']['merchantID'] = $merchantID;
					$this->Merchanttransaction->save($this->request->data);
				}
				// pipeline status
				$status_array = array('2','3');
				$this->loadModel('Merchantpipeline');
				foreach($status_array as $value){
					$this->Merchantpipeline->create();
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
					$pipelineData['Merchantpipeline']['statusFrom'] = $value-1;
					$pipelineData['Merchantpipeline']['statusTo'] = $value;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
					//update status date in pipeline
					if($value=='2'){
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'preappDate'=>date("Y-m-d")));
						$this->Merchant->save( $data, false, array('statusID','preappDate'));
					}else{
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'incompleteDate'=>date("Y-m-d")));
						$this->Merchant->save( $data, false, array('statusID','incompleteDate'));
					}
						
				}
				// save signature
				if($_POST['output']!=''){
					//$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(350, 150)));
					$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(235, 55)));
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					imagedestroy($img);
					
					######### Resize Imgae By Jitendra Pradhan	##########								
					/*$imageInfo = getimagesize($filePath);					
					$destinationWidth = "198";
					$destinationHeight = "55";					
					// Find the intial size of the image
					$sourceWidth = $imageInfo[0];
					$sourceHeight = $imageInfo[1];
					// Create the destination for the new image
					$destination = imagecreatetruecolor($destinationWidth, $destinationHeight);					
					// Now image resize appropriately					
					$source = imagecreatefrompng($filePath);
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
					imagepng($destination, $filePath);
					// Free up memory
					imagedestroy($source);
					imagedestroy($destination);*/
					############## Resize end #############
					
					// Output to browser
					/*header('Content-Type: image/png');
					imagepng($img);*/

					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Destroy the image in memory when complete
					//imagedestroy($img);
	
				}else{ // if sign is Text
					$img = imagecreatetruecolor(350, 30);
					$bgColour = imagecolorallocate($img, 0xff, 0xff, 0xff);
					$penColour = imagecolorallocate($img, 0x14, 0x53, 0x94);
					imagefilledrectangle($img, 0, 0, 399, 29, $bgColour);
					$text = $_POST['name'];
					$font = WWW_ROOT.'VLADIMIR.TTF';
					imagettftext($img, 20, 0, 10, 20, $penColour, $font, $text);
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Output to browser
					/*header('Content-Type: image/png');
					 imagepng($img);*/
					imagedestroy($img);
				}		
				
				echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Success</response_message><Success_msg>Your Information has been saved successfully.</Success_msg></response>';exit;
	
			}
		}
	}
	
	
	// Method for saving pre-app request from mojopay.com website 
	public function superadmin_fullapi_mojopay() {
		$this->layout = "merchantApi";
		$errorsArr ='';
		$api_response_xml = "";
		$errormsg = "";
		$merchantID = "";
		$imageUrl = Router::url('/',true);
		if(isset($_POST['merchantName']) && $_POST['contactPhone']!='Contact Phone Number' && $_POST['volume']!='Monthly Sales Volume'){
			//echo $_POST['output'];die;
			$userid = $_POST['username'];
			$password = md5($_POST['password']);
	
			$this->loadModel('User');
			$this->loadModel('Merchant');
	
			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
			if($count>0)
			{
				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				if($_POST['referalID']==""){
					$agentID = intval($agentInfo['User']['id']);
				}else{
					if($this->Common->isRoleAgent($_POST['referalID'])){
						$agentID = $_POST['referalID'];
					}else{
						$agentID = intval($agentInfo['User']['id']);
					}
				}
	
				$processorID 	= intval($agentInfo['User']['idProcessor']);
				$isoID 			= intval($agentInfo['User']['idIso']);
				$managerID 		= intval($agentInfo['User']['idManager']);
				foreach($_POST as $key => $value){
					$this->request->data['Merchant'][$key] 	=	 trim($_POST[$key]);
				}
				$this->request->data['Merchant']['sendUpDate'] 		=	 date("n/j/Y");
				$this->request->data['Merchant']['preappDate'] 		=	 date("Y-m-d");
				$this->request->data['Merchant']['statusID'] 		=	 '1'; // status 30 for Underwriting;'1'; // status 1 for preapp1 or Lead
				$this->request->data['Merchant']['agentID'] 		=	 $agentID;
				$this->request->data['Merchant']['processorID'] 	=	 1357;
				$this->request->data['Merchant']['isoID'] 			=	 $isoID;
				$this->request->data['Merchant']['managerID'] 		=	 $agentID;
				$this->request->data['Merchant']['referalID'] 		=	 $agentID;
				$this->request->data['Merchant']['user_ref_id'] 	=	 "user_ref".$_POST['referalID'];
	
				$this->Merchant->set($this->request->data);
				if(!$this->Merchant->validates())
				{
					$errorsArr = $this->Merchant->validationErrors;
				}
				if($errorsArr)
				{
					echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Failure</response_message><Failure_msg>Please provide all field values correctly.</Failure_msg></response>';exit;
				}
	
				if($this->Merchant->save($this->request->data)) {
					$merchantID = $this->Merchant->getLastInsertID();
					$body ='Thank you for your interest in our company, we value every customer  and offer impeccable services. We will be contacting you very soon.<br/> Your filling information is as follow:<br/><br/>';
	
					if($_POST['businessType']==1)
					$businessType = 'Swipe';
					elseif($_POST['accountCategory']==2)
					$businessType = 'MOTO';
					elseif($_POST['accountCategory']==3)
					$businessType = 'Internet';
					elseif($_POST['accountCategory']==4)
					$businessType = 'Mobile';
					elseif($_POST['accountCategory']==5)
					$businessType = 'Equipment';
					elseif($_POST['accountCategory']==6)
					$businessType = 'Gateway';
					elseif($_POST['accountCategory']==7)
					$businessType = 'Other';
					elseif($_POST['accountCategory']==8)
					$businessType = 'USB Swipe';
					elseif($_POST['accountCategory']==10)
					$businessType = 'PSP';
					elseif($_POST['accountCategory']==11)
					$businessType = 'Gift Cards';
					elseif($_POST['accountCategory']==12)
					$businessType = 'ACH';
	
					//email to user
					$to=array('underwriting@mojopay.com',$this->request->data['Merchant']['contactEmail'],'services@total-apps.com','services@mojopay.com');
					$sendto = $to;
					$subject = "New application from www.mojopay.com";
	
	//http://mojopay.com/templates/beez_20/images/logo.png
	
					$body = '<table width="600" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto; padding:15px 0 0 0;">
					<tbody><tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="top" style="height:71px;"><img width="27" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-left.gif"></td>
					<td align="left" width="310" valign="top" style=" height:71px; width:310px;"><a href="http://mojopay.com/"><img width="310" height="71" border="0" title="Logo" alt="logo" src="http://mojopay.com/templates/beez_20/images/logo.png"></a></td>
					<td align="left" width="120" valign="top" height="71"><img width="120" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/social-before.gif"></td>
					<td align="left" width="114" valign="bottom" height="71"><table width="114" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="bottom" height="71"><a href="http://www.facebook.com/"><img width="27" height="25" border="0" alt="Facebook" src="'.$imageUrl.'img/img_thanks_email/facebook.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://twitter.com/"><img width="25" height="25" border="0" alt="Twitter" src="'.$imageUrl.'img/img_thanks_email/twitter.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://www.linkedin.com/"><img width="25" height="25" border="0" alt="Linkedin" src="'.$imageUrl.'img/img_thanks_email/in.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="https://plus.google.com"><img width="25" height="25" border="0" alt="Share" src="'.$imageUrl.'img/img_thanks_email/share.gif"></a></td>
					</tr>
					</tbody></table></td>
					<td align="left" width="29" valign="top" height="71"><img width="29" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-right.gif"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<!--thank you heading start-->
					<td align="left" width="600" valign="middle" height="59" style="padding:0 0 0 56px;"><span style="font:18px Arial, Helvetica, sans-serif; color:#1e6ea0;">Thank you for your interest in our company,</span><br>
					<span style="font:12px Arial, Helvetica, sans-serif; color:#1e6ea0;">We value every customer and offer impeccable services. We will be contacting you very soon.</span></td>
					<!--thank you heading end-->
					</tr>
					<tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<!--your filling left part start-->
					<td width="27"></td>
					<!--your filling left part end-->
	
					<!--your filling mid part(contect) start-->
					<td align="left" width="542" valign="top"><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="542" valign="top" height="7"><img width="542" height="7" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-blue-top.gif"></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="22" bgcolor="#b5defe" style="background:#b5defe; padding:0 0 0 29px; font:12px Arial, Helvetica, sans-serif; color:#110d0e;">Your filling information is as follow:</td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="3"><img width="542" height="3" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-white-top.gif"></td>
					</tr>
					<tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td width="19" bgcolor="#b5defe" style="background:#b5defe;"></td>
					<td width="507" bgcolor="#fff"><table width="507" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Name:</b> '.$_POST['merchantName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Site:</b> '.$_POST['merchantURL'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Name:</b> '.$_POST['contactName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Email:</b> <a style="font:12px Arial, Helvetica, sans-serif; color:#110d0e; text-decoration:none;" href="mailto:'.$_POST['contactEmail'].'">'.$_POST['contactEmail'].'</a></td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Phone:</b> '.$_POST['contactPhone'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Sales Volume:</b> '.$_POST['volume'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Business/Account Type:</b> '.$businessType.' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="fff" style="background:#fff;  border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Description of product or services:</b> '.$this->request->data['Merchant']['detailExplanation'].' </td>
					</tr>';
	
					if($_POST['referalID']!=''){
						$referalname = $this->Common->getProcessorNameById($_POST['referalID']);
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral\'s Name:</b> '.$referalname.' </td>
						</tr>';
					}
					if($_POST['referral']!=''){
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral:</b> '.$_POST['referral'].' </td>
						</tr>';
					}
	
					$body .='<tr>
					<td height="50" bgcolor="fff" style="background:#fff;"></td>
					</tr>
					</tbody></table></td>
					<td width="16" bgcolor="#b5defe" style="background:#b5defe;"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="36"><a href="#"><img width="542" height="36" border="0" alt="pic" src="http://total-apps.net/merchant_full_api/images/test.gif"></a></td>
					</tr>
					</tbody></table></td>
	
					<!--your filling mid part(contect) end-->
	
					<!--your filling right part start-->
					<td width="31"></td>
					<!--your filling right part end-->
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td height="12"></td>
					</tr>
					
					</tbody></table>';
					$bodyText = $body;
					$email = new CakeEmail("smtp");
					//$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					if($managerID!='')
						$managerEmail = $this->Common->getProcessorEmail($managerID);
					else
						$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;
	
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					
					//$email->bcc('4008@dothejob.org');
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					//$email->send($bodyText);
					// send email to services@total-apps.com
					$email->to($sendto);
					//$email->to();
					$email->send($bodyText);
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $this->Merchant->getLastInsertID();
					$pipelineData['Merchantpipeline']['statusFrom'] = 0;
					$pipelineData['Merchantpipeline']['statusTo'] = 1;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
	
					$this->loadModel('Merchantnote');
					$noteData['Merchantnote']['merchantID'] = $pipelineData['Merchantpipeline']['merchantID'];
					$noteData['Merchantnote']['enteredBy'] 	= $agentID;
					$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
					$noteData['Merchantnote']['note'] 		= $_POST['note'];
					$this->Merchantnote->save($noteData);	
				}
				
				// save owner info
				if($merchantID!='' && $this->request->data['Merchant']['name1']!=''){
					$this->loadModel('Owner');
					unset($this->request->data['Merchant']);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Owner'][$key] 	=	 $value;
					}
					
					$this->Owner->set($this->request->data);
					if($this->Owner->validates()){	
						//insert data in Owner
						$ownerCount = $_POST['OwnerElement'];
						$this->Owner->deleteAll(array('Owner.merchantID' => $merchantID), false);
						for($i=1;$i<=$ownerCount;$i++){
							$this->Owner->create();
							$this->request->data['Owner']['name'] = $this->request->data['Owner']['name'.$i];
							$this->request->data['Owner']['dob'] = $this->request->data['Owner']['dob'.$i];
							$this->request->data['Owner']['socialSecurityNumber'] = $this->request->data['Owner']['socialSecurityNumber'.$i];
							
							if(isset($this->request->data['Owner']['title'.$i])){
								$this->request->data['Owner']['title'] = $this->request->data['Owner']['title'.$i];
							}
							if($this->request->data['Owner']['ownership'.$i]){
								$this->request->data['Owner']['ownership'] = $this->request->data['Owner']['ownership'.$i];
							}
							if($this->request->data['Owner']['licenceNumber'.$i]){
								$this->request->data['Owner']['licenceNumber'] = $this->request->data['Owner']['licenceNumber'.$i];
							}
							if($this->request->data['Owner']['homeAddress'.$i]){
								$this->request->data['Owner']['homeAddress'] = $this->request->data['Owner']['homeAddress'.$i];
							}
							if($this->request->data['Owner']['city'.$i]){
								$this->request->data['Owner']['city'] = $this->request->data['Owner']['city'.$i];
							}
							if($this->request->data['Owner']['state'.$i]){
								$this->request->data['Owner']['state'] = $this->request->data['Owner']['state'.$i];
							}
							if($this->request->data['Owner']['zip'.$i]){
								$this->request->data['Owner']['zip'] = $this->request->data['Owner']['zip'.$i];
							}
							if($this->request->data['Owner']['homePhone'.$i]){
								$this->request->data['Owner']['homePhone'] = $this->request->data['Owner']['homePhone'.$i];
							}
							
							$this->request->data['Owner']['merchantID'] = $merchantID;
							if($this->request->data['Owner']['name']!="")
							$this->Owner->save($this->request->data);
						}
					}
				}
				//save transaction value
				if($merchantID!='' && $_POST['highestTicketAmount']!=''){
					$this->loadModel('Merchanttransaction');
					unset($this->request->data);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Merchanttransaction'][$key] = $value;
					}
					$this->request->data['Merchanttransaction']['merchantID'] = $merchantID;
					$this->Merchanttransaction->save($this->request->data);
				}
				// pipeline status
				//$status_array = array('2','30');
				$this->loadModel('Merchantpipeline');
				//foreach($status_array as $value){
					$this->Merchantpipeline->create();
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
					$pipelineData['Merchantpipeline']['statusFrom'] = 1;
					$pipelineData['Merchantpipeline']['statusTo'] = 30;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
					//update status date in pipeline
					/* if($value=='2'){
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'preappDate'=>date("Y-m-d")));
						$this->Merchant->save( $data, false, array('statusID','preappDate'));
					}else{
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'incompleteDate'=>date("Y-m-d")));
						$this->Merchant->save( $data, false, array('statusID','incompleteDate'));
					} */
					$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>30));
					$this->Merchant->save( $data, false, array('statusID'));
						
				//}
				// save signature
				if($_POST['output']!=''){
					//$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(350, 150)));
					$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(235, 55)));
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					imagedestroy($img);
					
					######### Resize Imgae By Jitendra Pradhan	##########								
					/*$imageInfo = getimagesize($filePath);					
					$destinationWidth = "198";
					$destinationHeight = "55";					
					// Find the intial size of the image
					$sourceWidth = $imageInfo[0];
					$sourceHeight = $imageInfo[1];
					// Create the destination for the new image
					$destination = imagecreatetruecolor($destinationWidth, $destinationHeight);					
					// Now image resize appropriately					
					$source = imagecreatefrompng($filePath);
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
					imagepng($destination, $filePath);
					// Free up memory
					imagedestroy($source);
					imagedestroy($destination);*/
					############## Resize end #############
					
					// Output to browser
					/*header('Content-Type: image/png');
					imagepng($img);*/

					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Destroy the image in memory when complete
					//imagedestroy($img);
	
				}else{ // if sign is Text
					$img = imagecreatetruecolor(350, 30);
					$bgColour = imagecolorallocate($img, 0xff, 0xff, 0xff);
					$penColour = imagecolorallocate($img, 0x14, 0x53, 0x94);
					imagefilledrectangle($img, 0, 0, 399, 29, $bgColour);
					$text = $_POST['name'];
					$font = WWW_ROOT.'VLADIMIR.TTF';
					imagettftext($img, 20, 0, 10, 20, $penColour, $font, $text);
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Output to browser
					/*header('Content-Type: image/png');
					 imagepng($img);*/
					imagedestroy($img);
				}		
				
				echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Success</response_message><Success_msg>Your Information has been saved successfully.</Success_msg></response>';exit;
	
			}
		}
	}
	
	// Method for saving pre-app request from mojopay.com website
	public function superadmin_fullapi_mojopay_v2() {
		$this->layout = "merchantApi";
		$errorsArr ='';
		$api_response_xml = "";
		$errormsg = "";
		$merchantID = "";
		$imageUrl = Router::url('/',true);
		if(isset($_POST['merchantName']) && $_POST['contactPhone']!='Contact Phone Number' && $_POST['volume']!='Monthly Sales Volume'){
			//echo $_POST['output'];die;
			$userid = $_POST['username'];
			$password = md5($_POST['password']);
	
			$this->loadModel('User');
			$this->loadModel('Merchant');
	
			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
			if($count>0)
			{
				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				if($_POST['referalID']==""){
					$agentID = intval($agentInfo['User']['id']);
				}else{
					if($this->Common->isRoleAgent($_POST['referalID'])){
						$agentID = $_POST['referalID'];
					}else{
						$agentID = intval($agentInfo['User']['id']);
					}
				}
	
				$processorID 	= intval($agentInfo['User']['idProcessor']);
				$isoID 			= intval($agentInfo['User']['idIso']);
				$managerID 		= intval($agentInfo['User']['idManager']);
				foreach($_POST as $key => $value){
					$this->request->data['Merchant'][$key] 	=	 trim($_POST[$key]);
				}
				$this->request->data['Merchant']['sendUpDate'] 		=	 date("n/j/Y");
				$this->request->data['Merchant']['preappDate'] 		=	 date("Y-m-d");
				$this->request->data['Merchant']['statusID'] 		=	 '1'; // status 30 for Underwriting;'1'; // status 1 for preapp1 or Lead
				$this->request->data['Merchant']['agentID'] 		=	 $agentID;
				$this->request->data['Merchant']['processorID'] 	=	 1357;
				$this->request->data['Merchant']['isoID'] 			=	 $isoID;
				$this->request->data['Merchant']['managerID'] 		=	 $agentID;
				$this->request->data['Merchant']['referalID'] 		=	 $agentID;
				$this->request->data['Merchant']['user_ref_id'] 	=	 "user_ref".$_POST['referalID'];
	
				$this->Merchant->set($this->request->data);
				if(!$this->Merchant->validates())
				{
					$errorsArr = $this->Merchant->validationErrors;
				}
				if($errorsArr)
				{
					echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Failure</response_message><Failure_msg>Please provide all field values correctly.</Failure_msg></response>';exit;
				}
	
				if($this->Merchant->save($this->request->data)) {
					$merchantID = $this->Merchant->getLastInsertID();
					$body ='Thank you for your interest in our company, we value every customer  and offer impeccable services. We will be contacting you very soon.<br/> Your filling information is as follow:<br/><br/>';
	
					if($_POST['businessType']==1)
						$businessType = 'Swipe';
					elseif($_POST['accountCategory']==2)
					$businessType = 'MOTO';
					elseif($_POST['accountCategory']==3)
					$businessType = 'Internet';
					elseif($_POST['accountCategory']==4)
					$businessType = 'Mobile';
					elseif($_POST['accountCategory']==5)
					$businessType = 'Equipment';
					elseif($_POST['accountCategory']==6)
					$businessType = 'Gateway';
					elseif($_POST['accountCategory']==7)
					$businessType = 'Other';
					elseif($_POST['accountCategory']==8)
					$businessType = 'USB Swipe';
					elseif($_POST['accountCategory']==10)
					$businessType = 'PSP';
					elseif($_POST['accountCategory']==11)
					$businessType = 'Gift Cards';
					elseif($_POST['accountCategory']==12)
					$businessType = 'ACH';
	
					//email to user
					$to=array('underwriting@mojopay.com',$this->request->data['Merchant']['contactEmail'],'services@total-apps.com');
					$sendto = $to;
					$subject = "New application from www.mojopay.com";
	
					//http://mojopay.com/templates/beez_20/images/logo.png
	
					$body = '<table width="600" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto; padding:15px 0 0 0;">
					<tbody><tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="top" style="height:71px;"><img width="27" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-left.gif"></td>
					<td align="left" width="310" valign="top" style=" height:71px; width:310px;"><a href="http://mojopay.com/"><img width="310" height="71" border="0" title="Logo" alt="logo" src="http://mojopay.com/templates/beez_20/images/logo.png"></a></td>
					<td align="left" width="120" valign="top" height="71"><img width="120" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/social-before.gif"></td>
					<td align="left" width="114" valign="bottom" height="71"><table width="114" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="bottom" height="71"><a href="http://www.facebook.com/"><img width="27" height="25" border="0" alt="Facebook" src="'.$imageUrl.'img/img_thanks_email/facebook.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://twitter.com/"><img width="25" height="25" border="0" alt="Twitter" src="'.$imageUrl.'img/img_thanks_email/twitter.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://www.linkedin.com/"><img width="25" height="25" border="0" alt="Linkedin" src="'.$imageUrl.'img/img_thanks_email/in.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="https://plus.google.com"><img width="25" height="25" border="0" alt="Share" src="'.$imageUrl.'img/img_thanks_email/share.gif"></a></td>
					</tr>
					</tbody></table></td>
					<td align="left" width="29" valign="top" height="71"><img width="29" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-right.gif"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<!--thank you heading start-->
					<td align="left" width="600" valign="middle" height="59" style="padding:0 0 0 56px;"><span style="font:18px Arial, Helvetica, sans-serif; color:#1e6ea0;">Thank you for your interest in our company,</span><br>
					<span style="font:12px Arial, Helvetica, sans-serif; color:#1e6ea0;">We value every customer and offer impeccable services. We will be contacting you very soon.</span></td>
					<!--thank you heading end-->
					</tr>
					<tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<!--your filling left part start-->
					<td width="27"></td>
					<!--your filling left part end-->
	
					<!--your filling mid part(contect) start-->
					<td align="left" width="542" valign="top"><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="542" valign="top" height="7"><img width="542" height="7" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-blue-top.gif"></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="22" bgcolor="#b5defe" style="background:#b5defe; padding:0 0 0 29px; font:12px Arial, Helvetica, sans-serif; color:#110d0e;">Your filling information is as follow:</td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="3"><img width="542" height="3" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-white-top.gif"></td>
					</tr>
					<tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td width="19" bgcolor="#b5defe" style="background:#b5defe;"></td>
					<td width="507" bgcolor="#fff"><table width="507" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Name:</b> '.$_POST['merchantName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Site:</b> '.$_POST['merchantURL'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Name:</b> '.$_POST['contactName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Email:</b> <a style="font:12px Arial, Helvetica, sans-serif; color:#110d0e; text-decoration:none;" href="mailto:'.$_POST['contactEmail'].'">'.$_POST['contactEmail'].'</a></td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Phone:</b> '.$_POST['contactPhone'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Sales Volume:</b> '.$_POST['volume'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Business/Account Type:</b> '.$businessType.' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="fff" style="background:#fff;  border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Description of product or services:</b> '.$this->request->data['Merchant']['detailExplanation'].' </td>
					</tr>';
	
					if($_POST['referalID']!=''){
						$referalname = $this->Common->getProcessorNameById($_POST['referalID']);
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral\'s Name:</b> '.$referalname.' </td>
						</tr>';
					}
					if($_POST['referral']!=''){
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral:</b> '.$_POST['referral'].' </td>
						</tr>';
					}
	
					$body .='<tr>
					<td height="50" bgcolor="fff" style="background:#fff;"></td>
					</tr>
					</tbody></table></td>
					<td width="16" bgcolor="#b5defe" style="background:#b5defe;"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="36"><a href="#"><img width="542" height="36" border="0" alt="pic" src="http://total-apps.net/merchant_full_api/images/test.gif"></a></td>
					</tr>
					</tbody></table></td>
	
					<!--your filling mid part(contect) end-->
	
					<!--your filling right part start-->
					<td width="31"></td>
					<!--your filling right part end-->
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td height="12"></td>
					</tr>
						
					</tbody></table>';
					$bodyText = $body;
					$email = new CakeEmail("smtp");
					//$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					if($managerID!='')
						$managerEmail = $this->Common->getProcessorEmail($managerID);
					else
						$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;
	
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
						
					//$email->bcc('4008@dothejob.org');
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					//$email->send($bodyText);
					// send email to services@total-apps.com
					$email->to($sendto);
					//$email->to();
					$email->send($bodyText);
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $this->Merchant->getLastInsertID();
					$pipelineData['Merchantpipeline']['statusFrom'] = 0;
					$pipelineData['Merchantpipeline']['statusTo'] = 1;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
	
					$this->loadModel('Merchantnote');
					$noteData['Merchantnote']['merchantID'] = $pipelineData['Merchantpipeline']['merchantID'];
					$noteData['Merchantnote']['enteredBy'] 	= $agentID;
					$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
					$noteData['Merchantnote']['note'] 		= $_POST['note'];
					$this->Merchantnote->save($noteData);
				}
	
				// save owner info
				if($merchantID!='' && $this->request->data['Merchant']['name1']!=''){
					$this->loadModel('Owner');
					unset($this->request->data['Merchant']);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Owner'][$key] 	=	 $value;
					}
						
					$this->Owner->set($this->request->data);
					if($this->Owner->validates(array('fieldList' => array('name1', 'socialSecurityNumber1')))){
						//insert data in Owner
						$ownerCount = 1;//$_POST['OwnerElement'];
						$this->Owner->deleteAll(array('Owner.merchantID' => $merchantID), false);
						for($i=1;$i<=$ownerCount;$i++){
							$this->Owner->create();
							$this->request->data['Owner']['name'] = $this->request->data['Owner']['name'.$i];
							$this->request->data['Owner']['dob'] = $this->request->data['Owner']['dob'.$i];
							$this->request->data['Owner']['socialSecurityNumber'] = $this->request->data['Owner']['socialSecurityNumber'.$i];
							$this->request->data['Owner']['title'] = "";
							$this->request->data['Owner']['ownership'] = "";
							$this->request->data['Owner']['licenceNumber'] = "";
							$this->request->data['Owner']['homeAddress'] = "";
							$this->request->data['Owner']['city'] = "";
							$this->request->data['Owner']['state'] = "";
							$this->request->data['Owner']['zip'] = "";
							$this->request->data['Owner']['homePhone'] = "";	
							$this->request->data['Owner']['merchantID'] = $merchantID;
							if($this->request->data['Owner']['name']!="")
								$this->Owner->save($this->request->data);
						}
					}
				}
				//save transaction value
				if($merchantID!='' && $_POST['highestTicketAmount']!=''){
					$this->loadModel('Merchanttransaction');
					unset($this->request->data);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Merchanttransaction'][$key] = $value;
					}
					$this->request->data['Merchanttransaction']['merchantID'] = $merchantID;
					$this->Merchanttransaction->save($this->request->data);
				}
				// pipeline status
				//$status_array = array('2','30');
				$this->loadModel('Merchantpipeline');
				//foreach($status_array as $value){
				$this->Merchantpipeline->create();
				$pipelineData = array();
				$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
				$pipelineData['Merchantpipeline']['statusFrom'] = 1;
				$pipelineData['Merchantpipeline']['statusTo'] = 30;
				$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
				$this->Merchantpipeline->save($pipelineData);
				//update status date in pipeline
				/* if($value=='2'){
				 $data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'preappDate'=>date("Y-m-d")));
				$this->Merchant->save( $data, false, array('statusID','preappDate'));
				}else{
				$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'incompleteDate'=>date("Y-m-d")));
				$this->Merchant->save( $data, false, array('statusID','incompleteDate'));
				} */
				$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>30));
				$this->Merchant->save( $data, false, array('statusID'));
	
				//}
				// save signature
				if($_POST['output']!=''){
					//$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(350, 150)));
					$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(235, 55)));
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					imagedestroy($img);
						
					######### Resize Imgae By Jitendra Pradhan	##########
					/*$imageInfo = getimagesize($filePath);
					$destinationWidth = "198";
					$destinationHeight = "55";
					// Find the intial size of the image
					$sourceWidth = $imageInfo[0];
					$sourceHeight = $imageInfo[1];
					// Create the destination for the new image
					$destination = imagecreatetruecolor($destinationWidth, $destinationHeight);
					// Now image resize appropriately
					$source = imagecreatefrompng($filePath);
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
					imagepng($destination, $filePath);
					// Free up memory
					imagedestroy($source);
					imagedestroy($destination);*/
					############## Resize end #############
						
					// Output to browser
					/*header('Content-Type: image/png');
						imagepng($img);*/
	
					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Destroy the image in memory when complete
					//imagedestroy($img);
	
				}else{ // if sign is Text
					$img = imagecreatetruecolor(350, 30);
					$bgColour = imagecolorallocate($img, 0xff, 0xff, 0xff);
					$penColour = imagecolorallocate($img, 0x14, 0x53, 0x94);
					imagefilledrectangle($img, 0, 0, 399, 29, $bgColour);
					$text = $_POST['name'];
					$font = WWW_ROOT.'VLADIMIR.TTF';
					imagettftext($img, 20, 0, 10, 20, $penColour, $font, $text);
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Output to browser
					/*header('Content-Type: image/png');
					 imagepng($img);*/
					imagedestroy($img);
				}
	
				echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Success</response_message><Success_msg>Your Information has been saved successfully.</Success_msg></response>';exit;
	
			}
		}
	}
	// Method for saving pre-app request from mojopay.com website
	public function superadmin_fullapi_mojopay_demo() {
		$this->layout = "merchantApi";
		$errorsArr ='';
		$api_response_xml = "";
		$errormsg = "";
		$merchantID = "";
		$imageUrl = Router::url('/',true);
		if(isset($_POST['merchantName']) && $_POST['contactPhone']!='Contact Phone Number' && $_POST['volume']!='Monthly Sales Volume'){
			//echo $_POST['output'];die;
			$userid = $_POST['username'];
			$password = md5($_POST['password']);
	
			$this->loadModel('User');
			$this->loadModel('Merchant');
	
			$count = $this->User->find('count', array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
			if($count>0)
			{
				$agentInfo =  $this->User->find('first',array('conditions'=>array("User.username" => $userid, "User.password" => $password)));
				if($_POST['referalID']==""){
					$agentID = intval($agentInfo['User']['id']);
				}else{
					if($this->Common->isRoleAgent($_POST['referalID'])){
						$agentID = $_POST['referalID'];
					}else{
						$agentID = intval($agentInfo['User']['id']);
					}
				}
	
				$processorID 	= intval($agentInfo['User']['idProcessor']);
				$isoID 			= intval($agentInfo['User']['idIso']);
				$managerID 		= intval($agentInfo['User']['idManager']);
				foreach($_POST as $key => $value){
					$this->request->data['Merchant'][$key] 	=	 trim($_POST[$key]);
				}
				$this->request->data['Merchant']['sendUpDate'] 		=	 date("n/j/Y");
				$this->request->data['Merchant']['preappDate'] 		=	 date("Y-m-d");
				$this->request->data['Merchant']['statusID'] 		=	 '1'; // status 30 for Underwriting;'1'; // status 1 for preapp1 or Lead
				$this->request->data['Merchant']['agentID'] 		=	 $agentID;
				$this->request->data['Merchant']['processorID'] 	=	 1357;
				$this->request->data['Merchant']['isoID'] 			=	 $isoID;
				$this->request->data['Merchant']['managerID'] 		=	 $agentID;
				$this->request->data['Merchant']['referalID'] 		=	 $agentID;
				$this->request->data['Merchant']['user_ref_id'] 	=	 "user_ref".$_POST['referalID'];
	
				$this->Merchant->set($this->request->data);
				if(!$this->Merchant->validates())
				{
					$errorsArr = $this->Merchant->validationErrors;
				}
				if($errorsArr)
				{
					echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Failure</response_message><Failure_msg>Please provide all field values correctly.</Failure_msg></response>';exit;
				}
	
				if($this->Merchant->save($this->request->data)) {
					$merchantID = $this->Merchant->getLastInsertID();
					$body ='Thank you for your interest in our company, we value every customer  and offer impeccable services. We will be contacting you very soon.<br/> Your filling information is as follow:<br/><br/>';
	
					if($_POST['businessType']==1)
						$businessType = 'Swipe';
					elseif($_POST['accountCategory']==2)
					$businessType = 'MOTO';
					elseif($_POST['accountCategory']==3)
					$businessType = 'Internet';
					elseif($_POST['accountCategory']==4)
					$businessType = 'Mobile';
					elseif($_POST['accountCategory']==5)
					$businessType = 'Equipment';
					elseif($_POST['accountCategory']==6)
					$businessType = 'Gateway';
					elseif($_POST['accountCategory']==7)
					$businessType = 'Other';
					elseif($_POST['accountCategory']==8)
					$businessType = 'USB Swipe';
					elseif($_POST['accountCategory']==10)
					$businessType = 'PSP';
					elseif($_POST['accountCategory']==11)
					$businessType = 'Gift Cards';
					elseif($_POST['accountCategory']==12)
					$businessType = 'ACH';
	
					//email to user
					$to=array('underwriting@mojopay.com',$this->request->data['Merchant']['contactEmail'],'services@total-apps.com');
					$sendto = $to;
					$subject = "New application from www.mojopay.com";
	
					//http://mojopay.com/templates/beez_20/images/logo.png
	
					$body = '<table width="600" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto; padding:15px 0 0 0;">
					<tbody><tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="top" style="height:71px;"><img width="27" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-left.gif"></td>
					<td align="left" width="310" valign="top" style=" height:71px; width:310px;"><a href="http://mojopay.com/"><img width="310" height="71" border="0" title="Logo" alt="logo" src="http://mojopay.com/templates/beez_20/images/logo.png"></a></td>
					<td align="left" width="120" valign="top" height="71"><img width="120" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/social-before.gif"></td>
					<td align="left" width="114" valign="bottom" height="71"><table width="114" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="27" valign="bottom" height="71"><a href="http://www.facebook.com/"><img width="27" height="25" border="0" alt="Facebook" src="'.$imageUrl.'img/img_thanks_email/facebook.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://twitter.com/"><img width="25" height="25" border="0" alt="Twitter" src="'.$imageUrl.'img/img_thanks_email/twitter.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="http://www.linkedin.com/"><img width="25" height="25" border="0" alt="Linkedin" src="'.$imageUrl.'img/img_thanks_email/in.gif"></a></td>
					<td align="left" width="4" valign="bottom" height="71"><img width="4" height="25" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/gap-social.gif"></td>
					<td align="left" width="25" valign="bottom" height="71"><a href="https://plus.google.com"><img width="25" height="25" border="0" alt="Share" src="'.$imageUrl.'img/img_thanks_email/share.gif"></a></td>
					</tr>
					</tbody></table></td>
					<td align="left" width="29" valign="top" height="71"><img width="29" height="71" alt="pic" src="'.$imageUrl.'img/img_thanks_email/header-right.gif"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<!--thank you heading start-->
					<td align="left" width="600" valign="middle" height="59" style="padding:0 0 0 56px;"><span style="font:18px Arial, Helvetica, sans-serif; color:#1e6ea0;">Thank you for your interest in our company,</span><br>
					<span style="font:12px Arial, Helvetica, sans-serif; color:#1e6ea0;">We value every customer and offer impeccable services. We will be contacting you very soon.</span></td>
					<!--thank you heading end-->
					</tr>
					<tr>
					<td><table width="600" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<!--your filling left part start-->
					<td width="27"></td>
					<!--your filling left part end-->
	
					<!--your filling mid part(contect) start-->
					<td align="left" width="542" valign="top"><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td align="left" width="542" valign="top" height="7"><img width="542" height="7" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-blue-top.gif"></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="22" bgcolor="#b5defe" style="background:#b5defe; padding:0 0 0 29px; font:12px Arial, Helvetica, sans-serif; color:#110d0e;">Your filling information is as follow:</td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="3"><img width="542" height="3" border="0" alt="pic" src="'.$imageUrl.'img/img_thanks_email/curve-white-top.gif"></td>
					</tr>
					<tr>
					<td><table width="542" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
					<td width="19" bgcolor="#b5defe" style="background:#b5defe;"></td>
					<td width="507" bgcolor="#fff"><table width="507" cellspacing="0" cellpadding="0" border="0">
					<tbody>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Name:</b> '.$_POST['merchantName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Company Site:</b> '.$_POST['merchantURL'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Name:</b> '.$_POST['contactName'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Email:</b> <a style="font:12px Arial, Helvetica, sans-serif; color:#110d0e; text-decoration:none;" href="mailto:'.$_POST['contactEmail'].'">'.$_POST['contactEmail'].'</a></td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Contact Phone:</b> '.$_POST['contactPhone'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Sales Volume:</b> '.$_POST['volume'].' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Business/Account Type:</b> '.$businessType.' </td>
					</tr>
					<tr>
					<td align="left" valign="top" bgcolor="fff" style="background:#fff;  border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Description of product or services:</b> '.$this->request->data['Merchant']['detailExplanation'].' </td>
					</tr>';
	
					if($_POST['referalID']!=''){
						$referalname = $this->Common->getProcessorNameById($_POST['referalID']);
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral\'s Name:</b> '.$referalname.' </td>
						</tr>';
					}
					if($_POST['referral']!=''){
						$body .='<tr>
						<td align="left" valign="top" bgcolor="f0f6f6" style="background:#f0f6f6; border-bottom:2px solid #fff; font:12px Arial, Helvetica, sans-serif; color:#110d0e; padding:0 0 3px 10px;"><b style="font:12px Arial, Helvetica, sans-serif; font-weight:bold;">Referral:</b> '.$_POST['referral'].' </td>
						</tr>';
					}
	
					$body .='<tr>
					<td height="50" bgcolor="fff" style="background:#fff;"></td>
					</tr>
					</tbody></table></td>
					<td width="16" bgcolor="#b5defe" style="background:#b5defe;"></td>
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td align="left" width="542" valign="top" height="36"><a href="#"><img width="542" height="36" border="0" alt="pic" src="http://total-apps.net/merchant_full_api/images/test.gif"></a></td>
					</tr>
					</tbody></table></td>
	
					<!--your filling mid part(contect) end-->
	
					<!--your filling right part start-->
					<td width="31"></td>
					<!--your filling right part end-->
					</tr>
					</tbody></table></td>
					</tr>
					<tr>
					<td height="12"></td>
					</tr>
	
					</tbody></table>';
					$bodyText = $body;
					$email = new CakeEmail("smtp");
					//$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
					if($managerID!='')
						$managerEmail = $this->Common->getProcessorEmail($managerID);
					else
						$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;
	
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
	
	
					//$email->bcc('4008@dothejob.org');
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					//$email->send($bodyText);
					// send email to services@total-apps.com
					$email->to($sendto);
					//$email->to();
					$email->send($bodyText);
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $this->Merchant->getLastInsertID();
					$pipelineData['Merchantpipeline']['statusFrom'] = 0;
					$pipelineData['Merchantpipeline']['statusTo'] = 1;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
	
					$this->loadModel('Merchantnote');
					$noteData['Merchantnote']['merchantID'] = $pipelineData['Merchantpipeline']['merchantID'];
					$noteData['Merchantnote']['enteredBy'] 	= $agentID;
					$noteData['Merchantnote']['timeStamp'] 	= CURRENTDATE;
					$noteData['Merchantnote']['note'] 		= $_POST['note'];
					$this->Merchantnote->save($noteData);
				}
	
				// save owner info
				if($merchantID!='' && $this->request->data['Merchant']['name1']!=''){
					$this->loadModel('Owner');
					unset($this->request->data['Merchant']);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Owner'][$key] 	=	 $value;
					}
	
					$this->Owner->set($this->request->data);
					if($this->Owner->validates(array('fieldList' => array('name1', 'socialSecurityNumber1')))){
						//insert data in Owner
						$ownerCount = 1;//$_POST['OwnerElement'];
						$this->Owner->deleteAll(array('Owner.merchantID' => $merchantID), false);
						for($i=1;$i<=$ownerCount;$i++){
							$this->Owner->create();
							$this->request->data['Owner']['name'] = $this->request->data['Owner']['name'.$i];
							$this->request->data['Owner']['dob'] = $this->request->data['Owner']['dob'.$i];
							$this->request->data['Owner']['socialSecurityNumber'] = $this->request->data['Owner']['socialSecurityNumber'.$i];
							$this->request->data['Owner']['title'] = "";
							$this->request->data['Owner']['ownership'] = "";
							$this->request->data['Owner']['licenceNumber'] = "";
							$this->request->data['Owner']['homeAddress'] = "";
							$this->request->data['Owner']['city'] = "";
							$this->request->data['Owner']['state'] = "";
							$this->request->data['Owner']['zip'] = "";
							$this->request->data['Owner']['homePhone'] = "";
							$this->request->data['Owner']['merchantID'] = $merchantID;
							if($this->request->data['Owner']['name']!="")
								$this->Owner->save($this->request->data);
						}
					}
				}
				//save transaction value
				if($merchantID!='' && $_POST['highestTicketAmount']!=''){
					$this->loadModel('Merchanttransaction');
					unset($this->request->data);
					$this->request->data = array();
					foreach($_POST as $key => $value){
						$this->request->data['Merchanttransaction'][$key] = $value;
					}
					$this->request->data['Merchanttransaction']['merchantID'] = $merchantID;
					$this->Merchanttransaction->save($this->request->data);
				}
				// pipeline status
				//$status_array = array('2','30');
				$this->loadModel('Merchantpipeline');
				//foreach($status_array as $value){
				$this->Merchantpipeline->create();
				$pipelineData = array();
				$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
				$pipelineData['Merchantpipeline']['statusFrom'] = 1;
				$pipelineData['Merchantpipeline']['statusTo'] = 30;
				$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
				$this->Merchantpipeline->save($pipelineData);
				//update status date in pipeline
				/* if($value=='2'){
				 $data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'preappDate'=>date("Y-m-d")));
				$this->Merchant->save( $data, false, array('statusID','preappDate'));
				}else{
				$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>$value,'incompleteDate'=>date("Y-m-d")));
				$this->Merchant->save( $data, false, array('statusID','incompleteDate'));
				} */
				$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>30));
				$this->Merchant->save( $data, false, array('statusID'));
	
				//}
				// save signature
				if($_POST['output']!=''){
					//$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(350, 150)));
					$img = $this->Common->sigJsonToImage(stripslashes($_POST['output']),array('imageSize' => array(235, 55)));
					// Save to file
					$fileName = time()."-".$merchantID."-signature.png";
					$filePath = WWW_ROOT."files/Signature/".$fileName;
					imagepng($img, $filePath);
					imagedestroy($img);
	
					######### Resize Imgae By Jitendra Pradhan	##########
					/*$imageInfo = getimagesize($filePath);
					$destinationWidth = "198";
					$destinationHeight = "55";
					// Find the intial size of the image
					$sourceWidth = $imageInfo[0];
					$sourceHeight = $imageInfo[1];
					// Create the destination for the new image
					$destination = imagecreatetruecolor($destinationWidth, $destinationHeight);
					// Now image resize appropriately
					$source = imagecreatefrompng($filePath);
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
					imagepng($destination, $filePath);
					// Free up memory
					imagedestroy($source);
					imagedestroy($destination);*/
					############## Resize end #############
	
					// Output to browser
					/*header('Content-Type: image/png');
					imagepng($img);*/
	
					// Insert merchant signature in database
					$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
					$this->Merchant->save( $data, false, array('merchantSign'));
					// Destroy the image in memory when complete
					//imagedestroy($img);
	
				}else{ // if sign is Text
					$img = imagecreatetruecolor(350, 30);
						$bgColour = imagecolorallocate($img, 0xff, 0xff, 0xff);
						$penColour = imagecolorallocate($img, 0x14, 0x53, 0x94);
						imagefilledrectangle($img, 0, 0, 399, 29, $bgColour);
						$text = $_POST['name'];
						$font = WWW_ROOT.'VLADIMIR.TTF';
						imagettftext($img, 20, 0, 10, 20, $penColour, $font, $text);
						// Save to file
						$fileName = time()."-".$merchantID."-signature.png";
						$filePath = WWW_ROOT."files/Signature/".$fileName;
						imagepng($img, $filePath);
						// Insert merchant signature in database
						$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>$fileName));
						$this->Merchant->save( $data, false, array('merchantSign'));
						// Output to browser
						/*header('Content-Type: image/png');
						imagepng($img);*/
						 imagedestroy($img);
						}
	
						echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>Success</response_message><Success_msg>Your Information has been saved successfully.</Success_msg></response>';exit;
	
			}
		}
	}
	
	
	
	
	// two function created by pushkar soni ticket id 1960 to manage new api from mojopay
	
	public function superadmin_mojopay_merchant_request($merchant_id=null){
		$this->autoRender=false;
		$this->loadModel('Merchant');
		
		
		if($this->request->is('get')){
			
			$this->Merchant->id=$merchant_id;
			if($this->Merchant->exists()){ // checking merchant is exits or not
		
			$merchant_rec=$this->Merchant->find('first',array(
								'conditions'=>array('Merchant.id'=>$merchant_id,'Merchant.statusID'=>'3'),
								'recursive'=>-1,
								));
								
		
		
			if(is_array($merchant_rec)){
			return	json_encode($merchant_rec);die;
			
			}else{
				return 'Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.';
			}		
		}
			return 'Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.';
		
		}elseif($this->request->is('post')){
			$merchantID = $this->request->data['Merchant']['id'];
			$this->Merchant->set($this->request->data);
			if(!$this->Merchant->validates()){
			 $errorsArr = $this->Merchant->validationErrors; 
			 }

			if($errorsArr){
				return $errorsArr;
			}else {
			
			$data['Merchant']=$this->request->data;
			$data['Merchant']['id']=$data['Merchant']['merchant_id'];
		
		
			$data['Merchant']['legalAddress']=$data['Merchant']['legalAddress']."\n".$data['Merchant']['legalAddress2'];
			$this->Merchant->set($data);
			
				if($this->Merchant->save()){
					return 'record has been saved successfully';
					
				}
			}
		}else{
			return 'Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.';
		}
	}
	
	
	public function superadmin_mojopay_apiownerinfo($merchantID	 = null) {
		$this->autoRender = false;
		$errorsArr = "";		
		$this->loadModel('Owner');
		$this->loadModel('Merchant');
		

		if ($this->request->is('get')) {
			
			$count = $this->Merchant->find('count',
				array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.statusID'=>'3')));
			
			if($count!=1){
				return 'you are not elegible to open this URL. Your request status should be Incomplete to open this URL.';}
			
				$OwnerData = $this->Owner->find('all',
								array('conditions'=>array('Owner.merchantID'=>$merchantID),
									  'recursive'=>-1));
							
				return json_encode($OwnerData);
	
		} else {
		 
		
		 $data=$this->request->data;
	
			$this->Owner->query('delete from owners where merchantID="'.$data['merchant_id'].'"');
			foreach($data['Owner'] as $key=>$value){
				$this->Owner->create();
				if(!empty($value['name'])){
				
				$data1['Owner']['id']=$value['id'];
				$data1['Owner']['merchantID']=$value['merchantID'];
				$data1['Owner']['name']=$value['name'];
				$data1['Owner']['dob']=$value['dob'];
				$data1['Owner']['homeAddress']=$value['homeAddress'];
				$data1['Owner']['title']=$value['title'];
				$data1['Owner']['licenceNumber']=$value['licenceNumber'];
				$data1['Owner']['ownership']=$value['ownership'];
				$data1['Owner']['city']=$value['city'];
				$data1['Owner']['state']=$value['state'];
				$data1['Owner']['zip']=$value['zip'];
				$data1['Owner']['ownership']=$value['ownership'];
				$data1['Owner']['socialSecurityNumber']=$value['socialSecurityNumber'];
				$data1['Owner']['homePhone']=$value['homePhone'];
				
				$this->Owner->set($data1);
				$this->Owner->save($data1);
				}
			}
		
			return 'Record has been saved successfully';
		}
		
		die;
	}
	
	public function superadmin_mojopay_apiprofileinfo($merchantID	 = null) {
		
		$this->autoRender =false;
		$errorsArr = '';
		$this->loadModel('Merchant');
		$this->loadModel('Merchanttransaction');
		$merchantDBA = '';
		
		
		if ($this->request->is('get')) {
		
		
			$count =  $this->Merchant->find('count', array('conditions'=>array('Merchant.id'=>$merchantID,'Merchant.statusID'=>'3')));

		/*	if($count!=1){
				return 'Sorry,you are not elegible to open this URL. Your request status should be Incomplete to open this URL.';}*/
			
			$MerchantData = $this->Merchant->find('first',array(
							'conditions'=>array('Merchant.id'=>$merchantID),
							'recursive'=>1,
							));			
			$TransData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.merchantID'=>$merchantID)));
			if($TransData){
			$rec=array_merge($MerchantData, $TransData);
			}else{
				$rec=$MerchantData;
			}
			
			
			return json_encode($rec);die;
		
		}else{
			
			$merchantID = $this->request->data['Merchant']['id'];
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			$merchantDBA = $MerchantData['Merchant']['merchantDBA'];
			$this->Merchant->set($this->request->data);
			$this->Merchanttransaction->set($this->request->data);
			
			
				
				$merchantID = $this->request->data['Merchant']['id'];
				if($this->request->data['Merchant']['describePolicy']!=''){
					$this->request->data['Merchant']['hasRefundPolicy'] = 'yes';
				}

				$email = new CakeEmail("smtp");
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				$subject = "Merchant Status has been changed to Incomplete";
				$bodyText = "Hello, <br> Your Merchant ".$merchantDBA." has submitted information successfully. The status of your merchant has been changed form Pre-App to Incomplete successfully. Go to your account and proceed next step for your merchant.";
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));	
								

				if($this->Merchant->save($this->request->data)) {
					//update merchant transaction values
					if(isset($this->request->data['Merchanttransaction'])){
						$this->Merchanttransaction->deleteAll(array('Merchanttransaction.merchantID' => $merchantID), false);
						$this->request->data['Merchanttransaction']['merchantID'] = $merchantID;
						$this->Merchanttransaction->save($this->request->data);
					}
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
					$pipelineData['Merchantpipeline']['statusFrom'] = 2;
					$pipelineData['Merchantpipeline']['statusTo'] = 3;
					$pipelineData['Merchantpipeline']['statusToDate'] = date('Y-m-d');
					$this->Merchantpipeline->save($pipelineData);
					//send to agent
					$sendtoagent = $this->request->data['Merchant']['agentEmail'];
					if($sendtoagent!=''){
						$email->to($sendtoagent);
						$email->send($bodyText);
					}
					//send to manager
					$sendtoman = $this->request->data['Merchant']['managerEmail'];
					if($sendtoman){
						$email->to($sendtoman);
						$email->send($bodyText);
					}

					//add merchant notes when change in status
					$this->loadModel('Merchantnote');
					$noteData = array();
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = '';
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = "Basic information and additional information of this merchant has been updated by merchant itself. Status of pre-app request for this merchant has been changed form Pre-App To Incomplete on Date ".$timestamp;
					$this->Merchantnote->save($noteData);

					return 'Merchant Profile has been updated successfully.';
					exit;
				}
				
				return 'Data save problem, Please try again.';
				exit;
				

		}

	}
	
	/* task id 3279
	 * Send email every Sunday night with the excel file of the merchant export
	 * Created on 06-feb-2014
	 * created by Jitendra Pradhan
	 */
	public function superadmin_sendMerchantExportEmail(){
		ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
		ini_set('memory_limit','1024M');	//Maximum amount of memory a script may consume (64MB)

		
		$this->autoRender = false;	
		$this->loadModel('Merchant');
		$this->Merchant->unbindModel(
			array(
					'hasMany' => array('Commissionlog'),
					'belongsTo' => array('Agent','ISO'),
					'hasOne' => array('Commission')
			),false
		);
		$field_array = array("distinct(Merchant.id)","Merchant.merchantName","Merchant.merchantDBA","Merchant.merchantURL","Merchant.volume","Merchant.CID","Merchant.contactName","Merchant.contactEmail","Merchant.contactPhone","Merchant.legalCountry","Merchant.sicMCC","Merchant.merchantType","Merchant.preappDate","Merchant.startDate","Merchant.form_id","Status.status","Processor.user_Name","Manager.user_Name","Manager.user_Name","MerchantCategory.accountType","Referal.user_Name");
		$MerchantRec =$this->Merchant->find('all',array('fields'=>$field_array,'order'=>array('Merchant.id' => 'DESC')));
		
		//create a file
		$filename = WWW_ROOT."files/MerchantDocument/Merchant_export_".date("Y.m.d").".csv";
		@chmod($filename, 777);		
		$csv_file = fopen($filename, 'w');
			
		/* header('Content-type: application/csv');
		header('Content-Disposition: ; filename="'.$filename.'"'); */
			
		// The column headings of your .csv file
		$header_row = array("MERCHANT NAME","MERCHANT DBA NAME","URL","PROCESSING VOLUME","MID","CURRENT STATUS","CONTACT NAME","CONTACT EMAIL","CONTACT PHONE","PROCESSOR","MANAGER","CREATION DATE","COUNTRY","SIC/MCC","CATEGORY OF BUSINESS","MERCHANT CATEGORY","REFERRAL","NOTES","FORM ID");
		fputcsv($csv_file,$header_row,',','"');
			
		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		foreach($MerchantRec as $result)
		{
			$creation_date = ($result['Merchant']['preappDate']!='0000-00-00') ? $result['Merchant']['preappDate'] : $result['Merchant']['startDate'];
			$create_date = (strlen($creation_date)>=4)? date("M d, Y",strtotime($creation_date)) : "";
			// merchant add note (#taskid 3421)
			$note = $this->Common->getMerchantAddNote($result['Merchant']['id']);
			$note = str_replace("<br>", "\n", $note);
			// Array indexes correspond to the field names in your db table(s)
			$row = array(
					$result['Merchant']['merchantName'],
					$result['Merchant']['merchantDBA'],
					$result['Merchant']['merchantURL'],
					$this->merchantVolumeBeforeRender($result['Merchant']['volume'],'USD'),
					$result['Merchant']['CID'],
					$result['Status']['status'],
					$result['Merchant']['contactName'],
					$result['Merchant']['contactEmail'],
					$result['Merchant']['contactPhone'],
					$result['Processor']['user_Name'],
					$result['Manager']['user_Name'],
					$create_date,
					$result['Merchant']['legalCountry'],
					$result['Merchant']['sicMCC'],
					$result['Merchant']['merchantType'],
					$result['MerchantCategory']['accountType'],
					$result['Referal']['user_Name'],
					$note,
					$result['Merchant']['form_id']
			);
			fputcsv($csv_file,$row,',','"');
		}
		fclose($csv_file);
		
		// send email to clients
		$attachment_array = array();
		$attachment_array[] = $filename;
		$email = new CakeEmail("smtp");
		$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
		$sendto = "jelmaleh@seobrand.net";
		$cc = "russell@total-apps.com";
		//$sendto = "bush147258369@gmail.com";
		//$cc = "jitendra@planetwebsolution.com";
		$subject = "Merchant List File In Attachment";
		$bodyText = "Hello, <br> please find the merchant list file in attachment.";
		$email->emailFormat('html');
		$email->subject(strip_tags($subject));
		$email->attachments($attachment_array);
		$email->to($sendto);
		$email->cc($cc);
		if($email->send($bodyText)){
			@chmod($filename);
			@unlink($filename);
		}
	}
	
	/*
	* Function to get the merchant account is mojopay or not
	* task id 3694 Date 13 Mar 2014
	* @Return True or false
	*/
	public function superadmin_isMojopayAccount(){
		$this->autoRender = false;
		$this->layout = false;
		if(isset($_POST['email_address']) && isset($_POST['account_number'])){
			$this->loadModel('Merchant');
			$merchantCount = $this->Merchant->find('count',array('conditions'=>array('Merchant.contactEmail'=>$_POST['email_address'],'Merchant.CID'=>$_POST['account_number'],'Merchant.processorID'=>array(1357,1563,1607,1608))));
			if($merchantCount>0){
				echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>TRUE</response_message></response>';exit;
			}else{
				echo $api_response_xml = '<?xml version="1.0" encoding="utf-8"?><response><response_message>FALSE</response_message></response>';exit;
			}
		}
	
	}
	
}

?>
