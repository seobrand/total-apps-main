<?php
// app/Controller/DocumentsController.php

class ResidualsController extends AppController {

	    var $layout = 'admin';

	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');

		var $helpers = array('CakeGrid.Grid');

		


	 	public function superadmin_residual()
		{
			
		}
		
		

	 	public function beforeFilter()

		{

			parent::beforeFilter();

	   	}



	

		

}

?>