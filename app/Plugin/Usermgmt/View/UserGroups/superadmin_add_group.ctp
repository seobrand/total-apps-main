<div class="content">
  <div id="right">
    <div id="right2">
      <div class="box">
        <div class="display_row">
          <div class="table">
            <div class="news_indent"> <?php echo $this->Form->create('UserGroup', array('action' => 'addGroup')); ?>
              <div class="news_indent">
                <table style="background-color:#FFFFFF;" width="100%" class="form_table">
                  <tr>
                    <td width="15%"><div class="umstyle3"><?php echo __('Group Name');?><font color='red'>*</font></div></td>
                    <td><?php echo $this->Form->input("name" ,array('label' => false,'div' => false,'class'=>"input1" ,'style'=>'width:300px'))?></td>
                  </tr>
                  <tr>
                    <td><div class="umstyle3"><?php echo __('Alias Group Name');?><font color='red'>*</font></div></td>
                    <td><div class="umstyle4" ><?php echo $this->Form->input("alias_name" ,array('label' => false,'div' => false,'class'=>"input1",'style'=>'width:300px'))?></div></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php   if (!isset($this->request->data['UserGroup']['allowRegistration'])) {
							$this->request->data['UserGroup']['allowRegistration']=true;
						}   ?>
                      <?php echo __('Allow Registration');?>
                      <div class="umstyle4"><?php echo $this->Form->input("allowRegistration" ,array("type"=>"checkbox",'label' => false))?></div>
                      <?php echo $this->Form->Submit(__('Add Group'));?> </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                  </tr>
                </table>
              </div>
              <div>Note: If you add a new group then you should give permissions to this newly created Group.</div>
              <?php echo $this->Form->end(); ?> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
document.getElementById("UserUserGroupId").focus();
</script>