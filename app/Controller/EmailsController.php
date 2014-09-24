<?php
// app/Controller/DocumentsController.php

class EmailsController extends AppController {

	    var $layout = 'admin';

	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');

		var $helpers = array('CakeGrid.Grid');

		


	 	/*public function superadmin_addTemplate()
		{
			
		}*/
		
		public function superadmin_blastEmail()
		{
			
		}
		public function superadmin_listTemplate()
		{
			
		}
		
		
		

	 	public function beforeFilter()

		{

			parent::beforeFilter();

	   	}



	

		

}

?>