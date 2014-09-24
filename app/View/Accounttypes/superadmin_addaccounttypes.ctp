<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">MERCHANT CATEGORY
		  <div style="float:right">
         	<a href="<?php echo $this->webroot; ?>superadmin/accounttypes/viewlist"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
            </div>
		</div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Accounttype'); ?>
            <div class="news_indent">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="bottom">New Merchant Category *</td>
                </tr>
                
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Accounttype.accountType',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                 <tr>
                  <td align="left" valign="bottom">Navigation Sort Order</td>
                </tr>
                
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Accounttype.navigationOrder',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Add Merchant Category',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
			  <?php echo $this->Form->end();?>
              <!--<div class="box">
                <div class="display_row">
                  <div class="table">
				  <?php
					$this->Grid->addColumn('Gateway Name', '/Accounttype/accountType', array('paginate'=>true),'accountType');		
                    $this->Grid->addColumn('Navigation Order', '/Accounttype/navigationOrder', array('paginate'=>true),'navigationOrder');		
                    
                    
                    
                    	
					$this->Grid->addAction('Edit', array('controller' => 'accounttypes', 'action' => 'editaccounttypes'), array('/Accounttype/id'));
                    
					$this->Grid->addAction('Delete', array('controller' => 'accounttypes', 'action' => 'deleteaccounttypes'), array('/Accounttype/id'));
					echo $this->Grid->generate($AccountList);
					?>
					<div class="paginator">
						<?php echo $this->Paginator->numbers(array('first' => 'First page'));?></td>
					</div>
                 </div>
                </div>
              </div>-->
            </div>
            <?php echo $this->Form->end();?> </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
