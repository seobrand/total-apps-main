<?php 	APP::import('Model','Processordoc');
			$this->Processordoc = new Processordoc();
			APP::import('Model','Merchantprocessordoclink');
			$this->MerchantDoc = new Merchantprocessordoclink();
			//var_dump($countDoc);die;
?>

<script>
jQuery(document).ready(function(){
<?php foreach($processorDoc as $key => $docVal):?>
jQuery(".example<?php echo $docVal['Processordoclink']['docID'];?>").colorbox({width:"50%", inline:true});
<?php endforeach;?>
jQuery(".example-merchantPDF").colorbox({width:"50%", inline:true});
});
</script>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="doc">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
		  	<div class="box1">
		  		<div class="news_announcement">
                	<div class="titlebar">Merchant Document
						<div style="float:right">
							<a href="<?php echo $this->webroot; ?>superadmin/merchants/merchantrates/<?php echo $this->request->data['Merchant']['id']; ?>#rate">Next</a>
					</div>
					</div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
					  <?php $columncount = 3; $i = 0;?>
					  <?php if(isset($countDoc) && $countDoc>0):?>
					  <?php foreach($processorDoc as $key => $docVal):?>
					  <?php if ($i++%$columncount==0): ?>
					  <tr>
						<?php endif ?>
						<td width="33%" align="left" valign="top"><div class="doc_upload">
							<?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'merchantdoc','enctype'=>'multipart/form-data','onsubmit'=>'return checkfileExtension('.$i.')')); ?>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="35%" align="left" valign="top"><strong>Document:</strong></td>
								<td width="65%" align="left" valign="top"><?php echo $this->Processordoc->field('docName',array('id'=>$docVal['Processordoclink']['docID']));  ?></td>
							  </tr>
							  <tr>
								<td align="left" valign="top"><strong>Status:</strong> </td>
								<td align="left" valign="top" class="red">
								<?php $merchantDoc = $this->MerchantDoc->field('docName',array('docID'=>$docVal['Processordoclink']['docID'],'merchantID'=>$this->request->data['Merchant']['id']));
									if($merchantDoc){
									$folder = "files/MerchantDocument";
								?>
								  <a class='example<?php echo $docVal['Processordoclink']['docID'];?>' href="#inline_example<?php echo $docVal['Processordoclink']['docID'];?>">view</a>
								  <?php	$url=FULL_BASE_URL.Router::url('/', false).$folder."/".$merchantDoc; ?>
								  <div style='display:none'>
									<div id='inline_example<?php echo $docVal['Processordoclink']['docID'];?>' style='padding:10px; background:#fff;'>
									  <?php //if(substr(strrchr($merchantDoc,'.'),1)!='docx'){?>
										  <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
									  <?php //} ?>
									  <br />
									  <br />
									  <a href="<?php echo $url;?>" target="_blank">Download</a> </div>
								  </div>
								  <?php }else{?>
									Needed
								  <?php } ?>
								</td>
							  </tr>
							  <tr>
								<td align="left" valign="top" colspan="2"><?php echo $this->Form->input('Merchantprocessordoclink.docName', array('id'=>'docname'.$i.'','between'=>'<br />','type'=>'file','label'=>'','error'=>false));?> </td>
							  </tr>
							  <tr>
								<td align="left" valign="top" colspan="2"><?php echo $this->Form->input('Merchantprocessordoclink.merchantID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['id']));?> <?php echo $this->Form->input('Merchantprocessordoclink.docID', array('type' => 'hidden','value'=>$docVal['Processordoclink']['docID']));?> <?php echo $this->Form->submit('Upload',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>&nbsp;&nbsp;&nbsp;<?php if($merchantDoc){?> <a onclick="if (confirm('Are you sure to delete this document?')){  return true }else{return false}" class="cursorclass a-state-default ui-corner-all" href="<?php echo $this->webroot; ?>superadmin/merchants/docsdelete/<?php echo $docVal['Processordoclink']['docID'].DS.$this->request->data['Merchant']['id'] ?>">Delete</a><?php }?> </td>
							  </tr>
							</table>
							<?php echo $this->Form->end();?> </div></td>
						<?php if ($i%$columncount==0 ): ?>
					  </tr>
					  <?php endif ?>
					  <?php if($i==$countDoc):?><!-- Merchant PDF -->
								<?php  $merchantDoc = WWW_ROOT."files/Signature/".$this->request->data['Merchant']['merchantSign'];
									if(file_exists($merchantDoc)) { $folder = "files/Signature"; ?>
									<?php if($i%$columncount==0):?>
									<tr>
									 <?php endif; ?>
										<td width="33%" align="left" valign="top"><div class="doc_upload">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
											  <tr>
												<td width="35%" align="left" valign="top"><strong>Document:</strong></td>
												<td width="65%" align="left" valign="top">Merchant Profile PDF</td>
											  </tr>
											  <tr>
												<td align="left" valign="top"><strong>Status:</strong> </td>
												<td align="left" valign="top" class="red">
												<a href="<?php echo $this->webroot?>superadmin/apis/downloadpdf/<?php echo $this->request->data['Merchant']['id']?>.pdf">Download</a>
												 <!--  <a class='example-merchantPDF' href="#inline_example-merchantPDF">view</a> -->
												  <?php /*	$url=FULL_BASE_URL.Router::url('/', false).$folder."/Merchant-".$this->request->data['Merchant']['id'].".pdf"; ?>
												  <div style='display:none'>
													<div id='inline_example-merchantPDF' style='padding:10px; background:#fff;'>
														  <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
													  <br />
													  <a href="<?php echo $url;?>" target="_blank">Download</a> </div>
												  </div> <?php */ ?>
											  </td>
											</tr>
										   </table>
										  </div>
										</td>
									 <?php if($i%$columncount==0):?>
									</tr>
									<?php endif; ?>
								<?php } ?>
								</tr>
					  <?php endif; ?>
					  <?php endforeach;?>
					  <?php endif;?>
					  <?php // if document is not provided for merchant
							if(!isset($countDoc) || $countDoc==0):?>							
							<?php  $merchantDoc = WWW_ROOT."files/Signature/".$this->request->data['Merchant']['merchantSign'];
							if(file_exists($merchantDoc) && $this->request->data['Merchant']['merchantSign']!='') { $folder = "files/Signature"; ?>
							<tr>
								<td width="33%" align="left" valign="top"><div class="doc_upload">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td width="35%" align="left" valign="top"><strong>Document:</strong></td>
										<td width="65%" align="left" valign="top">Merchant Profile PDF</td>
									  </tr>
									  <tr>
										<td align="left" valign="top"><strong>Status:</strong> </td>
										<td align="left" valign="top" class="red">
										  <a href="<?php echo $this->webroot?>superadmin/apis/downloadpdf/<?php echo $this->request->data['Merchant']['id']?>.pdf">Download</a>
										 <!--  <a class='example-merchantPDF' href="#inline_example-merchantPDF">view</a> -->
										  <?php /*	$url=FULL_BASE_URL.Router::url('/', false).$folder."/Merchant-".$this->request->data['Merchant']['id'].".pdf"; ?>
										  <div style='display:none'>
											<div id='inline_example-merchantPDF' style='padding:10px; background:#fff;'>
												  <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
											  <br />
											  <a href="<?php echo $url;?>" target="_blank">Download</a> </div>
										  </div> <?php */ ?>
									  </td>
									</tr>
								   </table>
								  </div>
								</td>
							</tr>
						<?php }else{ ?>
							<tr><td colspan="3" width="100%" align="center">No Document Found</td></tr>
							<?php } ?>
					  <?php endif;?>
					</table>
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
var valid_extensions = /(.doc|.pdf|.docx)$/i;

function checkfileExtension(val){
filename = document.getElementById('docname'+val).value;
if(filename) {
		if (valid_extensions.test(filename)){
			return true;
		} else {
			alert("Please provide valid file of extension .doc,.pdf,.docx")
			return false;
		}
	} else {
		alert("Please provide file")
		return false;
	}
}
</script>