<?php
if(isset($TeminalData) && count($TeminalData)>0){
	foreach($TeminalData as $key =>$terminalarray ){
		$i = "selected_option".($key+1);
		$this->request->data['Terminalsoftgateway']['softwareName'.($key+1)] = $terminalarray['Terminalsoftgateway']['softwareName'];
		$this->request->data['Terminalsoftgateway']['trainingGivenBy'.($key+1)] = $terminalarray['Terminalsoftgateway']['trainingGivenBy'];
		$this->request->data['Terminalsoftgateway']['supplier'.($key+1)] = $terminalarray['Terminalsoftgateway']['supplier'];
		${$i} = explode(",",$terminalarray['Terminalsoftgateway']['options']);
	}
}else{
	$selected_option1 = array();
}


if(isset($PrinterData) && count($PrinterData)>0){
	foreach($PrinterData as $key =>$printerdata ){
		$this->request->data['Printer']['printerName'.($key+1)] = $printerdata['Printer']['printerName'];
		$this->request->data['Printer']['printerQuantity'.($key+1)] = $printerdata['Printer']['printerQuantity'];
		$this->request->data['Printer']['printerSupplier'.($key+1)] = $printerdata['Printer']['printerSupplier'];
		$this->request->data['Printer']['newOrFurbished'.($key+1)] = $printerdata['Printer']['newOrFurbished'];
	}
}

if(isset($CheckReaderData) && count($CheckReaderData)>0){
	foreach($CheckReaderData as $key =>$readerdata ){
		$this->request->data['Checkreader']['checkReaderName'.($key+1)] = $readerdata['Checkreader']['checkReaderName'];
		$this->request->data['Checkreader']['readerQuantity'.($key+1)] = $readerdata['Checkreader']['readerQuantity'];
		$this->request->data['Checkreader']['readerSupplier'.($key+1)] = $readerdata['Checkreader']['readerSupplier'];
		$this->request->data['Checkreader']['readerNewOrFurbished'.($key+1)] = $readerdata['Checkreader']['readerNewOrFurbished'];
	}
}
if(isset($adminName) && is_array($adminName)){
	foreach($adminName as $key =>$admins){
		$admin[$admins['Deployment']['adminName']] = $admins['Deployment']['adminName'];
	}
}else{
	$admin =array();
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
        <div class="display_row" id="deployment">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>		  
          <div class="tabs_des">
		  <div class="box1">
		  	<div class="news_announcement">
                <div class="titlebar">Select Deployment
				<div style="float:right">
					<a href="<?php echo $this->webroot; ?>superadmin/merchants/merchantcommission/<?php echo $this->request->data['Merchant']['id']; ?>#commission">Next</a>
				</div>
				</div>
                <div class="news_indent">
			  <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantdeployment','name'=>'admindeployment','type' => 'get'))?> 
					<table width="50%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
						<td width="30%" align="left">Select Name</td>
						<td><?php echo $this->Form->input('Deployment.adminName',array('label'=>false,'class'=>'input1','div'=>false,'type'=>'select','options'=>$admin,'empty'=>array('0'=>'-Select Deployment-'),'onchange' => "javascript:getDeployment(this.value);"));?></td>
                    </tr>
                  </table>
			<?php echo $this->Form->end();?>	  
				</div>
			</div>
		  </div>
          <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantdeployment')); ?>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Terminal/Software/Gateway Programming</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td style="line-height:20px;"><?php echo $this->Form->radio('Deployment.terminalPrograming', array('Retail' => 'Retail', 'Tips' => 'Tips', 'MOTO/Internet Gateway' => 'MOTO/Internet Gateway', 'Lodging' => 'Lodging **', 'Petroleum' => 'Petroleum **', 'Cash Advance' => 'Cash Advance ***'),array('legend' => false,'separator' => '<br/>', 'between' => '&nbsp;&nbsp;'));?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top" style="line-height:20px;">
                      ** Requires special application olny available on certain terminals, so be sure to check with Totalapps.<br/>
                        *** Only available for financial institutions and special paperwork is required. Requires a verifone Tranz 330 and printer.</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement"  style="margin:0 0 10px;">
                <div class="titlebar">Card/Transation type</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td><?php echo $this->Form->input('Deployment.cardTransactionType', array('label' => false,'type' => 'select', 'multiple' => 'checkbox','selected'=> $selected_ttype,'options' => array('Pin-based debit' => 'Pin-based debit','EBT' => 'EBT','Check/ACH/RDC Services' => 'Check/ACH/RDC Services','Gift or Loyalty' => 'Gift or Loyalty','Wright Express' => 'Wright Express (appropriate paperwork has been submited)','Voyager' => 'Voyager (appropriate paperwork has been submited)')));?> </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
			<div class="box1">
              <div class="news_announcement" style="margin:0px;">
                <div class="titlebar">Pin Pad</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td><?php echo $this->Form->radio('Deployment.pinPad', array('Terminal to be internally encrypted' => 'Terminal to be internally encrypted', 'Terminal to be have an external pin pad attached' => 'Terminal to be have an external pin pad attached'),array('legend' => false,'separator' => '<br/>', 'between' => '&nbsp;&nbsp;'));?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
			<div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Shipping Info</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone">Totalapps Sends welcome kits for each merchant, regardiess of who supplies the equipment.  Please let us know how, or if, you want the kit Shipped.</td>
                    </tr>
                    <tr>
                      <td colspan="5"><?php echo $this->Form->radio('Deployment.shippingInfo', array('Ground' => 'Ground', '2nd day' => '2nd day', 'Overnight' => 'Overnight', 'Saturday Delivery' => 'Saturday Delivery', 'No Kit Necessary' => 'No Kit Necessary *'),array('legend' => false,'separator' => '<br/>', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">&nbsp;</td>
                      <td colspan="2" align="left" valign="middle" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><?php echo $this->Form->radio('Deployment.shippingInfoOther', array('Ship to DBA Address' => 'Ship to DBA Address', 'Ship to Other' => 'Ship to Other'),array('legend' => false,'separator' => '<br/>', 'between' => '&nbsp;&nbsp;'));?></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone">* Totalapps will normally not ship a kit for an ecommerce merchant, but we will send a welcome letter via email.</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
			<div class="box1">
              <div class="news_announcement" style="margin:0px;">
                <div class="titlebar">Billing Info</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td><?php echo $this->Form->radio('Deployment.billingInfo', array('No Billing Required' => 'No Billing Required', 'Bill Agent' => 'Bill Agent', 'Bill Merchant' => 'Bill Merchant'),array('legend' => false,'separator' => '<br/>', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone">Billing notes<br />
                        <?php echo $this->Form->textarea('Deployment.billingNotes',array('class'=>'textarea1'));?> </td>
                    </tr>                   
                  </table>
                </div>
              </div>
            </div>
			<div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Other Services and Notes</div>
                <div class="news_indent">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone">Billing notes<br />
                        <?php echo $this->Form->textarea('Deployment.otherServies',array('class'=>'textarea1'));?> </td>
                    </tr>                    
                  </table>
                </div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Terminal/Software/Gateway</div>
                <div class="news_indent_addmore">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td align="left" valign="middle" class="rpadnone"> Terminal, Softwrare, or gateway</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Terminalsoftgateway.softwareName1',array('label'=>false,'class'=>'input2','div'=>false));?> </td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> Traning will be done by </td>
                      <td colspan="3"><?php echo $this->Form->radio('Terminalsoftgateway.trainingGivenBy1', array('totalapps' => 'Total-Apps', 'agent' => 'Agent&nbsp;&nbsp;&nbsp&nbsp;&nbsp;', 'other' => 'Other'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> Terminal Provided By
                      </td>
                      <td colspan="3"><?php echo $this->Form->radio('Terminalsoftgateway.supplier1', array('Totalapps' => 'Total-Apps','Merchant' => 'Merchant', 'Agent' => 'Agent'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;','class'=>'supplier'));?> </td>
                    </tr>
                    <tr>
                      <td width="23%"  align="left" valign="middle" class="rpadnone"> Options * </td>
                      <td colspan="3"><?php echo $this->Form->input('Terminalsoftgateway.options1', array('label' => false,'type' => 'select', 'multiple' => 'checkbox','selected'=> $selected_option1,'options' => array('Process via IP' => 'Process via IP','Wireless' => 'Wireless','Store and forward' => 'Store and forward','Timed upload' => 'Timed upload')));?> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone"><em> * These options are not available on all terminals. please check with Totalapps to ensure compatibility. </em></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addTerminalFormField()">Add another terminal, software, or gateway</a> (up to four) </td>
                      <input type="hidden" value="<?php if(isset($TeminalData) && count($TeminalData)>1) echo count($TeminalData); else echo "1"; ?>" id="TerminalsoftgatewayCount" name="data[Terminalsoftgateway][count]">
                    </tr>
                  </table>
                </div>
                <?php if(isset($TeminalData) && count($TeminalData)>1){ 
					foreach($TeminalData as $key => $terminal){ if($key>=1) {
					$optionCount = "selected_option".($key+1);
					?>
                <div class="news_indent_addmore">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td align="left" valign="middle" class="rpadnone"> Terminal, Softwrare, or gateway </td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Terminalsoftgateway.softwareName'.($key+1),array('label'=>false,'class'=>'input2','div'=>false));?> </td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> Traning will be done by</td>
                      <td colspan="3"><?php echo $this->Form->radio('Terminalsoftgateway.trainingGivenBy'.($key+1), array('totalapps' => 'Total-Apps', 'agent' => 'Agent&nbsp;&nbsp;&nbsp&nbsp;&nbsp;', 'other' => 'Other'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> Terminal provided by: </td>
                      <td colspan="3"><?php echo $this->Form->radio('Terminalsoftgateway.supplier'.($key+1), array('Totalapps' => 'Total-Apps','Merchant' => 'Merchant', 'Agent' => 'Agent'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td width="23%"  align="left" valign="middle" class="rpadnone"> Options * </td>
                      <td colspan="3"><?php echo $this->Form->input('Terminalsoftgateway.options'.($key+1), array('label' => false,'type' => 'select', 'multiple' => 'checkbox','selected'=> ${$optionCount},'options' => array('Process via IP' => 'Process via IP','Wireless' => 'Wireless','Store and forward' => 'Store and forward','Timed upload' => 'Timed upload')));?> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone"><em> * These options are not available on all terminals. please check with Totalapps to ensure compatibility. </em></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addTerminalFormField()">Add another terminal, software, or gateway</a> (up to four) &nbsp;&nbsp;&nbsp;&nbsp;<?php if($terminal['Terminalsoftgateway']['merchantID']==$this->request->data['Merchant']['id']){ echo $this->Html->link('Remove', array('controller' => 'merchants','action' => 'terminalsoftwaredelete', $terminal['Terminalsoftgateway']['id'], $terminal['Terminalsoftgateway']['merchantID'])); } ?> </td>
                    </tr>
                  </table>
                </div>
                <?php } } }?>
                <div id="divTxt"></div>
              </div>
            </div>
			<div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Printer</div>
                <div class="news_indent_addmore">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Printer</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Printer.printerName1',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone">Quantity</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Printer.printerQuantity1',array('label'=>false,'class'=>'input2','div'=>false));?> <span class="gray">(Numeric)</span></td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> Supplier</td>
                      <td colspan="3"><?php echo $this->Form->radio('Printer.printerSupplier1', array('Merchant Owned' => 'Merchant Owned', 'Agent Supplied' => 'Agent Supplied', 'Totalapps' => 'Total-Apps'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> New or refurbished</td>
                      <td colspan="3"><?php echo $this->Form->radio('Printer.newOrFurbished1', array('New' => 'New', 'Refurbished' => 'Refurbished'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addPrinterFormField()">Add another printer</a> (up to four) </td>
                      <input type="hidden" value="<?php if(isset($PrinterData) && count($PrinterData)>1) echo count($PrinterData); else echo "1"; ?>" id="PrinterCount" name="data[Printer][count]">
                    </tr>
                  </table>
                </div>
                <?php if(isset($PrinterData) && count($PrinterData)>1){ 
					foreach($PrinterData as $key => $printer){ if($key>=1) {
					?>
                <div class="news_indent_addmore">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Printer</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Printer.printerName'.($key+1),array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone">Quantity</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Printer.printerQuantity'.($key+1),array('label'=>false,'class'=>'input2','div'=>false));?> <span class="gray">(Numeric)</span></td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> Supplier</td>
                      <td colspan="3"><?php echo $this->Form->radio('Printer.printerSupplier'.($key+1), array('Merchant Owned' => 'Merchant Owned', 'Agent Supplied' => 'Agent Supplied', 'Totalapps' => 'Total-Apps'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> New or refurbished</td>
                      <td colspan="3"><?php echo $this->Form->radio('Printer.newOrFurbished'.($key+1), array('New' => 'New', 'Refurbished' => 'Refurbished'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addPrinterFormField()">Add another printer</a> (up to four) &nbsp;&nbsp;&nbsp;&nbsp;<?php if($printer['Printer']['merchantID']==$this->request->data['Merchant']['id']){ echo $this->Html->link('Remove', array('controller' => 'merchants','action' => 'printerdelete', $printer['Printer']['id'], $printer['Printer']['merchantID']));} ?></td>
                    </tr>
                  </table>
                </div>
                <?php } } }?>
                <div id="printerDivTxt"></div>
              </div>
            </div>
            <div class="box1">
              <div class="news_announcement">
                <div class="titlebar">Check Reader</div>
                <div class="news_indent_addmore">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Cheak Reader</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Checkreader.checkReaderName1',array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone">Quantity</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Checkreader.readerQuantity1',array('label'=>false,'class'=>'input2','div'=>false));?> <span class="gray">(Numeric)</span></td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> Supplier</td>
                      <td colspan="3"><?php echo $this->Form->radio('Checkreader.readerSupplier1', array('Merchant Owned' => 'Merchant Owned', 'Agent Supplied' => 'Agent Supplied', 'Totalapps' => 'Total-Apps'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> New or refurbished</td>
                      <td colspan="3"><?php echo $this->Form->radio('Checkreader.readerNewOrFurbished1', array('New' => 'New', 'Refurbished' => 'Refurbished'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addReaderFormField()">Add another check reader</a> (up to four) </td>
                      <input type="hidden" value="<?php if(isset($CheckReaderData) && count($CheckReaderData)>1) echo count($CheckReaderData); else echo "1"; ?>" id="CheckreaderCount" name="data[Checkreader][count]">
                    </tr>
                  </table>
                </div>
                <?php if(isset($CheckReaderData) && count($CheckReaderData)>1){ 
					foreach($CheckReaderData as $key => $checkreader){ if($key>=1) {
					?>
                <div class="news_indent_addmore">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                    <tr>
                      <td align="left" valign="middle" class="rpadnone">Cheak Reader</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Checkreader.checkReaderName'.($key+1),array('label'=>false,'class'=>'input2','div'=>false));?></td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone">Quantity</td>
                      <td colspan="4" align="left" valign="middle"><?php echo $this->Form->input('Checkreader.readerQuantity'.($key+1),array('label'=>false,'class'=>'input2','div'=>false));?> <span class="gray">(Numeric)</span></td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> Supplier</td>
                      <td colspan="3"><?php echo $this->Form->radio('Checkreader.readerSupplier'.($key+1), array('Merchant Owned' => 'Merchant Owned', 'Agent Supplied' => 'Agent Supplied', 'Totalapps' => 'Total-Apps'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td width="23%" align="left" valign="middle" class="rpadnone"> New or refurbished</td>
                      <td colspan="3"><?php echo $this->Form->radio('Checkreader.readerNewOrFurbished'.($key+1), array('New' => 'New', 'Refurbished' => 'Refurbished'),array('legend' => false,'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'between' => '&nbsp;&nbsp;'));?> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addReaderFormField()">Add another check reader</a> (up to four) &nbsp;&nbsp;&nbsp;&nbsp;<?php if($readerdata['Checkreader']['merchantID']==$this->request->data['Merchant']['id']){  echo $this->Html->link('Remove', array('controller' => 'merchants','action' => 'checkreaderdelete', $readerdata['Checkreader']['id'], $readerdata['Checkreader']['merchantID'])); } ?></td>
                    </tr>
                  </table>
                </div>
                <?php } } }?>
                <div id="readerDivTxt"></div>
              </div>
            </div>
            <?php echo $this->Form->input('Deployment.merchantID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['id']));?> <?php echo $this->Form->input('Deployment.statusID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['statusID']));?> <?php echo $this->Form->input('Deployment.id', array('type' => 'hidden','value'=>$ID));?>
            <div style="float:right; margin-right:10px;"><?php echo $this->Form->submit('Update',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></div>
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
var count = parseInt(document.getElementById('TerminalsoftgatewayCount').value);
var content ='';
function addTerminalFormField() {
var i = count+1;
	if(count<=3){
		content += '<div class="news_indent_addmore"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg"><tr><td align="left" valign="middle" class="rpadnone"> Terminal, Softwrare, or gateway </td><td colspan="4" align="left" valign="middle"><input type="text" id="TerminalsoftgatewaySoftwareName'+i+'" class="input2" name="data[Terminalsoftgateway][softwareName'+i+']"></td></tr><tr><td width="23%" align="left" valign="middle" class="rpadnone"> Traning will be done by </td><input type="hidden" value="" id="TerminalsoftgatewayTrainingGivenBy_" name="data[Terminalsoftgateway][trainingGivenBy'+i+']"><td width="15%" align="left" valign="middle"><input type="radio" value="totalapps" id="TerminalsoftgatewayTrainingGivenByTotalapps" name="data[Terminalsoftgateway][trainingGivenBy'+i+']"  />Total-Apps</td><td width="14%" align="left" valign="middle"><input type="radio" value="agent" id="TerminalsoftgatewayTrainingGivenByAgent" name="data[Terminalsoftgateway][trainingGivenBy'+i+']"  />Agent</td><td colspan="2" align="left" valign="middle"><input type="radio" value="other" id="TerminalsoftgatewayTrainingGivenByOther" name="data[Terminalsoftgateway][trainingGivenBy'+i+']"  />Other</td></tr><tr><td align="left" valign="middle" class="rpadnone">Terminal provided by</td><input type="hidden" value="" id="TerminalsoftgatewaySupplier_" name="data[Terminalsoftgateway][supplier'+i+']"><td align="left" valign="middle"><input type="radio" value="Totalapps" id="TerminalsoftgatewaySupplierTotalapps" name="data[Terminalsoftgateway][supplier'+i+']"  />Total-Apps</td><td align="left" valign="middle"><input type="radio" value="Merchant" id="TerminalsoftgatewaySupplierMerchantOwned" name="data[Terminalsoftgateway][supplier'+i+']"  />Merchant</td><td colspan="2" align="left" valign="middle"><input type="radio" value="Agent" id="TerminalsoftgatewaySupplierAgentSupplied" name="data[Terminalsoftgateway][supplier'+i+']"  />Agent</td></tr><tr><td align="left" valign="middle" class="rpadnone"> Options *</td><td align="left" valign="middle"><input type="checkbox" value="Process via IP" id="TerminalsoftgatewayOptionsProcessViaIP" name="data[Terminalsoftgateway][options'+i+'][]"  />Process via IP</td><td align="left" valign="middle"><input type="checkbox" value="Wireless" id="TerminalsoftgatewayOptionsWireless" name="data[Terminalsoftgateway][options'+i+'][]"  />Wireless</td><td width="17%" align="left" valign="middle"><input type="checkbox" value="Store and forward" id="TerminalsoftgatewayOptionsStoreAndForward" name="data[Terminalsoftgateway][options'+i+'][]"  />Store and forward</td><td width="31%" align="left" valign="middle"><input type="checkbox" value="Timed upload" id="TerminalsoftgatewayOptionsTimedUpload" name="data[Terminalsoftgateway][options'+i+'][]"  />Timed upload</td></tr><tr><td colspan="5" align="left" valign="middle" class="rpadnone"><em> * These options are not available on all terminals. please check with Totalapps to ensure compatibility. </em></td></tr><tr><td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addTerminalFormField()">Add another terminal, software, or gateway</a> (up to four) </td><input type="hidden" value="'+i+'" id="TerminalsoftgatewayCount" name="data[Terminalsoftgateway][count]"></tr></table></div>';
	document.getElementById("divTxt").innerHTML = content;
	count = count + 1;
	}else{
		alert("Sorry you can add total of 4 blocks");
	}
	
}
// for printer
var pcount = parseInt(document.getElementById('PrinterCount').value);;
var pcontent ='';
function addPrinterFormField() {
	j = pcount +1;
	if(pcount<=3){
		pcontent += '<div class="news_indent_addmore"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg"><tr><td align="left" valign="middle" class="rpadnone">Printer</td><td colspan="4" align="left" valign="middle"><input type="text" id="PrinterPrinterName'+j+'" class="input2" name="data[Printer][printerName'+j+']"></td></tr><tr><td width="23%" align="left" valign="middle" class="rpadnone">Quantity</td><td colspan="4" align="left" valign="middle"><input type="text" id="PrinterPrinterQuantity'+j+'" class="input2" name="data[Printer][printerQuantity'+j+']"><span class="gray">(Numeric)</span></td></tr><tr><td align="left" valign="middle" class="rpadnone">Supplier</td><input type="hidden" value="" id="PrinterPrinterSupplier_" name="data[Printer][printerSupplier'+j+']"><td width="15%" align="left" valign="middle"><input type="radio" value="Merchant Owned" id="PrinterPrinterSupplierMerchantOwned'+j+'" name="data[Printer][printerSupplier'+j+']"  />Merchant Owned</td><td width="14%" align="left" valign="middle"><input type="radio" value="Agent Supplied" id="PrinterPrinterSupplierAgentSupplied'+j+'" name="data[Printer][printerSupplier'+j+']"  />Agent Supplied</td><td colspan="2" align="left" valign="middle"><input type="radio" value="Totalapps" id="PrinterPrinterSupplierFormPowerpay'+j+'" name="data[Printer][printerSupplier'+j+']"  />Total-Apps</td></tr><tr><td align="left" valign="middle" class="rpadnone"> New or refurbished: </td><input type="hidden" value="" id="PrinterNewOrFurbished_" name="data[Printer][newOrFurbished'+j+']"><td align="left" valign="middle"><input type="radio" value="New" id="PrinterNewOrFurbishedNew'+j+'" name="data[Printer][newOrFurbished'+j+']"  />New</td><td colspan="3" align="left" valign="middle"><input type="radio" value="Refurbished" id="PrinterNewOrFurbishedRefurbished'+j+'" name="data[Printer][newOrFurbished'+j+']"  />Refurbished</td></tr><tr><td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addPrinterFormField()">Add another Printer</a> (up to four) </td><input type="hidden" value="'+j+'" id="PrinterCount" name="data[Printer][count]"></tr></table></div>';
	document.getElementById("printerDivTxt").innerHTML = pcontent;
	pcount = pcount + 1;
	}else{
		alert("Sorry you can add only 4 blocks");
	}
	
}
// for Reader
var Ccount = parseInt(document.getElementById('CheckreaderCount').value);;
var Ccontent ='';
function addReaderFormField() {
	var k=Ccount+1;
	if(Ccount<=3){
		Ccontent += '<div class="news_indent_addmore"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg"><tr><td align="left" valign="middle" class="rpadnone">Cheak Reader</td><td colspan="4" align="left" valign="middle"><input type="text" id="CheckreaderCheckreaderName'+k+'" class="input2" name="data[Checkreader][checkReaderName'+k+']"></td></tr><tr><td width="23%" align="left" valign="middle" class="rpadnone">Quantity</td><td colspan="4" align="left" valign="middle"><input type="text" id="CheckreaderReaderQuantity'+k+'" class="input2" name="data[Checkreader][readerQuantity'+k+']"><span class="gray">(Numeric)</span></td></tr><tr><td align="left" valign="middle" class="rpadnone">Supplier</td><input type="hidden" value="" id="CheckreaderReaderSupplier_" name="data[Checkreader][readerSupplier'+k+']"><td width="15%" align="left" valign="middle"><input type="radio" value="Merchant Owned" id="CheckreaderReaderSupplierMerchant'+k+'" name="data[Checkreader][readerSupplier'+k+']"  />Merchant Owned</td><td width="14%" align="left" valign="middle"><input type="radio" value="Agent Supplied" id="CheckreaderReaderSupplierAgent'+k+'" name="data[Checkreader][readerSupplier'+k+']"  />Agent Supplied</td><td colspan="2" align="left" valign="middle"><input type="radio" value="Totalapps" id="CheckreaderReaderSupplierPowerpay'+k+'" name="data[Checkreader][readerSupplier'+k+']"  />Total-Apps</td></tr><tr><td align="left" valign="middle" class="rpadnone"> New or refurbished: </td><input type="hidden" value="" id="CheckreaderNewOrFurbished_" name="data[Checkreader][readerNewOrFurbished'+k+']"><td align="left" valign="middle"><input type="radio" value="New" id="CheckreaderNewOrFurbishedNew'+k+'" name="data[Checkreader][readerNewOrFurbished'+k+']"  />New</td><td colspan="3" align="left" valign="middle"><input type="radio" value="Refurbished" id="CheckreaderNewOrFurbishedRefurbished'+k+'" name="data[Checkreader][readerNewOrFurbished'+k+']"  />Refurbished</td></tr><tr><td colspan="5" align="left" valign="middle" class="rpadnone"><a href="javascript:void(0)" onclick="addReaderFormField()">Add another check reader</a> (up to four) </td><input type="hidden" value="'+k+'" id="CheckreaderCount" name="data[Checkreader][count]"></tr></table></div>';
	document.getElementById("readerDivTxt").innerHTML = Ccontent;
	Ccount = Ccount + 1;
	}else{
		alert("Sorry you can add only 4 blocks");
	}
	
}

function getDeployment(value){
		//alert(value)
		if(value!='0'){
			document.admindeployment.submit();
		}
	}
</script>
