<script type="text/javascript">
function confirmation()
{
	alert('sdfdsaf');
}
</script>
<?php 
if($this->Session->read('UserAuth.User.user_group_id'))
{
        $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
    	$exportUSERLIST=$common->isUserGroupAccesss('Users','superadmin_export',$userGroupId);
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
          <div class="titlebar">Filter Options</div>
          <div class="news_indent"> <?php echo $this->Form->create('User',array('plugin'=>'Usermgmt','controller'=>'users','action'=>'index','type'=>'get'));?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
              <tr>
                <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="22%" align="left" valign="middle">Filter</td>
                      <td width="78%" align="left" valign="middle"><?php 
                      	
						$options=$common->getGroupList();
                        
                   
               //  $options = array('admin' => 'Admins', 'agent' => 'Agents','Manager' => 'Managers', 'iso' => 'ISOs','processor' => 'Processors', 'tech' => 'Techs');
echo $this->Form->select('role', $options, array('escape' => false,'empty'=>'Select Role','class'=>'select3'));
                      ?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Sort By</td>
                      <td align="left" valign="middle"><?php     $options = array('name' => 'Name', 'email' => 'Email');
echo $this->Form->select('sortby', $options, array('escape' => false,'empty'=>'Sort By','class'=>'select3'));?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Sort Order</td>
                      <td align="left" valign="middle"><?php     $options = array('ASC' => 'Ascending', 'DESC' => 'Descending');
echo $this->Form->select('sortOrder', $options, array('escape' => false,'empty'=>'Order By','class'=>'select3'));?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Status</td>
                      <td align="left" valign="middle"><?php 
					  if(isset($active))
					  {
					  	
					  		$default=$active;
					  }
					  
						 $options=array('1'=>'Active','0'=>'Inactive');
                   	echo	 $this->Form->input('active',array('class'=>'select3','id'=>'template','type'=>'select','options'=>$options,'empty'=>false,'default'=>$default,'label'=>false,'div'=>false)); ?>
                      </td>
                    </tr>
                  </table></td>
                <td align="left" valign="top" style="padding:0 0 0 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="26%" align="left" valign="middle">Users Returned</td>
                      <td width="74%" align="left" valign="middle"><?php echo $TOTALUSER; ?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Query Time</td>
                      <td align="left" valign="middle"><?php echo round(microtime(true) - $_SERVER['REQUEST_TIME'], 4) ; ?> seconds.</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="middle" style="padding:16px 0 0 10px;"><?php
                     /* echo $this->Form->input('Filter', array('label' => '','Type' => 'Submit','Type' => 'Filter','Name' => 'Filter','class'=>'cursorclass ui-state-default ui-corner-all','style'=>'width:100px;float:left'));*/
                      
                      echo $this->Form->submit('Filter',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                      
                      	echo $this->Form->input('SUBMIT',array('label'=>'','type'=>'hidden','value'=>'SUBMIT'));
                      
                      ?>
                        &nbsp;&nbsp;
                        <?php
                        if($exportUSERLIST)
                        {
                         echo $this->Form->submit('Export',array('name'=>'Export','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                        }
                        ?>
                      </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <?php echo $this->Form->end(); ?> </div>
        </div>
        <!-- display box / first -->
        <div class="box">
          <div class="display_row">
            <div class="table">
              <?php
						$this->Grid->addColumn('Name', '/User/user_Name', array('paginate'=>true),'user_Name');	
                        
                        $this->Grid->addColumn('Name', '/User/user_Name',array('paginate'=>true,'linkable' => array('url' => array('action' => 'users','action' => 'editUser'),'trailingParams' => array('/User/id'))),'user_Name');	
                        		
						$this->Grid->addColumn('Phone Number', '/User/userPhone', array('paginate'=>true),'userPhone');			 
						$this->Grid->addColumn('Email Address', '/User/userEmail', array('paginate'=>true),'userEmail');												
						$this->Grid->addColumn('Company', '/User/userCompany', array('paginate'=>true),'userCompany');
						
						$this->Grid->addAction('Login', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'loginuser'), array('/User/id'));
                        $this->Grid->addAction('Edit', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'editUser'), array('/User/id'));
						$this->Grid->addAction('Delete', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'deleteUser'), array('/User/id'));
                        $this->Grid->addAction('View', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'viewUser'), array('/User/id'));
                        
						
                       
                         
						echo $this->Grid->generate($UserRec);
					?>
              <div class="paginator">
                <?php //if(count(merchantSearchList)>0):?>
                <?php echo $this->element('admin-paging');?>
                </td>
                <?php //endif;?>
              </div>
            </div>
          </div>
          <!-- display box / second end here -->
        </div>
        <!-- end table -->
      </div>
    </div>
  </div>
  <!-- end content / right -->
</div>