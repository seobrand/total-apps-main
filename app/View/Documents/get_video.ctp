<?php 
$userId=$this->Session->read('UserAuth.User.id');
$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
?>
<div  style="width:500px;">
	<div style="clear:both;height:40px;">
    	<div style="float:left;width:120px;padding:5px;">Title</div>
        <div><?php echo $this->request->data['Document']['title'];?></div>
    </div>
    
    <div style="clear:both">
    	<div style="float:left;width:120px;">File</div>
        <div>
				<?php 
				 $uploadedFolder=$common->getFolderName($this->request->data['Document']['folder_id']);
				 
					if($this->request->data['Document']['documenttype'])
					{
						echo $this->Html->script('jquery-1.8.0.min.js');
						echo $this->Html->script('jwplayer.js');
					?>
						<div style="min-height:150px;">
							<object width="200" height="150" type="application/x-shockwave-flash" data="<?php echo $this->webroot; ?>player.swf" id="player_resRemote">
							<param name="movie" value="<?php echo $this->webroot; ?>player.swf" />
							<param name="flashvars" value="file=<?php echo FULL_BASE_URL.router::url('/',false).'folders/'.$userId.'/'.$uploadedFolder.'/'.$this->request->data['Document']['file_path'];?>&autostart=false" />
							</object>
						</div>
					<?php
					}else
					{
					 ?>
					 <a href="<?php echo FULL_BASE_URL.router::url('/',false).'folders/'.$userId.'/'.$uploadedFolder.'/'.$this->request->data['Document']['file_path'];?>" target="_blank">Download</a>
					 <?php
					}
				 ?>
        
        </div>
    </div>
</div>
