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

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
   
       <?php echo $this->element('generalinformation'); ?>
       
          
        <div class="display_row">
          <div class="tabs_outer">
          
           <?php echo $this->element('usersmenu'); ?>
           </div>
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
                          <td align="left" valign="middle"  width="500px;"><?php echo $this->Form->input('processorPackage', array('value' => 1, 'type' => 'checkbox')); ?></td>
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
                          <td align="left" valign="middle"></td>
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
             
            <div id="merchantInfo" style="max-height:400px;display:none;overflow-y:auto;">
           	<div class="box">
<div class="display_row">
            <div class="table">
            	 <?php
						$this->Grid->addColumn('Merchant Name', '/Merchant/merchantName', array('paginate'=>true),'merchantName');			
						$this->Grid->addColumn('Merchant DBA', '/Merchant/merchantDBA', array('paginate'=>true),'merchantDBA');			 
						echo $this->Grid->generate($MerchantREC);
				?>
              <div class="paginator"> <?php echo $this->Paginator->numbers(array('first' => 'First page'));?></div>
              <!--<table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td width="50%" align="center"><strong>Merchant Name</strong></td>
                  <td width="50%" align="center"><strong>Merchant DBA</strong></td>
                </tr>
                <?php
                                if (count($MerchantREC)) {
                                    foreach ($MerchantREC as $MerchantRec) {
                                        ?>
                <tr>
                  <td><?php echo $MerchantRec['Merchant']['merchantName']; ?></td>
                  <td><?php echo $MerchantRec['Merchant']['merchantDBA']; ?></td>
                </tr>
                <?php
                                    }
                                } else {
                                    ?>
                <tr>
                  <td colspan="3" align="center" height="200px;" valign="middle"><strong>No Record Found</strong></td>
                </tr>
                <?php } ?>
              </table>-->
              </div>
              </div>
              </div>
            </div>
            
            <div id="managerInfo" style="max-height:400px;display:none;overflow-y:auto;">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td width="33%" align="center"><strong>Name</strong></td>
                  <td width="33%" align="center"><strong>Phone Number</strong></td>
                  <td width="34%" align="center"><strong>Email Address</strong></td>
                </tr>
                <?php
                                if (count($managerRec)) {
                                    foreach ($managerRec as $MANAGER) {
                                        ?>
                <tr>
                  <td><?php echo $MANAGER['User']['user_Name']; ?></td>
                  <td><?php echo $MANAGER['User']['userPhone']; ?></td>
                  <td><?php echo $MANAGER['User']['userEmail']; ?></td>
                </tr>
                <?php
                                    }
                                } else {
                                    ?>
                <tr>
                  <td colspan="3" align="center" height="200px;" valign="middle"><strong>No Record Found</strong></td>
                </tr>
                <?php } ?>
              </table>
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
                
                <select class="input1" 'selected'="" style="width:200px;" method="post" name="data[Businesstypeprocessorlink][businessTypeID]">
                <option>Select Account Type</option>
                <?php foreach($accountType as $key =>$value) {?>
                <option value="<?php echo $key; ?>" <?php  if($businessTypeID==$key){ ?> selected="selected" <?php } ?>><?php echo $value; ?></option>
                <?php } ?>
                </select>
                
              <!-- <?php    
                  echo $this->Form->select('Businesstypeprocessorlink.businessTypeID', $accountType, array('escape' => false, 'empty' => 'Select Account Type', 'class' => 'input1', 'method' => 'post', 'style' => 'width:200px;',$selected)); ?>-->
                  
                  </td>
                </tr>
                <tr>
                  <td> Payment Methods: </td>
                  <td><?php echo $this->Form->input('processorPayMethod',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                  <td>CC<br />
                    DD </td>
                  <td> ACH<br />
                    Debit </td>
                </tr>
                <tr>
                  <td> On shore: </td>
                  <td><?php echo $this->Form->input('processorOnShore',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                  <td>Minimum Amount:<br />
                    DD </td>
                  <td><?php echo $this->Form->input('processorMinAmount',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                </tr>
                <tr>
                  <td> Buy Rate: </td>
                  <td><?php echo $this->Form->input('processorBuyRate',array('label'=>'','class'=>'input1', 'style' => 'width:200px;')); ?> </td>
                  <td>Split Rate: </td>
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