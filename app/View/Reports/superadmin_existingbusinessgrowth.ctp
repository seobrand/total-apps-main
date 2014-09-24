<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb">Existing Business Growth</div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">           
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Name </th>
                  <th align="center" valign="top" scope="col">Sales Volume&nbsp;<?php echo date('M - Y')?></th>
                  <th align="center" valign="top" scope="col">Sales Volume&nbsp;<?php echo date('M - Y', strtotime(date('Y-m')." -1 month"));?></th>
                  <th align="center" valign="top" scope="col">Sales Volume&nbsp;<?php echo date('M - Y', strtotime(date('Y-m')." -2 month"));?></th>
                  <th align="center" valign="top" scope="col">% of Growth</th>                 
                </tr>
                <?php 
                	$all_cur_month_volume = 0;
                	$all_pre_month_volume = 0;
                	$all_pre_to_pre_month_volume = 0;
	                $count = 0;
                	foreach ($merchants as $merchant) { 
                		$cur_month_volume = 0;
                		$pre_month_volume = 0;
                		$pre_to_pre_month_volume = 0;
                		$merchantTotal = 0;
                		if(count($merchant['Commissionlog'])>0){                			
                			foreach($merchant['Commissionlog'] as $commission){                				
                				if($commission['Commissionlog']['0']['month']==date('m')){
                					$cur_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -1 month"))){
                					$pre_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -2 month"))){
                					$pre_to_pre_month_volume += $commission['amount_processed'];
                				}
                			}
                			                		
                		$merchantTotal = $cur_month_volume + $pre_month_volume + $pre_to_pre_month_volume;  
                		$merchantTotalPercent = $merchantTotal/$allmerchantTotal*100;
                		
                		$all_cur_month_volume 			+= 	$cur_month_volume;
                		$all_pre_month_volume 			+= 	$pre_month_volume;
                		$all_pre_to_pre_month_volume 	+= 	$pre_to_pre_month_volume;
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($cur_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($pre_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($pre_to_pre_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo $this->Number->toPercentage($merchantTotalPercent)?></td>
		                </tr>
               	 <?php $count++; } // end of if condition                	
                  } // end of foreach loop
                  $all_cur_month_percentage 		= $all_cur_month_volume/$allmerchantTotal*100;
                  $all_pre_month_percentage 		= $all_pre_month_volume/$allmerchantTotal*100;
                  $all_pre_to_pre_month_percentage 	= $all_pre_to_pre_month_volume/$allmerchantTotal*100;
                  $all_total_percentage 			= $allmerchantTotal/$allmerchantTotal*100;
               	 ?>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="6">No record found</td></tr>
               	 <?php }?>            
                  <tr>
                  <td valign="top" align="center" class="blue" colspan="2"><strong>Total Volume </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($all_cur_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($all_pre_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($all_pre_to_pre_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($allmerchantTotal,2); ?></strong></td>
                </tr>
                <tr>
                  <td valign="top" align="center" class="blue" colspan="2"><strong>Total Percentage </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_cur_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_pre_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_pre_to_pre_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_total_percentage)?></strong></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="clear"></div>          
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 