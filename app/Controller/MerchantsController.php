<?php
//error_reporting(0);
App::uses('CakeEmail', 'Network/Email');

class MerchantsController extends AppController {

	var $layout = 'admin';
	var $helpers = array('Html','Text','Paginator','CakeGrid.Grid','Number'); //add some other helpers to controller
	var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler','HighCharts.HighCharts');
	
	public $HighCharts = null;
	
    /*public function index() {
        $this->Merchant->recursive = 0;
        $this->set('merchants', $this->paginate());
    }*/

	public function superadmin_addmerchant(){		
		$errorsArr ='';	
		$this->loadModel('Status');
 		$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.navigationOrder ASC")));
		
		$this->set('status',$Status_list);
		
		$this->loadModel('Usercat');
		$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
		$this->set('uc_list',$uc_list);
		
		$this->loadModel('Accounttype');
 		$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		$this->set('ac_list',$ac_list);
		
		$this->loadModel('Accountcat');
 		$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder asc")));
		$this->set('acat_list',$acat_list);
		
		$this->loadModel('BusinessCategory');
		$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
		$this->set('busi_cat_id',$busi_cat_id);
		
		$this->loadModel('User');
		$agentList =$this->Common->getAgentList(1);
		$this->set('agentList',$agentList);
		
		$referalList =$this->Common->getReferalList(1);
		$this->set('referalList',$referalList);
		
		$procList =$this->Common->getProcessorList(1);
		$this->set('procList',$procList);
		
		$mangList = $this->Common->getManagerList(1);
		$this->set('mangList',$mangList);
		
		$isoList = $this->Common->getIsoList(1);
		$this->set('isoList',$isoList);	
		
		$this->loadModel('Gateway');
 		$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
		$this->set('gatwayList',$gatwayList);
		if($this->request->is('get')){
			$this->request->data['Merchant']['agentID'] = $this->Session->read('UserAuth.User.id');
			$this->request->data['Merchant']['managerID'] = $this->Session->read('UserAuth.User.id');
			$this->request->data['Merchant']['processorID'] = $this->Session->read('UserAuth.User.id');
			/* $this->request->data['Merchant']['referalID'] = $this->Session->read('UserAuth.User.id');
			$this->request->data['Merchant']['isoID'] = $this->Session->read('UserAuth.User.id'); */
		}
		
	
		if($this->request->is('post')){
			foreach ($this->request->data['Merchant'] as $key => $value){
				$this->request->data['Merchant'][$key] = trim($value);
			}
			$this->Merchant->set($this->request->data);
			if(!$this->Merchant->validates()) 
			{
				$errorsArr = $this->Merchant->validationErrors;	
			}
			$this->request->data['Merchant']['startDate'] = $this->request->data['Merchant']['startDateMonth']."/".$this->request->data['Merchant']['startDateDay']."/".$this->request->data['Merchant']['startDateYear'];
			$this->request->data['Merchant']['sendUpDate'] = date("n/d/Y",time());
			$this->request->data['Merchant']['preappDate'] = date("Y-m-d");
			// task id 3532 to save form_id in taboo
			$this->request->data['Merchant']['form_id'] = 1;

			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				$statusID = $this->request->data['Merchant']['statusID'];
				if(is_array($this->request->data['Merchant']['merchantType'])){
					$this->request->data['Merchant']['merchantType'] = implode(",",$this->request->data['Merchant']['merchantType']);
				}
				//pr($this->request->data);die;
				if($this->Merchant->save($this->request->data)) {
					// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $this->Merchant->getLastInsertID();
					$pipelineData['Merchantpipeline']['statusFrom'] = 0;
					$pipelineData['Merchantpipeline']['statusTo'] = $statusID;
					$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
					$this->Merchantpipeline->save($pipelineData);
					
					
					$this->loadModel('Merchantnote');
					$noteData['Merchantnote']['merchantID'] = $pipelineData['Merchantpipeline']['merchantID'];
					$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
					//$timestamp = date("n/j/Y g:i:s A");
					//$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = CURRENTDATE;
					
					$noteData['Merchantnote']['note'] = "Merchant has been added successfully on Date ".CURRENTDATE;
					$this->Merchantnote->save($noteData);
					
					
					
					$this->Session->write('popup','New Merchant has been added successfully.');			
					$this->Session->setFlash('New Merchant has been added successfully.');  
					$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/".$statusID."/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}
		else{
			//task id 3899
			$this->request->data['Merchant']['isoID'] = $this->Common->getUserIso($this->Session->read('UserAuth.User.id'));			
		}
		// end if of check data array
	 } 
	 
	public function superadmin_search(){
			ini_set("memory_limit","1024M");
            $condition  = '';
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
			$this->set('status',$Status_list);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			$statusID = '';
			$agentID  = '';
			$processorID = '';
			$managerID = '';
			$isoID = '';
			$referalID = '';
			$merchantName = '';
			$CID = '';
			$contactName = '';
			$contactPhone = '';
			$contactEmail = '';
			$merchantDBA = '';
			$merchantURL = '';
			$argArr = array();
			
			// delete merchant
			if(isset($this->request->data['Merchant']['deleteID']) && $this->request->data['Merchant']['deleteID']!=''){
				$this->superadmin_delete($this->request->data['Merchant']['deleteID']);
			}
			
			if(isset($this->request->query) && count($this->request->query)>0){		
				$argArr = array();
				//for Merchcnt status
					if(isset($this->request->query['statusID']) && $this->request->query['statusID']) {
						$statusID = $this->request->query['statusID'];
						$argArr['statusID'] = $statusID;
					}				
				//for agentID
					if(isset($this->request->query['agentID']) && $this->request->query['agentID']) {
						$agentID = $this->request->query['agentID'];
						$argArr['agentID'] = $agentID;
					}
				//for accountTypeID
					if(isset($this->request->query['merchantName']) && $this->request->query['merchantName']) {
						$merchantName = trim($this->request->query['merchantName']);
						$argArr['merchantName'] = $merchantName;
					}
				//for processorID
					if(isset($this->request->query['processorID']) && $this->request->query['processorID']) {
						$processorID = $this->request->query['processorID'];
						$argArr['processorID'] = $processorID;
					}
				//for managerID
					if(isset($this->request->query['managerID']) && $this->request->query['managerID']) {
						$managerID = $this->request->query['managerID'];
						$argArr['managerID'] = $managerID;
					}
				//for isoID
					if(isset($this->request->query['isoID']) && $this->request->query['isoID']) {
						$isoID = $this->request->query['isoID'];
						$argArr['isoID'] = $isoID;
					}	
				//for RefferalID
					if(isset($this->request->query['referalID']) && $this->request->query['referalID']) {
						$referalID = $this->request->query['referalID'];
						$argArr['referalID'] = $referalID;
					}	
				//for CID
					if(isset($this->request->query['CID']) && $this->request->query['CID']) {
						$CID = trim($this->request->query['CID']);
						$argArr['CID'] = $CID;
					}
					if(isset($this->request->query['contactName']) && $this->request->query['contactName']) {
						$contactName = trim($this->request->query['contactName']);
						$argArr['contactName'] = $contactName;
					}	
					if(isset($this->request->query['contactPhone']) && $this->request->query['contactPhone']) {
						$contactPhone = trim($this->request->query['contactPhone']);
						$argArr['contactPhone'] = $contactPhone;
					}
					if(isset($this->request->query['contactEmail']) && $this->request->query['contactEmail']) {
						$contactEmail = trim($this->request->query['contactEmail']);
						$argArr['contactEmail'] = $contactEmail;
					}
					if(isset($this->request->query['merchantDBA']) && $this->request->query['merchantDBA']) {
						$merchantDBA = trim($this->request->query['merchantDBA']);
						$argArr['merchantDBA'] = $merchantDBA;
					}
					if(isset($this->request->query['merchantURL']) && $this->request->query['merchantURL']) {
						$merchantURL = trim($this->request->query['merchantURL']);
						$argArr['merchantURL'] = $merchantURL;
					}
					if(isset($this->request->query['common_search']) && $this->request->query['common_search']) {
						$commonSearch = trim($this->request->query['common_search']);
						$argArr['common_search'] = $commonSearch;
					}
							
										
			}		
			if(isset($this->params['named']) && count($this->params['named'])>0){
				//pr($this->params);
				//for Area of interest
				if(isset($this->params['named']['statusID']) && $this->params['named']['statusID']) {
					$statusID = $this->params['named']['statusID'];
					$argArr['statusID'] = $statusID;
				}				
				if(isset($this->params['named']['agentID']) && $this->params['named']['agentID']) {
					$agentID = $this->params['named']['agentID'];
					$argArr['agentID'] = $agentID;
				}
				if(isset($this->params['named']['merchantName']) && $this->params['named']['merchantName']) {
					$merchantName = $this->params['named']['merchantName'];
					$argArr['merchantName'] = $merchantName;
				}
				//for Area of interest
				if(isset($this->params['named']['processorID']) && $this->params['named']['processorID']) {
					$processorID = $this->params['named']['processorID'];
					$argArr['processorID'] = $processorID;
				}
				//for Area of interest
				if(isset($this->params['named']['managerID']) && $this->params['named']['managerID']) {
					$managerID = $this->params['named']['managerID'];
					$argArr['managerID'] = $managerID;
				}
				//for Area of interest
				if(isset($this->params['named']['isoID']) && $this->params['named']['isoID']) {
					$isoID = $this->params['named']['isoID'];
					$argArr['isoID'] = $isoID;
				}
				//for Area of interest
				if(isset($this->params['named']['referalID']) && $this->params['named']['referalID']) {
					$referalID = $this->params['named']['referalID'];
					$argArr['referalID'] = $referalID;
				}
					
				if(isset($this->params['named']['CID']) && $this->params['named']['CID']) {
					$CID = $this->params['named']['CID'];
					$argArr['CID'] = $CID;
				}
				if(isset($this->params['named']['contactName']) && $this->params['named']['contactName']) {
					$contactName = $this->params['named']['contactName'];
					$argArr['contactName'] = $contactName;
				}
				if(isset($this->params['named']['contactPhone']) && $this->params['named']['contactPhone']) {
					$contactPhone = $this->params['named']['contactPhone'];
					$argArr['contactPhone'] = $contactPhone;
				}
				if(isset($this->params['named']['contactEmail']) && $this->params['named']['contactEmail']) {
					$contactEmail = $this->params['named']['contactEmail'];
					$argArr['contactEmail'] = $contactEmail;
				}
				if(isset($this->params['named']['merchantDBA']) && $this->params['named']['merchantDBA']) {
					$merchantDBA = $this->params['named']['merchantDBA'];
					$argArr['merchantDBA'] = $merchantDBA;
				}
				if(isset($this->params['named']['merchantURL']) && $this->params['named']['merchantURL']) {
					$merchantURL = $this->params['named']['merchantURL'];
					$argArr['merchantURL'] = $merchantURL;
				}
				if(isset($this->params['named']['common_search']) && $this->params['named']['common_search']) {
					$commonSearch = $this->params['named']['common_search'];
					$argArr['common_search'] = $commonSearch;
				}
					
			}	
			$condition .= ' 1 = 1';

			$loginRole = $this->Session->read('UserAuth.UserGroup.name');
			// List Merchant which is assigned to login user under LOGIN ROLE( like agent,manager,iso, etc..)
			//if(strtolower($loginRole)!='admin' && count($this->request->query)<=0 && count($this->params['named'])<=0){
			if(strtolower($loginRole)!='admin'){
				/* List Merchant which is assigned to login user under agent */
				if(strtolower($loginRole)=='agent')
					$agentID = $this->Session->read('UserAuth.User.id');
				elseif(strtolower($loginRole)=='processor')
					$processorID = $this->Session->read('UserAuth.User.id');
				elseif(strtolower($loginRole)=='iso')
					$isoID = $this->Session->read('UserAuth.User.id');
				elseif(strtolower($loginRole)=='referal' || strtolower($loginRole)=='referral')
					$referalID = $this->Session->read('UserAuth.User.id');
				elseif(strtolower($loginRole)=='manager')
					$managerID = $this->Session->read('UserAuth.User.id');
			}/* elseif(strtolower($loginRole)=='admin' && count($this->request->query)<=0 && count($this->params['named'])<=0){
				$agentID = $this->Session->read('UserAuth.User.id');
				$processorID = $this->Session->read('UserAuth.User.id');
				$isoID = $this->Session->read('UserAuth.User.id');
				$referalID = $this->Session->read('UserAuth.User.id');
				$managerID = $this->Session->read('UserAuth.User.id');
			} */
			
			
			
			/* if search params is status */
			if(is_array($statusID)){
				$condition  .= ' AND Merchant.statusID IN ('.implode(",", $statusID).')';
			}elseif($statusID!='' && $statusID!='all'){
				$condition  .= ' AND Merchant.statusID = '.$statusID;
			}
			/* if search params is agent */
			if(is_array($agentID))
				$condition  .= ' AND Merchant.agentID IN ('.implode(",", $agentID).')';
			elseif($agentID!='')
				$condition .= ' AND Merchant.agentID = '.$agentID;			
			/* if search params is processor **/
			if(is_array($processorID))
				$condition  .= ' AND Merchant.processorID IN ('.implode(",", $processorID).')';
			elseif($processorID!='')
				$condition .= ' AND Merchant.processorID = '.$processorID;
			/* if search params is manager **/
			if(is_array($managerID))
				$condition  .= ' AND Merchant.managerID IN ('.implode(",", $managerID).')';
			elseif($managerID!='')
				$condition .= ' AND Merchant.managerID = '.$managerID;
			/* if search params is iso **/
			if(is_array($isoID))
				$condition  .= ' AND Merchant.isoID IN ('.implode(",", $isoID).')';
			elseif($isoID!='')
				$condition .= ' AND Merchant.isoID = '.$isoID;			
			/* if search params is referal **/
			if(is_array($referalID))
				$condition  .= ' AND Merchant.referalID IN ('.implode(",", $referalID).')';
			elseif($referalID!='')
				$condition .= ' AND Merchant.referalID = '.$referalID;
			/* if search params is CID **/	
			if($merchantName!='')
				$condition .= " AND Merchant.merchantName LIKE '%".$merchantName."%'";
			if($CID!='') 
				$condition .= " AND Merchant.CID LIKE '%".$CID."%'";
			if($contactName!='') 
				$condition .= " AND Merchant.contactName LIKE '%".$contactName."%'";
			if($contactPhone!='') 
				$condition .= " AND Merchant.contactPhone = '".$contactPhone."'";
			if($contactEmail!='') 
				$condition .= " AND Merchant.contactEmail LIKE '%".$contactEmail."%'";
			if($merchantDBA!='') 
				$condition .= " AND Merchant.merchantDBA LIKE '%".$merchantDBA."%'";
			if($merchantURL!='') 
				$condition .= " AND Merchant.merchantURL LIKE '%".$merchantURL."%'";
			
			// task id 3085 on jan-15-2014
			if(strlen($commonSearch)>0){
				$condition = "(Merchant.merchantName LIKE '%".$commonSearch."%' OR Merchant.CID LIKE '%".$commonSearch."%' OR Merchant.contactName LIKE '%".$commonSearch."%' OR Merchant.contactPhone LIKE '%".$commonSearch."%' OR Merchant.contactEmail LIKE '%".$commonSearch."%' OR Merchant.merchantDBA LIKE '%".$commonSearch."%' OR Merchant.merchantURL LIKE '%".$commonSearch."%')";
				// task id 3899
				if(strtolower($loginRole)=='agent'){
					$agentID = $this->Session->read('UserAuth.User.id');
					$condition .= ' AND Merchant.agentID = '.$agentID;
				}
			}
			//echo $condition;				
			$this->Merchant->unbindModel(
					array(
							'hasMany' => array('Commissionlog'),
                            'belongsTo' => array('Agent','ISO'),
                            'hasOne' => array('Commission')
                         )
			,false);
			//echo $condition;	
			if(strlen($condition)>6){
			//$MerchantRec = $this->Merchant->find('count',array('conditions' => array($condition)));		
				$this->paginate = array(
					'limit' => 50,
					'fields'=>array('Merchant.id','Merchant.merchantName','Merchant.merchantName','Merchant.merchantDBA','Merchant.merchantURL','Merchant.volume','Processor.user_Name','Manager.user_Name','Status.status','Merchant.CID','ProcessingMethod.accountCategory'),
					'recursive'=>0,
					'order' => array(
						'Merchant.id' => 'desc',
					),
					'conditions' => array($condition),
					'paramType' => 'querystring'
				);
				$MerchantRec = $this->paginate();				
				$this->set('merchantSearchList',$MerchantRec);
				$this->set('totalUser',$MerchantRec);
			}
			$this->set('statusID',$statusID);
			$this->set('agentID',$agentID);
			$this->set('processorID',$processorID);
			$this->set('managerID',$managerID);
			$this->set('isoID',$isoID);
			$this->set('referalID',$referalID);			
			$this->request->data['Merchant']['merchantName'] = $merchantName;
			$this->request->data['Merchant']['CID'] = $CID;
			$this->request->data['Merchant']['contactName'] = $contactName;
			$this->request->data['Merchant']['contactPhone'] = $contactPhone;
			$this->request->data['Merchant']['contactEmail'] = $contactEmail;
			$this->request->data['Merchant']['merchantDBA'] = $merchantDBA;
			$this->request->data['Merchant']['merchantURL'] = $merchantURL;		
			$this->request->data['Merchant']['common_search'] = $commonSearch;
			$this->set('argArr', $argArr);
			// link back to search button
			$search_url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["REQUEST_URI"];
			$this->Session->write('backToSearch',$search_url);
			
			if(isset($this->request->query['Submit']) && $this->request->query['Submit']=='Export'){				
				
				//$MerchantRec =$this->Merchant->find('all',array('conditions' => array($condition),'order'=>array('Merchant.id' => 'DESC')));
				$field_array = array("distinct(Merchant.id)","Merchant.merchantName","Merchant.merchantDBA","Merchant.merchantURL","Merchant.volume","Merchant.CID","Merchant.contactName","Merchant.contactEmail","Merchant.contactPhone","Merchant.legalCountry","Merchant.sicMCC","Merchant.merchantType","Merchant.preappDate","Merchant.startDate","Merchant.form_id","Status.status","Processor.user_Name","Manager.user_Name","Manager.user_Name","MerchantCategory.accountType","Referal.user_Name");
				$MerchantRec =$this->Merchant->find('all',array('fields'=>$field_array,'conditions' => array($condition),'order'=>array('Merchant.id' => 'DESC')));
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
				
				//create a file
				$filename = "Merchant_export_".date("Y.m.d").".csv";
				$csv_file = fopen('php://output', 'w');
			
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
					
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
				fclose($csv_file);die;
			
			}

	}
	 
	public function superadmin_viewbystatus(){
		ini_set("memory_limit","1024M");
		$order='';
		$condition='';

		$this->loadModel('User');
		$agentList =$this->Common->getAgentList(1);
		$this->set('agentList',$agentList);
		
		$procList =$this->Common->getProcessorList(1);
		$this->set('procList',$procList);
		
		$mangList = $this->Common->getManagerList(1);
		$this->set('mangList',$mangList);
		
		$isoList = $this->Common->getIsoList(1);
		$this->set('isoList',$isoList);	
		
		$this->loadModel('Gateway');
		$gatewayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
		$this->set('gatewayList',$gatewayList);
		
		$this->loadModel('Usercat');
		$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
		$this->set('uc_list',$uc_list);
		
		$this->loadModel('Accounttype');
 		$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		$this->set('ac_list',$ac_list);
		
		$this->loadModel('Accountcat');
		$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
		$this->set('acat_list',$acat_list);
		
		$this->loadModel('Status');
 		$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
		$this->set('status',$Status_list);	
		
		$referalList =$this->Common->getReferalList(1);
		$this->set('referalList',$referalList);
		
		$statusID = '';
		$agentID  = '';
		$accountTypeID = '';
		$argArr = array();
		$processorID = '';
		$managerID = '';
		$isoID = '';
		$gatewayID = '';
		$referalID = '';
		$accountCatID = '';
		
		$this->loadModel('Merchantpipeline');
		// unset the back button search link
		if ($this->Session->check('backToSearch')) {
			$this->Session->delete('backToSearch');
		}	
		// delete merchant
		if(isset($this->request->data['Merchant']['deleteID']) && $this->request->data['Merchant']['deleteID']!=''){
			$this->superadmin_delete($this->request->data['Merchant']['deleteID']);
			unset($this->request->data);
		}
		
			if(isset($this->request->query) && count($this->request->query)>0) {
			   //for Merchcnt status
				if(isset($this->request->query['statusID'])) {
					$statusID = $this->request->query['statusID'];
					$argArr['statusID'] = $statusID;
				}				
				//for agentID
				if(isset($this->request->query['agentID'])) {
					$agentID = $this->request->query['agentID'];
					$argArr['agentID'] = $agentID;
				}
				//for accountTypeID
				if(isset($this->request->query['accountTypeID'])) {
					$accountTypeID = $this->request->query['accountTypeID'];
					$argArr['accountTypeID'] = $accountTypeID;
				}
				//for processorID
				if(isset($this->request->query['processorID'])) {
					$processorID = $this->request->query['processorID'];
					$argArr['processorID'] = $processorID;
				}
				//for managerID
				if(isset($this->request->query['managerID'])) {
					$managerID = $this->request->query['managerID'];
					$argArr['managerID'] = $managerID;
				}
				//for isoID
				if(isset($this->request->query['isoID'])) {
					$isoID = $this->request->query['isoID'];
					$argArr['isoID'] = $isoID;
				}	
				//for gateways
				if(isset($this->request->query['gatewayID'])) {
					$gatewayID = $this->request->query['gatewayID'];
					$argArr['gatewayID'] = $gatewayID;
				}
				//for referal id
				if(isset($this->request->query['referalID'])) {
					$referalID = $this->request->query['referalID'];
					$argArr['referalID'] = $referalID;
				}
				// for account category
				if(isset($this->request->query['accountCatID'])) {
					$accountCatID = $this->request->query['accountCatID'];
					$argArr['accountCatID'] = $accountCatID;
				}
				// for month category
				if(isset($this->request->query['month'])) {
					$date = explode("-",$this->request->query['month']);
					$argArr['month'] = $date[1];
					$argArr['year'] = $date[0];
				}								
			}		
		  if((isset($this->params['named']) && count($this->params['named'])>0) || (isset($this->params['pass']) && count($this->params['pass'])>0)){
			//for Area of interest
				if(isset($this->params['named']['statusID']) && $this->params['named']['statusID']) {
					$statusID = $this->params['named']['statusID'];
					$argArr['statusID'] = $statusID;
				}elseif(isset($this->params['pass'][0])){
					$statusID = $this->params['pass'][0];
					$argArr['statusID'] = $statusID;										
				}else{ 
					$statusID = '';
					$argArr['statusID'] = '';
				}
				//for pipeline
				if(isset($this->params['named']['pipeline']) && $this->params['named']['pipeline']) {
					$pipeline = $this->params['named']['pipeline'];
					$argArr['pipeline'] = $pipeline;
				}elseif(isset($this->params['pass'][1])){
					$pipeline = $this->params['pass'][1];
					$argArr['pipeline'] = $pipeline;										
				}else{ 
					$pipeline = '';
					$argArr['pipeline'] = '';	
				}						
				//for Area of interest
				if(isset($this->params['named']['agentID']) && $this->params['named']['agentID']) {
					$agentID = $this->params['named']['agentID'];
					$argArr['agentID'] = $agentID;
				}
				//for Area of interest
				if(isset($this->params['named']['accountTypeID']) && $this->params['named']['accountTypeID']) {
					$accountTypeID = $this->params['named']['accountTypeID'];
					$argArr['accountTypeID'] = $accountTypeID;
				}
				//for Area of interest
				if(isset($this->params['named']['processorID']) && $this->params['named']['processorID']) {
					$processorID = $this->params['named']['processorID'];
					$argArr['processorID'] = $processorID;
				}
				//for Area of interest
				if(isset($this->params['named']['managerID']) && $this->params['named']['managerID']) {
					$managerID = $this->params['named']['managerID'];
					$argArr['managerID'] = $managerID;
				}
				//for Area of interest
				if(isset($this->params['named']['isoID']) && $this->params['named']['isoID']) {
					$isoID = $this->params['named']['isoID'];
					$argArr['isoID'] = $isoID;
				}
				//for Area of interest	
				if(isset($this->params['named']['gatewayID']) && $this->params['named']['gatewayID']) {
					$gatewayID = $this->params['named']['gatewayID'];
					$argArr['gatewayID'] = $gatewayID;
				}
				//for Area of gatewayID	
				if(isset($this->params['named']['referalID']) && $this->params['named']['referalID']) {
					$referalID = $this->params['named']['referalID'];
					$argArr['referalID'] = $referalID;
				}
				//for Area of interest	
				if(isset($this->params['named']['accountCatID']) && $this->params['named']['accountCatID']) {
					$accountCatID = $this->params['named']['accountCatID'];
					$argArr['accountCatID'] = $accountCatID;
				}
				// for month category
				if(isset($this->params['named']['month']) && $this->params['named']['year']) {
					$date = $this->params['named']['month'].$this->params['named']['year'];
					
					$argArr['month'] = $this->params['named']['month'];
					$argArr['year'] = $this->params['named']['year'];
				}						
			}	
			$condition .= ' 1 = 1';

			$loginRole = $this->Session->read('UserAuth.UserGroup.name');
			/* List Merchant which is assigned to login user under LOGIN ROLE( like agent,manager,iso, etc..) */
			//if(strtolower($loginRole)!='admin' && count($this->request->query)<=0 && (count($this->params['named'])<=0 || count($this->params['pass'])<=0)){
			if(strtolower($loginRole)!='admin'){
				/* List Merchant which is assigned to login user under agent */					
				if(strtolower($loginRole)=='agent')
					$agentID = $this->Session->read('UserAuth.User.id');
				elseif(strtolower($loginRole)=='processor')
					$processorID = $this->Session->read('UserAuth.User.id');
				elseif(strtolower($loginRole)=='iso')
					$isoID = $this->Session->read('UserAuth.User.id');
				elseif(strtolower($loginRole)=='referal' || strtolower($loginRole)=='referral')
					$referalID = $this->Session->read('UserAuth.User.id');
				elseif(strtolower($loginRole)=='manager')
					$managerID = $this->Session->read('UserAuth.User.id');
			}/* elseif(strtolower($loginRole)=='admin' && count($this->request->query)<=0 && (count($this->params['named'])<=0 || count($this->params['pass'])<=0) && strlen($pipeline)==0){
				$agentID = $this->Session->read('UserAuth.User.id');
				$processorID = $this->Session->read('UserAuth.User.id');
				$isoID = $this->Session->read('UserAuth.User.id');
				$referalID = $this->Session->read('UserAuth.User.id');
				$managerID = $this->Session->read('UserAuth.User.id');
			} */
			
			/* if search params is agent */
			if(is_array($agentID))
				$condition  .= ' AND Merchant.agentID IN ('.implode(",", $agentID).')';
			elseif($agentID!='')
				$condition .= ' AND Merchant.agentID = '.$agentID;
			/* if search params is accountType **/
			if(is_array($accountTypeID))
				$condition  .= ' AND Merchant.accountTypeID IN ('.implode(",", $accountTypeID).')';
			elseif($accountTypeID!='')
				$condition .= ' AND Merchant.accountTypeID = '.$accountTypeID;
			/* if search params is processor **/
			if(is_array($processorID))
				$condition  .= ' AND Merchant.processorID IN ('.implode(",", $processorID).')';
			elseif($processorID!='')
				$condition .= ' AND Merchant.processorID = '.$processorID;
			/* if search params is manager **/
			if(is_array($managerID))
				$condition  .= ' AND Merchant.managerID IN ('.implode(",", $managerID).')';
			elseif($managerID!='')
				$condition .= ' AND Merchant.managerID = '.$managerID;
			/* if search params is iso **/
			if(is_array($isoID))
				$condition  .= ' AND Merchant.isoID IN ('.implode(",", $isoID).')';
			elseif($isoID!='')
				$condition .= ' AND Merchant.isoID = '.$isoID;
			/* if search params is gateway **/
			if(is_array($gatewayID))
				$condition  .= ' AND Merchant.gatewayID IN ('.implode(",", $gatewayID).')';
			elseif($gatewayID!='')
				$condition .= ' AND Merchant.gatewayID = '.$gatewayID;
			/* if search params is referal **/
			if(is_array($referalID))
				$condition  .= ' AND Merchant.referalID IN ('.implode(",", $referalID).')';
			elseif($referalID!='')
				$condition .= ' AND Merchant.referalID = '.$referalID;
			/* if search params is accountCat **/
			if(is_array($accountCatID))
				$condition  .= ' AND Merchant.accountCategory IN ('.implode(",", $accountCatID).')';
			elseif($accountCatID!='')
				$condition .= ' AND Merchant.accountCategory = '.$accountCatID;
			
			//echo $condition;die;
			$total_volume = 0;
			/*********** IF Request Comes from dashboard with status and pipeline value *************/
			if(isset($pipeline) && $pipeline!=''){
					$userID = $this->Session->read('UserAuth.User.id');
					// Get Merchant list on basis of status and pipeline
					if($pipeline=='today'){
						$currDate = date("Y-m-d");
						$condition .= " AND Merchantpipeline.statusTo = ".$statusID." AND Merchant.statusID = ".$statusID." AND Merchantpipeline.statusToDate = '".$currDate."' ";
					}
					// if pipeline is mtd
					if($pipeline=='mtd'){
						$startdayCurrMonth = date("Y-m-01");
						$tilldayCurrMonth = date("Y-m-d");
						$condition .= " AND Merchantpipeline.statusTo = ".$statusID." AND Merchant.statusID = ".$statusID." AND Merchantpipeline.statusToDate >= '".$startdayCurrMonth."' AND Merchantpipeline.statusToDate <= '".$tilldayCurrMonth."' ";
							
					}
					// if pipeline is lastmonth
					if($pipeline=='lastmonth'){
						$startdaylastMonth = date("Y-m-d", strtotime(date('m', mktime() - 31*3600*24).'/01/'.date('Y').' 00:00:00'));
						$enddaylastMonth = date("Y-m-31", mktime() - 31*3600*24);
						$condition .= " AND Merchantpipeline.statusTo = ".$statusID." AND Merchant.statusID = ".$statusID." AND Merchantpipeline.statusToDate >= '".$startdaylastMonth."' AND Merchantpipeline.statusToDate <= '".$enddaylastMonth."' ";
							
					}
					// if pipeline is ytd
					if($pipeline=='ytd'){
						$startytdCurrMonth = date("Y-01-01");
						//$tillytdCurrMonth = date("Y-m-31", strtotime("-2 month"));
						$tillytdCurrMonth = date("Y-m-d");
						$condition .= " AND Merchantpipeline.statusTo = ".$statusID." AND Merchant.statusID = ".$statusID." AND Merchantpipeline.statusToDate >= '".$startytdCurrMonth."' AND Merchantpipeline.statusToDate <= '".$tillytdCurrMonth."' ";
						
					}
					// if pipeline is lastyear
					if($pipeline=='lastyear'){
						$startlastyearDate = date("Y-01-01",strtotime("-1 year"));
						$tilllastyeatendDate = date("Y-12-31", strtotime("-1 year"));
						$condition .= " AND Merchantpipeline.statusTo = ".$statusID." AND Merchant.statusID = ".$statusID." AND Merchantpipeline.statusToDate >= '".$startlastyearDate."' AND Merchantpipeline.statusToDate <= '".$tilllastyeatendDate."' ";	
						
					}
					// if pipeline is lifetime
					if($pipeline=='lifetime'){
						//$tilllifetimeDate = date("Y-12-31", strtotime("-2 year"));
						$tilllifetimeDate = date("Y-m-d");
						$condition .= " AND Merchant.statusID = ".$statusID." ";
						$joins 	=	array();
					}else{
						// Join with Merchantpipeline
					   $joins = array(
							array(
								'table' => 'merchantpipelines',
								'alias' => 'Merchantpipeline',
								'type' => 'LEFT',
								'conditions' => array(
									'Merchant.id = Merchantpipeline.merchantID'
								)
							)
						);
					}
					//echo $condition;			
					$MerchantVolTotal = $this->Merchant->find('first',array('fields'=>'COUNT(DISTINCT Merchant.id) as totalmerchant,sum(volume) as total_volume','conditions' => array($condition),'joins'=>$joins,'recursive' => -1));
					$volumTotal = $MerchantVolTotal[0]['total_volume'];
					$MerchantRec = $MerchantVolTotal[0]['totalmerchant'];
					
					/* $MerchantTotal = $this->Merchant->find('all',array('fields'=>'DISTINCT Merchant.id,Merchant.volume as volume','conditions' => array($condition),'joins'=>$joins));
					foreach($MerchantTotal as $merchants){
						$total_volume = $total_volume + $merchants['Merchant']['volume'];
					}
					$volumTotal = $total_volume;
					$MerchantRec = count($MerchantTotal);	*/				
					
					/***** Assign Paginate when pipeline present ****/
					$this->Merchant->unbindModel(
                                                        array(
                                                            'hasMany' => array('Commissionlog'),
                                                            'belongsTo' => array('Agent','ISO','Referal'),
                                                            'hasOne' => array('Commission')
                                                            )
                                        ,false);
					$this->paginate = array(
						'fields'	=> array('Merchant.id','merchantName','merchantDBA','merchantURL','volume','CID','statusID','merchantStatus','Processor.user_Name','Manager.user_Name','Status.status','ProcessingMethod.accountCategory'),
						'limit' => 50,
						'order' => array(
							'Merchant.id' => 'desc',
						),						
						'conditions' => array($condition),	
						'recursive' => 0,
						'paramType' => 'querystring',
						'joins' => $joins,
						'group' => 'Merchant.id'
					);
					
			}else{
				
				/************** When request Not Comes from dashboard ************/				
				if(isset($date)) {
					 
					if(isset($statusID)){  
							$condition  .= ' AND Merchantpipeline.statusTo = '.$statusID;
						}
					if($agentID != '' ) { 
						$commonid = $agentID;
						$this->set('agent_iso_referral','Agent');
					}
					if($referalID != '') { 
						$commonid = $referalID;
						$this->set('agent_iso_referral','Referal');
						
					}
					if($isoID != '') { 
						$commonid = $isoID;
						$this->set('agent_iso_referral','ISO');
					}
					if($managerID != '') { 
						$commonid = $managerID;
						$this->set('agent_iso_referral','MANAGER');
					}
						$condition  .= ' AND YEAR( Merchantpipeline.statusToDate ) = '.$argArr['year'];
						
						$condition  .= ' AND MONTH( Merchantpipeline.statusToDate ) = '.$argArr['month'];
						
						
					 $joins = array(
							array(
								'table' => 'merchantpipelines',
								'alias' => 'Merchantpipeline',
								'type' => 'LEFT',
								'conditions' => array(
									'Merchant.id = Merchantpipeline.merchantID'
								)
							),
							array
										(
											'table' => 'users',
											'alias' => 'User',
											'type'  => 'inner',
											'conditions' => array
														(
															'User.Id ='.$commonid
														)
										),
								
						);						
						ini_set('max_execution_time', 600);
						$MerchantVolTotal = $this->Merchant->find('first',array('fields'=>'COUNT(DISTINCT Merchant.id) as totalmerchant,sum(volume) as total_volume','conditions' => array($condition),'joins'=>$joins,'recursive' => -1));
					
					$volumTotal = $MerchantVolTotal[0]['total_volume'];
					$MerchantRec = $MerchantVolTotal[0]['totalmerchant'];
					
					$this->Merchant->unbindModel(
                                                        array(
                                                            'hasMany' => array('Commissionlog'),
                                                            'belongsTo' => array('Agent','ISO','Referal'),
                                                            'hasOne' => array('Commission')
                                                            )
                                        ,false);
										
					$this->paginate = array(
						'fields'	=> array(' DISTINCT Merchant.id','merchantName','merchantDBA','merchantURL','volume','CID','statusID','merchantStatus','Processor.user_Name','User.user_Name','Status.status','ProcessingMethod.accountCategory'),
						'limit' => 50,
						'order' => array(
							'Merchant.id' => 'desc',
						),						
						'conditions' => array($condition),	
						'recursive' => 0,
						'paramType' => 'querystring',
						'joins' => $joins				
					);					
				} else {	
						if(is_array($statusID)){ 
							$condition  .= ' AND Merchant.statusID IN ('.implode(",", $statusID).')';
						}elseif($statusID!='' && $statusID!='all'){
							$condition  .= ' AND Merchant.statusID = '.$statusID;
						}
										
						$MerchantTotal = $this->Merchant->find('first',array('fields'=>'COUNT(DISTINCT Merchant.id) as totalmerchant,sum(volume) as total_volume','conditions' => array($condition),'recursive' => -1));
						$volumTotal = $MerchantTotal[0]['total_volume'];
						$MerchantRec = $MerchantTotal[0]['totalmerchant'];
						
						$this->Merchant->unbindModel(
														array(
															'hasMany' => array('Commissionlog'),
															'belongsTo' => array('Agent','ISO'),
															'hasOne' => array('Commission')
															)
										,false);
						$this->paginate = array(
							'fields'	=> array('Merchant.id','merchantName','merchantDBA','merchantURL','volume','CID','statusID','merchantStatus','Processor.user_Name','Manager.user_Name','Status.status','ProcessingMethod.accountCategory'),
							'limit' => 50,
							'order' => array(
								'Merchant.id' => 'desc',
							),
							'conditions' => array($condition),
							'recursive' => 0,				
							'paramType' => 'querystring'
						);	
						$this->set('manager','manager');
				}
			}
				
				$MerchantRecData = $this->paginate();
                                //pr($MerchantRecData);die;
				$this->set('statusID',$statusID);
				$this->set('agentID',$agentID);
				$this->set('accountTypeID',$accountTypeID);
				$this->set('processorID',$processorID);
				$this->set('managerID',$managerID);
				$this->set('isoID',$isoID);
				$this->set('gatewayID',$gatewayID);
				$this->set('referalID',$referalID);
				$this->set('accountCatID',$accountCatID);
				
				$this->set('totalUser',$MerchantRec);
				$this->set('totalVolume',$volumTotal);
				$this->set('MerchantRec',$MerchantRecData);
				$this->set('argArr', $argArr);
				$this->set('loginRole',$loginRole);
				// link back to search button
				$search_url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["REQUEST_URI"];
				$this->Session->write('backToSearch',$search_url);
				
				if(isset($this->request->query['Submit']) && $this->request->query['Submit']=='Export'){
					
						//$MerchantRec =$this->Merchant->find('all',array('conditions' => array($condition),'order'=>array('Merchant.id' => 'DESC')));
						$field_array = array("distinct(Merchant.id)","Merchant.merchantName","Merchant.merchantDBA","Merchant.merchantURL","Merchant.volume","Merchant.CID","Merchant.contactName","Merchant.contactEmail","Merchant.contactPhone","Merchant.legalCountry","Merchant.sicMCC","Merchant.merchantType","Merchant.preappDate","Merchant.startDate","Merchant.form_id","Status.status","Processor.user_Name","Manager.user_Name","Manager.user_Name","MerchantCategory.accountType","Referal.user_Name");
						$MerchantRec =$this->Merchant->find('all',array('fields'=>$field_array,'conditions' => array($condition),'order'=>array('Merchant.id' => 'DESC')));
						
						ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
						//create a file
						$filename = "Merchant_export_".date("Y.m.d").".csv";
						$csv_file = fopen('php://output', 'w');
						
						header('Content-type: application/csv');
						header('Content-Disposition: attachment; filename="'.$filename.'"');
			
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
						fclose($csv_file);die;
						
				}

		
	}

	public function superadmin_edit($merchantID = null) {
			$errorsArr ='';	
			
			$this->set('id',$merchantID);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.navigationOrder ASC")));
			$this->set('status',$Status_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
						
			$this->loadModel('Merchantnote');
			if(strtolower($this->Session->read('UserAuth.UserGroup.name'))=='admin'){
				$merchnatNotes =  $this->Merchantnote->find("all", array("order" => array("Merchantnote.merchantNoteID DESC"), "conditions" => array("Merchantnote.merchantID" => $merchantID)));
			}else{
				$noteview = strtolower($this->Session->read('UserAuth.UserGroup.name')).'View'; 
				if(strtolower($this->Session->read('UserAuth.UserGroup.name'))=="referral"){
					$noteview = "referalView";
				}
				$merchnatNotes =  $this->Merchantnote->find("all", array("order" => array("Merchantnote.merchantNoteID DESC"), "conditions" => array("Merchantnote.merchantID" => $merchantID,$noteview=>1)));
			}
                        
			$this->set('merchnatNotes',$merchnatNotes);	
			
                        
                        
                            
			// Request With GET Parameter
			if ($this->request->is('get')) {
                $loginRole = $this->Session->read('UserAuth.UserGroup.name');
				$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
                if((strtolower($loginRole)=='referal' || strtolower($loginRole)=='referral') && $this->request->data['Merchant']['referalID'] != $this->Session->read('UserAuth.User.id')){
                    $this->redirect('/superadmin/dashboard');
                }
				if($this->request->data===FALSE){
					$this->Session->write('popup','Merchant not exist.');			
					$this->Session->setFlash('Merchant not exist.');
					$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
				}
				$stausID = $this->request->data['Merchant']['statusID'];
				$this->set('stausID',$stausID);							
				
			} else {	
			
			
											
				if($this->request->data['Submit']=='Add Note'){			
						$this->Merchantnote->set($this->request->data);
						$merchantID = $this->request->data['Merchantnote']['merchantID'];
						//$timestamp = date("n/j/Y g:i:s A");
						$date = new DateTime("@".time());
						//$date->setTimezone(new DateTimeZone('CDT'));  
						$date->setTimezone(new DateTimeZone('PST'));
						$timestamp = $date->format('n/j/Y g:i:s A');  // Pacific time
						$this->request->data['Merchantnote']['timeStamp'] = $timestamp;
						if(!$this->Merchantnote->validates()) 
						{
							$errorsArr = $this->Merchantnote->validationErrors;	
						}
						if($errorsArr) 
						{
							$this->set('errors',$errorsArr);
							$this->set('data',$this->request->data);
							$this->redirect(array('controller'=>'merchants','action' => "merchantnotes/".$merchantID));
						}
						else {	
						
								$email = new CakeEmail("smtp");
								$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
								$subject = "Note has been successfully added to your Merchant";
								$bodyText = "The Note is as following : <br>".$this->request->data['Merchantnote']['note'];
								$email->emailFormat('html');
								$email->subject(strip_tags($subject));
							if($this->Merchantnote->save($this->request->data)) {
								//send to agent
								/*$sendtoagent = trim($this->request->data['Merchantnote']['agentEmail']);
								if($this->request->data['Merchantnote']['agentView']=='1' && $sendtoagent!=''){
									$email->to($sendtoagent);
									$email->send($bodyText);
								}
								//send to processor
								$sendtopro = trim($this->request->data['Merchantnote']['proEmail']);
								if($this->request->data['Merchantnote']['processorView']=='1' && $sendtopro!=''){
									$email->to($sendtopro);
									$email->send($bodyText);
								}
								//send to manager
								$sendtoman = trim($this->request->data['Merchantnote']['managerEmail']);
								if($this->request->data['Merchantnote']['managerView']=='1' && $sendtoman!=''){
									$email->to($sendtoman);
									$email->send($bodyText);
								}
								//send to ISO
								$sendtoiso = trim($this->request->data['Merchantnote']['isoEmail']);
								if($this->request->data['Merchantnote']['isoView']=='1' && $sendtoiso!=''){
									$email->to($sendtoiso);
									$email->send($bodyText);
								}*/

								/*$this->Session->write('popup','Merchant Notes has been added successfully.');			
								$this->Session->setFlash('Merchant Notes has been added successfully.'); */ 
								$this->redirect(array('controller'=>'merchants','action' => "edit/".$merchantID."/message:success"));
							}	
							else {
								$this->Session->setFlash('Data save problem, Please try again.');  
							}	
						}//end if not error
					}
				elseif($this->request->data['Submit']=='Duplicate'){
					$this->redirect(array('controller'=>'merchants','action' => "duplicate",$merchantID));
				}
				elseif($this->request->data['Submit']=='Dead Deal'){
					$merchantID  = $this->request->data['Merchant']['id'];					
					$merchanInfo = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
					
					$merchantName = $this->request->data['Merchant']['merchantName'];
					$managerID = $this->Session->read('UserAuth.User.id');
					if($managerID!=''){
						$managerName = $this->Session->read('UserAuth.User.user_Name');
						$managerEmail = $this->Session->read('UserAuth.User.userEmail');
						$managerPhone = $this->Session->read('UserAuth.User.userPhone');
						$managerCompany = $this->Session->read('UserAuth.User.userCompany');
						$managerCompanyURl = $this->Session->read('UserAuth.User.userCompanyUrl');
					}else{
						$managerName = "";
						$managerEmail = CANDIDATE_EMAIL_ID_LOGIN;
						$managerPhone = "";
						$managerCompany = "";
						$managerCompanyURl = "";
					}
					
					$sendto = $this->request->data['Merchant']['contactEmail'];
					$subject = "Account Closed";
					$bodyText = "Dear ".$merchantName.",<br/><br/>Thank you for choosing Total Apps, Inc. for your Merchant Account and Gateway needs. We are confident that you will be very satisfied with the services that we offer.<br/><br/>At this time, your application has been closed due to the limited amount of information we have received from you.  We hope that you are simply busy developing your business or just waiting for the right time to get started.  If you believe the application has been closed in error, or wish to re-open your application, please contact us immediately so we may proceed with the application process.  We wish you all the best in your endeavors!<br/><br/>Sincerely,<br/><br/>".$managerName."<br/>Account Manager<br/>".$managerCompany."<br/>".$managerCompanyURl."<br/>".$managerPhone."<br/><br/>The information transmitted is intended only for the person or entity to which it is addressed and may contain confidential and/or privileged material. Any review, retransmission, dissemination or other use of, or taking of any action in reliance upon, this information by persons or entities other than the intended recipient is prohibited.";
					$email = new CakeEmail("smtp");
					
					$email->from(array($managerEmail));
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					
					$oldStatus = $this->request->data['Merchant']['statusID'];
					// sent merchant to dead list (statusID = 7 for dead )						
					$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>7));
					//pr($data);die;
					if($this->Merchant->save( $data, false, array('statusID'))){
						// Add status update in merchant pipeline
						$this->loadModel('Merchantpipeline');
						$pipelineData = array();
						$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
						$pipelineData['Merchantpipeline']['statusFrom'] = $oldStatus;
						$pipelineData['Merchantpipeline']['statusTo'] = 7;
						$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
						$this->Merchantpipeline->save($pipelineData);
						
						//add merchant notes when change in status
						$this->loadModel('Merchantnote');
						$noteData = array();
						$changedBy = $this->Session->read('UserAuth.User.user_Name');
						$noteData['Merchantnote']['merchantID'] = $merchantID;
						$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
						$timestamp = CURRENTDATE;
						$noteData['Merchantnote']['timeStamp'] = $timestamp;
						$noteData['Merchantnote']['note'] = "Status has been changed to DEAD by ".$changedBy." on Date ".$timestamp;
						$this->Merchantnote->save($noteData);
						
						if(Validation::email($sendto)){
							$email->to($sendto);
							$email->send($bodyText);
							$this->Session->write('popup','Email has been sended successfully to Merchant.');			
							$this->Session->setFlash('Email has been sended successfully to Merchant.');
						}						
						
					}
					
					$this->redirect(array('controller'=>'merchants','action' => "edit/".$merchantID."/message:success"));
					
				}
				else{
					foreach ($this->request->data['Merchant'] as $key => $value){
						$this->request->data['Merchant'][$key] = trim($value);
					}
					if(isset($this->request->data['Merchant']['contract_expiration']) && trim($this->request->data['Merchant']['contract_expiration'])!=''){
						$this->request->data['Merchant']['contract_expiration'] = date("Y-m-d",strtotime($this->request->data['Merchant']['contract_expiration']));
					}
					if(isset($this->request->data['Merchant']['contract_approval']) && trim($this->request->data['Merchant']['contract_approval'])!=''){
						$this->request->data['Merchant']['contract_approval'] = date("Y-m-d",strtotime($this->request->data['Merchant']['contract_approval']));
					}	
					/* echo "<pre>";
					print_r($this->request->data['Merchant']);die; */						
					$this->Merchant->set($this->request->data);
					$stausID = $this->request->data['Merchant']['statusID'];
					$stausID = ($stausID=="")? 0 :$stausID;
					$oldProcessor = $this->request->data['Merchant']['oldProcessor'];
					$oldStatus = $this->request->data['Merchant']['oldStatus'];
					$oldStatus = ($oldStatus=="")? 0 :$oldStatus;
					$newProcessor = $this->request->data['Merchant']['processorID'];
					if(is_array($this->request->data['Merchant']['merchantType']))
						$this->request->data['Merchant']['merchantType'] = implode(",",$this->request->data['Merchant']['merchantType']);
	
					if(!$this->Merchant->validates()) 
					{
						$errorsArr = $this->Merchant->validationErrors;	
					}
					if($errorsArr) 
					{
						// task id 3481
						$this->Merchant->recursive = 0;
						$merchanOtherInfo = $this->Merchant->find('first',array('fields'=>'Agent.user_Name,Processor.user_Name,Manager.user_Name,ISO.user_Name,Referal.user_Name','conditions'=>array('Merchant.id'=>$merchantID)));
						$this->request->data['Processor']['user_Name'] 	= $merchanOtherInfo['Processor']['user_Name'];
						$this->request->data['Manager']['user_Name'] 	= $merchanOtherInfo['Manager']['user_Name'];
						$this->request->data['ISO']['user_Name'] 		= $merchanOtherInfo['ISO']['user_Name'];
						$this->request->data['Agent']['user_Name'] 		= $merchanOtherInfo['Agent']['user_Name'];
						$this->request->data['Referal']['user_Name'] 	= $merchanOtherInfo['Referal']['user_Name'];
						$this->set('errors',$errorsArr);
						$this->set('data',$this->request->data);
						$this->set('stausID',$stausID);	
						$processorID = $this->request->data['Merchant']['processorID'];
						if(isset($processorID) && $processorID!=''){
							$processorDoc = $this->Common->getProcessorDoc($processorID);
							$this->set('countDoc',count($processorDoc));
							$this->set('processorDoc',$processorDoc);
						}
					}
					else {
						if($this->Merchant->save($this->request->data)) {
							//delete document of old processor
							if($oldProcessor!=$newProcessor){
								//Delete its documents
								$this->loadModel('Merchantprocessordoclink');
								$merchantDoc = $this->Merchantprocessordoclink->find('all',array('conditions'=>array('Merchantprocessordoclink.merchantID'=>$merchantID)));
								foreach($merchantDoc as $key =>$merchantDocs){
									$deletefile = WWW_ROOT."files/MerchantDocument/".$merchantDocs['Merchantprocessordoclink']['docName'];
									@unlink($deletefile);
								}	
								$this->Merchantprocessordoclink->deleteAll(array('Merchantprocessordoclink.merchantID' =>$merchantID));
							}
							// Add Note to merchant when information changed
							$this->loadModel('Merchantnote');
							$noteData = array();
							$changedBy = $this->Session->read('UserAuth.User.user_Name');
							$noteData['Merchantnote']['merchantID'] = $merchantID;
							$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
							$timestamp = CURRENTDATE;
							$noteData['Merchantnote']['timeStamp'] = $timestamp;
							$noteData['Merchantnote']['note'] ="";
							$noteData['Merchantnote']['note']  .= "Merchant Information has been changed by ".$changedBy." on Date ".$timestamp.". ";
							
							if($oldStatus!=$stausID){
								//var_dump($oldStatus);die;
								$statusTo = (strlen($stausID)>0 && $stausID!=0)? $this->Common->getStatusName($stausID) : "NULL";
								$statusFrom = (strlen($oldStatus)>0 && $oldStatus!="")? $this->Common->getStatusName($oldStatus) : "NULL";
								$noteData['Merchantnote']['note']  .= "Merchant Status has been changed from ".$statusFrom." To ".$statusTo;
								// Add status update in merchant pipeline
								$this->loadModel('Merchantpipeline');
								$pipelineData = array();
								$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
								$pipelineData['Merchantpipeline']['statusFrom'] = $oldStatus;
								$pipelineData['Merchantpipeline']['statusTo'] = $stausID;
								$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
								$this->Merchantpipeline->save($pipelineData);
							}
							
							$this->Merchantnote->save($noteData);
							
							$this->Session->write('popup','Merchant information has been updated successfully.');			
							$this->Session->setFlash('Merchant information has been updated successfully.');  
							$this->redirect(array('controller'=>'merchants','action' => "edit/".$merchantID."/message:success"));
						}	
						else {
							$this->Session->setFlash('Data save problem, Please try again.');  
						}	
					}//end if not error
					}
		}
	}
	 
	public function superadmin_duplicate($merchantID = null) {
			$errorsArr ='';	
			$this->set('id',$merchantID);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.id ASC")));
			$this->set('status',$Status_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);	
			
			$this->loadModel('Merchantprocessordoclink');
			$this->loadModel('Rate');
			$this->loadModel('Merchanttransaction');
			$this->loadModel('Deployment');
			$this->loadModel('Terminalsoftgateway');
			$this->loadModel('Printer');
			$this->loadModel('Checkreader');
			$this->loadModel('Owner');
			$this->loadModel('Merchantpipeline');
						
			if ($this->request->is('get')) {
				$this->request->data= $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
				$this->request->data['Merchant']['statusID'] = 1;
				$stausID = $this->request->data['Merchant']['statusID'];
				$this->set('stausID',$stausID);
				$this->request->data['Merchant']['id'] = '';
				// get all document which you want duplicate
				$DocumentData = $this->Merchantprocessordoclink->find('all',array('conditions'=>array('Merchantprocessordoclink.merchantID'=>$merchantID)));
				//pr($DocumentData);
				$this->set('DocumentData',$DocumentData);
			}else{
					$documentArr = array();
					if(is_array($this->request->data['Merchant']['merchantType']))
						$this->request->data['Merchant']['merchantType']=implode(',',$this->request->data['Merchant']['merchantType']);
					if($this->Merchant->save($this->request->data)) {
							$newMerchantID = $this->Merchant->getLastInsertId();
							// duplicate document	
							if(isset($this->request->data['Merchantprocessordoclink'])){				
								$documentArr = $this->request->data['Merchantprocessordoclink']['docID'];
								foreach($documentArr as $key => $docID){
									$this->Merchantprocessordoclink->create(); 
									$docData = $this->Merchantprocessordoclink->find('first',array('fields'=>array('merchantID','docID','docName'),'conditions'=>array('Merchantprocessordoclink.merchantID'=>$merchantID,'Merchantprocessordoclink.docID'=>$docID)));
									// copy the documents
									$originalDoc = WWW_ROOT.'files/MerchantDocument/'.$docData['Merchantprocessordoclink']['docName'];
									$newfile = WWW_ROOT.'files/MerchantDocument/'.date("s")."-".$docData['Merchantprocessordoclink']['docName'];
									copy($originalDoc, $newfile);
									$docData['Merchantprocessordoclink']['docName'] = date("s")."-".$docData['Merchantprocessordoclink']['docName'];
									$docData['Merchantprocessordoclink']['merchantID'] = $newMerchantID;
									$this->Merchantprocessordoclink->save($docData);
								}
							}
							//add to pipeline
							$pipelineData = array();
							$pipelineData['Merchantpipeline']['merchantID'] = $newMerchantID;
							$pipelineData['Merchantpipeline']['statusFrom'] = 0;
							$pipelineData['Merchantpipeline']['statusTo'] = 1;
							$pipelineData['Merchantpipeline']['statusToDate'] = date('Y-m-d');
							$this->Merchantpipeline->save($pipelineData);
							// duplicate rate	
							$rateData = $this->Rate->find('first',array('conditions'=>array('Rate.merchantID'=>$merchantID)));
							$rateData['Rate']['id'] = '';
							$rateData['Rate']['merchantID'] = $newMerchantID;
							$rateData['Rate']['lastUpdatedBy'] = '';
							$rateData['Rate']['lastUpdatedDate'] = date("Y-m-d H:i:s");
							$rateData['Rate']['adminName'] = 'NULL';
							$this->Rate->save($rateData);
							// duplicate transaction	
							$transactionData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.merchantID'=>$merchantID)));
							$transactionData['Merchanttransaction']['id'] = '';
							$transactionData['Merchanttransaction']['merchantID'] = $newMerchantID;
							$transactionData['Merchanttransaction']['lastUpdatedBy'] = '';
							$transactionData['Merchanttransaction']['lastUpdatedDate'] = date("Y-m-d H:i:s");
							$transactionData['Merchanttransaction']['adminName'] = 'NULL';
							$this->Merchanttransaction->save($transactionData);
							// duplicate deployment	
							$deploymentData = $this->Deployment->find('first',array('conditions'=>array('Deployment.merchantID'=>$merchantID)));
							$deploymentData['Deployment']['id'] = '';
							$deploymentData['Deployment']['merchantID'] = $newMerchantID;
							$deploymentData['Deployment']['lastUpdatedBy'] = $this->Session->read('UserAuth.User.id');
							$deploymentData['Deployment']['lastUpdatedDate'] = date("Y-m-d H:i:s");
							$deploymentData['Deployment']['adminName'] = 'NULL';
							$this->Deployment->save($deploymentData);
							// duplicate terminalsoftgateway of deployment	
							$termSoftGateData = $this->Terminalsoftgateway->find('all',array('conditions'=>array('Terminalsoftgateway.merchantID'=>$merchantID)));
							foreach($termSoftGateData as $key => $softGateData){
								$this->Terminalsoftgateway->create();
								$softGateData['Terminalsoftgateway']['id'] = ''; 								
								$softGateData['Terminalsoftgateway']['merchantID'] = $newMerchantID;
								$this->Terminalsoftgateway->save($softGateData);
							}
							// duplicate printer of deployment	
							$printerData = $this->Printer->find('all',array('conditions'=>array('Printer.merchantID'=>$merchantID)));
							foreach($printerData as $key => $printer){
								$this->Printer->create(); 		
								$printer['Printer']['id'] = '';						
								$printer['Printer']['merchantID'] = $newMerchantID;
								$this->Printer->save($printer);
							}
							// duplicate check reader of deployment	
							$chkReaderData = $this->Checkreader->find('all',array('conditions'=>array('Checkreader.merchantID'=>$merchantID)));
							foreach($chkReaderData as $key => $chkReader){
								$this->Checkreader->create(); 						
								$chkReader['Checkreader']['id'] = '';		
								$chkReader['Checkreader']['merchantID'] = $newMerchantID;
								$this->Checkreader->save($chkReader);
							}
							// duplicate Owner
							/*$ownerData = $this->Owner->find('all',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
							foreach($ownerData as $key => $owner){
								$this->Owner->create(); 						
								$owner['Owner']['id'] = '';		
								$owner['Owner']['merchantID'] = $newMerchantID;
								$this->Owner->save($owner);
							}*/
							$this->Session->write('popup','Duplicate Merchant information has been saved successfully.');			
							$this->Session->setFlash('Duplicate Merchant information has been saved successfully.');  
							$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:success"));
						}	
						else {
							$this->Session->setFlash('Data save problem, Please try again.');  
						}	
			}
		}
	   	 
	public function superadmin_merchantrates($merchantID	 = null) {
			$errorsArr ='';	
			
			$this->set('id',$merchantID);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
			$this->set('status',$Status_list);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			// ===== Find Referal Type User List ===============
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
			// ============= end ==========
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			$this->loadModel('Rate');
			
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			if($MerchantData===FALSE){
					$this->Session->write('popup','Merchant not exist.');			
					$this->Session->setFlash('Merchant not exist.');
					$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
			}

			if ($this->request->is('get')) {
				$RatesadminData = $this->Rate->find('list',array('fields'=>'adminName','conditions'=>array('Rate.userType'=>'admin')));
				$this->set('adminName',$RatesadminData);
				if(isset($this->request->query['adminrate'])){
					$RatesData = $this->Rate->find('first',array('conditions'=>array('Rate.id'=>$this->request->query['adminName'])));
					$this->request->data = array_merge($MerchantData, $RatesData);
					$this->request->data['Rate']['adminName'] = $this->request->query['adminName'];
					$this->set('ID','');
				}else{ 
					$RatesData = $this->Rate->find('first',array('conditions'=>array('Rate.merchantID'=>$merchantID)));
					if($RatesData){				
						$this->request->data = array_merge($MerchantData, $RatesData);
						$this->set('ID',$this->request->data['Rate']['id']);
					}else{
						$this->request->data = $MerchantData;
						$this->set('ID','');
					}	
				}		
				$stausID = $this->request->data['Merchant']['statusID'];
				$this->set('stausID',$stausID);			
			}else {
				//pr($this->request->data);die;
				
				
			     // compare nots fields and make text
				$ratesRec=$this->Rate->find('first',array('conditions'=>array('Rate.merchantID'=>$this->request->data['Rate']['merchantID'])));
				
				
				if(is_array($ratesRec)){
				$result = array_diff($this->request->data['Rate'],$ratesRec['Rate']);
				}else{
					$result = array_filter(array_map('trim',$this->request->data['Rate']));
				}
			
				$change=null;
				foreach($result as $key=>$value){
				if(!empty($ratesRec['Rate'][$key])){	
					switch($key){
						case 'chargebackFee':
							$change.='CHARGEBACK FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'electronicAvsFee':
							$change.='CHARGEBACK FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'retrievalReqFee':
							$change.='RETRIEVAL FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'wirelessDataMonthlyFee':
							$change.='WIRELESS MONTHLY FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'returnItemFee':
							$change.='RETURN ITEM FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'avsVoiceAuthFee':
							$change.='AVS VOICE AUTHORIZATION has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'vru_aru_fee':
							$change.='VRU & ARU FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
							
						case 'monthlyMinFee':
							$change.='MONTHLY MINIMUM FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'monthly_maintenance_fee':
							$change.='MONTHLY MAINTENANCE FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'eids_chargeback_retrieval_online_tool_fee':
							$change.='EIDS CHARGEBACK/ RETRIEVAL ONLINE TOOL has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'pci_compliance_fee_type':
							$change.='PCI COMPLIANCE FEE TYPE has been changed from '.$ratesRec['Rate'][$key].' to '.$this->request->data['Rate'][$key].'<br>';
							break;
						
						case 'otherFeeName1':
							$change.='OTHER FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'otherFeeName2':
							$change.='OTHER FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'achBatchFee':
							$change.='ACH/BATCH STATEMENT has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'statementFee':
							$change.='SERVICE/STATEMENT FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'merchantClubFee':
							$change.='MERCHANT CLUB FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'wirelessTransFee':
							$change.='WIRELESS TRANS. FEE  has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'applicationFee':
							$change.='APPLICATION FEE  has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'voiceAuthFee':
							$change.='VOICE AUTHORIZATION FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'regulatory_bundle_fee':
							$change.='REGULATORY BUNDLE FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'early_termination_fee':
							$change.='EARLY TERMINATION(one time fee) has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'online_reporting_fee':
							$change.='ONLINE REPORTING FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'pci_compliance_fee':
							$change.='PCI COMPLIANCE FEE has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						// 
						
						case 'visaDiscount':
							$change.='Visa Discount % has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'visaTransFee':
							$change.='Visa Trans Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
													
						case 'masterDiscount':
							$change.='MASTER CARD   Discount %  has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
					
						case 'masterTransFee':
							$change.='MASTER CARD  Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'discoverDiscount':
							$change.='DISCOVER  Discount %  has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
					
						case 'discoverTransFee':
							$change.='DISCOVER Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'checkDiscount':
							$change.='CHECK CARD Discount %  has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
					
						case 'checkTransFee':
							$change.='DISCOVER Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'amexTransFee':
							$change.='AMEX Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'jcbTransFee':
							$change.='JCB Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'midQualDiscount':
							$change.='MID-QUAL % has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'nonQualDiscount':
							$change.='NON-QUAL % has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						//INTERCHANGE PASS THROUGH	
						case 'interchangePlus':
							$change.='INTERCHANGE PLUS % has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'interchangePerItem':
							$change.='
PER ITEM % has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
						// ERR RATE
						case 'visa_qualify_dis_rate':
							$change.='VISA QUALIFIED Discount Rate(%)  has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'visa_non_qualify_fee':
							$change.='VISA Non-Qualified Discount Rate(%) has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
						
						case 'visa_authorization_fee':
							$change.='VISA QUALIFIED  Authorization Fee(%) has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						
							
						case 'mc_qualify_dis_rate':
							$change.='MC QUALIFIED Discount Rate(%)  has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'mc_non_qualify_fee':
							$change.='MC QUALIFIED  Discount Rate(%) has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
						
						case 'mc_authorization_fee':
							$change.='MC QUALIFIED Authorization Fee(%) has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
							
							
						case 'discover_qualify_dis_rate':
							$change.='DISCOVER QUALIFIED Discount Rate(%)  has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'discover_non_qualify_fee':
							$change.='DISCOVER QUALIFIED  Discount Rate(%) has been changed from '.$ratesRec['Rate'][$key].'% to '.$this->request->data['Rate'][$key].'%<br>';
							break;
						
						case 'discover_authorization_fee':
							$change.='DISCOVER QUALIFIED Authorization Fee(%) has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						//GATEWAY FEES
						case 'gatewayTransFee':
							$change.='GATEWAY TRANS FEE Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'gatewayMonthlyFee':
							$change.='GATEWAY MONTHLY Fee(%) has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'gatewaySetupFee':
							$change.='SETUP Fee(%) has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						//EBT
						case 'ebtCashBackMaxFee':
							$change.='EBT CASH BACK Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'ebtTransFee':
							$change.='EBT TRANS. FEE Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						// DEBIT
						case 'debitMonthlyAccessFee':
							$change.='DEBIT MONTHLY ACCESS FEE Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'debitAuthorizationFee':
							$change.='DEBIT AUTHORIZATION Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'debitCashBack':
							$change.='DEBIT CASH BACK Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'debitAccessFee':
							$change.='DEBIT ACCESS FEE Fee has been changed from '.$ratesRec['Rate'][$key].'$ to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						default :
							break;
					}
				}else{
					switch($key){
						case 'chargebackFee':
							$change.='CHARGEBACK FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'electronicAvsFee':
							$change.='CHARGEBACK FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'retrievalReqFee':
							$change.='RETRIEVAL FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'wirelessDataMonthlyFee':
							$change.='WIRELESS MONTHLY FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'returnItemFee':
							$change.='RETURN ITEM FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'avsVoiceAuthFee':
							$change.='AVS VOICE AUTHORIZATION has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'vru_aru_fee':
							$change.='VRU & ARU FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
							
						case 'monthlyMinFee':
							$change.='MONTHLY MINIMUM FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'monthly_maintenance_fee':
							$change.='MONTHLY MAINTENANCE FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'eids_chargeback_retrieval_online_tool_fee':
							$change.='EIDS CHARGEBACK/ RETRIEVAL ONLINE TOOL has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'pci_compliance_fee_type':
							$change.='PCI COMPLIANCE FEE TYPE has set to '.$this->request->data['Rate'][$key].'<br>';
							break;
						
						case 'otherFeeName1':
							$change.='OTHER FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'otherFeeName2':
							$change.='OTHER FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'achBatchFee':
							$change.='ACH/BATCH STATEMENT has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'statementFee':
							$change.='SERVICE/STATEMENT FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'merchantClubFee':
							$change.='MERCHANT CLUB FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'wirelessTransFee':
							$change.='WIRELESS TRANS. FEE  has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'applicationFee':
							$change.='APPLICATION FEE  has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'voiceAuthFee':
							$change.='VOICE AUTHORIZATION FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'regulatory_bundle_fee':
							$change.='REGULATORY BUNDLE FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'early_termination_fee':
							$change.='EARLY TERMINATION(one time fee) has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'online_reporting_fee':
							$change.='ONLINE REPORTING FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'pci_compliance_fee':
							$change.='PCI COMPLIANCE FEE has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						// 
						
						case 'visaDiscount':
							$change.='Visa Discount % has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'visaTransFee':
							$change.='Visa Trans Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
													
						case 'masterDiscount':
							$change.='MASTER CARD   Discount %  has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
					
						case 'masterTransFee':
							$change.='MASTER CARD  Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'discoverDiscount':
							$change.='DISCOVER  Discount %  has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
					
						case 'discoverTransFee':
							$change.='DISCOVER Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'checkDiscount':
							$change.='CHECK CARD Discount %  has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
					
						case 'checkTransFee':
							$change.='DISCOVER Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'amexTransFee':
							$change.='AMEX Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'jcbTransFee':
							$change.='JCB Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'midQualDiscount':
							$change.='MID-QUAL % has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'nonQualDiscount':
							$change.='NON-QUAL % has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						//INTERCHANGE PASS THROUGH	
						case 'interchangePlus':
							$change.='INTERCHANGE PLUS % has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'interchangePerItem':
							$change.='
PER ITEM % has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						// ERR RATE
						case 'visa_qualify_dis_rate':
							$change.='VISA QUALIFIED Discount Rate(%)  has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'visa_non_qualify_fee':
							$change.='VISA Non-Qualified Discount Rate(%) has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
						
						case 'visa_authorization_fee':
							$change.='VISA QUALIFIED  Authorization Fee(%) has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						
							
						case 'mc_qualify_dis_rate':
							$change.='MC QUALIFIED Discount Rate(%)  has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'mc_non_qualify_fee':
							$change.='MC QUALIFIED  Discount Rate(%) has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
						
						case 'mc_authorization_fee':
							$change.='MC QUALIFIED Authorization Fee(%) has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
							
							
						case 'discover_qualify_dis_rate':
							$change.='DISCOVER QUALIFIED Discount Rate(%)  has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
							
						case 'discover_non_qualify_fee':
							$change.='DISCOVER QUALIFIED  Discount Rate(%) has set to '.$this->request->data['Rate'][$key].'%<br>';
							break;
						
						case 'discover_authorization_fee':
							$change.='DISCOVER QUALIFIED Authorization Fee(%) has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						//GATEWAY FEES
						case 'gatewayTransFee':
							$change.='GATEWAY TRANS FEE Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'gatewayMonthlyFee':
							$change.='GATEWAY MONTHLY Fee(%) has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'gatewaySetupFee':
							$change.='SETUP Fee(%) has set to '.$this->request->data['Rate'][$key].'<br>$';
							break;
							
						//EBT
						case 'ebtCashBackMaxFee':
							$change.='EBT CASH BACK Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'ebtTransFee':
							$change.='EBT TRANS. FEE Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						// DEBIT
						case 'debitMonthlyAccessFee':
							$change.='DEBIT MONTHLY ACCESS FEE Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						case 'debitAuthorizationFee':
							$change.='DEBIT AUTHORIZATION Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'debitCashBack':
							$change.='DEBIT CASH BACK Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
							
						case 'debitAccessFee':
							$change.='DEBIT ACCESS FEE Fee has set to '.$this->request->data['Rate'][$key].'$<br>';
							break;
						
						default :
							break;
					}
				}
					
				}
				
				
				$updateBy = $this->Session->read('UserAuth.User.id');
				$updatedate = date("Y-m-d H:i:s");
				$this->Rate->set($this->request->data);
				$stausID = $this->request->data['Rate']['statusID'];
				$this->request->data['Rate']['lastUpdatedBy'] = $updateBy;
				$this->request->data['Rate']['lastUpdatedDate'] = $updatedate;
				$this->Rate->deleteAll(array('Rate.merchantID' => $merchantID), false);
				if($this->Rate->save($this->request->data)) {
				
				// $this->request->data['Rate']['merchantID']
				
				if(isset($change)){
					//add merchant notes when change in rate
					$this->loadModel('Merchantnote');
					$noteData = array();
					$changedBy = $this->Session->read('UserAuth.User.user_Name');
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = $updateBy;
					$noteData['Merchantnote']['delete'] ='N';
					
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = "Changes are done in Merchant Rates by ".$changedBy." on Date ".$timestamp.'.<br>Changes are as follows<br>'.$change;
					$this->Merchantnote->save($noteData);
				}
				
					
					$this->Session->write('popup','Merchant Rates has been updated successfully.');			
					$this->Session->setFlash('Merchant Rates has been updated successfully.');  
					$this->redirect(array('controller'=>'merchants','action' => "merchantrates/".$merchantID."/message:success"));
				}	
				else {
					$this->Session->write('popup','Data save problem, Please try again.');			
					$this->Session->setFlash('Data save problem, Please try again.');  
					$this->redirect(array('controller'=>'merchants','action' => "merchantrates/".$merchantID."/message:error"));
				}	
				
		}
		
	 }	 
	 
	public function superadmin_merchanttrans($merchantID	 = null) {
			$errorsArr ='';	
			
			$this->set('id',$merchantID);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
			$this->set('status',$Status_list);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			// ===== Find Referal Type User List ===============
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
			// ============= end ==========
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			$this->loadModel('Merchanttransaction');
			
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			if($MerchantData===FALSE){
					$this->Session->write('popup','Merchant not exist.');			
					$this->Session->setFlash('Merchant not exist.');
					$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
			}
			
			if ($this->request->is('get')) {
			
				$TransactionadminData = $this->Merchanttransaction->find('list',array('fields'=>'adminName','conditions'=>array('Merchanttransaction.userType'=>'admin')));
				$this->set('adminName',$TransactionadminData);
				if(isset($this->request->query['admintrans'])){
					$TransData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.id'=>$this->request->query['adminName'])));
					$this->request->data = array_merge($MerchantData, $TransData);
					$this->request->data['Merchanttransaction']['adminName'] = $this->request->query['adminName'];
					$this->set('ID','');
				}else{ 
					$TransData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.merchantID'=>$merchantID)));
					if($TransData){				
						$this->request->data = array_merge($MerchantData, $TransData);
						$this->set('ID',$this->request->data['Merchanttransaction']['id']);
					}else{
						$this->request->data = $MerchantData;
						$this->set('ID','');
					}	
				}
				
				$stausID = $this->request->data['Merchant']['statusID'];
				$this->set('stausID',$stausID);
			} else {
				$this->Merchanttransaction->set($this->request->data);
				if(!$this->Merchanttransaction->validates()) 
				{
					$errorsArr = $this->Merchanttransaction->validationErrors;	
				}
				if($errorsArr) 
				{
					$this->set('errors',$errorsArr);
					$this->request->data = array_merge($MerchantData, $this->request->data);
					$this->set('data',$this->request->data);
				}else{
					$updateBy = $this->Session->read('UserAuth.User.id');
					$updatedate = date("Y-m-d H:i:s");
					$this->Merchanttransaction->set($this->request->data);
					$stausID = $this->request->data['Merchanttransaction']['statusID'];
					$this->request->data['Merchanttransaction']['lastUpdatedBy'] = $updateBy;
					$this->request->data['Merchanttransaction']['lastUpdatedDate'] = $updatedate;
					
					$this->Merchanttransaction->deleteAll(array('Merchanttransaction.merchantID' => $merchantID), false);
					if($this->Merchanttransaction->save($this->request->data)) {
						//add merchant notes when change in rate
						$this->loadModel('Merchantnote');
						$noteData = array();
						$changedBy = $this->Session->read('UserAuth.User.user_Name');
						$noteData['Merchantnote']['merchantID'] = $merchantID;
						$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
						$timestamp = CURRENTDATE;
						$noteData['Merchantnote']['timeStamp'] = $timestamp;
						$noteData['Merchantnote']['note'] = "Merchant Transaction values has been changed successfully by ".$changedBy." on Date ".$timestamp;
						$this->Merchantnote->save($noteData);
						
						$this->Session->write('popup','Merchant Transaction has been updated successfully.');			
						$this->Session->setFlash('Merchant Transaction has been updated successfully.');  
						$this->redirect(array('controller'=>'merchants','action' => "merchanttrans/".$merchantID."/message:success"));
					}				
				}
				
		}
		
	 }	 	
	
	public function superadmin_merchantaction($merchantID = null) {
			$errorsArr ='';	
			$this->set('id',$merchantID);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.navigationOrder ASC")));
			$this->set('status',$Status_list);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.navigationOrder asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			// ===== Find Referal Type User List ===============
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
			// ============= end ==========
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			// jitendra 01-08-2013 in reference of ticket# 1280
			$this->loadModel('EmailTemplate');
			$groupId	=	$this->Session->read('UserAuth.User.user_group_id');
			$userId		=	$this->Session->read('UserAuth.User.id');
			$email_template = $this->EmailTemplate->find("list",array('fields'=>'id,title','conditions'=>array('OR'=>array('EmailTemplate.user_id'=>$userId,'EmailTemplate.user_group_id'=>1))));
			$this->set('other_email_template',$email_template);
			
			if ($this->request->is('get')) {
			
			
				$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
				// list DOCS section document for attach in this email.
				$this->loadModel('Merchantprocessordoclink');
				$merchantdocs = $this->Merchantprocessordoclink->find('all',array('conditions'=>array('Merchantprocessordoclink.merchantID'=>$merchantID)));
				$this->set('merchantdocs',$merchantdocs);
			
				if($this->request->data){
					$stausID = $this->request->data['Merchant']['statusID'];
					$this->set('stausID',$stausID);
					$this->set('marchant',$this->request->data);
				}else{
					$this->Session->write('popup','Merchant not exist.');			
					$this->Session->setFlash('Merchant not exist.');
					$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
				}
				
				$sendfrom = $this->Session->read('UserAuth.User.userEmail');
				$this->request->data['EmailTemplate']['sentFrom']=$sendfrom;
				
			
				
			} else {
			
				if($this->request->data['Submit']=='Send Email'){						
						$merchantID = $this->request->data['Merchant']['merchantID'];
						$this->Merchant->recursive = 0;
						$merchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
											
						$managerID 	= $merchantData['Merchant']['managerID'];
						$agentID 	= $merchantData['Merchant']['agentID'];
						$sendto 	= $merchantData['Merchant']['contactEmail'];
						$sendfrom 	= $this->request->data['Merchant']['sendFrom'];
						
						$subject 	= "Your Online Application Link - ".$merchantData['Merchant']['merchantName'];
						$bodyText 	= "";
						$package  	= $this->request->data['Processor']['Package'];
						$packFile  	= $this->request->data['Processor']['Filename'];
						
						$attachfilePath = WWW_ROOT."uploadedfile/".$packFile;
					
						$list = array();	
						$cclist = array();
						
						if(strlen($this->request->data['Merchant']['manager'])>1)
						{
							$list[]	=	$merchantData['Manager']['userEmail'];
						}
						if(strlen($this->request->data['Merchant']['iso'])>1)
						{
							$list[]	=	$merchantData['ISO']['userEmail'];
						}
						if(strlen($this->request->data['Merchant']['Agent'])>1)
						{
							$list[]	=	$merchantData['Agent']['userEmail'];
						}
						if(strlen($this->request->data['Merchant']['referral'])>1)
						{
							$list[]	=	$merchantData['Referal']['userEmail'];
						}
						
						if($this->request->data['Merchant']['cc_email']!=""){
							$cclist = explode(",",trim($this->request->data['Merchant']['cc_email']));
						}
						if($this->request->data['Merchant']['bcc_email']!=""){
							$bcclist = explode(",",trim($this->request->data['Merchant']['bcc_email']));
						}						
						if(is_array($bcclist) && is_array($list)){
							$list = array_merge($list,$bcclist);
						}
						
						// Replacce safe code like [MANAGER NAME] From email body text
						if($managerID!=''){
							$managerEmail		= 	$merchantData['Manager']['userEmail'];
							$managerName		= 	$merchantData['Manager']['user_Name'];
							$managerCompany 	= 	$merchantData['Manager']['userCompany'];
							$managerCompanyUrl 	=	$merchantData['Manager']['userCompanyUrl'];
							$managerPhone 		= 	"Phone:".$merchantData['Manager']['userPhone'];
						}else{
							$managerEmail = '';
							$managerName = '';
							$managerCompany = '';
							$managerCompanyUrl = '';
							$managerPhone = '';
						}
						$merchantContactName 	= $merchantData['Merchant']['contactName'];
						$merchantLegalName 		= $merchantData['Merchant']['merchantName'];
						$preapp_req_url = '<a href="'.FULL_BASE_URL.Router::url('/').'superadmin/apis/merchantbasicinfo/'.$merchantID.'">'.FULL_BASE_URL.Router::url('/').'superadmin/apis/merchantbasicinfo/'.$merchantID.'</a>';					
						
						$appFrom = $this->request->data['Merchant']['appFrom'];
						if($appFrom=='send-app' || $appFrom==''){
							$appFrom = "TotalApps";
						}
						
						//send to merchant
						$email = new CakeEmail("smtp");
						$email->from(array($sendfrom));
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						
						$attachment_array = array();
						if($package=='1' && file_exists($attachfilePath)){
							//$email->attachments(array($attachfilePath));
							$attachment_array[] = $attachfilePath;
							//$bodyText .= nl2br($this->request->data['Processor']['email_template'])."<br/><br/>";
							$bodyText .= "Dear ".$merchantLegalName.",<br/><br/>Find Your Application document in attachment to complete your application on Total-Apps.<br/><br/>Sincerely,<br/><br/>".$managerName."<br/>Account Manager<br/>".$managerCompany."<br/>".$managerCompanyUrl."<br/>".$managerPhone;
							$noteText = "An Application Document has been sent to merchant's email for completing the application on total-apps.";
							
							if($appFrom=='MojoPay'){
								$bodyText = str_ireplace("TotalApps", "MojoPay", $bodyText);
								$bodyText = str_ireplace("Total-Apps", "MojoPay", $bodyText);
							}
							if($appFrom=='MeritCard'){
								$bodyText = str_ireplace("TotalApps", "MeritCard", $bodyText);
								$bodyText = str_ireplace("Total-Apps", "MeritCard", $bodyText);
							}
							
						}else{
							$bodyText .= nl2br($this->request->data['Processor']['email_template']);						
							
							if($appFrom=='MojoPay'){
								$bodyText = str_ireplace("TotalApps", "MojoPay", $bodyText);
								$bodyText = str_ireplace("Total-Apps", "MojoPay", $bodyText);
							}
							if($appFrom=='MeritCard'){
								$bodyText = str_ireplace("TotalApps", "MeritCard", $bodyText);
								$bodyText = str_ireplace("Total-Apps", "MeritCard", $bodyText);
							}							
							
							$processr_id	=	$merchantData['Merchant']['processorID'];
							
							if(!empty($processr_id) && $processr_id=='1357'){
								$preapp_req_url = '<a href="http://mojopay.com/user-info.html?merchant_id='.$merchantID.'">Click Here</a>';
								
							}
						
							if(stripos($bodyText,"[PREAPP REQUEST URL]")===false && stripos($bodyText,"[MERCHANT/CONTACT NAME]")===false){
								$bodyText = "Dear ".$merchantLegalName.",<br/><br/>You are just a few, short steps away from being able to accept credit cards. Getting your merchant account setup properly and efficiently is our number one goal.<br/><br/>In order to process your application as quickly as possible, we offer a fully automated, online application system. Please click on the link below to start your online application:<br/><br/>".$preapp_req_url."<br/><br/>".$bodyText."<br/><br/>Sincerely,<br/><br/>".$managerName."<br/>Account Manager<br/>".$managerCompany."<br/>".$managerCompanyUrl."<br/>".$managerPhone;								
							}else{
								$search = array("[FROM MANAGER EMAIL]", "[MERCHANT/LEGAL NAME]", "[MERCHANT/CONTACT NAME]", "[MANAGER NAME]", "[MANAGER/COMPANY]","[MANAGER/Company URL]","[MANAGER/PHONE]","[PREAPP REQUEST URL]");
								$replace   = array($managerEmail, $merchantLegalName, $merchantContactName, $managerName, $managerCompany, $managerCompanyUrl, $managerPhone, $preapp_req_url);
								// Here is replcement of all safe code in body text
								$bodyText = str_replace($search, $replace, $bodyText);
							}
							$noteText = "An Application API LINK has been sent to merchant's email for completing the application on total-apps.";
						}
						//attach the documents uploaded (ticket id #2913)
						foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
							if($additionalDoc['error']==0){
								$docname = $additionalDoc['name'];
								$attachfilePath = $additionalDoc['tmp_name'];
								$attachment_array[$docname] = $attachfilePath;
							}
						}
						$email->attachments($attachment_array);
						/* echo "<pre>";
						print_r($list);die;	 */				
						if(Validation::email($sendto)){
							$email->to($sendto);
							$email->cc($cclist);
							$email->bcc($list);
							if($sendto!=''){
								$email->send($bodyText); 
							}
						}
						//sent merchant to incomplete list (statusID = 3 for incomplete )	***** STEP 2 ****
						$incompleteDate = date("Y-m-d");
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>3,'appFrom'=>$appFrom,'incompleteDate'=>$incompleteDate));						
						$this->Merchant->save( $data, false, array('statusID','appFrom','incompleteDate'));
						
						// Add status update in merchant pipeline
						$this->loadModel('Merchantpipeline');
						$pipelineData = array();
						$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
						$pipelineData['Merchantpipeline']['statusFrom'] = 1;
						$pipelineData['Merchantpipeline']['statusTo'] = 3;
						$pipelineData['Merchantpipeline']['statusToDate'] = date('Y-m-d');
						$this->Merchantpipeline->save($pipelineData);
						//add merchant notes when change in status
						
						$this->loadModel('Merchantnote');
						$noteData = array();
						$changedBy = $this->Session->read('UserAuth.User.user_Name');
						$noteData['Merchantnote']['merchantID'] = $merchantID;
						$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
						$timestamp = CURRENTDATE;
						$noteData['Merchantnote']['timeStamp'] = $timestamp;
						$noteData['Merchantnote']['note'] = $noteText." Status of pre-app request for this merchant has been changed form Lead To Incomplete by ".$changedBy." on Date ".$timestamp;
						$this->Merchantnote->save($noteData);
												
						$this->Session->write('popup','Email has been successfully sent to merchant.');			
						$this->Session->setFlash('Email has been successfully sent to merchant.');  
						$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));
				}
				if($this->request->data['Submit']=='Request Docs'){
					$merchantInfo = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
					// get processor docs
					$managerID = $merchantInfo['Merchant']['managerID'];
					$processorID = $this->request->data['Merchant']['processorID'];
					$processorDoc = $this->Common->getProcessorDoc($processorID);
					foreach($processorDoc as $key => $pDocs){
						$processorDocs[] = $pDocs['Processordoclink']['docID'];
					}
					// Get merchant docs
					$this->loadModel('Merchantprocessordoclink');
					$merchantDocs = $this->Merchantprocessordoclink->find('list',array("fields" => array("docID"),'conditions'=>array('Merchantprocessordoclink.merchantID'=>$merchantID)));
					foreach($merchantDocs as $key){
						$merchantDoc[] = $key;
					}
					//remaining docs
					$incompleteDocs = array_diff($processorDocs, $merchantDoc);
					//pr($incompleteDocs);die;
					// get document name list
					$incomDocList = '';
					$i = 1;
					$this->loadModel('Processordoc');
					foreach($incompleteDocs as $key){
						$docnames = $this->Processordoc->find('first',array("fields" => array("docName"),'conditions'=>array('Processordoc.id'=>$key)));
						$incomDocList .= $i.". ".$docnames['Processordoc']['docName']."<br/>";
						$i++;
					}
					// get manager information
					if($managerID!=''){
						$managerEmail = $merchantInfo['Manager']['userEmail'];
						$managerName = $merchantInfo['Manager']['user_Name'];
						$managerCompany = $merchantInfo['Manager']['userCompany'];
						$managerCompanyUrl = $merchantInfo['Manager']['userCompanyUrl'];
						$managerPhone = $merchantInfo['Manager']['userPhone'];
					}else{
						$managerEmail = '';
						$managerName = '';
						$managerCompany = '';
						$managerCompanyUrl = '';
						$managerPhone = '';
					}
					$merchantContactName = $merchantInfo['Merchant']['contactName'];
					$subject = "This is subject of incomplete document list email";
					$bodyText = $this->request->data['Merchant']['personalMessage'];
					$search = array("[MERCHANT/CONTACT NAME]", "[MANAGER NAME]", "[MANAGER/COMPANY]","[MANAGER/Company URL]","[MANAGER/PHONE]","[INCOMPLETE DOCUMENT LIST]");
					$replace   = array($merchantContactName, $managerName, $managerCompany, $managerCompanyUrl, $managerPhone, $incomDocList);
					// Here is replcement of all safe code in body text
					$bodyText = nl2br(str_replace($search, $replace, $bodyText));
					$attachment_array = array();
					//attach the documents uploaded (ticket id #2913)
					foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
						if($additionalDoc['error']==0){
							$docname = $additionalDoc['name'];
							$attachfilePath = $additionalDoc['tmp_name'];
							$attachment_array[$docname] = $attachfilePath;
						}
					}
					
					$email = new CakeEmail("smtp");
					if(count($attachment_array)>0){
						$email->attachments($attachment_array);
					}
					//sending emails
					if($this->request->data['Merchant']['mailto']=='agent'){
						$agentEmail =   $this->User->find('first',array("fields" => array("userEmail"),'conditions'=>array('User.id'=>$this->request->data['Merchant']['agentID'])));
						$sendto = $agentEmail['User']['userEmail'];
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						if(Validation::email($sendto)){
							$email->to($sendto);
							if($sendto!=''){ $email->send($bodyText); }
						}
					}
					elseif($this->request->data['Merchant']['mailto']=='merchant'){
						$sendto = $this->request->data['Merchant']['merchantEmail'];
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						if(Validation::email($sendto)){
							$email->to($sendto);
							if($sendto!=''){$email->send($bodyText);}
						}
					}
					else{
						$agentEmail =   $this->User->find('first',array("fields" => array("userEmail"),'conditions'=>array('User.id'=>$this->request->data['Merchant']['agentID'])));
						$sendtoagent = $agentEmail['User']['userEmail'];
						$sendtomerchant = $this->request->data['Merchant']['merchantEmail'];
						
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
						//send to agent
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						if(Validation::email($sendtoagent)){
							$email->to($sendtoagent);
							if($sendtoagent!=''){ $email->send($bodyText);}
						}
						//send to merchant
						$email->to($sendtomerchant);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						if(Validation::email($sendtomerchant)){
							$email->to($sendtomerchant);
							if($sendtomerchant!=''){ $email->send($bodyText);	}		
						}			
					}	
					
					//add merchant notes when change in status
					$this->loadModel('Merchantnote');
					$noteData = array();
					$changedBy = $this->Session->read('UserAuth.User.user_Name');
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = "Incomplete document list email has been sent by ".$changedBy." on Date ".$timestamp;
					$this->Merchantnote->save($noteData);
						
					$this->Session->write('popup','Incomplete Doc Email has been successfully sent.');			
					$this->Session->setFlash('Incomplete Doc Email has been successfully sent.');  
					$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));
					
				}
				if($this->request->data['Submit']=='Send Bad URL Email'){
						$merchantInfo = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
						$managerID = $merchantInfo['Merchant']['managerID'];
						// get manager information
						if($managerID!=''){
							$managerEmail 		= $merchantInfo['Manager']['userEmail'];
							$managerName 		= $merchantInfo['Manager']['user_Name'];
							$managerCompany 	= $merchantInfo['Manager']['userCompany'];
							$managerCompanyUrl 	= $merchantInfo['Manager']['userCompanyUrl'];
							$managerPhone 		= $merchantInfo['Manager']['userPhone'];
						}else{
							$managerEmail = '';
							$managerName = '';
							$managerCompany = '';
							$managerCompanyUrl = '';
							$managerPhone = '';
						}
						
						$sendtoagent 	=	$merchantInfo['Agent']['userEmail'];
						$sendtomerchant =	$merchantInfo['Merchant']['contactEmail'];
						$merchantContactName = $merchantInfo['Merchant']['contactName'];
						
						$email = new CakeEmail("smtp");
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
						$subject = "This is subject of Bad URL email";
						$bodyText = $this->request->data['Merchant']['Message'];
						$search = array("[MERCHANT/CONTACT NAME]", "[MANAGER NAME]", "[MANAGER/COMPANY]","[MANAGER/Company URL]","[MANAGER/PHONE]");
						$replace   = array($merchantContactName, $managerName, $managerCompany, $managerCompanyUrl, $managerPhone);
						// Here is replcement of all safe code in body text
						$bodyText = nl2br(str_replace($search, $replace, $bodyText));
						//attach the documents uploaded (ticket id #2913)
						foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
							if($additionalDoc['error']==0){
								$docname = $additionalDoc['name'];
								$attachfilePath = $additionalDoc['tmp_name'];
								$attachment_array[$docname] = $attachfilePath;
							}
						}
						$email->attachments($attachment_array);
						//send to agent
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						//if($sendtoagent!=''){$email->send($bodyText);}
						if(Validation::email($sendtoagent)){
							$email->to($sendtoagent);
							$email->send($bodyText);
						}
						//send to merchant
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						//if($sendtomerchant!=''){$email->send($bodyText);}
						if(Validation::email($sendtomerchant)){
							$email->to($sendtomerchant);
							$email->send($bodyText);
						}

						$oldStatus = $this->request->data['Merchant']['statusID'];
						// sent merchant to dead list (statusID = 7 for dead )						
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>7));
						//pr($data);die;
						if($this->Merchant->save( $data, false, array('statusID'))){
							// Add status update in merchant pipeline
							$this->loadModel('Merchantpipeline');
							$pipelineData = array();
							$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
							$pipelineData['Merchantpipeline']['statusFrom'] = $oldStatus;
							$pipelineData['Merchantpipeline']['statusTo'] = 7;
							$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
							$this->Merchantpipeline->save($pipelineData);
							
							//add merchant notes when change in status
							$this->loadModel('Merchantnote');
							$noteData = array();
							$changedBy = $this->Session->read('UserAuth.User.user_Name');
							$noteData['Merchantnote']['merchantID'] = $merchantID;
							$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
							$timestamp = CURRENTDATE;
							$noteData['Merchantnote']['timeStamp'] = $timestamp;
							$noteData['Merchantnote']['note'] = "Bad Url Email has been sent and Status has been changed to DEAD by ".$changedBy." on Date ".$timestamp;
							$this->Merchantnote->save($noteData);
													
							$this->Session->write('popup','Bad URL Email has been successfully sent.');			
							$this->Session->setFlash('Bad URL Email has been successfully sent.');  
							$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));
						
						}else{
							$this->Session->write('popup','Problem in saving data.');			
							$this->Session->setFlash('Problem in saving data.');  
							$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:failure"));
						}
					
				}
				if($this->request->data['Submit']=='Send Processor Pre-App Approval'){
						$i=1;$emailtemplate ="";
						$this->loadModel('Merchantprocessordoclink');
						$merchantREC= $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
						$merchantDocs = $this->Merchantprocessordoclink->find('all',array('conditions'=>array('Merchantprocessordoclink.merchantID'=>$merchantID)));
						$managerID = $merchantREC['Merchant']['managerID'];
						// get manager information
						if($managerID!=''){
							$managerEmail 		= $merchantREC['Manager']['userEmail'];
							$managerName 		= $merchantREC['Manager']['user_Name'];
							$managerCompany 	= $merchantREC['Manager']['userCompany'];
							$managerCompanyUrl 	= $merchantREC['Manager']['userCompanyUrl'];
							$managerPhone 		= $merchantREC['Manager']['userPhone'];
						}else{
							$managerEmail = '';
							$managerName = '';
							$managerCompany = '';
							$managerCompanyUrl = '';
							$managerPhone = '';
						}
						$merchantContactName = $merchantREC['Merchant']['contactName'];
							foreach($this->request->data['Processor'] as $key=>$value)
							{
								if($value && $value!='PREAPPROVAL')
								{	
									$processorEmailId=$this->Common->getProcessorEmail($key);
									if($processorEmailId!=""){
										$emailtemplate .="<table>
														<tr>
															<td width='120px'><strong>Contact Name:</strong></td>
															<td>".$merchantREC['Merchant']['merchantName']."</td>
														</tr>
														<tr>
															<td><strong>Contact Phone: </strong></td>
															<td>".$merchantREC['Merchant']['contactPhone']."</td>
														</tr>
														<tr>
															<td><strong>Contact Email:</strong></td>
															<td>".$merchantREC['Merchant']['contactEmail']."</td>
														</tr>
														<tr>
															<td><strong>Merchant DBA: </strong></td>
															<td>".$merchantREC['Merchant']['merchantDBA']."</td>
														</tr>
														
														<tr>
															<td><strong>Merchant URL:</strong></td>
															<td>".$merchantREC['Merchant']['merchantURL']."</td>
														</tr>
													</table>";
										$email = new CakeEmail("smtp");
										$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
										
										$email->emailFormat('html');
										$email->subject("Total-Apps: Processor pre approval mail");
										// send all supporting documents in one email to processors
										$attachment_array = array();
										//attach the documents uploaded(ticket id #2913)
										foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
											if($additionalDoc['error']==0){
												$docname = $additionalDoc['name'];
												$attachfilePath = $additionalDoc['tmp_name'];
												$attachment_array[$docname] = $attachfilePath;
											}
										}
										foreach($merchantDocs as $key=>$merchantDoc){
											$attachdocsPath = WWW_ROOT."files/MerchantDocument/".$merchantDoc['Merchantprocessordoclink']['docName'];
											if(file_exists($attachdocsPath)){
													$attachment_array[] = $attachdocsPath;												
												}
											}
											$email->attachments($attachment_array);
											$body1 = $this->request->data['Merchant']['Message']."<br/>Also you can find merchant's supporting documents in attachment.";
											
											$search = array("[MERCHANT/CONTACT NAME]", "[MANAGER NAME]", "[MANAGER/COMPANY]","[MANAGER/Company URL]","[MANAGER/PHONE]","[EMAIL TEMPLATE]");
											$replace   = array($merchantContactName, $managerName, $managerCompany, $managerCompanyUrl, $managerPhone, $emailtemplate);
											// Here is replcement of all safe code in body text
											$body1 = nl2br(str_replace($search, $replace, $body1));																	
											if(Validation::email($processorEmailId)){
												$email->to($processorEmailId);
												$email->send($body1);
											}
										// send application document in email
										$attachappDoc = WWW_ROOT."files/MerchantDocument/Merchant-".$merchantREC['Merchant']['id'].".pdf";
										if(file_exists($attachappDoc)){
												$email->attachments(array($attachappDoc));
												$body2 = $this->request->data['Merchant']['Message']."<br/>Also you can find merchant's application document in attachment.";
												$search = array("[MERCHANT/CONTACT NAME]", "[MANAGER NAME]", "[MANAGER/COMPANY]","[MANAGER/Company URL]","[MANAGER/PHONE]","[EMAIL TEMPLATE]");
												$replace   = array($merchantContactName, $managerName, $managerCompany, $managerCompanyUrl, $managerPhone, $emailtemplate);
												// Here is replcement of all safe code in body text
												$body2 = nl2br(str_replace($search, $replace, $body2));
												if(Validation::email($processorEmailId)){
													$email->to($processorEmailId);
													$email->send($body2);
												}
										}
										// send one click email
										/* if(Validation::email($processorEmailId)){
												$email->to($processorEmailId);
												$email->send($body);
										} */
										
										$i=$i+1;
									}
								}
							}
							//add merchant notes when change in status
							$this->loadModel('Merchantnote');
							$noteData = array();
							$changedBy = $this->Session->read('UserAuth.User.user_Name');
							$noteData['Merchantnote']['merchantID'] = $merchantID;
							$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
							$timestamp = CURRENTDATE;
							$noteData['Merchantnote']['timeStamp'] = $timestamp;
							$noteData['Merchantnote']['note'] = "Pre-Approval E-mail has been successfully send to selected processor by ".$changedBy." on Date ".$timestamp;
							$this->Merchantnote->save($noteData);
							
							$this->Session->write('popup','E-mail has been successfully send to selected processor.');			
							$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));		
						}
				if($this->request->data['Submit']=='Return for signature'){
					$this->loadModel('Rate');
					$this->loadModel('Owner');
					$this->loadModel('Commission');
					//$this->loadModel('Deployment');
					$this->loadModel('Merchanttransaction');
					
					$merchantID = $this->request->data['Merchant']['id'];
					$merchantREC= $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
					//check whether rates,transaction and owner information is saved or not for this merchant
					$RatesData = $this->Rate->find('first',array('conditions'=>array('Rate.merchantID'=>$merchantID)));
					$TransData = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.merchantID'=>$merchantID)));
					$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
					$CommissionData = $this->Commission->find('first',array('conditions'=>array('Commission.merchantID'=>$merchantID)));
					/*
					 * as in ticket id 1988 (remove deployment necessity for return for signature)
					 *
					$DeploymentData = $this->Deployment->find('first',array('conditions'=>array('Deployment.merchantID'=>$merchantID)));
					*
					*/
					if(!is_array($RatesData)){
						$this->Session->write('popup','Merchant Rates information is not saved!Please save this before submit return for signature');			
						$this->Session->setFlash('Your Rates information is not saved!Please save this before submit return for signature');  
						$this->redirect(array('controller'=>'merchants','action' => "merchantrates/".$merchantID."/message:failure#rate"));
						exit;
					}elseif(!is_array($TransData)){
						$this->Session->write('popup','Merchant Transaction information is not saved!Please save this before submit return for signature');			
						$this->Session->setFlash('Your Transaction information is not saved!Please save this before submit return for signature');  
						$this->redirect(array('controller'=>'merchants','action' => "merchanttrans/".$merchantID."/message:failure#transaction"));
						exit;
					}elseif(!is_array($OwnerData)){
						$this->Session->write('popup','Merchant owners/partners/officers information is not saved!Please save this before submit return for signature');			
						$this->Session->setFlash('Merchant owners/partners/officers information is not saved!Please save this before submit return for signature');  
						$this->redirect(array('controller'=>'merchants','action' => "moreinfo/".$merchantID."/message:failure#more"));
						exit;
					}/* elseif(!is_array($DeploymentData)){
						$this->Session->write('popup','Merchant Deployment information is not saved!Please save this before submit return for signature');			
						$this->Session->setFlash('Merchant Deployment information is not saved!Please save this before submit return for signature');  
						$this->redirect(array('controller'=>'merchants','action' => "merchantdeployment/".$merchantID."/message:failure#deployment"));
						exit;
					} */else{
						$pendingDate = date("Y-m-d");
						//sent merchant to Pending list (statusID = 4 for pending ) *** Step 4 ***						
						/* $data = array('Merchant' => array('id'=>$merchantID,'statusID'=>4,'pendingDate'=>$pendingDate));
						$this->Merchant->save( $data, false, array('statusID','pendingDate')); */
						// Add status update in merchant pipeline
						/* $this->loadModel('Merchantpipeline');
						$pipelineData = array();
						$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
						$pipelineData['Merchantpipeline']['statusFrom'] = 3;
						$pipelineData['Merchantpipeline']['statusTo'] = 4;
						$pipelineData['Merchantpipeline']['statusToDate'] = $pendingDate;
						$this->Merchantpipeline->save($pipelineData); */
						//add merchant notes when change in status
						$this->loadModel('Merchantnote');
						$noteData = array();
						$changedBy = $this->Session->read('UserAuth.User.user_Name');
						$noteData['Merchantnote']['merchantID'] = $merchantID;
						$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
						$timestamp = CURRENTDATE;
						$noteData['Merchantnote']['timeStamp'] = $timestamp;
						$noteData['Merchantnote']['note'] = "An email has been sent for sign the application document to this merchant by ".$changedBy." on Date ".$timestamp;
						$this->Merchantnote->save($noteData);
						// send mail to merchant
						$sendto = $this->request->data['Merchant']['contactEmail'];
						$subject = "Send your application approval signature";
						
						$email = new CakeEmail("smtp");
						$sendfrom = $this->Session->read('UserAuth.User.userEmail');
						$email->from(array($sendfrom));
						// add template of email from front end
						// task id 3718 (return for signature the email goes in spam)
						//$fullapp_req_url = '<a href="'.FULL_BASE_URL.Router::url('/').'superadmin/apis/merchantapi/'.$merchantID.'">Click here to digitally sign your merchant application</a>';
						$fullapp_req_url = '<a href="'.FULL_BASE_URL.Router::url('/').'superadmin/apis/merchantapi/'.$merchantID.'">'.FULL_BASE_URL.Router::url('/').'superadmin/apis/merchantapi/'.$merchantID.'</a>';
						$bodyText = $this->request->data['Merchant']['email_template'];
						if(stripos($bodyText,"[FULLAPP REQUEST URL]")===false){
							$bodyText = $bodyText."<br/><br/>".$fullapp_req_url;
						}else{
							$managerName = $merchantREC['Manager']['user_Name'];
							$managerEmail = '<a href="mailto:'.$merchantREC['Manager']['userEmail'].'">'.$merchantREC['Manager']['userEmail'].'</a>';
							$search = array("[FULLAPP REQUEST URL]", "[MANAGER NAME]", "[MANAGER EMAIL]");
							$replace   = array($fullapp_req_url, $managerName, $managerEmail);
							// Here is replcement of all safe code in body text
							$bodyText = str_replace($search, $replace, $bodyText);
						}
						$attachment_array = array();
						//attach the documents uploaded(ticket id #2913)
						foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
							if($additionalDoc['error']==0){
								$docname = $additionalDoc['name'];
								$attachfilePath = $additionalDoc['tmp_name'];
								$attachment_array[$docname] = $attachfilePath;
							}
						}
						$email->attachments($attachment_array);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						if(Validation::email($sendto)){
							$email->to($sendto);
							if($sendto!=''){
								$bodyText = nl2br($bodyText);
								$email->send($bodyText);
								// new update for resign the final application by merchant(new document point 13-5)
								$data = array('Merchant' => array('id'=>$merchantID,'merchantSign'=>''));
								$this->Merchant->save( $data, false, array('merchantSign'));
								// Delete Signature
								$signImg = WWW_ROOT."files/Signature/".$merchantREC['Merchant']['merchantSign'];
								if(file_exists($signImg)){
									@unlink($signImg);
								}
							}
							$this->Session->write('popup','Email has been successfully sent to merchant.');			
							$this->Session->setFlash('Email has been successfully sent to merchant.');  
						}
						$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));
					}
				}
				if($this->request->data['Merchant']['submitfrom']=="request_supporting_documents"){
					$attachment_array = array();
					$bodyText ="";
					$merchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
					$merchantEmail = $merchantData['Merchant']['contactEmail'];
					$managerEmail =  $merchantData['Manager']['userEmail'];
					$managerID    =  $merchantData['Merchant']['managerID'];
					
					if($managerID!=''){
						$managerEmail 		= $merchantData['Manager']['userEmail'];
						$managerName 		= $merchantData['Manager']['user_Name'];
						$managerCompany 	= $merchantData['Manager']['userCompany'];
						$managerCompanyUrl 	= $merchantData['Manager']['userCompanyUrl'];
						$managerPhone 		= $merchantData['Manager']['userPhone'];
					}else{
						$managerEmail = '';
						$managerName = '';
						$managerCompany = '';
						$managerCompanyUrl = '';
						$managerPhone = '';
					}
					$merchantContactName = $merchantData['Merchant']['contactName'];
					
					
					$attachfilePath = WWW_ROOT."uploadedfile/CARD NOT PRESENT QUESTIONNAIRE-E-CommMOTO Accts.pdf";
					//send to merchant
					$email = new CakeEmail("smtp");					
					$subject = "Supporting Documents Needed for your Merchant Account Application.";
					$managerEmail = "info@total-apps.com";
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
					
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));		
					$attachment_array[] = $attachfilePath; 
					//attach the documents uploaded #2319
					foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
						if($additionalDoc['error']==0){
							$docname = $additionalDoc['name'];
							$attachfilePath = $additionalDoc['tmp_name'];
							$attachment_array[$docname] = $attachfilePath;
						}
					}
					$email->attachments($attachment_array);					
					//$email->attachments(array($attachfilePath));
					
					$bodyText .= $this->request->data['Merchant']['Message'];
					$search = array("[MERCHANT/CONTACT NAME]", "[MANAGER NAME]", "[MANAGER/COMPANY]","[MANAGER/Company URL]","[MANAGER/PHONE]");
					$replace   = array($merchantContactName, $managerName, $managerCompany, $managerCompanyUrl, $managerPhone);
					// Here is replcement of all safe code in body text
					$bodyText = nl2br(str_replace($search, $replace, $bodyText));
					
					if(Validation::email($merchantEmail)){
						$email->to($merchantEmail);
						if($merchantEmail!=''){
							$email->send($bodyText);
														
							//add merchant notes when email sending successfully.
							$this->loadModel('Merchantnote');
							$noteData = array();
							$changedBy = $this->Session->read('UserAuth.User.user_Name');
							$noteData['Merchantnote']['merchantID'] = $merchantID;
							$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
							$timestamp = CURRENTDATE;
							$noteData['Merchantnote']['timeStamp'] = $timestamp;
							$noteData['Merchantnote']['note'] = "An email has been sent to the merchant with the supporting documents needed for merchant account application on Date ".$timestamp;
							$this->Merchantnote->save($noteData);						
							
							$this->Session->write('popup','Email has been successfully sent to merchant.');
							$this->Session->setFlash('Email has been successfully sent to merchant.');
							$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));
						}
					}
				}
				if($this->request->data['Merchant']['submitfrom']=="send_application_to_processor"){
					$bodyText ="";
					$merchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
					$merchantEmail = $merchantData['Merchant']['contactEmail'];
					
					$managerEmail = $merchantData['Manager']['userEmail'];
					$merchantDbaName = $merchantData['Merchant']['merchantDBA'];
					$managerID    =  $merchantData['Merchant']['managerID'];
						
					if($managerID!=''){
						$managerEmail 		= $merchantData['Manager']['userEmail'];
						$managerName 		= $merchantData['Manager']['user_Name'];
						$managerCompany 	= $merchantData['Manager']['userCompany'];
						$managerCompanyUrl 	= $merchantData['Manager']['userCompanyUrl'];
						$managerPhone 		= $merchantData['Manager']['userPhone'];
					}else{
						$managerEmail = '';
						$managerName = '';
						$managerCompany = '';
						$managerCompanyUrl = '';
						$managerPhone = '';
					}
					$cclist = array($merchantEmail,$managerEmail);
					//send to processor
					if(trim($merchantData['Processor']['application_email'])!=""){
						$processorEmail = trim($merchantData['Processor']['application_email']);
					}else{
						$processorEmail = trim($merchantData['Processor']['userEmail']);
					}
					
					$email = new CakeEmail("smtp");
					$subject = "Supporting Documents Needed for your Merchant Account Application.";
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					//attach the documents under DOCS					
					$attachment_array = array();
					foreach($this->request->data['Merchantdoc'] as $docname => $document){
						if($document!=0){
							$ext = end(explode(".", $document));
							$docname = $docname.'.'.$ext;
							//$docname = $docname;
							$attachfilePath = WWW_ROOT."files/MerchantDocument/".$document;
							$attachment_array[$docname] = $attachfilePath;	
						}					
					}
					//attach the documents uploaded #2319
					foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
						if($additionalDoc['error']==0){
							$docname = $additionalDoc['name'];
							$attachfilePath = $additionalDoc['tmp_name'];
							$attachment_array[$docname] = $attachfilePath;
						}
					}	
					$email->attachments($attachment_array);
					
					// task 2273 for add merchant pdf link.
					$pdflink = '<a href="'.FULL_BASE_URL.Router::url('/').'superadmin/apis/downloadpdf/'.$merchantID.'.pdf"> Click Here To Download Merchant Application Form PDF. </a>';
					$bodyText .= $this->request->data['Merchant']['Message'];
					$search = array("[MERCHANT DBA NAME]", "[PDF DOWNLOAD LINK]", "[MANAGER NAME]", "[MANAGER/COMPANY]","[MANAGER/Company URL]","[MANAGER/PHONE]");
					$replace   = array($merchantDbaName, $pdflink, $managerName, $managerCompany, $managerCompanyUrl, $managerPhone);
					// Here is replcement of all safe code in body text
					$bodyText = nl2br(str_replace($search, $replace, $bodyText));
					
					if(Validation::email($processorEmail)){
						$email->to($processorEmail);
						$email->cc($cclist); // cc email to manager
						$email->send($bodyText);
						//add merchant notes when email sending successfully.
						$this->loadModel('Merchantnote');
						$noteData = array();
						$changedBy = $this->Session->read('UserAuth.User.user_Name');
						$noteData['Merchantnote']['merchantID'] = $merchantID;
						$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
						$timestamp = CURRENTDATE;
						$noteData['Merchantnote']['timeStamp'] = $timestamp;
						$noteData['Merchantnote']['note'] = "Application submitted to underwriters on Date ".$timestamp;
						$this->Merchantnote->save($noteData);
						//also change the status of the merchant to Pending
						$data = array('Merchant' => array('id'=>$merchantID,'statusID'=>4));
						$this->Merchant->save( $data, false, array('statusID'));
						
						$this->Session->write('popup','Email has been successfully sent to processor.');
						$this->Session->setFlash('Email has been successfully sent to processor.');
						$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));						
					}
				}
				if($this->request->data['Merchant']['submitfrom']=="welcome_email"){
					$bodyText ="";
					$merchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
					$merchantDbaName = $merchantData['Merchant']['merchantDBA'];
					$merchantEmail 	 = $merchantData['Merchant']['contactEmail'];
				
					if($merchantData['Manager']['user_Name']!=''){
						$managerEmail 		= $merchantData['Manager']['userEmail'];
						$managerName 		= $merchantData['Manager']['user_Name'];
						$managerCompany 	= $merchantData['Manager']['userCompany'];
						$managerCompanyUrl 	= $merchantData['Manager']['userCompanyUrl'];
						$managerPhone 		= $merchantData['Manager']['userPhone'];
					}else{
						$managerEmail = '';
						$managerName = '';
						$managerCompany = '';
						$managerCompanyUrl = '';
						$managerPhone = '';
					}
						
					$email = new CakeEmail("smtp");
					$subject = "Welcome email message from total-apps.com.";
					if($managerEmail!='')
						$email->from(array($managerEmail));
					else
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));					
						
					$bodyText .= $this->request->data['Merchant']['Welcome_message'];
					$search = array("[MERCHANT DBA NAME]", "[MANAGER NAME]", "[MANAGER/COMPANY]","[MANAGER/Company URL]","[MANAGER/PHONE]");
					$replace   = array($merchantDbaName, $managerName, $managerCompany, $managerCompanyUrl, $managerPhone);
					// Here is replcement of all safe code in body text
					$bodyText = nl2br(str_replace($search, $replace, $bodyText));
					$attachment_array = array();
					//attach the documents uploaded # 2913
					foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
						if($additionalDoc['error']==0){
							$docname = $additionalDoc['name'];
							$attachfilePath = $additionalDoc['tmp_name'];
							$attachment_array[$docname] = $attachfilePath;
						}
					}
					$email->attachments($attachment_array);
					
					if(Validation::email($merchantEmail)){
						$email->to($merchantEmail);
						if($merchantEmail!=''){
							$email->send($bodyText);
							$this->Session->write('popup','Email has been successfully sent to merchant.');
							$this->Session->setFlash('Email has been successfully sent to merchant.');
							$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));
						}
					}
				}
				if($this->request->data['Merchant']['submitfrom']=="other_email_template"){
					
					$subject = $this->request->data['EmailTemplate']['subject'];
					$emailFrom = $this->request->data['EmailTemplate']['sentFrom'];
					$bodyText = $this->request->data['EmailTemplate']['template'];
					$image_url = FULL_BASE_URL.Router::url('/');
					$bodyText = str_replace("../../../../app/webroot/", $image_url, $bodyText);
					
					$merchantEmail = explode(",",trim($this->request->data['EmailTemplate']['merchantEmail']));		
					
								
					$email = new CakeEmail("smtp");						
					$email->from(array($emailFrom));
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
									
					$attachment_array = array();
					//attach the documents uploaded # 2913
					foreach($this->request->data['Merchant']['MerchantAddDoc'] as $additionalDoc){
						if($additionalDoc['error']==0){
							$docname = $additionalDoc['name'];
							$attachfilePath = $additionalDoc['tmp_name'];
							$attachment_array[$docname] = $attachfilePath;
						}
					}
					$email->attachments($attachment_array);
					
					if(is_array($merchantEmail)){
						foreach ($merchantEmail as $send_to){
							if(Validation::email(trim($send_to))){
								$email->to(trim($send_to));
								$email->send($bodyText);
							}
						}						
					}
					
					
					
					$this->Session->write('popup','Email template has been successfully sent.');
					$this->Session->setFlash('Email template has been successfully sent.');
					$this->redirect(array('controller'=>'merchants','action' => "merchantaction/".$merchantID."/message:success"));
				}
		}
		
	 }
	
	public function superadmin_merchantdoc($merchantID	 = null) {
			$errorsArr ='';	
			$this->set('id',$merchantID);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
			$this->set('status',$Status_list);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			// ===== Find Referal Type User List ===============
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
			// ============= end ==========
			//echo pr($this->Session->read('UserAuth'));
									
			if ($this->request->is('get')) {
				$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
				if($this->request->data===FALSE){
						$this->Session->write('popup','Merchant not exist.');			
						$this->Session->setFlash('Merchant not exist.');
						$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
				}
				$stausID = $this->request->data['Merchant']['statusID'];
				$this->set('stausID',$stausID);							
				$processorID = $this->request->data['Merchant']['processorID'];
				if(isset($processorID)){
					$processorDoc = $this->Common->getProcessorDoc($processorID);
					$this->set('countDoc',count($processorDoc));
					$this->set('processorDoc',$processorDoc);
				}
			} else {				
				if($this->request->data['Submit']=='Upload'){
						$this->loadModel('Merchantprocessordoclink');
						// Delete old document start here
						$ifExit = $this->Merchantprocessordoclink->find('first',array('conditions'=>array('Merchantprocessordoclink.docID'=>$this->request->data['Merchantprocessordoclink']['docID'], 'Merchantprocessordoclink.merchantID'=>$this->request->data['Merchantprocessordoclink']['merchantID'])));
						if($ifExit!==FALSE){
							$isOk = $this->Merchantprocessordoclink->delete($ifExit['Merchantprocessordoclink']['id']);
							$deletefile = WWW_ROOT."files/MerchantDocument/".$ifExit['Merchantprocessordoclink']['docName'];
							@unlink($deletefile);
						}
						// Delete old document end here
						$filename = time()."_".$this->request->data['Merchantprocessordoclink']['docName']['name'];
						$targetPath = WWW_ROOT."files/MerchantDocument/".$filename;
						$tmp_file    = $this->request->data['Merchantprocessordoclink']['docName']['tmp_name'];
						$ok = @move_uploaded_file($tmp_file,$targetPath);
						$this->request->data['Merchantprocessordoclink']['docName'] = $filename;		
						
						if($this->Merchantprocessordoclink->save($this->request->data)) {
							//add merchant notes when document uploaded
							$this->loadModel('Merchantnote');
							$noteData = array();
							$changedBy = $this->Session->read('UserAuth.User.user_Name');
							$noteData['Merchantnote']['merchantID'] = $this->request->data['Merchantprocessordoclink']['merchantID'];
							$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
							$timestamp = CURRENTDATE;
							$noteData['Merchantnote']['timeStamp'] = $timestamp;
							$noteData['Merchantnote']['note'] = "Supporting Documents has been uploaded for this merchant by ".$changedBy." on Date ".$timestamp;
							$this->Merchantnote->save($noteData);
							
							$this->Session->write('popup','Merchant document has been added successfully.');			
							$this->Session->setFlash('Merchant document has been added successfully.');  
							$this->redirect(array('controller'=>'merchants','action' => "merchantdoc/".$this->request->data['Merchantprocessordoclink']['merchantID']."/message:success"));
						}	
						else {
							$this->Session->setFlash('Data save problem, Please try again.');  
						}	
								
				}

			}
	 }	  
	 
	public function superadmin_merchantdeployment($merchantID	 = null) {
			$errorsArr ='';	
			
			$this->set('id',$merchantID);		
				
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
			$this->set('status',$Status_list);	

			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
				
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);		
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
				
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			// ===== Find Referal Type User List ===============
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
			// ============= end ==========
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			$this->loadModel('Deployment');
			$this->loadModel('Printer');
			$this->loadModel('Checkreader');
			$this->loadModel('Terminalsoftgateway');
			
			$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
			if($MerchantData===FALSE){
					$this->Session->write('popup','Merchant not exist.');			
					$this->Session->setFlash('Merchant not exist.');
					$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
					exit;
			}
			
			if ($this->request->is('get')) {
				$DeployadminData = $this->Deployment->find('all',array('fields'=>'adminName','conditions'=>array('Deployment.userType'=>'admin')));
				$this->set('adminName',$DeployadminData);
				
				if(isset($this->request->query['adminName'])){
					$DeployData = $this->Deployment->find('first',array('conditions'=>array('Deployment.adminName'=>$this->request->query['adminName'])));
					$this->request->data = array_merge($MerchantData, $DeployData);
					$this->request->data['Deployment']['adminName'] = $this->request->query['adminName'];
					$this->set('ID','');
					
					$selected_ttype = explode(",",$this->request->data['Deployment']['cardTransactionType']);
					
					$TeminalData = $this->Terminalsoftgateway->find('all',array('conditions'=>array('Terminalsoftgateway.userType'=>'admin','Terminalsoftgateway.adminName'=>$this->request->query['adminName'])));
					$this->set('TeminalData',$TeminalData);
					
					$PrinterData = $this->Printer->find('all',array('conditions'=>array('Printer.userType'=>'admin','Printer.adminName'=>$this->request->query['adminName'])));
					$this->set('PrinterData',$PrinterData);
					
					$CheckReaderData = $this->Checkreader->find('all',array('conditions'=>array('Checkreader.userType'=>'admin','Checkreader.adminName'=>$this->request->query['adminName'])));
					$this->set('CheckReaderData',$CheckReaderData);
					
				}else{ 
					$DeployData = $this->Deployment->find('first',array('conditions'=>array('Deployment.merchantID'=>$merchantID)));
					if($DeployData){				
						$this->request->data = array_merge($MerchantData, $DeployData);
						$this->set('ID',$this->request->data['Deployment']['id']);
						$selected_ttype = explode(",",$this->request->data['Deployment']['cardTransactionType']);
						
						$TeminalData = $this->Terminalsoftgateway->find('all',array('conditions'=>array('Terminalsoftgateway.merchantID'=>$merchantID)));
						$this->set('TeminalData',$TeminalData);
						
						$PrinterData = $this->Printer->find('all',array('conditions'=>array('Printer.merchantID'=>$merchantID)));
						$this->set('PrinterData',$PrinterData);
						
						$CheckReaderData = $this->Checkreader->find('all',array('conditions'=>array('Checkreader.merchantID'=>$merchantID)));
						$this->set('CheckReaderData',$CheckReaderData);
					
					}else{
						$this->request->data = $MerchantData;
						$selected_ttype = array();
						$this->set('ID','');
					}	
				}	
				
					$this->set('selected_ttype',$selected_ttype);
					$stausID = $this->request->data['Merchant']['statusID'];
					$this->set('stausID',$stausID);
				
			} else {
			//pr($this->Session->read('UserAuth.User.id'));die;
			
				$updateBy = $this->Session->read('UserAuth.User.id');
				$updatedate = date("Y-m-d H:i:s");
				$stausID = $this->request->data['Deployment']['statusID'];
				$this->request->data['Deployment']['lastUpdatedBy'] = $updateBy;
				$this->request->data['Deployment']['lastUpdatedDate'] = $updatedate;
				if(is_array($this->request->data['Deployment']['cardTransactionType'])){
					$this->request->data['Deployment']['cardTransactionType'] = implode(",",$this->request->data['Deployment']['cardTransactionType']);
				}
				// insert data in terminal soft
				$terminalCount = $this->request->data['Terminalsoftgateway']['count'];
				//pr($this->request->data['Terminalsoftgateway']);die;
				$this->Terminalsoftgateway->deleteAll(array('Terminalsoftgateway.merchantID' => $merchantID), false);
				for($i=1;$i<=$terminalCount;$i++){
					$this->Terminalsoftgateway->create();
					$this->request->data['Terminalsoftgateway']['softwareName'] = $this->request->data['Terminalsoftgateway']['softwareName'.$i];
					$this->request->data['Terminalsoftgateway']['trainingGivenBy'] = $this->request->data['Terminalsoftgateway']['trainingGivenBy'.$i];
					$this->request->data['Terminalsoftgateway']['supplier'] = $this->request->data['Terminalsoftgateway']['supplier'.$i];
					if(isset($this->request->data['Terminalsoftgateway']['options'.$i]))
						$this->request->data['Terminalsoftgateway']['options'] = implode(",",$this->request->data['Terminalsoftgateway']['options'.$i]);
					$this->request->data['Terminalsoftgateway']['merchantID'] = $this->request->data['Deployment']['merchantID'];
					$this->Terminalsoftgateway->save($this->request->data);
				}
				// insert data in Printer
				$printerCount = $this->request->data['Printer']['count'];
				$this->Printer->deleteAll(array('Printer.merchantID' => $merchantID), false);

				for($j=1;$j<=$printerCount;$j++){
					$this->Printer->create(); 
					$this->Printer->set($this->request->data); 
					$this->request->data['Printer']['printerName'] = $this->request->data['Printer']['printerName'.$j];
					$this->request->data['Printer']['printerQuantity'] = $this->request->data['Printer']['printerQuantity'.$j];
					$this->request->data['Printer']['printerSupplier'] = $this->request->data['Printer']['printerSupplier'.$j];
					$this->request->data['Printer']['newOrFurbished'] = $this->request->data['Printer']['newOrFurbished'.$j];
					$this->request->data['Printer']['merchantID'] = $this->request->data['Deployment']['merchantID'];
					$this->Printer->save($this->request->data);										
				}
				// insert data in Check Reader
				$readerCount = $this->request->data['Checkreader']['count'];
				$this->Checkreader->deleteAll(array('Checkreader.merchantID' => $merchantID), false);

				for($k=1;$k<=$readerCount;$k++){
					$this->Checkreader->create(); 
					$this->Checkreader->set($this->request->data); 
					$this->request->data['Checkreader']['checkReaderName'] = $this->request->data['Checkreader']['checkReaderName'.$k];
					$this->request->data['Checkreader']['readerQuantity'] = $this->request->data['Checkreader']['readerQuantity'.$k];
					$this->request->data['Checkreader']['readerSupplier'] = $this->request->data['Checkreader']['readerSupplier'.$k];
					$this->request->data['Checkreader']['readerNewOrFurbished'] = $this->request->data['Checkreader']['readerNewOrFurbished'.$k];
					$this->request->data['Checkreader']['merchantID'] = $this->request->data['Deployment']['merchantID'];
					$this->Checkreader->save($this->request->data);										
				}
				
				$this->Deployment->deleteAll(array('Deployment.merchantID' => $merchantID), false);

				if($this->Deployment->save($this->request->data)) {
					//add merchant notes when change in rate
					$this->loadModel('Merchantnote');
					$noteData = array();
					$changedBy = $this->Session->read('UserAuth.User.user_Name');
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = "Merchant Deployment values has been changed successfully by ".$changedBy." on Date ".$timestamp;
					$this->Merchantnote->save($noteData);
					
					$this->Session->write('popup','Merchant Deployment information has been updated successfully.');			
					$this->Session->setFlash('Merchant Deployment information has been updated successfully.');  
					$this->redirect(array('controller'=>'merchants','action' => "merchantdeployment/".$merchantID."/message:success"));
				}	
				
		}
		
	 }	
	 
	public function superadmin_deletemerchant($merchantID= null,$statusID=null) {
			// delete merchant
			$this->superadmin_delete($merchantID);
			$this->Session->write('popup','Merchant has been deleted successfully.');			
			$this->Session->setFlash('Merchant has been deleted successfully.');  
			$this->redirect(array('controller'=>'merchants','action'=>"viewbystatus/".$statusID."/message:success"));	
				
	}

	public function superadmin_delete($merchantID= null) {
			//$this->autoRender = false;
			$this->loadModel('Merchantprocessordoclink');
			// Delete all document
			$Docs = $this->Merchantprocessordoclink->find('all',array('conditions'=>array('Merchantprocessordoclink.merchantID'=>$merchantID)));
			if(count($Docs)){
				foreach($Docs as $key =>$docsArr){
					$deletefile = WWW_ROOT."files/MerchantDocument/".$docsArr['Merchantprocessordoclink']['docName'];
					@unlink($deletefile);
					$isOk = $this->Merchantprocessordoclink->delete($docsArr['Merchantprocessordoclink']['id']);
				}
			}
			// Delete Application Documents
			$appPDF = WWW_ROOT."files/MerchantDocument/Merchant-".$merchantID.".pdf";
			if(file_exists($appPDF)){
				@unlink($appPDF);
			}
			// Delete Signature
			$Signature = $this->Merchant->find('first',array('fields'=>array('merchantSign'),'conditions'=>array('Merchant.id'=>$merchantID)));
			$signImg = WWW_ROOT."files/Signature/".$Signature['Merchant']['merchantSign'];
			if(file_exists($signImg)){
				@unlink($signImg);
			}
			//Delete its notes
			$this->loadModel('Merchantnote');
			$this->Merchantnote->deleteAll(array('Merchantnote.merchantID' =>$merchantID));
			//Delete its Owners
			$this->loadModel('Owner');
			$this->Owner->deleteAll(array('Owner.merchantID' =>$merchantID));
			//Delete its rates
			$this->loadModel('Rate');
			$this->Rate->deleteAll(array('Rate.merchantID' =>$merchantID));
			//Delete its Transaction
			$this->loadModel('Merchanttransaction');
			$this->Merchanttransaction->deleteAll(array('Merchanttransaction.merchantID' =>$merchantID));
			//Delete its deployment
			$this->loadModel('Deployment');
			$this->Deployment->deleteAll(array('Deployment.merchantID' =>$merchantID));
			//Delete its printers
			$this->loadModel('Printer');
			$this->Printer->deleteAll(array('Printer.merchantID' =>$merchantID));
			//Delete its terminalsoftgateway
			$this->loadModel('Terminalsoftgateway');
			$this->Terminalsoftgateway->deleteAll(array('Terminalsoftgateway.merchantID' =>$merchantID));
			//Delete its checkreaders
			$this->loadModel('Checkreader');
			$this->Checkreader->deleteAll(array('Checkreader.merchantID' =>$merchantID));
			//Delete its checkreaders
			$this->loadModel('Appointment');
			$this->Appointment->deleteAll(array('Appointment.merchantID' =>$merchantID));
			//Delete its commission
			$this->loadModel('Commission');
			$this->Commission->deleteAll(array('Commission.merchantID' =>$merchantID));
			//Delete its commission logs
			$this->loadModel('Commissionlog');
			$this->Commissionlog->deleteAll(array('Commissionlog.merchantID' =>$merchantID));
			//Delete its Contacts
			$this->loadModel('Contact');
			$this->Contact->deleteAll(array('Contact.merchantID' =>$merchantID));
			//Delete its underwriting
			$this->loadModel('Underwriting');
			$this->Underwriting->deleteAll(array('Underwriting.merchantID' =>$merchantID));
			
			$this->Merchant->delete($merchantID);
				
	}
	
	public function superadmin_deleteNote($merchantNoteID= null,$merchantID=null) {
		$this->loadModel('Merchantnote');
		if($this->Merchantnote->delete($merchantNoteID))
		{
			$this->Session->write('popup','Merchant note has been deleted successfully.');			
			$this->Session->setFlash('Merchant note has been deleted successfully.');  
			//$this->redirect(array('controller'=>'merchants','action' => "edit/".$merchantID."/message:success"));	
			
			
	
			$referer=str_replace('message:success','',$this->referer());
			$referer=str_replace('/message:success','',$referer);
			$this->redirect($referer."/message:success");	
		}
	}
	
	public function superadmin_terminalsoftwaredelete($ID =null,$merchantID=null) {
		$this->loadModel('Terminalsoftgateway');
		if($this->Terminalsoftgateway->delete($ID))
		{
			$this->redirect(array('controller'=>'merchants','action' => "merchantdeployment/".$merchantID."/message:success"));
		}
	}
	
	public function superadmin_printerdelete($ID =null,$merchantID=null) {
		$this->loadModel('Printer');
		if($this->Printer->delete($ID))
		{
			$this->redirect(array('controller'=>'merchants','action' => "merchantdeployment/".$merchantID."/message:success"));
		}
	}
	
	public function superadmin_checkreaderdelete($ID =null,$merchantID=null) {
		$this->loadModel('Checkreader');
		if($this->Checkreader->delete($ID))
		{
			$this->redirect(array('controller'=>'merchants','action' => "merchantdeployment/".$merchantID."/message:success"));
		}
	}
	
	public function beforeFilter(){
		$this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));
		parent::beforeFilter();
		$this->UserAuth->autoRedirect = true;
   }
   
    public function superadmin_appointments($merchantID= null) {
			$errorsArr ='';	
			$this->set('id',$merchantID);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
			$this->set('status',$Status_list);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			// ===== Find Referal Type User List ===============
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
			// ============= end ==========
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			$this->loadModel('Appointment');
			$merchantAppointment =  $this->Appointment->find("all", array("order" => array("Appointment.appointmentFrom ASC"), "conditions" => array("Appointment.merchantID" => $merchantID)));	
			
					
			$this->set('merchantAppointment',$merchantAppointment);							
			
			if ($this->request->is('get')) {
				$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
				if($this->request->data===FALSE){
						$this->Session->write('popup','Merchant not exist.');			
						$this->Session->setFlash('Merchant not exist.');
						$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
				}
				$stausID = $this->request->data['Merchant']['statusID'];
				$this->set('stausID',$stausID);
			} else {				
				if($this->request->data['Submit']=='Add Note'){			
						$this->Merchantnote->set($this->request->data);
						$merchantID = $this->request->data['Merchantnote']['merchantID'];
						$timestamp = CURRENTDATE;
						$this->request->data['Merchantnote']['timeStamp'] = $timestamp;
						if(!$this->Merchantnote->validates()) 
						{
							$errorsArr = $this->Merchantnote->validationErrors;	
							pr($errorsArr);
						}
						if($errorsArr) 
						{
							$this->set('errors',$errorsArr);
							$this->set('data',$this->request->data);
							$this->redirect(array('controller'=>'merchants','action' => "merchantnotes/".$merchantID));
						}
						else {	
								
							if($this->Merchantnote->save($this->request->data)) {
								$this->Session->write('popup','Merchant Notes has been added successfully.');			
								$this->Session->setFlash('Merchant Notes has been added successfully.');  
								$this->redirect(array('controller'=>'merchants','action' => "merchantnotes/".$merchantID."/message:success"));
							}	
							else {
								$this->Session->setFlash('Data save problem, Please try again.');  
							}	
						}//end if not error
					}
			}
	 }	
	 
    public function superadmin_moreinfo($merchantID	 = null) {
			$errorsArr ='';	
			$errorsArr1 ='';
			$this->set('id',$merchantID);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
			$this->set('status',$Status_list);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			// ===== Find Referal Type User List ===============
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
			// ============= end ==========
			$this->loadModel('Owner');
			$this->loadModel('MerchantSiteSurvey');

			if ($this->request->is('get')) {
				$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
				if($this->request->data===FALSE){
						$this->Session->write('popup','Merchant not exist.');			
						$this->Session->setFlash('Merchant not exist.');
						$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
				}
				$OwnerData = $this->Owner->find('first',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
				if($OwnerData){				
					$OwnerData = $this->Owner->find('all',array('conditions'=>array('Owner.merchantID'=>$merchantID)));
					$this->set('OwnerData',$OwnerData);
				}
				
				$MerchantSiteSurveyData = $this->MerchantSiteSurvey->find('first',array('conditions'=>array('MerchantSiteSurvey.merchantID'=>$merchantID)));
				if($MerchantSiteSurveyData){
					$this->request->data['MerchantSiteSurvey'] = $MerchantSiteSurveyData['MerchantSiteSurvey'];
				}
								
				$selected_months = explode(",",$this->request->data['Merchant']['monthNames']);
				$selected_adsmethod = explode(",",$this->request->data['Merchant']['advertiseMethod']);
				$stausID = $this->request->data['Merchant']['statusID'];
				$this->set('selected_months',$selected_months);
				$this->set('selected_adsmethod',$selected_adsmethod);
				$this->set('stausID',$stausID);
				
			} else {				
						$merchantID = $this->request->data['Merchant']['id'];
						//pr($this->request->data);
						$this->Merchant->set($this->request->data);
						if(!$this->Merchant->validates()) 
						{
							$errorsArr = $this->Merchant->validationErrors;	
						}
						if($errorsArr) 
						{
							$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
							$this->set('errors',$errorsArr);
							$this->set('data',$this->request->data);
							$this->set('id',$merchantID);					
							$this->set('merchantType',$this->request->data['Merchant']['merchantType']);
							$this->set('stausID',$this->request->data['Merchant']['statusID']);
							$this->set('selected_months',$this->request->data['Merchant']['monthNames']);
							$this->set('selected_adsmethod',$this->request->data['Merchant']['advertiseMethod']);
						}
						$this->Owner->set($this->request->data);
						if(!$this->Owner->validates()) 
						{
							$errorsArr1 = $this->Owner->validationErrors;	
						}
						if($errorsArr1) 
						{
							$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
							$this->set('errors',$errorsArr1);
							$this->set('data',$this->request->data);
							$this->set('id',$merchantID);					
							$this->set('merchantType',$this->request->data['Merchant']['merchantType']);
							$this->set('stausID',$this->request->data['Merchant']['statusID']);
							$this->set('selected_months',$this->request->data['Merchant']['monthNames']);
							$this->set('selected_adsmethod',$this->request->data['Merchant']['advertiseMethod']);
						}
						if(!$errorsArr1 && !$errorsArr)	
						{
							
							if(is_array($this->request->data['Merchant']['monthNames'])){
								$this->request->data['Merchant']['monthNames'] = implode(",",$this->request->data['Merchant']['monthNames']);
							}
							if(is_array($this->request->data['Merchant']['advertiseMethod'])){
								$this->request->data['Merchant']['advertiseMethod'] = implode(",",$this->request->data['Merchant']['advertiseMethod']);
							}
							//pr($this->request->data);die;
							// insert data in terminal soft
							$ownerCount = $this->request->data['Owner']['count'];
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
								$this->Owner->save($this->request->data);
							}
							
							// Save merchant site survey information
							foreach ($this->request->data['MerchantSiteSurvey'] as $key => $value){							
								if(is_array($value)){
									$this->request->data['MerchantSiteSurvey'][$key] = $value[0];
								}
							}
							$this->request->data['MerchantSiteSurvey']['merchantID'] = $merchantID;			
							$this->MerchantSiteSurvey->deleteAll(array('MerchantSiteSurvey.merchantID' => $merchantID), false);			
							//pr($this->request->data);die;								
							$this->MerchantSiteSurvey->save($this->request->data);
							
							if($this->Merchant->save($this->request->data)) {
								// Add Note
								$this->loadModel('Merchantnote');
								$noteData = array();
								$changedBy = $this->Session->read('UserAuth.User.user_Name');
								$noteData['Merchantnote']['merchantID'] = $merchantID;
								$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
								$timestamp = CURRENTDATE;
								$noteData['Merchantnote']['timeStamp'] = $timestamp;
								$noteData['Merchantnote']['note'] = "Additional inforamtion of this merchant has been added by ".$changedBy." on Date ".$timestamp;
								$this->Merchantnote->save($noteData);
					
								$this->Session->write('popup','Merchant Profile has been updated successfully.');			
								$this->Session->setFlash('Merchant Profile has been updated successfully.');  
								$this->redirect(array('controller'=>'merchants','action' => "moreinfo/".$merchantID."/message:success"));
							}	
							else {
								$this->Session->setFlash('Data save problem, Please try again.');  
							}
						}	
			}
	 }	
	 
    public function superadmin_ownerdelete($ID =null,$merchantID=null) {
		$this->loadModel('Owner');
		if($this->Owner->delete($ID))
		{
			$this->redirect(array('controller'=>'merchants','action' => "moreinfo/".$merchantID."/message:success"));
		}
	}
   
    public function superadmin_view($merchantID = null) {
			$errorsArr ='';	
			$this->set('id',$merchantID);
			
			$this->loadModel('Status');
			$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.id ASC")));
			$this->set('status',$Status_list);
			
			$this->loadModel('Usercat');
			$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
			$this->set('uc_list',$uc_list);
			
			$this->loadModel('Accounttype');
			$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
			$this->set('ac_list',$ac_list);
			
			$this->loadModel('Accountcat');
			$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
			$this->set('acat_list',$acat_list);
			
			$this->loadModel('BusinessCategory');
			$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
			$this->set('busi_cat_id',$busi_cat_id);
			
			$this->loadModel('Gateway');
			$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
			$this->set('gatwayList',$gatwayList);
			
			$this->loadModel('User');
			$agentList =$this->Common->getAgentList(1);
			$this->set('agentList',$agentList);
			
			$procList =$this->Common->getProcessorList(1);
			$this->set('procList',$procList);
			
			$mangList = $this->Common->getManagerList(1);
			$this->set('mangList',$mangList);
			
			$isoList = $this->Common->getIsoList(1);
			$this->set('isoList',$isoList);	
			
			$referalList =$this->Common->getReferalList(1);
			$this->set('referalList',$referalList);
				
			$this->loadModel('Merchantnote');
			if(strtolower($this->Session->read('UserAuth.UserGroup.name'))=='admin'){
				$merchnatNotes =  $this->Merchantnote->find("all", array("order" => array("Merchantnote.merchantNoteID DESC"), "conditions" => array("Merchantnote.merchantID" => $merchantID)));
			}else{
				$noteview = strtolower($this->Session->read('UserAuth.UserGroup.name')).'View'; 
				if(strtolower($this->Session->read('UserAuth.UserGroup.name'))=="referral"){
					$noteview = "referalView";
				}
				$merchnatNotes =  $this->Merchantnote->find("all", array("order" => array("Merchantnote.merchantNoteID DESC"), "conditions" => array("Merchantnote.merchantID" => $merchantID,$noteview=>1)));
			}
			$this->set('merchnatNotes',$merchnatNotes);	
			
			
			
			// Request With GET Parameter
			if ($this->request->is('get')) {
                                $loginRole = $this->Session->read('UserAuth.UserGroup.name');
				$marchant=$this->request->data = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
                                if((strtolower($loginRole)=='referal' || strtolower($loginRole)=='referral') && $marchant['Merchant']['referalID'] != $this->Session->read('UserAuth.User.id')){
                                    $this->redirect('/superadmin/dashboard');
                                }
				if($this->request->data===FALSE){
					$this->Session->write('popup','Merchant not exist.');			
					$this->Session->setFlash('Merchant not exist.');
					$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
				}
				//pr($marchant);die;
				$this->set('marchant',$marchant);
				$stausID = $this->request->data['Merchant']['statusID'];
				$this->set('stausID',$stausID);							
				$processorID = $this->request->data['Merchant']['processorID'];
				if(isset($processorID)){
					$processorDoc = $this->Common->getProcessorDoc($processorID);
					$this->set('countDoc',count($processorDoc));
					$this->set('processorDoc',$processorDoc);
				}
			} 
			
			if($this->request->data['Submit']=='Add Note'){			
						$this->Merchantnote->set($this->request->data);
						$merchantID = $this->request->data['Merchantnote']['merchantID'];
						//$timestamp = date("n/j/Y g:i:s A");
						$date = new DateTime("@".time());
						//$date->setTimezone(new DateTimeZone('CDT'));  
						$date->setTimezone(new DateTimeZone('PST'));
						$timestamp = $date->format('n/j/Y g:i:s A');  // Pacific time
						$this->request->data['Merchantnote']['timeStamp'] = $timestamp;
						if(!$this->Merchantnote->validates()) 
						{
							$errorsArr = $this->Merchantnote->validationErrors;	
						}
						if($errorsArr) 
						{
							$this->set('errors',$errorsArr);
							$this->set('data',$this->request->data);
							$this->redirect(array('controller'=>'merchants','action' => "merchantnotes/".$merchantID));
						}
						else {	
								$email = new CakeEmail("smtp");
								$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
								$subject = "Note has been successfully added to your Merchant";
								$bodyText = "The Note is as following : <br>".$this->request->data['Merchantnote']['note'];
								$email->emailFormat('html');
								$email->subject(strip_tags($subject));
							if($this->Merchantnote->save($this->request->data)) {
								//send to agent
								/*$sendtoagent = trim($this->request->data['Merchantnote']['agentEmail']);
								if($this->request->data['Merchantnote']['agentView']=='1' && $sendtoagent!=''){
									$email->to($sendtoagent);
									$email->send($bodyText);
								}
								//send to processor
								$sendtopro = trim($this->request->data['Merchantnote']['proEmail']);
								if($this->request->data['Merchantnote']['processorView']=='1' && $sendtopro!=''){
									$email->to($sendtopro);
									$email->send($bodyText);
								}
								//send to manager
								$sendtoman = trim($this->request->data['Merchantnote']['managerEmail']);
								if($this->request->data['Merchantnote']['managerView']=='1' && $sendtoman!=''){
									$email->to($sendtoman);
									$email->send($bodyText);
								}
								//send to ISO
								$sendtoiso = trim($this->request->data['Merchantnote']['isoEmail']);
								if($this->request->data['Merchantnote']['isoView']=='1' && $sendtoiso!=''){
									$email->to($sendtoiso);
									$email->send($bodyText);
								}*/

								/*$this->Session->write('popup','Merchant Notes has been added successfully.');			
								$this->Session->setFlash('Merchant Notes has been added successfully.'); */ 
								
								$this->Session->write('popup','Merchant Notes has been added successfully.');			
								$this->redirect(array('controller'=>'merchants','action' => "view/".$merchantID."//message:success"));
							}	
							else {
								$this->Session->setFlash('Data save problem, Please try again.');  
							}	
						}//end if not error
					}
			
			
	}
	
    public function superadmin_docsdelete($docID =null,$merchantID=null) {
		$this->loadModel('Merchantprocessordoclink');
		// Delete old document start here
		$ifExit = $this->Merchantprocessordoclink->find('first',array('conditions'=>array('Merchantprocessordoclink.docID'=>$docID, 'Merchantprocessordoclink.merchantID'=>$merchantID)));
		if($ifExit!==FALSE){
			$isOk = $this->Merchantprocessordoclink->delete($ifExit['Merchantprocessordoclink']['id']);
			$deletefile = WWW_ROOT."files/MerchantDocument/".$ifExit['Merchantprocessordoclink']['docName'];
			@unlink($deletefile);
			$this->redirect(array('controller'=>'merchants','action' => "merchantdoc/".$merchantID));
		}
		
	}
	
	public function superadmin_isolist($userID = null)
	{
			$this->layout = 'ajax';
			$this->loadModel('User');
			
			$this->set('userID',$userID);			
			// Get iso of this agent
			$agentISO = $this->User->find('first',array('fields'=>'idIso','conditions'=>array('User.id'=>$userID)));
			$this->set('isoID',$agentISO['User']['idIso']);
			
	}
	
	public function superadmin_referrallist($userID = null)
	{
		$this->layout = 'ajax';
		$this->loadModel('User');
			
		$this->set('userID',$userID);
		// Get iso of this user
		$referralUser = $this->User->find('first',array('fields'=>'idReferal','conditions'=>array('User.id'=>$userID)));
		$this->set('referralID',$referralUser['User']['idReferal']);
			
	}
	
	public function superadmin_merchantcommission($merchantID	 = null) {
		$errorsArr ='';
			
		$this->set('id',$merchantID);
			
		$this->loadModel('Status');
		$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
		$this->set('status',$Status_list);
		
		$this->loadModel('Usercat');
		$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
		$this->set('uc_list',$uc_list);
			
		$this->loadModel('Accounttype');
		$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		$this->set('ac_list',$ac_list);
			
		$this->loadModel('Accountcat');
		$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
		$this->set('acat_list',$acat_list);
			
		$this->loadModel('BusinessCategory');
		$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
		$this->set('busi_cat_id',$busi_cat_id);
			
		$this->loadModel('User');
		$agentList =$this->Common->getAgentList(1);
		$this->set('agentList',$agentList);
			
		$procList =$this->Common->getProcessorList(1);
		$this->set('procList',$procList);
			
		// ===== Find Referal Type User List ===============
		$referalList =$this->Common->getReferalList(1);
		$this->set('referalList',$referalList);
		// ============= end ==========
			
		$mangList = $this->Common->getManagerList(1);
		$this->set('mangList',$mangList);
			
		$isoList = $this->Common->getIsoList(1);
		$this->set('isoList',$isoList);
			
		$this->loadModel('Gateway');
		$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
		$this->set('gatwayList',$gatwayList);
			
		$this->loadModel('Commission');
			
		$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
	
		if($MerchantData===FALSE){
			$this->Session->write('popup','Merchant not exist.');
			$this->Session->setFlash('Merchant not exist.');
			$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
		}
			
		if ($this->request->is('get')) {
			$condition = "Commission.merchantID = ".$merchantID." AND Commission.MID='".$MerchantData['Merchant']['CID']."'";
			$commissionData = $this->Commission->find('first',array('fields'=>array('Merchant.*'),'conditions'=>$condition));
			if(is_array($commissionData)){
				$this->request->data = array_merge($MerchantData, $commissionData);
			}else{
				$this->request->data = $MerchantData;
			}
			
					//====================== Pushkar ===================
			$agentRec=$this->User->find('first',array('fields'=>'User.agent_split,User.referral_split,User.iso_split',
									'conditions'=>'User.id="'.$this->request->data['Merchant']['agentID'].'" ','recursive'=>-1));
											
				
			/* $refRec=$this->User->find('first',array('fields'=>'User.referral_split',
									'conditions'=>'User.id="'.$this->request->data['Merchant']['referalID'].'"','recursive'=>-1)); */
													
													
			if(!is_array($commissionData)){
				$this->request->data['Commission']['agent_split']		=	($agentRec['User']['agent_split']>0) ? $agentRec['User']['agent_split'] : "";
				$this->request->data['Commission']['referral_split']	=	($agentRec['User']['referral_split']>0) ? $agentRec['User']['referral_split'] : "";
				$this->request->data['Commission']['iso_split']			=	($agentRec['User']['iso_split']>0) ? $agentRec['User']['iso_split'] : "";
			}
			//====================== End Pushkar =================== 
			
			
			$this->set('ID','');
			$stausID = $this->request->data['Merchant']['statusID'];
			$this->set('stausID',$stausID);
		} else {
	
			/*if(!$this->Merchanttransaction->validates())
				{
			$errorsArr = $this->Merchanttransaction->validationErrors;
			}
			if($errorsArr)
			{
			$this->set('errors',$errorsArr);
			$this->set('data',$this->request->data);
			}else{*/
			$updateBy = $this->Session->read('UserAuth.User.id');
			$updatedate = date("Y-m-d");
			$this->Commission->set($this->request->data);
			$stausID = $this->request->data['Commission']['statusID'];
			$this->request->data['Commission']['merchantID'] = $merchantID;
			$this->request->data['Commission']['MID'] = $MerchantData['Merchant']['CID'];
			$this->request->data['Commission']['lastUpdatedBy'] = $updateBy;	
			$this->request->data['Commission']['lastUpdatedDate'] = $updatedate;
	
			if($this->Commission->save($this->request->data)) {
				//add merchant notes when change in rate
				$this->loadModel('Merchantnote');
				$noteData = array();
				$changedBy = $this->Session->read('UserAuth.User.user_Name');
				$noteData['Merchantnote']['merchantID'] = $merchantID;
				$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
				$timestamp = CURRENTDATE;
				$noteData['Merchantnote']['timeStamp'] = $timestamp;
				$noteData['Merchantnote']['note'] = "Your commission rates has been successfully added by ".$changedBy." on Date ".$timestamp;
				$this->Merchantnote->save($noteData);
	
				$this->Session->write('popup','Commission rates has been added successfully.');
				$this->Session->setFlash('Commission rates has been added successfully.');
				$this->redirect(array('controller'=>'merchants','action' => "merchantcommission/".$merchantID."/message:success"));
			}
			/*}*/
	
		}
	
	}
	
	public function superadmin_underwriting($merchantID	 = null) {
		$errorsArr ='';
			
		$this->set('id',$merchantID);
			
		$this->loadModel('Status');
		$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
		$this->set('status',$Status_list);
		
		$this->loadModel('Usercat');
		$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
		$this->set('uc_list',$uc_list);
			
		$this->loadModel('Accounttype');
		$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		$this->set('ac_list',$ac_list);
			
		$this->loadModel('Accountcat');
		$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
		$this->set('acat_list',$acat_list);
			
		$this->loadModel('BusinessCategory');
		$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
		$this->set('busi_cat_id',$busi_cat_id);
			
		$this->loadModel('User');
		$agentList =$this->Common->getAgentList(1);
		$this->set('agentList',$agentList);
			
		$procList =$this->Common->getProcessorList(1);
		$this->set('procList',$procList);
			
		// ===== Find Referal Type User List ===============
		$referalList =$this->Common->getReferalList(1);
		$this->set('referalList',$referalList);
		// ============= end ==========
			
		$mangList = $this->Common->getManagerList(1);
		$this->set('mangList',$mangList);
			
		$isoList = $this->Common->getIsoList(1);
		$this->set('isoList',$isoList);
			
		$this->loadModel('Gateway');
		$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
		$this->set('gatwayList',$gatwayList);
			
		$this->loadModel('Merchant');
			
		$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
	
		if($MerchantData===FALSE){
			$this->Session->write('popup','Merchant not exist.');
			$this->Session->setFlash('Merchant not exist.');
			$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
		}
		$this->loadModel('Underwriting');
			
		if ($this->request->is('get')) {
			$UnderwritingData = $this->Underwriting->find('first',array('conditions'=>array('Underwriting.merchantID'=>$merchantID)));
			if($UnderwritingData){
				$this->request->data = array_merge($MerchantData, $UnderwritingData);
				$this->set('ID',$this->request->data['Underwriting']['id']);
			}else{
				$this->request->data = $MerchantData;
				$this->request->data['Underwriting']['merchantName'] = $MerchantData['Merchant']['merchantName'];
				$this->request->data['Underwriting']['dateinfo']  	 = date('m-d-Y');
				$this->request->data['Underwriting']['url'] 		 = $MerchantData['Merchant']['merchantURL'];
				$this->request->data['Underwriting']['doneby'] 		 = $this->Session->read('UserAuth.User.id');;
				$this->set('ID','');
			}			
			
			//$this->request->data['CheckList']['option'] = $MerchantData['Merchant']['checklist_value'];
			
			$stausID = $this->request->data['Merchant']['statusID'];
			$this->set('stausID',$stausID);
			/***** get the list of all duplicate merchant *********/
			$this->Merchant->recursive=-1;
			$duplicateCondition = "Merchant.id!=".$merchantID." AND Merchant.contactPhone='".$MerchantData['Merchant']['contactPhone']."'";
			/*$duplicateMerchantCount = $this->Merchant->find('count',array('conditions' => array($duplicateCondition)));
				$this->paginate = array(
						'limit' => 1,
						'fields' => array('id','merchantName','contactPhone'),
						'order' => array(
								'Merchant.merchantName' => 'asc',
						),
						'conditions' => array($duplicateCondition),
						'paramType' => 'querystring'
				);
			$MerchantDuplicateRecord = $this->paginate();*/
			$MerchantDuplicateRecord = $this->Merchant->find('all',array('fields'=>array('id','merchantName','contactPhone'),'conditions' => array($duplicateCondition),'order' => array('merchantName asc')));
			$this->set('duplicateMerchant',$MerchantDuplicateRecord);
				
	} else {
		$updateBy = $this->Session->read('UserAuth.User.id');
		$updatedate = date("Y-m-d H:i:s");
		$statusID = $MerchantData['Merchant']['statusID'];
		
		if($this->request->data['Submit']=='UPDATE'){
			
			foreach ($this->request->data['Underwriting'] as $key => $value){							
				if(is_array($value)){
					$this->request->data['Underwriting'][$key] = $value[0];
				}
			}
			$this->request->data['Underwriting']['merchantID'] = $merchantID;
			$updateBy = $this->Session->read('UserAuth.User.id');
			$updatedate = date("Y-m-d H:i:s");
			$this->request->data['Underwriting']['lastUpdatedBy'] = $updateBy;
			$this->request->data['Underwriting']['lastUpdatedDate'] = $updatedate;				
			$this->Underwriting->deleteAll(array('Underwriting.merchantID' => $merchantID), false);			
			//pr($this->request->data);	
			if($this->Underwriting->save($this->request->data)) {			
				$this->Session->write('popup','Values has been updated successfully.');
				$this->Session->setFlash('Values has been updated successfully.');
				$this->redirect(array('controller'=>'merchants','action' => "underwriting/".$merchantID."/message:success"));
			}
			
		}

		if($this->request->data['Submit']=='APPROVE'){
			if($this->request->data['Merchant']['checklist_value']=='PASS'){
					$integrationDate = date("Y-m-d");
					$data = array('Merchant' => array('id'=>$merchantID,'checklist_value'=>$this->request->data['Merchant']['checklist_value'],'statusID'=>9,'integrationDate'=>$integrationDate));
					$this->Merchant->save( $data, false, array('checklist_value','statusID','integrationDate'));
							// Add status update in merchant pipeline
					$this->loadModel('Merchantpipeline');
					$pipelineData = array();
					$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
					$pipelineData['Merchantpipeline']['statusFrom'] = $statusID;
					$pipelineData['Merchantpipeline']['statusTo'] = 9;
					$pipelineData['Merchantpipeline']['statusToDate'] = $integrationDate;
					$this->Merchantpipeline->save($pipelineData);
					//add merchant notes when change in status
					$this->loadModel('Merchantnote');
					$noteData = array();
					$changedBy = $this->Session->read('UserAuth.User.user_Name');
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = "Merchant Checklist value updated to \"PASS\" and Status has been changed from ".$this->Common->getStatusName($statusID)." To Integration by ".$changedBy." on Date ".$timestamp;
					$this->Merchantnote->save($noteData);
			}else{
				$data = array('Merchant' => array('id'=>$merchantID,'checklist_value'=>$this->request->data['Merchant']['checklist_value']));
				$this->Merchant->save( $data, false, array('checklist_value'));
			}
			$this->Session->write('popup','Checklist updated successfully.');
			$this->Session->setFlash('Checklist updated successfully.');
			$this->redirect(array('controller'=>'merchants','action' => "underwriting/".$merchantID."/message:success"));
		}
		
	}
	
	}
	
	function beforeRender() {
		parent::beforeRender();
		
		if (!empty($this->data['Merchant']['volume'])) {
			$volumeString = $this->merchantVolumeBeforeRender($this->request->data['Merchant']['volume']);
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
	
	/** function for showing merchant commmision processing history **/
	public function superadmin_processinghistory($merchantID = null) {
		$errorsArr ='';
		// check user is super admin or not , if yes allow otherwise not.
		$allow = $this->Session->read('UserAuth.User.is_super_admin');
		if(!$allow){
			$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
			die;
		}
		
		$this->set('id',$merchantID);
			
		$this->loadModel('Status');
		$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
		$this->set('status',$Status_list);
		
		$this->loadModel('Usercat');
		$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
		$this->set('uc_list',$uc_list);
			
		$this->loadModel('Accounttype');
		$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		$this->set('ac_list',$ac_list);
			
		$this->loadModel('Accountcat');
		$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
		$this->set('acat_list',$acat_list);
			
		$this->loadModel('BusinessCategory');
		$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
		$this->set('busi_cat_id',$busi_cat_id);
			
		$this->loadModel('User');
		$agentList =$this->Common->getAgentList(1);
		$this->set('agentList',$agentList);
			
		$procList =$this->Common->getProcessorList(1);
		$this->set('procList',$procList);
			
		// ===== Find Referal Type User List ===============
		$referalList =$this->Common->getReferalList(1);
		$this->set('referalList',$referalList);
		// ============= end ==========
			
		$mangList = $this->Common->getManagerList(1);
		$this->set('mangList',$mangList);
			
		$isoList = $this->Common->getIsoList(1);
		$this->set('isoList',$isoList);
			
		$this->loadModel('Gateway');
		$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
		$this->set('gatwayList',$gatwayList);
			
		$this->loadModel('Merchant');
			
		$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
	
		if($MerchantData===FALSE){
			$this->Session->write('popup','Merchant not exist.');
			$this->Session->setFlash('Merchant not exist.');
			$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
		}
			
		if ($this->request->is('get')) {
			$this->request->data = $MerchantData;			
			$this->set('ID','');
			$stausID = $this->request->data['Merchant']['statusID'];
			$this->set('stausID',$stausID);
			/***** get the list of commission history *********/
			/********extract chrgeback numbers as well: Rohit: 26-12-2013: start*****/
			$this->loadModel('Commissionlog');
			$log = $this->Commissionlog->find("all",array('conditions'=>array('Commissionlog.merchantID'=>$merchantID),'order'=>array('Commissionlog.date DESC'),'group' => array('Commissionlog.MID','Commissionlog.amount_processed','Commissionlog.gross_revenue','Commissionlog.totalapps_income','Commissionlog.chargebacks_numbers','Commissionlog.date')));
			/********extract chrgeback numbers as well: Rohit: 26-12-2013: end*****/
			//$log = $this->Commissionlog->find("all",array('conditions'=>array('Commissionlog.merchantID'=>$merchantID),'order'=>array('Commissionlog.date DESC')));
			$this->set('commissionLog',$log);
	
		} else {
			$updateBy = $this->Session->read('UserAuth.User.id');
			$updatedate = date("Y-m-d H:i:s");
			$statusID = $MerchantData['Merchant']['statusID'];
			//pr($this->request->data);die;
				
			if($this->request->data['Merchant']['checklist_value']=='PASS'){
				$integrationDate = date("Y-m-d");
				$data = array('Merchant' => array('id'=>$merchantID,'checklist_value'=>$this->request->data['Merchant']['checklist_value'],'statusID'=>9,'integrationDate'=>$integrationDate));
				$this->Merchant->save( $data, false, array('checklist_value','statusID','integrationDate'));
				// Add status update in merchant pipeline
				$this->loadModel('Merchantpipeline');
				$pipelineData = array();
				$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
				$pipelineData['Merchantpipeline']['statusFrom'] = $statusID;
				$pipelineData['Merchantpipeline']['statusTo'] = 9;
				$pipelineData['Merchantpipeline']['statusToDate'] = $integrationDate;
				$this->Merchantpipeline->save($pipelineData);
				//add merchant notes when change in status
				$this->loadModel('Merchantnote');
				$noteData = array();
				$changedBy = $this->Session->read('UserAuth.User.user_Name');
				$noteData['Merchantnote']['merchantID'] = $merchantID;
				$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
				$timestamp = CURRENTDATE;
				$noteData['Merchantnote']['timeStamp'] = $timestamp;
				$noteData['Merchantnote']['note'] = "Merchant Checklist value updated to \"PASS\" and Status has been changed from ".$this->Common->getStatusName($statusID)." To Integration by ".$changedBy." on Date ".$timestamp;
				$this->Merchantnote->save($noteData);
			}else{
				$data = array('Merchant' => array('id'=>$merchantID,'checklist_value'=>$this->request->data['Merchant']['checklist_value']));
				$this->Merchant->save( $data, false, array('checklist_value'));
			}
	
			$this->Session->write('popup','Checklist updated successfully.');
			$this->Session->setFlash('Checklist updated successfully.');
			$this->redirect(array('controller'=>'merchants','action' => "underwriting/".$merchantID."/message:success"));
		}
	
	}
	
    public function superadmin_contact($merchantID = null){
    	$errorsArr ='';
    		
    	$this->set('id',$merchantID);
    		
    	$this->loadModel('Status');
    	$Status_list =  $this->Status->find("list", array("fields" => array("id", 'status')));
    	$this->set('status',$Status_list);
    	
    	$this->loadModel('Usercat');
    	$uc_list =  $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
    	$this->set('uc_list',$uc_list);
    		
    	$this->loadModel('Accounttype');
    	$ac_list =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
    	$this->set('ac_list',$ac_list);
    		
    	$this->loadModel('Accountcat');
    	$acat_list =  $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder ASC")));
    	$this->set('acat_list',$acat_list);
    		
    	$this->loadModel('BusinessCategory');
    	$busi_cat_id =  $this->BusinessCategory->find("list", array("fields" => array("id", 'category_name'), "order" => array("BusinessCategory.category_name asc")));
    	$this->set('busi_cat_id',$busi_cat_id);
    		
    	$this->loadModel('User');
    	$agentList =$this->Common->getAgentList(1);
    	$this->set('agentList',$agentList);
    		
    	$procList =$this->Common->getProcessorList(1);
    	$this->set('procList',$procList);
    		
    	// ===== Find Referal Type User List ===============
    	$referalList =$this->Common->getReferalList(1);
    	$this->set('referalList',$referalList);
    	// ============= end ==========
    		
    	$mangList = $this->Common->getManagerList(1);
    	$this->set('mangList',$mangList);
    		
    	$isoList = $this->Common->getIsoList(1);
    	$this->set('isoList',$isoList);
    		
    	$this->loadModel('Gateway');
    	$gatwayList =  $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
    	$this->set('gatwayList',$gatwayList);
    		
    	$this->loadModel('Merchant');
    		
    	$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
    	
    	if($MerchantData===FALSE){
    		$this->Session->write('popup','Merchant not exist.');
    		$this->Session->setFlash('Merchant not exist.');
    		$this->redirect(array('controller'=>'merchants','action' => "viewbystatus/all/message:failure"));
    	}
    	
    	$this->loadModel('Contact');
    	
    	if ($this->request->is('get')) {
    		/***** get the contact detail of this merchant *********/
    		$contactLists = $this->Contact->find("all",array('conditions'=>array('Contact.merchantID'=>$merchantID)));
    		/* echo "<pre>";
    		print_r($contactLists); */
    		if($contactLists){
    			$this->set('contactLists',$contactLists);
    		}
    		
    		$this->request->data = $MerchantData;
    		//$this->request->data['Contact']['merchantID'] = $merchantID;    		
    		$this->set('ID','');
    		$stausID = $this->request->data['Merchant']['statusID'];
    		$this->set('stausID',$stausID);
    		
    	}else{
    		/* echo "<pre>";
    		print_r($this->request->data);die(); */
    		$this->Contact->set($this->request->data);	
	    	if ($this->Contact->validates()) {
			    $this->Contact->save($this->request->data);
			    $this->Session->write('popup','Contact detail saved successfully.');
			    $this->Session->setFlash('Contact detail saved successfully.');
			    $this->redirect(array('controller'=>'merchants','action' => "contact/".$merchantID."/message:success#contact"));
			} else {
			    // didn't validate logic
			    $errorsArr = $this->Contact->validationErrors;
			}
    		
    	}
    }
    
    public function superadmin_getcontactinfo($contactID= null){
    	$this->layout = 'ajax';
    	$currentdate = "";
    	if($this->request->is('get')){
    		$this->loadModel('Contact');
    		$contactDetail = $this->Contact->find("first",array('conditions'=>array('Contact.id'=>$contactID)));
    		$this->set('contactDetail',$contactDetail);
    	}
    } 
    
    public function superadmin_contactdelete($id= null,$merchantID=null){ 
    	$this->loadModel('Contact');
    	if($this->Contact->delete($id))
    	{
    		$this->Session->write('popup','Contact detail has been deleted successfully.');
    		$this->Session->setFlash('Contact detail has been deleted successfully.');
    		$this->redirect(array('controller'=>'merchants','action' => "contact/".$merchantID."/message:success#contact"));   			
    	}    
    }
    
    /* @Vishnu sharma
     * @Used To update merchant expire date Plus 3 years.
    * On 21-05-2013
    */
    public function superadmin_approved_contract_ex_date($merchantId = null){
    	if($merchantId != null){
    		$this->loadModel('Merchant');
    		
    		$datePlusThreeYears = date('Y-m-d',strtotime("+3 years"));
    		$data['Merchant']['id'] = $merchantId;
    		$data['Merchant']['contract_expiration'] = $datePlusThreeYears;
			$data['Merchant']['contract_approval'] = date('Y-m-d');
    		$this->Merchant->save($data,false);
    		
    		//get merchant info
    		/*
    		 * Commented as mentioned in task id 2393 By Jitendra
    		 *  On 12 Nov 2013
    		 * 
    		$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantId)));
    		$statusID = $MerchantData['Merchant']['statusID'];
    		    		
    		$datePlusThreeYears = date('Y-m-d',strtotime("+3 years"));
    		$data['Merchant']['id'] = $merchantId;
    		$data['Merchant']['statusID'] = 4;
    		$data['Merchant']['contract_expiration'] = $datePlusThreeYears;
    		$this->Merchant->save($data,false);
    		// Add status update in merchant pipeline
    		 
    		$approveDate = date("Y-m-d");
    		$this->loadModel('Merchantpipeline');
    		$pipelineData = array();
    		$pipelineData['Merchantpipeline']['merchantID'] 	= 	$merchantId;
    		$pipelineData['Merchantpipeline']['statusFrom'] 	= 	$statusID;
    		$pipelineData['Merchantpipeline']['statusTo'] 		= 	4;
    		$pipelineData['Merchantpipeline']['statusToDate'] 	= 	$approveDate;
    		$this->Merchantpipeline->save($pipelineData); */
    
    		$this->loadModel('Merchantnote');
    		$noteData = array();
    		$changedBy = $this->Session->read('UserAuth.User.user_Name');
    		$noteData['Merchantnote']['merchantID'] = $merchantId;
    		$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
    		$timestamp = CURRENTDATE;
    		$noteData['Merchantnote']['timeStamp'] = $timestamp;
    		$noteData['Merchantnote']['note'] = "Merchant Application is approved! Contract Expiration date is ".date('m/d/Y',strtotime($datePlusThreeYears))." and Contract Approval date is ".date('m/d/Y');
    		$this->Merchantnote->save($noteData);
    
    		$this->Session->write('popup','Contract Approved Successfully.');
    		$this->Session->setFlash('Contract Approved Successfully.');
    		$this->redirect(array('controller'=>'merchants','action' =>"edit/".$merchantId."/message:success"));
    	}
    }
    // End Function here.
    // Save mandatory information (ticket 1894)
    public function superadmin_mandatory_app_field(){
    	//save to owner
    	$this->autoRender = false;
    	 
    	$merchantID = $this->request->data['Merchant']['id'];
    	// insert data in Owner
    	$this->loadModel('Owner');
    	$ownerCount = $this->request->data['Owner']['count'];
		$this->Owner->deleteAll(array('Owner.merchantID' => $merchantID), false);
		for($i=1;$i<=$ownerCount;$i++){
			$this->Owner->create();
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
    	$this->request->data['Merchant']['statusID'] = 3;
		$this->Merchant->save($this->request->data);
		
		// Add status update in merchant pipeline
		$MerchantData = $this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$merchantID)));
		$statusID = $MerchantData['Merchant']['statusID'];
		
		$this->loadModel('Merchantpipeline');
		$pipelineData = array();
		$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
		$pipelineData['Merchantpipeline']['statusFrom'] = $statusID;
		$pipelineData['Merchantpipeline']['statusTo'] = 3;
		$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
		$this->Merchantpipeline->save($pipelineData);
    	 
    	$rate_id = $this->request->data['Merchant']['rate'];
    	$tran_id = $this->request->data['Merchant']['transaction'];
    	// get information of admin rates
    	if($rate_id>0){
	    	$this->loadModel('Rate');
	    	$this->request->data = $this->Rate->find('first',array('conditions'=>array('Rate.id'=>$rate_id)));
	    	unset($this->request->data['Rate']['id']);
	    	unset($this->request->data['Rate']['userType']);
	    	unset($this->request->data['Rate']['adminName']);
	    	$updateBy = $this->Session->read('UserAuth.User.id');
	    	$updatedate = date("Y-m-d H:i:s");
	    	$this->request->data['Rate']['merchantID'] = $merchantID;
	    	$this->request->data['Rate']['lastUpdatedBy'] = $updateBy;
	    	$this->request->data['Rate']['lastUpdatedDate'] = $updatedate;
	    	$this->Rate->set($this->request->data);
	    	$this->Rate->deleteAll(array('Rate.merchantID' => $merchantID), false);
	    	//pr($this->request->data);die;
	    	$this->Rate->save($this->request->data);
    	}
    	// get information of admin transaction
    	if($tran_id>0){
	    	$this->loadModel('Merchanttransaction');
	    	$this->request->data = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.id'=>$tran_id)));
	    	unset($this->request->data['Merchanttransaction']['id']);
	    	unset($this->request->data['Merchanttransaction']['userType']);
	    	unset($this->request->data['Merchanttransaction']['adminName']);
	    	$this->request->data['Merchanttransaction']['merchantID'] = $merchantID;
	    	$updateBy = $this->Session->read('UserAuth.User.id');
	    	$updatedate = date("Y-m-d H:i:s");
	    	$this->request->data['Merchanttransaction']['lastUpdatedBy'] = $updateBy;
	    	$this->request->data['Merchanttransaction']['lastUpdatedDate'] = $updatedate;
	    	$this->Merchanttransaction->deleteAll(array('Merchanttransaction.merchantID' => $merchantID), false);
	    	$this->Rate->set($this->request->data);
	    	//pr($this->request->data);die;
	    	$this->Merchanttransaction->save($this->request->data);
    	}
    	 
    	$this->Session->write('popup','Mandatory fields saved successfully.');
    	$this->Session->setFlash('Mandatory fields saved successfully.');
    	
    	if(strpos($this->referer(),"message:failure")!==false)
    		$redirect = str_replace("message:failure","message:success",$this->referer());
    	elseif(strpos($this->referer(),"message:success")===false)
    		$redirect = $this->referer()."/message:success";
    	else
    		$redirect = $this->referer();
    	
    	$this->redirect($redirect);
    	 
    }
}
?>
