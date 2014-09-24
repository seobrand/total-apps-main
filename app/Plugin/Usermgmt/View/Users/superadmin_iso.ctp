<script type="text/javascript">
function showhide(id1,id2,id3,id4)
{
	document.getElementById(id1).style.display='block';
	document.getElementById(id1+'-li').className = 'active';
	document.getElementById(id2).style.display='none';
	document.getElementById(id2+'-li').className = '';
	document.getElementById(id3).style.display='none';
	document.getElementById(id3+'-li').className = '';
	
	document.getElementById(id4).style.display='none';
	document.getElementById(id4+'-li').className = '';
	
	
}
</script>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php 
      
      echo $this->element('generalinformation'); ?>
        <div class="display_row">
          <div class="tabs_outer"> 
             <?php echo $this->element('usersmenu'); ?>
           </div>
          <div class="tabs_des">
            <div class="links_col">
              <ul class="links">
                <li class="active" id="isoInfo-li"><a href="javascript:void(0);" onclick="showhide('isoInfo','merchantInfo','agentInfo','referalInfo')">ISO Memberships:</a></li>
                <li id="merchantInfo-li"><a href="javascript:void(0);" onclick="showhide('merchantInfo','agentInfo','referalInfo','isoInfo')">View Merchants:</a></li>
                <li id="agentInfo-li"><a href="javascript:void(0);" onclick="showhide('agentInfo','referalInfo','isoInfo','merchantInfo')">View Agents:</a></li>
                <li id="referalInfo-li"><a href="javascript:void(0);" onclick="showhide('referalInfo','agentInfo','isoInfo','merchantInfo')">View Referral:</a></li>
              </ul>
            </div>
            <div id="isoInfo"> <?php echo $this->Form->create('User',array('controller'=>'user','action'=>'iso'));?>
              <div class="tabs_des">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                  <tr>
                    <td align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="30%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left" valign="middle"  >Referral</td>
                          <td align="left" valign="middle"><?php 
			//	echo $this->Form->select('idManager', $managerList, array('escape' => false,'empty'=>'Select Manager','class'=>'input1','method'=>'post'));
             ?>
                        
                        <select id="UserIdManager" class="input1" method="post" name="data[User][idManager]">
<option value="">Select Referral</option>
<?php 
foreach($referralList as $mngList)
{?>
	<option value="<?php echo $mngList['users']['id']?>" <?php if($mngList['users']['id']==$this->request->data['User']['idManager']) {?> selected="selected" <?php }?>>
    	<?php echo $mngList['users']['user_Name']?>
    </option>
<?php }
 ?>
</select>
                        
                          </td>
                        </tr>
                      </table></td>
                    <td align="left" valign="top" style="padding:0px;"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right"><?php
             echo $this->Form->input('SUBMIT',array('label'=>'','type'=>'hidden','value'=>'ISO'));
             echo $this->Form->submit('update',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
              </div>
              <?php echo $this->Form->end();?> </div>
            <?php /*** Showing Ajax paging ***/?> 
            <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('merchantInfo','agentInfo','referalInfo','isoInfo')"));?>
            <div id="merchantInfo" style="max-height:400px;display:none;overflow-y:auto;">
            <div class="box" id="content">
            <?php if(count($MerchantREC)>0){?>
			<div class="display_row">
			<div  id="spinner" class="agent-ajax-paging-loader">
            	<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
			</div> 
            <div class="table">
            <?php
            
						$this->Grid->addColumn('Merchant Name', '/Merchant/merchantName', array('paginate'=>false),'merchantName');			
						$this->Grid->addColumn('Merchant DBA', '/Merchant/merchantDBA', array('paginate'=>false),'merchantDBA');			 
					   	$this->Grid->addAction('View', array('plugin' => '','controller' => 'merchants', 'action' => 'view'), array('/Merchant/id'));	
						echo $this->Grid->generate($MerchantREC);
					?>
              <div class="paginator"> <?php echo $this->Paginator->numbers($options = array('model' => 'Merchant'),array('first' => 'First page'));?></div>
              </div>
              </div>
              <?php }else{?>
              <div class="display_row">No Results</div>
              <?php }?>
              </div>
            </div>
            
             <?php /*** Showing Ajax paging ***/?> 
            <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner_agent')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('agentInfo','referalInfo','isoInfo','merchantInfo')"));?>
            <div id="agentInfo" style="max-height:400px;display:none;overflow-y:auto;">
            <div class="box">
            <?php if(count($agentRec)>0){?>
			<div class="display_row" id="content">
			<div  id="spinner_agent" class="agent-ajax-paging-loader">
            	<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
			</div>
			<?php $this->Grid->reset();?>
            <div class="table">
            <?php       $this->Grid->addColumn('Name', '/User/user_Name', array('paginate'=>false),'user_Name');			
						$this->Grid->addColumn('Phone Number', '/User/userPhone', array('paginate'=>false),'userPhone');
						$this->Grid->addColumn('Email Address', '/User/userEmail', array('paginate'=>false),'userEmail');
						$this->Grid->addAction('View', array('plugin' => '','controller' => 'users', 'action' => 'viewUser'), array('/User/id'));	
						echo $this->Grid->generate($agentRec);
					?>
              <div class="paginator">
              	<?php if(count($agentRec)>=5){?>
               		<?php echo $this->Paginator->numbers(array($options = array('model' => 'UserGroupJoin'),'first' => 'First page'));?>
               	<?php }?>
               </div>
              </div>
              <?php }else{?>
              <div class="display_row">No Results</div>
              <?php }?>
              </div>
              </div>
            </div>
            
            <?php /*** Showing Ajax paging ***/?> 
            <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner_referal')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('referalInfo','agentInfo','isoInfo','merchantInfo')"));?>
            <div id="referalInfo" style="max-height:400px;display:none;overflow-y:auto;">
            <div class="box">
            <?php if(count($referalRec)>0){?>
			<div class="display_row" id="content">
			<div  id="spinner_referal" class="agent-ajax-paging-loader">
            	<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
			</div>
			<?php $this->Grid->reset();?>
            <div class="table">
            <?php       $this->Grid->addColumn('Name', '/User/user_Name', array('paginate'=>false),'user_Name');			
						$this->Grid->addColumn('Phone Number', '/User/userPhone', array('paginate'=>false),'userPhone');
						$this->Grid->addColumn('Email Address', '/User/userEmail', array('paginate'=>false),'userEmail');
						$this->Grid->addAction('View', array('plugin' => '','controller' => 'users', 'action' => 'viewUser'), array('/User/id'));	
						echo $this->Grid->generate($referalRec);
			?>
              <div class="paginator"> 
              <?php if(count($referalRec)>=5){?>
               		<?php echo $this->Paginator->numbers(array($options = array('model' => 'UserGroupJoin'),'first' => 'First page'));?>
               	<?php }?>
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
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
<?php echo $this->Js->writeBuffer();?>