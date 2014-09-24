<?php 
$userID 	= $this->Session->read('UserAuth.User.id');
$userRoleID = $this->Session->read('UserAuth.User.user_group_id');
?>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <!-- display box / first -->
        <div class="box">
          <div class="display_row">
            <div class="news_indent">
              <div class="news_announcement">
                <div class="titlebar">View submitted request                 
                </div>
           <div class="links_col">
              <ul class="links" id="supporttabs">
              <?php foreach($typeLists as $id=>$typeList) {//active ?>
                <li id="merchant-appointment-li" style="padding:4px 12px 0px 0px;" class="selected_<?php echo $id;?>">
                <a onclick="showTicketTab(<?php echo $id;?>)" href="javascript:void(0)"><?php echo $typeList;?></a>
                </li>
 					<?php }?>               
               
              </ul>
            </div>
           
           <?php echo $this->Form->create('Support', array('action'=>'ticketapproved','onsubmit'=>'return validForm();')); 
           if($userRoleID == '1'){
           ?>
				<div class="box" style="padding-right:100px;float:right;">
					<div  id="error_msg"></div>
            <select name="is_approved" id="is_approved" onchange="displayTextBox(this.value);">
            <option value="">Select action</option>
            <option value="1">Approved</option>
            <option value="2">Declined</option>
            </select>
            <?php echo $this->Form->hidden('tab_id');?>
            <?php echo $this->Form->text('email_send_to',array('value'=>'none','style'=>'display:none;width:200px;'));?>
				<input type="submit" value="Submit" name="submit_btn" />				
				</div>
               <?php }?>
               
                <div class="box">
                
                 <?php foreach($typeLists as $k=>$v) {//active ?>
                 <div class="display_row" id="<?php echo 'display_row_'.$k;?>" style="display:none;">
                    <div class="table">
					<table width="100%">
					  <tr>
					  	<th width="4%">[&nbsp;&nbsp;]</th>
                        <th width="4%">Request #<br /> &nbsp; Priority</th>
                        <th width="4%" class="visible_eta_date">ETA Date</th>
					  	<th width="6%" class="visible_case_type" style="display:none;">Request Type</th>
					  	<th width="10%">Request Title^</th>
					  	<th width="10%">Staffs Name</th>
						<th width="18%">Comments</th>
						<th width="10%" class="visible_case_add_date" style="display:none;">Date sent</th>
						<th width="10%" class="HtmlStatus" style="display:none;">Status</th>
						<th width="10%" class="changeHtmlStatus">Document attached</th>
					  </tr>
					 
					 <?php if(!empty($submitedReq)){
						//echo '<pre>'; print_R($submitedReq);				
						
						foreach($submitedReq as $req){				 	
							$Color = Configure::read('PRIORITY_LEVEL');
							$level_val = Configure::read('PRIORITY_VAL');
						?>
					 	<tr>
					 	<?php 
						if($k == $req['Ticket']['request_type'] && $req['Ticket']['is_approved']==0){		

						?>
					  	<td align="center"><input type="checkbox" name="ids[]" value="<?php echo $req['Ticket']['id'];?>" /></td>
                        <td width="4%" style="background-color:<?php echo $Color[$req['Ticket']['priority']];?>">
						<?php 
						echo $req['Ticket']['id'].'&nbsp;&nbsp;&nbsp;'.$level_val[$Color[$req['Ticket']['priority']]];?>
                        
                        </td>
                        <td>
						<?php 
						echo !empty($req['Ticket']['eta_date'])?date('m-d-Y',strtotime($req['Ticket']['eta_date'])):'';?></td>
                        
					  	<td width="10%"><?php echo $req['Ticket']['title'];?></td>
					  	<td width="10%"><?php echo $req['User']['user_Name'];?></td>
						<td width="18%"><?php echo $req['Ticket']['comment'];?></td>
						<td width="10%" align="center">
						<?php  
						if(!empty($req['TicketDocument'])){						
						foreach($req['TicketDocument'] as $doc){
						$pos = strpos($doc['document_name'], '_', 1) + 1; // $pos = 7, not 0
						$docs = substr($doc['document_name'],$pos);
						?>
						<a href="<?php echo $this->webroot.'superadmin/supports/downloadticketreq/'.$doc['id']; ?>" style="float:left;clear:both;"><?php echo substr($docs,0,20);?></a>
						
						<?php }} ?> </td>
						
						<?php }else if($k == '5' && $req['Ticket']['is_approved']==1){?>
						
						<td align="center"><input type="checkbox" name="ids[]" value="<?php echo $req['Ticket']['id'];?>" /></td>
                        <td width="4%" style="background-color:<?php echo $Color[$req['Ticket']['priority']];?>">
						<?php 
						echo $req['Ticket']['id'].'&nbsp;&nbsp;&nbsp;'.$level_val[$Color[$req['Ticket']['priority']]];?>
                        
                        </td>
                        <td>
						<?php 
						echo !empty($req['Ticket']['eta_date'])?date('m-d-Y',strtotime($req['Ticket']['eta_date'])):'';?></td>
						<td width="10%"><?php echo $req['RequestType']['name'];?></td>					  	
					  	<td width="10%"><?php echo $req['Ticket']['title'];?></td>
					  	<td width="10%"><?php echo $req['User']['user_Name'];?></td>
						<td width="18%"><?php echo $req['Ticket']['comment'];?></td>
						<td width="10%" align="center"><?php echo date('d-m-Y',strtotime($req['Ticket']['add_date']));?></td>
						<td width="10%" align="center">
						<?php  
						if(!empty($req['TicketDocument'])){						
						foreach($req['TicketDocument'] as $doc){
						
						$pos = strpos($doc['document_name'], '_', 1) + 1; // $pos = 7, not 0
						$docs = substr($doc['document_name'],$pos);
						?>
						<a href="<?php echo $this->webroot.'superadmin/supports/downloadticketreq/'.$doc['id']; ?>" style="float:left;clear:both;"><?php echo substr($docs,0,20);?></a>
						
						<?php }} ?> </td>	
							
						<?php	}else if($k == '6' && $req['Ticket']['is_approved']==2){?>
						
						<td align="center"><input type="checkbox" name="ids[]" value="<?php echo $req['Ticket']['id'];?>" /></td>
                        <td width="4%" style="background-color:<?php echo $Color[$req['Ticket']['priority']];?>">
						<?php 
						echo $req['Ticket']['id'].'&nbsp;&nbsp;&nbsp;'.$level_val[$Color[$req['Ticket']['priority']]];?>
                        
                        </td>
                        <td>
						<?php 
						echo !empty($req['Ticket']['eta_date'])?date('m-d-Y',strtotime($req['Ticket']['eta_date'])):'';?></td>
						<td width="10%"><?php echo $req['RequestType']['name'];?></td>					  	
					  	<td width="10%"><?php echo $req['Ticket']['title'];?></td>
					  	<td width="10%"><?php echo $req['User']['user_Name'];?></td>
						<td width="18%"><?php echo $req['Ticket']['comment'];?></td>
						<td width="10%" align="center"><?php echo date('d-m-Y',strtotime($req['Ticket']['add_date']));?></td>
						<td width="10%" align="center">
						<?php  
						if(!empty($req['TicketDocument'])){						
						foreach($req['TicketDocument'] as $doc){
						$pos = strpos($doc['document_name'], '_', 1) + 1; // $pos = 7, not 0
						$docs = substr($doc['document_name'],$pos);
						?>
						<a href="<?php echo $this->webroot.'superadmin/supports/downloadticketreq/'.$doc['id']; ?>" style="float:left;clear:both;"><?php echo substr($docs,0,20);?></a>
						
						<?php }} ?> </td>
										
						<?php }else if($k == '7' && $req['Ticket']['is_approved']==3){?>
						
						
						<td align="center"><input type="checkbox" name="ids[]" value="<?php echo $req['Ticket']['id'];?>" /></td>
                       <td width="4%" style="background-color:<?php echo $Color[$req['Ticket']['priority']];?>">
						<?php 
						echo $req['Ticket']['id'].'&nbsp;&nbsp;&nbsp;'.$level_val[$Color[$req['Ticket']['priority']]];?>
                        
                        </td>
                        <td>
						<?php 
						echo !empty($req['Ticket']['eta_date'])?date('m-d-Y',strtotime($req['Ticket']['eta_date'])):'';?></td>
					  	<td width="10%"><?php echo $req['RequestType']['name'];?></td>
					  	<td width="10%"><?php echo $req['Ticket']['title'];?></td>
					  	<td width="10%"><?php echo $req['User']['user_Name'];?></td>
						<td width="18%"><?php echo $req['Ticket']['comment'];?></td>
						<td width="10%" align="center"><?php echo date('d-m-Y',strtotime($req['Ticket']['add_date']));?></td>
						<td width="10%" align="center">pending</td>
						<td width="10%" align="center">
						<?php  
						if(!empty($req['TicketDocument'])){						
						foreach($req['TicketDocument'] as $doc){
						$pos = strpos($doc['document_name'], '_', 1) + 1; // $pos = 7, not 0
						$docs = substr($doc['document_name'],$pos);
						?>
						<a href="<?php echo $this->webroot.'superadmin/supports/downloadticketreq/'.$doc['id']; ?>" style="float:left;clear:both;"><?php echo substr($docs,0,20);?></a>
						
						<?php }} ?> </td>

						<?php }else if($k == '8' && $req['Ticket']['is_approved']==4){?>
						
						<td align="center"><input type="checkbox" name="ids[]" value="<?php echo $req['Ticket']['id'];?>" /></td>
                       <td width="4%" style="background-color:<?php echo $Color[$req['Ticket']['priority']];?>">
						<?php 
						echo $req['Ticket']['id'].'&nbsp;&nbsp;&nbsp;'.$level_val[$Color[$req['Ticket']['priority']]];?>
                        
                        </td>
                        <td>
						<?php 
						echo !empty($req['Ticket']['eta_date'])?date('m-d-Y',strtotime($req['Ticket']['eta_date'])):'';?></td>
					  	<td width="10%"><?php echo $req['RequestType']['name'];?></td>
					  	<td width="10%"><?php echo $req['Ticket']['title'];?></td>
					  	<td width="10%"><?php echo $req['User']['user_Name'];?></td>
						<td width="18%"><?php echo $req['Ticket']['comment'];?></td>
						<td width="10%" align="center"><?php echo date('d-m-Y',strtotime($req['Ticket']['add_date']));?></td>
						<td width="10%" align="center">
						<?php  
						if(!empty($req['TicketDocument'])){						
						foreach($req['TicketDocument'] as $doc){
						$pos = strpos($doc['document_name'], '_', 1) + 1; // $pos = 7, not 0
						$docs = substr($doc['document_name'],$pos);
						?>
						<a href="<?php echo $this->webroot.'superadmin/supports/downloadticketreq/'.$doc['id']; ?>" style="float:left;clear:both;"><?php echo substr($docs,0,20);?></a>
						
						<?php }} ?> </td>
						
						<?php }
						
						 }}?>					  
					 
					 
				    
				  </table>
                    </div>
                  </div>
                
                <?php }?>           
                
                </div>
              <?php echo $this->Form->end(); ?>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" >
$(function(){
<?php 
if(isset($tabId) && $tabId !=''){?>
 var tabId = '<?php echo $tabId;?>';
$('#display_row_'+tabId).show();
$('.selected_'+tabId).addClass('active');
$('.selected_'+tabId).css('background','none');
$('#SupportTabId').val(tabId);
showTicketTab(tabId);
 <?php }else{?>
$('#display_row_1').show();
$('.selected_1').addClass('active');
$('.selected_1').css('background','none');
$('#SupportTabId').val(1);
<?php }?>
	});
function showTicketTab(id){
	//alert(id)
	$('#error_msg').html('');
	$('#SupportEmailSendTo').val('none').hide();
	if(id==5){
		$("#is_approved option[value='1']").remove();
		$("#is_approved option[value='3']").remove();
		$("#is_approved option[value='4']").remove();
		$("#is_approved option[value='2']").remove();
		$("#is_approved option[value='5']").remove();
		//$("#is_approved option").eq(1).before($("<option></option>").val("3").text("Add to batch list"));
		$("#is_approved").append($("<option value='3'>Add to batch list</option>"));	
		$("#is_approved").append($("<option value='2'>Declined</option>"));	
		
		}else if(id == 7){
		$('.HtmlStatus').show();
		
		$("#is_approved option[value='1']").remove();
		$("#is_approved option[value='3']").remove();
		$("#is_approved option[value='4']").remove();
		$("#is_approved option[value='2']").remove();
		$("#is_approved option[value='5']").remove();
		$("#is_approved").append($("<option value='4'>Completed</option>"));	
		$("#is_approved").append($("<option value='2'>Recalled</option>"));	
		
		}else if(id == 8){
		$('.HtmlStatus').hide();
		
		$("#is_approved option[value='1']").remove();
		$("#is_approved option[value='3']").remove();
		$("#is_approved option[value='4']").remove();
		$("#is_approved option[value='2']").remove();
		$("#is_approved option[value='5']").remove();
		$("#is_approved").append($("<option value='1'>Approved</option>"));
		$("#is_approved").append($("<option value='3'>In Development</option>"));
		$("#is_approved").append($("<option value='5'>Delete</option>"));	
		
		}else{
			$('.changeHtmlStatus').html('Document attached');
			
			$("#is_approved option[value='3']").remove();
			$("#is_approved option[value='4']").remove();
			$("#is_approved option[value='2']").remove();
			$("#is_approved option[value='1']").remove();
			$("#is_approved option[value='5']").remove();
			$("#is_approved").append($("<option value='1'>Approved</option>"));	
			$("#is_approved").append($("<option value='2'>Declined</option>"));		
			}

			
		if(id == 5 || id == 6 || id == 7 || id == 8){
			$('.visible_case_type').show();
			$('.visible_eta_date').show();
			$('.visible_case_add_date').show();
			}else{
				$('.visible_case_type').hide();
				$('.visible_eta_date').show();
				$('.visible_case_add_date').hide();
				}
		
		$('input[type="checkbox"]').attr('checked',false);
		$('[id*="display_row_"]').hide();
		$('[class*="selected_"]').css('background','#EBEAEA')
		$('[class*="selected_"]').removeClass('active');
		$('.selected_'+id).addClass('active');
		$('.selected_'+id).css('background','none');
		$('#display_row_'+id).show();

// fill hidden box value with tabId
	$('#SupportTabId').val(id);

	}

function validForm(){
	var dd = $('#is_approved').val();
	var checkd = $('input[type="checkbox"]').is(':checked');
	if(dd==""){ $('#error_msg').html('<div class="error-message">Please select action</div>'); return false}
	if(!checkd){ $('#error_msg').html('<div class="error-message">Please select checkbox</div>');return false}
	
	if($('#SupportEmailSendTo').val() == ''){$('#error_msg').html('<div class="error-message">Please enter valid email id with comma separated</div>');return false}

	var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
  	var err = 0;
	if($('#SupportEmailSendTo').val() !='none' && $('#SupportEmailSendTo').val() !=''){
		var email = $('#SupportEmailSendTo').val();
		var strArr = email.split(',');
		$.each( strArr, function( key, value ) {
		  if(regex.test(value) === false){
			 $('#error_msg').html('<div class="error-message">Please enter valid email id with comma separated</div>');
			  err++;
			  return false;
			 }
			//alert( regex.test(value) );
		});
	}
if(err > 0) return false;

 }


function displayTextBox(val){
 if(val == '3' && $('#SupportTabId').val()=='5') 
 	$('#SupportEmailSendTo').val('').show();
 else 
 	$('#SupportEmailSendTo').val('none').hide();

}
</script>


