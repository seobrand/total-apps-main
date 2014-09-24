<?php 
if($this->Session->read('UserAuth.User.user_group_id'))
{
        $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
        $addaccounttypes=$common->isUserGroupAccesss('Accounttypes','superadmin_addaccounttypes',$userGroupId);
       // $deleteaccounttypes=$common->isUserGroupAccesss('Accounttypes','superadmin_deleteaccounttypes',$userGroupId);
       // $editaccounttypes=$common->isUserGroupAccesss('Accounttypes','superadmin_editaccounttypes',$userGroupId);
}
?>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">USER CATEGORY LIST<div style="float:right">
          <?php if($addaccounttypes){ ?>
          <a href="<?php echo $this->webroot; ?>superadmin/usercats/addusercat">Add New</a>
          <?php } ?>
          </div></div>
          <div class="news_indent">
           
            <div class="news_indent">
              <div class="box">
                <div class="display_row">
                  <div class="table">
				  <?php
					$this->Grid->addColumn('Category Name', '/Usercat/category_name', array('paginate'=>true),'category_name');		
                    $this->Grid->addColumn('Navigation Order', '/Usercat/navigationOrder', array('paginate'=>true),'navigationOrder');		
                    $this->Grid->addAction('Edit', array('controller' => 'usercats', 'action' => 'editusercat'), array('/Usercat/id'));
                    $this->Grid->addAction('Delete', array('controller' => 'usercats', 'action' => 'deleteusercat'), array('/Usercat/id'));
					echo $this->Grid->generate($AccountList);
					?>
					<div class="paginator">
						<?php echo $this->Paginator->numbers(array('first' => 'First page'));?></td>
					</div>
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
