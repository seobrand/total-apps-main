<?php //pr($this->request->data);?>
<div style="color:#000000;clear:both" id="123456"></div>
<div class="content"> 
  <!-- content / right -->
  <div id="right">
   
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="news_announcement">
            <div class="titlebar">SET REPORT PERMISSION</div>
				<div class="news_indent">
					<?php  echo $this->Form->create('UserReport',array('id'=>'from','onsubmit'=>'return validate_search_form()')); ?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
				  <tr>
				    <td colspan="2" align="left" valign="top">Select the users to set the permission for reports.</td>
				  </tr>	
				  <tr>
    				<td colspan="2" align="left" valign="top">Report Name:<br />
				     <?php echo $this->Form->input('reportlist_id',array('class'=>'select1','id'=>'reportlist','type'=>'select','options'=>$reportlist,'empty'=>'Please select Report','label'=>false,'div'=>false,'style'=>'width:485px','onChange'=>'onChangeAjaxGet()')); ?>
				    </td>
				   </tr>
				  <tr>
    				<td colspan="2" align="left" valign="top">Filter By User Level:<br />
				     <?php echo $this->Form->input('role',array('class'=>'select1','id'=>'role','type'=>'select','options'=>$role,'empty'=>'Please select','label'=>false,'div'=>false,'style'=>'width:485px','onChange'=>'onChangeAjaxGet()')); ?>
				    </td>
				   </tr>			 
				   <tr>
				    <td colspan="2" align="left" valign="top">Users:<br/>
					  <div style="height:300px!important;overflow:scroll;width:485px;" id="usersDropdown">
				       	 <div class="select1">
		                     <input type="checkbox" onclick="showTierDiv()" value="all" id="selectALLS">
		                     <label for="templateALL">ALL</label>
		           		 </div>
				        <?php 
							echo $this->Form->input('UserReport.id',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$userlist,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:485px'));
						?>				         
				     </div>
				    </td>
				  </tr>
				  <tr>
				    <td colspan="2" align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
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

<script type="text/javascript">

function showTierDiv()
{

	var isChecked = document.getElementById("selectALLS").checked;
	if(isChecked==true)
	{
		$('input[name="data[UserReport][id][]"]').attr("checked", "checked");
	}else
	{	
		$('input[name="data[UserReport][id][]"]').removeAttr("checked", "checked");
	}
}	

function onChangeAjaxGet()
{	
	var report = $("#reportlist").val();
	var roles = $("#role").val();	
	if(roles=='')
		roles = 'no_role';
	
	get_url = "<?php echo FULL_BASE_URL.router::url('/',false).'superadmin/email_templates/getuserbyrole/';?>";
	get_url += roles+'/'+report;
	$.ajax({
		type:"GET",
		url:get_url,
		success : function(data){
		   document.getElementById('usersDropdown').innerHTML=data
		},
		error : function() {
		   alert('Sorry there is some error.Please try again.');
		},
	})
	
}
function validate_search_form(){
	var count = 0;
	var msg = "";
	
	if( $("#reportlist").val()==''){
    	alert("Please select report name for set permission");
    	return false;
    }
	
	$('input[name="data[UserReport][id][]"]').each(function() {
        if( $(this).attr("checked")=='checked'){
        	count++;
        }
    }); 
	
    if(count==0){
		alert("Please select user for set permission");
		return false;
    }
    return true;
}
</script>