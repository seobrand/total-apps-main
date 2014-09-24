<?php
//App::uses('CakeEmail', 'Network/Email');

class MerchanttransactionsController extends AppController {

	var $layout = 'admin';
	var $helpers = array('Html','Text','Paginator','CakeGrid.Grid'); //add some other helpers to controller
	var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');

	public function superadmin_transaction($transactionID = NULL){
		$errorsArr ="";
		$adminID = $this->Session->read('UserAuth.User.id');
		if($transactionID != NULL){				
			$this->set('ID',$transactionID);
		}else{
			$this->set('ID','');
		}		
				
		if ($this->request->is('get')) {
				$this->request->data = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.id'=>$transactionID)));
		}else{
				//pr($this->request->data);die;
				$updateBy = $this->Session->read('UserAuth.User.id');
				$updatedate = date("Y-m-d H:i:s");
				$this->request->data['Merchanttransaction']['merchantID'] = $updateBy;
				$this->request->data['Merchanttransaction']['lastUpdatedBy'] = $updateBy;
				$this->request->data['Merchanttransaction']['lastUpdatedDate'] = $updatedate;
				$this->request->data['Merchanttransaction']['userType'] = 'admin';

				$this->Merchanttransaction->set($this->request->data);
				if(!$this->Merchanttransaction->validates()) 
				{
					$errorsArr = $this->Merchanttransaction->validationErrors;	
				}
				if($errorsArr) 
				{
					$this->set('errors',$errorsArr);
					$this->set('data',$this->request->data);
				}else{
					if($this->Merchanttransaction->save($this->request->data)) {
						$this->Session->write('popup','Admin Transaction has been saved successfully.');			
						$this->Session->setFlash('Admin Transaction has been saved successfully.');  
						$this->redirect(array('controller'=>'merchanttransactions','action' => "transactionlist/message:success"));
					}	
				}
		}
	
	}
	
	public function superadmin_transactionlist(){
		$this->paginate = array(
				'all',
				'limit' => 20,
				'order' => array('Merchanttransaction.id' => 'DESC'),
				'conditions' => array('Merchanttransaction.userType'=>'admin'),
				'paramType' => 'querystring'
	 	);
		$transactionlist = $this->paginate();
	    $this->set('transactionlist',$transactionlist);
	
	}
	
	public function superadmin_deletetransaction($ID =null) {
		if($this->Merchanttransaction->delete($ID))
		{
			$this->redirect(array('controller'=>'merchanttransactions','action' => "transactionlist/message:success"));
		}
	}
	
	public function beforeFilter(){
        parent::beforeFilter();
   }

	
	 
}
?>