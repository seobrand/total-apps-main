<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Business Category
		   <div style="float:right">
         	<a href="<?php echo $this->webroot; ?>superadmin/businesscats/viewlist"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
            </div>
		  </div>
          <div class="news_indent">
            <?php  echo $this->Form->create('Businesscat',array('controller'=>'businesscats','action'=>'editbusinesscategory')); ?>
            <div class="news_indent">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="bottom">New Business Category *</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Businesscat.category_name',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                 <tr>
                  <td align="left" valign="bottom">Navigation Sort Order</td>
                </tr>
                 <tr>
                  <td align="left" valign="top"><?php echo $this->Form->input('Businesscat.navigationOrder',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Update Category',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
			   <?php echo $this->Form->input('Businesscat.id', array('type' => 'hidden','value'=>$this->request->data['Businesscat']['id']));?>
			  </div>
           <?php echo $this->Form->end();?>
		    </div>
		   <div class="news_indent" style="padding-top:0px;">
            <?php  echo $this->Form->create('Businesscat',array('name'=>'busisubcat','controller'=>'businesscats','action'=>'editbusinesscategory','onsubmit'=>'return chekcformvalidation(this)')); ?>
            <div class="news_indent" style="padding-top:0px;">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="no_bg">
                <tr>
                  <td align="left" valign="top">Business Sub Category*<br/><?php echo $this->Form->input('Businesscat.sub_category_name.0',array('label'=>false,'class'=>'input2'));?></td>
                </tr>
                <tr><td align="left" valign="top" id="add_more_subcategory"></td></tr>
                <tr>
                  <td align="left" valign="top"><?php echo $this->Html->link('Add More','javascript:void(0)',array('onclick'=>'addBusinessSubcategory()'));?></td>
                </tr>               
                <tr>
                  <td align="left" valign="top"><?php echo $this->Form->submit('Add Sub Category',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  </td>
                </tr>
              </table>
              <input type="hidden" value="1" id="catcount" name="count">
			   <?php echo $this->Form->input('Businesscat.parent_id', array('type' => 'hidden','value'=>$this->request->data['Businesscat']['id']));?>
			  </div>
           <?php echo $this->Form->end();?>
		  </div>
        </div>
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>
<script>
i=1;
function addBusinessSubcategory(){
	Ccontent = 'Business Sub Category*:<br><input id="BusinesscatSubCategoryName'+i+'" class="input2" type="text" name="data[Businesscat][sub_category_name]['+i+']"><br/><br/>';
	$('#add_more_subcategory').append(Ccontent);
	i++;
	$('#catcount').val(i);
}
function chekcformvalidation(form){
	error = 0;
	count =  form.count.value;
	for(i=0;i<count;i++){		
		if($('#BusinesscatSubCategoryName'+i).val()==""){			
			error++;
		}
	}
	if(error>0){
		alert("Please enter sub category name.");
		return false;
	}
}
</script>