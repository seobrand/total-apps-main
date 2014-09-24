<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Business Category
		   <div style="float:right">
         	<a href="<?php echo $this->webroot; ?>superadmin/businesscats/viewlist"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
            </div>
		  </div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Businesscat',array('controller'=>'businesscats','action'=>'editbusinesscategory')); ?>
            <div class="news_indent">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="bottom">New Business Category *</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Businesscat.category_name',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                 <tr>
                  <td align="left" valign="bottom">Navigation Sort Order</td>
                </tr>
                 <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Businesscat.navigationOrder',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Update Category',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
			   <?php echo $this->Form->input('Businesscat.id', array('type' => 'hidden','value'=>$this->request->data['Businesscat']['id']));?>
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