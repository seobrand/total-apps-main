<?php
/*
 * Mass Merchant Controller
 * task #2000 (Used to search merchant which are associated to user and update infromation of merchats)
 * created by Jitendra
 * 
 */

App::uses('CakeEmail', 'Network/Email');

class MassMerchantUpdatesController extends AppController {

	var $layout = 'admin';
	var $helpers = array('Html','Text','Paginator','Number'); //add some other helpers to controller
	var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler','Paginator');
	var $uses = array('Usermgmt.UserGroup','Usermgmt.User','Merchant','Status','Accountcat','Accounttype','Gateway','Merchantpipeline','Merchantnote','MerchantBulkModificationRollback','Status');
	
	/*
	 * Function for search merchants associated to users.
	 * created by jitendra on 09 oct 2013
	 */
	public function superadmin_merchantsearch(){
		ini_set('memory_limit', '8000M');
		ini_set('max_execution_time', 600);
		// check user has permission or not , if yes allow otherwise not.		
		$loginuser = $this->Session->read('UserAuth.User.id');
		if($loginuser!=2 && $loginuser!=1266){
			$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
			die;
		}
		
		$status_option	=	array('1'=>'Active','0'=>'Inactive','2'=>'Both Active /Inactive');
		$this->set('user_status',$status_option);	
		
		//=========== All Dropdown values ================
		$this->Set('statusList', $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.navigationOrder ASC"))));
		$this->Set('acat_list', $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder asc"))));
		$this->Set('gatwayList', $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC"))));
		//task id 3834 28-march-2014
		$this->Set('merchantCatList', $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC"))));		
		$agentList =$this->Common->getAgentList(1);
		$this->Set('agentList', $agentList);
		$referalList =$this->Common->getReferalList(1);
		$this->Set('referalList', $referalList);
		$procList =$this->Common->getProcessorList(1);
		$this->Set('procList', $procList);
		$mangList = $this->Common->getManagerList(1);
		$this->Set('mangList', $mangList);
		$isoList = $this->Common->getIsoList(1);
		$this->Set('isoList', $isoList);
		
		if($this->request->is('post')){
			if(is_array($this->request->data['MassMerchantUpdates']['gatewayID'])){
				$gatewayids = implode(",",$this->request->data['MassMerchantUpdates']['gatewayID']);				
			}
			if(is_array($this->request->data['MassMerchantUpdates']['accountCategory'])){
				$acc_cats = implode(",",$this->request->data['MassMerchantUpdates']['accountCategory']);				
			}
			if(is_array($this->request->data['MassMerchantUpdates']['processorID'])){
				$processorids = implode(",",$this->request->data['MassMerchantUpdates']['processorID']);
			}
			if(is_array($this->request->data['MassMerchantUpdates']['isoID'])){
				$isoids = implode(",",$this->request->data['MassMerchantUpdates']['isoID']);
			}
			if(is_array($this->request->data['MassMerchantUpdates']['statusID'])){
				//updated as task id 3651 on 12-03-2014
				$status_array = array_merge($this->request->data['MassMerchantUpdates']['statusID'],array(6,19,20,21,23,24,27));
				$statusids = implode(",",$status_array);
			}
			if(is_array($this->request->data['MassMerchantUpdates']['agentID'])){
				$agentids = implode(",",$this->request->data['MassMerchantUpdates']['agentID']);
			}
			if(is_array($this->request->data['MassMerchantUpdates']['managerID'])){
				$managerids = implode(",",$this->request->data['MassMerchantUpdates']['managerID']);
			}
			if(is_array($this->request->data['MassMerchantUpdates']['referalID'])){
				$referralids = implode(",",$this->request->data['MassMerchantUpdates']['referalID']);
			}
			// task id 3834 28-march-2014
			if(is_array($this->request->data['MassMerchantUpdates']['accountTypeID'])){
				$accountTypeIDs = implode(",",$this->request->data['MassMerchantUpdates']['accountTypeID']);
			}			
			
			// business logic for search merchants
			//$search_condition = "Merchant.merchantName!=''";(task id 3651)
			$search_condition = "1=1";			
				
			// if merchant status select
			if($statusids!=NULL){
				$status_cond = " AND (";
				if(substr($statusids, 0,1)==0){ //if blank checkbox is select
					$status_cond .= "Merchant.statusID IS NULL OR ";
				}
				$status_cond .= "Merchant.statusID IN (".$statusids.")";
				$status_cond .= ")";
				$search_condition .= $status_cond;
			}
			// if merchant gateway select
			if($gatewayids!=NULL){
				$gateway_cond = " AND (";
				if(substr($gatewayids, 0,1)==0){ //if blank checkbox is select
					$gateway_cond .= "Merchant.gatewayID IS NULL OR ";
				}			
				$gateway_cond .= "Merchant.gatewayID IN (".$gatewayids.")";
				$gateway_cond .= ")";
				$search_condition .= $gateway_cond;
			}
			// if merchant processing method select
			if($acc_cats!=NULL){
				$acc_cat_cond = " AND (";
				if(substr($acc_cats, 0,1)==0){ //if blank checkbox is select
					$acc_cat_cond .= "Merchant.accountCategory IS NULL OR ";
				}
				$acc_cat_cond .= "Merchant.accountCategory IN (".$acc_cats.")";
				$acc_cat_cond .= ")";
				$search_condition .= $acc_cat_cond;
			}
			// if merchant processor select
			if($processorids!=NULL){
				$processorid_cond = " AND (";
				if(substr($processorids, 0,1)==0){ //if blank checkbox is select
					$processorid_cond .= "Merchant.processorID IS NULL OR ";
				}
				$processorid_cond .= "Merchant.processorID IN (".$processorids.")";
				$processorid_cond .= ")";
				$search_condition .= $processorid_cond;
			}
			// if merchant iso select
			if($isoids!=NULL){
				$isoid_cond = " AND (";
				if(substr($isoids, 0,1)==0){ //if blank checkbox is select
					$isoid_cond .= "Merchant.isoID IS NULL OR ";
				}
				$isoid_cond .= "Merchant.isoID IN (".$isoids.")";
				$isoid_cond .= ")";
				$search_condition .= $isoid_cond;
			}
			// if merchant agent select
			if($agentids!=NULL){
				$agentid_cond = " AND (";
				if(substr($agentids, 0,1)==0){ //if blank checkbox is select
					$agentid_cond .= "Merchant.agentID IS NULL OR ";
				}
				$agentid_cond .= "Merchant.agentID IN (".$agentids.")";
				$agentid_cond .= ")";
				$search_condition .= $agentid_cond;
			}
			// if merchant manager select
			if($managerids!=NULL){
				$managerid_cond = " AND (";
				if(substr($managerids, 0,1)==0){ //if blank checkbox is select
					$managerid_cond .= "Merchant.managerID IS NULL OR ";
				}
				$managerid_cond .= "Merchant.managerID IN (".$managerids.")";
				$managerid_cond .= ")";
				$search_condition .= $managerid_cond;
			}
			// if merchant referral select
			if($referralids!=NULL){
				$referralid_cond = " AND (";
				if(substr($referralids, 0,1)==0){ //if blank checkbox is select
					$referralid_cond .= "Merchant.referalID IS NULL OR ";
				}
				$referralid_cond .= "Merchant.referalID IN (".$referralids.")";
				$referralid_cond .= ")";
				$search_condition .= $referralid_cond;
			}
			// if merchant category select (task id 3834 28-march-2014)
			if($accountTypeIDs!=NULL){
				$merchantcat_cond = " AND (";
				if(substr($accountTypeIDs, 0,1)==0){ //if blank checkbox is select
					$merchantcat_cond .= "Merchant.accountTypeID IS NULL OR ";
				}
				$merchantcat_cond .= "Merchant.accountTypeID IN (".$accountTypeIDs.")";
				$merchantcat_cond .= ")";
				$search_condition .= $merchantcat_cond;
			}
			//echo $search_condition;die;
			if(strlen($search_condition)>0){
				/* $this->Merchant->recursive = -1;
				$count = $this->Merchant->find('count',array('conditions'=>array($search_condition)));	 */		
				$this->Merchant->recursive = -1;
				$this->paginate = array('fields' => 'Merchant.id,Merchant.merchantName,Merchant.CID,Merchant.gatewayID,Merchant.accountCategory,Merchant.processorID,Merchant.isoID,Merchant.statusID,Merchant.agentID,Merchant.managerID,Merchant.referalID,Merchant.accountTypeID',
						'conditions' => array($search_condition),
						'limit' => 2000,
						'order' => array(
								'Merchant.id' => 'DESC','Merchant.merchantName' => 'ASC'
						),
						'paramType' => 'querystring'
				);
					
				$merchantlist = $this->paginate('Merchant');
				$this->set('merchantlist',$merchantlist);
				//echo count($merchantlist);
			}
		}	
		
	}
	
	/*
	 * function for getting user list dynamic by status and user role
	 * created for ticket 2000
	 * updated for ticket 3033
	 * created date 11-oct-2013
	 * updated date 31-Jan-2014
	 */
	public function superadmin_getuserbyajax($status=null)
	{
			$status_sql  = "";
			if($status==2){
				$status_sql = "AND User.active IN (0,1)";
			}else{
				$status_sql = "AND User.active = ".$status;
			}
			$options['joins'] = array(
					array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id'))
			);
			$options['fields'] = array(
					'User.id',
					'User.user_Name'
			);
			$options['order'] = array(
					'User.user_Name ASC'
			);
			$this->User->recursive = 0;
			
			// Agent List
			$agent_condition = "UserGroupJoin.user_group_id = 20 ".$status_sql;	
			$options['conditions'] = $agent_condition;			
			$AgentList = $this->User->find('list',$options);
			foreach($AgentList as $value => $label){
				$agt_opt[] = array(
						'name' => $label,
						'value' => $value
				);
			}
			$this->set('AgentList',$agt_opt);
			
			// Manager List
			$mgr_condition = "UserGroupJoin.user_group_id = 24 ".$status_sql;
			$options['conditions'] = $mgr_condition;
			$ManagerList = $this->User->find('list',$options);
			foreach($ManagerList as $value => $label){
				$mgr_opt[] = array(
						'name' => $label,
						'value' => $value
				);
			}
			$this->set('ManagerList',$mgr_opt);
			
			// ISO List
			$iso_condition = "UserGroupJoin.user_group_id = 22 ".$status_sql;
			$options['conditions'] = $iso_condition;
			$ISOList = $this->User->find('list',$options);
			foreach($ISOList as $value => $label){
				$iso_opt[] = array(
						'name' => $label,
						'value' => $value
				);
			}
			$this->set('ISOList',$iso_opt);
			
			// Processor List
			$pro_condition = "UserGroupJoin.user_group_id = 23 ".$status_sql;
			$options['conditions'] = $pro_condition;
			$ProcessorList = $this->User->find('list',$options);
			foreach($ProcessorList as $value => $label){
				$pro_opt[] = array(
						'name' => $label,
						'value' => $value
				);
			}
			$this->set('ProcessorList',$pro_opt);
			
			// Referral List
			$ref_condition = "UserGroupJoin.user_group_id = 25 ".$status_sql;
			$options['conditions'] = $ref_condition;
			$ReferralList = $this->User->find('list',$options);
			foreach($ReferralList as $value => $label){
				$ref_opt[] = array(
						'name' => $label,
						'value' => $value
				);
			}
			$this->set('ReferralList',$ref_opt);		
		
	}
	
	/*
	* function for showing merchant mass updates for approval from admin
	* ticket 2000
	* 22-oct-2013
	*/
	public function superadmin_approve()
	{
		// check user has permission or not , if yes allow otherwise not.
		$loginuser = $this->Session->read('UserAuth.User.id');
		if($loginuser!=2 && $loginuser!=1266){
			$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
			die;
		}
		/* ==================== Set previous form value for before approval ================= */
		$updated_merchant['merchantID'] = array();
		if(!empty($this->request->data['modified_merchant']['merchantID'])){
			$updated_merchant['merchantID'] = explode(",",$this->request->data['modified_merchant']['merchantID']);
			$this->Session->write('updated_uncheck_merchant',$updated_merchant['merchantID']);
		}else{
			$this->Session->delete('updated_uncheck_merchant');
		}
		
		$selected_merchant = array();
		$selected_merchant['merchantID'] = array();
		if(isset($this->request->data['mass_merchant_id'])){
			$selected_merchant = $this->request->data['mass_merchant_id'];
			$this->Session->write('checked_merchant',$selected_merchant['merchantID']);
		}else{
			$this->Session->delete('checked_merchant');
		}
		
		if(isset($this->request->data['merchant_select_all'])){
			$this->Session->write('merchant_select_all',$this->request->data['merchant_select_all']);
		}else{
			$this->Session->delete('merchant_select_all');
		}
		
		if(is_array($this->request->data['MassMerchantUpdate'])){
			$this->Session->write('MassMerchantUpdate',$this->request->data['MassMerchantUpdate']);
		}
		
		if(is_array($this->request->data['Merchant'])){
			$this->Session->write('Merchant',$this->request->data['Merchant']);
		}
		
		if(is_array($this->request->data['MerchantOldValue'])){
			$this->Session->write('MerchantOldValue',$this->request->data['MerchantOldValue']);
		}
		
		$all_update_merchant['merchantID'] = array_unique(array_merge($selected_merchant['merchantID'],$updated_merchant['merchantID']));
		if(count($all_update_merchant)>0){
			$this->Session->write('mass_merchant_id',$all_update_merchant);
		}else{
			$this->Session->delete('mass_merchant_id');
		}
		
		
		//=========== All Dropdown values ================
		$status = $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.navigationOrder ASC")));
		$this->set('status', $status);
		
		$acat_list = $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder asc")));
		$this->set('acat_list', $acat_list);
			
		$gatwayList = $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
		$this->set('gatwayList', $gatwayList);
		//task id 3834 on 28-march-2014	
		$merchantCatList =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		$this->set('merchantCatList',$merchantCatList);
		
		$agentList =$this->Common->getAgentList();
		$this->set('agentList', $agentList);
		
		$referalList =$this->Common->getReferalList();
		$this->set('referalList', $referalList);
		
		$procList =$this->Common->getProcessorList();
		$this->set('procList', $procList);
		
		$mangList = $this->Common->getManagerList();
		$this->set('mangList', $mangList);
		
		$isoList = $this->Common->getIsoList();
		$this->set('isoList', $isoList);
		
		/* ==================== Set previous form value for after approval ================= */
			
		if($this->request->data['Submit']=='Approve'){	
			$created_time = date("Y-m-d H:i:s",strtotime(CURRENTDATE));
			$approve_update = $this->request->data['final_array'];
			$MerchantOldValue = $this->Session->read('MerchantOldValue');			
			foreach ($approve_update as $merchantID => $merchant_update){				
				// update merchant data in bulk
				$merchant_data['Merchant']['id'] 				= 	$merchantID;
				$merchant_data['Merchant']['gatewayID'] 		= 	$merchant_update['gatewayID'];
				$merchant_data['Merchant']['accountCategory'] 	= 	$merchant_update['accountCategory'];
				$merchant_data['Merchant']['processorID'] 		= 	$merchant_update['processorID'];
				$merchant_data['Merchant']['isoID'] 			= 	$merchant_update['isoID'];
				$merchant_data['Merchant']['statusID'] 			= 	$merchant_update['statusID'];
				$merchant_data['Merchant']['agentID'] 			= 	$merchant_update['agentID'];
				$merchant_data['Merchant']['managerID'] 		= 	$merchant_update['managerID'];
				$merchant_data['Merchant']['referalID'] 		= 	$merchant_update['referalID'];
				$merchant_data['Merchant']['accountTypeID']		= 	$merchant_update['accountTypeID'];
				$this->Merchant->save($merchant_data);
				
				// compare changed value to old values
				$difference = array_diff_assoc($approve_update[$merchantID],$MerchantOldValue[$merchantID]);
				
				$note ="";
				if(count($difference)>0){
					$note .= "Merchant information changed from bulk modification as follows:<br/>";
					foreach($difference as $key => $newValue){
						if($key=='gatewayID'){
							$gateway_from = !empty($gatwayList[$MerchantOldValue[$merchantID]['gatewayID']]) ? $gatwayList[$MerchantOldValue[$merchantID]['gatewayID']]:"Null Value";
							$gateway_to = !empty($gatwayList[$approve_update[$merchantID]['gatewayID']]) ? $gatwayList[$approve_update[$merchantID]['gatewayID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Gateway changed from <strong>".$gateway_from." To ".$gateway_to."</strong><br/>";
						}
						if($key=='accountCategory'){
							$proMethod_from = !empty($acat_list[$MerchantOldValue[$merchantID]['accountCategory']]) ? $acat_list[$MerchantOldValue[$merchantID]['accountCategory']]:"Null Value";
							$proMethod_to = !empty($acat_list[$approve_update[$merchantID]['accountCategory']]) ? $acat_list[$approve_update[$merchantID]['accountCategory']]:"Null Value";
							$note .= "&nbsp;&nbsp;Processing method changed from <strong>".$proMethod_from." To ".$proMethod_to."</strong><br/>";
						}
						if($key=='processorID'){
							$processor_from = !empty($procList[$MerchantOldValue[$merchantID]['processorID']]) ? $procList[$MerchantOldValue[$merchantID]['processorID']]:"Null Value";
							$processor_to = !empty($procList[$approve_update[$merchantID]['processorID']]) ? $procList[$approve_update[$merchantID]['processorID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Processor changed from <strong>".$processor_from." To ".$processor_to."</strong><br/>";
						}
						if($key=='isoID'){
							$iso_from = !empty($isoList[$MerchantOldValue[$merchantID]['isoID']]) ? $isoList[$MerchantOldValue[$merchantID]['isoID']]:"Null Value";
							$iso_to = !empty($isoList[$approve_update[$merchantID]['isoID']]) ? $isoList[$approve_update[$merchantID]['isoID']]:"Null Value";
							$note .= "&nbsp;&nbsp;ISO changed from <strong>".$iso_from." To ".$iso_to."</strong><br/>";
						}
						if($key=='statusID'){
							$status_from = !empty($status[$MerchantOldValue[$merchantID]['statusID']]) ? $status[$MerchantOldValue[$merchantID]['statusID']]:"Null Value";
							$status_to = !empty($status[$approve_update[$merchantID]['statusID']]) ? $status[$approve_update[$merchantID]['statusID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Status changed from <strong>".$status_from." To ".$status_to."</strong><br/>";
							// Add status update in merchant pipeline							
							$pipelineData = array();
							$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
							$pipelineData['Merchantpipeline']['statusFrom'] = $MerchantOldValue[$merchantID]['statusID'];
							$pipelineData['Merchantpipeline']['statusTo'] = $approve_update[$merchantID]['statusID'];
							$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
							if($status_from == 'Null Value'){
								$pipelineData['Merchantpipeline']['statusFrom'] = 0;
							}
							if($status_to == 'Null Value'){
								$pipelineData['Merchantpipeline']['statusTo'] = 0;
							}
							$this->Merchantpipeline->save($pipelineData);
						}
						if($key=='agentID'){
							$agent_from = !empty($agentList[$MerchantOldValue[$merchantID]['agentID']]) ? $agentList[$MerchantOldValue[$merchantID]['agentID']]:"Null Value";
							$agent_to = !empty($agentList[$approve_update[$merchantID]['agentID']]) ? $agentList[$approve_update[$merchantID]['agentID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Agent changed from <strong>".$agent_from." To ".$agent_to."</strong><br/>";
						}
						if($key=='managerID'){
							$manager_from = !empty($mangList[$MerchantOldValue[$merchantID]['managerID']]) ? $mangList[$MerchantOldValue[$merchantID]['managerID']]:"Null Value";
							$manager_to = !empty($mangList[$approve_update[$merchantID]['managerID']]) ? $mangList[$approve_update[$merchantID]['managerID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Manager changed from <strong>".$manager_from." To ".$manager_to."</strong><br/>";
						}
						if($key=='referalID'){
							$referral_from = !empty($referalList[$MerchantOldValue[$merchantID]['referalID']]) ? $referalList[$MerchantOldValue[$merchantID]['referalID']]:"Null Value";
							$referral_to = !empty($referalList[$approve_update[$merchantID]['referalID']]) ? $referalList[$approve_update[$merchantID]['referalID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Referral changed from <strong>".$referral_from." To ".$referral_to."</strong><br/>";
						}
						//task id 3834 on 28-march-2014	
						if($key=='accountTypeID'){
							$merchantcat_from = !empty($merchantCatList[$MerchantOldValue[$merchantID]['accountTypeID']]) ? $merchantCatList[$MerchantOldValue[$merchantID]['accountTypeID']]:"Null Value";
							$merchantcat_to = !empty($merchantCatList[$approve_update[$merchantID]['accountTypeID']]) ? $merchantCatList[$approve_update[$merchantID]['accountTypeID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Merchant category changed from <strong>".$merchantcat_from." To ".$merchantcat_to."</strong><br/>";
						}
					}
					//echo $note;die;
					//add merchant notes when change in merchant information
					$this->Merchantnote->create();
					$noteData = array();
					$changedBy = $this->Session->read('UserAuth.User.user_Name');
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = $note;
					$this->Merchantnote->save($noteData);	

					// insert log value for rollback functionality
					$this->MerchantBulkModificationRollback->create();
					$rollbackData = array();
					$rollbackData['MerchantBulkModificationRollback']['merchantID'] 		= 	$merchantID;
					$rollbackData['MerchantBulkModificationRollback']['gatewayID'] 			= 	$MerchantOldValue[$merchantID]['gatewayID'];
					$rollbackData['MerchantBulkModificationRollback']['accountCategory'] 	= 	$MerchantOldValue[$merchantID]['accountCategory'];
					$rollbackData['MerchantBulkModificationRollback']['processorID'] 		= 	$MerchantOldValue[$merchantID]['processorID'];
					$rollbackData['MerchantBulkModificationRollback']['isoID'] 				= 	$MerchantOldValue[$merchantID]['isoID'];
					$rollbackData['MerchantBulkModificationRollback']['statusID'] 			= 	$MerchantOldValue[$merchantID]['statusID'];
					$rollbackData['MerchantBulkModificationRollback']['agentID'] 			= 	$MerchantOldValue[$merchantID]['agentID'];
					$rollbackData['MerchantBulkModificationRollback']['managerID'] 			= 	$MerchantOldValue[$merchantID]['managerID'];
					$rollbackData['MerchantBulkModificationRollback']['referalID'] 			= 	$MerchantOldValue[$merchantID]['referalID'];
					$rollbackData['MerchantBulkModificationRollback']['accountTypeID']		= 	$MerchantOldValue[$merchantID]['accountTypeID'];
					$rollbackData['MerchantBulkModificationRollback']['created'] 			= 	$created_time;
					$rollbackData['MerchantBulkModificationRollback']['created_by'] 		= 	$this->Session->read('UserAuth.User.user_Name');
					$this->MerchantBulkModificationRollback->save($rollbackData);
				} // end of if condition
			} // end of first foreach loop
			
			$this->Session->write('popup','Merchant mass modification updated successfully.');
			// delete all session after process finish
			$this->Session->delete('merchant_select_all');
			$this->Session->delete('MassMerchantUpdate');
			$this->Session->delete('mass_merchant_id');
			$this->Session->delete('Merchant');
			$this->Session->delete('MerchantOldValue');
			$this->Session->delete('updated_uncheck_merchant');
			$this->Session->delete('checked_merchant');
			$this->redirect(array('controller'=>'mass_merchant_updates','action' => "merchantsearch/message:success"));
			
		}
			
	}
	
	
	/*
	* function for ROLLBAK PREVIOUS CHANGED MERCHANT DATA 
	* ticket 2000
	* 22-oct-2013
	*/
	public function superadmin_rollback()
	{
		ini_set('memory_limit', '8000M');
		ini_set('max_execution_time', 600);
		// check user has permission or not , if yes allow otherwise not.
		$loginuser = $this->Session->read('UserAuth.User.id');
		if($loginuser!=2 && $loginuser!=1266){
			$this->redirect(array('controller'=>'users','action' => "dashboard",'plugin'=>"usermgmt"));
			die;
		}
		//=========== All Dropdown values ================
		$status = $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.navigationOrder ASC")));
		$this->set('status', $status);
		
		$acat_list = $this->Accountcat->find("list", array("fields" => array("id", 'accountCategory'), "order" => array("Accountcat.navigationOrder asc")));
		$this->set('acat_list', $acat_list);
			
		$gatwayList = $this->Gateway->find("list", array("fields" => array("id", 'gatewayName'), "order" => array("Gateway.gatewayName ASC")));
		$this->set('gatwayList', $gatwayList);
		
		//task id 3834 on 28-march-2014
		$merchantCatList =  $this->Accounttype->find("list", array("fields" => array("id", 'accountType'), "order" => array("Accounttype.accountType ASC")));
		$this->set('merchantCatList',$merchantCatList);
			
		$agentList =$this->Common->getAgentList();
		$this->set('agentList', $agentList);
		
		$referalList =$this->Common->getReferalList();
		$this->set('referalList', $referalList);
		
		$procList =$this->Common->getProcessorList();
		$this->set('procList', $procList);
		
		$mangList = $this->Common->getManagerList();
		$this->set('mangList', $mangList);
		
		$isoList = $this->Common->getIsoList();
		$this->set('isoList', $isoList);		
		
		if($this->request->is('get')){
			// print the list of Mass Merchant History			
			$history = $this->MerchantBulkModificationRollback->find('all',array('order'=>'created DESC'));			
			$this->set('history',$history);
			$this->MerchantBulkModificationRollback->recursive = -1;
			$this->paginate = array('fields' => 'distinct(created) as created,created_by',
					'limit' => 10,
					'order'	=> array('created'=>'DESC'),
					'group' => array('created'),
					'paramType' => 'querystring'
			);			
			$history_dates = $this->paginate('MerchantBulkModificationRollback');			
			$this->set('history_dates',$history_dates);
		}
		
		if($this->request->is('post')){
			$created_time = date("Y-m-d H:i:s",strtotime(CURRENTDATE));
			$rollback_date = $this->request->data['Rollback']['rollback_date'];
			$this->MerchantBulkModificationRollback->recursive = -1;
			$rollback_merchants = $this->MerchantBulkModificationRollback->find('all',array('conditions'=>array('created'=>$rollback_date)));
			
			foreach($rollback_merchants as $merchant){
				$merchantID = $merchantdata['id'] 	= $merchant['MerchantBulkModificationRollback']['merchantID'];
				$merchantdata['gatewayID'] 			= $merchant['MerchantBulkModificationRollback']['gatewayID'];
				$merchantdata['accountCategory'] 	= $merchant['MerchantBulkModificationRollback']['accountCategory'];
				$merchantdata['processorID'] 		= $merchant['MerchantBulkModificationRollback']['processorID'];
				$merchantdata['isoID'] 				= $merchant['MerchantBulkModificationRollback']['isoID'];
				$merchantdata['statusID'] 			= $merchant['MerchantBulkModificationRollback']['statusID'];
				$merchantdata['agentID'] 			= $merchant['MerchantBulkModificationRollback']['agentID'];
				$merchantdata['managerID'] 			= $merchant['MerchantBulkModificationRollback']['managerID'];
				$merchantdata['referalID'] 			= $merchant['MerchantBulkModificationRollback']['referalID'];
				$merchantdata['accountTypeID']		= $merchant['MerchantBulkModificationRollback']['accountTypeID'];
				
				// find the merchant current information for log
				$this->Merchant->recursive = -1;
				$merchantLog = $this->Merchant->find('first',array('fields' => 'id,gatewayID,accountCategory,accountTypeID,processorID,isoID,statusID,agentID,managerID,referalID','conditions'=>array('id'=>$merchantID)));
				
				// compare changed value to old values
				$difference = array_diff_assoc($merchantLog['Merchant'],$merchantdata);
				
				$note = "";
				if(count($difference)>0){
					$note .= "Merchant information changed from bulk modification as follows:<br/>";
					foreach($difference as $key => $newValue){
						if($key=='gatewayID'){
							$gateway_from = !empty($gatwayList[$merchantLog['Merchant']['gatewayID']]) ? $gatwayList[$merchantLog['Merchant']['gatewayID']]:"Null Value";
							$gateway_to = !empty($gatwayList[$merchantdata['gatewayID']]) ? $gatwayList[$merchantdata['gatewayID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Gateway changed from <strong>".$gateway_from." To ".$gateway_to."</strong><br/>";
						}
						if($key=='accountCategory'){
							$proMethod_from = !empty($acat_list[$merchantLog['Merchant']['accountCategory']]) ? $acat_list[$merchantLog['Merchant']['accountCategory']]:"Null Value";
							$proMethod_to = !empty($acat_list[$merchantdata['accountCategory']]) ? $acat_list[$merchantdata['accountCategory']]:"Null Value";
							$note .= "&nbsp;&nbsp;Processing method changed from <strong>".$proMethod_from." To ".$proMethod_to."</strong><br/>";
						}
						if($key=='processorID'){
							$processor_from = !empty($procList[$merchantLog['Merchant']['processorID']]) ? $procList[$merchantLog['Merchant']['processorID']]:"Null Value";
							$processor_to = !empty($procList[$merchantdata['processorID']]) ? $procList[$merchantdata['processorID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Processor changed from <strong>".$processor_from." To ".$processor_to."</strong><br/>";
						}
						if($key=='isoID'){
							$iso_from = !empty($isoList[$merchantLog['Merchant']['isoID']]) ? $isoList[$merchantLog['Merchant']['isoID']]:"Null Value";
							$iso_to = !empty($isoList[$merchantdata['isoID']]) ? $isoList[$merchantdata['isoID']]:"Null Value";
							$note .= "&nbsp;&nbsp;ISO changed from <strong>".$iso_from." To ".$iso_to."</strong><br/>";
						}
						if($key=='statusID'){
							$status_from = !empty($status[$merchantLog['Merchant']['statusID']]) ? $status[$merchantLog['Merchant']['statusID']]:"Null Value";
							$status_to = !empty($status[$merchantdata['statusID']]) ? $status[$merchantdata['statusID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Status changed from <strong>".$status_from." To ".$status_to."</strong><br/>";
							// Add status update in merchant pipeline
							$pipelineData = array();
							$pipelineData['Merchantpipeline']['merchantID'] = $merchantID;
							$pipelineData['Merchantpipeline']['statusFrom'] = $merchantLog['Merchant']['statusID'];
							$pipelineData['Merchantpipeline']['statusTo'] 	= $merchantdata['statusID'];
							$pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");
							if($status_from == 'Null Value'){
								$pipelineData['Merchantpipeline']['statusFrom'] =  0;
							}
							if($status_to == 'Null Value'){
								$pipelineData['Merchantpipeline']['statusTo'] = 0;
							}
							$this->Merchantpipeline->save($pipelineData);
						}
						if($key=='agentID'){
							$agent_from = !empty($agentList[$merchantLog['Merchant']['agentID']]) ? $agentList[$merchantLog['Merchant']['agentID']]:"Null Value";
							$agent_to = !empty($agentList[$merchantdata['agentID']]) ? $agentList[$merchantdata['agentID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Agent changed from <strong>".$agent_from." To ".$agent_to."</strong><br/>";
						}
						if($key=='managerID'){
							$manager_from = !empty($mangList[$merchantLog['Merchant']['managerID']]) ? $mangList[$merchantLog['Merchant']['managerID']]:"Null Value";
							$manager_to = !empty($mangList[$merchantdata['managerID']]) ? $mangList[$merchantdata['managerID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Manager changed from <strong>".$manager_from." To ".$manager_to."</strong><br/>";
						}
						if($key=='referalID'){
							$referral_from = !empty($referalList[$merchantLog['Merchant']['referalID']]) ? $referalList[$merchantLog['Merchant']['referalID']]:"Null Value";
							$referral_to = !empty($referalList[$merchantdata['referalID']]) ? $referalList[$merchantdata['referalID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Referral changed from <strong>".$referral_from." To ".$referral_to."</strong><br/>";
						}
						//task id 3834 on 28-march-2014
						if($key=='accountTypeID'){
							$merchantcat_from = !empty($merchantCatList[$merchantLog['Merchant']['accountTypeID']]) ? $merchantCatList[$merchantLog['Merchant']['accountTypeID']]:"Null Value";
							$merchantcat_to = !empty($merchantCatList[$merchantdata['accountTypeID']]) ? $merchantCatList[$merchantdata['accountTypeID']]:"Null Value";
							$note .= "&nbsp;&nbsp;Merchant category changed from <strong>".$merchantcat_from." To ".$merchantcat_to."</strong><br/>";
						}
					}
					//echo $note;die;
					//add merchant notes when change in merchant information
					$this->Merchantnote->create();
					$noteData = array();
					$changedBy = $this->Session->read('UserAuth.User.user_Name');
					$noteData['Merchantnote']['merchantID'] = $merchantID;
					$noteData['Merchantnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
					$timestamp = CURRENTDATE;
					$noteData['Merchantnote']['timeStamp'] = $timestamp;
					$noteData['Merchantnote']['note'] = $note;
					$this->Merchantnote->save($noteData);
				
					// insert log value for rollback functionality
					$this->MerchantBulkModificationRollback->create();
					$rollbackData = array();
					$rollbackData['MerchantBulkModificationRollback']['merchantID'] 		= 	$merchantID;
					$rollbackData['MerchantBulkModificationRollback']['gatewayID'] 			= 	$merchantLog['Merchant']['gatewayID'];
					$rollbackData['MerchantBulkModificationRollback']['accountCategory'] 	= 	$merchantLog['Merchant']['accountCategory'];
					$rollbackData['MerchantBulkModificationRollback']['processorID'] 		= 	$merchantLog['Merchant']['processorID'];
					$rollbackData['MerchantBulkModificationRollback']['isoID'] 				= 	$merchantLog['Merchant']['isoID'];
					$rollbackData['MerchantBulkModificationRollback']['statusID'] 			= 	$merchantLog['Merchant']['statusID'];
					$rollbackData['MerchantBulkModificationRollback']['agentID'] 			= 	$merchantLog['Merchant']['agentID'];
					$rollbackData['MerchantBulkModificationRollback']['managerID'] 			= 	$merchantLog['Merchant']['managerID'];
					$rollbackData['MerchantBulkModificationRollback']['referalID'] 			= 	$merchantLog['Merchant']['referalID'];
					$rollbackData['MerchantBulkModificationRollback']['accountTypeID']		= 	$merchantLog['Merchant']['accountTypeID'];
					$rollbackData['MerchantBulkModificationRollback']['created'] 			= 	$created_time;
					$rollbackData['MerchantBulkModificationRollback']['created_by'] 		= 	$this->Session->read('UserAuth.User.user_Name');
					$this->MerchantBulkModificationRollback->save($rollbackData);
				} // end of if condition
				
				$this->Merchant->save($merchantdata);
			}
			
			$this->Session->write('popup','Merchant rollback process finished successfully.');	
			$this->redirect(array('controller'=>'mass_merchant_updates','action' => "rollback/message:success"));
		}
		
	}
	
	
} // end of MerchantsController class