<?php echo $this->Html->image("close_popup.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close_pop'));?>
<div class="display_row"> 
            <div class="comment_titlebar"><strong>Edit Ticket</strong></div>                
                <div class="comment_table">
                    <?php echo $this->Form->create("Support",array('action'=>'mojopay_addcomment','onsubmit'=>'return checkComment();'))?>
					<table width="100%" border="1">
					<tr height="20">
					 <td width="15%" align="left">Name&nbsp;&nbsp;</td>
					 <td align="left"><strong><span id="zendeskuser"><?php echo $username?></span></strong></td>
					</tr>					
					<tr height="35">
					 <td width="15%" align="left">Status&nbsp;&nbsp;</td>
					 <td align="left"><?php echo $this->Form->input('status_id',array('type'=>'select','options'=>array('open'=>'open','pending'=>'pending','solved'=>'solved','closed'=>'closed'),'class'=>'','label'=>false,'div'=>false))?></td>
					</tr>
					<tr height="35">
					 <td width="15%" align="left">Type&nbsp;&nbsp;</td>
					 <td align="left"><?php echo $this->Form->input('type_id',array('type'=>'select','options'=>array(''=>'No Type Set','problem'=>'problem','incident'=>'incident','question'=>'question','task'=>'task'),'class'=>'','label'=>false,'div'=>false))?></td>
					</tr>
					<tr height="35">
					 <td width="15%" align="left">Add Comment&nbsp;&nbsp;</td>
					 <td align="left"><?php echo $this->Form->input('comment',array('type'=>'textarea','class'=>'textarea_new','label'=>false,'div'=>false))?></td>
					</tr>
					<tr height="35">
					 <td align="center" colspan="2"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'))?></td>
					</tr>
					</table>	
					<?php echo $this->Form->input('ticketID',array('type'=>'hidden','id'=>'ticketID','value'=>$ticketID))?>
				<?php echo $this->Form->end();?>				
				</div>
          </div>