<?php

App::uses('AppModel', 'Model');

class News extends AppModel 
{
	var $useTable  = 'news';
	//var $belongsTo  ='UserGroup';
	
	function NewsValidation() {  // checking a validation for news
		$validate1 = array(
			'title'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter title')
							),	
			'user_group_id'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please select group')
							),		
			'description' => array(
					'rule' => 'notEmpty',
					'message' => 'Please enter description'			
				),
			'start_date' => array(
					'rule' 	  => 'notEmpty',
					'message' => 'Please enter start date'
				),
			'end_date' => array(
					'notEmpty'=>array(
									'rule' 	  => 'notEmpty',
									'message' => 'Please enter end date'
									),
					'Greater'=>array(
								'rule' 	  => 'DateGreater',
								'message' => 'End date is always greater than start date'
									)
				
							)
			);
			$this->validate=$validate1;
			return $this->validates();
	}
	
	function DateGreater() // check end date is greater or not
	   {	
			$startDate=strtotime($this->data['News']['start_date']);
			$endDate=strtotime($this->data['News']['end_date']);
			if($startDate > $endDate)
			{
				return false;
			}
		  	return true;
	   }
}