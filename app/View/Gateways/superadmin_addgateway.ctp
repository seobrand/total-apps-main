<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Gateway</div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Gateway'); ?>
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
                  <td align="left" valign="top"><?php echo $this->Form->submit('Add New Gateway',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
			  <?php echo $this->Form->end();?>
              <div class="box">
                <div class="display_row">
                  <div class="table">
				  <?php
					$this->Grid->addColumn('Gateway Name', '/Gateway/gatewayName', array('paginate'=>true),'gatewayName');			
					$this->Grid->addColumn('Gateway URL', '/Gateway/gatewayURL', array('paginate'=>true),'gatewayURL');			 
					$this->Grid->addColumn('Gateway UID', '/Gateway/gatewayUIDvar', array('paginate'=>true),'gatewayUIDvar');												
					$this->Grid->addColumn('Gateway Password', '/Gateway/gatewayPWDvar', array('paginate'=>true),'gatewayPWDvar');
					$this->Grid->addAction('Edit', array('controller' => 'gateways', 'action' => 'editgateway'), array('/Gateway/id'));
					$this->Grid->addAction('Delete', array('controller' => 'gateways', 'action' => 'deletegateway'), array('/Gateway/id'));
					echo $this->Grid->generate($GatewayList);
					?>
					<div class="paginator">
						<?php echo $this->Paginator->numbers(array('first' => 'First page'));?></td>
					</div>
                  </div>
                </div>
              </div>
            </div>
			</div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
