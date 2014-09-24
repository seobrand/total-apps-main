
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2"> 
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Filter Options</div>
          <div class="news_indent">
         <?php echo $this->Form->create('Merchant',array('controller'=>'user','action'=>'view'));?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
              <tr>
                <td width="50%" align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="22%" align="left" valign="middle">Filter:</td>
                      <td width="78%" align="left" valign="middle">
                      <?php 
                      	
						
                   
                 $options = array('admin' => 'Admins', 'agent' => 'Agents','Manager' => 'Managers', 'iso' => 'ISOs','processor' => 'Processors', 'tech' => 'Techs');
echo $this->Form->select('role', $options, array('escape' => false,'empty'=>'Select Role','class'=>'select3'));
                      ?>
                    </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Short By:</td>
                      <td align="left" valign="middle">
                   <?php     $options = array('name' => 'Name', 'email' => 'Email','1' => 'Active', '0' => 'Inactive');
echo $this->Form->select('sortby', $options, array('escape' => false,'empty'=>'Sort By','class'=>'select3'));?>
                      
                     </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Short Order:</td>
                      <td align="left" valign="middle">
                      <?php     $options = array('ASC' => 'Ascending', 'DESC' => 'Descending');
echo $this->Form->select('sortOrder', $options, array('escape' => false,'empty'=>'Order By','class'=>'select3'));?>
                    
                      
                    </td>
                    </tr>
                  </table></td>
                <td align="left" valign="top" style="padding:0 0 0 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="26%" align="left" valign="middle">Merchants Returned: </td>
                      <td width="74%" align="left" valign="middle">524</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">Query Time:</td>
                      <td align="left" valign="middle"><?php echo round(microtime(true) - $_SERVER['REQUEST_TIME'], 4) ; ?> seconds.</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="middle" style="padding:16px 0 0 10px;">
                      <?php
                      echo $this->Form->input('Filter', array('label' => '','Type' => 'Submit','class'=>'cursorclass ui-state-default ui-corner-all','style'=>'width:100px;float:left'));
                      
                      echo $this->Form->input('SUBMIT',array('label'=>'','type'=>'hidden','value'=>'SUBMIT'))
                      ?>
                      
                      
                      
                        &nbsp;&nbsp;
                        <input type="submit" class="cursorclass ui-state-default ui-corner-all" name="AddAnnouncement" value="Export" /></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
       
    <?php echo $this->Form->end(); ?>

          </div>
        </div>
        
        <!-- display box / first -->
        <div class="box">
          <div class="display_row">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                  <th width="20%" align="left" valign="top" scope="col"> Name</th>
                  <th width="20%" align="left" valign="top" scope="col"> Phone Number</th>
                  <th width="25%" align="left" valign="top" scope="col"> Email Address</th>
                  
                  <th width="23%" align="left" valign="top" scope="col">Active Status</th>
                  <th width="4%" align="left" valign="top" scope="col">&nbsp;</th>
                  <th width="4%" align="left" valign="top" scope="col">&nbsp;</th>
                  <th width="4%" align="left" valign="top" scope="col">&nbsp;</th>
                </tr>
           <?php
               foreach ($MerchantRec as $K=> $merchants){ ?>
               
                 <tr>
                  <td align="left" valign="top">
                  
             
                  
                  <?php echo $this->Html->link(__($merchants['Merchant']['merchantName']), array('action' => 'edit', $merchants['Merchant']['merchantID'])); ?></td>
                  <td align="left" valign="top"><?php echo  $merchants['Merchant']['merchantDBA'];  ?></td>
                  <td align="left" valign="top"><?php echo  $merchants['Merchant']['merchantURL'];  ?></td>
                  <td align="left" valign="top"><?php echo  $merchants['Merchant']['merchantURL'];  ?></td>
				  <td align="left" valign="top"><?php echo  $merchants['Merchant']['merchantURL'];  ?></td>
				  <td align="left" valign="top"><?php echo  $merchants['Merchant']['agentID'];  ?></td>
				  <td align="left" valign="top"><?php echo  $merchants['Merchant']['processorID'];  ?></td>
				  <td align="left" valign="top"><?php echo  $merchants['Merchant']['managerID'];  ?></td>
				  <td align="left" valign="top"><?php echo  $merchants['Merchant']['isoID'];  ?></td>
                  <td align="left" valign="top">
                  
                    </li>
                  
                  <?php echo $this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','url' => array('controller' => 'users', 'action' => 'edit', $merchants['Merchant']['userID']))); ?></td>
                  <td align="left" valign="top">
                  
                  <?php echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("are you sure?");','url' => array('controller' => 'users', 'action' => 'delete', $merchants['Merchant']['userID']))); ?>
                  
             
                  
                  </td>
                  <td align="left" valign="top"><a href="login.html"><?php echo $this->Html->image('login.png',array('alt'=>'Login','title'=>'Login'));?></a></td>
                </tr>
                
                
               
                
               <?php } ?>
              </table>
            </div>
          </div>
          
          <!-- display box / second end here --> 
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>