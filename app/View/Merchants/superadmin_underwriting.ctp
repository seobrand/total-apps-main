<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <div class="box1"> <?php echo $this->element('merchant_commonform'); ?>
        <!-- display box / first -->
        <div class="display_row" id="underwriting">
          <div class="tabs_outer"> <?php echo $this->element('merchant_tabmenu'); ?> </div>
          <div class="tabs_des">
			<div class="box1">
			  <div class="news_announcement">
				<div class="titlebar">Underwriting
				<div style="float:right">
					<a href="<?php echo $this->webroot; ?>superadmin/merchants/processinghistory/<?php echo $this->request->data['Merchant']['id']; ?>#processinghistory">Next</a>
				</div>
				</div>
        
       

<!--added new from here-->
<div class="news_indent">
  <div class="box1">
    <div class="news_announcement">
      <div class="news_indent">
     <?php  echo $this->Form->create('Merchant',array('controller'=>'merchants','action'=>'underwriting'))?> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
          <tr>
           <td>
           <table  width="99%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
           <tr>
            <td width="40%" align="left" valign="top" style="padding:5px 0px;"> Merchant Name: <?php echo $this->Form->input('Underwriting.merchantName',array('label'=>false,'div'=>false));?></td>
            <td width="48%" align="left" valign="top" style="padding:5px 0px;"> Date: <?php echo $this->Form->input('Underwriting.dateinfo',array('type'=>'text','label'=>false,'div'=>false,'style'=>'width:150px;'));?>(mm/dd/YYYY)</td>
            
           </tr>
              <tr>
            <td width="40%" align="left" valign="top" style="padding:5px 0px;"> URL: <?php echo $this->Form->input('Underwriting.url',array('label'=>false,'div'=>false));?></td>
            <td width="48%" align="left" valign="top" style="padding:5px 0px;"> Done By: <?php echo $this->Form->input('Underwriting.doneby',array('label'=>false,'div'=>false));?></td>
           </tr>
           </table>
           </td>  
          </tr>
          <tr>
          <td>
           <table  width="99%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form dynamic_form">
           <tr>
            <td colspan="3" width="100%" align="left" valign="top" style="padding:5px 0px;"> 
						<strong> 1.	Website Check </strong>
            </td>

            </tr>
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
           a.	List of all URL's to be processed on this account 
           </div>
            </td>
             <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
            <?php echo $this->Form->input('Underwriting.is_wc_url_processed',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
            <div class="clear"></div>
            </td>
           
            </tr>
            
            
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
           b.	Website is live
           </div>
            </td>
               <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
            <?php echo $this->Form->input('Underwriting.is_wc_website_live',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
                         <div class="clear"></div>
            </td>
            
            </tr>
            
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
           c.	Customer service links easily found 	
           </div>
            </td>
             <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_wc_cust_link_find',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
              <div class="clear"></div>
            </td>
            
            </tr>
            
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
           d.	Privacy statement 	
           </div>
            </td>
            <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
             <?php echo $this->Form->input('Underwriting.is_wc_privacy_stmt',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
                         <div class="clear"></div>
            </td>
           
            </tr>
            
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
         e.	Terms and conditions
           </div>
            </td>
             <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_wc_term_condition',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
           <div class="clear"></div>
            </td>
            
            </tr>
            
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
         f.	Refund Policy listed
           </div>
            </td>
              <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_wc_refund_policy_listed',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
           <div class="clear"></div>
            </td>
            
            </tr>
            
               <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
        g.	Buy page shows billing descriptor statement	
           </div>
            </td>
             <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_wc_descriptor_stmt',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
              <div class="clear"></div>
            </td>
          
            </tr>
            
       
       
        <tr>
            <td colspan="3" width="100%" align="left" valign="top" style="padding:5px 0px;"> 
						<strong> 2.	Background Check</strong>
            </td>

            </tr>
            
              <tr>
            <td width="45%"  align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
          a.	Netsol Check
           </div>
            </td>
              <td width="24%" align="left" valign="top" style="padding:5px 0px;">&nbsp; 
           
            </td>
             <td width="24%" align="left" valign="top" style="padding:5px 0px;">&nbsp; 
           
            </td>
          
            </tr>
            
            
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
           i.	Registrar matches application info
           </div>
           </div>
            </td>
             <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_bc_nc_registrar_matches_app_info',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
           <div class="clear"></div>
            </td>
            
            </tr>
            
            
               <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
          ii.	Server IP matches application info	
           </div>
           </div>
            </td>
             <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_bc_nc_server_ip_matches_app_ifo',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
           <div class="clear"></div>
            </td>
           
            </tr>
            
            
               <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
       iii.	Registration Date
           </div>
           </div>
            </td>
             <td colspan="2" align="left" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.bc_nc_registration_date',array('label'=>false,'div'=>false,'style'=>'width:110px;'));?>(mm/dd/YYYY)
            </td>
           
            </tr>
            
                <tr>
            <td width="45%"  align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
        b.	Alexa Check
           </div>
            </td>
             <td width="24%" align="left" valign="top" style="padding:5px 0px;">&nbsp; 
           
            </td>
             <td width="24%" align="left" valign="top" style="padding:5px 0px;">&nbsp; 
           
            </td>
          
            </tr>
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
        i.	Rank matches volume ok
           </div>
           </div>
            </td>
             <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_bc_ac_rank_matches_volume_ok',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
                  <div class="clear"></div>
            </td>
           
            </tr>
            
            
               <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
     ii.	Linked Websites ok	
           </div>
           </div>
            </td>
              <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_bc_ac_linked_website_ok',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
                <div class="clear"></div>
            </td>
            
            </tr>
            
            
               <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
      iii.	Wayback Machine ok
           </div>
           </div>
            </td>
              <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_bc_ac_wayback_machine_ok',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
               <div class="clear"></div>
            </td>
          
           
            </tr>
            
     <tr>
            <td width="45%"  align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
      c.	Rip Off Report
           </div>
            </td>
             <td width="24%" align="left" valign="top" style="padding:5px 0px;">&nbsp; 
           
            </td>
             <td width="24%" align="left" valign="top" style="padding:5px 0px;">&nbsp; 
           
            </td>
          
            </tr>
            
              <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
      i.	Owner's names ok	
           </div>
           </div>
            </td>
             <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_bc_rip_owner_name_ok',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
           <div class="clear"></div>
            </td>
            
            </tr>
            
            
               <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
   ii.	Corporation ok
           </div>
           </div>
            </td>
             <td width="48%" colspan="2" align="left" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_bc_rip_corporation_ok',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
             <div class="clear"></div>
            </td>
            
            </tr>
            
            
               <tr>
            <td width="45%" align="left" valign="top" style="padding:5px 0px;"> 
            <div class="list1">
             <div class="list1">
      iii.	Website URL ok
           </div>
           </div>
            </td>
              <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
           <?php echo $this->Form->input('Underwriting.is_bc_rip_website_url_ok',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
             <div class="clear"></div>
            </td>
           
           
            </tr>
            
              <tr>
            <td width="45%"  align="left" valign="top" style="padding:5px 0px;"> 
          
             <div class="list1">
     d.	Google link check
       
           </div>
            </td>
             <td width="24%" align="left" valign="top" style="padding:5px 0px;">&nbsp; 
           
            </td>
             <td width="24%" align="left" valign="top" style="padding:5px 0px;">&nbsp; 
           
            </td>
             
            </tr>
            
            <tr>
            <td width="100%" valign="top" align="left" style="padding:5px 0px;" colspan="3"> 
						<strong>3.	Processing History</strong>
            </td>

            </tr>
            
         <tr>
            <td width="45%" valign="top" align="left" style="padding:5px 0px;"> 
            <div class="list1">
           a.	Processing volume matches volume requested 
           </div>
            </td>
              <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
            <?php echo $this->Form->input('Underwriting.is_PH_pv_matches_vr',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
              <div class="clear"></div>
            </td>
            
            </tr>
            <tr>
            <td  width="45%" valign="top" align="left" style="padding:5px 0px;">
                 <div class="list1">
          b.	C/B ratio for volume and trans 
           </div>
            </td>
            <td valign="top" width="48%" align="left" style="padding:5px 0px;" colspan="2"> 
            VOL <?php echo $this->Form->input('Underwriting.PH_cb_ratio_for_volume',array('label'=>false,'div'=>false,'class'=>'small_size1'));?>
            &nbsp;&nbsp;&nbsp;
            TRANS  <?php echo $this->Form->input('Underwriting.PH_cb_ratio_for_trans',array('label'=>false,'div'=>false,'class'=>'small_size'));?>
            </td>
            </tr>
            
              <tr>
            <td width="45%" valign="top" align="left" style="padding:5px 0px;"> 
            <div class="list1">
           c.	Refund ratio LESS than 5% 	
           </div>
            </td>
              <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
	            <?php echo $this->Form->input('Underwriting.PH_refund_ratio_less_than_5',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
                <div class="clear"></div>
            </td>
           
            </tr>
            
              <tr>
            <td width="45%" valign="top" align="left" style="padding:5px 0px;"> 
            <div class="list1">
        d.	Average ticket matches website pricing 
           </div>
            </td>
               <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
	            <?php echo $this->Form->input('Underwriting.is_PH_avg_ticket_matches_wp',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
                  <div class="clear"></div>
            </td>
          
            </tr>
            
              <tr>
            <td width="45%" valign="top" align="left" style="padding:5px 0px;"> 
            <div class="list1">
           e.	Large volumetric fluctuations 
           </div>
            </td>
               <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
	            <?php echo $this->Form->input('Underwriting.is_PH_large_vol_fluctuation',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
                  <div class="clear"></div>
            </td>
           
            </tr>
            
              <tr>
            <td width="45%" valign="top" align="left" style="padding:5px 0px;"> 
            <div class="list1">
           f.	Reoccuring billing 
           </div>
            </td>
               <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
	            <?php echo $this->Form->input('Underwriting.is_PH_reoccuring_billing',array('type'=>'select','multiple'=>'checkbox','options'=>array('y'=>'YES','n'=>'NO','na'=>'N/A'),'label'=>false,'div'=>false));?>
                <div class="clear"></div>
            </td>
            </tr>
            
            <tr>
            <td width="100%" valign="top" align="left" style="padding:5px 0px;" colspan="3"> 
			<strong>4.	Risk Tier </strong>
            </td>

            </tr>
            <tr>
            <td width="45%" valign="top" align="left" style="padding:5px 0px;"> 
            <div class="list1">
           a.	Risk Tier 
           </div>
            </td>
               <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;"> 
	           
                <?php
				$options3=array('1'=>'1','1.5'=>'1.5','1.75'=>'1.75','2'=>'2');
				 echo $this->Form->input('Underwriting.risktier',array('type'=>'select','options'=>$options3,'label'=>false,'empty'=>'N/A','div'=>false,'style'=>'width:150px;'));?>
                <div class="clear"></div>
            </td>
            </tr>
            
             <tr>
            <td width="45%" valign="top" align="left" style="padding:30px 5px 0px 0px;">&nbsp;</td>
            <td width="48%" align="left" colspan="2" valign="top" style="padding:5px 0px;">
	            <div class="list12">
	          		<?php echo $this->Form->input('Underwriting.id', array('type' => 'hidden','value'=>$ID));?>
	            	<?php echo $this->Form->submit('UPDATE',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
	           </div>
           </td>
            </tr>
           </table>
		  </td>
          </tr>
        </table>
       <?php echo $this->Form->end();?>
      </div>
    </div>
  </div>
</div>
<!--ended new from here-->



                
				<div class="news_indent">		
          <div class="box1">
    <div class="news_announcement">		
    <div class="news_indent">		
				  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table outer_form">
					<tr>
					 <td width="100%" align="left" valign="top" style="padding:0px;">
					 <?php echo $this->Form->create('CheckList'); ?>
					  	<table width="50%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td align="left" width="35%" valign="middle">CHECKLIST</td>
							<td align="left" width="63%" valign="middle">
							<?php echo $this->Form->input('Merchant.checklist_value',array('type'=>'select','options'=>array('PASS'=>'PASS','FAILED'=>'FAILED'),'empty'=>'-N/A-','label'=>false,'class'=>'select1')); ?>							
							</td>
							<td align="left" width="25%" valign="middle"><?php echo $this->Form->submit('APPROVE',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
						  </tr>			 					  
						</table>
						<?php echo $this->Form->input("id",array('type'=>hidden));?>						  
						<?php echo $this->Form->end();?>
					 </td>
					 </tr>
					 <tr><td width="100%">&nbsp;</td></tr>
					 <tr>
					 <td width="100%" align="left" valign="top" style="padding:0px;">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					    <tr>
						  <td align="left" width="35%" valign="middle"><a onclick="showDuplicateMerchant();" class="cursorclass a-state-default ui-corner-all"><strong>CHECK DUPLICATE</strong></a>&nbsp;(By Clicking on this button you can view the list of all duplicate merchant who have same PHONE or SSN or EIN)</td>
					    </tr>						 					  
					  </table>
					 </td>						 
					</tr>
					</table>
					
				  <div class="box" id="duplicateMerchantDiv" style="display: none;">
		              <div class="display_row">
		                <div class="table">
		                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		                    <tr>
		                      <th width="25%" align="center" valign="top" scope="col">Merchant Name</th>
		                      <th width="25%" align="center" valign="top" scope="col">Phone Number</th>
		                      <th width="25%" align="center" valign="top" scope="col"> SSN</th>
							  <th width="25%" align="center" valign="top" scope="col"> EIN </th>
		                    </tr>
		                    <?php if(is_array($duplicateMerchant) && count($duplicateMerchant)>0):?>
		                    <?php foreach($duplicateMerchant as $merchant){?>								
		                    <tr>
		                      <td align="center" valign="top"><?php echo $this->Html->Link($merchant['Merchant']['merchantName'],array('controller'=>'merchants','action'=>'edit',$merchant['Merchant']['id']),array('target'=>'_blank'))?></td>
		                      <td align="center" valign="top"><?php echo $merchant['Merchant']['contactPhone']?></td>
		                      <td align="center" valign="top"><?php //echo $merchant['Merchant']['merchantName']?></td>
							  <td align="center" valign="middle"><?php //echo $merchant['Merchant']['merchantName']?></td>
		                    </tr>
		                    <?php } ?>	
		                    <?php else:?>		                   
							<tr>
		                      <td align="center" valign="top" colspan="4">No Duplicate merchant Found</td>
		                    </tr>	
		                   <?php endif;?> 							
		                  </table>
		                </div>
		              </div>
		            </div>				
                
                </div>
                </div>
                </div>		
				</div>
			  </div>
        	</div>
         </div>
        </div>
        <!-- display box / second end here -->
      </div>
      <!-- end table -->
    </div>
  </div>
  <!-- end content / right -->
</div>


<script type="text/javascript">
function numbersonly(myfield, e, dec)
	{ var key;var keychar;	
		if (window.event)
		   key = window.event.keyCode;
		else if (e)
		   key = e.which;
		else
		   return true;
		keychar = String.fromCharCode(key);
		// control keys
		if ((key==null) || (key==0) || (key==8) || 
			(key==9) || (key==13) || (key==27) || (key==46) )
		   return true;
		// numbers
		else if ((("0123456789").indexOf(keychar) > -1))
		   return true;
		else
		   return false;
	}
function showDuplicateMerchant(){
	if(document.getElementById('duplicateMerchantDiv').style.display=='none'){
		document.getElementById('duplicateMerchantDiv').style.display='block';
	}else{
		document.getElementById('duplicateMerchantDiv').style.display='none';
	}	
}
</script>
<script type="text/javascript">
$("input:checkbox").click(function() {
    if ($(this).attr("checked")) {
        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
        $(group).attr("checked", false);
        $(this).attr("checked", true);
    } else {
    	$(this).attr("checked", false);
    }
});
</script>