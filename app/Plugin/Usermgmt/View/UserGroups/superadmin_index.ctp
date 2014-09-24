<div class="content">
  <div id="right">
    <div id="right2">
      <div class="box">
        <div class="display_row">
          <div class="table">
            <div class="box">
              <div class="display_row">
                <!--<div class="table">
              <?php
						$this->Grid->addColumn('Group Id', '/UserGroup/id', array('paginate'=>true),'id');			
						$this->Grid->addColumn('Name', '/UserGroup/name', array('paginate'=>true),'name');			 
						$this->Grid->addColumn('Alias Name', '/UserGroup/alias_name', array('paginate'=>true),'alias_name');												
						$this->Grid->addColumn('Allow Registration', '/UserGroup/allowRegistration', array('paginate'=>true),'allowRegistration');
                        $this->Grid->addColumn('Created', '/UserGroup/created', array('paginate'=>true),'created');
                        $this->Grid->addAction('Edit', array('plugin' => 'usermgmt','controller' => 'UserGroups', 'action' => 'editGroup'), array('/UserGroup/id'));
					    $this->Grid->addAction('Delete', array('plugin' => 'usermgmt','controller' => 'UserGroups', 'action' => 'deleteGroup'), array('/UserGroup/id'));
						echo $this->Grid->generate($userGroups);
				?>
              <div class="paginator"> <?php echo $this->Paginator->numbers(array('first' => 'First page'));?>
                </td>
              </div>
            </div>-->
              </div>
              <!-- display box / second end here -->
            </div>
            <table cellspacing="0" cellpadding="0" width="100%" border="0" >
              <thead>
                <tr>
                  <th><?php echo __('Group Id');?></th>
                  <th><?php echo __('Name');?></th>
                  <th><?php echo __('Alias Name');?></th>
                  <th><?php echo __('Allow Registration');?></th>
                  <th><?php echo __('Created');?></th>
                  <th><?php echo __('Action');?></th>
                </tr>
              </thead>
              <tbody>
                <?php   if(!empty($userGroups)) {
							foreach ($userGroups as $row) {
								echo "<tr>";
								echo "<td>".$row['UserGroup']['id']."</td>";
								echo "<td>".h($row['UserGroup']['name'])."</td>";
								echo "<td>".h($row['UserGroup']['alias_name'])."</td>";
								echo "<td>";
								if ($row['UserGroup']['allowRegistration']) {
									echo "Yes";
								} else {
									echo "No";
								}
								echo"</td>";
								echo "<td>".date('d-M-Y',strtotime($row['UserGroup']['created']))."</td>";
								echo "<td>";
                                if ($row['UserGroup']['id']>25) {
									echo "<span class='icon'><a href='".$this->Html->url('/superadmin/usermgmt/user_groups/editGroup/'.$row['UserGroup']['id'])."'><img src='".SITE_URL."img/edit.png' border='0' alt='Edit' title='Edit'></a></span>&nbsp;&nbsp;";
                                    }
										if ($row['UserGroup']['id']>25) {
										echo $this->Form->postLink($this->Html->image(SITE_URL.'img/delete_bt.png', array("alt" => __('Delete'), "title" => __('Delete'))), array('action' => 'deleteGroup', $row['UserGroup']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to delete this group? Delete it at your own risk.')));
									}
								echo "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan=6><br/><br/>No Data</td></tr>";
						} ?>
              </tbody>
            </table>
            <div style="margin:15px 0 15px 0;clear:both">
                    <?php 
                        //echo $this->Paginator->prev(__('previous'), array(), null, array('class' => 'prev disabled')).'&nbsp;&nbsp;&nbsp;';
                        echo $this->Paginator->prev('Previous', null, null, array('class' => 'disabled')).'&nbsp;&nbsp;&nbsp;';
                        echo $this->Paginator->numbers();
                        echo  '&nbsp;&nbsp;&nbsp;'.$this->Paginator->next('Next ', null, null, array('class' => 'disabled')).'&nbsp;&nbsp;&nbsp;';
                        // echo '&nbsp;&nbsp;&nbsp;'.$this->Paginator->next(__('Next'), array(), null, array('class' => 'prev disabled')).'&nbsp;&nbsp;&nbsp;';
                        echo '&nbsp;&nbsp;&nbsp;'.$this->Paginator->counter();
                    ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>