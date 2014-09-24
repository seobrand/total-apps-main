<?php

App::uses('AuthComponent', 'Controller/Component');

/****************************************************
Model to handle valiation of amdin folder
*****************************************************/ 

class Folder extends AppModel {

	//public $primaryKey = 'userID';	

	var $name="Folder";


	function folderValidation() {  // checking a validation for news
		$validate1 = array(
			'title' => array(
					'notEmpty'=>array(
									'rule' 	  => 'notEmpty',
									'message' => 'Please enter folder name'
									),
					'unique'=>array(
								'rule' 	  => 'isFolderUnique',
								'message' => 'Folder name must be unique'
									)
				
							)
			);
			$this->validate=$validate1;
			return $this->validates();
	}

		public function isFolderUnique() 
		{			
		
			APP::import('Model','Folder');
			$this->Folder = new Folder();
		
		
		
			if(empty($this->data['Folder']['id']))
			{
				$totalRec=$this->Folder->find('count',array('conditions' => 'Folder.user_id="'.$this->data['Folder']['user_id'].'" and Folder.user_group_id="'.$this->data['Folder']['user_group_id'].'" and  Folder.title="'.$this->data['Folder']['title'].'" '));
			}else
			{
				
				 $totalRec=$this->Folder->find('count',array('conditions' => 'Folder.id!="'.$this->data['Folder']['id'].'" and Folder.user_id="'.$this->data['Folder']['user_id'].'" and Folder.user_group_id="'.$this->data['Folder']['user_group_id'].'"  and  Folder.title="'.$this->data['Folder']['title'].'"'));
			}
			
			if($totalRec)
			{
				return false;
			}
			return true;
	
			
			}
}
?>