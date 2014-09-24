<?php 


 ?>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="appointment">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
		  <div class="box1">
		  <div class="news_announcement">
            <div class="titlebar">Merchant Appointment
			<div style="float:right">
			<a href="<?php echo $this->webroot; ?>superadmin/merchants/merchantaction/<?php echo $this->request->data['Merchant']['id']; ?>#action">Next</a>
			</div>
			</div>
            <div class="links_col">
              <ul class="links">
                <li class="active" id="merchant-appointment-li"><a href="javascript:void(0)" onclick="showMerchantAppointment('merchant-appointment','merchant-add-appointment')">View Appointment:</a></li>
                <li id="merchant-add-appointment-li"><a href="javascript:void(0)" onclick="showMerchantAppointment('merchant-add-appointment','merchant-appointment')">Add Appointment:</a></li>
              </ul>
            </div>
            <div class="box">
              <div class="display_row" >
                <div class="table" id="merchant-appointment">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="25%" align="center" valign="top" scope="col">Date</th>
                     <?php /*?> <th width="10%" align="center" valign="top" scope="col">View</th><?php */?>
                      <th width="25%" align="center" valign="top" scope="col">Time</th>
                      <th width="25%" align="center" valign="top" scope="col"> Appointment With</th>
					  <th width="25%" align="center" valign="top" scope="col"> Action </th>
                    </tr>
                    
					<?php foreach($merchantAppointment as $key => $appointment):?>
					<?php $appointmentWith = array();?>
					<?php if($appointment['Appointment']['app_agent']!='')$appointmentWith[] = "Agent";
						if($appointment['Appointment']['app_manager']!='')$appointmentWith[] = "Manager";
						if($appointment['Appointment']['app_ISO']!='')$appointmentWith[] = "Iso";
						if($appointment['Appointment']['app_processor']!='')$appointmentWith[] = "Processor";					
					?>
                    <tr>
                      <td align="center" valign="top"><?php echo date("d-m-Y",strtotime($appointment['Appointment']['appointmentFrom']));?></td>
                      <td align="center" valign="top"><?php echo date("h:i A",strtotime($appointment['Appointment']['appointmentFrom']));?></td>
                      <td align="center" valign="top"><?php if(count($appointmentWith)>0) echo implode(",",$appointmentWith); ?></td>
					  <td align="center" valign="middle">
					  <?php echo $this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','onclick'=>'editAppointment('.$appointment['Appointment']['id'].')')); ?>&nbsp;
					  <?php echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("Are you sure to delete this appointment?");','url' => array('controller' => 'appointments', 'action' => 'deleteAppoinment', $appointment['Appointment']['id'],$appointment['Appointment']['merchantID']))); ?>
					  </td>
                    </tr>
                    <?php endforeach;?>
					<?php if(count($merchantAppointment)==0):?>
					<tr>
                      <td align="center" valign="top" colspan="4">No Results Found</td>
                    </tr>
					<?php endif;?>
                  </table>
                </div>
			    <div class="table" id="merchant-add-appointment" style="display:none">
			<?php  echo $this->Form->create('Appointment',array('controller'=>'appointments','action'=>'addappointment','onsubmit'=>'return validation();')); ?> 
			<?php $usercount = 0;?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                <tr>
                  <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				   	<tr>
                        <td align="left" valign="top"><strong>Date and Time</strong></td>
                      </tr>                      
                    <tr>
                        <td align="left" valign="top"><?php echo $this->Form->input('Appointment.appointmentFrom', array('type'=>'text','label'=>'','class'=>'','onblur'=>'toDateAssign()'));?></td>
                      </tr>
					<?php /* commented by pushkar ticket id 1479 & 1506
					<tr>
                        <td align="left" valign="top"><strong>To</strong></td>
                      </tr>
                    <tr>
                        <td align="left" valign="top"><?php echo $this->Form->input('Appointment.appointmentTo', array('type'=>'text','label'=>'','class'=>'','onfocus'=>'toDateAssign()'));?></td>
                      </tr>	
                      */ ?>
                      				  
                      <tr>
                        <td align="left" valign="top"><strong>Appointment Note</strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><?php echo $this->Form->input('Appointment.appointmentNote', array('label'=>'','type' => 'textarea','class'=>'textarea1'));?></td>
                      </tr>                      
                      <tr>
                        <td align="left" valign="top"><?php echo $this->Form->submit('Add Appointment',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                      </tr>
                    </table></td>
                  <td width="30%" align="left" valign="top" style="padding:0 0 0 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><strong>Appointment With </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <?php if($this->request->data['Merchant']['agentID']!=''){?>
							<?php $usercount++;?>
							<tr>
                              <td width="36%" align="left" valign="middle">Agent </td>
                              <td width="64%" align="left" valign="middle"> <?php echo $this->Form->checkbox('Appointment.agent', array('value' => 1)); ?></td><?php echo $this->Form->input('Appointment.agentEmail', array('type' => 'hidden','value'=>$this->request->data['Agent']['userEmail']));?>
                            </tr>
							<?php } ?>
							<?php if($this->request->data['Merchant']['managerID']!=''){?>
							<?php $usercount++;?>
                            <tr>
                              <td align="left" valign="middle">Manager </td>
                              <td align="left" valign="middle"> <?php echo $this->Form->checkbox('Appointment.manager', array('value' => 1)); ?></td>
							  <?php echo $this->Form->input('Appointment.managerEmail', array('type' => 'hidden','value'=>$this->request->data['Manager']['userEmail']));?>
                            </tr>
							<?php } ?>
							<?php if($this->request->data['Merchant']['isoID']!=''){?>
							<?php $usercount++;?>
                            <tr>
                              <td align="left" valign="middle">Iso </td>
                              <td align="left" valign="middle"> <?php echo $this->Form->checkbox('Appointment.iso', array('value' => 1)); ?></td>
							  <?php echo $this->Form->input('Appointment.isoEmail', array('type' => 'hidden','value'=>$this->request->data['ISO']['userEmail']));?>
                            </tr>
							<?php } ?>
							<?php if($this->request->data['Merchant']['processorID']!=''){?>
							<?php $usercount++;?>
                            <tr>
                              <td align="left" valign="middle">Processor </td>
                              <td align="left" valign="middle"> <?php echo $this->Form->checkbox('Appointment.processor', array('value' => 1)); ?></td>
							  <?php echo $this->Form->input('Appointment.processorEmail', array('type' => 'hidden','value'=>$this->request->data['Processor']['userEmail']));?>
                            </tr>
							<?php } ?>
                          </table>
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                             <tr>
                              <td colspan="2">&nbsp;</td>
                            </tr>
							<tr>
                              <td width="36%" align="left" valign="middle"><strong>Action </strong></td>
                              <td width="64%" align="left" valign="middle"> <?php echo $this->Form->input('Appointment.action',array('type'=>'select','options'=>array('Call'=>'Call','Email'=>'Email'),'label'=>false,'class'=>'')); ?></td>
                            </tr>
                        
                          </table>
						  </td>
                      </tr>
                    </table></td>
                </tr>
              </table>
			<?php echo $this->Form->input('Appointment.merchantID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['id']));?>
            <?php echo $this->Form->input('Appointment.currentDate', array('type' => 'hidden','value'=>date('m/d/Y',time()),'id'=>'currentdate'));?>
            
			<?php echo $this->Form->input('Appointment.merchantEmail', array('type' => 'hidden','value'=>$this->request->data['Merchant']['contactEmail']));?>
			<?php echo $this->Form->input('Appointment.merchantContactName', array('type' => 'hidden','value'=>$this->request->data['Merchant']['contactName']));?>
			<?php echo $this->Form->input('Appointment.agentID', array('type' => 'hidden','id'=>'agentID','value'=>$this->request->data['Merchant']['agentID']));?>
			<?php echo $this->Form->input('Appointment.processorID', array('type' => 'hidden','id'=>'processorID','value'=>$this->request->data['Merchant']['processorID']));?>
			<?php echo $this->Form->input('Appointment.isoID', array('type' => 'hidden','id'=>'isoID','value'=>$this->request->data['Merchant']['isoID']));?>
			<?php echo $this->Form->input('Appointment.managerID', array('type' => 'hidden','id'=>'managerID','value'=>$this->request->data['Merchant']['managerID']));?>
			<?php echo $this->Form->input('Appointment.usercount', array('type' => 'hidden','value'=>$usercount,'id'=>'usercount'));?>
			<?php echo $this->Form->end();?>
			  	</div>
				<div class="table" id="merchant-edit-appointment" style="display:none">
			<?php  echo $this->Form->create('Appointment',array('controller'=>'appointments','action'=>'editappointment')); ?> 
				<div id="edit_appointment" style="text-align:center;"></div>
			<?php echo $this->Form->end();?>
			  	</div>
              </div>
            </div>
			</div>
			</div>
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
function showMerchantAppointment(showId,HideId){
	document.getElementById(showId+'-li').className = 'active';
	document.getElementById(showId).style.display = 'block';
	document.getElementById(HideId+'-li').className = '';	
	document.getElementById(HideId).style.display = 'none';
	document.getElementById('merchant-edit-appointment').style.display = 'none';
}

function validation(){

	var currentDate=$('#currentdate').val();
	currentDate=currentDate+'12:00 pm';
	var from=$('#AppointmentAppointmentFrom').val();
	var to=$('#AppointmentAppointmentTo').val();
	
	
		
	var validation='';
	var total = 0;
	if(document.getElementById('agentID').value !='' && document.getElementById('AppointmentAgent').checked==false)
		total++;
	if(document.getElementById('managerID').value !='' && document.getElementById('AppointmentManager').checked==false)
		total++;	
	if(document.getElementById('isoID').value !='' && document.getElementById('AppointmentIso').checked==false)
		total++;	
	if(document.getElementById('processorID').value !='' && document.getElementById('AppointmentProcessor').checked==false)
		total++;	
	
	var usercount = document.getElementById('usercount').value;
	
	if(usercount == total){
		validation +="Please select user for appointment\n";
		//alert("Please select user for appointment");
		}
	
	/*if(currentDate > from)
	{
		validation +="Appoinment From date should be greate than current date\n";
	}
	
	if(from > to)
	{
		validation +="Appoinment To date should be greate than from date\n";
	}*/
	
	if(validation)
	{
		alert(validation);
		return false;
	}
	
	return true;
		
}

function editAppointment(app_id)
{
	document.getElementById('merchant-edit-appointment').style.display = 'block';
	document.getElementById('merchant-add-appointment-li').className = '';	
	document.getElementById('merchant-add-appointment').style.display = 'none';
	document.getElementById('merchant-appointment-li').className = '';	
	document.getElementById('merchant-appointment').style.display = 'none';
	
	var xmlhttp;
	var country='';
	agent=document.getElementById('agent').value;
	//alert(country);
	if(app_id!=null || app_id!='')
	{
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//alert(xmlhttp.responseText);
				document.getElementById("edit_appointment").innerHTML=xmlhttp.responseText;
			}else{
				document.getElementById("edit_appointment").innerHTML='Please Wait....';
			}
		  }
		var url='';
		url='<?=FULL_BASE_URL.router::url('/',false).'superadmin/appointments/editappointment'?>/'+app_id;
		
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
	}
	else
	{
		alert('Please select valid agent.');
	}

}

jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery("#AppointmentAppointmentFrom").datetimepicker({
		timeFormat: "hh:mm tt",
		stepMinute: 15
	});
	jQuery("#AppointmentAppointmentTo").datetimepicker({
		timeFormat: "hh:mm tt",
		stepMinute: 15
	});
	jQuery('#AppointmentAppointmentFromEdit').live('focus', function (e){
		 jQuery(this).datetimepicker({
				timeFormat: "hh:mm tt",
				stepMinute: 15
			});		
	});
	jQuery('#AppointmentAppointmentToEdit').live('focus', function (e){
		 jQuery(this).datetimepicker({
				timeFormat: "hh:mm tt",
				stepMinute: 15
			});		
	});
	
});

function toDateAssign(){
	document.getElementById('AppointmentAppointmentTo').value = document.getElementById('AppointmentAppointmentFrom').value;
}
</script>