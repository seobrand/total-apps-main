 <div class="select1">
                 <input type="checkbox" onclick="showTierDiv()" value="all" id="selectALLS">
               	 <label for="templateALL">ALL</label>
            </div>
 <?php
 echo $this->Form->input('EmailTemplate.emailId',array('class'=>'select1','id'=>'template','type'=>'select','options'=>$UserList,'empty'=>false,'multiple'=>'checkbox','label'=>false,'div'=>false,'style'=>'width:465px;')); ?>