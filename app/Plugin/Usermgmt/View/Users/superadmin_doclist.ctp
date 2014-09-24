<div class="content"> 
  <!-- content / right -->
  <div id="right">
   
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
        	<div class="news_announcement">
          <div class="titlebar">Filter Options</div>
          <div class="news_indent"> <?php echo $this->Form->create('User',array('controller'=>'user','action'=>'doclist','type'=>'get'));?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
              <tr>
                <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  	<td width="22%" align="left" valign="middle">User Type</td>
                      <td width="78%" align="left" valign="middle">
                      	  <select name="Role" id="UserRole" class="select3"  style="width:277px;">
                           <option value="">=== Please Select Role ===</option>
            <?php foreach($groupRec as $data) {?>
             
             <option value="<?php echo $data['user_groups']['id'] ?>"  <?php if($rolename==$data['user_groups']['id']){ ?>selected="selected"<?php } ?> ><?php echo $data['user_groups']['name'] ?></option>
              
            <?php } ?>
            </select></td>
                  </tr>
                  
                    
                     <tr>
                      <td align="left" valign="middle">Status</td>
                      <td align="left" valign="middle">
                      
                      <?php 
					  if(isset($active))
					  {
					  	
					  		$default=$active;
					  }
					  
						 $options=array('1'=>'Active','0'=>'Inactive');
                   	echo	 $this->Form->input('active',array('class'=>'select3','id'=>'template','type'=>'select','options'=>$options,'empty'=>array(''=>'-Select Status-'),'default'=>$default,'label'=>false,'div'=>false,'style'=>'width:277px')); ?>
                      
                      </td>
                    </tr>       
                    
                    <tr>
                      <td align="left" valign="middle">Complete</td>
                      <td align="left" valign="middle">
                      
                      <?php 
					  if(isset($doc_status))
					  {
					  	
					  		$default1=$doc_status;
					  }
					  
						 $options=array('1'=>'Complete','0'=>'Incomplete');
                   	echo	 $this->Form->input('doc_status',array('class'=>'select3','id'=>'template','type'=>'select','options'=>$options,'empty'=>array(''=>'-Select Document Status-'),'default'=>$default1,'label'=>false,'div'=>false,'style'=>'width:277px')); ?>
                      
                      </td>
                    </tr>              
                 </table></td>
                <td align="left" valign="top" style="padding:0 0 0 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  
                    <tr>
                      <td width="26%" align="left" valign="middle">Total Users Returned </td>
                      <td width="74%" align="left" valign="middle"><?php echo $TOTALUSER; ?></td>
                    </tr>
                    
                    <tr>
                      <td align="left" valign="middle">Query Time</td>
                      <td align="left" valign="middle"><?php echo round(microtime(true) - $_SERVER['REQUEST_TIME'], 4) ; ?> seconds.</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="middle" style="padding:16px 0 0 10px;"><?php
                      echo $this->Form->input('Filter', array('label' => '','name' => 'Serach','value' => 'Search','Type' => 'Submit','class'=>'cursorclass ui-state-default ui-corner-all','style'=>'width:100px;float:left'));
                      
                      echo $this->Form->input('SUBMIT',array('label'=>'','type'=>'hidden','value'=>'SUBMIT'))
                      ?>
                        &nbsp;&nbsp;
                         <?php
                       
                         echo $this->Form->submit('Export',array('name'=>'Export','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                       
                        ?>
                        </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <?php echo $this->Form->end(); ?> </div>
        </div>
        
        
          <div class="news_announcement">
            <div class="titlebar">DOCS</div>
<div class="news_indent">
<div class="box">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="13%" align="left" valign="top">NAME</th>
    <th width="13%" align="left" valign="top">Group Name</th>
    <th width="18%" align="center" valign="top">AGENT AGREEMENT</th>
    <th width="26%" align="center" valign="top">REFERRAL AGREEMENT</th>
    <th width="12%" align="center" valign="top">W-9 FORM</th>
    <th width="17%" align="center" valign="top">NDA</th>
    <th width="14%" align="center" valign="top">COMPLETE</th>
  </tr>
  <?php
  if(count($UserRec)>0)
  {
  	foreach ($UserRec as $userRec){ ?>
 	 <tr>
    <td align="left" valign="top"><?php echo $userRec['User']['user_Name']; ?></td>
   <td>
   <?php 
   
   $group='';
   for($i=0;$i<count($userRec['UserGroupJoin']);$i++)
   {
   if($userRec['UserGroupJoin'][$i]['user_group_id']!=0)
   {
   	 $group .=$common->Groupname($userRec['UserGroupJoin'][$i]['user_group_id']).' , ';
    }
   }
   echo $group;
   ?>
   </td>
    <td align="center" valign="top">
    
    
    				
    <?php
    if($userRec['User']['agent_doc'])
    {
     echo $this->Html->image('right.jpg',array('alt'=>'Login','title'=>'Login'));
    }else
    {
  		echo $this->Html->image('close.png',array('alt'=>'Login','title'=>'Login'));
    } 
     ?>
    </td>
   
    <td align="center" valign="top">
      <?php
    if($userRec['User']['referral_doc'])
    {
     echo $this->Html->image('right.jpg',array('alt'=>'Login','title'=>'Login'));
    }else
    {
  		echo $this->Html->image('close.png',array('alt'=>'Login','title'=>'Login'));
    } 
     ?>
    </td>
    <td align="center" valign="top">
    
    <?php
    if($userRec['User']['photo_doc'])
    {
     echo $this->Html->image('right.jpg',array('alt'=>'Login','title'=>'Login'));
    }else
    {
  		echo $this->Html->image('close.png',array('alt'=>'Login','title'=>'Login'));
    } 
     ?>
     
     
    </td>
     
        <td align="center" valign="top">
         <?php
        if($userRec['User']['video_doc'])
        {
         echo $this->Html->image('right.jpg',array('alt'=>'Login','title'=>'Login'));
        }else
        {
            echo $this->Html->image('close.png',array('alt'=>'Login','title'=>'Login'));
        } 
         ?>
        </td>
        
        
      <td align="center" valign="top">
         <?php
        if($userRec['User']['doc_status']==1)
        {
         echo 'Complete';
        }else
        {
          echo 'Incomplete';
        } 
         ?>
        </td>
  </tr>
  	<?php
  	}
  }else
  {?>
  <tr>
  	<td colspan="7" align="center">No Record Found</td>
  </tr>
  <?php
  }
  ?>
  
  
  
  
</table>

</div>
</div>
          </div>
          <div class="paginator">
						<?php if(count(merchantSearchList)>0):?>
						<?php echo $this->element('admin-paging');?></td>
					<?php endif;?>
					</div>
        </div>
        <!-- end table --> 
      </div>
 
  </div>
  <!-- end content / right --> 
</div>