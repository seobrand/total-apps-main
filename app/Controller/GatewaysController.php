<?php

// app/Controller/UsersController.php
class GatewaysController extends AppController {
	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		
		public $paginate = array(
			'limit' => 10,
			'order' => array(
				'Gateway.id' => 'desc'
			),
			'paramType' => 'querystring'
		);
		
		public function superadmin_addgateway() {		
		$errorsArr ='';	
		
		$GatewayList= $this->paginate();
		$this->set('GatewayList',$GatewayList);	
			
		if($this->request->is('post')){		
			$this->Gateway->set($this->request->data);
			if(!$this->Gateway->validates()) 
			{
				$errorsArr = $this->Gateway->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Gateway->save($this->request->data)) {
					$this->Session->write('popup','New Gateway has been added successfully.');			
					$this->Session->setFlash('New Gateway has been added successfully.');  
					$this->redirect(array('controller'=>'gateways','action' => "addgateway/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_editgateway($id = null) {		
		$errorsArr ='';	
		//$this->loadModel('Gateway');
		if($this->request->is('get')){
				$this->request->data = $this->Gateway->find('first',array('conditions'=>array('id'=>$id)));
		}
		else{			
			$this->Gateway->set($this->request->data);
			if(!$this->Gateway->validates()) 
			{
				$errorsArr = $this->Gateway->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
			
				if($this->Gateway->save($this->request->data)) {
					$this->Session->write('popup','Gateway has been Updated successfully.');			
					$this->Session->setFlash('Gateway has been Updated successfully.');  
					$this->redirect(array('controller'=>'gateways','action' => "addgateway/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_deletegateway($gatewayID= null) {
			//$this->loadModel('Gateway');
			if($this->Gateway->delete($gatewayID))
			{
				$this->Session->write('popup','Gateway has been deleted successfully.');			
				$this->Session->setFlash('Gateway has been deleted successfully.');  
				$this->redirect(array('controller'=>'gateways','action'=>"addgateway/message:success"));		
			}
		}
	 
	 	public function beforeFilter()
		{
			parent::beforeFilter();
	   	}

	
		
}
?>