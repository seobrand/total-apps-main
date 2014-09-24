<?php echo $this->element('editor'); ?>
<script type='text/javascript'>
function popup(id)
{

	  $.ajax({
               type:"GET",
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>email_templates/getTemplate?id="+id,
               success : function(data) {
					obj =  jQuery.parseJSON(data);
					document.getElementById("subject").value=obj.EmailTemplate.subject;
					
					tinyMCE.activeEditor.setContent(obj.EmailTemplate.message);
					//document.getElementById("message").value=obj.message;
					document.getElementById("froms").value=obj.EmailTemplate.from;

               },
               error : function() {
               },
           });
	$(".example8").colorbox({width:"50%", inline:true});
}	


function showTierDiv()
{
	var isChecked = document.getElementById("selectALLS").checked;
	if(isChecked==true)
	{
		$('input[name="data[EmailTemplate][idProcessor][]"]').attr("checked", "checked");
	}else
	{	
		$('input[name="data[EmailTemplate][idProcessor][]"]').removeAttr("checked", "checked");
	}
}
	
</script>
<div style="color:#000000;clear:both" id="123456">


</div>
<div style="color:#000000;clear:both" id="123456">


</div>
<div class="content"> 
  <!-- content / right -->
  <div id="right">
   
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="news_announcement">
            <div class="titlebar">MERCHANT  EMAIL BLAST</div>
<div class="news_indent">
<?php  echo $this->Form->create('EmailTemplate',array('action'=>'merchantBlastEmail','id'=>'from')); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
  <tr>
    <td colspan="2" align="left" valign="top">
      
      </td>
  </tr>
  <tr>
    <td align="left" valign="top">  Template :<br />
      <?php 

  echo $this->Form->input('template',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$templateList,'onChange'=>'popup(this.value)','empty'=>'Please select','label'=>false,'div'=>false,'style'=>'width:485px;')); ?>
      </td>
    <td align="left" valign="top">
    
    </td>
  </tr>
  <tr>
    <!--<td width="27%" align="left" valign="top">
      Recipients:<br />
 
  <?php 
  
  	 
	 

 
  	$role=array('20'=>'Associated ','22'=>'ISO');
  
 
  
  echo $this->Form->input('role',array('class'=>'select1','id'=>'role','type'=>'select','options'=>$role,'empty'=>'Please select','label'=>false,'div'=>false,'style'=>'width:479px;')); ?>
      </td>-->
    <td  colspan="2"  align="left" valign="top">From:<br />

  <?php echo $this->Form->input('from',array('class'=>'input2','id'=>'froms','type'=>'text','label'=>false,'div'=>false,'style'=>'width:479px;')); ?>
  </td>
  </tr>
  
  <tr>
    <td colspan="2" align="left" valign="top">
    	Subject:<br />
	    <?php echo $this->Form->input('subject',array('class'=>'input2','id'=>'subject','type'=>'text','label'=>false,'div'=>false,'style'=>'width:479px;')); ?>
    </td>
    </tr>
    
    <?php if($this->Session->read('UserAuth.User.user_group_id')=='1')
			{
	 ?>
      <tr>
    <td colspan="2" align="left" valign="top">
    	Processor:<br />
	  <div style="height:200px!important;overflow:scroll;width:485px;">
       <div class="select1">
                     <input type="checkbox" onclick="showTierDiv()" value="all" id="selectALLS">
                     <label for="templateALL">ALL</label>
           		 </div>
        <?php 
		$processorList=$common->getProcessorList();
		//echo $this->Form->input('idProcessor',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$processorList,'empty'=>'Processor','label'=>false,'div'=>false,'style'=>'width:485px','empty'=>'Select Processor'));
		
		echo $this->Form->input('idProcessor',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$processorList,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:485px'));
		
		 ?>
         
         </div>
    </td>
    </tr>
    <?php } ?>
    
    
    <tr>
    <td colspan="2" align="left" valign="top">
    	Status:<br />
	    <?php
		$option=array('1'=>'LEAD','2'=>'PRE-APP','3'=>'INCOMPLETE','4'=>'PENDING','5'=>'Processing','9'=>'INTEGRATION');
		echo $this->Form->input('statusID',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$option,'empty'=>'Select Status','label'=>false,'div'=>false,'style'=>'width:485px')); ?>
   
    </td>
    </tr>
    
  <tr>
    <td colspan="2" align="left" valign="top">
    <span class="label_textfield">Message:</span><br />
 	<?php echo $this->Form->input('message',array('id'=>'message','type'=>'textarea','label'=>false,'div'=>false)); ?>
    </td>
    </tr>
  <tr>
  
  
 
  <tr>
  
    <td colspan="2" align="left" valign="top">
    <!--  <table width="30%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="middle"><input type="submit" class="cursorclass ui-state-default ui-corner-all" name="AddAnnouncement3" value="Preview" /></td>
          <td align="left" valign="middle"><input type="submit" class="cursorclass ui-state-default ui-corner-all" name="AddAnnouncement" value="Cancel" /></td>
          <td align="left" valign="middle"></td>          
          </tr>
  </table>-->
      
     <?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> 
      
      </td>
  </tr>
  <tr>
  <td colspan="2" align="left" valign="top">
  <?php echo $this->Form->end(); ?>
  </td>
  </tr>
</table>


</div>
          </div>
        </div>
        <!-- end table --> 
      </div>
 
  </div>
  <!-- end content / right --> 
</div>