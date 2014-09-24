<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div id="right2"> 
        <!-- table -->
        <?php if($processor=='meritcard'){?>
        <div class="box1">         
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
			<div class="breadcrumb">Meritcard Tier Report (Tier 1-100%) </div>
			<div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Actual Margin</th>
                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
                  <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
                  <th align="center" valign="top" scope="col">Net Income</th>                                 
                </tr>
                <?php
	                $count100 = 0;
                	foreach ($merchant_1_100 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check;                		
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>    
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td>
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count100++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count100==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?>
               	 </table>
               	 </div>
               	 <br/>
               	 <br/>
               	 <div class="breadcrumb">Meritcard Tier Report Tier 1.5 ( 85%) </div>
               	 <div class="table autoscroll">
	              <table width="100%" border="0" cellspacing="0" cellpadding="0">	              
	                <tr>
	                  <th align="center" valign="top" scope="col">MID</th>
	                  <th align="center" valign="top" scope="col">Customer</th>
	                  <th align="center" valign="top" scope="col">Processor</th>
	                  <th align="center" valign="top" scope="col">Sales Volume</th>
	                  <th align="center" valign="top" scope="col">Total-apps Income</th>
	                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
	                  <th align="center" valign="top" scope="col">Total Revenue</th> 
	                  <th align="center" valign="top" scope="col">Actual Margin</th>
	                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
	                  <th align="center" valign="top" scope="col">ISO Name</th>
	                  <th align="center" valign="top" scope="col">ISO % Split</th>
	                  <th align="center" valign="top" scope="col">ISO $ Split</th>
	                  <th align="center" valign="top" scope="col">Referral Name</th>
	                  <th align="center" valign="top" scope="col">Referral%Split</th>
	                  <th align="center" valign="top" scope="col">Agent Name</th>
	                  <th align="center" valign="top" scope="col">Agent% Split</th>
	                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
	                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
	                  <th align="center" valign="top" scope="col">Net Income</th>                                 
	                </tr>            
                 
                 <?php
	                $count85 = 0;
                	foreach ($merchant_1_85 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>    
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td>
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count85++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count85==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?>   
               	 </table>
               	 </div>  
               	 <br/>
               	 <br/>
	              <div class="breadcrumb">Meritcard Tier Report Tier 1.75 ( 70%)</div>
               	 <div class="table autoscroll">
	              <table width="100%" border="0" cellspacing="0" cellpadding="0">
	              <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Actual Margin</th>
                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
                  <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
                  <th align="center" valign="top" scope="col">Net Income</th>                                 
                </tr>  
                 <?php
	                $count70 = 0;
                	foreach ($merchant_1_70 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>    
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td>
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count70++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count70==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?> 
               	 </table>
               	 </div>
               	 <br/>
               	 <br/>
	             <div class="breadcrumb">Meritcard Tier Report Tier 2 ( 60%)</div>
               	 <div class="table autoscroll">
	             <table width="100%" border="0" cellspacing="0" cellpadding="0">           
                 <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Actual Margin</th>
                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
                  <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
                  <th align="center" valign="top" scope="col">Net Income</th>                                 
                </tr>  
                 <?php
	                $count60 = 0;
                	foreach ($merchant_1_60 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>    
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td>
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count60++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count60==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?>                
              </table>
              </div>
            </div>
		
          </div>
          <div class="clear"></div>          
        </div>
        <?php }?>
        <?php if($processor=='meritus'){?>
        <div class="box1">         
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
			<div class="breadcrumb">Meritus Tier Report (<= 5% Split) </div>
			<div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Actual Margin</th>
                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
                  <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
                  <th align="center" valign="top" scope="col">Net Income</th>                                 
                </tr>
                <?php
	                $count11_5 = 0;
                	foreach ($merchant_11_5 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>   
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td> 
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count11_5++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count11_5==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?>  
               	 </table>
               	 </div>
               	 <br/>
               	 <br/>
               	 <div class="breadcrumb"> Meritus Tier Report (50% Split) </div>	             
               	 <div class="table autoscroll">
	             <table width="100%" border="0" cellspacing="0" cellpadding="0">           
	                 <tr>
		                  <th align="center" valign="top" scope="col">MID</th>
		                  <th align="center" valign="top" scope="col">Customer</th>
		                  <th align="center" valign="top" scope="col">Processor</th>
		                  <th align="center" valign="top" scope="col">Sales Volume</th>
		                  <th align="center" valign="top" scope="col">Total-apps Income</th>
		                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
		                  <th align="center" valign="top" scope="col">Total Revenue</th> 
		                  <th align="center" valign="top" scope="col">Actual Margin</th>
		                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
		                  <th align="center" valign="top" scope="col">ISO Name</th>
		                  <th align="center" valign="top" scope="col">ISO % Split</th>
		                  <th align="center" valign="top" scope="col">ISO $ Split</th>
		                  <th align="center" valign="top" scope="col">Referral Name</th>
		                  <th align="center" valign="top" scope="col">Referral%Split</th>
		                  <th align="center" valign="top" scope="col">Agent Name</th>
		                  <th align="center" valign="top" scope="col">Agent% Split</th>
		                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
		                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
		                  <th align="center" valign="top" scope="col">Net Income</th>                                 
	                </tr> 
                 <?php
	                $count11_50 = 0;
                	foreach ($merchant_11_50 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>   
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td> 
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count11_50++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count11_50==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?>  
               	 </table>
               	 </div> 
               	 <br/>
               	 <br/>
               	 <div class="breadcrumb">Meritus Tier Report (70% Split)</div>
               	 <div class="table autoscroll">	              
	             <table width="100%" border="0" cellspacing="0" cellpadding="0">           
                 <tr>
	                  <th align="center" valign="top" scope="col">MID</th>
	                  <th align="center" valign="top" scope="col">Customer</th>
	                  <th align="center" valign="top" scope="col">Processor</th>
	                  <th align="center" valign="top" scope="col">Sales Volume</th>
	                  <th align="center" valign="top" scope="col">Total-apps Income</th>
	                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
	                  <th align="center" valign="top" scope="col">Total Revenue</th> 
	                  <th align="center" valign="top" scope="col">Actual Margin</th>
	                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
	                  <th align="center" valign="top" scope="col">ISO Name</th>
	                  <th align="center" valign="top" scope="col">ISO % Split</th>
	                  <th align="center" valign="top" scope="col">ISO $ Split</th>
	                  <th align="center" valign="top" scope="col">Referral Name</th>
	                  <th align="center" valign="top" scope="col">Referral%Split</th>
	                  <th align="center" valign="top" scope="col">Agent Name</th>
	                  <th align="center" valign="top" scope="col">Agent% Split</th>
	                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
	                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
	                  <th align="center" valign="top" scope="col">Net Income</th>                                 
                </tr>          
                 
                 <?php
	                $count11_70 = 0;
                	foreach ($merchant_11_70 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>   
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td> 
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count11_70++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count11_70==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?>    
              </table>
            </div>
		
          </div>
          <div class="clear"></div>          
        </div>
        <?php }?>
        <?php if($processor=='powerpay'){?>
        <div class="box1"> 
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
			<div class="breadcrumb">Powerpay Tier Report (15% Split) </div>
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Actual Margin</th>
                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
                  <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
                  <th align="center" valign="top" scope="col">Net Income</th>                                 
                </tr>
                <?php
	                $count21_15 = 0;
                	foreach ($merchant_21_15 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>   
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td> 
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count21_15++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count21_15==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?>   
               	 </table>
               	 </div>
               	 <br/>
               	 <br/>
               	 <div class="breadcrumb">Powerpay Tier Report ( 50% Split) </div>
               	 <div class="table autoscroll"> 
               	 <table width="100%" border="0" cellspacing="0" cellpadding="0">  
               	 <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Actual Margin</th>
                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
                  <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
                  <th align="center" valign="top" scope="col">Net Income</th>                                 
                </tr>
                 <?php
	                $count21_50 = 0;
                	foreach ($merchant_21_50 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>   
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td> 
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td> 
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count21_50++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count21_50==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?> 
               	 </table>
               	 </div>
               	 
               	 <br/>
               	 <br/>
               	 <div class="breadcrumb">Powerpay Tier Report ( 60% Split) </div>
               	 <div class="table autoscroll"> 
               	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
               	 <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                 <?php /*?><th align="center" valign="top" scope="col">Volume Approved</th>                 
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Actual Margin</th>
                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
                  <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th> */ ?>
                  <th align="center" valign="top" scope="col">ISO/Agent/Referral Commission</th>
                  <th align="center" valign="top" scope="col">Net Income</th>                                 
                </tr>
                 <?php
	                $count21_60 = 0;
                	foreach ($merchant_21_60 as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$check = $iso_split_margin + $referral_split_margin + $agent_split_margin;
                		$net_income = $merchant['Commissionlog']['totalapps_income'] - $check; 
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>  
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td>
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td>
		                  <?php /*?><td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td> */?>
		                  <td align="center" valign="top"><?php echo "$".number_format($check,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($net_income,2);?></td>                  
		                </tr>
               	 <?php $count21_60++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count21_60==0){?>   
               	 <tr><td align="center" valign="top" colspan="19">No record found</td></tr>
               	 <?php }?>    
              </table>
            </div>
		
          </div>
          <div class="clear"></div>          
        </div>
        <?php }?>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 

