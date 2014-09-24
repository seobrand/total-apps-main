<?php
App::uses('UserMgmtAppModel', 'Usermgmt.Model');
App::uses('CakeEmail', 'Network/Email');

class User extends UserMgmtAppModel {


	var $belongsTo = array(
        'ReferralLink' => array(
            'className'    => 'ReferralLink',
            'foreignKey'   => 'referral_link_id'
        )
    );
	
	//var $hasOne=array('Usercontact');

	var $hasMany = array('Usermgmt.UserGroupJoin','Usercontact','UserAddress');

	var $validate = array();
	
	function LoginValidate() {
		$validate1 = array(
				'email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email or username')
					),
				'password'=>array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter password')
					)
			);
		$this->validate=$validate1;
		return $this->validates();
	}
	/**
	 * model validation array
	 *
	 * @var array
	 */
	function RegisterValidate() {
		$validate1 = array(
				
				'username'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter username',
						'last'=>true),
					'mustUnique'=>array(
						'rule' =>'isUnique',
						'message' =>'This username already taken',
					'last'=>true),
					'mustBeLonger'=>array(
						'rule' => array('minLength', 4),
						'message'=> 'Username must be greater than 3 characters',
						'last'=>true),
					),
				'user_Name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter name')
					),		
		/* 
		 * Validations removed as in ticket id# 1968 
		 * 
		 * 'userAddress' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter address'
			), 
		'userCity' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter city'			
			),
		'userCountry' => array(
			'rule' 	  => 'notEmpty',
			'message' => 'Please enter country'
			),
		
		 'userCompany'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter company name',
						'last'=>true)
					), 
		'userPhone2'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter phone number',
						'last'=>true)
					),	
		'userCompanyName'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter company name',
						'last'=>true)
					),
		'userCompanyAddress'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter address',
						'last'=>true)
					),
		'userCompanyCity'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter city',
						'last'=>true)
					),
		'userCompanyState'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter city',
						'last'=>true)
					),	
		'userCompanyCountry'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter country',
						'last'=>true)
					),
		'userCompanyZip'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter zip code',
						'last'=>true)
					),		
		'userCompanyPhone'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter phone',
						'last'=>true)
					),	 */	
		'userPhone'=> array(
				'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter phone number',
						'last'=>true)
		),
		/* 'userState' => array(
			'rule' 	  => 'notEmpty',
			'message' => 'Please enter state'
			),	
		'userZip'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter zip Code',
						'last'=>true)
					), */
		'userEmail'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid email',
						'last'=>true)/*,
					'mustUnique'=>array(
						'rule' =>'isUnique',
						'message' =>'This email is already registered',
						)*/
					),
				'password'=>array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter password',
						'on' => 'create',
						'last'=>true),
					'mustBeLonger'=>array(
						'rule' => array('minLength', 6),
						'message'=> 'Password must be greater than 5 characters',
						'on' => 'create',
						'last'=>true),
					'mustMatch'=>array(
						'rule' => array('verifies'),
						'message' => 'Both passwords must match'),
						//'on' => 'create'
					)
			);
		$this->validate=$validate1;
		return $this->validates();
	}
	/**
	 * Used to match passwords
	 *
	 * @access protected
	 * @return boolean
	 */
	protected function phonenumbersecond() {
		
		if($this->data['User']['userPhone2'])
		{
		
				if(preg_match('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/',trim($this->data['User']['userPhone2'])))
				{	
					return true;
				}else
				{
					return false;
				}
		
		}else
		{
			return true;
		}
	}
	
	
	protected function verifies() {
		return ($this->data['User']['password']===$this->data['User']['cpassword']);
	}
	
	protected function validphonenumber() {

		if(preg_match('/^(?:(?:\((?=\d{3}\)))?(\d{3})(?:(?<=\(\d{3})\))?[\s.\/-]?)?(\d{3})[\s\.\/-]?(\d{4})\s?(?:(?:(?:(?:e|x|ex|ext)\.?\:?|extension\:?)\s?)(?=\d+)(\d+))?$/',trim($this->data['User']['userPhone'])))
		{	
			return true;
		}
		else
		{
			return false;
		}
		
		
	}
	/**
	 * Used to send registration mail to user
	 *
	 * @access public
	 * @param array $user user detail array
	 * @return void
	 */
	public function sendRegistrationMail($user) {
		// send email to newly created user
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = emailFromAddress;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
		$email->subject('Your registration is complete');
		//$email->transport('Debug');
		$body="Welcome ".$user['User']['first_name'].", Thank you for your registration on ".SITE_URL." \n\n Thanks,\n".emailFromName;
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send registration email to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	/**
	 * Used to send email verification mail to user
	 *
	 * @access public
	 * @param array $user user detail array
	 * @return void
	 */
	public function sendVerificationMail($user) {
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = emailFromAddress;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
		$email->subject('Email Verification Mail');
		$activate_key = $this->getActivationKey($user['User']['password']);
		$link = Router::url("/userVerification?ident=$userId&activate=$activate_key",true);
		$body="Hi ".$user['User']['first_name'].", Click the link below to complete your registration \n\n ".$link;
		try{
			$result = $email->send($body);
		} catch (Exception $ex){
			// we could not send the email, ignore it
			$result="Could not send verification email to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	/**
	 * Used to generate activation key
	 *
	 * @access public
	 * @param string $password user password
	 * @return hash
	 */
	public function getActivationKey($password) {
		$salt = Configure::read ( "Security.salt" );
		return md5(md5($password).$salt);
	}
	/**
	 * Used to send forgot password mail to user
	 *
	 * @access public
	 * @param array $user user detail
	 * @return void
	 */
	public function forgotPassword($user) {
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = emailFromAddress;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
		$email->subject(emailFromName.': Request to Reset Your Password');
		$activate_key = $this->getActivationKey($user['User']['password']);
		$link = Router::url("/activatePassword?ident=$userId&activate=$activate_key",true);
		$body= "Welcome ".$user['User']['first_name'].", let's help you get signed in

You have requested to have your password reset on ".emailFromName.". Please click the link below to reset your password now :

".$link."


If above link does not work please copy and paste the URL link (above) into your browser address bar to get to the Page to reset password

Choose a password you can remember and please keep it secure.

Thanks,\n".

emailFromName;
		try{
			$result = $email->send($body);
		} catch (Exception $ex){
			// we could not send the email, ignore it
			$result="Could not send forgot password email to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	/**
	 * Used to mark cookie used
	 *
	 * @access public
	 * @param string $type
	 * @param string $credentials
	 * @return array
	 */
	public function authsomeLogin($type, $credentials = array()) {
		switch ($type) {
			case 'guest':
				// You can return any non-null value here, if you don't
				// have a guest account, just return an empty array
				return array();
			case 'cookie':
				list($token, $userId) = split(':', $credentials['token']);
				$duration = $credentials['duration'];

				$loginToken = $this->LoginToken->find('first', array(
					'conditions' => array(
						'user_id' => $userId,
						'token' => $token,
						'duration' => $duration,
						'used' => false,
						'expires <=' => date('Y-m-d H:i:s', strtotime($duration)),
					),
					'contain' => false
				));
				if (!$loginToken) {
					return false;
				}
				$loginToken['LoginToken']['used'] = true;
				$this->LoginToken->save($loginToken);

				$conditions = array(
					'User.id' => $loginToken['LoginToken']['user_id']
				);
			break;
			default:
				return array();
		}
		return $this->find('first', compact('conditions'));
	}
	/**
	 * Used to generate cookie token
	 *
	 * @access public
	 * @param integer $userId user id
	 * @param string $duration cookie persist life time
	 * @return string
	 */
	public function authsomePersist($userId, $duration) {
		$token = md5(uniqid(mt_rand(), true));
		$this->LoginToken->create(array(
			'user_id' => $userId,
			'token' => $token,
			'duration' => $duration,
			'expires' => date('Y-m-d H:i:s', strtotime($duration)),
		));
		$this->LoginToken->save();
		return "${token}:${userId}";
	}
	/**
	 * Used to get name by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getNameById($userId) {
		$res = $this->findById($userId);
		$name=(!empty($res)) ? ($res['User']['first_name'].' '.$res['User']['last_name']) : '';
		return $name;
	}
}