<?php 
//echo $this->element('editor'); ?>
<script type="text/javascript">
function showhide(id1,id2,id3)
{
	document.getElementById(id1+'-li').className = 'active';	
	document.getElementById(id1).style.display='block';
	document.getElementById(id2).style.display='none';
	document.getElementById(id2+'-li').className = '';
	document.getElementById(id3).style.display='none';
	document.getElementById(id3+'-li').className = '';
	
	if(id1=='agentInfo')
	{
		$("#krymson_nav ul").addClass('test');
	}else
	{
		$(".krymson_nav ul").addClass('test');
	}
	
}

function refreshpage(pageId,response)
{
	document.getElementById("office_name").value='';
	document.getElementById("office_url").value='';
	document.getElementById("office_username").value='';
	document.getElementById("office_password").value='';
	document.getElementById("office_notes").value='';
	
	alert(response);
	updatedUserList('Office');
	showhideInnerDiv('DepartmentList','addDepartmentContact');
}

function updatedUserList(type)
{
	$.ajax({
	  type: "GET",
      url: '<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/usermgmt/users/getuserList/'+type+'/'+<?php echo $id; ?>,
      success: function(response) {
	  document.getElementById("DepartmentList").innerHTML=response;
	 	
      },
	   error : function(error) {
	   alert('error');
	   
	   }
	  })
}

function frmSubmit(fromId,url)
{
	var dataString = $("#"+fromId).serialize();
	
	$.ajax({
			 type: "POST",
      url: url,
      data: dataString,
      success: function(response) {
	
		  if(response=='back officelogin detail has been saved successfully')
		  {
			refreshpage(fromId,response); 
		  }else
		  {
		 
			response=response.replace(/<br>/g, "\n");
			  alert(response);
		  }
		  
		  
	
      },
	   error : function(error) {
	   alert('error');
	   
	   }
	  })
	 
	return false;
}

function blankAllPages()
{
	$('#office_name').val('');
	$('#office_url').val('');
	$('#office_username').val('');
	$('#office_notes').val('');
	$('#office_password').val('');
	$('#office_id').val(''); 						
}


function showhideInnerDiv(firstDiv,SecondDiv)  
{
	blankAllPages()
	if(document.getElementById(firstDiv).style.display=='none')
	{
		document.getElementById(firstDiv).style.display='block';
		document.getElementById(SecondDiv).style.display='none';
	}else
	{
		document.getElementById(firstDiv).style.display='none';
		document.getElementById(SecondDiv).style.display='block';
	}	
}


function deleteContactInfo(id,userId,contactType)
{
	var contmsg=confirm('Are you sure, you want to delete?');
	if(contmsg)
	{
	 $.ajax({
               type:"GET",
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/usermgmt/users/deletecontactinformation/"+id+"/"+userId+'/'+contactType,
               success : function(data) {
			   //	obj =  jQuery.parseJSON(data);
				alert(data);
					updatedUserList('Office');
				
			
				
				
               },
               error : function() {
               },
           });
	}
	return false;

}

function editEmailContactInfo(id,userId,contactType)
{

	 $.ajax({
               type:"GET",
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/usermgmt/users/getusercontactinformation/"+id+"/"+userId+'/'+contactType,
               success : function(data) {
			   
			   obj =  jQuery.parseJSON(data);
						
					showhideInnerDiv('DepartmentList','addDepartmentContact');
					document.getElementById("office_name").value=obj.Userbackofficelogin.name;
					document.getElementById("office_url").value=obj.Userbackofficelogin.url;
					document.getElementById("office_username").value=obj.Userbackofficelogin.username;
					document.getElementById("office_notes").value=obj.Userbackofficelogin.notes;
					document.getElementById("office_password").value=obj.Userbackofficelogin.password;
					document.getElementById("office_id").value=obj.Userbackofficelogin.id;
				


               },
               error : function() {
               },
           });
	
}

</script>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('generalinformation'); ?>
        <div class="display_row">
          <div class="tabs_outer"> <?php echo $this->element('usersmenu'); ?> </div>
          <div class="tabs_des">
            <div class="links_col">
              <ul class="links" id="krymson_nav">
                <li class="active" id="firstdiv-li"><a href="javascript:void(0);">Back Office Login:</a></li>
              </ul>
              <div id="frmErrorMsg"></div>
            </div>
            <div id="firstdiv">
              <div id="departmentmessage"> </div>
              <div style="clear:both;height:5px;"></div>
              <div  id="content" class="box">
                <div style="clear:both;display:block" id="DepartmentList">
                  <input type="Button" name="Add" value="Add New Back Office Login" onclick="showhideInnerDiv('DepartmentList','addDepartmentContact')"  class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                  <br />
                  <br />
                  <table  width="100%">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>URL</th>
                        <th>User Name</th>
                        <th>Password</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
					  if(count($backofficeList) > 0)
					  { 
						foreach($backofficeList as $value){ ?>
                      <tr class="cg_row odd"  valign="middle" height="53px;">
                        <td><?php echo $value['Userbackofficelogin']['name']; ?></td>
                        <td><?php echo $value['Userbackofficelogin']['url']; ?></td>
                        <td><?php echo $value['Userbackofficelogin']['username']; ?></td>
                         <td><?php echo $value['Userbackofficelogin']['password']; ?></td>
                        <td><a href="javascript:void(0);"> <img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Userbackofficelogin']['id']; ?>,<?php echo $value['Userbackofficelogin']['user_id']; ?>,'Office');"> </a> 
                        
                        <a href="javascript:void(0);"> <img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Userbackofficelogin']['id']; ?>,<?php echo $value['Userbackofficelogin']['user_id']; ?>,'Office');"> </a> </td>
                      </tr>
                      <?php }}else{ ?>
                      	<tr>
                        	<td colspan="5" align="center"> No Record Found</td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div style="clear:both;display:none" id="addDepartmentContact">
                <div id="message_board"></div>
                <input type="Button" name="Add" value="Back Office Login List" onclick="showhideInnerDiv('DepartmentList','addDepartmentContact')"  class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                <br />
                <br />
                <?php echo $this->Form->create('User',array('id'=>'frmdepartment'));?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                  <tr>
                    <td align="left" valign="top" class="rpadnone" style="padding:0px;" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        
                        <tr>
                          <td align="left" valign="middle">Name</td>
                          <td align="left" valign="middle"><?php echo $this->Form->input('Userbackofficelogin.name',array('type'=>'text','id'=>'office_name','class'=>'input1','label'=>'')); ?></td>
                        </tr>
                        <tr> 
                          <td align="left" valign="middle">URL</td>
                          <td align="left" valign="middle"><?php echo $this->Form->input('Userbackofficelogin.url',array('type'=>'text','id'=>'office_url','class'=>'input1','label'=>'')); ?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">User Name</td>
                          <td align="left" valign="middle"><?php echo $this->Form->input('Userbackofficelogin.username',array('type'=>'text','id'=>'office_username','class'=>'input1','label'=>'')); ?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">Password</td>
                          <td align="left" valign="middle"><?php echo $this->Form->input('Userbackofficelogin.password',array('type'=>'text','id'=>'office_password','class'=>'input1','label'=>'')); ?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">Notes</td>
                          <td align="left" valign="middle"><?php echo $this->Form->input('Userbackofficelogin.notes',array('type'=>'textarea','id'=>'office_notes','class'=>'input1','label'=>'')); ?> </td>
                        </tr>
                        <tr>
                          <td align="right" valign="middle" colspan="2"><?php	
						
					
						//echo $this->Js->writeBuffer(array('inline' => 'true')); 
						echo $this->Form->input('Userbackofficelogin.user_id',array('label'=>'','type'=>'hidden','value'=>$id));
						echo $this->Form->input('Userbackofficelogin.contact_type',array('label'=>'','type'=>'hidden','value'=>'BackofficeLink'));
						echo $this->Form->input('Userbackofficelogin.id',array('label'=>'','id'=>'office_id','type'=>'hidden'));
						
						echo $this->Form->input('Userbackofficelogin.SUBMIT',array('label'=>'','type'=>'hidden','value'=>'AddbackOfficeLogin'));
						
					 echo $this->Form->submit('Add/Edit Back Office Login',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'style'=>'margin-right:35px;',"onClick"=>"return frmSubmit('frmdepartment','".FULL_BASE_URL.router::url('/',false)."superadmin/usermgmt/users/usercontact')"));
			
						
          				?></td>
                        </tr>
                      </table></td>
                    <td align="left" valign="top" style="padding:0px;"></td>
                  </tr>
                </table>
                <?php echo $this->Form->end();?> </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
<?php echo $this->Js->writeBuffer();?> 