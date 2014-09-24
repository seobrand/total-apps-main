<?php
//	 * Used to mange all News/
//	 *  Created by : Pushkar Soni


App::uses('AppController', 'Controller');

class NewsController extends AppController {
	var $layout = 'admin';
	public $name = 'News'; 

	public $uses = array('News');
	var $helpers = array('Html','Text','Paginator','CakeGrid.Grid'); //add some other helpers to controller
	var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
	
		
	public function superadmin_newsList()   // function for admin job list
	{
	
		$this->paginate = array('all',
								'limit' => 50,
								'order' => 'News.id desc',
						        'paramType' => 'querystring'
							 );
		$newsList = $this->paginate('News');
		$this->set('newsList',$newsList);
	}
		
		
	public function superadmin_addNews()  // action to add new News
	{
	
		if($this->request->data) /// check form submition
		{
		
			if(!empty($this->request->data['News']['Add']))  // new job entry
			{
					$this->request->data['News']['user_group_id']=implode(',',$this->request->data['News']['user_group_id']);
					$this->News->set($this->request->data);
					
					if(!$this->News->NewsValidation()) // checking validation
					{
						$this->request->data['News']['user_group_id']=explode(',',$this->request->data['News']['user_group_id']);
						$errorsArr = $this->News->validationErrors;
					}
					else
					{
						
						$this->request->data['News']['start_date']=strtotime($this->request->data['News']['start_date']);
						$this->request->data['News']['end_date']=strtotime($this->request->data['News']['end_date']);
						
						$this->Session->write('popup','News has been added successfully');
						$this->News->saveAll($this->request->data);
						$this->redirect(array('controller'=>'News','action'=>'newsList/message:success'));
					}
			}
		}
		
	}
	
	public function superadmin_editNews($NewsId=NULL) {
		
		if(!empty($this->request->data))
		{
			if(!empty($this->request->data['News']['Edit']))  // new job entry
			{
					$this->request->data['News']['user_group_id']=implode(',',$this->request->data['News']['user_group_id']);
					
					$this->News->set($this->request->data);
					if(!$this->News->NewsValidation()) // checking validation
					{
						$this->request->data['News']['user_group_id']=explode(',',$this->request->data['News']['user_group_id']);
						$errorsArr = $this->News->validationErrors;
					}else // save record
					{
						
						$this->request->data['News']['start_date']=strtotime($this->request->data['News']['start_date']);
						$this->request->data['News']['end_date']=strtotime($this->request->data['News']['end_date']);
						$this->Session->write('popup','News has been updated successfully');
						$this->News->saveAll($this->request->data);
						$this->redirect(array('controller'=>'News','action'=>'newsList/message:success'));
					}
			}
						
		}else
		{
			$this->request->data=$this->News->find('first',array('conditions'=>'News.id="'.$NewsId.'"'));
			$this->request->data['News']['start_date']=date('m/d/Y',$this->request->data['News']['start_date']);
			$this->request->data['News']['end_date']=date('m/d/Y',$this->request->data['News']['end_date']);
			$this->request->data['News']['user_group_id']=explode(',',$this->request->data['News']['user_group_id']);
		}
	}
	

	
	public function superadmin_deleteNews($Id=NULL)   // action for delete Skill 
	{
			if (!empty($Id)) {
				if ($this->News->delete($Id, false)) {
					$this->Session->write('popup','News has been deleted successfully');
				}
	
			$this->redirect(array('controller'=>'News','action'=>'newsList/message:success'));
			} else 
			{
				$this->redirect(array('controller'=>'News','action'=>'newsList'));
			}
	}
	

	
	function beforeFilter() 
	{ 
	     parent::beforeFilter();
	}
	function beforeRender(){
	    parent::beforeRender();
		
	}   
	
		
}