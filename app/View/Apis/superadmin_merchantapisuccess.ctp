	<div id="containerBackground" >
    <div class="started_inner">
      
      <div id="started_box" class="clearfix">
    	<div class="application_form">
              <div class="product_search_indent">
                <?php /*?><div class="product_search_title">Merchant application</div><?php */?>
                <div class="applicationform_bg">
                  <table class="applicationform_table table_font" style="width: 95%;font-size:24px!important;font-weight:bold">
                    <tr>
                      <td width="100%" align="center"  style="width: 95%;font-size:18px!important;font-weight:bold">
                     <div class="success_msg">
                      <?php if($this->request->params['named']['message']=='failure'):?>
                     <div class="merchant_heading containerBack-heading"> Failure</div>
						 <?php echo $this->Session->read('popup');?>
					  <?php else:?>
                <div class="merchant_heading containerBack-heading"> Merchant Application Submitted!</div>
						Your Merchant Application is currently being reviewed by your account manager. In a few minutes, your account manager will email the completed Merchant Application back to you for final review. Please make sure that all your account information is accurate and that there are no errors. Then digitally sign at the bottom so we may approve your account right away.<br/><br/><br/>Thank you for applying with us and we look forward to exceeding your expectations!
					  <?php endif;?>
                      </div>
                      </td>
                    </tr>                    
                  </table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>    
 </div>
    </div>
  </div>