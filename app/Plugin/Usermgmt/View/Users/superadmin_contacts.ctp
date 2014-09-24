<?php //echo $this->element('editor'); ?>
<script type="text/javascript">
function showhide(id1,id2,id3)
{
	document.getElementById(id1+'-li').className = 'active';	
	document.getElementById(id1).style.display='block';
	document.getElementById(id2).style.display='none';
	document.getElementById(id2+'-li').className = '';
	document.getElementById(id3).style.display='none';
	document.getElementById(id3+'-li').className = '';
	
	/*if(id1=='agentInfo')
	{
		$("#krymson_nav ul").addClass('test');
	}else
	{
		$(".krymson_nav ul").addClass('test');
	}*/
	
}

function refreshpage(pageId,response)
{
	if(pageId=='frmdepartment')
	{
		document.getElementById("department_title").value='';
		document.getElementById("department_notes").value='';
		document.getElementById("department_name").value='';
		document.getElementById("department_id").value='';
		document.getElementById("department_fax").value='';
		document.getElementById("department_email").value='';
		document.getElementById("department_phone_number").value='';
		alert(response);
		updatedUserList('Department');
		showhideInnerDiv('DepartmentList','addDepartmentContact');
		
	}
	if(pageId=='addEmailContact')
	{
			document.getElementById("email_title").value='';
			document.getElementById("email_notes").value='';
			document.getElementById("email_fax").value='';
			document.getElementById("email_email").value='';
			document.getElementById("email_id").value='';
			alert(response);
			updatedUserList('Email');
			showhideInnerDiv('emailList','addEmail');
	}
	
	if(pageId=='addphoneContact')
	{
							
		document.getElementById("phone_title").value='';
		document.getElementById("phone_notes").value='';
		document.getElementById("phone_id").value='';
		alert(response);
		updatedUserList('Phone');
		updatedUserList('Phone');
		showhideInnerDiv('phoneList','addphone');
	
			
	}
	
	
	
}

function updatedUserList(type)
{
	$.ajax({
	  type: "GET",
      url: '<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/usermgmt/users/getuserList/'+type+'/'+<?php echo $id; ?>,
      success: function(response) {
	  if(type=='Department')
	  {
	  	document.getElementById("DepartmentList").innerHTML=response;
	  }
	  
	  if(type=='Email')
	  {
	  	document.getElementById("emailLists").innerHTML=response;
	  }
	  
	  if(type=='Phone')
	  {
	  	document.getElementById("phoneList").innerHTML=response;
	  }
		
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
	
		  if(response=='Contact information has been saved successfully')
		  {
				if(fromId=='frmdepartment')
				{ 
					refreshpage(fromId,response); 
				}
				if(fromId=='addEmailContact')
				{ 
					refreshpage(fromId,response); 
				}
				
				if(fromId=='addphoneContact')
				{ 
					refreshpage(fromId,response); 
				}
				
				
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

	$('#email_title').val('');
	$('#email_notes').val('');
	$('#email_fax').val('');
	$('#email_email').val('');
	$('#email_id').val('');
	
	$('#phone_title').val('');
	$('#phone_notes').val('');
	$('#phone_notes').val('');
	
	$('#department_title').val('');
	$('#department_notes').val('');
	$('#department_id').val('');
	$('#department_name').val('');
	$('#department_fax').val('');
	$('#department_email').val('');
	$('#department_phone_number').val('');

						
}

function showhideInnerDiv(firstDiv,SecondDiv)  
{
	blankAllPages();
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
			   
			   if(contactType=='Email')
			   {
			   		alert(data);
					updatedUserList('Email');
			   }
			    if(contactType=='Phone')
			   {
			   		alert(data);
					updatedUserList('Phone');
			   }
			    if(contactType=='Department')
			   {
			   		alert(data);
					updatedUserList('Department');
			   }
			   
			   
				/*switch(contactType)
				{
					case 'Email':
							alert('pushkar');
							updatedUserList('Email');
					case 'Phone':
							
							alert(data);
							updatedUserList('Phone');
					case 'Department':
							alert(data);
							updatedUserList('Department');
					default :
							
				}*/
				
				
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
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/usermgmt/users/getusercontactinformation/"+id+"/"+userId,
               success : function(data) {
			   	obj =  jQuery.parseJSON(data);
				switch(contactType)
				{
				
					case 'Email':
							
							showhideInnerDiv('emailList','addEmail');
							jQuery('#email_title').val(obj.Usercontact.title);
							//document.getElementById("email_title").value=obj.Usercontact.title;
							document.getElementById("email_notes").value=obj.Usercontact.notes;
							document.getElementById("email_fax").value=obj.Usercontact.fax;
							document.getElementById("email_email").value=obj.Usercontact.email;
							document.getElementById("email_id").value=obj.Usercontact.id;

							break;
					
					case 'Phone':
							 
							showhideInnerDiv('phoneList','addphone');
							document.getElementById("phone_title").value=obj.Usercontact.title;
							document.getElementById("phone_notes").value=obj.Usercontact.notes;
							document.getElementById("phone_id").value=obj.Usercontact.id;
							break;
							
					case 'Department':
						   	
							showhideInnerDiv('DepartmentList','addDepartmentContact');
							document.getElementById("department_title").value=obj.Usercontact.title;
							document.getElementById("department_notes").value=obj.Usercontact.notes;
							document.getElementById("department_id").value=obj.Usercontact.id;
							document.getElementById("department_name").value=obj.Usercontact.name;
							
							document.getElementById("department_fax").value=obj.Usercontact.fax;
							document.getElementById("department_email").value=obj.Usercontact.email;
							document.getElementById("department_phone_number").value=obj.Usercontact.phone_number;
							
							break;   
					default :
						break;
							
				}


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
                <li class="active" id="firstdiv-li"><a href="javascript:void(0);" onclick="showhide('firstdiv','seconddiv','thirddiv')">Department Contact:</a></li>
                <li id="seconddiv-li"><a href="javascript:void(0);" onclick="showhide('seconddiv','thirddiv','firstdiv')">Email Contact:</a></li>
                <li id="thirddiv-li"><a href="javascript:void(0);" onclick="showhide('thirddiv','firstdiv','seconddiv')">Phone Contact:</a></li>
              </ul>
               <div id="frmErrorMsg"></div>
            </div>
           
            
            <div id="firstdiv">
            	<div id="departmentmessage"> </div>
            	
            	<div style="clear:both;height:5px;"></div>
           
             	<div  id="content" class="box">
                <div style="clear:both;display:block" id="DepartmentList">
                
                	<input type="Button" name="Add" value="Add New Department" onclick="showhideInnerDiv('DepartmentList','addDepartmentContact')"  class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                    <br /> <br />
                
               
				<table  width="100%">
                     <thead>
                     	<tr>
                        	<th>Title/Department</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                             <th>Email</th>
                             <!--<th>Notes</th>-->
                             <th>Action</th>
                        </tr>
                        </thead>
                    	<tbody>
                        <?php 
						if(count($userContactList)>0)
						{
							foreach($userContactList as $value){ ?>
                        <tr class="cg_row odd"  valign="middle" height="53px;">
                        	
                            <td><?php echo $value['Usercontact']['title']; ?></td>
                            <td><?php echo $value['Usercontact']['name']; ?></td>
                            <td><?php echo $value['Usercontact']['phone_number']; ?></td>
                            <td><?php echo $value['Usercontact']['email']; ?></td>
                            
                           <!-- 
                            <td><?php echo $value['Usercontact']['notes']; ?></td>-->
                            <td><a href="javascript:void(0);">
<img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Department');"></a>

<a href="javascript:void(0);">
<img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Department');"></a>
</td>


                        </tr>
                        <?php } }else
						{?>
                        	<tr> <td colspan="6" align="center">No Record Found </td></tr>
						<?php
						}?>
                        </tbody>
                     </table>
                   
                   <!--  <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner_agent')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('agentInfo','referalInfo','isoInfo','merchantInfo')"));?>
                   
                     <div class="table" id="content14">
                     
                     <table  width="100%">
                     <thead>
                     	<tr>
                        	<th>Title</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                         	<th>E-mail Address</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    	<tbody>
                        <?php 
						foreach($userContactList as $value){ ?>
                        <tr class="cg_row odd"  valign="middle" height="53px;">
                        	<td><?php echo $value['Usercontact']['title']; ?></td>
                            <td><?php echo $value['Usercontact']['name']; ?></td>
                            <td><?php echo $value['Usercontact']['phone_number']; ?></td>
                            <td><?php echo $value['Usercontact']['email']; ?></td>
                            
                           
                          	<td><a href="javascript:void(0);">
<img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Department');"> 
</a>

<a href="javascript:void(0);">
<img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Department');">
</a>
</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                     </table>
                     
                     
                     
                     
                <?php //$this->Grid->reset();?>
                      <?php
                       //     $this->Grid->addColumn('Title', '/Usercontact/title', array('paginate'=>false),'title');			
                        //    $this->Grid->addColumn('Name', '/Usercontact/name', array('paginate'=>false),'name');			 
                        //     $this->Grid->addColumn('Phone Number', '/Usercontact/phone_number', array('paginate'=>false),'phone_number');	
                         //    $this->Grid->addColumn('Email', '/Usercontact/email', array('paginate'=>false),'email');			 		 
                         //   $this->Grid->addAction('Edit', array('plugin' => '','controller' => 'users', 'action' => 'view'),array('/Merchant/id'));	                  
                          //  echo $this->Grid->generate($userContactList);
                     ?>   
                 		 <div class="paginator"> 
                   <?php //echo $this->Paginator->numbers($options = array('model' => 'Usercontact'),array('first' => 'First page'));?>
                  </div>    
                          
                  </div>-->
                  
           		</div>
                </div>
                
                
                <div style="clear:both;display:none" id="addDepartmentContact">
                  	<div id="message_board"></div>
                    <input type="Button" name="Add" value="Department List" onclick="showhideInnerDiv('DepartmentList','addDepartmentContact')"  class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                    <br /> <br />
                    
                   	<?php echo $this->Form->create('User',array('id'=>'frmdepartment'));?>
             		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                <tr>
                  <td align="left" valign="top" class="rpadnone" style="padding:0px;" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="24%" align="left" valign="middle"> Title/ Department</td>
                        <td width="76%" align="left" valign="middle"><?php echo $this->Form->input('Usercontact.title',array('type'=>'text','id'=>'department_title','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>  
                        <td align="left" valign="middle">Name</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.name',array('type'=>'text','id'=>'department_name','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Phone Number</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.phone_number',array('type'=>'text','id'=>'department_phone_number','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Email</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.email',array('type'=>'text','id'=>'department_email','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Fax</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.fax',array('type'=>'text','id'=>'department_fax','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Notes</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.notes',array('type'=>'textarea','id'=>'department_notes','class'=>'input1','label'=>'')); ?> </td>
                      </tr>
                       <tr>
                      
                        <td align="right" valign="middle" colspan="2">
					
						<?php	
						
					
						//echo $this->Js->writeBuffer(array('inline' => 'true')); 
						echo $this->Form->input('Usercontact.user_id',array('label'=>'','type'=>'hidden','value'=>$id));
						echo $this->Form->input('Usercontact.contact_type',array('label'=>'','type'=>'hidden','value'=>'Department'));
						echo $this->Form->input('Usercontact.id',array('label'=>'','id'=>'department_id','type'=>'hidden','value'=>'Department'));
						
						echo $this->Form->input('Usercontact.SUBMIT',array('label'=>'','type'=>'hidden','value'=>'AddDepartmentContact'));
						
					 echo $this->Form->submit('Add/Edit Department',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','style'=>'margin-right:35px;','div'=>false,"onClick"=>"return frmSubmit('frmdepartment','".FULL_BASE_URL.router::url('/',false)."superadmin/usermgmt/users/usercontact')"));
					 
					
						 /*echo $this->Js->submit('Post Your Message', array(
						'url' => array(
							'controller' => 'users',
							'action' => 'usercontact'
						),
						'class' => 'cursorclass ui-state-default ui-corner-all',
						'update' => '#message_board'
					));*/
						
          				?></td>
                      </tr>
                      
                    </table></td>
                  <td align="left" valign="top" style="padding:0px;"></td>
                </tr>
              </table>
              		<?php echo $this->Form->end();?>
                </div>
            </div>
            
             <div id="seconddiv" style="display:none">
           <div id="emailmessage"></div>
             	
            	<div style="clear:both;height:5px;"></div>
            
           
             	<div id="emailList"  style="display:block;clear:both">
					 <input type="Button" name="Add" value="Add Email Contact:" onclick="showhideInnerDiv('emailList','addEmail')" class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                    <br /> <br />
               
                    <div id="emailLists">
                   
                    
                     <div class="box">
                     <?php // pr($emailContactList); ?>
                     <table  width="100%">
                     <thead>
                     	<tr>
                        	<th>Title / Department</th>
                            <th>Email</th>
                            <th>Fax</th>
                          
                             <th>Action</th>
                        </tr>
                        </thead>
                    	<tbody>
                        <?php 
						if(count($emailContactList) > 0)
						foreach($emailContactList as $value){ ?>
                        <tr class="cg_row odd"  valign="middle" height="53px;">
                        	<td><?php //echo $value->  ?>
                            <?php echo $value['Usercontact']['title']; ?>
                            </td>
                            <td> <?php echo $value['Usercontact']['email']; ?></td>
                            <td><?php echo $value['Usercontact']['fax']; ?></td>
                            
                            <td>
                            <a href="javascript:void(0);">
<img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Email');"></a>

<a href="javascript:void(0);">
<img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Email');"></a>
</td>


                        </tr>
                        <?php }else{ ?>
                        	<tr>
                            	<td colspan="4" align="center">
                                	No Record Found
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                     </table>
                     
             
                  
                  </div>  
                          
                 </div>
                 
                     </div>
                 <div id="addEmail" style="display:none;clear:both">
                 <input type="Button" name="Add" value="Email Contact List" onclick="showhideInnerDiv('emailList','addEmail')" class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                    <br /> <br />
                 
                  	<div id="message_board1"></div>
                   	<?php echo $this->Form->create('User',array('id'=>'addEmailContact'));?>
             		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                <tr>
                  <td align="left" valign="top" class="rpadnone" style="padding:0px;" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="24%" align="left" valign="middle"> Title/ Department</td>
                        <td width="76%" align="left" valign="middle"><?php echo $this->Form->input('Usercontact.title',array('type'=>'text','id'=>'email_title','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Email</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.email',array('type'=>'text','id'=>'email_email','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Fax</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.fax',array('type'=>'text','id'=>'email_fax','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Notes</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.notes',array('type'=>'textarea','id'=>'email_notes','class'=>'input1','label'=>'')); ?> </td>
                      </tr>
                       <tr>  
                      
                        <td align="right" valign="middle" colspan="2">
					
						<?php	
						/* echo $this->Js->submit('Add E-mail contact', array(
						'url' => array(
							'controller' => 'users',
							'action' => 'usercontact'
						),
						'class' => 'cursorclass ui-state-default ui-corner-all',
						'update' => '#message_board1',
						'complete' => 'javascript:resetThisForm();'
					));*/
					
						echo $this->Js->writeBuffer(array('inline' => 'true')); 
						echo $this->Form->input('Usercontact.contact_type',array('label'=>'','type'=>'hidden','value'=>'Email'));
						echo $this->Form->input('Usercontact.user_id',array('label'=>'','type'=>'hidden','value'=>$id));
						echo $this->Form->input('Usercontact.id',array('label'=>'','type'=>'hidden','id'=>'email_id'));
						
						echo $this->Form->input('Usercontact.SUBMIT',array('label'=>'','type'=>'hidden','value'=>'AddEmailContact'));
						
						
					 echo $this->Form->submit('Add/Edit Email Contact',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','style'=>'margin-right:35px;','div'=>false,"onClick"=>"return frmSubmit('addEmailContact','".FULL_BASE_URL.router::url('/',false)."superadmin/usermgmt/users/usercontact')"));
						
						
          				// echo $this->Form->submit('Add Department Contact',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                      </tr>
                      
                      
                      
                    </table></td>
                  <td align="left" valign="top" style="padding:0px;"></td>
                </tr>
              </table>
              		<?php echo $this->Form->end();?>
                </div>
           		
            </div>
            
            <div id="thirddiv" style="display:none">
           		<div id="phonemessage"></div>
             	
            	<div style="clear:both;height:5px;"></div>
            
           
             	<div id="phoneList"  style="display:block;clear:both">
					        <input type="Button" name="Add" value="Add New Contact"  onclick="showhideInnerDiv('phoneList','addphone')" class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                    <br /> <br />      
                    <div id="content1">
                    <div id="content" >
                    
                     <div class="box">
                     <?php // pr($emailContactList); ?>
                     <table  width="100%">
                     <thead>
                     	<tr>
                        	<th>Title/Department</th>
                            <th>Phone Number</th>
                         
                            
                             <th>Action</th>
                        </tr>
                        </thead>
                    	<tbody>
                        <?php 
						if(count($phoneContactList) > 0)
						{
						foreach($phoneContactList as $value){ ?>
                        <tr class="cg_row odd"  valign="middle" height="53px;">
                        	<td><?php //echo $value->  ?>
                            <?php echo $value['Usercontact']['title']; ?>
                            </td>
                            <td> <?php echo $value['Usercontact']['phone_number']; ?></td>
                          
                          	<td><a href="javascript:void(0);">
<img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Phone');"></a>

<a href="javascript:void(0);">
<img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Phone');"></a>
</td>
                        </tr>
                        <?php } }else
						{
						?>
                        <tr>
                        	<td colspan="3" align="center">No Record Found</td>
                        </tr>
                        <?php 
						}
						?>
                        </tbody>
                     </table>
                     
             
                  
                  </div>  
                  </div>            
                 </div>
                 
                     </div>
                     
                 <div id="addphone" style="display:none;clear:both">
                  	<div id="message_board3"></div>
                    
                    <input type="Button" name="Add" value="Contact List"  onclick="showhideInnerDiv('phoneList','addphone')" class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                    <br /> <br /> 
                    
                   	<?php echo $this->Form->create('User',array('id'=>'addphoneContact'));?>
             		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                <tr>
                  <td align="left" valign="top" class="rpadnone" style="padding:0px;" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="24%" align="left" valign="middle"> Title/ Department</td>
                        <td width="76%" align="left" valign="middle"><?php echo $this->Form->input('Usercontact.title',array('type'=>'text','id'=>'phone_title','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Phone Number</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.phone_number',array('type'=>'text','id'=>'phone_number','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                   
                      <tr>
                        <td align="left" valign="middle">Notes</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Usercontact.notes',array('type'=>'textarea','id'=>'phone_notes','class'=>'input1','label'=>'')); ?> </td>
                      </tr>
                       <tr>
                      
                        <td align="right" valign="middle" colspan="2">
					
						<?php	
						/* echo $this->Js->submit('Add E-mail contact', array(
						'url' => array(
							'controller' => 'users',
							'action' => 'usercontact'
						),
						'class' => 'cursorclass ui-state-default ui-corner-all',
						'update' => '#message_board3',
						'complete' => 'javascript:resetThisForm();'
					));
					*/
						echo $this->Js->writeBuffer(array('inline' => 'true')); 
						echo $this->Form->input('Usercontact.contact_type',array('label'=>'','type'=>'hidden','value'=>'Phone'));
						echo $this->Form->input('Usercontact.user_id',array('label'=>'','type'=>'hidden','value'=>$id));
						echo $this->Form->input('Usercontact.id',array('label'=>'','type'=>'hidden','id'=>'phone_id'));
						echo $this->Form->input('Usercontact.SUBMIT',array('label'=>'','type'=>'hidden','value'=>'AddPhoneContact'));
						
						
						 echo $this->Form->submit('Add/Edit Phone Contact',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','style'=>'margin-right:35px;','div'=>false,"onClick"=>"return frmSubmit('addphoneContact','".FULL_BASE_URL.router::url('/',false)."superadmin/usermgmt/users/usercontact')"));
          				// echo $this->Form->submit('Add Department Contact',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                      </tr>
                      
                      
                      
                    </table></td>
                  <td align="left" valign="top" style="padding:0px;"></td>
                </tr>
              </table>
              		<?php echo $this->Form->end();?>
                </div>
           		
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