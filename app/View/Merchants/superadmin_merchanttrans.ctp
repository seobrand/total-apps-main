<?php //pr($this->request->data) ?>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="transaction">
          <div class="tabs_outer"><?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
		  <div class="box1">
		  	<div class="news_announcement">
                <div class="titlebar">Select Transaction
				<div style="float:right">
							<a href="<?php echo $this->webroot; ?>superadmin/merchants/moreinfo/<?php echo $this->request->data['Merchant']['id']; ?>#more">Next</a>
				</div>
				</div>
                <div class="news_indent">
			  <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchanttrans','name'=>'admintransaction','type' => 'get'))?> 
					<table width="50%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
						<td width="30%" align="left">Select Name</td>
						<td><?php echo $this->Form->input('Merchanttransaction.adminName',array('label'=>false,'class'=>'input1','div'=>false,'type'=>'select','options'=>$adminName,'empty'=>array('0'=>'-Select Transaction-'),'onchange' => "javascript:getTransaction(this.value);",'tabindex'=>50));?></td>
                    </tr>
                  </table>
				<?php echo $this->Form->input('Merchanttransaction.admintrans', array('type' => 'hidden','value'=>'1'));?>
			<?php echo $this->Form->end();?>	  
				</div>
			</div>
		  </div>
  		  <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchanttrans','onsubmit'=>'return validateTransaction();','name'=>'transaction'))?> 
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Transaction Information</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td colspan="2" align="left" valign="middle" class="rpadnone"><strong class="blue"s>Sales Information</strong></td>
                    </tr>
                    <tr>
                      <td width="28%" align="left" valign="middle" class="rpadnone"><sup class="red" style="vertical-align: bottom">*</sup>Average Monthly VISA & MC Volume&nbsp;$</td>
                      <td width="72%" align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.avgMonVisaVolume',array('type'=>'text','label'=>false,'class'=>'input2','div'=>false,'onKeyPress'=>"return numbersonly(this, event)",'tabindex'=>51));?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone"><sup class="red" style="vertical-align: bottom">*</sup>Average VISA & MC Ticket&nbsp;$</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.avgVisaTicket',array('type'=>'text','label'=>false,'class'=>'input2','div'=>false,'onKeyPress'=>"return numbersonly(this, event)",'tabindex'=>52));?>
                       </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone"><sup class="red" style="vertical-align: bottom">*</sup>Highest Ticket Amount&nbsp;$</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.highestTicketAmount',array('type'=>'text','label'=>false,'class'=>'input2','div'=>false,'onKeyPress'=>"return numbersonly(this, event)",'tabindex'=>53));?>
                        </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Seasonal Highest Monthly Volume&nbsp;$</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.seasonalHighMonVolume',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>54));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Recurring Billing</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.recurring_billing',array('label'=>false,'class'=>'input1','div'=>false,'type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'empty'=>'-Select Recurring Billing-','tabindex'=>54,'style'=>'width:370px;'));?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="middle" class="rpadnone" style="padding-top:16px;"><strong class="blue">Transaction Type Percentage</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Store Front/Swiped&nbsp;%</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.storeFrontSwiped',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>61));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Internet&nbsp;%</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.internet',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>62));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Mail Order&nbsp;%</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.mailOrder',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>63));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Telephone Order&nbsp;%</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.telephoneOrder',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>64));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone"><strong>Total&nbsp;%</strong></td>
                      <td align="left" valign="middle"><strong>= 100%</strong></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="middle" class="rpadnone" style="padding-top:16px;"><strong class="blue">How is transaction completed?</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Electronic data capture (swiped)&nbsp;%</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.electronicDataCapture',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>71));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Manual entry with Impr&nbsp;%</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.manualEntryWithImpr',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>72));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Manual entry, no card present, no imprint&nbsp;%</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.onlyManualEntry',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>73));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Voice Authorization and Capture&nbsp;%</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.voiceAuthCapture',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input2','div'=>false,'tabindex'=>74));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone"><strong>Total&nbsp;%</strong></td>
                      <td align="left" valign="middle"><strong>= 100%</strong></td>
                    </tr>
					<tr>
                      <td align="left" valign="middle" class="rpadnone">&nbsp;</td>
                      <td align="left" valign="middle"><?php echo $this->Form->submit('Update Transaction',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'tabindex'=>80));?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
			<?php echo $this->Form->input('Merchanttransaction.merchantID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['id']));?>
			<?php echo $this->Form->input('Merchanttransaction.statusID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['statusID']));?>
			<?php echo $this->Form->input('Merchanttransaction.id', array('type' => 'hidden','value'=>$ID));?>
  		<?php echo $this->Form->end();?>
          </div>
        </div>
        <!-- display box / second end here -->
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>


<script type="text/javascript">
	function validateTransaction(){
		var x = document.getElementById('MerchanttransactionAvgMonVisaVolume').value;
		var y = document.getElementById('MerchanttransactionAvgVisaTicket').value;
		var z = document.getElementById('MerchanttransactionHighestTicketAmount').value;
		var totaltrantype = parseInt(document.getElementById('MerchanttransactionStoreFrontSwiped').value)+parseInt(document.getElementById('MerchanttransactionInternet').value)+parseInt(document.getElementById('MerchanttransactionMailOrder').value)+parseInt(document.getElementById('MerchanttransactionTelephoneOrder').value);
		var totalinvolve = parseInt(document.getElementById('MerchanttransactionElectronicDataCapture').value)+parseInt(document.getElementById('MerchanttransactionManualEntryWithImpr').value)+parseInt(document.getElementById('MerchanttransactionOnlyManualEntry').value)+parseInt(document.getElementById('MerchanttransactionVoiceAuthCapture').value);
		
		var error ='';
		
		if(x=='')
			error += 'Please Enter Monthly VISA & MC Volume\n';
		if(y=='')
			error += 'Please Enter Average VISA & MC Ticket\n';
		if(z=='')
			error += 'Please Enter Highest Ticket Amount\n';
		if(totaltrantype>100 || totaltrantype<100)	
			error += 'Transaction Type Percentage Should be 100%\n';
		if(totalinvolve>100 || totalinvolve<100)	
			error += 'Transaction Percentage of different capture methods should be 100%\n';
			
		if(error!=''){
			alert(error);			
			return false;
		}else{
			return true;
		}
		
		
	}
	
	function getTransaction(value){
		//alert(value)
		if(value!='0'){
			document.admintransaction.submit();
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