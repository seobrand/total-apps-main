<div class="content">
	<!-- content / right -->
	<div id="right">
		<div class="breadcrumb" style="float:right"><?php echo $this->Html->link('Go To Langding Page For Referral','referralLinks',array('class'=>'cursorclass ui-state-default ui-corner-all'));?></div>
		<div id="right2">
			<!-- table -->
			<div class="box1">
				<div class="box">
					<div class="display_row">
						<div class="table">             
			              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
			              <tr>
			              <th colspan="2" align="left" style="padding-left:15px">Add A New Referral Link</th>
			              </tr>
			              <?php echo $this->Form->create('Support', array('id'=>'addreferralLink','onsubmit'=>'return Validation()')); ?>
			              <tr>
			                 <td align="right" valign="top" style="padding-top:15px">New Referral Link<span style="color:#FF0000">*</span> :</td>
			                 <td align="left" valign="top"><?php echo $this->Form->input("ReferralLink.referral_link" ,array('id'=>'referral_link','type' =>'text','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?>&nbsp; <?php echo $this->Form->submit('SUBMIT',array('name'=>'SUBMIT','value'=>'SUBMIT','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
			              </tr>			              
			              </table>
              				<?php echo $this->Form->end(); ?>
             				</div>

						<!-- list all referral links -->
						<div class="tabs_des">
							<div class="links_col"></div>
							<?php /*** Showing Ajax paging ***/?>
							<?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false))));?>
							<div id="merchantInfo">
								<div class="box" id="content">
									<?php if(count($alllinks)>0){?>
									<div class="display_row">
										<div id="spinner" class="agent-ajax-paging-loader">
											<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
										</div>
										<div class="table">
											<?php
												$this->Grid->addColumn('Referral Link', '/ReferralLink/referral_link', array('paginate'=>false),'ReferralLink.referral_link');
												$this->Grid->addAction('Delete', array('plugin' => '','controller' => 'supports', 'action' => 'removeReferralLink'), array('/ReferralLink/id'));
												echo $this->Grid->generate($alllinks);
											?>
											<div class="paginator">
												<?php echo $this->Paginator->numbers($options = array('model' => 'ReferralLink'),array('first' => 'First page'));?>
											</div>
										</div>
									</div>
									<?php }else{?>
									<div class="display_row">No Results</div>
									<?php }?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end table -->
	</div>
</div>
<?php echo $this->Js->writeBuffer();?>
<script type="text/javascript">
function Validation()
{
	var errors = '';
	var count = 0;
	if(trim(document.getElementById('referral_link').value)==''){
		errors += 'Please enter Referral link\n';
		count++;
	}	
	
	if(count>0){
		alert(errors);
		return false;
	}else{
		return true;
	}
}
function trim(s) { 
    s = s.replace(/(^\s*)|(\s*$)/gi,"");
    s = s.replace(/[ ]{2,}/gi," "); 
    s = s.replace(/\n /,"\n"); return s;
}
</script>