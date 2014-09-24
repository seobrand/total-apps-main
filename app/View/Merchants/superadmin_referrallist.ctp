<?php  APP::import('Model','Usermgmt.User');
	   $this->User = new User();
				
		$div= '<select name="data[Merchant][referalID]" id="MerchantReferalID" class="select1">';
		$div .=  '<option value="">-Select Referral-</option>';
				
				
		if(isset($userID) && $userID!='')
		{
			$options['joins'] = array(array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')));
			// ReferalID 25
			$options['conditions'] = array('UserGroupJoin.user_group_id' => 25,'User.active' => 1);
			$options['fields'] = array('User.user_Name,User.id');
			$options['order'] = array('User.user_Name ASC');
			$refList = $this->User->find('all', $options);				
			foreach($refList as $allref)
			{
				if($allIso['User']['id']!='' && $allref['User']['id']==$isoID){
					$div.= '<option value="'.$allref['User']['id'].'" selected="selected">'.$allref['User']['user_Name'].'</option>';
				}else{								
					$div.= '<option value="'.$allref['User']['id'].'">'.$allref['User']['user_Name'].'</option>';
				}
			}				
		}
				
		$div.='</select>';	
		echo $div;
?>