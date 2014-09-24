<?php 
//pr($headers); 
?>
<tr class="<?php echo $options['class_header'] ?>">
	<?php foreach($headers as $header) { ?>
		<th <?php if($header['title']=='Actions'){?>width="15%" <?php }?>>
	<?php if ($header['options']['paginate']) {
			echo $this->Paginator->sort($header['actionNmae'],$header['title']);
		} else {
			echo $header['title'];
		}?>
		</th>
	<?php } ?>
</tr>