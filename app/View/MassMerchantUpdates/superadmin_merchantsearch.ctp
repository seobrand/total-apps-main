<?php if(!$this->request->is('ajax')){?>
<div class="content">
<div id="right">	
<div id="right2">
<div class="box" id="content_form">  
<div class="news_announcement">
		<div class="titlebar">Filter Option</div>
			<?php echo $this->Form->create('mass_merchant_search',array('id'=>'mass_merchant_search'))?>
			<div class="news_indent" style="overflow: hidden">
				<div class="filter_dropdowns">
					<table class="bulk_filter_dropdown" cellpadding="0" cellspacing="0" width="50%" style="float: left">
						<tr><td>STATUS:</td><td><?php echo $this->Form->input('MassMerchantUpdates.status',array('class'=>'select1 bulk_user_status','id'=>'user_status','type'=>'select','options'=>$user_status,'label'=>false,'div'=>false,'onChange'=>'userByStatusAjax()'));?></td></tr>
						<tr><td>GATEWAY:</td><td><?php echo $this->Form->input('MassMerchantUpdates.gatewayID',array('id'=>'merchant_gateway','type'=>'select','multiple'=>'multiple','options'=>$gatwayList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>
						<tr><td>PROCESSING METHOD:</td><td><?php echo $this->Form->input('MassMerchantUpdates.accountCategory',array('id'=>'merchant_pro_method','type'=>'select','multiple'=>'multiple','options'=>$acat_list,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>
						<tr><td>PROCESSOR:</td><td id="processorlisttd"><?php echo $this->Form->input('MassMerchantUpdates.processorID',array('id'=>'merchant_processorid','type'=>'select','multiple'=>'multiple','options'=>$procList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>
						<tr><td>ISO:</td><td id="isolisttd"><?php echo $this->Form->input('MassMerchantUpdates.isoID',array('id'=>'merchant_isoid','type'=>'select','multiple'=>'multiple','options'=>$isoList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>
					</table>
					<table class="bulk_filter_dropdown" cellpadding="0" cellspacing="0" width="48%" style="float: right">						
						<tr><td>STATUS:</td><td><?php echo $this->Form->input('MassMerchantUpdates.statusID',array('id'=>'merchant_statusid','type'=>'select','multiple'=>'multiple','options'=>$statusList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>
						<tr><td>AGENT:</td><td id="agentlisttd"><?php echo $this->Form->input('MassMerchantUpdates.agentID',array('id'=>'merchant_agentid','type'=>'select','multiple'=>'multiple','options'=>$agentList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>
						<tr><td>MANAGER:</td><td id="managerlisttd"><?php echo $this->Form->input('MassMerchantUpdates.managerID',array('id'=>'merchant_manid','type'=>'select','multiple'=>'multiple','options'=>$mangList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>
						<tr><td>REFERRAL:</td><td id="referrallisttd"><?php echo $this->Form->input('MassMerchantUpdates.referalID',array('id'=>'merchant_refid','type'=>'select','multiple'=>'multiple','options'=>$referalList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>
						<tr><td>MERCHANT CATEGORY:</td><td id="merchantcattd"><?php echo $this->Form->input('MassMerchantUpdates.accountTypeID',array('id'=>'merchant_merchantcatid','type'=>'select','multiple'=>'multiple','options'=>$merchantCatList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:260px;'));?></td></tr>					
					</table>
				</div>
				<div class="submit_botton" style="float: left;"><?php echo $this->Form->submit('Search',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></div>
			</div>
		
		<?php echo $this->Form->end();?>
	
<?php }?>


<?php if(isset($merchantlist)){?>
<?php //$this->Paginator->options(array('update' => '#content_search','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('merchantInfo','agentInfo')"));?>
	<!-- Hanuman code from here -->
	<?php echo $this->Form->create('MassMerchantUpdate',array('id'=>'MassMerchantUpdate','action'=>'approve'));?>
	<?php if(!$this->request->is('ajax')){?>	
	<div class="table_new">
		<div class="bulk_info">Bulk or Separated Modification</div>
		<div class="bulk_table">
			<table width="100%" class="cg_table">
				<tr class="cg_header">
					<th>Gateway</th>
					<th>Processing<br/>Method</th>
					<th>Processor</th>
					<th>ISO</th>
					<th>Status</th>
					<th>Agent</th>
					<th>Manager</th>
					<th>REFERRAL</th>
					<th>Merchant<br/>Category</th>
				</tr>
				<tr class="cg_row odd">
					<td><?php echo $this->Form->input('gatewayID',array('type'=>'select','options'=>$gatwayList,'empty'=>'-Select Gateway-','label'=>false,'class'=>'combobox'));?></td>
					<td><?php echo $this->Form->input('accountCategory',array('type'=>'select','options'=>$acat_list,'empty'=>'-Processing Method-','label'=>false,'class'=>'combobox')); ?></td>
					<td><?php echo $this->Form->input('processorID',array('type'=>'select','options'=>$procList,'empty'=>'-Select Processor-','label'=>false,'class'=>'combobox'));?></td>
					<td><?php echo $this->Form->input('isoID',array('type'=>'select','options'=>$isoList,'empty'=>'-Select ISO-','label'=>false,'class'=>'combobox')); ?></td>
					<td><?php echo $this->Form->input('statusID',array('type'=>'select','options'=>$statusList,'empty'=>'-Select Status-','label'=>false,'class'=>'combobox')); ?></td>
					<td><?php echo $this->Form->input('agentID',array('type'=>'select','options'=>$agentList,'empty'=>'-Select Agent-','label'=>false,'class'=>'combobox')); ?></td>
					<td><?php echo $this->Form->input('managerID',array('type'=>'select','options'=>$mangList,'empty'=>'-Select Manager-','label'=>false,'class'=>'combobox')); ?></td>
					<td><?php echo $this->Form->input('referalID',array('type'=>'select','options'=>$referalList,'empty'=>'-Select Referral-','label'=>false,'class'=>'combobox')); ?></td>
					<td><?php echo $this->Form->input('accountTypeID',array('type'=>'select','options'=>$merchantCatList,'empty'=>'-Select Merchant Category-','label'=>false,'class'=>'combobox')); ?></td>
					</tr>
			</table>
		</div>
		<div class="clear"></div>
		<div class="bulk_note">
			<strong>Please Note:</strong> for bulk modification please click on
			the checkbox of each of the merchants you wish to edit in bulk and
			make the needed modification for the form shown above. if you wish to
			make detailed seperated modification for each account, please make the
			modification from the form presented below for each of the merchants
			you need to modify.
		</div>
	</div>
	
	<div class="table_new" id="content_search">	
	<?php } ?>			
		<table width="100%" class="cg_table">
			<tr class="cg_header">
				<th class="first_checkbox"><input type="checkbox" name="merchant_select_all" onclick="selectAllMerchant()" value="all_merchant" id="select_all_merchant"></th>
				<th>Merchant Name</th>
				<th>MID</th>
				<th>GATEWAY</th>
				<th>PROCESSING<br/>METHOD</th>
				<th>PROCESSOR</th>
				<th>ISO</th>
				<th>STATUS</th>
				<th>AGENT</th>
				<th>MANAGER</th>
				<th>REFERRAL</th>
				<th>Merchant<br/>Category</th>
			</tr>
			<?php foreach($merchantlist as $mass_merchant):?>
			<tr class="cg_row odd">
				<td class="first_checkbox"><input type="checkbox" name="data[mass_merchant_id][merchantID][]" onclick="merchantcheck('<?php echo $mass_merchant['Merchant']['id'];?>')" value="<?php echo $mass_merchant['Merchant']['id'];?>" id="merchant_<?php echo $mass_merchant['Merchant']['id'];?>" /></td>
				<td><?php echo $mass_merchant['Merchant']['merchantName']?></td>
				<td><?php echo $mass_merchant['Merchant']['CID']?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.gatewayID',array('type'=>'select','options'=>$gatwayList,'empty'=>'-Select Gateway-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['gatewayID'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'GatewayID\')'));?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.accountCategory',array('type'=>'select','options'=>$acat_list,'empty'=>'-Processing Method-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['accountCategory'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'AccountCategory\')')); ?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.processorID',array('type'=>'select','options'=>$procList,'empty'=>'-Select Processor-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['processorID'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'ProcessorID\')'));?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.isoID',array('type'=>'select','options'=>$isoList,'empty'=>'-Select ISO-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['isoID'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'IsoID\')')); ?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.statusID',array('type'=>'select','options'=>$statusList,'empty'=>'-Select Status-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['statusID'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'StatusID\')')); ?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.agentID',array('type'=>'select','options'=>$agentList,'empty'=>'-Select Agent-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['agentID'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'AgentID\')')); ?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.managerID',array('type'=>'select','options'=>$mangList,'empty'=>'-Select Manager-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['managerID'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'ManagerID\')')); ?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.referalID',array('type'=>'select','options'=>$referalList,'empty'=>'-Select Referral-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['referalID'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'ReferalID\')')); ?></td>
				<td><?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.accountTypeID',array('type'=>'select','options'=>$merchantCatList,'empty'=>'-Select Merchant Category-','label'=>false,'class'=>'combobox','selected' => $mass_merchant['Merchant']['accountTypeID'],'onchange'=>'blueStroke('.$mass_merchant['Merchant']['id'].',\'AccountTypeID\')')); ?></td>
			</tr>
				<?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.merchantName',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['merchantName']));?>
				<?php echo $this->Form->input('Merchant.'.$mass_merchant['Merchant']['id'].'.CID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['CID']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.gatewayID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['gatewayID']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.accountCategory',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['accountCategory']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.processorID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['processorID']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.isoID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['isoID']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.statusID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['statusID']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.agentID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['agentID']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.managerID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['managerID']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.referalID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['referalID']));?>
				<?php echo $this->Form->input('MerchantOldValue.'.$mass_merchant['Merchant']['id'].'.accountTypeID',array('type'=>'hidden','value'=>$mass_merchant['Merchant']['accountTypeID']));?>
			<?php endforeach;?>
				<input type="hidden" name="data[modified_merchant][merchantID]" id="modified_merchants"/>
			<?php if(count($merchantlist)==0):?>
				<tr><td colspan="12">No Merchant Found..</td></tr>
			<?php endif; ?>
		</table>
		<?php /** paging remove as issue no 3 in comment of 18 Nov 2013 ?>
		<div id="spinner" class="agent-ajax-paging-loader" style="position: fixed">
			<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
		</div>
		<div class="paginator">
			<?php echo $this->Paginator->numbers(array('first' => 'First page'));?>
		</div>
		<?php */?>				
	</div>	
	<div class="submit_botton"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></div>
	<?php }?>
	<?php echo $this->Form->end();?>
	<!-- Hanuman code from here -->
</div>	
</div>
</div>
<?php //echo $this->Js->writeBuffer();?>
<script type="text/javascript">
function userByStatusAjax(){
	var status = $("#user_status").val();	
	get_url = "<?php echo FULL_BASE_URL.router::url('/',false).'superadmin/mass_merchant_updates/getuserbyajax/';?>";
	get_url += status;
	$.ajax({
		type:"GET",
		url:get_url,
		success : function(data){
		   	result = data.split('divide_from_here');
			document.getElementById('agentlisttd').innerHTML=result[0];
			document.getElementById('managerlisttd').innerHTML=result[1];
			document.getElementById('isolisttd').innerHTML=result[2];
			document.getElementById('processorlisttd').innerHTML=result[3];
			document.getElementById('referrallisttd').innerHTML=result[4];
			jQuery("#merchant_processorid").multiselect({
				header: 'Select Any Processor!'
			});
			jQuery("#merchant_isoid").multiselect({
				header: 'Select Any ISO!'
			});
			jQuery("#merchant_agentid").multiselect({
				header: 'Select Any Agent!'
			});
			jQuery("#merchant_manid").multiselect({
				header: 'Select Any Manager!'
			});
			jQuery("#merchant_refid").multiselect({
				header: 'Select Any Referral!'
			});
		},
		error : function() {
		   alert('There is some problem in URL');
		},
	})	
}
/** for multiselect dropdown **/
jQuery.noConflict();
jQuery("#merchant_gateway").multiselect({
	header: 'Select Any Gateway!'
});
jQuery("#merchant_pro_method").multiselect({
	header: 'Select Any Processing Method!'
});
jQuery("#merchant_processorid").multiselect({
	header: 'Select Any Processor!'
});
jQuery("#merchant_isoid").multiselect({
	header: 'Select Any ISO!'
});
jQuery("#merchant_statusid").multiselect({
	header: 'Select Any Status!'
});
jQuery("#merchant_agentid").multiselect({
	header: 'Select Any Agent!'
});
jQuery("#merchant_manid").multiselect({
	header: 'Select Any Manager!'
});
jQuery("#merchant_refid").multiselect({
	header: 'Select Any Referral!'
});
jQuery("#merchant_merchantcatid").multiselect({
	header: 'Select Any Merchant Category!'
});

</script>
<?php echo $this->Html->script('bulk_merchant_function'); ?>
