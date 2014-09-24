<?php echo $this->Form->create('Post',array('enctype' => 'multipart/form-data')); ?>
<table>  
    <tr>
        <td colspan="2">
            <?php if(isset($errors)){ 
                foreach($errors as $k=>$v){
                    echo $v[0]."<br>";
                }
             }
            ?>
        </td>
    </tr>
    <tr>
        <td>Enter Post Title</td>
        <td><?php echo $this->Form->input('title',array('label'=>false,'div'=>false,'message'=>false)); ?></td>
    </tr>
    <tr>
        <td>Post Description</td>
        <td><?php echo $this->Form->input('body',array('rows'=>'4','message'=>false)); ?></td>
    </tr> 
    <tr>
        <td>Post Image</td>
        <td><?php echo $this->Form->input('imagename',array('type'=>'file','multiple')); ?></td>
    </tr>
     <tr>
         <td>&nbsp;</td>
        <td><?php echo $this->Form->end('Save Post'); ?></td>
    </tr>    
    <tr>
        <td><?php echo $this->Html->link('Back to Listing',array('action'=>'index')); ?></td>
        <td>&nbsp;</td>
    </tr>
</table>
