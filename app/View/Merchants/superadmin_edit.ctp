<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> 
      <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="note">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
		  <div class="box1">
		  		<div class="news_announcement">
                	<div class="titlebar">Merchant Notes
						<div style="float:right">
							<a href="<?php echo $this->webroot; ?>superadmin/merchants/appointments/<?php echo $this->request->data['Merchant']['id']; ?>#appointment">Next</a>
					</div>
					</div>
            <div class="links_col">
              <ul class="links">
                <li class="active" id="merchant-notes-li"><a href="javascript:void(0)" onclick="showMerchantNotes('merchant-notes','merchant-add-note')">View Notes:</a></li>
                <li id="merchant-add-note-li"><a href="javascript:void(0)" onclick="showMerchantNotes('merchant-add-note','merchant-notes')">Add Notes:</a></li>
              </ul>
            </div>
            <div class="box">
              <div class="display_row" >
                <div class="table mechant_edit" id="merchant-notes">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <!--<th width="8%" align="left" valign="top" scope="col">Subject</th>-->
                      <th width="60%" align="center" valign="top" scope="col">Notes</th>
                     <?php /*?> <th width="10%" align="center" valign="top" scope="col">View</th><?php */?>
                      <th width="10%" align="center" valign="top" scope="col">Entered By</th>
                      <th width="12%" align="center" valign="top" scope="col"> Date Created </th>
					
                      <th width="12%" align="center" valign="top" scope="col"> Action </th>
                     
                    </tr>
					<?php foreach($merchnatNotes as $key => $notes):?>
                    <tr>
                      <!--<td align="left" valign="top"><?php echo $notes['Merchantnote']['enteredBy']; ?></td>-->
                      <td align="left" valign="top"><?php echo nl2br($notes['Merchantnote']['note']); ?></td>
                      <td align="center" valign="top"><?php echo $notes['User']['user_Name'];  ?></td>
                      <td align="left" valign="top"><?php echo $notes['Merchantnote']['timeStamp']; ?></td>
                 
					  <td align="center" valign="top">
					  <?php if($notes['Merchantnote']['delete']=='Y'){ echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("Are you sure to delete this note?");','url' => array('controller' => 'merchants', 'action' => 'deleteNote', $notes['Merchantnote']['merchantNoteID'],$notes['Merchantnote']['merchantID']))); }?>
					  </td>
                     
                    </tr>
                    <?php endforeach;?>
					<?php if(count($merchnatNotes)==0):?>
					<tr>
                      <td align="center" valign="top" colspan="4">No Results Found</td>
                    </tr>
					<?php endif;?>
                  </table>
                </div>
				<div class="table" id="merchant-add-note" style="display:none">
				<?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'edit','onsubmit'=>'return validation();')); ?> 
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                <tr>
                  <td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><strong>New Note</strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><?php echo $this->Form->input('Merchantnote.note', array('label'=>'','type' => 'textarea','class'=>'textarea1'));?></td>
                      </tr>
                      
                      <tr>
                        <td align="left" valign="top"><?php echo $this->Form->submit('Add Note',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
                      </tr>
                    </table></td>
                  <td width="30%" align="left" valign="top" style="padding:0 0 0 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><strong>Viewable By </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="36%" align="left" valign="middle">Agent </td>
                              <td width="64%" align="left" valign="middle"> <?php echo $this->Form->checkbox('Merchantnote.agentView', array('value' => 1)); ?></td>
                            </tr>
                           
                           <tr style="display:none"> 
                              <td align="left" valign="middle">Manager </td>
                              <td align="left" valign="middle"> <?php echo $this->Form->checkbox('Merchantnote.managerView', array('value' => 1,'checked'=>'checked')); ?></td>
                            </tr>
          
                            <tr>
                              <td align="left" valign="middle">Iso </td>
                              <td align="left" valign="middle"> <?php echo $this->Form->checkbox('Merchantnote.isoView', array('value' => 1)); ?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle">Processor </td>
                              <td align="left" valign="middle"> <?php echo $this->Form->checkbox('Merchantnote.processorView', array('value' => 1)); ?></td>
                            </tr>
							<tr>
                              <td align="left" valign="middle">Referral </td>
                              <td align="left" valign="middle"> <?php echo $this->Form->checkbox('Merchantnote.referalView', array('value' => 1)); ?></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
			<?php echo $this->Form->input('Merchantnote.merchantID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['id']));?>
			<?php echo $this->Form->input('Merchantnote.enteredBy', array('type' => 'hidden','value'=>$this->Session->read('UserAuth.User.id')));?>
			<?php echo $this->Form->input('Merchantnote.statusID', array('type' => 'hidden','value'=>$this->request->data['Merchant']['statusID']));?>
			<?php echo $this->Form->input('Merchantnote.agentEmail', array('type' => 'hidden','value'=>$this->request->data['Agent']['userEmail']));?>
			<?php echo $this->Form->input('Merchantnote.proEmail', array('type' => 'hidden','value'=>$this->request->data['Processor']['userEmail']));?>
			<?php echo $this->Form->input('Merchantnote.managerEmail', array('type' => 'hidden','value'=>$this->request->data['Manager']['userEmail']));?>
			<?php echo $this->Form->input('Merchantnote.isoEmail', array('type' => 'hidden','value'=>$this->request->data['ISO']['userEmail']));?>
			<?php echo $this->Form->input('Merchantnote.referalEmail', array('type' => 'hidden','value'=>$this->request->data['Referal']['userEmail']));?>
			<?php echo $this->Form->end();?>
			  	</div>
              </div>
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
function showMerchantNotes(showId,HideId){
	document.getElementById(showId+'-li').className = 'active';
	document.getElementById(showId).style.display = 'block';
	document.getElementById(HideId+'-li').className = '';	
	document.getElementById(HideId).style.display = 'none';
}

function validation(){
	if(document.getElementById('MerchantnoteNote').value==''){
		alert("Please enter your note");
		return false
	}else{
		true;
	}

}

</script>