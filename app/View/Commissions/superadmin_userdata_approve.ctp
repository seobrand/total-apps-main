<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      		<div class="box1">
		       <div class="news_announcement">
		          <div class="titlebar">View Xls Record</div>
		          <?php // MIDs not exist in system ?>
		          <?php if(count($missing_user_data)>0){?>
		          	<div class="box"><div class="breadcrumb">Users Not Matching Database</div>
			            <div class="display_row">
			            <?php echo $this->Form->create("Commission",array('action'=>'missinguserdataexport'));?>
			              <div class="table">			              
							<div style="max-height:390px;overflow:auto;">
								<table width="100%" class="cg_table">
									<tr class="cg_header">
									  <th>MID</th>
									  <th>Agent Name</th>
									  <th>ISO Name</th>
									  <th>Referral Name</th>
									  <th><?php echo $this->Form->input('All_mid',array('type'=>'checkbox','id'=>'all_mids','value'=>'1','onclick'=>'checkAllMid(this.value)','label'=>'All'));?></th>
									</tr>
									<?php foreach($missing_user_data as $key => $xlsValue){?>
										<tr class="cg_row">
											<td align="center"><?php echo $xlsValue[0];?></td>
											<td align="center"><?php echo $xlsValue[1];?></td>
											<td align="center"><?php echo $xlsValue[2];?></td>
											<td align="center"><?php echo $xlsValue[3];?></td>
											<td align="center"><input type="checkbox" value="<?php echo $xlsValue[0];?>" name="data[Commission][checkMid][]"></td>
										</tr>
										<?php $finalUsersArray[$xlsValue[0]] = array($xlsValue[1],$xlsValue[2],$xlsValue[3]);?>
									<?php }?>								
								</table>
							</div>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table" align="center">
			                <tr>
			                <td width="100%" align="center"> 
			                <?php echo $this->Form->input('export_users_array',array('type'=>'hidden','value'=>serialize($finalUsersArray)));?>
			                <?php echo $this->Form->submit('Export selected list',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'));?></td>
			          		<?php echo $this->Form->end();?>
			                </tr>
				            </table>
			              </div>
			            </div>
			            <!-- display box / second end here -->
			          </div>
			          <?php }?>
		        </div>
	      </div>
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
