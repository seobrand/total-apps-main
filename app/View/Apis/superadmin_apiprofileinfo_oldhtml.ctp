<?php  echo $this->Form->create('Api',array('controller'=>'apis','action'=>'apiprofileinfo','onsubmit'=>'return validateForm()')); ?>
            <div class="application_form">
              <div class="product_search_indent">
                <div class="product_search_title">Products and Services Profile</div>
                <div class="applicationform_bg">
                <span class="validation_info">&nbsp;* All fields marked with a red asterisk character are mandatory.</span>
                  <table class="applicationform_table" style="width:95%">
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your monthly sales volume will be:($)<br>
                        <?php //echo $this->Form->input('Merchanttransaction.avgMonVisaVolume',array('type'=>'select','options'=>array(''=>'-Select-','1000'=>'1000','2000'=>'2000','3000'=>'3000','4000'=>'4000','5000'=>'5000','6000'=>'6000','7000'=>'7000','8000'=>'8000','9000'=>'9000','10000'=>'10000'),'label'=>false,'class'=>'select_01','div'=>false));?>
                        <?php echo $this->Form->input('Merchanttransaction.avgMonVisaVolume',array('type'=>'text','label'=>false,'class'=>'input_01','div'=>false,'onKeyPress'=>"return numbersonly(this, event)"));?>
                      </td>
                    </tr>
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your average transaction size will be:($)<br>
                        <?php //echo $this->Form->input('Merchanttransaction.avgVisaTicket',array('type'=>'select','options'=>array(''=>'-Select-','10.00'=>'10.00','50.00'=>'50.00','100.00'=>'100.00','200.00'=>'200.00','300.00'=>'300.00','400.00'=>'400.00','500.00'=>'500.00'),'label'=>false,'class'=>'select_01','div'=>false));?>
                        <?php echo $this->Form->input('Merchanttransaction.avgVisaTicket',array('type'=>'text','label'=>false,'class'=>'input_01','div'=>false,'onKeyPress'=>"return numbersonly(this, event)"));?>
                        </td>
                    </tr>
                    <tr>
                      <td><span class="validation_info">*</span>Please estimate what your maximum transaction size will be:($)<br>
                        <?php //echo $this->Form->input('Merchanttransaction.highestTicketAmount',array('type'=>'select','options'=>array(''=>'-Select-','10.00'=>'10.00','50.00'=>'50.00','100.00'=>'100.00','200.00'=>'200.00','300.00'=>'300.00','400.00'=>'400.00','500.00'=>'500.00'),'label'=>false,'class'=>'select_01','div'=>false));?>
                        <?php echo $this->Form->input('Merchanttransaction.highestTicketAmount',array('type'=>'text','label'=>false,'class'=>'input_01','div'=>false,'onKeyPress'=>"return numbersonly(this, event)"));?>
                        </td>
                    </tr>                   
                    <tr>
                      <td> Do you currently accept Visa-MC at this or any other business?<br>
                        <input type="hidden" value="" id="MerchantAcceptCreditCard_" name="data[Merchant][acceptCreditCard]">
                        <div class="small_col">
                          <input type="radio" value="yes" id="MerchantAcceptCreditCardYes" name="data[Merchant][acceptCreditCard]" <?php if($this->request->data['Merchant']['acceptCreditCard']=='yes'){?> checked<?php } ?>>
                        </div>
                        <label><strong>Yes</strong></label>
                        &nbsp;&nbsp;
                        <div class="small_col">
                          <input type="radio" value="no" id="MerchantAcceptCreditCardNo" name="data[Merchant][acceptCreditCard]" <?php if($this->request->data['Merchant']['acceptCreditCard']=='no'){?> checked<?php } ?>>
                        </div>
                        <label><strong>No</strong></label></td>
                    </tr>
                    <tr>
                      <td>Refund policy:<br>
                       <?php echo $this->Form->input('Merchant.describePolicy',array('type'=>'select','label'=>false,'class'=>'select_01','div'=>false,'options'=>array('All Sales Final'=>'All Sales Final','7 Days'=>'7 Days','14 Days'=>'14 Days','21 Days'=>'21 Days','Upon Request'=>'Upon Request','Upon Return of Product'=>'Upon Return of Product','Case-by-Case'=>'Case-by-Case','Other'=>'Other')));?>
                      </td>
                    </tr>
                    <tr>
                      <td> Previously processed before?<br>
                        <input id="MerchantProcessBefore_" type="hidden" value="" name="data[Merchant][processBefore]">
                        <div class="small_col">
                          <input type="radio" value="yes" id="MerchantProcessBeforeYes" name="data[Merchant][processBefore]" <?php if($this->request->data['Merchant']['processBefore']=='yes'){?> checked<?php } ?>>
                        </div>
                        <label><strong>Yes</strong></label>
                        &nbsp;&nbsp;
                        <div class="small_col">
                          <input type="radio" value="no"  id="MerchantProcessBeforeNo" name="data[Merchant][processBefore]" <?php if($this->request->data['Merchant']['acceptCreditCard']=='no'){?> checked<?php } ?>>
                        </div>
                        <label><strong>No</strong></label></td>
                    </tr>
                    <tr>
                      <td>If yes, name of processor and reason for leaving:<br>
                       <?php echo $this->Form->input('Merchant.processorAndLeaveReason',array('type'=>'text','label'=>false,'class'=>'input_01','div'=>false));?>
                      </td>
                    </tr>
                  </table>
                  <div class="sub_title">Trade References</div>
                  <table class="applicationform_table" style="width:95%">                  	
                    <tr>
	                    <td>
	                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		                    	<tr>
	                             <td>Trade Name:<br>
	                              	<?php echo $this->Form->input('Merchant.tradeName',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                              <td>Contact Name:<br>
                              		<?php echo $this->Form->input('Merchant.tradeContactName',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                          	</tr>
	                          	<tr>	                            	
	                              <td>Telephone:<br>
	                              <?php echo $this->Form->input('Merchant.tradePhone',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                              <td>Bank Name:<br>
	                              <?php echo $this->Form->input('Merchant.bankName',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                          	</tr>
	                          	<tr>	                            	
	                              <td>Bank Contact Name:<br>
	                              <?php echo $this->Form->input('Merchant.bankContactName',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                              <td>Bank Telephone:<br>
	                              <?php echo $this->Form->input('Merchant.bankPhone',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                          	</tr>
	                    	</table>
	                    </td>                      
                    </tr>
                  </table>
                  <div class="sub_title">Bank Information - Electronic Fund Transfer Authorization</div>
                  <table class="applicationform_table" style="width:95%">
                  	<tr>
                  		<td><img src="<?php echo $this->webroot;?>img/online_appform/sample-cheque.jpg" alt="Shopping Online" title="Shopping Online"></td>
                  	</tr>
                    <tr>
	                    <td>
	                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		                    	<tr>
	                            	<td> <span class="validation_info">*</span>Bank Contact (either your personal<br/>banker or bank’s name):<br>
	                              <?php echo $this->Form->input('Merchant.bankContact',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                              <td> <span class="validation_info">*</span>Telephone #:<br>
                              <?php echo $this->Form->input('Merchant.telephone',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                          	</tr>
	                          	<tr>	                            	
	                              <td> <span class="validation_info">*</span>DDA/Account #:<br>
                              <?php echo $this->Form->input('Merchant.accountNumber',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
                              <td> <span class="validation_info">*</span>ABA/Routing #:<br>
                              <?php echo $this->Form->input('Merchant.transitNumber',array('label'=>false,'class'=>'input_01','div'=>false));?></td>
	                          	</tr>
	                          	<tr>
	                          	<td>Account Type:<br>
	                              <input type="hidden" value="" id="MerchantBankAccountType_" name="data[Merchant][bankAccountType]">
	                              <div class="small_col">
	                                <input type="radio" value="Checking" id="MerchantBankAccountTypeChecking" name="data[Merchant][bankAccountType]" checked>
	                              </div>
	                              <label>Checking</label>
	                              &nbsp;&nbsp;
	                              <div class="small_col">
	                                <input type="radio" value="Saving" id="MerchantAccountTypeSaving" name="data[Merchant][bankAccountType]">
	                              </div>
	                              <label>Savings(not preferred)</label></td>
	                          	</tr>
	                    	</table>
	                    </td>
                      
                    </tr>
                  </table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
            <div class="form_button">
               <?php echo $this->Form->submit('/img/online_appform/next-bt.jpg'); ?>
            </div>
            <?php echo $this->Form->input('Merchant.id',array('type'=>'hidden','value'=>$id));?>
			<?php echo $this->Form->input('Merchant.agentEmail',array('type'=>'hidden','value'=>$agentEmail));?>
			<?php echo $this->Form->input('Merchant.managerEmail',array('type'=>'hidden','value'=>$managerEmail));?>
          <?php echo $this->Form->end();?>
          
          
 
<script type="text/javascript">
	function validateForm(){
		var x = document.getElementById('MerchanttransactionAvgMonVisaVolume').value;
		var y = document.getElementById('MerchanttransactionAvgVisaTicket').value;
		var z = document.getElementById('MerchanttransactionHighestTicketAmount').value;
		var a = document.getElementById('MerchantBankName').value;
		var b = document.getElementById('MerchantAccountNumber').value;
		var c = document.getElementById('MerchantTransitNumber').value;	
		var d = document.getElementById('MerchantTelephone').value;	
		var totaltrantype = parseInt(document.getElementById('MerchanttransactionStoreFrontSwiped').value)+parseInt(document.getElementById('MerchanttransactionInternet').value)+parseInt(document.getElementById('MerchanttransactionMailOrder').value)+parseInt(document.getElementById('MerchanttransactionTelephoneOrder').value);
		
		var error ='';
		
		if(x=='')
			error += 'Please enter monthly dollar amount of visa and MasterCard sales.\n';
		if(y=='')
			error += 'Please enter average dollar amount per credit card sale.\n';
		if(z=='')
			error += 'Please enter maximum dollar amount per credit card sale.\n';
		if(totaltrantype>100 || totaltrantype<100)	
			error += 'Total of transaction type percentage should be 100%.\n';
		if(a=='')
			error += 'Please enter Bank Name.\n';
		if(b=='')
			error += 'Please enter DDA/Account#. \n';
		if(c=='')
			error += 'Please enter ABA/Routing#.\n';
		if(d=='')
			error += 'Please enter Telephone#.\n';
		
			
		if(error!=''){
			alert(error);			
			return false;
		}else{
			return true;
		}
		
		
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
	
</script>