<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb">Meritus Chargeback Report</div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">  
        
        <div class="news_indent"> 
          <?php echo $this->Form->create('Report');?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr height="35">
                <td width="10%" valign="top" align="right">Search Month</td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('Month', array('dateFormat' => 'M',"empty"=>'Select Month','type'	=> 'date','label'=>false,'div'=>false,'style'=>'width:290px;')); ?>
	                 
				 </td>
				 <td width="10%" valign="top" align="right">Search Year</td>
                 <td width="30%" valign="top" style="padding:0px;">
		 <?php echo $this->Form->input('Year', array('dateFormat' => 'Y',"empty"=>'Select Year','type'	=> 'date','label'=>false,'div'=>false,'style'=>'width:290px;')); ?>
		 </td>
                 <td width="40%">&nbsp;</td>
              </tr>
              <tr height="35">
                <td width="10%" valign="top" align="left"><!--Processor--></td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php //echo $this->Form->input('Processor',array('type'=>'select','multiple'=>'multiple','options'=>$processorList,'div'=>false,'label'=>false,'style'=>'width:50%;'));?>
	             </td>
				 <td width="10%" valign="top" align="right">&nbsp</td>
                 <td width="20%" valign="top" style="padding:0px;">
                 <input type="submit" value="Search" class="cursorclass ui-state-default ui-corner-all" name="Submit"></td>
                 <td width="40%">&nbsp;</td>                 
              </tr>              
            </table>
          <?php $this->Form->end();?>
          </div>
          
          
          
         
          
          <div class="clear"></div>
        
         
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table table_scroll_autoy">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col">#MID </th>
                  <th align="center" valign="top" scope="col">Number of Transactions</th>
                  <th align="center" valign="top" scope="col">Number of Chargebacks</th>
                  <th align="center" valign="top" scope="col">% Chargeback</th>
                  
                </tr>
                <?php                 	               	
	                if( !empty($meritcard_data) ) { 
			    foreach ($meritcard_data as $data){
				    $chargeBack_per = ( $data['Commissionlog']['chargebacks_numbers']/$data['Commissionlog']['transaction_numbers']) *100;
			    ?>
				    <tr>
				      <td align="center" valign="top"><?php echo $this->Html->link($data['Commissionlog']['MID'],array('controller'=>'reports','action'=>'meritusreport/'.$data['Commissionlog']['MID'])); ?></td>
				      <td align="center" valign="top"><?php echo $data['Commissionlog']['transaction_numbers'];?></td>
				      <td align="center" valign="top"><?php echo $data['Commissionlog']['chargebacks_numbers'];?></td>
				      <td align="center" valign="top"><?php echo number_format($chargeBack_per,2)."%";?></td>
				     </tr>
		     <?php 	}
			}
			else { ?>
			<tr><td colspan="4" align="center">No result found.</td></td></tr>
			<?php } ?>
               	              
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
</script>
