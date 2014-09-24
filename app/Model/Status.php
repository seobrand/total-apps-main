<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Status extends AppModel {
	var $name="Status";
	
	var $validate =  array(
		'status' => array(
			'noblank' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter new status'
    		),
			'unique' =>array(
				'rule'    => 'isUnique',
				'message' => 'This status name has already been taken.'
			)
		)
	);	
        
        
	function getApplicationList(){
		 $full_url = FULL_BASE_URL.router::url('/',false);
		 //condition for merchant pipline on dash board		 
		 $merchant_pipline_condition = array("OR" => array(
		 		"Status.id" => array(1,2,3,4,5,9)		 		
		 ));
		 return $Status=$this->find('all',array('order' => 'Status.navigationOrder ASC','conditions'=>$merchant_pipline_condition,'fields'=>array('Status.id','Status.status') ));
                 
        }
	
}

?>