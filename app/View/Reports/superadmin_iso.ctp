<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
  <?php /* task id 2579 point#7 by jitendra on 29 Nov 2013 ?>
  <div class="box1">
  	<div class="news_indent"> 
          <?php echo $this->Form->create('Report',array('action'=>'accsearchbyiso'));?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr height="35">
                <td width="10%" valign="top" align="center" style="padding:0px;"><span style="font:14px arial;">Select ISO:</span></td>
                 <td width="15%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('userID',array('type'=>'select','multiple'=>'multiple','options'=>$isolist,'div'=>false,'label'=>false,'style'=>'width:90%;'));?>
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
  <?php */ ?>
    <div class="box">          
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <?php  /*================================  Hide this Section (Ticket#1043) ======================== ?>
          <!-- display box / first -->
          <div class="breadcrumb">Volume By ISO</div>
	  	  <div class="display_row padding_top_zero">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">ISO </th>
                  <th align="center" valign="top" scope="col">Pre-App </th>
                  <th align="center" valign="top" scope="col">Incomplete </th>
                  <th align="center" valign="top" scope="col">Pending </th>
                  <th align="center" valign="top" scope="col">Integrating </th>
                  <th align="center" valign="top" scope="col">Processing</th>
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
                		$preapp = $common->getIsoStatusVolume($iso['User']['id'], 2, $index );
                		$preappTotal += $preapp;
                		$incomplete = $common->getIsoStatusVolume($iso['User']['id'], 3, $index);
                		$incompleteTotal += $incomplete;
                		$pending = $common->getIsoStatusVolume($iso['User']['id'], 4, $index );
                		$pendingTotal += $pending;
                		$integrating = $common->getIsoStatusVolume($iso['User']['id'], 9, $index );
                		$integratingTotal += $integrating;
                		$processing = $common->getIsoStatusVolume($iso['User']['id'], 5, $index );
                		$processingTotal += $processing;
                		$total = $preapp + $incomplete + $pending + $integrating + $processing ;
                		$totalTotal += $total;
                	
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $iso['User']['user_Name']; ?></td>
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
          <?php /*========================= END ===================================== */ ?>
          
           <!-- display box / first -->
          <div class="breadcrumb">Active Accounts By ISO</div>
          <div class="display_row padding_top_zero">
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">ISO </th>
                  <th align="center" valign="top" scope="col">Pre-App </th>
                  <th align="center" valign="top" scope="col">Incomplete </th>
                  <th align="center" valign="top" scope="col">Pending </th>
                  <th align="center" valign="top" scope="col">Integrating </th>
                  <th align="center" valign="top" scope="col">Processing</th>
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
                                $preapp = $incomplete = $pending = $integrating = $processing = $total = 0;
                                    if(isset($resultIso[$iso['User']['id']])){
                                        foreach($resultIso[$iso['User']['id']] as $key => $Iso){
                                            if($key==2){
                                                $preapp = $Iso;
                                                $preappTotal += $preapp;
                                            }
                                            if($key==3){
                                                $incomplete = $Iso;
                                                $incompleteTotal += $incomplete;
                                            }
                                            if($key==4){
                                                $pending = $Iso;
                                                $pendingTotal += $pending;
                                            }
                                            if($key==9){
                                                $integrating = $Iso;
                                                $integratingTotal += $integrating;
                                            }
                                            if($key==5){
                                                $processing = $Iso;
                                                $processingTotal += $processing;
                                            }
                                            $total = $preapp + $incomplete + $pending + $integrating + $processing ;
                                        }
                                    }
                	?>
                	 <?php if($total>0){?> <?php // Task id 2579 point#7 Only include the processors that has at least one account ?>
		               <tr>
		                  <td align="center" valign="top"><?php echo $iso['User']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php if($preapp>0){ echo $this->Html->link($preapp,'/superadmin/merchants/viewbystatus?statusID=2&isoID='.$iso['User']['id']); }else{ echo $preapp;}?></td>
		                  <td align="center" valign="top"><?php if($incomplete>0){ echo $this->Html->link($incomplete,'/superadmin/merchants/viewbystatus?statusID=3&isoID='.$iso['User']['id']); }else{ echo $incomplete;}?></td>
		                  <td align="center" valign="top"><?php if($pending>0){ echo $this->Html->link($pending,'/superadmin/merchants/viewbystatus?statusID=4&isoID='.$iso['User']['id']); }else{ echo $pending;}?></td>
		                  <td align="center" valign="top"><?php if($integrating>0){ echo $this->Html->link($integrating,'/superadmin/merchants/viewbystatus?statusID=9&isoID='.$iso['User']['id']); }else{ echo $integrating;}?></td>
		                  <td align="center" valign="top"><?php if($processing>0){ echo $this->Html->link($processing,'/superadmin/merchants/viewbystatus?statusID=5&isoID='.$iso['User']['id']); }else{ echo $processing;}?></td>
		                  <td align="center" valign="top"><?php if($total>0){ echo $this->Html->link($total,'/superadmin/merchants/viewbystatus?statusID[]=2&statusID[]=3&statusID[]=4&statusID[]=5&statusID[]=9&isoID='.$iso['User']['id']); }else{ echo $total;}?></td>
		                  <td align="center" valign="top"><?php echo number_format((($total/$countTotal)*100),2) . "%"; ?></td>
		                </tr>
		            <?php } ?>
               	 <?php }?>
                  
                  <tr>
                  <td valign="top" align="left" class="blue"><strong>TOTALS </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $preappTotal; ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $incompleteTotal; ?> </strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $pendingTotal; ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $integratingTotal; ?></strong></td>
                  <td valign="top" align="center" class="blue"><strong><?php echo $processingTotal; ?></strong></td>
                  <td valign="top" align="center" class="blue">
                      <strong>
                        <?php $totalTotal = $processingTotal+$integratingTotal+$pendingTotal+$incompleteTotal+$preappTotal;
                            echo $totalTotal;
                        ?>
                      </strong>
                  </td>
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