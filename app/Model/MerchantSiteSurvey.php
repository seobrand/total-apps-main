<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class MerchantSiteSurvey extends AppModel {
 
	var $name = "MerchantSiteSurvey";
	public $useTable = 'merchant_site_survey';
	
	var $belongsTo = array(
			'Merchant' => array(
					'className'    => 'Merchant',
					'foreignKey'   => 'merchantID'
			)
	);
	
	
	
}

?>