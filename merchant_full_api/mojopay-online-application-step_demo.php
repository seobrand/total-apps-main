<?php include 'mojopy_merchant_api_demo.php';?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Total Apps Merchant Full Api</title>


<link rel="stylesheet" href="build/jquery.signaturepad.css">
<link href="css/reset.css" rel="stylesheet" type="text/css" media="all">
<link href="css/styles.css" rel="stylesheet" type="text/css" media="all">
<link href="css/tablet_portrait.css" rel="stylesheet" type="text/css" media="screen and (min-width: 768px) and (max-width: 995px)">
<link href="css/mobile_portrait.css" rel="stylesheet" type="text/css" media="screen and (max-width: 480px)">
<link href="css/mobile_landscape.css" rel="stylesheet" type="text/css" media="screen and (min-width: 481px) and (max-width: 767px)">
<link href="css/jquery.fader.css" rel="stylesheet" type="text/css" media="all">
<link href="css/fonts.css" rel="stylesheet" type="text/css" media="all">
<link href="css/superfish.css" rel="stylesheet" type="text/css" media="screen">
<script src="js/functions_v2.js"></script>

<!--
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="js/datepicker-jquery-ui.js"></script> -->

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

  <!--[if lt IE 9]><script src="build/flashcanvas.js"></script><![endif]-->
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
			changeYear: true
		});
		jQuery("#OwnerDob1").datepicker({
			 changeMonth: true,
			 changeYear: true
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


/*{"id":"100004298611935","name":"David Brown","first_name":"David","last_name":"Brown","link":"https://www.facebook.com/profile.php?id=100004298611935","birthday":"02/03/1987","gender":"male","email":"seobranddevelopers@gmail.com","timezone":5.5,"locale":"en_US","verified":true,"updated_time":"2013-07-24T10:14:25+0000"}*/
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
  </style>
</head>
<body>

<div id="wrapper_outer">		
<section>
<div id="container_outer" style="background:none!important">
<!--strrt container_outer -->
<div id="container_inner">
	<div class="product_search_main">
		<form action="" method="post" class="sigPad" name="fullapi"  onSubmit="return validation(this)">
		<?php if($response!='' && $response=='Failure'){?>
			<p class="error"><?php echo $responseMessage;?></p>
		<?php }elseif($response=='Success'){?>
			<p class="success"><?php echo $responseMessage;?></p>
		<?php }?>
			<div class="application_form">
              <div class="product_search_indent">
                <div class="product_search_title">Business Profile</div>
                <div class="applicationform_bg">
                <span class="validation_info">&nbsp;* All fields marked with a red asterisk character are mandatory.</span>
                  <table class="applicationform_table">
                    <tbody>
						
					<!-- <tr>
                      <th scope="row"><span class="validation_info">*</span>LEGAL NAME:</th>
                      <td><input type="text" id="MerchantMerchantName" value="<?php echo $merchantName;?>" maxlength="255" class="input_01" name="merchantName"></td>
                    </tr> -->   
                      <tr>
                      <th scope="row"><span class="validation_info">*</span>LEGAL NAME:</th>
                      <td><input type="text" id="MerchantMerchantName" value="<?php echo $merchantName;?>" maxlength="255" class="input_01" name="merchantName"></td>
                    </tr>                 
                    <tr>
                      <th scope="row"> LEGAL ADDRESS: </th>
                      <td><input type="text" id="MerchantLegalAddress" value="<?php echo $legalAddress;?>" maxlength="500" class="input_01" name="legalAddress">(NO PO BOX)</td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL ADDRESS #2: </th>
                      <td><input type="text" id="MerchantLegalAddress2" class="input_01" name="legalAddress2" value="<?php echo $legalAddress2;?>"></td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL CITY: </th>
                      <td><input type="text" id="MerchantLegalCity" value="<?php echo $legalCity;?>" maxlength="200" class="input_01" name="legalCity"></td>
                    </tr>
                    <tr>
                      <th scope="row">LEGAL STATE:</th>
                      <td><select id="MerchantLegalState" class="select_01" name="legalState">
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
                      <td><input type="text" id="MerchantLegalZip" value="<?php echo $legalZip;?>" maxlength="5" class="input_01" name="legalZip">                        (5 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>BUSINESS PHONE:</th>
                      <td><input type="text" id="MerchantContactPhone" value="<?php echo $contactPhone;?>" maxlength="10" onBlur="formatPhoneNumber('MerchantContactPhone')" class="input_01" name="contactPhone"></td>
                    </tr>
                    <tr>
                      <th scope="row"> EIN or SSN Tax ID#:<br>
                        <span>(appears on income tax return)</span> </th>
                      <td><input type="text" id="MerchantFederalTaxId" value="<?php echo $federalTaxId;?>" maxlength="9" class="input_01" name="federalTaxId">(9 digits)</td>
                    </tr>
                    <!-- <tr>
                      <th scope="row">BUSINESS START DATE:</th>
                      <td><input type="text" id="MerchantStartDate" value="<?php echo $startDate;?>" maxlength="15" class="input_01" name="startDate">                        (mm/dd/yyyy)</td>
                    </tr> -->
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>PRIMARY EMAIL CONTACT:</th>
                      <td><input type="text" id="MerchantContactEmail" value="<?php echo $contactEmail;?>" maxlength="255" class="input_01" name="contactEmail"></td>
                    </tr> 
                    <tr>
                      <th scope="row">PRIMARY CONTACT NAME:</th>
                      <td><input type="text" id="MerchantContactName" value="<?php echo $contactName;?>" maxlength="255" class="input_01" name="contactName"></td>
                    </tr>                    
                    <!-- <tr>
                      <th scope="row">BUSINESS TYPE:</th>
                      <td><select class="select_01" id="merchantAccountCategory" name="accountCategory">
					      	<option value="1" <?php if($accountCategory=='1'){?> selected="selected" <?php }?>>Swipe</option>
							<option value="3" <?php if($accountCategory=='3'){?> selected="selected" <?php }?>>Internet</option>
							<option value="2" <?php if($accountCategory=='2'){?> selected="selected" <?php }?>>MOTO</option>	
							<option value="13" <?php if($accountCategory=='13'){?> selected="selected" <?php }?>>Kuapay</option>											        
					      </select>
						</td>
                    </tr> -->
                    
                    
                    <tr>
                      <th scope="row">BUSINESS CATEGORY:</th>
                      <td><select id="MerchantMerchantType" class="select_01" name="merchantType">
							<option value="">What type of business do you have?</option>
							<option value="5">Accountant</option>
							<option value="6">CPA</option>
							<option value="7">Bookkeepers</option>
							<option value="8">Car Dealers</option>
							<option value="9">Beauty Professionals</option>
							<option value="10">Builders &amp; Contractors</option>
							<option value="11">Christian Church &amp; Ministry</option>
							<option value="12">Computer &amp; Software Professionals </option>
							<option value="13">Cruise, Travel &amp; Vacation </option>
							<option value="14">Dentist </option>
							<option value="15">Engineer</option>
							<option value="16">Retail store</option>
							<option value="17">Whole sale industries</option>
							<option value="18">Petshop</option>
							<option value="19">Executives</option>
							<option value="20">Food &amp; Restaurant </option>
							<option value="21">Finance &amp; Money Professionals </option>
							<option value="22">Hauling</option>
							<option value="39">Fitness Centers &amp; Gym </option>
							<option value="23">Moving </option>
							<option value="24">Trucking</option>
							<option value="25">Health &amp; Wellness Professionals</option>
							<option value="26">Hotel &amp; Motel </option>
							<option value="27">HR Professionals </option>
							<option value="28">Insurance Agents &amp; Brokers</option>
							<option value="29">Interior Decorator &amp; Designer </option>
							<option value="30">IT Computer Professionals</option>
							<option value="31">Jewelers</option>
							<option value="32">k-12 Teachers </option>
							<option value="33">Marketing Executives</option>
							<option value="34">Mortgage Brokers</option>
							<option value="35">Bankers</option>
							<option value="36">Pharmacy</option>
							<option value="37">Physician</option>
							<option value="38">Real Estate Agents</option>
							
							<!-- <option value="Sole Proprietor" <?php if($merchantType=='Sole Proprietor'){?> selected="selected" <?php }?>>Sole Proprietor</option>
							<option value="Partnership" <?php if($merchantType=='Partnership'){?> selected="selected" <?php }?>>Partnership</option>
							<option value="Private Corp." <?php if($merchantType=='Private Corp.'){?> selected="selected" <?php }?>>Private Corp.</option>
							<option value="Tax Exempt" <?php if($merchantType=='Tax Exempt'){?> selected="selected" <?php }?>>Tax Exempt</option>
							<option value="LLC" <?php if($merchantType=='LLC'){?> selected="selected" <?php }?>>LLC</option> -->
							</select>
						</td>
                    </tr>
                   	<input type="hidden" id="referral" value="<?php if($_GET['RefID']!=""){ echo trim($_GET['RefID']); }?>" maxlength="10" class="input_01" name="referalID"></td>
                   <tr>
                      <th scope="row">&nbsp;</th>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody></table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
			<div class="application_form mart25">
              <div class="product_search_indent">
                <div class="product_search_title">Tell Us About Your Business!</div>
                <div class="applicationform_bg">
                  <table class="applicationform_table">
                    <tbody><tr>
                      <th scope="row"><span class="validation_info">*</span>DBA (name of company):</th>
                      <td><input type="text" id="MerchantMerchantDBA" value="<?php echo $merchantDBA;?>" maxlength="255" class="input_01" name="merchantDBA"><!-- <input type="checkbox" onclick="sameAsLegalInfo()" id="sameas">
                        same above --> </td>
                    </tr>
                    <!-- 
                    <tr>
                      <th scope="row"> DBA ADDRESS: </th>
                      <td><input type="text" id="MerchantDbaAddress" value="<?php echo $dbaAddress;?>" maxlength="500" class="input_01" name="dbaAddress">(NO PO BOX)</td>
                    </tr>
                    <tr>
                      <th scope="row"> DBA CITY: </th>
                      <td><input type="text" id="MerchantDbaCity" value="<?php echo $dbaCity;?>" maxlength="255" class="input_01" name="dbaCity"></td>
                    </tr>
                    <tr>
                      <th scope="row">DBA STATE:</th>
                      <td><select id="MerchantDbaState" class="select_01" name="dbaState">
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
                      <td><input type="text" id="MerchantDbaZip" value="<?php echo $dbaZip;?>" maxlength="5" class="input_01" name="dbaZip">                        (5 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row">CUSTOMER SERVICE PHONE:</th>
                      <td><input type="text" id="MerchantCustomerServicePhone" value="<?php echo $customerServicePhone;?>" maxlength="12" onBlur="formatPhoneNumber('MerchantCustomerServicePhone')" class="input_01" name="customerServicePhone"></td>
                    </tr>
                    <tr>
                      <th scope="row">FAX # (Optional):</th>
                      <td><input type="text" id="MerchantBusinessFax" value="<?php echo $businessFax;?>" maxlength="255" class="input_01" name="businessFax"></td>
                    </tr> -->
                    <tr>
                      <th scope="row">WEBSITE URL:</th>
                      <td><input type="text" id="MerchantMerchantURL" value="<?php echo $merchantURL;?>" maxlength="255" class="input_01" name="merchantURL"></td>
                    </tr>
                  <!--  <tr>
                      <th scope="row"><span class="validation_info">*</span>MONTHLY SALES VOLUME($):</th>
                      <td><input type="text" id="MerchantVolume" value="<?php echo $volume;?>" maxlength="255" class="input_01" name="volume"></td>
                    </tr>
                    <tr>
                      <th scope="row">ABOUT YOUR BUSINESS:</th>
                      <td>
                      <textarea rows="5" cols="29" wrap="hard" class="input_01" name="detailExplanation"><?php echo $detailExplanation;?></textarea></td>
                    </tr> -->
                    <tr>
                      <th scope="row">&nbsp;</th>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody></table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>		
			<div class="application_form mart25">
				<div class="product_search_indent">
					<div class="product_search_title">Owners/Officers</div>
					<div class="applicationform_bg">
					<!-- <span class="validation_info">&nbsp;***Total ownership percent must be equal or greater than 50% for saving data.</span> -->
						<table style="width:95%;margin-bottom: 20px;" class="applicationform_table">
					<tbody><tr>
						<td><span class="validation_info">*</span>Name:<br>
						 <input type="text" id="OwnerName1" value="<?php echo $name1;?>" class="input_01" name="name1"></td>
						<!-- <td><span class="validation_info">*</span>Title:(Owner,Pres.,CEO,etc.)<br>
						<input type="text" id="OwnerTitle1" value="<?php echo $title1;?>" class="input_01" name="title1"></td> -->
					</tr>
					<tr>
						<!-- <td><span class="validation_info">*</span>Owner ship %:<br>
						 <input type="text" id="OwnerOwnership1" value="<?php echo $ownership1;?>" maxlength="3" onKeyPress="return numbersonly(this, event)" class="input_01" name="ownership1">						</td> -->
						<td><span class="validation_info">*</span>SSN:<br>
						<input type="text" id="OwnerSocialSecurityNumber1" value="<?php echo $socialSecurityNumber1;?>" maxlength="9" onBlur="formatSSNNumber('OwnerSocialSecurityNumber1')" class="input_01" name="socialSecurityNumber1">						</td>
					</tr>					
						<!--<tr>
					 <td>Home address:<br>
						 <input type="text" id="OwnerHomeAddress1" value="<?php echo $homeAddress1;?>" class="input_01" name="homeAddress1">						</td> 
						<td>Home city:<br>
						<input type="text" id="OwnerCity1" value="<?php echo $city1;?>" class="input_01" name="city1"></td>
					</tr>
					<tr>
						<td>Home State:<br>
						<select id="OwnerState1" class="select_01" name="state1">
							<option value="">-Select State-</option>
							<option value="AL" <?php if($state1=='AL'){?> selected="selected" <?php }?>>Alabama</option>
							<option value="AK" <?php if($state1=='AK'){?> selected="selected" <?php }?>>Alaska</option>
							<option value="AZ" <?php if($state1=='AZ'){?> selected="selected" <?php }?>>Arizona</option>
							<option value="AR" <?php if($state1=='AR'){?> selected="selected" <?php }?>>Arkansas</option>
							<option value="CA" <?php if($state1=='CA'){?> selected="selected" <?php }?>>California</option>
							<option value="CO" <?php if($state1=='CO'){?> selected="selected" <?php }?>>Colorado</option>
							<option value="CT" <?php if($state1=='CT'){?> selected="selected" <?php }?>>Connecticut</option>
							<option value="DE" <?php if($state1=='DE'){?> selected="selected" <?php }?>>Delaware</option>
							<option value="DC" <?php if($state1=='DC'){?> selected="selected" <?php }?>>District of Columbia</option>
							<option value="FL" <?php if($state1=='FL'){?> selected="selected" <?php }?>>Florida</option>
							<option value="GA" <?php if($state1=='GA'){?> selected="selected" <?php }?>>Georgia</option>
							<option value="HI" <?php if($state1=='HI'){?> selected="selected" <?php }?>>Hawaii</option>
							<option value="ID" <?php if($state1=='ID'){?> selected="selected" <?php }?>>Idaho</option>
							<option value="IL" <?php if($state1=='IL'){?> selected="selected" <?php }?>>Illinois</option>
							<option value="IN" <?php if($state1=='IN'){?> selected="selected" <?php }?>>Indiana</option>
							<option value="IA" <?php if($state1=='IA'){?> selected="selected" <?php }?>>Iowa</option>
							<option value="KS" <?php if($state1=='KS'){?> selected="selected" <?php }?>>Kansas</option>
							<option value="KY" <?php if($state1=='KY'){?> selected="selected" <?php }?>>Kentucky</option>
							<option value="LA" <?php if($state1=='LA'){?> selected="selected" <?php }?>>Louisiana</option>
							<option value="ME" <?php if($state1=='ME'){?> selected="selected" <?php }?>>Maine</option>
							<option value="MD" <?php if($state1=='MD'){?> selected="selected" <?php }?>>Maryland</option>
							<option value="MA <?php if($state1=='MA'){?> selected="selected" <?php }?>>Massachusetts</option>
							<option value="MI <?php if($state1=='MI'){?> selected="selected" <?php }?>>Michigan</option>
							<option value="MN <?php if($state1=='MN'){?> selected="selected" <?php }?>>Minnesota</option>
							<option value="MS <?php if($state1=='MS'){?> selected="selected" <?php }?>>Mississippi</option>
							<option value="MO <?php if($state1=='MO'){?> selected="selected" <?php }?>>Missouri</option>
							<option value="MT <?php if($state1=='MT'){?> selected="selected" <?php }?>>Montana</option>
							<option value="NE <?php if($state1=='NE'){?> selected="selected" <?php }?>>Nebraska</option>
							<option value="NV <?php if($state1=='NV'){?> selected="selected" <?php }?>>Nevada</option>
							<option value="NH <?php if($state1=='NH'){?> selected="selected" <?php }?>>New Hampshire</option>
							<option value="NJ <?php if($state1=='NJ'){?> selected="selected" <?php }?>>New Jersey</option>
							<option value="NM <?php if($state1=='NM'){?> selected="selected" <?php }?>>New Mexico</option>
							<option value="NY <?php if($state1=='NY'){?> selected="selected" <?php }?>>New York</option>
							<option value="NC <?php if($state1=='NC'){?> selected="selected" <?php }?>>North Carolina</option>
							<option value="ND <?php if($state1=='ND'){?> selected="selected" <?php }?>>North Dakota</option>
							<option value="OH <?php if($state1=='OH'){?> selected="selected" <?php }?>>Ohio</option>
							<option value="OK <?php if($state1=='OK'){?> selected="selected" <?php }?>>Oklahoma</option>
							<option value="OR <?php if($state1=='OR'){?> selected="selected" <?php }?>>Oregon</option>
							<option value="PA <?php if($state1=='PA'){?> selected="selected" <?php }?>>Pennsylvania</option>
							<option value="RI <?php if($state1=='RI'){?> selected="selected" <?php }?>>Rhode Island</option>
							<option value="SC <?php if($state1=='SC'){?> selected="selected" <?php }?>>South Carolina</option>
							<option value="SD <?php if($state1=='SD'){?> selected="selected" <?php }?>>South Dakota</option>
							<option value="TN <?php if($state1=='TN'){?> selected="selected" <?php }?>>Tennessee</option>
							<option value="TX <?php if($state1=='TX'){?> selected="selected" <?php }?>>Texas</option>
							<option value="UT <?php if($state1=='UT'){?> selected="selected" <?php }?>>Utah</option>
							<option value="VT <?php if($state1=='VT'){?> selected="selected" <?php }?>>Vermont</option>
							<option value="VA <?php if($state1=='VA'){?> selected="selected" <?php }?>>Virginia</option>
							<option value="WA <?php if($state1=='WA'){?> selected="selected" <?php }?>>Washington</option>
							<option value="WV <?php if($state1=='WV'){?> selected="selected" <?php }?>>West Virginia</option>
							<option value="WI <?php if($state1=='WI'){?> selected="selected" <?php }?>>Wisconsin</option>
							<option value="WY <?php if($state1=='WY'){?> selected="selected" <?php }?>>Wyoming</option>
							</select></td>
						<td>Home zip:<br>
						<input type="text" id="OwnerZip1" value="<?php echo $zip1;?>" maxlength="5" class="input_01" name="zip1"></td> 
					</tr>-->
					<tr>
						<td>Date of Birth:(MM/DD/YYYY)<br>
						 <input type="text" id="OwnerDob1" value="<?php echo $dob1;?>" class="input_01" name="dob1"></td>
						<!-- <td><span class="validation_info">*</span>Home/Cell Phone:<br>
						<input type="text" id="OwnerHomePhone1" value="<?php echo $homePhone1;?>" maxlength="10" onBlur="formatPhoneNumber('OwnerHomePhone1')" onKeyPress="return numbersonly(this, event)" class="input_01" name="homePhone1"></td> -->
					</tr>
					<!-- <tr>
						<td><span class="validation_info">*</span>Driver's License #<br>
						 <input type="text" id="OwnerLicenceNumber1" value="<?php echo $licenceNumber1;?>" class="input_01" name="licenceNumber1">
						</td>						
					</tr> -->	
					<input id="OwnerCount" type="hidden" name="OwnerCount" value="0">
					<input id="OwnerElement" type="hidden" name="OwnerElement" value="0">														
					</tbody></table>
					<div class="clear"></div>
					<div style="display: block;" id="divTxt"></div>
					<!-- <a href="javascript:void(0);" onClick="addOwnerFormField()" style="margin:0 0 10px 10px;float:left;">Add Another Owner</a> -->
					<span style="margin:0 10px 0px 0px;float:right;" id="owner-remove"></span>					
					</div>
				</div>
			</div>
			<div class="application_form mart25">
              <div class="product_search_indent">
                <div class="product_search_title">Products and Services Profile</div>
                <div class="applicationform_bg">
                <span class="validation_info">&nbsp;</span>
                  <table style="width:95%" class="applicationform_table">
                    <tbody><tr>
                      <td><span class="validation_info">*</span>Please estimate what your average monthly visa & mc volume will be:($)<br>
                       <input type="text" id="MerchanttransactionAvgMonVisaVolume" value="<?php echo $avgMonVisaVolume;?>" class="input_01" name="avgMonVisaVolume"></td>
                    </tr>
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your average transaction size will be:($)<br>
                      <input type="text" id="MerchanttransactionAvgVisaTicket" value="<?php echo $avgVisaTicket;?>" class="input_01" name="avgVisaTicket"></td>
                    </tr>
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your maximum transaction size will be:($)<br>
                      <input type="text" id="MerchanttransactionHighestTicketAmount" value="<?php echo $highestTicketAmount;?>" class="input_01" name="highestTicketAmount"></td>
                    </tr>                   
                    <!--
                    <tr>
                      <td> Do you currently accept Visa-MC at this or any other business?<br>
                        <input type="hidden" name="acceptCreditCard" id="MerchantAcceptCreditCard_" value="">
                        <div class="small_col">
                          <input type="radio" checked="" name="acceptCreditCard" id="MerchantAcceptCreditCardYes" value="yes" style="width: 20px;">
                        </div>
                        <label><strong>Yes</strong></label>
                        &nbsp;&nbsp;
                        <div class="small_col">
                          <input type="radio" name="acceptCreditCard" id="MerchantAcceptCreditCardNo" value="no" style="width: 20px;">
                        </div>
                        <label><strong>No</strong></label></td>
                    </tr>
                    
                    <tr>
                      <td>Refund policy:<br>
                       <select id="MerchantDescribePolicy" class="select_01" name="describePolicy">
						<option value="All Sales Final"  <?php if($describePolicy=='All Sales Final'){?> selected="selected" <?php }?>>All Sales Final</option>
						<option value="7 Days" <?php if($describePolicy=='7 Days'){?> selected="selected" <?php }?>>7 Days</option>
						<option value="14 Days" <?php if($describePolicy=='14 Days'){?> selected="selected" <?php }?>>14 Days</option>
						<option value="21 Days" <?php if($describePolicy=='21 Days'){?> selected="selected" <?php }?>>21 Days</option>
						<option value="Upon Request" <?php if($describePolicy=='Upon Request'){?> selected="selected" <?php }?>>Upon Request</option>
						<option value="Upon Return of Product" <?php if($describePolicy=='Upon Return of Product'){?> selected="selected" <?php }?>>Upon Return of Product</option>
						<option value="Case-by-Case" <?php if($describePolicy=='Case-by-Case'){?> selected="selected" <?php }?>>Case-by-Case</option>
						<option value="Other" <?php if($describePolicy=='Other'){?> selected="selected" <?php }?>>Other</option>
						</select></td>
                    </tr>
                    -->
                  </tbody></table>
                  <div class="sub_title">Bank Information - Electronic Fund Transfer Authorization</div>
                  <table style="width:95%" class="applicationform_table">
                  	<tbody><tr>
                  		<td colspan="2"><img title="Shopping Online" alt="Shopping Online" src="images/sample-cheque.jpg"></td>
                  	</tr>
                    <tr>
                      <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tbody><tr>
                            <td> <span class="validation_info">*</span>Account Holder Name:<br>
                              <input type="text" id="MerchantBankContact" value="<?php echo $bankContact;?>" maxlength="255" class="input_01" name="bankContact"></td>
                          </tr>
                          <tr>
                            <td> <span class="validation_info">*</span>ABA/Routing #:<br>
                              <input type="text" id="MerchantTransitNumber" value="<?php echo $transitNumber;?>" maxlength="9" class="input_01" name="transitNumber"></td>
                          </tr>
                        </tbody></table></td>
                      <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tbody><tr>
                            <td> <span class="validation_info">*</span>DDA/Account #:<br>
                              <input type="text" id="MerchantAccountNumber" value="<?php echo $accountNumber;?>" maxlength="255" class="input_01" name="accountNumber"></td>
                          </tr>
                          <tr>
                            <td>Account Type:<br>
                              <input type="hidden" name="bankAccountType" id="MerchantBankAccountType_" value="">
                              <div class="small_col">
                                <input type="radio" checked="" name="bankAccountType" id="MerchantBankAccountTypeChecking" value="Checking" style="width: 20px;">
                              </div>
                              <label>Checking</label>
                              &nbsp;&nbsp;
                              <div class="small_col">
                                <input type="radio" name="bankAccountType" id="MerchantAccountTypeSaving" value="Saving" style="width: 20px;">
                              </div>
                              <label>Savings(not preferred)</label></td>
                          </tr>
                        </tbody></table></td>
                    </tr>
                  </tbody></table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
			<div class="application_form mart25">
              <div class="product_search_indent">
                <div class="product_search_title">Upload Your Signature!</div>
                <div class="applicationform_bg">
                  <table class="applicationform_table" style="width:95%">
                  <td>                     
                     <tr>
					  <td width="28%" align="left" class="rpadnone"><span class="validation_info">*</span>Print your name</td>
					  <td width="72%" align="left" valign="middle"><input type="text" name="name" id="name" class="name input_01" style="width:50%" value="<?php echo $name; ?>"></td>
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
					</td>
                  </table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>	
           <div class="form_button">
				<input name="" type="image" src="images/submit_bt.gif" style="width:15%;border:none">
			</div>
			<div class="clear mart25"></div>
			<div class="clear"></div>
			<div class="clear"></div>
		</form>
	</div>
	<div class="clear"></div>
</div>
<!--end of container_outer -->
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
