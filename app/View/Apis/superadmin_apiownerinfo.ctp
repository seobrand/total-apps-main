<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
  
<?php //pr($OwnerData);
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


  <div id="started_outer">
    <div class="started_inner">
      <div class="started_title">Owners/Officers</div>
      <div id="started_box" class="clearfix">
        <div  style="width:90%;margin:auto"> 


<?php  echo $this->Form->create('Api',array('controller'=>'apis','action'=>'apiownerinfo','onsubmit'=>'return ownerInfoValidate()')); ?>
<?php if($this->Session->check('response')){?>
<p class="error"><?php echo $this->Session->read('response');?></p>
<?php }?>
	<div class="application_form">
		<div class="product_search_indent">
			<?php /*?><div class="product_search_title">Owners/Officers</div><?php */?>
			<div class="applicationform_bg">
			<span class="validation_info">&nbsp;* All fields marked with a red asterisk character are mandatory.</span>
				<table class="applicationform_table  table_font" style="width:95%;margin-bottom: 30px;border-bottom:1px solid #666666">
					<tr>
						<td><span class="validation_info">*</span>Name:<br>
						 <?php echo $this->Form->input('Owner.name1',array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
						<td><span class="validation_info">*</span>Title:(Owner,Pres.,CEO,etc.)<br>
						<?php echo $this->Form->input('Owner.title1',array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
					</tr>
					<tr>
						<td><span class="validation_info">*</span>Owner ship %:<br>
						 <?php echo $this->Form->input('Owner.ownership1',array('label'=>false,'class'=>'input_start','div'=>false,'onKeyPress'=>"return numbersonly(this, event)",'maxlength'=>3));?>
						</td>
						<td><span class="validation_info">*</span>SSN:<br>
						<?php echo $this->Form->input('Owner.socialSecurityNumber1',array('label'=>false,'class'=>'input_start','div'=>false,'onblur'=>"formatSSNNumber('OwnerSocialSecurityNumber1')",'maxlength'=>9));?>
						</td>
					</tr>					
					<tr>
						<td><span class="validation_info">*</span>Home address:<br>
						 <?php echo $this->Form->input('Owner.homeAddress1',array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
						<td>Home city:<br>
						<?php echo $this->Form->input('Owner.city1',array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
					</tr>
					<tr>
						<td>Home State:<br>
						<?php echo $this->Form->input('Owner.state1',array('type'=>'select','options'=>$stateList,'class'=>'input_start selectbox','div'=>false,'label'=>false));?>
						</td>
						<td>Home zip:<br>
						<?php echo $this->Form->input('Owner.zip1',array('label'=>false,'class'=>'input_start','div'=>false,'maxlength'=>5));?>
						</td>
					</tr>
					<tr>
						<td><span class="validation_info">*</span>Date of Birth:(MM/DD/YYYY)<br>
						 <?php echo $this->Form->input('Owner.dob1',array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
						<td><span class="validation_info">*</span>Home/Cell Phone:<br>
						<?php echo $this->Form->input('Owner.homePhone1',array('label'=>false,'class'=>'input_start','div'=>false,'onKeyPress'=>"return numbersonly(this, event)",'onblur'=>"formatPhoneNumber('OwnerHomePhone1')",'maxlength'=>10));?>
						</td>
					</tr>
					<tr>
						<td><span class="validation_info">*</span>Driver's License #<br>
						 <?php echo $this->Form->input('Owner.licenceNumber1',array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>						
					</tr>										
				</table>
				<input type="hidden" value="<?php if(isset($OwnerData) && count($OwnerData)>1) echo count($OwnerData); else echo "1"; ?>" id="OwnerCount" name="data[Owner][count]">
                <input type="hidden" value="<?php if(isset($OwnerData) && count($OwnerData)>1) echo count($OwnerData); else echo "1"; ?>" id="OwnerElement" name="data[Owner][element]">
				<div class="clear"></div>
				<?php 
			 	 if(isset($OwnerData) && count($OwnerData)>1){ 
					foreach($OwnerData as $key => $owner){ if($key>=1) {
				?>
				<table class="applicationform_table  table_font" style="width:95%;margin-bottom: 30px;border-bottom:1px solid #666666">
					<tr>
						<td><span class="validation_info">*</span>Name:<br>
						 <?php echo $this->Form->input('Owner.name'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
						<td><span class="validation_info">*</span>Title:(Owner,Pres.,CEO,etc.)<br>
						<?php echo $this->Form->input('Owner.title'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
					</tr>
					<tr>
						<td><span class="validation_info">*</span>Owner ship %:<br>
						 <?php echo $this->Form->input('Owner.ownership'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false,'onKeyPress'=>"return numbersonly(this, event)",'maxlength'=>3));?>
						</td>
						<td><span class="validation_info">*</span>SSN:<br>
						<?php echo $this->Form->input('Owner.socialSecurityNumber'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false,'onblur'=>'formatSSNNumber("OwnerSocialSecurityNumber'.($key+1).'")','maxlength'=>9));?>
						</td>
					</tr>					
					<tr>
						<td><span class="validation_info">*</span>Home address:<br>
						 <?php echo $this->Form->input('Owner.homeAddress'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
						<td>Home city:<br>
						<?php echo $this->Form->input('Owner.city'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
					</tr>
					<tr>
						<td>Home State:<br>
						 <?php echo $this->Form->input('Owner.state'.($key+1),array('type'=>'select','options'=>$stateList,'class'=>'select_01 selectbox','div'=>false,'label'=>false));?>
						</td>
						<td>Home zip:<br>
						<?php echo $this->Form->input('Owner.zip'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false,'maxlength'=>5));?>
						</td>
					</tr>
					<tr>
						<td><span class="validation_info">*</span>Date of Birth:(MM/DD/YYYY)<br>
						 <?php echo $this->Form->input('Owner.dob'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
						<td><span class="validation_info">*</span>Home/Cell Phone:<br>
						<?php echo $this->Form->input('Owner.homePhone'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false,'onKeyPress'=>"return numbersonly(this, event)",'onblur'=>'formatPhoneNumber("OwnerHomePhone'.($key+1).'")','maxlength'=>10));?>
						</td>
					</tr>
					<tr>
						<td><span class="validation_info">*</span>Driver's License #<br>
						 <?php echo $this->Form->input('Owner.licenceNumber'.($key+1),array('label'=>false,'class'=>'input_start','div'=>false));?>
						</td>
					</tr>									
				</table>
				<?php } } }?>
				<div style="display: block;" id="divTxt"></div>
					<table >
                    	<tr>
                        	<td> <a href="javascript:void(0);" onclick="addOwnerFormField()" style="margin:0 0 10px 10px;float:left;"><strong>Add Another</strong></a></td>
                            <td width="15px;"></td>
                            <td><span style="margin:0 10px 0px 0px;float:right;" id="owner-remove"></span></td>
                        </tr>
                    </table>
                   
					
                    
                    
			</div>
		</div>
	</div>

	<div class="form_button" style="float:right">
		<?php echo $this->Form->submit('/img/online_appform/next-bt.jpg',array('div'=>false,'style'=>'margin-right:35px;')); ?>      
	</div>
    <br /><br />
	<?php echo $this->Form->input('Merchant.id', array('type' => 'hidden','value'=>$id));?>
<?php echo $this->Form->end();?>
<br /><br /><br /><br />

 </div>
      </div>
    </div>
  </div>





<script type="text/javascript">
var Ccontent ='';
var count = parseInt(document.getElementById('OwnerCount').value);


function addOwnerFormField() {	
	var i = count+1;
	Ccontent = '<div id="owner_add_more_'+i+'"><table class="applicationform_table  table_font" style="width:95%;margin-bottom:20px;border-bottom:1px solid #666666"><tr><td><span class="validation_info">*</span>Name:<br><input name="data[Owner][name'+i+']" class="input_start" type="text" id="OwnerName'+i+'"/></td><td><span class="validation_info">*</span>Title:(Owner,Pres.,CEO,etc.)<br><input name="data[Owner][title'+i+']" class="input_start" type="text" id="OwnerTitle'+i+'"/></td></tr><tr><td><span class="validation_info">*</span>Owner ship %:<br><input name="data[Owner][ownership'+i+']" class="input_start" type="text" id="OwnerOwnership'+i+'" maxlength="3" onKeyPress="return numbersonly(this, event)"/></td><td><span class="validation_info">*</span>SSN:<br><input name="data[Owner][socialSecurityNumber'+i+']" class="input_start" type="text" id="OwnerSocialSecurityNumber'+i+'" maxlength="9" onblur="formatSSNNumber(\'OwnerSocialSecurityNumber'+i+'\')"/></td></tr><tr><td><span class="validation_info">*</span>Home address:<br><input name="data[Owner][homeAddress'+i+']" class="input_start" type="text" id="OwnerHomeAddress'+i+'"/></td><td>Home city:<br><input name="data[Owner][city'+i+']" class="input_start" type="text" id="OwnerCity'+i+'"/></td></tr><tr><td>Home State:<br><select id="OwnerState'+i+'" class="input_start selectbox" name="data[Owner][state'+i+']"><option value="-Select State-">-Select State-</option><option value="Alabama">Alabama</option><option value="Alaska">Alaska</option><option value="Arizona">Arizona</option><option value="Arkansas">Arkansas</option><option value="California">California</option><option value="Colorado">Colorado</option><option value="Connecticut">Connecticut</option><option value="Delaware">Delaware</option><option value="District of Columbia">District of Columbia</option><option value="Florida">Florida</option><option value="Georgia">Georgia</option><option value="Hawaii">Hawaii</option><option value="Idaho">Idaho</option><option value="Illinois">Illinois</option><option value="Indiana">Indiana</option><option value="Iowa">Iowa</option><option value="Kansas">Kansas</option><option value="Kentucky">Kentucky</option><option value="Louisiana">Louisiana</option><option value="Maine">Maine</option><option value="Maryland">Maryland</option><option value="Massachusetts">Massachusetts</option><option value="Michigan">Michigan</option><option value="Minnesota">Minnesota</option><option value="Mississippi">Mississippi</option><option value="Missouri">Missouri</option><option value="Montana">Montana</option><option value="Nebraska">Nebraska</option><option value="Nevada">Nevada</option><option value="New Hampshire">New Hampshire</option><option value="New Jersey">New Jersey</option><option value="New Mexico">New Mexico</option><option value="New York">New York</option><option value="North Carolina">North Carolina</option><option value="North Dakota">North Dakota</option><option value="Ohio">Ohio</option><option value="Oklahoma">Oklahoma</option><option value="Oregon">Oregon</option><option value="Pennsylvania">Pennsylvania</option><option value="Rhode Island">Rhode Island</option><option value="South Carolina">South Carolina</option><option value="South Dakota">South Dakota</option><option value="Tennessee">Tennessee</option><option value="Texas">Texas</option><option value="Utah">Utah</option><option value="Vermont">Vermont</option><option value="Virginia">Virginia</option><option value="Washington">Washington</option><option value="West Virginia">West Virginia</option><option value="Wisconsin">Wisconsin</option><option value="Wyoming">Wyoming</option></select></td><td>Home zip:<br><input name="data[Owner][zip'+i+']" class="input_start" maxlength="5" type="text" id="OwnerZip'+i+'"/></td></tr><tr><td><span class="validation_info">*</span>Date of Birth:(MM/DD/YYYY)<br><input name="data[Owner][dob'+i+']" class="input_start" type="text" id="OwnerDob'+i+'"/></td><td><span class="validation_info">*</span>Home/Cell Phone:<br><input name="data[Owner][homePhone'+i+']" class="input_start" type="text" id="OwnerHomePhone'+i+'" maxlength="10" onblur="formatPhoneNumber(\'OwnerHomePhone'+i+'\')" onKeyPress="return numbersonly(this, event)"/></td></tr><tr><td><span class="validation_info">*</span>Driver\'s License #:<br><input name="data[Owner][licenceNumber'+i+']" class="input_start" type="text" id="OwnerLicenceNumber'+i+'"/></td></tr><tr></tr><input type="hidden" value="'+i+'" id="OwnerCount" name="data[Owner][count]"></table></div>';
	$('#divTxt').append(Ccontent);
	document.getElementById("OwnerElement").value = i;
	count = count + 1;
	if(count>1)
		document.getElementById("owner-remove").innerHTML = '<a href="javascript:void(0);" onclick="removeOwnerFormField(\'owner_add_more_'+i+'\')" >Remove</a>';
	
	addDatePick(i);
}

function addDatePick(counterrr){	
	 $("#OwnerDob"+counterrr).datepicker({
	      changeMonth: true,
	      changeYear: true
	    });
}

function removeOwnerFormField(removeID){
	var child = document.getElementById(removeID);
	var parent = document.getElementById('divTxt');
	parent.removeChild(child);
	count = count - 1;
	document.getElementById("OwnerElement").value = count;
	Ccontent ='';
	element = parseInt(document.getElementById('OwnerCount').value);
	if(count>element)
		document.getElementById("owner-remove").innerHTML = '<a href="javascript:void(0);" onclick="removeOwnerFormField(\'owner_add_more_'+count+'\')" >Remove</a>';
	else
		document.getElementById("owner-remove").innerHTML= '';
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

function ownerInfoValidate(){
	var cnt = parseInt(document.getElementById('OwnerElement').value);	
	var i=1;
	var errorcnt = 0;
	var error = "* All fields marked with a red asterisk character are mandatory.\n\n";
	for(i=1;i<=cnt;i++){
		if(document.getElementById('OwnerName'+i).value==''){
			error += "Please Enter Owner Name\n";
			errorcnt++;			
		}
		if(document.getElementById('OwnerTitle'+i).value==''){
			error += "Please Enter Owner Title\n";
			errorcnt++;			
		}
		if(document.getElementById('OwnerOwnership'+i).value==''){
			error += "Please Enter Ownership % value\n";
			errorcnt++;			
		}		
		if(document.getElementById('OwnerSocialSecurityNumber'+i).value==''){
			error += "Please Enter Owner SSN\n";
			errorcnt++;			
		}
		if(document.getElementById('OwnerSocialSecurityNumber'+i).value.length<9){
			error += "Please Enter SSN in 9 digits\n";
			errorcnt++;
		}	
                if(document.getElementById('OwnerHomeAddress'+i).value==''){
			error += "Please Enter Owner Home Address\n";
			errorcnt++;			
		}
		if((document.getElementById('OwnerZip'+i).value.length>0) && (document.getElementById('OwnerZip'+i).value.length<5)){
			error += "Please Enter Zip Code in 5 digits\n";
			errorcnt++;
		}
                if(document.getElementById('OwnerDob'+i).value==''){
			error += "Please Enter Owner Date of Birth\n";
			errorcnt++;			
		}
		if(document.getElementById('OwnerHomePhone'+i).value==''){
			error += "Please Enter Owner Home Phone\n";
			errorcnt++;			
		}
		if(document.getElementById('OwnerHomePhone'+i).value.length<10){
			error += "Please Enter Owner Home Phone in 10 digits\n";
			errorcnt++;
		}
		if(document.getElementById('OwnerLicenceNumber'+i).value==''){
			error += "Please Enter Driver Licence Number\n";
			errorcnt++;			
		}
		
	}

	if(errorcnt > 0){
		alert(error);
		return false;
	}else{
		return true;
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
function formatSSNNumber(id){
	 val = document.getElementById(id).value;
	 arrChars=val.split('');
	 formatedString='';
	 if(val.length==9){
		 for(i=0;i < val.length;i++){
			 if(i==3)
			 formatedString+='-';
			 if(i==5)
			 formatedString+='-';
		
			 formatedString+=arrChars[i];
		 }
		 document.getElementById(id).value=formatedString;
	 }
}
</script>


  
   <script>
  $(function() {
    $( "#OwnerDob1" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange : '1950:'+Date()
    });
    $( "#OwnerDob2" ).datepicker({
        changeMonth: true,
        changeYear: true,
		yearRange : '1950:'+Date()
      });
    $( "#OwnerDob3" ).datepicker({
        changeMonth: true,
        changeYear: true,
		yearRange : '1950:'+Date()
      });
    $( "#OwnerDob4" ).datepicker({
        changeMonth: true,
        changeYear: true,
		yearRange : '1950:'+Date()
      });
    $( "#OwnerDob5" ).datepicker({
        changeMonth: true,
        changeYear: true,
		yearRange : '1950:'+Date()
      });
  }); 
  </script>