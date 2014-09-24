<?php 	
if(isset($OwnerData) && count($OwnerData)>0){
	foreach($OwnerData as $key =>$ownerdataval ){
		$this->request->data['Owner']['name'.($key+1)] = $ownerdataval['Owner']['name'];
		$this->request->data['Owner']['title'.($key+1)] = $ownerdataval['Owner']['title'];
		$this->request->data['Owner']['ownership'.($key+1)] = $ownerdataval['Owner']['ownership'];
		$this->request->data['Owner']['dob'.($key+1)] = $ownerdataval['Owner']['dob'];
		$this->request->data['Owner']['licenceNumber'.($key+1)] = $ownerdataval['Owner']['licenceNumber'];
		$this->request->data['Owner']['socialSecurityNumber'.($key+1)]=$common->getToken($ownerdataval['Owner']['socialSecurityNumber']);
		$this->request->data['Owner']['homeAddress'.($key+1)] = $ownerdataval['Owner']['homeAddress'];
		$this->request->data['Owner']['city'.($key+1)] = $ownerdataval['Owner']['city'];
		$this->request->data['Owner']['state'.($key+1)] = $ownerdataval['Owner']['state'];
		$this->request->data['Owner']['zip'.($key+1)] = $ownerdataval['Owner']['zip'];
		$this->request->data['Owner']['homePhone'.($key+1)] = $ownerdataval['Owner']['homePhone'];
	}
}

if($this->request->data['Merchant']['merchantType']!=''){
	$this->request->data['Merchant']['merchantType'] = explode(",",$this->request->data['Merchant']['merchantType']);
}
if($this->request->data['Merchant']['accountNumber']!=''){
	$this->request->data['Merchant']['accountNumber'] = $common->getToken($this->request->data['Merchant']['accountNumber']);
}

?>
<div class="application_form">
	<div class="product_search_indent">
		<div class="product_search_title">Business Profile	</div>
		<div class="applicationform_bg">
			<table class="applicationform_table" style="width:95%;">
				<tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Legal Name:<br>
                              <?php echo $this->Form->input('Merchant.merchantName',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>DBA Name:<br>
                              <?php echo $this->Form->input('Merchant.merchantDBA',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Legal Address:<br>
                              <?php echo $this->Form->input('Merchant.legalAddress',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>DBA Address:<br>
                              <?php echo $this->Form->input('Merchant.dbaAddress',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Legal City:<br>
                              <?php echo $this->Form->input('Merchant.legalCity',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>DBA City:<br>
                              <?php echo $this->Form->input('Merchant.dbaCity',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Legal State:<br>
                              <?php echo $this->Form->input('Merchant.legalState',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>DBA State:<br>
                              <?php echo $this->Form->input('Merchant.dbaState',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <?php /* ?>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Legal Country:<br>
                              <?php echo $this->Form->input('Merchant.legalCountry',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>DBA Country:<br>
                              <?php echo $this->Form->input('Merchant.dbaCountry',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <?php */ ?>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Legal Zip:<br>
                              <?php echo $this->Form->input('Merchant.legalZip',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>DBA Zip:<br>
                              <?php echo $this->Form->input('Merchant.dbaZip',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Contact Name:<br>
                              <?php echo $this->Form->input('Merchant.contactName',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Contact Email:<br>
                              <?php echo $this->Form->input('Merchant.contactEmail',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Business Phone:<br>
                              <?php echo $this->Form->input('Merchant.contactPhone',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Customer Service Phone:<br>
                              <?php echo $this->Form->input('Merchant.customerServicePhone',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Business Fax:<br>
                              <?php echo $this->Form->input('Merchant.businessFax',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Website URL:<br>
                              <?php echo $this->Form->input('Merchant.merchantURL',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Cardholder Descriptor:<br>
                              <?php echo $this->Form->input('Merchant.descriptor',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Monthly Sales Volume:<br>
                              <?php echo $this->Form->input('Merchant.volume',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Name (Legal Name Field):<br>
                              <?php echo $this->Form->input('Merchant.federalName',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Federal Tax ID # (appears on <br/>income tax return):<br>
                              <?php echo $this->Form->input('Merchant.federalTaxId',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>SIC/MCC:<br>
                            <?php echo $this->Form->input('Merchant.sicMCC',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>User Category:<br>
                              <?php echo $this->Form->input('Merchant.accountTypeID',array('type'=>'select','options'=>$uc_list,'empty'=>'-Select User Category-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                        </tr>
                        </table>
                     </td>
                  </tr>
                  <?php /*?><tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>MID#:<br>
                              <?php echo $this->Form->input('Merchant.CID',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Business Category:<br>
                              <?php echo $this->Form->input('Merchant.merchantType',array('type'=>'select','options' => array('Sole Proprietor' => 'SOLE PROPRIETOR','Partnership' => 'PARTNERSHIP','Private Corp.' => 'PRIVATE CORP.','Tax Exempt' => 'TAX EXEMPT','LLC' => 'LLC'),'empty'=>'-Select Business Category-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>           
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Shopping Cart:<br>
                              <?php echo $this->Form->input('Merchant.procUID',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>CRM:<br>
                             <?php echo $this->Form->input('Merchant.procPWD',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td> 
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Processing Method:<br>
                              <?php echo $this->Form->input('Merchant.accountCategory',array('type'=>'select','options'=>$acat_list,'empty'=>'-Select Processing Method-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                            <td>Manager:<br>
                              <?php echo $this->Form->input('Merchant.managerID',array('type'=>'select','options'=>$mangList,'empty'=>'-Select Manager-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Processor:<br>
                              <?php echo $this->Form->input('Merchant.processorID',array('type'=>'select','options'=>$procList,'empty'=>'-Select Processor-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                            <td>Referral:<br>
                              <?php echo $this->Form->input('Merchant.referalID',array('type'=>'select','options'=>$referalList,'empty'=>'-Select Referral-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>ISO:<br>
                              <?php echo $this->Form->input('Merchant.isoID',array('type'=>'select','options'=>$isoList,'empty'=>'-Select ISO-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                            <td>Category of Business:<br>
                              <?php echo $this->Form->input('Merchant.busi_cat_id',array('type'=>'select','options'=>$busi_cat_id,'empty'=>'-Select Business Category-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <?php  comment end here */ ?>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>State Filed:<br>
                              <?php echo $this->Form->input('Merchant.incorporation',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Gateway<br>
                              <?php echo $this->Form->input('Merchant.gatewayID',array('type'=>'select','options'=>$gatwayList,'empty'=>'-Select Gateway-','label'=>false,'class'=>'select_01','disabled'=>true)); ?></td>
                          </tr>
                        </table>
                     </td>
                  </tr> 
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Detailed Explanation of Type of Merchandise, products or Services Sold:<br>
                              <?php echo $this->Form->textarea('Merchant.detailExplanation',array('class'=>'textarea_new_01','disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">&nbsp;</td>
                  </tr>
			</table>
			<div class="sub_title">Owners / Partners / Officers</div>
			<table class="applicationform_table" style="width:95%">
				<tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Name:<br>
                              <?php echo $this->Form->input('Owner.name1',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Title:<br>
                              <?php echo $this->Form->input('Owner.title1',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Owner ship %:<br>
                              <?php echo $this->Form->input('Owner.ownership1',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>SSN:<br>
                              <?php echo $this->Form->input('Owner.socialSecurityNumber1',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Home address:<br>
                              <?php echo $this->Form->input('Owner.homeAddress1',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Home city:<br>
                              <?php echo $this->Form->input('Owner.city1',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Home State:<br>
                              <?php echo $this->Form->input('Owner.state1',array('type'=>'text','class'=>'input_01','div'=>false,'label'=>false,'disabled'=>true));?></td>
                            <td>Home zip:<br>
                              <?php echo $this->Form->input('Owner.zip1',array('label'=>false,'class'=>'input_01','div'=>false,'maxlength'=>5,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>DOB:<br>
                              <?php echo $this->Form->input('Owner.dob1',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Home/Cell Phone:<br>
                              <?php echo $this->Form->input('Owner.homePhone1',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">&nbsp;</td>
                  </tr>
               </table>
	        <?php 
	 		 if(isset($OwnerData) && count($OwnerData)>1){ 
				foreach($OwnerData as $key => $owner){ if($key>=1) {
			?>
			<table class="applicationform_table" style="width:95%">
				<tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Name:<br>
                              <?php echo $this->Form->input('Owner.name'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Title:<br>
                              <?php echo $this->Form->input('Owner.title'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Owner ship %:<br>
                              <?php echo $this->Form->input('Owner.ownership'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>SSN:<br>
                              <?php echo $this->Form->input('Owner.socialSecurityNumber'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Home address:<br>
                              <?php echo $this->Form->input('Owner.homeAddress'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Home city:<br>
                              <?php echo $this->Form->input('Owner.city'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Home State:<br>
                              <?php echo $this->Form->input('Owner.state'.($key+1),array('type'=>'text','class'=>'input_01','div'=>false,'label'=>false,'disabled'=>true));?></td>
                            <td>Home zip:<br>
                              <?php echo $this->Form->input('Owner.zip'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'maxlength'=>5,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>DOB:<br>
                              <?php echo $this->Form->input('Owner.dob'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Home/Cell Phone:<br>
                              <?php echo $this->Form->input('Owner.homePhone'.($key+1),array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">&nbsp;</td>
                  </tr>                  
				</table>
			<?php } } }?>
			<div class="sub_title">Merchant Profile</div>
			<table class="applicationform_table" style="width:95%">
                    <tr>
                      <td>Monthly dollar amount of visa and MasterCard sales (estimate):<br>
                        <?php echo $this->Form->input('Merchanttransaction.avgMonVisaVolume',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                    </tr>
                    <tr>
                      <td>Average dollar amount per credit card sale:<br>
                        <?php echo $this->Form->input('Merchanttransaction.avgVisaTicket',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                    </tr>
                    <tr>
                      <td>Maximum dollar amount per credit card sale:<br>
                        <?php echo $this->Form->input('Merchanttransaction.highestTicketAmount',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                    </tr>
                    <tr>
                      <td class="pad0"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Card swipe %:<br>
                              <?php echo $this->Form->input('Merchanttransaction.storeFrontSwiped',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input_01','div'=>false,'maxlength'=>2,'disabled'=>true));?></td>
                            <td>Mail Order %:<br>
                              <?php echo $this->Form->input('Merchanttransaction.mailOrder',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input_01','div'=>false,'maxlength'=>2,'disabled'=>true));?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td class="pad0"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Internet %:<br>
                              <?php echo $this->Form->input('Merchanttransaction.internet',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input_01','div'=>false,'maxlength'=>2,'disabled'=>true));?></td>
                            <td>Telephone Order %:<br>
                              <?php echo $this->Form->input('Merchanttransaction.telephoneOrder',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input_01','div'=>false,'maxlength'=>2,'disabled'=>true));?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td> Do you currently accept Visa-MC at this or any other business?<br>
                        <input type="hidden" value="" id="MerchantAcceptCreditCard_" name="data[Merchant][acceptCreditCard]">
                        <div class="small_col">
                          <input type="radio" value="yes" disabled="disabled" id="MerchantAcceptCreditCardYes" name="data[Merchant][acceptCreditCard]" <?php if($this->request->data['Merchant']['acceptCreditCard']=='yes'){?> checked="checked" <?php }?>>
                        </div>
                        <label><strong>Yes</strong></label>
                        &nbsp;&nbsp;
                        <div class="small_col">
                          <input type="radio" value="no" disabled="disabled" id="MerchantAcceptCreditCardNo" name="data[Merchant][acceptCreditCard]"  <?php if($this->request->data['Merchant']['acceptCreditCard']=='no'){?> checked="checked" <?php }?>>
                        </div>
                        <label><strong>No</strong></label></td>
                    </tr>
                    <tr>
                      <td>Refund policy:<br>
                        <select name="data[Merchant][describePolicy]" class="select_01" id="MerchantDescribePolicy" disabled="disabled">
                          <option value="All Sales Final" <?php if($this->request->data['Merchant']['describePolicy']=='All Sales Final'){?> selected="selected" <?php }?>>All Sales Final</option>
                          <option value="7 Days" <?php if($this->request->data['Merchant']['describePolicy']=='7 Days'){?> selected="selected" <?php }?>>7 Days</option>
                          <option value="14 Days" <?php if($this->request->data['Merchant']['describePolicy']=='14 Days'){?> selected="selected" <?php }?>>14 Days</option>
                          <option value="21 Days" <?php if($this->request->data['Merchant']['describePolicy']=='21 Days'){?> selected="selected" <?php }?>>21 Days</option>
                          <option value="Other" <?php if($this->request->data['Merchant']['describePolicy']=='Other'){?> selected="selected" <?php }?>>Other</option>
                        </select></td>
                    </tr>
                    <tr>
                   <td class="pad0">&nbsp;</td>
                  </tr> 
                  </table>   
                <div class="sub_title">Trade Reference</div>
				<table class="applicationform_table" style="width:95%">
				<tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Trade Name:<br>
                              <?php echo $this->Form->input('Merchant.tradeName',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Contact Name:<br>
                              <?php echo $this->Form->input('Merchant.tradeContactName',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Telephone:<br>
                              <?php echo $this->Form->input('Merchant.tradePhone',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Bank Name:<br>
                              <?php echo $this->Form->input('Merchant.bankName',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Bank Contact Name:<br>
                              <?php echo $this->Form->input('Merchant.bankContactName',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Bank Telephone:<br>
                              <?php echo $this->Form->input('Merchant.bankPhone',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">&nbsp;</td>
                  </tr> 
                 </table>               
                <div class="sub_title">Pricing(Rates)</div>
				<table class="applicationform_table" style="width:95%">
				<tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Chargeback Fee$:<br>
                              <?php echo $this->Form->input('Rate.chargebackFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>ACH/BATCH Statement:<br>
                              <?php echo $this->Form->input('Rate.achBatchFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>AVS Fee $:<br>
                              <?php echo $this->Form->input('Rate.electronicAvsFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Service/Statement Fee:<br>
                              <?php echo $this->Form->input('Rate.statementFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Retrieval Fee $:<br>
                              <?php echo $this->Form->input('Rate.retrievalReqFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Merchant Club Fee $:<br>
                              <?php echo $this->Form->input('Rate.merchantClubFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Wireless Monthly Fee $:<br>
                              <?php echo $this->Form->input('Rate.wirelessDataMonthlyFee',array('type'=>'text','class'=>'input_01','div'=>false,'label'=>false,'disabled'=>true));?></td>
                            <td>Wireless Trans. Fee $:<br>
                              <?php echo $this->Form->input('Rate.wirelessTransFee',array('label'=>false,'class'=>'input_01','div'=>false,'maxlength'=>5,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Return Item Fee $:<br>
                              <?php echo $this->Form->input('Rate.returnItemFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Application Fee $:<br>
                              <?php echo $this->Form->input('Rate.applicationFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>AVS Voice Authorization Fee $:<br>
                              <?php echo $this->Form->input('Rate.avsVoiceAuthFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Voice Authorization Fee $:<br>
                              <?php echo $this->Form->input('Rate.voiceAuthFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>VRU/ARU Fee $:<br>
                              <?php echo $this->Form->input('Rate.vru_aru_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Regulatory Bundle Fee $:<br>
                              <?php echo $this->Form->input('Rate.regulatory_bundle_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Monthly Minimum Fee $<br>
                              <?php echo $this->Form->input('Rate.monthlyMinFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Early Termination $:<br>
                              <?php echo $this->Form->input('Rate.early_termination_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Monthly Maintenance Fee $<br>
                              <?php echo $this->Form->input('Rate.monthly_maintenance_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Online Reporting Fee $:<br>
                              <?php echo $this->Form->input('Rate.online_reporting_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="2">EIDS Chargeback/ Retrieval Online Tool $:<br>
                              <?php echo $this->Form->input('Rate.eids_chargeback_retrieval_online_tool_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true,'style'=>'width: 485px;'));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>PCI Compliance Fee Type<br>
                            <?php echo $this->Form->input('Rate.pci_compliance_fee_type',array('type'=>'select','options'=>array('monthly'=>'Monthly','yearly'=>'Yearly'),'label'=>false,'class'=>'select_01','div'=>false,'disabled'=>true));?>
                            </td>
                            <td>PCI Compliance Fee $:<br>
                              <?php echo $this->Form->input('Rate.pci_compliance_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Interchange Plus %:<br>
                              <?php echo $this->Form->input('Rate.interchangePlus',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Interchange Per Item $:<br>
                              <?php echo $this->Form->input('Rate.interchangePerItem',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Gateway Setup Fee $:<br>
                              <?php echo $this->Form->input('Rate.gatewaySetupFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Gateway Monthly Fee $:<br>
                              <?php echo $this->Form->input('Rate.gatewayMonthlyFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="2">Gateway Transaction Fee $:<br>
                              <?php echo $this->Form->input('Rate.gatewayTransFee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true,'style'=>'width: 485px;'));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">&nbsp;</td>
                  </tr>
               </table>
               <div class="sub_title">ERR Pricing</div>
				<table class="applicationform_table" style="width:95%">
				<tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Visa Discount Rate %:<br>
                              <?php echo $this->Form->input('Rate.visa_qualify_dis_rate',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>Visa Non-Qualified Fee %:<br>
                              <?php echo $this->Form->input('Rate.visa_non_qualify_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Visa Authorization Fee $:<br>
                              <?php echo $this->Form->input('Rate.visa_authorization_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>MC Discount Rate %:<br>
                              <?php echo $this->Form->input('Rate.mc_qualify_dis_rate',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>MC Non-Qualified Fee %:<br>
                              <?php echo $this->Form->input('Rate.mc_non_qualify_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                            <td>MC Authorization Fee $:<br>
                              <?php echo $this->Form->input('Rate.mc_authorization_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Discover Discount Rate %:<br>
                              <?php echo $this->Form->input('Rate.discover_qualify_dis_rate',array('type'=>'text','class'=>'input_01','div'=>false,'label'=>false,'disabled'=>true));?></td>
                            <td>Discover Non-Qualified Fee %:<br>
                              <?php echo $this->Form->input('Rate.discover_non_qualify_fee',array('label'=>false,'class'=>'input_01','div'=>false,'maxlength'=>5,'disabled'=>true));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   <td class="pad0">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="2">Discover Authorization Fee $:<br>
                              <?php echo $this->Form->input('Rate.discover_authorization_fee',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true,'style'=>'width: 485px;'));?></td>
                          </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                   	<td class="pad0">&nbsp;</td>
                  </tr> 
                </table>
               <div class="sub_title">Bank Information - Electronic Fund Transfer Authorization</div>
               <table class="applicationform_table" style="width:95%">
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td> <span class="validation_info">*</span>Account Holder Name:<br>
                              <?php echo $this->Form->input('Merchant.bankContact',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                          <tr>
                            <td> <span class="validation_info">*</span>ABA/Routing #:<br>
                              <?php echo $this->Form->input('Merchant.transitNumber',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                        </table></td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td> <span class="validation_info">*</span>DDA/Account #:<br>
                              <?php echo $this->Form->input('Merchant.accountNumber',array('label'=>false,'class'=>'input_01','div'=>false,'disabled'=>true));?></td>
                          </tr>
                          <tr>
                            <td>Account Type:<br>
                              <input type="hidden" value="" id="MerchantBankAccountType_" name="data[Merchant][bankAccountType]">
                              <div class="small_col">
                                <input type="radio" value="Checking" id="MerchantBankAccountTypeChecking" name="data[Merchant][bankAccountType]" <?php if($this->request->data['Merchant']['bankAccountType']=='Checking'){?> checked="checked" <?php }?> disabled="disabled">
                              </div>
                              <label>Checking</label>
                              &nbsp;&nbsp;
                              <div class="small_col">
                                <input type="radio" value="Saving" id="MerchantAccountTypeSaving" name="data[Merchant][bankAccountType]" <?php if($this->request->data['Merchant']['bankAccountType']=='Saving'){?> checked="checked" <?php }?> disabled="disabled">
                              </div>
                              <label>Savings(not preferred)</label></td>
                          </tr>
                        </table></td>
                    </tr>
                     <tr>
                   		<td class="pad0">&nbsp;</td>
                  </tr> 
                  </table>                  
                  <div class="sub_title">Upload Your Signature</div>
                  <table class="applicationform_table" style="width:95%">
                     <tr>
					  	<td width="28%" align="left" valign="middle" class="rpadnone">&nbsp;Name Initial</td>
						<td width="72%" align="left" valign="middle"><input type="text" name="name_initial_here" id="name_initial_here" class="name input_01" style="width:46%" onkeyup="setNameInitialValue(this.value)"></td>
					  </tr>	
				  </table>	
                  <?php  echo $this->Form->create('Apis',array('controller'=>'apis','action'=>'merchantapi','class'=>'sigPad','style'=>"width:100%")); ?> 
                  <table class="applicationform_table" style="width:95%">
                  <td>
                     <?php if($this->request->data['Merchant']['merchantSign']==NULL){ ?>
                     <tr>
					  <td width="28%" align="left" valign="middle" class="rpadnone"> <span class="validation_info">*</span>Print your name</td>
						<td width="72%" align="left" valign="middle"><input type="text" name="name" id="name" class="name input_01" style="width:50%"></td>
					  </tr>					  
					  <tr>
					  	<td width="28%" align="left" valign="middle" class="rpadnone">Review your signature</td>
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
					  <input type="hidden" name="name_initial" id="name_initial">
					  <?php echo $this->Form->input('Merchant.id',array('type'=>'hidden','value'=>$this->request->data['Merchant']['id']));?>						
						<tr>
	                      <td align="left" valign="middle" class="rpadnone">&nbsp;</td>
	                      <td align="left" valign="middle"><?php echo $this->Form->submit('/img/online_appform/submit_bt.gif',array('style'=>'width:35%;border:none')); ?></td>
	                    </tr>
                     <?php }else{ ?>
						<tr>
						  <td align="left" valign="middle" class="rpadnone">Your Signature</td>
	                      <td align="center" valign="middle"><?php echo $this->Html->image('/files/Signature/'.$this->request->data['Merchant']['merchantSign']);?></td>
	                    </tr>
						<tr>
	                      <td align="right" valign="middle" colspan="2"><a href="<?php echo $this->webroot; ?>superadmin/apis/merchantpdf/<?php echo $this->request->data['Merchant']['id'] ?>" class="cursorclass ui-state-default ui-corner-all">Create PDF</a></td>
	                    </tr>
					<?php } ?>
					</td>
                  </table>
			<div class="clear"></div>
		</div>
	</div>
</div>


<script type="text/javascript">
	/**** disable merchant role *********/
	var merchantRole = document.getElementsByName("data[Merchant][merchantType][]");
	for(var i = 0, m = merchantRole.length; i < m; ++i) {
    merchantRole[i].disabled = true;
  }
</script>
<script type="text/javascript">
	/**** disable advertisement method *********/
	var adsmethod = document.getElementsByName("data[Merchant][advertiseMethod][]");
	for(var j = 0, n = adsmethod.length; j < n; ++j) {
    adsmethod[j].disabled = true;
  }
</script>
<script type="text/javascript">
	/**** disable Monthnames method *********/
	var monthname = document.getElementsByName("data[Merchant][monthNames][]");
	for(var i = 0, n = monthname.length; i < n; ++i) {
    monthname[i].disabled = true;
	}
function setNameInitialValue(val){
	document.getElementById('name_initial').value = val;
}
</script>
