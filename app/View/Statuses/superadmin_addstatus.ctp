<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">ACCOUNT STATUS</div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Status'); ?>
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
                  <td align="left" valign="top"><?php echo $this->Form->submit('Add New Status',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
			  <?php echo $this->Form->end();?>
              <div class="box">
                <div class="display_row">
                  <div class="table">
				   <?php
					$this->Grid->addColumn('Status', '/Status/status', array('paginate'=>true),'status');			
					$this->Grid->addColumn('Navigation Order', '/Status/navigationOrder', array('paginate'=>true),'navigationOrder');			 
					$this->Grid->addAction('Edit', array('controller' => 'statuses', 'action' => 'editstatus'), array('/Status/id'));
					$this->Grid->addAction('Delete', array('controller' => 'statuses', 'action' => 'deletestatus'), array('/Status/id'));
					echo $this->Grid->generate($StatusList);
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
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
