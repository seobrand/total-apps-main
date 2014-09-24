<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Merchant extends AppModel {
 
	var $name="Merchant";
	public $virtualFields = array(
	    'merchantStatus' => 'CONCAT(Merchant.id,"_", Merchant.statusID)'
	);
	public $belongsTo = array(
        'Agent' => array(
            'className'    => 'User',
			'fields' => array('user_Name','userEmail','application_email'),
            'foreignKey'   => 'agentID'
        ),
		 'Processor' => array(
            'className' => 'User',
			'fields' => array('user_Name','userEmail','application_email','processorPackage','processorPackageFilename','email_template'),
            'foreignKey' => 'processorID'
        ),
        'Manager' => array(
            'className' => 'User',
			'fields' => array('user_Name','userEmail','application_email','userPhone','userCompany','userCompanyUrl','email_template_id'),
            'foreignKey' => 'managerID'
        ),
		'ISO' => array(
            'className' => 'User',
			'fields' => array('user_Name','userEmail','application_email'),
            'foreignKey' => 'isoID'
        ),
		'Referal' => array(
            'className' => 'User',
			'fields' => array('user_Name','userEmail','application_email'),
            'foreignKey' => 'referalID'
        ),
		'Status' => array(
            'className' => 'Statuses',
			'fields' => array('status','id'),
            'foreignKey' => 'statusID'
        ),
		'ProcessingMethod' => array(
            'className' => 'Accountcat',
			'fields' => array('accountCategory'),
            'foreignKey' => 'accountCategory'
        ),
		'MerchantCategory' => array(
            'className' => 'Accounttype',
			'fields' => array('accountType'),
            'foreignKey' => 'accountTypeID'
        )
    );
	
	public $hasMany = array(
			'Commissionlog' => array(
					'className'     => 'Commissionlog',
					'fields'		=> 'Commissionlog.*,MONTH(Commissionlog.date) as month,YEAR(Commissionlog.date) as year',
					'foreignKey'    => 'merchantID',
					'conditions'	=> array("Commissionlog.date <= NOW() AND Commissionlog.date > ( NOW() - INTERVAL 8 MONTH )"),
					'order'         => 'Commissionlog.date DESC',
					'dependent'     => true
			)
	);
	
	public $hasOne = array(
			'Commission' => array(
					'className'    => 'Commission',
					'foreignKey'    => 'merchantID'
			)
	);
	
	var $validate =  array(
		'merchantName' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Legal/Merchant Name should not be empty'
	    	)		
		),
		/*'legalZip' => array(
        	'rule' => array('postal', null, 'us'),
			'allowEmpty' => true,
			'message' => 'Please enter valid Zip Code'
    	),*/
		'contactPhone' => array(
        	'noContactPhone' => array(
				'rule' => 'notEmpty',
				'message'  => 'Please enter contact phone number'
	    	)
    	),
		/* 'volume' => array(
        	'noVolume' => array(
				'rule' => 'notEmpty',
				'message'  => 'Please enter monthly sales volume'
	    	)
    	),
		'merchantDBA' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'DBA Name should not be empty'
	    	)
		),
		/*'dbaZip' => array(
        	'rule' => array('postal', null, 'us'),
			'allowEmpty' => true,
			'message' => 'Please enter valid Zip Code'
    	),*/
		'contactEmail' => array(
			'noEmail' => array(
				'rule'    => 'notEmpty',
				'message' => 'Contact email should not be empty'
			),
			'validEmail' => array(
				'rule'    => 'email',
				'message' => 'Please supply a valid email address'
			)
		),
		'merchantURL' => array(
        	/*'rule1' => array(
				'rule' => array('url', true),
				'allowEmpty' => true,
				'message' => 'Please enter valid URL(Ex:- http//www.example.com)'
			),*/
			'rule1' => array(
				'rule' => array('maxLength', 50),
				'allowEmpty' => true,
				'message' => 'URL length should be minimum then 50 characters.'
			)
    	),
		/* 'tradeName' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Trade Name should not be empty'
	    	)		
		),
		'tradeContactName' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Trade Contact Name should not be empty'
	    	)		
		),
		'tradePhone' => array(
			'noPhone' => array(
				'rule'    => 'notEmpty',
				'message' => 'Trade phone should not be empty'
			)
		),
		'bankName' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Bank Name should not be empty'
	    	)		
		),
		'bankContactName' => array(
			'noBlank' => array(
				'rule' => 'notEmpty',
				'message'  => 'Bank contact name should not be empty'
	    	)		
		),
		'bankPhone' => array(
			'noPhone' => array(
				'rule'    => 'notEmpty',
				'message' => 'Bank phone should not be empty'
			)			
		), */
		/*'bankContact' => array(
			'noContact' => array(
				'rule'    => 'notEmpty',
				'message' => 'Bank contact should not be empty'
			)			
		),
		'transitNumber' => array(
			'notransitNumber' => array(
				'rule'    => 'notEmpty',
				'message' => 'Transit Number should not be empty'
			)			
		),
		'telephone' => array(
			'noTelephone' => array(
				'rule'    => 'notEmpty',
				'message' => 'telephone should not be empty'
			)			
		),
		'accountNumber' => array(
			'noAccountNumber' => array(
				'rule'    => 'notEmpty',
				'message' => 'Account Number should not be empty'
			)			
		)/*,
		'federalTaxId' => array(
			'rule1' => array(
			 		'rule' => array('minLength', 9),
					'allowEmpty' => true,
					'message' => 'Please enter EIN in 9 digits.'
			),
			'rule2' => array(
					'rule' => array('maxLength', 9),
					'allowEmpty' => true,
					'message' => 'Please enter EIN in 9 digits.'
			)
		),
		'CID' => array(
			'isunique' => array(
				'rule'    => 'isUnique',
        		'message' => 'This MID Number has already been taken'
			)
		)*/
	);	
	
	
	protected function validphonenumber() {
		if(preg_match('/^(?:(?:\((?=\d{3}\)))?(\d{3})(?:(?<=\(\d{3})\))?[\s.\/-]?)?(\d{3})[\s\.\/-]?(\d{4})\s?(?:(?:(?:(?:e|x|ex|ext)\.?\:?|extension\:?)\s?)(?=\d+)(\d+))?$/',trim($this->data['User']['userPhone'])))
		{	
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function beforeSave($options = array()) {			
		if (!empty($this->data['Merchant']['volume'])) {
			$this->data['Merchant']['volume'] = $this->merchantVolumeBeforeSave($this->data['Merchant']['volume']);
		}
		return true;
	}
	
	public function merchantVolumeBeforeSave($volumeString) {
		$volume = str_replace(",", "", $volumeString);
		return $volume;
	}
	
}

?>