<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//pr($results);
?>

<table width="100%">
    <tr>
        <th colspan="5"><?php echo $this->Html->link('Add New Post',array('action'=>'add','controller'=>'posts')); ?></th>        
    </tr>
    <tr>
        <th><?php echo $this->Paginator->sort('id','ID'); ?></th>
        <th><?php echo $this->Paginator->sort('title','Title'); ?></th>
        <th><?php echo $this->Paginator->sort('body','Description'); ?></th>
        <th><?php echo $this->Paginator->sort('created','Created'); ?></th> 
        <th>Action</th>
    </tr>
    <?php foreach($posts as $post){ ?>
    <tr>
        <td><?php echo $post['Post']['id']; ?></td>
        <td><?php echo $post['Post']['title']; ?></td>
        <td><?php echo substr($post['Post']['body'],0,100); ?></td>
        <td><?php echo $post['Post']['created']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit',array('action'=>'edit',$post['Post']['id'])); ?>
            | 
            <?php echo $this->Form->postLink('Delete',array('action'=>'delete',$post['Post']['id']),array('confirm'=>'Are you sure want to delete?')); ?> 
            <?php //echo $ajax->link('Delete',array('action'=>'delete',$post['Post']['id']),array('confirm'=>'Are you sure want to delete?')); ?> 
            | 
            <?php echo $this->Html->link('View',array('action'=>'view',$post['Post']['id']));//echo $html->link('View',array('action'=>'view',$post['Post']['id'])); ?>
        </td>
    </tr>
    <?php } ?>
</table>