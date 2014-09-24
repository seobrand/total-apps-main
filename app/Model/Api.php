<?php
App::uses('AuthComponent', 'Controller/Component');
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Api extends AppModel { 
	var $name="Api";
	public function beforeSave($options = array()){
		if (!empty($this->data['Merchant']['volume'])){
			$this->data['Merchant']['volume'] = $this->merchantVolumeBeforeSave($this->data['Merchant']['volume']);
		}
		return true;
	}
	
	public function merchantVolumeBeforeSave($volumeString){
		$volume = str_replace(",", "", $volumeString);
		return $volume;
	}	
}

?>