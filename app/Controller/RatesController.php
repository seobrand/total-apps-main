<?php
//App::uses('CakeEmail', 'Network/Email');

class RatesController extends AppController {

	var $layout = 'admin';
	var $helpers = array('Html','Text','Paginator','CakeGrid.Grid'); //add some other helpers to controller
	var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');

	public function superadmin_rate($rateID = NULL){
		$errorsArr ="";
		$adminID = $this->Session->read('UserAuth.User.id');
		if($rateID != NULL){				
			$this->set('ID',$rateID);
		}else{
			$this->set('ID','');
		}	
		
		if ($this->request->is('get')) {
				$this->request->data = $this->Rate->find('first',array('conditions'=>array('Rate.id'=>$rateID)));
				/*$this->request->data = $this->Rate->find('first',array('conditions'=>array('Rate.userType'=>'admin')));*/
		}else{
				$updateBy = $this->Session->read('UserAuth.User.id');
				$updatedate = date("Y-m-d H:i:s");
				$this->request->data['Rate']['merchantID'] = $updateBy;
				$this->request->data['Rate']['lastUpdatedBy'] = $updateBy;
				$this->request->data['Rate']['lastUpdatedDate'] = $updatedate;
				$this->request->data['Rate']['userType'] = 'admin';
				$this->Rate->set($this->request->data);
				
				if(!$this->Rate->validates()) 
				{
					$errorsArr = $this->Rate->validationErrors;	
				}
				if($errorsArr) 
				{
					$this->set('errors',$errorsArr);
					$this->set('data',$this->request->data);
				}else{
					if($this->Rate->save($this->request->data)) {
						$this->Session->write('popup','Rates has been saved successfully.');			
						$this->Session->setFlash('Rates has been saved successfully.');  
						$this->redirect(array('controller'=>'rates','action' => "ratelist/message:success"));
					}	
				}
		}
	
	}
	
	public function superadmin_ratelist(){
		$this->paginate = array(
				'all',
				'limit' => 20,
				'order' => array('Rate.id' => 'DESC'),
				'conditions' => array('Rate.userType'=>'admin'),
				'paramType' => 'querystring'
	 	);
		$ratelist = $this->paginate();
		$this->set('ratelist',$ratelist);
	
	}
	
	public function superadmin_deleterates($ID =null) {
		if($this->Rate->delete($ID))
		{
			$this->redirect(array('controller'=>'rates','action' => "ratelist/message:success"));
		}
	}
	
	public function superadmin_transaction(){
		$adminID = $this->Session->read('UserAuth.User.id');
		$this->loadModel('Merchanttransaction');
			
		if ($this->request->is('get')) {
				$this->request->data = $this->Merchanttransaction->find('first',array('conditions'=>array('Merchanttransaction.userType'=>'admin')));
				if($this->request->data){				
					$this->set('ID',$this->request->data['Merchanttransaction']['id']);
				}else{
					$this->set('ID','');
				}
		}else{
				//pr($this->request->data);die;
				$updateBy = $this->Session->read('UserAuth.User.id');
				$updatedate = date("Y-m-d H:i:s");
				$this->request->data['Merchanttransaction']['merchantID'] = $updateBy;
				$this->request->data['Merchanttransaction']['lastUpdatedBy'] = $updateBy;
				$this->request->data['Merchanttransaction']['lastUpdatedDate'] = $updatedate;
				$this->request->data['Merchanttransaction']['userType'] = 'admin';
				

				if($this->Merchanttransaction->save($this->request->data)) {
					$this->Session->write('popup','Admin Transaction has been saved successfully.');			
					$this->Session->setFlash('Admin Transaction has been saved successfully.');  
					$this->redirect(array('controller'=>'admins','action' => "transaction/message:success"));
				}	
				
		}
	
	}
	
	public function beforeFilter(){
        parent::beforeFilter();
   }


	 
	
	
	 
}
?>