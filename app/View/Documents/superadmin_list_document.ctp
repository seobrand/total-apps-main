<link media="screen" rel="stylesheet" href="<?php echo FULL_BASE_URL.Router::url('/', false).'css/popup/';?>colorbox.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="<?php echo FULL_BASE_URL.Router::url('/', false).'css/popup/';?>/jquery.colorbox.js"></script>
<script type='text/javascript'>
function popup(testing)
{
	  $.ajax({
               type:"GET",
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>documents/getVideo?file="+testing,
               success : function(data) {
                   document.getElementById("popupvideos").innerHTML = data; 
               },
               error : function() {
               },
           })
	$(".example8").colorbox({width:"50%", inline:true});
}		
</script>
<div style='display:none'>
		<div id='inline_example1' style='padding:10px; background:#fff;'>
			<div id="popupvideos">
			
			</div>
		</div>
</div>

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
            
              <div class="news_announcement">
                <div class="titlebar">Document List
                  <div style="float:right"> <a href="<?php echo $this->webroot; ?>superadmin/documents/addDocument">Add New</a> </div>
                </div>
                <div class="box">
                  <div class="display_row">
                    <div class="table">
                     <?php
					  		//$this->Grid->addColumn('Title', '/Document/title', array('paginate'=>true),'title');
						//	$this->Grid->addColumn('Folder Name', '/Folder/title', array('paginate'=>true),'title');
						//	$this->Grid->addColumn('File Name', '/Document/file_path', array('paginate'=>true),'file_path');				
						//	$this->Grid->addAction('Edit', array('controller' => 'documents', 'action' => 'editDocument'), array('/Document/id'));
						//	$this->Grid->addAction('Delete', array('controller' => 'documents', 'action' => 'deleteDocument'), array('/Document/id'));
						//	echo $this->Grid->generate($documentList);
						?>
                        
                        
                         <!--
                      <div class="paginator">
                        <?php if(count(merchantSearchList)>10):?>
                        <?php echo $this->element('admin-paging');?>
                     
                        <?php endif;?>
                      </div>-->
                      
                          <?php  
			$userId=$this->Session->read('UserAuth.User.id');?>
					<?php //pr($documentList); ?>
						<table width="100%">
							<tr>
								<th width="25%">Title</th>
								<th width="25%">Folder Name</th>
								<th width="25%">File Name</th>
                                <th width="25%">Action</th>
							</tr>
						<?php foreach($documentList as $value){ 
						
						$uploadedFolder=$common->getFolderName($value['Document']['folder_id']);
						?>
							<tr>
								<td align="center"><?php echo $value['Document']['title'] ?></td>
								<td align="center"><?php echo $value['Folder']['title'] ?></td>
								
								<td align="center">
								<?php
								 if($value['Document']['documenttype']=='1')
								 { 
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
                                <td>
                                	<ul class="merchantAction">
                                        <li>
                                        <a href="<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/documents/deleteDocument/<?php echo $value['Document']['id']; ?>">
                                        <img =""="" onclick="return confirm("Are you sure to delete this entry?");" title="Delete" alt="Delete" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/delete_bt.png">
                                      
                                      
                                        </a>
                                        </li>
                                        <li>
                                       <a href="<?php echo FULL_BASE_URL.router::url('/',false);?>superadmin/documents/editDocument/<?php echo $value['Document']['id']; ?>">
                                        <img =""="" title="Edit" alt="Edit" src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/edit.png">
                                        </a>
                                        </li>
                                        </ul>
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