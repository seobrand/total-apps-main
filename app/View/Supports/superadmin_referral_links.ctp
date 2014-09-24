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
              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
              <tr>
              <th colspan="2" align="left" style="padding-left:15px">Add A New Referral Link</th>
              </tr>
              <?php echo $this->Form->create('Support', array('id'=>'addreferralLink')); ?>
              <tr>
                 <td align="right" valign="top" style="padding-top:15px">Default Referral Link :</td>
                 <td align="left" valign="top"><?php echo $this->Form->input("ReferralLink.referral_link" ,array('type' =>'text','label' => false,'div' => false,'data-validation-type'=>'present' ,'class'=>'input2'))?>&nbsp; <?php echo $this->Form->submit('SUBMIT',array('name'=>'SUBMIT','value'=>'SUBMIT','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
              </tr>
              <?php echo $this->Form->input("ReferralLink.id", array('type' => 'hidden','value'=>'1','label' => false,'div' => false,'id'=>'af-present','data-validation-type'=>'present' ));?>
              <?php echo $this->Form->end();?>
              <tr>
                 <td align="left" valign="top" style="padding-left:15px;font:bold 15px/25px arial;" colspan="2">Assign referral Links To users</td>
              </tr>
              <?php echo $this->Form->create('Support', array('id'=>'assignreferralLink')); ?>
                <tr>
                  <td align="right" valign="top" style="padding-top:15px">Users:</td>
                 
                  <td align="left" valign="top">
	                  <div style="height:250px!important;overflow:auto;width:465px;padding:10px;border: 1px solid #CCCCCC;" id="emailDropdown" >
		                  <div class="select1">
		                     <input type="checkbox" onclick="showTierDiv()" value="all" id="selectALLS">
		                     <label for="templateALL">ALL</label>
		           		 </div>
		           		 <?php 
	         				echo $this->Form->input('User.userID',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$userlist,'empty'=>false,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:465px;'));
						?>
	            		</div>
            		</td>
                </tr>
                <tr>
                  <td align="right" valign="top" style="padding-top:15px">Referral Links:</td>
                  <td align="left" valign="top">
	                  <?php 
	         				echo $this->Form->input('User.referral_link',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$referrallinks,'empty'=>'-Please Select-','label'=>false,'div'=>false,'style'=>'width:465px;'));
						?>&nbsp;<?php echo $this->Html->link('Manage Referral Link','manageReferralLink',array('class'=>'cursorclass ui-state-default ui-corner-all'));?>
            		</td>
                </tr>                
                <tr>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top"><?php echo $this->Form->submit('SUBMIT',array('name'=>'SUBMIT','value'=>'SUBMIT','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'onsubmit'=>'editor_content()'));?></td>
                </tr>
              </table>
              <?php echo $this->Form->end(); ?>
             </div>
             <div class="tabs_des">
             <div class="links_col"></div>
             <?php /*** Showing Ajax paging ***/?> 
             <?php $this->Paginator->options(array('update' => '#content','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false))));?>
             <div id="merchantInfo" style="max-height:400px;overflow-y:auto;">
	            <div class="box" id="content">	            
	            <?php if(count($assignusers)>0){?>
				<div class="display_row">
				<div  id="spinner" class="agent-ajax-paging-loader">
	            	<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
				</div> 
	            <div class="table">
	            <?php
       					$this->Grid->addColumn('User Name', '/User/user_Name', array('paginate'=>false),'User.user_Name');			
						$this->Grid->addColumn('Referral Link', '/ReferralLink/referral_link', array('paginate'=>false),'ReferralLink.referral_link');			 
					   	$this->Grid->addAction('Delete', array('plugin' => '','controller' => 'supports', 'action' => 'deleteReferralLink'), array('/User/id'));	
						echo $this->Grid->generate($assignusers);
					?>
	              <div class="paginator"> <?php echo $this->Paginator->numbers($options = array('model' => 'User'),array('first' => 'First page'));?></div>
	              </div>
	              </div>
	              <?php }else{?>
	              <div class="display_row">No Results</div>
	              <?php }?>
	              </div>
            </div>
            </div>
          </div>
     </div>
      </div>
    </div>
    <!-- end table -->
  </div>
</div>
<?php echo $this->Js->writeBuffer();?>


<script type="text/javascript">
function showTierDiv()
{
	var isChecked = document.getElementById("selectALLS").checked;
	if(isChecked==true)
	{
		$('input[name="data[User][userID][]"]').attr("checked", "checked");
	}else
	{	
		$('input[name="data[User][userID][]"]').removeAttr("checked", "checked");
	}
}
</script>