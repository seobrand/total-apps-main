<?php
// app/Controller/DocumentsController.php

class DocumentsController extends AppController {

	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		var $uses=array('Folder','Document');

		
		public function superadmin_index($folderId=NULL) // function to create folders
		{
			if($folderId)
			{
				$userId=$this->Session->read('UserAuth.User.id');
				$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
				
			
					$this->paginate = array('all',
								'limit' => 50,
								'order' => 'Document.id desc',
								'conditions' => 'Document.folder_id="'.$folderId.'" and Document.user_group_id="'.$userGroupId.'" and  Document.user_id="'.$userId.'"',
								'order'=>'Document.title asc',
						        'paramType' => 'querystring'
							 );
					$documentList = $this->paginate('Document');
					$this->set('documentList',$documentList);
			}
		}
		
		public function superadmin_createFolder() // function to create folders
		{
			
				
			if($this->request->data) /// check form submition
			{
				if(!empty($this->request->data['Folder']['Add']))  // new job entry
				{
					
						$userId=$this->Session->read('UserAuth.User.id');
						$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
						$this->request->data['Folder']['user_group_id']=$userGroupId;
						$this->request->data['Folder']['user_id']=$userId;
						
						$this->Folder->set($this->request->data);
						if(!$this->Folder->folderValidation()) // checking validation
						{
							$errorsArr = $this->News->validationErrors;
						}
						else
						{
						
							$this->Folder->create();
							if($this->Folder->save($this->request->data))
							{
								if(!file_exists(WWW_ROOT."folders/".$userId))
								{
									mkdir(WWW_ROOT."folders/".$userId, 0777);
								}
								mkdir(WWW_ROOT."folders/".$userId.'/'.$this->request->data['Folder']['title'], 0777);
								
								$this->Session->write('popup','Folder has been created  successfully');
								$this->redirect(array('controller'=>'documents','action'=>'listFolder/message:success'));
							}
						}
				}
			}
		}
		
		public function superadmin_editFolder($Id=NULL) // function to edit folders
		{
			$this->set('id',$Id);
			
			if($this->request->data) /// check form submition
			{
			
		
				if(!empty($this->request->data['Folder']['Edit']))  // new job entry
				{
						$userId=$this->Session->read('UserAuth.User.id');
						$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
						$this->request->data['Folder']['user_group_id']=$userGroupId;
						$this->request->data['Folder']['user_id']=$userId;
						
				
						$this->Folder->set($this->request->data);
						
						if(!$this->Folder->folderValidation()) // checking validation
						{
							$errorsArr = $this->News->validationErrors;
						}
						else
						{
						
								$folderRec=$this->Folder->find('first',array('fields'=>'Folder.title,Folder.id','conditions'=>'Folder.id="'.$Id.'"'));
							
								if($folderRec['folder']['title']!=$this->request->data['Folder']['title'])
								{
									$userId=$this->Session->read('UserAuth.User.id');
									$userGroupId=$this->Session->read('UserAuth.User.id');
									
									
									if(is_dir(WWW_ROOT."folders/".$userId.'/'.$folderRec['Folder']['title']))
									{
										rename(WWW_ROOT."folders/".$userId.'/'.$folderRec['Folder']['title'],WWW_ROOT."folders/".$userId.'/'.$this->request->data['Folder']['title']);
										chmod(WWW_ROOT."folders/".$userId.'/'.$this->request->data['Folder']['title'], 0777);  //changed to add the zero
									}else
									{
										mkdir(WWW_ROOT."folders/".$userId.'/'.$this->request->data['Folder']['title'], 0777);
									}
								}
							
							
							if($this->Folder->saveAll($this->request->data))
							{	
								$this->Session->write('popup','Folder has been edited  successfully');
								$this->redirect(array('controller'=>'documents','action'=>'listFolder/message:success'));
							}
						}
				}
			}
			else
			{
				$this->request->data=$this->Folder->find('first',array('conditions'=>'Folder.id="'.$Id.'"'));
			}
		}
		
		public function superadmin_listFolder() //  function to lsiting all folders
		{
			$userId=$this->Session->read('UserAuth.User.id');
			$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
				
			
			$this->paginate = array('all',
								'limit' => 50,
								'order' => 'Folder.id desc',
								'conditions' => 'Folder.user_group_id="'.$userGroupId.'" and  Folder.user_id="'.$userId.'"',
						        'paramType' => 'querystring'
							 );
			$folderList = $this->paginate('Folder');
			$this->set('folderList',$folderList);
		}
		
		public function superadmin_deleteFolder($Id=NULL) // delete folder
		{
	
			if (!empty($Id)) 
			{
				
					$userId=$this->Session->read('UserAuth.User.id'); // user id
					$folderRec=$this->Folder->find('first',array('fields'=>'title','conditions'=>'Folder.id="'.$Id.'"')); // folder record
					
					
					if(is_dir(WWW_ROOT."folders/".$userId.'/'.$folderRec['Folder']['title'])) // if folder exits than delete folder
					{
						rmdir(WWW_ROOT."folders/".$userId.'/'.$folderRec['Folder']['title']); 
					}
				
					$this->Document->query('delete  from documents where folder_id="'.$Id.'"');
					
					if ($this->Folder->delete($Id, true)) 
					{
						$this->Session->write('popup','folder has been deleted successfully');
						$this->redirect(array('controller'=>'documents','action'=>'listFolder/message:success'));
					}else
					{
						$this->Session->write('popup','Deletion problem, Please try again.');
						$this->redirect(array('controller'=>'documents','action'=>'listFolder'));
					}
	
				
			} else 
			{
				$this->redirect(array('controller'=>'documents','action'=>'listFolder'));
			}
		}
		
		public function superadmin_listDocument()
		{
				
			$userId=$this->Session->read('UserAuth.User.id');
			$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
				
				$this->paginate = array('all',
								'limit' => 50,
								'order' => 'Document.id desc',
								'conditions' => 'Document.user_group_id="'.$userGroupId.'" and  Document.user_id="'.$userId.'"',
						        'paramType' => 'querystring'
							 );
				$documentList = $this->paginate('Document');
				$this->set('documentList',$documentList);
		}
		
		public function superadmin_addDocument()
		{
				if($this->request->data) /// check form submition
					{
						$userId=$this->Session->read('UserAuth.User.id');
						$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
						$this->request->data['Document']['user_group_id']=$userGroupId;
						$this->request->data['Document']['user_id']=$userId;
					
					
						if(!empty($this->request->data['Document']['Add']))  // new job entry
						{
								$this->Document->set($this->request->data);
								if(!$this->Document->folderValidation()) // checking validation
								{
									$errorsArr = $this->Document->validationErrors;
								}
								else
								{
									$uploadedFolder=$this->Common->getFolderName($this->request->data['Document']['folder_id']);
									$file = time() . '_' . $this->request->data['Document']['file']['name'];
									move_uploaded_file($this->request->data['Document']['file']['tmp_name'], WWW_ROOT.'folders/'.$userId.'/'.$uploadedFolder.'/'.$file);
									$this->request->data['Document']['file_path'] = $file;
							
								
									$this->Session->write('popup','Document has been created  successfully');
									if($this->Document->saveAll($this->request->data))
									{
										$this->redirect(array('controller'=>'documents','action'=>'listDocument/message:success'));
									}
								}
						}
				}
		}

	 	public function superadmin_editDocument($Id=NULL)
		{
			
				if($this->request->data) /// check form submition
					{
						$userId=$this->Session->read('UserAuth.User.id');
						$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
						$this->request->data['Document']['user_group_id']=$userGroupId;
						$this->request->data['Document']['user_id']=$userId;
				
						if(!empty($this->request->data['Document']['Edit']))  // new job entry
						{
								$this->Document->set($this->request->data);
								
								if(!$this->Document->folderValidation()) // checking validation
								{
									$errorsArr = $this->Document->validationErrors;
								}
								else
								{
								$this->request->data['Document']['folder_id']=$this->request->data['Document']['folder_ids'];
							
								if($this->request->data['Document']['file']['name'])
								{
									$uploadedFolder=$this->Common->getFolderName($this->request->data['Document']['folder_id']); //get folder name
									
									$file = time() . '_' . $this->request->data['Document']['file']['name'];
									move_uploaded_file($this->request->data['Document']['file']['tmp_name'], WWW_ROOT.'folders/'.$userId.'/'.$uploadedFolder.'/'.$file);
									
									if(file_exists(WWW_ROOT.'folders/'.$userId.'/'.$uploadedFolder.'/'.$this->request->data['Document']['oldfile']))
									{
										unlink(WWW_ROOT.'folders/'.$userId.'/'.$uploadedFolder.'/'.$this->request->data['Document']['oldfile']);
									}
									
								}else
								{
									$file=$this->request->data['Document']['oldfile'];
								}
								
									$this->request->data['Document']['file_path'] = $file;
								
								
									$this->Session->write('popup','record has been updated  successfully');
									if($this->Document->saveAll($this->request->data))
									{
										$this->redirect(array('controller'=>'documents','action'=>'listDocument/message:success'));
									}
								}
						}
				}else
				{
				
					$this->request->data=$this->Document->find('first',array('conditions'=>'Document.id="'.$Id.'"'));
				}
		
		}
		
		public function superadmin_deleteDocument($Id=NULL)
		{
			if (!empty($Id)) 
			{
					$userId=$this->Session->read('UserAuth.User.id');
					$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
					$this->request->data['Document']['user_group_id']=$userGroupId;
					$this->request->data['Document']['user_id']=$userId;
									
					$fileRec=$this->Document->find('first',array('fields'=>'file_path,folder_id	','conditions'=>'Document.id="'.$Id.'"'));
					$uploadedFolder=$this->Common->getFolderName($fileRec['Document']['folder_id']);
				
					if(is_file(WWW_ROOT.'folders'.'/'.$userId.'/'.$uploadedFolder.'/'.$fileRec['Document']['file_path'])) // if folder exits than delete folder
					{
						unlink(WWW_ROOT.'folders'.'/'.$userId.'/'.$uploadedFolder.'/'.$fileRec['Document']['file_path']); 
					}
					
					if ($this->Document->delete($Id, false)) 
					{
						$this->Session->write('popup','document has been deleted successfully');
						$this->redirect(array('controller'=>'documents','action'=>'listDocument/message:success'));
					}else
					{
						$this->redirect(array('controller'=>'documents','action'=>'listDocument'));
					}
	
				
			} else 
			{
				$this->redirect(array('controller'=>'documents','action'=>'listDocument'));
			}
		}
		
		public function getVideo($Id=NULL)
		{
			$this->set('filename',$_GET['file']);
			$this->request->data=$this->Document->find('first',array('conditions'=>'Document.file_path="'.$_GET['file'].'"'));
			
		}
		
		

	 	public function beforeFilter()
		{
		
			$this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
			parent::beforeFilter();
	   	}



}

?>