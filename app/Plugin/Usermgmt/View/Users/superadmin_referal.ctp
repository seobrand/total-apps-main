<script type="text/javascript">
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
              <ul class="links">
                <li id="merchantInfo-li"><a href="javascript:void(0);" onclick="showhide('merchantInfo','agentInfo')">View Merchants:</a></li>
                 
                 <li class="active" id="agentInfo-li"><a href="javascript:void(0);" onclick="showhide('agentInfo','merchantInfo')">Referral Information:</a></li>
              
                
              </ul>
            </div>
            <?php /*** Showing Ajax paging ***/?> 
            <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('merchantInfo','agentInfo')"));?>
            <div id="merchantInfo" style="max-height:400px;display:block;overflow-y:auto;">
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
            
            
            <div id="agentInfo" style="max-height:400px;display:none;overflow-y:auto;"> <?php echo $this->Form->create('User',array('controller'=>'user','action'=>'referal'));?>
             
              <div class="tabs_des">
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                  <tr>
                    
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
                    <td align="right"><?php
             echo $this->Form->input('SUBMIT',array('label'=>'','type'=>'hidden','value'=>'AGENT'));
             echo $this->Form->submit('Edit Referal Information',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                  </tr>
                </table>
              </div>
              <?php echo $this->Form->end();?> </div>
          </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
<?php echo $this->Js->writeBuffer();?>