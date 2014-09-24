<?php 

          	echo $this->Html->css('style_preview.css');
		
		echo $this->Html->script('popup.js');
?>
<style>
 #content-pane
 {
 	top:0px!important;
 }
 .window
 {
 left:0px!important;
 margin:auto;
 }
 #boxes
 {
 
 }
 </style>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('generalinformation'); ?>
        <div class="display_row">
          <div class="tabs_outer"> <?php echo $this->element('usersmenu'); ?> </div>
          <div class="tabs_des">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
              <tr>
                <td width="33%" align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('plugin' => 'Usermgmt','controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><strong>AGENT AGREEMENT:</strong></td>
                        <td align="left" valign="top" class="red">
                         <?php 
                                        if($this->request->data['User']['agent_doc'])
			                            {?>
                        <a href="#popup1" id="automatic_click" name="modal" > view </a>
                      <?php }  ?>
                        
                        <div id="boxes">
                            <div id="popup1" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);"> 
                            
                              <div class="popup_outer2" style="width: 718px;left:0px;margin:auto;z-index:99999999999;">
                              <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
                                <div class="stroke" style="overflow: visible;">
                                  <div class="popup_container2">
                                    <div class="popup_indent" style="padding:0 0 0 0">
                                    <?php 
                                        if($this->request->data['User']['agent_doc'])
			                            {
            			                   $url=FULL_BASE_URL.Router::url('/', false).'files/userdocument/'.$this->request->data['User']['agent_doc'];
                        			    }
                                        
                                          if(substr(strrchr($this->request->data['User']['referral_doc'],'.'),1)!='docx')
                                  {
                          ?>
                                     <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:700px; height:500px;" frameborder="0"></iframe>
                                       <br /><br />
                                   
                                      <?php
                                      
                                      } 
                           			    if($this->request->data['User']['agent_doc'])
                                        {
                                    
                                          echo $this->Html->link('Download',$url);
                                        }
                           			 ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Mask to cover the whole screen -->
                            <div id="mask">&nbsp;</div>
                          </div>
                        
                        
                       
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('agent_doc', array('type' => 'file', 'label' => '')); ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['agent_doc']));
                                                        echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'AGENT'));
                                                        echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    <?php echo $this->Form->end(); ?> </div></td>
                <td width="33%" align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><strong>REFERRAL AGREEMENT:</strong></td>
                        <td align="left" valign="top" class="red"><?php 
                            if($this->request->data['User']['referral_doc'])
                            {
                           // echo $this->Html->link('Download',FULL_BASE_URL.Router::url('/', false).'files/userdocument/'.$this->request->data['User']['referral_doc']);
                           ?>
                             <a href="#popup2" id="automatic_click" name="modal" > view </a>
                           <?php
                            }
                            ?>
                        
                        <div id="boxes">
                            <div id="popup2" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);"> 
                              <div class="popup_outer2" style="width: 718px;left:0px;margin:auto;z-index:99999999999;">
                              <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
                                <div class="stroke" style="overflow: visible;">
                                  <div class="popup_container2">
                                    <div class="popup_indent" style="padding:0 0 0 0">
                                    <?php 
                                        if($this->request->data['User']['referral_doc'])
			                            {
            			                   $url=FULL_BASE_URL.Router::url('/', false).'files/userdocument/'.$this->request->data['User']['referral_doc'];
                        			    }
                                        
                                            if(substr(strrchr($this->request->data['User']['referral_doc'],'.'),1)!='docx')
                                  {
                                  
                          ?>
                                     <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:700px; height:500px;" frameborder="0"></iframe>
                                       <br /><br />
                                   
                                      <?php 
                                      }
                           			    if($this->request->data['User']['referral_doc'])
                                        {?>
                                      
                                        <?php 
                                    
                                         echo $this->Html->link('Download',$url);
                                          
                                        }
                           			 ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Mask to cover the whole screen -->
                            <div id="mask">&nbsp;</div>
                          </div>
                            
                          
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2">
                        
                        <?php echo $this->Form->input('referral_doc', array('type' => 'file', 'label' => '')); ?> 
                        
                        
                        
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['referral_doc']));
                                                        echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'REFERAL'));
                                                        echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    
                    <?php echo $this->Form->end(); ?> </div></td>
                <td width="33%" align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><strong>PHOTO ID:</strong></td>
                        <td align="left" valign="top" class="red"><?php 
                            if($this->request->data['User']['photo_doc'])
                            {
                           // echo $this->Html->link('Download',FULL_BASE_URL.Router::url('/', false).'files/userdocument/'.$this->request->data['User']['photo_doc']);
                            ?>
                            <a href="#popup3" id="automatic_click" name="modal" > view </a>
                            <?php
                            }
                            ?>
                            
                            
                            <div id="boxes">
                            <div id="popup3" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);"> 
                              <div class="popup_outer2" style="width: 718px;left:0px;margin:auto;z-index:99999999999">
                              <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
                                <div class="stroke" style="overflow: visible;">
                                  <div class="popup_container2">
                                    <div class="popup_indent" style="padding:0 0 0 0">
                                    <?php 
                                        if($this->request->data['User']['photo_doc'])
			                            {
            			                   $url=FULL_BASE_URL.Router::url('/', false).'files/userdocument/'.$this->request->data['User']['photo_doc'];
                        			    }
                                        
                                        
                                           if(substr(strrchr($this->request->data['User']['photo_doc'],'.'),1)!='docx')
                                  {
                                  
                          ?>
                                     <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:700px; height:500px;" frameborder="0"></iframe>
                                       <br /><br />
                                   
                                      <?php 
                                      }
                                      
                           			    if($this->request->data['User']['photo_doc'])
                                        {?>
                                      
                                        <?php 
                                    
                                         echo $this->Html->link('Download',$url);
                                          
                                        }
                           			 ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Mask to cover the whole screen -->
                            <div id="mask">&nbsp;</div>
                          </div>
                            
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('photo_doc', array('type' => 'file', 'label' => '')); ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['photo_doc']));
                                                        echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'PHOTOID'));
                                                        echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    <?php echo $this->Form->end(); ?> </div></td>
              </tr>
              <tr>
                <td align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('plugin' => 'Usermgmt','controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><strong>VOIDED CHECK</strong></td>
                        <td align="left" valign="top" class="red">
                        	<?php 
                            
                            if($this->request->data['User']['video_doc'])
                            {
                      
                         ?>
                           <a href="#popup4" id="automatic_click" name="modal" > view </a>
                           <?php 
                            }
                            ?>
                            
                            <div id="boxes">
                            <div id="popup4" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);"> 
                              <div class="popup_outer2" style="width: 718px;left:0px;margin:auto;z-index:99999999999;" onclick="javascript:void(0)">
                              <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
                                <div class="stroke" style="overflow: visible;">
                                  <div class="popup_container2">
                                    <div class="popup_indent" style="padding:0 0 0 0">
                                    <?php 
                                        if($this->request->data['User']['video_doc'])
			                            {
            			                   $url=FULL_BASE_URL.Router::url('/', false).'files/userdocument/'.$this->request->data['User']['video_doc'];
                        			    }
                                        
                                        if(substr(strrchr($this->request->data['User']['video_doc'],'.'),1)!='docx')
                                  {
                          ?>
                               
                                  
                                     <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:700px; height:500px;" frameborder="0"></iframe>
                                   
                                     
                                       <br /><br />
                                   
                                      <?php 
                                         }
                                      
                           			    if($this->request->data['User']['video_doc'])
                                        {?>
                                      <a href="<?php echo $url;?>" target="_blank" style="z-index:999999999">Download</a>
                                        <?php 
                                    
                                        // echo $this->Html->link('Download',$url);
                                          
                                        }
                           			 ?>
                                    </div>
                                    <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Mask to cover the whole screen -->
                            <div id="mask">&nbsp;</div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('video_doc', array('type' => 'file', 'label' => '')); 
                        
                        ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['photo_doc']));
                                                        echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'VIDEODOC'));
                                                        echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    <?php echo $this->Form->end(); ?> </div></td>
                <td align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" height="16px;"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><strong>Status:</strong></td>
                        <td align="left" valign="top" class="red"><?php 
                        $option=array('0'=>'Not completed','1'=>'Complete');
                      	echo $this->Form->Select('doc_status',$option,array('empty'=>'Select Status'));
                        ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                
                                echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'STATUS'));
                                echo $this->Form->submit('Save', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    <?php echo $this->Form->end(); ?> </div></td>
                <td align="left" valign="top"></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
