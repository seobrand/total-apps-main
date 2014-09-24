<?php
//error_reporting(0);
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
class UserAuthComponent extends Component {
	/**
	 * This component uses following components
	 *
	 * @var array
	 
	 */
	
	var $components = array('Session', 'Cookie', 'RequestHandler','Cookie');
	/**
	 * configur key
	 *
	 * @var string
	 */
	var $configureKey='User';

	function initialize($controller) {

	}

	function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
	}

	function startup(&$controller = null) {

	}
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @param object $c current controller object
	 * @return void
	 */
	function beforeFilter(&$c) {
		
		//exit;
		//pr($this->Session->read('UserAuth'));
		

		
	
		
		if($this->Session->read('UserAuth.User.id'))
		{
		
			if($this->Session->read('UserAuth.User.user_group_id'))
			{
				if($c->params['action']!='superadmin_login' and $c->params['action']!='superadmin_logout' and $c->params['action']!='superadmin_role')
				{
					$c->Session->write('Usermgmt.OriginAfterLogin', '/'.$c->params->url);
					$this->Cookie->write('OriginAfterLogin','/'.$c->params->url, true, 14400);
					
				}
			
			}
		
			if(!$this->Session->read('UserAuth.User.user_group_id'))
			{
		
				$userId=$this->Session->read('UserAuth.User.id');
				APP::import('Model','Usermgmt.UserGroupJoin');
				$this->UserGroupJoin = new UserGroupJoin();
				$rec = $this->UserGroupJoin->find("first",array('fields'=>'UserGroupJoin.user_group_id','conditions'=>'UserGroupJoin.user_id="'.$userId.'" and user_group_id!=0')); 
				$this->Session->write('UserAuth.User.user_group_id', $rec['UserGroupJoin']['user_group_id']);
				
				
				$this->UserGroup = new UserGroup();
				$rec1 = $this->UserGroup->find("first",array('conditions'=>'UserGroup.id="'.$rec['UserGroupJoin']['user_group_id'].'"')); 
				$this->Session->write('UserAuth.UserGroup.id', $rec1['UserGroup']['id']);		
			 	$this->Session->write('UserAuth.UserGroup.name', $rec1['UserGroup']['name']);		
				$this->Session->write('UserAuth.UserGroup.alias_name', $rec1['UserGroup']['alias_name']);		
				$this->Session->write('UserAuth.UserGroup.allowRegistration', $rec1['UserGroup']['allowRegistration']);
				$this->Session->write('UserAuth.UserGroup.created', $rec1['UserGroup']['created']);		
				$this->Session->write('UserAuth.UserGroup.modified', $rec1['UserGroup']['modified']);				
				
				
				//$this->redirect(array('plugin'=>'Usermgmt','controller'=>'users','action'=>'role'));
			}
			
			
			
			if(!$this->Session->read('UserAuth.UserGroup.id'))
			{
				$userId=$this->Session->read('UserAuth.User.id');
				APP::import('Model','Usermgmt.UserGroupJoin');
				$this->UserGroupJoin = new UserGroupJoin();
				$rec = $this->UserGroupJoin->find("first",array('fields'=>'UserGroupJoin.user_group_id','conditions'=>'UserGroupJoin.user_id="'.$userId.'" and user_group_id!=0')); 
				$this->Session->write('UserAuth.User.user_group_id', $rec['UserGroupJoin']['user_group_id']);
				
				
				$this->UserGroup = new UserGroup();
				$rec1 = $this->UserGroup->find("first",array('conditions'=>'UserGroup.id="'.$rec['UserGroupJoin']['user_group_id'].'"')); 
				$this->Session->write('UserAuth.UserGroup.id', $rec1['UserGroup']['id']);		
			 	$this->Session->write('UserAuth.UserGroup.name', $rec1['UserGroup']['name']);		
				$this->Session->write('UserAuth.UserGroup.alias_name', $rec1['UserGroup']['alias_name']);		
				$this->Session->write('UserAuth.UserGroup.allowRegistration', $rec1['UserGroup']['allowRegistration']);
				$this->Session->write('UserAuth.UserGroup.created', $rec1['UserGroup']['created']);		
				$this->Session->write('UserAuth.UserGroup.modified', $rec1['UserGroup']['modified']);
				
			//	$this->redirect(array('plugin'=>'Usermgmt','controller'=>'users','action'=>'role'));
			}
		}
		
	
		$user = $this->__getActiveUser();
		UsermgmtInIt($this);
		$pageRedirect = $this->Session->read('permission_error_redirect');
		
		$this->Session->delete('permission_error_redirect');
		$controller = $c->params['controller'];
		$action = $c->params['action'];
		$actionUrl = $controller.'/'.$action;
		
		if($controller!="apis"){
		
		
			$requested= (isset($controller->params['requested']) && $controller->params['requested']==1) ? true : false;
			$permissionFree=array('users/superadmin_login','users/superadmin_api','users/superadmin_api', 'users/superadmin_logout', 'users/superadmin_register', 'users/userVerification', 'users/forgotPassword', 'users/activatePassword', 'pages/display','users/superadmin_accessDenied','users/superadmin_role','users/superadmin_dashboard','email_templates/superadmin_ajaxGetUser','email_templates/getTemplate','users/superadmin_contacts','users/superadmin_usercontact','users/usercontact','users/getusercontactinformation','users/deletecontactinformation','users/getuserList','users/superadmin_fullapi_totalapss','users/superadmin_fullapi_mojopay','apis/mojopay_merchant_request','apis/mojopay_merchant_request','apis/superadmin_mojopay_apiprofileinfo','users/superadmin_addadditionalinformation','users/superadmin_deleteadditionalinformation');
			
	
			
			if ((empty($pageRedirect) || $actionUrl!='users/superadmin_login') && !$requested && !in_array($actionUrl, $permissionFree)) {
			App::import("Model", "Usermgmt.UserGroup");
			$userGroupModel = new UserGroup;
			
			if (!$this->isLogged()) {
				
				if (!$userGroupModel->isGuestAccess($controller, $action)) {
					
					$c->log('permission: actionUrl-'.$actionUrl, LOG_DEBUG);
					$c->Session->write('permission_error_redirect','/users/superadmin_login');
					$c->Session->setFlash('You need to be signed in to view this page.');
					$c->Session->write('Usermgmt.OriginAfterLogin', '/'.$c->params->url);
					$c->redirect('/superadmin/dashboard');
					
					http://192.168.100.93/pushkar/totalapps_final_new/superadmin/dashboard
				}
			} else {
				//echo $controller;
				//echo $action;
				//exit;
					
					if (!$userGroupModel->isUserGroupAccess($controller, $action, $this->getGroupId())) {
					$c->log('permission: actionUrl-'.$actionUrl, LOG_DEBUG);
					$c->Session->write('permission_error_redirect','/users/login');
					$c->redirect('/superadmin/dashboard');
					//$c->redirect('/superadmin/accessDenied');
				}
			}
		}
		
		}
	}
	/**
	 * Used to check whether user is logged in or not
	 *
	 * @access public
	 * @return boolean
	 */
	public function isLogged() {
		return ($this->getUserId() !== null);
	}
	/**
	 * Used to get user from session
	 *
	 * @access public
	 * @return array
	 */
	public function getUser() {
		return $this->Session->read('UserAuth');
	}
	/**
	 * Used to get user id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getUserId() {
		return $this->Session->read('UserAuth.User.id');
	}
	/**
	 * Used to get group id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getGroupId() {
	
		$userId=$this->Session->read('UserAuth.User.id');
	
	APP::import('Model','Usermgmt.UserGroupJoin');
			$this->UserGroupJoin = new UserGroupJoin();
		 	$rec = $this->UserGroupJoin->find("first",array('fields'=>'UserGroupJoin.user_group_id','conditions'=>'UserGroupJoin.user_id="'.$userId.'" and user_group_id!=0')); 
	
	
	if($this->Session->read('UserAuth.User.id'))
	{
		return $this->Session->read('UserAuth.User.user_group_id');
	}
	else
	{
		return $rec['UserGroupJoin']['user_group_id'];
	}
	
	//echo 'sdfsdf';die;
		/*return $this->Session->read('UserAuth.User.user_group_id');*/
	}
	/**
	 * Used to get group name from session
	 *
	 * @access public
	 * @return string
	 */
	public function getGroupName() {
		return $this->Session->read('UserAuth.UserGroup.alias_name');
	}
	/**
	 * Used to make password in hash format
	 *
	 * @access public
	 * @param string $pass password of user
	 * @return hash
	 */
	public function makePassword($pass) {
		return md5($pass);
	}
	/**
	 * Used to maintain login session of user
	 *
	 * @access public
	 * @param mixed $type possible values 'guest', 'cookie', user array
	 * @param string $credentials credentials of cookie, default null
	 * @return array
	 */
	public function login($type = 'guest', $credentials = null) {
		$user=array();
		if (is_string($type) && ($type=='guest' || $type=='cookie')) {
			App::import("Model", "Usermgmt.User");
			$userModel = new User;
			$user = $userModel->authsomeLogin($type, $credentials);
		} elseif (is_array($type)) {
			$user =$type;
		}
		
		Configure::write($this->configureKey, $user);
		$this->Session->write('UserAuth', $user);
		return $user;
	}
	/**
	 * Used to delete user session and cookie
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->Session->delete('UserAuth');
		Configure::write($this->configureKey, array());
		$this->Cookie->delete('UsermgmtCookie');
	}
	/**
	 * Used to persist cookie for remember me functionality
	 *
	 * @access public
	 * @param string $duration duration of cookie life time on user's machine
	 * @return boolean
	 */
	public function persist($duration = '2 weeks') {
		App::import("Model", "Usermgmt.User");
		$userModel = new User;
		$token = $userModel->authsomePersist($this->getUserId(), $duration);
		$token = $token.':'.$duration;
		return $this->Cookie->write(
			'UsermgmtCookie',
			$token,
			true, // encrypt = true
			$duration
		);
	}
	/**
	 * Used to check user's session if user's session is not available then it tries to get login from cookie if it exist
	 *
	 * @access private
	 * @return array
	 */
	private function __getActiveUser() {
		$user = Configure::read($this->configureKey);
		if (!empty($user)) {
			return $user;
		}

		$this->__useSession() || $this->__useCookieToken() || $this->__useGuestAccount();

		$user = Configure::read($this->configureKey);
		if (is_null($user)) {
			throw new Exception(
				'Unable to initilize user'
			);
		}
		return $user;
	}
	/**
	 * Used to get user from session
	 *
	 * @access private
	 * @return boolean
	 */
	private function __useSession() {
		$user = $this->getUser();
		if (!$user) {
			return false;
		}
		Configure::write($this->configureKey, $user);
		return true;
	}
	/**
	 * Used to get login from cookie
	 *
	 * @access private
	 * @return boolean
	 */
	private function __useCookieToken() {
		$token = $this->Cookie->read('UsermgmtCookie');
		if (!$token) {
			return false;
		}

		// Extract the duration appendix from the token
		$tokenParts = split(':', $token);
		$duration = array_pop($tokenParts);
		$token = join(':', $tokenParts);
		$user = $this->login('cookie', compact('token', 'duration'));
		// Delete the cookie once its been used
		$this->Cookie->delete('UsermgmtCookie');
		if (!$user) {
			return;
		}
		$this->persist($duration);
		return (bool)$user;
	}
	/**
	 * Used to get login as guest
	 *
	 * @access private
	 * @return array
	 */
	private function __useGuestAccount() {
		return $this->login('guest');
	}
}