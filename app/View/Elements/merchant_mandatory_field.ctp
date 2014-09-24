<?php 
	$rates_options = $common->getRatesOption();
	$transaction_options = $common->getTransactionOption();
	$OwnerData = $common->getOwnerdata($this->request->data['Merchant']['id']);
	
 if(isset($OwnerData) && count($OwnerData)>0){
	foreach($OwnerData as $key =>$ownerdataval ){
		$this->request->data['Owner']['name'.($key+1)] = $ownerdataval['Owner']['name'];
		$this->request->data['Owner']['title'.($key+1)] = $ownerdataval['Owner']['title'];
		$this->request->data['Owner']['ownership'.($key+1)] = $ownerdataval['Owner']['ownership'];
		$this->request->data['Owner']['dob'.($key+1)] = $ownerdataval['Owner']['dob'];
		$this->request->data['Owner']['licenceNumber'.($key+1)] = $ownerdataval['Owner']['licenceNumber'];
		$this->request->data['Owner']['socialSecurityNumber'.($key+1)] = $ownerdataval['Owner']['socialSecurityNumber'];
		$this->request->data['Owner']['homeAddress'.($key+1)] = $ownerdataval['Owner']['homeAddress'];
		$this->request->data['Owner']['city'.($key+1)] = $ownerdataval['Owner']['city'];
		$this->request->data['Owner']['state'.($key+1)] = $ownerdataval['Owner']['state'];
		$this->request->data['Owner']['zip'.($key+1)] = $ownerdataval['Owner']['zip'];
		$this->request->data['Owner']['homePhone'.($key+1)] = $ownerdataval['Owner']['homePhone'];
	}
} 


?>
<strong>Please enter All the mandatory fields.</strong><br />
   <?php echo $this->Form->create('Mandatory_Field',array('url' => array('controller' => 'merchants', 'action' => 'mandatory_app_field'),'onsubmit'=>'return validate_mandatory_fileds()'))?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr>
                <td valign="top">
                <fieldset>
                  <legend>Business Profile</legend>
                  <table width="100%">
                    <tr>
                      <td width="50%">Legal Name<span style="color:#FF0000">*</span><br/><?php echo $this->Form->input('Merchant.merchantName',array('label'=>false,'div'=>false,'class'=>'input1'));?></td>
                      <td>DBA (name of company)<span style="color:#FF0000">*</span><br/><?php echo $this->Form->input('Merchant.merchantDBA',array('label'=>false,'div'=>false,'class'=>'input1'));?></td>
                    </tr>  
                    <tr>
                      <td>Business Phone<span style="color:#FF0000">*</span><br/><?php echo $this->Form->input('Merchant.contactPhone',array('label'=>false,'div'=>false,'class'=>'input1'));?></td>
                      <td>Contact Email<span style="color:#FF0000">*</span><br/><?php echo $this->Form->input('Merchant.contactEmail',array('label'=>false,'div'=>false,'class'=>'input1'));?></td>
                    </tr>            
                  </table>
                 </fieldset>
                 <fieldset>
                  <legend>Owners/partners /officers</legend>                  
	              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
	                <tr>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Name<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.name1',array('id'=>'Merchant_Ownername1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Title<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.title1',array('id'=>'Merchant_Ownertitle1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left" valign="middle">Equity / Ownership%<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.ownership1',array('id'=>'Merchant_Ownerpercent1','label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                </tr>
	                <tr>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Date of Birth(MM/DD/YYYY)<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.dob1',array('id'=>'Merchant_Ownerdob1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Driver's License #<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.licenceNumber1',array('id'=>'Merchant_Ownerlicence1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left" valign="middle">Social Security #<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.socialSecurityNumber1',array('id'=>'Merchant_Ownerssn1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                </tr>
	                <tr>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Home Address<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.homeAddress1',array('id'=>'Merchant_Owneraddress1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left" width="40%" valign="middle">City<br /><?php echo $this->Form->input('Owner.city1',array('id'=>'Merchant_Ownercity1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                          <td align="left"  width="25%" valign="middle">State<br /><?php echo $this->Form->input('Owner.state1',array('id'=>'Merchant_Ownerstate1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                          <td align="left"  width="25%" valign="middle">Zip<br /><?php echo $this->Form->input('Owner.zip1',array('id'=>'Merchant_Ownerzip1','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left" valign="middle">Home Telephone<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.homePhone1',array('id'=>'Merchant_Ownerphone1','label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>70));?></td>
	                      </tr>
	                    </table>
						<input type="hidden" value="<?php if(isset($OwnerData) && count($OwnerData)>1) echo count($OwnerData); else echo "1"; ?>" id="OwnerCount_Mandatory" name="data[Owner][count]">
						<input type="hidden" value="<?php if(isset($OwnerData) && count($OwnerData)>1) echo count($OwnerData); else echo "1"; ?>" id="OwnerElement_Mandatory" name="data[Owner][element]">
						</td>
	                </tr>					
	             </table>
                  <?php 
			  		if(isset($OwnerData) && count($OwnerData)>1){ 
					foreach($OwnerData as $key => $owner){ if($key>=1) {
				  ?>
				  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form_new">
	                <tr>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Name<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.name'.($key+1),array('id'=>'Merchant_Ownername'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Title<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.title'.($key+1),array('id'=>'Merchant_Ownertitle'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left" valign="middle">Equity / Ownership%<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.ownership'.($key+1),array('id'=>'Merchant_Ownerpercent'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                </tr>
	                <tr>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Date of Birth(MM/DD/YYYY)<br /><?php echo $this->Form->input('Owner.dob'.($key+1),array('id'=>'Merchant_Ownerdob'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Driver's License #<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.licenceNumber'.($key+1),array('id'=>'Merchant_Ownerlicence'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left" valign="middle">Social Security #<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.socialSecurityNumber'.($key+1),array('id'=>'Merchant_Ownerssn'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                </tr>
	                <tr>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left"  valign="middle">Home Address<br /><?php echo $this->Form->input('Owner.homeAddress'.($key+1),array('id'=>'Merchant_Owneraddress'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left" width="40%" valign="middle">City<br /><?php echo $this->Form->input('Owner.city'.($key+1),array('id'=>'Merchant_Ownercity'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                          <td align="left"  width="25%" valign="middle">State<br /><?php echo $this->Form->input('Owner.state'.($key+1),array('id'=>'Merchant_Ownerstate'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                          <td align="left"  width="25%" valign="middle">Zip<br /><?php echo $this->Form->input('Owner.zip'.($key+1),array('id'=>'Merchant_Ownerzip'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                      <tr>
	                        <td align="left" valign="middle">Home Telephone<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.homePhone'.($key+1),array('id'=>'Merchant_Ownerphone'.($key+1),'label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>70));?></td>
	                      </tr>
	                    </table></td>
	                </tr>					
	             </table>
                   <?php } } }?>
                 <div id="divTxt_Mandatory"></div>
                 <table >
                   <tr>
                      <td> <a href="javascript:void(0);" onclick="addOwnerFormField_Mandatory()" style="margin:0 0 10px 10px;float:left;"><strong>Add Another</strong></a></td>
                      <td width="15px;"></td>
                      <td><span style="margin:0 0 10px 10px;float:right;" id="owner-remove"></span></td>
                    </tr>
                 </table>
                 </fieldset>
                 <fieldset>
                  <legend>Banking Information</legend>
                  <table width="100%">
                    <tr>
                      <td width="50%">Bank Contact<span style="color:#FF0000">*</span><br/><?php echo $this->Form->input('Merchant.bankContact',array('id'=>'Merchant_bankcontact','label'=>false,'div'=>false,'class'=>'input1'));?></td>
                      <td>Telephone<span style="color:#FF0000">*</span><br/><?php echo $this->Form->input('Merchant.telephone',array('id'=>'Merchant_bankphone','label'=>false,'div'=>false,'class'=>'input1'));?></td>
                    </tr>  
                    <tr>
                      <td>Transit # (ABA Routing)*<span style="color:#FF0000">*</span><br/><?php echo $this->Form->input('Merchant.transitNumber',array('id'=>'Merchant_banktransit','label'=>false,'div'=>false,'class'=>'input1'));?></td>
                      <td>Account # (DDA)*<span style="color:#FF0000">*</span><br/><?php echo $this->Form->input('Merchant.accountNumber',array('id'=>'Merchant_bankaccount','label'=>false,'div'=>false,'class'=>'input1'));?></td>
                    </tr>            
                  </table>
                 </fieldset>
                 <fieldset>
                  <legend>Rates AND Transactions</legend>
                  <table width="100%">
                    <tr>
                      <td width="50%">Select Rates<br/><?php echo $this->Form->input('Merchant.rate',array('label'=>false,'class'=>'input1','div'=>false,'type'=>'select','options'=>$rates_options,'empty'=>array('0'=>'-Select Rate-')));?></td>
                      <td>Select Transaction<br/><?php echo $this->Form->input('Merchant.transaction',array('label'=>false,'class'=>'input1','div'=>false,'type'=>'select','options'=>$transaction_options,'empty'=>array('0'=>'-Select Transaction-')));?></td>
                    </tr>   
                  </table>
                 </fieldset>                                
                 <table width="100%">
                    <tr height="40">
                      <td align="center" style="padding-top:10px;">
                      <?php echo $this->Form->hidden('Merchant.id')?>
                      <?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'tabindex'=>42));?>                      
                      </td>
                     </tr>   
                  </table>
                </td>
              </tr>                            
     </table>            
<?php echo $this->Form->end();?>  	

<?php if(isset($OwnerData) && count($OwnerData)>0){
	$total_count = count($OwnerData);
}else{
	$total_count = 1;
}
?>
<script type="text/javascript">

var Ccontent_Mandatory ='';
var count_Mandatory = <?php echo $total_count;?>;


function addOwnerFormField_Mandatory() {	
	var i = count_Mandatory+1;
	Ccontent_Mandatory = '<div id="Mandatory_owner_add_more_'+i+'"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form_new"><tr><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Name<span style="color:#FF0000">*</span><br /><input type="text" id="Merchant_Ownername'+i+'" class="input1" name="data[Owner][name'+i+']"></td></tr></table></td><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Title<span style="color:#FF0000">*</span><br /><input type="text" id="Merchant_Ownertitle'+i+'" class="input1" name="data[Owner][title'+i+']"></td></tr></table></td><td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle">Equity / Ownership%<span style="color:#FF0000">*</span><br /><input type="text" id="Merchant_Ownerpercent'+i+'" class="input1" name="data[Owner][ownership'+i+']" onKeyPress="return numbersonly(this, event)"></td></tr></table></td></tr><tr><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Date of Birth(MM/DD/YYYY)<span style="color:#FF0000">*</span><br /><input type="text" id="Merchant_Ownerdob'+i+'" class="input1" name="data[Owner][dob'+i+']"></td></tr></table></td><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Driver\'s License #<span style="color:#FF0000">*</span><br /><input type="text" id="Merchant_Ownerlicence'+i+'" class="input1" name="data[Owner][licenceNumber'+i+']"></td></tr></table></td><td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle">Social Security #<span style="color:#FF0000">*</span><br /><input type="text" id="Merchant_Ownerssn'+i+'" class="input1" name="data[Owner][socialSecurityNumber'+i+']"></td></tr></table></td></tr><tr><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Home Address<span style="color:#FF0000">*</span><br /><input type="text" id="Merchant_Owneraddress'+i+'" class="input1" name="data[Owner][homeAddress'+i+']"></td></tr></table></td><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" width="40%" valign="middle">City<br /><input type="text" id="Merchant_Ownercity'+i+'" class="input1" name="data[Owner][city'+i+']"></td><td align="left"  width="25%" valign="middle">State<br /><input type="text" id="Merchant_Ownerstate'+i+'" class="input1" name="data[Owner][state'+i+']"></td><td align="left"  width="25%" valign="middle">Zip<br /><input type="text" id="Merchant_Ownerzip'+i+'" class="input1" name="data[Owner][zip'+i+']"></td></tr></table></td><td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle">Home Telephone<span style="color:#FF0000">*</span><br /><input type="text" id="Merchant_Ownerphone'+i+'" class="input1" name="data[Owner][homePhone'+i+']" onKeyPress="return numbersonly(this, event)"></td></tr></table><input type="hidden" value="'+i+'" id="OwnerCount_Mandatory" name="data[Owner][count]"></td></tr></table></div>';
	$('#divTxt_Mandatory').append(Ccontent_Mandatory);
	document.getElementById("OwnerElement_Mandatory").value = i;	
	count_Mandatory = count_Mandatory + 1;
	if(count_Mandatory>1)
		document.getElementById("owner-remove").innerHTML = '<a href="javascript:void(0);" onclick="removeOwnerFormField_Mandatory(\'Mandatory_owner_add_more_'+i+'\')" >Remove</a>';
	
	addDatePick(i);
}
function removeOwnerFormField_Mandatory(removeID){
	var child = document.getElementById(removeID);
	var parent = document.getElementById('divTxt_Mandatory');
	parent.removeChild(child);
	count_Mandatory = count_Mandatory - 1;	
	document.getElementById("OwnerElement_Mandatory").value = count_Mandatory;
	Ccontent_Mandatory ='';
	element = parseInt(document.getElementById('OwnerCount_Mandatory').value);
	
	if(count_Mandatory>element)
		document.getElementById("owner-remove").innerHTML = '<a href="javascript:void(0);" onclick="removeOwnerFormField_Mandatory(\'Mandatory_owner_add_more_'+count_Mandatory+'\')" >Remove</a>';
	else
		document.getElementById("owner-remove").innerHTML= '';
}
function addDatePick(counterrr){	
	jQuery.noConflict();
	jQuery("#Merchant_Ownerdob"+counterrr).datepicker({
	  dateFormat: "mm/dd/yy",
      changeMonth: true,
      changeYear: true,
      maxDate : Date(),
	  yearRange : '1950:'+Date()
    });
}

function validate_mandatory_fileds(){	
		var errormessge = '';		
		var legalname 		= document.getElementById('MerchantMerchantName').value;
		var dbaname			= document.getElementById('MerchantMerchantDBA').value;
		var businessphone	= document.getElementById('MerchantContactPhone').value;
		var contactemail	= document.getElementById('MerchantContactEmail').value;
		
		var bankingcontact  = document.getElementById('Merchant_bankcontact').value;
		var transitnum 		= document.getElementById('Merchant_banktransit').value;
		var telephone 		= document.getElementById('Merchant_bankphone').value;
		var accountnum 		= document.getElementById('Merchant_bankaccount').value;
		
		var merchantrate	= document.getElementById('MerchantRate').value;
		var merchantrans	= document.getElementById('MerchantTransaction').value;		
		
		
		if(legalname==''){
			errormessge +=  "Please enter legal name\n";
		}
		if(dbaname==''){
			errormessge +=  "Please enter DBA name\n";
		}
		if(businessphone==''){
			errormessge +=  "Please enter business telephone\n";
		}
		if(contactemail==''){
			errormessge +=  "Please enter valid contact email\n";
		}
		
		var cnt = parseInt(document.getElementById('OwnerElement_Mandatory').value);
		var i=1;
		var total_percent = 0;
		for(i=1;i<=cnt;i++){
			if(document.getElementById('Merchant_Ownername'+i).value==''){
				errormessge += "Please Enter Owner Name\n";		
			}
			if(document.getElementById('Merchant_Ownertitle'+i).value==''){
				errormessge += "Please Enter Owner Title\n";			
			}
			
			if(document.getElementById('Merchant_Ownerpercent'+i).value==''){
				errormessge += "Please Enter Ownership % value\n";			
			}else{
				total_percent = total_percent + parseInt(document.getElementById('Merchant_Ownerpercent'+i).value);
			}
			
			if(document.getElementById('Merchant_Ownerdob'+i).value==''){
				errormessge += "Please Enter Date of Birth value\n";			
			}
			if(document.getElementById('Merchant_Ownerlicence'+i).value==''){
				errormessge += "Please Enter Drivers License Number\n";		
			}
			if(document.getElementById('Merchant_Owneraddress'+i).value==''){
				errormessge += "Please Enter Owner Home Address\n";		
			}
			if(document.getElementById('Merchant_Ownerphone'+i).value==''){
				errormessge += "Please Enter Owner Phone Number\n";		
			}			
		}

		if(total_percent<50){
			errormessge += "Total Ownership percent should be greater than 50%\n";	
		}
		
		if(bankingcontact==''){
			errormessge +=  "Please enter banking contact\n";
		}
		if(transitnum==''){
			errormessge +=  "Please enter banking transit number\n";
		}
		if(telephone==''){
			errormessge +=  "Please enter banking telephone\n";
		}
		if(accountnum==''){
			errormessge +=  "Please enter merchant account number\n";
		}
		
		/* task id 2436 commnet on 21 NOv 2013
		if(merchantrate==0){
			errormessge +=  "Please select merchant rates\n";
		}
		if(merchantrans==0){
			errormessge +=  "Please enter merchant transaction\n";
		}*/
				
		if(errormessge!=''){
			alert("* All fields marked with a red asterisk character are mandatory\n\n"+errormessge);
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

jQuery(function() {
	jQuery( "#Merchant_Ownerdob1" ).datepicker({
		dateFormat: "mm/dd/yy",
	    changeMonth: true,
	    changeYear: true,
	    maxDate : Date(),
		yearRange : '1950:'+Date()
    });
  });
</script>