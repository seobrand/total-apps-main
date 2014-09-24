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
                <div class="titlebar">My Templates LIST
                  <div style="float:right"> <a href="<?php echo $this->webroot; ?>superadmin/email_templates/createTemplate">Add New</a> </div>
                </div>
                <div class="box">
                  <div class="display_row">
                  
                  
                    <div class="table">
                      <?php
						$this->Grid->addColumn('Name', '/EmailTemplate/title', array('paginate'=>true),'title');	
						$this->Grid->addColumn('Subject', '/EmailTemplate/subject', array('paginate'=>true),'subject');	
                        $this->Grid->addColumn('message', '/EmailTemplate/message', array('paginate'=>true),'message');			 
						$this->Grid->addColumn('From', '/EmailTemplate/from', array('paginate'=>true),'from');
                        $this->Grid->addAction('Edit', array('controller' => 'email_templates', 'action' => 'editTemplate'), array('/EmailTemplate/id'));
						$this->Grid->addAction('Delete', array('controller' => 'email_templates', 'action' => 'delete'), array('/EmailTemplate/id'));
                        $this->Grid->addAction('View', array('controller' => 'email_templates', 'action' => 'templateView'), array('/EmailTemplate/id'));
						echo $this->Grid->generate($templateRec);
					?>
                      <div class="paginator">
                        <?php //if(count(merchantSearchList)>0):?>
                        <?php echo $this->element('admin-paging');?>
                        </td>
                        <?php //endif;?>
                      </div>
                    </div>
                    
               
               <?php if(count($adminTemplate)) {?>
                <br /><br />
                    <div class="titlebar">Admin Template LIST
                  <div style="float:right">  </div>
                </div>
                 <br /><br />
                    <div class="table">
                    
                    	<table class="cg_table" width="100%">
                        <thead>
                        <tr class="cg_header">
                            	<th>Name</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>From</th>
                                <th>Action</th>
                            </tr>
                           </thead>
                            <?php 
							foreach($adminTemplate as $value)
							{
								?>
                                <tr>
                                <td><?php echo $value['EmailTemplate']['title'] ?></td>
                                <td><?php echo $value['EmailTemplate']['subject'] ?></td>
                                <td>HTML</td>
                                <td><?php echo $value['EmailTemplate']['from'] ?></td>
                                <td><?php echo $this->Html->link('View',array('controller'=>'email_templates','action'=>'templateView',$value['EmailTemplate']['id'])); ?></td>
                                </tr>
                                <?php
							}
							?>
                            
                        </table>
                    </div>
                    <?php } ?>
                    
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
