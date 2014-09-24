<?php

// app/Controller/UsersController.php
class BusinesscatsController extends AppController {
	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		
	
		
		public function superadmin_addbusinesscategory() {		
		$errorsArr ='';	
		
		
		if($this->request->is('post')){
			$this->Businesscat->set($this->request->data);
			if(!$this->Businesscat->validates()) 
			{
				$errorsArr = $this->Businesscat->validationErrors;	
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else {
				if($this->Businesscat->save($this->request->data)) {
					$this->Session->write('popup','New Business Category has been added successfully.');			
					$this->redirect(array('controller'=>'businesscats','action' => "viewlist/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	 
	 	public function superadmin_editbusinesscategory($catID = null) {		
		$errorsArr ='';	
		//$this->loadModel('Accountcat');
		if($this->request->is('get')){
			$this->request->data = $this->Businesscat->find('first',array('conditions'=>array('Businesscat.id'=>$catID)));
		}else
		{			
			if($this->request->data['Businesscat']['parent_id']!=''){
				$count = $this->request->data['count'];
				foreach($this->request->data['Businesscat']['sub_category_name']  as $key => $value){
					$this->Businesscat->create();
					$this->request->data['Businesscat']['category_name'] = $value;					
					$this->Businesscat->save($this->request->data);					
				}
				$this->Session->write('popup','Business Sub Category has been added successfully.');
				$this->redirect(array('controller'=>'businesscats','action' => "viewlist/message:success"));
			}else{
				$this->Businesscat->set($this->request->data);
				if(!$this->Businesscat->validates())
				{
					$errorsArr = $this->Businesscat->validationErrors;
				}
					
				if($errorsArr)
				{
					$this->set('errors',$errorsArr);
					$this->set('data',$this->request->data);
				}
				else {
					if($this->Businesscat->save($this->request->data)) {
						$this->Session->write('popup','Business Category has been Updated successfully.');
						$this->redirect(array('controller'=>'businesscats','action' => "viewlist/message:success"));
					}
					else {
						$this->Session->setFlash('Data save problem, Please try again.');
					}
				}//end if not error
			}
			
		}// end if of check data array
	 } 
	 
	 	public function superadmin_deletebusinesscategory($catID= null) {
			//$this->loadModel('Accounttype');
			if($this->Businesscat->delete($catID))
			{
				$this->Session->write('popup','business Category has been deleted successfully.');			
				$this->Session->setFlash('business Category has been deleted successfully.');  
				$this->redirect(array('controller'=>'businesscats','action'=>"viewlist/message:success"));		
			}
		}
		
		public function superadmin_viewlist() {
			
		//=============== business List ================
			 $this->paginate = array(
									'all',
									'limit' => 15,
									'order' => array(
														'Businesscat.navigationOrder' => 'ASC'
        											),
									'paramType' => 'querystring',
			 						'conditions' => 'Businesscat.parent_id=0'
	 							);
			$BusinessCategoryList = $this->paginate("Businesscat");
			//pr($BusinessCategoryList);die;
			$this->set('BusinessCategoryList',$BusinessCategoryList);	
		//============ End ============================
		
		}
	 
	 	public function beforeFilter()
		{
			parent::beforeFilter();
	   	}

}
?>