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
             <?php 
             echo $this->Form->create('Support', array('action'=>'submitrequest','id'=>'form-validation', 'onsubmit'=>'return beforSubmit();','enctype' => 'multipart/form-data')); ?>
              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
              <tr>
              <th colspan="2" align="left" style="padding-left:15px">Add A New Request</th>
              </tr>
               <tr>
                  <td align="right" valign="top" style="padding-top:15px">Request title <span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Support.title" ,array('type' =>'text','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                <!--
                <tr>
                  <td align="right" valign="top" style="padding-top:15px">Email :</td>
                  <td align="left" valign="top"><?php //echo $this->Form->input("Support.email" ,array('type' =>'text','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                -->
                <tr>                
                  <td align="right" valign="top" style="padding-top:15px">Request type <span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Support.request_type" ,array('type' =>'select','options'=>$typeLists,'empty'=>'Please Select an option -','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                 <tr>                
                  <td align="right" valign="top" style="padding-top:15px">ETA date <span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Support.eta_date" ,array('type' =>'text','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2','readonly'=>true))?> </td>
                </tr>
                <tr>                
                  <td align="right" valign="top" style="padding-top:15px">Priority <span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Support.priority" ,array('type' =>'select','options'=>array('H'=>'High','M'=>'Medium','L'=>'Low'),'label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2','empty'=>'---Select---'))?> </td>
                </tr>
                 <tr>
                  <td align="right" valign="top" style="padding-top:15px">Comments <span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Support.comment" ,array('type' =>'textarea','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                
               <tr>
                  <td align="right" valign="top" style="padding-top:15px">Attach Document :</td>
                  
                  <td align="left" valign="top">
                  <?php 
					echo $this->Form->input("Support.document." ,array('type' =>'file', 'multiple','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                
                <tr>
                  <td align="right" valign="top">&nbsp;</td>

                  <td align="left" valign="top">
                  <?php
				  echo $this->Form->submit('SUBMIT TICKET',array('name'=>'SUBMIT TICKET','value'=>'SUBMIT TICKET','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'style'=>'margin-right:20px;'));
				  echo $this->Form->reset('CANCEL',array('name'=>'CANCEL','value'=>'CANCEL','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
				                
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

<script type="text/javascript" >

function beforSubmit(){
var error = 0;
var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
var title = $('#SupportTitle').val();
var email = $('#SupportEmail').val();
var etadate = $('#SupportEtaDate').val();
var priority = $('#SupportPriority').val();
var SupportRequestType = $('#SupportRequestType').val();
var SupportComment = $('#SupportComment').val();
var SupportDocument = $('#SupportDocument').val();
$('.error-message').remove(); 
 if(title == ''){
 $('#SupportTitle').after('<div class="error-message">Please enter title</div>');
 error++;;
  }
/*if(email == ''){
 $('#SupportEmail').after('<div class="error-message">Please enter email</div>');
 error++;;
  }
 if(email !='' && !reg.test(email)){
 $('#SupportEmail').after('<div class="error-message">Please enter valid email</div>');
 error++;;
  }*/
 if(etadate == ''){
	 $('#SupportEtaDate').after('<div class="error-message">Please enter ETA date</div>');
	 error++;;
  }
   if(priority == ''){
	 $('#SupportPriority').after('<div class="error-message">Please select priority</div>');
	 error++;;
  }
 if(SupportRequestType == ''){
  $('#SupportRequestType').after('<div class="error-message">Please select request type</div>');
  error++;
  }
   if(SupportComment == ''){
 $('#SupportComment').after('<div class="error-message">Please enter comment</div>');
 error++;
  }
/*   if(SupportDocument == ''){
  $('#SupportDocument').after('<div class="error-message">Please select file</div>');
  error++;
  }*/
  
  if(error>0){return false;}
  
	}

jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery("#SupportEtaDate").datepicker({
		dateFormat: "mm/dd/yy",
		minDate : 0
	});
	
});

</script>
