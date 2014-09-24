<?php 
	   $userGroupId=$this->Session->read('UserAuth.User.user_group_id');
	   // reports permission (Ticket#2244)
	   $user_report_permission = $common->getReportPermission($this->Session->read('UserAuth.User.id'));
?>
<style>
 .dashboard_content table td {border:0px !important;}
</style>
<div class="content">
	<!-- content / right -->
	<div id="right">

		<div class="breadcrumb"></div>
		<div id="right2">
			<!-- table -->
			<div class="box1">

				<div class="dashboard_content">
					<table>
						<tr>
							<td>
								<ul>
								<?php if(in_array(1, $user_report_permission)){?>
									<li class="residuals_icon"><strong><a href="<?php echo $this->webroot; ?>superadmin/reports/residualreport">Residuals</a></strong><br />
										View Residuals for each merchant account by month.</li>
								<?php }?>	
								<?php if(in_array(2, $user_report_permission)){?>
									<li class="residuals_icon">
										<strong><a href="#">Chargeback Report</a></strong><br />
										<a href="<?php echo $this->webroot; ?>superadmin/reports/meritcardreport">Meritcard Chargeback Report</a><br/>
										<a href="<?php echo $this->webroot; ?>superadmin/reports/meritusreport">Meritus Chargeback Report</a><br/></li>
								<?php }?>
								<?php if(in_array(3, $user_report_permission)){?>
									<li class="portfolio_icon"><strong><a href="<?php echo $this->webroot; ?>superadmin/reports/processorbyvolumeoramount">Taboo's Accounts</a></strong><br />
										View Accounts by each Processor/ Agent/Referral/ISO. </li>

								<?php }?>
								<?php if(in_array(4, $user_report_permission)){?>
									<li class="portfolio_icon"><strong><a href="<?php echo $this->webroot; ?>superadmin/reports/processormatrix">Processor Report</a></strong><br />
										View processor's performance by month and processor matrix.</li>

								<?php }?>
								<?php if(in_array(5, $user_report_permission)){?>
									<li class="portfolio_icon"><strong><a href="<?php echo $this->webroot; ?>superadmin/reports/commission">Agent/Referral/Iso Report</a></strong><br />
										View Agent/Referral/ISO commission for each account by month.</li>
									<?php }?>
								</ul>
							</td>
							<td>
								<ul>
								<?php if(in_array(6, $user_report_permission)){?>
									<li class="merchant_icon"><strong><a href="<?php echo $this->webroot; ?>superadmin/reports/monthlyprocessingvolume">Merchant Processing Volume</a></strong><br />
										Compare the volume processed for each merchant by month.</li>

									<?php }?>
								<?php if(in_array(7, $user_report_permission)){?>
									<li class="chargebacks_icon"><strong><a href="<?php echo $this->webroot; ?>superadmin/reports/manager">Managers Report</a></strong><br />
										View Account Status and Volume Processed for each Manager.</li>

								<?php }?>
								<?php if(in_array(8, $user_report_permission)){?>	
									<li class="portfolio_icon"><strong><a href="<?php echo $this->webroot; ?>superadmin/reports/loss">Loss</a></strong><br />
										View accounts with loss by month</li>
								<?php }?>		
								<?php if(in_array(9, $user_report_permission)){?>
									<li class="alerts_icon"><strong><a href="#">Gateway Report</a></strong><br /> NMI Report<br />Authorize.net Report</li>
								<?php }?>
								<?php if(in_array(10, $user_report_permission)){?>
									<li class="alerts_icon"><strong><a href="<?php echo $this->webroot; ?>superadmin/reports/paymentsetupfees">Other Reports</a></strong><br /> View other reports</li>
								<?php }?>	
								</ul>
							</td>
						</tr>
					</table>


				</div>



			</div>
			<!-- end table -->
		</div>

	</div>
	<!-- end content / right -->
</div>
