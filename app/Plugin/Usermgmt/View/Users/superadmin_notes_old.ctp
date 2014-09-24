<script type="text/javascript">
function showhide(id1,id2)
{
	document.getElementById(id1).style.display='block';
	document.getElementById(id1+'-li').className = 'active';
	document.getElementById(id2).style.display='none';
	document.getElementById(id2+'-li').className = '';
}
</script>

<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php
      
       echo $this->element('generalinformation'); ?>
        <div class="display_row">
          <div class="tabs_outer">   <?php echo $this->element('usersmenu'); ?></div>
          <div class="tabs_des">
            <div class="links_col">
              <ul class="links">
                <li class="active" id="viewnotes-li"><a href="javascript:void(0);" onclick="showhide('viewnotes','addnotes')">View Notes:</a></li>
                <li  id="addnotes-li"><a href="javascript:void(0);" onclick="showhide('addnotes','viewnotes')">Add Notes:</a></li>
              </ul>
            </div>
            <div id="viewnotes" style="display:block;">
              <div class="box">
                <div class="display_row">
                  <div class="table">
                  
              
                  
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php if(count($agentRec)) {?>
                      <tr>
                        <th width="20%" align="left" valign="top" scope="col"> User Id</th>
                        <th width="20%" align="left" valign="top" scope="col"> Date</th>
                        <th width="25%" align="left" valign="top" scope="col"> Note</th>
                        <th width="23%" align="left" valign="top" scope="col">Entered By</th>
                      <!-- <th width="4%" align="left" valign="top" scope="col">&nbsp;</th>-->
                        <th width="4%" align="left" valign="top" scope="col">&nbsp;</th>
                      </tr>
                      <?php
               
               foreach ($agentRec as $agentRec){ ?>
                      <tr>
                        <td align="left" valign="top"><!--<?php echo $this->Html->link(__($agentRec['Agentnote']['userID']), array('action' => 'edit', $agentRec['Agentnote']['agentNoteID'])); ?>-->
                        <?php
                     //   echo $agentRec['Agentnote']['agentNoteID'];
                        
                         echo  $common->getAgentName($agentRec['Agentnote']['agentNoteID']);  ?>
                        </td>
                        <td align="left" valign="top"><?php echo  $agentRec['Agentnote']['timeStamp'];  ?></td>
                        <td align="left" valign="top"><?php echo  $agentRec['Agentnote']['note'];  ?></td>
                        <td align="left" valign="top"><?php
                        echo  $common->getUserName($agentRec['Agentnote']['enteredBy']); 
                      //   echo  $agentRec['Agentnote']['enteredBy'];  ?> </td>
                       
                     <!--  <td align="left" valign="top">
                      <?php echo $this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','url' => array('controller' => 'users', 'action' => 'notes', $agentRec['Agentnote']['agentNoteID']))); ?>
                         
                          </td> -->
                          
                      <td align="left" valign="top"><?php echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("are you sure?");','url' => array('controller' => 'users', 'action' => 'deletenotes', 'delete',$agentRec['Agentnote']['agentNoteID'],$id))); ?> </td>
                      </tr>
                      
                     
                      <?php }?> 
                      <tr>
                      <td colspan="7">
                      	<div class="paginator"> <?php echo $this->Paginator->numbers(array('first' => 'First page'));?></div>
                      </td>
                      </tr>
                      <?php 
                }else
                {
                 ?>
                      <tr>
                        <td colspan="7" align="center"><strong>No Record Found</strong> </td>
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                </div>
                <!-- display box / second end here -->
              </div>
            </div>
            <div id="addnotes" style="max-height:400px;display:none;overflow-y:auto;">
              <div id="agentInfo"> <?php echo $this->Form->create('User',array('controller'=>'agentnotes','action'=>'notes'));?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
                  <tr>
                    <td align="left" valign="top" class="rpadnone" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="24%" align="left" valign="middle">Add Note:</td>
                          <td width="76%" align="left" valign="middle"><?php echo $this->Form->input('note',array('type'=>'textarea','row'=>'20','cols'=>'200','class'=>'input1','label'=>'','style'=>'width:400px;')); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="right"><?php      echo $this->Form->input('SUBMIT',array('label'=>'','type'=>'hidden','value'=>'NOTES'));
             echo $this->Form->submit('Add Notes',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
                          </td>
                        </tr>
                      </table></td>
                    <td align="left" valign="top" style="padding:0px;"></td>
                  </tr>
                </table>
                <?php echo $this->Form->end();?> </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
