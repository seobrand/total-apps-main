<?php  APP::import('Model','Usermgmt.User');
	   $this->User = new User();
				
		$div= '<select name="data[Merchant][isoID]" id="MerchantIsoID" class="select1">';
		$div .=  '<option value="">-Select ISO-</option>';
				
				
		if(isset($userID) && $userID!='')
		{
			$options['joins'] = array(array('table' => 'user_group_joins','alias' => 'UserGroupJoin','type' => 'inner','conditions' => array('User.id = UserGroupJoin.user_id')));
			// ISO ID 22
			$options['conditions'] = array('UserGroupJoin.user_group_id' => 22,'User.active' => 1);
			$options['fields'] = array('User.user_Name,User.id');
			$options['order'] = array('User.user_Name ASC');
			$isoList = $this->User->find('all', $options);				
			foreach($isoList as $allIso)
			{
				if($allIso['User']['id']!='' && $allIso['User']['id']==$isoID){
					$div.= '<option value="'.$allIso['User']['id'].'" selected="selected">'.$allIso['User']['user_Name'].'</option>';
				}else{								
					$div.= '<option value="'.$allIso['User']['id'].'">'.$allIso['User']['user_Name'].'</option>';
				}
			}				
		}
				
		$div.='</select>';	
		echo $div;
?>