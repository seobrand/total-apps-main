<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <br />
      <br />
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">add document
            <div style="float:right"> <a href="<?php echo $this->webroot; ?>superadmin/documents/listDocument"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a> </div>
          </div>
          <div class="box">
            <div class="display_row"> <?php echo $this->Form->create('Document', array('action'=>'editDocument','id'=>'form', 'enctype' => 'multipart/form-data')); ?>
              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
            <?php  
			$userId=$this->Session->read('UserAuth.User.id');
			$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
			$option=$common->getFolderList($userId,$userGroupId);?>
               <tr>
                  <td align="right" valign="top">Select Folder<span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Document.folder_id" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2','type'=>'select','options'=>$option,'empty'=>false,'disabled'=>'disabled'));
				  
				  
				  echo $this->Form->input("Document.folder_ids" ,array('type' => 'hidden','value'=>$this->request->data['Document']['folder_id'],'label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
				  
				  ?> 
                  
                  
                  
                  </td>
                </tr>
              
               
                <tr>
                  <td align="right" valign="top">Title<span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Document.title" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                
                 <?php  
			 $option=array('0'=>'document','1'=>'Video')?>
               <tr>
                  <td align="right" valign="top">Document Type <span class="required">*</span>:</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Document.documenttype" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2','type'=>'select','options'=>$option,'empty'=>false))?> </td>
                </tr>
                
                 <tr>
                  <td align="right" valign="top">File<span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Document.file" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2','type'=>'file'))?>
                 <br>
				 <br>
				 <br>
				 <br>
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
							<param name="flashvars" value="file=<?php echo FULL_BASE_URL.router::url('/',false).'folders/'.$uploadedFolder.'/'.$this->request->data['Document']['file_path'];?>&autostart=false" />
							</object>
						</div>
					<?php
					}else
					{
					 ?>
					 <a href="<?php echo FULL_BASE_URL.router::url('/',false).'folders/'.''.$userId.'/'.$uploadedFolder.'/'.$this->request->data['Document']['file_path'];?>" target="_blank">Download</a>
					 <?php
					}
				 ?>
                   </td>
                </tr>
                
                 <tr>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
				  
				  <?php
				  echo $this->Form->input("Document.id" ,array('type' => 'hidden','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
				  
				    echo $this->Form->input("Document.oldfile" ,array('type' => 'hidden','value'=>$this->request->data['Document']['file_path'],'label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
				  
				  echo $this->Form->input("Document.Edit" ,array('type' => 'hidden','value'=>'Edit','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
				   echo $this->Form->submit('SUBMIT',array('name'=>'SUBMIT','value'=>'SUBMIT','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'onsubmit'=>'editor_content()'));?></td>
                </tr>
              </table>
             
             
              <?php echo $this->Form->end(); ?> </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end table -->
  </div>
</div>