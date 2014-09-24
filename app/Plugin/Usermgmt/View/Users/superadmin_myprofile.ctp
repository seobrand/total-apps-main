<!--<div class="umtop">
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->element('dashboard'); ?>
	<div class="um_box_up"></div>
	<div class="um_box_mid">
		<div class="um_box_mid_content">
			<div class="um_box_mid_content_top">
				<span class="umstyle1"><?php echo __('My Profile'); ?></span>
				<span class="umstyle2" style="float:right"><?php echo $this->Html->link(__("Home",true),"/") ?></span>
				<div style="clear:both"></div>
			</div>
			<div class="umhr"></div>
			<div class="um_box_mid_content_mid" id="index">
				<table cellspacing="0" cellpadding="0" width="100%" border="0" >
					<tbody>
			<?php       if (!empty($user)) { ?>
							<tr>
								<td><strong><?php echo __('User Id');?></strong></td>
								<td><?php echo $user['User']['id']?></td>
							</tr>
							<tr>
								<td><strong><?php echo __('User Group');?></strong></td>
								<td><?php echo h($user['UserGroup']['name'])?></td>
							</tr>
							<tr>
								<td><strong><?php echo __('Username');?></strong></td>
								<td><?php echo h($user['User']['username'])?></td>
							</tr>
							<tr>
								<td><strong><?php echo __('First Name');?></strong></td>
								<td><?php echo h($user['User']['first_name'])?></td>
							</tr>
							<tr>
								<td><strong><?php echo __('Last Name');?></strong></td>
								<td><?php echo h($user['User']['last_name'])?></td>
							</tr>
							<tr>
								<td><strong><?php echo __('Email');?></strong></td>
								<td><?php echo h($user['User']['email'])?></td>
							</tr>
							<tr>
								<td><strong><?php echo __('Status');?></strong></td>
								<td><?php
										if ($user['User']['active']) {
											echo 'Active';
										} else {
											echo 'Inactive';
										}
									?>
								</td>
							</tr>
							<tr>
								<td><strong><?php echo __('Created');?></strong></td>
								<td><?php echo date('d-M-Y',strtotime($user['User']['created']))?></td>
							</tr>
				<?php   } else {
							echo "<tr><td colspan=2><br/><br/>No Data</td></tr>";
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="um_box_down"></div>
</div>-->

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">ACCOUNT INFORMATION</div>
          <div class="news_indent">
            <?php

     echo $this->Session->flash(); ?>
            <?php echo $this->Form->create('User'); 
                    ?> <?php echo $this->Form->input("id" ,array('type' => 'hidden', 'label' => false,'div' => false))?>
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
                      <td align="left" valign="middle"><?php echo $this->Form->input('userPhone2',array('label'=>'','class'=>'input1','error'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Company URL</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyUrl',array('label'=>'','class'=>'input1','error'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"> Address 2</td>
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
                      <td align="left" valign="middle"> Password<span style="color:#FF0000">*</span> </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('password',array('label'=>'','class'=>'input1' ));?> <?php echo $this->Form->input('old_password',array('label'=>'','class'=>'input1','type'=>'hidden','value'=>'hidden'));?> </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Confirm Password<span style="color:#FF0000">*</span> </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('cpassword',array('label'=>'','type'=>'password','class'=>'input1' ));?> </td>
                    </tr>
                  </table></td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top"><strong>USER LEVEL</strong><br/>
                        <?php if(isset($errors['userLevel'][0])): ?>
                        <div class="error-message"><?php echo $errors['userLevel'][0];?></div>
                        <?php endif;?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><table>
                          <?php
                      $myprofile=$this->request->data['UserGroupJoin'];
                      $i=1;
                       foreach($myprofile as $profileREC) {?>
                          <tr>
                            <td><strong>
                              <?php 
                            echo   $common->Groupname($profileREC['user_group_id']);
                               ?>
                              </strong> </td>
                          </tr>
                          <?php }?>
                        </table></td>
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
      </div>
    </div>
  </div>
</div>