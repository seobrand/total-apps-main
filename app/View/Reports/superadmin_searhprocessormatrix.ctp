<?php //pr($processors);die;?>
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
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col"> Business Type</th>
                  <th align="center" valign="top" scope="col">&nbsp;</th>
                  <?php foreach($processors as $processor){?>
                  <th align="center" valign="top" scope="col"><?php echo $processor['User']['user_Name'];?></th>  
                  <?php }?>               
                </tr>
                <?php if(count($processors)>0){?>
                <?php foreach($business_type as $busi_type){?>
                <?php if(count($busi_type['Subcat'])>0){?>
	                <?php foreach($busi_type['Subcat'] as $key => $busi_sub_type){?>
		                <tr>
			              <?php if($key==0){?>
			                <td align="center" valign="top" <?php if(count($busi_type['Subcat'])>1){ echo 'rowspan="'.count($busi_type['Subcat']).'"'; }?>> <?php echo $busi_type['Businesscat']['category_name'];?></td>
			              <?php }?>
		                
		                  <td align="center" valign="top"><?php echo $busi_sub_type['category_name'];?></td>
		                
		                  <?php foreach($processors as $processor){?>
		                  	<td align="center" valign="top"><?php echo $common->getProcessorMatrix($busi_sub_type['id'],$processor['User']['id']);?></td>
		                  <?php }?>
		                </tr>
	                <?php } // end of business sub type foreach?>
	           <?php }else{?>
	           			<tr>			              
			              <td align="center" valign="top"> <?php echo $busi_type['Businesscat']['category_name'];?></td>
			              <td align="center" valign="top">&nbsp;</td>
		                  <?php foreach($processors as $processor){?>
		                  	<td align="center" valign="top"><?php echo $common->getProcessorMatrix($busi_type['Businesscat']['id'],$processor['User']['id']);?></td>
		                  <?php }?>
		                </tr>
	           <?php } // end of if ?>
                <?php } // end of business type foreach?>
              <?php }else{?>
              			<tr>			              
			              <td align="center" valign="top" colspan="2">Processors not found.</td>
		                </tr>
              <?php }?>  
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