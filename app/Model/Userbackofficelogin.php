<?php

class Userbackofficelogin extends AppModel {

	var $name="Userbackofficelogin";
	var $useTable='user_backofficelink';

	
	function backofficeValidation()
	{
		
		$validate1 = array(
			
			'name'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter name')
							),
			'url'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter url')
							,
							'url'=>array(
							'rule' => 'url',
							'message'=> 'Please enter valid url.')
							),
			'username'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter user name')
							),
			'password'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter password')
							),
			'notes'=> array(
							'notes'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter notes')
							
							)
						
			
			
			);
			$this->validate=$validate1;
			return $this->validates();
	}
	
	
	function emailcontactValidation()
	{
		
		$validate1 = array(
			'title'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter title')
							),	
			'email'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter e-mail address')
							,
							'email'=>array(
							'rule' => 'email',
							'message'=> 'Please enter valid e-mail address')
							),
			'notes'=> array(
							'notes'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter notes')
							
							)
						
			
			
			);
			$this->validate=$validate1;
			return $this->validates();
	}
	
	function phonecontactValidation()
	{
		
		$validate1 = array(
			'title'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter title')
							),	
			'phone_number'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter name')
							),
			'notes'=> array(
							'notes'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter notes')
							
							)
						
			
			
			);
			$this->validate=$validate1;
			return $this->validates();
	}

}



?>