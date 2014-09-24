<?php 
$user_id = "Universal-mgr";
$password = "Bob646";
$agent_id = "2";
?>
<script type="text/javascript">
	function validation()
	{
			var validation="";
			var company = $.trim(document.getElementById("company").value);
			var website = $.trim(document.getElementById("website").value);
			var validUrl= validateUrl(website);
			var contact = $.trim(document.getElementById("contact").value);
			
			var phone = $.trim(document.getElementById("phone").value);
			var email = $.trim(document.getElementById("email").value);
			var merchanttype = document.getElementById("merchanttype").value;
			var salesVolume = $.trim(document.getElementById("salesVolume").value);
			
			
			
			
			if(company=='')
			{	
				validation ='Please Enter Company Name\n';
			}
			if(website=='')
			{	
				validation +='Please Enter Website(URL)\n';
			}else if(!validUrl)
			{
				validation +='Please Enter valid Website(URL)\n';
			}
			if(contact=='')
			{	
				validation +='Please Enter Contact Person Name\n';
			}
			if(phone=='')
			{	
				validation +='Please Enter Phone Number\n';
			}/*else
			{
				//var check_phone=/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/
				var check_phone=/^\d{10}(-\d{4})?$/;
				if (check_phone.test(phone)) 
					{
 					
					}
				  else
				  	{
						validation +='Please Enter Valid Phone Number\n';
					}
			}*/
			
			if(email=='')
			{	
				validation +='Please Enter E-mail Address\n';
				
			}
			if(email!='')
			{	
				filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (filter.test(email)) 
					{
 					
					}
				  else
				  	{
						validation +='Please Enter Valid E-mail Address\n';
					}
	
			}
			
			if(merchanttype=='')
			{	
				validation +='Please Select Merchant Type\n';
				
			}
			if(salesVolume=='')
			{	
				validation +='Please Enter Monthly Sales Volume\n';
			}else
			{
				filter = /^[0-9]+$/;
				if (filter.test(salesVolume)) 
					{
 					
					}
				  else
				  	{
						validation +='Volume Must be in Number Format\n';
					}
			
			}
			

			
			if(validation)
			{
			alert(validation);
			return false;
			}else
			{
				document.forms["myform"].submit();
			}
			
	}
	
	function textCounter(field,cntfield,maxlimit) {
		if (field.value.length > maxlimit) // if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
		// otherwise, update 'characters left' counter
		else
		cntfield.value = maxlimit - field.value.length;
	}
	
	  function validateUrl(url) {
       
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if (pattern.test(url)) {
          
            return true;
        } 
           
            return false;

    }
	
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
<div class="content">
  <!-- content / right -->
  <div id="right">
  
    <div class="breadcrumb"></div>
    <div id="right2">
      
      <form name="myform" method="POST" action=""  id="myform">
        <input type="hidden" name="agentID" value="<?php echo $agent_id?>">
        
        <div class="box1">
          <div class="news_announcement">
            <div class="titlebar"><b><font class="submenu1">  To Submit a Merchant Pre-App simply fill out the form below<br></font></b></div>
            <div class="news_indent">
            <div style="clear:both;color:#FF0000;"> 
  <?php  if(!empty($succesMsg)){
  echo $succesMsg;
  }
  
 echo $this->Session->flash();
   ?>
  </div>
              <table width="650" border="0" cellpadding="4" cellspacing="0" class="tableBorder form_table" >
                <tr>
                	<td colspan="3">
                    <div id="message" style="font-size:16px"><strong><?php echo $response; ?></strong></div>
   
      <br>
     
      <i>(*) indicates field is required.</i><br>
                    </td>
                </tr>
                
<tr>
<td valign="top">* Company Name:</td>
<td><img src="images/spacer.gif" width="56" height="1"></td>
<td valign="top"><input type="text" name="companyName"  class="input1" value="<?php echo $this->request->data['companyName'] ?>" id="company"></td>
</tr>
<tr>
<td valign="top">* Website(URL):</td>
<td></td>
<td valign="top"><input type="text" class="input1" name="companySite" value="<?php echo $this->request->data['companySite'] ?>" id="website"></td>
</tr>
<tr>
<td valign="top">* Contact Person:</td>
<td></td>
<td valign="top"><input type="text" class="input1" name="contactPerson"  value="<?php echo $this->request->data['contactPerson'] ?>" id="contact"></td>
</tr>
<tr>
<td valign="top">* Phone Number:</td>
<td></td>
<td valign="top"><input type="text" class="input1" name="contactPhone" maxlength="20"  onkeypress="return isNumberKey(event)" value="<?php echo $this->request->data['contactPhone'] ?>"  id="phone"></td>
</tr>
<tr>
<td valign="top">* Email Address:</td>
<td></td>
<td valign="top"><input type="text" class="input1" name="contactEmail" value="<?php echo $this->request->data['contactEmail'] ?>" id="email"></td>
</tr>
<tr>
<td valign="top">* Merchant Type:</td>
<td></td>
<td  valign="top">

<select name="businessType" class="select1" id="merchanttype">
<?php
foreach($uc_list as $key=>$value) { ?>
<option value="<?php echo $key; ?>"  <?php if($this->request->data['businessType'] == $key) echo 'selected="selected"'; ?>  ><?php echo $value; ?></option>
<?php } ?>
</select>




</td>
</tr>
<tr>
<td valign="top" colspan="2">Please give a detailed description of product or services:<br>

</td>
<td>
<textarea name="services" wrap="physical" cols="50" rows="3" onKeyDown="textCounter(document.myform.services,document.myform.remLen1,125)" 
onKeyUp="textCounter(document.myform.services,document.myForm.remLen1,125)"><?php echo $this->request->data['services'] ?></textarea>

<input readonly type="text" name="remLen1"  size="3" maxlength="3" value="125">
</td>
</tr>
<tr>
<td colspan="3">

<b><font class="submenu1">Merchant Financial Information</font></b>
</td>
</tr>
<tr>
<td valign="top">* Monthly Sales Volume:</td>
<td><img src="images/spacer.gif" width="72" height="1"></td>
<td valign="top"><input type="text" class="input1" name="salesVolume" value="<?php echo $this->request->data['salesVolume'] ?>" onkeypress="return isNumberKey(event)" id="salesVolume"></td>
</tr>

<tr>
<td valign="top"></td>
<td><img src="images/spacer.gif" width="72" height="1"></td>
<td valign="top"><?php echo $this->Recaptcha->display(); ?></td>
</tr>
</table>
              <br>
              <br>
              
              
              <br>
              <br>
              <input type="button"  class="cursorclass ui-state-default ui-corner-all" value="Submit Pre-App" onClick="return validation()" name="Submit">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>