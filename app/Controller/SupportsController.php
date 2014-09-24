<?php
// app/Controller/DocumentsController.php
App::uses('CakeEmail', 'Network/Email');
class SupportsController extends AppController {

	    var $layout = 'admin';

	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		var $uses=array('Folder','Document','Support','ReferralLink','User');
		
		/*
		 * function for add ticket
		 * created by gaurav bansal on 19 nov 2013
		 * task id 2424 and project id 153
		 */
		public function superadmin_index(){	
			if($this->request->data) /// check form submition
			{	
				if(!empty($this->request->data['Support']['Add']))  // new job entry
				{
					$this->Support->set($this->request->data);
					if(!$this->Support->supportValidation()) // checking validation
					{
						$errorsArr = $this->Document->validationErrors;
					}
					else
					{
						
						$userID = $this->Session->read('UserAuth.User.id');
						$userRoleID = $this->Session->read('UserAuth.User.user_group_id');
						
						/*App::import('Lib', 'Zendesk/Zendesk');
						$zd = new Zendesk(ZENDESK_ACCOUNTNAME, ZENDESK_USERNAME, ZENDESK_PASSWORD);	
						
						$result = $zd->create(ZENDESK_TICKETS, array(
								'details' => array(
										'description' => $this->request->data['Support']['address'],
										'subject' => $this->request->data['Support']['subject'],
										'external_id' => $userID
								)
						));*/
						/*
						   * api call for add ticket
						   * created by gaurav bansal on 19 nov 2013
						   * task id 2424 and project id 153
						   */
						  $json = '{
							"ticket":{
							  "subject":"'.$this->request->data['Support']['subject'].'",
							  "comment": { "body": "'.$this->request->data['Support']['address'].'" },
							  "priority": "urgent"
							}
						  }';
						  
						     $url = "https://totalapps.zendesk.com/api/v2/tickets.json";
							
							 $ch = curl_init();
							 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
							 curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
							 curl_setopt($ch, CURLOPT_URL, $url);
							 curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME.":".ZENDESK_PASSWORD);    
							 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
							 curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
							 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
							 curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
							 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							 curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
							 $output = curl_exec($ch);
							 curl_close($ch);
							 $zendtickets = json_decode($output,true); 
							 //echo '<pre>';print_r($zendtickets);die;
							 $result =  $zendtickets['ticket']['id'];
						
						if(!empty($result)){
							$this->request->data['Support']['zendesk_ticket_id'] = $result;
							$this->request->data['Support']['ticket_subject'] = $this->request->data['Support']['subject'];
							$this->request->data['Support']['ticket_description'] = $this->request->data['Support']['address'];
							$this->request->data['Support']['account_name'] = ZENDESK_ACCOUNTNAME;
							$this->request->data['Support']['create_user_id'] = $userID;
							$this->request->data['Support']['user_role_id'] = $userRoleID;							
							$this->Support->create();
							//print_r($this->request->data);die;
							$this->Support->save($this->request->data);								
							$this->Session->write('popup','New ticket has been added successfully');
							$this->redirect(array('controller'=>'supports','action'=>'index/message:success'));
						}else{
							$this->Session->write('popup','Some Zendesk API Error Occurs.');
							$this->redirect(array('controller'=>'supports','action'=>'index/message:failure'));
						}
					}
				}
			}
		}
		
		/*
		 * function for add ticket
		 * created by gaurav bansal on 20 nov 2013
		 * task id 2424 and project id 153
		 */
		
		public function superadmin_mojopayindex(){
			if($this->request->data) /// check form submition
			{	
				if(!empty($this->request->data['Support']['Add']))  // new job entry
				{
					$this->Support->set($this->request->data);
					if(!$this->Support->supportValidation()) // checking validation
					{
						$errorsArr = $this->Document->validationErrors;
					}
					else
					{
						
						$userID = $this->Session->read('UserAuth.User.id');
						$userRoleID = $this->Session->read('UserAuth.User.user_group_id');

						  $json = '{
							"ticket":{
							  "subject":"'.$this->request->data['Support']['subject'].'",
							  "comment": { "body": "'.$this->request->data['Support']['address'].'" },
							  "priority": "urgent"
							}
						  }';
						  
						     $url = "https://mojopay1.zendesk.com/api/v2/tickets.json";
							
							 $ch = curl_init();
							 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
							 curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
							 curl_setopt($ch, CURLOPT_URL, $url);
							 curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME_MP.":".ZENDESK_PASSWORD_MP);    
							 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
							 curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
							 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
							 curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
							 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							 curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
							 $output = curl_exec($ch);
							 curl_close($ch);
							 $zendtickets = json_decode($output,true); 
							 //echo '<pre>';print_r($zendtickets);die;
							 $result =  $zendtickets['ticket']['id'];
						
						if(!empty($result)){
							$this->request->data['Support']['zendesk_ticket_id'] = $result;
							$this->request->data['Support']['ticket_subject'] = $this->request->data['Support']['subject'];
							$this->request->data['Support']['ticket_description'] = $this->request->data['Support']['address'];
							$this->request->data['Support']['account_name'] = ZENDESK_ACCOUNTNAME_MP;
							$this->request->data['Support']['create_user_id'] = $userID;
							$this->request->data['Support']['user_role_id'] = $userRoleID;							
							$this->Support->create();
							$this->Support->save($this->request->data);								
							$this->Session->write('popup','New ticket has been added successfully');
							$this->redirect(array('controller'=>'supports','action'=>'mojopayindex/message:success'));
						}else{
							$this->Session->write('popup','Some Zendesk API Error Occurs.');
							$this->redirect(array('controller'=>'supports','action'=>'mojopayindex/message:failure'));
						}
					}
				}
			}
		}
		
		public function superadmin_ticket($pageNo = null){				
			/** Get list of ticket by API **/
			$userID 	= $this->Session->read('UserAuth.User.id');
			$userRoleID = $this->Session->read('UserAuth.User.user_group_id');
			
			if($pageNo == null){
				$pageNo = 1;
			}
		   //$url = "https://totalapps.zendesk.com/api/v2/tickets.json?sort_by=id&sort_order=desc";
		   //$url = "https://totalapps.zendesk.com/api/v2/tickets.json?page=$pageNo&per_page=30&sort_by=id&sort_order=desc";
		   //$url = "https://totalapps.zendesk.com/api/v2/tickets/22/comments.json";
		   //$url = "https://totalapps.zendesk.com/api/v2/search.json?query=type:ticket";
		   //$url = "https://totalapps.zendesk.com/api/v2/tickets/show_many.json?ids={188,187,128}";
		   
		   if($userRoleID==25){ // for referral login user
		   		$getOwnTicket = $this->Support->find('list',array('fields'=>'Support.zendesk_ticket_id','conditions'=>array('Support.create_user_id'=>$userID,'Support.user_role_id'=>25,'account_name'=>'totalapps'),'order'=>array('zendesk_ticket_id desc')));
		   		$ticketids = implode(",", $getOwnTicket);
		   		$url = "https://totalapps.zendesk.com/api/v2/tickets/show_many.json?ids={0,".$ticketids."}&sort_by=id&sort_order=desc";
		   }else{
		   		$url = "https://totalapps.zendesk.com/api/v2/tickets.json?page=$pageNo&per_page=30&sort_by=id&sort_order=desc";
		   }
		
		 
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
		   $zendtickets = json_decode($output,true); 
		   $cnt =  ceil($zendtickets['count'] / 30);
		   $this->set('alltickets',$zendtickets);
		   $this->set('pagecnt',$cnt);
		   $this->set('pageNo',$pageNo);
		  // echo $cnt =  ceil($zendtickets['count'] / 30);die;
			/* echo "<pre>";
			print_r($zendtickets);die;*/
		}
		
		/*
		 * function for add ticket
		 * created by gaurav bansal on 20 nov 2013
		 * task id 2424 and project id 153
		 */
		
		public function superadmin_mojopayticket($pageNo = null){				
			/** Get list of ticket by API **/
			$userID 	= $this->Session->read('UserAuth.User.id');
			$userRoleID = $this->Session->read('UserAuth.User.user_group_id');
			
			if($pageNo == null){
				$pageNo = 1;
			}
		   //$url = "https://totalapps.zendesk.com/api/v2/tickets.json?sort_by=id&sort_order=desc";
		  // $url = "https://mojopay.zendesk.com/api/v2/tickets.json?page=$pageNo&per_page=30&sort_by=id&sort_order=desc";
		   //$url = "https://totalapps.zendesk.com/api/v2/tickets/22/comments.json";
		   //$url = "https://totalapps.zendesk.com/api/v2/search.json?query=type:ticket";
		   if($userRoleID==25){ // for referral login user
			   	$getOwnTicket = $this->Support->find('list',array('fields'=>'Support.zendesk_ticket_id','conditions'=>array('Support.create_user_id'=>$userID,'Support.user_role_id'=>25,'account_name'=>'mojopay')));
			   	$ticketids = implode(",", $getOwnTicket);
		   		$url = "https://mojopay1.zendesk.com/api/v2/tickets/show_many.json?ids={0,".$ticketids."}&page=$pageNo&per_page=30&sort_by=id&sort_order=desc";
		   }else{
		   		$url = "https://mojopay1.zendesk.com/api/v2/tickets.json?page=$pageNo&per_page=30&sort_by=id&sort_order=desc";
		   }
		 
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
		   $zendtickets = json_decode($output,true); 
		   $cnt =  ceil($zendtickets['count'] / 30);
		   $this->set('alltickets',$zendtickets);
		   $this->set('pagecnt',$cnt);
		   $this->set('pageNo',$pageNo);
		  // echo $cnt =  ceil($zendtickets['count'] / 30);die;
			/* echo "<pre>";
			print_r($zendtickets);die;*/
		}
		
		/*
		 * ajax function for edit ticket
		 * created by gaurav bansal on 18 nov 2013
		 * task id 2424 and project id 153
		 */
		public function superadmin_edit_ticket_by_ajax($ticketID=null,$userId=null,$status=null,$type=null){
			// get userinfo
			
			 $url = "https://totalapps.zendesk.com/api/v2/users/{$userId}.json";		 
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
			 $username = $zendusers['user']['name'];
			  $this->set('username',$username);
			  /*$this->set('status_id',$status);
			  $this->set('type_id',$type);*/
			  $this->set('ticketID',$ticketID);
			  $this->request->data['Support']['status_id']=$status;
			  $this->request->data['Support']['type_id']=$type;
		}
		
		/*
		 * ajax function for edit ticket in mojopay
		 * created by gaurav bansal on 20 nov 2013
		 * task id 2424 and project id 153
		 */
		
		public function superadmin_mojopay_edit_ticket_by_ajax($ticketID=null,$userId=null,$status=null,$type=null){
			// get userinfo
			
			 $url = "https://mojopay1.zendesk.com/api/v2/users/{$userId}.json";		 
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
			 $username = $zendusers['user']['name'];
			  $this->set('username',$username);
			  /*$this->set('status_id',$status);
			  $this->set('type_id',$type);*/
			  $this->set('ticketID',$ticketID);
			  $this->request->data['Support']['status_id']=$status;
			  $this->request->data['Support']['type_id']=$type;
		}
		/*
		 * ajax function for view ticket
		 * created by gaurav bansal on 19 nov 2013
		 * task id 2424 and project id 153
		 */
	    public function superadmin_view_ticket_by_ajax($ticketID=null,$userId=null){
			// get userinfo
			
			 $url = "https://totalapps.zendesk.com/api/v2/tickets/$ticketID/comments.json";
		 
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
			 $zendcomments = json_decode($output,true); 
			 $comments = $zendcomments['comments'];
			// echo '<pre>';print_r($zendcomments);die;
			 
			 
			 $url = "https://totalapps.zendesk.com/api/v2/users/{$userId}.json";		 
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
			 
			 
			 $username = $zendusers['user']['name'];
			 $useremail = $zendusers['user']['email'];
			 $this->set('username',$username);
			 $this->set('useremail',$useremail);
			 $this->set('comments',$comments);
			 
        }
		
		/*
		 * ajax function for view ticket of mojopay
		 * created by gaurav bansal on 20 nov 2013
		 * task id 2424 and project id 153
		 */
		public function superadmin_mojopay_view_ticket_by_ajax($ticketID=null,$userId=null){
			// get userinfo
			
			 $url = "https://mojopay1.zendesk.com/api/v2/tickets/$ticketID/comments.json";
		 
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
			 $zendcomments = json_decode($output,true); 
			 $comments = $zendcomments['comments'];
			// echo '<pre>';print_r($zendcomments);die;
			 
			 
			 $url = "https://mojopay1.zendesk.com/api/v2/users/{$userId}.json";		 
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
			 
			 
			 $username = $zendusers['user']['name'];
			 $useremail = $zendusers['user']['email'];
			 $this->set('username',$username);
			 $this->set('useremail',$useremail);
			 $this->set('comments',$comments);
			 
        }

		public function superadmin_addcomment(){
			//App::import('Lib', 'Zendesk/Zendesk');
			// create object of zendesk 	
			//$zd = new Zendesk(ZENDESK_ACCOUNTNAME, ZENDESK_USERNAME, ZENDESK_PASSWORD);	
			
			if($this->request->data['Submit']=='Submit'){	
	
				  $ticketID = $this->request->data['Support']['ticketID'];
				  $status = $this->request->data['Support']['status_id'];
				  $type = $this->request->data['Support']['type_id'];
				  $comment = $this->request->data['Support']['comment'];	
				  
				$json = '{
					"ticket": {
						"comment": {
							"body": "'.$comment.'",
							"public": "true"
						},
						"status": "'.$status.'",
						"type":"'.$type.'"
					}
				}';
					  $url = "https://totalapps.zendesk.com/api/v2/tickets/{$ticketID}.json";
				   //$url = "https://totalapps.zendesk.com/api/v2/tickets.json?page=1&per_page=3";
				   //$url = "https://totalapps.zendesk.com/api/v2/tickets/22/comments.json";
				   //$url = "https://totalapps.zendesk.com/api/v2/search.json?query=type:ticket";
				 
				   $ch = curl_init();
				   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				   curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
				   curl_setopt($ch, CURLOPT_URL, $url);
				   curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME.":".ZENDESK_PASSWORD);    
				   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				   curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
				   curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
				   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				   curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
				   $output = curl_exec($ch);
				   curl_close($ch);
				   $zendtickets = json_decode($output,true); 
				   
					//echo '<pre>';print_r($zendtickets);	die;		
				
				
				if(!empty($zendtickets['ticket'])){
					$this->Session->write('popup','New comment has been added successfully.');
					$this->redirect(array('controller'=>'supports','action'=>'ticket/message:success'));					
				}else{
					$this->Session->write('popup','Some Zendesk API Error Occurs.');
					$this->redirect(array('controller'=>'supports','action'=>'ticket/message:failure'));
				}
			}
				
		}
		
		/*
		 * function for add comment on ticket of mojo pay
		 * created by gaurav bansal on 20 nov 2013
		 * task id 2424 and project id 153
		 */
		public function superadmin_mojopay_addcomment(){
			
			if($this->request->data['Submit']=='Submit'){	
	
				  $ticketID = $this->request->data['Support']['ticketID'];
				  $status = $this->request->data['Support']['status_id'];
				  $type = $this->request->data['Support']['type_id'];
				  $comment = $this->request->data['Support']['comment'];	
				  
				$json = '{
					"ticket": {
						"comment": {
							"body": "'.$comment.'",
							"public": "true"
						},
						"status": "'.$status.'",
						"type":"'.$type.'"
					}
				}';
					  $url = "https://mojopay1.zendesk.com/api/v2/tickets/{$ticketID}.json";
				   //$url = "https://totalapps.zendesk.com/api/v2/tickets.json?page=1&per_page=3";
				   //$url = "https://totalapps.zendesk.com/api/v2/tickets/22/comments.json";
				   //$url = "https://totalapps.zendesk.com/api/v2/search.json?query=type:ticket";
				 
				   $ch = curl_init();
				   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				   curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
				   curl_setopt($ch, CURLOPT_URL, $url);
				   curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME_MP.":".ZENDESK_PASSWORD_MP);    
				   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				   curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
				   curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
				   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				   curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
				   $output = curl_exec($ch);
				   curl_close($ch);
				   $zendtickets = json_decode($output,true); 
				   
					//echo '<pre>';print_r($zendtickets);	die;		
				
				
				if(!empty($zendtickets['ticket'])){
					$this->Session->write('popup','New comment has been added successfully.');
					$this->redirect(array('controller'=>'supports','action'=>'mojopayticket/message:success'));					
				}else{
					$this->Session->write('popup','Some Zendesk API Error Occurs.');
					$this->redirect(array('controller'=>'supports','action'=>'mojopayticket/message:failure'));
				}
			}
				
		}
		
		public function superadmin_deleteticket($ticketID=null){
			/*App::import('Lib', 'Zendesk/Zendesk');
			// create object of zendesk
			$zd = new Zendesk(ZENDESK_ACCOUNTNAME, ZENDESK_USERNAME, ZENDESK_PASSWORD);	
			$result_new = $zd->delete(ZENDESK_TICKETS, array(
					'id' => $ticketID
			));
*/

		    $url = "https://totalapps.zendesk.com/api/v2/tickets/{$ticketID}.json";

		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		   curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		   curl_setopt($ch, CURLOPT_URL, $url);
		   curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME.":".ZENDESK_PASSWORD);    
		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		   curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
		   $output = curl_exec($ch);
		   curl_close($ch);
		   $result_new = $output;
			if($result_new){
				$this->Support->delete($ticketID);
				$this->Session->write('popup','Ticket has been deleted successfully.');
				$this->redirect(array('controller'=>'supports','action'=>'ticket/message:success'));					
			}else{
				$this->Session->write('popup','Some Zendesk API Error Occurs.');
				$this->redirect(array('controller'=>'supports','action'=>'ticket/message:failure'));
			}
		}
		
		/*
		 * function for delete ticket in mojopay
		 * created by gaurav bansal on 20 nov 2013
		 * task id 2424 and project id 153
		 */
		public function superadmin_mojopay_deleteticket($ticketID=null){

		    $url = "https://mojopay1.zendesk.com/api/v2/tickets/{$ticketID}.json";

		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		   curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		   curl_setopt($ch, CURLOPT_URL, $url);
		   curl_setopt($ch, CURLOPT_USERPWD, ZENDESK_USERNAME_MP.":".ZENDESK_PASSWORD_MP);    
		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		   curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
		   $output = curl_exec($ch);
		   curl_close($ch);
		   $result_new = $output;
			if($result_new){
				$this->Support->delete($ticketID);
				$this->Session->write('popup','Ticket has been deleted successfully.');
				$this->redirect(array('controller'=>'supports','action'=>'mojopayticket/message:success'));					
			}else{
				$this->Session->write('popup','Some Zendesk API Error Occurs.');
				$this->redirect(array('controller'=>'supports','action'=>'mojopayticket/message:failure'));
			}
		}
		
		
		  /* Vishnu sharma Uses To submit support request
		  @ On 16-5-213
			*/
		 public function superadmin_submitrequest() {
		 	
		 	 $this->loadModel('RequestType');
		 	 $this->loadModel('Ticket');
		 	 $this->loadModel('TicketDocument');
		 	 $requestTypeList = $this->RequestType->find('list',array('conditions'=>array('display'=>0)));
		
			$this->set('typeLists',$requestTypeList); 
			if(!empty($this->data)){
		   	//echo '<pre>';print_r($this->data);die;
		   	$data['Ticket']['title'] 			= 	$this->data['Support']['title'];
			//$data['Ticket']['email'] 			= 	$this->data['Support']['email'];
			$data['Ticket']['eta_date'] 		= 	date("Y-m-d",strtotime($this->data['Support']['eta_date']));
		   	$data['Ticket']['user_id'] 		=  $this->Session->read('UserAuth.User.id');
		   	$data['Ticket']['priority']		= 	$this->data['Support']['priority'];
			$data['Ticket']['request_type'] = 	$this->data['Support']['request_type'];
		   	$data['Ticket']['comment']		= 	$this->data['Support']['comment'];
		   	$data['Ticket']['add_date'] 		= 	date('Y-m-d');
				$this->Ticket->save($data);	
				$lastId = $this->Ticket->getLastInsertID(); 
				//pr($this->data['Support']['document'][0]['name']); die;  	
		   	if(!empty($this->data['Support']['document']) && $this->data['Support']['document'][0]['name'] !=''){
		   		$uploadFile = $this->data['Support']['document'];
							
					foreach($uploadFile as $file){
		   			$docFileName = time().'_'.str_replace(' ','_',$file['name']);
		   			$destination = WWW_ROOT.'ticketDocument/'.$docFileName;
		   			//echo '<pre>';	print_r($destination);die;	
		   			move_uploaded_file($file['tmp_name'], $destination);
		   			$saveDoc['TicketDocument']['ticket_id'] 			= $lastId;
		   			$saveDoc['TicketDocument']['document_name'] 	= $docFileName;
		   			$saveDoc['TicketDocument']['add_date'] 			= date('Y-m-d');
						$this->TicketDocument->create();
		   			$this->TicketDocument->save($saveDoc);
		   			}
		   		
		   		}
		//==========================Email Functionality===============================
		// pr($this->data['Support']['email_send_to']);die;
			 $this->loadModel('RequestType');
		 	 $this->loadModel('Ticket');
		 	 $this->loadModel('TicketDocument');
		 	 
		 	 $this->Ticket->bindModel(array(
							'hasMany'=>array(
								'TicketDocument'=>array(
									'class'=>'TicketDocument',
									'foreignKey'=>'ticket_id'						
								)					
							),
							'belongsTo'=>array(
								'User'=>array(
									'class'=>'User',
									'foreignKey'=>'user_id',
									'fields' =>array('User.id','User.user_Name')					
								),
							'RequestType'=>array(
									'class'=>'RequestType',
									'foreignKey'=>'request_type',
									'fields' =>array('RequestType.id','RequestType.name')					
								)					
							)	 				
			 				),false);
		
			  	$req = $this->Ticket->find('first',array('conditions'=>array('Ticket.id'=>$lastId)));
		 		//echo '<pre>';print_r($submitedReq);die;
			
				$email = new CakeEmail("smtp");
				$subject = $req['Ticket']['title'];
				$email->from(array('services@total-apps.com'));
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				//attach the documents under DOCS					
				$attachment_array = array();
			
		if(!empty($req['TicketDocument']) && file_exists(WWW_ROOT."ticketDocument/".$document['document_name'])) {
			
			foreach($req['TicketDocument'] as $k => $document){
						$attachfilePath = WWW_ROOT."ticketDocument/".$document['document_name'];
						$attachment_array[$k] = $attachfilePath;	
							}
			$email->attachments($attachment_array);
			} 
			$bodyText .= '<b>Request Type</b> : '.$req['RequestType']['name'].'<br /><br />';
			$bodyText .= '<b>Description</b> : '.$req['Ticket']['comment'];
			
			$toArr = array('Taboosupport@total-apps.com','2001@dothejob.org');
			
				$email->to($toArr);
				//if(!empty($req['Ticket']['email']))
					//$email->cc(array($req['Ticket']['email']));
				
				$email->send($bodyText);
			
			//===================================End============================================	
				$this->Session->write('popup','Ticket request added successfully.');
				$this->redirect(array('controller'=>'supports','action'=>'submitrequest/message:success'));	
			 	}
			}

		/*Vishnu sharma Uses To view viewrequests
		  @ On 16-5-213*/
		public function superadmin_viewrequests($tabId=''){
			
		 	 $this->loadModel('RequestType');
		 	 $this->loadModel('Ticket');
		 	 $this->loadModel('TicketDocument');
		 	 $requestTypeList = $this->RequestType->find('list',array('conditions'=>array('OR'=>array('display'=>array(0,1)))));
			 $this->set('typeLists',$requestTypeList);
			
			 $this->set('tabId',$tabId);
			
			 $this->Ticket->bindModel(array(
							'hasMany'=>array(
								'TicketDocument'=>array(
									'class'=>'TicketDocument',
									'foreignKey'=>'ticket_id'						
								)					
							),
							'belongsTo'=>array(
								'User'=>array(
									'class'=>'User',
									'foreignKey'=>'user_id',
									'fields' =>array('User.id','User.user_Name')					
								),
							'RequestType'=>array(
									'class'=>'RequestType',
									'foreignKey'=>'request_type',
									'fields' =>array('RequestType.id','RequestType.name')					
								)					
							)	 				
			 				),false);
		
		
			 							
		 	 $rolId = $this->Session->read('UserAuth.User.user_group_id');	 
		 	 $userId = $this->Session->read('UserAuth.User.id');	 
			 $cond = ($rolId ==1)?array('conditions'=>array('1=1')):array('conditions'=>array('user_id'=>$userId));
			 $submitedReq = $this->Ticket->find('all',$cond);
			 //echo '<pre>';print_r($submitedReq);
			 $this->set('submitedReq',$submitedReq);
			}
	
		/*Vishnu sharma Uses To save ticket is approved or not
		  @ On 16-5-213*/
		public function superadmin_ticketapproved(){
			$this->loadModel('Ticket');
			if(!empty($this->data)){
		   	//pr($this->data);die;
		   	$varb = ($this->data['is_approved']=='1')?'approved':'declined';
		   	$varb = ($this->data['is_approved']=='3')?'Added to batch list':$varb;
			$varb = ($this->data['is_approved']=='4')?'Completed':$varb;
		   	$varb = ($this->data['is_approved']=='5')?'Deleted':$varb;
			
			$ids 	= 	$this->data['ids'];
		   	if($this->data['is_approved']=='5'){
				
				$this->Ticket->bindModel(array(
							'hasMany'=>array(
								'TicketDocument'=>array(
									'class'=>'TicketDocument',
									'foreignKey'=>'ticket_id'						
								)					
							)	 				
			 				),false);
				$submitedReq = $this->Ticket->find('all',array('conditions'=>array('id'=>$ids)));
				if(!empty($submitedReq)){
					foreach($submitedReq as $req){
						if(!empty($req['TicketDocument'])){
							foreach($req['TicketDocument'] as $doc){
								$docPath = WWW_ROOT.'ticketDocument/'.$doc['document_name'];
								if(file_exists($docPath))
									unlink($docPath);
							}
						}
					}
				}
				//pr($submitedReq);die;
				$this->Ticket->deleteAll(array('id' => $ids), false);
			}else{
				$data['Ticket.is_approved'] 	= 	"'".$this->data['is_approved']."'";
				$this->Ticket->updateAll($data,array('id'=>$ids)); 	
				if($this->data['is_approved']==1){
					$this->Ticket->bindModel(array(
							'hasMany'=>array(
									'TicketDocument'=>array(
											'class'=>'TicketDocument',
											'foreignKey'=>'ticket_id'
									)
							)
					),false);
					$submitedReq = $this->Ticket->find('all',array('conditions'=>array('id'=>$ids)));					
					foreach($submitedReq as $req){
						$email = new CakeEmail("smtp");
						$subject = $req['Ticket']['title'];
						$email->from(array('services@total-apps.com'));
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						//attach the documents under DOCS
						$attachment_array = array();						
						if(count($req['TicketDocument'])>0) {								
							foreach($req['TicketDocument'] as $k => $document){
								$attachfilePath = WWW_ROOT."ticketDocument/".$document['document_name'];
								if(file_exists($attachfilePath)){
									$attachment_array[$k] = $attachfilePath;
								}
							}
							$email->attachments($attachment_array);
						}
						$bodyText = $req['Ticket']['comment'];
						$sendTo = "jelmaleh@seobrand.net";//"jelmaleh@seobrand.net";
						//if(Validation::email('2001@dothejob.org')){
						$email->to($sendTo);
						$email->send($bodyText);
						//}
					}
				}
			}
		// send mail if admin add ticket in batch list
		 if($this->data['is_approved'] == '3' && $this->data['Support']['tab_id'] == '5'){
		// pr($this->data['Support']['email_send_to']);die;
			 $this->loadModel('RequestType');
		 	 $this->loadModel('Ticket');
		 	 $this->loadModel('TicketDocument');
		 	 
		 	 $this->Ticket->bindModel(array(
							'hasMany'=>array(
								'TicketDocument'=>array(
									'class'=>'TicketDocument',
									'foreignKey'=>'ticket_id'						
								)					
							),
							'belongsTo'=>array(
								'User'=>array(
									'class'=>'User',
									'foreignKey'=>'user_id',
									'fields' =>array('User.id','User.user_Name')					
								),
							'RequestType'=>array(
									'class'=>'RequestType',
									'foreignKey'=>'request_type',
									'fields' =>array('RequestType.id','RequestType.name')					
								)					
							)	 				
			 				),false);
		
			  $submitedReq = $this->Ticket->find('all',array('conditions'=>array('Ticket.id'=>$ids)));
		 		//echo '<pre>';print_r($submitedReq);die;
		
		    foreach($submitedReq as $req){
				
				$email = new CakeEmail("smtp");
				$subject = $req['Ticket']['title'];
				$email->from(array('services@total-apps.com'));
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				//attach the documents under DOCS					
				$attachment_array = array();
			
	if(!empty($req['TicketDocument']) && file_exists(WWW_ROOT."ticketDocument/".$document['document_name'])) {
			
			foreach($req['TicketDocument'] as $k => $document){
						$attachfilePath = WWW_ROOT."ticketDocument/".$document['document_name'];
						$attachment_array[$k] = $attachfilePath;	
							}
			$email->attachments($attachment_array);
			} 
			$bodyText .= $req['Ticket']['comment'];
			$toArr = explode(',',$this->data['Support']['email_send_to']);
			//if(Validation::email('2001@dothejob.org')){
				$email->to($toArr);
					$email->send($bodyText);
				//	}
				 }
			}
		   	
		   	$this->Session->write('popup','Ticket is '.$varb.' successfully.');
			$this->redirect(array('controller'=>'supports','action'=>'viewrequests/'.$this->data['Support']['tab_id'].'/message:success'));	
			}
			 	
		 }

	/*Vishnu sharma Uses To download file
	  @ On 16-5-213*/
	public function superadmin_downloadticketreq($docId=''){
		$this->loadModel('TicketDocument');
		$submitedReq = $this->TicketDocument->find('first',array('conditions'=>array('id'=>$docId)));
		$file_name = $submitedReq['TicketDocument']['document_name'];
		
		$file_url = Router::url('/', true).'ticketDocument/' . $file_name;
		
	    header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");
	    header("Content-Transfer-Encoding: Binary"); 
	    header("Content-disposition: attachment; filename=\"".$file_name."\""); 
	    readfile($file_url);
	 	die;
	}

	/*
	 * Public Function for add and list the referral links
	*/
	public function superadmin_referralLinks(){
		/* dropdown list values **/
		$userlist = $this->User->find('list',array('fields'=>array('id','user_Name'),'conditions'=>array('active'=>1),'order'=>array('user_Name ASC')));
		$referrallinks = $this->ReferralLink->find('list',array('fields'=>array('id','referral_link')));
		$this->set('userlist',$userlist);
		$this->set('referrallinks',$referrallinks);
		/** find list of assigned referral link users **/
		$this->User->unbindModel(array('hasMany' => array('UserGroupJoin')), true);
		$this->User->recursive = 2;
		$this->paginate = array('fields' => 'id,user_Name,referral_link_id',
				'conditions' => 'User.referral_link_id!=""',
				'limit' => 15,
				'paramType' => 'querystring'
		);
		$assignusers= $this->paginate('User');
		$this->set('assignusers', $assignusers);
			
		/** if form is submitted **/
		if($this->request->is('post')){
			if(isset($this->request->data['User'])){
				if(is_array($this->request->data['User']['userID']) && $this->request->data['User']['referral_link']!=''){
					foreach($this->request->data['User']['userID'] as $user){
						//$data = array('User' => array('id'=>$user,'user_referral_link'=>$this->request->data['User']['referral_link']));
						$success = $this->User->updateAll(
								array('User.referral_link_id' => '"'.$this->request->data['User']['referral_link'].'"'),
								array('User.id' => $user)
						);
					}
					$this->Session->write('popup','Successfully Assign.');
					$this->redirect(array('controller'=>'supports','action'=>'referralLinks/message:success'));
				}else{
					$this->Session->write('popup','Please select users and referral link both.');
					$this->redirect(array('controller'=>'supports','action'=>'referralLinks/message:failure'));
				}
			}else{
				$this->ReferralLink->save($this->request->data,false);
				$this->Session->write('popup','New referral link added successfully.');
				$this->redirect(array('controller'=>'supports','action'=>'referralLinks/message:success'));
			}
	
		}else{
			$this->request->data = $this->ReferralLink->find('first',array('conditions'=>array('id'=>1)));
		}
	
	}
	
	/*
	 * function to unassigned link from users
	*/
	public function superadmin_deleteReferralLink($userID=null){
		if($userID){
			$success = $this->User->updateAll(
					array('User.referral_link_id' => '""'),
					array('User.id' => $userID)
			);
			$this->Session->write('popup','Referral link has been deleted successfully.');
			$this->redirect(array('controller'=>'supports','action'=>'referralLinks/message:success'));
		}else{
			$this->Session->write('popup','User Not Exists.');
			$this->redirect(array('controller'=>'supports','action'=>'referralLinks/message:failure'));
		}
	}
	
	/*
	 * function to show list of referral link and add new referral link
	*/
	public function superadmin_manageReferralLink(){
		$this->paginate = array(
				'conditions' => 'id!=1',
				'limit' => 20,
				'paramType' => 'querystring'
		);
		$alllinks= $this->paginate('ReferralLink');
		$this->set('alllinks', $alllinks);
			
		if($this->request->is('post')){
			$this->ReferralLink->save($this->request->data,false);
			$this->Session->write('popup','New referral link added successfully.');
			$this->redirect(array('controller'=>'supports','action'=>'manageReferralLink/message:success'));
		}
	}
	
	/*
	 * function to delete link from ReferralLink
	*/
	public function superadmin_removeReferralLink($ID=null){
		if($ID){
			$success = $this->ReferralLink->delete($ID);
			$this->Session->write('popup','Referral link has been deleted successfully.');
			$this->redirect(array('controller'=>'supports','action'=>'manageReferralLink/message:success'));
		}else{
			$this->Session->write('popup','Referral Link Not Exists.');
			$this->redirect(array('controller'=>'supports','action'=>'manageReferralLink/message:failure'));
		}
	}
	
	public function beforeFilter()
	{
		parent::beforeFilter();
	}
	
	


}

?>
