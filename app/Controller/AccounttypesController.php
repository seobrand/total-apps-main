<?php

// app/Controller/UsersController.php alex
class AccounttypesController extends AppController {
	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		
		public $paginate = array(
			'limit' => 10,
			'order' => array(
				'Accounttype.id' => 'desc'
			),
			'paramType' => 'querystring'
		);
		
		public function superadmin_addaccounttypes() {		
		$errorsArr ='';	
		
		//=============== Account List ================
			 $this->paginate = array(
									'all',
									'limit' => 15,
									'order' => array(
														'Accounttype.navigationOrder' => 'ASC'
        											),
									'paramType' => 'querystring'
	 							);
			$AccountList = $this->paginate();
			$this->set('AccountList',$AccountList);	
		//============ End ============================
		if($this->request->is('post')){
			$this->Accounttype->set($this->request->data);
			if(!$this->Accounttype->validates()) 
			{
				$errorsArr = $this->Accounttype->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Accounttype->save($this->request->data)) {
					$this->Session->write('popup','New Merchant category has been added successfully.');			
					$this->Session->setFlash('New Merchant category has been added successfully.');  
					$this->redirect(array('controller'=>'accounttypes','action' => "viewlist/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_editaccounttypes($accountID = null) {		
		$errorsArr ='';	
		$this->loadModel('Accounttype');
		if($this->request->is('get')){
			$this->request->data = $this->Accounttype->find('first',array('conditions'=>array('id'=>$accountID)));
		}else
		{			
			$this->Accounttype->set($this->request->data);
			if(!$this->Accounttype->validates()) 
			{
				$errorsArr = $this->Accounttype->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Accounttype->save($this->request->data)) {
					$this->Session->write('popup','Merchant category has been Updated successfully.');			
					$this->Session->setFlash('Merchant category has been Updated successfully.');  
					$this->redirect(array('controller'=>'accounttypes','action' => "editaccounttypes/".$accountID."/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_deleteaccounttypes($accountID= null) {
			$this->loadModel('Accounttype');
			if($this->Accounttype->delete($accountID))
			{
				$this->Session->write('popup','Merchant category has been deleted successfully.');			
				$this->Session->setFlash('Merchant category has been deleted successfully.');  
				$this->redirect(array('controller'=>'accounttypes','action'=>"viewlist/message:success"));		
			}
		}
		
		public function superadmin_viewlist() {		
		
		//=============== Account List ================
			 $this->paginate = array(
									'all',
									'limit' => 15,
									'order' => array(
														'Accounttype.navigationOrder' => 'ASC'
        											),
									'paramType' => 'querystring'
	 							);
			$AccountList = $this->paginate();
			$this->set('AccountList',$AccountList);	
		//============ End ============================
		
		}
		
	 
	 	public function beforeFilter()
		{
			parent::beforeFilter();
	   	}

	
		
}
?>