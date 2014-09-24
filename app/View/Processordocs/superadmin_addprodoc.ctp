<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">PROCESSOR DOCUMENT</div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Processordoc'); ?>
            <div class="news_indent">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="bottom">Document Name *</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Processordoc.docName',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Add New Document',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
			  <?php echo $this->Form->end();?>
              <div class="box">
                <div class="display_row">
                  <div class="table">
				  <?php
					$this->Grid->addColumn('Document Name', '/Processordoc/docName', array('paginate'=>true),'docName');			
					$this->Grid->addAction('Edit', array('controller' => 'processordocs', 'action' => 'editprodoc'), array('/Processordoc/id'));
					$this->Grid->addAction('Delete', array('controller' => 'processordocs', 'action' => 'deleteprodoc'), array('/Processordoc/id'));
					echo $this->Grid->generate($ProcessordocList);
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
