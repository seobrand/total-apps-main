<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Gateway extends AppModel {
	var $name="Gateway";
	
	var $validate =  array(
		'gatewayName' => array(
			'noblank' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter new gateway name.'
    		),
			'unique' =>array(
				'rule'    => 'isUnique',
				'message' => 'This gateway name has already been taken.'
			)
		)
	);	
	
}

?>