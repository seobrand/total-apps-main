<?php
 echo $this->Html->script('high_chart/highcharts.js');
 echo $this->Html->script('high_chart/highcharts-more.js');
 echo $this->Html->script('high_chart/exporting.js');
 ?>
<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb">Processors Monthly Processing Report</div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">  
        <?php if(!isset($totalincome)){?>
        <div class="news_indent"> 
          <?php echo $this->Form->create('Report');?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr height="35">
                <td width="10%" valign="top" align="left" style="padding:0px;">Select Date</td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('Month',array('type'=>'select','options'=>$monthoptions,'default'=>date('m'),'div'=>false,'label'=>false,'style'=>'width:290px;'));?>
	                 
				 </td>
				 <td width="10%" valign="top" align="right">Year</td>
                 <td width="30%" valign="top" style="padding:0px;"><?php echo $this->Form->input('Year',array('type'=>'select','options'=>$year,'default'=>date('y'),'div'=>false,'label'=>false,'style'=>'width:290px;'));?></td>
                 <td width="40%">&nbsp;</td>
              </tr>
              <tr height="35">
                <td width="10%" valign="top" align="left"><!--Processor--></td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php //echo $this->Form->input('Processor',array('type'=>'select','multiple'=>'multiple','options'=>$processorList,'div'=>false,'label'=>false,'style'=>'width:50%;'));?>
	             </td>
				 <td width="10%" valign="top" align="right">&nbsp</td>
                 <td width="20%" valign="top" style="padding:0px;">
                 <input type="submit" value="Search" class="cursorclass ui-state-default ui-corner-all" name="Submit"></td>
                 <td width="40%">&nbsp;</td>                 
              </tr>              
            </table>
          <?php $this->Form->end();?>
          </div>
          
          <div class="display_row padding_top_zero">
            <div class="table">
				<div id="linewrapper" style="float:left"></div>
				<?php echo $this->HighCharts->render('Line Chart'); ?>
				<div id="activelinewrapper" style="float:left"></div>
				<?php echo $this->HighCharts->render('Active Account Line Chart'); ?>
			</div>				
	      </div>                  
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
          <div class="breadcrumb">Sales Volume Summary</div>  
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Processor </th>
                  <?php foreach($previous_month as $monthtime){?>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y',$monthtime);?></th>
                  <?php }?>                  
                </tr>
                <?php                 	               	
	                $count = 0;
                	foreach ($processorList as $processorId => $processorName){
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $processorName; ?></td>
		                  <?php foreach($previous_month as $monthtime){?>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($salesvolume[$monthtime][$processorId],2);?></td>
		                  <?php } // end of month foreach?>                  
		                </tr>
               	 <?php $count++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="9">No record found</td></tr>
               	 <?php }?>            
                  <tr>
                  <td valign="top" align="center" class="blue"><strong>Total Volume</strong></td>
                  <?php foreach($total_monthly_salesvloume as $totalvol){?>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($totalvol,2); ?></strong></td>
                  <?php }?>
                </tr>                
              </table>
            </div>
          </div>
          <div class="clear"></div>
          <?php //pr($activeaccounts)?>
          <div class="breadcrumb">Active Accounts Summary</div>          
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Processor </th>
                  <?php foreach($previous_month as $monthtime){?>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y',$monthtime);?></th>
                  <?php }?>                  
                </tr>
                <?php                 	               	
	                $count = 0;
                	foreach ($processorList as $processorId => $processorName){
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $processorName; ?></td>
		                  <?php foreach($previous_month as $monthtime){?>
		                  <td align="center" valign="top"><?php echo $activeaccounts[$monthtime][$processorId];?></td>
		                  <?php } // end of month foreach?>                  
		                </tr>
               	 <?php $count++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="9">No record found</td></tr>
               	 <?php }?>            
                  <tr>
                  <td valign="top" align="center" class="blue"><strong>Total Volume</strong></td>
                   <?php foreach($previous_month as $monthtime){?>
                  <td valign="top" align="center" class="blue"><strong><?php echo array_sum($activeaccounts[$monthtime]); ?></strong></td>
                  <?php }?>
                </tr>                
              </table>
            </div>
          </div>
          <div class="clear"></div>
        <?php }else{?>
         <div class="breadcrumb">2nd Layer</div>          
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Processor </th>
                  <th align="center" valign="top" scope="col">Active Accounts </th>
                  <th align="center" valign="top" scope="col">Total Volume </th>
                  <th align="center" valign="top" scope="col">Total-apps Income </th>
                  <th align="center" valign="top" scope="col">Profit Ratio </th>      
                </tr>
                <?php                 	               	
	                $count = 0;
	                $total_profile_ratio = 0;
                	foreach ($processorList as $processorId => $processorName){
                		$profile_ratio = $totalincome[$processorId]/$salesvolume[$processorId];
                		//$total_profile_ratio += $profile_ratio;
						$total_profile_ratio = $profile_ratio;
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $processorName; ?></td>
		                  <td align="center" valign="top"><?php echo $activeaccounts[$processorId];?></td>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($salesvolume[$processorId],2);?></td>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($totalincome[$processorId],2);?></td>
		                  <td align="center" valign="top"><?php echo number_format($profile_ratio,2);?></td>
		                 </tr>
               	 <?php $count++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="9">No record found</td></tr>
               	 <?php }?>            
                  <tr>
                  <td valign="top" align="center" class="blue"><strong>Total Volume</strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $totalactiveaccounts; ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($totalsalesvolume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($totaltotalappsincome,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo number_format($total_profile_ratio,2); ?></strong></td>
                </tr>                
              </table>
            </div>
          </div>
          <div class="clear"></div>
        <?php }?>            
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
<script type="text/javascript">
jQuery.noConflict();
jQuery("#ReportProcessor").multiselect({});
</script>
