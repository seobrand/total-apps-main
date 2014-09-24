<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">ACCOUNT STATUS
		  <div style="float:right">
         	<a href="<?php echo $this->webroot; ?>superadmin/statuses/addstatus"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
            </div>
		  </div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Status',array('controller'=>'statuses','action'=>'editstatus')); ?>
            <div class="news_indent">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="bottom">New Status *</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Status.status',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr>
                  <td align="left" valign="bottom">Navigation Sort Order</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Status.navigationOrder',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Update Status',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
			   <?php echo $this->Form->input('Status.id', array('type' => 'hidden','value'=>$this->request->data['Status']['id']));?>
			  </div>
           <?php echo $this->Form->end();?>
		    </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
