<?php 
//pr($this->request->data);
$edithtml ='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                <tr>
                  <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				   	<tr>
                        <td align="left" valign="top"><strong>Date & Time</strong></td>
                      </tr>
                    <tr>
                        <td align="left" valign="top">'.$this->Form->input('Appointment.appointmentFrom', array('id'=>'AppointmentAppointmentFromEdit','type'=>'text','label'=>'','class'=>'')).'</td>
                      </tr>
					  
					  				  
                      <tr>
                        <td align="left" valign="top"><strong>Appointment Note</strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">'.$this->Form->input('Appointment.appointmentNote', array('label'=>'','type' => 'textarea','class'=>'textarea1')).'</td>
                      </tr>                      
                      <tr>
                        <td align="left" valign="top">'.$this->Form->submit('Update Appointment',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false)).'</td>
                      </tr>
                    </table></td>
                  <td width="30%" align="left" valign="top" style="padding:0 0 0 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><strong>Appointment With </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
                            <td colspan="2" align="left" valign="middle">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">';

                            if($this->request->data['Merchant']['agentID']!=''){
							$usercount++;							
							$edithtml .= '<tr>
                              <td width="36%" align="left" valign="middle">Agent </td>
                              <td width="64%" align="left" valign="middle">';
	                              if($this->request->data['Appointment']['app_agent']!=''){
	                              $edithtml .= $this->Form->checkbox('Appointment.agent', array('value' => 1,'checked'=>'checked'));
	                              }else{
	                              	$edithtml .= $this->Form->checkbox('Appointment.agent', array('value' => 1));
	                              }
								$edithtml .='</td></tr>';
							}
							
							if($this->request->data['Merchant']['managerID']!=''){
							$usercount++;
                            $edithtml .= '<tr>
                              <td align="left" valign="middle">Manager </td>
                              <td align="left" valign="middle">';
	                            if($this->request->data['Appointment']['app_manager']!=''){
	                            	$edithtml .= $this->Form->checkbox('Appointment.manager', array('value' => 1,'checked'=>'checked'));
	                            }else{
	                            	$edithtml .= $this->Form->checkbox('Appointment.manager', array('value' => 1));
	                            }
	                            $edithtml .='</td></tr>';
							}
							
							if($this->request->data['Merchant']['isoID']!=''){
							$usercount++;
                            $edithtml .= '<tr>
                              <td align="left" valign="middle">Iso </td>
                              <td align="left" valign="middle">';
	                            if($this->request->data['Appointment']['app_ISO']!=''){
	                            	$edithtml .= $this->Form->checkbox('Appointment.iso', array('value' => 1,'checked'=>'checked'));
	                            }else{
	                            	$edithtml .= $this->Form->checkbox('Appointment.iso', array('value' => 1));
	                            }
	                            $edithtml .='</td></tr>';                              
							} 
							 
							if($this->request->data['Merchant']['processorID']!=''){
							$usercount++;
                            $edithtml .= '<tr>
                              <td align="left" valign="middle">Processor </td>
                              <td align="left" valign="middle">';
                              	if($this->request->data['Appointment']['app_processor']!=''){
	                            	$edithtml .= $this->Form->checkbox('Appointment.processor', array('value' => 1,'checked'=>'checked'));
	                            }else{
	                            	$edithtml .= $this->Form->checkbox('Appointment.processor', array('value' => 1));
	                            }
	                            $edithtml .='</td></tr>';
							}
							
                          $edithtml .= '</table></td>
                            </tr>
                          </table>
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                             <tr>
                              <td colspan="2">&nbsp;</td>
                            </tr>
							<tr>
                              <td width="36%" align="left" valign="middle"><strong>Action </strong></td>
                              <td width="64%" align="left" valign="middle">'.$this->Form->input('Appointment.action',array('type'=>'select','options'=>array('Call'=>'Call','Email'=>'Email'),'label'=>false,'class'=>'')).'</td>
                            </tr>
							<tr>
                              <td colspan="2">'.$this->Form->input('Appointment.id',array('type'=>'hidden','label'=>false,'class'=>'')).'&nbsp;'.$this->Form->input('Appointment.merchantID',array('type'=>'hidden','label'=>false,'class'=>'')).'</td>
                            </tr>                            
                          </table>
						  </td>
                      </tr>
                    </table></td>
                </tr>
              </table>';
			  
			  echo $edithtml;
			  
?>