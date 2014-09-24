<table width="100%" cellpadding="0" cellspacing="0" >
  <tr>
    <td align="center">
    
<table width="40%">
 
  <tr>
    <td align="center">
    
    
    <div id="simplemodal-container">
            <h3 style="font-family: Verdana,Arial,Helvetica,sans-serif; margin:0px; padding:8px 10px; text-align:left;">Login As</h3>
            <div id="basic-modal-content">
              <div class="simplemodal-login-fields">
                <div style="vertical-align: middle; padding: 5px;" id="UserInfoDiv">
                  <div class="users form">
                    <div class="um_box_mid_content_mid_left" style="height:200px;margin-left:0">
                    
                    <table width="100%">
      
        <tr>
        <td width="20%"></td>
        
          <td align="left"><?php echo $this->Form->create('User', array('action'=>'role'));?>
            <table>
              <tr>
                <td align="right" style="line-height:40px;vertical-align:middle;width:70px;">Role</td>
                 <td width="15"></td>
                <td  align="left" style="height:40px;line-height:40px;vertical-align:middle"><select name="Role">
                    <?php foreach($groupRec as $data) {?>
                    <option value="<?php echo $data['user_groups']['id'] ?>"><?php echo $data['user_groups']['name'] ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
            
              <tr>
              <td></td>
              <td width="15"></td>
              <td align="left"> <?php 
									echo $this->Form->Submit('Login',array('label' => false,'div' => false,'class'=>"submit_login"));
							
							echo $this->Form->end();?> </td>
              </tr>
            </table>
           </td>
        </tr>
       
      </table>
      
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
    
    </td>
  </tr>
</table>

</td></tr>
</table>