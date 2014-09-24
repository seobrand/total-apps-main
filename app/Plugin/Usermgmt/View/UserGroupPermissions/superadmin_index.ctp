<?php
echo $this->Html->script('/js/umupdate');

?>
<style>
.checkbox
{
width:150px;
float:left;
}
</style>
<div class="content">
  <div id="right">
    <div id="right2">
      <div class="box">
        <div class="display_row">
          <div class="table">
            <div class="um_box_mid_content">
              <div class="um_box_mid_content_top">
                <div style="float:left;margin:20px" >
                  <?php 
						// pr($allControllers);
						// echo '<pre>';
						//print_r($allControllers);
                       
						unset($allControllers[2]); 
						unset($allControllers[3]);
						unset($allControllers[4]);
						unset($allControllers[5]);
						unset($allControllers[6]);
						unset($allControllers[13]);
						//  unset($allControllers[6]);
						
						//unset($allControllers[24]); 
						unset($allControllers[25]); 
						unset($allControllers[26]); 
						unset($allControllers[27]); 
						unset($allControllers[28]); 
						unset($allControllers[29]); 
						unset($allControllers[30]); 
						unset($allControllers[31]); 
						unset($allControllers[32]); 
						unset($allControllers[35]); 
                        
                        $allControllers[-2]='Select Admin Section';
                        $allControllers[0]='Admin => Account Category';
                        $allControllers[1]='Admin => Account Types';
                    	//$allControllers[7]='Admin => Busineess Category';
						   //$allControllers[8]='Admin => Commission';
						   //$allControllers[9]='Admin => Deployment';
						$allControllers[7]='Admin => Appoinment';
						$allControllers[8]='Admin => Business Category';
						$allControllers[9]='Admin => Data Upload';
						$allControllers[10]='Admin => Deployment';
						$allControllers[11]='Documents';
						$allControllers[12]='Admin => Email Templates';
                       
						$allControllers[14]='Admin => Gatway Permission';
						$allControllers[15]='Admin => Bulk Merchant Modification';
                        $allControllers[16]='Merchant Permission(Pipeline)';
                     	 $allControllers[17]='Admin => Transaction';
                        $allControllers[18]='Admin => News & Announcement';
                        $allControllers[19]='Admin => Processor Document';
                       
					    $allControllers[20]='Admin => Rates';
                        $allControllers[21]='Reports';
						
                        $allControllers[22]='Residuals';
                        $allControllers[23]='Admin => Status Permission';
                        $allControllers[24]='Supports';
						 $allControllers[25]='User Category';
                         
                        $allControllers[33]='Admin => User Permission';
                        $allControllers[34]='Admin => All User Group';
                        
                        
                        
                    
                      
                        
                ?>
                  <span  class="umstyle2">
                  <?php __('Select Controller');?>
                  </span> <?php echo $this->Form->input("controller",array('type'=>'select','div'=>false,'options'=>$allControllers,'selected'=>$c,'label'=>false,"onchange"=>"window.location='".SITE_URL."superadmin/permissions/?c='+(this).value"))?> </div>
                <div style="clear:both"></div>
              </div>
              <div class="umhr"></div>
              <div class="um_box_mid_content_mid" id="permissions">
                <?php   if (!empty($controllers)) { ?>
                <input type="hidden" id="BASE_URL" value="<?php echo SITE_URL?>">
                <input type="hidden" id="groups" value="<?php echo $groups?>">
                <table width="100%">
                  <tbody>
                    <tr>
                      <th> <?php echo __("Action");?> </th>
                      <!--<th> <?php echo __("Action");?> </th>-->
                      <th> <?php echo __("Permission");?> </th>
                      <th> <?php echo __("Operation");?> </th>
                    </tr>
                    <?php
          
           
            					$k=1;
                               
                                  //  echo '<pre>';
                                  //    print_r($controllers);   
                               
                     
					foreach ($controllers as $key=>$value) {
                    	
                       
                   
						if (!empty($value)) {
                        $url='';
                     
                     
							for ($i=0; $i<count($value); $i++) {
                            
                            
								if (isset($value[$i])) {
									$action=$value[$i];
                                    
                                   
									echo $this->Form->create();
									echo $this->Form->hidden('controller',array('id'=>'controller'.$k,'value'=>$key));
									echo $this->Form->hidden('action',array('id'=>'action'.$k,'value'=>$action));
                                   ?>
                    <tr>
                      <?php $controller_action = $common->breadcrubPermission($key,$value[$i]); ?>
                      <?php $controller_action = !empty($controller_action) ? $controller_action : $value[$i]; ?>
                      <td width="310px;"><?php echo $controller_action;?><?php //echo $value[$i]; ?></td>                      
                      <td> 	<?php 
                                        for ($j=0; $j<count($user_groups); $j++) {
										$ugname=$user_groups[$j];
										if (isset($value[$action][$ugname]) && $value[$action][$ugname]==1) {
											$checked=true;
										} else {
											$checked=false;
										}
										echo $this->Form->input($ugname,array('id'=>$ugname.$k,'type'=>'checkbox','checked'=>$checked));
									}
                                        
                                 ?>
                      </td>
                      <td><?php echo $this->Form->submit('Update', array('type'=>'button','id'=>'mybutton123','name'=>$k,'onClick'=>'javascript:update_fields('.$k.');', 'class'=>'cursorclass ui-state-default ui-corner-all','div' => false));
                                        
                                      //  echo $this->Form->submit('Update ', array('name' => 'Submit', 'class' => 'cursorclass ui-state-default ui-corner-all', 'div' => false));
                                        
                                        echo "<div id='updateDiv".$k."' align='right'>&nbsp;</div>";
                                         ?> </td>
                    </tr>
                    <?php  
                    	echo $this->Form->end();
								$k++;
								}
							}
						}
					} ?>
                </table>
                <?php   }   ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
