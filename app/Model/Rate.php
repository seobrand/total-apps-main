<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Rate extends AppModel {
	//public $primaryKey = 'userID';	
	var $name="Rate";
	
		
    var $validate = array(
		'adminName' => array(
			'unique' => array(
				'rule'    => 'isUnique',
				'message' => 'This Name has already been taken'
			 ),
			'notempty' => array(
				'rule'    => 'notEmpty',
				'message' => 'Name should not empty'
			)
		 )
    );

	


}

?>