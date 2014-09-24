<?php $options = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December')?>
<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb">Merchant Losses</div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <div class="news_indent"> 
          <?php echo $this->Form->create('Commissionlog');?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr>
                <td width="10%" valign="top" align="left" style="padding:0px;font:bold 15px arial">Select Date</td>
                 <td width="30%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('Month',array('type'=>'select','options'=>$options,'empty'=>'Select Month','div'=>false,'label'=>false,'style'=>'width:290px;'));?>
	                 
				 </td>
				 <td width="03%" valign="top" align="left">Year</td>
                 <td width="30%" valign="top" style="padding:0px;"><?php echo $this->Form->input('Year',array('type'=>'text','class'=>'input1','maxlength'=>'04','div'=>false,'label'=>false));?></td>
                 <td width="30%" valign="top" style="padding:0px;"><input type="submit" value="Search" class="cursorclass ui-state-default ui-corner-all" name="Submit"></td>
              </tr>
            </table>
          <?php $this->Form->end();?>
          </div>
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Name</th>
                  <th align="center" valign="top" scope="col">Processor </th>
                  <th align="center" valign="top" scope="col">Status </th>
                  <th align="center" valign="top" scope="col">Net Income($) </th>                 
                </tr>
                <?php 
                	foreach ($merchants as $merchant) { 
                		$preapp = $common->getManagerAmountProcessed($merchant['User']['id'], 2, $index );  
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td>
		                  <td align="center" valign="top"><?php echo $common->getProcessorNameById($merchant['Merchant']['processorID']); ?></td>
		                  <td align="center" valign="top"><?php echo $common->getStatusName($merchant['Merchant']['statusID']); ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commissionlog']['totalapps_income'],2); ?></td>
		                </tr>
               	 <?php }?>
               	<?php if(count($merchants)==0){?>
               	<tr><td align="center" valign="top" colspan="5">No Record Found</td></tr>
               	<?php } ?>
              </table>
            </div>
          </div>
          <div class="clear"></div>          
          <!-- display box / first --> 
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 