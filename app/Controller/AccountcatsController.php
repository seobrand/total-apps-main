<?php
// alex
// app/Controller/UsersController.php
class AccountcatsController extends AppController {
	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		

		
		public function superadmin_addaccountcats() {		
		$errorsArr ='';	
		
		
		if($this->request->is('post')){
			$this->Accountcat->set($this->request->data);
			if(!$this->Accountcat->validates()) 
			{
				$errorsArr = $this->Accountcat->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Accountcat->save($this->request->data)) {
					$this->Session->write('popup','New Account Category has been added successfully.');			
					$this->redirect(array('controller'=>'accountcats','action' => "viewlist/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_editaccountcats($catID = null) {		
		$errorsArr ='';	
		//$this->loadModel('Accountcat');
		if($this->request->is('get')){
			$this->request->data = $this->Accountcat->find('first',array('conditions'=>array('id'=>$catID)));
		}else
		{			
			$this->Accountcat->set($this->request->data);
			if(!$this->Accountcat->validates()) 
			{
				$errorsArr = $this->Accountcat->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Accountcat->save($this->request->data)) {
					$this->Session->write('popup','Account Category has been Updated successfully.');			
				 
					$this->redirect(array('controller'=>'accountcats','action' => "editaccountcats/".$catID."/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_deleteaccountcats($catID= null) {
			//$this->loadModel('Accounttype');
			if($this->Accountcat->delete($catID))
			{
				$this->Session->write('popup','Account Category has been deleted successfully.');			
				$this->Session->setFlash('Account Category has been deleted successfully.');  
				$this->redirect(array('controller'=>'accountcats','action'=>"viewlist/message:success"));		
			}
		}
		
		public function superadmin_viewlist() {
			
			
			
		
			
		//=============== Account List ================
			 $this->paginate = array(
									'all',
									'limit' => 50,
									'order' => array(
														'Accountcat.navigationOrder' => 'ASC'
        											),
									'paramType' => 'querystring'
	 							);
			$AccountcatList = $this->paginate();
			$this->set('AccountcatList',$AccountcatList);	
		//============ End ============================
		
		}
	 
	 	public function beforeFilter()
		{
			parent::beforeFilter();
	   	}

}
?>