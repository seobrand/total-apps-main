<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
    {
	
        var $helpers = array('Form', 'Html', 'Session', 'Js', 'Usermgmt.UserAuth');
        public $components = array('Common','RequestHandler', 'Usermgmt.UserAuth','Cookie');
        function beforeFilter(){
		
		
		
		$user_id=$this->Session->read('UserAuth.User.id');
		$group_id=$this->Session->read('UserAuth.UserGroup.id');
		
		if(isset($user_id) && isset($group_id)){
		    App::import("Model", "Usermgmt.User");
			$this->User = new User;
			$data['User']['id']=$user_id;
			$data['User']['last_activity_sence']=time();
			$data['User']['login_as']=$group_id;
			$this->User->save($data);
		}
		
		
       	// test session time out
        //$this->Session->delete('UserAuth');
		ini_set('session.gc_maxlifetime', 500*60*60);
		$currentTimeoutInSecs = ini_get('session.gc_maxlifetime');
		
		if(!$this->params->params['controller'])
		{
			$this->redirect('/new');
		}	
		
		

	
			App::import("Model", "Usermgmt.UserGroup");
			$userGroupModel = new UserGroup;
			$this->set('userGroupModel',$userGroupModel);
			
            $this->userAuth();
			$this->set('common', $this->Common);
			
			
			
        }
		
		
        private function userAuth(){
            $this->UserAuth->beforeFilter($this);
        }
		
	
	
    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
		// Default deny
        return false;
    }
	
	
	  public function generalinformation($userId) 
	{
	
	
		$errorsLevel='';
		
			//$userGroups=$this->UserGroup->getGroups();
			$action = explode('_', $this->params['action']);
			$page = $action['1'];
			
			
			$this->set('page',$action['1']);
			
			if ($this->request -> isPut()) {
			
				if($this->request->data['User']['vendor']=='vendor'){
				
				unset($this->request->data['User']['username']);
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['old_password']);
				unset($this->User->data['User']['username']);
				unset($this->User->data['User']['password']);
				unset($this->User->data['User']['old_password']);
				
			}
				//pr($this->data);die;
				//pr($this->User->data);die;
				$this->User->set($this->request->data);
				
				
				$j=0;
				
						for($i=0;$i<count($this->request->data['UserGroupJoin']);$i++)
						{
							if($this->request->data['UserGroupJoin'][$i]['user_group_id'])
							{
								$userGroupData[$j]=$this->request->data['UserGroupJoin'][$i];
								$j=$j+1;	
							}else
							{
								App::import("Model", "UserGroupJoin");
								$this->UserGroupJoin = new UserGroupJoin;
								$this->UserGroupJoin->delete($this->request->data['UserGroupJoin'][$i]['id']);
							}
						}
						
						
					
						if($j==0)
						{
					
					$errorsLevel='Please Select at Least One User Level';
						}
				
				if ($this->User->RegisterValidate() && $errorsLevel=='') {
				
					unset($this->request->data['UserGroupJoin']);
					$this->request->data['UserGroupJoin']=$userGroupData;
					
					$this->set('errorsLevel',$errorsLevel);
					if (empty($this->request->data['User']['password'])) {
						unset($this->request->data['User']['password']);
					} else {
					
						$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
					}
					$this->User->create();
					$this->User->saveAssociated($this->request->data,false);
					
					$this->Session->write('popup', 'User Information Updated successfully.');
            		$this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
				}else
				{
						
				$user=$this->User->find("first",array('conditions'=>'User.id="'.$userId.'"')); 
				
						$this->request->data['User']['agent_doc']=$user['User']['agent_doc'];
						$this->request->data['User']['referral_doc']=$user['User']['referral_doc'];
						$this->request->data['User']['photo_doc']=$user['User']['photo_doc'];
						$this->request->data['User']['video_doc']=$user['User']['video_doc'];
						
						$errorsArr = $this->User->validationErrors;	
					
						
						$this->set('errorsLevel',$errorsLevel);
						$this->request->data = $this->data;
				}
				
				
			} else {
		//	$this->request->data = $this->User->read(null, $userId);
			
				$this->set('errorsLevel',$errorsLevel);
			
				$user = $this->User->read(null, $userId);
				$this->User->set('user',$user);
		
				$this->request->data=null;
				if (!empty($user)) {
					$user['User']['password']='';
					$this->request->data = $user;
				}
			}
		
	
	}
	
	/* Download function path if folder any folder in img path */
	function downloadFile($folder1,$folder2,$fielname)	{
		$folder = $folder1."/".$folder2;
		$this->autoLayout = false;
		$newFileName = $fielname;
		$folder = str_replace('-','/',$folder);
		//Replace - to / to view subfolder
	    $path =  WWW_ROOT.$folder.'/'.$fielname;
		if(file_exists($path) && is_file($path)) {	
			$mimeContentType = 'application/octet-stream';
			$temMimeContentType = $this->_getMimeType($path); 
			if(isset($temMimeContentType)  && !empty($temMimeContentType))	{ 
							$mimeContentType = $temMimeContentType;
			}
		    //echo  'sssssssssss--->' . $mimeContentType;		 exit;
			// START ANDR SILVA DOWNLOAD CODE
			// required for IE, otherwise Content-disposition is ignored
			if(ini_get('zlib.output_compression'))
			  	ini_set('zlib.output_compression', 'Off');
			header("Pragma: public"); // required
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); // required for certain browsers 
			header("Content-Type: " . $mimeContentType );
			// change, added quotes to allow spaces in filenames, by Rajkumar Singh
			header("Content-Disposition: attachment; filename=\"".(is_null($newFileName)?basename($path):$newFileName)."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($path));
			readfile($path);
			exit();
			// END ANDR SILVA DOWNLOAD CODE												
		 }
		 if(isset($_SERVER['HTTP_REFERER'])) {
		 	 $this->Session->setFlash('File not found.');
			 $this->redirect($_SERVER['HTTP_REFERER']);
		 }	 
 	}
	
	function _getMimeType($filepath) {
		ob_start();
		system("file -i -b {$filepath}");
		$output = ob_get_clean();
		$output = explode("; ",$output);
		if ( is_array($output) ) {
			$output = $output[0];
		}
		return $output;
	}
	
	function checkGroupid($GroupId)  // checking that groupid is found for not
		{
		
			if(!$GroupId)
			{
				$this->redirect(array('controller'=>'users','action' =>"role",'plugin' =>"usermgmt",'superadmin' =>true));
				//$this->redirect(array('controller'=>'users','action' => "logout",'plugin'=>'Usermgmt','superadmin'=>true));
			}
		
			
		}
	
    }