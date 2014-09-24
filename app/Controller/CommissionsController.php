<?php App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
class CommissionsController extends AppController {
	    var $layout = 'admin';
	    var $components = array('Usermgmt.UserAuth','Session','Common','Cookie','Email','RequestHandler');
		var $helpers = array('CakeGrid.Grid');
		
		public function superadmin_upload()
		{
			$errorsArr = "";				
			if ($this->request->is('post')) {
				if($this->request->data['SUBMIT']=='SUBMIT')
				{
					$this->Commission->set($this->request->data);
					if(!$this->Commission->validates())
					{
						$errorsArr = $this->Commission->validationErrors;
					}
					if($errorsArr)
					{
						$this->set('errors',$errorsArr);
						$this->set('data',$this->request->data);						
					}else{
						$prefix = time();
						$filename = $prefix."_".$this->request->data['Commission']['message']['name'];					
						$docDestination = APP.'webroot/uploaded/'.$filename;				            
			            @move_uploaded_file($this->request->data['Commission']['message']['tmp_name'], $docDestination) or die($docDestination);	
			            @chmod($docDestination, "0777");
						
						if($this->request->data['Commission']['message']['type']=='application/vnd.ms-excel') {
							$data = new Spreadsheet_Excel_Reader("uploaded/".$filename, true);
							$temp = $data->dumptoarray();
							
							/*$this->set('xlsrecord',$temp);	 */		                
			            }else if($this->request->data['Commission']['message']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
			            	$data = new Spreadsheet_Excel_Reader("uploaded/".$filename, true);
							$temp = $data->dumptoarray();
							/* $this->set('xlsrecord',$temp); */
			            }
			            // make two array of MID's Matching OR Not Matching
				  
			            if(is_array($temp)){
			            	if(count($temp)>100){
			            		$this->Session->write('popup','You are trying to upload more than 100 records , please try again and make sure that your excel sheet contains less than 100 records.');
			            		$this->Session->setFlash('You are trying to upload more than 100 records , please try again and make sure that your excel sheet contains less than 100 records.');
			            		$this->redirect(array('controller'=>'commissions','action' => "upload/message:failure"));
			            		exit;
			            	}
			            	foreach($temp as $key => $xlsValue){
			            		if($xlsValue[1]!="MID #" && $xlsValue[1]!="MID" && $xlsValue[1]!="MID#" && $xlsValue[1]!="mid"){
			            			$merchant = $this->Common->getMerchantNameByMID($xlsValue[1]);
			            			//MID's Matching
			            			if($merchant['Merchant']['merchantName']!=''){
		            					$merchants[$key]['merchantName'] = $merchant['Merchant']['merchantName'];
		            					$merchants[$key]['id'] = $merchant['Merchant']['id'];
		            					$merchants[$key][] =	$xlsValue[1];	
		            					$merchants[$key][] =	$xlsValue[2];
		            					$merchants[$key][] =	$xlsValue[3];
		            					$merchants[$key][] =	$xlsValue[4];
		            					$merchants[$key][] =	$xlsValue[5];
										$merchants[$key][] =	$xlsValue[6];
										$merchants[$key][] =	$xlsValue[7];
		            				}else{
		            					//MID's Not Matching
		            					$mids[$key][] =	$xlsValue[1];
		            					$mids[$key][] =	$xlsValue[2];
		            					$mids[$key][] =	$xlsValue[3];
		            					$mids[$key][] =	$xlsValue[4];
		            					$mids[$key][] =	$xlsValue[5];
										$mids[$key][] =	$xlsValue[6];
										$mids[$key][] =	$xlsValue[7];
		            				}		            							            			
			            		}
			            	}
			            	$this->set('merchants',$merchants);
			            	$this->set('mids',$mids);
			            	@unlink($docDestination);
			            }// end of if conditions			            
					}
				}
			}
		}
	
		public function superadmin_approve(){
			//pr($this->request->data['Commission']);
			$this->loadModel('Commissionlog');
			$this->loadModel('Merchant');
			
			if ($this->request->is('post')) {
				//pr($this->request->data);
				$commissions = unserialize($this->request->data['Commission']['final_array']);
				
				$lastupdateby = $this->Session->read('UserAuth.User.id');
				if(is_array($commissions)){
					foreach($commissions as $key => $val_arr){
						$merchantID 			= $val_arr[0];
						$mid 					= $val_arr[1];
						$amount_process 		= $val_arr[2];
						$transaction_numbers 	= $val_arr[3];
						$chargebacks_numbers 	= $val_arr[4];
						$gross_revenue 			= $val_arr[5];
						$totalapps_income 		= $val_arr[6];
						$lastupdatedate 		= $val_arr[7];
						$commission_month		= date("m",$lastupdatedate);
						// check whether commission is uploaded for this month and this merchant previously or not.
						$condition = "Commissionlog.merchantID = ".$merchantID." AND MONTH(Commissionlog.date) = ".$commission_month;
						$commission_count = $this->Commissionlog->find('count',array('conditions'=>array($condition)));
						// assign value to Commissionlog model
						$commissionlog['Commissionlog']['MID'] 					= $mid;
						$commissionlog['Commissionlog']['merchantID'] 			= $merchantID;
						$commissionlog['Commissionlog']['amount_processed'] 	= $amount_process;
						$commissionlog['Commissionlog']['transaction_numbers'] 	= $transaction_numbers;
						$commissionlog['Commissionlog']['chargebacks_numbers'] 	= $chargebacks_numbers;
						$commissionlog['Commissionlog']['gross_revenue'] 		= $gross_revenue;
						$commissionlog['Commissionlog']['totalapps_income'] 	= $totalapps_income;
						$commissionlog['Commissionlog']['date'] 				= date('Y-m-d',$lastupdatedate);
						// get users commission on the basis of merchant's split precentage
						$merchantinfo = $this->Merchant->find('first',array('fields'=>array('Commission.*'),'conditions'=>array('Merchant.id'=>$merchantID)));
						// calculate user commissions
						$agent_percentage = $merchantinfo['Commission']['agent_split'];
						$agent_commission = ($totalapps_income*$agent_percentage/100);
						$referral_percentage = $merchantinfo['Commission']['referral_split'];
						$referral_commission = ($totalapps_income*$referral_percentage/100);
						$iso_percentage = $merchantinfo['Commission']['iso_split'];
						$iso_commission = ($totalapps_income*$iso_percentage/100);
						// add filed value
						$commissionlog['Commissionlog']['agent_commission'] 	= $agent_commission;
						$commissionlog['Commissionlog']['referral_commission'] 	= $referral_commission;
						$commissionlog['Commissionlog']['iso_commission'] 		= $iso_commission;
						//insert data into commission log table if not exist for this month else replace
						if($commission_count>0){
							$this->Commissionlog->deleteAll(array($condition), false);
						}
						$this->Commissionlog->create();
						$this->Commissionlog->save($commissionlog);
						
						// update commission for MID's												
						$data = array('Commission.MID' => $mid,'Commission.amount_processed' => $amount_process,'Commission.gross_revenue' => $gross_revenue,'Commission.totalapps_commission' => $totalapps_income,'Commission.agent_commission' => $agent_commission,'Commission.referral_commission' => $referral_commission,'Commission.admin_commission' => $iso_commission,'Commission.lastUpdatedBy' => $lastupdateby,'Commission.lastUpdatedDate' => "'".date("Y-m-d h:i:s",$lastupdatedate)."'");
						$mid_count = $this->Commission->find('first',array('conditions'=>array('Commission.merchantID'=>$merchantID)));	
						
	   					if(($mid_count !== false) && (strtotime($mid_count['Commission']['lastUpdatedDate']) <= $lastupdatedate)){
	   						//$this->Commission->updateAll($data,array('Commission.merchantID' => $merchantID));
	   					}elseif($mid_count === false){
	   						/* $this->Commission->create();
	   						$commission['Commission']['amount_processed'] = $amount_process;
							
							$commissionlog['Commissionlog']['transaction_numbers'] = $transaction_numbers;
						    $commissionlog['Commissionlog']['chargebacks_numbers'] = $chargebacks_numbers; 
	   						$commission['Commission']['gross_revenue'] = $gross_revenue;
	   						$commission['Commission']['totalapps_commission'] = $totalapps_income;
	   						$commission['Commission']['agent_commission'] = $agent_commission;
	   						$commission['Commission']['referral_commission'] = $referral_commission;
	   						$commission['Commission']['admin_commission'] = $iso_commission;
	   						$commission['Commission']['MID'] = $mid;
	   						$commission['Commission']['merchantID'] = $merchantID;
	   						$commission['Commission']['lastUpdatedBy'] = $lastupdateby;
	   						$commission['Commission']['lastUpdatedDate'] = date("Y-m-d h:i:s",$lastupdatedate);
	   						$this->Commission->save($commission);*/
	   					}
					}
				}
				
				$this->Session->write('popup','Commission uploaded successfully');
				$this->Session->setFlash('Commission uploaded successfully');
				$this->redirect(array('controller'=>'commissions','action' => "upload/message:success"));
				exit;
			}
		}
		
		public function superadmin_export(){
			if($this->request->is('post')){
				//pr($this->request->data);die;
				$checkMid = $this->request->data['Commission']['checkMid'];
				$mid_values = unserialize($this->request->data['Commission']['export_mids_array']);
				
				/* echo count($mid_values);
				pr($checkMid);
				pr($mid_values);die; */
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
				//create a file
				$filename = "MIDs_not_matching_export_".time().".csv";
				$csv_file = fopen('php://output', 'w');
					
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
					
				// The column headings of your .csv file
				$header_row = array("MID#","Amount processed","Number of Transactions","Number of Chargebacks","Gross revenue","Totalapps income","Date(yyyy/mm/dd)");
				fputcsv($csv_file,$header_row,',','"');
					
				// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
				foreach($checkMid as $result)
				{
					// Array indexes correspond to the field names in your db table(s)
					$row = array(
							$result,
							$mid_values[$result][0],
							$mid_values[$result][1],
							$mid_values[$result][2],
							$mid_values[$result][3],
							$mid_values[$result][4],
							date("Y-m-d",$mid_values[$result][5]),				
					);
					fputcsv($csv_file,$row,',','"');
				}
				fclose($csv_file);die;
			}
		}
		
		// Agent/ISO/Referral split % data upload for Merchatns
		public function superadmin_splitdataupload()
		{
			$this->set('title_for_layout',' Upload Split Data');
			$errorsArr = "";
			if ($this->request->is('post')) {
				if($this->request->data['SUBMIT']=='SUBMIT')
				{
					$this->Commission->set($this->request->data);
					if(!$this->Commission->validates())
					{
						$errorsArr = $this->Commission->validationErrors;
					}
					if($errorsArr)
					{
						$this->set('errors',$errorsArr);
						$this->set('data',$this->request->data);
					}else{
						$prefix = time();
						$filename = $prefix."_".$this->request->data['Commission']['message']['name'];
						$docDestination = APP.'webroot/uploaded/'.$filename;
						@move_uploaded_file($this->request->data['Commission']['message']['tmp_name'], $docDestination) or die($docDestination);
						@chmod($docDestination, "0777");
		
						if($this->request->data['Commission']['message']['type']=='application/vnd.ms-excel') {
							$data = new Spreadsheet_Excel_Reader("uploaded/".$filename, true);
							$temp = $data->dumptoarray();
								
							/*$this->set('xlsrecord',$temp);	 */
						}else if($this->request->data['Commission']['message']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
							$data = new Spreadsheet_Excel_Reader("uploaded/".$filename, true);
							$temp = $data->dumptoarray();
							/* $this->set('xlsrecord',$temp); */
						}
						// make two array of MID's Matching OR Not Matching
						/*echo '<pre>';
						print_r($temp);die;*/
						
						if(is_array($temp)){
							foreach($temp as $key => $xlsValue){
								if($xlsValue[1]!="MID #" && $xlsValue[1]!="MID" && $xlsValue[1]!="MID#" && $xlsValue[1]!="mid"){
									$merchant = $this->Common->getMerchantNameByMID($xlsValue[1]);
									//MID's Matching
									if($merchant['Merchant']['merchantName']!=''){
										$merchants[$key]['merchantName'] = $merchant['Merchant']['merchantName'];
										$merchants[$key]['id'] = $merchant['Merchant']['id'];
										$merchants[$key][] =	$xlsValue[1];
										$merchants[$key][] =	$xlsValue[2];
										$merchants[$key][] =	$xlsValue[3];
										$merchants[$key][] =	$xlsValue[4];
										$merchants[$key][] =	$xlsValue[5];
										$merchants[$key][] =	$xlsValue[6];
									}else{
										//MID's Not Matching
										$mids[$key][] =	$xlsValue[1];
										$mids[$key][] =	$xlsValue[2];
										$mids[$key][] =	$xlsValue[3];
										$mids[$key][] =	$xlsValue[4];
										$mids[$key][] =	$xlsValue[5];
										$mids[$key][] =	$xlsValue[6];
									}
								}
							}
							$this->set('merchants',$merchants);
							$this->set('mids',$mids);
							@unlink($docDestination);
						}// end of if conditions
					}
				}
			}
		}
		
		/*================ Split data approve =========================== */
		public function superadmin_splitdata_approve(){
			//pr($this->request->data['Commission']);die;
			$this->loadModel('Commission');
			$this->loadModel('Merchant');
				
			if ($this->request->is('post')) {
				//pr($this->request->data);
				$commissions = unserialize($this->request->data['Commission']['final_array']);
				$lastupdateby = $this->Session->read('UserAuth.User.id');
				if(is_array($commissions)){
					foreach($commissions as $key => $val_arr){
						$merchantID 			= $val_arr[0];
						$mid 					= $val_arr[1];
						$agent_split	 		= $val_arr[2];
						$iso_split 				= $val_arr[3];
						$referral_split 		= $val_arr[4];
						$totalapps_split 		= $val_arr[5];
						$lastupdatedate 		= time();
						$commission_month		= date("m",$lastupdatedate);
						// check whether split is uploaded for this month and this merchant previously or not.
						//$condition = "Commission.merchantID = ".$merchantID." AND MONTH(Commission.lastUpdatedDate) = ".$commission_month;
						$condition = "Commission.MID = ".$mid;
						$commission_count = $this->Commission->find('count',array('conditions'=>array($condition)));
						// assign value to Commissionlog model
						$commission['Commission']['MID'] 				= $mid;
						$commission['Commission']['merchantID'] 		= $merchantID;
						$commission['Commission']['agent_split'] 		= $agent_split;
						$commission['Commission']['iso_split'] 			= $iso_split;
						$commission['Commission']['referral_split'] 	= $referral_split;
						$commission['Commission']['totalapps_split'] 	= $totalapps_split;
						$commission['Commission']['lastUpdatedDate'] 	= date('Y-m-d',$lastupdatedate);						
						$commission['Commission']['lastUpdatedBy'] 		= $lastupdateby;
						
						//insert data into commission table if not exist for this month else replace
						if($commission_count>0){
							$this->Commission->deleteAll(array($condition), false);
						}
					
						
						$this->Commission->create();
						$this->Commission->save($commission);
					}
				}
		
				$this->Session->write('popup','Split % data uploaded successfully');
				$this->Session->setFlash('Split % data uploaded successfully');
				$this->redirect(array('controller'=>'commissions','action' => "splitdataupload/message:success"));
				exit;
			}
		}
		/**================== Export not matching mid's split % data =============== */
		public function superadmin_splitdataexport(){
			if($this->request->is('post')){
				//pr($this->request->data);die;
				$checkMid = $this->request->data['Commission']['checkMid'];
				$mid_values = unserialize($this->request->data['Commission']['export_mids_array']);
		
				/* echo count($mid_values);
				 pr($checkMid);
				pr($mid_values);die; */
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
				//create a file
				$filename = "MIDs_not_matching_export_".time().".csv";
				$csv_file = fopen('php://output', 'w');
					
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
					
				// The column headings of your .csv file
				$header_row = array("MID#","Agent % Split","ISO % Split","Referral % Split","Totalapps % Split","Date(yyyy/mm/dd)");
				fputcsv($csv_file,$header_row,',','"');
					
				// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
				foreach($checkMid as $result)
				{
					// Array indexes correspond to the field names in your db table(s)
					$row = array(
							$result,
							$mid_values[$result][0],
							$mid_values[$result][1],
							$mid_values[$result][2],
							$mid_values[$result][3],
							date("Y-m-d",$mid_values[$result][4]),
					);
					fputcsv($csv_file,$row,',','"');
				}
				fclose($csv_file);die;
			}
		}
		
		// Agent/ISO/Referral data upload for Merchatns
		public function superadmin_agent_iso_referral_upload()
		{
			$this->set('title_for_layout',' Upload Agent/ISO/Referral Data');
			$errorsArr = "";
			if ($this->request->is('post')) {
				if($this->request->data['SUBMIT']=='SUBMIT')
				{
					$this->Commission->set($this->request->data);
					if(!$this->Commission->validates())
					{
						$errorsArr = $this->Commission->validationErrors;
					}
					if($errorsArr)
					{
						$this->set('errors',$errorsArr);
						$this->set('data',$this->request->data);
					}else{
						$prefix = time();
						$filename = $prefix."_".$this->request->data['Commission']['message']['name'];
						$docDestination = APP.'webroot/uploaded/'.$filename;
						@move_uploaded_file($this->request->data['Commission']['message']['tmp_name'], $docDestination) or die($docDestination);
						@chmod($docDestination, "0777");
		
						if($this->request->data['Commission']['message']['type']=='application/vnd.ms-excel') {
							$data = new Spreadsheet_Excel_Reader("uploaded/".$filename, true);
							$temp = $data->dumptoarray();
		
							/*$this->set('xlsrecord',$temp);	 */
						}else if($this->request->data['Commission']['message']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
							$data = new Spreadsheet_Excel_Reader("uploaded/".$filename, true);
							$temp = $data->dumptoarray();
							/* $this->set('xlsrecord',$temp); */
						}
						// make two array of MID's Matching OR Not Matching
						//pr($temp);die;
						if(is_array($temp)){
							foreach($temp as $key => $xlsValue){
								if($xlsValue[1]!="MID #" && $xlsValue[1]!="MID" && $xlsValue[1]!="MID#" && $xlsValue[1]!="mid"){
									$merchant = $this->Common->getMerchantNameByMID($xlsValue[1]);
									//MID's Matching
									if($merchant['Merchant']['merchantName']!=''){
										$merchants[$key]['merchantName'] = $merchant['Merchant']['merchantName'];
										$merchants[$key]['id'] = $merchant['Merchant']['id'];
										$merchants[$key][] =	$xlsValue[1];
										$merchants[$key][] =	$xlsValue[2];
										$merchants[$key][] =	$xlsValue[3];
										$merchants[$key][] =	$xlsValue[4];
									}else{
										//MID's Not Matching
										$mids[$key][] =	$xlsValue[1];
										$mids[$key][] =	$xlsValue[2];
										$mids[$key][] =	$xlsValue[3];
										$mids[$key][] =	$xlsValue[4];
									}
								}
							}
							$this->set('merchants',$merchants);
							$this->set('mids',$mids);
							@unlink($docDestination);
						}// end of if conditions
					}
				}
			}
		}
		
		/*================ User Data(Agent/ISO/Referral) approve =========================== */
		public function superadmin_userdata_approve(){
			//pr($this->request->data['Commission']);die;
			$this->loadModel('Commission');
			$this->loadModel('Merchant');
		
			if ($this->request->is('post')) {
				//pr($this->request->data);
				$commissions = unserialize($this->request->data['Commission']['final_array']);
				$lastupdateby = $this->Session->read('UserAuth.User.id');
				if(is_array($commissions)){
					foreach($commissions as $key => $val_arr){
						$merchantID 			= $val_arr[0];
						$mid 					= $val_arr[1];
						$agent_id		 		= $this->Common->getUserIdByName($val_arr[2]);
						$iso_id 				= $this->Common->getUserIdByName($val_arr[3]);
						$referral_id 			= $this->Common->getUserIdByName($val_arr[4]);
						
						// assign value to merchant model
						$merchant['Merchant']['id'] 			= $merchantID;
						if(!empty($agent_id)){
							$merchant['Merchant']['agentID'] 		= $agent_id;
						}else{
							$agent_id = NULL;
						}
						
						if(!empty($iso_id)){
							$merchant['Merchant']['isoID'] 			= $iso_id;
						}else{
							$iso_id = NULL;
						}
						
						if(!empty($referral_id)){
							$merchant['Merchant']['referalID'] 		= $referral_id;
						}else{
							$referral_id = NULL;
						}
						//update data into merchant table						
						$this->Merchant->save($merchant);
						if(is_null($agent_id) || is_null($iso_id) || is_null($referral_id)){
							$missing_user_data[$key][] = $mid;
							$missing_user_data[$key][] = is_null($agent_id)? "NOT MATCHING" : $val_arr[2];
							$missing_user_data[$key][] = is_null($iso_id)? "NOT MATCHING" : $val_arr[3];
							$missing_user_data[$key][] = is_null($referral_id)? "NOT MATCHING" : $val_arr[4];
						}
					}
				}
		
				if(count($missing_user_data)>0){
					$this->set('missing_user_data',$missing_user_data);
				}else{
					$this->Session->write('popup','Agent/ISO/Referral assigned successfully');
					$this->Session->setFlash('Agent/ISO/Referral assigned successfully');
					$this->redirect(array('controller'=>'commissions','action' => "agent_iso_referral_upload/message:success"));
					exit;
				}
			}
		}
		/**================== Export not matching mid's User Data(Agent/ISO/Referral) =============== */
		public function superadmin_userdataexport(){
			if($this->request->is('post')){
				//pr($this->request->data);die;
				$checkMid = $this->request->data['Commission']['checkMid'];
				$mid_values = unserialize($this->request->data['Commission']['export_mids_array']);
		
				/* echo count($mid_values);
				 pr($checkMid);
				pr($mid_values);die; */
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
				//create a file
				$filename = "MIDs_not_matching_export_".time().".csv";
				$csv_file = fopen('php://output', 'w');
					
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
					
				// The column headings of your .csv file
				$header_row = array("MID#","Agent Name","ISO Name","Referral Name");
				fputcsv($csv_file,$header_row,',','"');
					
				// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
				foreach($checkMid as $result)
				{
					// Array indexes correspond to the field names in your db table(s)
					$row = array(
							$result,
							$mid_values[$result][0],
							$mid_values[$result][1],
							$mid_values[$result][2]
					);
					fputcsv($csv_file,$row,',','"');
				}
				fclose($csv_file);die;
			}
		}
		
		// ticket id 1988 (crate for exporting unmatched users (agent,iso,referral))
		public function superadmin_missinguserdataexport()
		{
			if($this->request->is('post')){
				//pr($this->request->data);die;
				$checkMid = $this->request->data['Commission']['checkMid'];
				$mid_values = unserialize($this->request->data['Commission']['export_users_array']);
		
				/* echo count($mid_values);
				 pr($checkMid);
				pr($mid_values);die; */
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
				//create a file
				$filename = "Users_not_matching_export_".time().".csv";
				$csv_file = fopen('php://output', 'w');
					
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
					
				// The column headings of your .csv file
				$header_row = array("MID#","Agent Name","ISO Name","Referral Name");
				fputcsv($csv_file,$header_row,',','"');
					
				// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
				foreach($checkMid as $result)
				{
					// Array indexes correspond to the field names in your db table(s)
					$row = array(
							$result,
							$mid_values[$result][0],
							$mid_values[$result][1],
							$mid_values[$result][2]
					);
					fputcsv($csv_file,$row,',','"');
				}
				fclose($csv_file);die;
			}
		}
		
	 	public function beforeFilter()
		{
			parent::beforeFilter();
	   	}

		

}

?>