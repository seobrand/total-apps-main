<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"><?php echo $report_title; ?> Chargeback Report</div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">   
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table table_scroll_autoy">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr style="border-top:1px solid #e1e1e1">
                   <td align="center" valign="top" scope="col"></td>
                  <td align="center" valign="top" scope="col"><strong>Merchant : <?php echo (!empty($MID['Merchant']['merchantName'])) ? $MID['Merchant']['merchantName']: ""; ?></td>
                  <td align="center" valign="top" scope="col"><strong>MID :  <?php echo (!empty($MID['Commissionlog']['MID'])) ? $MID['Commissionlog']['MID']: ""; ?></strong></td>
                  <td align="center" valign="top" scope="col"></td>
                </tr>
                <tr>
                   <td align="center" valign="top" scope="col"></td>
                  <td align="center" valign="top" scope="col"><strong>Number of Transactions</strong>  </td>
                  <td align="center" valign="top" scope="col"><strong>Number of Chargebacks </strong></td>
                  <td align="center" valign="top" scope="col"> <strong>% Chargebacks</strong></td>
                </tr>
                <?php                 	               	
	                foreach ($meritcard_data as $key => $data){
                            
                		$chargeBack_per = ( $data['Commissionlog']['chargebacks_numbers']/$data['Commissionlog']['transaction_numbers']) *100;
                	?>
		                <tr>
		                  <td align="center" valign="top"><?php echo $key;?></td>
		                  <td align="center" valign="top"><?php echo (!empty($data['Commissionlog']['transaction_numbers'])) ? $data['Commissionlog']['transaction_numbers'] : "-";?></td>
		                  <td align="center" valign="top"><?php echo (!empty($data['Commissionlog']['chargebacks_numbers'])) ? $data['Commissionlog']['chargebacks_numbers']:"-";?></td>
		                  <td align="center" valign="top"><?php echo ($chargeBack_per) ? number_format($chargeBack_per,2)."%" : "-";?></td>
		                 </tr>
               	 <?php 	
                  } // end of foreach loop
                  
               	 ?>   
               	              
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
