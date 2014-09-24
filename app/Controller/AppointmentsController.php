<?php
App::uses('CakeEmail', 'Network/Email');
class AppointmentsController extends AppController {

	var $layout = 'admin';

	var $helpers = array('Html','Text','Paginator'); //add some other helpers to controller

    var $components = array('Session','Common','Cookie','Email','RequestHandler');

	public function superadmin_addappointment(){  
		$currentdate = "";
		if($this->request->is('post')){
			$dateCompareFrom = "";
			$dateCompareTo = "";
			$merchantID = $this->request->data['Appointment']['merchantID'];
			$fromdate = $this->request->data['Appointment']['appointmentFrom'];
			$todate = $this->request->data['Appointment']['appointmentTo'];
			$currentdate =time();

			$dateCompareFrom = date("Y-m-d H:i:s",strtotime($fromdate));			
			$dateCompareTo = date("Y-m-d H:i:s",strtotime($todate));
			
			$successUserType = array();
			$failure = 0;
			$failureMSG = "";

			if(isset($this->request->data['Appointment']['agent']) && $this->request->data['Appointment']['agent']=='1'){				
				$conditionAgent1 		= array('Appointment.appointmentFrom <='=>$dateCompareFrom, 'Appointment.appointmentTo >='=>$dateCompareFrom,'Appointment.merchantID!='.$merchantID,'Appointment.app_agent'=>$this->request->data['Appointment']['agentID']);
				$agentAppointmentFrom 	= $this->Appointment->find('count',array('conditions'=>$conditionAgent1));
				$conditionAgent2		= array('Appointment.appointmentFrom <='=>$dateCompareTo, 'Appointment.appointmentTo >='=>$dateCompareTo,'Appointment.merchantID!='.$merchantID,'Appointment.app_agent'=>$this->request->data['Appointment']['agentID']);
				$agentAppointmentTo 	= $this->Appointment->find('count',array('conditions'=>$conditionAgent2));
				if($agentAppointmentFrom==1 || $agentAppointmentTo==1){				
					$failure++;
					$failureMSG .= "Appointment already scheduled of this Agent with other merchant for this time duration.<br/>";
				}else{
					$successUserType[] = 'Agent';					
					$this->request->data['Appointment']['app_agent'] = $this->request->data['Appointment']['agentID'];
				}
			}
			if(isset($this->request->data['Appointment']['manager']) && $this->request->data['Appointment']['manager'] =='1' ){				
				$conditionManager1 		= array('Appointment.appointmentFrom <='=>$dateCompareFrom, 'Appointment.appointmentTo >='=>$dateCompareFrom,'Appointment.merchantID!='.$merchantID,'Appointment.app_manager'=>$this->request->data['Appointment']['managerID']);
				$managerAppointmentFrom = $this->Appointment->find('count',array('conditions'=>$conditionManager1));
				$conditionManager2		= array('Appointment.appointmentFrom <='=>$dateCompareTo, 'Appointment.appointmentTo >='=>$dateCompareTo,'Appointment.merchantID!='.$merchantID,'Appointment.app_manager'=>$this->request->data['Appointment']['managerID']);
				$managerAppointmentTo 	= $this->Appointment->find('count',array('conditions'=>$conditionManager2));
				if($managerAppointmentFrom==1 || $managerAppointmentTo==1){	
					$failure++;
					$failureMSG .= "Appointment already scheduled of this Manager with other merchant for this time duration.<br/>";
				}else{
					$successUserType[] = 'Manager';
					$this->request->data['Appointment']['app_manager'] = $this->request->data['Appointment']['managerID'];
				}	
			}
			if(isset($this->request->data['Appointment']['iso']) && $this->request->data['Appointment']['iso']=='1' ){				
				$conditionIso1 		= array('Appointment.appointmentFrom <='=>$dateCompareFrom, 'Appointment.appointmentTo >='=>$dateCompareFrom,'Appointment.merchantID!='.$merchantID,'Appointment.app_ISO'=>$this->request->data['Appointment']['isoID']);
				$isoAppointmentFrom = $this->Appointment->find('count',array('conditions'=>$conditionIso1));
				$conditionIso2		= array('Appointment.appointmentFrom <='=>$dateCompareTo, 'Appointment.appointmentTo >='=>$dateCompareTo,'Appointment.merchantID!='.$merchantID,'Appointment.app_ISO'=>$this->request->data['Appointment']['isoID']);
				$isoAppointmentTo	= $this->Appointment->find('count',array('conditions'=>$conditionIso2));
				if($isoAppointmentFrom==1 || $isoAppointmentTo==1){	
					$failure++;
					$failureMSG .= "Appointment already scheduled of this ISO with other merchant for this time duration.<br/>";
				}else{
					$successUserType[] = 'Iso';
					$this->request->data['Appointment']['app_ISO'] = $this->request->data['Appointment']['isoID'];
				}	
			}
			if(isset($this->request->data['Appointment']['processor']) && $this->request->data['Appointment']['processor']=='1' ){
				$conditionProcessor1 		= array('Appointment.appointmentFrom <='=>$dateCompareFrom, 'Appointment.appointmentTo >='=>$dateCompareFrom,'Appointment.merchantID!='.$merchantID,'Appointment.app_processor'=>$this->request->data['Appointment']['processorID']);
				$ProcessorAppointmentFrom 	= $this->Appointment->find('count',array('conditions'=>$conditionProcessor1));
				$conditionProcessor2		= array('Appointment.appointmentFrom <='=>$dateCompareTo, 'Appointment.appointmentTo >='=>$dateCompareTo,'Appointment.merchantID!='.$merchantID,'Appointment.app_processor'=>$this->request->data['Appointment']['processorID']);
				$ProcessorAppointmentTo		= $this->Appointment->find('count',array('conditions'=>$conditionProcessor2));
				if($ProcessorAppointmentFrom==1 || $ProcessorAppointmentTo==1){
					$failure++;
					$failureMSG .= "Appointment already scheduled of this processor with other merchant for this time duration.<br/>";
				}else{
					$successUserType[] = 'Processor';
					$this->request->data['Appointment']['app_processor'] = $this->request->data['Appointment']['processorID'];
				}
			}
			// check To date is larger than From date
			if(strtotime($dateCompareFrom) < $currentdate){
				$this->Session->write('popup','Sorry! Appointment ToDate Should be greater than Current Date.');			
				$this->Session->setFlash('Sorry! Appointment Date Should be greater than Current Date.');  
				$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:failure"));
			}/*
			commented by pushkar ticket id 1479 & 1506
			elseif(strtotime($dateCompareTo) < strtotime($dateCompareFrom)){
				$this->Session->write('popup','Sorry! Appointment ToDate Should be greater than FromDate.');			
				$this->Session->setFlash('Sorry! Appointment ToDate Should be greater than FromDate.');  
				$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:failure"));
			}*/else{ // add Appointment
				/*** create new appointment ***/
				$timestamp = CURRENTDATE;// Pacific time
				$changedBy = $this->Session->read('UserAuth.User.user_Name');
				$this->request->data['Appointment']['appointmentFrom'] = $dateCompareFrom;
				//$this->request->data['Appointment']['appointmentTo'] = $dateCompareTo; 1479 & 1506
				//pr($this->request->data);die;
				//$this->Appointment->create();
				
				
				$this->Appointment->save($this->request->data);							
				//Send Email to users whose associated with mechant in this note
				
				$appoinmentId=$this->Appointment->getLastInsertID();
				$fileName='appointment_'.$appoinmentId.'.ics';
				
				/// =========================== generate ics file ===================================	
				
$startDate1=date('Ymd',strtotime($this->request->data['Appointment']['appointmentFrom']));
$startTime=date('His',strtotime($this->request->data['Appointment']['appointmentFrom']));
$endDate1=date('Ymd',strtotime('+1 day', strtotime($this->request->data['Appointment']['appointmentTo'])));
$endTime=date('His',strtotime($this->request->data['Appointment']['appointmentTo']));

$this->loadModel('Merchant');
$this->Merchant->recursive = -1;
$merchant = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
$description = "Merchant Legal Name : ".$merchant['Merchant']['merchantName']."\n Merchant Phone Number : ".$merchant['Merchant']['contactPhone']."\n".$this->request->data['Appointment']['appointmentNote'];
$description = str_replace("\\", "", $description);
$description = str_replace("\r", "=0D=0A", $description);
$description = str_replace("\n", "=0D=0A", $description);
$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "example.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".$startDate1."T".$startTime."00Z
DTEND:".$startDate1."T".$startTime."00Z
SUMMARY: An appointment has been added with ".$merchant['Merchant']['merchantName']."
DESCRIPTION;ENCODING=QUOTED-PRINTABLE:".$description."
END:VEVENT
END:VCALENDAR";

//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename='.$fileName);
file_put_contents(WWW_ROOT."files/appoinment_files/".$fileName,$ical);
$attachdocsPath =WWW_ROOT."files/appoinment_files/".$fileName;
				//// =================== End ================================================
				
			
				$email = new CakeEmail("smtp");
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				foreach($successUserType as $users){
					$withuser = strtolower($users)."Email";
					$sendto = $this->request->data['Appointment'][$withuser];
					$subject = "An appointment has been added with you";
					$bodyText = "An appointment has been successfully added to you on ".$dateCompareFrom."  by ".$changedBy." on Date ".$timestamp." with ".$this->request->data['Appointment']['merchantContactName'].".<br/>The appointment note is as following:<br/>".$this->request->data['Appointment']['appointmentNote'];
					$email = new CakeEmail("smtp");
					$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
					$email->attachments(array($attachdocsPath));
					
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					if(Validation::email($sendto)){
						$email->to($sendto);
						$email->send($bodyText);
					}
				}				
				//Send Email to merchant
			/*	$sendtoMerchant = $this->request->data['Appointment']['merchantEmail'];
				$emailText = "An appointment has been successfully added to you From ".$dateCompareFrom." To ".$dateCompareTo."  by ".$changedBy." on Date ".$timestamp." with ".implode(",",$successUserType)." <br/>The appointment note is as following:<br/>".$this->request->data['Appointment']['appointmentNote'];
				//$email->attachments(array($attachdocsPath));
				if(Validation::email($sendtoMerchant)){
					$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
					$email = new CakeEmail("smtp");
					$email->to($sendtoMerchant);
					$email->send($emailText);
				}						
*/
				//add merchant notes when change in status
				if(is_array($successUserType)){
					$apoWithUser = implode(",",$successUserType);
				}else{
					$apoWithUser = $successUserType;
				}
				$this->loadModel('Merchantnote');
				$noteData = array();
				$noteData['Merchantnote']['merchantID'] = $merchantID;
				$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
				$noteData['Merchantnote']['timeStamp'] = $timestamp;
				$noteData['Merchantnote']['note'] = "An Appointment has been added with Your ".$apoWithUser." From ".$dateCompareFrom." To ".$dateCompareTo."  by ".$changedBy." on Date ".$timestamp;
				$this->Merchantnote->save($noteData);
				
				//
								
				if($failure>0){
					$this->Session->write('popup',$failureMSG);
					$this->Session->setFlash($failureMSG);
					$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:success"));
					exit;
				}else{
					$this->Session->write('popup','Appointment added successfully.');
					$this->Session->setFlash('Appointment added successfully.');
					$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:success"));
				}
				
				unlink($attachdocsPath); // uplink the file
				
			}// add Appointment
		}	
	}
	
	public function superadmin_editappointment($app_id=null){
		
		
		if($this->referer()=='/' || $this->referer()==FULL_BASE_URL.router::url('/',false).'superadmin/usermgmt/users/role')
		{
			$this->redirect(FULL_BASE_URL.router::url('/',false).'superadmin/dashboard');
		}
		
		$this->layout = 'ajax';
		$currentdate = "";
		if($this->request->is('get')){
			$this->request->data = $this->Appointment->find("first",array('conditions'=>array('Appointment.id'=>$app_id)));
			$this->request->data['Appointment']['appointmentFrom'] = date("m/d/Y h:i a",strtotime($this->request->data['Appointment']['appointmentFrom']));
			$this->request->data['Appointment']['appointmentTo'] = date("m/d/Y h:i a",strtotime($this->request->data['Appointment']['appointmentTo']));
		}else{
			
			$dateCompareFrom = "";
			$dateCompareTo = "";
			$merchantID = $this->request->data['Appointment']['merchantID'];
			$fromdate = $this->request->data['Appointment']['appointmentFrom'];
			$todate = $this->request->data['Appointment']['appointmentTo'];
			$appointmentID = $this->request->data['Appointment']['id'];
			$currentdate =time();
			
			if(isset($this->request->data['Appointment']['editFrom'])){
				$redirectTo = $this->request->data['Appointment']['editFrom'];
			}else{
				$redirectTo = "";
			}
			
			// get merchant information
			$this->loadModel('Merchant');
			$merchantInfo = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));			
			
			$dateCompareFrom = date("Y-m-d H:i:s",strtotime($fromdate));
			//$dateCompareTo = date("Y-m-d H:i:s",strtotime($todate));
			
			$successUserType = array();
			$failure = 0;
			$failureMSG = "";

			if(isset($this->request->data['Appointment']['agent']) && $this->request->data['Appointment']['agent']=='1'){				
				$conditionAgent1 		= array('Appointment.appointmentFrom <='=>$dateCompareFrom, 'Appointment.appointmentTo >='=>$dateCompareFrom,'Appointment.merchantID!='.$merchantID,'Appointment.app_agent'=>$merchantInfo['Merchant']['agentID']);
				$agentAppointmentFrom 	= $this->Appointment->find('count',array('conditions'=>$conditionAgent1));
				$conditionAgent2		= array('Appointment.appointmentFrom <='=>$dateCompareTo, 'Appointment.appointmentTo >='=>$dateCompareTo,'Appointment.merchantID!='.$merchantID,'Appointment.app_agent'=>$merchantInfo['Merchant']['agentID']);
				$agentAppointmentTo 	= $this->Appointment->find('count',array('conditions'=>$conditionAgent2));
				if($agentAppointmentFrom==1 || $agentAppointmentTo==1){				
					$failure++;
					$failureMSG .= "Appointment already scheduled of this Agent with other merchant for this time duration.<br/>";
				}else{
					$successUserType[] = 'Agent';					
					$this->request->data['Appointment']['app_agent'] = $merchantInfo['Merchant']['agentID'];
				}
			}else{
				$this->request->data['Appointment']['app_agent'] = "";
			}
			if(isset($this->request->data['Appointment']['manager']) && $this->request->data['Appointment']['manager'] =='1' ){				
				$conditionManager1 		= array('Appointment.appointmentFrom <='=>$dateCompareFrom, 'Appointment.appointmentTo >='=>$dateCompareFrom,'Appointment.merchantID!='.$merchantID,'Appointment.app_manager'=>$merchantInfo['Merchant']['managerID']);
				$managerAppointmentFrom = $this->Appointment->find('count',array('conditions'=>$conditionManager1));
				$conditionManager2		= array('Appointment.appointmentFrom <='=>$dateCompareTo, 'Appointment.appointmentTo >='=>$dateCompareTo,'Appointment.merchantID!='.$merchantID,'Appointment.app_manager'=>$merchantInfo['Merchant']['managerID']);
				$managerAppointmentTo 	= $this->Appointment->find('count',array('conditions'=>$conditionManager2));
				if($managerAppointmentFrom==1 || $managerAppointmentTo==1){	
					$failure++;
					$failureMSG .= "Appointment already scheduled of this Manager with other merchant for this time duration.<br/>";
				}else{
					$successUserType[] = 'Manager';
					$this->request->data['Appointment']['app_manager'] = $merchantInfo['Merchant']['managerID'];
				}	
			}else{
				$this->request->data['Appointment']['app_manager'] = "";
			}
			if(isset($this->request->data['Appointment']['iso']) && $this->request->data['Appointment']['iso']=='1' ){				
				$conditionIso1 		= array('Appointment.appointmentFrom <='=>$dateCompareFrom, 'Appointment.appointmentTo >='=>$dateCompareFrom,'Appointment.merchantID!='.$merchantID,'Appointment.app_ISO'=>$merchantInfo['Merchant']['isoID']);
				$isoAppointmentFrom = $this->Appointment->find('count',array('conditions'=>$conditionIso1));
				$conditionIso2		= array('Appointment.appointmentFrom <='=>$dateCompareTo, 'Appointment.appointmentTo >='=>$dateCompareTo,'Appointment.merchantID!='.$merchantID,'Appointment.app_ISO'=>$merchantInfo['Merchant']['isoID']);
				$isoAppointmentTo	= $this->Appointment->find('count',array('conditions'=>$conditionIso2));
				if($isoAppointmentFrom==1 || $isoAppointmentTo==1){	
					$failure++;
					$failureMSG .= "Appointment already scheduled of this ISO with other merchant for this time duration.<br/>";
				}else{
					$successUserType[] = 'Iso';
					$this->request->data['Appointment']['app_ISO'] = $merchantInfo['Merchant']['isoID'];
				}	
			}else{
				$this->request->data['Appointment']['app_ISO'] = "";
			}
			if(isset($this->request->data['Appointment']['processor']) && $this->request->data['Appointment']['processor']=='1' ){
				$conditionProcessor1 		= array('Appointment.appointmentFrom <='=>$dateCompareFrom, 'Appointment.appointmentTo >='=>$dateCompareFrom,'Appointment.merchantID!='.$merchantID,'Appointment.app_processor'=>$merchantInfo['Merchant']['processorID']);
				$ProcessorAppointmentFrom 	= $this->Appointment->find('count',array('conditions'=>$conditionProcessor1));
				$conditionProcessor2		= array('Appointment.appointmentFrom <='=>$dateCompareTo, 'Appointment.appointmentTo >='=>$dateCompareTo,'Appointment.merchantID!='.$merchantID,'Appointment.app_processor'=>$merchantInfo['Merchant']['processorID']);
				$ProcessorAppointmentTo		= $this->Appointment->find('count',array('conditions'=>$conditionProcessor2));
				if($ProcessorAppointmentFrom==1 || $ProcessorAppointmentTo==1){
					$failure++;
					$failureMSG .= "Appointment already scheduled of this processor with other merchant for this time duration.<br/>";
				}else{
					$successUserType[] = 'Processor';
					$this->request->data['Appointment']['app_processor'] = $merchantInfo['Merchant']['processorID'];
				}
			}else{
				$this->request->data['Appointment']['app_processor'] = "";
			}
			
			// check To date is larger than From date
			if(strtotime($dateCompareFrom) < $currentdate){
				$this->Session->write('popup','Sorry! Appointment ToDate Should be greater than Current Date.');			
				$this->Session->setFlash('Sorry! Appointment ToDate Should be greater than Current Date.');  
				if($redirectTo=='dashboard'){
					$this->redirect('/superadmin/usermgmt/users/dashboard/message:failure');
				}else{
					$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:failure"));
				}
			}/*elseif(strtotime($dateCompareTo) < strtotime($dateCompareFrom)){
				$this->Session->write('popup','Sorry! Appointment ToDate Should be greater than FromDate.');			
				$this->Session->setFlash('Sorry! Appointment ToDate Should be greater than FromDate.');
				if($redirectTo=='dashboard'){
					$this->redirect('/superadmin/usermgmt/users/dashboard/message:failure');
				}else{
					$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:failure"));
				}  				
			}*/else{ 
				/*** update appointment ***/
				$timestamp = CURRENTDATE;
				$changedBy = $this->Session->read('UserAuth.User.user_Name');	
				$this->request->data['Appointment']['appointmentFrom'] = $dateCompareFrom;
				$this->request->data['Appointment']['appointmentTo'] = $dateCompareTo;
				
				if($failure==0){	
				
								
					$this->Appointment->save($this->request->data);
					//Send Email to users whose associated with mechant in this note

				$appoinmentId=$this->request->data['Appointment']['id'];
				$fileName='appointment_'.$appoinmentId.'.ics';
		/// =========================== generate ics file ===================================	
				
$startDate1=date('Ymd',strtotime($this->request->data['Appointment']['appointmentFrom']));
$startTime=date('His',strtotime($this->request->data['Appointment']['appointmentFrom']));
$endDate1=date('Ymd',strtotime($this->request->data['Appointment']['appointmentTo']));
$endTime=date('His',strtotime($this->request->data['Appointment']['appointmentTo']));

$this->loadModel('Merchant');
$this->Merchant->recursive = -1;
$merchant = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
$description = "Merchant Legal Name : ".$merchant['Merchant']['merchantName']."\n Merchant Phone Number : ".$merchant['Merchant']['contactPhone']."\n".$this->request->data['Appointment']['appointmentNote'];
$description = str_replace("\\", "", $description);
$description = str_replace("\r", "=0D=0A", $description);
$description = str_replace("\n", "=0D=0A", $description);

$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "example.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".$startDate1."T".$startTime."00Z
DTEND:".$startDate1."T".$startTime."00Z
SUMMARY: An appointment has been added with ".$merchant['Merchant']['merchantName']."
DESCRIPTION;ENCODING=QUOTED-PRINTABLE:".$description."
END:VEVENT
END:VCALENDAR";


//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename='.$fileName);
file_put_contents(WWW_ROOT."files/appoinment_files/".$fileName,$ical);
$attachdocsPath =WWW_ROOT."files/appoinment_files/".$fileName;
				//// =================== End ================================================					
					
					
					
					foreach($successUserType as $users){					
						$sendto = $merchantInfo[$users]['userEmail'];
						$subject = "An appointment has been added with you";
						$bodyText = "An appointment has been successfully added to you on ".$dateCompareFrom."  by ".$changedBy." on Date ".$timestamp." with ".$this->request->data['Appointment']['merchantContactName'].".<br/>The appointment note is as following:<br/>".$this->request->data['Appointment']['appointmentNote'];
						$email = new CakeEmail("smtp");
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
						 $email->attachments(array($attachdocsPath));
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						if(Validation::email($sendto)){
							$email->to($sendto);
							$email->send($bodyText);
						}
					}				
					//Send Email to merchant
					$sendtoMerchant = $merchantInfo['Merchant']['contactEmail'];
					$emailText = "An appointment has been successfully added to you on ".$dateCompareFrom." by ".$changedBy." on Date ".$timestamp." with ".implode(",",$successUserType)." <br/>The appointment note is as following:<br/>".$this->request->data['Appointment']['appointmentNote'];
					 $email->attachments(array($attachdocsPath));
					if(Validation::email($sendtoMerchant)){
						$email->to($sendtoMerchant);
						$email->send($emailText);
					}						
	
					//add merchant notes when change in status
					if(is_array($successUserType)){
						$apoWithUser = implode(",",$successUserType);
					}else{
						$apoWithUser = $successUserType;
					}
					$this->loadModel('Merchantnote');
					$noteData = array();
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = "An Appointment has been added with Your ".$apoWithUser." From ".$dateCompareFrom." To ".$dateCompareTo."  by ".$changedBy." on Date ".$timestamp;
					$this->Merchantnote->save($noteData);
					
					$this->Session->write('popup','Appointment updated successfully.');
					$this->Session->setFlash('Appointment updated successfully.');
					if($redirectTo=='dashboard'){
						$this->redirect('/superadmin/usermgmt/users/dashboard/message:success');
					}else{
						$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:success"));
					}
				}else{
					$this->Session->write('popup',$failureMSG);
					$this->Session->setFlash($failureMSG);
					if($redirectTo=='dashboard'){
						$this->redirect('/superadmin/usermgmt/users/dashboard/message:failure');
					}else{
						$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:failure"));
					}					
					exit;
				}
				
				unlink($attachdocsPath); // uplink the file
			}
			
		}
			
	}	

	public function superadmin_deleteAppoinment($id= null,$merchantID=null) {

		if($this->Appointment->delete($id))
		{
			$this->Session->write('popup','Merchant Appointment has been deleted successfully.');	
			$this->Session->setFlash('Merchant Appointment has been deleted successfully.');  
			$this->redirect(array('controller'=>'merchants','action' => "appointments/".$merchantID."/message:success"));	
		}

	}
	
	public function superadmin_delete($id= null) {
	
		if($this->Appointment->delete($id))
		{
			$this->Session->write('popup','Merchant Appointment has been deleted successfully.');
			$this->Session->setFlash('Merchant Appointment has been deleted successfully.');
			//$this->redirect('usermgmt/users/dashboard/message:success');
			
			$this->redirect('/superadmin/usermgmt/users/dashboard/message:success');
			
		}
	
	}

	public function beforeFilter()
	{
		$this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
		parent::beforeFilter();
	}

}