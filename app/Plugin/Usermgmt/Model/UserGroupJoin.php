<?php
App::uses('UserMgmtAppModel', 'Usermgmt.Model');
App::uses('CakeEmail', 'Network/Email');
class UserGroupJoin extends UserMgmtAppModel {
	//public $belongsTo=array('User','UserGroup');
	//var $hasOne="User";
	 var $belongsTo=array("Usermgmt.UserGroup","Usermgmt.User");
	 
	 
}