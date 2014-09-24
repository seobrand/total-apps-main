<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Gateway
		  <div style="float:right">
         	<a href="<?php echo $this->webroot; ?>superadmin/gateways/addgateway"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
            </div>
		  </div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Gateway',array('controller'=>'gateway','action'=>'editgateway')); ?>
            <div class="news_indent">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="bottom">New Gateway *</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Gateway.gatewayName',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr>
                  <td align="left" valign="bottom">Gateway URL</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Gateway.gatewayURL',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
				<tr>
                  <td align="left" valign="bottom">Gateway UID</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Gateway.gatewayUIDvar',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
				<tr>
                  <td align="left" valign="bottom">Gateway Password </td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Gateway.gatewayPWDvar',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Update Gateway',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
			   <?php echo $this->Form->input('Gateway.id', array('type' => 'hidden','value'=>$this->request->data['Gateway']['id']));?>
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
