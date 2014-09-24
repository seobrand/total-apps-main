<?php 
class Emailtemplate extends AppModel {
	var $name="EmailTemplate";
	/*This is validation rule for ppc add form*/
	var $validate =  array(
				 'title'=>array('rule' => 'notEmpty',
        		 				'message' => 'Please enter title.'),
				 'subject' => array(
        						'rule' => 'notEmpty',
        						'message' => 'Please enter subject.'),
				'from' => array(
        						'allowEmpty' => true,
								'rule' => 'email',
        						'message' => 'Please enter valid e-mail address.'),
					
				 'message' => array(
        						'rule' =>array('contentValidation'),
        						'message' => 'Please enter message.')
						
				 );
				 
				 
	function userMassEmail() {  // checking a validation for news
		$validate1 = array(
			'template'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please select template')
							),	
			'role'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please select user type')
							)
			
			);
			$this->validate=$validate1;
			return $this->validates();
	}	 
	
	
					 
	function merchantMassEmail() {  // checking a validation for news
		$validate1 = array(
			'template'=> array(
							'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please select template')
							)
			
			);
			$this->validate=$validate1;
			return $this->validates();
	}	 			 
				 
				 
				 

	function contentValidation() {
		if(strip_tags($this->data['EmailTemplate']['message'])=='') {
	    	 return false;
	  }
	  return true;
	}	
}	 
?>
