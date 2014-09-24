<?php

// app/Controller/UsersController.php
class AgentnotesController extends AppController {
	//var name = 'Agentnote';
    var $layout = 'admin';
	    var $components = array('Auth','Session','Common','Cookie','Email','RequestHandler');

	public function superadmin_notes($userID = null) 
	{	
		// ============  Fetch Record For Notes =============================
			$this->loadModel('Agentnote');
			$condition = 'Agentnote.adminid = "'.$this->Session->read('USERID').'" and  Agentnote.userID="'.$userID.'" ';
			$agentREC=$this->Agentnote->find('all',array('conditions'=>$condition));
			$this->Set('agentRec',$agentREC);
		// ===================  End  =============================
		
			
		 if ($this->request->is('post'))
		 {
		
		 	 if ($this->request->data['Agentnote']['SUBMIT'] == 'NOTES') {
			
				$this->request->data['Agentnote']['userID']=$userID;
				$this->request->data['Agentnote']['enteredBy']=$this->Session->read('ROLE');
				$this->request->data['Agentnote']['adminid']=$this->Session->read('USERID');
				$this->request->data['Agentnote']['timeStamp']=date('d/m/Y h:m:s');
			
			
			 	$this->Agentnote->set($this->request->data);
				
				  if ($this->Agentnote->save($this->request->data)) {
                    $this->Session->write('popup', 'Information Updtaed successfully.');
                    $this->Session->setFlash('Information Updtaed successfully.');
                    $this->redirect(array('controller' => 'agentnotes', 'action' => "notes/".$userID."/message:success"));
                }
			}
		 	
		 }else
		 {
		 	$this->loadModel('User');
		 	 $this->request->data = $this->User->read(null, $userID);
			 $this->request->data['User']['password'] = $this->request->data['User']['userPWD'];
			 $action = explode('_', $this->params['action']);
            $this->request->data['User']['page'] = $action['1'];
		 }
	
	}
	
		public function superadmin_delete($userID,$ID) 
		{	
		  if ($this->Agentnote->delete($userID)) {
				$this->Session->write('popup', 'User has been deleted successfully.');
				$this->Session->setFlash('User has been deleted successfully');
				$this->redirect(array('controller' => 'agentnotes', 'action' => "notes/".$ID."/message:success"));
        }
	}
}
?>