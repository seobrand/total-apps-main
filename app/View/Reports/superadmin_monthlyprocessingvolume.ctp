<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb">Monthly Merchant processing volume</div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">  
        <div class="news_indent"> 
          <?php echo $this->Form->create('Report',array('action'=>'selectedmonthreport'));?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr height="35">
                <td width="10%" valign="top" align="left" style="padding:0px;">Select Date</td>
                 <td width="25%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('Month',array('type'=>'select','options'=>$monthoptions,'empty'=>'Select Month','div'=>false,'label'=>false,'style'=>'width:290px;'));?>
	              </td>
				 <td width="08%" valign="top" align="right">Year</td>
                 <td width="25%" valign="top" style="padding:0px;"><?php echo $this->Form->input('Year',array('type'=>'select','options'=>$year,'empty'=>'Select Year','div'=>false,'label'=>false,'style'=>'width:290px;'));?></td>
                 <td width="35%" valign="top" style="padding-left:25px;"><input type="submit" value="Search" class="cursorclass ui-state-default ui-corner-all" name="Submit"></td>
              </tr>
              <tr height="35">
                <td valign="top" align="left">Processor</td>
                 <td  valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('Processor',array('type'=>'select','multiple'=>'multiple','options'=>$procList,'div'=>false,'label'=>false,'style'=>'width:290px;'));?>
	             </td>
				 <td valign="top" align="right">Manager</td>
                 <td valign="top" style="padding:0px;"><?php echo $this->Form->input('Manager',array('type'=>'select','multiple'=>'multiple','options'=>$mangList,'div'=>false,'label'=>false,'style'=>'width:90%;'));?></td>
                 <td valign="top" align="left">&nbsp;</td>                 
              </tr>
            </table>
          <?php $this->Form->end();?>
          </div>           
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Name </th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Manager </th>
                  <th align="center" valign="top" scope="col">Approved Volume</th>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y')?></th>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y', strtotime(date('Y-m')." -1 month"));?></th>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y', strtotime(date('Y-m')." -2 month"));?></th>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y', strtotime(date('Y-m')." -3 month"));?></th>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y', strtotime(date('Y-m')." -4 month"));?></th>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y', strtotime(date('Y-m')." -5 month"));?></th>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y', strtotime(date('Y-m')." -6 month"));?></th>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y', strtotime(date('Y-m')." -7 month"));?></th>
                </tr>
                <?php 
                	$all_cur_month_volume = 0;
                	$all_pre_month_volume = 0;
                	$all_pre_to_pre_month_volume = 0;
	                $count = 0;
	                $total_approved_volume = 0;
                	foreach ($merchants as $merchant) { 
                		$first_month_volume = 0;
	                	$second_month_volume = 0;
	                	$third_month_volume = 0;
	                	$fourth_month_volume = 0;
	                	$fifth_month_volume = 0;
	                	$sixth_month_volume = 0;
	                	$seven_month_volume = 0;
	                	$eight_month_volume = 0;
                		$merchantTotal = 0;
                		
                		if(count($merchant['Commissionlog'])>0){                			
                			foreach($merchant['Commissionlog'] as $commission){                				
                				if($commission['Commissionlog']['0']['month']==date('m')){
                					$first_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -1 month"))){
                					$second_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -2 month"))){
                					$third_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -3 month"))){
                					$fourth_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -4 month"))){
                					$fifth_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -5 month"))){
                					$sixth_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -6 month"))){
                					$seven_month_volume += $commission['amount_processed'];
                				}
                				if($commission['Commissionlog']['0']['month']==date('m', strtotime(date('Y-m')." -7 month"))){
                					$eight_month_volume += $commission['amount_processed'];
                				}
                			}
                		$total_approved_volume += $merchant['Merchant']['volume'];
                		$merchantTotal = $first_month_volume + $second_month_volume + $third_month_volume + $fourth_month_volume + $fifth_month_volume + $sixth_month_volume + $seven_month_volume + $eight_month_volume;  
                		/* $merchantTotalPercent = $merchantTotal/$allmerchantTotal*100; */
                		
                		$all_first_month_volume 	+= 	$first_month_volume;
                		$all_second_month_volume 	+= 	$second_month_volume;
                		$all_third_month_volume 	+= 	$third_month_volume;
                		$all_fourth_month_volume 	+= 	$fourth_month_volume;
                		$all_fifth_month_volume 	+= 	$fifth_month_volume;
                		$all_sixth_month_volume 	+= 	$sixth_month_volume;
                		$all_seven_month_volume 	+= 	$seven_month_volume;
                		$all_eight_month_volume 	+= 	$eight_month_volume;
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Manager']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2); ?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($first_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($second_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($third_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($fourth_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($fifth_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($sixth_month_volume,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($seven_month_volume,2);?></td>		                  
		                  <td align="center" valign="top"><?php echo "$".number_format($eight_month_volume,2);?></td>		                  
		                </tr>
               	 <?php $count++; } // end of if condition                	
                  } // end of foreach loop
                  /* $all_first_month_percentage 		= $all_first_month_volume/$allmerchantTotal*100;
                  $all_second_month_percentage 		= $all_second_month_volume/$allmerchantTotal*100;
                  $all_third_month_percentage 		= $all_third_month_volume/$allmerchantTotal*100;
                  $all_fourth_month_percentage 		= $all_fourth_month_volume/$allmerchantTotal*100;
                  $all_fifth_month_percentage 		= $all_fifth_month_volume/$allmerchantTotal*100;
                  $all_sixth_month_percentage 		= $all_sixth_month_volume/$allmerchantTotal*100;
                  $all_seven_month_percentage 		= $all_seven_month_volume/$allmerchantTotal*100;
                  $all_eight_month_percentage 		= $all_eight_month_volume/$allmerchantTotal*100;
                  $all_total_percentage 			= $allmerchantTotal/$allmerchantTotal*100; */
               	 ?>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="6">No record found</td></tr>
               	 <?php }?>            
                  <tr>
                  <td valign="top" align="center" class="blue" colspan="4"><strong>Total Volume </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_approved_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_first_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_second_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_third_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_fourth_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_fifth_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_sixth_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_seven_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_eight_month_volume,2); ?></strong></td>
                </tr>
                <?php /*?><tr>
                  <td valign="top" align="center" class="blue" colspan="2"><strong>Total Percentage </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_first_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_second_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_third_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_fourth_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_fourth_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_fourth_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_fourth_month_percentage)?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $this->Number->toPercentage($all_fourth_month_percentage)?></strong></td>
                </tr><?php */ ?>
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
<script type="text/javascript">
jQuery.noConflict();
jQuery("#ReportProcessor").multiselect({});
jQuery("#ReportManager").multiselect({});
</script>