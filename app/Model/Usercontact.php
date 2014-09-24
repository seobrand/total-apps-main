<?php

class Usercontact extends AppModel {

	var $name="Usercontact";
	var $useTable='user_contacts';

	
	function departmentcontactValidation()
	{
		
		$validate1 = array(
			'title'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter title')
							),	
			'name'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter name')
							),
			'phone_number'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter name')
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