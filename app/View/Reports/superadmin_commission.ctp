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
                 <td width="30%" valign="top" style="padding:0px;"><?php echo $this->Form->input('Year',array('type'=>'select','options'=>$year,'empty'=>'Select Year','div'=>false,'label'=>false,'style'=>'width:290px;'));?></td>
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
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Name </th>
                  <?php foreach($previous_month as $monthtime){?>
                  <th align="center" valign="top" scope="col"><?php echo date('M - Y',$monthtime);?></th>
                  <?php }?>                  
                </tr>
                <?php 
                	$all_first_month_volume = 0;
	                $all_second_month_volume = 0;
	                $all_third_month_volume = 0;
	                $all_fourth_month_volume = 0;
	                $all_fifth_month_volume = 0;
	                $all_sixth_month_volume = 0;
	                $all_seven_month_volume = 0;
	                $all_eight_month_volume = 0;                	
	                $count = 0;
	                foreach($previous_month as $key => $monthtime){
                			$monthvol[] = $common->getUserCommissionByMonth($userIdList,$monthtime);
                	}
                	 
                	// Fetch All user list for all months
                    $monthvol = array_filter($monthvol);
                    // ticket id 2060 
                    foreach($monthvol as $key=>$months_commission):
                      foreach($months_commission as $monthtime=>$user_commission):
                          foreach($user_commission as $user =>$commission_val):
                            $userids[] = $user;                       
                       	  endforeach;
                       	  $data[$monthtime] = $user_commission;
                       endforeach;
                    endforeach; // lopp for formating the required array for print listing
                        
                  	$user_with_commmission = array_unique($userids);
                        
                	foreach ($users as $user){ ?>
                		<?php if(in_array($user['User']['id'],$user_with_commmission)){?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $user['User']['user_Name']; ?></td>
		                  <?php foreach($previous_month as $key => $monthtime){?>
			                  <td align="center" valign="top">		                  
			                  <?php if($key==0){
			                  			$all_first_month_volume 	+= 	$data[$monthtime][$user['User']['id']];
			                  		}elseif($key==1){
			                  			$all_second_month_volume 	+= 	$data[$monthtime][$user['User']['id']];
			                  		}elseif($key==2){
			                  			$all_third_month_volume 	+= 	$data[$monthtime][$user['User']['id']];
			                  		}elseif($key==3){
			                  			$all_fourth_month_volume 	+= 	$data[$monthtime][$user['User']['id']];
		                  			}elseif($key==4){
		                  				$all_fifth_month_volume 	+= 	$data[$monthtime][$user['User']['id']];
		                  			}elseif($key==5){
		                  				$all_sixth_month_volume 	+= 	$data[$monthtime][$user['User']['id']];
		                  			}elseif($key==6){
		                  				$all_seven_month_volume 	+= 	$data[$monthtime][$user['User']['id']];
	                  				}elseif($key==7){
	                  					$all_eight_month_volume 	+= 	$data[$monthtime][$user['User']['id']];
	                  				}		                  
			                  ?>
			                  <?php if(!empty($data[$monthtime][$user['User']['id']])){ echo "$ ".number_format($data[$monthtime][$user['User']['id']],2);}else{ echo "N/A"; }?>
			                 </td>   
			              <?php } // end of month foreach?>               
		                </tr>
		                <?php $count++; }?>
               	 <?php } // end of foreach loop  ?>  
               	  
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="9">No processing accounts found for either ISO, Agent or referral for the past 8 months.</td></tr>
               	 <?php }?> 
               	            
                  <tr>
                  <td valign="top" align="center" class="blue"><strong>Total Volume </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_first_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_second_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_third_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_fourth_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_fifth_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_sixth_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_seven_month_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_eight_month_volume,2); ?></strong></td>
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
