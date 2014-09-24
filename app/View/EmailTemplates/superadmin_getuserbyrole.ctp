 <?php if(count($UserList)>0){?>
 <div class="select1">
    <input type="checkbox" name="user_select_all" onclick="showTierDiv()" value="all" id="selectALLS">
    <label for="templateALL">ALL</label>
 </div>
 <?php echo $this->Form->input('UserReport.id',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$UserList,'selected'=>$selected_user,'empty'=>false,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:465px;')); ?>
 <?php }else{?>
 No user Found
 <?php }?>