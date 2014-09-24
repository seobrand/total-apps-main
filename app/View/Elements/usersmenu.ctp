<?php
 $action = explode('_', $this->params['action']);
 $page = $action['1'];
 $groupName=$common->fetchAllGroupName(); 
?>

<ul>
  <?php

 foreach($groupName as $name) {
	$checkuserjoin=$common->checkUserGroup($name['UserGroup']['id'],$id);
    
    if($name['UserGroup']['id']<=25)
    {
    	if($checkuserjoin  && $name['UserGroup']['id']!='1')
    	{
			$groupid=$name['UserGroup']['id'];
			$action='';
			$name='';
   	
			if($groupid=='22')
			{
				$action='iso';
				$name='ISO';
  			 ?>
                <li   <?php if($page=='iso') {?> class="active"  <?php }?>>
						<?php  echo $this->Html->link(__($name,true),"/superadmin/".$action.'/'.$id); ?>
                </li>
  			<?php 
    		}
    
    
			if($groupid=='20')
			{
				$action='agent';
				$name='Agent';
			?>
                <li  <?php if($page=='agent') {?> class="active"  <?php }?>>
                    <?php  echo $this->Html->link(__($name,true),"/superadmin/".$action.'/'.$id); ?>
                </li>
			<?php 
			}
    
			if($groupid=='23')
			{
					$action='processor';
					$name='Processor';
				?>
				<li  <?php if($page=='processor') {?> class="active"  <?php }?>>
					<?php  echo $this->Html->link(__($name,true),"/superadmin/".$action.'/'.$id); ?>
				</li>
				<?php 
			}
     
			if($groupid=='24')
			{
				$action='manager';
				$name='Manager';
				
				?>
				<li  <?php if($page=='manager') {?> class="active"  <?php }?> >
					<?php echo $this->Html->link(__($name,true),"/superadmin/".$action.'/'.$id); ?>
				</li>
			<?php 
			}
    
			if($groupid=='25')
			{
				$action='referal';
				$name='Referral';
				?>
			
                <li  <?php if($page=='referal') {?> class="active"  <?php }?> >
                        <?php  echo $this->Html->link(__($name,true),"/superadmin/".$action.'/'.$id); ?>
                </li>
			<?php 
			}

  
      ?>
  <?php } }}?>

    <li <?php if($page=='notes') {?> class="active"  <?php }?>> 
            <?php  echo $this->Html->link(__("Notes",true),"/superadmin/notes/$id") ?> 
    </li>
    <li  <?php if($page=='editUser') {?> class="active"  <?php }?>>
        <?php  echo $this->Html->link(__("Docs",true),"/superadmin/editUser/$id") ?>
    </li>
    

            
    <li  <?php if($page=='contacts') {?> class="active"  <?php }?>>
        <?php  echo $this->Html->link(__("Contacts",true),"/superadmin/contacts/$id") ?>
    </li>
    
    <li  <?php if($page=='officelink') {?> class="active"  <?php }?>>
        <?php  echo $this->Html->link(__("Back Office Login",true),"/superadmin/usermgmt/users/officelink/$id") ?>
    </li>
  
</ul>