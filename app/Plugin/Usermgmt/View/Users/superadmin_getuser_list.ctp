<!--------- ========================================================
							 Record For Department 
            ========================================================  --->
<?php 
if($userType=='Department')
{
?>

<input type="Button" name="Add" value="Add New Department" onclick="showhideInnerDiv('DepartmentList','addDepartmentContact')"  class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
<br />
<br />
<table  width="100%">
  <thead>
    <tr>
      <th>Title/Department</th>
      <th>Name</th>
      <th>Phone Number</th>
      <th>Email</th>
    
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php 
	if(count($departmentContactList) > 0)
	{
	foreach($departmentContactList as $value){ ?>
    <tr class="cg_row odd"  valign="middle" height="53px;">
      <td><?php echo $value['Usercontact']['title']; ?></td>
      <td><?php echo $value['Usercontact']['name']; ?></td>
      <td><?php echo $value['Usercontact']['phone_number']; ?></td>
      <td><?php echo $value['Usercontact']['email']; ?></td>
     
      <td><a href="javascript:void(0);"> <img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Department');"></a> 
      <a href="javascript:void(0);"> <img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Department');"></a> </td>
    </tr>
    <?php }}else{ ?>
    	<tr>
        	<td colspan="6" align="center">No Record Found</td>	
        </tr>
    <?php } ?>
  </tbody>
</table>
<?php 
}
 
 
/* ========================================================
							 Record For Department 
            ========================================================  */
if($userType=='Email')
{

?>
<div class="box">
  <?php // pr($emailContactList); ?>
  <table  width="100%">
    <thead>
      <tr>
        <th>Title/Department</th>
        <th>Email</th>
        <th>FAX</th>
     
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
	  if(count($emailContactList)>0)
	  {
		foreach($emailContactList as $value){ ?>
      <tr class="cg_row odd"  valign="middle" height="53px;">
        <td><?php //echo $value->  ?>
          <?php echo $value['Usercontact']['title']; ?> </td>
        <td><?php echo $value['Usercontact']['email']; ?></td>
        <td><?php echo $value['Usercontact']['fax']; ?></td>
        
        <td><a href="javascript:void(0);"> <img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Email');"></a> <a href="javascript:void(0);"> <img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Email');"></a> </td>
      </tr>
      <?php } 
	  }else
	  {
	  	?>
        <td colspan="5" align="center"> No Record Found</td>
        <?php
	  }?>
    </tbody>
  </table>
</div>
<?php } 

/* ========================================================
							 Phone For Department 
            ========================================================  */


if($userType=='Phone')
{
?>
<input type="Button" name="Add" value="Add New Contact"  onclick="showhideInnerDiv('phoneList','addphone')" class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
<br />
<br />
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
		  if(count($phoneContactList)>0)
		  {
				foreach($phoneContactList as $value){ ?>
          <tr class="cg_row odd"  valign="middle" height="53px;">
            <td><?php //echo $value->  ?>
              <?php echo $value['Usercontact']['title']; ?> </td>
            <td><?php echo $value['Usercontact']['phone_number']; ?></td>
           
            <td><a href="javascript:void(0);"> <img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Phone');"></a> <a href="javascript:void(0);"> <img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Usercontact']['id']; ?>,<?php echo $value['Usercontact']['user_id']; ?>,'Phone');"></a> </td>
          </tr>
          <?php } }else
		  {
		  ?>
          	<tr>
            	<td colspan="4" align="center">No Record Found</td>
            </tr>
          <?php 
		  }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php } ?>


<?php if($userType=='Office'){ ?>
 <input type="Button" name="Add" value="Add New Back Office Login" onclick="showhideInnerDiv('DepartmentList','addDepartmentContact')"  class="cursorclass ui-state-default ui-corner-all" style="float:right;margin-bottom:10px;"/>
                  <br />
                  <br />
                  <table  width="100%">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>URL</th>
                        <th>User Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
					  
					  if(count($backofficeList)>0)
					  {
						foreach($backofficeList as $value){ ?>
                      <tr class="cg_row odd"  valign="middle" height="53px;">
                        <td><?php echo $value['Userbackofficelogin']['name']; ?></td>
                        <td><?php echo $value['Userbackofficelogin']['url']; ?></td>
                        <td><?php echo $value['Userbackofficelogin']['username']; ?></td>
                        <td>
                        
                        <a href="javascript:void(0);"> <img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png" onclick="return editEmailContactInfo(<?php echo $value['Userbackofficelogin']['id']; ?>,<?php echo $value['Userbackofficelogin']['user_id']; ?>,'Office');"></a> 
                        
                        
                        <a href="javascript:void(0);"> <img title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png" onclick="return deleteContactInfo(<?php echo $value['Userbackofficelogin']['id']; ?>,<?php echo $value['Userbackofficelogin']['user_id']; ?>,'Office');"></a> </td>
                      </tr>
                      <?php }}else
					  {
					  ?>
                      <tr>
                      	<td colspan="4" align="center">No Record Found</td>
                      </tr>
                      <?php
					  } ?>
                    </tbody>
                  </table>
<?php } ?>
