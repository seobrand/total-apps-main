 <?php if(count($AgentList)>0){?> 
 <?php echo $this->Form->input('MassMerchantUpdates.agentID',array('id'=>'merchant_agentid','type'=>'select','multiple'=>'multiple','options'=>$AgentList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:255px;'));?>
 <?php }else{?> No user Found <?php }?>divide_from_here<?php if(count($ManagerList)>0){?> 
 <?php echo $this->Form->input('MassMerchantUpdates.managerID',array('id'=>'merchant_manid','type'=>'select','multiple'=>'multiple','options'=>$ManagerList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:255px;'));?>
 <?php }else{?> No user Found <?php }?>divide_from_here <?php if(count($ISOList)>0){?> 
 <?php echo $this->Form->input('MassMerchantUpdates.isoID',array('id'=>'merchant_isoid','type'=>'select','multiple'=>'multiple','options'=>$ISOList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:255px;'));?>
 <?php }else{?> No user Found <?php }?> divide_from_here <?php if(count($ProcessorList)>0){?> 
 <?php echo $this->Form->input('MassMerchantUpdates.processorID',array('id'=>'merchant_processorid','type'=>'select','multiple'=>'multiple','options'=>$ProcessorList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:255px;'));?>
 <?php }else{?> No user Found <?php }?> divide_from_here <?php if(count($ReferralList)>0){?> 
 <?php echo $this->Form->input('MassMerchantUpdates.referalID',array('id'=>'merchant_refid','type'=>'select','multiple'=>'multiple','options'=>$ReferralList,'empty'=>array('0'=>'Blank'),'label'=>false,'div'=>false,'style'=>'width:255px;'));?>
 <?php }else{?> No user Found <?php }?>