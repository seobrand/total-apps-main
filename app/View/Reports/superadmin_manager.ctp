<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <div class="breadcrumb">Accounts By volume</div>          
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col" style="width: 20%;"><?php echo $this->Paginator->sort('User.user_Name', 'Manager');?> </th>
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
	                
                	foreach ($managers as $manager) { 

                                $preapp = $incomplete = $pending = $integrating = $processing = $total = 0;
                                if(isset($result[$manager['User']['id']])){
                                       
                                        foreach($result[$manager['User']['id']] as $key => $Manager){
                                            if($key==2){
                                                $preapp = $Manager;
                                                $preappTotal += $preapp;
                                            }
                                            if($key==3){
                                                $incomplete = $Manager;
                                                $incompleteTotal += $incomplete;
                                            }
                                            if($key==4){
                                                $pending = $Manager;
                                                $pendingTotal += $pending;
                                            }
                                            if($key==9){
                                                $integrating = $Manager;
                                                $integratingTotal += $integrating;
                                            }
                                            if($key==5){
                                                $processing = $Manager;
                                                $processingTotal += $processing;
                                            }
                                            $total = $preapp + $incomplete + $pending + $integrating + $processing ;
                                        }
                                    }
//                	
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $manager['User']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php if($preapp>0){ echo $this->Html->link("$ ".number_format($preapp,2),'/superadmin/merchants/viewbystatus?statusID=2&managerID='.$manager['User']['id']); }else{ echo "$ ".number_format($preapp,2);}?></td>
		                  <td align="center" valign="top"><?php if($incomplete>0){ echo $this->Html->link("$ ".number_format($incomplete,2),'/superadmin/merchants/viewbystatus?statusID=3&managerID='.$manager['User']['id']); }else{ echo "$ ".number_format($incomplete,2);}?></td>
		                  <td align="center" valign="top"><?php if($pending>0){ echo $this->Html->link("$ ".number_format($pending,2),'/superadmin/merchants/viewbystatus?statusID=4&managerID='.$manager['User']['id']); }else{ echo "$ ".number_format($pending,2);}?></td>
		                  <td align="center" valign="top"><?php if($integrating>0){ echo $this->Html->link("$ ".number_format($integrating,2),'/superadmin/merchants/viewbystatus?statusID=9&managerID='.$manager['User']['id']); }else{ echo "$ ".number_format($integrating,2);}?></td>
		                  <td align="center" valign="top"><?php if($processing>0){ echo $this->Html->link("$ ".number_format($processing,2),'/superadmin/merchants/viewbystatus?statusID=5&managerID='.$manager['User']['id']); }else{ echo "$ ".number_format($processing,2);}?></td>
		                  <td align="center" valign="top"><?php if($total>0){ echo $this->Html->link("$ ".number_format($total,2),'/superadmin/merchants/viewbystatus?statusID[]=2&statusID[]=3&statusID[]=4&statusID[]=5&statusID[]=9&managerID='.$manager['User']['id']); }else{ echo "$ ".number_format($total,2);}?></td>
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
                  <td valign="top" align="center" class="blue">
                      <strong>
                        <?php $totalTotal = $processingTotal+$integratingTotal+$pendingTotal+$incompleteTotal+$preappTotal;
                            echo "$ ".number_format($totalTotal,2);
                        ?>
                      </strong>
                  </td>
                  <td valign="top" align="center" class="blue"><strong><?php echo round(($totalTotal/$grandTotal)*100) . "%"; ?></strong></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="clear"></div>
          <br/><br/>
          <!-- display box / first --> 
          
           <!-- display box / first -->
	  <div class="breadcrumb">Accounts by number</div>          
          <div class="display_row padding_top_zero">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col" style="width: 20%;">Manager </th>
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
	                
                	foreach ($managers as $manager) { 
                                    $preapp = $incomplete = $pending = $integrating = $processing = $total = 0;
                                    if(isset($resultVol[$manager['User']['id']])){
                                       
                                        foreach($resultVol[$manager['User']['id']] as $key => $Manager){
                                            if($key==2){
                                                $preapp = $Manager;
                                                $preappTotal += $preapp;
                                            }
                                            if($key==3){
                                                $incomplete = $Manager;
                                                $incompleteTotal += $incomplete;
                                            }
                                            if($key==4){
                                                $pending = $Manager;
                                                $pendingTotal += $pending;
                                            }
                                            if($key==9){
                                                $integrating = $Manager;
                                                $integratingTotal += $integrating;
                                            }
                                            if($key==5){
                                                $processing = $Manager;
                                                $processingTotal += $processing;
                                            }
                                            $total = $preapp + $incomplete + $pending + $integrating + $processing ;
                                        }
                                    }
                	
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $manager['User']['user_Name']; ?></td>
		                  <td align="center" valign="top"><?php if($preapp>0){ echo $this->Html->link($preapp,'/superadmin/merchants/viewbystatus?statusID=2&managerID='.$manager['User']['id']); }else{ echo $preapp;}?></td>
		                  <td align="center" valign="top"><?php if($incomplete>0){ echo $this->Html->link($incomplete,'/superadmin/merchants/viewbystatus?statusID=3&managerID='.$manager['User']['id']); }else{ echo $incomplete;}?></td>
		                  <td align="center" valign="top"><?php if($pending>0){ echo $this->Html->link($pending,'/superadmin/merchants/viewbystatus?statusID=4&managerID='.$manager['User']['id']); }else{ echo $pending;}?></td>
		                  <td align="center" valign="top"><?php if($integrating>0){ echo $this->Html->link($integrating,'/superadmin/merchants/viewbystatus?statusID=9&managerID='.$manager['User']['id']); }else{ echo $integrating;}?></td>
		                  <td align="center" valign="top"><?php if($processing>0){ echo $this->Html->link($processing,'/superadmin/merchants/viewbystatus?statusID=5&managerID='.$manager['User']['id']); }else{ echo $processing;}?></td>
		                  <td align="center" valign="top"><?php if($total>0){ echo $this->Html->link($total,'/superadmin/merchants/viewbystatus?statusID[]=2&statusID[]=3&statusID[]=4&statusID[]=5&statusID[]=9&managerID='.$manager['User']['id']); }else{ echo $total;}?></td>
		                  <td align="center" valign="top"><?php echo number_format((($total/$countTotal)*100),2) . "%"; ?></td>
		                </tr>
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