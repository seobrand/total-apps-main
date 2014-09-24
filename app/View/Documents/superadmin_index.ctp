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
                <div class="titlebar">Document List
                  <!--<div style="float:right"> <a href="<?php echo $this->webroot; ?>superadmin/documents/addDocument">Add New</a> </div>-->
                </div>
                <div class="box">
                  <div class="display_row">
                    <div class="table">
                    <?php  
			$userId=$this->Session->read('UserAuth.User.id');?>
					<?php //pr($documentList); ?>
						<table width="100%">
							<tr>
								<th>Title</th>
								<th>Folder Name</th>
								<th>File Name</th>
							</tr>
						<?php foreach($documentList as $value){ 
						
						$uploadedFolder=$common->getFolderName($value['Document']['folder_id']);
						?>
							<tr>
								<td align="center"><?php echo $value['Document']['title'] ?></td>
								<td align="center"><?php echo $value['Folder']['title'] ?></td>
								
								<td align="center">
								<?php if($value['Document']['documenttype']=='1'){ 
								echo $this->Html->script('jquery-1.8.0.min.js');
								echo $this->Html->script('jwplayer.js');
								?>
						

							<div style="min-height:150px;">
							<object width="200" height="150" type="application/x-shockwave-flash" data="<?php echo $this->webroot; ?>player.swf" id="player_resRemote">
							<param name="movie" value="<?php echo $this->webroot; ?>player.swf" />
							<param name="flashvars" value="file=<?php echo FULL_BASE_URL.router::url('/',false).'folders/'.''.$userId.'/'.$uploadedFolder.'/'.$value['Document']['file_path'];?>&autostart=false" />
							</object>
							</div>
							
								<?php }
								else
								{?>
									<a href="<?php echo FULL_BASE_URL.router::url('/',false).'folders/'.''.$userId.'/'.$uploadedFolder.'/'.$value['Document']['file_path'];?>" target="_blank">Download</a>
								<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</table>
                   
                      <div class="paginator">
                        <?php if(count(documentList)>10):?>
                        <?php echo $this->element('admin-paging');?>
                        </td>
                        <?php endif;?>
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