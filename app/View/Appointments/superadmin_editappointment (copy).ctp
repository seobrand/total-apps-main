<?php $edithtml ='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                <tr>
                  <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				   	<tr>
                        <td align="left" valign="top"><strong>From</strong></td>
                      </tr>
                    <tr>
                        <td align="left" valign="top">'.$this->Form->input('Appointment.appointmentFrom', array('label'=>'','class'=>'')).'</td>
                      </tr>
					<tr>
                        <td align="left" valign="top"><strong>To</strong></td>
                      </tr>
                    <tr>
                        <td align="left" valign="top">'.$this->Form->input('Appointment.appointmentTo', array('label'=>'','class'=>'')).'</td>
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
                              <td colspan="2" align="left" valign="middle">'.$this->request->data['Appointment']['userType'].'</td>
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
                              <td colspan="2">'.$this->Form->input('Appointment.id',array('type'=>'hidden','label'=>false,'class'=>'')).'&nbsp;'.$this->Form->input('Appointment.merchantID',array('type'=>'hidden','label'=>false,'class'=>'')).'&nbsp;'.$this->Form->input('Appointment.appointmentWithUser',array('type'=>'hidden','label'=>false,'class'=>'')).'&nbsp;'.$this->Form->input('Appointment.userType',array('type'=>'hidden','label'=>false,'class'=>'')).'</td>
                            </tr>
                          </table>
						  </td>
                      </tr>
                    </table></td>
                </tr>
              </table>';
			  
			  echo $edithtml;
			  
?>