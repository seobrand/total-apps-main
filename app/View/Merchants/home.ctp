<div class="content"> 
  <!-- content / right -->
  <div id="right">
    
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="news_announcement">
            <div class="titlebar">BUSSINESS INFORMATION</div>
            <div class="news_indent">
			<?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'home')); ?>
			  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
                <tr>
                  <td width="100%" align="left" valign="top" style="padding:0px;">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" width="35%" valign="middle">Company Name:</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('merchantName',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">Website:</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalAddress',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">Contact Person:</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalCity',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">Phone Number:</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalState',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">Email Address:</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('legalZip',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">Merchant Type:</td>
                        <td align="left" width="63%" valign="middle">
                        <?php
                        $merchanttype=array('14'=>'Retail Swipe','15'=>'MoTo','16'=>'Cash Advance','17'=>'Other','4'=>'General Ecommerce');
                         echo $this->Form->input('Merchant.statusID',array('type'=>'select','options'=>$merchanttype,'empty'=>'-Select Status-','selected'=>1,'label'=>false,'class'=>'select1')); ?>
                        
                  </td>
                      </tr>
                      <tr>
                        <td align="left" width="35%" valign="middle">Please give a detailed description of product or services:</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('contactPhone',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">Merchant Financial Information</td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('businessFax',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                        <tr>
                        <td align="left" width="35%" valign="middle">CARDHOLDER DESCRIPTOR <em>(21 Characters - Must Include Phone # if Keyed Merchant)</em></td>
                        <td align="left" width="63%" valign="middle"><?php echo $this->Form->input('descriptor',array('label'=>false,'class'=>'input1'));?></td>
                      </tr>
                    </table>
				 </td>
                 
                </tr>
                 
				
                 
				 <tr>
                  <td width="50%" align="left" valign="top" style="padding:0px;">
				  </td>
                  <td width="50%" valign="top" align="left" style="padding:0px;"></td>
                </tr>
				 
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
                <tr>
                  <td>&nbsp;</td>
                  <td align="right" valign="top" style="padding:16px 40px 0 0;"><?php echo $this->Form->submit('Add Merchant',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                </tr>
              </table>
   			<?php echo $this->Form->end();?>
            </div>
          </div>
        </div>
        <!-- end table --> 
      </div>
 
  </div>
  <!-- end content / right --> 
</div>