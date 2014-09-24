<script>
function sendapplication(){
	var email=$('#ProcessorSendFrom').val();
	email=email.trim();
	var message=$('#ProcessorEmailTemplate').val();
	message=message.trim();
	
	var validation='';
		var email_filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(!email){
				validation +='Please enter from email address\n';
		}else if(!email_filter.test(email)){
			validation +='Please enter e-mail addrees\n';
		}
		
		if(!message){
			validation +='Please enter message.\n';
		}
	
		if(validation){
		alert(validation);return false;}
		
		return true;
	
		return false;
	}
	function othr_email_template_validation(){
		var EmailTemplateSentFrom=$('#EmailTemplateSentFrom').val();
		EmailTemplateSentFrom=EmailTemplateSentFrom.trim();
		
		var EmailTemplateSubject=$('#EmailTemplateSubject').val();
		EmailTemplateSubject=EmailTemplateSubject.trim();
		
		var EmailTemplateTemplate=$('#EmailTemplateTemplate').val();
		var EmailTemplateTemplate=$('#EmailTemplateTemplate').val();
		
		
		var validation='';
		var email_filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(!EmailTemplateSentFrom){
				validation +='Please enter from email address\n';
		}else if(!email_filter.test(EmailTemplateSentFrom)){
			validation +='Please Enter Valid From E-mail addrees\n';
		}
		
		if(!EmailTemplateSubject){
				validation +='Please enter subject\n';
		}
	
		if(validation){
		alert(validation);return false;}
		
		return true;
		
	}
</script>
<?php echo $this->element('editor'); ?>
<?php $processor = $common->getProcessorNameById($this->request->data['Merchant']['processorID']);?>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <?php if($this->Session->read('UserAuth.User.user_group_id')=='20'){ ?>
        <!-- Show Merchant View if user is agent -->
        <?php echo $this->element('merchant_view'); ?>
        <?php }else{?>
        <!-- Show Merchant edit if user is not agent -->
        <?php echo $this->element('merchant_commonform'); ?>
        <?php }?>
        <!-- display box / first -->
        <div class="display_row" id="action">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Action
                  <div style="float:right"> <a href="<?php echo $this->webroot; ?>superadmin/merchants/merchantdoc/<?php echo $this->request->data['Merchant']['id']; ?>#doc">Next</a> </div>
                </div>
                <div class="links_col">
                  <select name="actiontabs" onchange="showMerchantActions(this.value)" style="float:left">
                    <?php if($processor=='Merit Card - M' || $processor=='Merit Card - WF-ONLINE' || $processor=='Merit Card - WF-SWIPE' || $processor=='Merit Card' || $processor=='MeritCard'){?>
                    <option value="MeritCard">Send Application With MeritCard</option>
                    <?php /*}elseif(strtolower($processor)=='mojopay' || strtolower($processor)=='mojo pay' || strtolower($processor)=='mp' || strtolower($processor)=='mojo-pay'){?>
							<option value="MojoPay">Send Application With MojoPay</option>	
							<?php */}else{?>
                    <option value="send-app">Send Application</option>
                    <option value="MeritCard">Send Application With MeritCard</option>
                    <option value="MojoPay">Send Application With MojoPay</option>
                    <?php }?>
                    <option value="incomplete-doc">Incomplete Doc Email</option>
                    <option value="pre-approve">Send Processor Pre-App Approval</option>
                    <?php if($this->request->data['Merchant']['statusID']==3){?>
                    <option value="return-for-signature">Return for signature</option>
                    <?php }?>
                    <option value="request_supporting_documents">Request Supporting Documents</option>
                    <option value="send_application_to_processor">Send Application to Processor</option>
                    <option value="bad-url">Bad URL Email</option>
                    <option value="welcome_email">Welcome Email</option>
                    <option value="other_template">Other Email Template</option>
                  </select>
                </div>
                <div id="send-app" <?php if(strtolower($processor)=='mojopay' || strtolower($processor)=='mojo pay' || strtolower($processor)=='mp' || strtolower($processor)=='mojo-pay'){?> style="display: none;" <?php }?>>
                  <!--<p>there is not a processor package for <strong>Merit Card - WF-ONLINE.</strong> </p>
						  <div class="divider"></div>-->
                  <?php if(strtolower($processor)=='mojo pay' || strtolower($processor)=='mojopay'){
								  	$email_from = 'info@mojopay.com';
								}else{
									$email_from = $this->Session->read('UserAuth.User.userEmail');
								}
							?>
                  <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction','onsubmit'=>'return sendapplication();')); ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                    <tr>
                      <td width="8%" align="left" valign="top" style="padding:15px 0 0 15px;">Sent from:</td>
                      <td width="92%" align="left" valign="middle"><table  border="0">
                          <?php echo $this->Form->input("Processor.appFrom",array('type'=>'hidden','value'=>''));?>
                          <tr>
                            <td><?php
									echo $this->Form->input('Processor.processor_id',array('type'=>'hidden','value'=>$this->request->data['Merchant']['processorID'],'name'=>'processor_id'));
									 echo $this->Form->input('Processor.sendFrom', array('label'=>'','value'=>$email_from));?></td>
                            <td><?php echo $this->Form->input('Processor.manager', array('label'=>'Manager','type'=>'checkbox','value'=>$this->request->data['Manager']['userEmail'],'checked'=>true,'disabled'=>true));?></td>
                            <td><?php echo $this->Form->input('Processor.iso', array('label'=>'ISO','type'=>'checkbox','value'=>$this->request->data['ISO']['userEmail']));?></td>
                            <td><?php echo $this->Form->input('Processor.Agent', array('label'=>'Agent','type'=>'checkbox','value'=>$this->request->data['Agent']['userEmail']));?> </td>
                            <td><?php echo $this->Form->input('Processor.referral', array('label'=>'Referral','type'=>'checkbox','value'=>$this->request->data['Referal']['userEmail']));?> </td>
                          </tr>
                          <tr>
                            <td>CC:<?php echo $this->Form->input('Processor.cc_email', array('label'=>false,'div'=>false));?> </td>
                            <td colspan="4">BCC:<?php echo $this->Form->input('Processor.bcc_email', array('label'=>false,'div'=>false));?> </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top" style="padding-left:15px;"><?php echo $this->Form->input('Processor.email_template', array('label'=>'','type' => 'textarea','class'=>'textarea1 mceNoEditor'));?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top" style="padding-left:15px;"><?php echo $this->Form->submit('Send Email',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'onsubmit'=>'return sendapplication()'));?></td>
                    </tr>
                  </table>
                
                  
                  <?php echo $this->Form->input('Processor.sendTo',array('type' => 'hidden','value'=>$this->request->data['Merchant']['contactEmail']));?> <?php echo $this->Form->input('Processor.Package',array('type' => 'hidden','value'=>$this->request->data['Processor']['processorPackage']));?> <?php echo $this->Form->input('Processor.managerID',array('type' => 'hidden','value'=>$this->request->data['Merchant']['managerID']));?> <?php echo $this->Form->input('Processor.agentID',array('type' => 'hidden','value'=>$this->request->data['Merchant']['agentID']));?> <?php echo $this->Form->input('Processor.Filename',array('type' => 'hidden','value'=>$this->request->data['Processor']['processorPackageFilename']));?><?php echo $this->Form->input('Processor.managerName',array('type' => 'hidden','value'=>$this->request->data['Manager']['user_Name']));?><?php echo $this->Form->input('Processor.managerEmail',array('type' => 'hidden','value'=>$this->request->data['Manager']['userEmail']));?><?php echo $this->Form->input('Processor.managerPhone',array('type' => 'hidden','value'=>$this->request->data['Manager']['userPhone']));?><?php echo $this->Form->input('Processor.managerCompany',array('type' => 'hidden','value'=>$this->request->data['Manager']['userCompany']));?><?php echo $this->Form->input('Processor.managerCompanyUrl',array('type' => 'hidden','value'=>$this->request->data['Manager']['userCompanyUrl']));?><?php echo $this->Form->input('Processor.merchantContactName',array('type' => 'hidden','value'=>$this->request->data['Merchant']['contactName']));?><?php echo $this->Form->input('Processor.legalName',array('type' => 'hidden','value'=>$this->request->data['Merchant']['merchantName']));?> <?php echo $this->Form->end()?> </div>
                <div id="incomplete-doc" style="display:none;">
                  <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction')); ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                    <tr>
                      <td width="15%" align="left" valign="middle">Send Notice To:</td>
                      <td width="85%" align="left" valign="middle"><select name="data[Merchant][mailto]">
                          <option value="agent">Agent</option>
                          <option value="merchant">Merchant</option>
                          <option value="agentMerchant">Agent &amp; Merchant</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Personal Message:</td>
                      <td align="left" valign="top"><?php echo $this->Form->input('Merchant.personalMessage', array('label'=>'','type' => 'textarea','class'=>'textarea1 mceNoEditor','value'=>"Dear [MERCHANT/CONTACT NAME]

Your Incomplete documents are following:
[INCOMPLETE DOCUMENT LIST]							  		

[MANAGER NAME]
Account Manager
[MANAGER/COMPANY]
[MANAGER/Company URL] 
[MANAGER/PHONE]"));?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top"><?php echo $this->Form->submit('Request Docs',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                    </tr>
                  </table>
                  <?php echo $this->Form->input('Merchant.merchantID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['id']));?> <?php echo $this->Form->input('Merchant.merchantEmail', array('type' => 'hidden','value'=>$this->request->data['Merchant']['contactEmail']));?> <?php echo $this->Form->input('Merchant.agentID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['agentID']));?> <?php echo $this->Form->input('Merchant.processorID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['processorID']));?> <?php echo $this->Form->input('Merchant.statusID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['statusID']));?> <?php echo $this->Form->end();?> </div>
                <div id="bad-url"  <?php if(strtolower($processor)=='mojopay' || strtolower($processor)=='mojo pay' || strtolower($processor)=='mp' || strtolower($processor)=='mojo-pay'){?> style="display: block;" <?php }else{?> style="display:none;" <?php }?>>
                <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction')); ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                  <tr>
                    <td align="left" valign="middle"><strong>Send Bad URL email</strong><br/>
                      <br/>
                      By pushing the below button, you will notify the merchant and the agent that this merchant has been moved to the dead list because the supplied URL is not correct.<br/>
                      <br/>
                      A note will be added that reflects this action.<br/>
                      <?php echo $this->Form->input('Merchant.Message', array('label'=>'','type' => 'textarea','class'=>'textarea1 mceNoEditor','value'=>"Dear [MERCHANT/CONTACT NAME]

This is body text of of Bad URL email.				  		

[MANAGER NAME]
Account Manager
[MANAGER/COMPANY]
[MANAGER/Company URL] 
[MANAGER/PHONE]"));?> </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><?php echo $this->Form->submit('Send Bad URL Email',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
                <?php echo $this->Form->input('Merchant.statusID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['statusID']));?> <?php echo $this->Form->input('Merchant.agentID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['agentID']));?> <?php echo $this->Form->input('Merchant.merchantEmail', array('type' => 'hidden','value'=>$this->request->data['Merchant']['contactEmail']));?> <?php echo $this->Form->end();?> </div>
              <div id="pre-approve" style="display:none;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formtable">
                  <tr>
                    <td class="bodyTextA"><b>Send Processor Pre-App Approval</b><br>
                      <br>
                      Please select all of the following processors you wish to send a pre-app to.<br>
                      *If there is a processor missing, either they are 'inactive' OR they do not have an email address in the system. <br>
                      <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction')); ?>
                      <table cellspacing="0" cellpadding="0" border="0" class="tableBorder" width="100%">
                        <tr>
                          <?php  
								   $i=1;
										  foreach($procList as $key => $value)
										  {
										  ?>
                          <td style="padding-right: 100px" class="bodyTextA"><?php echo $this->Form->input('Processor.'.$key, array('label'=>$value,'type'=>'checkbox'));?> </td>
                          <?php 
										  if($i%4==0)
										  {?>
                        </tr>
                        <tr>
                          <?php }
										   $i=$i+1;
										  }?>
                        </tr>
                      </table>
                      <br>
                      A note will be added that reflects this action. <br/>
                      <?php echo $this->Form->input('Merchant.Message', array('label'=>'','type' => 'textarea','class'=>'textarea1 mceNoEditor','value'=>"Dear [MERCHANT/CONTACT NAME]

[EMAIL TEMPLATE]			  		

[MANAGER NAME]
Account Manager
[MANAGER/COMPANY]
[MANAGER/Company URL] 
[MANAGER/PHONE]"));?></td>
                  </tr>
                  <tr>
                    <td><br>
                      <?php echo $this->Form->input('Processor.PREAPPROVAL',array('type' => 'hidden','value'=>'PREAPPROVAL'));?> <?php echo $this->Form->submit('Send Processor Pre-App Approval',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> </td>
                  </tr>
                </table>
              </div>
              <div id="signature" style="display:none;">
                <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction')); ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                  <tr>
                    <td colspan="2" align="left" valign="top"><?php echo $this->Form->input('Merchant.email_template', array('label'=>'','type' => 'textarea','class'=>'textarea1 mceNoEditor','value'=>'Congratulations!  You are finished filling out the application questions and you only need to sign it.  This can be easily done digitally from your computer.
							  		
[FULLAPP REQUEST URL]
						
Should you have any questions concerning your application, please contact [MANAGER NAME], your Underwriting Support Representative, by phone at 866-397-3515 or 949-274-8975 or by email at [MANAGER EMAIL]'));?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><?php echo $this->Form->submit('Return for signature',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
                <?php echo $this->Form->input('Merchant.contactEmail',array('type' => 'hidden','value'=>$this->request->data['Merchant']['contactEmail']));?> <?php echo $this->Form->input('Merchant.id',array('type' => 'hidden','value'=>$this->request->data['Merchant']['id']));?><?php echo $this->Form->input('Merchant.managerEmail',array('type' => 'hidden','value'=>$this->request->data['Manager']['userEmail']));?> <?php echo $this->Form->end()?> </div>
              <div id="request_supporting_documents" style="display:none;">
                <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction')); ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                  <tr>
                    <td align="left" valign="middle"><strong>Request supporting documents</strong><br/>
                      <br/>
                      Sending an email to the merchant with the Supporting Documents Needed for Merchant Account Application. <br/>
                      <?php echo $this->Form->input('Merchant.Message', array('label'=>'','type' => 'textarea','class'=>'textarea1 mceNoEditor','value'=>"Dear [MERCHANT/CONTACT NAME]

Thanks for submitting your application to Total-apps. We will forward the application to the underwriting department. In order to finalize your application, PLEASE SUBMIT THE FOLLOWING SUPPORTING DOCUMENTS:
										
● Please fill out the Card Not Present Questionnaire Attached
● Photo ID of signer (Driver license or Passport)
● Copy of Articles of Incorporation or Business Certificate (proof you are a business)
● Voided business check or Bank Letter of Authorization (we have samples if needed)
● One month bank statement ( personal if business is a start up to show liquidity)
● Proof of EIN number (ss-4 form or w-9 and we have samples if needed)
● Last three months of your processing statements if applicable			  		

Sincerely,
[MANAGER NAME]
Account Manager
[MANAGER/COMPANY]
[MANAGER/Company URL] 
[MANAGER/PHONE]
(949) 266-8260 Fax"));?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
                <?php echo $this->Form->input('submitfrom', array('type' => 'hidden','value'=>'request_supporting_documents'));?> <?php echo $this->Form->end();?> </div>
              <div id="send_application_to_processor" style="display:none;">
                <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction','type'=>'file')); ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                  <tr>
                    <td align="left" valign="middle"><strong>Send Application to Processor</strong><br/>
                      <br/>
                      Sending an email to the processor with the attaching the following supporting documents needed for your Merchant Account Application.</td>
                  </tr>
                </table>
                <table cellspacing="0" cellpadding="0" border="0" class="tableBorder" width="100%">
                  <tr>
                    <?php //pr($merchantdocs);?>
                    <?php $i=1; foreach($merchantdocs as $key => $value){ ?>
                    <td style="padding-right: 100px" class="bodyTextA"><?php echo $this->Form->input('Merchantdoc.'.$value['Document']['docName'], array('label'=>$value['Document']['docName'],'type'=>'checkbox','value'=>$value['Merchantprocessordoclink']['docName']));?> </td>
                    <?php if($i%4==0){?>
                  </tr>
                  <tr>
                    <?php } $i=$i+1; }?>
                  </tr>
                </table>
                <table cellspacing="0" cellpadding="0" border="0" class="tableBorder" width="100%">
                  <tr>
                    <td style="padding-right: 10px" class=""> Upload multiple document from here <?php echo $this->Form->input('MerchantAddDoc.', array('label'=>false,'div'=>false,'type'=>'file','multiple'));?> </td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top"><?php echo $this->Form->input('Merchant.Message', array('label'=>'','type' => 'textarea','class'=>'textarea1 mceNoEditor','value'=>"Hello,

This is a new application for [MERCHANT DBA NAME]. The application form and all the supporting documents are attached. Please let me know if you have any questions.
Please download the application form pdf from this link:
[PDF DOWNLOAD LINK]                    				  		

Sincerely,
[MANAGER NAME]
Account Manager
[MANAGER/COMPANY]
[MANAGER/Company URL] 
[MANAGER/PHONE]
(949) 266-8260 Fax"));?></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
                <?php echo $this->Form->input('submitfrom', array('type' => 'hidden','value'=>'send_application_to_processor'));?> <?php echo $this->Form->end();?> </div>
              <div id="welcome_email_message" style="display:none;">
                <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction')); ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                  <tr>
                    <td align="left" valign="middle"><strong>Send Welcome Email to Merchant</strong></td>
                  </tr>
                </table>
                <table cellspacing="0" cellpadding="0" border="0" class="tableBorder" width="100%">
                  <tr>
                    <td align="left" valign="top"><?php echo $this->Form->input('Merchant.Welcome_message', array('label'=>'','type' => 'textarea','class'=>'textarea1 mceNoEditor','value'=>"Hello [MERCHANT DBA NAME],

This is a welcome email message from total-apps.com.		  		

Sincerely,
[MANAGER NAME]
Account Manager
[MANAGER/COMPANY]
[MANAGER/Company URL] 
[MANAGER/PHONE]
(949) 266-8260 Fax"));?></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
                <?php echo $this->Form->input('submitfrom', array('type' => 'hidden','value'=>'welcome_email'));?> <?php echo $this->Form->end();?> </div>
              <div id="other_email_templates" style="display:none;">
                <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantaction','id'=>'othr_email_template','onsubmit'=>'return othr_email_template_validation()')); ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                  <tr>
                    <td width="15%" align="left" valign="middle">Select Email Template:</td>
                    <td width="85%" align="left" valign="middle"><?php echo $this->Form->input('EmailTemplate.id',array('type'=>'select','options'=>$other_email_template,'empty'=>'Select Email Template','class'=>'select1','div'=>false,'label'=>false,'onchange'=>'showEmailTemplate(this.value)','style'=>'width:50%'));?></td>
                  </tr>
                  <tr>
                    <td width="15%" align="left" valign="middle">To:</td>
                    <td width="85%" align="left" valign="middle"><?php echo $this->Form->input('EmailTemplate.merchantEmail', array('type' => 'text','div'=>false,'label'=>false,'class'=>'input1','value'=>$this->request->data['Merchant']['contactEmail'],'style'=>'width:50%'));?>&nbsp;&nbsp;(Emails can be comma separated)</td>
                  </tr>
                  <tr>
                    <td width="15%" align="left" valign="middle">Sent From:</td>
                    <td width="85%" align="left" valign="middle"><?php echo $this->Form->input('EmailTemplate.sentFrom', array('type' => 'text','class'=>'input1','div'=>false,'label'=>false,'style'=>'width:50%'));?></td>
                  </tr>
                  <tr>
                    <td width="15%" align="left" valign="middle">Subject:</td>
                    <td width="85%" align="left" valign="middle"><?php echo $this->Form->input('EmailTemplate.subject', array('type' => 'text','class'=>'input1','div'=>false,'label'=>false,'style'=>'width:50%'));?></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle">Email Template:</td>
                    <td align="left" valign="top"><?php echo $this->Form->input('EmailTemplate.template', array('label'=>'','type' => 'textarea','class'=>'textarea1','style'=>'width: 790px; height: 400px;'));?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><?php echo $this->Form->submit('Send Email Template',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
                <?php echo $this->Form->input('submitfrom', array('type' => 'hidden','value'=>'other_email_template','id'=>'othr_email_template','onsubmit'=>'return othr_email_template_validation()'));?> <?php echo $this->Form->end();?> </div>
            </div>
          </div>
        </div>
      </div>
      <!-- display box / second end here -->
    </div>
    <!-- end table -->
  </div>
</div>
<!-- end content / right -->
</div>
<script type="text/javascript">
	function showMerchantActions(showId){
		//HideId1,HideId2,HideId3
		if(showId=='send-app' || showId=='MojoPay' || showId=='MeritCard'){
			document.getElementById('send-app').style.display = 'block';
			document.getElementById('incomplete-doc').style.display = 'none';
			document.getElementById('bad-url').style.display = 'none';
			document.getElementById('pre-approve').style.display = 'none';
			document.getElementById('signature').style.display = 'none';
			document.getElementById('ProcessorAppFrom').value = showId;
			document.getElementById('send_application_to_processor').style.display = 'none';
			document.getElementById('request_supporting_documents').style.display = 'none';
			document.getElementById('other_email_templates').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'none';
		}else if(showId=='incomplete-doc'){
			document.getElementById('incomplete-doc').style.display = 'block';
			document.getElementById('send-app').style.display = 'none';
			document.getElementById('bad-url').style.display = 'none';
			document.getElementById('pre-approve').style.display = 'none';
			document.getElementById('signature').style.display = 'none';
			document.getElementById('send_application_to_processor').style.display = 'none';
			document.getElementById('request_supporting_documents').style.display = 'none';
			document.getElementById('other_email_templates').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'none';
		}else if(showId=='bad-url'){
			document.getElementById('bad-url').style.display = 'block';
			document.getElementById('send-app').style.display = 'none';
			document.getElementById('incomplete-doc').style.display = 'none';
			document.getElementById('pre-approve').style.display = 'none';
			document.getElementById('signature').style.display = 'none';
			document.getElementById('send_application_to_processor').style.display = 'none';
			document.getElementById('request_supporting_documents').style.display = 'none';
			document.getElementById('other_email_templates').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'none';
		}else if(showId=='pre-approve'){
			document.getElementById('pre-approve').style.display = 'block';
			document.getElementById('send-app').style.display = 'none';
			document.getElementById('incomplete-doc').style.display = 'none';
			document.getElementById('bad-url').style.display = 'none';
			document.getElementById('signature').style.display = 'none';
			document.getElementById('send_application_to_processor').style.display = 'none';
			document.getElementById('request_supporting_documents').style.display = 'none';
			document.getElementById('other_email_templates').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'none';
		}else if(showId=='return-for-signature'){
			document.getElementById('pre-approve').style.display = 'none';
			document.getElementById('send-app').style.display = 'none';
			document.getElementById('incomplete-doc').style.display = 'none';
			document.getElementById('bad-url').style.display = 'none';
			document.getElementById('signature').style.display = 'block';
			document.getElementById('send_application_to_processor').style.display = 'none';
			document.getElementById('request_supporting_documents').style.display = 'none';
			document.getElementById('other_email_templates').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'none';
		}else if(showId=='request_supporting_documents'){
			document.getElementById('pre-approve').style.display = 'none';
			document.getElementById('send-app').style.display = 'none';
			document.getElementById('incomplete-doc').style.display = 'none';
			document.getElementById('bad-url').style.display = 'none';
			document.getElementById('signature').style.display = 'none';
			document.getElementById('send_application_to_processor').style.display = 'none';
			document.getElementById('request_supporting_documents').style.display = 'block';
			document.getElementById('other_email_templates').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'none';
		}else if(showId=='send_application_to_processor'){
			document.getElementById('pre-approve').style.display = 'none';
			document.getElementById('send-app').style.display = 'none';
			document.getElementById('incomplete-doc').style.display = 'none';
			document.getElementById('bad-url').style.display = 'none';
			document.getElementById('signature').style.display = 'none';
			document.getElementById('send_application_to_processor').style.display = 'block';
			document.getElementById('request_supporting_documents').style.display = 'none';
			document.getElementById('other_email_templates').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'none';
		}else if(showId=='welcome_email'){
			document.getElementById('pre-approve').style.display = 'none';
			document.getElementById('send-app').style.display = 'none';
			document.getElementById('incomplete-doc').style.display = 'none';
			document.getElementById('bad-url').style.display = 'none';
			document.getElementById('signature').style.display = 'none';
			document.getElementById('send_application_to_processor').style.display = 'none';
			document.getElementById('request_supporting_documents').style.display = 'none';
			document.getElementById('other_email_templates').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'block';
		}else if(showId=='other_template'){
			document.getElementById('pre-approve').style.display = 'none';
			document.getElementById('send-app').style.display = 'none';
			document.getElementById('incomplete-doc').style.display = 'none';
			document.getElementById('bad-url').style.display = 'none';
			document.getElementById('signature').style.display = 'none';
			document.getElementById('send_application_to_processor').style.display = 'none';
			document.getElementById('request_supporting_documents').style.display = 'none';
			document.getElementById('welcome_email_message').style.display = 'none';
			document.getElementById('other_email_templates').style.display = 'block';			
		}		
	}
	function showEmailTemplate(templateID){
		$.ajax({
            type:"GET",
            url:"<?php echo FULL_BASE_URL.router::url('/',false);?>email_templates/getTemplate?id="+templateID,
            success : function(data) {
					obj =  jQuery.parseJSON(data);
					jQuery("#EmailTemplateSubject").val(obj.EmailTemplate.subject);
					tinyMCE.activeEditor.setContent(obj.EmailTemplate.message);					
					jQuery("#EmailTemplateSentFrom").val(obj.EmailTemplate.from);
            },
            error : function() {
            },
        });
   }
</script>
