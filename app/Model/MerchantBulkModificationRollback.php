<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class MerchantBulkModificationRollback extends AppModel {
 
	var $name = "MerchantBulkModificationRollback";
	public $useTable = 'merchant_bulk_modification_rollback';
	
	var $belongsTo = array(
			'Merchant' => array(
					'className'    => 'Merchant',
					'foreignKey'   => 'merchantID',
					'fields'	   => array('merchantName','CID')
			)
	);
	
}

?>