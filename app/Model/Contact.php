<?php
App::uses('AppModel', 'Model');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Contact extends AppModel {
 
	var $name="Contact";
	
	var $validate =  array(
			'name' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter contact name.'
			),
			'email' => array(
				'notblank' => array(	
					'rule'	=> 'notEmpty',
					'message' => 'Please enter email id.'
				),
				'validEmail' => array(
					'rule'	=> 'email',
					'message' => 'Please enter valid email id.'
				)
			)
	);	
	
	
	
	
	
}

?>