<style>
/* task id 2059 */
.backbutton{float:right;}
@media print{ 
	div.backbutton { display:none;}
	<?php if($col_val==2){?>
	@page { margin: 0.8in 0in 0in 0in;}	
	<?php }else{?>
	@page { margin: 0.5in 0in 0in 0in;}	
	<?php }?>
}
@-moz-document url-prefix() {
	<?php if($col_val==3){?>  	
	  @page { margin: 0.35in 0in 0in 0in!important;}
	<?php }else{?>
	  @page { margin: 0.74in 0in 0in 0in!important;}
	<?php }?>
}
</style>
<?php /*  task id 2059 */ ?>
<div class="backbutton">
   <a href="<?php echo $this->webroot; ?>superadmin/addresses/searchuser"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a>
</div>

<?php echo $resultAddress;?>