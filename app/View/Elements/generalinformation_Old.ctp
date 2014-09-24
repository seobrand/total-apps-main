                  <div class="news_announcement">
            <div class="titlebar">GENERAL INFORMATION</div>
            <div class="news_indent">

<?php

     echo $this->Session->flash(); ?>

                	<?php echo $this->Form->create('User'); 
                    ?>
                   <?php echo $this->Form->input("id" ,array('type' => 'hidden', 'label' => false,'div' => false))?>
			
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                <tr>
                  <td width="42%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="27%" align="left" valign="middle">Name<span style="color:#FF0000">*</span></td>
                        <td width="73%" align="left" valign="middle"><?php echo $this->Form->input('user_Name',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Phone<span style="color:#FF0000">*</span></td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userPhone',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Company</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userCompany',array('label'=>'','class'=>'input1','error'=>false));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Address<span style="color:#FF0000">*</span></td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userAddress',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">City<span style="color:#FF0000">*</span></td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userCity',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Country<span style="color:#FF0000">*</span></td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userCountry',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">User ID<span style="color:#FF0000">*</span></td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('username',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                    </table></td>
                  <td width="42%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" align="left" valign="middle">Email<span style="color:#FF0000">*</span></td>
                        <td width="70%" align="left" valign="middle"><?php echo $this->Form->input('userEmail',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Phone 2</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userPhone2',array('label'=>'','class'=>'input1'));?>
                        
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Company URL</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyUrl',array('label'=>'','class'=>'input1','error'=>false));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">	Address 2</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userAddress2',array('label'=>'','class'=>'input1','error'=>false));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">State<span style="color:#FF0000">*</span></td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userState',array('label'=>'','class'=>'input1' ));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Zip<span style="color:#FF0000">*</span></td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userZip',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">	Password<span style="color:#FF0000">*</span> </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('password',array('label'=>'','class'=>'input1' ));?>
                        <?php echo $this->Form->input('old_password',array('label'=>'','class'=>'input1','type'=>'hidden','value'=>'hidden'));?>
                       
                        </td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle">Confirm Password<span style="color:#FF0000">*</span></td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('cpassword',array('label'=>'','type'=>'password','class'=>'input1' ));?>
                        
                       
                        </td>
                      </tr>
                      
                    </table></td>
                  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top"><strong>USER LEVEL</strong><br/><?php if(isset($errors['userLevel'][0])): ?><div class="error-message"><?php echo $errors['userLevel'][0];?></div><?php endif;?>
                      <div style="color:#FF0000;"><?php echo $errorsLevel;?></div>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="top">
                      
                      	<?php   
                       
                        
                        
                        if (count($userGroups)) { ?>
					
							<div class="umstyle3"><?php echo __('Group');?><font color='red'>*</font></div>
							<div class="umstyle4" >
                            <?php
                          
                            $i=0;
                            $count=count($this->request->data['UserGroupJoin']);
                            
                       foreach($userGroups as $key=>$value)
                       {
              	     ?>
                 <div style="clear:both"> 
                 
                 <?php 
                 $checked='';
                 
                if($i< $count)
                {
                     if($this->request->data['UserGroupJoin'][$i]['user_group_id']==$key)
                     {
                        $checked='checked';
                     }
                     $id=$this->request->data['UserGroupJoin'][$i]['id'];
                }else
                {
                	$id='';
                } 
                 
                 
                  echo "<div style='clear:both'>".$this->Form->checkbox('UserGroupJoin.'.$i.'.user_group_id',array('value' => $key,$checked))."&nbsp;&nbsp;".$value."</div>"; 
                 ?> 
                  
                    &nbsp;&nbsp;
                    
                  
                    
                    <input type="hidden" name="data[UserGroupJoin][<?php echo $i ?>][id]" value="<?php echo $id?>" />
                    
                    </div>
                   <?php 
                      
                      $i=$i+1; }    
                       ?>
                           
                            
                            </div>
							<div style="clear:both"></div>
						
			<?php   }   ?>
                      
                      </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="3" align="right" valign="top"><span style="padding:16px 40px 0 0;"></span>
                  
                  	 <?php
                         echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'SUBMIT'));
                       //  echo $this->Form->Submit(__('Update User'));
						
			 echo $this->Form->submit('Update User', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
             ?> 
                 </td>
                </tr>
              </table>
                      
						
					<?php echo $this->Form->end(); ?>
                    
                    
  


	
				
				
		
	
	


<script>
document.getElementById("UserUserGroupId").focus();
</script>

</div>
          </div>