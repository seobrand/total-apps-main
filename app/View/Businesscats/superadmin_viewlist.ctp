<?php 
if($this->Session->read('UserAuth.User.user_group_id'))
{
        $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
        $addbusinesscats=$common->isUserGroupAccesss('Businesscats','superadmin_addbusinesscats',$userGroupId);
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
          <div class="titlebar">BUSINESS CATEGORY LIST<div style="float:right">
          
          <?php if($addbusinesscats){ ?>
          <a href="<?php echo $this->webroot; ?>superadmin/businesscats/addbusinesscategory">Add New</a>
          <?php } ?>
          
          </div></div>
          <div class="news_indent">
              <div class="box">
                <div class="display_row">
                  <div class="table">
				  <?php
					$this->Grid->addColumn('Business Category', '/Businesscat/category_name', array('paginate'=>true),'category_name');		
                    $this->Grid->addColumn('Navigation Order', '/Businesscat/navigationOrder', array('paginate'=>true),'navigationOrder');		
                 	
                    	$this->Grid->addAction('Edit', array('controller' => 'businesscats', 'action' => 'editbusinesscategory'), array('/Businesscat/id'));
                 
					
                    	$this->Grid->addAction('Delete', array('controller' => 'businesscats', 'action' => 'deletebusinesscategory'), array('/Businesscat/id'));
                 
					echo $this->Grid->generate($BusinessCategoryList);
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
