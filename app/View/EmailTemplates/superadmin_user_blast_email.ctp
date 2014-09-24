<?php echo $this->element('editor'); ?>

<script type='text/javascript'>

 
 
 //var atLeastOneIsChecked = $('input[name="data[EmailTemplate][emailId][]"]:checked').length;
 
 

function showTierDiv()
{

	var isChecked = document.getElementById("selectALLS").checked;
	if(isChecked==true)
	{
		$('input[name="data[EmailTemplate][emailId][]"]').attr("checked", "checked");
	}else
	{	
		$('input[name="data[EmailTemplate][emailId][]"]').removeAttr("checked", "checked");
	}
}


function onChangeAjaxGet(url,value,updateDiv)
{
	var status=document.getElementById('status').value;
	
	var role=document.getElementById('role').value;
	$.ajax({
               type:"GET",
               url:url+''+role+'/'+status,
               success : function(data) {
			   document.getElementById('emailBox').style.display='block';
            	document.getElementById(updateDiv).innerHTML=data
				
				},
               error : function() {
			   alert('sdf');
               },
           })
	
}

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
           })
	$(".example8").colorbox({width:"50%", inline:true});
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
            <div class="titlebar">User EMAIL BLAST</div>
<div class="news_indent">
<?php  echo $this->Form->create('EmailTemplate',array('action'=>'userBlastEmail','id'=>'from')); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
  <tr>
    <td colspan="2" align="left" valign="top">
     
      </td>
  </tr>

  
  
   <tr>
    <td colspan="2" align="left" valign="top">
    Template :<br />
     <?php 

  echo $this->Form->input('template',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$templateList,'onChange'=>'popup(this.value)','empty'=>'Please select','label'=>false,'div'=>false,'style'=>'width:485px')); ?>
    </td>
    </tr>
  
   <tr>
    <td colspan="2" align="left" valign="top">
    	
         Recipients:<br />
         <?php 
		 
  if($this->Session->read('UserAuth.User.user_group_id')=='1')
  {
  	   $role=$common->getGroupList();
	 
	  $role['ALL']='ALL';
	  
  }
  if($this->Session->read('UserAuth.User.user_group_id')=='24')
  {
  	$role=array('20'=>'Agent','22'=>'ISO');
  }
  if($this->Session->read('UserAuth.User.user_group_id')=='22')
  {
  	$role=array('20'=>'Agent');
  }
  
   if($this->Session->read('UserAuth.User.user_group_id')=='23')
  {
  	$role=$common->getGroupList();
	 unset($role['1']);
	 
	//$role=array('20'=>'Agent','22'=>'ISO','24'=>'MANAGER','25'=>'Referral','26'=>'Support','27'=>'MANAGER');
  }
  
  
 
	
  
   if($this->Session->read('UserAuth.User.user_group_id')=='1')
  {
  		echo $this->Form->input('role',array('class'=>'select1','id'=>'role','type'=>'select','options'=>$role,'empty'=>'Please select','label'=>false,'div'=>false,'style'=>'width:485px','onChange'=>'onChangeAjaxGet("'.FULL_BASE_URL.router::url('/',false).'superadmin/email_templates/ajaxGetUser/",this.value,"emailDropdown")')); 
 
  }else
  {
  	 echo $this->Form->input('role',array('class'=>'select1','id'=>'role','type'=>'select','options'=>$role,'empty'=>'Please select','label'=>false,'div'=>false,'style'=>'width:485px')); 
  }
  
  ?>
    </td>
   </tr> 
  
   <tr>
    <td colspan="2" align="left" valign="top">
    	Status:<br />
	    <?php
		$option=array('1'=>'Active','0'=>'Deactive');
		
		
		  if($this->Session->read('UserAuth.User.user_group_id')=='1')
 		 {
			echo $this->Form->input('active',array('class'=>'select1','id'=>'status','type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'div'=>false,'style'=>'width:485px','onChange'=>'onChangeAjaxGet("'.FULL_BASE_URL.router::url('/',false).'superadmin/email_templates/ajaxGetUser/",this.value,"emailDropdown")')); 
   		}else
        {
        	echo $this->Form->input('active',array('class'=>'select1','id'=>'status','type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'div'=>false,'style'=>'width:485px')); 
        }
		?>
    </td>
    </tr>
    <?php
	  if($this->Session->read('UserAuth.User.user_group_id')=='1')
 	 {
	 ?>
    <tr>
        <td colspan="2" align="left" valign="top">
        
       
           <div id="emailBox">
            User:<br />
            
            <div style="height:250px!important;overflow:auto;width:465px;padding:10px;border: 1px solid #CCCCCC;" id="emailDropdown" >
           
           
            
            
            <div class="select1">
                 <input type="checkbox" onclick="showTierDiv()" value="all" id="selectALLS">
               	 <label for="templateALL">ALL</label>
            </div>
            
            <?php
         	echo $this->Form->input('EmailTemplate.emailId',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$UserList,'empty'=>false,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:465px;'));
			
			 ?>
            </div>
                <div style="color:#FF0000">
                <?php if(!empty($emailIdError))
                {
                    echo $emailIdError;
                } ?>
                </div>
            </div>
           
        </td>
    </tr>
    <?php } ?>
  
  <tr>
    <td colspan="2" align="left" valign="top">
    From:<br />
    <?php echo $this->Form->input('from',array('class'=>'input2','id'=>'froms','type'=>'text','label'=>false,'div'=>false,'style'=>'width:479px')); ?>
    </td>
  </tr>
  
  
  <tr>
    <td colspan="2" align="left" valign="top">
    Subject:<br />


      <?php echo $this->Form->input('subject',array('class'=>'input2','id'=>'subject','type'=>'text','label'=>false,'div'=>false,'style'=>'width:479px')); ?>
    </td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top">
   <span class="label_textfield"> Message:</span><br />
 	<?php echo $this->Form->input('message',array('id'=>'message','type'=>'textarea','label'=>false,'div'=>false)); ?>
    </td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top">
 	    <?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> 
    </td>
  </tr>
  
</table>
<?php echo $this->Form->end(); ?>

</div>
          </div>
        </div>
        <!-- end table --> 
      </div>
 
  </div>
  <!-- end content / right --> 
</div>