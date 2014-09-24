<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Merchantpipeline extends AppModel {
	var $name="Merchantpipeline";
	
	public $belongsTo = array(
        'Merchant' => array(
            'className'    => 'Merchant',
            'foreignKey'   => 'merchantID'
        )
    );	
	
}

?>