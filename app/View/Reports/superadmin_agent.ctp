<?php //pr($agents); ?>
<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
          
          
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
         
            <div class="table">
             <div>
            	<?php  echo $this->Form->create('Report',array('action'=>'agent','type'=>'get')); ?>
             	<?php echo $this->Form->submit('Export',array('name'=>'AddAnnouncement3','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
             	<?php echo $this->Form->end();?>
             </div><br />

             
             <?php 
             $this->Grid->addColumn('Agent Name', '/User/user_Name', array('paginate'=>true),'User.user_Name');
             $this->Grid->addColumn('Agent Phone Number', '/User/userPhone', array('paginate'=>true),'User.userPhone');
             $this->Grid->addColumn('Agent Company', '/User/userCompany', array('paginate'=>true),'User.userCompany');
             echo $this->Grid->generate($agents);
             ?>
         	<div class="paginator">
	            <?php echo $this->element('admin-paging');?>
	        </div>
            <div class="clear"></div>
            <br />
           <div>
  				<?php  echo $this->Form->create('Report',array('action'=>'agent','type'=>'get')); ?>
             	<?php echo $this->Form->submit('Export',array('name'=>'AddAnnouncement3','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
             	<?php echo $this->Form->end();?>
            </div>
            
            </div>
          
          </div>
          
         <!-- display box / first -->
          
         <div class="clear"></div>
         
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 