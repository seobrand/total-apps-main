<?php
$action = explode('_', $this->params['action']);
if(isset($action['1']))
$page = $action['1'];


if($this->Session->read('UserAuth.User.user_group_id'))
{
 	 $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
    $userAddUser=$common->isUserGroupAccesss('Users','superadmin_addUser',$userGroupId);
    
    $userdoclist=$common->isUserGroupAccesss('Users','superadmin_doclist',$userGroupId);
    $usersearch=$common->isUserGroupAccesss('Users','superadmin_search',$userGroupId);
    $userUserList=$common->isUserGroupAccesss('Users','superadmin_index',$userGroupId);
    
     $userdelete=$common->isUserGroupAccesss('Users','deleteUser',$userGroupId);
     $useredit=$common->isUserGroupAccesss('Users','editUser',$userGroupId);
     
    
    
    $merchantAddNew=$common->isUserGroupAccesss('Merchants','superadmin_addmerchant',$userGroupId);
    $merchantSearch=$common->isUserGroupAccesss('Merchants','superadmin_search',$userGroupId);
   // $merchantSearch=$common->isUserGroupAccesss('Merchants','superadmin_viewbystatus',$userGroupId);
    
    
    $addgateway=$common->isUserGroupAccesss('Gateways','superadmin_addgateway',$userGroupId);
   	 
     
     
    $viewaccounttypesList=$common->isUserGroupAccesss('Accounttypes','superadmin_viewlist',$userGroupId);
	$viewaccountCatList = $common->isUserGroupAccesss('Accountcats','superadmin_viewlist',$userGroupId);
    
    $addstatus=$common->isUserGroupAccesss('Statuses','superadmin_addstatus',$userGroupId);
    $Processordocs=$common->isUserGroupAccesss('Processordocs','superadmin_addprodoc',$userGroupId);
    
    $UserGroupPermissions=$common->isUserGroupAccesss('UserGroupPermissions','superadmin_index',$userGroupId);

    $addGroup=$common->isUserGroupAccesss('UserGroupPermissions','superadmin_addGroup',$userGroupId);
    $editGroup=$common->isUserGroupAccesss('UserGroupPermissions','superadmin_editGroup',$userGroupId);
    $listGroup=$common->isUserGroupAccesss('UserGroupPermissions','superadmin_index',$userGroupId);
    $deleteGroup=$common->isUserGroupAccesss('UserGroupPermissions','superadmin_deleteGroup',$userGroupId);
    
    
 
}


$cakeDescription = __d('cake_dev', 'Total APP: Admin Panel');
$pipeline_outer = $common->getMerchantStatusOuter();
$pipeline_other = $common->getMerchantStatusOther();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset');
		echo $this->Html->css('style');
		
		?>
		<!--[if IE 7]>
		<?php 
		echo $this->Html->css('ie7');
		?>
		<![endif]-->
		<?php 
		echo $this->Html->css('blue');?>
		
		<link rel="shortcut icon" href="<?php echo FULL_BASE_URL.router::url('/',false).'app/webroot/favicon.ico'; ?>" type="image/x-icon"/>

<?php /********** CSS AND JS FOR SIGATURE PAD ******/ ?>
		<?php echo $this->Html->css('signature/jquery.signaturepad.css'); ?>
		<!--[if lt IE 9]><?php echo $this->Html->script('signature/build/flashcanvas'); ?><![endif]-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<?php echo $this->Html->script('signature/build/jquery.signaturepad.min'); ?>
		 <script>
		 jQuery.noConflict();
			jQuery(document).ready(function() {
			  jQuery('.sigPad').signaturePad();
			});
		  </script>
		<?php echo $this->Html->script('signature/build/json2.min'); ?>
		
		<?php if($this->Session->read('popup')) {?>
</head>
<body onload="javascript:autoClick()">
<?php } else {?>
</head>
<body>
<?php } ?>
	<input type="hidden" value="<?php echo $this->Session->check('popup') ?  $this->Session->read('popup') : 'no'; ?>" id="popcheck" />
	<script language="javascript">
	function goto_club() {
	if(document.getElementById('popup_check').value=='yes') {
		document.getElementById('closethisLink').click();	
		document.getElementById('popup_check').value = 'no';
	 } 
	 }
	window.setInterval(function(){
	if(document.getElementById('popcheck').value != 'no') {
	  goto_club();
	  }
	}, 5000);
	</script>
	<div id="header"> 
				  <!-- logo -->
				  <div id="logo">
					<h1 class="logo"><a href="#" title="total apps Admin Panel" alt="total apps Admin Panel"></a></h1>
				  </div>
				  <!-- end logo --> 
				  <!-- user -->
                
                  
				  <ul id="user1">
					<li>
                    <?php  if($this->Session->read('UserAuth.User.id')){ ?>
					  <table cellpadding="0" cellspacing="0" border="0" style="margin-right:10px;">
						<tr>
						  <td>
                          
                          <strong>Hello <?php echo ucfirst($this->Session->read('UserAuth.User.user_Name')); ?> |</strong> <?php echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout')); ?><b> | Server Date : <?php echo date('d M Y');?></b>
                          
                          </td>
						</tr>
					  </table>
                      
                      <?php }?>
					</li>
				  </ul>
				  <!-- end user -->
				  <div id="header-inner"> 
					<!-- quick -->

                
                     <?php  if($this->Session->read('UserAuth.User.id') && $page!='role'){ ?>
					<ul id="quick">
      <li class="select">
     
    
      
        <a href="<?php echo $this->webroot; ?>superadmin/dashboard"><?php echo  '<span class="icon">'.$this->Html->image('home.png').'</span><span>Home</span>'; ?></a>
       </li>
      				<li><a href="#"><span class="icon"><?php echo $this->Html->image('award_star_bronze_1.png', array('alt' => 'Home'));?></span><span>PIPELINE</span></a>
						<ul>
						  <li><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/all">ALL</a></li>
						  <?php foreach($pipeline_outer as $key => $value):?>
						  <li><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/<?php echo $value['Status']['id'];?>"><?php echo strtoupper($value['Status']['status']);?></a></li>
						  <?php endforeach;?>
						  <li><a class="childs">OTHER</a>
							<ul>
							  <?php foreach($pipeline_other as $k => $v):?>
							 	 <li><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/<?php echo $v['Status']['id'];?>"><?php echo strtoupper($v['Status']['status']);?></a></li>
							  <?php endforeach;?>
							</ul>
						  </li>
						</ul>
					  </li>
					  <li><a href="#"><span class="icon"><?php echo $this->Html->image('script.png', array('alt' => 'Home'));?></span><span>MERCHANTS </span></a>
						<ul>
						  <li>
                          <?php
                          if($merchantAddNew){
                           ?>
                          
                          <a href="<?php echo $this->webroot; ?>superadmin/merchants/addmerchant">ADD</a>
                          <?php } ?>
                          </li>
						  <li>
                         <?php if($merchantSearch) {?> 
                          <a href="<?php echo $this->webroot; ?>superadmin/merchants/search">SEARCH</a>
                          <?php } ?>
                          </li>
						</ul>
					  </li>
      <li><a #><span class="icon"><?php echo $this->Html->image('user_red.png', array('alt' => 'Home'));?></span><span>USERS</span></a>
						<ul>
						  <li>
                          <?php
                          
                       
                        if($userAddUser)
                        {
                           echo $this->Html->link(__("ADD",true),"/superadmin/addUser");
                         } 
                          ?>
                          </li>
						  <li>
                          
                          
                          <?php
                           if($userdoclist)
                       		 {
                           echo $this->Html->link(__("DOCS",true),"/superadmin/doclist") ;
                           }
                           
                           ?>
                          </li>
						  <li>
                          <?php
                          if($usersearch)
                       		 {
                             echo $this->Html->link(__("SEARCH",true),"/superadmin/search") ;
                          
                           }
                           ?>
                          </li>
                          
                          
						  <li><?php 
                          
                          if($userUserList)
                       		 {
                          echo $this->Html->link(__("All Users",true),"/superadmin/allUsers");
                          }
                           ?></li>
						</ul>
					  </li>
      
      <li><a href="#"><span class="icon"><?php echo $this->Html->image('world_link.png', array('alt' => 'Home'));?></span><span>RESIDUALS</span></a>
      <ul>
      <li><a href="#" style="color:#FF0000">Phase 2/3</a></li>
      </ul>
      </li>
      <li><a href="documents.html"><span class="icon"><?php echo $this->Html->image('folder_page.png', array('alt' => 'Home'));?></span><span>DOCUMENTS</span></a>
        <ul>
        	<li><a href="#" style="color:#FF0000">Phase 3</a></li>
          <li><a href="#">AGENT FORMS</a></li>
          <li><a href="#">EQUIPMENT</a></li>
          <li><a href="#">MARKETING</a></li>
          <li><a href="#">PRICING</a></li>
          <li><a href="#">PROPOSALS</a></li>
          <li><a href="#">REGULATIONS</a></li>
          <li><a href="#">SERVICES</a></li>
          <li><a href="#">TECHNICAL</a></li>
        </ul>
      </li>
      <li><a href="#"><span class="icon"><?php echo $this->Html->image('support1.gif', array('alt' => 'Home'));?></span><span>SUPPORT</span></a>
        <ul>
        <li><a href="#" style="color:#FF0000">Phase 3</a></li>
          <li><a href="#">CONTACT US</a></li>
          <li><a href="#">NEW TICKET</a></li>
          <li><a href="#">OPEN TICKET</a></li>
          <li><a href="#">PENDING</a></li>
          <li><a href="#">UPDATED</a></li>
          <li><a href="#">CLOSED</a></li>
          <li><a href="#">SEARCH</a></li>
        </ul>
      </li>
      <li><a href="reports.html"><span class="icon"><?php echo $this->Html->image('report.png', array('alt' => 'Home'));?></span><span>REPORTS</span></a>
        <ul>
         <li><a href="#" style="color:#FF0000">Phase 3</a></li>
          <li><a href="#">COMMISSIONS </a></li>
          <li><a href="#">CONVERSION </a></li>
          <li><a href="#">PROCESSORS </a></li>
          <li><a href="#">MANAGERS </a></li>
          <li><a href="#">ISO </a></li>
          <li><a href="#">AGENT </a></li>
          <li><a href="#">REFERRAL </a></li>
          <li><a href="#">BUSINESS TYPE </a></li>
          <li><a href="#">PROCESSOR MATRIX </a></li>
          <li><a href="#">TICKETS </a></li>
          <li><a href="#">UNDERWRITING </a></li>
        </ul>
      </li>
      <li><a href="#"><span class="icon"><?php echo $this->Html->image('administrator1_16x16.gif', array('alt' => 'Home'));?></span><span>ADMIN</span></a>
						<ul>
                        <li><a href="<?php echo $this->webroot; ?>superadmin/editUser/<?php echo $this->Session->read('UserAuth.User.id')?>">MY PROFILE</a></li>
                        	<?php if($listGroup) {?>
						   <li><a href="<?php echo $this->webroot; ?>superadmin/allGroups">ALL USER GROUPS</a></li>
                           <?php } ?>
                           <?php if($addGroup) {?>
                           <li><a href="<?php echo $this->webroot; ?>superadmin/addGroup">ADD USER GROUPS</a></li>
                          <?php } ?>
                          <?php if($UserGroupPermissions) {?>
                           <li><a href="<?php echo $this->webroot; ?>superadmin/permissions">SET USER PERMISSION</a></li>
                           <?php } ?>  
                             
                          <?php if($viewaccountCatList){?>
                          <li><a href="<?php echo $this->webroot; ?>superadmin/accountcats/viewlist">MERCHANT ACCOUNT CATEGORY</a></li>
                        <?php }?>
						
                         
                       <?php if($addstatus){?>
                       	 <li><a href="<?php echo $this->webroot; ?>superadmin/statuses/addstatus">MERCHANT STATUS</a></li>
                        <?php }?>
                        
                        
						<?php if($viewaccounttypesList){?>
                          <li><a href="<?php echo $this->webroot; ?>superadmin/accounttypes/viewlist">MERCHANT ACCOUNT TYPE</a></li>
                        <?php }?>
                          
						  <li><a href="#">COMMISSION UPLOAD <font color="#FF0000">Phase 2</font> </a></li>
						  <li><a href="#">DOCUMENTS<font color="#FF0000">Phase 2</font></a></li>
						  <li><a href="#">EMAIL BLAST<font color="#FF0000">Phase 3</font></a></li>
                          
                          <?php if($addgateway) {?>
						  <li><a href="<?php echo $this->webroot; ?>superadmin/gateways/addgateway">GATEWAY</a></li>
                          <?php } ?>
						  <li><a href="<?php echo $this->webroot; ?>superadmin/admins/announcement">NEWS & ANNOUNCEMENT<font color="#FF0000">Phase 3</font></a></li>
						  <li><a href="<?php echo $this->webroot; ?>superadmin/rates/ratelist">RATES(PRICING)</a></li>
                           <li><a href="<?php echo $this->webroot; ?>superadmin/merchanttransactions/transactionlist/">TRANSACTION</a></li>
                           <li><a href="<?php echo $this->webroot; ?>superadmin/deployments/deploymentlist/">DEPLOYMENT</a></li>
                           <?php if($Processordocs) {?>
						  <li><a href="<?php echo $this->webroot; ?>superadmin/processordocs/addprodoc">PROCESSOR DOCUMENTS</a></li>
                         <?php } ?> 
                          
						  <li><a href="#">TEMPLATE EMAILS<font color="#FF0000">Phase 3</font></a></li>
		</ul>
					  </li>
    </ul>
                    <?php } ?>
					<!-- end quick -->
					<div class="corner tl"></div>
					<div class="corner tr"></div>
				  </div>
				</div>	

<div id="content">
                <?php //echo $this->Session->flash(); ?>
                <?php echo $this->element('admin_msg'); ?>
                <?php echo $this->fetch('content'); ?>
		</div>
		
		<div id="footer">
		  	<p>&copy;2012 Copyright Total Apps. All rights reserved.</p>
		</div>

	<?php  //echo $this->element('sql_dump'); ?>
</body>
</html>
