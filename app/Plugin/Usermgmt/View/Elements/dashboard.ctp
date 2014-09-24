
<div id="dashboard">
	<div style="float:left"><?php echo $this->Html->link(__("Dashboard",true),"/superadmin/dashboard") ?></div>
<?php   if ($this->UserAuth->getGroupName()=='Admin') { ?>
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("Add User",true),"/superadmin/addUser") ?></div>
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("All Users",true),"/superadmin/allUsers") ?></div>
    
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("Add Group",true),"/superadmin/addGroup") ?></div>
   
    
    
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("All Groups",true),"/superadmin/allGroups") ?></div>
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("Permissions",true),"/superadmin/permissions") ?></div>
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("Profile",true),"/superadmin/viewUser/".$this->UserAuth->getUserId()) ?></div>
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("Edit Profile",true),"/superadmin/editUser/".$this->UserAuth->getUserId()) ?></div>
<?php   } else {?>
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("Profile",true),"/superadmin/myprofile") ?></div>
<?php   } ?>
	<div style="float:left;padding-left:10px"><?php echo $this->Html->link(__("Change Password",true),"/superadmin/changePassword") ?></div>
	
	<div style="clear:both"></div>
</div>