<?php

App::uses('AuthComponent', 'Controller/Component');

/****************************************************
Model to handle valiation of amdin folder
*****************************************************/ 

class Document extends AppModel {

	//public $primaryKey = 'userID';	

	var $name="Document";
	var $belongsTo="Folder";


	function folderValidation() {  // checking a validation for news
		$validate1 = array(
		
		'folder_id' => array(
					'notEmpty'=>array(
									'rule' 	  => 'notEmpty',
									'message' => 'Please select folder'
									)
				
							),
							
		'documenttype' => array(
					'notEmpty'=>array(
									'rule' 	  => 'notEmpty',
									'message' => 'Please select document type'
									)
				
							),
		'title' => array(
			'notEmpty'=>array(
							'rule' 	  => 'notEmpty',
							'message' => 'Please enter title'
							)
					)
			);
			$this->validate=$validate1;
			return $this->validates();
	}

}
?>