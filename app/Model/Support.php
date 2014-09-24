<?php

App::uses('AuthComponent', 'Controller/Component');

/****************************************************
Model to handle valiation of amdin folder
*****************************************************/ 

class Support extends AppModel {

	//public $primaryKey = 'userID';	

	public $name="Support";
	public $useTable = 'support_tickets';
	
	function supportValidation() {  // checking a validation for news
		$validate1 = array(
		
		'fname' => array(
					'notEmpty'=>array(
									'rule' 	  => 'notEmpty',
									'message' => 'Please enter first name'
									)
							),
		'lname' => array(
					'notEmpty'=>array(
									'rule' 	  => 'notEmpty',
									'message' => 'Please enter last name'
									)
							),
		'phone'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter phone number',
						'last'=>true)
					),	
		'subject'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter subject',
						'last'=>true)
					),	
		'email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter e-mail address',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid e-mail address',
						'last'=>true)
					),	
		'address' => array(
					'notEmpty'=>array(
									'rule' 	  => 'notEmpty',
									'message' => 'Please enter comment'
									)
							)
					
			);
			$this->validate=$validate1;
			return $this->validates();
	}

}
?>