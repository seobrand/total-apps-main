<div class="content">
<div id="right">
<div id="right2">
<div class="box1">
	<div class="news_announcement">
		<div class="titlebar">View Mass Merchant Modifications History</div>
		<div class="box">
            <div class="display_row">
               <?php //echo $this->Paginator->numbers(array('first' => 'First page'));?>
              <?php foreach($history_dates as $key => $dates){?>
              <div class="rollback_title">
              	<span class="date_title"><?php echo $dates['MerchantBulkModificationRollback']['created'];?> BY <?php echo $dates['MerchantBulkModificationRollback']['created_by'];?></span>
              	<span class="rollback_button">
              	  <?php echo $this->Form->create('Rollback', array('id'=>'Rollback_'.$key,'url' => array('controller' => 'mass_merchant_updates', 'action' => 'rollback')));?>
                  <?php echo $this->Form->submit('Rollback',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'));?>
                  <?php echo $this->Form->input('rollback_date',array('type'=>'hidden','value'=>$dates['MerchantBulkModificationRollback']['created']));?>
                  <?php echo $this->Form->end();?>
              	</span>
              </div>
              <div class="table" style="padding-bottom: 50px;">              
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
					<?php foreach($history as $log){?>
						<?php if($log['MerchantBulkModificationRollback']['created']==$dates['MerchantBulkModificationRollback']['created']){?>
						<?php $merchantChangedValues = $common->getMerchantRollbackUpdateValues($log['MerchantBulkModificationRollback']['merchantID']);?>
						<?php 	// compare changed value to old values
							$difference = array_diff_assoc($log['MerchantBulkModificationRollback'],$merchantChangedValues['Merchant']);
						?>
						<?php /*echo "<pre>";?>
						<?php print_r($difference);*/?>
						<?php $blueGatewayClass 	= array_key_exists('gatewayID', $difference)?'boldBlueColor':''; ?>
						<?php $blueAcClass 			= array_key_exists('accountCategory', $difference)?'boldBlueColor':''; ?>
						<?php $blueProIdClass 		= array_key_exists('processorID', $difference)?'boldBlueColor':''; ?>
						<?php $blueisoIDClass 		= array_key_exists('isoID', $difference)?'boldBlueColor':''; ?>
						<?php $blueStatusClass 		= array_key_exists('statusID', $difference)?'boldBlueColor':''; ?>
						<?php $blueAgentClass 		= array_key_exists('agentID', $difference)?'boldBlueColor':''; ?>
						<?php $blueManagerClass 	= array_key_exists('managerID', $difference)?'boldBlueColor':''; ?>
						<?php $blueReferralClass 	= array_key_exists('referalID', $difference)?'boldBlueColor':''; ?>
						<?php $blueMerchantCatClass = array_key_exists('accountTypeID', $difference)?'boldBlueColor':''; ?>
						<tr class="cg_row">
							<td align="center"><?php echo $log['Merchant']['merchantName']?></td>
							<td align="center"><?php echo $log['Merchant']['CID']?></td>
							<td align="center" class="<?php echo $blueGatewayClass?>"><?php echo $gatwayList[$log['MerchantBulkModificationRollback']['gatewayID']]?></td>
							<td align="center" class="<?php echo $blueAcClass?>"><?php echo $acat_list[$log['MerchantBulkModificationRollback']['accountCategory']]?></td>
							<td align="center" class="<?php echo $blueProIdClass?>"><?php echo $procList[$log['MerchantBulkModificationRollback']['processorID']]?></td>
							<td align="center" class="<?php echo $blueisoIDClass?>"><?php echo $isoList[$log['MerchantBulkModificationRollback']['isoID']]?></td>
							<td align="center" class="<?php echo $blueStatusClass?>"><?php echo $status[$log['MerchantBulkModificationRollback']['statusID']]?></td>
							<td align="center" class="<?php echo $blueAgentClass?>"><?php echo $agentList[$log['MerchantBulkModificationRollback']['agentID']]?></td>
							<td align="center" class="<?php echo $blueManagerClass?>"><?php echo $mangList[$log['MerchantBulkModificationRollback']['managerID']]?></td>
							<td align="center" class="<?php echo $blueReferralClass?>"><?php echo $referalList[$log['MerchantBulkModificationRollback']['referalID']]?></td>
							<td align="center" class="<?php echo $blueMerchantCatClass?>"><?php echo $merchantCatList[$log['MerchantBulkModificationRollback']['accountTypeID']]?></td>
						</tr>
						<?php }?>																
					<?php }?>					
				</table>
				</div>				
              </div>
              <?php }?>
              <div style="padding:0 10px;">
              <?php echo $this->element('admin-paging');?>
              </div>
            </div>
            <!-- display box / second end here -->
         </div>
	</div>
</div>
</div>
</div>
</div>