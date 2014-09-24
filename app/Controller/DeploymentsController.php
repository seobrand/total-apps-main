<?php
//App::uses('CakeEmail', 'Network/Email');

class DeploymentsController extends AppController {

	var $layout = 'admin';
	var $helpers = array('Html','Text','Paginator','CakeGrid.Grid'); //add some other helpers to controller
	var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');

	public function superadmin_deployment($deploymentID = NULL){
		$errorsArr = "";
		$adminID = $this->Session->read('UserAuth.User.id');
		$this->loadModel('Printer');
		$this->loadModel('Checkreader');
		$this->loadModel('Terminalsoftgateway');
		$this->set('TeminalData','');
		$this->set('PrinterData','');
		$this->set('CheckReaderData','');
		$this->set('selected_ttype','');
		$this->set('userType','');
		
		if($deploymentID != NULL){				
			$this->set('ID',$deploymentID);
		}else{
			$this->set('ID','');
		}
		

					
		if ($this->request->is('get')) {
				$this->request->data  = $this->Deployment->find('first',array('conditions'=>array('Deployment.id'=>$deploymentID)));
				if($this->request->data){				
					$selected_ttype = explode(",",$this->request->data['Deployment']['cardTransactionType']);
					$this->set('selected_ttype',$selected_ttype);
					$this->set('userType',$this->request->data['Deployment']['userType']);
					$this->set('adminName',$this->request->data['Deployment']['adminName']);
				}else{
					$selected_ttype = array();
					$this->set('selected_ttype',$selected_ttype);
					$this->set('userType','');
					$this->set('adminName','');
				}
				
				$adminName = $this->request->data['Deployment']['adminName'];			

				
				$TeminalData = $this->Terminalsoftgateway->find('all',array('conditions'=>array('Terminalsoftgateway.userType'=>'admin','adminName'=>$adminName)));
				$this->set('TeminalData',$TeminalData);
				
				$PrinterData = $this->Printer->find('all',array('conditions'=>array('Printer.userType'=>'admin','adminName'=>$adminName)));
				$this->set('PrinterData',$PrinterData);
				
				$CheckReaderData = $this->Checkreader->find('all',array('conditions'=>array('Checkreader.userType'=>'admin','adminName'=>$adminName)));
				$this->set('CheckReaderData',$CheckReaderData);
				
		}else{
				//pr($this->request->data);die;
				$updateBy = $this->Session->read('UserAuth.User.id');
				$updatedate = date("Y-m-d H:i:s");
				$this->request->data['Deployment']['lastUpdatedBy'] = $updateBy;
				$this->request->data['Deployment']['lastUpdatedDate'] = $updatedate;
				$this->request->data['Deployment']['userType'] = 'admin';
				$this->request->data['Deployment']['merchantID'] = $updateBy;
				$adminName = $this->request->data['Deployment']['adminName'];			

				$this->Deployment->set($this->request->data);
				if(!$this->Deployment->validates()) 
				{
					$errorsArr = $this->Deployment->validationErrors;	
				}
				if($errorsArr) 
				{
					$this->set('errors',$errorsArr);
					$this->set('data',$this->request->data);
				}else{
					// Save record for in table
					if(is_array($this->request->data['Deployment']['cardTransactionType'])){
						$this->request->data['Deployment']['cardTransactionType'] = implode(",",$this->request->data['Deployment']['cardTransactionType']);
					}
					// insert data in terminal soft
					$terminalCount = $this->request->data['Terminalsoftgateway']['count'];
					//pr($this->request->data['Terminalsoftgateway']);die;
					$this->Terminalsoftgateway->deleteAll(array('Terminalsoftgateway.userType' => 'admin','Terminalsoftgateway.adminName'=>$adminName), false);
					for($i=1;$i<=$terminalCount;$i++){
						$this->Terminalsoftgateway->create();
						$this->request->data['Terminalsoftgateway']['softwareName'] = $this->request->data['Terminalsoftgateway']['softwareName'.$i];
						$this->request->data['Terminalsoftgateway']['trainingGivenBy'] = $this->request->data['Terminalsoftgateway']['trainingGivenBy'.$i];
						$this->request->data['Terminalsoftgateway']['supplier'] = $this->request->data['Terminalsoftgateway']['supplier'.$i];
						if(is_array($this->request->data['Terminalsoftgateway']['options'.$i]))
							$this->request->data['Terminalsoftgateway']['options'] = implode(",",$this->request->data['Terminalsoftgateway']['options'.$i]);
						$this->request->data['Terminalsoftgateway']['merchantID'] = $updateBy;
						$this->request->data['Terminalsoftgateway']['userType'] = 'admin';
						$this->request->data['Terminalsoftgateway']['adminName'] = $adminName;
						$this->Terminalsoftgateway->save($this->request->data);
					}
					// insert data in Printer
					$printerCount = $this->request->data['Printer']['count'];
					$this->Printer->deleteAll(array('Printer.userType' => 'admin','Printer.adminName'=>$adminName), false);
	
					for($j=1;$j<=$printerCount;$j++){
						$this->Printer->create(); 
						$this->Printer->set($this->request->data); 
						$this->request->data['Printer']['printerName'] = $this->request->data['Printer']['printerName'.$j];
						$this->request->data['Printer']['printerQuantity'] = $this->request->data['Printer']['printerQuantity'.$j];
						$this->request->data['Printer']['printerSupplier'] = $this->request->data['Printer']['printerSupplier'.$j];
						$this->request->data['Printer']['newOrFurbished'] = $this->request->data['Printer']['newOrFurbished'.$j];
						$this->request->data['Printer']['merchantID'] = $updateBy;
						$this->request->data['Printer']['userType'] = 'admin';
						$this->request->data['Printer']['adminName'] = $adminName;
						$this->Printer->save($this->request->data);										
					}
					// insert data in Check Reader
					$readerCount = $this->request->data['Checkreader']['count'];
					$this->Checkreader->deleteAll(array('Checkreader.userType' => 'admin','Checkreader.adminName'=>$adminName), false);
	
					for($k=1;$k<=$readerCount;$k++){
						$this->Checkreader->create(); 
						$this->Checkreader->set($this->request->data); 
						$this->request->data['Checkreader']['checkReaderName'] = $this->request->data['Checkreader']['checkReaderName'.$k];
						$this->request->data['Checkreader']['readerQuantity'] = $this->request->data['Checkreader']['readerQuantity'.$k];
						$this->request->data['Checkreader']['readerSupplier'] = $this->request->data['Checkreader']['readerSupplier'.$k];
						$this->request->data['Checkreader']['readerNewOrFurbished'] = $this->request->data['Checkreader']['readerNewOrFurbished'.$k];
						$this->request->data['Checkreader']['merchantID'] = $updateBy;
						$this->request->data['Checkreader']['userType'] = 'admin';
						$this->request->data['Checkreader']['adminName'] = $adminName;
						$this->Checkreader->save($this->request->data);										
					}
					if($this->Deployment->save($this->request->data)) {				
						$this->Session->write('popup','Admin Deployment information has been saved successfully.');			
						$this->Session->setFlash('Admin Deployment information has been saved successfully.');  
						$this->redirect(array('controller'=>'deployments','action' => "deploymentlist/message:success"));
					}	
				}
		}
	
	}
	
	public function superadmin_deploymentlist(){
		$this->paginate = array(
				'all',
				'limit' => 50,
				'order' => array('Deployment.id' => 'DESC'),
				'conditions' => array('Deployment.userType'=>'admin'),
				'paramType' => 'querystring'
	 	);
		$deploymentlist = $this->paginate();
	    $this->set('deploymentlist',$deploymentlist);
	
	}

	public function superadmin_deletedeployment($ID =null,$adminName=null) {
		$this->loadModel('Terminalsoftgateway');
		$this->loadModel('Checkreader');
		$this->loadModel('Printer');

		if($this->Deployment->delete($ID))
		{
			$this->Checkreader->deleteAll(array('Checkreader.userType' => 'admin','Checkreader.adminName'=>$adminName), false);
			$this->Terminalsoftgateway->deleteAll(array('Terminalsoftgateway.userType' => 'admin','Terminalsoftgateway.adminName'=>$adminName), false);
			$this->Printer->deleteAll(array('Printer.userType' => 'admin','Printer.adminName'=>$adminName), false);
			$this->redirect(array('controller'=>'deployments','action' => "deploymentlist/message:success"));
		}
	}
	
	public function superadmin_terminalsoftwaredelete($ID =null,$merchantID=null) {
		$this->loadModel('Terminalsoftgateway');
		if($this->Terminalsoftgateway->delete($ID))
		{
			$this->redirect(array('controller'=>'deployments','action' => "deployment/message:success"));
		}
	}
	
	public function superadmin_printerdelete($ID =null,$merchantID=null) {
		$this->loadModel('Printer');
		if($this->Printer->delete($ID))
		{
			$this->redirect(array('controller'=>'deployments','action' => "deployment/message:success"));
		}
	}
	
	public function superadmin_checkreaderdelete($ID =null,$merchantID=null) {
		$this->loadModel('Checkreader');
		if($this->Checkreader->delete($ID))
		{
			$this->redirect(array('controller'=>'deployments','action' => "deployment/message:success"));
		}
	}
	
	
	public function beforeFilter(){
        parent::beforeFilter();
   }


	 
	
	
	 
}
?>