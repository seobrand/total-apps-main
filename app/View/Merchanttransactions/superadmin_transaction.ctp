<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">  <div class="titlebar">ADMIN TRANSACTION
	  	<div style="float:right">
         	<a href="<?php echo $this->webroot; ?>superadmin/merchanttransactions/transactionlist/"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
        </div>
	  </div>
        <!-- display box / first -->
        <div class="display_row">
          <div class="tabs_des">
  		  <?php  echo $this->Form->create('Merchanttransaction',array('controller'=>'merchanttransaction','action'=>'transaction','onsubmit'=>'return validateTransaction();','name'=>'transaction'))?> 
		  <div class="box1">
		  	<div class="news_announcement">
                <div class="titlebar">Name</div>
                <div class="news_indent">
					<table width="50%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
						<td width="10%" align="left">Name*</td>
						<td><?php echo $this->Form->input('Merchanttransaction.adminName',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                    </tr>
                  </table>
				</div>
			</div>
		  </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Transaction Information</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td colspan="2" align="left" valign="middle" class="rpadnone"><strong class="blue"s>Sales Information</strong></td>
                    </tr>
                    <tr>
                      <td width="28%" align="left" valign="middle" class="rpadnone">Average Monthly VISA & MC Volume&nbsp;$ </td>
                      <td width="72%" align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.avgMonVisaVolume',array('label'=>false,'class'=>'input2','div'=>false));?>
                        <sup class="red">*</sup></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Average VISA & MC Ticket&nbsp;$ </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.avgVisaTicket',array('label'=>false,'class'=>'input2','div'=>false));?>
                        <sup class="red">*</sup></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Highest Ticket Amount&nbsp;$ </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.highestTicketAmount',array('label'=>false,'class'=>'input2','div'=>false));?>
                        <sup class="red">*</sup></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Seasonal Highest Monthly Volume&nbsp;$ </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.seasonalHighMonVolume',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Recurring Billing</td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.recurring_billing',array('label'=>false,'class'=>'input1','div'=>false,'type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'empty'=>'-Select Recurring Billing-','style'=>'width:370px;'));?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="middle" class="rpadnone" style="padding-top:16px;"><strong class="blue">Transaction Type Percentage</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Store Front/Swiped&nbsp;% </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.storeFrontSwiped',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Internet&nbsp;% </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.internet',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Mail Order&nbsp;% </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.mailOrder',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Telephone Order&nbsp;% </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.telephoneOrder',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone"><strong>Total&nbsp;% </strong></td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.transactionTotal',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="middle" class="rpadnone" style="padding-top:16px;"><strong class="blue">How is transaction completed?</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Electronic data capture (swiped)&nbsp;% </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.electronicDataCapture',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Manual entry with Impr&nbsp;% </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.manualEntryWithImpr',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Manual entry, no card present, no imprint&nbsp;% </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.onlyManualEntry',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Voice Authorization and Capture&nbsp;% </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.voiceAuthCapture',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone"><strong>Total&nbsp;%</strong></td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchanttransaction.entryTypeTotal',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
					<tr>
                      <td align="left" valign="middle" class="rpadnone">&nbsp;</td>
                      <td align="left" valign="middle">
					  <?php if($ID!=''){ echo $this->Form->submit('Update Transaction',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false)); }else{ echo $this->Form->submit('Add Transaction',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false)); }?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
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
		var error ='';
		
		if(x=='')
			error += 'Please Enter Monthly VISA & MC Volume\n';
		if(y=='')
			error += 'Please Enter Average VISA & MC Ticket\n';
		if(z=='')
			error += 'Please Enter Highest Ticket Amount\n';
			
		if(error!=''){
			alert(error);			
			return false;
		}else{
			return true;
		}
		
		
	}
</script>