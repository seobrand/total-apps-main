<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Merchanttransaction extends AppModel {
	//public $primaryKey = 'userID';	
	var $name="Merchanttransaction";
	
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
		 ),	 	'avgMonVisaVolume' => array(	 		'notBlank' => array(	 				'rule' => 'notEmpty',	 				'allowEmpty' => false,	 				'message' => 'Please enter your monthly sales volume.'	 		)/* ,	 		'alphanumeric' => array(	 				'rule' => 'alphaNumeric',	 				'message' => 'Please enter alphanumeric value.'			 		) */		 	),
 		'avgVisaTicket' => array(
 				'notBlank' => array(
 						'rule' => 'notEmpty',
 						'allowEmpty' => false,
 						'message' => 'Please enter average transaction size.'
 				)/* ,
 				'alphanumeric' => array(
 						'rule' => 'alphaNumeric',
 						'message' => 'Please enter alphanumeric value.'
 				) */
 		),	 	'highestTicketAmount' => array(	 		'notBlank' => array(	 				'rule' => 'notEmpty',	 				'allowEmpty' => false,	 				'message' => 'Please enter your maximum transaction size.'	 		)/* ,	 		'alphanumeric' => array(	 				'rule' => 'alphaNumeric',	 				'message' => 'Please enter alphanumeric value.'			 		)	 */		 	)
    );
	
	
}

?>