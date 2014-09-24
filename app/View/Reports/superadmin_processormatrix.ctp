<?php //pr($domestic_processor)?>
<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <div class="news_indent"> 
          <?php echo $this->Form->create('Report',array('action'=>'searhprocessormatrix'));?>
           <table width="100%" cellspacing="0" cellpadding="0" border="0" class="form_table">
              <tr height="35">
                <td width="18%" valign="top" align="left" style="padding:0px;"><span style="font:14px arial;">Select International/Domestic:</span></td>
                 <td width="30%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('processor_type',array('type'=>'select','options'=>array('domestic'=>'Domestic','international'=>'International'),'empty'=>'ALL','div'=>false,'label'=>false,'style'=>'width:290px;'));?>
	             </td>
				 <td width="15%" valign="top" align="left"><span style="font:14px arial;">Select Business Type:</span></td>
                 <td width="30%" valign="top" style="padding:0px;"><?php echo $this->Form->input('business_type',array('type'=>'select','multiple'=>'multiple','options'=>$business_type_options,'div'=>false,'label'=>false,'style'=>'width:90%;'));?></td>
                 <td width="30%" valign="top" style="padding:0px;"></td>
              </tr>
              <tr height="35">
                <td width="10%" valign="top" align="left"><span style="font:14px arial;">Select Processor Status:</span></td>
                 <td width="20%" valign="top" style="padding:0px;">
	                <?php echo $this->Form->input('processor_status',array('type'=>'select','options'=>array('1'=>'Active','0'=>'Inactive'),'empty'=>'ALL','div'=>false,'label'=>false,'style'=>'width:290px;'));?>
	             </td>
				 <td width="03%" valign="top" align="left">&nbsp;</td>
                 <td width="20%" valign="top" style="padding:0px;"><input type="submit" value="Search" class="cursorclass ui-state-default ui-corner-all" name="Submit"></td>                 
              </tr>
            </table>
          <?php $this->Form->end();?>
          </div>  
          <div class="breadcrumb">Domestic Processors:</div>          
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col"> Business Type</th>
                  <th align="center" valign="top" scope="col">&nbsp;</th>
                  <?php foreach($domestic_processor as $proId => $proName){?>
                  <th align="center" valign="top" scope="col"><?php echo $proName;?></th>  
                  <?php }?>               
                </tr>
                <?php if(count($domestic_processor)>0){?>
                <?php foreach($business_type as $busi_type){?>
                <?php if(count($busi_type['Subcat'])>0){?>
	                <?php foreach($busi_type['Subcat'] as $key => $busi_sub_type){?>
		                <tr>
			              <?php if($key==0){?>
			                <td align="center" valign="top" <?php if(count($busi_type['Subcat'])>1){ echo 'rowspan="'.count($busi_type['Subcat']).'"'; }?>> <?php echo $busi_type['Businesscat']['category_name'];?></td>
			              <?php }?>
		                
		                  <td align="center" valign="top"><?php echo $busi_sub_type['category_name'];?></td>
		                
		                  <?php foreach($domestic_processor as $proId => $proName){?>
		                  	<td align="center" valign="top"><?php echo $common->getProcessorMatrix($busi_sub_type['id'],$proId);?></td>
		                  <?php }?>
		                </tr>
	                <?php } // end of business sub type foreach?>
	           <?php }else{?>
	           			<tr>			              
			              <td align="center" valign="top"> <?php echo $busi_type['Businesscat']['category_name'];?></td>
			              <td align="center" valign="top">&nbsp;</td>
		                  <?php foreach($domestic_processor as $proId => $proName){?>
		                  	<td align="center" valign="top"><?php echo $common->getProcessorMatrix($busi_type['Businesscat']['id'],$proId);?></td>
		                  <?php }?>
		                </tr>
	           <?php } // end of if ?>
                <?php } // end of business type foreach?>
              <?php }else{?>
              			<tr>			              
			              <td align="center" valign="top" colspan="2">There is No Domestic Processors availbale.</td>
		                </tr>
              <?php }?>  
              </table>
            </div>
          </div>
          <div class="clear"></div>
          
          <!-- display box / first --> 
        </div>
        <!-- end table --> 
        <div class="box1"> 
          <div class="breadcrumb">International Processors: </div>
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
            <div class="table autoscroll">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="center" valign="top" scope="col"> Business Type</th>
                  <th align="center" valign="top" scope="col">&nbsp;</th>
                  <?php foreach($international_processor as $proId => $proName){?>
                  <th align="center" valign="top" scope="col"><?php echo $proName;?></th>  
                  <?php }?>               
                </tr>
                <?php if(count($international_processor)>0){?>
                <?php foreach($business_type as $busi_type){?>
                <?php if(count($busi_type['Subcat'])>0){?>
	                <?php foreach($busi_type['Subcat'] as $key => $busi_sub_type){?>
		                <tr>
			              <?php if($key==0){?>
			                <td align="center" valign="top" <?php if(count($busi_type['Subcat'])>1){ echo 'rowspan="'.count($busi_type['Subcat']).'"'; }?>> <?php echo $busi_type['Businesscat']['category_name'];?></td>
			              <?php }?>
		                
		                  <td align="center" valign="top"><?php echo $busi_sub_type['category_name'];?></td>
		                
		                  <?php foreach($international_processor as $proId => $proName){?>
		                  	<td align="center" valign="top"><?php echo $common->getProcessorMatrix($busi_sub_type['id'],$proId);?></td>
		                  <?php }?>
		                </tr>
	                <?php } // end of business sub type foreach?>
	           <?php }else{?>
	           			<tr>			              
			              <td align="center" valign="top"> <?php echo $busi_type['Businesscat']['category_name'];?></td>
			              <td align="center" valign="top">&nbsp;</td>
		                  <?php foreach($international_processor as $proId => $proName){?>
		                  	<td align="center" valign="top"><?php echo $common->getProcessorMatrix($busi_type['Businesscat']['id'],$proId);?></td>
		                  <?php }?>
		                </tr>
	           <?php } // end of if ?>
                <?php } // end of business type foreach?>
              <?php }else{?>
              			<tr>			              
			              <td align="center" valign="top" colspan="2">There is No International Processors availbale.</td>
		                </tr>
              <?php }?>         
              </table>
            </div>
          </div>
          <div class="clear"></div>
          
          <!-- display box / first --> 
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
<script type="text/javascript">
jQuery.noConflict();
jQuery("#ReportBusinessType").multiselect({});
</script>