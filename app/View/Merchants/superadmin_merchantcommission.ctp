
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="commission">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
			<div class="box1">
			  <div class="news_announcement">
				<div class="titlebar">Commissions
				<div style="float:right">
							<a href="<?php echo $this->webroot; ?>superadmin/merchants/underwriting/<?php echo $this->request->data['Merchant']['id']; ?>#underwriting">Next</a>
					</div>
				</div>
				<div class="news_indent">
				<?php  echo $this->Form->create('Commission'); ?>
				  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
					<tr>
					 <td width="45%" align="left" valign="top" style="padding:0px;">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td align="left" width="35%" valign="middle">AGENT SPLIT<!-- <span style="color:#FF0000">*</span> --></td>
							<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('agent_split',array('label'=>false,'div'=>false,'class'=>'input1','onKeyPress'=>'return numbersonly(this, event)','maxlength'=>'3'));?> %</td>
						  </tr>
						  <tr>
							<td align="left" width="35%" valign="middle">REFERRAL SPLIT</td>
							<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('referral_split',array('label'=>false,'div'=>false,'class'=>'input1','onKeyPress'=>'return numbersonly(this, event)','maxlength'=>'3'));?> %</td>
						  </tr>						  		  
						</table>
					 </td>
                     <td width="4%"></td>
                     <td width="45%" align="left" valign="top" style="padding:0px;">
                     	<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td align="left" width="35%" valign="middle">ISO SPLIT</td>
							<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('iso_split',array('label'=>false,'div'=>false,'class'=>'input1','onKeyPress'=>'return numbersonly(this, event)','maxlength'=>'3'));?> %</td>
						  </tr>
						  <tr>
							<td align="left" width="35%" valign="middle">TOTAL-APPS SPLIT </td>
							<td align="left" width="63%" valign="middle"><?php echo $this->Form->input('totalapps_split',array('label'=>false,'div'=>false,'class'=>'input1','onKeyPress'=>'return numbersonly(this, event)'));?>%</td>
						  </tr>						  					  
						</table>
                     </td>			 
					</tr>
					<tr height="40">
						<td align="left" width="45%" valign="middle">&nbsp;</td>
						<td align="left" width="4%" valign="middle">&nbsp;</td>
						<td align="right" width="45%" valign="middle" style="padding-right: 35px;"><?php echo $this->Form->submit('Update',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
				  	</tr>	
				  </table>
				  <?php echo $this->Form->input("id",array('type'=>hidden));?>				  
				<?php echo $this->Form->end();?>
				</div>
			  </div>
        	</div>
         </div>
        </div>
        <!-- display box / second end here -->
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>


<script type="text/javascript">
function numbersonly(myfield, e, dec)
	{ var key;var keychar;	
		if (window.event)
		   key = window.event.keyCode;
		else if (e)
		   key = e.which;
		else
		   return true;
		keychar = String.fromCharCode(key);
		// control keys
		if ((key==null) || (key==0) || (key==8) || 
			(key==9) || (key==13) || (key==27) || (key==46) )
		   return true;
		// numbers
		else if ((("0123456789").indexOf(keychar) > -1))
		   return true;
		else
		   return false;
	}
</script>

