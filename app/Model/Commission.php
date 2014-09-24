<?php
App::uses('AppModel', 'Model');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Commission extends AppModel {
 
	var $name="Commission";
	
	public $belongsTo = array(
			'Merchant' => array(
					'className'    => 'Merchant',
					'fields' => array('id','merchantName','contactName','merchantURL','contactPhone','contactEmail','statusID','agentID','managerID','isoID','processorID','referalID'),
					'foreignKey'   => 'merchantID'
			)
	);
	
	
	var $validate =  array(
		'message' => array(
			'validFile' => array(
					'rule'    => array('extension', array('xls', 'xlsx')),
					'message' => 'Please supply an valid .xls file.'
			)
		)
	);	
	
	
	
	
	
}

?>