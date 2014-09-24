<?php

// app/Controller/UsersController.php
class StatusesController extends AppController {
	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		
		public $paginate = array(
			'limit' => 10,
			'order' => array(
				'Status.id' => 'desc'
			),
			'paramType' => 'querystring'
		);
		
		public function superadmin_addstatus() {		
		$errorsArr ='';	
		
		$this->set('title_for_layout','Merchant Status');
		
		$StatusList= $this->paginate();
		$this->set('StatusList',$StatusList);
		
		if($this->request->is('post')){			
			$this->Status->set($this->request->data);
			if(!$this->Status->validates()) 
			{
				$errorsArr = $this->Status->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->request->data['Status']['navigationOrder']=='')
					$this->request->data['Status']['navigationOrder'] =0;
					
				if($this->Status->save($this->request->data)) {
					$this->Session->write('popup','New Status has been added successfully.');			
					$this->Session->setFlash('New Status has been added successfully.');  
					$this->redirect(array('controller'=>'statuses','action' => "addstatus/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_editstatus($statusID = null) {		
		$errorsArr ='';	
		//$this->loadModel('Status');
		if($this->request->is('get')){
			$this->request->data = $this->Status->find('first',array('conditions'=>array('id'=>$statusID)));
		}else
		{			
			$this->Status->set($this->request->data);
			if(!$this->Status->validates()) 
			{
				$errorsArr = $this->Status->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->request->data['Status']['navigationOrder']=='')
					$this->request->data['Status']['navigationOrder'] =0;
					
				if($this->Status->save($this->request->data)) {
					$this->Session->write('popup','Status has been Updated successfully.');			
					$this->Session->setFlash('Status has been Updated successfully.');  
					$this->redirect(array('controller'=>'statuses','action' => "addstatus/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_deletestatus($statusID= null) {
			if($this->Status->delete($statusID))
			{
				$this->Session->write('popup','Status has been deleted successfully.');			
				$this->Session->setFlash('Status has been deleted successfully.');  
				$this->redirect(array('controller'=>'statuses','action'=>"addstatus/message:success"));		
			}
		}
	 
	 	public function beforeFilter()
		{
			parent::beforeFilter();
	   	}

	
		
}
?>