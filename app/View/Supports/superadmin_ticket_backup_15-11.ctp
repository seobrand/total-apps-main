<?php echo $this->Html->script('table_sorter/jquery.tablesorter.js'); ?>
<script type="text/javascript">
 jq = jQuery.noConflict();
 jq(document).ready(function() 
 { 
	 jq("#support_ticket").tablesorter({
		    headers: {6: {sorter: false}}
	 }); 
 } 
); 
</script>

<?php 
$userID 	= $this->Session->read('UserAuth.User.id');
$userRoleID = $this->Session->read('UserAuth.User.user_group_id');
$ticketIDs = $common->getTicketSubmitByUser($userID,$userRoleID);
?>

<?php $j=1;?>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <!-- display box / first -->
        <div class="box">
          <div class="display_row">
            <div class="news_indent">
              <div class="news_announcement">
                <div class="titlebar">All Open Tickets                 
                </div>
                <div class="box">
                  <div class="display_row">
                    <div class="table">
					<table width="100%" id="support_ticket" class="tablesorter">
					<thead>
					  <tr>
					  	<th width="6%">Ticket#</th>
					  	<th width="10%">Status</th>
					  	<th width="10%">Type</th>
						<th width="18%">Subject</th>
						<th width="35%">Description</th>
						<th width="10%">Group</th>
						<th width="10%">Actions</th>
					  </tr>
					 </thead>
					 <tbody>
				<?php if($userRoleID=='20' || $userRoleID =='22' || $userRoleID =='23' || $userRoleID =='24' || $userRoleID =='25'){?> 
					 <?php foreach($alltickets as $ticket){ ?>
					 <?php if(in_array($ticket['nice_id'], $ticketIDs)){?>
					 <tr>
					 	<td align="center"><?php echo $ticket['nice_id'];?></td>
					 	<td align="center"><span class="statusIcon"><?php echo $this->Html->image($common->getStatusImage($ticket['status_id']),array('height'=>12));?></span>&nbsp;&nbsp;<strong><?php echo $common->getZendeskStatusName($ticket['status_id']);?></strong></td>
					 	<td align="center"><?php echo $common->getZendeskTicketType($ticket['ticket_type_id']);?></td>
						<td align="left"><?php echo $ticket['subject'] ?></td>
						<td align="left"><?php echo nl2br($ticket['description']);?></td>
						<td align="center"><?php echo $common->getZendeskGroupInfo($ticket['group_id']); ?></td>
						<td align="center">
							<?php echo $this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','onclick'=>"addComment(".$ticket['nice_id'].",".$ticket['status_id'].",".$ticket['ticket_type_id'].",'".$ticketuser['name']."','".$ticketuser['email']."')",'style'=>'cursor:pointer'));?>&nbsp;
							<?php echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("Are you sure to delete this entry?");','url' =>array('controller'=>'supports','action'=>'deleteticket', $ticket['nice_id'])));?>&nbsp;
							<?php echo $this->Html->image("view.png", array('alt'=>'View','title'=>'view','onclick'=>"popClick('showcomment_".$j."')",'style'=>'cursor:pointer;width:24px;'));?>
						</td>
					</tr>
					<a href="#?w=600" rel="comment_<?php echo $j;?>" class="poplight" style="display:none;"><input type="hidden" id="showcomment_<?php echo $j;?>"/></a>
					  <div id="comment_<?php echo $j;?>" class="popup_block_new"><?php echo $this->Html->image("close_popup.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close_pop'));?>
					   <div id="show_message<?php echo $j;?>" style="text-align:left;height:400px; overflow:auto;" class="content">					   
					    <span><strong>Ticket Submitted By : <?php echo $ticketuser['name']." (".$ticketuser['email'].")";?></strong></span>
					    <?php foreach($ticket['comments'] as $key => $comment){?>
					     <?php $commentBy = $common->getZendeskUserInfo($comment['author_id']);?>
						    <div style="padding-top:15px;">
						    	<span style="font-size: 18px;font-weight: bold;padding-bottom:10px;"><?php echo $commentBy['name'];?></span>&nbsp;&nbsp;<?php echo date("F d,Y h:i A",strtotime($comment['created_at']));?> <br/>
						    	<div style="padding-top:10px;"><?php echo nl2br($comment['value']);?></div>
						    </div>							
					    <?php }?>
						</div>
					</div>
				    <?php $j++; }/*end of if */ }?>
				    
			<?php }else{ /** shows all tickets to agent,support and technicals **/?>
					
					<?php foreach($alltickets as $ticket){ ?>
					<?php $ticketuser = $common->getZendeskUserInfo($ticket['requester_id']);?>									 
					 <tr>
					 	<td align="center"><?php echo $ticket['nice_id'];?></td>
					 	<td align="center"><span class="statusIcon"><?php echo $this->Html->image($common->getStatusImage($ticket['status_id']),array('height'=>12));?></span>&nbsp;&nbsp;<strong><?php echo $common->getZendeskStatusName($ticket['status_id']);?></strong></td>
					 	<td align="center"><?php echo $common->getZendeskTicketType($ticket['ticket_type_id']);?></td>
						<td align="left"><?php echo $ticket['subject'] ?></td>
						<td align="left"><?php echo nl2br($ticket['description']);?></td>
						<td align="center"><?php echo $common->getZendeskGroupInfo($ticket['group_id']); ?></td>
						<td align="center">
							<?php echo $this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','onclick'=>"addComment(".$ticket['nice_id'].",".$ticket['status_id'].",".$ticket['ticket_type_id'].",'".$ticketuser['name']."','".$ticketuser['email']."')",'style'=>'cursor:pointer'));?>&nbsp;
							<?php echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("Are you sure to delete this entry?");','url' =>array('controller'=>'supports','action'=>'deleteticket', $ticket['nice_id'])));?>&nbsp;
							<?php echo $this->Html->image("view.png", array('alt'=>'View','title'=>'view','onclick'=>"popClick('showcomment_".$j."')",'style'=>'cursor:pointer;width:24px;'));?>
						</td>
					</tr>
					<a href="#?w=600" rel="comment_<?php echo $j;?>" class="poplight" style="display:none;"><input type="hidden" id="showcomment_<?php echo $j;?>"/></a>
					  <div id="comment_<?php echo $j;?>" class="popup_block_new"><?php echo $this->Html->image("close_popup.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close_pop'));?>
					   <div id="show_message<?php echo $j;?>" style="text-align:left;height:400px;overflow:auto;" class="content">					   
					    <span><strong>Ticket Submitted By : <?php echo $ticketuser['name']." (".$ticketuser['email'].")";?></strong></span>
					    <?php foreach($ticket['comments'] as $key => $comment){?>
					    <?php $commentBy = $common->getZendeskUserInfo($comment['author_id']);?>
					    <div style="padding-top:15px;">
					    	<span style="font-size: 18px;font-weight: bold;padding-bottom:10px;"><?php echo $commentBy['name'];?></span>&nbsp;&nbsp;<?php echo date("F d,Y h:i A",strtotime(substr($comment['created_at'], 0, -6)));?> <br/>
					    	<div style="padding-top:10px;"><?php echo nl2br($comment['value']);?></div>
					    </div>					    
					    <?php }?>
						</div>
					</div>
				    <?php $j++; }?>
			<?php } ?>
					
					<?php /******* If there is no ticket available **/ ?>
				    <?php if($j==1){?>
				    <tr>
						<td align="center" colspan="7">No Tickets Available.</td>
					</tr>
				    <?php }?>
				   </tbody>
				  </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Div for add new comment start -->
<a href="#?w=500" rel="addcomment" class="poplight" style="display:none;"><input type="hidden" id="add_comment_div"/></a>
<div id="addcomment" class="popup_block_new"><?php echo $this->Html->image("close_popup.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close_pop'));?>
 <!-- Form start -->
          <div class="display_row"> 
            <div class="comment_titlebar"><strong>Edit Ticket</strong></div>                
                <div class="comment_table">
                    <?php echo $this->Form->create("Support",array('action'=>'addcomment','onsubmit'=>'return checkComment();'))?>
					<table width="100%" border="1">
					<tr height="20">
					 <td width="15%" align="left">Name&nbsp;&nbsp;</td>
					 <td align="left"><strong><span id="zendeskuser"></span></strong></td>
					</tr>					
					<tr height="35">
					 <td width="15%" align="left">Status&nbsp;&nbsp;</td>
					 <td align="left"><?php echo $this->Form->input('status_id',array('type'=>'select','options'=>array('1'=>'Open','2'=>'Pending','3'=>'Solved','4'=>'Closed'),'class'=>'','label'=>false,'div'=>false))?></td>
					</tr>
					<tr height="35">
					 <td width="15%" align="left">Type&nbsp;&nbsp;</td>
					 <td align="left"><?php echo $this->Form->input('type_id',array('type'=>'select','options'=>array('0'=>'No Type Set','1'=>'Question','2'=>'Incident','3'=>'Problem','4'=>'Task'),'class'=>'','label'=>false,'div'=>false))?></td>
					</tr>
					<tr height="35">
					 <td width="15%" align="left">Add Comment&nbsp;&nbsp;</td>
					 <td align="left"><?php echo $this->Form->input('comment',array('type'=>'textarea','class'=>'textarea_new','label'=>false,'div'=>false))?></td>
					</tr>
					<tr height="35">
					 <td align="center" colspan="2"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'))?></td>
					</tr>
					</table>	
					<?php echo $this->Form->input('ticketID',array('type'=>'hidden','id'=>'ticketID'))?>
				<?php echo $this->Form->end();?>				
				</div>
          </div>
          
</div>

<script type="text/javascript">
function closePopup(){
	document.getElementById("closelink").click();
}
function popClick(id){	
    document.getElementById(id).click();
}
function addComment(ticketID,statusID,typeID,zendeskUser,zendeskuseremail){
	document.getElementById('ticketID').value= ticketID;
	document.getElementById('zendeskuser').innerHTML = zendeskUser+'&nbsp;('+zendeskuseremail+')';	
	// make selection of status filed    
 	var status = document.getElementById('SupportStatusId');
    status.value = statusID;
 	// make selection of type filed    
 	var type = document.getElementById('SupportTypeId');
 	type.value = typeID;   
	
	document.getElementById('add_comment_div').click();		  
}
function checkComment(){
	if(document.getElementById('SupportComment').value==''){
		alert("Please Enter Comment");
		return false;
	}
	return true;	
}

</script>
