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
            <?php

     echo $this->Session->flash(); ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
              <tr>
                <td width="42%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
              <td width="27%" align="left" valign="middle"><strong>Reference Url</strong></td>
              <td width="73%" align="left" valign="middle"><?php 
							echo 'http://total-apps.com/user_ref'.$id;
						?></td>
            </tr>
                   
                    <tr>
                      <td width="27%" align="left" valign="middle"><strong>Name<span style="color:#FF0000">*</span></strong></td>
                      <td width="73%" align="left" valign="middle"><?php echo $user['User']['user_Name'];?></td>
                    </tr>
                   
                    <tr>
                      <td align="left" valign="middle"><strong>Phone<span style="color:#FF0000">*</span></strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userPhone'];?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>Company</strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userCompany'];?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>Address<span style="color:#FF0000">*</span></strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userAddress'];?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>City<span style="color:#FF0000">*</span></strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userCity'];?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>Country<span style="color:#FF0000">*</span></strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userCountry'];?></td>
                    </tr>
                     <?php if($this->request->data['User']['vendor']!='vendor'){ ?>
                    <tr>
                      <td align="left" valign="middle"><strong>User ID<span style="color:#FF0000">*</span></strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['username'];?></td>
                    </tr>
                    <?php } ?>
                    
                  </table></td>
                <td width="42%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="30%" align="left" valign="middle"><strong>Email<span style="color:#FF0000">*</span></strong></td>
                      <td width="70%" align="left" valign="middle"><?php echo $user['User']['userEmail'];?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>Phone 2</strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userPhone2'];?> </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>Company URL</strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userCompanyUrl'];?> 
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>Address 2</strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userAddress2'];?> </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>State<span style="color:#FF0000">*</span></strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userState'];?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><strong>Zip<span style="color:#FF0000">*</span></strong></td>
                      <td align="left" valign="middle"><?php echo $user['User']['userZip'];?> </td>
                    </tr>
                  </table></td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top"><strong>USER LEVEL</strong><br/>
                        <?php if(isset($errors['userLevel'][0])): ?>
                        <div class="error-message"><?php echo $errors['userLevel'][0];?></div>
                        <?php endif;?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php   
                      
                             
                       foreach($user['UserGroupJoin'] as $key=>$value)
                       {
                       	if($value['user_group_id'])
                       	echo '<strong>'.$common->Groupname($value['user_group_id']).'<br /><br /></strong>';
                      
                       }
                        
                         ?>
                      </td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan="3" align="right" valign="top"><span style="padding:16px 40px 0 0;"></span> </td>
              </tr>
            </table>
            <script>
            document.getElementById("UserUserGroupId").focus();
            </script>
          </div>
        </div>
        <div class="display_row"> </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>