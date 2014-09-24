<?php 
if($this->Session->read('UserAuth.User.user_group_id'))
{
        $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
        $addAccountCat=$common->isUserGroupAccesss('Accountcats','superadmin_addaccountcats',$userGroupId);
       // $deleteAccountTypes=$common->isUserGroupAccesss('Accounttypes','superadmin_deleteaccountcats',$userGroupId);
      //  $editAccountTypes=$common->isUserGroupAccesss('Accounttypes','superadmin_editaccountcats',$userGroupId);
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
          <div class="titlebar">ACCOUNT CATEGORY LIST
          	<div style="float:right">
            <?php if($addAccountCat) {?>
            <a href="<?php echo $this->webroot; ?>superadmin/accountcats/addaccountcats">Add New</a>
            <?php } ?>
            </div>
          </div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Accountcat'); ?>
            <div class="news_indent">
              <!--<table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="bottom">New Account Category *</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Accountcat.accountCategory',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Accountcat.navigationOrder',array('label'=>false,'class'=>'input2'));?> </td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Add Account Category',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> </td>
                </tr>
              </table>-->
              <?php echo $this->Form->end();?>
              <div class="box">
                <div class="display_row">
                  <div class="table">
                    <?php
                        $this->Grid->addColumn('Category Name', '/Accountcat/accountCategory', array('paginate'=>true),'accountCategory');	
                        $this->Grid->addColumn('Navigation Order', '/Accountcat/navigationOrder', array('paginate'=>true),'navigationOrder');	
                        $this->Grid->addAction('Edit', array('controller' => 'accountcats', 'action' => 'editaccountcats'), array('/Accountcat/id'));
                        $this->Grid->addAction('Delete', array('controller' => 'accountcats', 'action' => 'deleteaccountcats'), array('/Accountcat/id'));
                        echo $this->Grid->generate($AccountcatList);
					?>
                    <div class="paginator"> <?php echo $this->Paginator->numbers(array('first' => 'First page'));?>
                      </td>
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
