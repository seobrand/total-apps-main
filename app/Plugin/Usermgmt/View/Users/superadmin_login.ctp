<table width="100%" cellpadding="0" cellspacing="0" >
  <tr>
    <td align="center"><table width="40%" cellpadding="0" cellspacing="0">
        <tr>
          <td><div id="simplemodal-container">
            <h3 style="font-family: Verdana,Arial,Helvetica,sans-serif; margin:0px; padding:8px 10px; text-align:left;">Admin Login</h3>
            <div id="basic-modal-content">
              <div class="simplemodal-login-fields">
                <div style="vertical-align: middle; padding: 5px;" id="UserInfoDiv">
                  <div class="users form"> <?php echo $this->Session->flash(); ?> <!--<span class="umstyle1"><?php echo __('Sign In or'); ?></span> <span  class="umstyle2"><?php echo $this->Html->link(__("Sign Up",true),"/register") ?></span> --><span class="umstyle2" style="float:right"><!--<?php echo $this->Html->link(__("Home",true),"/") ?>--></span>
                    <div class="um_box_mid_content_mid_left" style="height:200px;margin-left:50px"> <?php echo $this->Form->create('User', array('action' => 'login')); ?>
                      <table class="login_tbl">
                       <tr>
                        	<td colspan="3" height="15px;"></td>
                        </tr>
                        <tr>
                          <td align="right" style="line-height:25px;"><?php echo __('Username');?></td>
                          <td width="15"></td>
                          <td align="left"><?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"input1" ))?></td>
                        </tr>
                        <tr>
                        	<td colspan="3" height="15px;"></td>
                        </tr>
                        <tr>
                          <td align="right"><?php echo __('Password');?></td>
                            <td width="15"></td>
                          <td align="left"><?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"input1" ))?></td>
                        </tr>
                        <tr>
                        	<td colspan="3" height="10px;"></td>
                        </tr>
                        <tr>
                        <td></td>
                       <td width="15"></td>
                          <td align="left">
                            
                          <?php   if(!isset($this->request->data['User']['remember']))
								$this->request->data['User']['remember']=true;
					?>
                            <?php echo __('Remember me');?>
                            <?php echo $this->Form->input("remember" ,array("type"=>"checkbox",'label' => false,'div' => false,'style' => 'width:15px;background-image:none;'))?>
                            <div style="clear:both"></div>
                            
                            
                          	  
                            
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3" height="10px;"></td>
                        </tr>
                        
                         <tr>
                         <td></td>
											 <td width="15"></td>
                        	<td align="left">
                          
                          <?php echo $this->Form->Submit('Sign In',array('label' => false,'div' => false,'class'=>"submit_login"));?>
                          
                           
                           
                            
                            </td>
                        </tr>
                        
                        
                      </table>
                      
                      <?php echo $this->Form->end(); ?>
                      <!--<div  align="left"><?php echo $this->Html->link(__("Forgot Password?",true),"/forgotPassword",array("class"=>"style30")) ?></div>-->
                    </div>
                    <script>
document.getElementById("UserEmail").focus();
</script>
                  </div>
                </div>
              </div>
            </div></td>
        </tr>
      </table></td>
  </tr>
</table>
