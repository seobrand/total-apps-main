<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  $loginRole = $this->Session->read('UserAuth.UserGroup.name');
// $this->Session->read('UserAuth.User.id');
?>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
        <?php echo $this->Form->create('Merchant',array('action'=>'search/','type'=>'get'));?>
        <?php // task id 3085 jan 16 2014?>
          <div class="titlebar">MERCHANT SEARCH&nbsp;<?php echo $this->Form->input('Merchant.common_search',array('type'=>'text','div'=>false,'label'=>false,'class'=>'contact_expiration'))?><input type="submit" value="" class="arrow_submit"></div>
          <div class="news_indent">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table merchant_table">
              <tr>
                <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr height="39">
                      <td width="30%" align="left" valign="middle">Legal Name </td>
                      <td width="70%" align="left" valign="middle"><?php echo $this->Form->input('Merchant.merchantName',array('label'=>false,'class'=>'input1'));?></td>
                    </tr>
                    <tr height="39">
                      <td align="left" valign="middle">Contact Name </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.contactName',array('label'=>false,'class'=>'input1'));?></td>
                    </tr>
                    <tr height="39">
                      <td align="left" valign="middle">Contact Phone  </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.contactPhone',array('label'=>false,'class'=>'input1'));?></td>
                    </tr>
                    <tr height="39">
                      <td align="left" valign="middle">Contact Email  </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.contactEmail',array('label'=>false,'class'=>'input1'));?></td>
                    </tr>
                    <tr height="39">
                      <td align="left" valign="middle">Merchant DBA  </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.merchantDBA',array('label'=>false,'class'=>'input1'));?></td>
                    </tr>
                    <tr height="39">
                      <td align="left" valign="middle">Merchant URL  </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.merchantURL',array('label'=>false,'class'=>'input1'));?></td>
                    </tr>
					<tr height="39">
                      <!--<td align="left" valign="middle"><strong>MID </strong> </td>-->
                      <td align="left" valign="middle">MID </td>
                      <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.CID',array('label'=>false,'class'=>'input1'));?></td>
                    </tr>

                  </table></td>
                <td width="40%" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr height="39">
                      <td align="left" valign="middle" width="25%">Status  </td>
                      <td align="left" valign="middle" width="75%"><?php echo $this->Form->input('Merchant.statusID',array('type'=>'select','options'=>$status,'multiple'=>'multiple','selected' => $statusID,'label'=>false,'style'=>'width:290px;')); ?></td>
                    </tr>					
                    <tr height="39">
                      <td align="left" valign="middle"> Agent  </td>
                      <td align="left" valign="middle">
                      <?php if(strtolower($loginRole)=='agent'):?>
                      	<?php echo $this->Form->input('Merchant.agentID',array('type'=>'select','options'=>$agentList,'multiple'=>'multiple','selected' => $agentID,'label'=>false,'style'=>'width:290px;','disabled'=>'disabled')); ?>
                      <?php else:?>
                      	<?php echo $this->Form->input('Merchant.agentID',array('type'=>'select','options'=>$agentList,'multiple'=>'multiple','selected' => $agentID,'label'=>false,'style'=>'width:290px;')); ?>
                      <?php endif;?>
                      </td>
                    </tr>
                    <tr height="39">
                      <td align="left" valign="middle">Processor  </td>
                      <td align="left" valign="middle">
                      <?php if(strtolower($loginRole)=='processor'):?>
                      	<?php echo $this->Form->input('Merchant.processorID',array('type'=>'select','options'=>$procList,'multiple'=>'multiple','selected' => $processorID,'label'=>false,'style'=>'width:290px;','disabled'=>'disabled')); ?>
                      <?php else:?>
                      	<?php echo $this->Form->input('Merchant.processorID',array('type'=>'select','options'=>$procList,'multiple'=>'multiple','selected' => $processorID,'label'=>false,'style'=>'width:290px;')); ?>
                      <?php endif;?>
                      </td>
                    </tr>					
                    <tr height="39">
                      <td align="left" valign="middle"> Manager  </td>
                      <td align="left" valign="middle">
                      <?php if(strtolower($loginRole)=='manager'):?>
                      	<?php echo $this->Form->input('Merchant.managerID',array('type'=>'select','options'=>$mangList,'multiple'=>'multiple','selected' => $managerID,'label'=>false,'style'=>'width:290px;','disabled'=>'disabled')); ?>
                      <?php else:?>
                      	<?php echo $this->Form->input('Merchant.managerID',array('type'=>'select','options'=>$mangList,'multiple'=>'multiple','selected' => $managerID,'label'=>false,'style'=>'width:290px;')); ?>
                      <?php endif;?>                      
                      </td>
                    </tr>	
                    <tr height="39">
                      <td align="left" valign="middle"> ISO  </td>
                      <td align="left" valign="middle">
                      <?php if(strtolower($loginRole)=='iso'):?>
                      	<?php echo $this->Form->input('Merchant.isoID',array('type'=>'select','options'=>$isoList,'multiple'=>'multiple','selected' => $isoID,'label'=>false,'style'=>'width:290px;','disabled'=>'disabled')); ?>
                      <?php else:?>
                      	<?php echo $this->Form->input('Merchant.isoID',array('type'=>'select','options'=>$isoList,'multiple'=>'multiple','selected' => $isoID,'label'=>false,'style'=>'width:290px;')); ?>
                      <?php endif;?>                       
                      </td>
                    </tr>	
                    <tr height="39">
                      <td align="left" valign="middle"> Referral  </td>
                      <td align="left" valign="middle">
                      <?php if(strtolower($loginRole)=='referal'):?>
                      	<?php echo $this->Form->input('Merchant.referalID',array('type'=>'select','options'=>$referalList,'multiple'=>'multiple','selected' => $referalID,'label'=>false,'style'=>'width:290px;')); ?>
                      <?php else:?>
                      	<?php echo $this->Form->input('Merchant.referalID',array('type'=>'select','options'=>$referalList,'multiple'=>'multiple','selected' => $referalID,'label'=>false,'style'=>'width:290px;')); ?>
                      <?php endif;?> 
                      </td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top" style="padding:16px 40px 0 0;"><?php echo $this->Form->submit('Search Merchant',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>&nbsp;&nbsp;<?php echo $this->Form->submit('Export',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
              </tr>
            </table>
            <?php echo $this->Form->end();?> </div>
			<?php if(isset($merchantSearchList)):?>
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
						$this->Grid->addColumn('MANAGER', '/Manager/user_Name', array('paginate'=>true),'Manager.user_Name');
						$this->Grid->addColumn('STATUS', '/Status/status', array('paginate'=>true),'Status.status');
						$this->Grid->addColumn('MID#', '/Merchant/CID', array('paginate'=>true),'Merchant.CID');
						$this->Grid->addColumn('PRO. METHOD', '/ProcessingMethod/accountCategory', array('paginate'=>true),'ProcessingMethod.accountCategory');
						
						$this->Grid->addAction('Edit', array('controller' => 'merchants', 'action' => 'edit'), array('/Merchant/id'));
						$this->Grid->addAction('Delete', array('controller' => 'merchants', 'action' => 'delete'), array('/Merchant/id'));
                        $this->Grid->addAction('View', array('controller' => 'merchants', 'action' => 'view'), array('/Merchant/id'));
                        echo $this->Grid->generate($merchantSearchList);
					?>
					<div class="paginator">
						<?php if(count($merchantSearchList)>0):?>
						<?php echo $this->element('admin-paging');?></td>
					<?php endif;?>
					</div>
              </div>
            </div>
            <!-- display box / second end here -->
          </div>
		  <?php endif;?>		  
        </div>
      </div>
    </div>
  </div>
  <!-- end content / right -->
</div>
<script type="text/javascript">
jQuery.noConflict();
jQuery("#MerchantStatusID").multiselect({
	header: 'Select Any Status!'
});
jQuery("#MerchantManagerID").multiselect({
	header: 'Select Any Manager!'
});
jQuery("#MerchantProcessorID").multiselect({
	header: 'Select Any Processor!'
});
jQuery("#MerchantIsoID").multiselect({
	header: 'Select Any ISO!'
});
jQuery("#MerchantAgentID").multiselect({
	header: 'Select Any Agent!'
});
jQuery("#MerchantReferalID").multiselect({
	header: 'Select Any Referral!'
});
</script>
