<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table>
    <tr>
        <td>Post ID</td>
        <td><?php echo $post['Post']['id']; ?></td>
    </tr>
    <tr>
        <td>Post Title</td>
        <td><?php echo $post['Post']['title']; ?></td>
    </tr>
    <tr>
        <td>Post Description</td>
        <td><?php echo $post['Post']['body']; ?></td>
    </tr>
    <tr>
        <td>Post Created</td>
        <td><?php echo $post['Post']['created']; ?></td>
    </tr>
    <tr>
        <td>Post Modified</td>
        <td><?php echo $post['Post']['modified']; ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Html->link('Back to Listing',array('action'=>'index')); ?></td>
        <td>&nbsp;</td>
    </tr>
</table>