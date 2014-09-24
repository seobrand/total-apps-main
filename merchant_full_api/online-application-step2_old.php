<?php include 'merchant_full_api.php';?>
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
<script src="js/functions.js"></script>
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
  <!-- datepicker styles and js -->
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />	
  <script src="build/jquery.signaturepad.min.js"></script>
  <script>
  	jQuery.noConflict();
	jQuery(document).ready(function() {
	  jQuery('.sigPad').signaturePad();
	});
  </script>
  <script src="build/json2.min.js"></script>
</head>
<body>

<div id="wrapper_outer">		
<section>
<div id="container_outer">
<!--strrt container_outer -->
<div id="container_inner">
	<div class="product_search_main">
		<form action="" method="post" class="sigPad" name="fullapi" onsubmit="return validation(this)">
		<?php if($responseMessage!=''){?>
		<p class="error"><?php echo $responseMessage;?></p>
		<?php }?>
			<div class="application_form">
              <div class="product_search_indent">
                <div class="product_search_title">Business Profile</div>
                <div class="applicationform_bg">
                <span class="validation_info">&nbsp;* All fields marked with a red asterisk character are mandatory.</span>
                  <table class="applicationform_table">
                    <tbody><tr>
                      <th scope="row"><span class="validation_info">*</span>LEGAL NAME:</th>
                      <td><input type="text" id="MerchantMerchantName" value="" maxlength="255" class="input_01" name="merchantName"></td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL ADDRESS: </th>
                      <td><input type="text" id="MerchantLegalAddress" value="" maxlength="500" class="input_01" name="legalAddress">(NO PO BOX)</td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL ADDRESS #2: </th>
                      <td><input type="text" id="MerchantLegalAddress2" class="input_01" name="legalAddress2"></td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL CITY: </th>
                      <td><input type="text" id="MerchantLegalCity" value="" maxlength="200" class="input_01" name="legalCity"></td>
                    </tr>
                    <tr>
                      <th scope="row">LEGAL STATE:</th>
                      <td><select id="MerchantLegalState" class="select_01" name="legalState">
							<option value="">-Select State-</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
							</select></td>
                    </tr>
                    <tr>
                      <th scope="row">LEGAL ZIP:</th>
                      <td><input type="text" id="MerchantLegalZip" value="" maxlength="5" class="input_01" name="legalZip">                        (5 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>BUSINESS PHONE:</th>
                      <td><input type="text" id="MerchantContactPhone" value="" maxlength="12" onblur="formatPhoneNumber('MerchantContactPhone')" class="input_01" name="contactPhone"></td>
                    </tr>
                    <tr>
                      <th scope="row"> EIN or SSN Tax ID#:<br>
                        <span>(appears on income tax return)</span> </th>
                      <td><input type="text" id="MerchantFederalTaxId" value="" maxlength="9" class="input_01" name="federalTaxId">(9 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row">BUSINESS START DATE:</th>
                      <td><input type="text" id="MerchantStartDate" value="" maxlength="15" class="input_01" name="startDate">                        (mm/dd/yyyy)</td>
                    </tr>
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>PRIMARY EMAIL CONTACT:</th>
                      <td><input type="text" id="MerchantContactEmail" value="" maxlength="255" class="input_01" name="contactEmail"></td>
                    </tr> 
                    <tr>
                      <th scope="row">PRIMARY CONTACT NAME:</th>
                      <td><input type="text" id="MerchantContactName" value="" maxlength="255" class="input_01" name="contactName"></td>
                    </tr>                    
                   <tr>
                      <th scope="row">BUSINESS TYPE:</th>
                      <td><select class="select_01" id="merchantAccountCategory" name="accountCategory">
					      	<option value="1">Swipe</option>
							<option value="3">Internet</option>
							<option value="2">MOTO</option>
							<option value="8">USB Swipe</option>
							<option value="4">Mobile</option>
							<option value="7">Other</option>
							<option value="6">Gateway</option>
							<option value="5">Equipment</option>
							<option value="10">PSP</option>
							<option value="11">Gift Cards</option>
							<option value="12">ACH</option>					        
					      </select>
						</td>
                    </tr>
                    <tr>
                      <th scope="row">BUSINESS CATEGORY:</th>
                      <td><select id="MerchantMerchantType" class="select_01" name="merchantType">
							<option value="">-Select Business Category-</option>
							<option value="Sole Proprietor">Sole Proprietor</option>
							<option value="Partnership">Partnership</option>
							<option value="Private Corp.">Private Corp.</option>
							<option value="Tax Exempt">Tax Exempt</option>
							<option value="LLC">LLC</option>
							</select>
						</td>
                    </tr>
                    <tr>
                      <th scope="row">REFERRAL:</th>
                      <td><input type="text" id="referral" value="" maxlength="10" class="input_01" name="referalID"></td>
                    </tr>
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
                <div class="product_search_title">Tell Us About your Business!</div>
                <div class="applicationform_bg">
                  <table class="applicationform_table">
                    <tbody><tr>
                      <th scope="row"><span class="validation_info">*</span>DBA (name of company):</th>
                      <td><input type="text" id="MerchantMerchantDBA" value="" maxlength="255" class="input_01" name="merchantDBA"><!-- <input type="checkbox" onclick="sameAsLegalInfo()" id="sameas">
                        same above --> </td>
                    </tr>
                    <tr>
                      <th scope="row"> DBA ADDRESS: </th>
                      <td><input type="text" id="MerchantDbaAddress" value="" maxlength="500" class="input_01" name="dbaAddress">(NO PO BOX)</td>
                    </tr>
                    <tr>
                      <th scope="row"> DBA CITY: </th>
                      <td><input type="text" id="MerchantDbaCity" value="" maxlength="255" class="input_01" name="dbaCity"></td>
                    </tr>
                    <tr>
                      <th scope="row">DBA STATE:</th>
                      <td><select id="MerchantDbaState" class="select_01" name="dbaState">
						<option value="">-Select State-</option>
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
						</select></td>
                    </tr>
                    <tr>
                      <th scope="row">DBA ZIP:</th>
                      <td><input type="text" id="MerchantDbaZip" value="" maxlength="5" class="input_01" name="dbaZip">                        (5 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row">CUSTOMER SERVICE PHONE:</th>
                      <td><input type="text" id="MerchantCustomerServicePhone" value="" maxlength="12" onblur="formatPhoneNumber('MerchantCustomerServicePhone')" class="input_01" name="customerServicePhone"></td>
                    </tr>
                    <tr>
                      <th scope="row">FAX # (Optional):</th>
                      <td><input type="text" id="MerchantBusinessFax" value="" maxlength="255" class="input_01" name="businessFax"></td>
                    </tr>
                    <tr>
                      <th scope="row">WEBSITE URL:</th>
                      <td><input type="text" id="MerchantMerchantURL" value="" maxlength="255" class="input_01" name="merchantURL"></td>
                    </tr>
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>MONTHLY SALES VOLUME($):</th>
                      <td><input type="text" id="MerchantVolume" value="" maxlength="255" class="input_01" name="volume"></td>
                    </tr>
                    <tr>
                      <th scope="row">ABOUT YOUR BUSINESS:</th>
                      <td>
                      <textarea rows="5" cols="29" wrap="hard" class="input_01" name="detailExplanation"></textarea></td>
                    </tr>
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
					<span class="validation_info">&nbsp;***Total ownership percent must be equal or greater than 50% for saving data.</span>
						<table style="width:95%;margin-bottom: 20px;" class="applicationform_table">
					<tbody><tr>
						<td><span class="validation_info">*</span>Name:<br>
						 <input type="text" id="OwnerName1" value="" class="input_01" name="name1"></td>
						<td><span class="validation_info">*</span>Title:(Owner,Pres.,CEO,etc.)<br>
						<input type="text" id="OwnerTitle1" value="" class="input_01" name="title1"></td>
					</tr>
					<tr>
						<td><span class="validation_info">*</span>Owner ship %:<br>
						 <input type="text" id="OwnerOwnership1" value="" maxlength="3" onkeypress="return numbersonly(this, event)" class="input_01" name="ownership1">						</td>
						<td><span class="validation_info">*</span>SSN:<br>
						<input type="text" id="OwnerSocialSecurityNumber1" value="" maxlength="9" onblur="formatSSNNumber('OwnerSocialSecurityNumber1')" class="input_01" name="socialSecurityNumber1">						</td>
					</tr>					
					<tr>
						<td>Home address:<br>
						 <input type="text" id="OwnerHomeAddress1" value="" class="input_01" name="homeAddress1">						</td>
						<td>Home city:<br>
						<input type="text" id="OwnerCity1" value="" class="input_01" name="city1">						</td>
					</tr>
					<tr>
						<td>Home State:<br>
						<select id="OwnerState1" class="select_01" name="state1">
							<option value="">-Select State-</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
							</select></td>
						<td>Home zip:<br>
						<input type="text" id="OwnerZip1" value="" maxlength="5" class="input_01" name="zip1">						</td>
					</tr>
					<tr>
						<td>Date of Birth:(MM/DD/YYYY)<br>
						 <input type="text" id="OwnerDob1" value="" class="input_01" name="dob1">						</td>
						<td><span class="validation_info">*</span>Home/Cell Phone:<br>
						<input type="text" id="OwnerHomePhone1" value="" maxlength="10" onblur="formatPhoneNumber('OwnerHomePhone1')" onkeypress="return numbersonly(this, event)" class="input_01" name="homePhone1">						</td>
					</tr>
					<input id="OwnerCount" type="hidden" name="OwnerCount" value="1">
					<input id="OwnerElement" type="hidden" name="OwnerElement" value="1">														
					</tbody></table>
					<div class="clear"></div>
					<div style="display: block;" id="divTxt"></div>
					<a href="javascript:void(0);" onclick="addOwnerFormField()" style="margin:0 0 10px 10px;float:left;">Add Another Owner</a>
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
                      <td><span class="validation_info">*</span>Please estimate what your monthly sales volume will be:($)<br>
                       <input type="text" id="MerchanttransactionAvgMonVisaVolume" value="" class="input_01" name="avgMonVisaVolume">                      </td>
                    </tr>
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your average transaction size will be:($)<br>
                      <input type="text" id="MerchanttransactionAvgVisaTicket" value="" class="input_01" name="avgVisaTicket">                        </td>
                    </tr>
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your maximum transaction size will be:($)<br>
                      <input type="text" id="MerchanttransactionHighestTicketAmount" value="" class="input_01" name="highestTicketAmount">                        </td>
                    </tr>                   
                    <tr>
                      <td> Do you currently accept Visa-MC at this or any other business?<br>
                        <input type="hidden" name="acceptCreditCard" id="MerchantAcceptCreditCard_" value="">
                        <div class="small_col">
                          <input type="radio" checked="" name="acceptCreditCard" id="MerchantAcceptCreditCardYes" value="yes">
                        </div>
                        <label><strong>Yes</strong></label>
                        &nbsp;&nbsp;
                        <div class="small_col">
                          <input type="radio" name="acceptCreditCard" id="MerchantAcceptCreditCardNo" value="no">
                        </div>
                        <label><strong>No</strong></label></td>
                    </tr>
                    <tr>
                      <td>Refund policy:<br>
                       <select id="MerchantDescribePolicy" class="select_01" name="describePolicy">
						<option value="All Sales Final">All Sales Final</option>
						<option value="7 Days">7 Days</option>
						<option selected="selected" value="14 Days">14 Days</option>
						<option value="21 Days">21 Days</option>
						<option value="Upon Request">Upon Request</option>
						<option value="Upon Return of Product">Upon Return of Product</option>
						<option value="Case-by-Case">Case-by-Case</option>
						<option value="Other">Other</option>
						</select></td>
                    </tr>
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
                              <input type="text" id="MerchantBankContact" value="" maxlength="255" class="input_01" name="bankContact"></td>
                          </tr>
                          <tr>
                            <td> <span class="validation_info">*</span>ABA/Routing #:<br>
                              <input type="text" id="MerchantTransitNumber" value="" maxlength="255" class="input_01" name="transitNumber"></td>
                          </tr>
                        </tbody></table></td>
                      <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tbody><tr>
                            <td> <span class="validation_info">*</span>DDA/Account #:<br>
                              <input type="text" id="MerchantAccountNumber" value="" maxlength="255" class="input_01" name="accountNumber"></td>
                          </tr>
                          <tr>
                            <td>Account Type:<br>
                              <input type="hidden" name="bankAccountType" id="MerchantBankAccountType_" value="">
                              <div class="small_col">
                                <input type="radio" checked="" name="bankAccountType" id="MerchantBankAccountTypeChecking" value="Checking">
                              </div>
                              <label>Checking</label>
                              &nbsp;&nbsp;
                              <div class="small_col">
                                <input type="radio" name="bankAccountType" id="MerchantAccountTypeSaving" value="Saving">
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
					  <td width="72%" align="left" valign="middle"><input type="text" name="name" id="name" class="name input_01" style="width:50%"></td>
					  </tr>
					  <tr>
					  	<td width="28%" align="left" valign="middle" class="rpadnone"  style="vertical-align:middle">Review your signature</td>
						<td width="72%" align="left" valign="middle"><ul class="sigNav" style="width:50%">
						  <li class="typeIt"><a href="#type-it" class="current">Type It</a></li>
						  <li class="drawIt"><a href="#draw-it" >Draw It</a></li>
						  <li class="clearButton"><a href="#clear">Clear</a></li>
						</ul>
						<div class="sig sigWrapper" style="width:51%">
						  <div class="typed"></div>
						  <canvas class="pad" width="198" height="55"></canvas>
						  <input type="hidden" name="output" class="output">
						</div></td>
					  </tr>	               
					</td>
                  </table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>	
            <div class="application_form mart25">   
            <div class="product_search_title">Enter Security Text!</div>           
                <div class="applicationform_bg">
                  <table class="applicationform_table" style="width:95%">
                     <tr>
					  <td width="28%" align="left" class="rpadnone"><span class="validation_info">*</span>Security Text</td>
					  <td width="72%" align="left" valign="middle">
					  	<img src="captcha.php" id="captcha" style="float:left;padding-bottom:10px"/><br/>
						<span style="cursor:pointer;float:left;" onclick="document.getElementById('captcha').src='captcha.php?'+Math.random();" id="change-image">Can't read? Change text.</span>
						<input type="text" name="captcha_val" id="captcha_val" class="textbox01" autocomplete="off" maxlength="20"></td>
					  </tr>					  
                  </table>
                  <div class="clear"></div>
                </div>              
            </div>		
			<div class="form_button">
				<input name="" type="image" src="images/submit_bt.gif" style="width:15%;border:none">
			</div>
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
<script>
 $(function() {
    $("#MerchantStartDate").datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
 
  $(function() {
	    $("#OwnerDob1").datepicker({
	      changeMonth: true,
	      changeYear: true
	    });
	  });
  
</script>