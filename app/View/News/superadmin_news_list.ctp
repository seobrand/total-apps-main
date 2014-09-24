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
           
              <div class="news_announcement">
                <div class="titlebar">News & Announcement
                  <div style="float:right"> <a href="<?php echo $this->webroot; ?>superadmin/news/addNews">Add New</a> </div>
                </div>
                <div class="box">
                  <div class="display_row">
                    <div class="table">
                      <?php
					  		$this->Grid->addColumn('Title', '/News/title', array('paginate'=>true),'title');	
							$this->Grid->addColumn('Publish  Date', '/News/start_date', array('paginate'=>true),'start_date');	
							$this->Grid->addColumn('End Date', '/News/end_date', array('paginate'=>true),'end_date');
							$this->Grid->addColumn('Group ', '/News/user_group_id', array('paginate'=>true),'user_group_id');			 
							$this->Grid->addColumn('Status','/News/active', array('paginate'=>true),'from');
							$this->Grid->addAction('Edit', array('controller' => 'News', 'action' => 'editNews'), array('/News/id'));
							$this->Grid->addAction('Delete', array('controller' => 'News', 'action' => 'deleteNews'), array('/News/id'));
							//$this->Grid->addAction('View', array('controller' => 'News', 'action' => 'viewNews'), array('/News/id'));
							echo $this->Grid->generate($newsList);
						?>
                      <div class="paginator">
                        <?php if(count(merchantSearchList)>10):?>
                        <?php echo $this->element('admin-paging');?>
                        </td>
                        <?php endif;?>
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