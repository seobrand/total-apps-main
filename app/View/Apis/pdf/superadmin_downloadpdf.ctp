<?php 
//============================================================+
// File name   : Superadmin_downloadpdf.ctp
// Begin       : 2012-08-07
// Last Update : 2012-08-07
//
// Description : Merchant Pdf for Merchant Information
//
// Author: Jitendra Pradhan
//
// (c) Copyright:
//               Jitendra Pradhan
//               Sr. Web Developer
//               Planet Web Solution PVT. LTD
//               Jaipur
//               INDIA
//               www.planetwebsolution.com
//============================================================+

/**
 * Creates an PDF Which contain all the merchant information
 * @author Jitendra Pradhan
 * @since 2012-08-07
 */
//pr($this->request->data);die;
// set terminated date if it is blank
if($this->request->data['Merchant']['terminatedDate']!=''){
	//$terminateDate = date("F d, Y",strtotime($this->request->data['Merchant']['terminatedDate']));
	$terminateDate = date("m/d/Y",strtotime($this->request->data['Merchant']['terminatedDate']));
}else{
	$terminateDate = "";
}

if($this->request->data['Merchant']['merchantType']!=''){
	$merchantType = explode(",",$this->request->data['Merchant']['merchantType']);
}else{
	$merchantType = array();
}

if($this->request->data['Merchant']['monthNames']!=''){
	$monthNames = explode(",",$this->request->data['Merchant']['monthNames']);
}else{
	$monthNames = array();
}

if($this->request->data['Merchant']['advertiseMethod']!=''){
	$advertiseMethod = explode(",",$this->request->data['Merchant']['advertiseMethod']);
}else{
	$advertiseMethod = array();
}

$dbaName = $this->request->data['Merchant']['merchantDBA'];

$sign = $this->request->data['Merchant']['merchantSign'];
$signature = FULL_BASE_URL.Router::url('/')."files/Signature/".$sign;

$logo = FULL_BASE_URL.Router::url('/')."/img/logo-pdf.png";
//$size = getimagesize($signature);
// check for tired pricing checkbox
if($this->request->data['Rate']['visaDiscount']!='' && $this->request->data['Rate']['masterDiscount']!='' && $this->request->data['Rate']['discoverDiscount']!='' && $this->request->data['Rate']['checkDiscount']!='' && $this->request->data['Rate']['visaTransFee']!='' && $this->request->data['Rate']['masterTransFee']!='' && $this->request->data['Rate']['discoverTransFee']!='' && $this->request->data['Rate']['checkTransFee']!='' && $this->request->data['Rate']['amexTransFee']!='' && $this->request->data['Rate']['jcbTransFee']!='' && $this->request->data['Rate']['midQualDiscount']!='' && $this->request->data['Rate']['nonQualDiscount']){
	$check_tired_pricing	=	 "checked";
}else{
	$check_tired_pricing	=	 "";
}
// check for ERR rate checkbox
if($this->request->data['Rate']['visa_qualify_dis_rate']!='' && $this->request->data['Rate']['mc_qualify_dis_rate']!='' && $this->request->data['Rate']['discover_qualify_dis_rate']!='' && $this->request->data['Rate']['visa_non_qualify_fee']!='' && $this->request->data['Rate']['mc_non_qualify_fee']!='' && $this->request->data['Rate']['discover_non_qualify_fee']!='' && $this->request->data['Rate']['visa_authorization_fee']!='' && $this->request->data['Rate']['mc_authorization_fee']!='' && $this->request->data['Rate']['discover_authorization_fee']){
	$check_ERR_pricing	=	 "checked";
}else{
	$check_ERR_pricing	=	 "";
}

// task id 3357
$amexTransFee = ($this->request->data['Rate']['amexAccount']=='N/A Applied')? "________" : $this->request->data['Rate']['amexTransFee']; 
$amexAccountNumber = ($this->request->data['Rate']['amexAccount']=='Have Existing Account' && $this->request->data['Rate']['existAmexNumber']!='Enter Existing AMEX Number')? $this->request->data['Rate']['existAmexNumber'] : "&nbsp;___________________________&nbsp;";

?>
<style>
.mer_agr{text-align:center; display:block; margin:2px 0;}
</style>

<table width="100%" cellpadding="0" cellspacing="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;" >
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px; font-family:Arial, Helvetica, sans-serif; color:#333333; font-weight:bold;">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="background:#231f20; border-bottom:1px solid #696667; text-align:center; font-size:70%; color:#fff; font-weight:bold;">MERCHANT PROCESSING APPLICATION AND AGREEMENT</td>
  </tr>
  <tr>
    <td valign="top" align="center"><img src="<?php echo $logo;?>"></td>
  </tr>
  <tr>
    <td valign="top" align="right" style="font-size:9px; font-weight:bold; margin:0 0 3px 0;">Page 1 of 5</td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td>
    
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid #2c2829;">
  <tr>
    <td bgcolor="#000000" style="  border-bottom:1px solid #696667;">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%" align="center" bgcolor="#ffffff" style="font-size:9px; border-left:1px solid #333; border-top:1px solid #333; " >TotalApp1504(ia)</td>
    <td width="70%"  align="center" style="font-size:70%; color:#fff; font-weight:bold; line-height:13px; height:auto;">1. BUSINESS INFORMATION</td>
    <td width="15%" align="center" bgcolor="#ffffff" style="font-size:9px; border-right:1px solid #333; border-top:1px solid #333;">TotalApp1504(ia)</td>
  </tr>
</table>

    
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333333;">
  <tr>
    <td width="14%" height="30" align="left" style="float: left;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="15%" height="30" align="left"><input type="checkbox" <?php if(in_array("Sole Proprietor",$merchantType)){?> checked<?php }?>></td>
	    <td align="left" style="font-size:9px; font-weight:bold; padding:7px 0 2px 4px; ">Sole Proprietor</td>
	  </tr>
	</table>
	</td>
    <td width="15%" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="16%" height="30" align="left"  ><input type="checkbox" <?php if(in_array("Partnership",$merchantType)){?> checked<?php }?>></td>
	    <td align="left" style="font-size:9px; font-weight:bold; padding:2px 0 2px 5px; ">Partnership</td>
	  </tr>
	</table>
	</td>   
    <td width="14%" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="16%" height="30" align="left"  ><input type="checkbox" <?php if(in_array("Private Corp.",$merchantType)){?> checked<?php }?>></td>
	    <td align="left" style="font-size:9px; font-weight:bold; padding:7px 0 2px 4px; ">Private Corp.</td>
	  </tr>
	</table>
	</td>
    <td width="15%" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="16%" height="30" align="left"  ><input type="checkbox" <?php if(in_array("Tax Exempt",$merchantType)){?> checked<?php }?>></td>
	    <td align="left" style="font-size:9px; font-weight:bold; padding:2px 0 2px 4px; ">Tax Exempt</td>
	  </tr>
	</table>
	</td>
    <td width="10%" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="22%" height="30" align="left"  ><input type="checkbox" <?php if(in_array("LLC",$merchantType)){?> checked<?php }?>></td>
	    <td align="left" style="font-size:9px; font-weight:bold; padding:2px 0 2px 4px; ">LLC</td>
	  </tr>
	</table>
	</td> 
   <td width="22%" align="left" style="font-size:9px; font-weight:bold; padding:7px 0 2px 4px; float:left;">State Filed:&nbsp;<?php echo $this->request->data['Merchant']['incorporation'];?></td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333333;">
  <tr>
    <td width="50%" height="30" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Legal Name:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['merchantName'];?></span></td>
    <td width="50%" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%;  ">DBA Name:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['merchantDBA'];?></span></td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333333;">
  <tr>
    <td width="50%" height="30" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Legal Address:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['legalAddress'];?></span></td>
   <td width="50%" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; ">DBA Address:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['dbaAddress'];?></span></td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333333;">
  <tr>
    <td width="50%" valign="top" >
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" height="30" align="left" width="60%" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Legal City:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['legalCity'];?></span></td>
    <td valign="top" align="left" width="20%" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">State:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['legalState'];?></span></td>
    <td valign="top" align="left" width="20%" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">ZIP:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['legalZip'];?></span></td>
  </tr>
</table>
    </td>
    <td width="50%" valign="top" >
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" height="30" width="60%" align="left" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">DBA City:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['dbaCity'];?></span></td>
    <td valign="top" width="20%" align="left" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">State:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['dbaState'];?></span></td>
    <td valign="top" width="20%" align="left" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%;  ">ZIP:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['dbaZip'];?></span></td>
  </tr>
</table>
    </td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333333;">
  <tr>
    <td width="50%" height="30" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Contact Name:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['contactName'];?></span></td>
    <td width="50%" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; ">Contact E-Mail:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['contactEmail'];?></span></td>
  </tr>
</table>
    
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333333;">
  <tr>
    <td width="50%" valign="top">
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" height="30" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Business Phone:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['contactPhone'];?></span></td>
    <td width="50%" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Business Fax:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['businessFax'];?></span></td>
  </tr>
</table>

    
    </td>
    <td width="50%" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%;">Customer Service Phone:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['customerServicePhone'];?></span></td>
  </tr>
</table>
    
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333333;">
  <tr>
    <td width="50%" height="30" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Cardholder Descriptor: (21 Characters \96 Must Include Phone # if Keyed Merchant)<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['descriptor'];?></span></td>
    <td width="50%" valign="top" >
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="72%" height="30" valign="top" align="left" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Website URL:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['merchantURL'];?></span></td>
    <td width="28%" valign="top" align="left" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; ">Business Start Date:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['startDate'];?></span></td>
  </tr>
</table>

    </td>
  </tr>
</table>
    
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333333;">
  <tr>
    <td width="33%" height="30" valign="top" align="left" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">Name <span style="font-size:9px; font-weight:normal;">(legal name field)</span>:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['federalName'];?></span></td>
    <td width="33%" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">FEDERAL TAX ID # <span style="font-size:9px; font-weight:normal;">(as it appears on income tax return)</span>:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['federalTaxId'];?></span></td>
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" width="7%"><input name=""  type="checkbox" value=""></td>
    <td  valign="top" height="50" align="left" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%;  ">I certify that I am a foreign entity/nonresident alien.<br/>
<span style="font-size:9px; font-weight:normal;">(If checked, please attach IRS Form W-8.)</span></td>
  </tr>
</table>
    </td>
  </tr>
</table>
    
    </td>
  </tr>
  <tr>
    <td height="40" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-bottom:1px solid #333333; ">NOTE: <span style="font-size:9px; font-weight:normal;">Failure to provide accurate information may result in a withholding of merchant funding per IRS regulations. (See Part II, Section A3 of your Program Guide for further information.)</span></td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="10%" height="70" valign="top" align="left" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%; border-right:1px solid #333333; ">SIC /MCC:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['sicMCC'];?></span></td>
    <td width="90%" align="left" valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%;  ">Detailed Explanation of Type of Merchan dise, Products or Services Sold:<br><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['detailExplanation'];?></span></td>
  </tr>
</table>
    </td>
  </tr>
</table>

    
    </td>
  </tr>
  <tr>
    <td width="100%" bgcolor="#000000"  align="center" style="font-size:70%; color:#fff; font-weight:bold;">2. OWNERS / PARTNERS / OFFICERS</td>
  </tr>
  <?php foreach($OwnerData as $owner){?>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 2px 0;">
  <tr>
    <td style="border:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" height="30" width="40%"  style="font-size:9px; font-weight:bold;  border-right:1px solid #333333; padding:0.3% 0 0 0.5%; ">Name:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['name'];?></span></td>
    <td align="left" valign="top" width="40%"  style="font-size:9px; font-weight:bold;  border-right:1px solid #333333; padding:0.3% 0 0 0.5%; ">Title:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['title'];?></span></td>
    <td align="left"  valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%;  ">Equity/Ownership %:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['ownership'];?></span></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td style="border:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" height="30" width="40%"  style="font-size:9px; font-weight:bold;  border-right:1px solid #333333; padding:0.3% 0 0 0.5%; ">Date of Birth:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['dob'];?></span></td>
    <td align="left" valign="top" width="40%"  style="font-size:9px; font-weight:bold;  border-right:1px solid #333333; padding:0.3% 0 0 0.5%; ">Driver's License # / State:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['licenceNumber'];?></span></td>
    <td align="left"  valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%;  ">Social Security #:<br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['socialSecurityNumber'];?></span></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td style="border:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" height="30" width="40%"  style="font-size:9px; font-weight:bold;  border-right:1px solid #333333; padding:0.3% 0 0 0.5%; ">Home Address: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['homeAddress'];?></span></td>
    <td align="left" valign="top" width="40%"  >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" height="30" width="60%"  style="font-size:9px; font-weight:bold;  border-right:1px solid #333333; padding:0.3% 0 0 0.5%; ">City: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['city'];?></span></td>
    <td align="left" valign="top" width="20%"  style="font-size:9px; font-weight:bold;  border-right:1px solid #333333; padding:0.3% 0 0 0.5%; ">State: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['state'];?></span></td>
    <td align="left" valign="top"   style="font-size:9px; font-weight:bold;  border-right:1px solid #333333; padding:0.3% 0 0 0.5%; ">ZIP: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['zip'];?></span></td>
  </tr>
</table>

    </td>
    <td align="left"  valign="top" style="font-size:9px; font-weight:bold; padding:0.3% 0 0 0.5%;  ">Home Telephone: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $owner['Owner']['homePhone'];?></span></td>
  </tr>
</table>
</td>
  </tr>
</table>
    </td>
  </tr>
  <?php } // end of foreach ?>
   
  <tr>
    <td width="100%" bgcolor="#000000"  align="center" style="font-size:70%; color:#fff; font-weight:bold;">3. MERCHANT PROFILE</td>
  </tr>
  
  <tr>
    <td width="100%" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #333;" headers="10"> 
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top" height="20" width="50%" align="left" style="border-right:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" height="20" width="100%" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="77%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Do you currently accept Visa/MC/Discover\AE Network?</td>
    <td align="left" valign="top" width="33%" style="font-size:9px;"><?php echo $this->Form->radio('Merchant.acceptCreditCard', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;'));?></td>
  </tr>
</table>
    </td> 
  </tr> 
  <tr>
    <td valign="top" height="15" width="100%" align="left" style="font-size:9px; color:#000; font-weight:bold; padding:5px 0 0 5px;">
    If yes, you must submit 3 most current monthly statements.
    </td> 
  </tr>
</table>
    </td> 
    <td valign="top"  width="50%" align="left" style="border-right:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" height="15" width="100%" align="left" style="font-size:9px; color:#000; font-weight:bold; padding:5px 0 0 5px;">
    Has the business or any Associated Principal been terminated as a
    </td> 
  </tr>
  <tr>
    <td valign="top" height="30" width="100%" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="44%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Visa/MC/Discover Network Merchant?</td>
    <td valign="top" width="22%" align="left" style="font-size:9px; vertical-align:top; "><?php echo $this->Form->radio('Merchant.terminatedCreditCard', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
    <td align="left" valign="top" width="34%" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Provide date, if "Yes": <?php echo $terminateDate;?></td>
  </tr>
</table>
    </td> 
  </tr>
</table>
    </td> 
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="20%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Previously processed before?</td>
    <td align="left" valign="top"  style="font-size:9px; vertical-align:top; "><?php echo $this->Form->radio('Merchant.processBefore', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td valign="top" width="100%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">If yes, name of processor and reason for leaving: <?php echo $this->request->data['Merchant']['processorAndLeaveReason'];?></td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
  <tr>
    <td valign="middle" height="40" width="82%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Has Merchant or any Associated Principal disclosed above filed for bankruptcy or been subject to an involuntary bankruptcy?</td>
    <td align="left" valign="middle" width="18%" style="font-size:9px;  "><?php echo $this->Form->radio('Merchant.hasBankruptcy', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td valign="top" width="82%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Do you have a refund policy for Visa/MC/Discover Network? Is the refund policy in writing that is obvious to the cardholder/customer?</td>
    <td align="left" valign="top" width="18%" style="font-size:9px; vertical-align:top; "><?php echo $this->Form->radio('Merchant.hasRefundPolicy', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td valign="top" width="100%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Please describe refund policy: <?php echo $this->request->data['Merchant']['describePolicy'];?></td>
  </tr>
</table>

    
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td valign="top" width="82%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Do you use any third party to store, process or transmit cardholder data?</td>
    <td align="left" valign="top" width="18%" style="font-size:9px;"><?php echo $this->Form->radio('Merchant.hasThirdParty', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td valign="top" width="100%" align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Please identify any Software used for storing, transmitting or processing Card Transactions or Authorization requests: <?php echo $this->request->data['Merchant']['softwareUsed'];?></td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td valign="middle" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
  <tr>
<td   height="40" valign="middle"   align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">Seasonal?</td>
<td  valign="middle" width="12%"  align="left" style="font-size:9px;  "><?php echo $this->Form->radio('Merchant.hasSeasonal', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
<td  valign="middle" width="15%"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">If yes, indicate months:</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Jan",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">J&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Feb",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">F&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Mar",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">M&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Apr",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">A&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("May",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">M&nbsp;</td>
<td  valign="middle" width="2%"  align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Jun",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">J&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Jul",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">J&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Aug",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">A&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold;"><input type="checkbox" <?php if(in_array("Sep",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">S&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Oct",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">O&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Nov",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">N&nbsp;</td>
<td  valign="middle" width="2%" align="left" style="font-size:9px; color:#333333; font-weight:bold; "><input type="checkbox" <?php if(in_array("Dec",$monthNames)){?> checked<?php }?>></td>
<td  valign="middle"  align="left" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 5px; ">D&nbsp;</td>
   
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td style="border:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33%" valign="top" align="left" style="border-right:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td valign="top" align="center" colspan="2" height="10"  style="font-size:10px;" >Processing Volume for Visa/MC/Discover</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Average Monthly Volume:</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 ">$<?php echo $this->request->data['Merchanttransaction']['avgMonVisaVolume'];?></td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Average Ticket:</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 ">$<?php echo $this->request->data['Merchanttransaction']['avgVisaTicket'];?></td>
  </tr>
 <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Highest Ticket Amount:</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 ">$<?php echo $this->request->data['Merchanttransaction']['highestTicketAmount'];?></td>
  </tr>
</table>
    </td>
    <td width="33%" valign="top" align="left" style="border-right:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td valign="top" align="center" colspan="2" height="10" style="font-size:10px;"  >Where are Sales Transacted?</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Store Front / Face to Face</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 "><?php echo $this->request->data['Merchanttransaction']['storeFrontSwiped'];?>%</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Internet</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 "><?php echo $this->request->data['Merchanttransaction']['internet'];?>%</td>
  </tr>
 <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Mail Order</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 "><?php echo $this->request->data['Merchanttransaction']['mailOrder'];?>%</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Telephone Order</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 "><?php echo $this->request->data['Merchanttransaction']['telephoneOrder'];?>%</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Total Must Equal</td>
    <td valign="top" style="font-size:12px; color:#333333; font-weight:bold; padding:5px 0 0 0 ">100%</td>
  </tr>
</table>
    </td>
    <td width="33%" valign="top" align="left" >
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td valign="top" align="center" colspan="2" height="10" style="font-size:10px;">How are Transactions Completed?</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Electronic Data Capture (Swiped)</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 "><?php echo $this->request->data['Merchanttransaction']['electronicDataCapture'];?>%</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Manual Entry with Imprint</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 "><?php echo $this->request->data['Merchanttransaction']['manualEntryWithImpr'];?>%</td>
  </tr>
 <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Manual Entry, No Card Present</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 "><?php echo $this->request->data['Merchanttransaction']['onlyManualEntry'];?>%</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Voice Auth and Capture</td>
    <td valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 0 "><?php echo $this->request->data['Merchanttransaction']['voiceAuthCapture'];?>%</td>
  </tr>
  <tr>
    <td width="60%" valign="top" style="font-size:9px; color:#333333; font-weight:bold; padding:5px 0 0 20px ">Total Must Equal</td>
    <td valign="top" style="font-size:10px; color:#333333; font-weight:bold; padding:5px 0 0 0 ">100%</td>
  </tr>
</table>
    </td>
  </tr>
</table>
    </td>
  </tr>
</table>
    </td>
  </tr>
</table>
</td>
</tr>
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:30px 0 0 0;">
<tr>
<td width="65%" align="right" style="font-size:9px; color:#333;">Total Apps, Inc. is a registered ISO of Wells Fargo Bank, N.A., Walnut Creek, CA</td>
<td align="right" style="font-size:10px; color:#333;">Merchant Initials: <?php echo $this->request->data['Merchant']['name_initial'];?></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>


<tr>
<td>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;font-size:9px; ">
  <tr>
    <td>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 4px 0;">
        <tr>
          <td valign="top" align="left" width="50%"  style="font-size:9px;">DBA Name:  <?php if($dbaName!=''){ echo '<u>'.$dbaName.'</u>'; }else{ echo " _______________________________ "; }?></td>
          <td valign="top" align="left" width="40%" style="font-size:9px;">Merchant #: _______________________________</td>
          <td valign="top" align="right" style="font-size:9px; font-weight:bold;">Page 2 of 5</td>
        </tr>
      </table>
      
      </td>
  </tr>
  <tr>
    <td width="100%" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
        <tr>
          <th valign="top" bgcolor="#000" align="center"  > <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
              <tr>
                <td valign="top" width="20%" align="center" bgcolor="#fff" style="font-size:9px; color:#333; border:1px solid #000;">TotalApp1504(ia)</td>
                <td valign="top" align="center" bgcolor="#000" style="font-size:70%; color:#fff">3. MERCHANT PROFILE (cont'd)</td>
                <td valign="top" width="20%" align="center" bgcolor="#fff" style="font-size:9px; color:#333; border:1px solid #000;">TotalApp1504(ia)</td>
              </tr>
            </table>
          </th>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:5px; font-size:10px; color:#333;">Mail / Telephone Order / Business to Business Information (All Questions Must Be Answered by Keyed Type of Merchants)</td>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" width="62%" height="15" align="left" style="font-size:9px; color:#333;">What % of total sales represent Business to Business (vs Business to Consumer):</td>
                <td valign="top" width="10%" align="left" style="font-size:9px; color:#333;">B2B <?php echo $this->request->data['Merchant']['b2bOfTotalsale'];?>%</td>
                <td valign="top" width="2%" align="left" style="font-size:9px; color:#333;">+</td>
                <td valign="top" width="10%" align="left" style="font-size:9px; color:#333;">B2C <?php echo $this->request->data['Merchant']['b2cOfTotalsale'];?>%</td>
                <td valign="top" width="2%" align="left" style="font-size:9px; color:#333;">=</td>
                <td valign="top"  align="left" style="font-size:9px; color:#333;">100% (total sales)</td>
              </tr>
              <tr>
                <td valign="top" width="62%" align="left" style="font-size:9px; color:#333;">What % of bankcard sales represent Business to Business (vs Business to Consumer):</td>
                <td valign="top" width="10%" align="left" style="font-size:9px; color:#333;">B2B <?php echo $this->request->data['Merchant']['b2bOfbankcard'];?>%</td>
                <td valign="top" width="2%" align="left" style="font-size:9px; color:#333;">+</td>
                <td valign="top" width="10%" align="left" style="font-size:9px; color:#333;">B2C <?php echo $this->request->data['Merchant']['b2cOfbankcard'];?>%</td>
                <td valign="top" width="2%" align="left" style="font-size:9px; color:#333;">=</td>
                <td valign="top"  align="left" style="font-size:9px; color:#333;">100% (total sales)</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:5px 5px 0 5px; font-size:9px; color:#333;">What is the time frame from transaction to delivery? </td>
        </tr>
        <tr>
          <td width="100%" valign="top" style="padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"  width="30%" height="15" align="left" style="font-size:9px; color:#333;">(% of orders delivered in days):</td>
                <td valign="top" width="8%" align="left" style="font-size:9px; color:#333;">0-7&nbsp;&nbsp;<?php echo $this->request->data['Merchant']['deliveryTimeFrame1'];?>%</td>
                <td valign="top" width="2%" align="left" style="font-size:9px; color:#333;">+</td>
                <td valign="top" width="10%" align="left" style="font-size:9px; color:#333;">8-14&nbsp;&nbsp;<?php echo $this->request->data['Merchant']['deliveryTimeFrame2'];?>%</td>
                <td valign="top" width="2%" align="left" style="font-size:9px; color:#333;">+</td>
                <td valign="top" width="12%"  align="left" style="font-size:9px; color:#333;">15-30&nbsp;&nbsp;<?php echo $this->request->data['Merchant']['deliveryTimeFrame3'];?>%</td>
                <td valign="top" width="2%" align="left" style="font-size:9px; color:#333;">+</td>
                <td valign="top" width="18%" align="left" style="font-size:9px; color:#333;">over 30 days&nbsp;&nbsp;<?php echo $this->request->data['Merchant']['deliveryTimeFrame4'];?>%</td>
                <td valign="top" width="2%" align="left" style="font-size:9px; color:#333;">=</td>
                <td valign="top"  align="left" style="font-size:9px; color:#333;">100% delivered</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="middle" width="42%" style="font-size:9px; color:#333;" >Visa /MC/Discover Network/American Express OnePoint sales are deposited on (check one):</td>
                <td valign="top" align="left" width="38%" style="font-size:9px;"><?php echo $this->Form->radio('Merchant.ccDeposited', array('DoO' => 'Date of Order', 'DoD' => 'Date of Delivery','other'=>'Other'),array('legend' => false,'id'=>'ccCard','separator' => '&nbsp;'));?></td>
                <td valign="top" style="font-size:9px; color:#333;" >Other: <?php echo $this->request->data['Merchant']['ccDepositedOther'];?></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="middle" width="32%" style="font-size:9px; color:#333;" >Who performs product/service fulfillment?</td>
                <td valign="middle" align="left" width="68%" style="font-size:9px;"><?php echo $this->Form->radio('Merchant.productFullfillmentBy', array('direct' => 'Direct', 'vendor' => 'Vendor','other'=>'Other'),array('legend' => false,'separator' => '&nbsp;'));?> &nbsp;&nbsp; If vendor or third party is involved, provide the following:</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="100%" valign="top" style="font-size:9px; color:#333;"> Name/Address /Contact Phone #: <?php echo $this->request->data['Merchant']['vendorDetail'];?> </td>
        </tr>
        <tr>
          <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="middle" width="30%" style="font-size:9px; color:#333;" >Are customers required to leave a deposit?</td>
                <td valign="top" align="left" width="13%" style="font-size:9px;"><?php echo $this->Form->radio('Merchant.leaveDeposited', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
                <td valign="middle" width="28%" style="font-size:9px; color:#333;" >If Yes, % of deposit required: <?php echo $this->request->data['Merchant']['depositRquired'];?>%</td>
                <td valign="middle" style="font-size:9px; color:#333;" >Time Frame for Delivery: <?php echo $this->request->data['Merchant']['depositeTimeFrame'];?> days</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="middle" width="30%" style="font-size:9px; color:#333;" >Advertising Method(s) (check all that apply):</td>
                <td valign="top" align="left" width="3%" style="font-size:9px; color:#333;"><input type="checkbox" <?php if(in_array("Newspapers",$advertiseMethod)){?> checked<?php }?>></td>
                <td valign="middle" width="12%" style="font-size:9px; color:#333;" >Newspapers</td>
                <td valign="top" align="left" width="3%" style="font-size:9px; color:#333;"><input type="checkbox" <?php if(in_array("Magazines",$advertiseMethod)){?> checked<?php }?>></td>
                <td valign="middle" width="10%" style="font-size:9px; color:#333;" >Magazines</td>
                <td valign="top" align="left" width="3%" style="font-size:9px; color:#333;"><input type="checkbox" <?php if(in_array("Yellow Pages",$advertiseMethod)){?> checked<?php }?>></td>
                <td valign="middle" width="13%" style="font-size:9px; color:#333;" >Yellow Pages</td>
                <td valign="top" align="left" width="3%" style="font-size:9px; color:#333;"><input type="checkbox" <?php if(in_array("Radio / TV",$advertiseMethod)){?> checked<?php }?>></td>
                <td valign="middle" width="10%" style="font-size:9px; color:#333;" >Radio/TV</td>
                <td valign="top" align="left" width="3%" style="font-size:9px; color:#333;"><input type="checkbox" <?php if(in_array("Internet",$advertiseMethod)){?> checked<?php }?>></td>
                <td valign="middle" style="font-size:9px; color:#333;" >Internet</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="100%" valign="top" align="left" style="font-size:9px; color:#333;"><span style="font-size:12px;">REQUIRED:</span> Attach Marketing Materials for ALL MOTO, B2B and Internet Businesses (attach Web page printout) </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="100%" valign="top" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
        <tr>
          <th width="100%" align="center" valign="top" bgcolor="#000" style="font-size:70%; color:#fff; font-weight:bold;">4. TRADE REFERENCES</th>
        </tr>
        <tr>
          <td width="100%" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%" height="35" valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Trade Name: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['tradeName'];?></span></td>
                <td width="30%" valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Contact Name: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['tradeContactName'];?></span></td>
                <td valign="top" width="20%" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Telephone: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['tradePhone'];?></span></td>
              </tr>
              <tr>
                <td width="50%" height="35" valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Bank Name: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['bankName'];?></span></td>
                <td width="30%" valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Contact Name: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['bankContactName'];?></span></td>
                <td valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Telephone: <br/><span style="font-size:11px; font-weight:bold;"><?php echo $this->request->data['Merchant']['bankPhone'];?></span></td>
              </tr>
            </table></td>
        </tr>
        </table>
        </td>
        </tr>
        <tr>
          <td width="100%" valign="top" >
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
              <tr>
                <th width="100%" align="center" valign="top" bgcolor="#000" style="font-size:70%; font-weight:bold; color:#fff;">5. BANKING INFORMATION ***ATTACH A VOIDED CHECK FROM ACCOUNT***</th>
              </tr>
              <tr>
                <td width="100%" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50%" height="35" valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Bank Contact:<br/><span style="font-size:11px; font-weight:bold;"> <?php echo $this->request->data['Merchant']['bankContact'];?></span></td>
                      <td  valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Telephone:<br/><span style="font-size:11px; font-weight:bold;"> <?php echo $this->request->data['Merchant']['telephone'];?></span></td>
                    </tr>
                    <tr>
                      <td width="50%" height="35" valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Transit # (ABA Routing):<br/><span style="font-size:11px; font-weight:bold;"> <?php echo $this->request->data['Merchant']['transitNumber'];?></span></td>
                      <td valign="top" align="left" style="font-size:9px; color:#333; border:1px solid #333; padding:5px;">Account # (DDA):<br/><span style="font-size:11px; font-weight:bold;"> <?php echo $this->request->data['Merchant']['accountNumber'];?></span></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            </td>
        </tr>
        <tr>
          <td width="100%" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
              <tr>
                <th width="100%" align="center" valign="top" bgcolor="#000" style="font-size:70%; font-weight:bold; color:#fff;">6. MERCHANT SITE SURVEY (To be completed by sales representative)</th>
              </tr>
              <tr>
                <td width="100%" valign="top"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="top" width="50%" style="padding:2px; border:1px solid #333;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="100%" valign="top" align="left" style="font-size:9px; color:#333;">Business Location:</td>
                          </tr>
                          <tr>
                            <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top" align="left" width="60%" style="font-size:9px;">
                                  <?php echo $this->Form->radio('MerchantSiteSurvey.business_location', array('store front'=>'Store Front','office'=>'Office','home'=>'Home','other'=>'Other'),array('legend' => false,'separator' => '&nbsp;'));?>
                                  </td>
                                  <td valign="middle" align="left" style="font-size:9px; color:#333;">(specify) <?php echo $this->request->data['MerchantSiteSurvey']['business_loc_name']?></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                      <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="44%" valign="top" style="border-right:1px solid #333; padding:5px; border-bottom:1px solid #333;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100%" valign="top" style="font-size:9px; color:#333;">Approximate Size: (square footage)</td>
                                </tr>
                                <tr>
                                  <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td valign="top" align="left" width="100%" style="font-size:9px;">
                                        <?php echo $this->Form->radio('MerchantSiteSurvey.approximate_size', array('0-500'=>'0-500','501-2000'=>'501-2000','2000+'=>'2000+'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;'));?>
                                       </td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                            <td  valign="top" style="padding:5px; border-bottom:1px solid #333;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="100%" valign="top" style="font-size:9px; color:#333;">Zone:</td>
                                </tr>
                                <tr>
                                  <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td valign="top" align="left" width="100%" style="font-size:9px;">
                                        <?php echo $this->Form->radio('MerchantSiteSurvey.zone', array('commercial'=>'Commercial','industrial'=>'Industrial','residential'=>'Residential'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;'));?>
                                        </td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="100%" valign="top" style="border-bottom:1px solid #333;"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50%" valign="top" style="border-right:1px solid #333; padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td valign="top" align="left" style="font-size:9px; color:#333;">Does the name on the store front match the DBA name?</td>
                          </tr>
                          <tr>
                            <td valign="top" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top" align="left" width="26%"><?php echo $this->Form->radio('MerchantSiteSurvey.is_frontname_match_dbaname', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
                                  <td valign="middle" align="left" style="font-size:9px; color:#333;">Explain if No: <?php echo $this->request->data['MerchantSiteSurvey']['matching_reason']?></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                      <td  valign="top" style=" padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td valign="top" align="left" style="font-size:9px; color:#333;">Is inventory and merchandise displayed consistent with the type of business?</td>
                          </tr>
                          <tr>
                            <td valign="top" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top" align="left" width="26%"><?php echo $this->Form->radio('MerchantSiteSurvey.is_display_consistent', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;'));?></td>
                                  <td valign="middle" align="left" style="font-size:9px; color:#333;">Explain if No: <?php echo $this->request->data['MerchantSiteSurvey']['display_consist_reason']?></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="100%" valign="top"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="80%" style="border-right:1px solid #333; padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="40%" valign="middle" style="font-size:9px; color:#333;">Business Hours: <?php echo $this->request->data['MerchantSiteSurvey']['business_hours_from']?> to <?php echo $this->request->data['MerchantSiteSurvey']['business_hours_to']?></td>
                            <td width="14%" valign="middle" style="font-size:9px; color:#333;">Time Zone:</td>
                            <td width="46%" valign="top"><?php echo $this->Form->radio('MerchantSiteSurvey.timezone', array('pacific'=>'Pacific','eastern'=>'Eastern','central'=>'Central','mountain'=>'Mountain'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'));?></td>
                          </tr>
                        </table></td>
                      <td valign="middle" align="left" style="font-size:9px; color:#333; padding:5px;">Number of Employees: <?php echo $this->request->data['MerchantSiteSurvey']['number_of_employee'];?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="100%" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
              <tr>
                <th valign="top" bgcolor="#000" align="center" style="font-size:70%; font-weight:bold; color:#fff;">7. EQUIPMENT DETAILS</th>
              </tr>
              <tr>
                <td valign="top" width="100%"><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" width="20%" align="left" style="font-size:9px; color:#333;">Terminal Provided By:</td>
                      <td valign="middle" width="4%" align="left"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" width="13%" align="left" style="font-size:9px; color:#333;">Total-Apps</td>
                      <td valign="middle" width="4%" align="left"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" width="10%" align="left" style="font-size:9px; color:#333;">Merchant</td>
                      <td valign="middle" width="4%" align="left"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" width="8%" align="left" style="font-size:9px; color:#333;">Agent</td>
                      <td valign="middle" width="11%" align="left" style="font-size:9px; color:#333;">Ship To:</td>
                      <td valign="middle" width="4%" align="left"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" width="12%" align="left" style="font-size:9px; color:#333;">Merchant</td>
                      <td valign="middle" width="4%" align="left"><input name="" type="checkbox" value=""></td>
                      <td valign="middle"  align="left" style="font-size:9px; color:#333;">Agent</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td valign="top" width="100%" style="border-bottom:1px solid #333;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" align="left" width="28%" style="font-size:9px; color:#333;">Total-Apps To Build Terminal Download File?</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="3%" style="font-size:9px; color:#333;">Yes</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="3%" style="font-size:9px; color:#333;">No</td>
                      <td valign="middle" align="left" width="17%" style="font-size:9px; color:#333;">Build State Only File?</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="3%" style="font-size:9px; color:#333;">Yes</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="3%" style="font-size:9px; color:#333;">No</td>
                      <td valign="middle" align="left" width="17%" style="font-size:9px; color:#333;">Agent to Conduct Training?</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="3%" style="font-size:9px; color:#333;">Yes</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left"  style="font-size:9px; color:#333;">No</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td valign="top" width="100%" style="border-bottom:1px solid #333;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="38%" valign="top" style="border-right:1px solid #333; padding:5px;">
                      
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="100%" valign="top" align="left" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="10%" valign="top" ><input name="" type="checkbox" value=""></td>
                                  <td valign="middle" align="left" style="font-size:9px; color:#333;">RE-PROGRAM (please indicate terminal model)</td>
                                </tr>
                              </table>
                              </td>
                          </tr>
                          <tr>
                            <td valign="top" height="15" align="left"  style="font-size:9px; color:#333;" >Terminal Model_______________________Qty__________</td>
                          </tr>
                          <tr>
                            <td valign="top" height="15" align="left" style="font-size:9px; color:#333;" >Gateway Type________________________Qty__________</td>
                          </tr>
                          <tr>
                            <td valign="top" height="15" align="left" style="font-size:9px; color:#333;" >Software Model_______________________Qty__________</td>
                          </tr>

                        </table></td>
                      <td width="32%" valign="top" style="border-right:1px solid #333; padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td valign="top" align="left" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="10%" valign="top" >&nbsp;</td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr>
                            <td valign="top" height="15" align="left" style="font-size:9px; color:#333;" >PIN Pad_______________________Qty__________</td>
                          </tr>
                          <tr>
                            <td valign="top" height="15" align="left" style="font-size:9px; color:#333;" >Check Reader__________________Qty__________</td>
                          </tr>
                          <tr>
                            <td valign="top" height="15" align="left" style="font-size:9px; color:#333;" >Printer Model__________________Qty__________</td>
                          </tr>
                        </table></td>
                      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top" align="left" width="9%"><input name="" type="checkbox" value="">&nbsp;</td>
                                  <td valign="top" align="left" style="font-size:9px; color:#333;padding-top:5px;">Ship Welcome Kit Only&nbsp;</td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="7%" valign="top" align="left"><input name="" type="checkbox" value=""></td>
                                  <td width="16%" valign="middle" align="left" style="font-size:9px; color:#333;">Call for:</td>
                                  <td width="7%" valign="top" align="left"><input name="" type="checkbox" value=""></td>
                                  <td width="19%" valign="middle" align="left" style="font-size:9px; color:#333;">Download</td>
                                  <td width="7%" valign="top" align="left"><input name="" type="checkbox" value=""></td>
                                  <td width="17%" valign="middle" align="left" style="font-size:9px; color:#333;">Training</td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr>
                            <td valign="middle" height="22" width="100%" align="left" style="font-size:9px; color:#333;">Contact: _____________________________</td>
                          </tr>
                          <tr>
                            <td valign="top" width="100%" height="22" align="left" style="font-size:9px; color:#333;">Telephone #:_____________________________</td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td valign="top" width="100%" style="padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" width="60%" align="left" style="font-size:9px; color:#333;"><span style="font-size:12px;" >TERMINAL PROGRAMMING:</span> Is there an existing Manual Imprinter at this location?</td>
                      <td valign="top" width="3%" align="left"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" width="5%" align="left" style="font-size:9px; color:#333;">Yes</td>
                      <td valign="top" width="3%" align="left"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" style="font-size:9px; color:#333;">No</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td valign="top" width="100%" style="padding:5px; font-size:9px; color:#333;">Merchant acknowledges that an imprinter is required for any non-swiped transactions. </td>
              </tr>
              <tr>
                <td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="8%" style="font-size:9px; color:#333;">Gift Cards</td>
                      <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="8%" style="font-size:9px; color:#333;">Wireless</td>
                      <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="12%" style="font-size:9px; color:#333;">Purchase Cards</td>
                      <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="14%" style="font-size:9px; color:#333;">Retail (80% swiped)</td>
                      <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="12%" style="font-size:9px; color:#333;">Retail (with tips)</td>
                      <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" width="15%" style="font-size:9px; color:#333;">Restaurant (with tips)</td>
                      <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left"  style="font-size:9px; color:#333;">Petroleum</td>
                    </tr>
                    <tr>
                      <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left"  style="font-size:9px; color:#333;">Lodging</td>
                      <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" style="font-size:9px; color:#333;">MOTO</td>
                      <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" colspan="3" align="left" width="12%" style="font-size:9px; color:#333;">Address Verification service (AVS)</td>
                      <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left"  style="font-size:9px; color:#333;">4 Digit Verification</td>
                      <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left"  style="font-size:9px; color:#333;">Invoice #</td>
                      <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left"  style="font-size:9px; color:#333;">Server ID</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="100%" valign="top" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="middle" width="15%" align="left" style="font-size:9px; color:#333;" >Dial Out Code:</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" width="18%" align="left" style="font-size:9px; color:#333;" >"___________________"</td>
                      <td valign="middle" width="20%" align="left" style="font-size:9px; color:#333;" >Auto Batch Closing&nbsp; Time:</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" width="20%" align="left" style="font-size:9px; color:#333;" >Default 9:00 PM</td>
                      <td valign="top" width="3%" align="left" ><input name="" type="checkbox" value=""></td>
                      <td valign="middle" align="left" style="font-size:9px; color:#333;" >Other: "__________________"</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; border:1px solid #333;">
  <tr>
    <th valign="top" align="center" bgcolor="#000" style="font-size:70%; font-weight:bold; color:#fff;">8. VISA /MASTERCARD ACCEPTANCE</th>
  </tr>
  <tr>
    <td width="100%" valign="top"><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" align="center" style="font-size:11px; color:#333;">Accept all MasterCard, Visa and Discover Network Transactions <span style="font-size:9px;"> (presumed, unless any selections below are checked)</span></td>
        </tr>
        <tr>
          <td valign="top" align="center" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left" width="28%" style="font-size:9px; color:#333;">Accept MC Credit Transactions ONLY</td>
                <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left" width="28%" style="font-size:9px; color:#333;">Accept Visa Credit Transactions ONLY</td>
                <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left"  style="font-size:9px; color:#333;">Accept Discover Network Credit Transactions ONLY</td>
              </tr>
              <tr>
                <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left"  style="font-size:9px; color:#333;">Accept MC Non-PIN Debit Transactions ONLY</td>
                <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left"  style="font-size:9px; color:#333;">Accept Visa Non-PIN Debit Transactions ONLY</td>
                <td valign="top" align="left" ><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left"  style="font-size:9px; color:#333;">Accept Discover Network Non-PIN Debit Transactions ONLY</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; border:1px solid #333;">
  <tr>
    <th valign="top" align="center" bgcolor="#000" style="font-size:70%; font-weight:bold; color:#fff;">9. JCB ACCEPTANCE</th>
  </tr>
  <tr>
    <td width="100%" valign="top" style="padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>


          <td valign="top" width="100%" style="font-size:9px; color:#333; line-height:18px;">Discount Rate: _____________ By signing below, I (we) represent that all of the information contained on this application is true and complete. I (we) understand that the
            JCB Card Acceptance Terms and Conditions will be sent to the address above with a welcome letter upon approval by JCB. I (we) agree to be bound by he JCB Card Acceptance
            Terms and Conditions for accepting the JCB Card for purchases of goods or other services.</td>
        </tr>
        <tr>
          <td valign="top" width="100%" style="font-size:12px; color:#333; padding:7px 0 0 0;">AGREED AND ACCEPTED: JCB Acceptance</td>
        </tr>
        <tr>
          <td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="middle" align="left" width="65%" style="font-size:9px; color:#333;">Signature _______________________________________________________________</td>
                <td width="4%" valign="top"><input name="" type="checkbox" value="" /></td>
                <td valign="middle" align="left"  style="font-size:9px; color:#333;">Existing JCB #: ___________________________</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; border:1px solid #333;">
  <tr>
    <th valign="top" align="center" bgcolor="#000" style="font-size:70%; font-weight:bold; color:#fff;">10. ADDED SERVICE ENROLLMENT</th>
  </tr>
  <tr>
    <td width="100%" valign="top"><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" align="center" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left" width="35%" style="font-size:9px; color:#333;">American Express (Please see Section 11)</td>
                <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left" colspan="3" style="font-size:9px; color:#333;">Merchant Cash Advance (Requires separate Third-party paperwork)</td>

              </tr>
              <tr>
                <td valign="top" align="left" width="3%"><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left" width="35%"  style="font-size:9px; color:#333;">Gift Card Services (Requires separate Third-party paperwork)</td>
                <td valign="top" align="left" width="3%" ><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left" width="27%"  style="font-size:9px; color:#333;">PIN Debit Cards (Please see page 3)</td>
                <td valign="top" align="left" width="3%" ><input name="" type="checkbox" value=""></td>
                <td valign="middle" align="left"  style="font-size:9px; color:#333;">Petroleum Services (Please see page 3)</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</td>
</tr>
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:50px 0 0 0;">
<tr>
<td width="65%" align="right" style="font-size:9px; color:#333;">Total Apps, Inc. is a registered ISO of Wells Fargo Bank, N.A., Walnut Creek, CA</td>
<td align="right" style="font-size:10px; color:#333;">Merchant Initials: <?php echo $this->request->data['Merchant']['name_initial'];?></td>
</tr>
</table>
</td>
</tr>
</table>


</td>
</tr>


<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 7px 0;">
        <tr>
          <td valign="top" align="left" width="50%"  style="font-size:9px;">DBA Name: <?php if($dbaName!=''){ echo '<u>'.$dbaName.'</u>'; }else{ echo " _______________________________ "; }?></td>
          <td valign="top" align="left" width="40%" style="font-size:9px;">Merchant #: _______________________________</td>
          <td valign="top" align="right" style="font-size:9px; font-weight:bold;">Page 3 of 5</td>
        </tr>
      </table>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:0px; border:1px solid #000; font-family:Arial, Helvetica, sans-serif;">
<!--th start-->



<tr>
<th align="center" style=" background:#000; font-size:70%; font-weight:bold; color:#fff;">11. SCHEDULE OF CHARGES</th>
</tr>
<!--th end-->

<tr>
<td align="left" valign="top" width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="left" width="33%" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="100%" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="10%" align="left"><input type="checkbox" <?php if($this->request->data['Rate']['interchangePlus']!='' && $this->request->data['Rate']['interchangePerItem']!=''){?> checked <?php }?>></td>
    <td valign="middle" align="left" style="font-size:9px; color:#333333; ">Interchange/Cost Plus: <?php echo $this->request->data['Rate']['interchangePlus']?>% + $<?php echo $this->request->data['Rate']['interchangePerItem']?> </td>
  </tr>	  
  <tr>
    <td valign="top" align="left" width="10%"><input type="checkbox" <?php echo $check_tired_pricing;?>></td>
    <td valign="middle" align="left" style="font-size:9px; color:#333333; ">Tiered Pricing: (Default if below is completed)</td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
  <td height="10"></td>
  </tr>
  <tr>
    <td valign="top" width="100%"  >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" height="30" align="center" width="25%">&nbsp;</td>
    <td valign="top" align="center" width="25%" style="font-size:11px; color:#333; font-weight:bold;">Checkcard Rate</td>
    <td valign="top" align="center" width="25%" style="font-size:11px; color:#333; font-weight:bold;">Credit Rate</td>
    <td valign="top" align="center" style="font-size:11px; color:#333; font-weight:bold;">Trans Fee</td>
  </tr>
  <tr>
    <td valign="top" height="40" align="left" style="font-size:9px; color:#333;" >&nbsp;Visa:</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;"><?php echo $this->request->data['Rate']['checkDiscount']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;"><?php echo $this->request->data['Rate']['visaDiscount']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['visaTransFee']?></td>
  </tr>
  <tr>
    <td valign="top" height="40" align="left" style="font-size:9px; color:#333;" >&nbsp;MasterCard:</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;"><?php echo $this->request->data['Rate']['checkDiscount']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;"><?php echo $this->request->data['Rate']['masterDiscount']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['masterTransFee']?></td>
  </tr>
  <tr>
    <td valign="top" height="40" align="left" style="font-size:9px; color:#333;" >&nbsp;Discover:</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;"><?php echo $this->request->data['Rate']['checkDiscount']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;"><?php echo $this->request->data['Rate']['discoverDiscount']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['discoverTransFee']?></td>
  </tr>
  <tr>
    <td valign="top" colspan="4" height="20" align="left" style="font-size:9px; color:#333;" >&nbsp;American Express #:</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" height="20" align="left" style="font-size:9px; color:#333;" >&nbsp;<?php echo $amexAccountNumber; ?></td>
     <td valign="top" align="center" style="font-size:9px; color:#333;">$<?php echo $amexTransFee;?>&nbsp;</td>
  </tr>
</table>
    </td>
  </tr>
   <tr>
    <td valign="top" width="100%"  >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="10%" align="left"><input name="" type="checkbox" value="" <?php if($this->request->data['Rate']['amexAccount']=='New Account'){?>checked<?php }?>></td>
    <td valign="middle" align="left" style="font-size:9px; color:#333333; ">Apply for American Express</td>
  </tr>
</table>
    </td>
  </tr>
  
</table>

</td>


<td width="28%" align="left" valign="top" style="border-right:1px solid #333; border-left:1px solid #333; font-family:Arial, Helvetica, sans-serif; ">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">AVS Voice Authorization</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333;">$<?php echo $this->request->data['Rate']['avsVoiceAuthFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">VRU &amp; ARU Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; ">$<?php echo $this->request->data['Rate']['vru_aru_fee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Voice Authorization Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; ">$<?php echo $this->request->data['Rate']['voiceAuthFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Chargeback Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333;">$<?php echo $this->request->data['Rate']['chargebackFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Retrieval Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; ">$<?php echo $this->request->data['Rate']['retrievalReqFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">ACH/Batch Settlement</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333;">$<?php echo $this->request->data['Rate']['achBatchFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">AVS Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333;">$<?php echo $this->request->data['Rate']['electronicAvsFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Monthly Minimum Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333;">$<?php echo $this->request->data['Rate']['monthlyMinFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Service/Statement Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; ">$<?php echo $this->request->data['Rate']['statementFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Merchant Club</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333;">$<?php echo $this->request->data['Rate']['merchantClubFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Application Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333;">$<?php echo $this->request->data['Rate']['applicationFee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Monthly Maintenance Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; ">$<?php echo $this->request->data['Rate']['monthly_maintenance_fee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333; border-right:1px solid #333;">Online Reporting Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333; border-bottom:1px solid #333;">$<?php echo $this->request->data['Rate']['online_reporting_fee']?></td>
</tr>
<tr>
<td width="70%" height="21" align="left" valign="middle" style="font-size:9px; color:#333;  border-right:1px solid #333;">Regulatory Bundle Fee</td>
<td align="left" valign="middle" style="font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['regulatory_bundle_fee']?></td>
</tr>
</table>
</td>


<td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="border-bottom:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80%" valign="top" style="border-right:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="middle" width="50%" style="font-size:9px; color:#333; ">PCI Compliance Fee</td>
    <td valign="top" style="font-size:9px;"><?php echo $this->Form->radio('Rate.pci_compliance_fee_type', array('yearly' => 'Annual', 'monthly' => 'Monthly'),array('legend' => false,'separator' => '&nbsp;'));?></td>
  </tr>
</table>

    </td>
    <td valign="middle" align="left" style="font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['pci_compliance_fee']?></td>
  </tr>
</table>

    </td>
  </tr>
  
 <tr>
    <td valign="middle" style="border-bottom:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80%" height="22" valign="middle" style="border-right:1px solid #333; font-size:9px; color:#333;">Early Termination Fee (One Time Fee)</td>
    <td valign="middle" align="left" style="font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['early_termination_fee']?></td>
  </tr>
</table>

    </td>
  </tr>
  
  <tr>
    <td valign="middle" style="border-bottom:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80%" height="22" valign="middle" style="border-right:1px solid #333; font-size:9px; color:#333;">EIDS Chargeback/Retrieval Online Tool</td>
    <td valign="middle" align="left" style="font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['eids_chargeback_retrieval_online_tool_fee']?></td>
  </tr>
</table>

    </td>
  </tr>
  
  <tr>
    <td valign="middle" style="border-bottom:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80%" height="22" valign="middle" style="border-right:1px solid #333; font-size:9px; color:#333;">Other Fee<?php if($this->request->data['Rate']['otherFeeName1']!=''){ echo "(".$this->request->data['Rate']['otherFeeName1'].")"; }?></td>
    <td valign="middle" align="left" style="font-size:9px; color:#333;">$<?php if($this->request->data['Rate']['otherFeeValue1']!=''){ echo $this->request->data['Rate']['otherFeeValue1']; }?></td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
  <td valign="middle" align="center" style="font-size:11px; color:#333; font-weight:bold; border-bottom:1px solid #333;">Select All that Apply</td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input name="" type="checkbox" value=""></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">MobilePay Activation Fee</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$</td>
  </tr>
</table>
  </td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input name="" type="checkbox" value=""></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">MobilePay Activation Fee</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$</td>
  </tr>
</table>
  </td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input type="checkbox" <?php if($this->request->data['Rate']['wirelessDataMonthlyFee']!=''){?> checked <?php }?>></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">Wireless Monthly Fee</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['wirelessDataMonthlyFee'];?></td>
  </tr>
</table>
  </td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input type="checkbox" <?php if($this->request->data['Rate']['wirelessTransFee']!=''){?> checked <?php }?>></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">Wireless Transaction Fee</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['wirelessTransFee'];?></td>
  </tr>
</table>
  </td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input type="checkbox" <?php if($this->request->data['Rate']['gatewaySetupFee']!=''){?> checked <?php }?>></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">Gateway Setup Fee</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['gatewaySetupFee'];?></td>
  </tr>
</table>
  </td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input type="checkbox" <?php if($this->request->data['Rate']['gatewayMonthlyFee']!=''){?> checked <?php }?>></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">Gateway Monthly Fee</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['gatewayMonthlyFee'];?></td>
  </tr>
</table>
  </td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input type="checkbox" <?php if($this->request->data['Rate']['gatewayTransFee']!=''){?> checked <?php }?>></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">Gateway Transaction Fee</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$<?php echo $this->request->data['Rate']['gatewayTransFee'];?></td>
  </tr>
</table>
  </td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input name="" type="checkbox" value=""></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">Equipment Encryption</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$</td>
  </tr>
</table>
  </td>
  </tr>
  <tr>
  <td valign="top" style="border-bottom:1px solid #333;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top"  width="10%" align="center" style="border-right:1px solid #333;"><input name="" type="checkbox" value=""></td>
    <td  valign="middle" width="70%" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">Equipment Swap</td>
    <td valign="middle" align="left" style="border-right:1px solid #333; font-size:9px; color:#333;">$</td>
  </tr>
</table>
  </td>
  </tr>
</table>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td valign="middle" style="border-bottom:1px solid #333; border-top:1px solid #333; font-size:9px; color:#333; padding:5px; line-height:18px;">
Qualified Rate is assessed when your transactions meet certain criteria set by the applicable Association and Processor. When your Card transactions fail to meet those
qualification criteria, we will process your transactions at the higher Mid-qualified Discount Rate (Rate 2) of <?php echo $this->request->data['Rate']['midQualDiscount']?> % + $0.10 or, in certain circumstances, at a Non-qualified
Discount Rate (Rate : / Standard*) of <?php echo $this->request->data['Rate']['nonQualDiscount']?> % + $0.10. Both rates are a surcharge to the qualified rate. An interchange transaction fee of $0.1073 is assessed on each
bankcard transaction. Rates may appear on your statement as Electronic or Standard.
</td>
</tr>

<tr>
<td width="100%" valign="top" style="border-bottom:1px solid #333;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="50%" style="border-right:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td height="10"></td>
    </tr>
  <tr>
    <td valign="top" height="30" align="left" width="25%">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left" width="25%"><input type="checkbox" <?php echo $check_ERR_pricing;?>></td>
    <td valign="middle" align="left" style="font-size:11px; color:#333; font-weight:bold; text-decoration:underline;">ERR Rate:</td>
  </tr>
</table>

    </td>
    <td valign="top" align="center" width="25%" style="font-size:9px; color:#333; font-weight:bold">Discount<br/>Rate</td>
    <td valign="top" align="center" width="25%" style="font-size:9px; color:#333; font-weight:bold">Non-Qualified<br/>Fee</td>
    <td valign="top" align="center" style="font-size:9px; color:#333; font-weight:bold">Authorization<br/>Fee</td>
  </tr>
   <tr>
    <td valign="top" height="40" align="left" width="25%"  style="font-size:9px; color:#333; font-weight:bold" > Visa Qualified:</td>
    <td valign="top" align="center" width="25%" style="font-size:9px; color:#333; font-weight:bold"><?php echo $this->request->data['Rate']['visa_qualify_dis_rate']?>%</td>
    <td valign="top" align="center" width="25%" style="font-size:9px; color:#333; font-weight:bold"><?php echo $this->request->data['Rate']['visa_non_qualify_fee']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333; font-weight:bold">$<?php echo $this->request->data['Rate']['visa_authorization_fee']?></td>
  </tr>
  <tr>
    <td valign="top" height="40" align="left" width="25%"  style="font-size:9px; color:#333; font-weight:bold" >MC Qualified:</td>
    <td valign="top" align="center" width="25%" style="font-size:9px; color:#333; font-weight:bold"><?php echo $this->request->data['Rate']['mc_qualify_dis_rate']?>%</td>
    <td valign="top" align="center" width="25%" style="font-size:9px; color:#333; font-weight:bold"><?php echo $this->request->data['Rate']['mc_non_qualify_fee']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333; font-weight:bold">$<?php echo $this->request->data['Rate']['mc_authorization_fee']?></td>
  </tr>
  <tr>
    <td valign="top" height="40" align="left" width="25%"  style="font-size:9px; color:#333; font-weight:bold" >Discover Qualified:</td>
    <td valign="top" align="center" width="25%" style="font-size:9px; color:#333; font-weight:bold"><?php echo $this->request->data['Rate']['discover_qualify_dis_rate']?>%</td>
    <td valign="top" align="center" width="25%" style="font-size:9px; color:#333; font-weight:bold"><?php echo $this->request->data['Rate']['discover_non_qualify_fee']?>%</td>
    <td valign="top" align="center" style="font-size:9px; color:#333; font-weight:bold">$<?php echo $this->request->data['Rate']['discover_authorization_fee']?></td>
  </tr>
</table>

    </td>
    
    
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="middle" style="font-size:9px; color:#333; padding:7px 0 0 7px; font-weight:bold;"><span style="font-size:12px;">EBT:</span> FCS #: ____________________________________________________ Transaction Fee: $<?php echo $this->request->data['Rate']['ebtTransFee'];?></td>
  </tr>
  <tr>
    <td valign="top" style="font-size:9px; color:#333; padding:7px 0 0 7px; font-weight:bold;">Benefit Issuance Availability: Days _________ Hours _________</td>
  </tr>
  <tr>
    <td valign="top" style="font-size:9px; color:#333; padding:7px 0 0 7px; font-weight:bold;">Check all EBT services provided at this location:</td>
  </tr>
  
  <tr>
    <td valign="top" style="padding:0 0 0 7px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="6%"><input name="" type="checkbox" value=""></td>
    <td valign="middle" align="left" width="25%" style="font-size:9px; color:#333;">Food Stamps</td>
    <td valign="top" width="6%"><input name="" type="checkbox" value=""></td>
   <td valign="middle" align="left" width="25%" style="font-size:9px; color:#333;">Cash Benefits</td>
    <td valign="top" width="6%"><input name="" type="checkbox" value=""></td>
   <td valign="middle" align="left" style="font-size:9px; color:#333;">Purchase with Cash Back</td>
  </tr>
  <tr>
    <td valign="top" width="6%"><input name="" type="checkbox" value=""></td>
    <td valign="middle" align="left" width="25%" style="font-size:9px; color:#333;">Purchase</td>
    <td valign="top" width="6%"><input name="" type="checkbox" value=""></td>
   <td valign="middle" align="left" style="font-size:9px; color:#333;">Cash Withdrawal</td>
    <td valign="top" >&nbsp;</td>
   <td valign="middle" align="left" style="font-size:9px; color:#333;">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" height="40" width="6%"><input name="" type="checkbox" value=""></td>
    <td valign="middle" align="left" colspan="5" style="font-size:9px; color:#333;">If Cash Issuance, the limit amount: $____________________________________</td>
  </tr>
</table>

    
    </td>
  </tr>
</table>

    </td>
  </tr>
</table>


</td>
</tr>

<tr>
<td valign="top" width="100%" style="border-bottom:1px solid #333; ">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="50%" valign="top" style="border-right:1px solid #333;" >
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td valign="middle" height="40" style="font-size:9px; color:#333; font-weight:bold; padding:5px 0 0 5px;"><span style="font-size:12px;"> PIN-Debit Card:</span> Monthly Network Access Fee: $<?php echo $this->request->data['Rate']['debitMonthlyAccessFee'];?></td>
  </tr>
  <tr>
    <td height="15" valign="top" style="font-size:9px; color:#333; font-weight:bold; padding:5px 0 0 5px;">Authorization/Transaction Fee: $<?php echo $this->request->data['Rate']['debitAuthorizationFee'];?> + Network Fees (default)</td>
  </tr>
  <tr>
    <td valign="top" style="font-size:9px; color:#333; font-weight:bold; padding:5px 0 0 5px;">OR + Network Fees <?php if($this->request->data['Rate']['debitAccessFee']!=''){ echo "($".$this->request->data['Rate']['debitAccessFee'].")"; }?></td>
  </tr>
  <tr>
    <td valign="top" style="padding:5px 0 0 5px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5%" valign="top" align="left"><input type="checkbox" <?php if($this->request->data['Rate']['debitCashBack']!=''){?> checked <?php }?>></td>
    <td valign="middle" align="left" style="font-size:9px; color:#333; font-weight:bold;">&nbsp;Cash Back: $<?php echo $this->request->data['Rate']['debitCashBack'];?> Max</td>
  </tr>
</table>

    </td>
  </tr>
</table>
    </td>
    
    <td valign="top"> 
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:5px 0 10px 0;">
  <tr> 
    <td valign="top" width="100%" style="padding:5px"> 
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" valign="middle" align="left" style="font-size:12px; color:#333; font-weight:bold;">Petroleum:</td>
    <td width="25%" valign="middle" align="left" style="font-size:9px; color:#333; font-weight:bold;">Pay at the Pump:</td>
    <td width="6%" valign="top"><input name="" type="checkbox" value=""></td>
    <td  width="6%" valign="middle" align="left" style="font-size:9px; color:#333; font-weight:bold;">Yes</td>
    <td width="6%" valign="top"><input name="" type="checkbox" value=""></td>
    <td   valign="middle" align="left" style="font-size:9px; color:#333; font-weight:bold;">No</td>
  </tr>
</table>
    </td>
  </tr>
  <tr> 
    <td valign="top" width="100%" style="padding:5px 0 0 7px; font-size:9px; color:#333; font-weight:bold;">Wright Express (WEX) #:________________________________ </td>
  </tr>
  
  <tr> 
    <td valign="top" width="100%" style="padding:5px 0 0 7px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="5%"><input name="" type="checkbox" value=""></td>
    <td valign="middle" align="left" style="font-size:9px; color:#333; font-weight:bold;">WEX Rate: &nbsp;&nbsp;&nbsp;&nbsp; ________% &nbsp;&nbsp;&nbsp;&nbsp;Authorization Fee: $_________</td>
  </tr>
</table>
    </td>
  </tr>
   <tr> 
    <td valign="top" width="100%" style="padding:5px 0 0 7px; font-size:9px; color:#333; font-weight:bold;">Voyager #: ____________________________________________</td>
  </tr>
  
   <tr> 
    <td valign="top" width="100%" style="padding:5px 0 0 7px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="5%"><input name="" type="checkbox" value=""></td>
    <td valign="middle" align="left" style="font-size:9px; color:#333; font-weight:bold;">Voyager Rate: &nbsp;&nbsp;&nbsp;&nbsp; ________% &nbsp;&nbsp;&nbsp;&nbsp;Authorization Fee: $_________</td>
  </tr>
</table>
    </td>
  </tr>
</table>

    </td>
  </tr>
</table>


</td>
</tr>

<tr>
<td valign="top" align="left" style="font-size:9px; color:#333;  padding:5px; line-height:12px;">
<span style="font-size:12px; font-weight:bold;"> Other Bank Fees:</span><br/>
Returned Item Fee: $25 (charged if amounts due are not avail able when a debit is attempted); Decline Fee (an amount equal to the Authoriza tion
Fee amount and charged per item). The following Visa, MasterCard and Discover fees are assessed by the appropriate association and passed on to the Merchant: NABU,
VAP, Acquirer Support, Cross Border, Zero Floor Limit, Assessments, IAF & ISA.
</td>
</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:30px 0 0 0;">
<tr>
<td width="65%" align="right" style="font-size:9px; color:#333;">Total Apps, Inc. is a registered ISO of Wells Fargo Bank, N.A., Walnut Creek, CA</td>
<td align="right" style="font-size:10px; color:#333;">Merchant Initials: <?php echo $this->request->data['Merchant']['name_initial'];?></td>
</tr>
</table>


</td>
</tr>

<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 7px 0;">
        <tr>
          <td valign="top" align="left" width="50%"  style="font-size:9px;">DBA Name: <?php if($dbaName!=''){ echo '<u>'.$dbaName.'</u>'; }else{ echo " _______________________________ "; }?></td>
          <td valign="top" align="left" width="40%" style="font-size:9px;">Merchant #: _______________________________</td>
          <td valign="top" align="right" style="font-size:9px; font-weight:bold;">Page 4 of 5</td>
        </tr>
      </table>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
  <tr>
    <td valign="top"  bgcolor="#000000">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%" align="center" bgcolor="#ffffff" style="font-size:9px; border:1px solid #333; " >TotalApp1504(ia)</td>
    <td width="70%" align="center" style="font-size:70%; color:#fff; font-weight:bold;">12. SIGNATURES</td>
    <td width="15%" align="center" bgcolor="#ffffff" style="font-size:9px; border:1px solid #333;">TotalApp1504(ia)</td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td valign="top" align="left" style="font-size:9px;  padding:5px; font-family:Arial, Helvetica, sans-serif;   ">
    Client certifies that all information set forth in this completed Merchant Processing Application is true and correct and that Client has received a copy of the Program Guide
[Version TotalApp1504(ia)] and Confir mation Page, which is part of this Merchant Processing Applica tion (consisting of Sections 1-12), and by this refer ence incorporated
herein. Client hereby consents to receiving commercial electronic mail messages from us or our Affiliates from time to time. Client further agrees that Client will not accept
more than 20% of its card transactions via mail, telephone or Internet order. However, if your Application is approved based upon contrary infor mation stated in Section 3,
Trans ac tion Information section above, you are authorized to accept transactions in accor dance with the percentages indicated in that section. Client authorizes MeritCards
Solutions, LP and Wells Fargo Bank, N.A. ("Bank") and their Affiliates to investigate the ref er ences, state ments and other data contained herein and to obtain addi tional
infor mation from credit bureaus and other lawful sources, including persons and companies named in this Merchant Processing Application. Client authorizes MeritCards
Solutions, LP and BANK and their Affiliates (a) to procure infor ma tion from any consumer reporting agency bearing his/her personal credit worthiness, credit standing, credit
capacity, character, general reputation, personal charac teristics, or mode of living, and (b) to contact all previous employers, personal references and educational institutions.
Each of the under signed authorizes us and our Affiliates to provide amongst each other the information contained in this Merchant Processing Application and Agreement
and any information received from all references, including banks and consumer reporting agencies. It is our policy to obtain certain information in order to verify your identity
while processing your account application.<br/><br/>
By signing below, I represent that I have read and am authorized to sign and submit this application for the above entity which agrees to be bound by the American Express®
Card Acceptance Agreement ("Agreement"), and that all information provided herein is true, complete and accurate. I authorize MeritCards Solutions, LP and American
Express Travel Related Services Company, Inc. ("AXP") and AXP's agents and Affiliates to verify the information in this application and receive and exchange information
about me per sonally, including by requesting reports from consumer reporting agencies, and disclose such information to their agent, subcontractors, Affiliates and other
parties for any purpose permitted by law. I authorize and direct MeritCards Solutions, LP and AXP and AXP agents and Affiliates to inform me directly, or through the entity
above, of reports about me that they have requested from consumer reporting agencies. Such information will include the name and address of the agency furnishing the
report. I also authorize AXP to use the reports from consumer reporting agencies for marketing and administrative purposes. I understand that upon AXP's approval of the
Application, the entity will be the Agreement and materials welcoming it, either to AXP's program for MeritCards Solutions, LP to perform services for AXP or in AXP's standard
Card acceptance program, which has different servicing terms (e.g., different speeds of pay). I understand that if the entity does not qualify for the MeritCards Solutions, LP
servicing program, the entity may be enrolled in AXP's standard Card acceptance program, and the entity may terminate the Agreement. By accepting the American Express
Card for the purchase of goods and/or services, or otherwise indicating its intention to be bound, the entity agrees to be bound by the Agreement.<br/><br/>
Client authorizes MeritCards Solutions, LP and Bank and their affiliates to debit Client's designated bank account via Automated Clearing House (ACH) for costs associated
with equip ment hard ware, software and shipping.<br/><br/>
You further acknowledge and agree that you will not use your merchant account and/or the Services for illegal transactions, for example, those prohibited by the Unlawful
Internet Gambling Enforcement Act, 31 U.S.C. Section 5361 et seq, as may be amended from time to time.<br/><br/>
<span style="font-size:10px; font-weight:bold;">
Client certifies, under penalties of perjury, that the federal taxpayer identification number and corresponding filing name provided herein are correct.
Client agrees to all the terms of this Merchant Processing Application and Agreement. This Merchant Processing Application and Agreement shall not
take effect until Client has been approved and this Agreement has been accepted by MeritCards Solutions, LP and Bank.<br/>
Client's Business Principal/Officer:
</span><br/>
</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #333;">
  <tr>
    <td width="40%" height="40"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Signature <span style="font-size:12px; font-weight:bold;" >X</span></td>
    <td width="20%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Title</td>
    <td colspan="2" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Signature <span style="font-size:12px; font-weight:bold;" >X</span></td>
  </tr>
   <tr>
    <td width="40%" height="40"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Print Name of Signer <span style="font-size:12px; font-weight:bold;" >X</span></td>
    <td width="20%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Title</td>
    <td colspan="2"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Print Name of Signer</td>
  </tr>
  <tr>
    <td width="40%" height="40"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Signature : <?php if(!empty($sign)){?> <img src="<?php echo $signature;?>"> <?php }?> </td>
    <td width="20%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Title : Owner</td>
    <td width="20%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Title</td>
    <td  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Date</td>
  </tr>
  <tr>
    <td width="40%" height="40"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Print Name of Signer: <?php echo $this->request->data['Merchant']['merchantName'];?></td>
    <td width="20%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Date: <?php echo date('m/d/Y');?></td>
    <td width="20%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">&nbsp;</td>
    <td  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">&nbsp;</td>
  </tr>

</table>
    </td>
  </tr>
  
  <tr>
    <td align="left" valign="top" width="100%" style="border-bottom:1px solid #333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="center" style="font-size:12px; font-weight:bold;  padding:0.3% 0; font-family:Arial, Helvetica, sans-serif;  ">TELECHECK ACH AUTHORIZATION</td>
  </tr>
  <tr>
    <td valign="top" align="left" style="font-size:9px;   padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;  "><span style="font-size:10px; font-weight:bold;">ACH Debit and Credit Authorization:</span> Client authorizes its Financial Institution to pay and charge to its account the amount(s) due TeleCheck under this TeleCheck
Agreement and to accept all credits and debits made to its account by TeleCheck via electronic funds transfer in connection with TeleCheck's services under this TeleCheck
Agreement. This authorization shall remain in effect until (30) thirty days after revoked in writing.</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td width="40%" height="40"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Signature: <?php if(!empty($sign)){?> <img src="<?php echo $signature;?>"> <?php }?> </td>
    <td width="40%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Print Name/ Title: <?php echo $this->request->data['Merchant']['merchantName'];?></td>
    <td  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Date: <?php echo date('m/d/Y');?></td>
  </tr>
  <tr>
    <td  valign="top" align="left"   style="font-size:9px;  padding:0 0 0 40px; font-family:Arial, Helvetica, sans-serif;" >Authorized Signature on TeleCheck Account for ACH</td>
    <td width="40%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">&nbsp;</td>
    <td  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >&nbsp;</td>
  </tr>
</table>

    </td>
  </tr>
</table>

    
    </td>
  </tr>
  
  <tr>
    <td width="100%" align="left" valign="top" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">
    <span style="font-size:10px; font-weight:bold;"> The undersigned guarantees to MeritCards Solutions, LP and Bank the performance of this Agreemen and any addendum thereto by Client, and in
the event of default, hereby waives Notice of Default and agrees to indemnify the other parties, including payment of all sums due and owing and costs associated with
enforce ment of the terms thereof. MeritCards Solutions, LP and Bank shall not be required to first proceed against Client or enforce any other remedy before proceeding
against the under signed individual. This is a continuing guarantee and shall not be discharged or affected by the death of the under signed and shall bind the heirs, adminis -
trators, representatives and assigns and be enforced by or for the benefit of any suc cessor of MeritCards Solutions, LP and Bank. The term of this guar antee shall be for the
duration of the Merchant Processing Application and Agreement and any addendum thereto, and shall guarantee all obligations which may arise or occur in connection with
my activities during the term thereof, though enforcement may be sought subsequent to any termination.
    </td>
  </tr>
  
  <tr>
    <td width="100%" height="15" align="left" valign="middle" style="font-size:11px; font-weight:bold;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Personal Guarantee</td>
  </tr>
  <tr>
    <td width="100%"  align="left" valign="top" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="40%" height="10"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Signature: <?php if(!empty($sign)){?> <img src="<?php echo $signature;?>"> <?php }?> </td>
    <td width="40%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Print Name: <?php echo $this->request->data['Merchant']['merchantName'];?></td>
    <td  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Date: <?php echo date('m/d/Y');?></td>
  </tr>
</table>
    </td>
  </tr>
  
  <tr>
    <td width="100%" height="15" align="left" valign="middle" style="font-size:11px; font-weight:bold;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Personal Guarantee</td>
  </tr>
  <tr>
    <td width="100%"  align="left" valign="top" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="40%" height="10"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Signature <span style="font-size:12px; font-weight:bold;" >X</span></td>
    <td width="40%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Print Name</td>
    <td  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Date</td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top" >
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="40%" height="15"  align="left" valign="middle" style="font-size:11px; font-weight:bold;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Accepted By MeritCards Solutions, LP</td>
    <td    align="left" valign="middle" style="font-size:11px; font-weight:bold;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Wells Fargo Bank, N.A., 1200 Montego Way, Walnut Creek, CA 94598</td>
  </tr>
  
 
</table>
 <tr>
  <td width="100%" valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td width="40%" valign="top" height="10"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Signature <span style="font-size:12px; font-weight:bold;" >X</span></td>
     <td  valign="top"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Signature <span style="font-size:12px; font-weight:bold;" >X</span></td>
  </tr>
</table>

  </td>
  </tr>
  
  <tr>
  <td width="100%" valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 4px 0;">
 <tr>
    <td width="30%" height="10"  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;" >Title</td>
    <td width="30%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Date</td>
    <td width="20%" style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Title</td>
    <td  style="font-size:9px;  padding:0.3% 0 0 0.5%; font-family:Arial, Helvetica, sans-serif;">Date</td>
  </tr>
</table>

  </td>
  </tr>

    </td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:50px 0 0 0;">
<tr>
<td width="65%" align="right" style="font-size:9px; color:#333;">Total Apps, Inc. is a registered ISO of Wells Fargo Bank, N.A., Walnut Creek, CA</td>
<td align="right" style="font-size:10px; color:#333;">Merchant Initials: <?php echo $this->request->data['Merchant']['name_initial'];?></td>
</tr>
</table>
</td>
</tr>

</table>

</td>
</tr>
</table>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<table width="100%" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
<tr>
<td>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 7px 0;">
        <tr>
          <td valign="top" align="left" width="50%"  style="font-size:9px;">DBA Name: <?php if($dbaName!=''){ echo '<u>'.$dbaName.'</u>'; }else{ echo " _______________________________ "; }?></td>
          <td valign="top" align="left" width="40%" style="font-size:9px;">Merchant #: _______________________________</td>
          <td valign="top" align="right" style="font-size:9px; font-weight:bold;">Page 5 of 5</td>
        </tr>
      </table>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
  <tr>
    <td width="15%" align="center" bgcolor="#ffffff"  style="font-size:9px; border:1px solid #333;font-weight:bold;font-family:Arial, Helvetica, sans-serif;">TotalApp1504(ia)</td>
    <td width="70%" align="center" bgcolor="#000" style="font-size:70%; color:#fff; font-weight:bold;font-family:Arial, Helvetica, sans-serif;">CONFIRMATION PAGE</td>
    <td width="15%" align="center" bgcolor="#ffffff"  style="font-size:9px; border:1px solid #333;font-weight:bold;font-family:Arial, Helvetica, sans-serif;">TotalApp1504(ia)</td>
  </tr>
</table>

<p style="font-size:10px;font-family:Arial, Helvetica, sans-serif;"><strong>Please read the Merchant Services' Program Guide in its entirety. It describes the terms under which we will provide merchant processing services to you.</strong></p>
<p style="font-size:10px;font-family:Arial, Helvetica, sans-serif;"><strong>From time to time you may have questions regarding the contents of your Agreement with Bank and/or Processor or the contents of your
  agreement with TeleCheck. The following information summarizes portions of your Agreement in order to assist you in answering some of
  the questions we are most commonly asked:</strong></p>
<table class="listing_tbl" style="border-collapse:collapse; width:100%;font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
  <tr>
    <td width="50%" style="padding:0px 0 2px 0; vertical-align:top;font-size:9px;font-family:Arial, Helvetica, sans-serif;"><table width="100%">
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>1.</strong></td>
          <td width="98%"><strong>Your discount rates are assessed</strong> on transactions that qualify for Your discount rates are assessed on transactions that qualify for transactions that fail to qualify for these reduced rates will be charged an additional fee (see Section 18 of the Card Processing Program Guide).</td>
        </tr>
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>2.</strong></td>
          <td width="98%"><strong>We may debit your bank account</strong> from time to time for amounts owed to us under the Agreement.</td>
        </tr>
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>3.</strong></td>
          <td width="98%"><strong>There are many reasons</strong> why a Chargeback may occur. When they occur we will debit your settlement funds or settlement account. For a more detailed discussion regarding Chargebacks see Section 10.</td>
        </tr>
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>4.</strong></td>
          <td width="98%"><strong>If you dispute any charge or funding</strong>, you must notify us within 45 days of the date of the statement where the charge or funding appears, or should have appeared.</td>
        </tr>
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>5.</strong></td>
          <td width="98%"><strong>The Agreement limits our liability to you.</strong>For a detailed description of the limitation of liability see Section 20.</td>
        </tr>
      </table></td>
    <td width="50%" style="padding:0px 0 2px 0; vertical-align:top;font-size:9px;font-family:Arial, Helvetica, sans-serif;"><table width="100%">
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>6.</strong></td>
          <td width="98%"><strong>We have assumed certain risks</strong> by agreeing to provide you with Card processing. Accordingly, we may take certain actions to mitigate our risk,	including termination of the Agreement, and/or hold monies otherwise payable to you (see Section 23, Term; Events of Default and Section 24, Reserve Account; Security Interest).</td>
        </tr>
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>7.</strong></td>
          <td width="98%"><strong>By executing this Agreement with us you are authorizing us</strong> to obtain financial and credit information regarding your business and the signer and guarantors of the Agreement until all your obligations to us are satisfied.</td>
        </tr>
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>8.</strong></td>
          <td width="98%"><strong>The Agreement contains a provision</strong> that in the event you terminate the Agreement early, you will be responsible for the payment of an early termination fee as set forth in Section 36, Additional Fee Information.</td>
        </tr>
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>9.</strong></td>
          <td width="98%"><strong>If you lease equipment from Processor</strong>, it is important that you read Section 34. <strong>This lease is a non-cancelable lease for the term indicated.</strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<table class="listing_tbl" style="border-collapse:collapse; width:100%;font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
  <tr>
    <td style="padding:0px 0 0px 0; vertical-align:top;font-size:9px;font-family:Arial, Helvetica, sans-serif;"><table width="100%" style="border-top:1px solid #000;">
        <tr>
          <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; "><strong>10.</strong></td>
          <td width="98%"><strong><strong>Association Disclosure</strong></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td style="padding:0px 0 0px 0; vertical-align:top;font-size:9px;font-family:Arial, Helvetica, sans-serif;"><table width="100%">
        <tr>
          <td width="100%"><strong>Visa and MasterCard Member Bank Information: Wells Fargo Bank, N.A.</strong><br />
            The Bank's mailing address is 1200 Montego Way, Walnut Creek, CA 94598 and its phone number is 1(925) 746-4143.</td>
        </tr>
      </table></td>
  </tr>
</table>
 
  <table class="listing_tbl" style="border-collapse:collapse; width:100%;font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
    <tr>
      <td width="50%" style="padding:0px 0 0px 0; vertical-align:top;font-size:9px;font-family:Arial, Helvetica, sans-serif;"><table width="100%">
          <tr>
            <td width="100%" style="padding:0;"><strong>Important Member Bank Responsibilities:</strong></td>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(a)</td>
            <td width="98%">The Bank is the only entity approved to extend acceptance of Association products directly to a Merchant.</td>
          </tr>
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(b)</td>
            <td width="98%">The Bank must be a principal (signer) to the Merchant Agreement.</td>
          </tr>
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(c)</td>
            <td width="98%">The Bank is responsible for educating Merchants on pertinent Association Rules with which Merchants must comply.</td>
          </tr>
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(d)</td>
            <td width="98%">The Bank is responsible for and must provide settlement funds to the Merchant.</td>
          </tr>
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(e)</td>
            <td width="98%">The Bank is responsible for all funds held in reserve that are derived from settlement.</td>
          </tr>
        </table></td>
      <td width="50%" style="padding:0px 0 2px 0; vertical-align:top;font-size:9px;font-family:Arial, Helvetica, sans-serif;"><table width="100%">
          <tr>
            <td width="100%" style="padding:0;"><strong>Important Merchant Responsibilities:</strong></td>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(a)</td>
            <td width="98%">Ensure compliance with cardholder data security and storage requirements.</td>
          </tr>
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(b)</td>
            <td width="98%">Maintain fraud and chargebacks below Association thresholds.</td>
          </tr>
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(c)</td>
            <td width="98%">Review and understand the terms of the Merchant Agreement.</td>
          </tr>
          <tr>
            <td width="2%" style=" vertical-align:top; padding:0 2px 1px 0; ">(d)</td>
            <td width="98%">Comply with Association rules.</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p style="font-size:9px;font-family:Arial, Helvetica, sans-serif;"><strong>Print Client's Business Legal Name:</strong> <span class="name_bdr"> <?php echo $this->request->data['Merchant']['merchantName'];?></span></p>
  <p style="font-size:9px;font-family:Arial, Helvetica, sans-serif;"><strong>By its signature below, Client acknowledges that it has received the complete Program Guide [Version TotalApp1504(ia)] consisting of 34 pages (including this confirmation).</strong></p>
  <p style="font-size:9px;font-family:Arial, Helvetica, sans-serif;"><strong>Client further acknowledges reading and agreeing to all terms in the Program Guide, which shall be incorporated into Client's Agreement. Upon receipt of a signed facsimile or original of this Confirmation Page by us, Client's Application will be processed.</strong></p>
  <p style="font-size:9px;font-family:Arial, Helvetica, sans-serif;"><strong>Client understands that a copy of the Program Guide is also available for downloading from the Internet at:</strong></p>
  <p style="font-size:9px;font-family:Arial, Helvetica, sans-serif;" class="merchant_link mer_agr"><a href="http://www.total-apps.com/merchant-account-help/merchant-terms-and-conditions">Merchant Agreement</a></p>
  <p style="font-size:9px;font-family:Arial, Helvetica, sans-serif;"><strong class="small_Text">NO ALTERATIONS OR STRIKE-OUTS TO THE PROGRAM GUIDE WILL BE ACCEPTED AND, IF MADE, ANY SUCH ALTERATIONS OR STRIKE-OUTS SHALL NOT APPLY.</strong></p>
  <p style="font-size:9px;font-family:Arial, Helvetica, sans-serif;"><strong>Client's Business Principal: <br />
    Signature (Please sign below):</strong></p>
  <table class="sig_tbl" style="width:100%; padding:2px 0 0px;">
    <tr>
      <td style="width:25%" valign="middle"><strong class="my_strong" style=" display: inline-block; margin:0 3%; width:94%; padding:1px 0; font-size:9px;font-family:Arial, Helvetica, sans-serif;">X&nbsp; <?php if(!empty($sign)){?> <img src="<?php echo $signature;?>"> <?php }?> </strong></td>
      <td style="width:25%" valign="middle"><strong class="my_strong" style=" display: inline-block; margin:0 3%; width:94%; padding:1px 0; font-size:9px;font-family:Arial, Helvetica, sans-serif;">Title&nbsp;<?php echo $owner['Owner']['title'];?></strong></td>
      <td style="width:25%" valign="middle"><strong class="my_strong" style=" display: inline-block; margin:0 3%; width:94%; padding:1px 0; font-size:9px;font-family:Arial, Helvetica, sans-serif;">Date &nbsp;<?php echo CURRENTDATE;?></strong></td>
    </tr>
  </table>
  <table class="sig_tbl" style="width:100%; padding:2px 0 0px;font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
    <tr>
      <td style="width:25%" valign="middle"><strong class="my_strong" style=" display: inline-block; margin:0 3%; width:94%; padding:1px 0; font-size:9px;font-family:Arial, Helvetica, sans-serif;">Name of Signer &nbsp; <?php echo $this->request->data['Merchant']['merchantName'];?></strong></td>
      <td style="width:25%"><strong class="my_strong" style=" display: inline-block; margin:0 3%; width:94%; padding:1px 0; font-size:9px;font-family:Arial, Helvetica, sans-serif;">IP Address &nbsp; <?php echo $_SERVER['REMOTE_ADDR'];?></strong></td>
      <td style="width:25%">&nbsp;</td>
    </tr>
  </table>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:50px 0 0 0;font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
<tr>
<td width="65%" align="right" style="font-size:9px; font-weight:bold; color:#333;font-family:Arial, Helvetica, sans-serif;">Total Apps, Inc. is a registered ISO of Wells Fargo Bank, N.A., Walnut Creek, CA</td>
<td align="right" style="font-size:10px; font-weight:bold; color:#333;">Merchant Initials: <?php echo $this->request->data['Merchant']['name_initial'];?></td>
</tr>
</table>


<?php //die;?>
