<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title></title>
<style>
body{padding-top:0; margin-top:0}
/*#box-wrapper table{width:100%; border:none; margin:0px; padding:0 20px 0 0;font-size:15px;}*/
#box-wrapper table{width:100%; border:none; margin:0px; padding:0px;font-size:15px;}
#box-wrapper{width:1000px; margin:0 auto;}
#box-wrapper table td{margin:0 0px; vertical-align:top;}

#box-wrapper table td.box-first-col{
	border:1px solid #000000;
	border-collapse:separate;
	-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px; height:103px; padding:0;}

#box-wrapper table td.box-first-col{text-align:center !important;} 
  #box-wrapper table td.two_column_avery_blank-space{width:0.12in;}
  #box-wrapper table td.two_column_avery_blank-space-last{width:0.12in;}
  #box-wrapper table td.two_column_avery{height:1.25in;width:2.5in; }
  #box-wrapper table td .two_column_avery_box{height:1.25in;font-size:18px; overflow: hidden;}
  
  #box-wrapper table td.three_column_avery_blank-space{width:0.08in;}
  #box-wrapper table td.three_column_avery{height:1.1in;width:3in;padding:0.05in 0.1in 0.1in;}
  #box-wrapper table td .three_column_avery_box{height:1.1in;font-size:15px; overflow: hidden;}
  #box-wrapper table td table{padding:0}
  
@media all {
  .pagebreak  {display: none;}
}

/* firefox specific */
  @-moz-document url-prefix() {
   		  #box-wrapper table td.box-first-col  { /* border:none; */text-align:center !important;}  
		  #box-wrapper table td.two_column_avery_blank-space{width:0.1in!important;}
		  #box-wrapper table td.two_column_avery{height:1.48in!important;width:4.0in!important;padding:0.05in 0.2in 0.2in!important;}
		  #box-wrapper table td .two_column_avery_box{height:1.48in!important;font-size:18px; overflow: hidden;}
		  #box-wrapper table {position:relative;}
		  
  	@media print {  	
	  	  #box-wrapper table td.box-first-col  { border:none;text-align:center !important;}  
		  
		  #box-wrapper table td.two_column_avery_blank-space{width:0.2in!important;font-size:0!important;}
		  #box-wrapper table td.two_column_avery_blank-space-last{width:0.0in!important;font-size:0!important;}
		  #box-wrapper table td.two_column_avery{height:1.53in!important;width:4.0in!important;padding:0.05in 0.2in 0.2in!important;}
		  #box-wrapper table td .two_column_avery_box{height:1.53in!important;font-size:18px; overflow: hidden;}
		  #box-wrapper table.two_column_avery {position:relative;margin-left:-15px!important;width:103%!important;}
		  
		  #box-wrapper table td.three_column_avery_blank-space{width:0.13in!important;font-size:0!important;}
		  #box-wrapper table td.three_column_avery_blank-space-last{width:0.0in!important;font-size:0!important;}
		  #box-wrapper table td.three_column_avery{height:1.19in!important;width:3.0in!important;padding:0.05in 0.1in 0.1in!important;}
		  #box-wrapper table td .three_column_avery_box{height:1.19in!important;font-size:15px; overflow: hidden;}
		  #box-wrapper table.three_column_avery {position:relative;margin-left:-14px!important;width:103%!important;}
		  
		  #box-wrapper table {position:relative;}
    }
    
  }

@media print {
  .pagebreak  { display: block; page-break-before: always; }
  #box-wrapper table td.box-first-col  {  border:none; text-align:center !important;}  
  
  #box-wrapper table td.two_column_avery_blank-space{width:0.12in;}
  #box-wrapper table td.two_column_avery_blank-space-last{width:0.12in;}
  #box-wrapper table td.two_column_avery{height:1.25in;width:2.5in;padding:0.2in;}
  #box-wrapper table td .two_column_avery_box{height:1.25in;font-size:18px; overflow: hidden;} 
  
  #box-wrapper table td.three_column_avery_blank-space{width:0.12in;}
  #box-wrapper table td.three_column_avery_blank-space-last{width:0.2in;}
  #box-wrapper table td.three_column_avery{height:1.042in;width:2.65in;padding:0.1in;}
  #box-wrapper table td .three_column_avery_box{height:1.042in;font-size:15px; overflow: hidden;}
  #box-wrapper table.three_column_avery {position:relative;margin-left:5px}
  
  #box-wrapper table td table{padding:0}  
}

 
 

</style>
</head>
<body onload="javascript:window.print()">
<?php echo $content_for_layout;?>
</body>
</html> 