<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
  <div class="box1">
  	<div class="news_indent"> 
          <?php echo $this->Form->create('Report');?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr height="35">
                <td width="10%" valign="top" align="center" style="padding:0px;"><span style="font:14px arial;">Select Processor:</span></td>
                 <td width="15%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('userID',array('type'=>'select','multiple'=>'multiple','options'=>$processorlist,'div'=>false,'label'=>false,'style'=>'width:90%;'));?>
	             </td>
				 <td width="32%" valign="top" style="padding:0px;">&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="cursorclass ui-state-default ui-corner-all" name="Submit"></td>
               </tr>
              <tr height="35">
                <td width="10%" valign="top" align="center"><span style="font:14px arial;">Select Status:</span></td>
                 <td width="10%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('status',array('type'=>'select','multiple'=>'multiple','options'=>array('2'=>'Pre-App','3'=>'Incomplete','4'=>'Pending','9'=>'Integrating','5'=>'Processing'),'div'=>false,'label'=>false,'style'=>'width:90%;'));?>
	             </td>
				 <td width="03%" valign="top" align="left">&nbsp;</td>               
              </tr>
            </table>
          <?php $this->Form->end();?>
    </div> 
  </div>
    <div class="box">    
      <!--<div class="breadcrumb">Volume By Processor</div>-->
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- display box / first -->
	  <?php /*
          <div class="display_row padding_top_zero">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Processor </th>
                  <?php foreach($statusarray as $status){?>
                  <th align="center" valign="top" scope="col"><?php echo $common->getStatusName($status);?> </th>
                  <?php }?>
                  <th align="center" valign="top" scope="col">Total </th>
                  <th align="center" valign="top" scope="col">Percent</th>
                </tr>
                <?php 
                	$index = 0;
                	$preappTotal = 0;
                	$incompleteTotal = 0;
                	$pendingTotal = 0;
                	$integratingTotal = 0;
                	$processingTotal = 0;              	
                	$totalTotal = 0;
	                
                	foreach ($isos as $iso) { 
                		foreach($statusarray as $status){
                			if($status==2){
                				$preapp = $common->getProcessorVolume($iso['User']['id'], 2, $index );
                				$preappTotal += $preapp;
                			}elseif($status==3){
                				$incomplete = $common->getProcessorVolume($iso['User']['id'], 3, $index);
                				$incompleteTotal += $incomplete;
                			}elseif($status==4){
                				$pending = $common->getProcessorVolume($iso['User']['id'], 4, $index );
                				$pendingTotal += $pending;
                			}elseif($status==5){
                				$processing = $common->getProcessorVolume($iso['User']['id'], 5, $index );
                				$processingTotal += $processing;
                			}elseif($status==9){
                				$integrating = $common->getProcessorVolume($iso['User']['id'], 9, $index );
                				$integratingTotal += $integrating;
                			}
                		}                		
                		$total = $preapp + $incomplete + $pending + $integrating + $processing ;
                		$totalTotal += $total;
                	
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $iso['User']['user_Name']; ?></td>
		                  <?php foreach($statusarray as $status){
			                  	if($status==2){
			                  		echo '<td align="center" valign="top">$ '.number_format($preapp,2).'</td>';
			                  	}elseif($status==3){
			                  		echo '<td align="center" valign="top">$ '.number_format($incomplete,2).'</td>';
			                  	}elseif($status==4){
			                  		echo '<td align="center" valign="top">$ '.number_format($pending,2).'</td>';
			                  	}elseif($status==5){
			                  		echo '<td align="center" valign="top">$ '.number_format($processing,2).'</td>';
			                  	}elseif($status==9){
			                  		echo '<td align="center" valign="top">$ '.number_format($integrating,2).'</td>';
			                  	}
                			} ?>		                  
		                  <td align="center" valign="top"><?php echo "$ ".number_format($total,2); ?></td>
		                  <td align="center" valign="top"><?php echo number_format((($total/$grandTotal)*100),2) . "%"; ?></td>
		                </tr>
               	 <?php }?>
                  
                  <tr>
                  <td valign="top" align="left" class="blue"><strong>TOTALS </strong></td>
                   <?php foreach($statusarray as $status){
			                  	if($status==2){
			                  		echo '<td valign="top" align="center" class="blue"><strong>$ '.number_format($preappTotal,2).'</strong></td>';
			                  	}elseif($status==3){
			                  		echo '<td valign="top" align="center" class="blue"><strong>$ '.number_format($incompleteTotal,2).'</strong></td>';
			                  	}elseif($status==4){
			                  		echo '<td valign="top" align="center" class="blue"><strong>$ '.number_format($pendingTotal,2).'</strong></td>';
			                  	}elseif($status==5){
			                  		echo '<td valign="top" align="center" class="blue"><strong>$ '.number_format($processingTotal,2).'</strong></td>';
			                  	}elseif($status==9){
			                  		echo '<td valign="top" align="center" class="blue"><strong>$ '.number_format($integratingTotal,2).'</strong></td>';
			                  	}
                	} ?>      
                  <td valign="top" align="center" class="blue"><strong><?php echo "$ ".number_format($totalTotal,2); ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo round(($totalTotal/$grandTotal)*100) . "%"; ?></strong></td>
                </tr>
              </table>
            </div>
          </div>
	  <?php */ ?>
          <div class="clear"></div>
          
          <!-- display box / first --> 
          
           <!-- display box / first -->
           <div class="breadcrumb">Active Accounts By Processor</div>
          <div class="display_row padding_top_zero">
            <div class="table table_scroll_autoy">
              <table width="101%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">Processor </th>
                  <?php foreach($statusarray as $status){?>
                  <th align="center" valign="top" scope="col"><?php echo $common->getStatusName($status);?> </th>
                  <?php }?>
                  <th align="center" valign="top" scope="col">Total </th>
                  <th align="center" valign="top" scope="col">Percent</th>
                </tr>
                <?php 
                	$index = 1;
                	$preappTotal = 0;
                	$incompleteTotal = 0;
                	$pendingTotal = 0;
                	$integratingTotal = 0;
                	$processingTotal = 0;
                	$totalTotal = 0;
	                
                	foreach ($isos as $iso) { 
                		foreach($statusarray as $status){
                			if($status==2){
                				$preapp = $common->getProcessorVolume($iso['User']['id'], 2, $index );
                				$preappTotal += $preapp;
                			}elseif($status==3){
                				$incomplete = $common->getProcessorVolume($iso['User']['id'], 3, $index);
                				$incompleteTotal += $incomplete;
                			}elseif($status==4){
                				$pending = $common->getProcessorVolume($iso['User']['id'], 4, $index );
                				$pendingTotal += $pending;
                			}elseif($status==5){
                				$processing = $common->getProcessorVolume($iso['User']['id'], 5, $index );
                				$processingTotal += $processing;
                			}elseif($status==9){
                				$integrating = $common->getProcessorVolume($iso['User']['id'], 9, $index );
                				$integratingTotal += $integrating;
                			}
                		}      
                		$total = $preapp + $incomplete + $pending + $integrating + $processing ;
                		$totalTotal += $total;
                	
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $iso['User']['user_Name']; ?></td>
		                  <?php foreach($statusarray as $status){
			                  	if($status==2){
			                  		echo '<td align="center" valign="top">'.$preapp.'</td>';
			                  	}elseif($status==3){
			                  		echo '<td align="center" valign="top">'.$incomplete.'</td>';
			                  	}elseif($status==4){
			                  		echo '<td align="center" valign="top">'.$pending.'</td>';
			                  	}elseif($status==5){
			                  		echo '<td align="center" valign="top">'.$processing.'</td>';
			                  	}elseif($status==9){
			                  		echo '<td align="center" valign="top">'.$integrating.'</td>';
			                  	}
                			} ?>
		                  <td align="center" valign="top"><?php echo $total; ?></td>
		                  <td align="center" valign="top"><?php echo number_format((($total/$countTotal)*100),2) . "%"; ?></td>
		                </tr>
               	 <?php }?>
                  
                  <tr>
                  <td valign="top" align="left" class="blue"><strong>TOTALS </strong></td>
                   <?php foreach($statusarray as $status){
	                  	if($status==2){
	                  		echo '<td valign="top" align="center" class="blue"><strong>'.$preappTotal.'</strong></td>';
	                  	}elseif($status==3){
	                  		echo '<td valign="top" align="center" class="blue"><strong>'.$incompleteTotal.'</strong></td>';
	                  	}elseif($status==4){
	                  		echo '<td valign="top" align="center" class="blue"><strong>'.$pendingTotal.'</strong></td>';
	                  	}elseif($status==5){
	                  		echo '<td valign="top" align="center" class="blue"><strong>'.$processingTotal.'</strong></td>';
	                  	}elseif($status==9){
	                  		echo '<td valign="top" align="center" class="blue"><strong>'.$integratingTotal.'</strong></td>';
	                  	}
                	} ?>                  
                  <td valign="top" align="center" class="blue"><strong><?php echo $totalTotal; ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo round(($totalTotal/$countTotal)*100) . "%"; ?></strong></td>
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
<script type="text/javascript">
jQuery.noConflict();
jQuery("#ReportUserID").multiselect({});
jQuery("#ReportStatus").multiselect({});
</script>