<script> 
jq = jQuery.noConflict();
jq(function() {
	jq("#start_date").datepicker({
		minDate : 0
	});
			});
jq(function() {
	jq("#end_date").datepicker({
		minDate : 0
	});
});
</script>
<?php
echo $this->element('editor'); ?>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
     
      <div class="box1">
        
            
          <div class="box">
            <div class="display_row"> 
						<div class="table">
						<?php echo $this->Form->create('News', array('action' => 'editNews','id'=>'form')); ?>
            <div style="float:right; padding-right:15px; margin-top:6px;"> <a href="<?php echo $this->webroot; ?>superadmin/news/newsList"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a> </div>

              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
              <tr>
              <th colspan="2" align="left" class="padding_title_left">
              Edit News
              </th>
              </tr>
                <?php  
			 $option=$common->getGroupList();?>
                <tr>
                  <td align="right"><span class="required">*</span>Group :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("News.user_group_id" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2 input_width','type'=>'select','options'=>$option,'empty'=>false,'multiple'=>'multiple'))?> </td>
                </tr>
                <tr>
                  <td align="right"><span class="required">*</span>Title :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("News.title" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                <tr>
                  <td width="15%" align="right"><span class="required">*</span>Start Date :</td>
                  <td width="85%" align="left" valign="top"><?php echo $this->Form->input("News.start_date" ,array('label' => false,'div' => false,'id'=>'start_date','data-validation-type'=>'present','class'=>'input2'))?></td>
                </tr>
                <tr>
                  <td width="15%" align="right"><span class="required">*</span>End Date :</td>
                  <td width="85%" align="left" valign="top"><?php echo $this->Form->input("News.end_date" ,array('label' => false,'div' => false,'id'=>'end_date','data-validation-type'=>'present','class'=>'input2'))?></td>
                </tr>
                <tr>
                  <td align="right" valign="top" style="padding-top:10px"><span class="required">*</span>Description  :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("News.description" ,array('type' => 'textarea','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ))?></td>
                </tr>
                <tr>
                  <td align="right" valign="middle">Status</td>
                  <td><?php 
							$options=array('1'=>'Active','0'=>'Deactive');
							$attributes=array('legend'=>false,'default'=>'1');
							echo $this->Form->radio('News.active',$options,$attributes); 
						?>
                  </td>
                </tr>
                <tr>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top"><?php
				  echo $this->Form->input("News.id" ,array('type' => 'hidden','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
				  echo $this->Form->input("News.Edit" ,array('type' => 'hidden','value'=>'Edit','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
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