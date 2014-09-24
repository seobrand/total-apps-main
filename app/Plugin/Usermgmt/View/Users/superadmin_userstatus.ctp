<style>
.titlebar{

height:20px;}
.titlebar li{
border-right:#4F9DEC solid 1px;

padding:0 10px 0 10px!important;
float:left;
}
.titlebar li .active{
font-weight:bold;
color:#000000;
font-size:14px;
}

.titlebar li:last-child{
border:none !important;
}
</style>
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <!-- display box / first -->
        <div class="box">
          <div class="display_row">
          
          
            <div class="news_indent">
             <span style="color:#2460A0;font-weight:bold;margin:0 0 20px 15px;font-size:16px"> View Users status by user level</span><br /><br />
              
              <div class="news_announcement">
            
                <div class="titlebar">
                 <?php
				  $group_list=$common->getGroupList(); ?>
                  <ul style="display:inline">
                 		<?php foreach($group_list as $key=>$value){ ?>
                        <li><a href="<?php echo FULL_BASE_URL.router::url('/',false) ?>superadmin/usermgmt/users/userstatus/<?php echo $key; ?>" <?php if($group_id==$key){?>class="active" <?php } ?>><?php echo $value; ?></a></li>
                        <?php } ?>
                 
                 
                  </ul>
                </div>
                <div class="box">
                  <div class="display_row">
                    <div class="table">
                 <!--   <br>(has been sing in the last time since)-->
                   <?php
$this->Grid->addColumn('Name', '/User/user_Name', array('paginate'=>true),'user_Name');	
$this->Grid->addColumn('User ID', '/User/username', array('paginate'=>true),'username');
$this->Grid->addColumn('Company', '/User/userCompany', array('paginate'=>true),'userCompany');	
$this->Grid->addColumn('Phone #', '/User/userPhone', array('paginate'=>true),'userPhone');	
$this->Grid->addColumn('online since', '/User/online_since', array('paginate'=>true),'online_since');
//$this->Grid->addAction('View', array('controller' => 'email_templates', 'action' => 'templateView'), array('/User/id'));
						echo $this->Grid->generate($login_users);
					?>
                      <div class="paginator">
                        <?php
						 if(count($login_users)>0){?>
                        <?php echo $this->element('admin-paging');}?>
                     
                        <?php 
						
						//endif;?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><br />
            
            
            <div class="news_indent">
             
              <div class="news_announcement">
            
                <div class="titlebar">
                 New Users
                  
                </div>
                <div class="box">
                  <div class="display_row">
                    <div class="table">
                 <!--   <br>(has been sing in the last time since)-->
                 
                 <div style="height:350px;overflow:auto;">
                   <?php
				  // pr($new_user_list);
				   $this->Grid->reset();
$this->Grid->addColumn('Name', '/User/user_Name', array('paginate'=>false),'user_Name');	
$this->Grid->addColumn('User ID', '/User/username', array('paginate'=>false),'username');
$this->Grid->addColumn('Company', '/User/userCompany', array('paginate'=>false),'userCompany');	
$this->Grid->addColumn('Phone #', '/User/userPhone', array('paginate'=>false),'userPhone');
$this->Grid->addColumn('Created by', '/User/user_by', array('paginate'=>false),'user_by');	
$this->Grid->addColumn('Date/Time created', '/User/created', array('paginate'=>false),'created');			
echo $this->Grid->generate($new_user_list);
					?>
                    </div>  
                    </div>
                  </div>
                </div>
              </div>
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
