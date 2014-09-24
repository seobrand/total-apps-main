		<div class="application_form">
              <div class="product_search_indent">
                <div class="product_search_title">Merchant application</div>
                <div class="applicationform_bg">
                  <table class="applicationform_table" style="width: 95%">
                    <tr>
                      <td width="100%" align="center">
                      <?php if($this->request->params['named']['message']=='failure'):?>
						 <?php echo $this->Session->read('popup');?>
					  <?php else:?>
						Merchant Application Submitted!<br/><br/>Your Merchant Application is currently being reviewed by your account manager. In a few minutes, your account manager will email the completed Merchant Application back to you for final review. Please make sure that all your account information is accurate and that there are no errors. Then digitally sign at the bottom so we may approve your account right away.<br/><br/><br/>Thank you for applying with us and we look forward to exceeding your expectations!<br/><br/>
					  <?php endif;?>
						<!--<span style="margin-left:60px;"><a href="<?php echo $this->webroot; ?>superadmin/dashboard">Go To Dashboard</a></span>-->
                      </td>
                    </tr>                    
                  </table>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
            
            


