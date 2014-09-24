<?php
//App::uses('CakeEmail', 'Network/Email');

class AdminsController extends AppController {

	var $layout = 'admin';
	var $helpers = array('Html','Text','Paginator'); //add some other helpers to controller
    var $components = array('Session','Common','Cookie','Email','RequestHandler');

	public function superadmin_announcement(){
		// phase 3
		
	}
	
	 
}
?>