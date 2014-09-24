<?php 
$startyear = 2006;

$endyear = date("Y",mktime(0,0,0,date('m')+1, date('d'), date('Y')));
$endmonth = date("m",mktime(0,0,0,date('m')+1, date('d'), date('Y')));

$currentyear = date("Y");

?>
<!-- content -->
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
          
          
          <!-- display box / first -->
          <div class="display_row padding_top_zero">
         
            <div class="table">
            
			 <?php for($year=$startyear;$year<=$endyear;$year++){?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                  <th colspan="6" valign="top" scope="col" class="title"><?php echo $year;?></th>
               </tr>
                <tr>
                  <th align="center" valign="top" scope="col">Date </th>
                  <th align="center" valign="top" scope="col">Gross    </th>
                  <th align="center" valign="top" scope="col">Agent </th>
                   <th align="center" valign="top" scope="col">Manager    </th>
                  <th align="center" valign="top" scope="col">Iso    </th>
                  <th align="center" valign="top" scope="col">Net</th>
                </tr>
                <?php 
                if($year==2006)
                	$startmonth = "02";
                else
                	$startmonth = "01";
                
                if($year==$endyear){
                	if($endyear==$currentyear)
                		$endmonth = date("m")+1;
                	else
                		$endmonth = "01";
                }else{
                	$endmonth = "12";
                }
                
                ?>
                
                <?php for($month=$startmonth;$month<=$endmonth;$month++){?>
                <?php 	$gross 		= $common->getTotal($month,$year,2);
						$agent 		= $common->getTotal($month,$year,1);
						$iso 		= $common->getTotal($month,$year,3);
						$manager 	= $common->getTotal($month,$year,4);
						$net 		= ($gross) - ($agent) - ($iso) - ($manager);
				?>
                <tr>
                  <td align="center" valign="top"><?php echo $common->getMonthName($month);?></td>
                  <td align="center" valign="top"><?php echo $this->Number->currency($gross,'USD');?></td>
                  <td align="center" valign="top"><?php echo $this->Number->currency($agent,'USD');?></td>
                  <td align="center" valign="top"><?php echo $this->Number->currency($iso,'USD');?></td>
                  <td align="center" valign="top"><?php echo $this->Number->currency($manager,'USD');?></td>
                  <td align="center" valign="top"><?php echo $this->Number->currency($net,'USD');?></td>
                </tr>
                <?php }?>   
              </table>
             <?php } // end of 1st for loop ?>
            </div>
          </div>
          
          <div class="clear"></div>
          
         <!-- display box / first -->
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 