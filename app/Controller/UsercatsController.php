<?php
class UsercatsController extends AppController {
	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		
		public $paginate = array(
			'limit' => 10,
			'order' => array(
				'Usercat.id' => 'desc'
			),
			'paramType' => 'querystring'
		);
		
		public function superadmin_addusercat() {		
		$errorsArr ='';	
		
		if($this->request->is('post')){
			$this->Usercat->set($this->request->data);
			if(!$this->Usercat->validates()) 
			{
				$errorsArr = $this->Usercat->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Usercat->save($this->request->data)) {
					$this->Session->write('popup','Category name has been added successfully.');			
					$this->Session->setFlash('Category name has been added successfully.');  
					$this->redirect(array('controller'=>'usercats','action' => "viewlist/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_editusercat($accountID = null) {		
		$errorsArr ='';	
		$this->loadModel('Usercat');
		if($this->request->is('get')){
			$this->request->data = $this->Usercat->find('first',array('conditions'=>array('id'=>$accountID)));
		}else
		{			
			$this->Usercat->set($this->request->data);
			if(!$this->Usercat->validates()) 
			{
				$errorsArr = $this->Usercat->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Usercat->save($this->request->data)) {
					$this->Session->write('popup','User category has been Updated successfully.');			
					$this->Session->setFlash('User category has been Updated successfully.');  
					$this->redirect(array('controller'=>'usercats','action' => "editusercat/".$accountID."/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_deleteusercat($accountID= null) {
			$this->loadModel('Usercat');
			if($this->Usercat->delete($accountID))
			{
				$this->Session->write('popup','Category has been deleted successfully.');			
				$this->Session->setFlash('Category has been deleted successfully.');  
				$this->redirect(array('controller'=>'usercats','action'=>"viewlist/message:success"));		
			}
		}
		
		public function superadmin_viewlist() {		
		
		//=============== Account List ================
			 $this->paginate = array(
									'all',
									'limit' => 15,
									'order' => array(
														'Usercat.navigationOrder' => 'ASC'
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