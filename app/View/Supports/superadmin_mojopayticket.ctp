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
                <div class="titlebar">All Tickets For MojoPay                 
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
                     <?php //echo "<pre>";print_r($alltickets);
					 foreach($alltickets as $alltickets1){
						 foreach($alltickets1 as $ticket){
							 //$ticketuser = $common->getZendeskUserInfo($ticket['requester_id']);
						
					 ?>
                       <tr>
					 	<td align="center"><?php echo $ticket['id'];?></td>
                        <td align="center"><span class="statusIcon"><?php echo $this->Html->image($common->getStatusImage($ticket['status']),array('height'=>12));?></span>&nbsp;&nbsp;<strong><?php echo $ticket['status'];?></strong></td>
                        <td align="center"><?php if($ticket['type'] != ''){echo $ticket['type'];}else{ echo 'No Type Set';}?></td>
						<td align="left"><?php echo $ticket['subject'] ?></td>
						<td align="left"><?php echo nl2br($ticket['description']);?></td>
                        <td align="center">Support</td>
                       <td align="center">
							<?php echo $this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','onclick'=>"addComment(".$ticket['id'].",'".$ticket['status']."','".$ticket['type']."',".$ticket['requester_id'].")",'style'=>'cursor:pointer'));?>&nbsp;
							<?php echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("Are you sure to delete this entry?");','url' =>array('controller'=>'supports','action'=>'mojopay_deleteticket', $ticket['id'])));?>&nbsp;

							<?php echo $this->Html->image("view.png", array('alt'=>'View','title'=>'view','onclick'=>"popClick(".$ticket['id'].",".$ticket['requester_id'].")",'style'=>'cursor:pointer;width:24px;'));?>

						</td>
                        </tr>
                     <?php }}?>
                     <?php if($alltickets['count']==0){?>
                      <tr>
					 	<td align="center" colspan="7">No Ticket Found..</td>
					  </tr>
                     <?php }?>
				   </tbody>
				  </table>
                 
                  <div class="paginator">
						<table class="pagingview" width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
                          <tbody>
                          <tr>
                          <td align="left" colspan="2">
                          <div class="f_left">
                          <?php
						  for($i=1;$i<=$pagecnt;$i++){
							  if($pageNo == $i){
								  $class="current";
							  }else{
								   $class="";
							  }
						   echo $this->Html->link('<span class="'.$class.'">'.$i.'</span>|', array('action'=>'/ticket/'.$i), array('escape'=>false));
						  }
						   ?>
                         <?php /*?> <span class="current">1</span>|
                          <span class="current">2</span>|
                          <span class="current">3</span>|<?php */?>
                         
                          </div>
                          </td>
                          </tr>
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
</div>
<!-- Div for add new comment start -->
<a href="#?w=500" rel="addcomment" class="poplight" style="display:none;"><input type="hidden" id="add_comment_div"/></a>
<div id="addcomment" class="popup_block_new"></div>
<a href="#?w=600" rel="showcomment" class="poplight" style="display:none;"><input type="hidden" id="show_comment_div"/></a>
<div id="showcomment" class="popup_block_new"></div>
 <div id="spinner" style=" left: 50%;position: fixed;top: 50%; display:none;">
   <?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
  </div>



<script type="text/javascript">
function closePopup(){
	document.getElementById("closelink").click();
}
/*function popClick(id){	
    document.getElementById(id).click();
}
*/
function popClick(ticketID,userId){	
    $("#spinner").css("display", "block");
	get_url = "<?php echo FULL_BASE_URL.router::url('/',false).'superadmin/supports/mojopay_view_ticket_by_ajax/';?>";
	get_url += ticketID+'/'+userId;
	$.ajax({
		type:"GET",
		url:get_url,
		success : function(data){
			$("#spinner").css("display", "none");
		   //document.getElementById('emailBox').style.display='block';
		   document.getElementById('showcomment').innerHTML=data
		   document.getElementById('show_comment_div').click();	
		},
		error : function() {
			$("#spinner").css("display", "none");
		   alert('there is some problem in ajax action.');
		},
	})  
}

function addComment(ticketID,status,type,userId){	
    $("#spinner").css("display", "block");
	get_url = "<?php echo FULL_BASE_URL.router::url('/',false).'superadmin/supports/mojopay_edit_ticket_by_ajax/';?>";
	get_url += ticketID+'/'+userId+'/'+status+'/'+type;
	$.ajax({
		type:"GET",
		url:get_url,
		success : function(data){
		   $("#spinner").css("display", "none");
		   //document.getElementById('emailBox').style.display='block';
		   document.getElementById('addcomment').innerHTML=data
		   document.getElementById('add_comment_div').click();	
		},
		error : function() {
			$("#spinner").css("display", "none");
		   alert('there is some problem in ajax action.');
		},
	})  
}

function checkComment(){
	if(document.getElementById('SupportTypeId').value==''){
		alert("Please select support Type");
		return false;
	}
	if(document.getElementById('SupportComment').value==''){
		alert("Please Enter Comment");
		return false;
	}
	return true;	
}

</script>
