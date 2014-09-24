<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">USER CATEGORY
		  <div style="float:right">
         	<a href="<?php echo $this->webroot; ?>superadmin/usercats/viewlist"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
            </div>
		</div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Usercat'); ?>
            <div class="news_indent">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="bottom">Category Name*</td>
                </tr>
                
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Usercat.category_name',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                 <tr>
                  <td align="left" valign="bottom">Navigation Sort Order</td>
                </tr>
                
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Usercat.navigationOrder',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Add Category',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>			       
            </div>
            <?php echo $this->Form->end();?> </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
