<?php 
/**************************************************************************
 Coder  : Jitendra Pradhan 
 Object : Controller to handle Search and Print address
**************************************************************************/ 
class AddressesController extends AppController {
	var $name = 'Addresses'; //Model name attached with this controller 
	var $layout = 'admin';
	var $helpers = array('Html','Text','Paginator','CakeGrid.Grid'); //add some other helpers to controller
	var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
	public $uses = array('Usermgmt.User','Status','Usermgmt.UserGroupJoin','Merchant');


 	public function superadmin_searchuser(){
 		$resultCount = 0;
 		$address = "";
 		$filter_option = array('merchant'=>'Merchant','referral'=>'Referral','agent'=>'Agents');
 		$merchantstatus = "";
 		
 		$merchantstatus =  $this->Status->find("list", array("fields" => array("id", 'status'), "order" => array("Status.id ASC")));
 		$this->set('merchantstatus',$merchantstatus);
		$this->set('resultCount',$resultCount);
		
		$userlist = $this->User->find("list", array("fields" => array("id", 'user_Name'), "order" => array("User.user_Name ASC")));
		foreach($userlist as $value => $label){
			$useropt[] = array(
					'name' => $label,
					'value' => $value,
					'class' => 'user_checkbox',
					'onClick' => 'usercheck(this.value)'
			);
		}
		$this->set('userlist',$useropt);	
 	}
	
	public function superadmin_print_options(){
		$this->layout = 'ajax';
	}
 	
 	public function superadmin_showuseraddress(){
 		$this->layout =	'print';
 		$count = 1;
 		$pageBreakCount = 1; 		
 		
 		
 		if($this->request->is('post')){
			$col_val = $this->request->data['Address']['print_value'];
			$this->Session->delete('set_options');
 			$userType = $this->request->data['Address']['filterby'];
 			$class_name = ($col_val==2)? "two_column_avery" : "three_column_avery";
 			
 			$address = '<div id="box-wrapper"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="first_page" class="'.$class_name.'">';
 			
 			if(!is_array($this->request->data['Address']['userID'])){
 				$this->Session->write('popup','Please select merchant and user for print address!');
 				$this->Session->setFlash('Please select merchant and user for print address!');
 				$this->redirect(array('controller'=>'addresses','action' => "searchuser/message:failure"));
 				exit;
 			}
 			$total_count = count($this->request->data['Address']['userID']);
 			foreach($this->request->data['Address']['userID'] as $userID){
 				$userInfo = $this->Common->getUserNameAddress($userID,$userType); 				
 				if(($count-1)%$col_val==0){ 					
 					$address .="<tr>";
 				}
 				if($userType=='merchant'){
					
					$legalAddress='';
					$dbaAddress='';
					$legalCity='';
					$legalState='';
					$legalZip='';
				
					if($userInfo['Merchant']['legalAddress']){ 
						$legalAddress=$userInfo['Merchant']['legalAddress']; 
					}
					
					if($userInfo['Merchant']['legalCity']){ 
						$legalCity= '<br/>'.$userInfo['Merchant']['legalCity'];						
					}
					if($userInfo['Merchant']['legalState']){ 
						$legalState= ",&nbsp;".$userInfo['Merchant']['legalState']; 
					}
					if($userInfo['Merchant']['legalZip']){ 
						$legalZip= "<br/>".$userInfo['Merchant']['legalZip']; 
					}				
 					$address .= '<td class="box-first-col '.$class_name.'"><div class="'.$class_name.'_box"><strong>'.$userInfo['Merchant']['merchantName']."</strong><br>".$legalAddress."".$legalCity."".$legalState."".$legalZip.'</div></td>';
 					if($count%$col_val==0){
						$address .= '<td class="'.$class_name.'_blank-space-last">&nbsp;</td>';
					}else{
						$address .= '<td class="'.$class_name.'_blank-space">&nbsp;</td>';
					}
 					
 				}else{
					$address1 = $userInfo['User']['userAddress'];
					$address2=$userInfo['User']['userAddress2'];
					$userCity=$userInfo['User']['userCity'];
					$userState=$userInfo['User']['userState'];
					$userZip=$userInfo['User']['userZip'];
					$userCountry=$userInfo['User']['userCountry'];
					if($address1){
						$address1= "<br/>".$address1;
					}
					if($address2){ 
						$address2= "<br/>".$address2; 
					}
					if($userCity)
					{ 
							$userCity= "<br/>".$userCity;							
					}
					if($userState){ 
						$userState= ",&nbsp;".$userState; 
					}
					if($userZip){ 
						$userZip= "<br/>".$userZip;
					}
					if($userCountry){ 
						$userCountry= ",&nbsp;".$userCountry; 
					}
					
					$address .= '<td class="box-first-col '.$class_name.'"><div class="'.$class_name.'_box"><strong>'.$userInfo['User']['user_Name']."</strong>".$address1."".$address2."".$userCity."".$userState."".$userZip."".$userCountry.'</div></td>';
					if($count%$col_val==0){
						$address .= '<td class="'.$class_name.'_blank-space-last">&nbsp;</td>';
					}else{
						$address .= '<td class="'.$class_name.'_blank-space">&nbsp;</td>';
					}
 				}
 				
 				if($col_val==2){
 					if($count%14==0 && $count<$total_count){ 						
 						$address .= '</table><div class="pagebreak"></div>';
 						$address .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="'.$class_name.'">';
 					}
 					if($count==$total_count && $total_count%2!=0){
 						$address .= ($total_count%2!=0)? '<td class="box-first-col '.$class_name.'" style="visibility:hidden"><div class="'.$class_name.'_box"></div></td><td class="'.$class_name.'_blank-space-last">&nbsp;</td>':'';
 					} 					
 				}else{
 					if($count%30==0 && $count<$total_count){
 						$address .= '</table><div class="pagebreak"></div>';
 						$address .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="'.$class_name.'">';
 					} 					
 					if($count==$total_count){
 						if($total_count%3==1){
 							$address .= '<td class="box-first-col '.$class_name.'" style="visibility:hidden"><div class="'.$class_name.'_box"></div></td><td class="'.$class_name.'_blank-space">&nbsp;</td><td class="box-first-col '.$class_name.'" style="visibility:hidden"></td><td class="'.$class_name.'_blank-space-last">&nbsp;</td>'; 							
 						}elseif($total_count%3==2){
 							$address .= '<td class="box-first-col '.$class_name.'" style="visibility:hidden"><div class="'.$class_name.'_box"></div></td><td class="'.$class_name.'_blank-space-last">&nbsp;</td>';
 						} 						
 					}
 				}
 				
 				$count++;
 			}
 						
 			$address .= "</table></div>"; 			
 			$this->set('resultCount', $total_count);
 			$this->set('resultAddress',$address);
 			$this->set('col_val',$col_val);
 		}else{ 			
 			$this->redirect(array('controller'=>'addresses','action' => "searchuser"));
 			exit;
 		}
 	}
 	
 	public function superadmin_getuserbyfilter($filterby=null,$status=null){
 		//get merchant list
 		if($filterby=='merchant'){
 			$merchant = $this->Merchant->find('list',array('fields'=>array('Merchant.id','Merchant.merchantName'),'conditions'=>array('Merchant.statusID'=>$status)));
 			$this->set('UserList',$merchant);
 		}
 		// get users list
 		if($filterby=='referral' || $filterby=='agent'){
 				if($filterby=='referral')
 					$groupID = '25';
 				else 
 					$groupID = '20';
 				
 				$options['joins'] = array(
			    	array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id'))
				);				
				// PROCESSOR ID 23			
				$options['conditions'] = array(    
					'UserGroupJoin.user_group_id' =>$groupID,'User.active' =>$status   
				);
				$options['fields'] = array(    
					'User.id','User.user_Name'    
				);
				$options['order'] = array(    
					'User.user_Name ASC'  
				);

				$UserList = $this->User->find('list',$options);
				$this->set('UserList',$UserList);
 		}
 			
 	}
 	
 	public function superadmin_getmerchantbyuser($filterby=null,$status=null,$userID=null){
 		//get merchant list
 		if($filterby=='merchant'){
 			if($userID!='')
 			{
	 			$condition = "Merchant.statusID=".$status." AND (Merchant.agentID IN (".$userID.") OR Merchant.managerID IN (".$userID.") OR Merchant.isoID IN (".$userID.") OR Merchant.processorID IN (".$userID.") OR Merchant.referalID IN (".$userID."))";
	 			$merchant = $this->Merchant->find('list',array('fields'=>array('Merchant.id','Merchant.merchantName'),'conditions'=>$condition));
	 			$this->set('UserList',$merchant);
 			}else{
 				$condition = "Merchant.statusID=".$status;
 				$merchant = $this->Merchant->find('list',array('fields'=>array('Merchant.id','Merchant.merchantName'),'conditions'=>$condition));
 				$this->set('UserList',$merchant);
 			}
 		}
 	}
		
	
	function beforeFilter() { 
		parent::beforeFilter();
      
   	}
	
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
	
	} 
}//end class
?>