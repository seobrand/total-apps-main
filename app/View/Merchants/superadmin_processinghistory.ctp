<?php //pr($this->request->data); ?>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="processinghistory">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
		  <div class="box1">
		  <div class="news_announcement">
            <div class="titlebar">Commission Processing History
			<div style="float:right">
			<a href="<?php echo $this->webroot; ?>superadmin/merchants/contact/<?php echo $this->request->data['Merchant']['id']; ?>#contact">Next</a>
			</div>
			</div>
            
            <div class="box">
              <div class="display_row" >
                <div class="table" id="merchant-appointment">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="10%" align="center" valign="top" scope="col">MID #</th>
                      <th width="13%" align="center" valign="top" scope="col">Amount Processed</th>
		      <th width="15%" align="center" valign="top" scope="col">Gross Revenue</th>
		      <th width="13%" align="center" valign="top" scope="col">Number of Transactions</th>
                      <th width="15%" align="center" valign="top" scope="col"> Totalapps income</th>
                      <th width="13%" align="center" valign="top" scope="col"> Agent Split($)</th>
                      <th width="12%" align="center" valign="top" scope="col"> Referral Split($)</th>
                      <th width="10%" align="center" valign="top" scope="col"> ISo Split($)</th>
					  <th width="10%" align="center" valign="top" scope="col"> Date </th>
                    </tr>
                    
					<?php foreach($commissionLog as $key => $logs):?>	
                    <tr>
                      <td align="center" valign="top"><?php echo $logs['Commissionlog']['MID'];?></td>
                      <td align="center" valign="top">$<?php echo $logs['Commissionlog']['amount_processed'];?></td>		      
                      <td align="center" valign="top">$<?php echo $logs['Commissionlog']['gross_revenue'];?></td>
		      <td align="center" valign="top"><?php echo $logs['Commissionlog']['transaction_numbers'];?></td>
					  <td align="center" valign="middle">$<?php echo $logs['Commissionlog']['totalapps_income'];?></td>
					  <td align="center" valign="middle">$<?php echo $logs['Commissionlog']['agent_commission'];?></td>
					  <td align="center" valign="middle">$<?php echo $logs['Commissionlog']['referral_commission'];?></td>
					  <td align="center" valign="middle">$<?php echo $logs['Commissionlog']['iso_commission'];?></td>
					  <td align="center" valign="middle"><?php echo date("M Y",strtotime($logs['Commissionlog']['date']));?></td>
                    </tr>
                    <?php endforeach;?>
					<?php if(count($commissionLog)==0):?>
					<tr>
                      <td align="center" valign="top" colspan="9">No Results Found</td>
                    </tr>
					<?php endif;?>
                  </table>
                </div>
              </div>
            </div>
			</div>
			</div>
          </div>
        </div>
        <!-- display box / second end here -->
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
