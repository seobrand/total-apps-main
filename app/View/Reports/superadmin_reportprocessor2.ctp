<?php $processorID = array();?>
<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col"> Bank</th>
                  <?php foreach($processorSet as $processor){?>
                  <th align="center" valign="top" scope="col"> <?php echo $processor['User']['user_Name']; ?></th>
                  <?php }//end of foreach ?>
                </tr>
                <tr>
                  <td align="center" valign="top"> ACH/CC/DD/Debit</td>
                  <?php foreach($processorSet as $processor){?>
                  <td align="center" valign="top"><?php echo $processor['User']['processorPayMethod'];?></td>
                  <?php }?>
                </tr>
                <tr>
                  <td align="center" valign="top"> Domestic/Offshore</td>
                  <?php foreach($processorSet as $processor){?>
	                  <?php if(strlen($processor['User']['processorOnShore'])>0){?>
	                  	<?php if($processor['User']['processorOnShore']=="0"){?>
	                  		<td align="center" valign="top">OS</td>
	                  	<?php }else{?>
	                  		<td align="center" valign="top">D</td>
	                  	<?php }?>
	                  <?php }else{?>
	                  	<td align="center" valign="top">OS</td>
	                  <?php }?>                 
                  <?php }//end foreach?>
                </tr>
                <tr>
                  <td align="center" valign="top"> Minimum Volume</td>
                  <?php foreach($processorSet as $processor){?>
                  	<?php if($processor['User']['processorMinAmount']==null){?>
                  		<td align="center" valign="top"><?php echo $this->Number->currency(0,'USD');?></td>
                  	<?php }else{?>	
                  		<td align="center" valign="top"><?php echo $this->Number->currency($processor['User']['processorMinAmount'],'USD');?></td>
                  	<?php }?>
                  <?php }?>
                </tr>
                <tr>
                <td colspan="71">&nbsp;</td>
                </tr>
                 <tr>
                  <th align="center" valign="top" scope="col"> Bank</th>
                  <?php foreach($processorSet as $processor){?>
                   <th align="center" valign="top" scope="col"> <?php echo $processor['User']['user_Name'];?></th>
                  <?php }?>
                </tr>
                <?php foreach($accType_list as $accountTypes){?>
                <tr>                
                  <td align="center" valign="top"> <?php echo $accountTypes['Accounttype']['accountType'];?></td>
                  <?php foreach($processorSet as $processor){?>
                  <td align="center" valign="top"><?php echo $common->getProcessorBusinessType($processor['User']['id'],$accountTypes['Accounttype']['id'])?></td>
                  <?php }?>
                </tr>
                <?php }?>                
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