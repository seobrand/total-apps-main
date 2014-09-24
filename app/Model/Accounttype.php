<?php
class Accounttype extends AppModel {
	var $name="Accounttype";
	
	var $validate =  array(
		'accountType' => array(
			'noblank' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter merchant category'
    		),
			'unique' =>array(
				'rule'    => 'isUnique',
				'message' => 'This merchant category has already been taken.'
			)
		)
	);	
	
}

?>