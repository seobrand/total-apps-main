<?php 
App::uses('AuthComponent', 'Controller/Component');

/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Appointment extends AppModel {
	var $name="Appointment";
	public $belongsTo = array(
        'Merchant' => array(
            'className'    => 'Merchant',
			'fields' => array('merchantName','contactName','merchantURL','contactPhone','contactEmail','agentID','managerID','isoID','processorID','referalID'),
            'foreignKey'   => 'merchantID'
        )
    );
}

?>