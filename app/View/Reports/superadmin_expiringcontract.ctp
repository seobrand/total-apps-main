<?php  echo $this->Html->script('table_sorter/jquery.tablesorter.js');?>
<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  $loginRole = $this->Session->read('UserAuth.UserGroup.name');
// $this->Session->read('UserAuth.User.id');
?>
<script type="text/javascript">
 jq = jQuery.noConflict();
 jq(document).ready(function() 
 { 
	 jq("#non_expiration_merchant").tablesorter({ 
	        // pass the headers argument and assing a object 
	        headers: { // assign the fifth column (we start counting zero) 
	            4: {                  
	                sorter: false // disable it by setting the property sorter to false
	            }
	        } 
	    }); 
 } 
); 
</script>
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
            <?php  echo $this->Form->create('Merchant',array('type'=>'get')); ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
              <tr>
                <td width="75%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="12%" align="center" valign="top"><strong class="big_text">Filter:</strong></td>
                      <td width="88%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td valign="top" style="padding:0px" align="left">
                              <ul class="shiftable_data">
                                <li>Contract Expiration Date(FROM):<br /><br />
                                  <?php echo $this->Form->input('Merchant.contract_expiration_from',array('type'=>'text','label'=>false,'class'=>'input1')); ?> </li>
                                <li>Contract Expiration Date(TO):<br /><br />
                                  <?php echo $this->Form->input('Merchant.contract_expiration_to',array('type'=>'text','label'=>false,'class'=>'input1')); ?> </li>
                              </ul>
                              <div class="clear"></div></td>
                          </tr>
                          <tr>
                            <td width="33%" align="left" valign="top" style="padding: 0px"><?php echo $this->Form->submit('Filter Merchant',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> &nbsp;&nbsp; <?php //echo $this->Form->submit('Export',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
                <td align="left" valign="top" style="padding:0 0 0 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle">Users Returned: </td>
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
                /* $this->Grid->addColumn('Name', '/Merchant/merchantName',array('paginate'=>true,'linkable' => array('url' => array('controller'=>'merchants','action' => 'view'),'trailingParams' => array('/Merchant/id'))),'merchantName');
                $this->Grid->addColumn('Name', '/Merchant/merchantName',array('paginate'=>true,'linkable' => array('url' => array('controller'=>'merchants','action' => 'edit'),'trailingParams' => array('/Merchant/id'))),'merchantName'); */
                $this->Grid->addColumn('DBA', '/Merchant/merchantDBA',array('paginate'=>true,'linkable' => array('url' => array('controller'=>'merchants','action' => 'edit'),'trailingParams' => array('/Merchant/id'),'options'=>array('target'=>'_blank'))),'merchantDBA');
                $this->Grid->addColumn('MID', '/Merchant/CID', array('paginate'=>true),'CID');
                $this->Grid->addColumn('STATUS', '/Status/status', array('paginate'=>true),'Status.status');
                $this->Grid->addColumn('PROCESSOR', '/Processor/user_Name', array('paginate'=>true),'Processor.user_Name');
                $this->Grid->addColumn('APPROVAL DATE', '/Merchant/contract_approval', array('paginate'=>true),'contract_approval');
                $this->Grid->addColumn('CONTRACT EXPIRATION DATE', '/Merchant/contract_expiration', array('paginate'=>true),'contract_expiration');
				echo $this->Grid->generate($MerchantRec);
				?>
              <div class="paginator">
                <?php if($totalUser>0):?>
                <?php echo $this->element('admin-paging');?>
               
                <?php endif;?>
              </div>
            </div>
            <?php // task id 3498 (on dev server)?>
            <div class="breadcrumb">Merchant accounts that currently do not have a contract expiration date</div>
            <div class="table autoscroll" style="max-height: 600px;margin:0px!important;width:97.5%">
             <?php echo $this->Form->create();?>
             <table width="100%" class="tablesorter cg_table" id="non_expiration_merchant">             
             <thead>
				<tr class="cg_header">
					<th>DBA</th>
					<th>MID</th>
					<th>STATUS</th>
					<th>PROCESSOR</th>
					<th>APPROVAL DATE</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($merchant_without_contract_exp as $merchant){?>
			<tr class="cg_row">
				<td><?php echo $this->Html->link($merchant['Merchant']['merchantDBA'],array('controller'=>'merchants','action'=>'edit',$merchant['Merchant']['id']),array('target'=>'_blank'));?></td>
				<td><?php echo $merchant['Merchant']['CID'];?></td>
				<td><?php echo $merchant['Status']['status'];?></td>
				<td><?php echo $merchant['Processor']['user_Name'];?></td>
				<td><?php echo $this->Form->input('Merchant.contract_approval.'.$merchant['Merchant']['id'],array('type'=>'text','id'=>'contract_approval_'.$merchant['Merchant']['id'],'div'=>false,'label'=>false,'class'=>'input1'));?></td>
			</tr>
			<?php }?>
			</tbody>
			<tr><td colspan="5" align="center"><?php echo $this->Form->submit('Update',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td></tr>
			</table>
			<?php echo $this->Form->end();?>
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
jQuery(document).ready(function(){
	jQuery("#MerchantContractExpirationFrom").datepicker({
		dateFormat: "mm/dd/yy",
	});
	jQuery("#MerchantContractExpirationTo").datepicker({
		dateFormat: "mm/dd/yy",
	});

	<?php foreach($merchant_without_contract_exp as $merchant){?>
		jQuery("#contract_approval_"+<?php echo $merchant['Merchant']['id']?>).datepicker({
			dateFormat: "yy-mm-dd",
		});
	<?php }?>
	
});
</script>