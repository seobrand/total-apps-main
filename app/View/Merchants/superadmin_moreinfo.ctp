<?php //pr($OwnerData);
 if(isset($OwnerData) && count($OwnerData)>0){
	foreach($OwnerData as $key =>$ownerdataval ){
		$this->request->data['Owner']['name'.($key+1)] = $ownerdataval['Owner']['name'];
		$this->request->data['Owner']['title'.($key+1)] = $ownerdataval['Owner']['title'];
		$this->request->data['Owner']['ownership'.($key+1)] = $ownerdataval['Owner']['ownership'];
		$this->request->data['Owner']['dob'.($key+1)] = $ownerdataval['Owner']['dob'];
		$this->request->data['Owner']['licenceNumber'.($key+1)] = $ownerdataval['Owner']['licenceNumber'];
		$this->request->data['Owner']['socialSecurityNumber'.($key+1)] = $ownerdataval['Owner']['socialSecurityNumber'];
		$this->request->data['Owner']['homeAddress'.($key+1)] = $ownerdataval['Owner']['homeAddress'];
		$this->request->data['Owner']['city'.($key+1)] = $ownerdataval['Owner']['city'];
		$this->request->data['Owner']['state'.($key+1)] = $ownerdataval['Owner']['state'];
		$this->request->data['Owner']['zip'.($key+1)] = $ownerdataval['Owner']['zip'];
		$this->request->data['Owner']['homePhone'.($key+1)] = $ownerdataval['Owner']['homePhone'];
	}
} 

?>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="more">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
            <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'moreinfo','onsubmit'=>'return validateForm()')); ?>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">MERCHANT PROFILE
				<div style="float:right">
							<a href="<?php echo $this->webroot; ?>superadmin/merchants/merchantdeployment/<?php echo $this->request->data['Merchant']['id']; ?>#deployment">Next</a>
					</div>
				</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                    <tr>
                      <td colspan="2" width="75%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Do you currently accept Visa/MC/Discover Network?<br />
                              If yes, you must submit 3 most current monthly statements.</td>
                          </tr>
                        </table></td>
                      <td width="25%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle"><?php echo $this->Form->radio('Merchant.acceptCreditCard', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','tabindex'=>55));?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="75%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Has the business or any Associated Principal been terminated as a Visa/MC/Discover Network Merchant?<br />
                              Provide date, if "Yes"</td>
                          </tr>
                        </table></td>
                      <td width="25%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle"><?php echo $this->Form->radio('Merchant.terminatedCreditCard', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','onclick'=>'enableDisableDate(this.value)','tabindex'=>55));?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding:0px" align="left"  valign="middle"><?php if($this->request->data['Merchant']['terminatedCreditCard']=='no'){ echo $this->Form->input('Merchant.terminatedDate',array('label'=>false,'div'=>false,'id'=>'terminatedate','empty'=>'-Select-','disabled'=>true,'tabindex'=>55));}else{ echo $this->Form->input('Merchant.terminatedDate',array('label'=>false,'div'=>false,'id'=>'terminatedate','empty'=>'-Select-','tabindex'=>55)); }?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="75%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Previously processed before?<br />
                              If yes, name of processor and reason for leaving</td>
                          </tr>
                        </table></td>
                      <td width="25%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle"><?php echo $this->Form->radio('Merchant.processBefore', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','onclick'=>'enableDisableFields(this.value,"MerchantProcessorAndLeaveReason")','tabindex'=>55));?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding:0px" align="left"  valign="middle"><?php if($this->request->data['Merchant']['processBefore']=='no'){ echo $this->Form->input('Merchant.processorAndLeaveReason',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'tabindex'=>55));}else{ echo $this->Form->input('Merchant.processorAndLeaveReason',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55)); }?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="75%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Has Merchant or any Associated Principal disclosed above filed for bankruptcy or been subject to an involuntary bankruptcy? </td>
                          </tr>
                        </table></td>
                      <td width="25%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  style="padding-top:0px" valign="top"><?php echo $this->Form->radio('Merchant.hasBankruptcy', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','tabindex'=>55));?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="75%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Do you have a refund policy for Visa/MC/Discover Network? Is the refund policy in writing that is obvious to the cardholder/customer?
                              Please describe refund policy</td>
                          </tr>
                        </table></td>
                      <td width="25%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle"><?php echo $this->Form->radio('Merchant.hasRefundPolicy', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','onclick'=>'enableDisableFields(this.value,"MerchantDescribePolicy")','tabindex'=>55));?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding:0px" align="left"  valign="middle"><?php if($this->request->data['Merchant']['hasRefundPolicy']=='no'){ echo $this->Form->input('Merchant.describePolicy',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'tabindex'=>55)); }else{ echo $this->Form->input('Merchant.describePolicy',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55)); }?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="75%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Do you use any third party to store, process or transmit cardholder data? Please identify any Software used for storing, transmitting or processing card Transactions or Authorization requests </td>
                          </tr>
                        </table></td>
                      <td width="25%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle"><?php echo $this->Form->radio('Merchant.hasThirdParty', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','onclick'=>'enableDisableFields(this.value,"MerchantSoftwareUsed")','tabindex'=>55));?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding:0px" align="left"  valign="middle"><?php if($this->request->data['Merchant']['hasThirdParty']=='no'){ echo $this->Form->input('Merchant.softwareUsed',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'tabindex'=>55));}else{ echo $this->Form->input('Merchant.softwareUsed',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55));}?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td width="100%" colspan="3" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Seasonal? </td>
                            <td align="left"  valign="middle" width="10%"><?php echo $this->Form->radio('Merchant.hasSeasonal', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;','onclick'=>'enableDisableMonth(this.value)','tabindex'=>55));?></td>
                            <td align="left"  valign="middle" width="15%">If Yes, indicate months </td>
                            <td align="left"  valign="middle"><?php echo $this->Form->input('Merchant.monthNames', array('label' => false,'class'=>'monthnames','type' => 'select', 'multiple' => 'checkbox','selected'=> $selected_months,'options' => array('Jan' => 'Jan','Feb' => 'Feb','Mar' => 'Mar','Apr' => 'Apr','May' => 'May','Jun' => 'Jun','Jul' => 'Jul','Aug' => 'Aug','Sep' => 'Sep','Oct' => 'Oct','Nov' => 'Nov','Dec' => 'Dec')));?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                  <br />
                  
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                    <tr>
                      <td colspan="3" width="100%" align="left" valign="top" style=""><strong>Mail / Telephone Order / Business to Business Information (All Questions Must Be Answered By Keyed Type of Merchants)</strong></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="60%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">What % of total sales represent Business to Business <em>(vs Business to Consumer)</em></td>
                          </tr>
                        </table></td>
                      <td width="40%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" width="10%" valign="middle">B2B </td>
                            <td align="left"  width="15%" valign="middle"><?php echo $this->Form->input('Merchant.b2bOfTotalsale',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));?></td>
                            <td align="left"  width="20%" valign="middle">% + B2C </td>
                            <td align="left"  width="15%" valign="middle"><?php echo $this->Form->input('Merchant.b2cOfTotalsale',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));?></td>
                            <td align="left" width="40%" valign="middle">% = <strong>100%</strong> (total sales) </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="60%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">What % of bankcard sales represent Business to Business <em>(vs Business to Consumer)</em></td>
                          </tr>
                        </table></td>
                      <td width="40%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" width="10%" valign="middle">B2B </td>
                            <td align="left"  width="15%" valign="middle"><?php echo $this->Form->input('Merchant.b2bOfbankcard',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));?></td>
                            <td align="left"  width="20%" valign="middle">% + B2C </td>
                            <td align="left"  width="15%" valign="middle"><?php echo $this->Form->input('Merchant.b2cOfbankcard',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));?></td>
                            <td align="left" width="40%" valign="middle">% = <strong>100%</strong> (total sales) </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="3" width="100%" align="left" valign="top" style="padding:0px;"><table border="0" cellpaddiing="0" cellspacing="0" >
                          <tr>
                            <td colspan="2" width="34%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left"  valign="middle">What is the time frame from transaction to delivery?<br />
                                    <em>% of orders delivered in days)</em></td>
                                </tr>
                              </table></td>
                            <td width="66%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" width="5%" valign="middle">0-7 </td>
                                  <td align="left"  width="7%" valign="middle"><?php echo $this->Form->input('Merchant.deliveryTimeFrame1',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));?></td>
                                  <td align="left"  width="10%" valign="middle">% + 8-14 </td>
                                  <td align="left"  width="7%" valign="middle"><?php echo $this->Form->input('Merchant.deliveryTimeFrame2',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));?></td>
                                  <td align="left" width="12%" valign="middle">% + 15-30 </td>
                                  <td align="left" width="7%" valign="middle"><?php echo $this->Form->input('Merchant.deliveryTimeFrame3',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));?></td>
                                  <td align="left"  width="18%" valign="middle">% + over 30 days</td>
                                  <td align="left" width="7%" valign="middle"><?php echo $this->Form->input('Merchant.deliveryTimeFrame4',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));?></td>
                                  <td align="left"  width="20%" valign="middle">% = <strong>100%</strong> delivered</td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="3" width="100%" align="left" valign="top" style="padding:0px;"><table border="0" cellpaddiing="0" cellspacing="0" >
                          <tr>
                            <td colspan="2" width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left"  valign="middle">Visa / MC / Discover Network / American Express OnePoint sales are deposited on <em>(check one)</em></td>
                                </tr>
                              </table></td>
                            <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" width="60%" style="padding-top:0px;" valign="middle"><?php echo $this->Form->radio('Merchant.ccDeposited', array('DoO' => 'Date of Order', 'DoD' => 'Date of Delivery','other'=>'Other'),array('legend' => false,'id'=>'ccCard','separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','onclick'=>'ccDeposite(this.value,"MerchantCcDepositedOther")','tabindex'=>55));?>
                                  </td>
                                  <td align="left"  width="40%" valign="middle"><?php if($this->request->data['Merchant']['ccDeposited']!='other'){  echo $this->Form->input('Merchant.ccDepositedOther',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'tabindex'=>55)); }else{  echo $this->Form->input('Merchant.ccDepositedOther',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55));}?></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="3" width="100%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellpaddiing="0" cellspacing="0" >
                          <tr>
                            <td colspan="2" width="30%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left"  valign="middle">Who performs product / service fulfillment?</td>
                                </tr>
                              </table></td>
                            <td width="70%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" width="40%" style="padding-top:0px;" valign="middle"><?php echo $this->Form->radio('Merchant.productFullfillmentBy', array('direct' => 'Direct', 'vendor' => 'Vendor','other'=>'Other'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','onclick'=>'whoPerform(this.value,"MerchantVendorDetail")','tabindex'=>55));?></td>
                                  <td align="left"  valign="middle">If vendor or third party is involved, provide the following</td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="3" width="100%"  align="left" valign="top"><table width="100%" border="0" cellpaddiing="0" cellspacing="0" >
                          <tr>
                            <td colspan="2" width="30%" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" style="padding-top:0px;"  valign="middle">Name / Address / Contact Phone#</td>
                                </tr>
                              </table></td>
                            <td width="70%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" width="40%" style="padding-top:0px;" valign="middle"><?php if($this->request->data['Merchant']['productFullfillmentBy']=='direct'){ echo $this->Form->input('Merchant.vendorDetail',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'tabindex'=>55));}else{ echo $this->Form->input('Merchant.vendorDetail',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55));}?></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="3" width="100%" align="left" valign="top" ><table width="100%" border="0" cellpaddiing="0" cellspacing="0" >
                          <tr>
                            <td colspan="2" width="30%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left"  valign="middle">Are customers required to leave a deposit?</td>
                                </tr>
                              </table></td>
                            <td width="70%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" width="14%" style="padding-top:0px;" valign="middle"><?php echo $this->Form->radio('Merchant.leaveDeposited', array('yes' => 'Yes', 'no' => 'No'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','onclick'=>'enableDisableFields(this.value,"MerchantDepositRquired")','tabindex'=>55));?></td>
                                  <td align="left" width="25%" valign="middle">If Yes, % of deposit required</td>
                                  <td align="left"   width="10%"  valign="middle"><?php if($this->request->data['Merchant']['leaveDeposited']=='no'){ echo $this->Form->input('Merchant.depositRquired',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','disabled'=>true,'tabindex'=>55)); }else{ echo $this->Form->input('Merchant.depositRquired',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55)); }?></td>
                                  <td align="left"  width="22%"   valign="middle">% &nbsp;Time Frame for Delivery</td>
                                  <td align="left"  width="10%"  valign="middle"><?php  if($this->request->data['Merchant']['leaveDeposited']=='no'){ echo $this->Form->input('Merchant.depositeTimeFrame',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'onKeyPress'=>'return numbersonly(this, event)')); }else{ echo $this->Form->input('Merchant.depositeTimeFrame',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>55));}?></td>
                                  <td align="left"  width="5%"  valign="middle">days</td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="3" width="100%"  align="left" valign="top"><table width="100%" border="0" cellpaddiing="0" cellspacing="0" >
                          <tr>
                            <td colspan="2" width="30%" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" style="padding-top:0px;"  valign="middle">Advertising Method(s) <em>(check all that apply)</em></td>
                                </tr>
                              </table></td>
                            <td width="70%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" width="40%" style="padding-top:0px;" valign="middle">
								  <?php echo $this->Form->input('Merchant.advertiseMethod', array('label' => false,'class'=>'monthnames','type' => 'select', 'multiple' => 'checkbox','selected'=> $selected_adsmethod,'options' => array('Newspapers' => 'Newspapers','Magazines' => 'Magazines','Yellow Pages' => 'Yellow Pages','Radio / TV' => 'Radio / TV','Internet' => 'Internet')));?>
                                  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="3" width="100%"  align="left" valign="top"><table width="100%" border="0" cellpaddiing="0" cellspacing="0" >
                          <tr>
                            <td colspan="3" width="100%" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" style="padding-top:0px;"  valign="middle"><strong>Required</strong> Attach Marketing Materials for ALL MOTO, B2B and Internet Businesses ( attach Web page Printout )
                                  
                                 
                                  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">MERCHANT SITE SURVEY</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                    <tr>
                      <td colspan="2" width="65%" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Business Location<br /> If Other, please (specify)   </td>
                          </tr>
                        </table>
                      </td>
                      <td width="35%" align="left" valign="top" class="input_area"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                          <?php $busiLocoptions = array('store front'=>'Store Front','office'=>'Office','home'=>'Home','other'=>'Other');?>
                            <td align="left"  valign="middle"><?php echo $this->Form->input('MerchantSiteSurvey.business_location',array('type'=>'select','multiple'=>'checkbox','options'=>$busiLocoptions,'label'=>false,'div'=>false,'onclick'=>'enableDisableFields(this.value,"MerchantSiteSurveyBusinessLocName")'));?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding:8px" align="left"  valign="middle"><?php if($this->request->data['MerchantSiteSurvey']['business_location']!='other'){ echo $this->Form->input('MerchantSiteSurvey.business_loc_name',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'tabindex'=>55));}else{ echo $this->Form->input('MerchantSiteSurvey.business_loc_name',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55)); }?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="65%" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Approximate Size: (square footage) </td>
                          </tr>
                        </table>
                      </td>
                      <td width="35%" align="left" valign="top" class="input_area"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                          <?php $apxsizeoptions = array('0-500'=>'0-500','501-2000'=>'501-2000','2000+'=>'2000+');?>
                            <td align="left"  valign="middle"><?php echo $this->Form->input('MerchantSiteSurvey.approximate_size',array('type'=>'select','multiple'=>'checkbox','options'=>$apxsizeoptions,'label'=>false,'div'=>false));?></td>
                          </tr>                          
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="65%" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Zone </td>
                          </tr>
                        </table>
                      </td>
                      <td width="35%" align="left" valign="top" class="input_area"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                          <?php $zoneoptions = array('commercial'=>'Commercial','industrial'=>'Industrial','residential'=>'Residential');?>
                            <td align="left"  valign="middle"><?php echo $this->Form->input('MerchantSiteSurvey.zone',array('type'=>'select','multiple'=>'checkbox','options'=>$zoneoptions,'label'=>false,'div'=>false));?></td>
                          </tr>                          
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="65%" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Does the name on the store front match the DBA name?  <br /> Explain if No </td>
                          </tr>
                        </table>
                      </td>
                      <td width="35%" align="left" valign="top" class="input_area"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                          <?php $matchingoptions = array('yes'=>'Yes','no'=>'No');?>
                            <td align="left"  valign="middle"><?php echo $this->Form->input('MerchantSiteSurvey.is_frontname_match_dbaname',array('type'=>'select','multiple'=>'checkbox','options'=>$matchingoptions,'label'=>false,'div'=>false));?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding:8px" align="left"  valign="middle"><?php if($this->request->data['MerchantSiteSurvey']['is_frontname_match_dbaname']=='yes'){ echo $this->Form->input('MerchantSiteSurvey.matching_reason',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'tabindex'=>55));}else{ echo $this->Form->input('MerchantSiteSurvey.matching_reason',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55)); }?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="65%" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Is inventory and merchandise displayed consistent with the type of business?<br /> Explain if No </td>
                          </tr>
                        </table>
                      </td>
                      <td width="35%" align="left" valign="top" class="input_area"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                          <?php $displayedoptions = array('yes'=>'Yes','no'=>'No');?>
                            <td align="left"  valign="middle"><?php echo $this->Form->input('MerchantSiteSurvey.is_display_consistent',array('type'=>'select','multiple'=>'checkbox','options'=>$displayedoptions,'label'=>false,'div'=>false));?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="padding:8px" align="left"  valign="middle"><?php if($this->request->data['MerchantSiteSurvey']['is_display_consistent']=='yes'){ echo $this->Form->input('MerchantSiteSurvey.display_consist_reason',array('label'=>false,'class'=>'input1','div'=>false,'disabled'=>true,'tabindex'=>55));}else{ echo $this->Form->input('MerchantSiteSurvey.display_consist_reason',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55)); }?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="65%" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Business Hours</td>
                          </tr>
                        </table>
                      </td>
                      <td width="35%" align="left" valign="top" class="input_area"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                         <tr>
                            <td colspan="2" style="padding:8px" align="left"  valign="middle"><?php  echo $this->Form->input('MerchantSiteSurvey.business_hours_from',array('label'=>false,'class'=>'small_input1','div'=>false,'tabindex'=>55)); ?>&nbsp;&nbsp;TO&nbsp;&nbsp;&nbsp;<?php  echo $this->Form->input('MerchantSiteSurvey.business_hours_to',array('label'=>false,'class'=>'small_input1','div'=>false,'tabindex'=>55)); ?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="65%" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">TimeZone </td>
                          </tr>
                        </table>
                      </td>
                      <td width="35%" align="left" valign="top" class="input_area"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                          <?php $timezoneoptions = array('pacific'=>'Pacific','eastern'=>'Eastern','central'=>'Central','mountain'=>'Mountain');?>
                            <td align="left"  valign="middle"><?php echo $this->Form->input('MerchantSiteSurvey.timezone',array('type'=>'select','multiple'=>'checkbox','options'=>$timezoneoptions,'label'=>false,'div'=>false));?></td>
                          </tr>                          
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" width="65%" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"  valign="middle">Number of employees</td>
                          </tr>
                        </table>
                      </td>
                      <td width="35%" align="left" valign="top" class="input_area"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                         <tr>
                            <td colspan="2" style="padding:8px" align="left"  valign="middle"><?php  echo $this->Form->input('MerchantSiteSurvey.number_of_employee',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>55)); ?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                 </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">TRADE REFEERENCES</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                    <tr>
                      <td width="33%" align="left" valign="top" style="padding:0px;"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" width="40%" valign="middle">Trade Name</td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.tradeName',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>60));?></td>
                          </tr>
                          <tr>
                            <td align="left" width="40%" valign="middle">Bank Name</td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.bankName',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>61));?></td>
                          </tr>
                        </table></td>
                      <td width="33%" align="left" valign="top" style="padding:0px;"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" width="40%" valign="middle">Contact Name</td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.tradeContactName',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>60));?></td>
                          </tr>
                          <tr>
                            <td align="left" width="40%" valign="middle">Contact Name</td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.bankContactName',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>61));?></td>
                          </tr>
                        </table></td>
                      <td width="33%" align="left" valign="top" style="padding:0px;"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" width="40%" valign="middle">Telephone</td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.tradePhone',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>60));?></td>
                          </tr>
                          <tr>
                            <td align="left" width="40%" valign="middle">Telephone</td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.bankPhone',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>61));?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
			<div class="box1">
              <div class="news_announcement">
                <div class="titlebar">BANKING INFORMATION</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                    <tr>
                      <td width="50%" align="left" valign="top" style="padding:0px;"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" width="40%" valign="middle">Bank Contact<span style="color:#FF0000">*</span></td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.bankContact',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>65));?></td>
                          </tr>
                          <tr>
                            <td align="left" width="40%" valign="middle">Transit # (ABA Routing)<span style="color:#FF0000">*</span></td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.transitNumber',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>66));?></td>
                          </tr>
                          <tr>
                            <td align="left" width="40%" valign="middle">Account type</td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.bankAccountType',array('type'=>'select','options'=>array('Business Account'=>'Business Account','Personal Account'),'empty'=>'Select Account Type','label'=>false,'class'=>'select1','div'=>false,'tabindex'=>66));?></td>
                          </tr>
                        </table></td>
                      <td width="50%" align="left" valign="top" style="padding:0px;"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" width="40%" valign="middle">Telephone<span style="color:#FF0000">*</span></td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.telephone',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>65));?></td>
                          </tr>
                          <tr>
                            <td align="left" width="40%" valign="middle">Account # (DDA)<span style="color:#FF0000">*</span></td>
                            <td align="left"  width="60%" valign="middle"><?php echo $this->Form->input('Merchant.accountNumber',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>66));?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
			<div class="box1">
          <div class="news_announcement">
            <div class="titlebar">Owners / Partners / Officers</div>
            <div class="news_indent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                <tr>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Name<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.name1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Title<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.title1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle">Equity / Ownership%<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.ownership1',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Date of Birth(MM/DD/YYYY)<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.dob1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Driver's License #<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.licenceNumber1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle">Social Security #<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.socialSecurityNumber1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Home Address<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.homeAddress1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="40%" valign="middle">City<br /><?php echo $this->Form->input('Owner.city1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                          <td align="left"  width="25%" valign="middle">State<br /><?php echo $this->Form->input('Owner.state1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                          <td align="left"  width="25%" valign="middle">Zip<br /><?php echo $this->Form->input('Owner.zip1',array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle">Home Telephone<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.homePhone1',array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>70));?></td>
                      </tr>
                    </table>
					<input type="hidden" value="<?php if(isset($OwnerData) && count($OwnerData)>1) echo count($OwnerData); else echo "1"; ?>" id="OwnerCount" name="data[Owner][count]">
					<input type="hidden" value="<?php if(isset($OwnerData) && count($OwnerData)>1) echo count($OwnerData); else echo "1"; ?>" id="OwnerElement" name="data[Owner][element]">
					</td>
                </tr>
				<tr>
                  <td colspan="2"><a href="javascript:void(0)" onclick="addOwnerFormField()" tabindex="10">Add another owners / partners / officers</a></td>
				</tr>
             </table>
			  <?php 
			  if(isset($OwnerData) && count($OwnerData)>1){ 
					foreach($OwnerData as $key => $owner){ if($key>=1) {
				?>
			 <div class="news_indent_more">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                <tr>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Name<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.name'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Title<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.title'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle">Equity / Ownership%<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.ownership'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Date of Birth(MM/DD/YYYY)<br /><?php echo $this->Form->input('Owner.dob'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Driver's License #<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.licenceNumber'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle">Social Security #<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.socialSecurityNumber'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left"  valign="middle">Home Address<br /><?php echo $this->Form->input('Owner.homeAddress'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="40%" valign="middle">City<br /><?php echo $this->Form->input('Owner.city'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                          <td align="left"  width="25%" valign="middle">State<br /><?php echo $this->Form->input('Owner.state'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                          <td align="left"  width="25%" valign="middle">Zip<br /><?php echo $this->Form->input('Owner.zip'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                  <td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle">Home Telephone<span style="color:#FF0000">*</span><br /><?php echo $this->Form->input('Owner.homePhone'.($key+1),array('label'=>false,'class'=>'input1','div'=>false,'onKeyPress'=>'return numbersonly(this, event)','tabindex'=>70));?></td>
                      </tr>
                    </table></td>
                </tr>
				<tr>
                  <td colspan="2"><a href="javascript:void(0)" onclick="addOwnerFormField()" tabindex="10">Add another owners / partners / officers</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($owner['Owner']['merchantID']==$this->request->data['Merchant']['id']){ echo $this->Html->link('Remove', array('controller' => 'merchants','action' => 'ownerdelete', $owner['Owner']['id'], $owner['Owner']['merchantID']));} ?></td>
				</tr>
             </table>
			 </div>
			 <?php } } }?>
			  <div id="divTxt"></div>
			  <div class="news_indent">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
					  <tr>
					  <td colspan="2"><?php echo $this->Form->input('Merchant.id', array('type' => 'hidden','value'=>$this->request->data['Merchant']['id']));?></td>
					  <td align="right" valign="top" style="padding:0 40px 0 0;"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'tabindex'=>70));?></td>
					</tr>
				  </table>
			  </div>
            </div>
          </div>
        </div>
            <?php echo $this->Form->end();?> </div>
        </div>
        <!-- display box / second end here -->
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>


<script type="text/javascript">
var Ccontent ='';
var count = parseInt(document.getElementById('OwnerCount').value);

function addOwnerFormField() {
	var i = count+1;

	Ccontent = '<div class="news_indent_more"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form"><tr><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Name<span style="color:#FF0000">*</span><br /><input type="text" id="OwnerName'+i+'" class="input1" name="data[Owner][name'+i+']"></td></tr></table></td><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Title<span style="color:#FF0000">*</span><br /><input type="text" id="OwnerTitle'+i+'" class="input1" name="data[Owner][title'+i+']"></td></tr></table></td><td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle">Equity / Ownership%<span style="color:#FF0000">*</span><br /><input type="text" id="OwnerOwnership'+i+'" class="input1" name="data[Owner][ownership'+i+']" onKeyPress="return numbersonly(this, event)"></td></tr></table></td></tr><tr><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Date of Birth(MM/DD/YYYY)<span style="color:#FF0000">*</span><br /><input type="text" id="OwnerDob'+i+'" class="input1" name="data[Owner][dob'+i+']"></td></tr></table></td><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Driver\'s License #<span style="color:#FF0000">*</span><br /><input type="text" id="OwnerLicenceNumber'+i+'" class="input1" name="data[Owner][licenceNumber'+i+']"></td></tr></table></td><td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle">Social Security #<span style="color:#FF0000">*</span><br /><input type="text" id="OwnerSocialSecurityNumber'+i+'" class="input1" name="data[Owner][socialSecurityNumber'+i+']"></td></tr></table></td></tr><tr><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left"  valign="middle">Home Address<span style="color:#FF0000">*</span><br /><input type="text" id="OwnerHomeAddress'+i+'" class="input1" name="data[Owner][homeAddress'+i+']"></td></tr></table></td><td width="33%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" width="40%" valign="middle">City<br /><input type="text" id="OwnerCity'+i+'" class="input1" name="data[Owner][city'+i+']"></td><td align="left"  width="25%" valign="middle">State<br /><input type="text" id="OwnerState'+i+'" class="input1" name="data[Owner][state'+i+']"></td><td align="left"  width="25%" valign="middle">Zip<br /><input type="text" id="OwnerZip'+i+'" class="input1" name="data[Owner][zip'+i+']"></td></tr></table></td><td width="33%"  align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle">Home Telephone<span style="color:#FF0000">*</span><br /><input type="text" id="OwnerHomePhone'+i+'" class="input1" name="data[Owner][homePhone'+i+']" onKeyPress="return numbersonly(this, event)"></td></tr></table><input type="hidden" value="'+i+'" id="OwnerCount" name="data[Owner][count]"></td></tr><tr><td colspan="2"><a href="javascript:void(0)" onclick="addOwnerFormField()">Add another owners / partners / officers</a></td></tr></table></div>';
	$('#divTxt').append(Ccontent);
	document.getElementById("OwnerElement").value = i;	
	count = count + 1;
	addDatePick(i);
}

function addDatePick(counterrr){	
	jQuery.noConflict();
	jQuery("#OwnerDob"+counterrr).datepicker({
	 dateFormat: "mm/dd/yy",
      changeMonth: true,
      changeYear: true
    });
}

function validateForm(){
	var errormessge = '';
	var b2btotalsalevalue = document.getElementById('MerchantB2bOfTotalsale').value;
	var b2ctotalsalevalue = document.getElementById('MerchantB2cOfTotalsale').value;
	var b2bbankcardvalue = document.getElementById('MerchantB2bOfbankcard').value;
	var b2cbankcardvalue = document.getElementById('MerchantB2cOfbankcard').value;
	var time1 = document.getElementById('MerchantDeliveryTimeFrame1').value;
	var time2 = document.getElementById('MerchantDeliveryTimeFrame2').value;
	var time3 = document.getElementById('MerchantDeliveryTimeFrame3').value;
	var time4 = document.getElementById('MerchantDeliveryTimeFrame4').value;
	
	totalb2bvalue = parseInt(b2btotalsalevalue) + parseInt(b2ctotalsalevalue);
	totalb2cvalue = parseInt(b2bbankcardvalue) + parseInt(b2cbankcardvalue);
	totaltimeperchant = parseInt(time1) + parseInt(time2) + parseInt(time3) + parseInt(time4);
	
	/*var tradename = document.getElementById('MerchantTradeName').value;
	var bankname = document.getElementById('MerchantBankName').value;
	var tradecontact = document.getElementById('MerchantTradeContactName').value;
	var bankcontact = document.getElementById('MerchantBankContactName').value;
	var tradephone = document.getElementById('MerchantTradePhone').value;
	var bankphone = document.getElementById('MerchantBankPhone').value;*/
	
	var bankingcontact = document.getElementById('MerchantBankContact').value;
	var transitnum = document.getElementById('MerchantTransitNumber').value;
	var telephone = document.getElementById('MerchantTelephone').value;
	var accountnum = document.getElementById('MerchantAccountNumber').value;

	if(totalb2bvalue < 100 || totalb2bvalue > 100){
		alert("B2B and B2C % of Total sale must not larger or smaller than 100% ");
		document.getElementById('MerchantB2bOfTotalsale').focus();
		return false;
	}
	if(totalb2cvalue > 100 || totalb2cvalue < 100){
		alert("B2B and B2C % of Bank Card must not larger or smaller than 100% ");
		document.getElementById('MerchantB2bOfbankcard').focus();
		return false;
	}
	if(totaltimeperchant > 100 || totaltimeperchant < 100){
		alert("Total % of orders delivered in days must not larger or smaller than 100%");
		document.getElementById('MerchantDeliveryTimeFrame1').focus();
		return false;
	}
	
	if(bankingcontact==''){
		errormessge +=  "Please enter banking contact number\n";
	}
	if(transitnum==''){
		errormessge +=  "Please enter banking transit number\n";
	}
	if(telephone==''){
		errormessge +=  "Please enter banking telephone\n";
	}
	if(accountnum==''){
		errormessge +=  "Please enter merchant account number\n";
	}
	

	var cnt = parseInt(document.getElementById('OwnerElement').value);
	var i=1;
	for(i=1;i<=cnt;i++){
		if(document.getElementById('OwnerName'+i).value==''){
			errormessge += "Please Enter Owner Name\n";		
		}
		if(document.getElementById('OwnerTitle'+i).value==''){
			errormessge += "Please Enter Owner Title\n";			
		}
		if(document.getElementById('OwnerOwnership'+i).value==''){
			errormessge += "Please Enter Ownership % value\n";			
		}
		if(document.getElementById('OwnerDob'+i).value==''){
			errormessge += "Please Enter Date of Birth value\n";			
		}
		if(document.getElementById('OwnerLicenceNumber'+i).value==''){
			errormessge += "Please Enter Drivers License Number\n";		
		}
		if(document.getElementById('OwnerSocialSecurityNumber'+i).value==''){
			errormessge += "Please Enter Social Security Number\n";		
		}
		if(document.getElementById('OwnerHomeAddress'+i).value==''){
			errormessge += "Please Enter Owner Home Address\n";		
		}
		if(document.getElementById('OwnerHomePhone'+i).value==''){
			errormessge += "Please Enter Owner Telephone\n";		
		}
		
	}
	
	
	if(errormessge!=''){
		alert("* All fields marked with a red asterisk character are mandatory\n\n"+errormessge);
		return false;
	}
	
	return true;

}

</script>
<script type="text/javascript">
function enableDisableMonth(val){
	var monthname = document.getElementsByName("data[Merchant][monthNames][]");

	if(val=='yes'){
		for(var i = 0, n = monthname.length; i < n; ++i) {
			monthname[i].disabled = false;
		}
	}else{
		for(var i = 0, n = monthname.length; i < n; ++i) {
			monthname[i].checked = false
			monthname[i].disabled = true;
		}
	}
}

function enableDisableDate(val){
	if(val=='yes'){
		document.getElementById('terminatedateMonth').disabled = false;
		document.getElementById('terminatedateDay').disabled = false;
		document.getElementById('terminatedateYear').disabled = false;
	}else{
		document.getElementById('terminatedateMonth').disabled = true;
		document.getElementById('terminatedateDay').disabled = true;
		document.getElementById('terminatedateYear').disabled = true;
		document.getElementById('terminatedateMonth').value = '';
		document.getElementById('terminatedateDay').value = '';
		document.getElementById('terminatedateYear').value = '';
	}
}
function enableDisableFields(val,changeID){
	if(val=='yes'){
		document.getElementById(changeID).disabled = false;
		if(changeID == 'MerchantDepositRquired'){
			document.getElementById('MerchantDepositeTimeFrame').disabled = false;
		}
	}else{
		document.getElementById(changeID).disabled = true;
		document.getElementById(changeID).value = '';
		if(changeID == 'MerchantDepositRquired'){
			document.getElementById('MerchantDepositeTimeFrame').disabled = true;
			document.getElementById('MerchantDepositeTimeFrame').value = '';
		}
	}
}
function whoPerform(val,changeID){
	if(val=='direct'){
		document.getElementById(changeID).disabled = true;
		document.getElementById(changeID).value = '';
	}else{
		document.getElementById(changeID).disabled = false;
	}
}
function ccDeposite(val,changeID){
	if(val=='other'){
		document.getElementById(changeID).disabled = false;
	}else{
		document.getElementById(changeID).disabled = true;
		document.getElementById(changeID).value = '';
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

</script>
<script type="text/javascript">
/**** disable Monthnames method *********/
<?php if($this->request->data['Merchant']['hasSeasonal']=='no'){ ?>
			var monthname = document.getElementsByName("data[Merchant][monthNames][]");
			for(var i = 0, n = monthname.length; i < n; ++i) {
			    monthname[i].disabled = true;
			}
<?php } ?>
</script>
<script type="text/javascript">
$("input:checkbox").click(function(){
    if ($(this).attr("checked")) {
        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
        $(group).attr("checked", false);
        $(this).attr("checked", true);
    } else {
    	$(this).attr("checked", false);
    }
    // show field on basis of checkboxes
    if($(this).attr("name") == 'data[MerchantSiteSurvey][business_location][]'){
	    if($(this).attr("id")=='MerchantSiteSurveyBusinessLocationOther'){
			$('#MerchantSiteSurveyBusinessLocName').attr('disabled',false);
	    }else{
	    	$('#MerchantSiteSurveyBusinessLocName').attr('value','').attr('disabled',true);
	    }
    }
    if($(this).attr("name") == 'data[MerchantSiteSurvey][is_frontname_match_dbaname][]'){
	    if($(this).attr("id")=='MerchantSiteSurveyIsFrontnameMatchDbanameNo'){
			$('#MerchantSiteSurveyMatchingReason').attr('disabled',false);
	    }else{
	    	$('#MerchantSiteSurveyMatchingReason').attr('value','').attr('disabled',true);
	    }
    }
    if($(this).attr("name") == 'data[MerchantSiteSurvey][is_display_consistent][]'){
        if($(this).attr("id")=='MerchantSiteSurveyIsDisplayConsistentNo'){
    		$('#MerchantSiteSurveyDisplayConsistReason').attr('disabled',false);
        }else{
        	$('#MerchantSiteSurveyDisplayConsistReason').attr('value','').attr('disabled',true);
        }
    }
});

jQuery.noConflict();
jQuery(function() {
	jQuery( "#OwnerDob1" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  maxDate : Date(),
	  yearRange : '1950:'+Date()
    });
  }); 

</script>