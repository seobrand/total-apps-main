<?php 
$selected_merchant = $this->Session->read('mass_merchant_id.merchantID');
$updated_uncheck_merchant = $this->Session->read('updated_uncheck_merchant');
$checked_merchant = $this->Session->read('checked_merchant');
$merchant_old_data = $this->Session->read('MerchantOldValue');
$merchant_new_data = $this->Session->read('Merchant');
$bulk_update_data  = $this->Session->read('MassMerchantUpdate'); // apply this value to all selected merchants

?>
<div class="content">
<div id="right">
<div id="right2">
<div class="box1">
	<div class="news_announcement">
		<div class="titlebar">View Mass Merchant Modifications</div>
		<div class="box">
            <div class="display_row">
              <div class="table">
              <?php echo $this->Form->create("MassMerchantModification",array('id'=>'MassMerchantModification'));?>
              <div style="max-height:500px;overflow:auto;">
				<table width="100%" class="cg_table">
					<tr class="cg_header">
					  <th>Merchant Name</th>
					  <th>MID</th>
					  <th>Gateway</th>
					  <th>Processing Method</th>
					  <th>Processor</th>
					  <th>Iso</th>
					  <th>Status</th>
					  <th>Agent</th>
					  <th>Manager</th>
					  <th>Referral</th>
					  <th>Merchant Category</th>
					</tr>								
					<?php $total_exist = 0;?>
					<?php foreach($selected_merchant as $merchantID){?>						
						<?php if(in_array($merchantID, $checked_merchant)){?>
							<?php // apply bulk modification values from top area for checked merchant ?>
							<?php $gatewayID 		= !empty($bulk_update_data['gatewayID']) ? $bulk_update_data['gatewayID'] : $merchant_old_data[$merchantID]['gatewayID'];?>
							<?php $accountCategory 	= !empty($bulk_update_data['accountCategory']) ? $bulk_update_data['accountCategory'] : $merchant_old_data[$merchantID]['accountCategory'];?>
							<?php $processorID		= !empty($bulk_update_data['processorID']) ? $bulk_update_data['processorID'] : $merchant_old_data[$merchantID]['processorID'];?>
							<?php $isoID			= !empty($bulk_update_data['isoID']) ? $bulk_update_data['isoID'] : $merchant_old_data[$merchantID]['isoID'];?>
							<?php $statusID			= !empty($bulk_update_data['statusID']) ? $bulk_update_data['statusID'] : $merchant_old_data[$merchantID]['statusID'];?>
							<?php $agentID			= !empty($bulk_update_data['agentID']) ? $bulk_update_data['agentID'] : $merchant_old_data[$merchantID]['agentID'];?>
							<?php $managerID		= !empty($bulk_update_data['managerID']) ? $bulk_update_data['managerID'] : $merchant_old_data[$merchantID]['managerID'];?>
							<?php $referalID		= !empty($bulk_update_data['referalID']) ? $bulk_update_data['referalID'] : $merchant_old_data[$merchantID]['referalID'];?>
							<?php $accountTypeID	= !empty($bulk_update_data['accountTypeID']) ? $bulk_update_data['accountTypeID'] : $merchant_old_data[$merchantID]['accountTypeID'];?>
						<?php }else{?>
							<?php // apply indivisual modification values for updated uncheck merchant ?>
							<?php $gatewayID 		= $merchant_new_data[$merchantID]['gatewayID'];?>
							<?php $accountCategory 	= $merchant_new_data[$merchantID]['accountCategory'];?>
							<?php $processorID		= $merchant_new_data[$merchantID]['processorID'];?>
							<?php $isoID			= $merchant_new_data[$merchantID]['isoID'];?>
							<?php $statusID			= $merchant_new_data[$merchantID]['statusID'];?>
							<?php $agentID			= $merchant_new_data[$merchantID]['agentID'];?>
							<?php $managerID		= $merchant_new_data[$merchantID]['managerID'];?>
							<?php $referalID		= $merchant_new_data[$merchantID]['referalID'];?>
							<?php $accountTypeID	= $merchant_new_data[$merchantID]['accountTypeID'];?>
						<?php }?>
						<?php $total_exist++; ?>
						<?php $blueGatewayClass 	= ($gatewayID!=$merchant_old_data[$merchantID]['gatewayID'])?'boldBlueColor':''; ?>
						<?php $blueAcClass 			= ($accountCategory!=$merchant_old_data[$merchantID]['accountCategory'])?'boldBlueColor':''; ?>
						<?php $blueProIdClass 		= ($processorID!=$merchant_old_data[$merchantID]['processorID'])?'boldBlueColor':''; ?>
						<?php $blueisoIDClass 		= ($isoID!=$merchant_old_data[$merchantID]['isoID'])?'boldBlueColor':''; ?>
						<?php $blueStatusClass 		= ($statusID!=$merchant_old_data[$merchantID]['statusID'])?'boldBlueColor':''; ?>
						<?php $blueAgentClass 		= ($agentID!=$merchant_old_data[$merchantID]['agentID'])?'boldBlueColor':''; ?>
						<?php $blueManagerClass 	= ($managerID!=$merchant_old_data[$merchantID]['managerID'])?'boldBlueColor':''; ?>
						<?php $blueReferralClass 	= ($referalID!=$merchant_old_data[$merchantID]['referalID'])?'boldBlueColor':''; ?>
						<?php $blueMerchantCatClass	= ($accountTypeID!=$merchant_old_data[$merchantID]['accountTypeID'])?'boldBlueColor':''; ?>
						
							<tr class="cg_row">
								<td align="center"><?php echo $merchant_new_data[$merchantID]['merchantName'];?></td>
								<td align="center"><?php echo $merchant_new_data[$merchantID]['CID'];?></td>
								<td align="center" class="<?php echo $blueGatewayClass;?>"><?php echo $gatwayList[$gatewayID];?></td>
								<td align="center" class="<?php echo $blueAcClass;?>"><?php echo $acat_list[$accountCategory];?></td>
								<td align="center" class="<?php echo $blueProIdClass;?>"><?php echo $procList[$processorID];?></td>
								<td align="center" class="<?php echo $blueisoIDClass;?>"><?php echo $isoList[$isoID];?></td>
								<td align="center" class="<?php echo $blueStatusClass;?>"><?php echo $status[$statusID];?></td>
								<td align="center" class="<?php echo $blueAgentClass;?>"><?php echo $agentList[$agentID];?></td>
								<td align="center" class="<?php echo $blueManagerClass;?>"><?php echo $mangList[$managerID];?></td>
								<td align="center" class="<?php echo $blueReferralClass;?>"><?php echo $referalList[$referalID];?></td>
								<td align="center" class="<?php echo $blueMerchantCatClass;?>"><?php echo $merchantCatList[$accountTypeID];?></td>
							</tr>
								<?php // assign values to hidden fields ?>
								<?php echo $this->Form->input('final_array.'.$merchantID.'.gatewayID',array('type'=>'hidden','value'=>$gatewayID))?>
			                  	<?php echo $this->Form->input('final_array.'.$merchantID.'.accountCategory',array('type'=>'hidden','value'=>$accountCategory))?>
			                  	<?php echo $this->Form->input('final_array.'.$merchantID.'.processorID',array('type'=>'hidden','value'=>$processorID))?>
			                 	<?php echo $this->Form->input('final_array.'.$merchantID.'.isoID',array('type'=>'hidden','value'=>$isoID))?>
			                  	<?php echo $this->Form->input('final_array.'.$merchantID.'.statusID',array('type'=>'hidden','value'=>$statusID))?>
			                  	<?php echo $this->Form->input('final_array.'.$merchantID.'.agentID',array('type'=>'hidden','value'=>$agentID))?>
			                  	<?php echo $this->Form->input('final_array.'.$merchantID.'.managerID',array('type'=>'hidden','value'=>$managerID))?>
			                  	<?php echo $this->Form->input('final_array.'.$merchantID.'.referalID',array('type'=>'hidden','value'=>$referalID))?>
			                  	<?php echo $this->Form->input('final_array.'.$merchantID.'.accountTypeID',array('type'=>'hidden','value'=>$accountTypeID))?>									
					<?php }?>
					<?php if($total_exist==0){?>
						<tr class="cg_row">
						  <td align="center" colspan="11">No modification made for any merchant.</td>
						</tr>
					<?php }?>
				</table>
				</div>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table" align="center" style="margin-top: 5px;">
	                <tr>
	                <?php if($total_exist>0){?>
	                  <td width="50%" align="right">
		                  <?php echo $this->Form->submit('Approve',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'));?>
	                  </td>
	                <?php }?>
	           		<?php echo $this->Form->end();?>
	                  <td <?php if($total_exist>0){?> width="50%" align="left" <?php }else{?> width="100%" align="center"<?php }?>>
	                  <a class="cursorclass a-state-default ui-corner-all" href="javascript:void(0);" onclick="history.go(-1); return false;">Cancel</a>
		             </td>
	                </tr>
	            </table>
              </div>
            </div>
            <!-- display box / second end here -->
         </div>
	</div>
</div>
</div>
</div>
</div>