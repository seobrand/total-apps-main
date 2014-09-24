<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <br />
      <br />
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Create Folder
            <div style="float:right"> <a href="<?php echo $this->webroot; ?>superadmin/documents/listFolder"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a> </div>
          </div>
          <div class="box">
            <div class="display_row"> <?php echo $this->Form->create('Document', array('action'=>'createFolder','id'=>'form-validation')); ?>
              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
            
               
                <tr>
                  <td align="right" valign="top"><span class="required">*</span>Title :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Folder.title" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                
                 <tr>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
				  
				  <?php
				  echo $this->Form->input("Folder.Add" ,array('type' => 'hidden','value'=>'Add','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
				   echo $this->Form->submit('SUBMIT',array('name'=>'SUBMIT','value'=>'SUBMIT','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'onsubmit'=>'editor_content()'));?></td>
                </tr>
              </table>
             
             
              <?php echo $this->Form->end(); ?> </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end table -->
  </div>
</div>