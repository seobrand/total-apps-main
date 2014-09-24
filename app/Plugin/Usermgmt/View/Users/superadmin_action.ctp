
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
            <div class="links_col">
              <!--<ul class="links">
                <li class="active"><a href="javascript:void(0);" onclick="showhide('viewnotes','addnotes')">View Notes:</a></li>
                <li><a href="javascript:void(0);" onclick="showhide('addnotes','viewnotes')">Add Notes:</a></li>
              </ul>-->
            </div>
            <div id="viewnotes">
              <div class="box">
                <div class="display_row">
                 
                    <div>
                     <?php echo $this->Form->create('User',array('controller'=>'users','action'=>'action'));?>
                     <div style="margin:40px 0 40px 0">
                     
                     
                     </div>
                      <?php      echo $this->Form->input('SUBMIT',array('label'=>'','type'=>'hidden','value'=>'ACTION'));
             echo $this->Form->submit('Sent Login Information',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
                    </div>
                  
                </div>
                <!-- display box / second end here -->
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
