<?php
class ReportsController extends AppController {

	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler','HighCharts.HighCharts');
		var $helpers = array('Html','Text','Paginator','CakeGrid.Grid','Number'); //add some other helpers to controller
		var $uses = array('Usermgmt.UserGroupJoin', 'Merchant','Accounttype', 'Usermgmt.User','Commission','Commissionlog','Merchantpipeline','Businesscat');
		
	 	public function superadmin_allreports(){
	 		
	 	}
		
		public function superadmin_manager(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(7, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
				
			$this->paginate = array(
				'order' => array(
						'User.user_Name' => 'ASC',
				),
				'conditions' => array('UserGroupJoin.user_group_id' => 24, 'User.active' => 1, 'NOT' => array('User.id' => null,'User.user_Name' => 'Universal_mgr')),
				'paramType' => 'querystring'
			);
		
			$activeManagers = $this->paginate('UserGroupJoin');
			foreach($activeManagers as $Managers){
				$ManagersIdList[] = $Managers['User']['id'];
			}
			$this->set('managers', $activeManagers);
			
			$condition = "(Merchant.statusID IN (2,3,4,5,9) ) and (Merchant.managerID IN (".implode(",", $ManagersIdList)."))";
				
			$grandTotal = $this->Merchant->find('first',array('fields' => array('sum(Merchant.volume) as volume'), 'conditions' => array($condition), 'recursive' => -1));
			$this->Merchant->recursive = -1;
			$countTotal = $this->Merchant->find('count',array('fields'=>array('Merchant.id'),'conditions'=>array($condition)));
			
			$this->set('grandTotal', $grandTotal[0]['volume']);
			$this->set('countTotal', $countTotal);
                        
           	$result = $this->Merchant->find('all', array('fields' => array('Merchant.statusID','Merchant.managerID','sum(Merchant.volume) as count'),  'conditions' => array('Merchant.statusID IN (2,3,4,5,9)',  'Merchant.managerID IN ('.implode(",", $ManagersIdList).')'  ),'group'=>'Merchant.managerID, Merchant.statusID', 'recursive' => -1));
            $result = Set::combine($result,"{n}.Merchant.statusID","{n}.0.count","{n}.Merchant.managerID");
            $this->set('result',$result);
                        
            $this->Merchant->recursive = -1;
            $resultVol = $this->Merchant->find('all', array('fields' => array('Merchant.statusID','Merchant.managerID','count(Merchant.id) as count'),  'conditions' => array('Merchant.statusID IN (2,3,4,5,9)',  'Merchant.managerID IN ('.implode(",", $ManagersIdList).')'  ),'group'=>'Merchant.managerID, Merchant.statusID'));
            $resultVol = Set::combine($resultVol,"{n}.Merchant.statusID","{n}.0.count","{n}.Merchant.managerID");
            $this->set('resultVol',$resultVol);
		}
		
		public function superadmin_manageraccount(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(7, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			
			$this->paginate = array(
				'order' => array(
						'User.user_Name' => 'ASC',
				),
				'conditions' => array('UserGroupJoin.user_group_id' => 24, 'User.active' => 1, 'NOT' => array('User.id' => null,'User.user_Name' => 'Universal_mgr')),
				'paramType' => 'querystring'
			);
		
			$activeManagers = $this->paginate('UserGroupJoin');
			foreach($activeManagers as $Managers){
				$ManagersIdList[] = $Managers['User']['id'];
			}
			//print_r($activeManagers);die;
			$this->set('managers', $activeManagers);
			
			$condition = "(Merchant.statusID IN (2,3,4,5,9) ) and (Merchant.managerID IN (".implode(",", $ManagersIdList)."))";
			$grandTotal = $this->Commissionlog->find('first',array('fields' => array('sum(Commissionlog.amount_processed) as volume'), 'conditions' => array($condition)));
			$this->Merchant->recursive = -1;
			$countTotal = $this->Merchant->find('count',array('fields'=>array('Merchant.id'),'conditions'=>array($condition)));
			
			$this->set('grandTotal', $grandTotal[0]['volume']);
			$this->set('countTotal', $countTotal);
			
            $result = $this->Commissionlog->find('all', array('fields' => array('Merchant.statusID','Merchant.managerID','sum(Commissionlog.amount_processed) as count'),  'conditions' => array('Merchant.statusID IN (2,3,4,5,9)',  'Merchant.managerID IN ('.implode(",", $ManagersIdList).')'  ),'group'=>'Merchant.managerID, Merchant.statusID'));
            $result = Set::combine($result,"{n}.Merchant.statusID","{n}.0.count","{n}.Merchant.managerID");
            $this->set('result',$result);

            $this->Merchant->recursive = -1;
            $resultVol = $this->Merchant->find('all', array('fields' => array('Merchant.statusID','Merchant.managerID','count(Merchant.id) as count'),'conditions' => array('Merchant.statusID IN (2,3,4,5,9)',  'Merchant.managerID IN ('.implode(",", $ManagersIdList).')'  ),'group'=>'Merchant.managerID, Merchant.statusID'));
            $resultVol = Set::combine($resultVol,"{n}.Merchant.statusID","{n}.0.count","{n}.Merchant.managerID");
            $this->set('resultVol',$resultVol);            
		}
		
		public function superadmin_processorbyvolumeoramount(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(3, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$activeProcessor	  = $this->UserGroupJoin->find('all', array('fields' => array('User.id','User.user_Name'), 'conditions' => array('UserGroupJoin.user_group_id' => 23, 'User.active' => 1, 'NOT' => array('User.id' => null)),'order'=>array('User.user_Name ASC')));
			$condition = "(Merchant.statusID IN (2,3,4,5,9)) AND (Merchant.setupfeepaid = 0) ";
			foreach($activeProcessor as $processor){
				$processorIds[] =  $processor['User']['id'];
				$processorlist[$processor['User']['id']] = $processor['User']['user_Name'];
			}
			
			$activeProcessorsCount = count($processorIds);
			if($activeProcessorsCount>0){
				$condition .= " AND (Merchant.processorID IN (".implode(",", $processorIds)."))";
			}
			$this->Merchant->recursive = -1;
			$countTotal = $this->Merchant->find('count',array('fields'=>array('Merchant.volume'),'conditions'=>array($condition)));
			
            $result = $this->Merchant->find('all', array('fields' => array('Merchant.statusID','Merchant.processorID','count(Merchant.statusID) as count'),  'conditions' => array('Merchant.statusID IN (2,3,4,5,9)',  'Merchant.processorID IN ('.implode(",", $processorIds).')'  ),'group'=>'Merchant.processorID, Merchant.statusID', 'recursive' => -1));
            $result = Set::combine($result,"{n}.Merchant.statusID","{n}.0.count","{n}.Merchant.processorID");
                        
            $this->set('processors', $activeProcessor);
			$this->set('countTotal', $countTotal);
			$this->set('processorlist',$processorlist);
			$this->set('result',$result);
		}
		
		public function superadmin_processorsetupfees() {
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(10, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$activeProcessors = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array('UserGroupJoin.user_group_id' => 23, 'User.active' => 1, 'NOT' => array('User.id' => null))));
			$inactiveProcessors = $this->UserGroupJoin->find('all', array('fields' => array('User.id'), 'conditions' => array('UserGroupJoin.user_group_id' => 23, 'User.active' => 0, 'NOT' => array('User.id' => null))));
			
			$condition = "(Merchant.statusID = 2 OR Merchant.statusID = 3 OR Merchant.statusID = 4 OR Merchant.statusID = 9 OR Merchant.statusID = 5) AND (setupfeepaid = 0) AND (processorID > 0) ";
			foreach( $inactiveProcessors as $proc){
				$condition .= " AND (processorID != ".$proc['User']['id'].")";
			}
			
			$grandTotal = $this->Merchant->find('first',array('fields' => array('sum(setupfee) as setupfee'), 'conditions' => array($condition)));
			
			/*
			$condition1 = array(
					'AND' => array(
							'OR' => array(
									'Merchant.statusID' => array(2,3,4,5,9)
									),
							'setupfeepaid' => 0,
							
							));
			
			$condition = "(Merchant.statusID = 2 OR Merchant.statusID = 3 OR Merchant.statusID = 4 OR Merchant.statusID = 9 OR Merchant.statusID = 5) AND (setupfeepaid = 0) AND (processorID > 0) ";
			foreach( $inactiveProcessors as $proc){
				$condition .= " AND (processorID != ".$proc['User']['id'].")";
			}
				
			$grandTotal1 = $this->Merchant->find('first',array('fields' => array('sum(setupfee) as setupfee'), 'conditions' => array($condition)));
			
			pr($grandTotal1);
			
			 */
			
			
			$this->set('processors', $activeProcessors);
			$this->set('grandTotal', $grandTotal[0]['setupfee']);
		}
		
		public function superadmin_iso() {
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(3, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}			
			$isos = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array('UserGroupJoin.user_group_id' => 22, 'User.active'=>1, 'NOT' => array('User.id' => null)),'order'=>array('User.user_Name ASC')));
			$this->set('isos', $isos);
			
			$condition = "(Merchant.statusID IN (2,3,4,9,5))";
			
			$isoIds = array();
			foreach($isos as $iso){
                $isoIdList[] = $iso['User']['id'];
				$isoIds[$iso['User']['id']] = $iso['User']['user_Name'];
			}	
			
			$activeIsoCount = count($isoIds);
			if($activeIsoCount>0){
				$condition .= " AND (Merchant.isoID IN (".implode(",", $isoIdList)."))";
			}
			//echo $condition;die;
            $this->Merchant->recursive = -1;
			$countTotal = $this->Merchant->find('count',array('fields'=>array('Merchant.volume'),'conditions'=>array($condition)));				
			$this->set('countTotal', $countTotal);
                        
			// get the active ISO list
			$this->set('isolist',$isoIds);
            $resultIso = $this->Merchant->find('all', array('fields' => array('Merchant.statusID','Merchant.isoID','count(Merchant.statusID) as count'),  'conditions' => array('Merchant.statusID IN (2,3,4,5,9)','Merchant.isoID IN ('.implode(",",$isoIdList).')'  ),'group'=>'Merchant.isoID, Merchant.statusID', 'recursive' => -1));
            $resultIso = Set::combine($resultIso,"{n}.Merchant.statusID","{n}.0.count","{n}.Merchant.isoID");
            $this->set('resultIso',$resultIso);
		}
		/* task id 2579 point#7 by jitendra on 29 Nov 2013
		public function superadmin_accsearchbyiso(){
			if($this->request->is('post')){
				$user_condition = "UserGroupJoin.user_group_id = 22 AND User.active=1";
				if(is_array($this->request->data['Report']['userID'])){
					$user_condition .= " AND User.id IN (".implode(",", $this->request->data['Report']['userID']).")";
				}
				$isos = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array($user_condition)));
				$this->set('isos', $isos);
				
				if(is_array($this->request->data['Report']['status'])){
					$status_condition = "Merchant.statusID IN (".implode(",", $this->request->data['Report']['status']).") and (Merchant.isoID > 0)";
					$this->set('statusarray',$this->request->data['Report']['status']);
				}else{
					$status_condition = "(Merchant.statusID = 2 OR Merchant.statusID = 3 or Merchant.statusID = 4 or Merchant.statusID = 9 or Merchant.statusID = 5) and (Merchant.isoID > 0)";
					$this->set('statusarray',array('2','3','4','9','5'));
				}
				$result = $this->Merchant->find('first',array('fields'=>array('sum(Merchant.volume) as volume'),'conditions'=>array($status_condition)));
					
				$this->set('grandTotal', $result[0]['volume']);
				$result = $this->Merchant->find('count',array('fields'=>array('Merchant.volume'),'conditions'=>array($status_condition)));
			
				$this->set('countTotal', $result);
			}
			
			$iso_rec = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array('UserGroupJoin.user_group_id' => 22, 'User.active'=>1, 'NOT' => array('User.id' => null))));
			$isoIds = array();
			foreach($iso_rec as $iso){
				$isoIds[$iso['User']['id']] = $iso['User']['user_Name'];
			}
			// get the active ISO list
			$this->set('isolist',$isoIds);
			
		}*/
		
		public function superadmin_agent()
		{
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(10, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$agents = $this->UserGroupJoin->find('all',array('fields'=>array('User.userName','User.userPhone','User.userCompany'),'conditions'=>array('UserGroupJoin.user_group_id'=>20, 'NOT' => array('User.id' => null))));
			
			
			if(isset($this->request->query['AddAnnouncement3']) && $this->request->query['AddAnnouncement3']=='Export'){
					
				//$MerchantRec =$this->Merchant->find('all',array('conditions' => array($condition),'order'=>array('Merchant.merchantName' => 'asc')));
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
				//create a file
				$filename = "Agent_export_".date("Y.m.d").".csv";
				$csv_file = fopen('php://output', 'w');
			
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
			
				// The column headings of your .csv file
				$header_row = array("Agent NAME","Agent Phone Number","Agent Company");
				fputcsv($csv_file,$header_row,',','"');
			
				// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
				foreach($agents as $result)
				{
					// Array indexes correspond to the field names in your db table(s)
					$row = array(
							$result['User']['userName'],
							$result['User']['userPhone'],
							$result['User']['userCompany']
					);
					fputcsv($csv_file,$row,',','"');
				}
				fclose($csv_file);die;
			
			}
			
			
			/***** Assign Paginate when pipeline present ****/
			
			$condition  = ' UserGroupJoin.user_group_id = 20 and User.id > 0';
			
			$this->paginate = array(
					'limit' => 50,
					'fields' => array('User.user_Name','User.userPhone', 'User.userCompany'),					
					'conditions' => array($condition),			
					'paramType' => 'querystring'
				);	
			
			$agents = $this->paginate();
			$this->set('agents',$agents);
			
			
		}
		
		public function superadmin_reportprocessor2()
		{
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(10, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$processorSet = $this->UserGroupJoin->find('all',array('fields'=>array('User.*'),'conditions'=>array('UserGroupJoin.user_group_id'=>23),'order'=>array('username asc')));
			$this->set("processorSet",$processorSet);
			
			$accType_list =  $this->Accounttype->find("all");
			$this->set("accType_list",$accType_list);
			
		}
		
		public function superadmin_expiringcontract() {
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(10, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$order='';
			$condition='';

			// task id 3498 comment of 25-feb-2014
			if($this->request->is('post')){			
				$this->loadModel('Merchant');
				$this->loadModel('Merchantnote');
				$contract_approval = $this->request->data['Merchant']['contract_approval'];				
				foreach($contract_approval as $merchantID => $approval_date){
					if($approval_date!=""){
						$datePlusThreeYears = date('Y-m-d',strtotime($approval_date." +3 years"));
						$data['Merchant']['id'] = $merchantID;
						$data['Merchant']['contract_expiration'] = $datePlusThreeYears;
						$data['Merchant']['contract_approval']   = $approval_date;
						$this->Merchant->save($data,false);
			
						// save note
						$this->Merchantnote->create();
						$noteData = array();
						$changedBy = $this->Session->read('UserAuth.User.user_Name');
						$noteData['Merchantnote']['merchantID'] = $merchantID;
						$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
						$timestamp = CURRENTDATE;
						$noteData['Merchantnote']['timeStamp'] = $timestamp;
						$noteData['Merchantnote']['note'] = "Merchant information has been changed. The application was approved on ".date('m/d/Y',strtotime($approval_date))." and the expiration was approved on ".date('m/d/Y',strtotime($datePlusThreeYears))." by ".$changedBy;
						$this->Merchantnote->save($noteData);
					}
				}
			}
			
			if(isset($this->request->query) && count($this->request->query)>0) {
				//for from date
				if(isset($this->request->query['contract_expiration_from']) && $this->request->query['contract_expiration_from']) {
					$fromdate = date("Y-m-d",strtotime($this->request->query['contract_expiration_from']));
					$argArr['contract_expiration_from'] = $fromdate;
				}
				//for to date
				if(isset($this->request->query['contract_expiration_to']) && $this->request->query['contract_expiration_to']) {
					$todate = date("Y-m-d",strtotime($this->request->query['contract_expiration_to']));
					$argArr['contract_expiration_to'] = $todate;
				}
			}
			
			if((isset($this->params['named']) && count($this->params['named'])>0) || (isset($this->params['pass']) && count($this->params['pass'])>0)){
				//for from date
				if(isset($this->params['named']['contract_expiration_from']) && $this->params['named']['contract_expiration_from']) {
					$fromdate = date("Y-m-d",strtotime($this->params['named']['contract_expiration_from']));
					$argArr['contract_expiration_from'] = $fromdate;
				}
				//for Area of interest
				if(isset($this->params['named']['contract_expiration_to']) && $this->params['named']['contract_expiration_to']) {
					$todate = date("Y-m-d",strtotime($this->params['named']['contract_expiration_to']));
					$argArr['contract_expiration_to'] = $todate;
				}			
			}
			
			$condition .= 'Merchant.contract_expiration IS NOT NULL';
			
			if($fromdate!='')
				$condition .= " AND Merchant.contract_expiration >= '".$fromdate."'";
			if($todate!='')
				$condition .= " AND Merchant.contract_expiration <= '".$todate."'";
			
			$MerchantVolTotal=$this->Merchant->find('all',array('fields'=>'sum(volume) as total_volume','conditions' => array($condition)));
			$volumTotal = $MerchantVolTotal[0][0]['total_volume'];
			$MerchantRec=$this->Merchant->find('count',array('conditions' => array($condition)));
			
			$this->paginate = array(
					'limit' => 50,
					'fields' => array('distinct(Merchant.id)','Merchant.merchantDBA','Merchant.CID','Merchant.contract_approval','Merchant.contract_expiration','Status.status','Processor.user_Name'),
					'order' => array(
							'Merchant.id' => 'desc',
					),
					'conditions' => array($condition),
					'paramType' => 'querystring'
			);
			
			$MerchantRecData = $this->paginate('Merchant');
				
			$this->set('totalUser',$MerchantRec);
			$this->set('totalVolume',$volumTotal);
			$this->set('MerchantRec',$MerchantRecData);
			$this->set('argArr', $argArr); 
			
			if($fromdate!='')
			$this->request->data['Merchant']['contract_expiration_from'] = date("m/d/Y",strtotime($fromdate));
			if($todate!='')
			$this->request->data['Merchant']['contract_expiration_to'] = date("m/d/Y",strtotime($todate));
			
			/* echo "<pre>";
			print_r($MerchantRecData);die; */
			
			// task id 3498 (on dev server)
			$this->Merchant->recursive = 0;
			$contract_expireation_condition = '(Merchant.contract_expiration IS NULL OR Merchant.contract_expiration="") AND (Merchant.statusID=5 OR Merchant.statusID=9)';
			$merchant_without_contract_exp = $this->Merchant->find("all",array('fields'=>array('distinct(Merchant.id)','Merchant.merchantDBA','Merchant.CID','Merchant.contract_approval','Merchant.contract_expiration','Status.status','Processor.user_Name'),'conditions'=>array($contract_expireation_condition),'order'=>array('Merchant.id DESC')));
			$this->set('merchant_without_contract_exp',$merchant_without_contract_exp);
			
		}

		public function superadmin_loss()
		{
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(8, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$condition = "totalapps_income < 0";
			if($this->request->data['Commissionlog']['Month']==''){
				$this->request->data['Commissionlog']['Month'] = date('m');
				$condition .= " AND MONTH(date) = MONTH(CURDATE())"; 
			}else{
				$condition .= " AND MONTH(date) = ".$this->request->data['Commissionlog']['Month'];
			}
			if($this->request->data['Commissionlog']['Year']==''){
				$this->request->data['Commissionlog']['Year'] = date('Y');
				$condition .= " AND YEAR(date) = YEAR(CURDATE())";
			}else{
				$condition .= " AND YEAR(date) = ".$this->request->data['Commissionlog']['Year'];
			}
			
			//echo $condition;die;
			$countTotal = $this->Commissionlog->find('count',array('conditions'=>array($condition)));
			
			/* $this->set('managers', $activeManagers); */
			$this->paginate = array(
					'limit' => $countTotal,
					'order' => array(
							'Commissionlog.date' => 'DESC',
					),
					'conditions' => array($condition),
					'paramType' => 'querystring'
			);
			
			$loss_merchant = $this->paginate('Commissionlog');
			$this->set('merchants', $loss_merchant);
			
		}
		
		public function superadmin_newbusinessgrowth(){	
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(6, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$allmerchantTotal = 0;
			// Give a list of new merchants in the past three months. The new merchants are the ones who never showed up in the residual reports three months before ( they only processed less than or equal to three month).
			$options['joins'] = array(
					array('table' => 'merchantpipelines',
							'alias' => 'Merchantpipeline',
							'type' => 'inner',
							'conditions' => array(
									'Merchant.id = Merchantpipeline.merchantID',
							)
					)
			);
			$condition = "Merchantpipeline.statusFrom = 0 AND Merchantpipeline.statusTo=1 AND Merchantpipeline.statusToDate <= NOW() AND Merchantpipeline.statusToDate > ( NOW() - INTERVAL 3 MONTH )";
			$options['conditions'] = array($condition);
			$options['order'] = array('Merchantpipeline.statusToDate DESC');
			$options['fields'] = array('Merchant.CID','Merchant.merchantDBA');
			
			$merchants = $this->Merchant->find('all', $options);
			foreach ($merchants as $merchant) {
				if(count($merchant['Commissionlog'])>0){
					foreach($merchant['Commissionlog'] as $commission){
						$chkdate = date('Y-m-01', strtotime(date('Y-m')." -2 month"));						
						if($commission['date']>=$chkdate){
							$allmerchantTotal += $commission['amount_processed'];
						}
					}
				}
			}
			$this->set('allmerchantTotal',$allmerchantTotal);
			$this->set('merchants',$merchants);
			
			
		}
		
		public function superadmin_existingbusinessgrowth(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(6, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$allmerchantTotal = 0;
                        $this->Merchant->unbindModel(
                                array(
                                    'belongsTo' => array('Agent','Processor','Manager','ISO','Referal','Status','ProcessingMethod'),
                                    'hasOne' => array('Commission')
                                    )
                        ,false);
			// Give us a list of old merchants who are processing in the last three months. The old merchants are the ones who processed more than three months.
			$options['joins'] = array(
					array('table' => 'merchantpipelines',
							'alias' => 'Merchantpipeline',
							'type' => 'inner',
							'conditions' => array(
									'Merchant.id = Merchantpipeline.merchantID',
							)
					)
			);
			$condition = "Merchantpipeline.statusFrom = 0 AND Merchantpipeline.statusTo=1 AND Merchantpipeline.statusToDate < ( NOW() - INTERVAL 3 MONTH )";
			$options['conditions'] = array($condition);
			$options['order'] = array('Merchantpipeline.statusToDate DESC');
			$options['fields'] = array('Merchant.CID','Merchant.merchantDBA');
				
			$merchants = $this->Merchant->find('all', $options);
                        
			foreach ($merchants as $merchant) {
				if(count($merchant['Commissionlog'])>0){
					foreach($merchant['Commissionlog'] as $commission){
						$chkdate = date('Y-m-01', strtotime(date('Y-m')." -2 month"));						
						if($commission['date']>=$chkdate){
							$allmerchantTotal += $commission['amount_processed'];
						}
					}
				}
			}
			
			$this->set('allmerchantTotal',$allmerchantTotal);
			$this->set('merchants',$merchants);
				
				
		}
		
		public function superadmin_existingwithoutnerium(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(6, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$allmerchantTotal = 0;
                        $this->Merchant->unbindModel(
                                array(
                                    'belongsTo' => array('Agent','Processor','Manager','ISO','Referal','Status','ProcessingMethod'),
                                    'hasOne' => array('Commission')
                                    )
                        ,false);
			// Give us a list of old merchants who are processing in the last three months. The old merchants are the ones who processed more than three months.Not include all the acccount that has "Nerium" in the name.
			$options['joins'] = array(
					array('table' => 'merchantpipelines',
							'alias' => 'Merchantpipeline',
							'type' => 'inner',
							'conditions' => array(
									'Merchant.id = Merchantpipeline.merchantID',
							)
					)
			);
			$condition = "Merchant.merchantDBA NOT LIKE '%nerium%' AND Merchantpipeline.statusFrom = 0 AND Merchantpipeline.statusTo=1 AND Merchantpipeline.statusToDate < ( NOW() - INTERVAL 3 MONTH )";
			$options['conditions'] = array($condition);
			$options['order'] = array('Merchantpipeline.statusToDate DESC');
			$options['fields'] = array('Merchant.CID','Merchant.merchantDBA');
			
			$merchants = $this->Merchant->find('all', $options);
			
			foreach ($merchants as $merchant) {
				if(count($merchant['Commissionlog'])>0){
					foreach($merchant['Commissionlog'] as $commission){
						$chkdate = date('Y-m-01', strtotime(date('Y-m')." -2 month"));						
						if($commission['date']>=$chkdate){
							$allmerchantTotal += $commission['amount_processed'];
						}
					}
				}
			}
				
			$this->set('allmerchantTotal',$allmerchantTotal);
			$this->set('merchants',$merchants);
			
			
		}
		
		public function superadmin_monthlyprocessingvolume(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(6, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$monthoptions = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
			$allmerchantTotal = 0;
			
			$current_year = date('Y');
			for($y=$current_year;$y>=1900;$y--){
				$year[$y] = $y;
			}
			$this->set('year',$year);
			
			// get list of processor 
			$procList =$this->Common->getProcessorList();
			
			$this->set('procList',$procList);
			// get manager list
			$mangList = $this->Common->getManagerList();
			$this->set('mangList',$mangList);
			
			// Give us a list of old merchants who are processing in the last three months. The old merchants are the ones who processed more than three months.Not include all the acccount that has "Nerium" in the name.
			$options['joins'] = array(
					array('table' => 'merchantpipelines',
							'alias' => 'Merchantpipeline',
							'type' => 'inner',
							'conditions' => array(
									'Merchant.id = Merchantpipeline.merchantID',
							)
					)
			);
			/* $condition = "Merchantpipeline.statusFrom = 0 AND Merchantpipeline.statusTo=1 AND Merchantpipeline.statusToDate < ( NOW() - INTERVAL 3 MONTH )"; */
			$condition = "Merchantpipeline.statusFrom = 0 AND Merchantpipeline.statusTo=1";
			$options['conditions'] = array($condition);
			$options['order'] = array('Merchant.id DESC');
			$options['fields'] = array('Merchant.CID','Merchant.merchantDBA','Merchant.volume','Processor.user_Name','Manager.user_Name');
				
			$merchants = $this->Merchant->find('all', $options);	
			//pr($merchants);die;	
			$this->set('monthoptions',$monthoptions);
			$this->set('allmerchantTotal',$allmerchantTotal);
			$this->set('merchants',$merchants);			
		}
		
		public function superadmin_selectedmonthreport(){	
			$condition = "1=1";
			if($this->request->is('post')){	
				$this->Merchant->unbindModel(
						array('hasMany' => array('Commissionlog'))
				);
				$allmerchantTotal = 0;
				// Give us a list of old merchants who are processing in the last three months. The old merchants are the ones who processed more than three months.Not include all the acccount that has "Nerium" in the name.
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
				if($this->request->data['Report']['Month']!=""){
					$month = $this->request->data['Report']['Month'];					
				}else{
					$month = date('m');
				}
				$condition .= " AND MONTH(Commissionlog.date)=".$month;
				
				if($this->request->data['Report']['Year']!=""){
					$year = trim($this->request->data['Report']['Year']);					
				}else{
					$year = date('Y');
				}
				$condition .= " AND YEAR(Commissionlog.date)=".$year;
				
				if(is_array($this->request->data['Report']['Processor'])){
					$processor_list = implode(",",$this->request->data['Report']['Processor']);
					$condition .= " AND Merchant.processorID IN (".$processor_list.")";
				}
				
				if(is_array($this->request->data['Report']['Manager'])){
					$manager_list = implode(",",$this->request->data['Report']['Manager']);
					$condition .= " AND Merchant.managerID IN (".$manager_list.")";
				}				
				//echo $condition;die;
				$options['conditions'] = array($condition);
				$options['order'] = array('Merchant.id DESC');
				$options['fields'] = array('Merchant.CID','Merchant.merchantDBA','Merchant.volume','Processor.user_Name','Manager.user_Name','sum(Commissionlog.amount_processed) as amount_processed');
				$options['group'] = array('Merchant.id');
				
				$merchants = $this->Merchant->find('all', $options);
				$this->set('merchants',$merchants);
				$this->set('month',$month);
				$this->set('year',$year);				
			}
		}
		
		// get the report of processor business matrix
		public function superadmin_processormatrix(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(4, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			//get domestic processor
			$domestic_cond = "User.processor_type='domestic' OR User.processor_type='all'";
			$domestic_processor = $this->User->find('list',array('fields'=>array('User.id','User.user_Name'),'conditions'=>array($domestic_cond),'order'=>array('User.user_Name ASC')));
			$this->set('domestic_processor',$domestic_processor);
			//get international processor
			$international_cond = "User.processor_type='international' OR User.processor_type='all'";
			$international_processor = $this->User->find('list',array('fields'=>array('User.id','User.user_Name'),'conditions'=>array($international_cond),'order'=>array('User.user_Name ASC')));
			$this->set('international_processor',$international_processor);
			//get business type(business category)
			$business_type = $this->Businesscat->find('all',array('fields'=>array('Businesscat.id','Businesscat.category_name'),'conditions'=>array('Businesscat.parent_id=0'),'order'=>array('Businesscat.category_name ASC')));
			$this->set('business_type',$business_type);
			//pr($business_type);			
			$business_type_options = $this->Businesscat->find('list',array('fields'=>array('Businesscat.id','Businesscat.category_name'),'conditions'=>array('Businesscat.parent_id=0'),'order'=>array('Businesscat.category_name ASC')));
			$this->set('business_type_options',$business_type_options);
			
		}
		
		// search the report of processor business matrix
		public function superadmin_searhprocessormatrix(){
			if($this->request->is('post')){
				$processor_type = $this->request->data['Report']['processor_type'];
				$business_type  = $this->request->data['Report']['business_type'];
				$processor_status = $this->request->data['Report']['processor_status'];
				
				$condition = "UserGroupJoin.user_group_id=23 AND User.id!=''";
				$busi_type_condition = "1=1";
				
				if($processor_type!=''){
					$condition .= " AND User.processor_type = '".$processor_type."'";										
				}
				
				if($processor_status!=''){
					$condition .= " AND User.active = '".$processor_status."'";
				}
				//get processor
				$processor = $this->UserGroupJoin->find('all',array('fields'=>array('User.id','User.user_Name'),'conditions'=>array($condition),'order'=>array('username asc')));
				$this->set('processors',$processor);
				
				//get business type
				if(is_array($business_type)){
					$busi_type_condition .= " AND Businesscat.id IN(".implode(",", $business_type).")";					
				}else{
					$busi_type_condition .= " AND Businesscat.parent_id=0";
				}
				$business_type = $this->Businesscat->find('all',array('fields'=>array('Businesscat.id','Businesscat.category_name'),'conditions'=>array($busi_type_condition),'order'=>array('Businesscat.category_name ASC')));
				$this->set('business_type',$business_type);				
			}
		}
		
		// get the list of all merchant by agents
		public function superadmin_accountbyagent(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(3, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$activeAgents	  = $this->UserGroupJoin->find('all', array('fields' => array('User.id','User.user_Name'), 'conditions' => array('UserGroupJoin.user_group_id' => 20, 'User.active' => 1, 'NOT' => array('User.id' => null)),'order' => array('User.user_Name' => 'ASC')));
			$condition = "(Merchant.statusID IN (2,3,4,9,5)) AND (Merchant.setupfeepaid = 0) ";
			$agentslist = array();
			foreach($activeAgents as $agent){
				$agentIds[] =  $agent['User']['id'];
				$agentslist[$agent['User']['id']] = $agent['User']['user_Name'];
			}			
			$activeAgentCount = count($agentIds);
			if($activeAgentCount>0){
				$condition .= " AND (Merchant.agentID IN (".implode(",", $agentIds)."))";
			}
            $this->Merchant->recursive = -1;
			$countTotal = $this->Merchant->find('count',array('fields'=>array('Merchant.volume'),'conditions'=>array($condition)));
			
            $result = $this->Merchant->find('all', array('fields' => array('Merchant.statusID','Merchant.agentID','count(Merchant.statusID) as count'),  'conditions' => array('Merchant.statusID IN (2,3,4,5,9)',  'Merchant.agentID IN ('.implode(",", $agentIds).')'  ),'group'=>'Merchant.agentID, Merchant.statusID', 'recursive' => -1));
            $result = Set::combine($result,"{n}.Merchant.statusID","{n}.0.count","{n}.Merchant.agentID");                        
                        
			$this->set('agents', $activeAgents);
			$this->set('countTotal', $countTotal);
			$this->set('agentslist',$agentslist);
            $this->set('result',$result);
		}
		// get the list of all merchant by agents search
		/* task id 2579 point#7 by jitendra on 29 Nov 2013
		public function superadmin_accsearchbyagent(){
			$agent_rec = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array('UserGroupJoin.user_group_id' => 20, 'User.active'=>1, 'NOT' => array('User.id' => null)),'order' => array('User.user_Name' => 'ASC')));
			$agentIds = array();
			foreach($agent_rec as $agent){
				$agentlist[$agent['User']['id']] = $agent['User']['user_Name'];
				$agentIds[] = $agent['User']['id'];
			}
			// get the active agent list
			$this->set('isolist',$agentlist);			
			
			if($this->request->is('post')){
				$user_condition = "UserGroupJoin.user_group_id = 20 AND User.active=1";
				if(is_array($this->request->data['Report']['userID'])){
					$user_condition .= " AND User.id IN (".implode(",", $this->request->data['Report']['userID']).")";
				}
				$agents = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array($user_condition),'order' => array('User.user_Name' => 'ASC')));
				$this->set('isos', $agents);
		
				if(is_array($this->request->data['Report']['status'])){
					$this->set('statusarray',$this->request->data['Report']['status']);
				}else{
					$this->set('statusarray',array('2','3','4','9','5'));
				}
				if(count($agentIds)>0){
					$status_condition = "(Merchant.statusID = 2 OR Merchant.statusID = 3 or Merchant.statusID = 4 or Merchant.statusID = 9 or Merchant.statusID = 5) and (Merchant.agentID > 0) AND (Merchant.setupfeepaid = 0) AND (Merchant.agentID IN (".implode(",", $agentIds)."))";
				}
				
				$result = $this->Merchant->find('first',array('fields'=>array('sum(Merchant.volume) as volume'),'conditions'=>array($status_condition)));
				$this->set('grandTotal', $result[0]['volume']);
				$result = $this->Merchant->find('count',array('fields'=>array('Merchant.volume'),'conditions'=>array($status_condition)));
					
				$this->set('countTotal', $result);
			}	
				
		}*/
		
		// get the list of all merchant by referral
		public function superadmin_accountbyreferral(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(3, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$activeReferral	  = $this->UserGroupJoin->find('all', array('conditions' => array('UserGroupJoin.user_group_id' => 25, 'User.active' => 1, 'NOT' => array('User.id' => null)),'fields' => array('User.id','User.user_Name'), 'order' => array('User.user_Name' => 'ASC')));
                        $condition = "(Merchant.statusID IN (2,3,4,9,5)) AND (Merchant.setupfeepaid = 0) ";
			
                        foreach($activeReferral as $referral){
				$referralIds[] =  $referral['User']['id'];
				$referrallist[$referral['User']['id']] = $referral['User']['user_Name'];
			}
			$activeReferralCount = count($referralIds);
			if($activeReferralCount>0){
				$condition .= " AND (Merchant.referalID IN (".implode(",", $referralIds)."))";
			}
                        $this->Merchant->recursive = -1;
			$countTotal = $this->Merchant->find('count',array('fields'=>array('Merchant.volume'),'conditions'=>array($condition)));                        
                        
                        $result = $this->Merchant->find('all', array('fields' => array('Merchant.statusID','Merchant.referalID','count(Merchant.statusID) as count'),  'conditions' => array('Merchant.statusID IN (2,3,4,5,9)',  'Merchant.referalID IN ('.implode(",", $referralIds).')'  ),'group'=>'Merchant.referalID, Merchant.statusID', 'recursive' => -1));
                        $result = Set::combine($result,"{n}.Merchant.statusID","{n}.0.count","{n}.Merchant.referalID");
                        
			$this->set('referrals', $activeReferral);
			$this->set('countTotal', $countTotal);
			$this->set('referrallist',$referrallist);
			$this->set('result',$result);
		}
		// get the list of all merchant by referral search
		/* task id 2579 point#7 by jitendra on 29 Nov 2013
		public function superadmin_accsearchbyreferral(){
			$referral_rec = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array('UserGroupJoin.user_group_id' => 25, 'User.active'=>1, 'NOT' => array('User.id' => null)),'order' => array('User.user_Name' => 'ASC')));
			$referralIds = array();
			foreach($referral_rec as $referral){
				$referrallist[$referral['User']['id']] = $referral['User']['user_Name'];
				$referralIds[] = $referral['User']['id'];
			}
			// get the active referral list
			$this->set('referrallist',$referrallist);
				
			if($this->request->is('post')){
				$user_condition = "UserGroupJoin.user_group_id = 25 AND User.active=1";
				if(is_array($this->request->data['Report']['userID'])){
					$user_condition .= " AND User.id IN (".implode(",", $this->request->data['Report']['userID']).")";
				}
				$referrals = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array($user_condition),'order' => array('User.user_Name' => 'ASC')));
				$this->set('isos', $referrals);
		
				if(is_array($this->request->data['Report']['status'])){
					$this->set('statusarray',$this->request->data['Report']['status']);
				}else{
					$this->set('statusarray',array('2','3','4','9','5'));
				}
				if(count($referralIds)>0){
					$status_condition = "(Merchant.statusID = 2 OR Merchant.statusID = 3 or Merchant.statusID = 4 or Merchant.statusID = 9 or Merchant.statusID = 5) and (Merchant.referalID > 0) AND (Merchant.setupfeepaid = 0) AND (Merchant.referalID IN (".implode(",", $referralIds)."))";
				}
		
				$result = $this->Merchant->find('first',array('fields'=>array('sum(Merchant.volume) as volume'),'conditions'=>array($status_condition)));
				$this->set('grandTotal', $result[0]['volume']);
				$result = $this->Merchant->find('count',array('fields'=>array('Merchant.volume'),'conditions'=>array($status_condition)));
					
				$this->set('countTotal', $result);
			}
		
		}*/
		
		// get the list of all merchant by processor search
		/* task id 2579 point#7 by jitendra on 29 Nov 2013
		public function superadmin_accsearchbyprocessor(){
			$processor_rec = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array('UserGroupJoin.user_group_id' => 23, 'User.active'=>1, 'NOT' => array('User.id' => null)),'order' => array('User.user_Name' => 'ASC')));
			$processorIds = array();
			foreach($processor_rec as $processor){
				$processorlist[$processor['User']['id']] = $processor['User']['user_Name'];
				$processorIds[] = $processor['User']['id'];
			}
			// get the active processor list
			$this->set('processorlist',$processorlist);
		
			if($this->request->is('post')){
				$user_condition = "UserGroupJoin.user_group_id = 23 AND User.active=1";
				if(is_array($this->request->data['Report']['userID'])){
					$user_condition .= " AND User.id IN (".implode(",", $this->request->data['Report']['userID']).")";
				}
				$processors = $this->UserGroupJoin->find('all', array('fields' => array('User.id', 'User.user_Name'), 'conditions' => array($user_condition),'order' => array('User.user_Name' => 'ASC')));
				$this->set('isos', $processors);
		
				if(is_array($this->request->data['Report']['status'])){
					$this->set('statusarray',$this->request->data['Report']['status']);
				}else{
					$this->set('statusarray',array('2','3','4','9','5'));
				}
				if(count($processorIds)>0){
					$status_condition = "(Merchant.statusID = 2 OR Merchant.statusID = 3 or Merchant.statusID = 4 or Merchant.statusID = 9 or Merchant.statusID = 5) and (Merchant.processorID > 0) AND (Merchant.setupfeepaid = 0) AND (Merchant.processorID IN (".implode(",", $processorIds)."))";
				}
		
				$result = $this->Merchant->find('first',array('fields'=>array('sum(Merchant.volume) as volume'),'conditions'=>array($status_condition)));
				$this->set('grandTotal', $result[0]['volume']);
				$result = $this->Merchant->find('count',array('fields'=>array('Merchant.volume'),'conditions'=>array($status_condition)));
					
				$this->set('countTotal', $result);
			}
		
		}*/
		
		// get the commission report of users(Agent,ISO,Referral)
		public function superadmin_commission(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(5, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			//search dropdown options
			$monthoptions = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
			$this->set('monthoptions',$monthoptions);
			
			$current_year = date('Y');
			for($y=$current_year;$y>=1900;$y--){
				$year[$y] = $y;
			}
			$this->set('year',$year);
			
			// get list of agents
			$agentList =$this->Common->getAgentList();
			$this->set('agentList',$agentList);
			// get referral list
			$referralList = $this->Common->getReferalList();
            $this->set('referralList',$referralList);
			// get iso list
			$isoList = $this->Common->getIsoList();
			$this->set('isoList',$isoList);
			
			// show result table matrix
			$condition = "UserGroupJoin.user_group_id IN(20,22,25) AND User.active=1 AND User.id!=''";
			$agent_ref_iso = $this->UserGroupJoin->find('all', array('fields' => array('distinct(User.id)', 'User.user_Name'), 'conditions' => array($condition),'order'=>array('User.user_name ASC')));
			$this->set('users',$agent_ref_iso);
			
			// task id 2144 for commission report for agent user login
			$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
			if($userGroupId==20){
				$users['0']['User']['id'] = $this->Session->read('UserAuth.User.id');
				$users['0']['User']['user_Name'] = $this->Session->read('UserAuth.User.user_Name');
				$this->set('users',$users);
			}
                        
            $userIdList = Set::combine($agent_ref_iso, '{n}.User.id', '{n}.User.id');
            $this->set('userIdList',$userIdList);
            // processing accounts in last 8 months.
			$first_month_time 	= time();
			$second_month_time 	= strtotime(date('Y-m')." -1 month");
			$third_month_time 	= strtotime(date('Y-m')." -2 month");
			$fourth_month_time 	= strtotime(date('Y-m')." -3 month");
			$fifth_month_time 	= strtotime(date('Y-m')." -4 month");
			$sixth_month_time 	= strtotime(date('Y-m')." -5 month");
			$seventh_month_time = strtotime(date('Y-m')." -6 month");
			$eight_month_time 	= strtotime(date('Y-m')." -7 month");
			$previous_month	=	array($first_month_time,$second_month_time,$third_month_time,$fourth_month_time,$fifth_month_time,$sixth_month_time,$seventh_month_time,$eight_month_time);
			$this->set('previous_month',$previous_month);	
		}
		
		// search commission report
		public function superadmin_commissionreportsearch($userID=null,$monthtime=null){
			//search dropdown options
			$monthoptions = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
			$this->set('monthoptions',$monthoptions);
			$current_year = date('Y');
			for($y=$current_year;$y>=1900;$y--){
				$year[$y] = $y;
			}
			$this->set('year',$year);
			
			// get list of agents
			$agentList =$this->Common->getAgentList();
			$this->set('agentList',$agentList);
			// get referral list
			$referralList = $this->Common->getReferalList();
			$this->set('referralList',$referralList);
			// get iso list
			$isoList = $this->Common->getIsoList();
			$this->set('isoList',$isoList);
						
			// show result table matrix
			$condition = "UserGroupJoin.user_group_id IN(20,22,25) AND User.active=1 AND User.id!=''";
			$agent_ref_iso = $this->UserGroupJoin->find('all', array('fields' => array('distinct(User.id)', 'User.user_Name'), 'conditions' => array($condition),'order'=>array('User.user_name ASC')));
			$this->set('users',$agent_ref_iso);	
			
			// task id 2144 for commission report for agent user login
			$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
			if($userGroupId==20){
				$users['0']['User']['id'] = $this->Session->read('UserAuth.User.id');
				$users['0']['User']['user_Name'] = $this->Session->read('UserAuth.User.user_Name');
				$this->set('users',$users);
			}
			
			// Business Logic start from here for layer 3
			$layer3_condition = "1=1";
			$this->Merchant->unbindModel(
					array('hasMany' => array('Commissionlog'))
			);
			$allmerchantTotal = 0;
			$options['joins'] = array(
					array('table' => 'commissionlogs',
							'alias' => 'Commissionlog',
							'type' => 'inner',
							'conditions' => array(
									'Merchant.id = Commissionlog.merchantID'
							),
							'order' => array('Commissionlog.date DESC')
					)
			);
			// when comes from search form
			if($this->request->is('post')){	
				// search month and year
				$this->set('searchmonth',$this->request->data['Report']['Month']);
				$this->set('searchyear',$this->request->data['Report']['Year']);
				$monthtime = mktime(0, 0, 0, $this->request->data['Report']['Month'], 1, $this->request->data['Report']['Year']);				
				$this->set('monthtime',$monthtime);
				
				if(is_array($this->request->data['Report']['agent']) || is_array($this->request->data['Report']['referral']) || is_array($this->request->data['Report']['iso'])){
					// search parameters
					$month = $this->request->data['Report']['Month'];						
					$layer3_condition .= " AND MONTH(Commissionlog.date)=".$month;					
					$year = trim($this->request->data['Report']['Year']);						
					$layer3_condition .= " AND YEAR(Commissionlog.date)=".$year;
				
					if(is_array($this->request->data['Report']['agent'])){
						$agent_list = implode(",",$this->request->data['Report']['agent']);
						$layer3_condition .= " AND Merchant.agentID IN (".$agent_list.")";
					}					
					if(is_array($this->request->data['Report']['referral'])){
						$referral_list = implode(",",$this->request->data['Report']['referral']);
						$layer3_condition .= " AND Merchant.referalID IN (".$referral_list.")";
					}						
					if(is_array($this->request->data['Report']['iso'])){
						$iso_list = implode(",",$this->request->data['Report']['iso']);
						$layer3_condition .= " AND Merchant.isoID IN (".$iso_list.")";
					}
					//echo $layer3_condition;die;
					$options['conditions'] = array($layer3_condition);
					$options['order'] = array('Merchant.id DESC');
					// ticket id 2060
					//$options['fields'] = array('distinct(Merchant.id),Merchant.CID','Merchant.merchantDBA','Merchant.volume','Processor.user_Name','ISO.user_Name','Referal.user_Name','Agent.user_Name','Commission.*','sum(Commissionlog.amount_processed) as amount_processed','sum(Commissionlog.gross_revenue) as gross_revenue','sum(Commissionlog.totalapps_income) as totalapps_income','sum(Commissionlog.agent_commission) as agent_commission','sum(Commissionlog.referral_commission) as referral_commission','sum(Commissionlog.iso_commission) as iso_commission');
					$options['fields'] = array('distinct(Merchant.id),Merchant.CID','Merchant.merchantDBA','Merchant.volume','Processor.user_Name','ISO.user_Name','Referal.user_Name','Agent.user_Name','Commission.*','Commissionlog.*');
					$options['group'] = array('Merchant.id');				
					$merchants = $this->Merchant->find('all', $options);
					$this->set('merchants',$merchants);
				}
			}
			
			// when comes from click on user name
			if(isset($userID) && $userID!=""){	
				$this->request->data['Report']['agent'] = $userID;
				$this->request->data['Report']['referral'] = $userID;
				$this->request->data['Report']['iso'] = $userID;
				
				$this->request->data['Report']['Month'] = date("m",$monthtime);
				$this->request->data['Report']['Year'] = date("Y",$monthtime);
				
				$layer3_condition .= " AND MONTH(Commissionlog.date)=".date("m",$monthtime);
				$layer3_condition .= " AND YEAR(Commissionlog.date)=".date("Y",$monthtime);
				
				$layer3_condition .= " AND (Merchant.agentID=".$userID." OR Merchant.referalID=".$userID." OR Merchant.isoID=".$userID.")";
				//echo $layer3_condition;die;
				$options['conditions'] = array($layer3_condition);
				$options['order'] = array('Commissionlog.date DESC');
				// ticket id 2060
				//$options['fields'] = array('distinct(Merchant.id),Merchant.CID','Merchant.merchantDBA','Merchant.volume','Processor.user_Name','ISO.user_Name','Referal.user_Name','Agent.user_Name','Commission.*','sum(Commissionlog.amount_processed) as amount_processed','sum(Commissionlog.gross_revenue) as gross_revenue','sum(Commissionlog.totalapps_income) as totalapps_income','sum(Commissionlog.agent_commission) as agent_commission','sum(Commissionlog.referral_commission) as referral_commission','sum(Commissionlog.iso_commission) as iso_commission');
				$options['fields'] = array('distinct(Merchant.id),Merchant.CID','Merchant.merchantDBA','Merchant.volume','Processor.user_Name','ISO.user_Name','Referal.user_Name','Agent.user_Name','Commission.*','Commissionlog.*');
				$options['group'] = array('Merchant.id');
				$merchants = $this->Merchant->find('all', $options);
				//pr($merchants);die;
				$this->set('merchants',$merchants);
			}
		}
		
		// Tier report of those merchants who have commission values
		public function superadmin_tierreport($processor_name=null){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(4, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}		
			$this->set('processor',$processor_name);
			$this->Merchant->unbindModel(
					array('hasMany' => array('Commissionlog'))
			);
			$options['joins'] = array(
					array('table' => 'commissionlogs',
							'alias' => 'Commissionlog',
							'type' => 'inner',
							'conditions' => array(
									'Merchant.id = Commissionlog.merchantID'
							)
					)
			);
			$options['order'] = array('Commissionlog.date DESC');
			// task id 2060
			$options['fields'] = array('Merchant.CID','Merchant.merchantDBA','Merchant.volume','Processor.user_Name','ISO.user_Name','Referal.user_Name','Agent.user_Name','Commission.*','Commissionlog.*');
			$options['group'] = array('Merchant.id');	

			if($processor_name=='meritcard'){
				// Tier report for Meritcard Processor	
				$tab1condition = "Commission.totalapps_split='100' AND (Processor.user_Name LIKE 'meritcard%' OR Processor.user_Name LIKE 'merit card%')";
				$options['conditions'] = array($tab1condition);
				$merchant_100 = $this->Merchant->find('all', $options);
				$this->set('merchant_1_100',$merchant_100);
				
				$tab2condition = "Commission.totalapps_split='85' AND (Processor.user_Name LIKE 'meritcard%' OR Processor.user_Name LIKE 'merit card%')";
				$options['conditions'] = array($tab2condition);
				$merchant_85 = $this->Merchant->find('all', $options);
				$this->set('merchant_1_85',$merchant_85);
				
				$tab3condition = "Commission.totalapps_split='70' AND (Processor.user_Name LIKE 'meritcard%' OR Processor.user_Name LIKE 'merit card%')";
				$options['conditions'] = array($tab3condition);
				$merchant_70 = $this->Merchant->find('all', $options);
				$this->set('merchant_1_70',$merchant_70);
				
				$tab4condition = "Commission.totalapps_split='60' AND (Processor.user_Name LIKE 'meritcard%' OR Processor.user_Name LIKE 'merit card%')";
				$options['conditions'] = array($tab4condition);
				$merchant_60 = $this->Merchant->find('all', $options);
				$this->set('merchant_1_60',$merchant_60);
			}
			// Tier report for Meritus Processor
			if($processor_name=='meritus'){
				$tab11condition = "Commission.totalapps_split<='5' AND (Processor.user_Name LIKE 'meritus%')";
				$options['conditions'] = array($tab11condition);
				$merchant_5 = $this->Merchant->find('all', $options);
				$this->set('merchant_11_5',$merchant_5);
					
				$tab12condition = "Commission.totalapps_split='50' AND (Processor.user_Name LIKE 'meritus%')";
				$options['conditions'] = array($tab12condition);
				$merchant_50 = $this->Merchant->find('all', $options);
				$this->set('merchant_11_50',$merchant_50);
					
				$tab13condition = "Commission.totalapps_split='70' AND (Processor.user_Name LIKE 'meritus%')";
				$options['conditions'] = array($tab13condition);
				$merchant_70 = $this->Merchant->find('all', $options);
				$this->set('merchant_11_70',$merchant_70);
			}
			// Tier report for Powerpay Processor
			if($processor_name=='powerpay'){
				$tab21condition = "Commission.totalapps_split='15' AND (Processor.user_Name LIKE 'powerpay%' OR Processor.user_Name LIKE 'pp%')";
				$options['conditions'] = array($tab21condition);
				$merchant_21_15 = $this->Merchant->find('all', $options);
				$this->set('merchant_21_15',$merchant_21_15);
				
				$tab22condition = "Commission.totalapps_split='50' AND (Processor.user_Name LIKE 'powerpay%' OR Processor.user_Name LIKE 'pp%')";
				$options['conditions'] = array($tab22condition);
				$merchant_21_50 = $this->Merchant->find('all', $options);
				$this->set('merchant_21_50',$merchant_21_50);
				
				$tab23condition = "Commission.totalapps_split='60' AND (Processor.user_Name LIKE 'powerpay%' OR Processor.user_Name LIKE 'pp%')";
				$options['conditions'] = array($tab23condition);
				$merchant_21_60 = $this->Merchant->find('all', $options);
				$this->set('merchant_21_60',$merchant_21_60);
			}
		}
		
		// residual report
		public function superadmin_residualreport($monthtime=null){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));			
			if(!in_array(1, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}			
			// processing accounts in last 8 months.
			$monthoptions = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
			$this->set('monthoptions',$monthoptions);
			
			$current_year = date('Y');
			for($y=$current_year;$y>=1900;$y--){
				$year[$y] = $y;
			}
			$this->set('year',$year);
			
			if($this->request->is('post') || isset($monthtime)){
								
				if(isset($monthtime)){
					$month = date('m',$monthtime);
					$year = date('Y',$monthtime);
				}else{
					$month = $this->request->data['Report']['Month'];
					$year = $this->request->data['Report']['Year'];
				}
								
				$condition = "1=1";
			

			   $this->Merchant->UnBindModel(array('belongsTo'=>array('Manager','Status','ProcessingMethod'),
													'hasMany'=>array('Commissionlog'),
													//'hasOne'=>array('Commission')
													));


				$options['joins'] = array(
						array('table' => 'commissionlogs',
								'alias' => 'Commissionlog',
								'type' => 'inner',
								'conditions' => array(
										'Merchant.id = Commissionlog.merchantID'
								)
						)
				);
				
				$condition .= " AND MONTH(Commissionlog.date)=".$month;				
				$condition .= " AND YEAR(Commissionlog.date)=".$year;				
				
				$options['conditions'] = array($condition);
				$options['order'] = array('Merchant.id DESC');
				$options['fields'] = array('distinct(Merchant.id),Commissionlog.transaction_numbers as transaction_numbers,Merchant.CID','Merchant.merchantDBA','Merchant.volume','Processor.user_Name','ISO.user_Name','Referal.user_Name','Agent.user_Name','Commissionlog.*','Commission.*');
				$options['group'] = array('Merchant.id');
				
				$merchants = $this->Merchant->find('all', $options);

				$this->set('merchants',$merchants);
				
			}else{
			
				$first_month_time 	= time();
				$second_month_time 	= strtotime(date('Y-m')." -1 month");
				$third_month_time 	= strtotime(date('Y-m')." -2 month");
				$fourth_month_time 	= strtotime(date('Y-m')." -3 month");
				$fifth_month_time 	= strtotime(date('Y-m')." -4 month");
				$sixth_month_time 	= strtotime(date('Y-m')." -5 month");
				$seventh_month_time = strtotime(date('Y-m')." -6 month");
				$eight_month_time 	= strtotime(date('Y-m')." -7 month");
				$previous_month	=	array($first_month_time,$second_month_time,$third_month_time,$fourth_month_time,$fifth_month_time,$sixth_month_time,$seventh_month_time,$eight_month_time);
				
				$month_report = array();
				$applicationChartData = array();
				$xAxisCategoryArray = array();
				$salesvolumeChartData = array();
				
				foreach($previous_month as $monthtime){
                                        
					$month_volumes = $this->Common->getResidualReport($monthtime);
					$month_report[$monthtime] = $month_volumes;
					//pr($month_volumes);die;
					
					$monthNumber = date('M',$monthtime);
					$monthYear = date('y',$monthtime);
					
					// active accounts graph
					//array shows on x axis
					$xAxisData = $monthNumber."-".$monthYear;
					$xAxisCategoryArray[] = $xAxisData;
					//array shows on y axis
					$activeAccounts = $month_volumes['0'];
					$applicationChartData[] = $activeAccounts;	

					// sales volume graph
					$totalsalesvolume = $month_volumes['5'];
					$salesvolumeChartData[] = $totalsalesvolume;
					
					// net income graph
					$totalapps_income  = $month_volumes['4'];
					$check = $month_volumes['1'] + $month_volumes['2'] + $month_volumes['3'];
					$net_income = $totalapps_income - $check;
					$netIncomeChartData[] = $net_income;
								
				}
				// graph 1
											
				$applicationChartName = 'Column Chart';										 
				$applicationChart = $this->HighCharts->create( $applicationChartName, 'column' );		
					
				$this->HighCharts->setChartParams(
						$applicationChartName,
						array(
								'renderTo'          => 'columnwrapper', // div to display chart inside
								'chartWidth'        => 330,
								'chartHeight'       => 300,
								'title'             => 'Active Accounts',
								'yAxisTitleText'    => 'Number Of Active Accounts',
								'xAxisCategories'   => $xAxisCategoryArray,
								'creditsText'       => '',
								'creditsURL'        => ''
						)
				);				
				$applicationChartSeries = $this->HighCharts->addChartSeries();				
				$applicationChartSeries->addName('Active Accounts')->addData($applicationChartData);				
				$applicationChart->addSeries($applicationChartSeries);
				
				//graph 2	
				 $applicationChartData = $salesvolumeChartData;
				 $applicationChartName = 'Volume Chart';
				 $applicationChart = $this->HighCharts->create( $applicationChartName, 'column' );
				 $this->HighCharts->setChartParams(
				 		$applicationChartName,
				 		array(
				 				'renderTo'          => 'volumewrapper', // div to display chart inside
				 				'chartWidth'        => 330,
				 				'chartHeight'       => 300,
				 				'title'             => 'Sales Volume',
				 				'yAxisTitleText'    => 'Total Sales Volume',
				 				'xAxisCategories'   => $xAxisCategoryArray,
				 				'creditsText'       => '',
				 				'creditsURL'        => ''
				 		)
				 );
				 	
				 $applicationChartSeries = $this->HighCharts->addChartSeries();				 	
				 $applicationChartSeries->addName('Sales Volume')->addData($applicationChartData);				 	
				 $applicationChart->addSeries($applicationChartSeries);
				 
				 //graph 3
				 $applicationChartData = $netIncomeChartData;
				 $applicationChartName = 'Net Income Chart';
				 $applicationChart = $this->HighCharts->create( $applicationChartName, 'column' );
				 $this->HighCharts->setChartParams(
				 		$applicationChartName,
				 		array(
				 				'renderTo'          => 'incomewrapper', // div to display chart inside
				 				'chartWidth'        => 350,
				 				'chartHeight'       => 300,
				 				'title'             => 'Net Income',
				 				'yAxisTitleText'    => 'Total Net Income',
				 				'xAxisCategories'   => $xAxisCategoryArray,
				 				'creditsText'       => '',
				 				'creditsURL'        => ''
				 		)
				 );
				 $applicationChartSeries = $this->HighCharts->addChartSeries();
				 $applicationChartSeries->addName('Net Income')->addData($applicationChartData);
				 $applicationChart->addSeries($applicationChartSeries);
				 
				 $this->set('month_report',$month_report);
			}
			
		}
		
	 	
		// Processors monthly processing 
		public function superadmin_procmonthlyprocessing(){
			// check user has permission or not , if yes allow otherwise not.
			$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
			if(!in_array(4, $allow)){
				$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
				die;
			}
			$monthoptions = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
			$this->set('monthoptions',$monthoptions);
							
			$current_year = date('Y');
			for($y=$current_year;$y>=1900;$y--){
				$year[$y] = $y;
			}
			$this->set('year',$year);
			// get list of processor
			//$processorList = $this->Common->getProcessorList();
			
			// Change by Prakash Saini at 10 jully 2013 to solve issue number 8.a in task id : 1043
			$selected_processor = array('ABC','Durango','Frontline','JetPay','Merit Card - M','Merit Card - WF-ONLINE','Merit Card - WF-SWIPE','Meritus - WF','Meritus-Harris','Meritus-NCAL','Meritus-Wood Forest','Powerpay-High Risk','Powerpay-Low Risk','Powerpay-Other','Signature card','Transfirst','Vantiv','VPS');
			$processorList = $this->Common->getProcessorByNameList($selected_processor);
			
			$this->set('processorList',$processorList);
			
			if($this->request->is('get')){
				// get current months
				$first_month_time 	= time();
				$second_month_time 	= strtotime(date('Y-m')." -1 month");
				$third_month_time 	= strtotime(date('Y-m')." -2 month");
				$fourth_month_time 	= strtotime(date('Y-m')." -3 month");
				$fifth_month_time 	= strtotime(date('Y-m')." -4 month");
				$sixth_month_time 	= strtotime(date('Y-m')." -5 month");
				$seventh_month_time = strtotime(date('Y-m')." -6 month");
				$eight_month_time 	= strtotime(date('Y-m')." -7 month");
				$previous_month	=	array($first_month_time,$second_month_time,$third_month_time,$fourth_month_time,$fifth_month_time,$sixth_month_time,$seventh_month_time,$eight_month_time);
				$this->set('previous_month',$previous_month);
				
				// get processors monthly vloume
				$total_monthly_salesvloume = array();
				$processor_monthly_salesvloume = array();
				$total_monthly_account = array();
				$result = array();
				foreach($previous_month as $monthtime){
					foreach ($processorList as $processorID => $processorName){
						$result = $this->Common->getProcessorMonthlyVolume($processorID,$monthtime);
						$processor_month_vol[$monthtime][$processorID] = $result['1'];
						$processor_month_account[$monthtime][$processorID] = $result['0'];
					}
					$total_monthly_salesvloume[] = array_sum($processor_month_vol[$monthtime]);
					$total_monthly_account[] = array_sum($processor_month_account[$monthtime]);
					
					$monthNumber = date('m',$monthtime);
					$monthYear = date('y',$monthtime);
					//array shows on x axis
					$xAxisData = $monthNumber."/".$monthYear;
					$xAxisCategoryArray[] = $xAxisData;
					// y axix data for each processor
				}
				
				// show record in ctp file in table
				$this->set('salesvolume',$processor_month_vol);	
				$this->set('activeaccounts',$processor_month_account);
				
				// records for graph data
				$this->set('total_monthly_salesvloume',$total_monthly_salesvloume);
				
				// graph 1
				$chartName = 'Line Chart';			
				$mychart = $this->HighCharts->create( $chartName, 'line' );			
				$this->HighCharts->setChartParams(
						$chartName,
						array(
								'renderTo'				=> 'linewrapper',  // div to display chart inside
								'chartWidth'			=> 560,
								'chartHeight'			=> 450,
								'chartMarginTop' 		=> 60,
								'chartMarginLeft'		=> 90,
								'chartMarginRight'		=> 30,
								'chartMarginBottom'		=> 150,
								'chartSpacingRight'		=> 10,
								'chartSpacingBottom'	=> 15,
								'chartSpacingLeft'		=> 0,
								'chartAlignTicks'		=> FALSE,
								'chartBackgroundColorLinearGradient' => array(0,0,0,0),
								'chartBackgroundColorStops'	=> array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
								'title'					=> 'Sales Volume',
								'titleAlign'			=> 'center',
								'titleFloating'			=> TRUE,
								'titleStyleFont'		=> '18px Metrophobic, Arial, sans-serif',
								'titleStyleColor'		=> '#0099ff',
								'titleX'				=> 20,
								'titleY'				=> 20,			
								'legendEnabled' 		=> TRUE,
								'legendLayout'			=> 'horizontal',
								'legendAlign'			=> 'center',
								'legendVerticalAlign '	=> 'bottom',
								'legendItemStyle'		=> array('color' => '#222'),
								'legendBackgroundColorLinearGradient' => array(0,0,0,25),
								'legendBackgroundColorStops' => array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
								'tooltipEnabled' 		=> FALSE,
								'xAxisLabelsEnabled' 	=> TRUE,
								'xAxisLabelsAlign' 		=> 'right',
								'xAxisLabelsStep' 		=> 1,
								'xAxislabelsX' 			=> 5,
								'xAxisLabelsY' 			=> 20,
								'xAxisCategories'       => $xAxisCategoryArray,
								'yAxisTitleText' 		=> 'Sales Volume',
								'enableAutoStep' 		=> FALSE,							
								'creditsText'       => '',
								'creditsURL'        => ''
						)
				);
				
				/* $series = $this->HighCharts->addChartSeries();			
				$series->addName('Sales Volume')->addData($total_monthly_salesvloume);			
				$mychart->addSeries($series); */
				
				/*====Show the volume for each processor for each month (change 15 Jul Ticket#1043)====== */
				foreach ($processorList as $processorID => $processorName){
					$processor_series_data = array();
					$series{$processorID} = $this->HighCharts->addChartSeries();
					foreach($previous_month as $monthtime){
						$processor_series_data[] = $processor_month_vol[$monthtime][$processorID];						
					}
					$series{$processorID}->addName($processorName)->addData($processor_series_data);
					$mychart->addSeries($series{$processorID});
				}
				
				
				// graph 2
				$chartName = 'Active Account Line Chart';
				$mychart = $this->HighCharts->create( $chartName, 'line' );
				$this->HighCharts->setChartParams(
						$chartName,
						array(
								'renderTo'				=> 'activelinewrapper',  // div to display chart inside
								'chartWidth'			=> 560,
								'chartHeight'			=> 450,
								'chartMarginTop' 		=> 60,
								'chartMarginLeft'		=> 90,
								'chartMarginRight'		=> 10,
								'chartMarginBottom'		=> 150,
								'chartSpacingRight'		=> 10,
								'chartSpacingBottom'	=> 15,
								'chartSpacingLeft'		=> 0,
								'chartAlignTicks'		=> FALSE,
								'chartBackgroundColorLinearGradient' => array(0,0,0,0),
								'chartBackgroundColorStops'	=> array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
								'title'					=> 'Active Accounts',
								'titleAlign'			=> 'center',
								'titleFloating'			=> TRUE,
								'titleStyleFont'		=> '18px Metrophobic, Arial, sans-serif',
								'titleStyleColor'		=> '#0099ff',
								'titleX'				=> 20,
								'titleY'				=> 20,
								'legendEnabled' 		=> TRUE,
								'legendLayout'			=> 'horizontal',
								'legendAlign'			=> 'right',
								'legendVerticalAlign '	=> 'bottom',
								'legendItemStyle'		=> array('color' => '#222'),
								'legendBackgroundColorLinearGradient' => array(0,0,0,25),
								'legendBackgroundColorStops' => array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
								'tooltipEnabled' 		=> FALSE,
								'xAxisLabelsEnabled' 	=> TRUE,
								'xAxisLabelsAlign' 		=> 'right',
								'xAxisLabelsStep' 		=> 1,
								'xAxislabelsX' 			=> 5,
								'xAxisLabelsY' 			=> 20,
								'xAxisCategories'       => $xAxisCategoryArray,
								'yAxisTitleText' 		=> 'Active Accounts',
								'enableAutoStep' 		=> FALSE,							
								'creditsText'       => '',
								'creditsURL'        => ''
						)
				);
					
				/* $series = $this->HighCharts->addChartSeries();
				$series->addName('Active Accounts')->addData($total_monthly_account);
				$mychart->addSeries($series); */
				
				/*====Show the total number of accounts for each processor for each month (change 15 Jul Ticket#1043)====== */
				foreach ($processorList as $processorID => $processorName){
					$processor_series_account_number = array();
					$series{$processorID} = $this->HighCharts->addChartSeries();
					foreach($previous_month as $monthtime){
						$processor_series_account_number[] = $processor_month_account[$monthtime][$processorID];
					}
					$series{$processorID}->addName($processorName)->addData($processor_series_account_number);
					$mychart->addSeries($series{$processorID});
				}
				
			}else{
				// get processors monthly vloume
				$total_monthly_salesvloume = array();				
				$total_monthly_account = array();				
				$processor_monthly_salesvloume = array();				
				$result = array();
				
				$month = $this->request->data['Report']['Month'];
				$year = $this->request->data['Report']['Year'];
				$monthtime = mktime(0, 0, 0, $month, 1, $year);
				
				$processorID = $this->request->data['Report']['Processor'];
				$selected_processor = array();
				if(is_array($processorID)){
					foreach($processorID as $processor){
						$selected_processor[$processor] = "";
					}					
					$processorList = array_intersect_key($processorList, $selected_processor);
				}				
				
				foreach ($processorList as $processorID => $processorName){
					$result = $this->Common->getProcessorMonthlyVolume($processorID,$monthtime);
					$processor_month_vol[$processorID] = $result['1'];
					$processor_month_income[$processorID] = $result['2'];
					$processor_month_account[$processorID] = $result['0'];
				}
				
				$total_monthly_salesvloume = array_sum($processor_month_vol);
				$total_monthly_income = array_sum($processor_month_income);
				$total_monthly_account = array_sum($processor_month_account);	
				
				// show record in grand total row in ctp file in table
				$this->set('totalsalesvolume',$total_monthly_salesvloume);
				$this->set('totalactiveaccounts',$total_monthly_account);
				$this->set('totaltotalappsincome',$total_monthly_income);
				
				// show record processors row in ctp file in table
				$this->set('processorList',$processorList);
				$this->set('salesvolume',$processor_month_vol);
				$this->set('activeaccounts',$processor_month_account);
				$this->set('totalincome',$processor_month_income);
				
			}
		
		}
		
		public function superadmin_meritcardreport( $MID = NULL )
		{
				// check user has permission or not , if yes allow otherwise not.
				$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
				if(!in_array(2, $allow)){
					$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
					die;
				}	
				//$this->loadModel('Commissionlog');
				
				$this->Commissionlog->unbindModel(
						//array('belongsTo' => array('Merchant'))
				);
				
				$options['joins'] = array( array('table' => 'merchants',
								'alias' => 'MT',
								'type' => 'inner',
								'conditions' => array(
										'MT.id = Commissionlog.merchantID'
								
								),
						)
				);
				
				if( !empty($this->request->data['Report']['Month']['month'])) {
					$options['conditions'][] = array('MONTH(date)'=>$this->request->data['Report']['Month']['month']);
				}
				if( !empty($this->request->data['Report']['Year']['year'])) {
					$options['conditions'][] = array('YEAR(date)'=>$this->request->data['Report']['Year']['year']);
				}
				
				$this->Merchant->unbindModel(array('belongsTo'=>array('Agent','Manager','ISO','Referal','Status','ProcessingMethod'),'hasMany'=>array('Commissionlog'),'hasOne'=>array('Commission')));
				$condition = "Processor.id = 1193 OR Processor.id = 1126 OR Processor.id = 788";
				$meritcard_marchats = $this->Merchant->find('all',array('fields'=>array('Merchant.id'),'conditions'=>array($condition)));
				$marchants_array = NULL;
				foreach ($meritcard_marchats as $mar )
					$marchants_array[] = $mar['Merchant']['id'];
					
				$options['conditions'][] = array('Commissionlog.merchantID'=>$marchants_array);
				//$options['limit'] = 10;
				$options['fields'] = array('Commissionlog.id','Commissionlog.MID','Commissionlog.transaction_numbers','Commissionlog.chargebacks_numbers','Commissionlog.date','Merchant.merchantName');
				//$options['conditions'] = array('MT.processorID'=>);
				
				if( $MID ) {
					
					$options['fields'] = array('Commissionlog.transaction_numbers','Commissionlog.chargebacks_numbers');
					$options['order'] = array('date DESC');
					
					for( $start_m = 0; $start_m  <= 5; $start_m ++ )
					{
						$month = date("m",strtotime("-" . $start_m . " month"));
						$year = date("Y",strtotime("-" . $start_m . " month"));
						$month_Year = date("M-Y",strtotime("-" . $start_m . " month"));
						$options['conditions'] = array('MID'=>$MID,'MONTH(date)'=>$month,'YEAR(date)'=>$year);
						$meritcard_data[$month_Year] = $this->Commissionlog->find('first',$options);
						//echo $this->Commissionlog->getLastQuery();
					}
					//pr($meritcard_data);die;
					$com_log = $this->Commissionlog->find('first',array('conditions'=>array('MID'=>$MID),'fields'=>array('Commissionlog.MID','Merchant.merchantName')));
					
					$this->set('MID',$com_log);
					$this->set('report_title','Meritcard');
					$this->set('meritcard_data',$meritcard_data);
					$this->render('superadmin_meritcardreport_bymarchat');
					
				}
				else 
				$meritcard_data = $this->Commissionlog->find('all',$options);
				$this->set('meritcard_data',$meritcard_data);
				//echo $this->Commissionlog->getLastQuery();
				
				
		}
		
		public function superadmin_meritusreport( $MID = NULL )
		{
			
				// check user has permission or not , if yes allow otherwise not.
				$allow = $this->Common->getReportPermission($this->Session->read('UserAuth.User.id'));
				if(!in_array(2, $allow)){
					$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
					die;
				}	
				//$this->loadModel('Commissionlog');
				
				$this->Commissionlog->unbindModel(
						//array('belongsTo' => array('Merchant'))
				);
				$options['joins'] = array(
						array('table' => 'merchants',
								'alias' => 'MT',
								'type' => 'inner',
								'conditions' => array(
										'MT.id = Commissionlog.merchantID'
								
								),
								'fields'=>'id',
								
						)
				);
				
				if( !empty($this->request->data['Report']['Month']['month'])) {
					$options['conditions'][] = array('MONTH(date)'=>$this->request->data['Report']['Month']['month']);
				}
				
				if( !empty($this->request->data['Report']['Year']['year'])) {
					$options['conditions'][] = array('YEAR(date)'=>$this->request->data['Report']['Year']['year']);
				}
				
				$this->Merchant->unbindModel(array('belongsTo'=>array('Agent','Manager','ISO','Referal','Status','ProcessingMethod'),'hasMany'=>array('Commissionlog'),'hasOne'=>array('Commission')));
				$condition = "Processor.id = 1197 OR Processor.id = 734 OR Processor.id = 719 OR Processor.id = 620";
				$meritcard_marchats = $this->Merchant->find('all',array('fields'=>array('Merchant.id'),'conditions'=>array($condition)));
				$marchants_array = NULL;
				foreach ($meritcard_marchats as $mar )
					$marchants_array[] = $mar['Merchant']['id'];
					
				$options['conditions'][] = array('Commissionlog.merchantID'=>$marchants_array);
				
				
				//$options['limit'] = 10;
				$options['fields'] = array('Commissionlog.id','Commissionlog.MID','Commissionlog.transaction_numbers','Commissionlog.chargebacks_numbers','Commissionlog.date','Merchant.merchantName');
				//$options['conditions'] = array('MT.processorID'=>);
				
				if( $MID ) {
					
					$options['fields'] = array('Commissionlog.transaction_numbers','Commissionlog.chargebacks_numbers');
					$options['order'] = array('date DESC');
					
					for( $start_m = 0; $start_m  <= 5; $start_m ++ )
					{
						$month = date("m",strtotime("-" . $start_m . " month"));
						$year = date("Y",strtotime("-" . $start_m . " month"));
						$month_Year = date("M-Y",strtotime("-" . $start_m . " month"));
						$options['conditions'] = array('MID'=>$MID,'MONTH(date)'=>$month,'YEAR(date)'=>$year);
						$meritcard_data[$month_Year] = $this->Commissionlog->find('first',$options);
						//echo $this->Commissionlog->getLastQuery();
					}
					//pr($meritcard_data);die;
					$com_log = $this->Commissionlog->find('first',array('conditions'=>array('MID'=>$MID),'fields'=>array('Commissionlog.MID','Merchant.merchantName')));
					$MID = $com_log;
					$report_title = "Meritus";
					$this->set(compact('MID','meritcard_data','report_title'));
					$this->render('superadmin_meritcardreport_bymarchat');
					
				}
				else 
				$meritcard_data = $this->Commissionlog->find('all',$options);
				$this->set('meritcard_data',$meritcard_data);
		}
		
		public function superadmin_paymentsetupfees()
		{
				
		}
		
		public function superadmin_conversion()
		{
				
		}
		
		public function superadmin_processor()
		{
				
				
		}
		
	 	public function beforeFilter()
		{
			parent::beforeFilter();
	   	}



	

		

}

?>
