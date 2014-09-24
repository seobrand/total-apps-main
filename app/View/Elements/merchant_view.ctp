<div class="news_announcement">
            <div class="titlebar">MERCHANT INFORMATION</div>
            <div class="news_indent">
			 
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                <tr>
					<td align="left" valign="middle" style="color:#FF0000" colspan="2">
						<div style="float: right;">
	         				<?php echo $this->Html->link('Go back to Search',$this->Session->read('backToSearch'),array('class'=>'cursorclass ui-state-default ui-corner-all','escape'=>false));?>
			            </div>
		            </td>
				</tr>
                <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">LEGAL NAME</td>
                        <td align="left" width="63%" valign="middle">
                        <?php echo $marchant['Merchant']['merchantName'];  ?>
                       </td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">LEGAL ADDRESS</td>
                        <td align="left" width="63%" valign="middle">
                         <?php echo $marchant['Merchant']['legalAddress'];  ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">LEGAL CITY</td>
                        <td align="left" width="63%" valign="middle">
                         <?php echo $marchant['Merchant']['legalCity'];  ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">STATE</td>
                        <td align="left" width="63%" valign="middle">
                         <?php echo $marchant['Merchant']['legalState'];  ?>
                       </td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">COUNTRY</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['legalCountry'];?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">ZIP</td>
                        <td align="left" width="63%" valign="middle">
                         <?php echo $marchant['Merchant']['legalZip'];  ?>
                       </td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CONTACT NAME</td>
                        <td align="left" width="63%" valign="middle">
                        
                         <?php echo $marchant['Merchant']['contactName'];  ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">BUSINESS PHONE</td>
                        <td align="left" width="63%" valign="middle">
                         <?php echo $marchant['Merchant']['contactPhone'];  ?>
                        </td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">BUSINESS FAX</td>
                        <td align="left" width="63%" valign="middle">
                         <?php echo $marchant['Merchant']['businessFax'];  ?>
                       </td>
                      </tr>
                      <tr>
                      <?php if(strtolower($role)!='referal' && strtolower($role)!='referral' && strtolower($role)!='agent'){?>
                        <td align="left" width="35%" valign="middle">CARDHOLDER DESCRIPTOR</td>
                        <td align="left" width="63%" valign="top"><?php echo $marchant['Merchant']['descriptor'];?></td>
                     <?php }?>
                      </tr>
                    </table>
				 </td>
                 <td width="50%" colspan="2" align="left" valign="top" style="padding:0px;">
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA NAME</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['merchantDBA'];?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA ADDRESS</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['dbaAddress'];?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">DBA CITY</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['dbaCity'];?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">STATE</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['dbaState'];?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">COUNTRY</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['dbaCountry'];?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">ZIP</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['dbaZip'];?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CONTACT E-MAIL</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['contactEmail'];?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">CUSTOMER SERVICE PHONE</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['customerServicePhone'];?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">WEBSITE URL</td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['merchantURL'];?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">MONTHLY SALES VOLUME</td>
                        <td align="left" width="63%" valign="middle">$<?php echo $this->request->data['Merchant']['volume'];?></td>
                      </tr>
                    </table>
				</td>
                </tr>
                 <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">NAME <em>(Legal Name Field)</em></td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['federalName'];?></td>
                      </tr>
	                  <tr>
	                    <td  align="left" width="35%" valign="middle">MID#</td>
						<td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['CID'];  ?></td>
	                  </tr>
                    </table>
                  </td>
                   <td width="50%" colspan="2" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">                      
                      <tr height="46">
                      <?php if(strtolower($role)!='referal' && strtolower($role)!='referral' && strtolower($role)!='agent'){?>
                        <td align="left" width="35%" valign="middle">FEDERAL TAX ID # <em>(as it appears on your income tax return)</em></td>
                        <td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['federalTaxId'];  ?></td>
                      <?php }else{?>
                      	<td align="left" colspan="2">&nbsp;</td>
                      <?php }?>
                     </tr>
                      
                      <tr>
	                    <td  align="left" width="35%" valign="middle">SIC/MCC</td>
						<td align="left" width="63%" valign="middle"><?php echo $marchant['Merchant']['sicMCC'];?></td>
	                  </tr>
                    </table></td>
                </tr>
				<tr>
	                <td colspan="2" style="padding: 0px;">
		                <table width="100%" cellpadding="0" cellspacing="0">
		                  <tr>
		                  	<td width="180" align="left">BUSINESS CATEGORY</td>
		                    <td align="left"><?php echo $marchant['Merchant']['merchantType'];?></td>
		                  </tr>
		                </table>
	                </td>
                </tr>                 
				 <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">				  	
					  <tr>
                        <td align="left" valign="middle" width="35%">SHOPPING CART  </td>
                        <td align="left" valign="middle" width="65%"><?php echo $marchant['Merchant']['procUID'];?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">CRM </td>
                        <td align="left" valign="middle"><?php echo $marchant['Merchant']['procPWD'];?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">GATEWAY  </td>
                        <td align="left" valign="middle"><?php echo  $common->getGatewayName($marchant['Merchant']['gatewayID']);?></td>
                      </tr>
                      <?php if(strtolower($role)!='referal' && strtolower($role)!='referral' && strtolower($role)!='agent'){	?>
					  <tr>
                        <td align="left" valign="middle">PROCESSING METHOD </td>
                        <td align="left" valign="middle"><?php echo  $common->getAccountCatName($marchant['Merchant']['accountCategory']);?></td>
                      </tr>
                      <?php }?>
                      <?php if(strtolower($role)!='referal' && strtolower($role)!='referral' && strtolower($role)!='agent'){	?>
					  <tr>
                        <td align="left" valign="middle">PROCESSOR  </td>
                        <td align="left" valign="middle"><?php echo $marchant['Processor']['user_Name'];  ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	ISO  </td>
                        <td align="left" valign="middle"><?php echo $marchant['ISO']['user_Name'];  ?></td>
                      </tr>
                      <!-- <tr>
                        <td align="left" valign="middle">USER REF </td>
                        <td align="left" valign="middle"> <?php echo $marchant['Merchant']['user_ref_id'];  ?></td>
                      </tr> -->
                      <?php }?>
                    </table></td>
                  	<td width="50%" valign="top" align="left" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top" width="35%">STATE FILED  </td>
                        <td align="left" valign="middle" width="65%"> <?php echo $marchant['Merchant']['incorporation'];?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" width="35%">STATUS  </td>
                        <td align="left" valign="middle" width="65%"> <?php echo  $common->getStatusName($marchant['Merchant']['statusID']);?></td>
                      </tr>
                     <!--  <tr>
                        <td align="left" valign="top">	MERCHANT CATEGORY  </td>
                        <td align="left" valign="middle"><?php echo  $common->getAccountType($marchant['Merchant']['accountTypeID']);?></td>
                      </tr> -->
                      <tr>
                        <td align="left" valign="middle">	AGENT  </td>
                        <td align="left" valign="middle"><?php echo $marchant['Agent']['user_Name'];  ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle">	MANAGER  </td>
                        <td align="left" valign="middle"><?php echo $marchant['Manager']['user_Name'];  ?></td>
                      </tr>
					  <?php if(strtolower($role)!='referal' && strtolower($role)!='referral' && strtolower($role)!='agent'){	?>
					  <tr>
                        <td align="left" valign="middle">	REFERRAL  </td>
                        <td align="left" valign="middle"> <?php echo $common->getReferalUser($marchant['Merchant']['referalID']);?></td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle">	CATEGORY OF BUSINESS  </td>
                        <td align="left" valign="middle"><?php echo $common->getBusinessCategory($marchant['Merchant']['busi_cat_id']);?></td>
                      </tr>
					  <?php } ?>
                    </table></td>
                </tr>
				 <tr>
				 <td align="left" colspan="2" valign="middle">DETAILED EXPLANATION OF TYPE OF MERCHANDISE, PRODUCTS OR SERVICES SOLD <br />
				 <?php echo $marchant['Merchant']['detailExplanation'];  ?>             
                 </td>
                 </tr>
              </table>
              </div>
          </div>