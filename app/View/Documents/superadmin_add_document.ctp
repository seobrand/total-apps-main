<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
     
      <div class="box1">
      
        <div class="box">
<div class="display_row">
<div class="table">

           <?php echo $this->Form->create('Document', array('action'=>'addDocument','id'=>'form-validation', 'enctype' => 'multipart/form-data')); ?>
              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
            <?php  
			$userId=$this->Session->read('UserAuth.User.id');
			$userGroupId=$this->Session->read('UserAuth.User.user_group_id');
			$option=$common->getFolderList($userId,$userGroupId);?>
       <tr>
       <th colspan="2" align="left" style="padding-left:15px">Add Document</th>
       </tr>
               <tr>
                  <td align="right">Select Folder<span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Document.folder_id" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2','type'=>'select','options'=>$option,'empty'=>false))?> </td>
                </tr>
               
                <tr>
                  <td align="right">Title<span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Document.title" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?> </td>
                </tr>
                
                 <?php  
			 $option=array('0'=>'document','1'=>'Video')?>
               <tr>
                  <td align="right">Document Type <span class="required">*</span>:</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Document.documenttype" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2','type'=>'select','options'=>$option,'empty'=>false))?> </td>
                </tr>
                
                 <tr>
                  <td align="right">File<span class="required">*</span> :</td>
                  <td align="left" valign="top"><?php echo $this->Form->input("Document.file" ,array('label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2','type'=>'file'))?> </td>
                </tr>
                
                 <tr>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
				  
				  <?php
				  echo $this->Form->input("Document.Add" ,array('type' => 'hidden','value'=>'Add','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));
				   echo $this->Form->submit('SUBMIT',array('name'=>'SUBMIT','value'=>'SUBMIT','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'onsubmit'=>'editor_content()'));?></td>
                </tr>
              </table>
             
             
              <?php echo $this->Form->end(); ?> 
              </div>
              </div>
              </div>
    
      </div>
    </div>
    <!-- end table -->
  </div>
</div>