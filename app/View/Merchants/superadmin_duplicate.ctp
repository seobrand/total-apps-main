<?php
if($this->request->data['Merchant']['merchantType']!=''){
	$this->request->data['Merchant']['merchantType'] = explode(',',$this->request->data['Merchant']['merchantType']);
}
?>
<div class="content"> 
  <!-- content / right -->
  <div id="right">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="news_announcement">
            <div class="titlebar"> MERCHANT INFORMATION </div>
            <div class="news_indent">
			 <?php  echo $this->Form->create('Merchant'); ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
				<tr>
					<td align="left" valign="middle" style="color:#FF0000" colspan="2">* All fields marked with a red asterisk character are mandatory.</td>
				</tr>
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
                        <td align="left" width="35%" valign="middle">MONTHLY SALES VOLUME ($) </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.volume',array('label'=>false,'type'=>'text','class'=>'input1','tabindex'=>20));?></td>
                      </tr>
                        
                    </table>
				</td>
                </tr>
                 <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">NAME <em>(as it appears on your income  tax return)</em>
 </td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.federalName',array('label'=>false,'class'=>'input1','tabindex'=>21));?></td>
                      </tr>
                       
                       <tr>
                    <td  align="left" width="35%" valign="middle">MID# </td>
					<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.CID',array('label'=>false,'class'=>'input1','tabindex'=>23));?></td>
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
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('Merchant.merchantType',array('type'=>'select','options' => array('Sole Proprietor' => 'SOLE PROPRIETOR','Partnership' => 'PARTNERSHIP','Private Corp.' => 'PRIVATE CORP.','Tax Exempt' => 'TAX EXEMPT','LLC' => 'LLC'),'empty'=>'-Select Business Category-','label'=>false,'class'=>'select1','tabindex'=>24)); ?></td>
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
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.processorID',array('type'=>'select','options'=>$procList,'empty'=>'-Select Processor-','label'=>false,'class'=>'select1','tabindex'=>34)); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	ISO  </td>
                        <td align="left" valign="middle" id="isoDiv"><?php echo $this->Form->input('Merchant.isoID',array('type'=>'select','options'=>$isoList,'empty'=>'-Select ISO-','label'=>false,'class'=>'select1','tabindex'=>36)); ?></td>
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
                      <!-- <tr>
                        <td align="left" valign="top">	MERCHANT CATEGORY  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.accountTypeID',array('type'=>'select','options'=>$ac_list,'empty'=>'-Select Merchant Category-','label'=>false,'class'=>'select1','tabindex'=>31)); ?></td>
                      </tr>  -->
					  
                      <tr>
                        <td align="left" valign="middle">	AGENT  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.agentID',array('type'=>'select','options'=>$agentList,'empty'=>'-Select Agent-','label'=>false,'class'=>'select1','onchange'=>'makeISOCombo("agent",this.value)','id'=>'agent','tabindex'=>33)); ?></td>
                      </tr>
                      
					  <tr>
                        <td align="left" valign="middle">	MANAGER  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.managerID',array('type'=>'select','options'=>$mangList,'empty'=>'-Select Manager-','label'=>false,'class'=>'select1','tabindex'=>35)); ?></td>
                      </tr>					  
					  <tr>
                        <td align="left" valign="middle">	REFERRAL  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.referalID',array('type'=>'select','options'=>$referalList,'empty'=>'-Select Referral-','label'=>false,'class'=>'select1','onchange'=>'makeISOCombo("referral",this.value)','tabindex'=>37)); ?></td>
                      </tr>  
                       <tr>
                        <td align="left" valign="middle">	CATEGORY OF BUSINESS  </td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('Merchant.busi_cat_id',array('type'=>'select','options'=>$busi_cat_id,'empty'=>'-Select category of business-','label'=>false,'class'=>'select1','tabindex'=>39)); ?></td>
                      </tr>			  
                    </table></td>
                </tr>
				 <tr>
                        <td align="left" colspan="2" valign="middle">DETAILED EXPLANATION OF TYPE OF MERCHANDISE, PRODUCTS OR SERVICES SOLD <br />
						<?php echo $this->Form->textarea('detailExplanation',array('class'=>'textarea_new','tabindex'=>40));?></td>
                      </tr>
              </table>             
			  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
			  	<?php if(count($DocumentData)>0):?>
					 <tr>
					  <td colspan="2"><div class="titlebar">PLEASE SELECT WHICH DOCUMENT YOU WANT TO DUPLICATE ?</div></td>
					</tr>
					 <tr>
					  <td colspan="2">&nbsp;</td>
					 </tr>
					<?php foreach($DocumentData as $key => $docList):?>
					<tr height="30">
					  <td width="100%" align="left" valign="top" style="padding:0px;">
						 <input name="data[Merchantprocessordoclink][docID][]" checked="checked" value="<?php echo $docList['Merchantprocessordoclink']['docID'] ?>" id="MerchantprocessordoclinkdocID<?php echo $key; ?>" type="checkbox">&nbsp;
						<?php echo $docList['Document']['docName']; ?>					 
					  </td>
					</tr>
					<?php endforeach;?>
				<?php endif;?>
				<tr>
                  <td>&nbsp;</td>
                  <td align="right" valign="top" style="padding:16px 40px 0 0;"><?php echo $this->Form->submit('Duplicate Merchant',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                </tr>
              </table>
   			<?php echo $this->Form->end();?>
            </div>
          </div>
        </div>
        <!-- end table --> 
      </div>
 
  </div>
  <!-- end content / right --> 
</div>