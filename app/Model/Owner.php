<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Owner extends AppModel {
 
	var $name="Owner";
	
	var $validate =  array(
		'name1' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Owner Name should not be empty'
	    	)		
		),
		'title1' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Owner title should not be empty'
	    	)		
		),
		'ownership1' => array(
			'between' => array(
				'rule'    => array('between', 1, 100),
                'message' => 'Please enter valid Ownership Percent '
			)		
		),
		'licenceNumber1' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Licence number should not be empty'
	    	)		
		),
		'socialSecurityNumber1' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Social security number should not be empty'
	    	)		
		),
		/*'zip1' => array(
        	'rule' => array('postal', null, 'us'),
			'allowEmpty' => true,
			'message' => 'Invalid Zip Code'
    	),*/
		'homePhone1' => array(
			'noPhone' => array(
				'rule'    => 'notEmpty',
				'message' => 'Home telephone should not be empty'
			)
    	)
	);	
	
	var $belongsTo = array(
			'Merchant' => array(
					'className'    => 'Merchant',
					'foreignKey'   => 'merchantID'
			)
	);
	
	
	
}

?>