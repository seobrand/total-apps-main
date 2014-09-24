<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Merchantprocessordoclink extends AppModel {
	var $name="Merchantprocessordoclink";
	
	public $belongsTo = array(
        'Document' => array(
            'className'    => 'Processordoc',
            'foreignKey'   => 'docID',
			'fields'		   => 'docName'
        )
    );
	
}

?>