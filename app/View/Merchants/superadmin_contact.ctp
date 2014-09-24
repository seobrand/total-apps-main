<?php 
    echo $this->Html->css('style_preview.css');
    echo $this->Html->script('popup.js');
?>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="contact">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
			<div class="box1">
			  <div class="news_announcement">
				<div class="titlebar">Contact Information
				<div style="float:right">
					<a href="javascript:void(0);" onclick="addcontact()">Add Contact</a>
				</div>
				</div>
				<div class="box">
             	  <div class="display_row" >
					<div class="table" id="contactlist">
	                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	                    
	                    <tr>
	                      <th width="20%" align="center" valign="top" scope="col">Name</th>
	                      <th width="20%" align="center" valign="top" scope="col">Email</th>
	                      <th width="15%" align="center" valign="top" scope="col"> Phone</th>
						  <th width="35%" align="center" valign="top" scope="col"> title </th>
						  <th width="10%" align="center" valign="top" scope="col"> Action </th>
	                    </tr>
	                    <?php if(count($contactLists)>0){?>
						<?php foreach($contactLists as $contacts){?>
	                    <tr>
	                      <td align="center" valign="top"><?php echo $contacts['Contact']['name']; ?></td>
	                      <td align="center" valign="top"><?php echo $contacts['Contact']['email']; ?></td>
	                      <td align="center" valign="top"><?php echo $contacts['Contact']['phone_number']; ?></td>
	                      <td align="center" valign="top"><?php echo $contacts['Contact']['title']; ?></td>
						  <td align="center" valign="middle">
						  	<?php echo $this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','onclick'=>'editContact('.$contacts['Contact']['id'].')')); ?>&nbsp;
					  		<?php echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("Are you sure to delete this contact detail?");','url' => array('controller' => 'merchants', 'action' => 'contactdelete', $contacts['Contact']['id'],$contacts['Contact']['merchantID']))); ?>
					  	  </td>
	                    </tr>
	                    <?php }?>
	                    <?php }else{?>
						<tr>
	                      <td align="center" valign="top" colspan="5">No Results Found</td>
	                    </tr>
						<?php }?>
	                  </table>
	                </div>
				   </div>
				 </div>
				 
				
			  </div>
        	</div>
         </div>
        </div>
        <!-- display box / second end here -->
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
<!-- Contact Add Form start from here in popup start -->
<a href="#contactaddpopup" id="contact_add_here" name="modal"  style="display:none"></a>
<div id="boxes" style="margin-top:2px;">
<div id="contactaddpopup" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);"> 
<table height="100%" width="1150" style="margin:auto">
<tr>
<td valign="middle">
<div class="popup_outer2" style="width: 450px;left:0px;margin:auto;z-index:99999999999;">
<a href="#" class="close close_button" style="float:right;"><?php echo $this->Html->image('close.png', array('alt' => 'Close'));?></a>
<div class="stroke" style="overflow: visible;">
<div class="popup_container2" style="padding:35px 10px" id="add_contact_form">
<?php  echo $this->Form->create('Merchant',array('name'=>'contactForm','onsubmit'=>'return contactValidation()')); ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
	<tr>
	 <td width="100%" align="left" valign="top" style="padding:0px;">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr height="30">
			<td align="left" width="30%" valign="middle">Name<span style="color:#FF0000">*</span></td>
			<td align="left" width="70%" valign="middle"><?php echo $this->Form->input('Contact.name',array('label'=>false,'div'=>false,'class'=>'input1'));?></td>
		  </tr>
		  <tr height="30">
			<td align="left" valign="middle">Email<span style="color:#FF0000">*</span></td>
			<td align="left" valign="middle"><?php echo $this->Form->input('Contact.email',array('label'=>false,'div'=>false,'class'=>'input1'));?></td>
		  </tr>
		  <tr height="30">
			<td align="left" valign="middle">Phone number</td>
			<td align="left" valign="middle"><?php echo $this->Form->input('Contact.phone_number',array('label'=>false,'div'=>false,'class'=>'input1'));?></td>
		  </tr>
		  <tr height="30">
			<td align="left" valign="middle">Title </td>
			<td align="left" valign="middle"><?php echo $this->Form->input('Contact.title',array('label'=>false,'div'=>false,'class'=>'input1'));?></td>
		  </tr>						  
		  <tr height="40">
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle"><?php echo $this->Form->submit('Save',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
		  </tr>						  
		</table>
	 </td>					 
	</tr>
  </table>
  <?php echo $this->Form->input("Contact.merchantID",array('type'=>hidden,'value'=>$this->request->data['Merchant']['id']));?>
  <?php echo $this->Form->input("Contact.id",array('type'=>hidden));?>				  
<?php echo $this->Form->end();?>
</div>
</div>
</div>
</td>
</tr>
</table>
</div>
</div>

<script type="text/javascript">
function addcontact()
{
	$(document).ready(function(){
		$("#contact_add_here").click();
    });
}
function editContact(id)
{		var xmlhttp;
		if(id!=null || id!='')
		{
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					var contactInfo = xmlhttp.responseText;
					var contactArray = contactInfo.split('~');					
					document.getElementById("ContactName").value = contactArray[0];
					document.getElementById("ContactEmail").value = contactArray[1];
					document.getElementById("ContactPhoneNumber").value = contactArray[2];
					document.getElementById("ContactTitle").value = contactArray[3];
					document.getElementById("ContactMerchantID").value = contactArray[4];
					document.getElementById("ContactId").value = id;
				}
			  }
			var url='';
			url='<?=FULL_BASE_URL.router::url('/',false).'superadmin/merchants/getcontactinfo'?>/'+id;
			
			xmlhttp.open("GET",url,true);
			xmlhttp.send();
			$(document).ready(function(){
		     	$("#contact_add_here").click();
		    });
		}
		else
		{
			alert('Please select valid appointment.');
		}
}

function contactValidation()
{
	var errors = '';
	var count = 0;
	var email1 = document.getElementById('ContactEmail').value;
	var email =trim(email1);
	
	if(trim(document.getElementById('ContactName').value)==''){
		errors += 'Please enter contact name\n';
		count++;
	}
	
	if(email==''){
		errors += 'Please enter contact email\n';
		count++;
	}else if(email!=''){	
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (filter.test(email)){}
		else{
			errors +='Please Enter Valid E-mail Address\n';
			count++;
		}
	}
	
	if(count>0){
		alert(errors);
		return false;
	}else{
		return true;
	}
}

function trim(s) { 
    s = s.replace(/(^\s*)|(\s*$)/gi,"");
    s = s.replace(/[ ]{2,}/gi," "); 
    s = s.replace(/\n /,"\n"); return s;
}

function numbersonly(myfield, e, dec)
	{ var key;var keychar;	
		if (window.event)
		   key = window.event.keyCode;
		else if (e)
		   key = e.which;
		else
		   return true;
		keychar = String.fromCharCode(key);
		// control keys
		if ((key==null) || (key==0) || (key==8) || 
			(key==9) || (key==13) || (key==27) || (key==46) )
		   return true;
		// numbers
		else if ((("0123456789").indexOf(keychar) > -1))
		   return true;
		else
		   return false;
	}
</script>

