<?php echo $this->element('editor'); ?>
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
           <div class="titlebar">add new email Template
            <div style="float:right">
         	<a href="<?php echo $prePage; ?>"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
            </div>
          </div>
          <div class="box">
            <div class="display_row">
        
         	 <?php echo $this->Form->create('EmailTemplate', array('action'=>'createTemplate','id'=>'form','enctype'=>'multipart/form-data'));?>
               
                
                    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
                      <tr>
                        <td align="right" valign="top"><span class="required">*</span>Title :</td>
                        <td align="left" valign="top">
						<?php echo $this->Form->input('title', array('label'=>'','id'=>'title','class'=>'input2','div'=>false,'style'=>'width:415px;height:15px;')); ?>
                        
                       
                        </td>
                      </tr>	
                      
                        
                      <tr>
                        <td width="15%" align="right" valign="top"><span class="required">*</span>Subject :</td>
                        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('subject', array('label'=>'','id'=>'subject','class'=>'input2','div'=>false,'style'=>'width:415px;height:15px;')); ?></td>
                      </tr>
                
                      <tr>
                        <td width="15%" align="right" valign="top">From :</td>
                        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('from', array('label'=>false,'id'=>'from','class'=>'input2','div'=>false,'style'=>'width:415px;height:15px;')); ?></td>
                      </tr>
                
                      <tr>
                        <td align="right" valign="top"><span class="required">*</span>Message :</td>
                        <td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0" class="nostyle" >
                                <tr><td><?php echo $this->Form->input('message', array('label'=>'','type'=>'textarea','cols'=>'80','rows'=>'20','id'=>'message')); ?> </td></tr></table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">&nbsp;</td>
                        <td align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'onsubmit'=>'editor_content()'));?></td>
                      </tr>
                     </table>
                       <?php echo $this->Form->input('prePage', array('label'=>'','type'=>'hidden','value'=>$prePage)); ?>
              <input type="hidden" name="SUBMIT" value="SUBMIT" />
              <?php echo $this->Form->end();?>
              
        </div>
        </div>
           </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
