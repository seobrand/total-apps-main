<div class="content"> 
  <!-- content / right -->
  <div id="right">
    
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="news_announcement">
            <div class="titlebar">BUSSINESS INFORMATION</div>
            <div class="news_indent">
			<?php  echo $this->Form->create('Merchant',array('onsubmit'=>'return checkisoreferral()')); ?>
			  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
			  	<tr>
					<td align="left" valign="middle" style="color:#FF0000" colspan="2">* All fields marked with a red asterisk character are mandatory.</td>
				</tr>
                <tr>
                 <td width="50%" align="left" valign="top" style="padding:0px;">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td align="left" width="35%" valign="middle">LEGAL NAME<span style="color:#FF0000">*</span></td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('merchantName',array('label'=>false,'class'=>'input1','tabindex'=>1));?></td>
					  </tr>
					  <tr>
						<td align="left" width="35%" valign="middle">LEGAL ADDRESS </td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalAddress',array('label'=>false,'class'=>'input1','tabindex'=>3));?></td>
					  </tr>
					  <tr>
						<td align="left" width="35%" valign="middle">LEGAL CITY </td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalCity',array('label'=>false,'class'=>'input1','tabindex'=>5));?></td>
					  </tr>
					  <tr>
						<td align="left" width="35%" valign="middle">STATE </td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalState',array('label'=>false,'class'=>'input1','tabindex'=>7));?></td>
					  </tr>
					  <tr>
						<td align="left" width="35%" valign="middle">COUNTRY</td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalCountry',array('label'=>false,'class'=>'input1','tabindex'=>9));?></td>
					  </tr>
					  <tr>
						<td align="left" width="35%" valign="middle">ZIP </td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalZip',array('label'=>false,'class'=>'input1','tabindex'=>11));?></td>
					  </tr>
					  <tr>
						<td align="left" width="35%" valign="middle">CONTACT NAME </td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('contactName',array('label'=>false,'class'=>'input1','tabindex'=>13));?></td>
					  </tr>
					  <tr>
						<td align="left" width="35%" valign="middle">BUSINESS PHONE<span style="color:#FF0000">*</span></td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('contactPhone',array('label'=>false,'class'=>'input1','tabindex'=>15));?></td>
					  </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">BUSINESS FAX </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('businessFax',array('label'=>false,'class'=>'input1','tabindex'=>17));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CARDHOLDER DESCRIPTOR <em>(Must Include Phone # if Keyed Merchant)</em> </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('descriptor',array('label'=>false,'class'=>'input1','tabindex'=>19));?></td>
                      </tr>
                       <tr>
                        <td align="left" width="35%" valign="middle">MONTHLY SALES VOLUME ($) </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('volume',array('label'=>false,'type'=>'text','class'=>'input1','onKeyPress'=>'return numbersonly(this, event)','tabindex'=>23));?></td>
                      </tr>
                    </table>
				 </td>
                 <td width="50%" align="left" valign="top" style="padding:0px;">
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA NAME<span style="color:#FF0000">*</span></td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('merchantDBA',array('label'=>false,'class'=>'input1','tabindex'=>2));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA ADDRESS </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('dbaAddress',array('label'=>false,'class'=>'input1','tabindex'=>4));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA CITY </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('dbaCity',array('label'=>false,'class'=>'input1','tabindex'=>6));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">STATE </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('dbaState',array('label'=>false,'class'=>'input1','tabindex'=>8));?></td>
                      </tr>
					  <tr>
                        <td align="left" width="35%" valign="middle">COUNTRY </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('dbaCountry',array('label'=>false,'class'=>'input1','tabindex'=>10));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">ZIP </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('dbaZip',array('label'=>false,'class'=>'input1','tabindex'=>12));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CONTACT E-MAIL<span style="color:#FF0000">*</span></td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('contactEmail',array('label'=>false,'class'=>'input1','tabindex'=>14));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CUSTOMER SERVICE PHONE </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('customerServicePhone',array('label'=>false,'class'=>'input1','tabindex'=>16));?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">WEBSITE URL </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('merchantURL',array('label'=>false,'class'=>'input1','tabindex'=>18));?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle" style="padding-top:20px;">BUSINESS START DATE </td>
                        <td align="left" width="63%" valign="middle" style="padding-top:20px;"><select name="data[Merchant][startDateMonth]" tabindex="20">
						<?php for($i=1;$i<=12;$i++){?><option value="<?php echo $i;?>" <?php if(date('m')==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option><?php }?>
						</select> / 
						<select name="data[Merchant][startDateDay]" tabindex="21">
						<?php for($j=1;$j<=31;$j++){?><option value="<?php echo $j;?>" <?php if(date('d')==$j){?> selected="selected" <?php } ?>><?php echo $j;?></option><?php }?>
						</select> / 
						<select name="data[Merchant][startDateYear]" tabindex="22">
							<?php  for($k=1900;$k<=date("Y");$k++){?><option <?php if(date('Y')==$k){?> selected="selected" <?php } ?> value="<?php echo $k;?>"><?php echo $k;?></option><?php }?>
						</select></td>
                      </tr>	
                     	<tr>
                        <td align="left" width="35%" valign="middle">FEDERAL TAX ID # <em>(Legal Name field)</em>  
</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('federalTaxId',array('label'=>false,'class'=>'input1','tabindex'=>26));?></td>
                      </tr>	 
                    </table>
				</td>
                </tr>
                <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">NAME <em>(as it appears on your income  tax return)</em>  
</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('federalName',array('label'=>false,'class'=>'input1','tabindex'=>25));?></td>
                      </tr>
                       
                       <tr>
                    <td  align="left" width="35%" valign="middle">MID# </td>
					<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('CID',array('label'=>false,'class'=>'input1','tabindex'=>27));?></td>
                      </tr>
                     
                      <tr>
                    <td  align="left" width="35%" valign="middle">Processor ID# </td>
					<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.processor_id',array('label'=>false,'class'=>'input1','tabindex'=>23,'type'=>'text'));?></td>
                      </tr>
                      
                      
                    </table></td>
                  <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      
                      <tr>
                        <td align="left" width="35%" valign="middle">SIC/MCC </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('sicMCC',array('label'=>false,'class'=>'input1','tabindex'=>28));?></td>
                      </tr>
                      
                       <tr>
                        <td align="left" width="35%" style="padding-top:20px;">STATE FILED</td>
                        <td align="left" width="63%" style="padding-top:20px;"><?php echo $this->Form->input('incorporation',array('label'=>false,'class'=>'input1','tabindex'=>24));?></td>
                      </tr>	
                      
                    </table></td>
                </tr>
				<tr>
                  <td align="left" width="50%" valign="middle" style="padding:0px;">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" width="35%" valign="middle">BUSINESS CATEGORY</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.merchantType',array('type'=>'select','options' => array('LLC' => 'LLC','Partnership' => 'PARTNERSHIP','Private Corp.' => 'PRIVATE CORP.','Sole Proprietor' => 'SOLE PROPRIETOR','Tax Exempt' => 'TAX EXEMPT'),'empty'=>'-Select Business Category-','label'=>false,'class'=>'select1','tabindex'=>24)); ?></td>
                      </tr>
                    </table>
                  </td>
                  <!-- <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">                     
                      <tr>
                        <td align="left" width="35%" valign="middle">USER CATEGORY</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.accountTypeID',array('type'=>'select','options'=>$uc_list,'empty'=>'-Select User Category-','label'=>false,'class'=>'select1','tabindex'=>25)); ?></td>
                      </tr>
                    </table>
                  </td> -->
                </tr>  
				<tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
                        <td align="left" valign="middle" width="35%">SHOPPING CART</td>
                        <td align="left" valign="middle" width="65%"><?php echo $this->Form->input('procUID',array('label'=>false,'class'=>'input1','tabindex'=>30));?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">CRM</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('procPWD',array('label'=>false,'class'=>'input1','tabindex'=>32));?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	GATEWAY  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.gatewayID',array('type'=>'select','options'=>$gatwayList,'empty'=>'-Select Gateway-','label'=>false,'class'=>'select1','tabindex'=>34)); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	PROCESSING METHOD </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.accountCategory',array('type'=>'select','options'=>$acat_list,'empty'=>'-Processing Method-','label'=>false,'class'=>'select1','tabindex'=>36)); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">PROCESSOR  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.processorID',array('type'=>'select','options'=>$procList,'empty'=>'-Select Processor-','label'=>false,'class'=>'select1','tabindex'=>38)); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">	MANAGER  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.managerID',array('type'=>'select','options'=>$mangList,'empty'=>'-Select Manager-','label'=>false,'class'=>'select1','tabindex'=>37)); ?></td>
                      </tr>					  
                      <tr>
                        <td align="left" valign="middle">	RESERVE  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.reserve',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'div'=>false,'class'=>'input1','tabindex'=>36)); ?>%</td>
                      </tr>                      
                    </table></td>
                  <td width="50%" valign="top" align="left" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                     
					  <tr>
                        <td align="left" valign="top" width="35%">STATUS  </td>
                        <td align="left" valign="middle" width="65%"><?php echo $this->Form->input('Merchant.statusID',array('type'=>'select','options'=>$status,'empty'=>'-Select Status-','selected'=>1,'label'=>false,'class'=>'select1','tabindex'=>31)); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">	MERCHANT CATEGORY </td>
                        <td align="left" valign="middle"><?php 
						
						echo $this->Form->input('Merchant.accountTypeID',array('type'=>'select','options'=>$ac_list,'empty'=>'-Select Merchant Category-','label'=>false,'class'=>'select1','tabindex'=>33)); ?></td>
                      </tr>					  
                      <tr>
                        <td align="left" valign="middle">	AGENT  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.agentID',array('type'=>'select','options'=>$agentList,'empty'=>'-Select Agent-','label'=>false,'class'=>'select1','tabindex'=>35)); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	REFERRAL  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.referalID',array('type'=>'select','options'=>$referalList,'empty'=>'-Select Referral-','label'=>false,'class'=>'select1','onchange'=>'makeISOCombo("referral",this.value)','tabindex'=>39)); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">	ISO  </td>
                        <td align="left" valign="middle" id="isoDiv"><?php echo $this->Form->input('Merchant.isoID',array('type'=>'select','options'=>$isoList,'empty'=>'-Select ISO-','label'=>false,'class'=>'select1','tabindex'=>40)); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	CATEGORY OF BUSINESS  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.busi_cat_id',array('type'=>'select','options'=>$busi_cat_id,'empty'=>'-Select category of business-','label'=>false,'class'=>'select1','tabindex'=>41)); ?></td>
                      </tr>
                    </table></td>
                </tr>
				<tr>
					<td align="left" colspan="2" valign="middle">DETAILED EXPLANATION OF TYPE OF MERCHANDISE, PRODUCTS OR SERVICES SOLD <br />
				<?php echo $this->Form->textarea('detailExplanation',array('class'=>'textarea_new','tabindex'=>42));?></td>
			  	</tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                <tr>
                  <td>&nbsp;</td>
                  <td align="right" valign="top" style="padding:16px 40px 0 0;"><?php echo $this->Form->submit('Add Merchant',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'tabindex'=>43));?></td>
                </tr>
              </table>
   			<?php echo $this->Form->end();?>
            </div>
          </div>
        </div>
        <!-- end table --> 
      </div>
 
  </div>
  <!-- end content / right --> 
</div>
<script type="text/javascript">
function checkisoreferral(){
	ref_val = $("#MerchantReferalID").val();
	iso_val = $("#MerchantIsoID").val();
	if(ref_val==iso_val && ref_val!=2 && ref_val!=""){
		alert('Please make sure that the value set to the Referral dropdown is not the same as the value set in the ISO dropdown!');
		return false;
	}
	return true;
}
function numbersonly(myfield, e, dec)
{ var key;var keychar;	
	if (window.event)
	   key = window.event.keyCode;
	else if (e)
	   key = e.which;
	else
	   return true;
	keychar = String.fromCharCode(key);
	// control keys
	if ((key==null) || (key==0) || (key==8) || 
		(key==9) || (key==13) || (key==27) || (key==46) )
	   return true;
	// numbers
	else if ((("0123456789").indexOf(keychar) > -1))
	   return true;
	else
	   return false;
}
function makeISOCombo(user_type,userID)
{
	var xmlhttp;
	var country='';
	//alert(user_type);
	//alert(userID);
	
	if(userID!=null || userID!='')
	{
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function()
		  {
		  	if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("isoDiv").innerHTML=xmlhttp.responseText;
			}
		  }
		var url='';
		url='<?php echo FULL_BASE_URL.router::url('/',false).'superadmin/merchants/isolist'?>/'+userID;
		
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
	}
	else
	{
		alert('Please select valid user.');
	}

}

</script>