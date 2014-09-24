<?php $currentAction = $this->params['action'];
	  $merchantID = $this->request->data['Merchant']['id'];
?>
<?php 
	// check user is super admin or not , if yes allow otherwise not.
	$allow = $this->Session->read('UserAuth.User.is_super_admin');
?>

<?php // task id 3899 ?>
<ul>
	<li <?php if($currentAction=='superadmin_edit'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('notes'),array('controller'=>'merchants','action'=>'edit',$merchantID,'#' => 'note')); ?></li>
	<li <?php if($currentAction=='superadmin_appointments'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('appointment'),array('controller'=>'merchants','action'=>'appointments',$merchantID,'#' => 'appointment')); ?></li>
	<li <?php if($currentAction=='superadmin_merchantaction'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('action'),array('controller'=>'merchants','action'=>'merchantaction',$merchantID,'#' => 'action')); ?></li>
	<li <?php if($currentAction=='superadmin_merchantdoc'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('docs'),array('controller'=>'merchants','action'=>'merchantdoc',$merchantID,'#' => 'doc')); ?></li>
	<li <?php if($currentAction=='superadmin_merchantrates'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('rates'),array('controller'=>'merchants','action'=>'merchantrates',$merchantID,'#' => 'rate')); ?></li>
	<li <?php if($currentAction=='superadmin_merchanttrans'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('transaction'),array('controller'=>'merchants','action'=>'merchanttrans',$merchantID,'#' => 'transaction')); ?></li>
	<li <?php if($currentAction=='superadmin_moreinfo'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('More Info'),array('controller'=>'merchants','action'=>'moreinfo',$merchantID,'#' => 'more')); ?></li>
	<li <?php if($currentAction=='superadmin_merchantdeployment'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('deployment'),array('controller'=>'merchants','action'=>'merchantdeployment',$merchantID,'#' => 'deployment')); ?></li>
	<li <?php if($currentAction=='superadmin_merchantcommission'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('commission'),array('controller'=>'merchants','action'=>'merchantcommission',$merchantID,'#' => 'commission')); ?></li>
	<li <?php if($currentAction=='superadmin_underwriting'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('Underwriting'),array('controller'=>'merchants','action'=>'underwriting',$merchantID,'#' => 'underwriting')); ?></li>
	<?php if($allow){?>
	<li <?php if($currentAction=='superadmin_processinghistory'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('Processing History'),array('controller'=>'merchants','action'=>'processinghistory',$merchantID,'#' => 'processinghistory')); ?></li>
	<?php }?>	
	<li <?php if($currentAction=='superadmin_contact'):?> class="active" <?php endif;?>><?php echo $this->Html->link(strtoupper('Company Contacts'),array('controller'=>'merchants','action'=>'contact',$merchantID,'#' => 'contact')); ?></li>
</ul>


