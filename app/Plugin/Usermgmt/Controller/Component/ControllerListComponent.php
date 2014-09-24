<?php

/*
	This file is part of UserMgmt.

	Author: Chetan Varshney (http://ektasoftwares.com)

	UserMgmt is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	UserMgmt is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/


class ControllerListComponent extends Component {
	/**
	 * Used to get all controllers with all methods for permissions
	 *
	 * @access public
	 * @return array
	 */
	public function get() {
		$controllerClasses = App::objects('Controller');
		$superParentActions = get_class_methods('Controller');
		$parentActions = get_class_methods('AppController');
		$parentActionsDefined=$this->_removePrivateActions($parentActions);
		$parentActionsDefined = array_diff($parentActionsDefined, $superParentActions);
		$controllers= array();
		foreach ($controllerClasses as $controller) {
			$controllername=str_replace('Controller', '',$controller);
			$actions= $this->__getControllerMethods($controllername, $superParentActions, $parentActions);
			if (!empty($actions)) {
				$controllers[$controllername] = $actions;
			}
		}
		$plugins = App::objects('plugins');
		foreach ($plugins as $p) {
			$pluginControllerClasses = App::objects($p.'.Controller');
			foreach ($pluginControllerClasses as $controller) {
				$controllername=str_replace('Controller', '',$controller);
				$actions= $this->__getControllerMethods($controllername, $superParentActions, $parentActions, $p);
				if (!empty($actions)) {
					$controllers[$controllername] = $actions;
				}
			}
		}
		
		
		
		  $rmArray= array('Admins'=>array("superadmin_deployment",'superadmin_deployment','superadmin_printerdelete','superadmin_checkreaderdelete','superadmin_rates','superadmin_terminalsoftwaredelete','superadmin_transaction','superadmin_announcement'),
		  				'Agentnotes'=>array("superadmin_notes",'superadmin_delete'),
						'Apis'=>array("superadmin_merchantapi",'superadmin_api','superadmin_merchantapisuccess','superadmin_merchantbasicinfo','viewPdf','superadmin_merchantpdf','superadmin_merchantpdf','superadmin_apiownerinfo ','superadmin_apiprofileinfo','superadmin_apiownerinfo','superadmin_ownerdelete'),
						'App'=>array("isAuthorized",'generalinformation','downloadFile'),
						//'Appointments'=>array("superadmin_addappointment",'superadmin_deleteAppoinment'),
						'Merchants'=>array("index",'superadmin_terminalsoftwaredelete','superadmin_printerdelete','superadmin_checkreaderdelete','superadmin_ownerdelete','superadmin_view','superadmin_docsdelete'),
						
						'UserGroupPermissions'=>array("superadmin_update"),
						'Users'=>array("superadmin_userajax",'superadmin_login','superadmin_dashboard','superadmin_accessDenied'),
						'Deployments'=>array("superadmin_terminalsoftwaredelete","superadmin_printerdelete","superadmin_checkreaderdelete"),
						'Rates'=>array("superadmin_transaction"),
						'StackedDemo'=>array("bar","column","percent_column","grouped_column"),
						'SingleSeriesDemo'=>array("area","areaspline","bar","column","line","pie","scatter","spline"),
						'MultiSeriesDemo'=>array("area","areaspline","bar","column","line","pie","scatter","spline"),
						'MixedChartsDemo'=>array("mixed_charts","spline_live","column_drilldown"),
						'MinimalistDemo'=>array("column","column_rotated","pie","spline_cross","line"),
						'HighChartsDemo'=>array("index"),
						'CombinationDemo'=>array("combo"),
						'Emails'=>array("superadmin_blastEmail","superadmin_listTemplate")
						
						
						
						
						
						//'Merchanttransactions'=>array("superadmin_transaction","superadmin_transactionlist","superadmin_deletetransaction")
		  
                  			); 
	

           

	
	foreach($controllers as $key=>$value)
	{
		foreach($value as $key1=>$value1)
		{
			foreach($rmArray as $key2=>$value2)
			{
				if($key==$key2)
				{
					 if(in_array($controllers[$key][$key1], $value2))
					 {
					 	unset($controllers[$key][$key1]);
					 }
					
				}
				
			}
			// if(in_array($key, $data1))
				// unset($value[$key1]);
		}	
	}
	
	
	//pr($controllers);
		return $controllers;
	}
	/**
	 * Used to delete private actions from list of controller's methods
	 *
	 * @access private
	 * @param array $actions Controller's action
	 * @return array
	 */
	private function _removePrivateActions($actions) {
		foreach ($actions as $k => $v) {
			if ($v{0} == '_') {
				unset($actions[$k]);
			}
		}
		return $actions;
	}
	/**
	 * Used to get methods of controller
	 *
	 * @access private
	 * @param string $controllername Controller name
	 * @param array $superParentActions Controller class methods
	 * @param array $parentActions App Controller class methods
	 * @param string $p plugin name
	 * @return array
	 */
	private function __getControllerMethods($controllername, $superParentActions, $parentActions, $p=null) {
	
		if (empty($p)) {
			App::import('Controller', $controllername);
		} else {
			App::import('Controller', $p.'.'.$controllername);
		}
		$actions = get_class_methods($controllername."Controller");
		if (!empty($actions)) {
			$actions=$this->_removePrivateActions($actions);
			$actions= ($controllername=='App') ? array_diff($actions, $superParentActions) : array_diff($actions, $parentActions);
		}
		
	/*	$data1 = array("superadmin_deployment","superadmin_deployment", "superadmin_deployment", "superadmin_checkreaderdelete","superadmin_rates","superadmin_rates","superadmin_announcement");
		echo $controllername;
		foreach($actions as $key=>$value)
		 {
		 
			 if(in_array($value, $data1))
				 unset($actions[$key]);
	 	 }
     */
		
		//pr($actions);
		return $actions;
	}
	/**
	 *  Used to get controller's list
	 *
	 * @access public
	 * @return array
	 */
	public function getControllers() {
		$controllerClasses = App::objects('Controller');
		foreach ($controllerClasses as $key=>$value) {
			$controllerClasses[$key]=str_replace('Controller', '',$value);
		}
		$controllerClasses[-2]="Select Controller";
		$controllerClasses[-1]="All";
		$plugins = App::objects('plugins');
		foreach ($plugins as $p) {
			$pluginControllerClasses = App::objects($p.'.Controller');
			foreach ($pluginControllerClasses as $controller) {
				$controllerClasses[]=str_replace('Controller', '',$controller);
			}
		}
		
		ksort($controllerClasses);
		return $controllerClasses;
	}
}