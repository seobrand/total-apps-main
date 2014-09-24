<div class="content">
  <div id="right">
	 <div id="right2">
        <div class="box">
          <div class="display_row">
            <div class="table">
            
            		
                    		
	
	<div class="um_box_mid">
		<div class="um_box_mid_content">
			
			<div class="umhr"></div>
			<div class="um_box_mid_content_mid" id="addgroup">
				<?php echo $this->Form->create('UserGroup'); ?>
                <table style="width:100%">
                    	<tr>
                        	<td width="15%"><div class="umstyle3"><?php echo __('Group Name');?><font color='red'>*</font></div></td>
                            <td><div class="umstyle4" ><?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"umstyle5" ))?></div></td>
                        </tr>
                        <tr>
                        	<td><div class="umstyle3"><?php echo __('Alias Group Name');?><font color='red'>*</font></div></td>
                            <td><div class="umstyle4" ><?php echo $this->Form->input("alias_name" ,array('label' => false,'div' => false,'class'=>"umstyle5" ))?></div></td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<?php echo $this->Form->hidden('id')?>
                            <div>
					<div class="umstyle3"><?php echo __('Allow Registration');?></div>
					<div class="umstyle4"><?php echo $this->Form->input("allowRegistration" ,array("type"=>"checkbox",'label' => false))?></div>
					<div style="clear:both"></div>
				</div>
                            </td>
                          
                        </tr>
                        <tr>
                        	<td colspan="2">
                            	<div>
					<div class="umstyle3"></div>
					<div class="umstyle4"><?php echo $this->Form->Submit(__('Update Group'));?></div>
					<div style="clear:both"></div>
				</div>
                            </td>
                        </tr>
                </table>
			
				
                
				
				
				
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
	

            
            </div>
    </div>
    </div>
	</div>
    </div>
</div>







<script>
document.getElementById("UserUserGroupId").focus();
</script>