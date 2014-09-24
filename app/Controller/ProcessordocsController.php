<?php
// app/Controller/UsersController.php
class ProcessordocsController extends AppController {
	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		
		public $paginate = array(
			'limit' => 10,
			'order' => array(
				'Processordoc.id' => 'desc'
			),
			'paramType' => 'querystring'
		);
		
		public function superadmin_addprodoc() {		
		$errorsArr ='';	
		
		$ProcessordocList= $this->paginate();
		$this->set('ProcessordocList',$ProcessordocList);	
			
		if($this->request->is('post')){		
			$this->Processordoc->set($this->request->data);
			if(!$this->Processordoc->validates()) 
			{
				$errorsArr = $this->Processordoc->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Processordoc->save($this->request->data)) {
					$this->Session->write('popup','New Document has been added successfully.');			
					$this->Session->setFlash('New Document has been added successfully.');  
					$this->redirect(array('controller'=>'processordocs','action' => "addprodoc/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_editprodoc($id = null) {		
		$errorsArr ='';	
		if($this->request->is('get')){
				$this->request->data = $this->Processordoc->find('first',array('conditions'=>array('id'=>$id)));
		}
		else{			
			$this->Processordoc->set($this->request->data);
			if(!$this->Processordoc->validates()) 
			{
				$errorsArr = $this->Processordoc->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
			
				if($this->Processordoc->save($this->request->data)) {
					$this->Session->write('popup','Document has been Updated successfully.');			
					$this->Session->setFlash('Document has been Updated successfully.');  
					$this->redirect(array('controller'=>'processordocs','action' => "addprodoc/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_deleteprodoc($docID= null) {
			if($this->Processordoc->delete($docID))
			{
				$this->Session->write('popup','Document has been deleted successfully.');			
				$this->Session->setFlash('Document has been deleted successfully.');  
				$this->redirect(array('controller'=>'processordocs','action'=>"addprodoc/message:success"));		
			}
		}
	 
	 	public function beforeFilter()
		{
			parent::beforeFilter();
	   	}

	
		
}
?>