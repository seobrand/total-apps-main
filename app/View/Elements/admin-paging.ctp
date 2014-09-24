<?php /* echo "<pre>";
print_r($this->params->action); */?>
<?php $limit = (isset($this->request->query['limit']) && $this->request->query['limit']!='') ? $this->request->query['limit'] : 10; ?>
<table border="0" cellpadding="2" cellspacing="2" align="center"  class="pagingview" width="100%">
  <tr> 
  	<td colspan="2" align="left">
    <div class="f_left">
    	<?php echo $this->Paginator->numbers(array('first' => 'First page'));?>
     </div>
         <div class="f_right">Shows
      <select onchange="setURL('limit', this.value)">
      <?php if($this->params->action=='superadmin_rollback'){?>
		<option value="10"<?php echo ($limit == '10') ? ' selected="selected"' : ''?>>10</option>
        <option value="20"<?php echo ($limit == '20') ? ' selected="selected"' : ''?>>20</option>
        <option value="50"<?php echo ($limit == '50') ? ' selected="selected"' : ''?>>50</option>
        <option value="100"<?php echo ($limit == '100') ? ' selected="selected"' : ''?>>100</option>
      <?php }else{?>
        <option value="50"<?php echo ($limit == '50') ? ' selected="selected"' : ''?>>50</option>
		<option value="100"<?php echo ($limit == '100') ? ' selected="selected"' : ''?>>100</option>
		<!--<option value="200"<?php echo ($limit == '200') ? ' selected="selected"' : ''?>>200</option>-->
		<option value="500"<?php echo ($limit == '500') ? ' selected="selected"' : ''?>>500</option>
		<option value="1000"<?php echo ($limit == '1000') ? ' selected="selected"' : ''?>>1000</option>
	<?php }?>
	</select> Per Page
  </div>
  <div class="clear"></div>
	</td>
  </tr>
</table>	
<script type="text/javascript">
/**
 * setURL
 *
 * Modifies the current URL and redirects the browser
 *
 * @param string key The name of the parameter to set
 * @param mixed value The value to set the parameter to
 * @return void
 * @author Dom Hastings
 */
function setURL(key, value) {
  // set up the url separators
  newUrl = '';
  // get the current url
  var url = window.location.href;
  var url = url.replace(/(page=)[^\&]+/, '$1' + 1);
  // check if the specified key already exists
  var exists = url.indexOf('limit');
  var parameterExists = url.indexOf('?');
  // if it does
  if (exists > -1) {
  		// replace the value of limit
   		var newUrl = url.replace(/(limit=)[^\&]+/, '$1' + value);
  }else if(parameterExists > -1){
    	// append limit to new url
		var newUrl = url + '&limit='+value
  }else{
      	// append limit to new url
		var newUrl = url + '?limit='+value
  }

  // send controller to first page
  
  
  // set the url
  window.location.href = newUrl;
}</script>