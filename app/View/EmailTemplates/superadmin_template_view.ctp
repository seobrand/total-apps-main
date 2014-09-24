
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="breadcrumb"></div>
    <div id="right2">
      <!-- table -->
      <br />
      <br />
      <div class="box1">
        <div class="news_announcement">
          <div class="titlebar">Template Detail
            <div style="float:right"> <a href="<?php echo $prePage; ?>"><?php echo $this->Html->image('back.png',array('title' => 'Back'));?></a> </div>
          </div>
          <div class="box">
            <div class="display_row">
              <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
                <tr>
                  <td align="right" valign="top"><span class="required">*</span>Title :</td>
                  <td align="left" valign="top"><?php echo $templateRec['EmailTemplate']['title']; ?></td>
                </tr>
                <tr>
                  <td width="15%" align="right" valign="top"><span class="required">*</span>Subject :</td>
                  <td width="85%" align="left" valign="top"><?php echo $templateRec['EmailTemplate']['subject']; ?></td>
                </tr>
                <tr>
                  <td width="15%" align="right" valign="top">From :</td>
                  <td width="85%" align="left" valign="top"><?php echo $templateRec['EmailTemplate']['from']; ?></td>
                </tr>
                <tr>
                  <td align="right" valign="top"><span class="required">*</span>Message :</td>
                  <td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0" class="nostyle" >
                      <tr>
                        <td>
                        <?php echo $templateRec['EmailTemplate']['message']; ?>
                         </td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end table -->
  </div>
</div>
