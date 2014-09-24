<?php $loginRole = $UserGroupName; ?>
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
                <tr>
                    <td colspan="7">
                         <div id="loader_application" style="display: none; text-align: center;margin-bottom: 10px;">
                            <?php echo $this->Html->image('loading.gif', array('alt' => 'Loading'));?>
                       </div>
                    </td>
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
                          <div class="titlebar">Processing YTD Opportunities Gauge</div>
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
              <tr>
                <td align="right" valign="top" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top"><div class="graph_col">
                          <div class="titlebar">Annual Sales Volume</div>
                          <div class="graph_indent">
                          <div class="chart">
	                          	<div id="ytdvolumewrapper"></div>
	                          	<?php echo $this->HighCharts->render('YTD Volume Chart'); ?>
                                        
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
          
          
          
<?php ############## This section which is not visible for users(type-Support,Technical,QA,level 2 Support,etc..) ########## ?>
<?php if(strtolower($loginRole)=="admin" || strtolower($loginRole)=="agent" || strtolower($loginRole)=="manager" || strtolower($loginRole)=="processor" || strtolower($loginRole)=="referal" || strtolower($loginRole)=="iso"){?>
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
                text: 'Processing YTD'
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
            name: 'Processing YTD Opportunities',
            data: [<?php echo $common->getProcessingYTDApplication($user['User']['id'],$loginRole);?>],
            tooltip: {
                valueSuffix: ''
            }
        }]
    
    },
    // Add some life
    function (chart) {
        setInterval(function () {           
            newVal = <?php echo $common->getProcessingYTDApplication($user['User']['id'],$loginRole);?>;
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
 