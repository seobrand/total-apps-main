<?php echo $this->Html->image("close_popup.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close_pop'));?>
<div id="show_message" style="text-align:left;height:400px; overflow:auto;" class="content">					   
					    <span><strong>Ticket Submitted By : <?php echo $username." (".$useremail.")";?></strong></span>
					    <?php foreach($comments as $key => $comment){?>
					     <?php $commentBy = $common->getZendeskUserInfoMojopay($comment['author_id']);?>
						    <div style="padding-top:15px;">
						    	<span style="font-size: 18px;font-weight: bold;padding-bottom:10px;"><?php echo $commentBy['name'];?></span>&nbsp;&nbsp;<?php echo date("F d,Y h:i A",strtotime($comment['created_at']));?> <br/>
						    	<div style="padding-top:10px;"><?php echo nl2br($comment['body']);?></div>
						    </div>							
					    <?php }?>
						</div>