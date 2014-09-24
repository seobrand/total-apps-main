<?php 
/**************************************************************************
 Coder  : Pushkar Soni
 Object : Controller to handle Area of interests add, edit and delete operation
**************************************************************************/ 
App::uses('CakeEmail', 'Network/Email');
class EmailTemplatesController extends AppController {
	var $name = 'EmailTemplates'; //Model name attached with this controller 
	var $layout = 'admin';
	var $helpers = array('Html','Text','Paginator','CakeGrid.Grid'); //add some other helpers to controller
	var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
	public $uses = array('Usermgmt.User','EmailTemplate','Usermgmt.UserGroupJoin','Merchant','ReportPermission');


 function superadmin_index() 
 {
 		$groupId=$this->Session->read('UserAuth.User.user_group_id');
		$userId=$this->Session->read('UserAuth.User.id');
		
		$this->paginate = array('all',
								'limit' => 50,
								'order' => array(
					    		       			'EmailTemplate.id'
						        				),
								'conditions'=>'EmailTemplate.user_group_id="1"  and EmailTemplate.user_id="'.$userId.'"',
								'paramType' => 'querystring'
							 );
		$templateRec = $this->paginate('EmailTemplate');
		$this->set('templateRec',$templateRec);
 }

	 function superadmin_templateView($templateId=NULL) 
	 {
			$templateRec=$this->EmailTemplate->find('first',array('conditions'=>'EmailTemplate.id="'.$templateId.'" '));
			$this->set('templateRec',$templateRec);
			$this->set('prePage',$this->referer());
	 }


	 function superadmin_myTemplate() 
	 {
	
	 
			$groupId=$this->Session->read('UserAuth.User.user_group_id');
			$userId=$this->Session->read('UserAuth.User.id');
			
			if($groupId!='1')
			{
				$this->paginate = array('all',
									'limit' => 50,
									'order' => array(
													'EmailTemplate.id'
													),
									'conditions'=>'EmailTemplate.user_group_id="1"',
									'paramType' => 'querystring'
								 );
				$adminTemplate = $this->paginate('EmailTemplate');
				$this->set('adminTemplate',$adminTemplate);
			}else
			{
				$this->paginate = array('all',
									'limit' => 50,
									'order' => array(
													'EmailTemplate.id'
													),
									'conditions'=>'EmailTemplate.user_group_id="1" and EmailTemplate.user_id!="'.$userId.'"',
									'paramType' => 'querystring'
								 );
				$adminTemplate = $this->paginate('EmailTemplate');
				$this->set('adminTemplate',$adminTemplate);
				
			}
			
			
			$this->paginate = array('all',
									'limit' => 50,
									'order' => array(
													'EmailTemplate.id'
													),
									'conditions'=>'EmailTemplate.user_group_id="'.$groupId.'" and EmailTemplate.user_id="'.$userId.'"',
									'paramType' => 'querystring'
								 );
								 
			$templateRec = $this->paginate('EmailTemplate');
			$this->set('templateRec',$templateRec);
	 }

	 /*********************************************************************
	 Function to save new Email Templates
	 **********************************************************************/
	 function superadmin_createTemplate() 
	 {
	 	$errors ='';
		
		
		
		if(!empty($this->request->data['SUBMIT']) && is_array($this->data))  
		{	
			$this->set('prePage',$this->request->data['EmailTemplate']['prePage']);
			$this->EmailTemplate->set($this->request->data['EmailTemplate']);
		
			if(!$this->EmailTemplate->validates())
			 {
				$errorsArr = $this->EmailTemplate->validationErrors;
				$errors =$errorsArr;
			 }
			if($errors)
			 {
				$this->set('errors',$errors);
				$this->set('data',$this->data);
			}
			else
			{ 
				$this->request->data['EmailTemplate']['user_group_id']=$this->Session->read('UserAuth.User.user_group_id');
				$this->request->data['EmailTemplate']['user_id']=$this->Session->read('UserAuth.User.id');
				
				if($this->EmailTemplate->save($this->data)) {
				$this->Session->write('popup','Email template has been created successfully.');
					
					$this->request->data['EmailTemplate']['prePage']=str_replace('/message:success','',$this->request->data['EmailTemplate']['prePage']);
					
					
					$this->redirect($this->request->data['EmailTemplate']['prePage'].'/message:success');
					
				//	$this->redirect(array('controller'=>'News','action'=>'newsList/message:success'));
					
					
					// echo $this->referer();
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}
		else
		{
			$this->set('prePage',$this->referer());
		}// end if of check data array
	} 
	
	function superadmin_editTemplate($id=NULL) 
	 {
	 	$errors ='';
		if(!empty($this->request->data['SUBMIT']) && is_array($this->data))  
		{	
			$this->set('prePage',$this->request->data['EmailTemplate']['prePage']);
			$this->EmailTemplate->set($this->request->data['EmailTemplate']);
			if(!$this->EmailTemplate->validates())
			 {
				$errorsArr = $this->EmailTemplate->validationErrors;
				$errors =$errorsArr;
			 }
			if($errors)
			 {
				$this->set('errors',$errors);
				$this->set('data',$this->data);
			}
			else
			{ 
				$this->request->data['EmailTemplate']['user_group_id']=$this->Session->read('UserAuth.User.user_group_id');
				$this->request->data['EmailTemplate']['user_id']=$this->Session->read('UserAuth.User.id');
				
				if($this->EmailTemplate->save($this->data)) {
					$this->Session->write('popup','Email template has been created successfully.');
					$this->request->data['EmailTemplate']['prePage']=str_replace('/message:success','',$this->request->data['EmailTemplate']['prePage']);
					$this->redirect($this->request->data['EmailTemplate']['prePage'].'/message:success');
					
				}	
				else 
				{
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}
		else
		{
			$this->set('prePage',$this->referer());
			$this->request->data=$this->EmailTemplate->find('first',array('conditions'=>'EmailTemplate.id="'.$id.'"'));
		}
	} 
	
	function superadmin_ajaxGetUser($ROLE= null,$STATUS	= null) 
	 {
			if($ROLE!='ALL')
			{
			$options['joins'] = array(
			    array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)
				);
				
				// PROCESSOR ID 23
			
				$options['conditions'] = array(    
					'UserGroupJoin.user_group_id' =>$ROLE,'User.active' =>$STATUS   
				);
				$options['fields'] = array(    
					'User.user_Name'    
				);
				$options['order'] = array(    
					'User.user_Name ASC'  
				);

				$UserList = $this->User->find('list',$options);
				$this->set('UserList',$UserList);
				
			}else
			{
				$userList = $this->User->find('list',array('fields'=>'userEmail,user_Name','conditions'=>'User.active="'.$STATUS.'"'));
				$this->set('UserList',$userList);
			}
	 }
	
	function superadmin_userBlastEmail() 
	 {
	 	$groupId=$this->Session->read('UserAuth.User.user_group_id');
		$userId=$this->Session->read('UserAuth.User.id');
		$templateList=$this->Common->getTemplatelist($userId,$groupId);
		$this->set('templateList',$templateList);
		
	
	
		$this->set('UserList',$this->Common->getAllUserList()); // get all user list
		
	
		if(!empty($this->request->data['Submit']) && is_array($this->data))  
		{	
			
			$this->EmailTemplate->set($this->request->data['EmailTemplate']);
			if(!$this->EmailTemplate->userMassEmail())
			 {
				$errorsArr = $this->EmailTemplate->validationErrors;
				$errors =$errorsArr;
				
				if($this->Session->read('UserAuth.User.user_group_id')=='1')
				{
					
					if(empty($this->request->data['EmailTemplate']['emailId']))
						{
							
							$errors['emailId']['0']='please select at least one user name';
							$this->set('emailIdError',$errors['emailId']['0']);
						}
				}
				
				
			}
			if($errors)
			 {
			 
				if($this->Session->read('UserAuth.User.user_group_id')=='1')
				{
					$ROLE=$this->request->data['EmailTemplate']['role'];
					$STATUS=$this->request->data['EmailTemplate']['active'];
					
					if($ROLE!='ALL')
					{
						$options['joins'] = array(
							array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)
						);
						
						$condition='';
						
						if(!empty($ROLE))
						{
							$condition.='UserGroupJoin.user_group_id="'.$ROLE.'"';
						}
						
						
						if(!empty($STATUS))
						{
							if($condition)
							{
								$condition.=' and User.active="'.$STATUS.'"';
							}else
							{
								$condition.=' User.active="'.$STATUS.'"';
							}
						}
				
						
						$options['conditions'] = array($condition);
						$options['fields'] = array(    
							'User.user_Name'    
						);
						$options['order'] = array(    
							'User.user_Name ASC'  
						);
		
						$UserList = $this->User->find('list',$options);
						
						$this->set('UserList',$UserList);
					
					}else
					{
						$userList = $this->User->find('list',array('fields'=>'userEmail,user_Name','conditions'=>'User.active="'.$STATUS.'"'));
						
						
						$this->set('UserList',$userList);
					}
			 	}
			 
				$this->set('errors',$errors);
				$this->set('data',$this->data);
				
			}
			else
			{
			$role=$this->request->data['EmailTemplate']['role'];
			
		 	$status=$this->request->data['EmailTemplate']['active'];
			$condition='';
			
			
			$sendfrom = $this->request->data['EmailTemplate']['from'];
			$subject = $this->request->data['EmailTemplate']['subject'];
			$bodyText = $this->request->data['EmailTemplate']['message'];
			$bodyText =str_replace('../../../app/webroot/',FULL_BASE_URL.router::url('/',false),$bodyText);
			
			switch($this->Session->read('UserAuth.User.user_group_id'))
			{
				case '1':
							if($this->request->data['EmailTemplate']['role']=='ALL')
								{
									
									$emailtotal=$this->User->find('all',array('fields'=>'User.userEmail'));
									
								}else
								{
									
								
									/*$emailtotal=$this->UserGroupJoin->find('all',array('fields'=>'User.userEmail,User.active',
																	'conditions'=>'UserGroupJoin.user_group_id="'.$this->request->data['EmailTemplate']['role'].'" 
																					and User.active="'.$status.'"
																	'));
																	*/
											$email='';						
									foreach($this->request->data['EmailTemplate']['emailId'] as $value)
										{
											$userEmail=$this->User->find('first',array('fields'=>'User.userEmail','conditions'=>'User.id="'.$value.'"','recursive'=>-1));
											
											if($userEmail['User']['userEmail'])
											{
													$sendto = $userEmail['User']['userEmail'];
													$email = new CakeEmail("smtp");
													$email->from(array($sendfrom));
													$email->to($sendto);
													$email->emailFormat('html');
													$email->subject($subject);
													$email->send($bodyText);
											}
										}
										
									$this->request->data['EmailTemplate']['prePage']=str_replace('/message:success','',$this->request->data['EmailTemplate']['prePage']);
									$this->request->data['EmailTemplate']['prePage']=str_replace('/message:success','',$this->request->data['EmailTemplate']['prePage']);
									
									$this->Session->write('popup','Email has been sent successfully.');
									$referer=str_replace('/message:success','',$this->referer());
									$referer=str_replace('/message:success','',$referer);
									$referer=str_replace('/message:success','',$referer);
									$referer=str_replace('/message:success','',$referer);
									$this->redirect($referer.'/message:success');
									
										
								}
							break;
				case '24':
							$emailtotal=$this->UserGroupJoin->find('all',array('fields'=>'User.userEmail',
															'conditions'=>'UserGroupJoin.user_group_id="'.$this->request->data['EmailTemplate']['role'].'" and 
																		  User.idManager="'.$userId.'" and User.active="'.$status.'"	'));
							break;
																		  
				case '22':
							$emailtotal=$this->UserGroupJoin->find('all',array('fields'=>'User.userEmail',
															'conditions'=>'UserGroupJoin.user_group_id="'.$this->request->data['EmailTemplate']['role'].'" and 
																		  User.idIso="'.$userId.'" and User.active="'.$status.'"'));
							break;	
			
				case '23':
							$emailtotal=$this->UserGroupJoin->find('all',array('fields'=>'User.userEmail',
															'conditions'=>'UserGroupJoin.user_group_id="'.$this->request->data['EmailTemplate']['role'].'" and 
																		  User.idProcessor="'.$userId.'" and User.active="'.$status.'"'));
							break;	
							
							
							
				default:
						$emailtotal=array();
						break;										  
			
			}
		
		
		
			$emailtotal=$this->UserGroupJoin->find('all',array('fields'=>'User.userEmail',
																	'conditions'=>'UserGroupJoin.user_group_id="'.$this->request->data['EmailTemplate']['role'].'"'));
			
			// mail sending to all users
				
				foreach($emailtotal as $value)
				{
					//var_dump(Validation::email('sdf'));die;
					if(Validation::email($value['User']['userEmail']))
					{
				
							$sendto = $value['User']['userEmail'];
							$email = new CakeEmail("smtp");
							$email->from(array($sendfrom));
							$email->to($sendto);
							$email->emailFormat('html');
							$email->subject($subject);
							$email->send($bodyText);
							
							
					}
				}
			
					
					$referer=str_replace('/message:success','',$this->referer());
					$referer=str_replace('/message:success','',$referer);
					$referer=str_replace('/message:success','',$referer);
					$referer=str_replace('/message:success','',$referer);
					
					$this->Session->write('popup','Email has been sent successfully.');
					$this->redirect($this->referer().'/message:success');	
				
						
						
			
			
			}//end if not error
		}
	 }
	 
	 function superadmin_merchantBlastEmail() 
	 {
			
	 	$groupId=$this->Session->read('UserAuth.User.user_group_id');
		$userId=$this->Session->read('UserAuth.User.id');
		$templateList=$this->Common->getTemplatelist($userId,$groupId);
		$this->set('templateList',$templateList);
	
		if(!empty($this->request->data['Submit']) && is_array($this->data))  
		{	
			$this->EmailTemplate->set($this->request->data['EmailTemplate']);
			if(!$this->EmailTemplate->merchantMassEmail())
			 {
				$errorsArr = $this->EmailTemplate->validationErrors;
				$errors =$errorsArr;
			 }
			if($errors)
			 {
				$this->set('errors',$errors);
				$this->set('data',$this->data);
			}
			else
			{
				$condition='1=1';
				
				if(is_array($this->request->data['EmailTemplate']['idProcessor']))
				{
					$condition.=" AND Merchant.processorID IN (".implode(",",$this->request->data['EmailTemplate']['idProcessor']).")";
				}
				
				if($this->request->data['EmailTemplate']['statusID'])
				{
					$condition.=" AND Merchant.statusID='".$this->request->data['EmailTemplate']['statusID']."'";
				}
			
				if($this->Session->read('UserAuth.User.user_group_id')!='1'){				
					$condition .= ' AND (Merchant.isoID="'.$userId.'" or Merchant.referalID="'.$userId.'" or Merchant.managerID="'.$userId.'" or Merchant.agentID="'.$userId.'" or Merchant.processorID="'.$userId.'")';
				}
				
				//echo $condition;die;
				$this->Merchant->recursive = 0;
				$merchantRec	=	$this->Merchant->find('all',array('fields'=>'DISTINCT  Merchant.contactEmail,Merchant.id,Merchant.managerID','conditions'=>$condition));
			
			
			// mail sending to all users
				$sendfrom = $this->request->data['EmailTemplate']['from'];
				$subject = $this->request->data['EmailTemplate']['subject'];
				$bodyText = $this->request->data['EmailTemplate']['message'];
				$bodyText =str_replace('../../../app/webroot/',FULL_BASE_URL.router::url('/',false),$bodyText);
	
				//pr($merchantRec);die;
				
				foreach($merchantRec as $value)
				{
					$mangerInfo=$this->Common->getUserInformation($value['Merchant']['managerID']);
					//pr($mangerInfo);
					$managerInformation="<div style='clear:both;'>
											".$mangerInfo['User']['user_Name']."<br>
											".$mangerInfo['User']['userPhone']."<br>
											".$mangerInfo['User']['userEmail']."<br>
											".$mangerInfo['User']['userCompany']."<br>
											".$mangerInfo['User']['userAddress']."<br>
										</div>";
										
					$bodyText.=$managerInformation;
					
					
					
					if(Validation::email($value['Merchant']['contactEmail']))
					{
						$sendto = $value['Merchant']['contactEmail'];						
						$email = new CakeEmail("smtp");
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
					}
				}
				
				$Refrer=str_replace('/message:success','',$this->referer());
				$this->Session->write('popup','Email has been sent successfully.');
				$this->redirect($Refrer.'/message:success');
				
			}//end if not error
		}
	 
	
	 }
	
	function superadmin_delete($id=NULL) { /* Function to delete Email Template */
	   $this->id = (int)$id;
			  if($this->EmailTemplate->delete($this->id,false)) 
			  { 
			  		$this->Session->write('popup','Email Template has been deleted successfully.');
					
					$referer=str_replace('/message:success','',$this->referer());
					$referer=str_replace('/message:success','',$referer);
					$this->redirect($referer.'/message:success');
			  }
			  else {
					$this->Session->setFlash('Deletion problem, Please try again.');  
					$this->redirect($this->referer());
				}
		}
	
	function getTemplate()
	{
	
	  	
	$templateRec=$this->EmailTemplate->find('first',array('fields'=>'EmailTemplate.message,EmailTemplate.subject,EmailTemplate.from','conditions'=>'EmailTemplate.id="'.$_GET['id'].'" '));

	echo json_encode($templateRec);

	
			exit;
	}
	
	/*
	 * Get the list of users by role
	* created by jitendra
	* created at oct 30, 2013
	* task 2244
	*/	 
	public function superadmin_getuserbyrole($role = null, $reportID = null){
		
		$options['joins'] = array(
				array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')	)
		);
		
		if($role!='no_role'){
			$options['conditions'] = array(
					'UserGroupJoin.user_group_id' => $role
			);
		}		
		$options['fields'] = array(
				'User.id',
				'User.user_Name'
		);
		$options['order'] = array(
				'User.user_Name ASC'
		);
		$userList = $this->User->find('list', $options);
		$this->set('UserList',$userList);
		
		if($reportID!='all'){
			$selected_users = $this->ReportPermission->find('list',array('fields'=>array('user_id'),'conditions'=>array('ReportPermission.reportlist_id'=>$reportID)));
			$this->set('selected_user',$selected_users);
		}else{
			$selected_users = $this->ReportPermission->find('list',array('fields'=>array('id','user_id'),'group'=>'user_id HAVING count(user_id) >= 10'));
			$this->set('selected_user',$selected_users);
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