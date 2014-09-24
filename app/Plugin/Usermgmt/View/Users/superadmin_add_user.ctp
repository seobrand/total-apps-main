<?php $templateList=$common->getTemplatelist($userId,$groupId); ?>
<?php 
 $address_user_id=$this->request->data['User']['id'];
 $address_rec=$common->getUserAddresslist($address_user_id);
 ?>
<link media="screen" rel="stylesheet" href="<?php echo FULL_BASE_URL.Router::url('/', false).'css/popup/';?>colorbox.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="<?php echo FULL_BASE_URL.Router::url('/', false).'css/popup/';?>/jquery.colorbox.js"></script>
<script>
		$(document).ready(function(){
		
		
		
			$(".level_checkbox INPUT[type='checkbox']").click(function(){
		
					if($(this).val()==34){	
					if($(this).attr('checked')){
					
						var total_check=0;
						 var vendor_check=0;
						$("#level-checkbox INPUT[type='checkbox']").each(function(){
							if($(this).val()!=34){	
							if($(this).attr('checked')){
								total_check=total_check+1;
								
							}}else{
								if($(this).attr('checked')){
									vendor_check=vendor_check+1;
								}
							}
						});
						
						if(total_check  || !vendor_check){
							$('#login_crenditial').css('display','block');
							$('#vendor').val('');
						}else{
							$('#login_crenditial').css('display','none');
							$('#vendor').val('vendor');
						}
						
						}else{
						$('#login_crenditial').css('display','block');
						$('#vendor').val('');
					}
					}else{
			
						var total_check=0;
					    var vendor_check=0;
						$("#level-checkbox INPUT[type='checkbox']").each(function(){
						
							if($(this).val()!=34){	
							if($(this).attr('checked')){
								total_check=total_check+1;
								
							}
							}else{
								if($(this).attr('checked')){
									vendor_check=vendor_check+1;
								}
							}
						});
					
						if(total_check || !vendor_check){
							$('#login_crenditial').css('display','block');
							$('#vendor').val('');
						}else{
							$('#login_crenditial').css('display','none');
							$('#vendor').val('vendor');
						}
					}
			});

			
		
			$(".example12").colorbox({width:"50%", inline:true});
			
			  $("#form_address").submit(function(){
			  
			    var form_name=$('#UserAddressFormname').val();
				if(!form_name){
					alert('please enter form name');
				}else{
					var dataString = $("#form_address").serialize();
						$.ajax({
               				type:"POST",
               				url:"<?php echo FULL_BASE_URL.router::url('/',false);?>/superadmin/usermgmt/users/addadditionalinformation",
			 				data:dataString,
               				success : function(data) {
							$('#UserAddressFormname').val('');
							alert(data);
							window.location='<?php echo FULL_BASE_URL.router::url('/',false).''.$this->params->url;?>';
			   				
			   			},
               			error : function() {},
           			
					});	
				}
				return false;
			  
			  return false;
			  }); 
		});
</script>
<style>
fieldset {
	border: 1px solid;
	padding:10px;
}
legend {
	padding:0 8px 0 8px;
	font-weight:bold;
}
.inner fieldset {
	border: 1px solid #999999;
	padding:10px;
	margin-bottom:20px;
}
.inner legend {
	padding:0 8px 0 8px;
	font-weight:bold;
	color:#666666;
}
.clear {
	clear:both;
}
.level_checkbox {
	margin-right:5px;
	display:inline-block;
}
.label {
	top:0px;
	padding:0px 5px 0 2px;
}
.require_field {
	color:#FF0000;
}
</style>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">New User Registration</div>
          <div style="clear:both"> </div>
          <div class="news_indent"> <?php echo $this->Form->create('User', array('action' => 'addUser')); ?>
            <div class="clear">
              <table  width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                <tr>
                  <td><fieldset>
                    <legend>USER INFO</legend>
                    <table  width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                      <tr>
                        <td><table  width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                            <tr>
                              <td width="10%">Contract Length</td>
                              <td width="30%"><?php
				  $contractList =array('1'=>'1 Year','2'=>'2 Year','3'=>'3 Year','4'=>'4 Year','5'=>'5 Year','6'=>'6 Year','7'=>'7 Year','8+'=>'8+ Year');
					echo $this->Form->input('contract_length',array('type'=>'select','options'=>$contractList,'empty'=>false,'label'=>false,'class'=>'select1','tabindex'=>40,'style'=>"width:250px")); 
				   ?> </td>
                              <td width="25%" align="right"> Status<span style="color:#FF0000">*</span> </td>
                              <td width="20%"><?php 
						 $options=array('1'=>'Active','0'=>'Inactive');
                    echo $this->Form->input('active',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$options,'empty'=>false,'label'=>false,'div'=>false,'style'=>'width:324px')); ?>
                              </td>
                            </tr>
                        <?php  $allow2 = $this->Session->read('UserAuth.User.id');
            if ($allow2 == 2){ ?>    
                            <tr>
                     
                      
                        
                 
                      <td >Is Super Admin</td>
                      <td><?php echo $this->Form->input('is_super_admin',array('type'=>'radio','lable'=>false,'div'=>false,'legend'=>false,'separator'=>'&nbsp;&nbsp;&nbsp;&nbsp;','options'=>array('1'=>'Yes','0'=>'No'),'default'=>'0'))?></td>
          
                     <td></td>
                      <td>
                      </td>
                      
                    </tr>
                    <?php } ?>
                          </table></td>
                      </tr>
                      <tr>
                        <td><fieldset id="level-checkbox">
                          <legend>USER LEVEL</legend>
                          <div style="color:#FF0000"><?php echo $errorsLevel;?></div>
                          <?php if(isset($errors['userLevel'][0])){ ?>
                          <div class="error-message"><?php echo $errors['userLevel'][0];?></div>
                          <?php }?>
                          <?php   if (count($userGroups) >2) { ?>
                          <div style="display:block">
                            <?php foreach($userGroups as $key=>$value){
                         echo "<span class='level_checkbox'>".$this->Form->checkbox('UserGroupJoin.'.$key.'.user_group_id',array('value' => $key))."<label class='label'>".$value."</label></span>"; 
                       } ?>
                          </div>
                          <?php   }   ?>
                          </fieldset></td>
                      </tr>
                      <tr>
                        <td><table  width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                            <tr>
                              <td width="45%"  valign="top"><table width="100%" >
                                  <tr>
                                    <td width="15%">Name<span class="require_field">*</span></td>
                                    <td width="30%"><?php echo $this->Form->input('user_Name',array('label'=>false,'class'=>'input1'));?></td>
                                  </tr>
                                  <tr>
                                    <td>Phone<span style="color:#FF0000">*</span></td>
                                    <td><?php echo $this->Form->input('userPhone',array('label'=>'','class'=>'input1'));?></td>
                                  </tr>
                                  <tr>
                                    <td>Email</td>
                                    <td><?php echo $this->Form->input('userEmail',array('label'=>'','class'=>'input1'));?></td>
                                  </tr>
                                  <tr>
                                    <td width="30%" align="left" valign="middle">Application Email</td>
                                    <td width="70%" align="left" valign="middle"><?php echo $this->Form->input('application_email',array('label'=>'','class'=>'input1'));?></td>
                                  </tr>
                                  <tr>
                                  	<td colspan="2">
                                    <div id="login_crenditial" <?php if($this->request->data['User']['vendor']=='vendor'){ ?>style="display:none" <?php } ?>>
                                    	<table  cellpadding="0" cellspacing="0" width="100%">
                                        	 <tr id="tr_username">
                                    <td  width="30%">User ID<span style="color:#FF0000">*</span></td>
                                    <td  width="70%"><?php echo $this->Form->input('username',array('label'=>'','class'=>'input1'));?></td>
                                  </tr>
                                  <tr id="tr_password"  style="width:100%">
                                    <td width="30%"> Password<span style="color:#FF0000">*</span> </td>
                                    <td width="70%" ><?php echo $this->Form->input('password',array('label'=>'','class'=>'input1' ));?> <?php echo $this->Form->input('old_password',array('label'=>'','class'=>'input1','type'=>'hidden','value'=>'hidden'));?> </td>
                                  </tr>
                                  <tr  id="tr_password1"  style="width:100%">
                                    <td  width="30%">Confirm Password<span style="color:#FF0000">*</span></td>
                                    <td  width="30%"><?php echo $this->Form->input('cpassword',array('label'=>'','type'=>'password','class'=>'input1' ));?> </td>
                                  </tr>
                                        </table>
                                        </div>
                                    </td>
                                  </tr>
                                  
                                 
                                  <tr>
                                    <td>User EIN<span style="color:#FF0000">*</span></td>
                                    <td><?php echo $this->Form->input('ein',array('label'=>'','type'=>'text','class'=>'input1' ));?> </td>
                                  </tr>
                                </table></td>
                              <td width="5%"></td>
                              <td  width="45%" valign="top"><table width="100%">
                                  
                                   <tr>
                                    <td>Birthday E-mail Template</td>
                                    <td><?php 
		echo $this->Form->input('email_template_id',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$templateList,'empty'=>'Please select','label'=>false,'div'=>false)); ?>
                                    </td>
                                  </tr>
                                 <?php /*?>  <tr>
                                    <td>Agent ID</td>
                                    <td><?php
				  $agentList =$common->getAgentList();
					echo $this->Form->input('agent_id',array('type'=>'select','options'=>$agentList,'empty'=>false,'label'=>false,'class'=>'select1','tabindex'=>40)); 
				   ?>
                                    </td>
                                  </tr><?php */?>
                                   
                                   <tr>
                                    <td>Agent Split</td>
                                    <td><?php echo $this->Form->input('agent_split',array('label'=>'','class'=>'input1','div'=>false));?>%</td>
                                  </tr>
                              
                                  <tr>
                                    <td>Referral Split</td>
                                    <td><?php echo $this->Form->input('referral_split',array('label'=>'','class'=>'input1','div'=>false));?>%</td>
                                  </tr>
                                  
                                  <tr>
                                    <td>ISO</td>
                                    <td><?php
                      $isoList = $common->getIsoList();
                        echo $this->Form->input('idIso',array('type'=>'select','options'=>$isoList,'empty'=>'-Select ISO-','label'=>false,'class'=>'select1','tabindex'=>40)); 
                       ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>ISO Split</td>
                                    <td><?php echo $this->Form->input('iso_split',array('label'=>'','class'=>'input1','div'=>false));?>%</td>
                                  </tr>
                                 
                                <?php /*?> 
                                  <tr>
                                    <td>Contract Length</td>
                                    <td><?php
				  $contractList =array('1'=>'1 Year','2'=>'2 Year','3'=>'3 Year','4'=>'4 Year','5'=>'5 Year','6'=>'6 Year','7'=>'7 Year','8+'=>'8+ Year');
					echo $this->Form->input('contract_length',array('type'=>'select','options'=>$contractList,'empty'=>false,'label'=>false,'class'=>'select1','tabindex'=>40)); 
				   ?>
                                    </td>
                                  </tr><?php */?>
                                  
                                  <tr>
                                    <td>Internal Debit Card Encryption Key</td>
                                    <td><?php echo $this->Form->input('debitcart_key',array('label'=>'','class'=>'input1','div'=>false));?> </td>
                                  </tr>
                                 
                                  <tr>
                                    <td>User SSN</td>
                                    <td><?php echo $this->Form->input('ssn',array('label'=>'','type'=>'text','class'=>'input1' ));?> </td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                    </fieldset></td>
                </tr>
                <tr>
                  <td><table  width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                      <tr>
                        <td valign="top"><fieldset>
                          <legend>Company Address</legend>
                          <table width="100%">
                            <tr>
                              <td>Company</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyName',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Website</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyUrl',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Address</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyAddress',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
		                      <td>Address2</td>
		                      <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyAddress2',array('label'=>'','class'=>'input1'));?></td>
		                    </tr>
                            <tr>
                              <td>City</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyCity',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>State</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyState',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Country</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyCountry',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>zip</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyZip',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Phone</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyPhone',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Fax</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompanyFax',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                          </table>
                          </fieldset></td>
                        <td></td>
                        <td><fieldset>
                          <legend>User Address</legend>
                          <table width="100%">
                            <tr>
                              <td>Company</td>
                              <td align="left" valign="middle"><?php echo $this->Form->input('userCompany',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Website</td>
                              <td ><?php echo $this->Form->input('website',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Address</td>
                              <td><?php echo $this->Form->input('userAddress',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
		                      <td>Address2</td>
		                      <td><?php echo $this->Form->input('userAddress2',array('label'=>'','class'=>'input1'));?></td>
		                    </tr>
                            <tr>
                              <td>City</td>
                              <td><?php echo $this->Form->input('userCity',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>State</td>
                              <td><?php echo $this->Form->input('userState',array('label'=>'','class'=>'input1' ));?></td>
                            </tr>
                            <tr>
                              <td>Country</td>
                              <td><?php echo $this->Form->input('userCountry',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Zip</td>
                              <td><?php echo $this->Form->input('userZip',array('label'=>'','class'=>'input1'));?></td>
                            </tr>
                            <tr>
                              <td>Phone </td>
                              <td><?php echo $this->Form->input('userPhone2',array('label'=>'','class'=>'input1'));?> </td>
                            </tr>
                            <tr>
                              <td>Fax</td>
                              <td><?php echo $this->Form->input('userfax',array('label'=>'','class'=>'input1'));?> </td>
                            </tr>
                          </table>
                          </fieldset></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td align="right"><span style="padding:16px 0;">
                    <?php 	
		echo $this->Form->input('vendor',array('id'=>'vendor','label'=>false,'class'=>'input1','type'=>'hidden'));
					$created_by=$this->Session->read('UserAuth.User.username');
		echo $this->Form->input('user_by',array('label'=>'','value'=>$created_by,'class'=>'input1','type'=>'hidden'));
	echo $this->Form->input('userID',array('label'=>'','class'=>'input1','type'=>'hidden'));
	echo $this->Form->submit('Add User',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
    </span>
    </td>
                </tr>
              </table>
            </div>
            <?php echo $this->Form->end(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>