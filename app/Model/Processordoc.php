<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Processordoc extends AppModel {
	var $name="Processordoc";
	
	var $validate =  array(
		'docName' => array(
			'rule'    => 'notEmpty',
			'message' => 'Please enter document name'
    		)
	);	
	
}

?>