<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb">Commission Report</div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">  
        <div class="news_indent"> 
          <?php echo $this->Form->create('Report',array('action'=>'commissionreportsearch','onsubmit'=> 'return SearchCommission(this)'));?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr height="35">
                <td width="10%" valign="top" align="left" style="padding:0px;">Select Date</td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('Month',array('type'=>'select','options'=>$monthoptions,'empty'=>'Select Month','div'=>false,'label'=>false,'style'=>'width:290px;'));?>
	             </td>
				 <td width="10%" valign="top" align="right">Year</td>
                 <td width="30%" valign="top" style="padding:0px;"><?php echo $this->Form->input('Year',array('type'=>'select','options'=>$year,'div'=>false,'label'=>false,'style'=>'width:290px;'));?></td>
                 <td width="40%">&nbsp;</td>
              </tr>
              <tr height="35">
                <td width="10%" valign="top" align="left">Agent</td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('agent',array('type'=>'select','multiple'=>'multiple','options'=>$agentList,'div'=>false,'label'=>false,'style'=>'width:50%;'));?>
	             </td>
				 <td width="10%" valign="top" align="right">ISO</td>
                 <td width="20%" valign="top" style="padding:0px;">
                 <?php echo $this->Form->input('iso',array('type'=>'select','multiple'=>'multiple','options'=>$isoList,'div'=>false,'label'=>false,'style'=>'width:50%;'));?></td>
                 <td width="40%">&nbsp;</td>                 
              </tr>
              <tr height="35">
                <td width="10%" valign="top" align="left">Referral</td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('referral',array('type'=>'select','multiple'=>'multiple','options'=>$referralList,'div'=>false,'label'=>false,'style'=>'width:50%;'));?>
	             </td>
				 <td valign="top" style="padding-left:110px;" colspan="3"><input type="submit" value="Search" class="cursorclass ui-state-default ui-corner-all" name="Submit"></td>                 
              </tr>
            </table>
          <?php $this->Form->end();?>
          </div>           
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
          <?php //########################### Shows layer 2 if agent,iso,and referral not selected ############ ?>
          <?php if(!isset($merchants) && !is_array($merchants)){?>
          
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Name </th>
                  <th align="center" valign="top" scope="col">Active Accounts</th>
                  <th align="center" valign="top" scope="col">Referral Split</th>
                  <th align="center" valign="top" scope="col">Agent Split</th>
                  <th align="center" valign="top" scope="col">ISO Split</th>
                  <th align="center" valign="top" scope="col">Total Commission</th>                                  
                </tr>
                <?php 
                	$total_active_account = 0;
	                $total_agent_commission = 0;
	                $total_referral_commission = 0;
	                $total_iso_commission = 0;
	                $grand_total_commission = 0;             	
	                $count = 0;
                	foreach ($users as $user){
                		$commission = $common->getUserCommissionBySearch($user['User']['id'],$searchmonth,$searchyear);
                		$active_account = $commission['0'];
                		$agent_commission = $commission['1'];
                		$referral_commission = $commission['2'];
                		$iso_commission = $commission['3'];
                		$total_commission = $commission['4'];
                		
                		$total_active_account		+= $active_account;
                		$total_agent_commission 	+= $agent_commission;
                		$total_referral_commission  += $referral_commission;
                		$total_iso_commission 		+= $iso_commission;
                		$grand_total_commission 	+= $total_commission;
                	?>
                		<?php if($active_account>0){?>
		                <tr>
		                  <td align="center" valign="top"><?php if($active_account>0){ echo $this->Html->link($user['User']['user_Name'],'commissionreportsearch/'.$user['User']['id'].'/'.$monthtime); }else{ echo $user['User']['user_Name'];}?></td>		                  
		                  <td align="center" valign="top"><?php echo $active_account; ?> </td> 
		                  <td align="center" valign="top"><?php echo "$ ".number_format($referral_commission,2);?> </td>  
		                  <td align="center" valign="top"><?php echo "$ ".number_format($agent_commission,2);?>  </td>  
		                  <td align="center" valign="top"><?php echo "$ ".number_format($iso_commission,2);?>  </td>  
		                  <td align="center" valign="top"><?php echo "$ ".number_format($total_commission,2);?>  </td>                  
		                </tr>
		                <?php }?>
               	 <?php $count++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="6">No record found</td></tr>
               	 <?php }?>            
                  <tr>
                  <td valign="top" align="center" class="blue"><strong>Total Volume </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $total_active_account; ?></strong></td>
                   <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_referral_commission,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_agent_commission,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_iso_commission,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($grand_total_commission,2); ?></strong></td>
                </tr>                
              </table>
            </div>
            <?php }else{?>
			<?php //############## Shows layer 3 if either agent or referral or iso is selected ######### ?> 
			
			<div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">MID</th>
                  <th align="center" valign="top" scope="col">Customer</th>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Volume Approved</th>
                  <th align="center" valign="top" scope="col">Sales Volume</th>
                  <th align="center" valign="top" scope="col">Total Revenue</th> 
                  <th align="center" valign="top" scope="col">Total-apps Income</th>
                  <th align="center" valign="top" scope="col">Actual Margin</th>
                  <th align="center" valign="top" scope="col">Total-Apps % Split</th>
                  <th align="center" valign="top" scope="col">ISO Name</th>
                  <th align="center" valign="top" scope="col">ISO % Split</th>
                  <th align="center" valign="top" scope="col">ISO $ Split</th>
                  <th align="center" valign="top" scope="col">Referral Name</th>
                  <th align="center" valign="top" scope="col">Referral%Split</th>
                  <th align="center" valign="top" scope="col">Referral $ Split</th>
                  <th align="center" valign="top" scope="col">Agent Name</th>
                  <th align="center" valign="top" scope="col">Agent% Split</th>
                  <th align="center" valign="top" scope="col">Agent $ Split</th>                                 
                </tr>
                <?php 
                	$total_volume_approved 		= 0;
	                $total_sales_volume 		= 0;
	                $total_total_revenue 		= 0;
	                $total_totalapps_income 	= 0;
	                $total_iso_split_margin 	= 0;
	                $total_agent_split_margin 	= 0;
	                $count = 0;
                	foreach ($merchants as $merchant){ 
                		$total_revenue = ($merchant['Commissionlog']['totalapps_income']/$merchant['Commission']['totalapps_split']*100);
                		
                		if($merchant['Commissionlog']['amount_processed']==0){
                			$actual_margin = "N/A";
                		}else{
                			$actual_margin = number_format(($merchant['Commissionlog']['totalapps_income']/$merchant['Commissionlog']['amount_processed']*100),2)."%";
                		}
                		                		
                		$iso_split_margin 	= $merchant['Commissionlog']['iso_commission'];
                		$agent_split_margin = $merchant['Commissionlog']['agent_commission'];                		
                		$referral_split_margin 	= $merchant['Commissionlog']['referral_commission'];
                		
                		$total_volume_approved			+= $merchant['Merchant']['volume'];
                		$total_sales_volume		 		+= $merchant['Commissionlog']['amount_processed'];
                		$total_total_revenue  			+= $total_revenue;
                		$total_totalapps_income			+= $merchant['Commissionlog']['totalapps_income'];
                		$total_iso_split_margin 		+= $iso_split_margin;
                		$total_agent_split_margin 		+= $agent_split_margin;
                		$total_referral_split_margin 	+= $referral_split_margin;
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>		                  
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td> 
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>  
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2);?></td>  
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['amount_processed'],2);?>  </td>  
		                  <td align="center" valign="top"><?php echo "$".number_format($total_revenue,2);?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Commissionlog']['totalapps_income'],2);?></td>
		                  <td align="center" valign="top"><?php echo $actual_margin;?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['totalapps_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo $merchant['ISO']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['iso_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($iso_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Referal']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['referral_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($referral_split_margin,2);?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Agent']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo number_format($merchant['Commission']['agent_split'],2)."%";?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($agent_split_margin,2);?></td>                  
		                </tr>
               	 <?php $count++;      	
                  } // end of foreach loop               
               	 ?>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="17">No record found</td></tr>
               	 <?php }?>            
                  <tr>
                  <td valign="top" align="center" class="blue" colspan="3"><strong>Total Volume </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_volume_approved,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_sales_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_total_revenue,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_totalapps_income,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_iso_split_margin,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_referral_split_margin,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong>&nbsp;</strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_agent_split_margin,2); ?></strong></td>
                </tr>                
              </table>
            </div>
			           
            <?php } ?>
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
jQuery("#ReportAgent").multiselect({});
jQuery("#ReportIso").multiselect({});
jQuery("#ReportReferral").multiselect({});

function SearchCommission(form){
	month = document.getElementById('ReportMonth').value;
	year  = document.getElementById('ReportYear').value;
	if(month=="" && year==""){
		alert('Please select date to serch commission');
		return false;
	}else if((month!="" && year=="") || (month=="" && year!="")){
		alert('Please select month and year both');
		return false;
	}else{
		return true;
	}
}
</script>
