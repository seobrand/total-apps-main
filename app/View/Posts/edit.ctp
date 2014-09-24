<?php echo $this->Form->create('Post'); ?>
<table>    
    <tr>
        <td>Enter Post Title</td>
        <td><?php echo $this->Form->input('title',array('label'=>false,'div'=>false)); ?></td>
    </tr>
    <tr>
        <td>Post Description</td>
        <td><?php echo $this->Form->input('body',array('rows'=>'4')); ?></td>
    </tr> 
     <tr>
        <td>Post Description</td>
        <td><?php echo $this->Form->input('id',array('type'=>'hidden')); echo $this->Form->end('Update Post'); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Html->link('Back to Listing',array('action'=>'index')); ?></td>
        <td>&nbsp;</td>
    </tr>
</table>
