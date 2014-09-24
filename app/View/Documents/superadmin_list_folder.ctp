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
              <div class="news_announcement">
                <div class="titlebar">Folders List
                  <div style="float:right"> <a href="<?php echo $this->webroot; ?>superadmin/documents/createFolder">Add New</a> </div>
                </div>
                <div class="box">
                  <div class="display_row">
                    <div class="table">
                      <?php
					  		$this->Grid->addColumn('Title', '/Folder/title', array('paginate'=>true),'title');	
							$this->Grid->addAction('Delete', array('controller' => 'documents', 'action' => 'deleteFolder'), array('/Folder/id'));
							$this->Grid->addAction('Edit', array('controller' => 'documents', 'action' => 'editFolder'), array('/Folder/id'));
							echo $this->Grid->generate($folderList);
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>