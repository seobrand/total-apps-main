
function trim(s) { 
    s = s.replace(/(^\s*)|(\s*$)/gi,"");
    s = s.replace(/[ ]{2,}/gi," "); 
    s = s.replace(/\n /,"\n"); return s;
}

function validation(form)
{
	
	var validation="";

	var company1 = form.merchantName.value;
	var company =trim(company1);	

	var phone1= form.contactPhone.value;
	var phone =trim(phone1);
	
	var email1 = form.contactEmail.value;
	var email =trim(email1);

	var merchantdba = form.merchantDBA.value;
	var merchantdba =trim(merchantdba);
	
	var salesVolume1 = form.volume.value;
	var salesVolume =trim(salesVolume1);

	//var security = form.secure_captcha.value;

	var numbers = /^[0-9]+$/;
	
	if(company=='')
	{	
		validation ='Please Enter Legal Name\n';
	}
	
	var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
	
	if(phone =='')
	{	
		validation +='Please Enter Business Phone\n';
	}else if(!phone.match(regexObj)){
		validation +='Please Enter Business Phone Number in 10 digits\n';
	}

	if(email=='')
	{
		validation +='Please Enter Contact Email\n';
	}else if(email!='')
	{	
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (filter.test(email)) 
		{			}
		else{
			validation +='Please Enter Valid E-mail Address\n';
		}
	}

	if(salesVolume=='')
	{	
		validation +='Please Enter Monthly Sales Volume\n';
	}else
	{
		filter = /^[0-9]+$/;
		if (filter.test(salesVolume)) 
		{}else{
			validation +='Volume Must be Numeric\n';
		}
	}
	
	if(merchantdba==''){
		validation +='Please Enter DBA Name\n';
	}
	
	var cnt = parseInt(document.getElementById('OwnerElement').value);
	var i=1;
	for(i=1;i<=cnt;i++){
		if(trim(document.getElementById('OwnerName'+i).value)==''){
			validation += "Please Enter Owner Name\n";		
		}
		if(trim(document.getElementById('OwnerTitle'+i).value)==''){
			validation += "Please Enter Owner Title\n";			
		}
		if(trim(document.getElementById('OwnerOwnership'+i).value)==''){
			validation += "Please Enter Ownership % value\n";			
		}
		/*if(trim(document.getElementById('OwnerLicenceNumber'+i).value)==''){
			validation += "Please Enter Drivers License Number\n";		
		}*/
		if(trim(document.getElementById('OwnerSocialSecurityNumber'+i).value)==''){
			validation += "Please Enter Owner Social Security Number\n";			
		}
		if(trim(document.getElementById('OwnerHomePhone'+i).value)==''){
			validation += "Please Enter Owner Home Phone\n";		
		}
	}
	
	
	var avgMonVisaVolume = form.avgMonVisaVolume.value;
	var avgMonVisaVolume =	trim(avgMonVisaVolume);
	if(avgMonVisaVolume==''){
		validation +='Please Enter Estimate Monthly Sales Volume\n';
	}
	
	var avgVisaTicket = form.avgVisaTicket.value;
	var avgVisaTicket =	trim(avgVisaTicket);
	if(avgVisaTicket==''){
		validation +='Please Enter Estimate Average Transaction Size\n';
	}
	
	var highestTicketAmount = form.highestTicketAmount.value;
	var highestTicketAmount =	trim(highestTicketAmount);
	if(highestTicketAmount==''){
		validation +='Please Enter Estimate Maximum Transaction Size\n';
	}
	
	var bankContact = form.bankContact.value;
	var bankContact =	trim(bankContact);
	if(bankContact==''){
		validation +='Please Enter Account Holder Name\n';
	}
	
	var bankContact = form.bankContact.value;
	var bankContact =	trim(bankContact);
	if(bankContact==''){
		validation +='Please Enter Account Number\n';
	}
	
	var transitNumber = form.transitNumber.value;
	var transitNumber =	trim(transitNumber);
	if(transitNumber==''){
		validation +='Please Enter ABA/Routing Number\n';
	}
	
	if(validation)
	{
		jAlert(validation, 'Message');
		
	//	alert('TESTER');
		//alert(validation);
		return false;
	}else
	{
		return true;
	}		

}





function textCounter(field,cntfield,maxlimit) {

	if (field.value.length > maxlimit) // if too long...trim it!

field.value = field.value.substring(0, maxlimit);

// otherwise, update 'characters left' counter

	else

	cntfield.value = maxlimit - field.value.length;

}



var Ccontent ='';
//var count = parseInt(document.getElementById('OwnerCount').value);
var count = 1;

function addOwnerFormField() {	
	var i = count+1;
	Ccontent = '<div id="owner_add_more_'+i+'"><table class="applicationform_table" style="width:95%;margin-bottom:20px;"><tr><td><span class="validation_info">*</span>Name:<br><input name="name'+i+'" class="text_box" type="text" id="OwnerName'+i+'"/></td><td><span class="validation_info">*</span>Title:(Owner,Pres.,CEO,etc.)<br><input name="title'+i+'" class="text_box" type="text" id="OwnerTitle'+i+'"/></td></tr><tr><td><span class="validation_info">*</span>Owner ship %:<br><input name="ownership'+i+'" class="text_box" type="text" id="OwnerOwnership'+i+'" maxlength="3" onKeyPress="return numbersonly(this, event)"/></td><td><span class="validation_info">*</span>SSN:<br><input name="socialSecurityNumber'+i+'" class="text_box" type="text" id="OwnerSocialSecurityNumber'+i+'" maxlength="9" onblur="formatSSNNumber(\'OwnerSocialSecurityNumber'+i+'\')"/></td></tr><tr><td>Home address:<br><input name="homeAddress'+i+'" class="text_box" type="text" id="OwnerHomeAddress'+i+'"/></td><td>Home city:<br><input name="city'+i+'" class="text_box" type="text" id="OwnerCity'+i+'"/></td></tr><tr><td>Home State:<br><select id="OwnerState'+i+'" class="text_box" style="width:320px;" name="state'+i+'"><option value="-Select State-">-Select State-</option><option value="Alabama">Alabama</option><option value="Alaska">Alaska</option><option value="Arizona">Arizona</option><option value="Arkansas">Arkansas</option><option value="California">California</option><option value="Colorado">Colorado</option><option value="Connecticut">Connecticut</option><option value="Delaware">Delaware</option><option value="District of Columbia">District of Columbia</option><option value="Florida">Florida</option><option value="Georgia">Georgia</option><option value="Hawaii">Hawaii</option><option value="Idaho">Idaho</option><option value="Illinois">Illinois</option><option value="Indiana">Indiana</option><option value="Iowa">Iowa</option><option value="Kansas">Kansas</option><option value="Kentucky">Kentucky</option><option value="Louisiana">Louisiana</option><option value="Maine">Maine</option><option value="Maryland">Maryland</option><option value="Massachusetts">Massachusetts</option><option value="Michigan">Michigan</option><option value="Minnesota">Minnesota</option><option value="Mississippi">Mississippi</option><option value="Missouri">Missouri</option><option value="Montana">Montana</option><option value="Nebraska">Nebraska</option><option value="Nevada">Nevada</option><option value="New Hampshire">New Hampshire</option><option value="New Jersey">New Jersey</option><option value="New Mexico">New Mexico</option><option value="New York">New York</option><option value="North Carolina">North Carolina</option><option value="North Dakota">North Dakota</option><option value="Ohio">Ohio</option><option value="Oklahoma">Oklahoma</option><option value="Oregon">Oregon</option><option value="Pennsylvania">Pennsylvania</option><option value="Rhode Island">Rhode Island</option><option value="South Carolina">South Carolina</option><option value="South Dakota">South Dakota</option><option value="Tennessee">Tennessee</option><option value="Texas">Texas</option><option value="Utah">Utah</option><option value="Vermont">Vermont</option><option value="Virginia">Virginia</option><option value="Washington">Washington</option><option value="West Virginia">West Virginia</option><option value="Wisconsin">Wisconsin</option><option value="Wyoming">Wyoming</option></select></td><td>Home zip:<br><input name="zip'+i+'" class="text_box" maxlength="5" type="text" id="OwnerZip'+i+'"/></td></tr><tr><td>Date of Birth:(MM/DD/YYYY)<br><input name="dob'+i+'" class="text_box" type="text" id="OwnerDob'+i+'"/></td><td><span class="validation_info">*</span>Home/Cell Phone:<br><input name="homePhone'+i+'" class="text_box" type="text" id="OwnerHomePhone'+i+'" maxlength="10" onblur="formatPhoneNumber(\'OwnerHomePhone'+i+'\')" onKeyPress="return numbersonly(this, event)"/></td></tr><tr></tr><input type="hidden" value="'+i+'" id="OwnerCount" name="count"></table></div>';
	jQuery('#divTxt').append(Ccontent);
	document.getElementById("OwnerElement").value = i;
	count = count + 1;
	if(count>1)
		document.getElementById("owner-remove").innerHTML = '<a href="javascript:void(0);" onclick="removeOwnerFormField(\'owner_add_more_'+i+'\')" >Remove</a>';
	
	addDatePick(i);
}

function addDatePick(counterrr){	
	 jQuery("#OwnerDob"+counterrr).datepicker({
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
	if(count>1)
		document.getElementById("owner-remove").innerHTML = '<a href="javascript:void(0);" onclick="removeOwnerFormField(\'owner_add_more_'+count+'\')" >Remove</a>';
	else
		document.getElementById("owner-remove").innerHTML= '';
		
	//$("#divTxt").hide();
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
		if((document.getElementById('OwnerZip'+i).value.length>0) && (document.getElementById('OwnerZip'+i).value.length<5)){
			error += "Please Enter Zip Code in 5 digits\n";
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
		
	}

	if(errorcnt > 0){
		jAlert(error, 'Message');
		
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
 
