<?php
/*
	This file is part of UserMgmt.

	Author: Chetan Varshney (http://ektasoftwares.com)

	UserMgmt is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	UserMgmt is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
App::uses('UserMgmtAppController', 'Usermgmt.Controller');
class UserGroupsController extends UserMgmtAppController {

  var $layout = 'admin';
	public $uses = array('Usermgmt.UserGroup');
	  var $helpers = array('Html','Text','Paginator','CakeGrid.Grid'); //add some other helpers to controller
	/**
	 * Used to view all groups by Admin
	 *
	 * @access public
	 * @return array
	 */
	public function superadmin_index() {
		$this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
	
		$this->UserGroup->unbindModel( array('hasMany' => array('UserGroupPermission')));
		
		 $this->paginate = array('all',
		'limit' => 10,
		'order' => array(
            'UserGroup.id' => 'asc'
        ),
		'paramType' => 'querystring'
		
	 );
		$userGroups = $this->paginate('UserGroup');
		//pr($userGroups);die;
		//$userGroups=$this->UserGroup->find('all', array('order'=>'UserGroup.id'));
		$this->set('userGroups', $userGroups);
		
		
	}
	/**
	 * Used to add group on the site by Admin
	 *
	 * @access public
	 * @return void
	 */
	public function superadmin_addGroup() {
		$this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
	
		if ($this->request -> isPost()) {
			$this->UserGroup->set($this->data);
			if ($this->UserGroup->addValidate()) {
				$this->UserGroup->save($this->request->data,false);
				$this->Session->setFlash(__('The group is successfully added'));
				
				$this->Session->write('popup', 'New Group has been added Succeessfully.');
				$this->Session->setFlash('New Group has been added Succeessfully.');
				
				 $this->redirect(array('controller' => 'user_groups', 'action' => "/addGroup/message:success"));
			//	$this->redirect('/addGroup');
			}
		}
	}
	/**
	 * Used to edit group on the site by Admin
	 *
	 * @access public
	 * @param integer $groupId group id
	 * @return void
	 */
	public function superadmin_editGroup($groupId=null) {
		$this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
		
		if (!empty($groupId)) {
			if ($this->request -> isPut()) {
				$this->UserGroup->set($this->data);
				if ($this->UserGroup->addValidate()) {
					$this->UserGroup->save($this->request->data,false);
					
					$this->Session->write('popup', 'The group is successfully updated.');
				$this->Session->setFlash('The group is successfully updated.');
					
					$this->redirect('/superadmin/usermgmt/user_groups/index/message:success');
				}
			} else {
				$this->request->data = $this->UserGroup->read(null, $groupId);
			}
		} else {
			$this->redirect('/superadmin/usermgmt/user_groups/index');
		}
	}
	
	public function superadmin_deleteGroup($groupId = null) {
		$this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
	
		if (!empty($groupId)) {
			if ($this->request -> isPost()) {
				if ($this->UserGroup->delete($groupId, false)) {
				
				$this->UserGroup->query("delete from user_group_joins where user_group_id='".$groupId."'");
					
						$this->Session->write('popup', 'Group is successfully deleted.');
				$this->Session->setFlash('Group is successfully deleted.');
					
				}
			}
			$this->redirect('/superadmin/usermgmt/user_groups/index/message:success');
		} else {
			$this->redirect('/superadmin/usermgmt/user_groups/index/message:success');
		}
	}
}