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
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Rate LIST<div style="float:right">
          
          <?php //if($ratelist){ ?>
          <a href="<?php echo $this->webroot; ?>superadmin/rates/rate">Add New</a>
          <?php //} ?>
          
          </div></div>
          <div class="news_indent">
           
           
			  
              <div class="box">
                <div class="display_row">
                  <div class="table">
				  <?php
					$this->Grid->addColumn('Name', '/Rate/adminName', array('paginate'=>true),'adminName');		
                 	
					$this->Grid->addAction('Edit', array('controller' => 'rates', 'action' => 'rate'), array('/Rate/id'));
					$this->Grid->addAction('Delete', array('controller' => 'rates', 'action' => 'deleterates'), array('/Rate/id'));
                 
					echo $this->Grid->generate($ratelist);
					?>
					<div class="paginator">
						<?php echo $this->Paginator->numbers(array('first' => 'First page'));?></td>
					</div>
                 </div>
                </div>
             
            </div>
            <?php echo $this->Form->end();?> </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
