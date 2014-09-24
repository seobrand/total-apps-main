<table width="100%"  class="tablePopup" >
	<tr>
    	<td align="center"><h3>Label Size Selection</h3></td>
    </tr>
    <tr>
    	<td align="center">Please select your desired label size format</td>
    </tr>
    <tr>
    	<td align="center">
		<table align="center" width="350px" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">

		<?php
		$options = array('One' => 'Avery Label 1 1/3 x 4 inches', 'Two' => 'Avery Label 1 x 2 5/8 inches');
		$attributes = array('separator'=>'<br />','legend' => false,'onclick'=>'set_print_options();','id'=>'print_options','value'=>'One');
		echo $this->Form->radio('ptint_options', $options, $attributes);
		
		 ?>
         </td>
  </tr>
</table>
         </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
            <input type="button" value="Print" id="print_form" class='cursorclass ui-state-default ui-corner-all' />
            <input type="button" value="Cancel" id="close_colorbox" class='cursorclass ui-state-default ui-corner-all' />
        </td>
    </tr>
</table>

 
 <script>
 $(document).ready(function(){
 	$("#cboxClose").css('display','none');
 	set_print_options();
 })
 function set_print_options(){
 	if($('#PrintOptionsOne').is(':checked')){
 		$("#print_value").val('2');
	}
	if($('#PrintOptionsTwo').is(':checked')){
 		$("#print_value").val('3');
	}
   
 }
 $( "#print_form" ).click(function() {
   parent.$.colorbox.close();
   //window.parent.document.getElementById('from').submit();   
   $("#from").submit();
 })
 
 $( "#close_colorbox" ).click(function() {
 	parent.$.colorbox.close();
 })
 </script>