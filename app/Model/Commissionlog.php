<?php
App::uses('AppModel', 'Model');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Commissionlog extends AppModel {
 
	var $name="Commissionlog";
	
	public $belongsTo = array(
			'Merchant' => array(
					'className'    => 'Merchant',
					'fields' => array('id','merchantName','merchantDBA','contactEmail','statusID','processorID','CID'),
					'foreignKey'   => 'merchantID'
			)
	);
	
}

?>
