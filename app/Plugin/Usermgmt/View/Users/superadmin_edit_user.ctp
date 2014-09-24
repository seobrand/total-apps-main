
<script>
		$(document).ready(function(){
			$(".example8").colorbox({width:"50%", inline:true});
			$(".example9").colorbox({width:"50%", inline:true});
			$(".example10").colorbox({width:"50%", inline:true});
			$(".example11").colorbox({width:"50%", inline:true});
			
			
		});
		
</script>
<script type="text/javascript">
function agentdoc()
{
	var error='';
	var valid_extensions = /(.doc|.pdf|.docx)$/i;
	var filename=document.getElementById('UserAgentDoc').value;
	if(!filename)
	{
		alert('Please Upload Document for Agent Agreement');
		return false;
	}else if (valid_extensions.test(filename))
	{
	
	}
	else
	{
		alert("Please provide valid file of extension .doc,.pdf")
		return false;
	}
	
}




function referaldoc()
{
	var error='';
	var valid_extensions = /(.doc|.pdf|.docx)$/i;
	var filename=document.getElementById('UserReferralDoc').value;
	
	
	if(!document.getElementById('UserReferralDoc').value)
	{
		alert('Please Upload Document for Referal Agreement');
		return false;
	}else if (valid_extensions.test(filename))
	{
	
	}
	else
	{
		alert("Please provide valid file of extension .doc,.pdf")
		return false;
	}
	
}


function mojoreferaldoc()
{
	var error='';
	var valid_extensions = /(.doc|.pdf|.docx)$/i;
	var filename=document.getElementById('UserMojopayReferral').value;
	
	
	if(!document.getElementById('UserMojopayReferral').value)
	{
		alert('Please Upload Document for Mojo Pay Referal Agreement');
		return false;
	}else if (valid_extensions.test(filename))
	{
	
	}
	else
	{
		alert("Please provide valid file of extension .doc,.pdf")
		return false;
	}
	
}

function photodoc()
{
	var error='';
	var valid_extensions = /(.doc|.pdf|.docx)$/i;
	var filename=document.getElementById('UserPhotoDoc').value;
	
	
	if(!filename)
	{
		alert('Please Upload W-9 Form');
		return false;
	}else if (valid_extensions.test(filename))
	{
	
	}
	else
	{
		alert("Please provide valid file of extension .doc,.pdf")
		return false;
	}
	
}

function voideddoc()
{
	var error='';
	var valid_extensions = /(.doc|.pdf|.docx)$/i;
	var filename=document.getElementById('UserVideoDoc').value;
	
	
	if(!filename)
	{
		alert('Please Upload NDA Form');
		return false;
	}else if (valid_extensions.test(filename))
	{
	
	}
	else
	{
		alert("Please provide valid file of extension .doc,.pdf")
		return false;
	}
	
}
function mojo_voideddoc()
{
	var error='';
	var valid_extensions = /(.doc|.pdf|.docx)$/i;
	var filename=document.getElementById('UserMojoVideoDoc').value;
	
	
	if(!filename)
	{
		alert('Please Upload Mojo Pay NDA Form');
		return false;
	}else if (valid_extensions.test(filename))
	{
	
	}
	else
	{
		alert("Please provide valid file of extension .doc,.pdf")
		return false;
	}
	
}
</script>
<style>
#content-pane {
	top:0px!important;
}
.window {
	left:0px!important;
	margin:auto;
}
.bttonCLOSE {
	position:relative;
	z-index:99999999999999;
}
#boxes {
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
                        <td colspan="2" style="color:#FF0000"><?php echo $agentfileerror; ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><strong>AGENT AGREEMENT</strong> </td>
                        <td align="left" valign="top" class="red">
						<?php 
						$user_agent_doc=$this->request->data['User']['agent_doc'];
						$user_agent_file = WWW_ROOT.'/files/userdocument/'.$user_agent_doc;
						if(isset($user_agent_doc) && $user_agent_doc!='' && file_exists($user_agent_file)){?>
                    
                    <a class='example8' href="#inline_example1">View</a>
                   <?php  echo $this->Html->link(__("Delete",true),"/superadmin/editUser/".$id."?Agentfilename=".$this->request->data['User']['agent_doc'],array('confirm' => __('Are you sure you want to delete?')));?>
                          <div style='display:none'>
                            <div id='inline_example1' style='padding:10px; background:#fff;'>
                              <?php 
								if($this->request->data['User']['agent_doc']){
								   $url= FULL_BASE_URL.'/files/userdocument/'.$this->request->data['User']['agent_doc'];
								}
                                        
                               if(substr(strrchr($this->request->data['User']['agent_doc'],'.'),1)!='docx' || substr(strrchr($this->request->data['User']['agent_doc'],'.'),1)!='pptx' || substr(strrchr($this->request->data['User']['agent_doc'],'.'),1)!='ppt'){
                          ?>
                              <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
                              <br />
                              <br />
                              <?php  } 
                           	 if($this->request->data['User']['agent_doc']){?>
                             <a href="<?php echo $url;?>" target="_blank" class="bttonCLOSE">Download</a>
                              <?php } ?>
                            </div>
                          </div>
                          <?php } ?>
                          
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('agent_doc', array('type' => 'file', 'label' => '')); ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['agent_doc']));
                                                       echo $this->Form->input('SUBMIT', array('label' =>'','type' =>'hidden','value'=>'AGENT'));
                                                       echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false,'onClick'=> 'return agentdoc()'));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    <?php echo $this->Form->end(); ?> </div></td>
                <td width="33%" align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" style="color:#FF0000"><?php
                        echo $referalfileerror;
                         ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><strong>TOTAL APPS REFERRAL AGREEMENT</strong></td>
                        <td align="left" valign="top" class="red">
			<?php 
			$user_referal_doc=$this->request->data['User']['referral_doc'];
			$user_referal_file = WWW_ROOT.'/files/userdocument/'.$user_referal_doc;
              if(isset($user_referal_doc) && $user_referal_doc!='' && file_exists($user_referal_file))
                  { ?>
                     <a class='example9' href="#inline_example2">View</a>
                     <?php  echo $this->Html->link(__("Delete",true),"/superadmin/editUser/".$id."?referalFile=".$this->request->data['User']['referral_doc'],array('confirm' => __('Are you sure you want to delete?'))); ?>
                          
                          <div style='display:none'>
                            <div id='inline_example2' style='padding:10px; background:#fff;'>
                              <?php 
                                if($this->request->data['User']['referral_doc'])
                                {
                                   $url=FULL_BASE_URL.'/files/userdocument/'.$this->request->data['User']['referral_doc'];
                                }
                                  
                                                            
                               if(substr(strrchr($this->request->data['User']['referral_doc'],'.'),1)!='docx' || substr(strrchr($this->request->data['User']['referral_doc'],'.'),1)!='pptx' || substr(strrchr($this->request->data['User']['referral_doc'],'.'),1)!='ppt')
                              {
                              
                      ?>
                              <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
                              <br />
                              <br />
                              <?php 
                                  }
                                if($this->request->data['User']['referral_doc'])
                                {?>
                              <a href="<?php echo $url;?>" target="_blank" style="z-index:999999999">Download</a>
                              <?php 
                                  }
                                 ?>
                            </div>
                          </div>
                          
                      <?php } ?>
                      </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('referral_doc', array('type' => 'file', 'label' => '')); ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['referral_doc']));
                                               echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'REFERAL'));
                                               echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false,'onClick'=> 'return referaldoc()'));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    <?php echo $this->Form->end(); ?> </div></td>
                     
                              
                      <!--   Mojo Pay referral Agreement -->  
                <td width="33%" align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" style="color:#FF0000"><?php
                        echo $referalfileerror;
                         ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><strong>MOJO PAY REFERRAL AGREEMENT</strong></td>
                        <td align="left" valign="top" class="red">
		<?php 
		$user_mojoreferal_doc=$this->request->data['User']['mojopay_referral'];
		$user_mojoreferal_file = WWW_ROOT.'/files/userdocument/'.$user_mojoreferal_doc;
              if(isset($user_mojoreferal_doc) && $user_mojoreferal_doc!="" && file_exists($user_mojoreferal_file)){ ?>
                     <a class='example9' href="#inline_example5">View</a>
                     <?php  echo $this->Html->link(__("Delete",true),"/superadmin/editUser/".$id."?mojoreferalFile=".$this->request->data['User']['mojopay_referral'],array('confirm' => __('Are you sure you want to delete?'))); ?>
                          
                          <div style='display:none'>
                            <div id='inline_example5' style='padding:10px; background:#fff;'>
                              <?php 
                                if($this->request->data['User']['mojopay_referral']){
                                   $url=FULL_BASE_URL.'/files/userdocument/'.$this->request->data['User']['mojopay_referral'];
                                }
                                  
                                                            
                               if(substr(strrchr($this->request->data['User']['mojopay_referral'],'.'),1)!='docx' || substr(strrchr($this->request->data['User']['mojopay_referral'],'.'),1)!='pptx' || substr(strrchr($this->request->data['User']['mojopay_referral'],'.'),1)!='ppt')
                              {
                              
                      ?>
                              <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
                              <br />
                              <br />
                              <?php 
                                  }
                                if($this->request->data['User']['mojopay_referral'])
                                {?>
                              <a href="<?php echo $url;?>" target="_blank" style="z-index:999999999">Download</a>
                              <?php 
                                  }
                                 ?>
                            </div>
                          </div>
                          
                      <?php } ?>
                      </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('mojopay_referral', array('type' => 'file', 'label' => '')); ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['mojopay_referral']));
                                               echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'MOJO_REFERAL'));
                                               echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false,'onClick'=> 'return mojoreferaldoc()'));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    <?php echo $this->Form->end(); ?> </div></td>
                      
                <td width="33%" align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" style="color:#FF0000"><?php echo $photofileerror; ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><strong>W-9 FORM</strong></td>
                        <td align="left" valign="top" class="red"><?php 
                     
							$user_photo_doc	= $this->request->data['User']['photo_doc'];
							$user_w9_file = WWW_ROOT.'/files/userdocument/'.$user_photo_doc;
				  			if(isset($user_photo_doc) && $user_photo_doc!='' && file_exists($user_w9_file))
                            {
                           
                            ?>
                          <a class='example10' href="#inline_example3">View</a>
                          <?php 
                          
                           echo $this->Html->link(__("Delete",true),"/superadmin/editUser/".$id."?photoFile=".$this->request->data['User']['photo_doc'],array('confirm' => __('Are you sure you want to delete?'))); 
                          
                          ?>
                         
                          <div style='display:none'>
                            <div id='inline_example3' style='padding:10px; background:#fff;'>
                              <?php 
                                        if($this->request->data['User']['photo_doc'])
			                            {
            			                   $url=FULL_BASE_URL.'/files/userdocument/'.$this->request->data['User']['photo_doc'];
                        			    }
                                        
                                        
                                           if(substr(strrchr($this->request->data['User']['photo_doc'],'.'),1)!='docx' || substr(strrchr($this->request->data['User']['photo_doc'],'.'),1)!='pptx' || substr(strrchr($this->request->data['User']['photo_doc'],'.'),1)!='ppt')
                                  {
                                  
                          ?>
                              <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
                              <br />
                              <br />
                              <?php 
                                 }
                                 if($this->request->data['User']['photo_doc'])
                                    {?>
                              <a href="<?php echo $url;?>" target="_blank" style="z-index:999999999">Download</a>
                              <?php  } ?>
                            </div>
                          </div>
                           <?php }?>
                          </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('photo_doc', array('type' => 'file', 'label' => '')); ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['photo_doc']));
                                                        echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'PHOTOID'));
                                                        echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false,'onClick'=> 'return photodoc()'));
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
                        <td colspan="2" style="color:#FF0000"><?php echo $videofileerror; ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><strong>TOTAL APPS NDA FORM</strong></td>
                        <td align="left" valign="top" class="red">
		<?php 
          $user_video_doc=$this->request->data['User']['video_doc'];    
          $user_video_file = WWW_ROOT.'/files/userdocument/'.$user_video_doc;
          if(isset($user_video_doc) && $user_video_doc!='' && file_exists($user_video_file)){  ?>
              <a class='example11' href="#inline_example4" >View</a>
                   <?php echo $this->Html->link('Delete',"/superadmin/editUser/".$id."?videoFile=".$this->request->data['User']['video_doc'],array('confirm' => __('Are you sure you want to delete?'))); ?>
                          
                          <div style='display:none'>
                            <div id='inline_example4' style='padding:10px; background:#fff;'>
                              <?php 
                                        if($this->request->data['User']['video_doc'])
			                            {
            			                   $url=FULL_BASE_URL.'/files/userdocument/'.$this->request->data['User']['video_doc'];
                        			    }
                                        
                                        if(substr(strrchr($this->request->data['User']['video_doc'],'.'),1)!='docx' || substr(strrchr($this->request->data['User']['video_doc'],'.'),1)!='pptx' || substr(strrchr($this->request->data['User']['video_doc'],'.'),1)!='ppt')
                                  {
                          ?>
                              <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
                              <br />
                              <br />
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
                          </div>
                          <?php } ?>
                          <div id="boxes">
                            <div id="popup4" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);">
                              <div class="popup_outer2" style="width: 718px;left:0px;margin:auto;z-index:99999999999;" onclick="javascript:void(0)"> <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
                                <div class="stroke" style="overflow: visible;">
                                  <div class="popup_container2">
                                    <div class="popup_indent" style="padding:0 0 0 0"> </div>
                                    <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a> </div>
                                </div>
                              </div>
                            </div>
                            <!-- Mask to cover the whole screen -->
                            <div id="mask">&nbsp;</div>
                          </div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('video_doc', array('type' => 'file', 'label' => '')); 
                        
                        ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['video_doc']));
                                                        echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'VIDEODOC'));
                                                        echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false,'onClick'=> 'return voideddoc()'));
                                                        ?>
                        </td>
                      </tr>
                    </table>
                    <?php echo $this->Form->end(); ?> </div></td>
               
                      <td align="left" valign="top"><div class="doc_upload"> <?php echo $this->Form->create('User', array('plugin' => 'Usermgmt','controller' => 'user', 'action' => 'editUser', 'enctype' => 'multipart/form-data')); ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" style="color:#FF0000"><?php echo $videofileerror; ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><strong>MOJO PAY NDA FORM</strong></td>
                        <td align="left" valign="top" class="red">
		<?php 
          $mojo_user_video_doc=$this->request->data['User']['mojo_video_doc']; 
          $mojo_user_video_file = WWW_ROOT.'/files/userdocument/'.$mojo_user_video_doc;
          if(isset($mojo_user_video_doc) && $mojo_user_video_doc!="" && file_exists($mojo_user_video_file))
          {  ?>
              <a class='example11' href="#inline_example6" >View</a>
                   <?php echo $this->Html->link('Delete',"/superadmin/editUser/".$id."?mojo_videoFile=".$this->request->data['User']['mojo_video_doc'],array('confirm' => __('Are you sure you want to delete?'))); ?>
                          
                          <div style='display:none'>
                            <div id='inline_example6' style='padding:10px; background:#fff;'>
                              <?php 
                                        if($this->request->data['User']['mojo_video_doc'])
			                            {
            			                   $url=FULL_BASE_URL.'/files/userdocument/'.$this->request->data['User']['mojo_video_doc'];
                        			    }
                                        
                                        if(substr(strrchr($this->request->data['User']['mojo_video_doc'],'.'),1)!='docx' || substr(strrchr($this->request->data['User']['mojo_video_doc'],'.'),1)!='pptx' || substr(strrchr($this->request->data['User']['mojo_video_doc'],'.'),1)!='ppt')
                                  {
                          ?>
                              <iframe src="http://docs.google.com/gview?url=<?php echo $url?>&embedded=true" style="width:580px; height:500px;" frameborder="0"></iframe>
                              <br />
                              <br />
                              <?php 
                                         }
                                      
                           			    if($this->request->data['User']['mojo_video_doc'])
                                        {?>
                              <a href="<?php echo $url;?>" target="_blank" style="z-index:999999999">Download</a>
                              <?php 
                                    
                                        // echo $this->Html->link('Download',$url);
                                          
                                        }
                           			 ?>
                            </div>
                          </div>
                          <?php } ?>
                          <div id="boxes">
                            <div id="popup4" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);">
                              <div class="popup_outer2" style="width: 718px;left:0px;margin:auto;z-index:99999999999;" onclick="javascript:void(0)"> <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
                                <div class="stroke" style="overflow: visible;">
                                  <div class="popup_container2">
                                    <div class="popup_indent" style="padding:0 0 0 0"> </div>
                                    <a href="#" class="close close_button"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a> </div>
                                </div>
                              </div>
                            </div>
                            <!-- Mask to cover the whole screen -->
                            <div id="mask">&nbsp;</div>
                          </div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php echo $this->Form->input('mojo_video_doc', array('type' => 'file', 'label' => '')); 
                        
                        ?> </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2"><?php
                                                        echo $this->Form->input('oldfile', array('label' => '', 'type' => 'hidden', 'value' => $this->request->data['User']['mojo_video_doc']));
                                                        echo $this->Form->input('SUBMIT', array('label' => '', 'type' => 'hidden', 'value' => 'MOJO_VIDEODOC'));
                                                        echo $this->Form->submit('Upload', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false,'onClick'=> 'return mojo_voideddoc()'));
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
                            $option=array('0'=>'Incomplete','1'=>'Complete');
                            echo $this->Form->Select('doc_status',$option,array('empty'=>false));
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
