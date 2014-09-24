<script type="text/javascript">
    function showhide(id1,id2,id3,id4,id5)
    {
		document.getElementById(id1).style.display='block';
		document.getElementById(id1+'-li').className = 'active';
        document.getElementById(id2).style.display='none';
		document.getElementById(id2+'-li').className = '';
        document.getElementById(id3).style.display='none';
		document.getElementById(id3+'-li').className = '';
        document.getElementById(id4).style.display='none';
		document.getElementById(id4+'-li').className = '';
        document.getElementById(id5).style.display='none';
		document.getElementById(id5+'-li').className = '';
    }
</script>

<?php $processor_type = array('all'=>'All','domestic'=>'Domestic','international'=>'International');?>
<?php 
// business type dropdown box

$businesstypeoption_initial = "";
$businesstypeoption_end = "";

foreach($businessType as $business_type){
	$selected = "";
	if(count($business_type['Subcat'])>0){
		$businesstypeoption_end .= "<optgroup label=".$business_type['Businesscat']['category_name'].">";
		foreach($business_type['Subcat'] as $subcat){
			if(in_array($subcat['id'], $processor_business_type))
			{ $selected = "selected";}
			$businesstypeoption_end .= "<option value=".$subcat['id']." $selected>".$subcat['category_name']."</option>";
		}
		$businesstypeoption_end .= "</optgroup>";
	}else{
		if(in_array($business_type['Businesscat']['id'], $processor_business_type)){
			$selected = "selected";
		}
		$businesstypeoption_initial .= "<option value=".$business_type['Businesscat']['id']." $selected>".$business_type['Businesscat']['category_name']."</option>";
	}
}
$business_type_options = $businesstypeoption_initial."".$businesstypeoption_end;
?>

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
                <li class="active" id="processorInfo-li"><a  href="javascript:void(0);" onclick="showhide('processorInfo','merchantInfo','managerInfo','document','profile')">Processor Information:</a></li>
                <li  id="merchantInfo-li"><a  href="javascript:void(0);" onclick="showhide('merchantInfo','managerInfo','document','profile','processorInfo')">View Merchants:</a></li>
                <li  id="managerInfo-li"><a  href="javascript:void(0);" onclick="showhide('managerInfo','document','profile','processorInfo','merchantInfo')">View Managers:</a></li>
                <li  id="document-li"><a  href="javascript:void(0);" onclick="showhide('document','profile','processorInfo','merchantInfo','managerInfo')">Processor Documents:</a></li>
                <li  id="profile-li"><a  href="javascript:void(0);" onclick="showhide('profile','processorInfo','merchantInfo','managerInfo','document')">Profile :</a></li>
              </ul>
            </div>
            <div id="processorInfo"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'processor', 'enctype' => 'multipart/form-data')); ?>
              <div class="tabs_des links_col" >
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                  <tr>
                    <td align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left" valign="middle"  width="500px;">
                          <div style="width:320px;">
                          <?php 
                          $options=array('1'=>'Preapp Application with PDF as attachement ','0'=>'Preapp Application with online form link');
                        $attributes=array('legend'=>false);
                        echo $this->Form->radio('processorPackage',$options,$attributes);
                          
                          ?>
                          
                          </div>
                          
                          
                          <?php //echo $this->Form->input('processorPackage', array('value' => 1, 'type' => 'checkbox')); ?>
                          
                          </td>
                          <td align="left" valign="middle"> Existing File Name&nbsp;&nbsp;</a> </td>
                          <td><?php echo $this->request->data['User']['processorPackageFilename']; ?> </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" ></td>
                          <td align="left" valign="middle"> New File </td>
                          <td><?php echo $this->Form->input('processorPackageFilename', array('type' => 'file', 'label' => '')); ?> </td>
                        </tr>
                      </table></td>
                    <td align="left" valign="top" style="padding:0px;"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['processorPackageFilename']));
                                                        echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'PROCESSOR'));
                                                        echo $this->Form->submit('Upload File', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
                                                        ?></td>
                  </tr>
                </table>
              </div>
              <?php echo $this->Form->end(); ?> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'processor', 'name' => 'frmemailTEMP', 'enctype' => 'multipart/form-data')); ?>
              <div class="tabs_des ">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                  <tr>
                    <td align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left" valign="middle"  width="500px;"><?php
							echo $this->Form->textarea('email_template', array('rows' => '10', 'cols' => '80'));
							?>
                          </td>
                          <td align="left" valign="middle"><!-- <strong>[FROM MANAGER EMAIL]=></strong> Replacing By Merchant Manager Email<br/><br/> --><strong>[MERCHANT/CONTACT NAME]=></strong> Replacing By Merchant Contact Name<br/><br/><strong>[MERCHANT/LEGAL NAME]=></strong> Replacing By Merchant Legal Name<br/><br/><strong>[PREAPP REQUEST URL]=></strong> Replacing By Pre-app Request url<br/><br/><strong>[MANAGER NAME]=></strong> Replacing By Merchant Manager Name<br/><br/><strong>[MANAGER/COMPANY]=></strong> Replacing By Manager Company Name<br/><br/><strong>[MANAGER/Company URL] </strong>=> Replacing By Manager Company URL<br/><br/>
<strong>[MANAGER/PHONE]=></strong> Replacing By Manager Phone Number</td>
                        </tr>
                      </table></td>
                    <td align="left" valign="top" style="padding:0px;"></td>
                  </tr>
                  <tr>
                 <td colspan="2" align="right"><?php
			echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'TEMPLATE'));
			echo $this->Form->submit('Update Template', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
			?></td>
                  </tr>
                </table>
              </div>
              <?php echo $this->Form->end(); ?> </div>
            <?php /*** Showing Ajax paging ***/?> 
            <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('merchantInfo','managerInfo','document','profile','processorInfo')"));?>
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
              <div class="paginator"> 
              <?php echo $this->Paginator->numbers($options = array('model' => 'Merchant'),array('first' => 'First page'));?></div>
              </div>
              </div>
              <?php }else{?>
              <div class="display_row">No Results</div>
              <?php }?>
              </div>
            </div>
            
            <?php /*** Showing Ajax paging ***/?> 
            <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner_agent')->effect('fadeIn', array('buffer' => false)),'complete' => "showhide('managerInfo','document','profile','processorInfo','merchantInfo')"));?>
            <div id="managerInfo" style="max-height:400px;display:none;overflow-y:auto;">
            <div class="box">
            <?php if(count($managerRec)>0){?>
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
						echo $this->Grid->generate($managerRec);
					?>
              <div class="paginator">
              <?php if(count($managerRec)>=5){?>
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
            
            
            <div id="document" style="max-height:400px;display:none;overflow-y:auto;"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'processor', 'name' => 'frmemailTEMP', 'enctype' => 'multipart/form-data')); ?>
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td><?php
                  
                 $userid=$this->request->data['User']['id'];
                                        if (count($docRec)) {
                                            foreach ($docRec as $docRec) {
                                            
                                                ?>
                    <div style="width:250px;height:80px;;text-align:center;float:left;display:block;line-height:60px;"> <?php echo $docRec['processordocs']['docName']; ?>
                      <?php // $common->checkProcessorDOC($userid,$docRec['processordocs']['id']); ?>
                      <select id="User2" class="input1" method="post" name="data[User][<?php echo $docRec['processordocs']['id'];?>]">
                        <option value="">Selected</option>
                        <option value="1" <?php if($common->checkProcessorDOC($userid,$docRec['processordocs']['id'])=='1') {?> selected="selected" <?php } ?> >Required</option>
                        <option value="0" <?php if($common->checkProcessorDOC($userid,$docRec['processordocs']['id'])=='0') {?> selected="selected" <?php } ?> >Not Required</option>
                      </select>
                      <div>
                        <?php
                                                        ?>
                      </div>
                    </div>
                    <?php
                                            }
                                        } else {
                                            ?>
                    <strong>No Record Found</strong>
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td align="right"><?php echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'DOCUMENT'));
echo $this->Form->submit('Update Document', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false)); ?> </td>
                </tr>
              </table>
              <?php echo $this->Form->end(); ?> </div>
            <div id="profile" style="max-height:400px;display:none;overflow-y:auto;"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'processor','name' => 'frmemailTEMP', 'enctype' => 'multipart/form-data')); ?>
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td colspan="4"><?php
                  $selected='';
             
              
                
              ?>
                    
                  </td>
                </tr>
                
                 <tr>
                  <td>Account Type </td>                  
                  <td> <select class="input1" 'selected'="" style="width:200px;" method="post" name="data[Businesstypeprocessorlink][businessTypeID]">
                      <option>Select Account Type</option>
                      <?php foreach($accountType as $key =>$value) {?>
                      <option value="<?php echo $key; ?>" <?php  if($businessTypeID==$key){ ?> selected="selected" <?php } ?>><?php echo $value; ?></option>
                      <?php } ?>
                    </select></td>
                    <td>Processor Type </td> 
                    <td>
                    <?php echo $this->Form->select('User.processor_type',$processor_type,  array('class'=>'input1','empty'=>'-Select Type-', 'style' => 'width:200px;','escape' => false));?>
                    </td>                 
                </tr>
                <tr>
                  <td> Payment Methods </td>
                  <td><?php echo $this->Form->input('processorPayMethod',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                  <td>Business Type </td>
                 <td><select id="BusinesstypeprocessorlinkId" name="data[Businesstypeprocessorlink][businessTypeID][]" multiple="multiple" size="5"><?php echo $business_type_options;?></select></td>
                </tr>
                <tr>
                  <td> On shore</td>
                  <td><?php echo $this->Form->input('processorOnShore',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                  <td>Minimum Amount<br />
                    DD </td>
                  <td><?php echo $this->Form->input('processorMinAmount',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                </tr>
                <tr>
                  <td> Buy Rate </td>
                  <td><?php echo $this->Form->input('processorBuyRate',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                  <td>Split Rate</td>
                  <td><?php echo $this->Form->input('processorSplitRate',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                </tr>
                <tr>
                  <td align="right" colspan="4"><?php echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'profile'));
                    echo $this->Form->submit('Update Document', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false)); ?> </td>
                </tr>
              </table>
              <?php echo $this->Form->end(); ?> </div>
          </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
<?php echo $this->Js->writeBuffer();?>
<script type="text/javascript">
jQuery.noConflict();
jQuery("#BusinesstypeprocessorlinkId").multiselect({});
</script>