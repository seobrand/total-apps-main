<link media="screen" rel="stylesheet" href="<?php echo FULL_BASE_URL.Router::url('/', false).'css/popup/';?>colorbox.css" />

<script src="<?php echo FULL_BASE_URL.Router::url('/', false).'css/popup/';?>/jquery.colorbox.js"></script>


<?php if($this->request->data['Merchant']['merchantType']!=''){
	$this->request->data['Merchant']['merchantType'] = explode(",",$this->request->data['Merchant']['merchantType']);
}
if($this->request->data['Merchant']['contract_expiration']!=''){
	$this->request->data['Merchant']['contract_expiration'] = date("m/d/Y",strtotime($this->request->data['Merchant']['contract_expiration']));
}
if($this->request->data['Merchant']['contract_approval']!=''){
	$this->request->data['Merchant']['contract_approval'] = date("m/d/Y",strtotime($this->request->data['Merchant']['contract_approval']));
}
//$this->request->data['Merchant']['detailExplanation'] = trim(preg_replace('/\s\s+/', ' ', $this->request->data['Merchant']['detailExplanation']));
//task id 3357 by jitendra
$processorID 	= $this->request->data['Merchant']['processorID'];
$managerID 		= $this->request->data['Merchant']['managerID'];
$referralID 	= $this->request->data['Merchant']['referalID'];
$agentID 		= $this->request->data['Merchant']['agentID'];
$isoID		 	= $this->request->data['Merchant']['isoID'];

// task id 3481
if(!in_array($processorID, array_keys($procList)) && ($processorID!="" && $processorID!=0)){
	$procList = $procList + array($processorID=>"Inactive : ".$this->request->data['Processor']['user_Name']);
	echo '<style>#MerchantProcessorID > option{ color:#666666;} #MerchantProcessorID > option:last-child {color: #FF0000;}</style>';
	echo '<script>$(document).ready(function(){$("#MerchantProcessorID").css("color", "#ff0000");$("#MerchantProcessorID").on(\'change\', function() {var sel = $("#MerchantProcessorID").val();if (sel=="'.$processorID.'") {$("#MerchantProcessorID").css("color", "#ff0000");}else if (sel!=="'.$processorID.'") {$("#MerchantProcessorID").css("color", "#666666");}});});</script>';
}
if(!in_array($isoID, array_keys($isoList)) && ($isoID!="" && $isoID!=0)){
	$isoList = $isoList + array($isoID=>"Inactive : ".$this->request->data['ISO']['user_Name']);
	echo '<style>#MerchantIsoID > option{ color:#666666;} #MerchantIsoID > option:last-child {color: #FF0000;}</style>';
	echo '<script>$(document).ready(function(){$("#MerchantIsoID").css("color", "#ff0000");$("#MerchantIsoID").on(\'change\', function() {var sel = $("#MerchantIsoID").val();if (sel=="'.$isoID.'") {$("#MerchantIsoID").css("color", "#ff0000");}else if (sel!=="'.$isoID.'") {$("#MerchantIsoID").css("color", "#666666");}});});</script>';
}
if(!in_array($managerID, array_keys($mangList)) && ($managerID!="" && $managerID!=0)){
	$mangList = $mangList + array($managerID=>"Inactive : ".$this->request->data['Manager']['user_Name']);
	echo '<style>#MerchantManagerID > option{ color:#666666;} #MerchantManagerID > option:last-child {color: #FF0000;}</style>';
	echo '<script>$(document).ready(function(){$("#MerchantManagerID").css("color", "#ff0000");$("#MerchantManagerID").on(\'change\', function() {var sel = $("#MerchantManagerID").val();if (sel=="'.$managerID.'") {$("#MerchantManagerID").css("color", "#ff0000");}else if (sel!=="'.$managerID.'") {$("#MerchantManagerID").css("color", "#666666");}});});</script>';
}
if(!in_array($agentID, array_keys($agentList)) && ($agentID!="" && $agentID!=0)){
	$agentList = $agentList + array($agentID=>"Inactive : ".$this->request->data['Agent']['user_Name']);
	echo '<style>#agent > option{ color:#666666;} #agent > option:last-child {color: #FF0000;}</style>';
	echo '<script>$(document).ready(function(){$("#agent").css("color", "#ff0000");$("#agent").on(\'change\', function() {var sel = $("#agent").val();if (sel=="'.$agentID.'") {$("#agent").css("color", "#ff0000");}else if (sel!=="'.$agentID.'") {$("#agent").css("color", "#666666");}});});</script>';
}
if(!in_array($referralID, array_keys($referalList)) && ($referralID!="" && $referralID!=0)){
	$referalList = $referalList + array($referralID=>"Inactive : ".$this->request->data['Referal']['user_Name']);
	echo '<style>#MerchantReferalID > option{ color:#666666;} #MerchantReferalID > option:last-child {color: #FF0000;}</style>';
	echo '<script>$(document).ready(function(){$("#MerchantReferalID").css("color", "#ff0000");$("#MerchantReferalID").on(\'change\', function() {var sel = $("#MerchantReferalID").val();if (sel=="'.$referralID.'") {$("#MerchantReferalID").css("color", "#ff0000");}else if (sel!=="'.$referralID.'") {$("#MerchantReferalID").css("color", "#666666");}});});</script>';
}

?>
<div class="news_announcement">			
			<?php echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'edit','onsubmit'=>'return checkisoreferral()')); ?>			
            <div class="titlebar" style="background-size:100% 100%;overflow:hidden;">MERCHANT INFORMATION<span class="contact_exp_label">Contract Expiration&nbsp;<?php echo $this->Form->input('Merchant.contract_expiration',array('type'=>'text','div'=>false,'label'=>false,'class'=>'contact_expiration'));?><br/>&nbsp;&nbsp;<span style="margin-top: 2px;float:left;">Contract Approval&nbsp;&nbsp;&nbsp;<?php echo $this->Form->input('Merchant.contract_approval',array('type'=>'text','div'=>false,'label'=>false,'class'=>'contact_expiration'));?></span></span></div>
            <div class="news_indent">			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
			<?php if($this->Session->read('backToSearch')!=""){?>
				<tr>
					<td align="left" valign="middle" style="color:#FF0000" colspan="2">* All fields marked with a red asterisk character are mandatory.
						<div style="float: right;">	         				
	         				<a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Session->read('backToSearch')?>">Go back to Search</a>
			            </div>
		            </td>
				</tr>
				<?php } ?>
                <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">LEGAL NAME<span style="color:#FF0000">*</span> </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.merchantName',array('label'=>false,'class'=>'input1','tabindex'=>1));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">LEGAL ADDRESS </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.legalAddress',array('label'=>false,'class'=>'input1','tabindex'=>3));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">LEGAL CITY </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.legalCity',array('label'=>false,'class'=>'input1','tabindex'=>5));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">STATE </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.legalState',array('label'=>false,'class'=>'input1','tabindex'=>7));?></td>
                      </tr>
					   <tr>
						<td align="left" width="35%" valign="middle">COUNTRY</td>
						<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalCountry',array('label'=>false,'class'=>'input1','tabindex'=>9));?></td>
					  </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">ZIP </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.legalZip',array('label'=>false,'class'=>'input1','tabindex'=>11));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CONTACT NAME </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.contactName',array('label'=>false,'class'=>'input1','tabindex'=>13));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">BUSINESS PHONE<span style="color:#FF0000">*</span> </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.contactPhone',array('label'=>false,'class'=>'input1','tabindex'=>15));?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">BUSINESS FAX </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.businessFax',array('label'=>false,'class'=>'input1','tabindex'=>17));?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">CARDHOLDER DESCRIPTOR <em>(Must Include Phone # if Keyed Merchant)</em> </td>
                        <td align="left" width="63%" valign="top"><?php echo $this->Form->input('Merchant.descriptor',array('label'=>false,'class'=>'input1','tabindex'=>19));?></td>
                      </tr>
                    </table>
				 </td>
                 <td width="50%" align="left" valign="top" style="padding:0px;">
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA NAME<span style="color:#FF0000">*</span> </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.merchantDBA',array('label'=>false,'class'=>'input1','tabindex'=>2));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA ADDRESS </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.dbaAddress',array('label'=>false,'class'=>'input1','tabindex'=>4));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA CITY </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.dbaCity',array('label'=>false,'class'=>'input1','tabindex'=>6));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">STATE </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.dbaState',array('label'=>false,'class'=>'input1','tabindex'=>8));?></td>
                      </tr>
					  <tr>
                        <td align="left" width="35%" valign="middle">COUNTRY </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('dbaCountry',array('label'=>false,'class'=>'input1','tabindex'=>10));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">ZIP </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.dbaZip',array('label'=>false,'class'=>'input1','tabindex'=>12));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CONTACT E-MAIL<span style="color:#FF0000">*</span></td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.contactEmail',array('label'=>false,'class'=>'input1','tabindex'=>14));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CUSTOMER SERVICE PHONE </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.customerServicePhone',array('label'=>false,'class'=>'input1','tabindex'=>16));?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">WEBSITE URL </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.merchantURL',array('label'=>false,'class'=>'input1','tabindex'=>18));?></td>
                      </tr>
					  <tr>
                        <td align="left" width="35%" valign="middle">MONTHLY SALES VOLUME($) </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.volume',array('label'=>false,'type'=>'text','class'=>'input1','tabindex'=>20));?></td>
                      </tr>
                        
                    </table>
				</td>
                </tr>
                 <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">NAME <em>(Legal Name field)</em>
 </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.federalName',array('label'=>false,'class'=>'input1','tabindex'=>21));?></td>
                      </tr>
                       
                       <tr>
                    <td  align="left" width="35%" valign="middle">MID# </td>
					<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.CID',array('label'=>false,'class'=>'input1','tabindex'=>23));?></td>
                      </tr>
                       <tr>
                    <td  align="left" width="35%" valign="middle">Processor ID# </td>
					<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.processor_id',array('label'=>false,'class'=>'input1','tabindex'=>23,'type'=>'text'));?></td>
                      </tr>
                      
                    </table></td>
                   <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">FEDERAL TAX ID # <em>(appears on income tax return)</em>
 </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.federalTaxId',array('label'=>false,'class'=>'input1','tabindex'=>22));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">SIC/MCC </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.sicMCC',array('label'=>false,'class'=>'input1','tabindex'=>24));?></td>
                      </tr>
                    </table></td>
                </tr>
				<tr>
                  <td align="left" width="50%" valign="middle" style="padding:0px;">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" width="35%" valign="middle">BUSINESS CATEGORY</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.merchantType',array('type'=>'select','options' => array('LLC' => 'LLC','Partnership' => 'PARTNERSHIP','Private Corp.' => 'PRIVATE CORP.','Sole Proprietor' => 'SOLE PROPRIETOR','Tax Exempt' => 'TAX EXEMPT'),'empty'=>'-Select Business Category-','label'=>false,'class'=>'select1','tabindex'=>24)); ?></td>
                      </tr>
                    </table>
                  </td>
                  <!-- <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">                     
                      <tr>
                        <td align="left" width="35%" valign="middle">USER CATEGORY</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.accountTypeID',array('type'=>'select','options'=>$uc_list,'empty'=>'-Select User Category-','label'=>false,'class'=>'select1','tabindex'=>25)); ?></td>
                      </tr>
                    </table>
                  </td> -->
                </tr>                
				 <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
                        <td align="left" valign="middle" width="35%">SHOPPING CART</td>
                        <td align="left" valign="middle" width="63%"><?php echo $this->Form->input('Merchant.procUID',array('label'=>false,'class'=>'input1','tabindex'=>26));?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">CRM</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.procPWD',array('label'=>false,'class'=>'input1','tabindex'=>28));?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	GATEWAY  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.gatewayID',array('type'=>'select','options'=>$gatwayList,'empty'=>'-Select Gateway-','label'=>false,'class'=>'select1','tabindex'=>30)); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	PROCESSING METHOD </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.accountCategory',array('type'=>'select','options'=>$acat_list,'empty'=>'-Select Processing Method-','label'=>false,'class'=>'select1','tabindex'=>32)); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">PROCESSOR  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.processorID',array('type'=>'select','options'=>$procList,'empty'=>'-Select Processor-','label'=>false,'class'=>'select1','tabindex'=>34)); ?>
                        <?php //if(!$is_proc_show && $processorID!=""){ echo $this->request->data['Processor']['user_Name'];}?>
                        </td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	MANAGER  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.managerID',array('type'=>'select','options'=>$mangList,'empty'=>'-Select Manager-','label'=>false,'class'=>'select1','tabindex'=>35)); ?>
                        <?php //if(!$is_mang_show && $managerID!=""){ echo $this->request->data['Manager']['user_Name'];}?>
                        </td>
                      </tr>	
                      <tr>
                        <td align="left" valign="middle">	RESERVE  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.reserve',array('type'=>'text','onKeyPress'=>'return numbersonly(this, event)','label'=>false,'div'=>false,'class'=>'input1','tabindex'=>36)); ?>%</td>
                      </tr>
                       <!-- <tr>
                        <td align="left" valign="middle"> USER REF. </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.user_ref_id',array('type'=>'text','label'=>false,'class'=>'input1','tabindex'=>38));?></td>
                      </tr> -->
                     
                    </table></td>
                  <td width="50%" valign="top" align="left" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="top">STATE FILED </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.incorporation',array('label'=>false,'class'=>'input1','tabindex'=>27));?></td>
                      </tr>
                     
					  <tr>
                        <td align="left" valign="top" width="35%">STATUS  </td>
                        <td align="left" valign="middle" width="63%"><?php echo $this->Form->input('Merchant.statusID',array('type'=>'select','options'=>$status,'empty'=>'-Select Status-','label'=>false,'class'=>'select1','tabindex'=>29)); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">	MERCHANT CATEGORY </td>
                        <td align="left" valign="middle"><?php						
						$ac_list=$common->getAccontTypeLst();
						echo $this->Form->input('Merchant.accountTypeID',array('type'=>'select','options'=>$ac_list,'empty'=>'-Select Merchant Category-','label'=>false,'class'=>'select1','tabindex'=>33)); ?></td>
                      </tr>
                      
                      <!-- <tr>
                        <td align="left" valign="top">	MERCHANT CATEGORY  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.accountTypeID',array('type'=>'select','options'=>$ac_list,'empty'=>'-Select Merchant Category-','label'=>false,'class'=>'select1','tabindex'=>31)); ?></td>
                      </tr>  -->
					  
                      <tr>
                        <td align="left" valign="middle">	AGENT  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.agentID',array('type'=>'select','options'=>$agentList,'empty'=>'-Select Agent-','label'=>false,'class'=>'select1','onchange'=>'makeISOCombo("agent",this.value)','id'=>'agent','tabindex'=>33)); ?>
                        <?php //if(!$is_agent_show && $agentID!=""){ echo $this->request->data['Agent']['user_Name'];}?>
                        </td>
                      </tr> 		  
					  <tr>
                        <td align="left" valign="middle">	REFERRAL  </td>
                        <td align="left" valign="middle" id="referralDiv"><?php echo $this->Form->input('Merchant.referalID',array('type'=>'select','options'=>$referalList,'empty'=>'-Select Referral-','label'=>false,'class'=>'select1','onchange'=>'makeISOCombo("referral",this.value)','tabindex'=>37)); ?>
                        <?php //if(!$is_referral_show && $referralID!=""){ echo $this->request->data['Referal']['user_Name'];}?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">	ISO  </td>
                        <td align="left" valign="middle" id="isoDiv"><?php echo $this->Form->input('Merchant.isoID',array('type'=>'select','options'=>$isoList,'empty'=>'-Select ISO-','label'=>false,'class'=>'select1','onchange'=>'makeReferralCombo("iso",this.value)','tabindex'=>36)); ?>
                        <?php //if(!$is_iso_show && $isoID!=""){ echo $this->request->data['ISO']['user_Name'];}?>
                        </td>
                      </tr>  
                       <tr>
                        <td align="left" valign="middle">	CATEGORY OF BUSINESS  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.busi_cat_id',array('type'=>'select','options'=>$busi_cat_id,'empty'=>'-Select category of business-','label'=>false,'class'=>'select1','tabindex'=>39)); ?></td>
                      </tr>			  
                    </table></td>
                </tr>
				 <tr>
                        <td align="left" colspan="2" valign="middle">DETAILED EXPLANATION OF TYPE OF MERCHANDISE, PRODUCTS OR SERVICES SOLD <br />
						<?php echo $this->Form->textarea('detailExplanation',array('class'=>'textarea_new mceNoEditor','tabindex'=>40));?></td>
                      </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                <tr>
                  <td align="center" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					<td align="center" valign="top">
					<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
					<?php echo $this->Form->input('Merchant.oldProcessor',array('type'=>'hidden','value'=>$this->request->data['Merchant']['processorID']));?>
					<?php echo $this->Form->input('Merchant.oldStatus',array('type'=>'hidden','value'=>$stausID));?>
                    <?php echo $this->Form->submit('Update',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'tabindex'=>41));?>
                   	</td>
					<td align="center" valign="top">
					<?php echo $this->Form->submit('Duplicate',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'tabindex'=>42));?></td>
					<td align="center" valign="top"><a class='mandatoryAppField cursorclass ui-state-default ui-corner-all' href="#mandatory_fields" style="text-decoration:none !important;padding:6px 5px 5px 5px;display:inline-block;">Mandatory App Field</a></td> 
					<td align="center" valign="top"><?php echo $this->Form->submit('Dead Deal',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'tabindex'=>43));?></td>
					<td align="center" valign="top" style="padding-top: 12px; width:20%;" >
                    <a onclick="if (confirm('Are you sure you are ready to approve this merchant ?')){  return true; }else{return false;}" class="cursorclass a-state-default ui-corner-all" href="<?php echo $this->webroot; ?>superadmin/merchants/approved_contract_ex_date/<?php echo $id;?>" tabindex="44">Approved Contract</a></td>
					<td align="center" valign="top" style="padding-top: 12px;"><a onclick="if (confirm('Are you sure to delete merchant?')){  return true }else{return false}" class="cursorclass a-state-default ui-corner-all" href="<?php echo $this->webroot; ?>superadmin/merchants/deletemerchant/<?php echo $id.DS.$stausID ?>" tabindex="44">Delete</a><?php /*echo $this->Form->postLink(
						'Delete',
						array('controller'=>'merchants','action' => 'delete',$id,$stausID),
						array('confirm' => 'Are you sure to delete merchant?','class'=>'cursorclass a-state-default ui-corner-all'));*/
					?></td>
					</tr>
					</table>
                  </td>
                </tr>
              </table>
            </div>
            <?php echo $this->Form->end();?>
          </div>
          
          
<div style='display:none'>
  <div id='mandatory_fields' style='padding:10px; background:#fff;'>
   <?php echo $this->element('merchant_mandatory_field');?>   
  </div>
</div>


<script type="text/javascript">
//task id 3481 start
function checkisoreferral(){
	ref_val = $("#MerchantReferalID").val();
	iso_val = $("#MerchantIsoID").val();
	if(ref_val==iso_val && ref_val!=2 && ref_val!=""){
		alert('Please make sure that the value set to the Referral dropdown is not the same as the value set in the ISO dropdown!');
		return false;
	}
	return true;
}
//task id 3481 end

function makeISOCombo(user_type,userID)
{
	var xmlhttp;
	var country='';
	//alert(user_type);
	//alert(userID);
	
	if(userID!=null || userID!='')
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
				document.getElementById("isoDiv").innerHTML=xmlhttp.responseText;
			}
		  }
		var url='';
		url='<?php echo FULL_BASE_URL.router::url('/',false).'superadmin/merchants/isolist'?>/'+userID;
		
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
	}
	else
	{
		alert('Please select valid user.');
	}

}

function makeReferralCombo(user_type,userID)
{
	var xmlhttp;
	var country='';
	//alert(user_type);
	//alert(userID);
	
	if(userID!=null || userID!='')
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
				document.getElementById("referralDiv").innerHTML=xmlhttp.responseText;
			}
		  }
		var url='';
		url='<?php echo FULL_BASE_URL.router::url('/',false).'superadmin/merchants/referrallist'?>/'+userID;
		
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
	}
	else
	{
		alert('Please select valid user.');
	}

}

function numbersonly(myfield, e, dec)
{ var key;var keychar;	
	if (window.event)
	   key = window.event.keyCode;
	else if (e)
	   key = e.which;
	else
	   return true;
	keychar = String.fromCharCode(key);
	// control keys
	if ((key==null) || (key==0) || (key==8) || 
		(key==9) || (key==13) || (key==27) || (key==46) )
	   return true;
	// numbers
	else if ((("0123456789").indexOf(keychar) > -1))
	   return true;
	else
	   return false;
}

jQuery.noConflict();
jQuery(document).ready(function(){


	jQuery("#MerchantContractExpiration").datepicker({
		dateFormat: "mm/dd/yy",
	});
	jQuery("#MerchantContractApproval").datepicker({
		dateFormat: "mm/dd/yy",
	});
	
jQuery(".mandatoryAppField").colorbox({width:"50%", height:"882px", inline:true});


});

</script>