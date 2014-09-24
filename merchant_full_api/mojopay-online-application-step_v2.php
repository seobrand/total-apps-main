<?php include 'mojopy_merchant_api_v2.php';?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Total Apps Merchant Full Api</title>


<link rel="stylesheet" href="mojopay/css/jquery.signaturepad.css">
<link href="mojopay/css/reset.css" rel="stylesheet" type="text/css" media="all">



<link href="mojopay/css/style.css" rel="stylesheet" type="text/css" media="all">


<script src="js/functions_v2.js"></script>

<meta name="viewport" content="width=device-width, maximum-scale = 1, minimum-scale=1" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="build/jquery.signaturepad.min.js"></script>
<script>
window.fbAsyncInit = function() {
  FB.init({
    appId      : '435072703275174', 
	//channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
	//frictionlessRequests : true
  });
};
// Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));

// Here we run a very simple test of the Graph API after login is successful. 
// This testAPI() function is only called in those cases. 
function fbLogin() 
{
	FB.login(function(response) 
	{	/* handle the response */ }, 
	{scope: 'email,user_birthday,user_status'});
	
	FB.Event.subscribe('auth.authResponseChange', function(response) 
	{
		// Here we specify what we do with the response anytime this event occurs. 
		if (response.status === 'connected') {
		  testAPI();
		} else if (response.status === 'not_authorized') {
		  FB.login();
		} else {
		  FB.login();
		}
	});
} 
  	jQuery.noConflict();
	jQuery(document).ready(function() 
	{
		jQuery('.sigPad').signaturePad({validateFields:false});
	  
		jQuery("#MerchantStartDate").datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '1970:2055'
		});
		jQuery("#OwnerDob1").datepicker({
			 changeMonth: true,
			 changeYear: true,
			 yearRange: '1970:2055'
		});	
	});	
function testAPI() 
{
	FB.api('/me', function(response) 
	{
		jQuery('#MerchantContactEmail').val( response.email );
		jQuery('#MerchantContactName').val( response.name );
		jQuery('#OwnerName1').val( response.name );
		jQuery('#OwnerDob1').val( response.birthday );
    });
} 
</script>

  <script src="build/json2.min.js"></script>
  
  
  <script src="js/jquery.alerts.js"></script>
<link href="js/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen">
  <style>
  p.success {
    background-color: #11BC3F;
    color: #FFFFFF;
    display: block;
    font-weight: bold;
    margin: 0.5em 0;
    padding: 0.4em; }
	.validation_info{
	
	color:#CC0000;
	font:18px 'ropa_sansregular';}
	.step_inner ul li{
		margin:0px !important;
	}
  </style>
</head>
<body>
<section class="slideshow_container">
  <div class="slideshow"  style="color:#FFFFFF"> 
  <br><br><br>
   <div class="step_title">Business Profile</div>

		<form action="" method="post" class="sigPad" id="appform"name="fullapi"  onSubmit="return validation(this)">
        
		<?php if($response!='' && $response=='Failure'){?>
			<p class="error"><?php echo $responseMessage;?></p>
		<?php }elseif($response=='Success'){?>
			<p class="success"><?php echo $responseMessage;?></p>
		<?php }?>
			<div class="step_inner">
              <div class="product_search_indent">
                
                <div class="applicationform_bg">
                <span class="validation_info">&nbsp;* All fields marked with a red asterisk character are mandatory.</span>
                  <table class="applicationform_table" cellpadding="2" cellspacing="10">
                    <tbody><tr>
                      <th scope="row"><span class="validation_info">*</span>LEGAL NAME:</th>
                      <td><input type="text" id="MerchantMerchantName" value="<?php echo $merchantName;?>" maxlength="255" class="text_box" name="merchantName"></td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL ADDRESS: </th>
                      <td><input type="text" id="MerchantLegalAddress" value="<?php echo $legalAddress;?>" maxlength="500" class="text_box" name="legalAddress">(NO PO BOX)</td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL ADDRESS #2: </th>
                      <td><input type="text" id="MerchantLegalAddress2" class="text_box" name="legalAddress2" value="<?php echo $legalAddress2;?>"></td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL CITY: </th>
                      <td><input type="text" id="MerchantLegalCity" value="<?php echo $legalCity;?>" maxlength="200" class="text_box" name="legalCity"></td>
                    </tr>
                    <tr>
                      <th scope="row">LEGAL STATE:</th>
                      <td><select id="MerchantLegalState" class="text_box" style="width:320px;" name="legalState">
							<option value="">-Select State-</option>
							<option value="AL" <?php if($legalState=='AL'){?> selected="selected" <?php }?>>Alabama</option>
							<option value="AK" <?php if($legalState=='AK'){?> selected="selected" <?php }?>>Alaska</option>
							<option value="AZ" <?php if($legalState=='AZ'){?> selected="selected" <?php }?>>Arizona</option>
							<option value="AR" <?php if($legalState=='AR'){?> selected="selected" <?php }?>>Arkansas</option>
							<option value="CA" <?php if($legalState=='CA'){?> selected="selected" <?php }?>>California</option>
							<option value="CO" <?php if($legalState=='CO'){?> selected="selected" <?php }?>>Colorado</option>
							<option value="CT" <?php if($legalState=='CT'){?> selected="selected" <?php }?>>Connecticut</option>
							<option value="DE" <?php if($legalState=='DE'){?> selected="selected" <?php }?>>Delaware</option>
							<option value="DC" <?php if($legalState=='DC'){?> selected="selected" <?php }?>>District of Columbia</option>
							<option value="FL" <?php if($legalState=='FL'){?> selected="selected" <?php }?>>Florida</option>
							<option value="GA" <?php if($legalState=='GA'){?> selected="selected" <?php }?>>Georgia</option>
							<option value="HI" <?php if($legalState=='HI'){?> selected="selected" <?php }?>>Hawaii</option>
							<option value="ID" <?php if($legalState=='ID'){?> selected="selected" <?php }?>>Idaho</option>
							<option value="IL" <?php if($legalState=='IL'){?> selected="selected" <?php }?>>Illinois</option>
							<option value="IN" <?php if($legalState=='IN'){?> selected="selected" <?php }?>>Indiana</option>
							<option value="IA" <?php if($legalState=='IA'){?> selected="selected" <?php }?>>Iowa</option>
							<option value="KS" <?php if($legalState=='KS'){?> selected="selected" <?php }?>>Kansas</option>
							<option value="KY" <?php if($legalState=='KY'){?> selected="selected" <?php }?>>Kentucky</option>
							<option value="LA" <?php if($legalState=='LA'){?> selected="selected" <?php }?>>Louisiana</option>
							<option value="ME" <?php if($legalState=='ME'){?> selected="selected" <?php }?>>Maine</option>
							<option value="MD" <?php if($legalState=='MD'){?> selected="selected" <?php }?>>Maryland</option>
							<option value="MA <?php if($legalState=='MA'){?> selected="selected" <?php }?>>Massachusetts</option>
							<option value="MI <?php if($legalState=='MI'){?> selected="selected" <?php }?>>Michigan</option>
							<option value="MN <?php if($legalState=='MN'){?> selected="selected" <?php }?>>Minnesota</option>
							<option value="MS <?php if($legalState=='MS'){?> selected="selected" <?php }?>>Mississippi</option>
							<option value="MO <?php if($legalState=='MO'){?> selected="selected" <?php }?>>Missouri</option>
							<option value="MT <?php if($legalState=='MT'){?> selected="selected" <?php }?>>Montana</option>
							<option value="NE <?php if($legalState=='NE'){?> selected="selected" <?php }?>>Nebraska</option>
							<option value="NV <?php if($legalState=='NV'){?> selected="selected" <?php }?>>Nevada</option>
							<option value="NH <?php if($legalState=='NH'){?> selected="selected" <?php }?>>New Hampshire</option>
							<option value="NJ <?php if($legalState=='NJ'){?> selected="selected" <?php }?>>New Jersey</option>
							<option value="NM <?php if($legalState=='NM'){?> selected="selected" <?php }?>>New Mexico</option>
							<option value="NY <?php if($legalState=='NY'){?> selected="selected" <?php }?>>New York</option>
							<option value="NC <?php if($legalState=='NC'){?> selected="selected" <?php }?>>North Carolina</option>
							<option value="ND <?php if($legalState=='ND'){?> selected="selected" <?php }?>>North Dakota</option>
							<option value="OH <?php if($legalState=='OH'){?> selected="selected" <?php }?>>Ohio</option>
							<option value="OK <?php if($legalState=='OK'){?> selected="selected" <?php }?>>Oklahoma</option>
							<option value="OR <?php if($legalState=='OR'){?> selected="selected" <?php }?>>Oregon</option>
							<option value="PA <?php if($legalState=='PA'){?> selected="selected" <?php }?>>Pennsylvania</option>
							<option value="RI <?php if($legalState=='RI'){?> selected="selected" <?php }?>>Rhode Island</option>
							<option value="SC <?php if($legalState=='SC'){?> selected="selected" <?php }?>>South Carolina</option>
							<option value="SD <?php if($legalState=='SD'){?> selected="selected" <?php }?>>South Dakota</option>
							<option value="TN <?php if($legalState=='TN'){?> selected="selected" <?php }?>>Tennessee</option>
							<option value="TX <?php if($legalState=='TX'){?> selected="selected" <?php }?>>Texas</option>
							<option value="UT <?php if($legalState=='UT'){?> selected="selected" <?php }?>>Utah</option>
							<option value="VT <?php if($legalState=='VT'){?> selected="selected" <?php }?>>Vermont</option>
							<option value="VA <?php if($legalState=='VA'){?> selected="selected" <?php }?>>Virginia</option>
							<option value="WA <?php if($legalState=='WA'){?> selected="selected" <?php }?>>Washington</option>
							<option value="WV <?php if($legalState=='WV'){?> selected="selected" <?php }?>>West Virginia</option>
							<option value="WI <?php if($legalState=='WI'){?> selected="selected" <?php }?>>Wisconsin</option>
							<option value="WY <?php if($legalState=='WY'){?> selected="selected" <?php }?>>Wyoming</option>
							</select></td>
                    </tr>
                    <tr>
                      <th scope="row">LEGAL ZIP:</th>
                      <td><input type="text" id="MerchantLegalZip" value="<?php echo $legalZip;?>" maxlength="5" class="text_box" name="legalZip">                        (5 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>BUSINESS PHONE:</th>
                      <td><input type="text" id="MerchantContactPhone" value="<?php echo $contactPhone;?>" maxlength="10" onBlur="formatPhoneNumber('MerchantContactPhone')" class="text_box" name="contactPhone"></td>
                    </tr>
                    <tr>
                      <th scope="row"> EIN or SSN Tax ID#:<br>
                        <span>(appears on income tax return)</span> </th>
                      <td><input type="text" id="MerchantFederalTaxId" value="<?php echo $federalTaxId;?>" maxlength="9" class="text_box" name="federalTaxId">(9 digits)</td>
                    </tr>
                    <?php /*?><tr>
                      <th scope="row">BUSINESS START DATE:</th>
                      <td><input type="text" id="MerchantStartDate" value="<?php echo $startDate;?>" maxlength="15" class="text_box" name="startDate">                        (mm/dd/yyyy)</td>
                    </tr><?php */?>
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>PRIMARY EMAIL CONTACT:</th>
                      <td><input type="text" id="MerchantContactEmail" value="<?php echo $contactEmail;?>" maxlength="255" class="text_box" name="contactEmail"></td>
                    </tr> 
                    <tr>
                      <th scope="row">PRIMARY CONTACT NAME:</th>
                      <td><input type="text" id="MerchantContactName" value="<?php echo $contactName;?>" maxlength="255" class="text_box" name="contactName"></td>
                    </tr>                    
                   <?php /*?><tr>
                      <th scope="row">BUSINESS TYPE:</th>
                      <td><select  class="text_box" style="width:320px;"  id="merchantAccountCategory" name="accountCategory">
					      	<option value="1" <?php if($accountCategory=='1'){?> selected="selected" <?php }?>>Swipe</option>
							<option value="3" <?php if($accountCategory=='3'){?> selected="selected" <?php }?>>Internet</option>
							<option value="2" <?php if($accountCategory=='2'){?> selected="selected" <?php }?>>MOTO</option>	
							<option value="13" <?php if($accountCategory=='13'){?> selected="selected" <?php }?>>Kuapay</option>											        
					      </select>
						</td>
                    </tr><?php */?>
                    <tr>
                      <th scope="row">BUSINESS CATEGORY:</th>
                      <td><select id="MerchantMerchantType"  class="text_box" style="width:320px;"  name="merchantType">
							<option value="">-Select Business Category-</option>
							<option value="Sole Proprietor" <?php if($merchantType=='Sole Proprietor'){?> selected="selected" <?php }?>>Sole Proprietor</option>
							<option value="Partnership" <?php if($merchantType=='Partnership'){?> selected="selected" <?php }?>>Partnership</option>
							<option value="Private Corp." <?php if($merchantType=='Private Corp.'){?> selected="selected" <?php }?>>Private Corp.</option>
							<option value="Tax Exempt" <?php if($merchantType=='Tax Exempt'){?> selected="selected" <?php }?>>Tax Exempt</option>
							<option value="LLC" <?php if($merchantType=='LLC'){?> selected="selected" <?php }?>>LLC</option>
							</select>
						</td>
                    </tr>
                   	<input type="hidden" id="referral" value="<?php if($_GET['RefID']!=""){ echo trim($_GET['RefID']); }?>" maxlength="10" class="text_box" name="referalID"></td>
                   <tr>
                      <th scope="row">&nbsp;</th>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody></table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
            
            
			<div class="step_title">Tell Us About Your Business!</div>
			<div class="step_inner mart25">
              <div class="product_search_indent">
             
                <div class="applicationform_bg">
                  <table class="applicationform_table"  cellpadding="2" cellspacing="10" width="100%">
                    <tbody><tr>
                      <th scope="row" width="22%"><span class="validation_info">*</span>DBA (name of company):</th>
                      <td><input type="text" id="MerchantMerchantDBA" value="<?php echo $merchantDBA;?>" maxlength="255" class="text_box" name="merchantDBA"></td>
                    </tr>
                   <?php /*?> <tr>
                      <th scope="row"> DBA ADDRESS: </th>
                      <td><input type="text" id="MerchantDbaAddress" value="<?php echo $dbaAddress;?>" maxlength="500" class="text_box" name="dbaAddress">(NO PO BOX)</td>
                    </tr>
                    <tr>
                      <th scope="row"> DBA CITY: </th>
                      <td><input type="text" id="MerchantDbaCity" value="<?php echo $dbaCity;?>" maxlength="255" class="text_box" name="dbaCity"></td>
                    </tr>
                    <tr>
                      <th scope="row">DBA STATE:</th>
                      <td><select id="MerchantDbaState" class="text_box" style="width:320px;" name="dbaState">
						<option value="">-Select State-</option>
							<option value="AL" <?php if($dbaState=='AL'){?> selected="selected" <?php }?>>Alabama</option>
							<option value="AK" <?php if($dbaState=='AK'){?> selected="selected" <?php }?>>Alaska</option>
							<option value="AZ" <?php if($dbaState=='AZ'){?> selected="selected" <?php }?>>Arizona</option>
							<option value="AR" <?php if($dbaState=='AR'){?> selected="selected" <?php }?>>Arkansas</option>
							<option value="CA" <?php if($dbaState=='CA'){?> selected="selected" <?php }?>>California</option>
							<option value="CO" <?php if($dbaState=='CO'){?> selected="selected" <?php }?>>Colorado</option>
							<option value="CT" <?php if($dbaState=='CT'){?> selected="selected" <?php }?>>Connecticut</option>
							<option value="DE" <?php if($dbaState=='DE'){?> selected="selected" <?php }?>>Delaware</option>
							<option value="DC" <?php if($dbaState=='DC'){?> selected="selected" <?php }?>>District of Columbia</option>
							<option value="FL" <?php if($dbaState=='FL'){?> selected="selected" <?php }?>>Florida</option>
							<option value="GA" <?php if($dbaState=='GA'){?> selected="selected" <?php }?>>Georgia</option>
							<option value="HI" <?php if($dbaState=='HI'){?> selected="selected" <?php }?>>Hawaii</option>
							<option value="ID" <?php if($dbaState=='ID'){?> selected="selected" <?php }?>>Idaho</option>
							<option value="IL" <?php if($dbaState=='IL'){?> selected="selected" <?php }?>>Illinois</option>
							<option value="IN" <?php if($dbaState=='IN'){?> selected="selected" <?php }?>>Indiana</option>
							<option value="IA" <?php if($dbaState=='IA'){?> selected="selected" <?php }?>>Iowa</option>
							<option value="KS" <?php if($dbaState=='KS'){?> selected="selected" <?php }?>>Kansas</option>
							<option value="KY" <?php if($dbaState=='KY'){?> selected="selected" <?php }?>>Kentucky</option>
							<option value="LA" <?php if($dbaState=='LA'){?> selected="selected" <?php }?>>Louisiana</option>
							<option value="ME" <?php if($dbaState=='ME'){?> selected="selected" <?php }?>>Maine</option>
							<option value="MD" <?php if($dbaState=='MD'){?> selected="selected" <?php }?>>Maryland</option>
							<option value="MA <?php if($dbaState=='MA'){?> selected="selected" <?php }?>>Massachusetts</option>
							<option value="MI <?php if($dbaState=='MI'){?> selected="selected" <?php }?>>Michigan</option>
							<option value="MN <?php if($dbaState=='MN'){?> selected="selected" <?php }?>>Minnesota</option>
							<option value="MS <?php if($dbaState=='MS'){?> selected="selected" <?php }?>>Mississippi</option>
							<option value="MO <?php if($dbaState=='MO'){?> selected="selected" <?php }?>>Missouri</option>
							<option value="MT <?php if($dbaState=='MT'){?> selected="selected" <?php }?>>Montana</option>
							<option value="NE <?php if($dbaState=='NE'){?> selected="selected" <?php }?>>Nebraska</option>
							<option value="NV <?php if($dbaState=='NV'){?> selected="selected" <?php }?>>Nevada</option>
							<option value="NH <?php if($dbaState=='NH'){?> selected="selected" <?php }?>>New Hampshire</option>
							<option value="NJ <?php if($dbaState=='NJ'){?> selected="selected" <?php }?>>New Jersey</option>
							<option value="NM <?php if($dbaState=='NM'){?> selected="selected" <?php }?>>New Mexico</option>
							<option value="NY <?php if($dbaState=='NY'){?> selected="selected" <?php }?>>New York</option>
							<option value="NC <?php if($dbaState=='NC'){?> selected="selected" <?php }?>>North Carolina</option>
							<option value="ND <?php if($dbaState=='ND'){?> selected="selected" <?php }?>>North Dakota</option>
							<option value="OH <?php if($dbaState=='OH'){?> selected="selected" <?php }?>>Ohio</option>
							<option value="OK <?php if($dbaState=='OK'){?> selected="selected" <?php }?>>Oklahoma</option>
							<option value="OR <?php if($dbaState=='OR'){?> selected="selected" <?php }?>>Oregon</option>
							<option value="PA <?php if($dbaState=='PA'){?> selected="selected" <?php }?>>Pennsylvania</option>
							<option value="RI <?php if($dbaState=='RI'){?> selected="selected" <?php }?>>Rhode Island</option>
							<option value="SC <?php if($dbaState=='SC'){?> selected="selected" <?php }?>>South Carolina</option>
							<option value="SD <?php if($dbaState=='SD'){?> selected="selected" <?php }?>>South Dakota</option>
							<option value="TN <?php if($dbaState=='TN'){?> selected="selected" <?php }?>>Tennessee</option>
							<option value="TX <?php if($dbaState=='TX'){?> selected="selected" <?php }?>>Texas</option>
							<option value="UT <?php if($dbaState=='UT'){?> selected="selected" <?php }?>>Utah</option>
							<option value="VT <?php if($dbaState=='VT'){?> selected="selected" <?php }?>>Vermont</option>
							<option value="VA <?php if($dbaState=='VA'){?> selected="selected" <?php }?>>Virginia</option>
							<option value="WA <?php if($dbaState=='WA'){?> selected="selected" <?php }?>>Washington</option>
							<option value="WV <?php if($dbaState=='WV'){?> selected="selected" <?php }?>>West Virginia</option>
							<option value="WI <?php if($dbaState=='WI'){?> selected="selected" <?php }?>>Wisconsin</option>
							<option value="WY <?php if($dbaState=='WY'){?> selected="selected" <?php }?>>Wyoming</option>
						</select></td>
                    </tr>
                    <tr>
                      <th scope="row">DBA ZIP:</th>
                      <td><input type="text" id="MerchantDbaZip" value="<?php echo $dbaZip;?>" maxlength="5" class="text_box" name="dbaZip">                        (5 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row">CUSTOMER SERVICE PHONE:</th>
                      <td><input type="text" id="MerchantCustomerServicePhone" value="<?php echo $customerServicePhone;?>" maxlength="12" onBlur="formatPhoneNumber('MerchantCustomerServicePhone')" class="text_box" name="customerServicePhone"></td>
                    </tr>
                    <tr>
                      <th scope="row">FAX # (Optional):</th>
                      <td><input type="text" id="MerchantBusinessFax" value="<?php echo $businessFax;?>" maxlength="255" class="text_box" name="businessFax"></td>
                    </tr><?php */?>
                    <tr>
                      <th scope="row">WEBSITE URL:</th>
                      <td><input type="text" id="MerchantMerchantURL" value="<?php echo $merchantURL;?>" maxlength="255" class="text_box" name="merchantURL"></td>
                    </tr>
                    <?php /*?><tr>
                      <th scope="row"><span class="validation_info">*</span>MONTHLY SALES VOLUME($):</th>
                      <td><input type="text" id="MerchantVolume" value="<?php echo $volume;?>" maxlength="255" class="text_box" name="volume"></td>
                    </tr>
                    <tr>
                      <th scope="row">ABOUT YOUR BUSINESS:</th>
                      <td>
                      <textarea rows="5" cols="29" wrap="hard" class="message_txtbox" name="detailExplanation" style="height:100px;"><?php echo $detailExplanation;?></textarea></td>
                    </tr><?php */?>
                    <tr>
                      <th scope="row">&nbsp;</th>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody></table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>			
            
			<div class="step_title">Owners/Officers</div>
            	
			<div class="step_inner mart25">
				<div class="product_search_indent">
					<div class="applicationform_bg">
					<?php /*?><span class="validation_info">&nbsp;***Total ownership percent must be equal or greater than 50% for saving data.</span><?php */?>
						<table style="width:95%;margin-bottom: 20px;" class="applicationform_table"  cellpadding="2" cellspacing="10">
					<tbody><tr>
						<td width="23%"><span class="validation_info">*</span>Name:<br>
						 </td>
						<td><input type="text" id="OwnerName1" value="<?php echo $name1;?>" class="text_box" name="name1">
                        </td>
					</tr>
					<tr>
						<td>
                        <span class="validation_info">*</span>SSN:<br>
						</td>
						<td><input type="text" id="OwnerSocialSecurityNumber1" value="<?php echo $socialSecurityNumber1;?>" maxlength="9" onBlur="formatSSNNumber('OwnerSocialSecurityNumber1')" class="text_box" name="socialSecurityNumber1"></td>
					</tr>					
					<tr>
						<td>Date of Birth:(MM/DD/YYYY)<br>
						</td>
						<td> <input type="text" id="OwnerDob1" value="<?php echo $dob1;?>" class="text_box" name="dob1"></td>
					</tr>
						
																		
					</tbody></table>
					
					
										
					</div>
				</div>
			</div>
            
           <div class="step_title">Products and Services Profile</div>
              
			<div class="step_inner mart25">
              <div class="product_search_indent">
              
                <div class="applicationform_bg">
                <span class="validation_info">&nbsp;</span>
                  <table style="width:95%" class="applicationform_table" cellpadding="2px;" cellspacing="7px">
                    <tbody><tr>
                      <td><span class="validation_info">*</span>Please estimate what your average monthly visa & mc volume will be:($)<br>
                       <input type="text" id="MerchanttransactionAvgMonVisaVolume" value="<?php echo $avgMonVisaVolume;?>" class="text_box" name="avgMonVisaVolume">
                      
                       </td>
                    </tr>
                    
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your average transaction size will be:($)<br>
                      <input type="text" id="MerchanttransactionAvgVisaTicket" value="<?php echo $avgVisaTicket;?>" class="text_box" name="avgVisaTicket">
                      
                      </td>
                    </tr>
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your maximum transaction size will be:($)<br>
                      <input type="text" id="MerchanttransactionHighestTicketAmount" value="<?php echo $highestTicketAmount;?>" class="text_box" name="highestTicketAmount"></td>
                    </tr>                   
                   <?php /*?> <tr>
                      <td> Do you currently accept Visa-MC at this or any other business?<br>
                        <input type="hidden" name="acceptCreditCard" id="MerchantAcceptCreditCard_" value="">
                     
                          <input type="radio" checked="" name="acceptCreditCard" id="MerchantAcceptCreditCardYes" value="yes" style="width: 20px;">
                          
                        
                        <label><strong>Yes</strong></label>
                        &nbsp;&nbsp;
                        
                          <input type="radio" name="acceptCreditCard" id="MerchantAcceptCreditCardNo" value="no" style="width: 20px;">
                      
                        <label><strong>No</strong></label></td>
                    </tr><?php */?>
               
                    <?php /*?><tr>
                      <td>Refund policy:<br>
                       <select id="MerchantDescribePolicy" class="text_box" style="width:320px;" name="describePolicy">
						<option value="All Sales Final"  <?php if($describePolicy=='All Sales Final'){?> selected="selected" <?php }?>>All Sales Final</option>
						<option value="7 Days" <?php if($describePolicy=='7 Days'){?> selected="selected" <?php }?>>7 Days</option>
						<option value="14 Days" <?php if($describePolicy=='14 Days'){?> selected="selected" <?php }?>>14 Days</option>
						<option value="21 Days" <?php if($describePolicy=='21 Days'){?> selected="selected" <?php }?>>21 Days</option>
						<option value="Upon Request" <?php if($describePolicy=='Upon Request'){?> selected="selected" <?php }?>>Upon Request</option>
						<option value="Upon Return of Product" <?php if($describePolicy=='Upon Return of Product'){?> selected="selected" <?php }?>>Upon Return of Product</option>
						<option value="Case-by-Case" <?php if($describePolicy=='Case-by-Case'){?> selected="selected" <?php }?>>Case-by-Case</option>
						<option value="Other" <?php if($describePolicy=='Other'){?> selected="selected" <?php }?>>Other</option>
						</select></td>
                    </tr><?php */?>
                  
                  </tbody></table>
                  
                  <table style="width:95%" class="applicationform_table"  cellpadding="2" cellspacing="10">
                  	<tbody>
                    <tr>
                    	<td colspan="2">Bank Information - Electronic Fund Transfer Authorization </td>
                    </tr>
                    <tr>
                  		<td colspan="2"><img title="Shopping Online" alt="Shopping Online" src="images/sample-cheque.jpg"></td>
                  	</tr>
                    <tr>
                      <td>
                      	<table width="100%" cellspacing="7" cellpadding="0" border="0">
                          <tr>
                          
                            <td>
                            <span class="validation_info">*</span>Account Holder Name:<br>
                             <input type="text" id="MerchantBankContact" value="<?php echo $bankContact;?>" maxlength="255" class="text_box" name="bankContact" ></td>
                            <td></td>
                          
                            <td>
                            <span class="validation_info">*</span>DDA/Account #:<br>
                            <input type="text" id="MerchantAccountNumber" value="<?php echo $accountNumber;?>" maxlength="255" class="text_box" name="accountNumber"  ></td>
                          </tr>
                          <tr>
                          
                            <td>
                            <span class="validation_info">*</span>ABA/Routing #:<br>
                            <input type="text" id="MerchantTransitNumber" value="<?php echo $transitNumber;?>" maxlength="9" class="text_box" name="transitNumber" ></td>
                          
                            <td></td>
                            <td>Account Type:<br>
                              <input type="hidden" name="bankAccountType" id="MerchantBankAccountType_" value="">
                              <input type="radio" checked="" name="bankAccountType" id="MerchantBankAccountTypeChecking" value="Checking" style="width: 20px;">
                               <label>Checking</label>
                              <input type="radio" name="bankAccountType" id="MerchantAccountTypeSaving" value="Saving" style="width: 20px;">
                            
                              <label>Savings(not preferred)</label>
                            
                            </td>
                          </tr>
                         </table>
                          
                      
                      </td>
                      <td></td>
                    </tr>
                  </tbody></table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
            
            
            
            
			 <div class="step_title">Upload Your Signature!</div>
			<div class="step_inner mart25">
              <div class="product_search_indent">
                
                <div class="applicationform_bg">
                 
                  <table class="applicationform_table" style="width:95%" cellspacing="7px">
                  <td>                     
                     <tr>
					  <td width="28%" align="left" class="rpadnone"><span class="validation_info">*</span>Print your name</td>
					  <td width="72%" align="left" valign="middle"><input type="text" name="name" id="name" class="name text_box" style="width:50%" value="<?php echo $name; ?>">
                      <br> <br>
                      </td>
					  </tr>
					  <tr>
					  	<td width="28%" align="left" valign="middle" class="rpadnone"  style="vertical-align:middle">Review your signature</td>
						<td width="72%" align="left" valign="middle"><ul class="sigNav" style="width:50%">
						  <li class="typeIt"><a href="#type-it" class="current">Type It</a></li>
						  <li class="drawIt"><a href="#draw-it" >Draw It</a></li>
						  <li class="clearButton"><a href="#clear">Clear</a></li>
						</ul>
						<div class="sig sigWrapper" style="width:235px">
						  <div class="typed"><?php echo $output; ?></div>
						  <canvas class="pad" width="235" height="55"><?php echo $output; ?></canvas>
						  <input type="hidden" name="output" class="output"  value="<?php echo $output; ?>">
						</div></td>
					  </tr>	
                      
                      <tr>
                    	<td>Enter Security Text!</td>
                        <td><input type="text" name="captcha_val" id="captcha_val" class="text_box" autocomplete="off" maxlength="20"></td>
                    </tr>
                    
                     <tr>
					  <td width="28%" align="left" class="rpadnone"><span class="validation_info">*</span>Security Text</td>
					  <td width="72%" align="left" valign="middle">
					  <table>
                      	<tr>
                        	<td></td>
                            
                        </tr>
                      </table>
                      	<img src="captcha.php" id="captcha" style="float:left;padding-bottom:10px"/><br/>
						<span style="cursor:pointer;float:left;" onClick="document.getElementById('captcha').src='captcha.php?'+Math.random();" id="change-image">Can't read? Change text.</span>
						</td>
					  </tr>	
                      
                      <tr>
                      	<td colspan="2" align="center">
                        	 <div class="form_button">
				<a href="javascript:void(0);" id="facebookimg"><img src="images/login-with-facebook.png" /></a>
			</div>		
            <br><br>
			<div class="form_button">
				<input name="" type="image" src="http://total-apps.net/merchant_full_api/images/submit.png" style="width:15%;border:none">
			</div>
			
                        </td>
                      </tr>
                                     
					</td>
                  </table>
                  
                  <div class="clear" style="height:60px;"></div>
                </div>
              </div>
            </div>	
            
            
            <div class="step_inner mart25">   
           <?php /*?> <div class="product_search_title">Enter Security Text!</div>  <?php */?>         
                      
                
                        
            </div>
            
            <br><br>
			
		</form>
    </div>  
</section>


</div>
</body>
</html>

<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.3.custom.min.css" />

<script src="js/oauthpopup.js"></script> 
<script>
 
 //(function(jQuery){
 jQuery(document).ready(function(){
	jQuery('#facebookimg').click(function(e){
		fbLogin();
		return false;
		
		//alert("ok");
		jQuery.oauthpopup({
			path: 'http://mojopay.com/fb-login.php',
			width:600,
			height:300,
			callback: function(){
				window.location.reload();
			}
		});
		e.preventDefault();
	});
 });
	  
//}); 
</script>