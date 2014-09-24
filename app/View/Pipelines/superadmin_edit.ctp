<div class="content"> 
  <!-- content / right -->
  <div id="right">
    
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="news_announcement">
            <div class="titlebar">GENERAL INFORMATION</div>
            <div class="news_indent">
			<?php  echo $this->Form->create('User',array('controller'=>'users','action'=>'edit')); ?> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                <tr>
                  <td width="42%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="27%" align="left" valign="middle">Name:*</td>
                        <td width="73%" align="left" valign="middle"><?php echo $this->Form->input('user_Name',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Phone:*</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userPhone',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Company:</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userCompany',array('label'=>'','class'=>'input1','error'=>false));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Address:*</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userAddress',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">City:*</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userCity',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Country:*</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userCountry',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">User ID:*</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('username',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                    </table></td>
                  <td width="42%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" align="left" valign="middle">Email:*</td>
                        <td width="70%" align="left" valign="middle"><?php echo $this->Form->input('userEmail',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Phone 2:</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userPhone2',array('label'=>'','class'=>'input1','error'=>false));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Company URL:</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyUrl',array('label'=>'','class'=>'input1','error'=>false));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">	Address 2:</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userAddress2',array('label'=>'','class'=>'input1','error'=>false));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">State:*</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userState',array('label'=>'','class'=>'input1' ));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Zip:*</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('userZip',array('label'=>'','class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">	Password:* 	</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('password',array('label'=>'','class'=>'input1' ));?>
                        <?php echo $this->Form->input('old_password',array('label'=>'','class'=>'input1','type'=>'hidden','value'=>'hidden'));?>
                       
                        </td>
                      </tr>
                    </table></td>
                  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top"><strong>USER LEVEL</strong><br/><?php if(isset($errors['userLevel'][0])): ?><div class="error-message"><?php echo $errors['userLevel'][0];?></div><?php endif;?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                         <tr>
                          <td width="10%" align="left" valign="middle"><?php echo $this->Form->checkbox('User.isAdmin',array('value' => 1)); ?></td>
                          <td width="90%" align="left" valign="middle">Admin</td>
                        </tr>
                        <tr>
                          <td width="10%" align="left" valign="middle"><?php echo $this->Form->checkbox('User.isAgent', array('value' => 1)); ?></td>
                          <td width="90%" align="left" valign="middle">Agent</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"><?php echo $this->Form->checkbox('User.isIso', array('value' => 1)); ?></td>
                          <td align="left" valign="middle">ISO</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"><?php echo $this->Form->checkbox('User.isProcessor', array('value' => 1)); ?></td>
                          <td align="left" valign="middle">Processor</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"><?php echo $this->Form->checkbox('User.isManager', array('value' => 1)); ?></td>
                          <td align="left" valign="middle">Manager</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"><?php echo $this->Form->checkbox('User.isTech', array('value' => 1)); ?></td>
                          <td align="left" valign="middle">Technical</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"><?php echo $this->Form->checkbox('User.isSupport', array('value' => 1)); ?></td>
                          <td align="left" valign="middle">Support</td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="3" align="right" valign="top"><span style="padding:16px 40px 0 0;">
                     <?php echo $this->Form->input('userID',array('label'=>'','class'=>'input1','type'=>'hidden','value'=>'hidden'));?>
                    <?php echo $this->Form->submit('Add User',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
                  </span></td>
                </tr>
              </table>
         
  			<?php echo $this->Form->end();?>
            </div>
          </div>
		  
		  <div class="display_row">
<div class="tabs_outer">
<ul>
<li class="active"><a href="user-agent.html">Agent </a></li>
<li><a href="user-iso.html">Iso</a></li>
<li><a href="user-processor.html">Processor</a></li>
<li><a href="user-manager.html">Manager</a></li>
<li><a href="user-action.html">Action</a></li>
<li><a href="user-notes.html">Notes</a></li>
<li><a href="user-referral-source.html">Referral Source</a></li>
</ul>
</div>
<div class="tabs_des">
<div class="links_col">
<ul class="links">
<li class="active"><a href="user-view-merchant.html">Agent Information:</a></li>
<li><a href="user-view-merchant.html">View Merchants:</a></li>
<li><a href="view-source.html">View Source</a></li>
</ul>
</div>

 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
  <tr>
    <td align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="24%" align="left" valign="middle">Bank Name:</td>
        <td width="76%" align="left" valign="middle"><input name="input" type="text" class="input1" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Account Number:</td>
        <td align="left" valign="middle"><input name="input23" type="text" class="input1" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Photo ID:</td>
        <td align="left" valign="middle"><input name="input23" type="text" class="input1" /></td>
      </tr>
    </table></td>
    <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="22%" align="left" valign="middle">ABA/Routing:</td>
        <td width="78%" align="left" valign="middle"><input name="input20" type="text" class="input1" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Voided  Check:</td>
        <td align="left" valign="middle"><input name="input21" type="text" class="input1" /></td>
      </tr>
    </table></td>
  </tr>
</table>
 






</div>





</div>

        </div>
        <!-- end table --> 
      </div>
 
  </div>
  <!-- end content / right --> 
</div>