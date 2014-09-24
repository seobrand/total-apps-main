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

<?php 
if(isset($this->request->data['Processor'])){
 $processor = strtolower($this->request->data['Processor']['user_Name']);
 if($processor=='mojopay' || $processor=='mojo-pay' || $processor=='mojo pay' || $processor=='mp'){
 	$showlogo = "mojopay";
 }else{
 	$showlogo = "totalapps";
 }
}else{
	$showlogo = "totalapps";
}		

$showbannername = "Online Application";
 
 ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Total Apps</title>
<?php 
echo $this->Html->css('online_appform/reset');
echo $this->Html->css('online_appform/styles');
echo $this->Html->css(array('online_appform/tablet_portrait'), 'stylesheet', array('media' => 'screen and (min-width: 768px) and (max-width: 995px)'));
echo $this->Html->css(array('online_appform/mobile_portrait'), 'stylesheet', array('media' => 'screen and (max-width: 480px)'));
echo $this->Html->css(array('online_appform/mobile_landscape'), 'stylesheet', array('media' => 'screen and (min-width: 481px) and (max-width: 767px)'));
echo $this->Html->css('online_appform/fonts');
echo $this->Html->css('online_appform/superfish');
?>
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
<meta name="viewport" content="width=device-width, maximum-scale = 1, minimum-scale=1" />

<!--[if lt IE 8]>
   <div style=' clear: both; text-align:center; position: relative;background:#d0dbed;'>
     <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode" target="_blank">
       <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
    </a>
  </div>
<![endif]-->
<!--[if (IE 7)|(IE 8)]>
<script src="js/html5.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/ie.css"> 
<![endif]-->

</head>
<body>
<div id="wrapper_outer">
  <header> 
    <!--start_header -->
    <div id="header_top_outer"> 
      <!--start header_top_outer -->
      <div id="header_top_inner">
        <section id="header_collm">
          <div id="header_top_left">
          <?php if($showlogo=='totalapps'){?>
            <h1 class="logos"><a href="#">Total Apps</a></h1>
          <?php }else{?>
          	<h1 class="mojo_logos"><a href="#">Mojo Pay</a></h1>
          <?php }?>
            <div class="logo_tagline">Your Advanced Payment Processing Solution</div>
          </div>
          <div id="header_top_right">
            <div class="header_mem_box">
              <ul>
                <li>
                  <input type="button" value=" " name="" class="member_login">
                </li>
                <li>&nbsp;</li>
              </ul>
            </div>
            <div id="header_social">
              <ul>
                <li><a href="#"></a></li>
              </ul>
            </div>
          </div>
          <div class="clear"></div>
        </section>
        <nav id="navigation">
          <ul class="sf-menu">
            
          </ul>
          <ul class="nav_other">
            <li><a href="credit_cards.html">&nbsp;</a></li>
            
          </ul>
          <div class="clear"></div>
        </nav>
        <div class="clear"></div>
      </div>
      <!--end of header_top_outer --> 
    </div>
    <div id="header_middle_outer"> 
      <!--start header_middle_outer -->
      <div id="header_middle_inner_pages">
        <ul class="fader">
          <li> 
            <!-- Slide collm start -->
            <div class="slider_img"><img src="<?php echo $this->webroot;?>img/online_appform/online_shop.png" alt="Shopping Online" title="Shopping Online"></div>
            <div class="slider_credit_text">
              <div class="slider_title"><?php echo $showbannername;?></div>
            </div>
            <div class="clear"></div>
            <!-- Slide collm end --> 
          </li>
        </ul>
        <div class="steps_des">
          <p>You are a few steps away<br>
            from being able to accept<br>
            credit cards!</p>
        </div>
      </div>
      <!--end of header_middle_outer --> 
    </div>
    <!--end of header --> 
  </header>
  <section>
    <div id="container_outer"> 
      <!--strrt container_outer -->
      <div id="container_inner">
        <div class="product_search_main">
          <?php echo $this->element('admin_msg'); ?>
                <?php echo $this->fetch('content'); ?>
        </div>
        <div class="clear"></div>
      </div>
      <!--end of container_outer --> 
    </div>
  </section>
  <footer>
    <div id="footer_outer"> 
      <!--start footer_outer -->
      <div id="footer_copyright">
        <div class="footer_inner">
          <p><!--  30 Enterprise, Suite 210, Aliso Viejo, CA 92656  |  Tel: (949) 274-8975 Fax: (949) 266-8260<br>
            Total Apps, Inc is a registered ISO/MSP of Wells Fargo, N.A., Walnut Creek, CA. --></p>
        </div>
      </div>
      <!--end of footer_inner --> 
    </div>
  </footer>
  <!--end of wrapper_outer --> 
  
</div>
</body>
</html>










