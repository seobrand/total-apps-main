<link media="screen" rel="stylesheet" href="<?php echo FULL_BASE_URL.Router::url('/', false).'css/popup/';?>colorbox.css" />
<script src="<?php echo FULL_BASE_URL.Router::url('/', false); ?>js/jquery-1.4.4.min.js"></script>
<script src="<?php echo FULL_BASE_URL.Router::url('/', false).'css/popup/';?>jquery.colorbox.js"></script>
<div class="content">
	<!-- content / right -->
	<div id="right">
		<div class="breadcrumb"></div>
		<div id="right2">
			<!-- table -->
			<div class="box1">
				<div class="news_announcement">
					<div class="titlebar">Print Addresses</div>
					<?php if($resultCount==0){?>
					<div class="news_indent">
						<?php // echo $this->Form->create('Address',array('name'=>'printAddress','action'=>'showuseraddress','id'=>'from','onsubmit'=>'return confirmSubmit();')); 
						 echo $this->Form->create('Address',array('name'=>'printAddress','action'=>'showuseraddress','id'=>'from')); 
						?>
						<table width="60%" border="0" cellspacing="0" cellpadding="0"
							class="no_bg">
							<tr>
								<td colspan="2" align="left" valign="top"></td>
							</tr>
							<tr>
								<td colspan="2" align="left" valign="top">Filter By:<br />
							 	<?php echo $this->Form->input('filterby',array('type'=>'select','options'=>array('merchant'=>'Merchant','referral'=>'Referral','agent'=>'Agents'),'empty'=>'--Filter By--','div'=>false,'label'=>false,'class'=>'select1','style'=>'width:485px','onchange'=>'getuserbyfilter(this.value)'));?>
								</td>
							</tr>

							<tr>
								<td colspan="2" width="100% align="left" valign="top"  id="user_status"  style="display: none;">User Status:<br /> <?php
								$option=array('1'=>'Active','0'=>'Deactive');
								if($this->Session->read('UserAuth.User.user_group_id')=='1')
								{
									echo $this->Form->input('active',array('class'=>'select1','id'=>'status','type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'div'=>false,'style'=>'width:485px','onchange'=>"getuserbyfilter('users')"));
								}else
								{
									echo $this->Form->input('active',array('class'=>'select1','id'=>'status','type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'div'=>false,'style'=>'width:485px'));
								}
								?>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="left" valign="top" style="display: none;" id="userboxshow">
									<div id="userbox">User:<br />
										<div style="height: 250px !important; overflow: auto; width: 465px; padding: 10px; border: 1px solid #CCCCCC;" id="userdropdown">
											<div class="select1">
												<input type="checkbox" onclick="showUserTierDiv()" value="all" id="selectUserALLS" name="data[Address][selectuserID][]"> <label for="templateALL">ALL</label>
											</div>
											<?php //echo $this->Form->input('Address.userID[]',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$UserList,'empty'=>false,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:465px;'));
											echo $this->Form->input('Address.selectuserID',array('class'=>'select1','id'=>'selectuserid','type'=>'select','options'=>$userlist,'empty'=>false,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:465px;'));
											?>
										</div>
									</div>
								</td>
							</tr>
							<tr >
								<td colspan="2" align="left" valign="top" id="merchant_status" style="display: none;">Merchant Status:<br/>
									<?php echo $this->Form->input('merchantStatus',array('class'=>'select1','type'=>'select','options'=>$merchantstatus,'label'=>false,'div'=>false,'style'=>'width:485px','onchange'=>"getuserbyfilter('merchant')"));?>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="left" valign="top">
									<div id="emailBox">
										Merchant/User:<br />
										<div style="height: 250px !important; overflow: auto; width: 465px; padding: 10px; border: 1px solid #CCCCCC;" id="emailDropdown">
											<div class="select1">
												<input type="checkbox" onclick="showTierDiv()" value="all" id="selectALLS" name="data[Address][userID][]"> <label for="templateALL">ALL</label>
											</div>
											<?php //echo $this->Form->input('Address.userID[]',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$UserList,'empty'=>false,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:465px;'));
											echo $this->Form->input('Address.userID[]',array('class'=>'select1','id'=>'template','type'=>'select','empty'=>false,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:465px;'));
											?>
										</div>
										<div style="color: #FF0000">
											<?php if(!empty($emailIdError))
											{
												echo $emailIdError;
											}?>							
										</div>
									</div>

								</td>
							</tr>
							<tr>
								<td colspan="2" align="left" valign="top"><?php //echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
								?>
                                <input type="button" value="Submit" onclick="confirmSubmit();" class='cursorclass ui-state-default ui-corner-all' />
								</td>
							</tr>

						</table>
						<?php 
						
						/*This will use for the print options*/
						echo $this->Form->input('print_value',array('type'=>'hidden','id'=>'print_value','value'=>2));
						echo $this->Form->end(); ?>
					</div>
					<?php }else{?>
					<div class="news_indent"><?php echo $resultAddress;?></div>
					<?php }?>
				</div>
			</div>
			<!-- end table -->
		</div>

	</div>
	<!-- end content / right -->
</div>
<script type="text/javascript">
$(document).ready(function(){
	var val = $("#AddressFilterby").val();
	if(val!=''){
		getuserbyfilter(val);
	}
})
function getuserbyfilter(val){
	if(val!=''){
		if(val=='merchant'){
			document.getElementById('merchant_status').style.display = 'block';
			document.getElementById('user_status').style.display = 'none';
			document.getElementById('userboxshow').style.display = 'block';
			var status = document.getElementById('AddressMerchantStatus').value;

			/*** get value of search criteria ***/
			var filterby = document.getElementById('AddressFilterby').value;
			var users = []; 	
			$('.user_checkbox:checked').each(function(){
				users.push($(this).val());
		    });			
			
			$.ajax({
		               type:"GET",
		               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/addresses/getmerchantbyuser/"+filterby+'/'+status+'/'+users,
		               success : function(data) {
						   	document.getElementById('emailBox').style.display='block';
			            	document.getElementById('emailDropdown').innerHTML=data					
						},
		               error : function() {
					   		alert('sorry, connection error occured.');
		               },
		           });
			
		}else{
			document.getElementById('merchant_status').style.display = 'none';
			document.getElementById('user_status').style.display = 'block';
			document.getElementById('userboxshow').style.display = 'none';
			var status = document.getElementById('status').value;
			/*** get value of search criteria ***/
			var filterby = document.getElementById('AddressFilterby').value;
			$.ajax({
		               type:"GET",
		               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/addresses/getuserbyfilter/"+filterby+'/'+status,
		               success : function(data) {
						   	document.getElementById('emailBox').style.display='block';
			            	document.getElementById('emailDropdown').innerHTML=data					
						},
		               error : function() {
					   		alert('sorry, connection error occured.');
		               },
		           });
		}
		
	}else{ /*** --filter by option is selected ***/
		document.getElementById('merchant_status').style.display = 'none';
		document.getElementById('user_status').style.display = 'none';
		document.getElementById('emailDropdown').innerHTML ='<div class="select1"><input type="checkbox" id="selectALLS" value="all" onclick="showTierDiv()" name="data[Address][userID][]"> <label for="templateALL">ALL</label></div>';
	}
}

function showTierDiv()
{
	var isChecked = document.getElementById("selectALLS").checked;
	if(isChecked==true)
	{
		$('input[name="data[Address][userID][]"]').attr("checked", "checked");
	}else
	{	
		$('input[name="data[Address][userID][]"]').removeAttr("checked", "checked");
	}
}

function showUserTierDiv()
{
	var isChecked = document.getElementById("selectUserALLS").checked;
	if(isChecked==true)
	{
		$('input[name="data[Address][selectuserID][]"]').attr("checked", "checked");
	}else
	{	
		$('input[name="data[Address][selectuserID][]"]').removeAttr("checked", "checked");
	}
	usercheck();
}

function confirmSubmit(){
	checkUser = 0;	
	var filterby = document.getElementById('AddressFilterby').value;
	if(filterby==''){
		alert('Please select filter option');
		return false;
	}
	/** check atleast one checkbox is checked for print name and address ***/
	$('input[name="data[Address][userID][]"]').each(function() {
		if( $(this).attr("checked")==true){
			checkUser++;
        }        
    });
	if(checkUser==0){
		alert('Please check atleast one name to print address');
		return false;
	}
	$.colorbox({href: "<?php echo FULL_BASE_URL.Router::url('/', false); ?>superadmin/addresses/print_options", innerWidth: "40%"});		 	 
}

function usercheck(userID=null) {
	var filterby = document.getElementById('AddressFilterby').value;
	var status = document.getElementById('AddressMerchantStatus').value;
	var users = []; 	
	$('.user_checkbox:checked').each(function(){
		users.push($(this).val());
    });	
    
	$.ajax({
               type:"GET",
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/addresses/getmerchantbyuser/"+filterby+'/'+status+'/'+users,
               success : function(data) {
				   	document.getElementById('emailBox').style.display='block';
	            	document.getElementById('emailDropdown').innerHTML=data					
				},
               error : function() {
			   		alert('sorry, connection error occured.');
               },
    });
}
</script>
