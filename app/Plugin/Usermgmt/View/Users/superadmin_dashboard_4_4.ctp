<?php 
    echo $this->Html->css('style_preview.css');
    echo $this->Html->script('popup.js');
    $loginRole = $UserGroupName;
?>
<script>
	$(document).ready(function(){
     $("#automatic_click").click();
    });
</script>
<style>
 #content-pane
 {
 	top:0px!important;
 }
 .window
 {
 left:0px!important;
 margin:auto;
 }
 #boxes
 {
 	
 }
 .popup_indent table.no_bg td{padding:5px 0px;}
 </style>
 
<?php if(count($todayAppointment)>0): ?>
<a href="#onloadpopup" id="automatic_click" name="modal"  style="display:none"></a>
<?php endif;?>
<!--------- Today Appointmet Start Here ------->
<div id="boxes" style="margin-top:2px;">
<div id="onloadpopup" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);"> 
<table height="100%" width="1150" style="margin:auto">
<tr>
<td valign="middle">
<div class="popup_outer2" style="width: 1150px;left:0px;margin:auto;z-index:99999999999;">
<a href="#" class="close close_button" style="float:right;"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
<div class="stroke" style="overflow: visible;">
<div class="popup_container2" style="padding:35px 0">
<div class="popup_indent" style="padding:0 0 0 0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr height="20">
	  <th align="center" valign="top" scope="col">Date </th>
	  <th align="center" valign="top" scope="col">Time </th>
	  <th align="center" valign="top" scope="col">Merchant </th>
	  <th align="center" valign="top" scope="col">URL </th>
	  <th align="center" valign="top" scope="col">Name </th>
	  <th align="center" valign="top" scope="col">Phone </th>
	  <th align="center" valign="top" scope="col">Email </th>
	  <th align="center" valign="top" scope="col">Action </th>
	</tr>
	<?php foreach($todayAppointment as $key => $todayappointments):?>
	<tr height="20">
	  <td align="center" valign="top"><?php echo date("m/d/Y",strtotime($todayappointments['Appointment']['appointmentFrom'])); ?> </td>
	  <td align="center" valign="top"><?php echo date("h:i A",strtotime($todayappointments['Appointment']['appointmentFrom'])); ?> </td>
	  <td align="center" valign="top"><a href="<?php echo $this->webroot;?>superadmin/merchants/edit/<?php echo $todayappointments['Appointment']['merchantID'];?>"><?php echo strtoupper($todayappointments['Merchant']['merchantName']);?></a></td>
	  <td align="center" valign="top"><?php echo $todayappointments['Merchant']['merchantURL'];?></td>
	  <td align="center" valign="top"><a href="<?php echo $this->webroot;?>superadmin/merchants/edit/<?php echo $todayappointments['Appointment']['merchantID'];?>"><?php echo strtoupper($todayappointments['Merchant']['contactName']);?></a></td>
	  <td align="center" valign="top"><?php echo $todayappointments['Merchant']['contactPhone'];?> </td>
	  <td align="center" valign="top"><a href="mailto:<?php echo $todayappointments['Merchant']['contactEmail'];?>"><?php echo $todayappointments['Merchant']['contactEmail'];?></a></td>
	  <td align="center" valign="top"><?php echo strtoupper($todayappointments['Appointment']['action']);?></td>
	</tr>
	<?php endforeach;?>
</table>
</div>
</div>
</div>
</div>
</td>
</tr>
</table>

</div>
<!-- Mask to cover the whole screen -->
<div id="mask">&nbsp;</div>
</div>
<!--------- Today Appointmet End Here ------->


<!-- Appointment edit from here in popup start -->
<a href="#appointmentloadpopup" id="appointment_edit_click" name="modal"  style="display:none"></a>
<!--------- Today Appointmet Start Here ------->
<div id="boxes" style="margin-top:2px;">
<div id="appointmentloadpopup" class="window " style="padding-left:26px;position:fixed;width:100%;height:100%;background:rgba(0, 0, 0, .5);"> 
<table height="100%" width="1150" style="margin:auto">
<tr>
<td valign="middle">
<div class="popup_outer2" style="width: 950px;left:0px;margin:auto;z-index:99999999999;">
<a href="#" class="close close_button" style="float:right;"><?php echo $this->Html->image('close.png', array('alt' => 'Home'));?></a>
<div class="stroke" style="overflow: visible;">
<div class="popup_container2" style="padding:35px 10px">
<?php  //echo $this->Form->create('Appointment',array('controller'=>'appointments','action'=>'editappointment','usermgmt'=>false)); ?>
<form id="AppointmentEditappointmentForm" accept-charset="utf-8" method="post" action="<?php echo $this->webroot;?>superadmin/appointments/editappointment">
<div class="popup_indent" style="padding:0 0 0 0" id="appointment_info"></div>
<input type="hidden" name="data[Appointment][editFrom]" value="dashboard" />
</form>
</div>
</div>
</div>
</td>
</tr>
</table>
</div>
<!-- Mask to cover the whole screen -->
<div id="mask">&nbsp;</div>
</div>




<div class="content"> 


  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div id="right2"> 
        <!-- table -->
        <div class="box1">
         <div class="news_announcement">
            <div class="titlebar">NEWS AND ANNOUNCEMENTS - ADMIN</div>
            <div class="news_indent">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="no_bg">
<tr>
<td align="left" valign="top" style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php foreach($News as $value){ ?>
<tr>
<td align="left" valign="top">
 <strong><?php echo $value['News']['title'] ?></strong><br />
<?php echo $value['News']['description'] ?>
</td>
</tr>

<?php } ?>

</table></td>
</tr>
</table>
            </div>
          </div>
		  </div>
          
          <!-- display box / first -->
          <div class="display_row">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th colspan="9" valign="top" scope="col" class="title"> Appointments </th>
                </tr>
                <tr>
                  <th align="center" valign="top" scope="col">Date </th>
                  <th align="center" valign="top" scope="col">Time </th>
                  <th align="center" valign="top" scope="col">Merchant </th>
                  <th align="center" valign="top" scope="col">URL </th>
                  <th align="center" valign="top" scope="col">Name </th>
                  <th align="center" valign="top" scope="col">Phone </th>
                  <th align="center" valign="top" scope="col">Email </th>
                  <th align="center" valign="top" scope="col">Action </th>
                  <th align="center" valign="top" scope="col">&nbsp;</th>
                </tr>
                <?php foreach($appointment as $key => $appointments):?>
				<tr>
                  <td align="center" valign="top"><?php echo date("m/d/Y",strtotime($appointments['Appointment']['appointmentFrom'])); ?> </td>
                  <td align="center" valign="top"><?php echo date("h:i A",strtotime($appointments['Appointment']['appointmentFrom'])); ?> </td>
                  <td align="center" valign="top"><a href="<?php echo $this->webroot;?>superadmin/merchants/edit/<?php echo $appointments['Appointment']['merchantID'];?>"><?php echo strtoupper($appointments['Merchant']['merchantName']);?></a></td>
                  <td align="center" valign="top"><?php echo $appointments['Merchant']['merchantURL'];?></td>
                  <td align="center" valign="top"><a href="<?php echo $this->webroot;?>superadmin/merchants/edit/<?php echo $appointments['Appointment']['merchantID'];?>"><?php echo strtoupper($appointments['Merchant']['contactName']);?></a></td>
                  <td align="center" valign="top"><?php echo $appointments['Merchant']['contactPhone'];?> </td>
                  <td align="center" valign="top"><a href="mailto:<?php echo $appointments['Merchant']['contactEmail'];?>"><?php echo $appointments['Merchant']['contactEmail'];?></a></td>
                  <td align="center" valign="top"><?php echo strtoupper($appointments['Appointment']['action']);?></td>
                  <td align="center" valign="top">
                  <?php echo $this->Html->image("edit.png", array('alt'=>'Edit','title'=>'Edit','onclick'=>'editAppointment('.$appointments['Appointment']['id'].')')); ?>&nbsp;
				  <?php echo $this->Html->image("delete_bt.png", array('alt'=>'Delete','title'=>'Delete','onclick'=>'return confirm("Are you sure to delete this appointment?");','url' => array('controller' => 'appointments','action'=>'delete', $appointments['Appointment']['id'], 'plugin' => null))); ?>
				  </td>
                </tr>
                <?php endforeach;?>
				<?php if(count($appointment)==0):?>
				<tr>
                  <td align="center" colspan="9">No Appointment Found</td>
                </tr>
				<?php endif;?>
              </table>
            </div>
          </div>
         <?php ############## This section which is not visible for users(type-Support,Technical,QA,level 2 Support,etc..) ########## ?>
         <?php if(strtolower($loginRole)=="admin" || strtolower($loginRole)=="agent" || strtolower($loginRole)=="manager" || strtolower($loginRole)=="processor" || strtolower($loginRole)=="referal"){?>
          <div class="display_row">
            <div class="table">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th align="left" valign="top" scope="col">Applications for <?php echo $user['User']['user_Name'];?> (ID# <?php echo $user['User']['id'];?>) </th>
                  <th align="center" valign="top" scope="col">Today </th>
                  <th align="center" valign="top" scope="col">MTD </th>
                  <th align="center" valign="top" scope="col">Last Month </th>
                  <th align="center" valign="top" scope="col">YTD </th>
                  <th align="center" valign="top" scope="col">Last Year </th>
                  <th align="center" valign="top" scope="col">Lifetime </th>
                </tr>
				<?php $todayCount = 0;$mtdCount = 0;$lastmonthCount=0;$ytdCount=0;$lastyearCount=0;$lifetimeCount=0; ?>
				<?php foreach($Status as $key =>$status):?>
				<?php // total of each timeframe //
						  $todayApiCount = $common->todayPipeline($status['Status']['id'],$user['User']['id'],$loginRole);
						  $todayCount += $todayApiCount;
						  $mtdApiCount =  $common->mtdPipeline($status['Status']['id'],$user['User']['id'],$loginRole);
						  $mtdCount 	+= $mtdApiCount;
						  $lastmonthApiCount = $common->lastmonthPipeline($status['Status']['id'],$user['User']['id'],$loginRole);
						  $lastmonthCount += $lastmonthApiCount;
						  $ytdApiCount = $common->ytdPipeline($status['Status']['id'],$user['User']['id'],$loginRole);
						  $ytdCount += $ytdApiCount;
						  $lastyearApiCount = $common->lastyearPipeline($status['Status']['id'],$user['User']['id'],$loginRole);
						  $lastyearCount += $lastyearApiCount;
						  $lifetimeApiCount = $common->lifetimePipeline($status['Status']['id'],$user['User']['id'],$loginRole);
						  $lifetimeCount += $lifetimeApiCount;
				?>
                <tr>
                  <td align="left" valign="top"><?php echo $status['Status']['status'];?></td>
                  <td align="center" valign="top">
				  <?php //$todaycount = $common->todayPipeline($status['Status']['id'],$user['User']['id'],$loginRole);?>
				  <?php if($todayApiCount>0):?>
					<strong><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/<?php echo $status['Status']['id']?>/today"><?php echo $todayApiCount;?></a></strong>
				  <?php else:?>
				  	<?php echo $todayApiCount;?>	
				  <?php endif;?>				  
				  </td>
                  <td align="center" valign="top">
				  <?php //$mtdcount = $common->mtdPipeline($status['Status']['id'],$user['User']['id'],$loginRole);?>
				  <?php if($mtdApiCount>0):?>
					<strong><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/<?php echo $status['Status']['id']?>/mtd"><?php echo $mtdApiCount;?></a></strong>
				  <?php else:?>
				  	<?php echo $mtdApiCount;?>	
				  <?php endif;?>
                  <td align="center" valign="top">
				  <?php //$lastmonthcount = $common->lastmonthPipeline($status['Status']['id'],$user['User']['id'],$loginRole);?>
				  <?php if($lastmonthApiCount>0):?>
					<strong><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/<?php echo $status['Status']['id']?>/lastmonth"><?php echo $lastmonthApiCount;?></a></strong>
				  <?php else:?>
				  	<?php echo $lastmonthApiCount;?>	
				  <?php endif;?>
                  <td align="center" valign="top">
				  <?php //$ytdcount = $common->ytdPipeline($status['Status']['id'],$user['User']['id'],$loginRole);?>
				  <?php if($ytdApiCount>0):?>
					<strong><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/<?php echo $status['Status']['id']?>/ytd"><?php echo $ytdApiCount;?></a></strong>
				  <?php else:?>
				  	<?php echo $ytdApiCount;?>	
				  <?php endif;?>
                  <td align="center" valign="top">
				  <?php //$lastyearcount = $common->lastyearPipeline($status['Status']['id'],$user['User']['id'],$loginRole);?>
				  <?php if($lastyearApiCount>0):?>
					<strong><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/<?php echo $status['Status']['id']?>/lastyear"><?php echo $lastyearApiCount;?></a></strong>
				  <?php else:?>
				  	<?php echo $lastyearApiCount;?>	
				  <?php endif;?>
                  <td align="center" valign="top">
				  <?php //$lifetimecount = $common->lifetimePipeline($status['Status']['id'],$user['User']['id'],$loginRole);?>
				  <?php if($lifetimeApiCount>0):?>
					<strong><a href="<?php echo $this->webroot; ?>superadmin/merchants/viewbystatus/<?php echo $status['Status']['id']?>/lifetime"><?php echo $lifetimeApiCount;?></a></strong>
				  <?php else:?>
				  	<?php echo $lifetimeApiCount;?>	
				  <?php endif;?>
                </tr>
				<?php endforeach;?>
                <tr>
                  <td align="left" valign="top" class="blue"><strong>TOTAL </strong></td>
                  <td align="center" valign="top" class="blue"><strong><?php echo $todayCount; ?></strong></td>
                  <td align="center" valign="top" class="blue"><strong><?php echo $mtdCount; ?></strong></td>
                  <td align="center" valign="top" class="blue"><strong><?php echo $lastmonthCount; ?></strong></td>
                  <td align="center" valign="top" class="blue"><strong><?php echo $ytdCount; ?></strong></td>
                  <td align="center" valign="top" class="blue"><strong><?php echo $lastyearCount; ?></strong></td>
                  <td align="center" valign="top" class="blue"><strong><?php echo $lifetimeCount; ?></strong></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="clear"></div>
          <div class="content_outer">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="graphs">
              <tr>
                <td align="left" valign="top" width="40%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                      <td align="left" valign="top"><div class="graph_col">
                          <div class="titlebar">MY PIPELINE</div>
                          <div class="graph_indent">
	                          <div class="chart">
	                          	<div id="piewrapper"></div>
	                          	<?php echo $this->HighCharts->render('Pie Chart'); ?>
							  </div>
						  </div>
                        </div></td>
                    </tr>
                  </table></td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top"><div class="graph_col">
                          <div class="titlebar">Applications Submitted</div>
                          <div class="graph_indent">
                          <div class="chart">
                           <div id="columnwrapper"></div>
								<?php echo $this->HighCharts->render('Column Chart'); ?>
							</div>
                          </div>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" width="40%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                      <td align="left" valign="top"><div class="graph_col">
                          <div class="titlebar">My Closed Won Opportunities Gauge</div>
                          <div class="graph_indent">
	                          <div id="container" style="width: 450px; height: 400px; margin: 0 auto"></div>
						  </div>
                        </div></td>
                    </tr>
                  </table></td>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top"><div class="graph_col">
                          <div class="titlebar">Monthly Sales Volume</div>
                          <div class="graph_indent">
                          <div class="chart">
	                          	<div id="volumewrapper"></div>
	                          	<?php echo $this->HighCharts->render('Volume Chart'); ?>
							  </div>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            </ul>
          </div>
          <!-- display box / first end here --> 
          <!-- display box / second --> 
          <?php } ?>
          <?php ############## END OF section which is not visible for users(type-Support,Technical,QA,level 2 Support,etc..) ########## ?>          
          <!-- display box / second end here --> 
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>

<script type="text/javascript">
function editAppointment(app_id)
{
	$(document).ready(function(){
     $("#appointment_edit_click").click();
    });
	
	var xmlhttp;
	//var country='';
	//agent=document.getElementById('agent').value;
	//alert(country);
	if(app_id!=null || app_id!='')
	{
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//alert(xmlhttp.responseText);
				document.getElementById("appointment_info").innerHTML=xmlhttp.responseText;
			}else{
				document.getElementById("appointment_info").innerHTML='Please Wait....';
			}
		  }
		var url='';
		url='<?=FULL_BASE_URL.router::url('/',false).'superadmin/appointments/editappointment'?>/'+app_id;
		
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
	}
	else
	{
		alert('Please select valid appointment.');
	}

}

/***********  Code to show datetimepicker ***********/
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#AppointmentAppointmentFromEdit').live('focus', function (e){
		 jQuery(this).datetimepicker({
				timeFormat: "hh:mm tt"
			});		
	});
	jQuery('#AppointmentAppointmentToEdit').live('focus', function (e){
		 jQuery(this).datetimepicker({
				timeFormat: "hh:mm tt"
			});		
	});
	
});
</script>

<?php ############## This section which is not visible for users(type-Support,Technical,QA,level 2 Support,etc..) ########## ?>
<?php if(strtolower($loginRole)=="admin" || strtolower($loginRole)=="agent" || strtolower($loginRole)=="manager" || strtolower($loginRole)=="processor" || strtolower($loginRole)=="referal"){?>
<?php //echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'));?>
<?php
 echo $this->Html->script('high_chart/highcharts.js');
 echo $this->Html->script('high_chart/highcharts-more.js');
 echo $this->Html->script('high_chart/exporting.js');
 ?>
 <?php $greenvalue = ceil($lifetimeCount*2/3); ?>
 <?php $yellowvalue = ceil($lifetimeCount*6/7); ?>
 <?php $redvalue = ceil($lifetimeCount); ?>
 
 <script type="text/javascript">
 $(function () {
    
    var chart = new Highcharts.Chart({
    
        chart: {
            renderTo: 'container',
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        
        title: {
            text: 'Number Of Opportunities'
        },
        
        credits: {
        	text: ''
        },
        
        pane: {
            startAngle: -90,
            endAngle: 90,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
           
        // the value axis
        yAxis: {
            min: 0,
            max: <?php echo $lifetimeCount; ?>,
            
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',
    
            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'Closed Opportunities'
            },            
            plotBands: [{
                from: 0,
                to: <?php echo $greenvalue;?>,
                color: '#55BF3B' // green
            }, {
                from: <?php echo $greenvalue?>,
                to: <?php echo $yellowvalue?>,
                color: '#DDDF0D' // yellow
            }, {
                from: <?php echo $yellowvalue?>,
                to: <?php echo $redvalue;?>,
                color: '#DF5353' // red
            }]        
        },
    
        series: [{
            name: 'Closed Opportunities',
            data: [<?php echo $common->getClosedApplication($user['User']['id'],$loginRole);?>],
            tooltip: {
                valueSuffix: ''
            }
        }]
    
    },
    // Add some life
    function (chart) {
        setInterval(function () {           
            newVal = <?php echo $common->getClosedApplication($user['User']['id'],$loginRole);?>;
            //	alert(newVal)
            if (newVal < 0 || newVal > 200) {
                newVal = point.y - inc;
            }
            
            point.update(newVal);
            
            
        }, 3000);
    });
});
</script>
<?php } ?>
<?php ############## END OF section which is not visible for users(type-Support,Technical,QA,level 2 Support,etc..) ########## ?>
 