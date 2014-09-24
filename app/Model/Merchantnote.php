<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Merchantnote extends AppModel {
	var $name="Merchantnote";
	public $primaryKey = 'merchantNoteID';
	
	public $belongsTo  = array(
        'User' => array(
            'className'    => 'User',
           	'fields' => array('user_Name'),
            'foreignKey'   => 'enteredBy'
        )
    );
	
}

?>