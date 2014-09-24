<?php
echo $this->Html->script('date/jquery.ui.core.js');
echo $this->Html->script('date/jquery.ui.widget.js');
echo $this->Html->script('date/jquery.ui.datepicker.js');
echo $this->Html->css('date/jquery-ui.css');
?>
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
            <div class="table"> <?php echo $this->Form->create('News', array('action' => 'addNews','id'=>'form-validation')); ?>
              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
             <?php  
			 $option=$common->getGroupList();?>
               
               <tr>
               <th colspan="2" align="left" style="padding-left:15px">Add News        <div style="float:right; position: relative; top: -18px; height:0px; margin-right:4px;"> <a href="<?php echo $this->webroot; ?>superadmin/news/newsList"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a> </div>
               </th>
               </tr>
               <tr>
                  <td align="right"><span class="required">*</span>Group :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("News.user_group_id" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2 multiple_list_box','type'=>'select','options'=>$option,'empty'=>false,'multiple'=>'multiple'))?> </td>
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
                  <td align="right" valign="top"><span class="required">*</span>Description  :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("News.description" ,array('type' => 'textarea','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ))?></td>
                </tr>
               
                <tr>
                	<td align="right">Status</td>
                    <td>
                    	<?php 
							$options=array('1'=>'Active','0'=>'Deactive');
							$attributes=array('legend'=>false,'default'=>'1');
							echo $this->Form->radio('News.active',$options,$attributes); 
						?>
                    </td>
                </tr>
                 <tr>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
				  
				  <?php
				  echo $this->Form->input("News.Add" ,array('type' => 'hidden','value'=>'Add','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
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