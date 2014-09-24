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
             <?php echo $this->Form->create('Support', array('action'=>'index','id'=>'form-validation', 'enctype' => 'multipart/form-data')); ?>
              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
              <tr>
              <th colspan="2" align="left" style="padding-left:15px">Add A New Ticket</th>
              </tr>
                <tr>
                  <td align="right" valign="top" style="padding-top:15px">Subject<span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Support.subject" ,array('type' =>'text','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                 
                 <tr>
                  <td align="right" valign="top" style="padding-top:15px">Comment<span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Support.address" ,array('type' =>'textarea','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                
                <tr>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top"><?php
				  echo $this->Form->input("Support.Add" ,array('type' => 'hidden','value'=>'Add','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
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
