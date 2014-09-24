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
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Processor</th>
                  <th align="center" valign="top" scope="col">Pre-App</th>
                  <th align="center" valign="top" scope="col">Incomplete</th>
                  <th align="center" valign="top" scope="col">Pending</th>
                  <th align="center" valign="top" scope="col">Integrating</th>
                  <th align="center" valign="top" scope="col">Processing</th>
                  <th align="center" valign="top" scope="col">Total</th>
                  <th align="center" valign="top" scope="col">Percent</th>
                </tr>
                <?php 
                	$preappTotal = 0;
                	$incompleteTotal = 0;
                	$pendingTotal = 0;
                	$integratingTotal = 0;
                	$processingTotal = 0;
                	$totalTotal = 0;
	                
                	foreach ($processors as $processor) { 
                		$preapp = $common->getProcessorSetupFee($processor['User']['id'], 2 );
                		$preappTotal += $preapp;
                		$incomplete = $common->getProcessorSetupFee($processor['User']['id'], 3);
                		$incompleteTotal += $incomplete;
                		$pending = $common->getProcessorSetupFee($processor['User']['id'], 4 );
                		$pendingTotal += $pending;
                		$integrating = $common->getProcessorSetupFee($processor['User']['id'], 9 );
                		$integratingTotal += $integrating;
                		$processing = $common->getProcessorSetupFee($processor['User']['id'], 5 );
                		$processingTotal += $processing;
                		$total = $preapp + $incomplete + $pending + $integrating + $processing ;
                		$totalTotal += $total;
                	
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $processor['User']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($preapp,2); ?></td>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($incomplete,2); ?></td>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($pending,2); ?></td>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($integrating,2); ?></td>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($processing,2); ?></td>
		                  <td align="center" valign="top"><?php echo "$ ".number_format($total,2); ?></td>
		                  <td align="center" valign="top"><?php echo number_format((($total/$grandTotal)*100),2) . "%"; ?></td>
		                </tr>
               	 <?php }?>
                  
                  <tr>
                  <td valign="top" align="left" class="blue"><strong>TOTALS </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($preappTotal,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($incompleteTotal,2); ?> </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($pendingTotal,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($integratingTotal,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($processingTotal,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($totalTotal,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo round(($totalTotal/$grandTotal)*100) . "%"; ?></strong></td>
                </tr>
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