<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb">Monthly Merchant processing volume</div>
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
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Manager </th>
                  <th align="center" valign="top" scope="col">Approved Volume</th>
                  <th align="center" valign="top" scope="col"><?php echo date("M - Y",strtotime($year."-".$month));?></th>                  
                </tr>
                <?php 
                	$all_month_volume = 0;                	
	                $count = 0;
	                $total_approved_volume = 0;
                	foreach ($merchants as $merchant) { 
                		$month_volume = 0;	                	
                		$merchantTotal = 0;
                		
	                		$total_approved_volume += $merchant['Merchant']['volume'];
	                		$merchantTotal = $merchant[0]['amount_processed'];
	                		$all_month_volume 	+= 	$merchantTotal;
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['CID']; ?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Merchant']['merchantDBA']; ?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Processor']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo $merchant['Manager']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($merchant['Merchant']['volume'],2); ?></td>
		                  <td align="center" valign="top"><?php echo "$".number_format($merchantTotal,2);?></td>		                  		                  
		                </tr>
               	 <?php $count++; // end of if condition                	
                  } // end of foreach loop                 
               	 ?>   
               	 <?php if($count==0){?>   
               	 <tr><td align="center" valign="top" colspan="6">No record found</td></tr>
               	 <?php }?>            
                  <tr>
                  <td valign="top" align="center" class="blue" colspan="4"><strong>Total Volume </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($total_approved_volume,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$".number_format($all_month_volume,2); ?></strong></td>
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
