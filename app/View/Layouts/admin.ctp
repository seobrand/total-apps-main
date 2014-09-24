<?php
$action = explode('_', $this->params['action']);
$page = $action['1'];
$loginUserId = $this->Session->read('UserAuth.User.user_group_id');

if($this->Session->read('UserAuth.User.user_group_id'))
{
	   $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
	   $is_super_admin = $this->Session->read('UserAuth.User.is_super_admin');
	
	   /// permisssion for resports ====
	   $userstatus=$common->isUserGroupAccesss('Users','superadmin_userstatus',$userGroupId);
	   
       $allreports_permission=$common->isUserGroupAccesss('Reports','superadmin_allreports',$userGroupId);		
       $residualreport_permission=$common->isUserGroupAccesss('Reports','superadmin_residualreport',$userGroupId);       
   
       $processorbyvolumeoramount_permission=$common->isUserGroupAccesss('Reports','superadmin_processorbyvolumeoramount',$userGroupId);
	   $accountbyagent_permission=$common->isUserGroupAccesss('Reports','superadmin_accountbyagent',$userGroupId);
	   $accountbyreferral_permission=$common->isUserGroupAccesss('Reports','superadmin_accountbyreferral',$userGroupId);
	   $iso_permission=$common->isUserGroupAccesss('Reports','superadmin_iso',$userGroupId);
     
	   $procmonthlyprocessing_permission=$common->isUserGroupAccesss('Reports','superadmin_procmonthlyprocessing',$userGroupId);
	   $processormatrix_permission=$common->isUserGroupAccesss('Reports','superadmin_processormatrix',$userGroupId);
	   $tierreport_permission=$common->isUserGroupAccesss('Reports','superadmin_tierreport',$userGroupId);
       $commission_permission=$common->isUserGroupAccesss('Reports','superadmin_commission',$userGroupId);
       $monthlyprocessingvolume_permission=$common->isUserGroupAccesss('Reports','superadmin_monthlyprocessingvolume',$userGroupId);  
	 
	   $newbusinessgrowth_permission=$common->isUserGroupAccesss('Reports','superadmin_newbusinessgrowth',$userGroupId); 
	  
	   $existingbusinessgrowth_permission=$common->isUserGroupAccesss('Reports','superadmin_existingbusinessgrowth',$userGroupId);
	
	   $existingwithoutnerium_permission=$common->isUserGroupAccesss('Reports','superadmin_existingwithoutnerium',$userGroupId);
       $paymentsetupfees_permission=$common->isUserGroupAccesss('Reports','superadmin_paymentsetupfees',$userGroupId);
	   $reportprocessor2_permission=$common->isUserGroupAccesss('Reports','superadmin_reportprocessor2',$userGroupId);
	   $processorsetupfees_permission=$common->isUserGroupAccesss('Reports','superadmin_processorsetupfees',$userGroupId); 
	   $expiringcontract_permission=$common->isUserGroupAccesss('Reports','superadmin_expiringcontract',$userGroupId);
	   $agent_permission=$common->isUserGroupAccesss('Reports','superadmin_agent',$userGroupId);
	   $manager_permission=$common->isUserGroupAccesss('Reports','superadmin_manager',$userGroupId);
	   $manageraccount_permission=$common->isUserGroupAccesss('Reports','superadmin_manageraccount',$userGroupId);
	   $loss_permission =	$common->isUserGroupAccesss('Reports','superadmin_loss',$userGroupId);
	   /// end ====
	
	   // reports permission (Ticket#2244)
	   $user_report_permission = $common->getReportPermission($this->Session->read('UserAuth.User.id'));
	
	$userAddUser=$common->isUserGroupAccesss('Users','superadmin_addUser',$userGroupId);
	
	$userdoclist=$common->isUserGroupAccesss('Users','superadmin_doclist',$userGroupId);
	$usersearch=$common->isUserGroupAccesss('Users','superadmin_search',$userGroupId);
	$userUserList=$common->isUserGroupAccesss('Users','superadmin_index',$userGroupId);
	
	$userdelete=$common->isUserGroupAccesss('Users','deleteUser',$userGroupId);
	$useredit=$common->isUserGroupAccesss('Users','editUser',$userGroupId);
	$myprofile=$common->isUserGroupAccesss('Users','editUser',$userGroupId);
	
	
	$merchantAddNew=$common->isUserGroupAccesss('Merchants','superadmin_addmerchant',$userGroupId);
	$merchantSearch=$common->isUserGroupAccesss('Merchants','superadmin_search',$userGroupId);
	$merchantStatus=$common->isUserGroupAccesss('Merchants','superadmin_viewbystatus',$userGroupId);
	
	
	$addgateway=$common->isUserGroupAccesss('Gateways','superadmin_addgateway',$userGroupId);
   	 
     
     
	$viewaccounttypesList=$common->isUserGroupAccesss('Accounttypes','superadmin_viewlist',$userGroupId);
	$viewaccountCatList = $common->isUserGroupAccesss('Accountcats','superadmin_viewlist',$userGroupId);
	$viewBusinessCatList = $common->isUserGroupAccesss('Businesscats','superadmin_viewlist',$userGroupId);
	
	

    
    $addstatus=$common->isUserGroupAccesss('Statuses','superadmin_addstatus',$userGroupId);
    $Processordocs=$common->isUserGroupAccesss('Processordocs','superadmin_addprodoc',$userGroupId);
    
    $UserGroupPermissions=$common->isUserGroupAccesss('UserGroupPermissions','superadmin_index',$userGroupId);

    $addGroup=$common->isUserGroupAccesss('UserGroups','superadmin_addGroup',$userGroupId);
    $editGroup=$common->isUserGroupAccesss('UserGroups','superadmin_editGroup',$userGroupId);
  
    $listGroup=$common->isUserGroupAccesss('UserGroups','superadmin_index',$userGroupId);
    $deleteGroup=$common->isUserGroupAccesss('UserGroups','superadmin_deleteGroup',$userGroupId);
    
    $ratelist=$common->isUserGroupAccesss('Rates','superadmin_ratelist',$userGroupId);
    $deploymentList=$common->isUserGroupAccesss('Deployments','superadmin_deploymentlist',$userGroupId);
    $transactionList=$common->isUserGroupAccesss('Merchanttransactions','superadmin_transactionlist',$userGroupId);
    
    
    $editUser=$common->isUserGroupAccesss('Users','superadmin_editUser',$userGroupId);
 
 
	//=========================  Set Document Menu =====================
	 $documentList=$common->isUserGroupAccesss('Documents','superadmin_listDocument',$userGroupId);
	 $folderList=$common->isUserGroupAccesss('Documents','superadmin_listFolder',$userGroupId);
	
	//============================= End ================================

	//=========================  Set Residual Menu =====================
	$menuResidual=$common->isUserGroupAccesss('Documents','superadmin_AgentForm',$userGroupId);
	//============================= End ================================



	//=========================  News & Announcement =====================
	
	$menuNewsList=$common->isUserGroupAccesss('News','superadmin_newsList',$userGroupId);

	//=========================  Emails =====================
	
    $userBlastEmail=$common->isUserGroupAccesss('EmailTemplates','superadmin_userBlastEmail',$userGroupId);
	$merchantBlastEmail=$common->isUserGroupAccesss('EmailTemplates','superadmin_merchantBlastEmail',$userGroupId);
	 
	$adminTemplateList=$common->isUserGroupAccesss('EmailTemplates','superadmin_index',$userGroupId);
	$myTemplate=$common->isUserGroupAccesss('EmailTemplates','superadmin_myTemplate',$userGroupId);
	//============================= End ================================

	//=========================  News & Announcement =====================
	$menuCommission=$common->isUserGroupAccesss('Commissions','superadmin_commission',$userGroupId);
	//============================= End ================================


	//=========================  Supports =====================
	$supportMenu	=	$common->isUserGroupAccesss('Supports','superadmin_index',$userGroupId);
	$referralLinks	=	$common->isUserGroupAccesss('Supports','superadmin_referralLinks',$userGroupId);
	//============================= End ================================

	//=========================  Supports =====================

	$menuSupportCommission=$common->isUserGroupAccesss('Reports','superadmin_commission',$userGroupId);
    $menuConversion=$common->isUserGroupAccesss('Reports','superadmin_conversion',$userGroupId);
    $menuProcessor=$common->isUserGroupAccesss('Reports','superadmin_processor',$userGroupId);
    $menuManager=$common->isUserGroupAccesss('Reports','superadmin_manager',$userGroupId);
    
    $menuIso=$common->isUserGroupAccesss('Reports','superadmin_iso',$userGroupId);
    
    $menuAgent=$common->isUserGroupAccesss('Reports','superadmin_agent',$userGroupId);
    $menuReferal=$common->isUserGroupAccesss('Reports','superadmin_referal',$userGroupId);
    
    $menuBusinessType=$common->isUserGroupAccesss('Reports','superadmin_businessType',$userGroupId);
    $menuProcessorMatrix=$common->isUserGroupAccesss('Reports','superadmin_processorMatrix',$userGroupId);
    $menuTicket=$common->isUserGroupAccesss('Reports','superadmin_ticket',$userGroupId);
    $menuUnderWriting=$common->isUserGroupAccesss('Reports','superadmin_underWriting',$userGroupId);
    
	//============================= end ===========
    $showAddresses =  $common->isUserGroupAccesss('Addresses','superadmin_searchuser',$userGroupId);

	// Bulk Merchant modification permission (Ticket#2000)
    $bulk_merchant_permission = $common->isUserGroupAccesss('MassMerchantUpdates','superadmin_merchantsearch',$userGroupId);
	

} 


$cakeDescription = __d('cake_dev', 'Total APP: Admin Panel');
$pipeline_outer = $common->getMerchantStatusOuter();
$pipeline_other = $common->getMerchantStatusOther();

$pagename = $this->params['action'];


$roleoption = $common->getUserRole($this->Session->read('UserAuth.User.id'));
foreach($roleoption as $userRole){
	$user_role[$userRole['UserGroup']['id']] = $userRole['UserGroup']['name'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php // task id 3203 ?>
<!-- no cache headers -->
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Cache-Control" content="no-cache">
<!-- end no cache headers -->
<?php echo $this->Html->charset(); ?>
<title><?php echo $cakeDescription ?>:<?php echo $title_for_layout; ?></title>
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css('reset');
	echo $this->Html->css('style');	
	/* Add css bootstrap.min,residual 21-02-2014  */
	/* removed due to issues on merchant info 03-03-2014  */
	// echo $this->Html->css('bootstrap.min.css');
?>
<!--[if IE 7]>
<?php 
	echo $this->Html->css('ie7');
?>
<![endif]-->
<?php 
		echo $this->Html->css('blue');
		
		echo $this->Html->script('jq-cal/jquery.js');
		echo $this->Html->script('jq-cal/jquery-ui.js');
		echo $this->Html->css('jq-cal/smoothness/jquery-ui.css');
	
		?>
<link rel="shortcut icon" href="<?php echo FULL_BASE_URL.router::url('/',false).'app/webroot/favicon.ico'; ?>" type="image/x-icon"/>
<!-- scripts (jquery) -->
<?php 
		echo $this->Html->script('functions.js');
		//echo $this->Html->script('jquery-1.4.2.min');
		echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'));
		echo $this->Html->script('jquery-ui-1.8.custom.min');
?>
<!-- Js/Css For datetime picker Start -->
<?php echo $this->Html->css('smoothness/jquery-ui.css');?>
<?php echo $this->Html->css('datetimepicker/jquery-ui-timepicker-addon.css');?><?php echo $this->Html->script('datetimepicker/jquery-1.8.2.min.js');?><?php echo $this->Html->script('datetimepicker/jquery-ui.min.js');?><?php echo $this->Html->script('datetimepicker/jquery-ui-timepicker-addon.js');?><?php echo $this->Html->script('datetimepicker/jquery-ui-sliderAccess.js');?>
<!-- Js/Css For datetime picker END -->
<!-- Js/Css For multiselect dropdown start -->
<?php echo $this->Html->css('multiselect/jquery.multiselect.css');?><?php echo $this->Html->css('multiselect/style.css');?>
<?php if($pagename=='superadmin_viewbystatus' || $pagename=='superadmin_search'){?>
<?php echo $this->Html->css('jqueryui/jquery-ui.css');?>
<?php }?>
<?php echo $this->Html->script('multiselect/jquery.multiselect.js');?>
<!-- Js/Css For multiselect dropdown end -->
<!--[if IE]><?php echo $this->Html->script('excanvas.min'); ?><![endif]-->
<!-- scripts (custom) -->
<?php 
	echo $this->Html->script('smooth');
	echo $this->Html->script('smooth.menu');
?>
<?php echo $this->element("message_popup");?>
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
		if(document.getElementById('closethisLink') != null){
			document.getElementById('closethisLink').click();	
		}
		
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
          <td align="right"><strong>Hello <?php echo ucfirst($this->Session->read('UserAuth.User.user_Name')); ?> |</strong> <?php echo $this->Html->link(__("Logout",true),"/superadmin/usermgmt/users/logout") ; ?>
            <b> | Server Date : <?php echo date('d M Y');?> </b>
         	<?php  if($this->Session->read('UserAuth.User.id') && $page!='role'){ ?>
         		<?php echo $this->Form->create("UserRole",array('id'=>'loginUserRole','url' => array('controller'=>'users','action'=>'role','plugin'=>'usermgmt')));?>
	         	<?php echo $this->Form->input('',array('name'=>'Role','type'=>'select','options'=>$user_role,'default'=>$this->Session->read('UserAuth.User.user_group_id'),'label'=>'<b>Login As</b>&nbsp;','div'=>false,'class'=>'user_level_select','onchange'=>'change_login_role()'));?>
	         	<?php echo $this->Form->input('',array('name'=>'RoleChangeFrom','type'=>'hidden','value'=>'header'));?>
	         	<?php echo $this->Form->end();?>
         	<?php }?>
         	<script>
	         	function change_login_role(){
		         	$('#loginUserRole').submit();
	         	}
            </script>
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
      <li class="select"> <a href="<?php echo $this->webroot; ?>superadmin/dashboard"><?php echo  '<span class="icon">'.$this->Html->image('home.png').'</span><span>Home</span>'; ?></a> </li>
      <?php if($merchantStatus){ ?>
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
      <?php } ?>
      <?php 
      	if($merchantAddNew || $merchantSearch){
      ?>
      <li><a href="#"><span class="icon"><?php echo $this->Html->image('script.png', array('alt' => 'Home'));?></span><span>MERCHANTS </span></a>
        <ul>
          <li>
            <?php
            if($merchantAddNew)
            { ?>
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
      <?php 
      }
      ?>
      <?php 
		 if($loginUserId!='1' and $loginUserId!='24' and $loginUserId!='22' and $loginUserId!='23')
		  {
			$userBlastEmail='';
		  }
		  
      if($userAddUser || $userdoclist || $usersearch || $userUserList || $editUser || $myTemplate || $userBlastEmail || $merchantBlastEmail)
     {
	    ?>
      <li><a #><span class="icon"><?php echo $this->Html->image('user_red.png', array('alt' => 'Home'));?></span><span>USERS</span></a>
        <ul>
          <?php if($editUser) {?>
          <li> <a href="<?php echo $this->webroot; ?>superadmin/editUser/<?php echo $this->Session->read('UserAuth.User.id')?>">MY PROFILE</a> </li>
          <?php } ?>
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
          <li>
            <?php 
                   if($userUserList)
                    {
                    	echo $this->Html->link(__("All USERS",true),"/superadmin/allUsers");
                    }
                ?>
          </li>
          <?php if($myTemplate) {?>
          <li> <a href="<?php echo $this->webroot; ?>superadmin/email_templates/myTemplate">EMAIL TEMPLATE</a> </li>
          <?php } ?>
          <?php if($userBlastEmail) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/email_templates/userBlastEmail">USER EMAIL BLAST</a></li>
          <?php } ?>
          <?php if($merchantBlastEmail) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/email_templates/merchantBlastEmail">MERCHANT EMAIL BLAST</a></li>
          <?php } ?>
        </ul>
      </li>
      <?php 
      }
      ?>
      <?php 
	  $userId=$this->Session->read('UserAuth.User.id');
	 
	  $folders=$common->getFolderList($userId,$userGroupId);
		
	  ?>
      <li><a><span class="icon"><?php echo $this->Html->image('folder_page.png', array('alt' => 'Home'));?></span><span>DOCUMENTS</span></a>
        <?php if(count($folders) >0) {?>
        <ul>
          <?php foreach($folders as $key=>$value){ ?>
          <li><?php echo $this->Html->link(strtoupper($value),array('controller'=>'documents','action'=>'index','style'=>'index',$key,'plugin'=>null),array()); ?></li>
          <?php } ?>
        </ul>
        <?php } ?>
      </li>
      <?php ?>
      <?php if($supportMenu){ ?>
      <li><a href="#"><span class="icon"><?php echo $this->Html->image('support1.gif', array('alt' => 'Home'));?></span><span>SUPPORT</span></a>
        <ul>
          <li> <a class="childs" style="text-transform:uppercase;">TotalApps.com</a>
            <ul>
              <li><a href="<?php echo $this->webroot; ?>superadmin/supports/index" style="text-transform:uppercase;">Add Ticket</a></li>
          	  <li><a href="<?php echo $this->webroot; ?>superadmin/supports/ticket" style="text-transform:uppercase;">All Tickets</a></li>
            </ul>
          </li>
          <li> <a class="childs" style="text-transform:uppercase;">Mojopay.com</a>
            <ul>
              <li><a href="<?php echo $this->webroot; ?>superadmin/supports/mojopayindex" style="text-transform:uppercase;">Add Ticket</a></li>
          	  <li><a href="<?php echo $this->webroot; ?>superadmin/supports/mojopayticket" style="text-transform:uppercase;">All Tickets</a></li>
            </ul>
          </li>          
		  <li> <a class="childs" style="text-transform:uppercase;">Taboo Support Requests</a>
            <ul>
              <li><a href="<?php echo $this->webroot; ?>superadmin/supports/submitrequest">Submit request</a></li>
              <li><a href="<?php echo $this->webroot; ?>superadmin/supports/viewrequests">View submitted requests</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <?php }?>
     
     
    <?php

 // ===========end =========

	
	
	
	
	if($allreports_permission || $residualreport_permission || $processorbyvolumeoramount_permission || $accountbyagent_permission ||$accountbyreferral_permission || $iso_permission ||  $procmonthlyprocessing_permission || $processormatrix_permission || $tierreport_permission || $commission_permission || $monthlyprocessingvolume_permission || $newbusinessgrowth_permission || $existingwithoutnerium_permission || $manager_permission || $manageraccount_permission || $loss_permission || $paymentsetupfees_permission ||  $reportprocessor2_permission ||  $processorsetupfees_permission || $expiringcontract_permission || $agent_permission){ ?>
      <li><a><span class="icon"><?php echo $this->Html->image('report.png', array('alt' => 'Home'));?></span><span>REPORTS</span></a>
        <ul>
        
        <?php if($allreports_permission){ ?>  <li><a href="<?php echo $this->webroot; ?>superadmin/reports/allreports">ALL REPORTS</a></li><?php } ?>
          
       <?php if(in_array(1, $user_report_permission)){?>
       <li><a href="<?php echo $this->webroot; ?>superadmin/reports/residualreport">RESIDUAL REPORT</a></li>
       <?php } ?>
       <?php if(in_array(2, $user_report_permission)){?>
         <li><a class="childs" style="text-transform:uppercase;">CHARGEBACK REPORT</a>
         	<ul>            
            	<li><a href="<?php echo $this->webroot; ?>superadmin/reports/meritcardreport">Meritcard Chargeback Report</a></li>
            	<li><a href="<?php echo $this->webroot; ?>superadmin/reports/meritusreport">Meritus Chargeback Report</a></li>
             </ul>
         </li>
         <?php }?>
         <!--
         <?php //if(in_array(3, $user_report_permission)){?>
         <?php //if($accountbyagent_permission  || $accountbyagent_permission || $accountbyreferral_permission || $iso_permission){ ?>
         <li> <a class="childs" style="text-transform:uppercase;">Taboo's Accounts</a>
            
            <ul>
				
            <?php //if($accountbyagent_permission){ ?>  <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/accountbyagent">Accounts By Agent</a></li> <?php // } ?>
            
           	<?php //if($accountbyreferral_permission){ ?>  <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/accountbyreferral">Accounts By Referral</a></li> <?php  //} ?>
            
            <?php //if($iso_permission){ ?> <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/iso">Accounts By ISO</a></li><?php // } ?>
            </ul>
			
          </li> 
          <?php //} } ?>-->
          
         <?php if(in_array(4, $user_report_permission)){?>
         <li> <a class="childs" style="text-transform:uppercase;">PROCESSOR REPORT</a>
            <ul>
			<!--Add Current Account Status link -->
			<?php if($processorbyvolumeoramount_permission){ ?> <li><a href="<?php echo $this->webroot; ?>superadmin/reports/processorbyvolumeoramount">Current Account Status</a></li> <?php } ?>
           	 <?php if($procmonthlyprocessing_permission){ ?>   <li><a href="<?php echo $this->webroot; ?>superadmin/reports/procmonthlyprocessing">Processors Monthly Processing</a></li>	<?php } ?>
              <?php if($processormatrix_permission){ ?> <li><a href="<?php echo $this->webroot; ?>superadmin/reports/processormatrix">Processor Business Matrix</a></li>	<?php } ?>
              <?php if($tierreport_permission){ ?> <li><a class="childs">Tier Reports</a>
			      <ul>
					<li><a href="<?php echo $this->webroot; ?>superadmin/reports/tierreport/meritcard">Meritcard Tier Report</a></li>
					<!--<li><a href="<?php // echo $this->webroot; ?>superadmin/reports/tierreport/powerpay">Powerpay Tier Report</a></li> -->
					<li><a href="<?php echo $this->webroot; ?>superadmin/reports/tierreport/meritus">Meritus Tier Report</a></li>
			      </ul>
	      </li>	<?php } ?>
            </ul>
          </li>
          <?php }?>
         <?php if(in_array(5, $user_report_permission)){?>
          <li> <a class="childs" style="text-transform:uppercase;">AGENT/REFERRAL/ISO REPORT</a>
            <ul>
            <?php if($commission_permission){ ?>  <li><a href="<?php echo $this->webroot; ?>superadmin/reports/commission">Commission Report</a></li> <?php } ?> 
			<?php if($accountbyagent_permission){ ?>  <li><a href="<?php echo $this->webroot; ?>superadmin/reports/currentaccountstatus">Current Account Status</a></li> <?php } ?>
			<?php if($commission_permission){ ?>  <li><a href="<?php echo $this->webroot; ?>superadmin/reports/leadsubmitted">Leads Submitted</a></li> <?php  } ?>
			<?php if($commission_permission){ ?>  <li><a href="<?php echo $this->webroot; ?>superadmin/reports/monthlysales">Monthly Sales</a></li> <?php } ?>
            </ul>
          </li>
          <?php } ?>
		  <!--   Delete Merchant Processing Volume task id #80 date 17-feb-2014 --> 
		  <!--
          <?php //if(in_array(6, $user_report_permission)){?>
          <li> <a class="childs" style="text-transform:uppercase;">MERCHANT PROCESSING VOLUME</a>
            <ul>
            <?php //if($monthlyprocessingvolume_permission){ ?>  <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/monthlyprocessingvolume">Monthly Merchant Processing Volume</a></li><?php //} ?>
          
           <?php //if($newbusinessgrowth_permission){ ?>    <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/newbusinessgrowth">New Business Growth</a></li> <?php //} ?>
            <?php //if($existingbusinessgrowth_permission){ ?>   <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/existingbusinessgrowth">Existing Business Growth</a></li> <?php //} ?>
            <?php //if($existingwithoutnerium_permission){ ?>   <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/existingwithoutnerium">Existing Business Growth(Except Nerium)</a></li><?php //} ?>
            </ul>
          </li>
        <?php // }?>
		-->
        <?php if(in_array(7, $user_report_permission)){?>
          <li> <a class="childs" style="text-transform:uppercase;">MANAGER REPORT</a>
            <ul>
			<!-- Rename Manager's Account to Current Account Status task id #76 date 17-feb-2014  -->
			 <?php if($manager_permission){ ?>  <li><a href="<?php echo $this->webroot; ?>superadmin/reports/manager">Current Account Status</a></li><?php } ?>
            <!-- Rename Manager's Account to Current Account Status task id #76 date 17-feb-2014
			<?php //if($manager_permission){ ?>  <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/manager">Manager's Account</a></li><?php //} ?>
			-->
			<!-- Add Monthly Sales link task id #67 date 17-Feb-2014 -->
			<?php if($commission_permission){ ?>  <li><a href="<?php echo $this->webroot; ?>superadmin/reports/managermonthlysales">Monthly Sales</a></li> <?php } ?>
			<!--   Delete Manager's Processing Account task id #76 date 17-feb-2014 -->
			<!--
            <?php //if($manageraccount_permission){ ?> <li><a href="<?php //echo $this->webroot; ?>superadmin/reports/manageraccount">Manager's Processing Account</a></li><?php //} ?>
            -->
			</ul>
          </li>
        <?php } ?>  
         
        <?php if(in_array(8, $user_report_permission)){?>  
        <?php if($loss_permission){ ?>
        <li><a href="<?php echo $this->webroot; ?>superadmin/reports/loss">LOSS</a></li>
        <?php } }?>
          
         <?php if(in_array(9, $user_report_permission)){?> 
          <li> <a class="childs" style="text-transform:uppercase;">GATEWAY REPORT</a>
            <ul>
              <li><a href="#">NMI Report</a></li>
              <li><a href="#">Authorize.net Report</a></li>
            </ul>
          </li>
          <?php } ?>
         
         <?php if(in_array(10, $user_report_permission)){?>
          <li> <a class="childs" style="text-transform:uppercase;">OTHER REPORTS</a>
            <ul>
			
			<!--
             <?php if($paymentsetupfees_permission){ ?> <li><a href="<?php echo $this->webroot; ?>superadmin/reports/paymentsetupfees">Set Up Fees</a></li><?php } ?>
             <?php if($reportprocessor2_permission){ ?> <li><a href="<?php echo $this->webroot;?>superadmin/reports/reportprocessor2">Processor Business Type</a></li><?php } ?>
             <?php if($processorsetupfees_permission){ ?> <li><a href="<?php echo $this->webroot;?>superadmin/reports/processorsetupfees">Processor Set Up Fees</a></li><?php } ?>
			 -->
			 
             <?php if($expiringcontract_permission){ ?> <li><a href="<?php echo $this->webroot; ?>superadmin/reports/expiringcontract">Expiring Contracts</a></li><?php } ?>
			 
			 <!--
             <?php if($agent_permission){ ?> <li><a href="<?php echo $this->webroot; ?>superadmin/reports/agent">Agents Contact</a></li><?php } ?> -->
            </ul>
          </li>
          <?php }?>
          
        </ul>
      </li>
      <?php }
      
	   if($loginUserId!='1'){
			$userBlastEmail='';
			$merchantBlastEmail='';
	   }		
	   if($userstatus || $listGroup || $addGroup || $UserGroupPermissions || $viewaccountCatList || $addstatus || $viewaccounttypesList || $documentList || $folderList || $userBlastEmail || $merchantBlastEmail  || $addgateway || $menuNewsList || $ratelist || $transactionList || $deploymentList    || $Processordocs  || $menuCommission || $adminTemplateList){
	   	   
	   ?>
      <li><a href="#"><span class="icon"><?php echo $this->Html->image('administrator1_16x16.gif', array('alt' => 'Home'));?></span><span>ADMIN</span></a>
     
     
         <ul>
         <?php if($userstatus){?>  
    	<li><a href="<?php echo $this->webroot; ?>superadmin/usermgmt/users/userstatus/1">ACTIVE USERS/ CREATED LOGS</a></li><?php } ?>
         
        <?php if($listGroup || $addGroup) {?>
          <li><a  class="childs" >USER GROUPS</a>
       	  <ul>
		 	 <?php if($listGroup) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/allGroups">ALL USER GROUPS</a></li>
          	<?php } ?>
        	 <?php if($addGroup) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/addGroup">ADD USER GROUPS</a></li>
         	 <?php } ?>
          </ul>
       	 </li>
           <?php } ?>
           
           
       
          
          
          
          <?php if($UserGroupPermissions) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/permissions">SET USER PERMISSION</a></li>
          <?php } ?>          
          <?php // only shows to Universal-mgr and Crystal-shi (task 2145)
				$loginuser = $this->Session->read('UserAuth.User.id');
	   	  ?>
	   	  <?php if($loginuser==2 || $loginuser==1266){?>	
          <li><a href="<?php echo $this->webroot; ?>superadmin/reportsPermission">SET REPORT PERMISSION</a></li>
          <?php }?>
          <?php if($viewaccountCatList){?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/accountcats/viewlist">MERCHANT ACCOUNT CATEGORY</a></li>
          <?php }?>
          <?php if($viewBusinessCatList){?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/businesscats/viewlist">BUSINESS CATEGORY</a></li>
          <?php }?>
          <?php if($addstatus){?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/statuses/addstatus">MERCHANT STATUS</a></li>
          <?php }?>
          <?php if($viewaccounttypesList){ // task id 3601 comment on 10 Mar 2014 18:11 by jelmaleh ?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/accounttypes/viewlist">MERCHANT CATEGORY</a></li>
          <?php }?>
          
          <?php /*if($viewaccounttypesList){ // task id 3601 comment on 10 Mar 2014 18:11 by jelmaleh ?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/usercats/viewlist">USER CATEGORY</a></li>
          <?php }*/?>
          
          <?php if($userGroupId==1) { // visible for only admin user (taskid #2858)?>
          <li><a class="childs">DATA UPLOAD</a>
          		<ul>
                	 <?php if($menuCommission) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/commissions/upload">COMMISSION UPLOAD</a></li>
          <?php }?>
          			<li><a href="<?php echo $this->webroot; ?>superadmin/commissions/splitdataupload">SPLIT % DATA UPLOAD</a></li>
          
          			<li><a href="<?php echo $this->webroot; ?>superadmin/commissions/agent_iso_referral_upload">AGENT/ISO/REFERRAL UPLOAD</a></li>
                
                </ul>
          </li>
          <?php }?>
          
          <?php if($folderList) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/documents/listFolder">FOLDER<font color="#FF0000"></font></a></li>
          <?php } ?>
          <?php if($documentList) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/documents/listDocument">DOCUMENTS<font color="#FF0000"></font></a></li>
          <?php } ?>
          
          <li><a  class="childs" >EMAIL BLAST</a>
          	<ul>
          			<?php if($adminTemplateList){ ?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/email_templates/index">TEMPLATE EMAILS</a></li>
          <?php } ?>
          <?php if($userBlastEmail) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/email_templates/userBlastEmail">USER EMAIL BLAST</a></li>
          <?php } ?>
          <?php if($merchantBlastEmail) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/email_templates/merchantBlastEmail">MERCHANT EMAIL BLAST</a></li>
          <?php } ?>
         	</ul>
          </li>
          <?php // task id 2000 ?>
          <?php if($bulk_merchant_permission && ($loginuser==2 || $loginuser==1266)) {?>
          <li><a class="childs" href="<?php echo $this->webroot; ?>superadmin/mass_merchant_updates/merchantsearch">BULK MERCHANT MODIFICATION</a>
	          <ul>
	          	<li><a href="<?php echo $this->webroot; ?>superadmin/mass_merchant_updates/rollback">ROLLBACK MERCHANT DATA</a></li>	                
	           </ul>
          </li>
          <?php } ?>
          
          <?php if($addgateway) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/gateways/addgateway">GATEWAY</a></li>
          <?php } ?>
          <?php if($menuNewsList) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/news/newsList">NEWS & ANNOUNCEMENT</a></li>
          <?php } ?>
          <?php if($ratelist){ ?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/rates/ratelist">RATES(PRICING)</a></li>
          <?php } 
          if($transactionList)
        	{?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/merchanttransactions/transactionlist/">TRANSACTION</a></li>
          <?php } 
        
          if($deploymentList)
        	{?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/deployments/deploymentlist/">DEPLOYMENT</a></li>
          <?php } 
         ?>
          <?php if($Processordocs) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/processordocs/addprodoc">PROCESSOR DOCUMENTS</a></li>
          <?php } ?>
          <?php if($showAddresses) {?>
          <li><a href="<?php echo $this->webroot; ?>superadmin/addresses/searchuser">ADDRESSES</a></li>
          <?php } ?>
          <?php if($referralLinks) {?>
          <li> <a href="<?php echo $this->webroot; ?>superadmin/supports/referralLinks">LANDING PAGE FOR REFERRAL</a> </li>
          <?php } ?>
          
          
        </ul>
      </li>
      <?php } ?>
    </ul>
    <?php } ?>
    <!-- end quick -->
    <div class="corner tl"></div>
    <div class="corner tr"></div>
  </div>
</div>
<div id="content">
  <?php //echo $this->Session->flash(); ?>
  <?php echo $this->element('admin_msg'); ?> <?php echo $this->fetch('content'); ?> </div>
<div id="footer">
  <p>&copy;2012 Copyright Total Apps. All rights reserved.</p>
</div>
<?php #echo $this->element('sql_dump'); ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		if( isFunction( showhide ) ){
			showhide('merchantInfo','agentInfo','referalInfo','isoInfo');
		}
		
		// check if a function is defined or not before calling it
		function isFunction(possibleFunction) {
			return (typeof(possibleFunction) == typeof(Function));
		}
	});
</script>
</body>
</html>
