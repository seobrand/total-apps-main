<script type="text/javascript">
<?php if(isset($this->request->params['paging']['Merchant']['page'])){ ?>
$(document).ready(function() {
showhide('merchantInfo','agentInfo');
});
<?php } ?>


function showhide(id1,id2)
{

	document.getElementById(id2).style.display='none';
	document.getElementById(id1+'-li').className = 'active';	
	document.getElementById(id1).style.display='block';
	document.getElementById(id2+'-li').className = '';
	
	if(id1=='agentInfo')
	{
		$("#krymson_nav ul").addClass('test');
	}else
	{
		$(".krymson_nav ul").addClass('test');
	}
	
}
</script>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('generalinformation'); ?>
        <div class="display_row">
          <div class="tabs_outer"> <?php echo $this->element('usersmenu'); ?> </div>
          <div class="tabs_des">
            <div class="links_col">
              <ul class="links" id="krymson_nav">
                <li class="active" id="agentInfo-li"><a href="javascript:void(0);" onclick="showhide('agentInfo','merchantInfo')">Agent Information:</a></li>
                <li id="merchantInfo-li"><a href="javascript:void(0);" onclick="showhide('merchantInfo','agentInfo')">View Merchants:</a></li>
              </ul>
            </div>
            <div id="agentInfo"> <?php echo $this->Form->create('User',array('controller'=>'user','action'=>'agent'));?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                <tr>
                  <td align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="24%" align="left" valign="middle">Bank User Name</td>
                        <td width="76%" align="left" valign="middle"><?php echo $this->Form->input('bankUserName',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Bank Address</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankAddress',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Bank City</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankCity',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Bank Zip</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankZip',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Account Number</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankAccountNumber',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Swift Number</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankSwiftNumber',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                    </table></td>
                  <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="22%" align="left" valign="middle">Bank Phone</td>
                        <td width="78%" align="left" valign="middle"><?php echo $this->Form->input('bankPhone',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Bank Address 2</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankAddress2',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Bank State</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankState',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">Bank Country</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankCountry',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle">ABA Number</td>
                        <td align="left" valign="middle"><?php echo $this->Form->input('bankABANumber',array('type'=>'text','class'=>'input1','label'=>'')); ?></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
              <div class="tabs_des">
                <div class="links_col">
                  <ul class="links">
                    <li class="active">Agent Memberships:</li>
                  </ul>
                </div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                  <tr>
                    <td align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left" valign="middle" >Manager</td>
                          <td align="left" valign="middle"><?php 
             
             
             
             
//echo $this->Form->select('idManager', $managerList, array('escape' => false,'empty'=>'Select Manager','class'=>'input1','method'=>'post'));
  

    ?>
                            <select id="UserIdManager" class="input1" method="post" name="data[User][idManager]">
                              <option value="">Select Manager</option>
                              <?php 
foreach($managerList as $mngList)
{?>
                              <option value="<?php echo $mngList['users']['id']?>" <?php if($mngList['users']['id']==$this->request->data['User']['idManager']) {?> selected="selected" <?php }?>> <?php echo $mngList['users']['user_Name']?> </option>
                              <?php }
 ?>
                            </select>
                          </td>
                        </tr>
                      </table></td>
                    <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left" valign="middle">ISO</td>
                          <td align="left" valign="middle"><?php 
             
//echo $this->Form->select('idIso', $IsoList, array('escape' => false,'empty'=>'Select Iso','class'=>'input1'));
             ?>
                            <select id="UserIdIso" class="input1" name="data[User][idIso]">
                              <option value="">Select Iso</option>
                              <?php 
foreach($IsoList as $IsoList)
{?>
                              <option value="<?php echo $IsoList['users']['id']?>" <?php if($IsoList['users']['id']==$this->request->data['User']['idIso']) {?> selected="selected" <?php }?>> <?php echo $IsoList['users']['user_Name']?> </option>
                              <?php }
 ?>
                            </select>
                          </td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right"><?php
             echo $this->Form->input('SUBMIT',array('label'=>'','type'=>'hidden','value'=>'AGENT'));
             echo $this->Form->submit('Edit Agent Information',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
              </div>
              <?php echo $this->Form->end();?> </div>
            <?php /*** Showing Ajax paging ***/?> 
            <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('merchantInfo','agentInfo')"));?>
            <div id="merchantInfo" style="max-height:400px;display:none;overflow-y:auto;">            
            <div class="box" id="content">            
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
              <div class="paginator"> <?php echo $this->Paginator->numbers(array('first' => 'First page'));?></div>              
              </div>
              </div>
              </div>
            </div>
            <?php echo $this->Js->writeBuffer();?>
          </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
