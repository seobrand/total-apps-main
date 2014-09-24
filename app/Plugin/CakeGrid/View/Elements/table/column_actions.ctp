<?php
//pr($actions);
if(isset($actions['Login'])){
	$login_class = "loginaction";
}else{
	$login_class = "";
}

if($this->Session->read('UserAuth.User.user_group_id'))
{
	 $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
}
 ?>
 <ul class="merchantAction <?php echo $login_class;?>">
<?php foreach($actions as $title => $action): ?>
<?php //echo $title;?>
<?php if(strtolower($title)=='edit'):?>
<?php
    if(!empty($action['url']['plugin']))
    {
    $plugin=$action['url']['plugin'];
    }else
    {
    $plugin='';
    }

 	$useredit=$common->isUserGroupAccesss($action['url']['controller'],'superadmin_'.$action['url']['action'],$userGroupId);
    if($useredit)
    {
     	echo "<li>".$this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','url' =>$action['url'], $action['options']))."</li>"; 
    }

?> &nbsp;
<?php elseif(strtolower($title)=='view'):

if(!empty($action['url']['plugin']))
    {
    	$plugin=$action['url']['plugin'];
    }else
    {
    	$plugin='';
    }
	$button=$common->isUserGroupAccesss($action['url']['controller'],'superadmin_'.$action['url']['action'],$userGroupId);
	if($button)
	{
	 echo "<li>".$this->Html->image("view.jpg", array('alt'=>'View','title'=>'view','url' =>$action['url'], $action['options'],'style'=>'width:30px;'))."</li>";
	 }
 ?>
<?php elseif(strtolower($title)=='delete'):?>
    <?php 
    if(!empty($action['url']['plugin']))
    {
    $plugin=$action['url']['plugin'];
    }else
    {
    $plugin='';
    }

   $userdelete=$common->isUserGroupAccesss($action['url']['controller'],'superadmin_'.$action['url']['action'],$userGroupId);
    if($userdelete)
    {
        if($action['url']['controller']=='merchants'){
			echo "<li>".$this->Form->create(array('name'=>'deleteMerchantForm','id'=>'deleteMerchantForm','onsubmit'=>'return confirm("Are you sure to delete this entry?")'));
			echo $this->Form->input("deleteID",array('type'=>'hidden','value'=>$action['url'][0]));
			echo $this->Form->submit("delete_bt.png",array('name'=>'Delete','div'=>false));
		  	echo $this->Form->end()."</li>";
		}else{
			echo "<li>".$this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("Are you sure to delete this entry?");','url' =>$action['url'], $action['options']))."</li>";
		}	
    }
    ?> &nbsp;
    <?php elseif(strtolower($title)=='login'):?>    
    	<?php if(!empty($action['url']['plugin']))
			    {
			    	$plugin=$action['url']['plugin'];
			    }else
			    {
			    	$plugin='';
			    }
				$button=$common->isUserGroupAccesss($action['url']['controller'],'superadmin_'.$action['url']['action'],$userGroupId);
				if($button)
				{
				 echo "<li>".$this->Html->link($this->Html->image('login_icon.png',array('alt'=>'Login','title'=>'Login')),$action['url'], array('target'=>'_blank','escape'=>false))."</li>";
				 }
		?>
    <?php else:?>
         <?php            
            echo $this->Html->link($title, $action['url'], $action['options'] + array('class' => 'cg_action'));
         ?> 
      
<?php endif; ?>
<?php endforeach; ?>
</ul>