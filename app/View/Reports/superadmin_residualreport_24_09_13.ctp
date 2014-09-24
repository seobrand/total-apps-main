<?php
 echo $this->Html->script('high_chart/highcharts.js');
 echo $this->Html->script('high_chart/highcharts-more.js');
 echo $this->Html->script('high_chart/exporting.js');
 echo $this->Html->script('table_sorter/jquery.tablesorter.js');
 ?>
<script type="text/javascript">
 jq = jQuery.noConflict();
 jq(document).ready(function() 
 { 
	 jq("#residualReport2").tablesorter(); 
 } 
); 
</script>

<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb">Residual Report</div>
      <div id="right2"> 
        <!-- table -->
        <?php if(!isset($merchants)){?>
        <div class="box1">
		  <div class="news_indent"> 
          <?php echo $this->Form->create('Report');?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr height="35">
                <td width="10%" valign="top" align="left" style="padding:0px;">Select Date</td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('Month',array('type'=>'select','options'=>$monthoptions,'default'=>date('m'),'div'=>false,'label'=>false,'style'=>'width:290px;'));?>
	              </td>
				 <td width="10%" valign="top" align="right">Year</td>
                 <td width="30%" valign="top" style="padding:0px;"><?php echo $this->Form->input('Year',array('type'=>'select','options'=>$year,'default'=>date('Y'),'div'=>false,'label'=>false,'style'=>'width:290px;'));?></td>
                 <td width="40%" valign="top" style="padding:0px;"><input type="submit" value="Search" class="cursorclass ui-state-default ui-corner-all" name="Submit"></td>
              </tr>
            </table>
          <?php $this->Form->end();?>
          </div>     
		  </div>
		<div class="box1">  
			<div class="display_row padding_top_zero">
	            <div class="table">
	            	<div id="columnwrapper" style="float:left"></div>
					<?php echo $this->HighCharts->render('Column Chart'); ?>
					<div id="volumewrapper" style="float:left"></div>
					<?php echo $this->HighCharts->render('Volume Chart'); ?>
					<div id="incomewrapper" style="float:left"></div>
					<?php echo $this->HighCharts->render('Net Income Chart'); ?>
				</div>				
	         </div>
		</div>
		
        <div class="box1">           
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Date</th>
                  <th align="center" valign="top" scope="col">Active Accounts</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Net Income</th>
                </tr>
                <?php foreach ($month_report as $key => $report){ 
                		$totalapps_income  = $report['4'];
                		$check = $report['1'] + $report['2'] + $report['3'];
                		$net_income = $totalapps_income - $check;
                	?> <tr>
		                  <td align="center" valign="top"><strong><?php echo $this->Html->link(date('M/y',$key),'residualreport/'.$key); ?></strong></td>
		                  <td align="center" valign="top"><?php echo $report['0'];?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($report['5'],2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>
		                </tr>
               	 <?php }?>
              </table>
            </div>
          </div>
          <div class="clear"></div>
          <!-- display box / first --> 
        </div>
        <?php }else{?>
        <div class="box1">                     
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table autoscroll">
              <table id="residualReport2" class="tablesorter" width="100%" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Volume Approved</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
		  		  <th align="center" valign="top" scope="col">Number of Transactions</th>
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                  <th align="center" valign="top" scope="col">Actual Margin</th>
		  
                  <!--<th align="center" valign="top" scope="col">Total-Apps % Split</th>-->
                  <!-- <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th> -->
                  <th align="center" valign="top" scope="col">Agent/Referral/ISO Commission</th>
                  <th align="center" valign="top" scope="col">Residual</th>                                 
                </tr>
               </thead>
               <tbody>
                <?php
	                $count = 0;
	                $total_vol_approved	 = 0;
	                $total_sales_volume	 = 0;
	                $total_total_revenue = 0;
	                $total_totalapp_income = 0;
	                $total_iso_commission = 0;
	                $total_agent_commission = 0;
	                $total_check_volume = 0;
	                $total_net_income = 0;
	                $total_residual_income = 0;
                	foreach ($merchants as $merchant){
						$total_revenue='';
						if($merchant['Commission']['totalapps_split']){ 
                		$total_revenue = ($merchant['0']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
						}
                		if($merchant['0']['amount_processed']==0){
                			$actual_margin = "-"; //"N/A";
                		}else{
                			$actual_margin = number_format(($merchant['0']['totalapps_income']/$merchant['0']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['0']['iso_commission'];
                		$agent_split_margin = $merchant['0']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['0']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['0']['totalapps_income'] - $check;
                		//$residual_income  =  ($merchant['0']['gross_revenue']*$merchant['Commission']['totalapps_split']/100) - $check;
						$residual_income = $net_income;
                		// get the grand total values
                		$total_vol_approved 	+= $merchant['Merchant']['volume'];
                		$total_sales_volume 	+= $merchant['0']['amount_processed'];
                		$total_total_revenue 	+= $total_revenue;
                		$total_totalapp_income 	+= $merchant['0']['totalapps_income'];
                		$total_iso_commission 	+= $iso_split_margin;
                		$total_agent_commission += $agent_split_margin;
                		$total_check_volume 	+= $check;
                		$total_net_income 		+= $net_income;
                		$total_residual_income 	+= $residual_income;
                		
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $this->Html->link($merchant['Merchant']['CID'],array('controller' => 'merchants', 'action' => 'edit', $merchant['Merchant']['id'])); ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>  
		                  <td align="center" valign="top"><?php echo "$".$merchant['Merchant']['volume'];?></td>  
		                  <td align="center" valign="top"><?php echo "$".$merchant['0']['amount_processed'];?>  </td>
				  		  <td align="center" valign="top"><?php echo $merchant['Commissionlog']['transaction_numbers'];?></td>
		                  <td align="center" valign="top"><?php echo "$".$total_revenue;?></td>
		                  <td align="center" valign="top"><?php echo "$".$merchant['0']['totalapps_income'];?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
				  
		                  <!-- <td align="center" valign="top"><?php echo $merchant['Commission']['totalapps_split']."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td>  -->
		                  <td align="center" valign="top"><?php echo "$".$check;?></td>
		                  <!-- <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td> --> 
		                  <td align="center" valign="top"><?php echo "$".$residual_income.".00";?></td>                  
		                </tr>
               	 <?php $count++;      	
                  } // end of foreach loop               
               	 ?>
               	 </tbody>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?> 
               	 <tr>
                  <td valign="top" align="center" class="blue"><strong>Total</strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo number_format($total_vol_approved,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($total_sales_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($total_total_revenue,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($total_totalapp_income,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong></strong></td>
                  <td valign="top" align="center" class="blue"><strong></strong></td>
                  <!-- <td valign="top" align="center" class="blue"><strong></strong></td>
                  <td valign="top" align="center" class="blue"><strong></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($total_iso_commission,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong></strong></td>
                  <td valign="top" align="center" class="blue"><strong></strong></td>
                  <td valign="top" align="center" class="blue"><strong></strong></td>
                  <td valign="top" align="center" class="blue"><strong></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($total_agent_commission,2); ?></strong></td> -->
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($total_check_volume,2); ?></strong></td>
                  <!-- <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($total_net_income,2); ?></strong></td> -->
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($total_residual_income,2); ?></strong></td>
                </tr>                     
              </table>
             </div>
          </div>
          <div class="clear"></div>
          <!-- display box / first --> 
        </div>
        <?php } ?>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
<script type="text/javascript">
jQuery.noConflict();
jQuery("#ReportUserID").multiselect({});
jQuery("#ReportStatus").multiselect({});
</script>