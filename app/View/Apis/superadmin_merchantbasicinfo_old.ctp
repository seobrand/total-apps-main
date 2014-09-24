<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<?php
 if(!is_array($this->request->data['Merchant']['merchantType']) && $this->request->data['Merchant']['merchantType']!=''){
	$this->request->data['Merchant']['merchantType'] = explode(",",$this->request->data['Merchant']['merchantType']);
}
 ?>
  
 <?php echo $this->Form->create('Api',array('controller'=>'apis','action'=>'merchantbasicinfo')); ?>
            <div class="application_form">
              <div class="product_search_indent">
                <div class="product_search_title">Business Profile</div>
                <div class="applicationform_bg">
                <span class="validation_info">&nbsp;* All fields marked with a red asterisk character are mandatory.</span>
                  <table class="applicationform_table">
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>LEGAL NAME:</th>
                      <td><?php echo $this->Form->input('Merchant.merchantName',array('label'=>false,'div'=>false,'class'=>'input_01'));?></td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL ADDRESS: </th>
                      <td><?php echo $this->Form->input('Merchant.legalAddress',array('label'=>false,'div'=>false,'class'=>'input_01'));?>
                        (NO PO BOX)</td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL ADDRESS #2: </th>
                      <td><?php echo $this->Form->input('Merchant.legalAddress2',array('label'=>false,'div'=>false,'class'=>'input_01'));?></td>
                    </tr>
                    <tr>
                      <th scope="row"> LEGAL CITY: </th>
                      <td><?php echo $this->Form->input('Merchant.legalCity',array('label'=>false,'div'=>false,'class'=>'input_01'));?></td>
                    </tr>
                    <tr>
                      <th scope="row">LEGAL STATE:</th>
                      <td><?php echo $this->Form->input('Merchant.legalState',array('type'=>'select','options'=>$stateList,'class'=>'select_01','div'=>false,'label'=>false));?></td>
                    </tr>
                    <tr>
                      <th scope="row">LEGAL ZIP:</th>
                      <td><?php echo $this->Form->input('Merchant.legalZip',array('label'=>false,'div'=>false,'class'=>'input_01','maxlength'=>5));?>
                        (5 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>BUSINESS PHONE:</th>
                      <td><?php echo $this->Form->input('Merchant.contactPhone',array('label'=>false,'div'=>false,'class'=>'input_01','onblur'=>"formatPhoneNumber('MerchantContactPhone')",'maxlength'=>10));?></td>
                    </tr>
                    <tr>
                      <th scope="row"> EIN or SSN Tax ID#:<br>
                        <span>(appears on income tax return)</span> </th>
                      <td><?php echo $this->Form->input('Merchant.federalTaxId',array('label'=>false,'div'=>false,'class'=>'input_01','maxlength'=>9));?>(9 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row">BUSINESS START DATE:</th>
                      <td><?php echo $this->Form->input('Merchant.startDate',array('label'=>false,'div'=>false,'class'=>'input_01'));?>
                        (mm/dd/yyyy)</td>
                    </tr>
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>PRIMARY EMAIL CONTACT:</th>
                      <td><?php echo $this->Form->input('Merchant.contactEmail',array('label'=>false,'div'=>false,'class'=>'input_01'));?></td>
                    </tr>
                    <tr>
                      <th scope="row">BUSINESS CATEGORY:</th>
                      <td><?php echo $this->Form->input('Merchant.merchantType',array('type'=>'select','options' => array(''=>'-Select Business Category-','Sole Proprietor' => 'Sole Proprietor','Partnership' => 'Partnership','Private Corp.' => 'Private Corp.','Tax Exempt' => 'Tax Exempt','LLC' => 'LLC'),'class'=>'select_01','div'=>false,'label'=>false));?></td>
                    </tr>
                    <tr>
                      <th scope="row">&nbsp;</th>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
            <div class="application_form mart25">
              <div class="product_search_indent">
                <div class="product_search_title">Tell Us About your Business!</div>
                <div class="applicationform_bg">
                  <table class="applicationform_table">
                    <tr>
                      <th scope="row"><span class="validation_info">*</span>DBA (name of company):</th>
                      <td><?php echo $this->Form->input('Merchant.merchantDBA',array('label'=>false,'div'=>false,'class'=>'input_01'));?>
                        <input type="checkbox" id="sameas" onclick="sameAsLegalInfo()">
                        same as above </td>
                    </tr>
                    <tr>
                      <th scope="row"> DBA ADDRESS: </th>
                      <td><?php echo $this->Form->input('Merchant.dbaAddress',array('label'=>false,'div'=>false,'class'=>'input_01'));?>
                        (NO PO BOX)</td>
                    </tr>
                    <tr>
                      <th scope="row"> DBA CITY: </th>
                      <td><?php echo $this->Form->input('Merchant.dbaCity',array('label'=>false,'div'=>false,'class'=>'input_01'));?></td>
                    </tr>
                    <tr>
                      <th scope="row">DBA STATE:</th>
                      <td><?php echo $this->Form->input('Merchant.dbaState',array('type'=>'select','options'=>$stateList,'class'=>'select_01','div'=>false,'label'=>false));?></td>
                    </tr>
                    <tr>
                      <th scope="row">DBA ZIP:</th>
                      <td><?php echo $this->Form->input('Merchant.dbaZip',array('label'=>false,'div'=>false,'class'=>'input_01','maxlength'=>5));?>
                        (5 digits)</td>
                    </tr>
                    <tr>
                      <th scope="row">CUSTOMER SERVICE PHONE:</th>
                      <td><?php echo $this->Form->input('Merchant.customerServicePhone',array('label'=>false,'div'=>false,'class'=>'input_01','onblur'=>"formatPhoneNumber('MerchantCustomerServicePhone')",'maxlength'=>10));?></td>
                    </tr>
                    <tr>
                      <th scope="row">FAX # (Optional):</th>
                      <td><?php echo $this->Form->input('Merchant.businessFax',array('label'=>false,'div'=>false,'class'=>'input_01'));?></td>
                    </tr>
                    <tr>
                      <th scope="row">WEBSITE URL:</th>
                      <td><?php echo $this->Form->input('Merchant.merchantURL',array('label'=>false,'div'=>false,'class'=>'input_01'));?></td>
                    </tr>
                    <tr>
                      <th scope="row">&nbsp;</th>
                      <td>&nbsp;</td>
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
          <?php echo $this->Form->input('Processor.user_Name',array('type'=>'hidden','value'=>$this->request->data['Processor']['user_Name']));?>
		<?php echo $this->Form->end();?>
 
 
 
 <script type="text/javascript">
 function sameAsLegalInfo(){
	if(document.getElementById('sameas').checked){
	document.getElementById('MerchantMerchantDBA').value = document.getElementById('MerchantMerchantName').value;
	document.getElementById('MerchantDbaAddress').value = document.getElementById('MerchantLegalAddress').value;
	document.getElementById('MerchantDbaCity').value = document.getElementById('MerchantLegalCity').value;
	document.getElementById('MerchantDbaState').value = document.getElementById('MerchantLegalState').value;
	document.getElementById('MerchantDbaZip').value = document.getElementById('MerchantLegalZip').value;
	document.getElementById('MerchantCustomerServicePhone').value = document.getElementById('MerchantContactPhone').value;
	}else{
		document.getElementById('MerchantMerchantDBA').value = "";
		document.getElementById('MerchantDbaAddress').value = "";
		document.getElementById('MerchantDbaCity').value = "";
		document.getElementById('MerchantDbaState').value = "-- Select --";
		document.getElementById('MerchantDbaZip').value = "";
		document.getElementById('MerchantCustomerServicePhone').value = "";
	}
 }

 function formatPhoneNumber(id){
	 val = document.getElementById(id).value;
	 arrChars=val.split('');
	 formatedString='';
	 if(val.length==10){
		 for(i=0;i < val.length;i++){
			 if(i==3)
			 formatedString+='-';
			 if(i==6)
			 formatedString+='-';
		
			 formatedString+=arrChars[i];
		 }
		 document.getElementById(id).value=formatedString;
	 }
 } 

 $(function() {
	    $( "#MerchantStartDate" ).datepicker({
	      changeMonth: true,
	      changeYear: true
	    });	   
	}); 
 </script>
 
