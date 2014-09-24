<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  $loginRole = $this->Session->read('UserAuth.UserGroup.name');
// $this->Session->read('UserAuth.User.id');

//pr($MerchantRec);die;
?>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Filter Options</div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Merchant',array('action'=>'viewbystatus/','type'=>'get')); ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
              <tr>
                <td width="75%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="12%" align="center" valign="top"><strong class="big_text">Filter:</strong></td>
                      <td width="88%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td valign="top" style="padding:0px" align="left"><ul class="shiftable_data">
                                <li>Status:<br />
                                  <?php echo $this->Form->input('Merchant.statusID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$status,'selected' => $statusID,'label'=>false)); ?> </li>
                                <li>Manager:<br />
                                <?php if(strtolower($loginRole)=='manager'):?>
                                	<?php echo $this->Form->input('Merchant.managerID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$mangList,'selected' => $managerID,'label'=>false,'disabled'=>'disabled'));?>
                                <?php else:?>
                                	<?php echo $this->Form->input('Merchant.managerID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$mangList,'selected' => $managerID,'label'=>false));?>
                                <?php endif;?>
                                </li>                                
                                <li>Processor:<br />
                                <?php if(strtolower($loginRole)=='processor'):?>
                                	<?php echo $this->Form->input('Merchant.processorID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$procList,'selected' => $processorID,'label'=>false,'disabled'=>'disabled')); ?> 
                                <?php else:?>
                                	<?php echo $this->Form->input('Merchant.processorID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$procList,'selected' => $processorID,'label'=>false)); ?> 
                                <?php endif;?>
                                </li>
                                <li>ISO:<br />
                                <?php if(strtolower($loginRole)=='iso'):?>
                                	<?php echo $this->Form->input('Merchant.isoID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$isoList,'selected' => $isoID,'label'=>false,'disabled'=>'disabled')); ?> 
                                <?php else:?>
                                	<?php echo $this->Form->input('Merchant.isoID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$isoList,'selected' => $isoID,'label'=>false)); ?> 
                                <?php endif;?>
                                </li> 
                                <li>Agent:<br />
                                  <?php if(strtolower($loginRole)=='agent'):?>
                                	<?php echo $this->Form->input('Merchant.agentID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$agentList,'selected' => $agentID,'label'=>false,'disabled'=>'disabled')); ?>  
                                <?php else:?>
                                	<?php echo $this->Form->input('Merchant.agentID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$agentList,'selected' => $agentID,'label'=>false)); ?>  
                                <?php endif;?>
                                </li>
                                <li>Account Type:<br />
                                  <?php echo $this->Form->input('Merchant.accountTypeID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$ac_list,'selected' => $accountTypeID,'label'=>false)); ?> </li>
                                <li>Referral:<br />
                                  <?php if(strtolower($loginRole)=='referal'):?>
                                	<?php echo $this->Form->input('Merchant.referalID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$referalList,'selected' => $referalID,'label'=>false,'disabled'=>'disabled')); ?>  
                                <?php else:?>
                                	<?php echo $this->Form->input('Merchant.referalID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$referalList,'selected' => $referalID,'label'=>false)); ?>  
                                <?php endif;?>
                                 </li>
                                <li>Gateway:<br />
                                  <?php echo $this->Form->input('Merchant.gatewayID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$gatewayList,'selected' => $gatewayID,'label'=>false)); ?> </li>
                                <li>Account Category:<br />
                                  <?php echo $this->Form->input('Merchant.accountCatID',array('type'=>'select','multiple'=>'multiple', 'size'=>'5','options'=>$acat_list,'selected' => $accountCatID,'label'=>false)); ?> </li>
                              </ul>
                              <div class="clear"></div></td>
                          </tr>
                          <tr>
                            <td width="33%" align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
                <td align="left" valign="top" style="padding:0 0 0 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle">Merchants: </td>
                      <td align="left" valign="middle"><?php echo $totalUser;?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Query Time:</td>
                      <td align="left" valign="middle"><?php echo round(microtime(true) - $_SERVER['REQUEST_TIME'], 4) ; ?> seconds. </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Total Volume:</td>
                      <td align="left" valign="middle">
                        <?php if($totalVolume) echo $this->Number->currency($totalVolume,'USD'); else echo 0;?>
                        
                        
                        </td>
                    </tr>
                    <tr>
                      <!--<td colspan="2" align="left" valign="middle" style="padding:67px 0 0 10px;"><?php // echo $this->Form->submit('Filter Users',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> &nbsp;&nbsp; <?php// echo $this->Form->submit('Export',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>-->
					  <?php if(isset($manager)){ ?>
								<td colspan="2" align="left" valign="middle" style="padding:67px 0 0 10px;"><?php echo $this->Form->submit('Filter Users',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> &nbsp;&nbsp; <?php echo $this->Form->submit('Export',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
						<?php } else { ?>
								<td colspan="2" align="left" valign="middle" style="padding:67px 0 0 10px;"><?php echo $this->Form->submit('Filter Users',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
						<?php } ?>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <?php echo $this->Form->end();?> </div>
        </div>
        <!-- display box / first -->
        <div class="box">
          <div class="display_row">
            <div class="table">
              <?php
                // task id 3899
                if(strtolower($loginRole)=='referal' || strtolower($loginRole)=='referral'){
               	 $this->Grid->addColumn('Name', '/Merchant/merchantName',array('paginate'=>true,'linkable' => array('url' => array('action' => 'view'),'trailingParams' => array('/Merchant/id'))),'merchantName');
                }else{
               	 $this->Grid->addColumn('Name', '/Merchant/merchantName',array('paginate'=>true,'linkable' => array('url' => array('action' => 'edit'),'trailingParams' => array('/Merchant/id'))),'merchantName');
                }								
				$this->Grid->addColumn('DBA', '/Merchant/merchantDBA', array('paginate'=>true),'merchantDBA');			 
				$this->Grid->addColumn('URL', '/Merchant/merchantURL', array('paginate'=>true,'type'=>'url'),'merchantURL');												
				$this->Grid->addColumn('VOLUME', '/Merchant/volume', array('paginate'=>true),'volume');
				$this->Grid->addColumn('PROCESSOR', '/Processor/user_Name', array('paginate'=>true),'Processor.user_Name');
				if(isset($manager)){	
					$this->Grid->addColumn('MANAGER', '/Manager/user_Name', array('paginate'=>true),'Manager.user_Name');
				} else {
					$this->Grid->addColumn($agent_iso_referral, '/User/user_Name', array('paginate'=>true),'User.user_Name');
				}
				$this->Grid->addColumn('STATUS', '/Status/status', array('paginate'=>true),'Status.status');
				$this->Grid->addColumn('MID#', '/Merchant/CID', array('paginate'=>true),'Merchant.CID');
				$this->Grid->addColumn('PRO. METHOD', '/ProcessingMethod/accountCategory', array('paginate'=>true),'ProcessingMethod.accountCategory');
				
				$this->Grid->addColumn('Days In', '/Merchant/merchantStatus', array('paginate'=>true),'ProcessingMethod.accountCategory');
				
				$this->Grid->addAction('Edit', array('controller' => 'merchants', 'action' => 'edit'), array('/Merchant/id'));
				$this->Grid->addAction('Delete', array('controller' => 'merchants', 'action' => 'delete'), array('/Merchant/id'));
				$this->Grid->addAction('View', array('controller' => 'merchants', 'action' => 'view'), array('/Merchant/id'));
				echo $this->Grid->generate($MerchantRec);
				?>
              <div class="paginator">
                <?php if($totalUser>0):?>
                <?php echo $this->element('admin-paging');?>
               
                <?php endif;?>
              </div>
            </div>
          </div>
          <!-- display box / second end here -->
        </div>
        <!-- end table -->
      </div>
    </div>
  </div>
  <!-- end content / right -->
</div>
<script type="text/javascript">
jQuery.noConflict();
/*jQuery("#MerchantStatusID").multiselect({
	header: 'Select Any Staus!'
});*/
jQuery("#MerchantStatusID").multiselect({});
jQuery("#MerchantManagerID").multiselect({});
jQuery("#MerchantProcessorID").multiselect({});
jQuery("#MerchantIsoID").multiselect({});
jQuery("#MerchantAgentID").multiselect({});
jQuery("#MerchantAccountTypeID").multiselect({});
jQuery("#MerchantReferalID").multiselect({});
jQuery("#MerchantGatewayID").multiselect({});
jQuery("#MerchantAccountCatID").multiselect({});
</script>