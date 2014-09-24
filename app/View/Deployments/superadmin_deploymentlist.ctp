<?php 
/*if($this->Session->read('UserAuth.User.user_group_id'))
{
        $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
        $addaccounttypes=$common->isUserGroupAccesss('Accounttypes','superadmin_addaccounttypes',$userGroupId);
       // $deleteaccounttypes=$common->isUserGroupAccesss('Accounttypes','superadmin_deleteaccounttypes',$userGroupId);
       // $editaccounttypes=$common->isUserGroupAccesss('Accounttypes','superadmin_editaccounttypes',$userGroupId);
}*/
?>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      
      <br />
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Deployment LIST<div style="float:right">
          
          <?php //if($deploymentlist){ ?>
          <a href="<?php echo $this->webroot; ?>superadmin/deployments/deployment">Add New</a>
          <?php //} ?>
          
          </div></div>
         
			  
              <div class="box">
                <div class="display_row">
                  <div class="table">
				  <?php
					$this->Grid->addColumn('Name', '/Deployment/adminName', array('paginate'=>true),'adminName');		
                 	
					$this->Grid->addAction('Edit', array('controller' => 'deployments', 'action' => 'deployment'), array('/Deployment/id'));
					$this->Grid->addAction('Delete', array('controller' => 'deployments', 'action' => 'deletedeployment'), array('/Deployment/id','/Deployment/adminName'));
                 
					echo $this->Grid->generate($deploymentlist);
					?>
					<div class="paginator">
						<?php echo $this->Paginator->numbers(array('first' => 'First page'));?></td>
					</div>
                 </div>
                </div>
              </div>
            </div>
            <?php echo $this->Form->end();?> </div>
       
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
