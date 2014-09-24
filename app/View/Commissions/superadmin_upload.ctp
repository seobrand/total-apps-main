<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <?php if(!isset($merchants) && !isset($mids)){?>
      <div class="box1">
        <div class="news_announcement">
           <div class="titlebar">Add New Commissions
            <!-- <div style="float:right">
         	<a href="<?php echo $prePage; ?>"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
            </div> -->
          </div>
           	 <?php echo $this->Form->create('Commission', array('id'=>'form','enctype'=>'multipart/form-data'));?> 
                 <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
                   <tr>
                      <td align="right" valign="middle"><span class="required">*</span>XLS File :</td>
                      <td align="left" valign="middle"><table cellpadding="0" cellspacing="0" border="0" class="nostyle" >
                      <tr><td style="padding: 0px;"><?php echo $this->Form->input('message', array('label'=>'','type'=>'file')); ?> </td></tr></table></td>
                   </tr>
                   <tr>
                     <td align="right" valign="top">&nbsp;</td>
                     <td align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'onsubmit'=>'editor_content()'));?></td>
                   </tr>
                 </table>
                 <?php echo $this->Form->input('prePage', array('label'=>'','type'=>'hidden','value'=>$prePage)); ?>
                 <input type="hidden" name="SUBMIT" value="SUBMIT" />
             <?php echo $this->Form->end();?>
           </div>
        </div>
        <?php }else{?>
	        <div class="box1">
		        <div class="news_announcement">
		          <div class="titlebar">View Xls Record</div>
		          <?php // MIDs not exist in system ?>
		          <?php if(count($mids)>0){?>
		          	<div class="box"><div class="breadcrumb">Records Not Matching MIDs #</div>
			            <div class="display_row">
			            <?php echo $this->Form->create("Commission",array('action'=>'export'));?>
			              <div class="table">			              
							<div style="max-height:390px;overflow:auto;">
								<table width="100%" class="cg_table">
									<tr class="cg_header">
									  <th>MID</th>
									  <th>Amount processed</th>
									  <th>Number of Transactions</th>
									  <th>Number of Chargebacks</th>
									  <th>Gross revenue</th>
									  <th>Totalapps income</th>
									  <th>Date</th>
									  <th><?php echo $this->Form->input('All_mid',array('type'=>'checkbox','id'=>'all_mids','value'=>'1','onclick'=>'checkAllMid(this.value)','label'=>'All'));?></th>
									</tr>
									<?php foreach($mids as $key => $xlsValue){?>
										<tr class="cg_row">
											<td align="center"><?php echo $xlsValue[0];?></td>
											<td align="center"><?php echo $xlsValue[1];?></td>
											<td align="center"><?php echo $xlsValue[2];?></td>
											<td align="center"><?php echo $xlsValue[3];?></td>
											<td align="center"><?php echo $xlsValue[4];?></td>
											<td align="center"><?php echo $xlsValue[5];?></td>
											<td align="center"><?php echo date("m/d/Y",strtotime($xlsValue[6]));?></td>
											<td align="center"><input type="checkbox" value="<?php echo $xlsValue[0];?>" name="data[Commission][checkMid][]"></td>
										</tr>
										<?php $finalMidsArray[$xlsValue[0]] = array($xlsValue[1],$xlsValue[2],$xlsValue[3],$xlsValue[4],$xlsValue[5],strtotime($xlsValue[6]));?>
									<?php }?>								
								</table>
							</div>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table" align="center">
			                <tr>
			                <td width="100%" align="center"> 
			                <?php echo $this->Form->input('export_mids_array',array('type'=>'hidden','value'=>serialize($finalMidsArray)));?>
			                <?php echo $this->Form->submit('Export selected list',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'));?></td>
			          		<?php echo $this->Form->end();?>
			                </tr>
				            </table>
			              </div>
			            </div>
			            <!-- display box / second end here -->
			          </div>
			          <?php }?>
			          <?php // MIDs Which exist in system ?>
			          <div class="box">
			            <div class="display_row">
			              <div class="table">
			              <?php echo $this->Form->create("Commission",array('action'=>'approve'));?>
			              <div style="max-height:340px;overflow:auto;">
							<table width="100%" class="cg_table">
								<tr class="cg_header">
								  <th>Merchant Name</th>
								  <th>MID</th>
								  <th>Amount processed</th>
								  <th>Number of Transactions</th>
								  <th>Number of Chargebacks</th>
								  <th>Gross revenue</th>
								  <th>Totalapps income</th>
								  <th>Date</th>
								</tr>								
								<?php $total_exist = 0;?>
								<?php foreach($merchants as $key => $xlsValue){?>
									<?php $total_exist++; ?>
										<tr class="cg_row">
											<td align="center"><?php echo $xlsValue['merchantName'];?></td>
											<td align="center"><?php echo $xlsValue[0];?></td>
											<td align="center"><?php echo $xlsValue[1];?></td>
											<td align="center"><?php echo $xlsValue[2];?></td>
											<td align="center"><?php echo $xlsValue[3];?></td>
											<td align="center"><?php echo $xlsValue[4];?></td>
											<td align="center"><?php echo $xlsValue[5];?></td>
											<td align="center"><?php echo date("m/d/Y",strtotime($xlsValue[6]));?></td>
										</tr>
									<?php $finalArray[] = array($xlsValue['id'],$xlsValue[0],$xlsValue[1],$xlsValue[2],$xlsValue[3],$xlsValue[4],$xlsValue[5],strtotime($xlsValue[6]));?>									
								<?php }?>
								<?php if($total_exist==0){?>
									<tr class="cg_row">
									  <td align="center" colspan="8">MID# in this xls file are not matching in database.</td>
									</tr>
								<?php }?>
							</table>
							</div>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table" align="center">
				                <tr>
				                <?php if($total_exist>0){?>
				                  <td width="50%" align="right">
				                  <?php echo $this->Form->input('final_array',array('type'=>'hidden','value'=>serialize($finalArray)))?>
					                  <?php echo $this->Form->submit('Approve',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'));?>
				                  </td>
				                <?php }?>
				           		<?php echo $this->Form->end();?>
				                  <td <?php if($total_exist>0){?> width="50%" align="left" <?php }else{?> width="100%" align="center"<?php }?>>
				                  	  <?php //echo $this->Html->link('Reload',array('controller'=>'commissions','action'=>'upload'),array());?>
				                  	  <?php echo $this->Form->create("Commission",array('action'=>'upload','type'=>'get'));?>
					                  <?php echo $this->Form->submit('Reload',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'));?>
					                  <?php echo $this->Form->end();?>
				                  </td>
				                </tr>
				            </table>
			              </div>
			            </div>
			            <!-- display box / second end here -->
			          </div>
		        </div>
	      </div>
        <?php }?>
      </div>
      <!-- end table -->
    </div>
  </div>
 <script>
function checkAllMid(chk){
  var c = new Array();
  c = document.getElementsByTagName('input');
  for (var i = 0; i < c.length; i++)
  {
	if (c[i].type == 'checkbox')
	{
		if(document.getElementById('all_mids').checked == true){
			 c[i].checked = true;
		 }else{
			 c[i].checked = false;
		 }
	}
  }
}
 </script>
