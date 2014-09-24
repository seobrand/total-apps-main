<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <div class="titlebar">RATES (PRICING)
	  <div style="float:right">
         	<a href="<?php echo $this->webroot; ?>superadmin/rates/ratelist"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
        </div>
	  </div>
        <!-- display box / first -->
        <div class="display_row">
          
          <div class="tabs_des">
		  <?php  echo $this->Form->create('Rate',array('controller'=>'rates','action'=>'rate'))?> 
		  <div class="box1">
		  	<div class="news_announcement">
                <div class="titlebar">Name</div>
                <div class="news_indent">
					<table width="50%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
						<td width="10%" align="left">Name*</td>
						<td><?php echo $this->Form->input('Rate.adminName',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                    </tr>
                  </table>
				</div>
			</div>
		  </div>		
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Discount Rates</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td width="40%" align="left" valign="top" class="rpadnone" style="padding:0px;">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="31%" align="left" valign="top">&nbsp;</td>
                            <td width="69%" align="left" valign="top"><strong class="blue">Discount&nbsp;(%)</strong></td>
                          </tr>
                          <tr>
                            <td align="left">Visa</td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.visaDiscount',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" >Master Card </td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.masterDiscount',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" >Discover </td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.discoverDiscount',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" > Check Card </td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.checkDiscount',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" >AMEX </td>
                            <td align="left" valign="top"><?php //echo $this->Form->input('Rate.amexDiscount	',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" >JCB </td>
                            <td align="left" valign="top"><?php //echo $this->Form->input('Rate.jcbDiscount',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                      <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" ><strong class="blue">Trans Fee&nbsp;($)</strong></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.visaTransFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.masterTransFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.discoverTransFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.checkTransFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
						  <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.amexTransFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
						  <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.jcbTransFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                      <td width="35%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="26%" align="left" valign="top">&nbsp;</td>
                            <td width="74%" align="left"><strong class="blue">Discount</strong></td>
                          </tr>
                          <tr>
                            <td align="left" >Mid-Qual % </td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.midQualDiscount',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" >Non-Qual % </td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.nonQualDiscount',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">FIXED CHARGES</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td width="50%" align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <?php /*?><tr>
                            <td align="left" valign="middle">Merchant Category:</td>
                            <td align="left" valign="middle"><select name="select4" class="select1" tabindex="70">
                                <option value="4:General Ecommerce">General Ecommerce</option>
                                <option value="14:Retail Swipe">Retail Swipe</option>
                                <option value="17:ACH">ACH</option>
                              </select></td>
                          </tr><?php */?>
                          <tr>
                            <td width="40%" align="left" valign="middle"><strong class="blue">Processor Fees</strong></td>
                            <td width="60%" align="left" valign="middle"><strong class="blue">Amount</strong></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">CHARGEBACK FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.chargebackFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>71));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">AVS FEE $ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.electronicAvsFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>73));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">RETRIEVAL FEE $ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.retrievalReqFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>75));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">WIRELESS MONTHLY FEE $ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.wirelessDataMonthlyFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>77));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">RETURN ITEM FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.returnItemFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>79));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">AVS VOICE AUTHORIZATION&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.avsVoiceAuthFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>81));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">VRU & ARU FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.vru_aru_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>83));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">MONTHLY MINIMUM FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.monthlyMinFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>85));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">MONTHLY MAINTENANCE FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.monthly_maintenance_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>87));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">EIDS CHARGEBACK/ RETRIEVAL ONLINE TOOL $ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.eids_chargeback_retrieval_online_tool_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>89));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">PCI COMPLIANCE FEE TYPE</td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.pci_compliance_fee_type',array('type'=>'select','options'=>array('monthly'=>'Monthly','yearly'=>'Yearly'),'label'=>false,'class'=>'select1','div'=>false,'tabindex'=>90));?></td>
                          </tr>
                        </table></td>
                      <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="45%" align="left" valign="top"><strong class="blue">Processor Fee</strong></td>
                            <td width="55%" align="left" valign="top"><strong class="blue">Amount</strong></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">ACH/BATCH STATEMENT</td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.achBatchFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>72));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">SERVICE/STATEMENT FEE</td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.statementFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>74));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">MERCHANT  CLUB FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.merchantClubFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>76));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">WIRELESS TRANS. FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.wirelessTransFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>78));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">APPLICATION FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.applicationFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>80));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">VOICE AUTHORIZATION FEE $ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.voiceAuthFee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>82));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">REGULATORY BUNDLE FEE $ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.regulatory_bundle_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>84));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">EARLY TERMINATION(one time fee)$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.early_termination_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>86));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">ONLINE REPORTING FEE&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.online_reporting_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>88));?></td>
                          </tr>
                          <tr height="46">
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">PCI COMPLIANCE FEE $ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.pci_compliance_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>91));?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="rpadnone"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="39%" align="left" valign="middle">1.	OTHER FEE  </td>
                            <td width="61%" align="left" valign="middle"><?php echo $this->Form->input('Rate.otherFeeName1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>92));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">2.	OTHER FEE  </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.otherFeeName2',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>94));?></td>
                          </tr>
                        </table></td>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="43%" align="left" valign="middle">&nbsp;</td>
                            <td width="57%" align="left" valign="middle">$&nbsp;<?php echo $this->Form->input('Rate.otherFeeValue1',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>93));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="left" valign="middle">$&nbsp;<?php echo $this->Form->input('Rate.otherFeeValue2',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>95));?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Interchange Pass through</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td width="40%" align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="35%" align="left" valign="middle">Interchange Plus&nbsp;% </td>
                            <td width="65%" align="left" valign="middle"><?php echo $this->Form->input('Rate.interchangePlus',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                      <td width="35%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="32%" align="left" valign="middle">Per Item&nbsp;$ </td>
                            <td width="68%" align="left" valign="middle"><?php echo $this->Form->input('Rate.interchangePerItem',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">ERR RATE</div>
                <div class="news_indent">                  
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td width="50%" align="left" valign="top" class="rpadnone" style="padding:0px;">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="40%" align="left" valign="top">&nbsp;</td>
                            <td width="60%" align="left" valign="top"><strong class="blue">Discount Rate (%)</strong></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">VISA QUALIFIED</td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.visa_qualify_dis_rate',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>101));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">MC QUALIFIED </td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.mc_qualify_dis_rate',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>104));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">DISCOVER QUALIFIED</td>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.discover_qualify_dis_rate',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>107));?></td>
                          </tr>                          
                        </table></td>
                      <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><strong class="blue">Non-Qualified Fee (%)</strong></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.visa_non_qualify_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>102));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.mc_non_qualify_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>105));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.discover_non_qualify_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>108));?></td>
                          </tr>                          
                        </table></td>
                      <td width="25%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><strong class="blue">Authorization Fee ($)</strong></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.visa_authorization_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>103));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.mc_authorization_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>106));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><?php echo $this->Form->input('Rate.discover_authorization_fee',array('onKeyPress'=>'return numbersonly(this, event)','label'=>false,'class'=>'input1','div'=>false,'tabindex'=>109));?></td>
                          </tr>                          
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Gateway Fess</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td width="33%" align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="23%" align="left" valign="middle">Trans Fee&nbsp;$ </td>
                            <td width="77%" align="left" valign="top"><?php echo $this->Form->input('Rate.gatewayTransFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                      <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="28%" align="left" valign="middle">Monthly Fee&nbsp;$ </td>
                            <td width="72%" align="left" valign="top"><?php echo $this->Form->input('Rate.gatewayMonthlyFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                      <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="25%" align="left" valign="middle">Setup Fee&nbsp;$ </td>
                            <td width="75%" align="left" valign="top"><?php echo $this->Form->input('Rate.gatewaySetupFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">EBT</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td width="40%" align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="24%" align="left" valign="middle">Cash Back max $ </td>
                            <td width="76%" align="left" valign="middle"><?php echo $this->Form->input('Rate.ebtCashBackMaxFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                      <td width="35%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="21%" align="left" valign="middle">Trans. Fee $ .</td>
                            <td width="79%" align="left" valign="middle"><?php echo $this->Form->input('Rate.ebtTransFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Debit</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td width="40%" align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="28%" align="left" valign="middle">Monthly Access Fee&nbsp;$ </td>
                            <td width="72%" align="left" valign="middle"><?php echo $this->Form->input('Rate.debitMonthlyAccessFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">Authorization Fee&nbsp;$ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.debitAuthorizationFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table></td>
                      <td width="35%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="21%" align="left" valign="middle">Cash Back $ </td>
                            <td width="79%" align="left" valign="middle"><?php echo $this->Form->input('Rate.debitCashBack',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">Access Fee $ </td>
                            <td align="left" valign="middle"><?php echo $this->Form->input('Rate.debitAccessFee',array('label'=>false,'class'=>'input1','div'=>false));?></td>
                          </tr>
                        </table>			
						</td>
                    </tr>
                  </table>
					<?php echo $this->Form->input('Rate.id', array('type' => 'hidden','value'=>$ID));?>
                </div>
              </div>
            </div>
			<div style="float:right; margin-right:10px;">
			<?php if($ID!=''){ echo $this->Form->submit('Update Rates',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));}else{ echo $this->Form->submit('Add Rates',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));}?></div>
		<?php echo $this->Form->end();?>
          </div>
        </div>
        <!-- display box / second end here -->
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
