<?php
App::uses('UserMgmtAppController', 'Usermgmt.Controller');

class UsersController extends UserMgmtAppController {

    var $components = array('Session', 'Common', 'HighCharts.HighCharts', 'Recaptcha.Recaptcha');
    var $helpers = array('Html', 'Text', 'Paginator', 'CakeGrid.Grid'); //add some other helpers to controller
    var $layout = 'admin';
    public $uses = array('Usermgmt.User', 'Usermgmt.UserGroup', 'News', 'Usermgmt.UserGroupJoin', 'UserGroupPermission', 'Merchantpipeline', 'Merchant', 'Merchantnote', 'Usercontact', 'Usercontact1', 'Usercontact2', 'Userbackofficelogin', 'Businesscat','Reportlist','ReportPermission');
    public $HighCharts = null;

    public function superadmin_addUser() { // create new user

        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
        $userGroups = $this->UserGroup->find('list');
        $errorsLevel = '';

        $this->set('errorsLevel', $errorsLevel);
        $this->set('userGroups', $userGroups);

        if ($this->request->isPost()) {
		
		
			if($this->request->data['User']['vendor']=='vendor'){
				unset($this->request->data['User']['username']);
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['old_password']);
			}
			
			
            $this->User->set($this->request->data);
            $j = 0;
            foreach ($this->request->data['UserGroupJoin'] as $key => $value) {
                if ($this->request->data['UserGroupJoin'][$key]['user_group_id']) {
                    $userGroupData[$key] = $this->request->data['UserGroupJoin'][$key];
                    $j = $j + 1;
                }
            }

            if (!$j) {
                $errorsLevel = 'Please Select at Least One User Level';
            }



            if ($this->User->RegisterValidate() && $errorsLevel == '') {
                unset($this->request->data['UserGroupJoin']);
                $this->request->data['UserGroupJoin'] = $userGroupData;

                $this->request->data['User']['userPWD'] = $this->request->data['User']['password'];
                $this->request->data['User']['active'] = 1;
                $this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
                $this->set('errorsLevel', $errorsLevel);
                if ($this->User->saveAssociated($this->request->data, true)) {
                    $this->Session->write('popup', 'The user is successfully added.');
                } else {
                    $this->Session->write('popup', 'The user is successfully added.');
                }
                $this->redirect(array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'index/message:success'));
            } else {
                $this->set('errorsLevel', $errorsLevel);
            }
        }
    }

    public function superadmin_doclist() {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
        $groupRec = $this->User->query('select id,name from user_groups where id in(select user_group_id from user_group_joins)');
        $this->set('groupRec', $groupRec);


        //// -===== set document field to complete ====================
        $documentList = $this->User->find('all', array('fields' => 'User.id', 'conditions' => ' ( User.agent_doc IS NOT NULL || User.referral_doc IS NOT NULL )  AND User.photo_doc IS NOT NULL AND User.video_doc IS NOT NULL and User.doc_status="0"', 'recursive' => -1));
        foreach ($documentList as $value) {
            $data['User']['id'] = $value['User']['id'];
            $data['User']['doc_status'] = 1;
            $this->User->save($data);
        }


        $documentList1 = $this->User->find('all', array('fields' => 'User.id', 'conditions' => ' ( User.agent_doc IS NULL || User.referral_doc IS NULL )  || User.photo_doc IS NULL || User.video_doc IS NULL and User.doc_status="1"', 'recursive' => -1));

        foreach ($documentList1 as $value) {
            $data['User']['id'] = $value['User']['id'];
            $data['User']['doc_status'] = 0;
            $this->User->save($data);
        }
        //// -================ End  ====================



        if ($this->params->query) {
            $condition = '';
            if (isset($this->params->query['active']) && strlen($this->params->query['active']) > 0) {
                if ($condition) {
                    $condition .=' and ';
                }
                $condition .="User.active='" . $this->params->query['active'] . "'";
                $this->set('active', $this->params->query['active']);
            } else {
                $this->set('active', '');
            }



            if (!empty($this->request->query['Role']) && strlen($this->params->query['Role']) > 0) {
                $test = '';
                $numberofrec = '';
                $i = 1;

                $totalREC = $this->User->query('select user_id from user_group_joins where user_group_id="' . $this->request->query['Role'] . '"');
                $numberofrec = count($totalREC);


                foreach ($totalREC as $key => $value) {
                    foreach ($value['user_group_joins'] as $key => $value) {
                        $test .=$value;
                    }

                    if ($i != $numberofrec) {
                        $test.=',';
                    }

                    $i = $i + 1;
                }


                if ($condition) {
                    $condition .=' and ';
                }

                if ($test != ',') {
                    $condition .=' User.id in' . '(' . $test . ')';
                }


                $this->set('rolename', $this->request->query['Role']);
            } else {
                $this->set('rolename', '');
            }

            if (isset($this->params->query['doc_status']) && strlen($this->params->query['doc_status']) > 0) {
                if ($condition) {
                    $condition .=' and ';
                }
                if ($this->params->query['doc_status'] == 1) {
                    $condition .=" User.doc_status='1' ";
                } else {
                    $condition .=" ( User.doc_status='0' || User.doc_status = '' || User.doc_status IS NULL )";
                }
                $this->set('doc_status', $this->params->query['doc_status']);
            } else {
                $this->set('doc_status', '');
            }
        } else {
            $this->set('rolename', '');
            $this->set('active', '');
            $this->set('doc_status', '');
        }


        $this->set('TOTALUSER', $this->User->find('count', array('conditions' => array($condition))));

        $order = 'User.id DESC';
        $this->paginate = array(
            'fields' => 'user_Name,agent_doc,referral_doc,photo_doc,video_doc,doc_status',
            'limit' => 50,
            'conditions' => $condition,
            'order' => array(
                'User.id' => 'DESC'
            ),
            'paramType' => 'querystring'
        );
        $UserRec = $this->paginate('User');
        $this->set('UserRec', $UserRec);
    }

    public function superadmin_search() {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page

        $groupRec = $this->User->query('select id,name from user_groups where id in(select user_group_id from user_group_joins)');
        $this->set('groupRec', $groupRec);
        //	$this->User->unbindModel( array('hasMany' => array('LoginToken')));
        ////$countRec=$this->Common->countRec('User');

        $condition = '';


        if ($this->request->query) {
            if (isset($this->request->query['user_Name'])) {
                $condition .="User.user_Name like '%" . trim($this->request->query['user_Name']) . "%' ";
                $this->set('user_Name', $this->request->query['user_Name']);
            } else {
                $this->set('user_Name', '');
            }


            if (isset($this->request->query['userEmail'])) {
                if ($condition) {
                    $condition .=' and ';
                }
                $condition .="User.userEmail like '%" . trim($this->request->query['userEmail']) . "%' ";
                $this->set('userEmail', $this->request->query['userEmail']);
            } else {
                $this->set('userEmail', '');
            }

            if (isset($this->params->query['active'])) {
                if ($condition) {
                    $condition .=' and ';
                }
                $condition .="User.active='" . $this->params->query['active'] . "'";
                $this->set('active', $this->params->query['active']);
            } else {
                $this->set('active', '');
            }




            if (isset($this->request->query['userPhone'])) {
                if ($condition) {
                    $condition .=' and ';
                }
                $condition .="User.userPhone like '%" . trim($this->request->query['userPhone']) . "%' ";
                $this->set('userPhone', $this->request->query['userPhone']);
            } else {
                $this->set('userPhone', '');
            }


            if (isset($this->request->query['userCompany'])) {
                if ($condition) {
                    $condition .=' and ';
                }
                $condition .=" User.userCompany like '%" . trim($this->request->query['userCompany']) . "%'";
                $this->set('userCompany', $this->request->query['userCompany']);
            } else {
                $this->set('userCompany', '');
            }

            if (isset($this->request->query['userCompanyUrl'])) {
                if ($condition) {
                    $condition .=' and ';
                }

                $condition .=" User.userCompanyUrl like '%" . trim($this->request->query['userCompanyUrl']) . "%'";

                $this->set('userCompanyUrl', $this->request->query['userCompanyUrl']);
            } else {
                $this->set('userCompanyUrl', '');
            }


            if (isset($this->request->query['userAddress'])) {
                if ($condition) {
                    $condition .=' and ';
                }

                $condition .=" User.userAddress like '%" . trim($this->request->query['userAddress']) . "%'";
                $this->set('userAddress', $this->request->query['userAddress']);
            } else {

                $this->set('userAddress', '');
            }


            if (!empty($this->request->query['Role'])) {
                $test = '';
                $numberofrec = '';
                $i = 1;

                $totalREC = $this->User->query('select user_id from user_group_joins where user_group_id="' . $this->request->query['Role'] . '"');
                $numberofrec = count($totalREC);


                foreach ($totalREC as $key => $value) {
                    foreach ($value['user_group_joins'] as $key => $value) {
                        $test .=$value;
                    }

                    if ($i != $numberofrec) {
                        $test.=',';
                    }

                    $i = $i + 1;
                }


                if ($condition) {
                    $condition .=' and ';
                }

                if ($test != ',') {
                    $condition .=' User.id in' . '(' . $test . ')';
                }


                $this->set('rolename', $this->request->query['Role']);
            } else {
                $this->set('rolename', '');
            }
        } else {
            $this->set('rolename', '');
            $this->set('userAddress', '');
            $this->set('userCompanyUrl', '');
            $this->set('userCompany', '');
            $this->set('userPhone', '');
            $this->set('userEmail', '');
            $this->set('active', '');
            $this->set('user_Name', '');
        }
        $TOTALUSER = $this->User->find('count', array('conditions' => array($condition)));


        if (strlen($condition) > 1) {
            $this->paginate = array(
                'fields' => 'user_Name,userPhone,userEmail,notActive,id,userCompany',
                'conditions' => array($condition),
                'limit' => 50,
                'order' => array(
                    'User.id' => 'desc'
                ),
                'paramType' => 'querystring'
            );
            $UserRec = $this->paginate('User');
			
            $this->set('UserRec', $UserRec);
            $this->set('TOTALUSER', $TOTALUSER);
        }

        if (!empty($this->request->query['Export'])) {


            $UserRec = $this->User->find('all', array('conditions' => array($condition)));

            ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
            //create a file
            $filename = "export_" . date("Y.m.d") . ".csv";
            $csv_file = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            // The column headings of your .csv file

            $header_row = array("id", "Name", "Phone 1", "Phone 2", "Email", "Company", "Website", "Address 1", "Address 2", "City", "State", "Zip", "Country", "Bank User Name", "Bank  Name", "Bank Address 1", "Bank Address 2", "Bank City", "Bank State", "Bank Zip", "Bank Country", "Bank Phone Number", "Bank Account Number", "Bank State", "Bank Zip", "Bank State", "Bank Zip", "Bank Country", "Bank Phone");
            fputcsv($csv_file, $header_row, ',', '"');
            // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column

            foreach ($UserRec as $result) {
                // Array indexes correspond to the field names in your db table(s)
                $row = array(
                    $result['User']['id'],
                    $result['User']['user_Name'],
                    $result['User']['userPhone'],
                    $result['User']['userPhone2'],
                    $result['User']['userEmail'],
                    $result['User']['userCompany'],
                    $result['User']['userCompanyUrl'],
                    $result['User']['userAddress'],
                    $result['User']['userAddress2'],
                    $result['User']['userCity'],
                    $result['User']['userState'],
                    $result['User']['userZip'],
                    $result['User']['userCountry'],
                    $result['User']['bankUserName'],
                    $result['User']['bankName'],
                    $result['User']['bankAddress'],
                    $result['User']['bankAddress2'],
                    $result['User']['bankCity'],
                    $result['User']['bankState'],
                    $result['User']['bankZip'],
                    $result['User']['bankCountry'],
                    $result['User']['bankPhone'],
                    $result['User']['bankAccountNumber'],
                    $result['User']['bankState'],
                    $result['User']['bankZip'],
                    $result['User']['bankCountry'],
                    $result['User']['bankPhone']
                );
                fputcsv($csv_file, $row, ',', '"');
            }
            fclose($csv_file);
            die;
        }
    }

    public function superadmin_index() {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page



        $sortOrder = '';
        $condition = '';
        $sortby = 'id';
        $order = 'DESC';

        if ($this->request->query) {
            $role = '';
            if (!empty($this->request->query['sortby'])) {
                $this->request->data['User']['sortby'] = $this->request->query['sortby'];
                switch ($this->request->query['sortby']) {

                    case 'name':
                        $sortby = 'user_Name';
                        break;
                    case 'email':
                        $sortby = 'userEmail';
                        break;
                }
            }

            if (!empty($this->request->query['role'])) {
                $this->request->data['User']['role'] = $this->request->query['role'];
                $groupjoin = $this->User->query("select user_id from user_group_joins where user_group_id	='" . $this->request->query['role'] . "'");

                $uID = '';
                $uu = '';
                $i = 1;

                foreach ($groupjoin as $grouprec) {
                    $uID.= $grouprec['user_group_joins']['user_id'];
                    if ($i != count($groupjoin)) {
                        $uID.= ',';
                    }
                    $i = $i + 1;
                }

                if ($uID) {
                    $condition = 'User.id in' . '(' . $uID . ')';
                } else {
                    $condition = 'User.id=0';
                }
            }


            if (isset($this->params->query['active'])) {
                if ($condition) {
                    $condition .=' and ';
                }
                $condition .="User.active='" . $this->params->query['active'] . "'";
                $this->set('active', $this->params->query['active']);
            }


            if (!empty($this->request->query['sortOrder'])) {
                $this->request->data['User']['sortOrder'] = $this->request->query['sortOrder'];
                $order = $this->request->query['sortOrder'];
            }
        }

        $TOTALUSER = $this->User->find('count', array('conditions' => array($condition)));
        $this->set('TOTALUSER', $TOTALUSER);
        $this->paginate = array('all',
            'conditions' => array($condition),
            'limit' => 50,
            'order' => array(
                'User.' . $sortby => $order
            ),
            'paramType' => 'querystring'
        );
        $UserRec = $this->paginate('User');
        /* echo "<pre>";
          print_r($UserRec);die; */
        $this->set('UserRec', $UserRec);


        if (!empty($this->request->query['Export'])) {
            $UserRec = $this->User->find('all', array('conditions' => array($condition)));

            ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
            //create a file
            $filename = "export_" . date("Y.m.d") . ".csv";
            $csv_file = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            // The column headings of your .csv file

            $header_row = array("id", "Name", "Phone 1", "Phone 2", "Email", "Company", "Website", "Address 1", "Address 2", "City", "State", "Zip", "Country", "Bank User Name", "Bank  Name", "Bank Address 1", "Bank Address 2", "Bank City", "Bank State", "Bank Zip", "Bank Country", "Bank Phone Number", "Bank Account Number", "Bank State", "Bank Zip", "Bank State", "Bank Zip", "Bank Country", "Bank Phone");
            fputcsv($csv_file, $header_row, ',', '"');
            // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column

            foreach ($UserRec as $result) {
                // Array indexes correspond to the field names in your db table(s)
                $row = array(
                    $result['User']['id'],
                    $result['User']['user_Name'],
                    $result['User']['userPhone'],
                    $result['User']['userPhone2'],
                    $result['User']['userEmail'],
                    $result['User']['userCompany'],
                    $result['User']['userCompanyUrl'],
                    $result['User']['userAddress'],
                    $result['User']['userAddress2'],
                    $result['User']['userCity'],
                    $result['User']['userState'],
                    $result['User']['userZip'],
                    $result['User']['userCountry'],
                    $result['User']['bankUserName'],
                    $result['User']['bankName'],
                    $result['User']['bankAddress'],
                    $result['User']['bankAddress2'],
                    $result['User']['bankCity'],
                    $result['User']['bankState'],
                    $result['User']['bankZip'],
                    $result['User']['bankCountry'],
                    $result['User']['bankPhone'],
                    $result['User']['bankAccountNumber'],
                    $result['User']['bankState'],
                    $result['User']['bankZip'],
                    $result['User']['bankCountry'],
                    $result['User']['bankPhone']
                );
                fputcsv($csv_file, $row, ',', '"');
            }
            fclose($csv_file);
            die;
        }
        //===============
        /* $this->User->unbindModel( array('hasMany' => array('LoginToken')));
          $users=$this->User->find('all', array('order'=>'User.id desc'));
          $this->set('users', $users); */
    }

    public function superadmin_userajax() {
        $this->User->unbindModel(array('hasMany' => array('LoginToken')));
        $users = $this->User->find('all', array('order' => 'User.id desc'));
        $this->set('users', $users);
    }

    public function superadmin_viewUser($userId = null) {
        $this->set('id', $userId);
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);
        $user = $this->User->read(null, $userId);

        if (!empty($userId)) {

            $user = $this->User->read(null, $userId);
            $this->set('user', $user);
            $this->request->data = null;
            if (!empty($user)) {
                $user['User']['password'] = '';
                $this->request->data = $user;
            }
        }
    }

    public function superadmin_editUser($userId = null) {

        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page
        //// -===== set document field to complete ====================
        /* $documentList=$this->User->find('all',array('fields'=>'User.id','conditions'=>' ( User.agent_doc IS NOT NULL || User.referral_doc IS NOT NULL )  AND User.photo_doc IS NOT NULL AND User.video_doc IS NOT NULL and User.doc_status="0"','recursive'=>-1));
          foreach($documentList as $value)
          {
          $data['User']['id']=$value['User']['id'];
          $data['User']['doc_status']=1;
          $this->User->save($data);
          }

          $documentList=$this->User->find('all',array('fields'=>'User.id','conditions'=>' ( User.agent_doc IS NOT NULL || User.referral_doc IS NOT NULL )  AND User.photo_doc IS NOT NULL AND User.video_doc IS NOT NULL and User.doc_status="1"','recursive'=>-1));
          foreach($documentList as $value)
          {
          $data['User']['id']=$value['User']['id'];
          $data['User']['doc_status']=0;
          $this->User->save($data);
          } */


        //// -================ End  ====================


        $errorsLevel = '';
        $this->set('agentfileerror', '');
        $this->set('videofileerror', '');
        $this->set('referalfileerror', '');
        $this->set('photofileerror', '');
        $this->set('id', $userId);


        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);

        $user = $this->User->read(null, $userId);

        if ($this->request->query) {  // if query string

            if (!empty($this->request->query['Agentfilename'])) {  // uypload agent file
                $this->request->data['User']['agent_doc'] = '';
                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    unlink(WWW_ROOT . "/files/userdocument/" . $this->request->query['Agentfilename']);
                    //check whether any document is deleted or added and then set status "complete" or "incomplete"
                    $doc_cond = "((User.agent_doc = '' AND User.referral_doc = '') OR User.photo_doc ='' OR User.video_doc ='') AND User.id=" . $userId;
                    $doc_completed = $this->User->find('count', array('fields' => 'User.id', 'conditions' => array($doc_cond), 'recursive' => -1));
                    if ($doc_completed == 1) {
                        $userdata = array('User' => array('id' => $userId, 'doc_status' => '0'));
                        $this->User->save($userdata, false, array('doc_status'));
                    } else {
                        $userdata = array('User' => array('id' => $userId, 'doc_status' => '1'));
                        $this->User->save($userdata, false, array('doc_status'));
                    }


                    $this->Session->write('popup', 'Agent document has been deleted successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                }
            }


            if (!empty($this->request->query['referalFile'])) {  // upload referal file
                $this->request->data['User']['referral_doc'] = '';
                $this->User->set($this->request->data);

                if ($this->User->save($this->request->data)) {
                    unlink(WWW_ROOT . "/files/userdocument/" . $this->request->query['referalFile']);
                    //check whether any document is deleted or added and then set status "complete" or "incomplete"
                    $doc_cond = "((User.agent_doc = '' AND User.referral_doc = '') OR User.photo_doc ='' OR User.video_doc ='') AND User.id=" . $userId;
                    $doc_completed = $this->User->find('count', array('fields' => 'User.id', 'conditions' => array($doc_cond), 'recursive' => -1));
                    if ($doc_completed == 1) {
                        $userdata = array('User' => array('id' => $userId, 'doc_status' => '0'));
                        $this->User->save($userdata, false, array('doc_status'));
                    } else {
                        $userdata = array('User' => array('id' => $userId, 'doc_status' => '1'));
                        $this->User->save($userdata, false, array('doc_status'));
                    }

                    $this->Session->write('popup', 'Referal document has been deleted successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                }
            }

            if (!empty($this->request->query['mojoreferalFile'])) {  // upload referal file
                $this->request->data['User']['mojopay_referral'] = '';
                $this->User->set($this->request->data);

                if ($this->User->save($this->request->data)) {
                    unlink(WWW_ROOT . "/files/userdocument/" . $this->request->query['mojopay_referral']);
                    //check whether any document is deleted or added and then set status "complete" or "incomplete"

                    $this->Session->write('popup', 'Referal document has been deleted successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                }
            }


            if (!empty($this->request->query['photoFile'])) {
                $this->request->data['User']['photo_doc'] = '';
                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    unlink(WWW_ROOT . "/files/userdocument/" . $this->request->query['photoFile']);
                    //check whether any document is deleted or added and then set status "complete" or "incomplete"
                    $doc_cond = "((User.agent_doc = '' AND User.referral_doc = '') OR User.photo_doc ='' OR User.video_doc ='') AND User.id=" . $userId;
                    $doc_completed = $this->User->find('count', array('fields' => 'User.id', 'conditions' => array($doc_cond), 'recursive' => -1));
                    if ($doc_completed == 1) {
                        $userdata = array('User' => array('id' => $userId, 'doc_status' => '0'));
                        $this->User->save($userdata, false, array('doc_status'));
                    } else {
                        $userdata = array('User' => array('id' => $userId, 'doc_status' => '1'));
                        $this->User->save($userdata, false, array('doc_status'));
                    }

                    $this->Session->write('popup', 'W-9 document has been deleted successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                }
            }




            if (!empty($this->request->query['videoFile'])) { // upload video file
                $this->request->data['User']['video_doc'] = '';
                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    unlink(WWW_ROOT . "/files/userdocument/" . $this->request->query['videoFile']);
                    //check whether any document is deleted or added and then set status "complete" or "incomplete"
                    $doc_cond = "((User.agent_doc = '' AND User.referral_doc = '') OR User.photo_doc ='' OR User.video_doc ='') AND User.id=" . $userId;
                    $doc_completed = $this->User->find('count', array('fields' => 'User.id', 'conditions' => array($doc_cond), 'recursive' => -1));
                    if ($doc_completed == 1) {
                        $userdata = array('User' => array('id' => $userId, 'doc_status' => '0'));
                        $this->User->save($userdata, false, array('doc_status'));
                    } else {
                        $userdata = array('User' => array('id' => $userId, 'doc_status' => '1'));
                        $this->User->save($userdata, false, array('doc_status'));
                    }

                    $this->Session->write('popup', 'NDA document has been deleted successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                }
            }
            
                if (!empty($this->request->query['mojo_videoFile'])) { // upload video file
                $this->request->data['User']['mojo_video_doc'] = '';
                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    unlink(WWW_ROOT . "/files/userdocument/" . $this->request->query['mojo_video_doc']);                  

                    $this->Session->write('popup', 'Mojo Pay NDA document has been deleted successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                }
            }
        }

        if ($this->request->data) {  // if submit data
		
            if ($this->request->data['User']['SUBMIT'] == 'AGENT') {  // save record for agent menu
                $this->request->data['User']['id'] = $userId;
                $agentfileerror = '';
                $agentFileExtension = end(explode('.', $this->request->data['User']['agent_doc']['name']));

                if ($agentFileExtension != 'exe') {
                    if ($this->request->data['User']['agent_doc']['name']) {
                        $image = time() . '_' . $this->request->data['User']['agent_doc']['name'];
                        move_uploaded_file($this->request->data['User']['agent_doc']['tmp_name'], WWW_ROOT . "/files/userdocument/" . $image);
                        if ($this->request->data['User']['oldfile']) {
                            unlink(WWW_ROOT . "/files/userdocument/" . $this->request->data['User']['oldfile']);
                        }
                        $this->request->data['User']['agent_doc'] = $image;
                    } else {
                        $this->request->data['User']['agent_doc'] = $this->request->data['User']['oldfile'];
                    }
                    $this->User->set($this->request->data);

                    if ($this->User->save($this->request->data)) {
                        //check whether any document is deleted or added and then set status "complete" or "incomplete"
                        $doc_cond = "((User.agent_doc = '' AND User.referral_doc = '') OR User.photo_doc ='' OR User.video_doc ='') AND User.id=" . $userId;
                        $doc_completed = $this->User->find('count', array('fields' => 'User.id', 'conditions' => array($doc_cond), 'recursive' => -1));
                        if ($doc_completed == 1) {
                            $userdata = array('User' => array('id' => $userId, 'doc_status' => '0'));
                            $this->User->save($userdata, false, array('doc_status'));
                        } else {
                            $userdata = array('User' => array('id' => $userId, 'doc_status' => '1'));
                            $this->User->save($userdata, false, array('doc_status'));
                        }
                        $this->Session->write('popup', 'Agent Document has been Uploaded Successfully.');
                        $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                    } else {
                        $this->Session->setFlash('Data save problem, Please try again.');
                    }
                } else {
                    $this->set('agentfileerror', 'Please upload another file');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'VIDEODOC') {
                $this->request->data['User']['id'] = $userId;
                $agentfileerror = '';
                $agentFileExtension = end(explode('.', $this->request->data['User']['video_doc']['name']));
                if ($agentFileExtension != 'exe') {
                    if ($this->request->data['User']['video_doc']['name']) {
                        $image = time() . '_' . $this->request->data['User']['video_doc']['name'];
                        move_uploaded_file($this->request->data['User']['video_doc']['tmp_name'], WWW_ROOT . "/files/userdocument/" . $image);
                        if ($this->request->data['User']['oldfile']) {
                            unlink(WWW_ROOT . "/files/userdocument/" . $this->request->data['User']['oldfile']);
                        }
                        $this->request->data['User']['video_doc'] = $image;
                    } else {
                        $this->request->data['User']['video_doc'] = $this->request->data['User']['oldfile'];
                    }

                    $this->User->set($this->request->data);

                    if ($this->User->save($this->request->data)) {
                        //check whether any document is deleted or added and then set status "complete" or "incomplete"
                        $doc_cond = "((User.agent_doc = '' AND User.referral_doc = '') OR User.photo_doc ='' OR User.video_doc ='') AND User.id=" . $userId;
                        $doc_completed = $this->User->find('count', array('fields' => 'User.id', 'conditions' => array($doc_cond), 'recursive' => -1));
                        if ($doc_completed == 1) {
                            $userdata = array('User' => array('id' => $userId, 'doc_status' => '0'));
                            $this->User->save($userdata, false, array('doc_status'));
                        } else {
                            $userdata = array('User' => array('id' => $userId, 'doc_status' => '1'));
                            $this->User->save($userdata, false, array('doc_status'));
                        }
                        $this->Session->write('popup', 'NDA document has been uploaded successfully.');
                        $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                    } else {
                        $this->Session->setFlash('Data save problem, Please try again.');
                    }
                } else {
                    $this->set('videofileerror', 'Please upload another file');
                }
            }

                 if ($this->request->data['User']['SUBMIT'] == 'MOJO_VIDEODOC') {
                $this->request->data['User']['id'] = $userId;
                $agentfileerror = '';
                $agentFileExtension = end(explode('.', $this->request->data['User']['mojo_video_doc']['name']));
                if ($agentFileExtension != 'exe') {
                    if ($this->request->data['User']['mojo_video_doc']['name']) {
                        $image = time() . '_' . $this->request->data['User']['mojo_video_doc']['name'];
                        move_uploaded_file($this->request->data['User']['mojo_video_doc']['tmp_name'], WWW_ROOT . "/files/userdocument/" . $image);
                        if ($this->request->data['User']['oldfile']) {
                            unlink(WWW_ROOT . "/files/userdocument/" . $this->request->data['User']['oldfile']);
                        }
                        $this->request->data['User']['mojo_video_doc'] = $image;
                    } else {
                        $this->request->data['User']['mojo_video_doc'] = $this->request->data['User']['oldfile'];
                    }

                    $this->User->set($this->request->data);

                    if ($this->User->save($this->request->data)) {                       
                        $this->Session->write('popup', 'Mojo Pay NDA document has been uploaded successfully.');
                        $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                    } else {
                        $this->Session->setFlash('Data save problem, Please try again.');
                    }
                } else {
                    $this->set('videofileerror', 'Please upload another file');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'REFERAL') {
                $this->request->data['User']['id'] = $userId;
                $agentfileerror = '';
                $agentFileExtension = end(explode('.', $this->request->data['User']['referral_doc']['name']));

                if ($agentFileExtension != 'exe') {

                    if ($this->request->data['User']['referral_doc']['name']) {
                        $image = time() . '_' . $this->request->data['User']['referral_doc']['name'];
                        move_uploaded_file($this->request->data['User']['referral_doc']['tmp_name'], WWW_ROOT . "/files/userdocument/" . $image);
                        if ($this->request->data['User']['oldfile']) {
                            unlink(WWW_ROOT . "/files/userdocument/" . $this->request->data['User']['oldfile']);
                        }

                        $this->request->data['User']['referral_doc'] = $image;
                    } else {
                        $this->request->data['User']['referral_doc'] = $this->request->data['User']['oldfile'];
                    }


                    $this->User->set($this->request->data);
                    if ($this->User->save($this->request->data)) {
                        //check whether any document is deleted or added and then set status "complete" or "incomplete"
                        $doc_cond = "((User.agent_doc = '' AND User.referral_doc = '') OR User.photo_doc ='' OR User.video_doc ='') AND User.id=" . $userId;
                        $doc_completed = $this->User->find('count', array('fields' => 'User.id', 'conditions' => array($doc_cond), 'recursive' => -1));
                        if ($doc_completed == 1) {
                            $userdata = array('User' => array('id' => $userId, 'doc_status' => '0'));
                            $this->User->save($userdata, false, array('doc_status'));
                        } else {
                            $userdata = array('User' => array('id' => $userId, 'doc_status' => '1'));
                            $this->User->save($userdata, false, array('doc_status'));
                        }
                        $this->Session->write('popup', 'Referal Document has been Uploaded Successfully.');
                        $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                    } else {
                        $this->Session->setFlash('Data save problem, Please try again.');
                    }
                } else {
                    $this->set('referalfileerror', 'Please upload another file');
                }
            }

            if ($this->request->data['User']['SUBMIT'] == 'MOJO_REFERAL') {
                $this->request->data['User']['id'] = $userId;
                $agentfileerror = '';
                
                $agentFileExtension = end(explode('.', $this->request->data['User']['mojopay_referral']['name']));

                if ($agentFileExtension != 'exe') {

                    if ($this->request->data['User']['mojopay_referral']['name']) {
                        $image = time() . '_' . $this->request->data['User']['mojopay_referral']['name'];
                        move_uploaded_file($this->request->data['User']['mojopay_referral']['tmp_name'], WWW_ROOT . "/files/userdocument/" . $image);
                        if ($this->request->data['User']['oldfile']) {
                            unlink(WWW_ROOT . "/files/userdocument/" . $this->request->data['User']['oldfile']);
                        }
                        $this->request->data['User']['mojopay_referral'] = $image;
                    } else {
                        $this->request->data['User']['mojopay_referral'] = $this->request->data['User']['oldfile'];
                    }

                    
                    $this->User->set($this->request->data);
                    if ($this->User->save($this->request->data)) {
                        
                        //check whether any document is deleted or added and then set status "complete" or "incomplete"					
                        $this->Session->write('popup', 'Mojo Pay Referal Document has been Uploaded Successfully.');
                        $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                    } else {
                        $this->Session->setFlash('Data save problem, Please try again.');
                    }
                } else {
                    $this->set('referalfileerror', 'Please upload another file');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'PHOTOID') {
                $this->request->data['User']['id'] = $userId;
                $agentfileerror = '';
                $agentFileExtension = end(explode('.', $this->request->data['User']['photo_doc']['name']));
                if ($agentFileExtension != 'exe') {
                    if ($this->request->data['User']['photo_doc']['name']) {
                        $image = time() . '_' . $this->request->data['User']['photo_doc']['name'];
                        move_uploaded_file($this->request->data['User']['photo_doc']['tmp_name'], WWW_ROOT . "/files/userdocument/" . $image);
                        if ($this->request->data['User']['oldfile']) {
                            unlink(WWW_ROOT . "/files/userdocument/" . $this->request->data['User']['oldfile']);
                        }
                        $this->request->data['User']['photo_doc'] = $image;
                    } else {
                        $this->request->data['User']['photo_doc'] = $this->request->data['User']['oldfile'];
                    }

                    $this->User->set($this->request->data);
                    if ($this->User->save($this->request->data)) {
                        //check whether any document is deleted or added and then set status "complete" or "incomplete"
                        $doc_cond = "((User.agent_doc = '' AND User.referral_doc = '') OR User.photo_doc ='' OR User.video_doc ='') AND User.id=" . $userId;
                        $doc_completed = $this->User->find('count', array('fields' => 'User.id', 'conditions' => array($doc_cond), 'recursive' => -1));
                        if ($doc_completed == 1) {
                            $userdata = array('User' => array('id' => $userId, 'doc_status' => '0'));
                            $this->User->save($userdata, false, array('doc_status'));
                        } else {
                            $userdata = array('User' => array('id' => $userId, 'doc_status' => '1'));
                            $this->User->save($userdata, false, array('doc_status'));
                        }
                        $this->Session->write('popup', 'W-9 form document has been uploaded successfully.');
                        $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
                    } else {

                        $this->Session->setFlash('Data save problem, Please try again.');
                    }
                } else {
                    $this->set('photofileerror', 'Please upload another file');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'STATUS') {
                if ($this->request->data['User']['doc_status'] == 0)
                    $userdata = array('User' => array('id' => $userId, 'doc_status' => 0));
                else
                    $userdata = array('User' => array('id' => $userId, 'doc_status' => 1));

                $this->User->save($userdata, false, array('doc_status'));
                $this->Session->write('popup', 'Status Changed successfully.');
                $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
            }
        }




        if (!empty($userId)) {
            $this->generalinformation($userId);
        } else {
            $this->redirect(array('controller' => 'users', 'action' => "editUser/" . $userId . "/message:success"));
        }
    }

    public function superadmin_deleteUser($userId = null) { // delete user

        $id = $userId;
        if ($this->User->deleteAll(array('User.id' => $id), true)) {


            $this->UserGroupPermission->delete(array('UserGroupPermission.user_id="' . $id . '"'));

            $this->Session->write('popup', 'User has been deleted successfully.');
            $this->Session->setFlash('User has been deleted successfully');
            $this->redirect(array('controller' => 'users', 'action' => "index/message:success"));
        }
    }

    function superadmin_export() {  // exprt record
        $UserRec = $this->User->find('all');
        ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
        //create a file

        $filename = "export_" . date("Y.m.d") . ".csv";
        $csv_file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // The column headings of your .csv file
        $header_row = array("id", "Name", "Phone 1", "Phone 2", "Email", "Company", "Website", "Address 1", "Address 2", "City", "State", "Zip", "Country", "Bank User Name", "Bank  Name", "Bank Address 1", "Bank Address 2", "Bank City", "Bank State", "Bank Zip", "Bank Country", "Bank Phone Number", "Bank Account Number", "Bank State", "Bank Zip", "Bank State", "Bank Zip", "Bank Country", "Bank Phone");

        fputcsv($csv_file, $header_row, ',', '"');
        // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column


        foreach ($UserRec as $result) {
            // Array indexes correspond to the field names in your db table(s)
            $row = array(
                $result['User']['id'],
                $result['User']['user_Name'],
                $result['User']['userPhone'],
                $result['User']['userPhone2'],
                $result['User']['userEmail'],
                $result['User']['userCompany'],
                $result['User']['userCompanyUrl'],
                $result['User']['userAddress'],
                $result['User']['userAddress2'],
                $result['User']['userCity'],
                $result['User']['userState'],
                $result['User']['userZip'],
                $result['User']['userCountry'],
                $result['User']['bankUserName'],
                $result['User']['bankName'],
                $result['User']['bankAddress'],
                $result['User']['bankAddress2'],
                $result['User']['bankCity'],
                $result['User']['bankState'],
                $result['User']['bankZip'],
                $result['User']['bankCountry'],
                $result['User']['bankPhone'],
                $result['User']['bankAccountNumber'],
                $result['User']['bankState'],
                $result['User']['bankZip'],
                $result['User']['bankCountry'],
                $result['User']['bankPhone']
            );

            fputcsv($csv_file, $row, ',', '"');
        }

        fclose($csv_file);
        die;
    }

    public function superadmin_login() { // check to login process

        $this->Session->write('Usermgmt.OriginAfterLogin', $this->Cookie->read('OriginAfterLogin'));


        if (!$this->Session->read('UserAuth.User.id')) { // if userid in session than redirect to role
            $this->UserAuth->logout();
        } else {
            $this->redirect('/superadmin/usermgmt/users/role');
        }

        if ($this->request->isPost()) {
            $this->User->set($this->data);
            if ($this->User->LoginValidate()) {
                $email = $this->data['User']['email'];
                $password = $this->data['User']['password'];
                $user = $this->User->findByUsername($email);

                // check for inactive account
                if (isset($user['User']['id'])) {
                    if ($user['User']['active'] == 0) {
                        $this->Session->setFlash(__('<div style="color:red">Contact with administrator to activate your account.</div>'));
                        return;
                    }
                    $hashed = md5($password);


                    if ($user['User']['password'] === $hashed) {

                        $this->UserAuth->login($user);
                        $remember = (!empty($this->data['User']['remember']));
                        if ($remember) {
                            //$this->UserAuth->persist('2 weeks');
                        }


                        //================================== user_group_id ===========================
                        $userId = $user['User']['id'];
                        $rec = $this->UserGroupJoin->find("first", array('fields' => 'UserGroupJoin.user_group_id',
                            'conditions' => 'UserGroupJoin.user_id="' . $userId . '" and user_group_id!=0'));
                        $this->Session->write('UserAuth.User.user_group_id', $rec['UserGroupJoin']['user_group_id']);
                        //==================================end ===========================

                        $recsss = $this->UserGroupJoin->find("count", array('fields' => 'UserGroupJoin.user_group_id', 'conditions' => 'UserGroupJoin.user_id="' . $userId . '" and user_group_id!=0'));
                        if ($recsss > 1) {


                            $redirect = '/superadmin/usermgmt/users/role';
                        } else {


                            $redirect = '/superadmin/usermgmt/users/dashboard';
                        }
                        $this->redirect($redirect);
                    } else {
                        $this->Session->setFlash(__('<div style="color:red">The User name and password does not match , please check your login information and try again.</div>'));

                        return;
                    }
                } else {
                    $this->Session->setFlash(__('<div style="color:red">The User name and password does not match , please check your login information and try again.</div>'));
                    return;
                }
            }
        } // submit login page
    }

    public function superadmin_role() { // role
        $userId = $this->Session->read('UserAuth.User.id');
        if (empty($userId)) {
            $this->redirect('/superadmin/login');
        }

        $groupRec = $this->User->query('select * from user_groups where id in(select user_group_id from user_group_joins where user_id="' . $userId . '")');
        $this->set('groupRec', $groupRec);


        if ($this->request->is('post')) { // submit page 
            APP::import('Model', 'Usermgmt.UserGroup');
            $this->UserGroup = new UserGroup();
            $rec = $this->UserGroup->find("first", array('conditions' => 'id="' . $this->request->data['Role'] . '"'));

            if ($rec) {
                $this->Session->write('UserAuth.User.user_group_id', $this->request->data['Role']);
                $this->Session->write('UserAuth.UserGroup', $rec['UserGroup']);
                if (strtolower($rec['UserGroup']['name']) == 'referral') {
                    $this->Session->write('UserAuth.UserGroup.name', 'referal');
                }

                $pos = strpos($this->Session->read('redirects'), 'superadmin');
                $redirect = $this->Session->read('Usermgmt.OriginAfterLogin');

                // update login time
                $user_id = $this->Session->read('UserAuth.User.id');
                $user_data['User']['id'] = $user_id;
                $user_data['User']['online_since'] = time();
                $this->User->save($user_data);



                if (isset($this->request->data['RoleChangeFrom']) && $this->request->data['RoleChangeFrom'] == 'header') {
                    $this->redirect('/superadmin/dashboard');
                    exit;
                }
                
                $this->redirect('/superadmin/dashboard');
		     /* $redirect=$this->Session->read('Usermgmt.OriginAfterLogin');
			$array=array('/superadmin/usermgmt/users/columnChart');
	
				if (!in_array($redirect,$array) && $redirect) {
                    $this->redirect($redirect);
                } else {
                    $this->redirect('/superadmin/dashboard');
                } */
            }
        }
    }

    public function superadmin_contacts($userId = null) { // create new user
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page


        $this->set('id', $userId);
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);
        $this->request->data['User']['id'] = $userId;




        $departmentContactList = $this->Usercontact->find('all', array('conditions' => array('Usercontact.user_id' => $userId, 'Usercontact.contact_type' => 'Department')));
        $this->set('userContactList', $departmentContactList);

        $emailContactList = $this->Usercontact->find('all', array('conditions' => array('Usercontact.user_id' => $userId, 'Usercontact.contact_type' => 'Email')));
        $this->set('emailContactList', $emailContactList);

        $phoneContactList = $this->Usercontact->find('all', array('conditions' => array('Usercontact.user_id' => $userId, 'Usercontact.contact_type' => 'Phone')));
        $this->set('phoneContactList', $phoneContactList);

        if ($this->request->is('post')) {

            if ($this->request->data['User']['SUBMIT'] == 'ISO') {
                $this->request->data['User']['id'] = $userId;

                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'Iso Information Updated successfully.');
                    $this->Session->setFlash('Iso Information Updated successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "iso/" . $userId . "/message:success"));
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'GENERAL') {
                $this->generalinformation();
            }
        }


        if (!empty($userId)) {
            $this->generalinformation($userId);
        } else {
            $this->redirect('/superadmin/usermgmt/users/index');
        }
    }

    public function superadmin_officelink($userId = null) { // create new user
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page



        $this->set('id', $userId);
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);
        $this->request->data['User']['id'] = $userId;




        $backofficeList = $this->Userbackofficelogin->find('all', array('conditions' => array('Userbackofficelogin.user_id' => $userId)));
        $this->set('backofficeList', $backofficeList);



        if ($this->request->is('post')) {

            if ($this->request->data['User']['SUBMIT'] == 'ISO') {
                $this->request->data['User']['id'] = $userId;

                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'Iso Information Updated successfully.');
                    $this->Session->setFlash('Iso Information Updated successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "iso/" . $userId . "/message:success"));
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'GENERAL') {
                $this->generalinformation();
            }
        }


        if (!empty($userId)) {
            $this->generalinformation($userId);
        } else {
            $this->redirect('/superadmin/usermgmt/users/index');
        }
    }

    public function superadmin_getusercontactinformation($id = null, $userId = null, $contactType = null) {
        if ($this->referer() == '/' || $this->referer() == FULL_BASE_URL . router::url('/', false) . 'superadmin/usermgmt/users/role') {
            $this->redirect(FULL_BASE_URL . router::url('/', false) . 'superadmin/dashboard');
        }

        $this->autoRender = false;

        if ($contactType == 'Office') {
            $record = $this->Userbackofficelogin->find('first', array('conditions' => 'Userbackofficelogin.id="' . $id . '" and Userbackofficelogin.user_id="' . $userId . '"'));
            echo json_encode($record);
        } else {
            $record = $this->Usercontact->find('first', array('conditions' => 'Usercontact.id="' . $id . '" and Usercontact.user_id="' . $userId . '"'));
            echo json_encode($record);
        }
    }

    public function superadmin_deletecontactinformation($id = null, $userId = null, $contactType = null) {
        if ($this->referer() == '/' || $this->referer() == FULL_BASE_URL . router::url('/', false) . 'superadmin/usermgmt/users/role') {
            $this->redirect(FULL_BASE_URL . router::url('/', false) . 'superadmin/dashboard');
        }

        $this->autoRender = false;
        if ($contactType == 'Office') {
            $this->Userbackofficelogin->delete($id);
            echo 'Back office login detail has been deleted successfully.';
        } else {
            $this->Usercontact->delete($id);
            echo 'Contact information has been deleted successfully.';
        }
    }

    public function superadmin_getuserList($userType = null, $userId = null) {
        if ($this->referer() == '/' || $this->referer() == FULL_BASE_URL . router::url('/', false) . 'superadmin/usermgmt/users/role') {
            $this->redirect(FULL_BASE_URL . router::url('/', false) . 'superadmin/dashboard');
        }
        //echo $userId;die;

        if ($this->referer() == '/' || $this->referer() == FULL_BASE_URL . router::url('/', false) . 'superadmin/usermgmt/users/role') {
            $this->redirect(FULL_BASE_URL . router::url('/', false) . 'superadmin/dashboard');
        }

        if ($userType == 'Department') {
            $departmentContactList = $this->Usercontact->find('all', array('conditions' => array('Usercontact.user_id' => $userId, 'Usercontact.contact_type' => 'Department'), 'order' => 'id desc'));
            $this->set('departmentContactList', $departmentContactList);
            $this->set('userType', $userType);
        }


        if ($userType == 'Email') {
            $departmentContactList = $this->Usercontact->find('all', array('conditions' => array('Usercontact.user_id' => $userId, 'Usercontact.contact_type' => 'Email'), 'order' => 'id desc'));
            $this->set('emailContactList', $departmentContactList);
            $this->set('userType', $userType);
        }

        if ($userType == 'Phone') {
            $departmentContactList = $this->Usercontact->find('all', array('conditions' => array('Usercontact.user_id' => $userId, 'Usercontact.contact_type' => 'Phone'), 'order' => 'id desc'));
            $this->set('phoneContactList', $departmentContactList);
            $this->set('userType', $userType);
        }

        if ($userType == 'Office') {
            $backofficeList = $this->Userbackofficelogin->find('all', array('conditions' => array('Userbackofficelogin.user_id' => $userId), 'order' => 'id desc'));
            $this->set('backofficeList', $backofficeList);
            $this->set('userType', $userType);
        }
    }

    public function superadmin_usercontact($userId = null) {
        if ($this->referer() == '/' || $this->referer() == FULL_BASE_URL . router::url('/', false) . 'superadmin/usermgmt/users/role') {
            $this->redirect(FULL_BASE_URL . router::url('/', false) . 'superadmin/dashboard');
        }

        $this->autoRender = false;


        if ($this->RequestHandler->isAjax()) {

            if (!empty($this->request->data)) {


                if ($this->request->data['Usercontact']['SUBMIT'] == 'AddDepartmentContact') {

                    $this->Usercontact->set($this->request->data['Usercontact']);

                    if (!$this->Usercontact->departmentcontactValidation()) {
                        $errorsArr = $this->Usercontact->validationErrors;
                        $error = '';
                        foreach ($errorsArr as $value) {
                            $error .=$value[0] . '<br>';
                        }
                        echo $error;
                    } else {

                        $this->Usercontact->save($this->request->data['Usercontact']);
                        echo 'Contact information has been saved successfully';
                    }
                }


                if ($this->request->data['Usercontact']['SUBMIT'] == 'AddEmailContact') { //emailcontactValidation
                    $this->Usercontact->set($this->request->data['Usercontact']);

                    if (!$this->Usercontact->emailcontactValidation()) {
                        $errorsArr = $this->Usercontact->validationErrors;
                        $error = '';
                        foreach ($errorsArr as $value) {
                            $error .=$value[0] . '<br>';
                        }
                        echo $error;
                    } else {
                        $this->Usercontact->save($this->request->data['Usercontact']);
                        echo 'Contact information has been saved successfully';
                    }
                }


                if ($this->request->data['Usercontact']['SUBMIT'] == 'AddPhoneContact') {

                    $this->Usercontact->set($this->request->data['Usercontact']);

                    if (!$this->Usercontact->phonecontactValidation()) {
                        $errorsArr = $this->Usercontact->validationErrors;
                        $error = '';
                        foreach ($errorsArr as $value) {
                            $error .=$value[0] . '<br>';
                        }
                        echo $error;
                    } else {
                        $this->Usercontact->save($this->request->data['Usercontact']);
                        echo 'Contact information has been saved successfully';
                    }
                }


                if ($this->request->data['Userbackofficelogin']['SUBMIT'] == 'AddbackOfficeLogin') {

                    $this->Userbackofficelogin->set($this->request->data['Userbackofficelogin']);

                    if (!$this->Userbackofficelogin->backofficeValidation()) {
                        $errorsArr = $this->Userbackofficelogin->validationErrors;
                        $error = '';
                        foreach ($errorsArr as $value) {
                            $error .=$value[0] . '<br>';
                        }
                        echo $error;
                    } else {
                        $this->Userbackofficelogin->save($this->request->data['Userbackofficelogin']);
                        echo 'back officelogin detail has been saved successfully';
                    }
                }
            }
        }
    }

    public function usercontact($userId = null) {
        $this->autoRender = false;
        echo 'asdf';
    }

    public function superadmin_agent($userId = null) {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page



        $this->set('id', $userId);
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);

        $this->request->data['User']['id'] = $userId;

        $managerList = $this->User->query("select users.id,users.user_Name,user_group_joins.user_group_id from users,user_group_joins where users.id=user_group_joins.user_id and user_group_joins.user_group_id='24' ");
        $this->set('managerList', $managerList);


        $IsoList = $this->User->query("select users.id,users.user_Name,user_group_joins.user_group_id from users,user_group_joins where users.id=user_group_joins.user_id and user_group_joins.user_group_id='22' ");


        $this->set('IsoList', $IsoList);

        //=====================   RECORD For Merchant =========================
        $this->loadModel('Merchant');
        $this->paginate = array('fields' => 'merchantName,merchantDBA,id',
            'conditions' => array('agentID' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );

        $rec = $this->paginate('Merchant');
        $this->set('MerchantREC', $rec);

        //=====================   RECORD For Merchant =========================


        if ($this->request->is('post')) {
            if ($this->request->data['User']['SUBMIT'] == 'AGENT') {

                $this->request->data['User']['userID'] = $userId;
                $this->User->set($this->request->data);

                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'Agent Information Updated successfully.');
                    $this->redirect('/superadmin/agent/' . $userId . '/message:success');
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'GENERAL') {
                $this->generalinformation();
            }
        }



        if (!empty($userId)) {
            $this->generalinformation($userId);
        } else {
            $this->redirect('/superadmin/usermgmt/users/index');
        }
    }

    public function superadmin_manager($userId = null) {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page

        $this->set('id', $userId);
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);
        $this->request->data['User']['id'] = $userId;

        //======================== Fetch Recrod of merchant ====================
        $processorList = $this->User->query("select users.id,users.user_Name,user_group_joins.user_group_id from users,user_group_joins where users.id=user_group_joins.user_id and user_group_joins.user_group_id='23' ");

        $this->set('processorList', $processorList);

        //==========================================================
        //=====================   RECORD For Merchant =========================

        $this->loadModel('Merchant');

        $this->paginate = array('fields' => 'merchantName,merchantDBA,id',
            'conditions' => array('managerID' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $rec = $this->paginate('Merchant');
        $this->set('MerchantREC', $rec);
        //=====================   end =========================
        //=====================   RECORD For Agent =========================
        $this->paginate = array('fields' => 'User.userEmail,User.id,User.user_Name,User.userPhone',
            'conditions' => array('UserGroupJoin.user_group_id' => 20, 'User.idManager' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $agentRec = $this->paginate('UserGroupJoin');
        $this->set('agentRec', $agentRec);
        /* $agentRec=$this->User->query('SELECT `User`.`user_Name`,`User`.`id`, `User`.`userPhone`, `User`.`userEmail`, `User`.`id` FROM users as User,user_group_joins where user_group_joins.user_id=User.id and user_group_joins.user_group_id="20" and User.idManager="'.$userId .'"');

          $this->set('agentRec', $agentRec); */
        //=====================  End =========================
        //=====================   RECORD For Iso =========================
        /* $isoRec=$this->User->query('SELECT `User`.`user_Name`,`User`.`id`, `User`.`userPhone`, `User`.`userEmail`, `User`.`id` FROM users as User,user_group_joins where  user_group_joins.user_id=User.id and user_group_joins.user_group_id="22" and User.idManager="'.$userId .'"');
          $this->set('isoRec', $isoRec); */
        $this->paginate = array('fields' => 'User.userEmail,User.id,User.user_Name,User.userPhone',
            'conditions' => array('UserGroupJoin.user_group_id' => 22, 'User.idManager' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $isoRec = $this->paginate('UserGroupJoin');
        $this->set('isoRec', $isoRec);
        //=====================   End =========================

        if ($this->request->is('post')) {

            if ($this->request->data['User']['SUBMIT'] == 'MANAGER') {

                $this->request->data['User']['userId'] = $userId;
                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {

                    $this->Session->write('popup', 'Processor has been change successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "manager/" . $userId . "/message:success"));
                } else {

                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }

            if ($this->request->data['User']['SUBMIT'] == 'GENERAL') {
                $this->generalinformation();
            }
        }


        if (!empty($userId)) {
            $this->generalinformation($userId);
        } else {
            $this->redirect('/superadmin/usermgmt/users/index');
        }
    }

    public function superadmin_referal($userId = null) {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page

        $this->set('id', $userId);
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);
        $this->request->data['User']['id'] = $userId;

        $IsoList = $this->User->query("select users.id,users.user_Name,user_group_joins.user_group_id from users,user_group_joins where users.id=user_group_joins.user_id and user_group_joins.user_group_id='22' ");
        $this->set('IsoList', $IsoList);

        //======================== Fetch Recrod of merchant ====================
        //  $this->set('processorList',$this->User->find("list",array('fields'=>'id,user_Name','conditions'=>'User.isProcessor	=1')));
        //==========================================================
        //=====================   RECORD For Merchant =========================
        $this->loadModel('Merchant');
        $this->paginate = array('fields' => 'merchantName,merchantDBA,id',
            'conditions' => array('referalID' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $rec = $this->paginate('Merchant');
        $this->set('MerchantREC', $rec);
        //=====================   RECORD For Merchant =========================


        if ($this->request->is('post')) {

            if ($this->request->data['User']['SUBMIT'] == 'MANAGER') {
                $this->request->data['User']['userId'] = $userId;

                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'Information Updated successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "manager/" . $userId . "/message:success"));
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'AGENT') {  // submit iso information
                $this->request->data['User']['userID'] = $userId;
                $this->User->set($this->request->data);

                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'Agent Information Updated successfully.');
                    $this->redirect('/superadmin/referal/' . $userId . '/message:success');
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }




            if ($this->request->data['User']['SUBMIT'] == 'GENERAL') { // save record common form 
                $this->generalinformation();
            }
        }


        if (!empty($userId)) {

            $this->generalinformation($userId);
        } else {

            $this->redirect('/superadmin/usermgmt/users/index');
        }
    }

    public function superadmin_iso($userId = null) {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page


        $this->set('id', $userId);
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);
        $this->request->data['User']['id'] = $userId;

        //======================== Fetch Recrod of manager ====================
        $referralList = $this->User->query("select users.id,users.user_Name,user_group_joins.user_group_id from users,user_group_joins where users.id=user_group_joins.user_id and user_group_joins.user_group_id='25' ");
        $this->set('referralList', $referralList);

        //=====================   RECORD For Merchant =========================
        $this->loadModel('Merchant');
        $this->paginate = array('fields' => 'merchantName,merchantDBA,id',
            'conditions' => array('isoID' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $rec = $this->paginate('Merchant');
        $this->set('MerchantREC', $rec);
        //=====================End   RECORD For Merchant =========================
        //=====================   RECORD For Agent =========================
        $this->paginate = array('fields' => 'User.userEmail,User.id,User.user_Name,User.userPhone',
            'conditions' => array('UserGroupJoin.user_group_id' => 20, 'User.idIso' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $agentRec = $this->paginate('UserGroupJoin');
        $this->set('agentRec', $agentRec);

        /* $agentRec=$this->UserGroupJoin->find('all',array('fields'=>'User.userEmail,User.id,User.user_Name,User.userPhone',
          'conditions'=>'UserGroupJoin.user_group_id=20 and
          User.idIso="'.$userId.'"	'));
          $this->set('agentRec', $agentRec); */


        //=====================   referal  =========================

        $this->paginate = array('fields' => 'User.userEmail,User.id,User.user_Name,User.userPhone',
            'conditions' => array('UserGroupJoin.user_group_id' => 25, 'User.idIso' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $referalRec = $this->paginate('UserGroupJoin');
        $this->set('referalRec', $referalRec);

        /* $referalRec=$this->UserGroupJoin->find('all',array('fields'=>'User.userEmail,User.id,User.user_Name,User.userPhone',
          'conditions'=>'UserGroupJoin.user_group_id=25 and
          User.idIso="'.$userId.'"	'));

          $this->set('referalRec', $referalRec); */




        if ($this->request->is('post')) {

            if ($this->request->data['User']['SUBMIT'] == 'ISO') {
                $this->request->data['User']['id'] = $userId;

                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'Iso Information Updated successfully.');
                    $this->Session->setFlash('Iso Information Updated successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "iso/" . $userId . "/message:success"));
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'GENERAL') {
                $this->generalinformation();
            }
        }


        if (!empty($userId)) {
            $this->generalinformation($userId);
        } else {
            $this->redirect('/superadmin/usermgmt/users/index');
        }
    }

    public function superadmin_processor($userId = null) {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page

        $this->set('id', $userId);
        $this->request->data['User']['id'] = $userId;
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);
        $this->request->data['User']['id'] = $userId;

        //======================== Fetch Recrod of merchant ====================
        $this->set('processorList', $this->User->find("list", array('fields' => 'id,user_Name', 'conditions' => 'User.isProcessor	=1')));
        //==========================================================
        //=====================   RECORD For Merchant =========================
        $this->loadModel('Merchant');
        $this->paginate = array('fields' => 'id,merchantName,merchantDBA',
            'conditions' => array('processorID' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $rec = $this->paginate('Merchant');
        $this->set('MerchantREC', $rec);
        //=====================   End =========================
        //=====================   RECORD For manager =========================
        /* $managerRec=$this->User->query('SELECT `User`.`id`,`User`.`user_Name`, `User`.`userPhone`, `User`.`userEmail`, `User`.`id` FROM users as User,user_group_joins where  user_group_joins.user_id=User.id and user_group_joins.user_group_id="24" and User.idProcessor="'.$userId .'"');
          $this->set('managerRec', $managerRec); */
        $this->paginate = array('fields' => 'User.userEmail,User.id,User.user_Name,User.userPhone',
            'conditions' => array('UserGroupJoin.user_group_id' => 24, 'User.idProcessor' => $userId),
            'limit' => 5,
            'paramType' => 'querystring'
        );
        $managerRec = $this->paginate('UserGroupJoin');
        $this->set('managerRec', $managerRec);
        //=====================  end =========================
        //=====================   processordoc LIST =========================
        $docLIST = $this->User->query("SELECT * from  processordocs");
        $this->set('docRec', $docLIST);
        //============================  END ==========================
        //=====================   processordoc LIST =========================
        $this->loadModel('Accounttype');
        $accountType = $this->Accounttype->find('list', array('fields' => array('id', 'accountType')));
        $this->set('accountType', $accountType);
        //============================  END ==========================
        //=============================Business Type Processor Link ===========
        $processor_busi_type = array();
        $this->loadModel('Businesstypeprocessorlink');
        $businessRec = $this->Businesstypeprocessorlink->find('all', array('conditions' => 'user_id=' . $userId . ''));
        foreach ($businessRec as $selectedbusinesstype) {
            $processor_busi_type[] = $selectedbusinesstype['Businesstypeprocessorlink']['businessTypeID'];
        }
        $this->set('processor_business_type', $processor_busi_type);

        //========================= Business Type (category)			
        $businessType = $this->Businesscat->find('all', array('conditions' => 'parent_id=0'));
        $this->set('businessType', $businessType);


        if ($this->request->is('post')) {
            //=========================  For Documnt Save =====================
            if ($this->request->data['User']['SUBMIT'] == 'DOCUMENT') {
                foreach ($this->request->data['User'] as $key => $value) {
                    if ($value == '1') {
                        $this->loadModel('Processordoclink');
                        $businessDoc = $this->Processordoclink->find('count', array('conditions' => 'processorID=' . $userId . ' and  docID=' . $key . ''));
                        if (!$businessDoc) {
                            $docLIST = $this->User->query("insert into processordoclinks set processorID='" . $userId . "',
																										docID='" . $key . "'
																									");
                        }
                    }
                }
                $this->Session->write('popup', 'Record has Updated successfully.');
                $this->redirect(array('controller' => 'users', 'action' => "processor/" . $userId . "/message:success"));
            }
            //=========================  For Documnt Save =====================
            //=========================  For profile  =====================
            if ($this->request->data['User']['SUBMIT'] == 'profile') {
                //pr($this->request->data);die;
                $this->request->data['User']['userID'] = $userId;
                $this->request->data['Businesstypeprocessorlink']['user_id'] = $userId;
                $this->loadModel('Businesstypeprocessorlink');


                if (count($this->request->data['Businesstypeprocessorlink']['businessTypeID'] > 0)) {
                    $this->Businesstypeprocessorlink->deleteAll(array('Businesstypeprocessorlink.user_id' => $userId), false);
                    foreach ($this->request->data['Businesstypeprocessorlink']['businessTypeID'] as $businesstype) {
                        $this->request->data['Businesstypeprocessorlink']['businessTypeID'] = $businesstype;
                        $this->request->data['Businesstypeprocessorlink']['user_id'] = $userId;
                        $this->Businesstypeprocessorlink->create();
                        //pr($this->request->data);die;
                        // save data
                        $this->Businesstypeprocessorlink->save($this->request->data);
                    }
                }

                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'Profile information has updated successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "processor/" . $userId . "/message:success"));
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }

            //=========================  end Profile =====================

            if ($this->request->data['User']['SUBMIT'] == 'TEMPLATE') {
                $this->request->data['User']['id'] = $userId;
                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'Template has been Updated successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "processor/" . $userId . "/message:success"));
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }


            if ($this->request->data['User']['SUBMIT'] == 'PROCESSOR') {

                $this->request->data['User']['userID'] = $userId;

                if ($this->request->data['User']['processorPackageFilename']['name']) {
                    $image = time() . '_' . $this->request->data['User']['processorPackageFilename']['name'];
                    move_uploaded_file($this->request->data['User']['processorPackageFilename']['tmp_name'], WWW_ROOT . "/uploadedfile/" . $image);
                    if ($this->request->data['User']['oldfile']) {
                        unlink(WWW_ROOT . "/uploadedfile/" . $this->request->data['User']['oldfile']);
                    }

                    if (!$this->request->data['User']['processorPackage']) {
                        $this->request->data['User']['processorPackage'] = '1';
                    }
                    $this->request->data['User']['processorPackageFilename'] = $image;
                } else {
                    $this->request->data['User']['processorPackageFilename'] = $this->request->data['User']['oldfile'];
                }


                $this->User->set($this->request->data);
                if ($this->User->save($this->request->data)) {
                    $this->Session->write('popup', 'File has been uploaded Successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "processor/" . $userId . "/message:success"));
                } else {
                    $this->Session->setFlash('Data save problem, Please try again.');
                }
            }
        }


        if (!empty($userId)) {
            $this->generalinformation($userId);
        } else {
            $this->redirect('/superadmin/usermgmt/users/index');
        }
    }

    public function superadmin_deletenotes($delete, $agentNoteID = null, $userid = null) {
        if ($agentNoteID) {
            $this->loadModel('Agentnote');
            $this->User->delete($agentNoteID);
            $this->Agentnote->query("delete from agentnotes where agentNoteID='" . $agentNoteID . "'");
            $this->Session->write('popup', 'Note has been deleted successfully.');
            $this->redirect(array('controller' => 'users', 'action' => "notes/" . $userid . "/message:success"));
        }
    }

    public function superadmin_notes($userId = null) {
        $this->checkGroupid($this->Session->read('UserAuth.User.user_group_id'));  // if empty user_group_id than redirect to role page

        $this->set('id', $userId);
        $userGroups = $this->UserGroup->find('list');
        $this->set('userGroups', $userGroups);
        // ============  Fetch Record For Notes =============================
        $this->loadModel('Agentnote');
        if ($this->Session->read('UserAuth.User.user_group_id') == 1) {
            $condition = 'Agentnote.userID="' . $userId . '"';
        } else {
            $condition = 'Agentnote.enteredBy = "' . $this->Session->read('UserAuth.User.id') . '" and  Agentnote.userID="' . $userId . '" ';
        }
        $this->paginate = array('all', 'conditions' => array($condition),
            'limit' => 50,
            'order' => array(
                'agentNoteID' => 'desc'
            ),
            'paramType' => 'querystring'
        );

        $agentREC = $this->paginate('Agentnote');
        $this->Set('agentRec', $agentREC);
        // ===================  End  =============================


        if ($this->request->is('post')) {
            if ($this->request->data['User']['SUBMIT'] == 'NOTES') {
                $this->loadModel('Agentnote');
                $this->request->data['Agentnote'] = $this->request->data['User'];
                $this->request->data['Agentnote']['userID'] = $userId;
                $this->request->data['Agentnote']['enteredBy'] = $this->Session->read('UserAuth.User.id');
                /* $date = new DateTime("@".time());
                  $date->setTimezone(new DateTimeZone('PST'));
                  $timestamp = $date->format('d/m/Y g:i:s A');  // Pacific time */


                $timestamp = CURRENTDATE;
                $this->request->data['Agentnote']['timeStamp'] = $timestamp;
                $this->Agentnote->set($this->request->data);

                if ($this->Agentnote->save($this->request->data)) {
                    $this->Session->write('popup', 'New note has been added successfully.');
                    $this->redirect(array('controller' => 'users', 'action' => "notes/" . $userId . "/message:success"));
                }
            }
        }



        if (!empty($userId)) {
            $this->generalinformation($userId);
        } else {
            $this->redirect('/superadmin/usermgmt/users/index');
        }
    }

    public function superadmin_dashboard() {
    	$CurrentTime = time();
        $userGroupId = $this->Session->read('UserAuth.User.user_group_id');
        $this->checkGroupid($userGroupId);  // if empty user_group_id than redirect to role page
        // find announcement for login user basis of role
        $news = $this->News->find('all', array('paramType' => 'querystring',
            'order' => 'News.id desc',
            'conditions' => 'FIND_IN_SET(' . $userGroupId . ',user_group_id) and News.end_date > "' . $CurrentTime . '" and News.start_date < "' . $CurrentTime . '" and News.active=1'));
        $this->set('News', $this->News->find('all', array('paramType' => 'querystring',
                    'order' => 'News.id desc',
                    'conditions' => 'FIND_IN_SET(' . $userGroupId . ',user_group_id) and News.end_date > "' . $CurrentTime . '" and News.start_date <= "' . $CurrentTime . '" and News.active=1')));

        //=====

        $role = strtolower($this->Session->read('UserAuth.UserGroup.name'));
        if ($role == 'referral' || $role == 'referal') {
            $groupName = "referal";
        } else {
            $groupName = $this->Session->read('UserAuth.UserGroup.name');
        }

        $this->set('UserGroupName', $groupName);
        $userId = $this->UserAuth->getUserId();
		//$applications_rec=$this->Common->get_applications_rec($userId,$groupName);
	//	echo '<pre>';
	//	print_r($applications_rec);
		$this->set(compact('applications_rec'));
        if (empty($userId)) {
            $this->redirect('/superadmin/login');
        }
        $user = $this->User->findById($userId);

        $this->set('user', $user);
        // get appointment list of login users
        $currentDate = date("Y-m-d h:i:s", time());
        $this->loadModel('Appointment');
        $app_condition = "(Appointment.app_agent=" . $userId . " OR Appointment.app_manager=" . $userId . " OR Appointment.app_ISO=" . $userId . " OR Appointment.app_processor=" . $userId . ") AND Appointment.appointmentFrom >'" . $currentDate . "'";
        $appointment = $this->Appointment->find('all', array('conditions' => $app_condition, 'order' => 'Appointment.appointmentFrom ASC'));
        $this->set('appointment', $appointment);
        // get current date appointment list of login users
        $todayStartDate = date("Y-m-d h:i:s", time());
        $todayEndDate = date("Y-m-d 23:59:59", time());
        $today_app_condition = "(Appointment.app_agent=" . $userId . " OR Appointment.app_manager=" . $userId . " OR Appointment.app_ISO=" . $userId . " OR Appointment.app_processor=" . $userId . ") AND Appointment.appointmentFrom >='" . $todayStartDate . "' AND Appointment.appointmentFrom <='" . $todayEndDate . "'";
        $todayAppointment = $this->Appointment->find('all', array('conditions' => $today_app_condition, 'order' => 'Appointment.appointmentFrom ASC'));
        $this->set('todayAppointment', $todayAppointment);
        
        // get pipeline list of login users
        $this->loadModel('Status');
        $full_url = FULL_BASE_URL . router::url('/', false);
        
        //condition for merchant pipline on dash board
        $merchant_pipline_condition = array("OR" => array(
                "Status.id" => array(1, 2, 3, 4, 5, 9)
        ));
        $Status = $this->Status->find('all', array('order' => 'Status.navigationOrder ASC', 'conditions' => $merchant_pipline_condition));
        $this->set('Status', $Status);
		

        $pipelineChartData = array();
        ############## This section is not visible for users(type-Support,Technical,QA,level 2 Support,etc..) ##########
        if (strtolower($groupName) == "admin" || strtolower($groupName) == "agent" || strtolower($groupName) == "manager" || strtolower($groupName) == "processor" || strtolower($groupName) == "referal" || strtolower($groupName) == "iso") {
            /*             * ** Pipeline Graph code start from here (GRAPH 1) ** */
            // ***************Get data for Pie Chart and assign them into array********************* //
            $pipeChart = $this->Common->lifetimePipelineTest($user['User']['id'], $groupName);
            
            foreach ($pipeChart as $pipe) {
                $linkId = $pipe['Merchant']['statusID'];
                switch ($linkId) {
                    case 1:
                        $pipeType = "Lead";
                        break;
                    case 2:
                        $pipeType = "Pre-Apps";
                        break;
                    case 3:
                        $pipeType = "Incomplete";
                        break;
                    case 4:
                        $pipeType = "Pending";
                        break;
                    case 9:
                        $pipeType = "Integration";
                        break;
                }                
                if ($linkId == 1) {
                    $pipelineChartData[] = array(
                        'name' => '<a href="' . $full_url . 'superadmin/merchants/viewbystatus/' . $linkId . '">' . $pipeType . '</a>',
                        'y' => (int) $pipe[0]['count'],
                        'sliced' => false,
                        'selected' => true
                    );
                } else {
                    $pipelineChartData[] = array(
                        '<a href="' . $full_url . 'superadmin/merchants/viewbystatus/' . $linkId . '">' . $pipeType . '</a>',
                        (int) $pipe[0]['count']
                    );
                }
            }
            
            $pipelineChartName = 'Pie Chart';
            $pipelineChart = $this->HighCharts->create($pipelineChartName, 'pie');

            $this->HighCharts->setChartParams(
                    $pipelineChartName, array(
                'renderTo' => 'piewrapper', // div to display chart inside
                'chartWidth' => 450,
                'chartHeight' => 400,
                'title' => 'Pipeline Lifetime History',
                'creditsText' => '',
                'creditsURL' => '',
                'plotOptionsShowInLegend' => TRUE
                    )
            );

            $pipelineSeries = $this->HighCharts->addChartSeries();
            $pipelineSeries->addName('Merchants')->addData($pipelineChartData);

            $pipelineChart->addSeries($pipelineSeries);
            /*             * ** Pipeline Graph(GRAPH 1) code ends here *** */
            
            

            /*             * ** Application submitted Graph(GRAPH 2) code start from here 
             * 
             * 
              Getting total of leads received in the last 6 months * */
            $applicationChartData = array();
            $xAxisCategoryArray = array();

            for ($m = 5; $m >= 0; $m--) {
                $monthNumber = date('m', strtotime("-" . $m . " month"));
                $monthYear = date('Y', strtotime("-" . $m . " month"));
                //array shows on x axis
                $xAxisData = $monthNumber . "/" . date('y', strtotime("-" . $m . " month"));
                $xAxisCategoryArray[] = $xAxisData;
                //array shows on y axis
                $LeadApp = $this->Common->getLeadApplicationByMonth($monthNumber, $monthYear, $user['User']['id'], $groupName);
                $applicationChartData[] = $LeadApp;
            }
            /* $janLeadApp = $this->Common->getLeadApplicationByMonth("01",$user['User']['id'],$groupName);
              $febLeadApp = $this->Common->getLeadApplicationByMonth("02",$user['User']['id'],$groupName);
              $applicationChartData = array( $janLeadApp, $febLeadApp, $marLeadApp, $aprLeadApp, $mayLeadApp, $junLeadApp, $julLeadApp, $augLeadApp, $sepLeadApp, $octLeadApp, $novLeadApp, $decLeadApp ); */

            $applicationChartName = 'Column Chart';

            $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

            $this->HighCharts->setChartParams(
                    $applicationChartName, array(
                'renderTo' => 'columnwrapper', // div to display chart inside
                'chartWidth' => 550,
                'chartHeight' => 400,
                'title' => 'Total Received Leads In The Last 6 Months: ' . array_sum($applicationChartData),
                'yAxisTitleText' => 'Number Of Total Leads',
                'xAxisCategories' => $xAxisCategoryArray,
                'creditsText' => '',
                'creditsURL' => ''
                    )
            );

            $applicationChartSeries = $this->HighCharts->addChartSeries();

            $applicationChartSeries->addName('Leads')->addData($applicationChartData);

            $applicationChart->addSeries($applicationChartSeries);
            /*             * ** Pipeline Graph(GRAPH 2) code ends here *** */
            

            /*             * ** Pipeline Graph(For total volume of merchants GRAPH 4) code start from here ** */
            $volumeChart = $this->Common->lifetimePipelineVolumeTest('1', $user['User']['id'], $groupName);
            
            $applicationChartData = array();
            foreach ($volumeChart as $volume) {
                $linkId = $volume['Merchant']['statusID'];
                switch ($linkId) {
                    case 1:
                        $leadVolume = (float) $volume[0]['volume'];
                        break;
                    case 2:
                        $preappVolume = (float) $volume[0]['volume'];
                        break;
                    case 3:
                        $incompVolume = (float) $volume[0]['volume'];
                        break;
                    case 4:
                        $pendingVolume = (float) $volume[0]['volume'];
                        break;
                    case 9:
                        $integVolume = (float) $volume[0]['volume'];
                        break;
                    case 5:
                        $processingVolume = (float) $volume[0]['volume'];
                        break;
                }
            }
            $applicationChartData = array($leadVolume, $preappVolume, $incompVolume, $pendingVolume, $integVolume, $processingVolume);
            $applicationChartName = 'Volume Chart';

            $pointEventsClick = <<<EOF
function(){if(this.category=='Lead'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/1'} else if(this.category=='Pre-app'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/2'} else if(this.category=='Incomplete'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/3'} else if(this.category=='Pending'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/4'} else if(this.category=='Integration'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/9'} else if(this.category=='Processing'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/5'}}
EOF;

            $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

            $this->HighCharts->setChartParams(
                    $applicationChartName, array(
                'renderTo' => 'volumewrapper', // div to display chart inside
                'chartWidth' => 550,
                'chartHeight' => 400,
                'title' => 'Monthly Sales Volume',
                'yAxisTitleText' => 'Total Volume',
                'xAxisCategories' => array('Lead', 'Pre-app', 'Incomplete', 'Pending', 'Integration', 'Processing'),
                'creditsText' => '',
                'creditsURL' => '',
                'plotOptionsColumnCursor' => 'pointer',
                'plotOptionsColumnPointEventsClick' => $pointEventsClick
                    )
            );

            $applicationChartSeries = $this->HighCharts->addChartSeries();

            $applicationChartSeries->addName('Total Volume')->addData($applicationChartData);

            $applicationChart->addSeries($applicationChartSeries);
            /*             * ** Pipeline Graph (GRAPH 4) code ends here *** */

            
            /*             * ** Pipeline Graph 5(For Annual Sales volume of merchants GRAPH 5) code start from here ** */
            $volumeChart = $this->Common->ytdPipelineVolumeTest('1', $user['User']['id'], $groupName);


            $applicationChartData = array();
            foreach ($volumeChart as $volume) {
                $linkId = $volume['Merchant']['statusID'];
                switch ($linkId) {
                    case 1:
                        $leadVolume = (float) $volume[0]['volume'];
                        break;
                    case 2:
                        $preappVolume = (float) $volume[0]['volume'];
                        break;
                    case 3:
                        $incompVolume = (float) $volume[0]['volume'];
                        break;
                    case 4:
                        $pendingVolume = (float) $volume[0]['volume'];
                        break;
                    case 9:
                        $integVolume = (float) $volume[0]['volume'];
                        break;
                    case 5:
                        $processingVolume = (float) $volume[0]['volume'];
                        break;
                }
            }
            $applicationChartData = array($leadVolume, $preappVolume, $incompVolume, $pendingVolume, $integVolume, $processingVolume);
            $applicationChartName = 'YTD Volume Chart';

            $pointEventsClick = <<<EOF
function(){if(this.category=='Lead'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/1/ytd'} else if(this.category=='Pre-app'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/2/ytd'} else if(this.category=='Incomplete'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/3/ytd'} else if(this.category=='Pending'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/4/ytd'} else if(this.category=='Integration'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/9/ytd'} else if(this.category=='Processing'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/5/ytd'}}
EOF;

            $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

            $this->HighCharts->setChartParams(
                    $applicationChartName, array(
                'renderTo' => 'ytdvolumewrapper', // div to display chart inside
                'chartWidth' => 550,
                'chartHeight' => 400,
                'title' => 'Annual Sales Volume',
                'yAxisTitleText' => 'Total Volume',
                'xAxisCategories' => array('Lead', 'Pre-app', 'Incomplete', 'Pending', 'Integration', 'Processing'),
                'creditsText' => '',
                'creditsURL' => '',
                'plotOptionsColumnCursor' => 'pointer',
                'plotOptionsColumnPointEventsClick' => $pointEventsClick
                    )
            );

            $applicationChartSeries = $this->HighCharts->addChartSeries();

            $applicationChartSeries->addName('Total Volume')->addData($applicationChartData);

            $applicationChart->addSeries($applicationChartSeries);
            /*             * ** Pipeline Graph(GRAPH 5) code ends here *** */
        }
        ############## END OF section which is not visible for users(type-Support,Technical,QA,level 2 Support,etc..) ##########
    }

    public function superadmin_accessDenied() {
        
    }

    public function superadmin_api() {
        $this->loadModel('Usercat');
        $uc_list = $this->Usercat->find("list", array("fields" => array("id", 'category_name'), "order" => array("Usercat.category_name ASC")));
        $this->set('uc_list', $uc_list);


        $errorsArr = '';


        if (isset($_POST['companyName'])) {

            $userid = "Universal-mgr";

            $password = md5("km2425");
            $agentid = "2";

            $this->loadModel('User');
            $this->loadModel('Merchant');
            $this->loadModel('Merchant');


            $count = $this->User->find('count', array('conditions' => array("User.username" => $userid, "User.password" => $password)));




            if ($this->request->is('post')) {
                if ($this->Recaptcha->verify()) {
                    if ($count > 0) {
                        $agentInfo = $this->User->find('first', array('conditions' => array("User.username" => $userid, "User.password" => $password)));
                        if ($_POST['referalID'] == "") {
                            $agentID = intval($agentInfo['User']['id']);
                        } else {
                            if ($this->Common->isRoleAgent($_POST['referalID'])) {
                                $agentID = $_POST['referalID'];
                            } else {
                                $agentID = intval($agentInfo['User']['id']);
                            }
                        }


                        $processorID = intval($agentInfo['User']['idProcessor']);
                        $isoID = intval($agentInfo['User']['idIso']);
                        $managerID = intval($agentInfo['User']['idManager']);
                        $this->request->data['Merchant']['merchantName'] = $_POST['companyName'];
                        $this->request->data['Merchant']['merchantDBA'] = $_POST['companyName'];
                        $this->request->data['Merchant']['merchantURL'] = $_POST['companySite'];
                        $this->request->data['Merchant']['startDate'] = date("n/j/Y");
                        $this->request->data['Merchant']['sendUpDate'] = date("n/j/Y");
                        $this->request->data['Merchant']['preappDate'] = date("Y-m-d");
                        $this->request->data['Merchant']['contactPhone'] = $_POST['contactPhone'];
                        $this->request->data['Merchant']['contactName'] = $_POST['contactPerson'];
                        $this->request->data['Merchant']['contactEmail'] = $_POST['contactEmail'];
                        $this->request->data['Merchant']['statusID'] = '1'; // status 1 for preapp1 or Lead
                        $this->request->data['Merchant']['accountCategory'] = intval(($_POST['businessType'] > 0) ? $_POST['businessType'] : '7');
                        $this->request->data['Merchant']['agentID'] = $agentID;
                        $this->request->data['Merchant']['processorID'] = $processorID;
                        $this->request->data['Merchant']['isoID'] = $isoID;
                        $this->request->data['Merchant']['managerID'] = $agentID;
                        $this->request->data['Merchant']['referalID'] = $_POST['referalID'];
                        $this->request->data['Merchant']['volume'] = $_POST['salesVolume'];
                        $this->request->data['Merchant']['detailExplanation'] = $_POST['services'];
                        $this->request->data['Merchant']['user_ref_id'] = "user_ref" . $_POST['referalID'];


                        if ($this->Merchant->save($this->request->data)) {
                            $body = 'Thank you for your interest in our company,  we value every customer  and offer impeccable services. We will be contacting you very soon.<br/> Your filling information is as follow:<br/><br/>';
                            /* foreach ($_POST as $key=>$value) {
                              if($key!='username' && $key!='password' && $key!='agentID')
                              $body .= "$key: $value <br>";
                              } */


                            if ($_POST['businessType'] == 1)
                                $businessType = 'Swipe';
                            elseif ($_POST['businessType'] == 2)
                                $businessType = 'MOTO';
                            elseif ($_POST['businessType'] == 3)
                                $businessType = 'Internet';
                            elseif ($_POST['businessType'] == 4)
                                $businessType = 'Mobile';
                            elseif ($_POST['businessType'] == 5)
                                $businessType = 'Equipment';
                            elseif ($_POST['businessType'] == 6)
                                $businessType = 'Gateway';
                            elseif ($_POST['businessType'] == 7)
                                $businessType = 'Other';
                            elseif ($_POST['businessType'] == 8)
                                $businessType = 'USB Swipe';
                            elseif ($_POST['businessType'] == 10)
                                $businessType = 'PSP';
                            elseif ($_POST['businessType'] == 11)
                                $businessType = 'Gift Cards';
                            elseif ($_POST['businessType'] == 12)
                                $businessType = 'ACH';

                            $body .= "Company Name: " . $_POST['companyName'] . "<br>";
                            $body .= "Company Site: " . $_POST['companySite'] . "<br>";
                            $body .= "Contact Name: " . $_POST['contactPerson'] . "<br>";
                            $body .= "Contact Email: " . $_POST['contactEmail'] . "<br>";
                            $body .= "Contact Phone: " . $_POST['contactPhone'] . "<br>";
                            $body .= "Sales Volume: " . $_POST['salesVolume'] . "<br>";
                            $body .= "Business/Account Type: " . $businessType . "<br>";
                            $body .= "Description of product or services: " . $_POST['services'] . "<br>";
                            //email to user

                            $sendto = $this->request->data['Merchant']['contactEmail'];
                            $subject = "New application from www.total-apps.com";
                            $bodyText = $body;
                            $email = new CakeEmail();

                            //$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));


                            if ($managerID != '') {

                                $managerEmail = $this->Common->getProcessorEmail($managerID);
                            } else {
                                $managerEmail = CANDIDATE_EMAIL_ID_LOGIN;
                            }

                            if ($managerEmail != '') {
                                $email->from(array($managerEmail));
                            } else {
                                $email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
                            }
                            $email->to($sendto);
                            $email->emailFormat('html');
                            $email->subject(strip_tags($subject));
                            $email->send($bodyText);
                            // send email to services@total-apps.com
                            $email->to('services@total-apps.com');
                            $email->send($bodyText);

                            // Add status update in merchant pipeline
                            $this->loadModel('Merchantpipeline');
                            $pipelineData = array();
                            $pipelineData['Merchantpipeline']['merchantID'] = $this->Merchant->getLastInsertID();
                            $pipelineData['Merchantpipeline']['statusFrom'] = 0;
                            $pipelineData['Merchantpipeline']['statusTo'] = 1;
                            $pipelineData['Merchantpipeline']['statusToDate'] = date("Y-m-d");

                            $this->Merchantpipeline->save($pipelineData); // save merchant pipeline

                            $noteData['Merchantnote']['merchantID'] = $pipelineData['Merchantpipeline']['merchantID'];
                            $noteData['Merchantnote']['enteredBy'] = $agentID;
                            //$timestamp = date("n/j/Y g:i:s A");
                            //$noteData['Merchantnote']['timeStamp'] = $timestamp;

                            $timestamp = date("n/j/Y g:i:s A");
                            $noteData['Merchantnote']['timeStamp'] = CURRENTDATE;


                            $noteData['Merchantnote']['note'] = "Merchant has been added successfully on Date " . CURRENTDATE;
                            $this->Merchantnote->save($noteData);   // save merchant note
//					$this->set('succesMsg','Merchant application has been send');
                            $this->Session->setFlash('Merchant application has been send');

                            unset($this->request->data);
                            $this->request->data = '';
                        }
                    }
                } else {
                    // display the raw API error

                    $this->set($this->request->data);
                    $this->Session->setFlash($this->Recaptcha->error);
                }
            }
        }
    }
    
    /*
     * Function for assign permission to user for reports
    * created by Jitendra Pradhan
    * updated on Oct 30, 2013
    * task id 2244
    *
    */
    public function superadmin_reports_permission() {
        $loginuser = $this->Session->read('UserAuth.User.id');
        /* task 2145 */
        if ($loginuser != 2 && $loginuser != 1266) {
            echo "Your are not eligible to open this.";
            die;
        }

        // get report names #2244
        $this->Reportlist->recursive = 0;
        $reportlist = $this->Reportlist->find('list',array('fields'=>array('id','report_name')));
        $reportlists = $reportlist;
        $reportlists['all'] = "All Report Permission"; 
        $this->set('reportlist',$reportlists);
        
        // get group names
        $userGroups = $this->UserGroup->find('list');
        $this->set('role', $userGroups);
        
        // get user list
        $userlist = $this->User->find('list', array('fields' => array('id','user_Name'),'order'=>array('user_Name ASC')));
        $this->set('userlist', $userlist);       
        
        
        if ($this->request->is('post')) {
            if (is_array($this->request->data['UserReport']['id'])) {
            	$report = $this->request->data['UserReport']['reportlist_id'];
            	$this->ReportPermission->deleteAll(array('ReportPermission.reportlist_id'=>$report),false);
                // now assign permission to again
                foreach ($this->request->data['UserReport']['id'] as $userid) {
                	// insert if permission not have                	
                	if($report=='all'){                		
                		foreach ($reportlist as $report_id => $report_name){
                			$this->ReportPermission->deleteAll(array('ReportPermission.user_id'=>$userid,'ReportPermission.reportlist_id'=>$report_id),false);
                			$this->ReportPermission->create();
                			$setReportPermission['ReportPermission']['user_id'] = $userid;
                			$setReportPermission['ReportPermission']['reportlist_id'] = $report_id;
                			$this->ReportPermission->save($setReportPermission);
                		}
                	}else{
	                	$this->ReportPermission->create();
	                    $setReportPermission['ReportPermission']['user_id'] = $userid;
	                    $setReportPermission['ReportPermission']['reportlist_id'] = $report;
	                    $this->ReportPermission->save($setReportPermission);   
                	}   
                }
                $this->Session->write('popup', 'Permission assigned successfully.');
                $this->redirect(array('controller' => 'users', 'action' => "reports_permission/message:success"));
            } else {
                $this->Session->write('popup', 'Please select users to assign permission.');
                $this->redirect(array('controller' => 'users', 'action' => "reports_permission/message:failure"));
            }
        } 
    }

    public function superadmin_loginuser($userID = null) {
        $UserRec = $this->User->findById($userID);
        // set session for another user login
        $this->Session->write('UserAuthSecond', $UserRec);
        //$url = Router::url("/../", true)."main3/superadmin/usermgmt/users/role";
        $url = Router::url("/", true) . "totalapps/superadmin/usermgmt/users/role";
        $this->redirect($url);
    }

    public function superadmin_userstatus($group_id = null) {
        if (!$group_id)
            $this->redirect('/superadmin/dashboard');

        $this->UserGroup->id = $group_id;
        if (!$this->UserGroup->exists()) {
            $this->redirect('/superadmin/dashboard');
        }


        // last fifty new user
        $new_user_list = $this->User->find('all', array(
            'fields' => array('user_Name', 'userPhone', 'userCompany', 'userCompany', 'username', 'created', 'user_by'),
            'order' => 'id desc',
            'limit' => 50,
            'recursive' => -1,
        ));


        // current login users based on there role
        $this->paginate = array('all',
            'fields' => array('User.user_Name', 'User.userPhone', 'User.userCompany', 'User.userCompany', 'User.username', 'User.last_activity_sence', 'User.login_as', 'User.online_since'),
            'conditions' => array('UserGroupJoin.user_group_id' => $group_id, 'User.login_as' => $group_id, 'User.last_activity_sence >' => time() - (60 * 120)),
            'limit' => 50,
            'paramType' => 'querystring'
        );

        $login_users = $this->paginate('UserGroupJoin');





        $this->set(compact(array('login_users', 'group_id', 'new_user_list')));
    }

    public function beforeFilter() {
        $this->UserAuth->autoRedirect = true;
        parent::beforeFilter();
    }

    public function superadmin_logout() { // logot function
        $user_id = $this->Session->read('UserAuth.User.id');
        $user_data['User']['id'] = $user_id;
        $user_data['User']['online_since'] = null;
        $user_data['User']['login_as'] = null;
        $user_data['User']['last_activity_sence'] = null;


        $this->User->save($user_data);


        $this->UserAuth->logout();
        $this->Session->setFlash(__('You are successfully signed out'));
        $this->redirect('/superadmin/login');
    }

    public function superadmin_columnChart() {
        $role = strtolower($this->Session->read('UserAuth.UserGroup.name'));
        if ($role == 'referral' || $role == 'referal') {
            $groupName = "referal";
        } else {
            $groupName = $this->Session->read('UserAuth.UserGroup.name');
        }
        /*         * ** Application submitted Graph(GRAPH 2) code start from here 
          Getting total of leads received in the last 6 months * */
        $applicationChartData = array();
        $xAxisCategoryArray = array();

        for ($m = 5; $m >= 0; $m--) {
            $monthNumber = date('m', strtotime("-" . $m . " month"));
            $monthYear = date('Y', strtotime("-" . $m . " month"));
            //array shows on x axis
            $xAxisData = $monthNumber . "/" . date('y', strtotime("-" . $m . " month"));
            $xAxisCategoryArray[] = $xAxisData;
            //array shows on y axis
            $LeadApp = $this->Common->getLeadApplicationByMonth($monthNumber, $monthYear, $user['User']['id'], $groupName);
            $applicationChartData[] = $LeadApp;
        }

        /* $janLeadApp = $this->Common->getLeadApplicationByMonth("01",$user['User']['id'],$groupName);
          $febLeadApp = $this->Common->getLeadApplicationByMonth("02",$user['User']['id'],$groupName);
          $applicationChartData = array( $janLeadApp, $febLeadApp, $marLeadApp, $aprLeadApp, $mayLeadApp, $junLeadApp, $julLeadApp, $augLeadApp, $sepLeadApp, $octLeadApp, $novLeadApp, $decLeadApp ); */

        $applicationChartName = 'Column Chart';

        $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

        $this->HighCharts->setChartParams(
                $applicationChartName, array(
            'renderTo' => 'columnwrapper', // div to display chart inside
            'chartWidth' => 550,
            'chartHeight' => 400,
            'title' => 'Total Received Leads In The Last 6 Months: ' . array_sum($applicationChartData),
            'yAxisTitleText' => 'Number Of Total Leads',
            'xAxisCategories' => $xAxisCategoryArray,
            'creditsText' => '',
            'creditsURL' => ''
                )
        );

        $applicationChartSeries = $this->HighCharts->addChartSeries();

        $applicationChartSeries->addName('Leads')->addData($applicationChartData);

        $applicationChart->addSeries($applicationChartSeries);
        /*         * ** Pipeline Graph(GRAPH 2) code ends here *** */
    }

    public function superadmin_pieChart() {
        $role = strtolower($this->Session->read('UserAuth.UserGroup.name'));
        if ($role == 'referral' || $role == 'referal') {
            $groupName = "referal";
        } else {
            $groupName = $this->Session->read('UserAuth.UserGroup.name');
        }
        /*         * ** Pipeline Graph code start from here (GRAPH 1) ** */
        $pipelineChartData = array(
            array(
                'name' => '<a href="' . $full_url . 'superadmin/merchants/viewbystatus/1">Lead</a>',
                'y' => $this->Common->lifetimePipeline('1', $user['User']['id'], $groupName),
                'sliced' => false,
                'selected' => true
            ),
            array('<a href="' . $full_url . 'superadmin/merchants/viewbystatus/2">Pre-Apps</a>', $this->Common->lifetimePipeline('2', $user['User']['id'], $groupName)),
            array('<a href="' . $full_url . 'superadmin/merchants/viewbystatus/3">Incomplete</a>', $this->Common->lifetimePipeline('3', $user['User']['id'], $groupName)),
            array('<a href="' . $full_url . 'superadmin/merchants/viewbystatus/4">Pending</a>', $this->Common->lifetimePipeline('4', $user['User']['id'], $groupName)),
            //array('<a href="'.$full_url.'superadmin/merchants/viewbystatus/5">Processing</a>', $this->Common->lifetimePipeline('5',$user['User']['id'],$groupName)),
            array('<a href="' . $full_url . 'superadmin/merchants/viewbystatus/9">Integration</a>', $this->Common->lifetimePipeline('9', $user['User']['id'], $groupName))
        );

        $pipelineChartName = 'Pie Chart';

        $pipelineChart = $this->HighCharts->create($pipelineChartName, 'pie');

        $this->HighCharts->setChartParams(
                $pipelineChartName, array(
            'renderTo' => 'piewrapper', // div to display chart inside
            'chartWidth' => 450,
            'chartHeight' => 400,
            'title' => 'Pipeline Lifetime History',
            'creditsText' => '',
            'creditsURL' => '',
            'plotOptionsShowInLegend' => TRUE
                )
        );

        $pipelineSeries = $this->HighCharts->addChartSeries();

        $pipelineSeries->addName('Merchants')->addData($pipelineChartData);

        $pipelineChart->addSeries($pipelineSeries);
        /*         * ** Pipeline Graph(GRAPH 1) code ends here *** */
    }

    public function superadmin_volumeChart() {
        $role = strtolower($this->Session->read('UserAuth.UserGroup.name'));
        if ($role == 'referral' || $role == 'referal') {
            $groupName = "referal";
        } else {
            $groupName = $this->Session->read('UserAuth.UserGroup.name');
        }
        /*         * ** Pipeline Graph(For total volume of merchants GRAPH 4) code start from here ** */
        $leadVolume = floatval($this->Common->lifetimePipelineVolume('1', $user['User']['id'], $groupName));
        $preappVolume = floatval($this->Common->lifetimePipelineVolume('2', $user['User']['id'], $groupName));
        $incompVolume = floatval($this->Common->lifetimePipelineVolume('3', $user['User']['id'], $groupName));
        $pendingVolume = floatval($this->Common->lifetimePipelineVolume('4', $user['User']['id'], $groupName));
        $integVolume = floatval($this->Common->lifetimePipelineVolume('9', $user['User']['id'], $groupName));
        $processingVolume = floatval($this->Common->lifetimePipelineVolume('5', $user['User']['id'], $groupName));

        $applicationChartData = array($leadVolume, $preappVolume, $incompVolume, $pendingVolume, $integVolume, $processingVolume);

        $applicationChartName = 'Volume Chart';

        $pointEventsClick = <<<EOF
function(){if(this.category=='Lead'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/1'} else if(this.category=='Pre-app'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/2'} else if(this.category=='Incomplete'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/3'} else if(this.category=='Pending'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/4'} else if(this.category=='Integration'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/9'} else if(this.category=='Processing'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/5'}}
EOF;

        $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

        $this->HighCharts->setChartParams(
                $applicationChartName, array(
            'renderTo' => 'volumewrapper', // div to display chart inside
            'chartWidth' => 550,
            'chartHeight' => 400,
            'title' => 'Monthly Sales Volume',
            'yAxisTitleText' => 'Total Volume',
            'xAxisCategories' => array('Lead', 'Pre-app', 'Incomplete', 'Pending', 'Integration', 'Processing'),
            'creditsText' => '',
            'creditsURL' => '',
            'plotOptionsColumnCursor' => 'pointer',
            'plotOptionsColumnPointEventsClick' => $pointEventsClick
                )
        );

        $applicationChartSeries = $this->HighCharts->addChartSeries();

        $applicationChartSeries->addName('Total Volume')->addData($applicationChartData);

        $applicationChart->addSeries($applicationChartSeries);

        /*         * ** Pipeline Graph (GRAPH 4) code ends here *** */
    }

    public function superadmin_ytdVolumeChart() {
        $role = strtolower($this->Session->read('UserAuth.UserGroup.name'));
        if ($role == 'referral' || $role == 'referal') {
            $groupName = "referal";
        } else {
            $groupName = $this->Session->read('UserAuth.UserGroup.name');
        }
        /*         * ** Pipeline Graph 5(For Annual Sales volume of merchants GRAPH 5) code start from here ** */
        $leadVolume = floatval($this->Common->ytdPipelineVolume('1', $user['User']['id'], $groupName));
        $preappVolume = floatval($this->Common->ytdPipelineVolume('2', $user['User']['id'], $groupName));
        $incompVolume = floatval($this->Common->ytdPipelineVolume('3', $user['User']['id'], $groupName));
        $pendingVolume = floatval($this->Common->ytdPipelineVolume('4', $user['User']['id'], $groupName));
        $integVolume = floatval($this->Common->ytdPipelineVolume('9', $user['User']['id'], $groupName));
        $processingVolume = floatval($this->Common->ytdPipelineVolume('5', $user['User']['id'], $groupName));

        $applicationChartData = array($leadVolume, $preappVolume, $incompVolume, $pendingVolume, $integVolume, $processingVolume);

        $applicationChartName = 'YTD Volume Chart';

        $pointEventsClick = <<<EOF
function(){if(this.category=='Lead'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/1/ytd'} else if(this.category=='Pre-app'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/2/ytd'} else if(this.category=='Incomplete'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/3/ytd'} else if(this.category=='Pending'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/4/ytd'} else if(this.category=='Integration'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/9/ytd'} else if(this.category=='Processing'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/5/ytd'}}
EOF;

        $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

        $this->HighCharts->setChartParams(
                $applicationChartName, array(
            'renderTo' => 'ytdvolumewrapper', // div to display chart inside
            'chartWidth' => 550,
            'chartHeight' => 400,
            'title' => 'Annual Sales Volume',
            'yAxisTitleText' => 'Total Volume',
            'xAxisCategories' => array('Lead', 'Pre-app', 'Incomplete', 'Pending', 'Integration', 'Processing'),
            'creditsText' => '',
            'creditsURL' => '',
            'plotOptionsColumnCursor' => 'pointer',
            'plotOptionsColumnPointEventsClick' => $pointEventsClick
                )
        );

        $applicationChartSeries = $this->HighCharts->addChartSeries();

        $applicationChartSeries->addName('Total Volume')->addData($applicationChartData);

        $applicationChart->addSeries($applicationChartSeries);
        /*         * ** Pipeline Graph(GRAPH 5) code ends here *** */
    }

    function superadmin_applicationList() {
        $role = strtolower($this->Session->read('UserAuth.UserGroup.name'));
        if ($role == 'referral' || $role == 'referal') {
            $groupName = "referal";
        } else {
            $groupName = $this->Session->read('UserAuth.UserGroup.name');
        }

        $this->set('UserGroupName', $groupName);
        $userId = $this->UserAuth->getUserId();
        if (empty($userId)) {
            $this->redirect('/superadmin/login');
        }
        $user = $this->User->findById($userId);
        $this->loadModel('Status');
        //condition for merchant pipline on dash board		 
        $merchant_pipline_condition = array("OR" => array(
                "Status.id" => array(1, 2, 3, 4, 5, 9)
        ));
        $Status = $this->Status->find('all', array('order' => 'Status.navigationOrder ASC', 'conditions' => $merchant_pipline_condition, 'fields' => array('Status.id', 'Status.status')));

        $this->set('Status', $Status);
        $this->set('user', $user);


        /*         * ** Pipeline Graph 5(For Annual Sales volume of merchants GRAPH 5) code start from here ** */
        $leadVolume = floatval($this->Common->ytdPipelineVolume('1', $user['User']['id'], $groupName));
        $preappVolume = floatval($this->Common->ytdPipelineVolume('2', $user['User']['id'], $groupName));
        $incompVolume = floatval($this->Common->ytdPipelineVolume('3', $user['User']['id'], $groupName));
        $pendingVolume = floatval($this->Common->ytdPipelineVolume('4', $user['User']['id'], $groupName));
        $integVolume = floatval($this->Common->ytdPipelineVolume('9', $user['User']['id'], $groupName));
        $processingVolume = floatval($this->Common->ytdPipelineVolume('5', $user['User']['id'], $groupName));

        $applicationChartData = array($leadVolume, $preappVolume, $incompVolume, $pendingVolume, $integVolume, $processingVolume);

        $applicationChartName = 'YTD Volume Chart';

        $pointEventsClick = <<<EOF
function(){if(this.category=='Lead'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/1/ytd'} else if(this.category=='Pre-app'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/2/ytd'} else if(this.category=='Incomplete'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/3/ytd'} else if(this.category=='Pending'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/4/ytd'} else if(this.category=='Integration'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/9/ytd'} else if(this.category=='Processing'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/5/ytd'}}
EOF;

        $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

        $this->HighCharts->setChartParams(
                $applicationChartName, array(
            'renderTo' => 'ytdvolumewrapper', // div to display chart inside
            'chartWidth' => 550,
            'chartHeight' => 400,
            'title' => 'Annual Sales Volume',
            'yAxisTitleText' => 'Total Volume',
            'xAxisCategories' => array('Lead', 'Pre-app', 'Incomplete', 'Pending', 'Integration', 'Processing'),
            'creditsText' => '',
            'creditsURL' => '',
            'plotOptionsColumnCursor' => 'pointer',
            'plotOptionsColumnPointEventsClick' => $pointEventsClick
                )
        );

        $applicationChartSeries = $this->HighCharts->addChartSeries();

        $applicationChartSeries->addName('Total Volume')->addData($applicationChartData);

        $applicationChart->addSeries($applicationChartSeries);
        /*         * ** Pipeline Graph(GRAPH 5) code ends here *** */


        /*         * ** Pipeline Graph(For total volume of merchants GRAPH 4) code start from here ** */
        $leadVolume = floatval($this->Common->lifetimePipelineVolume('1', $user['User']['id'], $groupName));
        $preappVolume = floatval($this->Common->lifetimePipelineVolume('2', $user['User']['id'], $groupName));
        $incompVolume = floatval($this->Common->lifetimePipelineVolume('3', $user['User']['id'], $groupName));
        $pendingVolume = floatval($this->Common->lifetimePipelineVolume('4', $user['User']['id'], $groupName));
        $integVolume = floatval($this->Common->lifetimePipelineVolume('9', $user['User']['id'], $groupName));
        $processingVolume = floatval($this->Common->lifetimePipelineVolume('5', $user['User']['id'], $groupName));

        $applicationChartData = array($leadVolume, $preappVolume, $incompVolume, $pendingVolume, $integVolume, $processingVolume);

        $applicationChartName = 'Volume Chart';

        $pointEventsClick = <<<EOF
function(){if(this.category=='Lead'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/1'} else if(this.category=='Pre-app'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/2'} else if(this.category=='Incomplete'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/3'} else if(this.category=='Pending'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/4'} else if(this.category=='Integration'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/9'} else if(this.category=='Processing'){window.location.href = '{$full_url}superadmin/merchants/viewbystatus/5'}}
EOF;

        $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

        $this->HighCharts->setChartParams(
                $applicationChartName, array(
            'renderTo' => 'volumewrapper', // div to display chart inside
            'chartWidth' => 550,
            'chartHeight' => 400,
            'title' => 'Monthly Sales Volume',
            'yAxisTitleText' => 'Total Volume',
            'xAxisCategories' => array('Lead', 'Pre-app', 'Incomplete', 'Pending', 'Integration', 'Processing'),
            'creditsText' => '',
            'creditsURL' => '',
            'plotOptionsColumnCursor' => 'pointer',
            'plotOptionsColumnPointEventsClick' => $pointEventsClick
                )
        );

        $applicationChartSeries = $this->HighCharts->addChartSeries();

        $applicationChartSeries->addName('Total Volume')->addData($applicationChartData);

        $applicationChart->addSeries($applicationChartSeries);

        /*         * ** Pipeline Graph (GRAPH 4) code ends here *** */

        /*         * ** Pipeline Graph code start from here (GRAPH 1) ** */
        $pipelineChartData = array(
            array(
                'name' => '<a href="' . $full_url . 'superadmin/merchants/viewbystatus/1">Lead</a>',
                'y' => $this->Common->lifetimePipeline('1', $user['User']['id'], $groupName),
                'sliced' => false,
                'selected' => true
            ),
            array('<a href="' . $full_url . 'superadmin/merchants/viewbystatus/2">Pre-Apps</a>', $this->Common->lifetimePipeline('2', $user['User']['id'], $groupName)),
            array('<a href="' . $full_url . 'superadmin/merchants/viewbystatus/3">Incomplete</a>', $this->Common->lifetimePipeline('3', $user['User']['id'], $groupName)),
            array('<a href="' . $full_url . 'superadmin/merchants/viewbystatus/4">Pending</a>', $this->Common->lifetimePipeline('4', $user['User']['id'], $groupName)),
            //array('<a href="'.$full_url.'superadmin/merchants/viewbystatus/5">Processing</a>', $this->Common->lifetimePipeline('5',$user['User']['id'],$groupName)),
            array('<a href="' . $full_url . 'superadmin/merchants/viewbystatus/9">Integration</a>', $this->Common->lifetimePipeline('9', $user['User']['id'], $groupName))
        );

        $pipelineChartName = 'Pie Chart';

        $pipelineChart = $this->HighCharts->create($pipelineChartName, 'pie');

        $this->HighCharts->setChartParams(
                $pipelineChartName, array(
            'renderTo' => 'piewrapper', // div to display chart inside
            'chartWidth' => 450,
            'chartHeight' => 400,
            'title' => 'Pipeline Lifetime History',
            'creditsText' => '',
            'creditsURL' => '',
            'plotOptionsShowInLegend' => TRUE
                )
        );

        $pipelineSeries = $this->HighCharts->addChartSeries();

        $pipelineSeries->addName('Merchants')->addData($pipelineChartData);

        $pipelineChart->addSeries($pipelineSeries);
        /*         * ** Pipeline Graph(GRAPH 1) code ends here *** */

        /*         * ** Application submitted Graph(GRAPH 2) code start from here 
          Getting total of leads received in the last 6 months * */
        $applicationChartData = array();
        $xAxisCategoryArray = array();

        for ($m = 5; $m >= 0; $m--) {
            $monthNumber = date('m', strtotime("-" . $m . " month"));
            $monthYear = date('Y', strtotime("-" . $m . " month"));
            //array shows on x axis
            $xAxisData = $monthNumber . "/" . date('y', strtotime("-" . $m . " month"));
            $xAxisCategoryArray[] = $xAxisData;
            //array shows on y axis
            $LeadApp = $this->Common->getLeadApplicationByMonth($monthNumber, $monthYear, $user['User']['id'], $groupName);
            $applicationChartData[] = $LeadApp;
        }

        /* $janLeadApp = $this->Common->getLeadApplicationByMonth("01",$user['User']['id'],$groupName);
          $febLeadApp = $this->Common->getLeadApplicationByMonth("02",$user['User']['id'],$groupName);
          $applicationChartData = array( $janLeadApp, $febLeadApp, $marLeadApp, $aprLeadApp, $mayLeadApp, $junLeadApp, $julLeadApp, $augLeadApp, $sepLeadApp, $octLeadApp, $novLeadApp, $decLeadApp ); */

        $applicationChartName = 'Column Chart';

        $applicationChart = $this->HighCharts->create($applicationChartName, 'column');

        $this->HighCharts->setChartParams(
                $applicationChartName, array(
            'renderTo' => 'columnwrapper', // div to display chart inside
            'chartWidth' => 550,
            'chartHeight' => 400,
            'title' => 'Total Received Leads In The Last 6 Months: ' . array_sum($applicationChartData),
            'yAxisTitleText' => 'Number Of Total Leads',
            'xAxisCategories' => $xAxisCategoryArray,
            'creditsText' => '',
            'creditsURL' => ''
                )
        );

        $applicationChartSeries = $this->HighCharts->addChartSeries();

        $applicationChartSeries->addName('Leads')->addData($applicationChartData);

        $applicationChart->addSeries($applicationChartSeries);
        /*         * ** Pipeline Graph(GRAPH 2) code ends here *** */
    }
	
  function superadmin_addadditionalinformation(){
	  
	  $this->loadModel('UserAddress');
	  $rec=$this->UserAddress->find('first');
		if ($this->request->isPost()) {
		
			$data=$this->request->data;
			if($this->UserAddress->save($data['UserAddress'])){
				echo 'New address box has created successfully';
			}else{
				echo 'Problem in database save';
			}
			
		}
	  die;
	  }
	
	
	 function superadmin_deleteadditionalinformation($id=null){
	 $this->autoRender=false;
	  $this->loadModel('UserAddress');

		if (isset($id)){
			$this->UserAddress->delete($id);
				echo 'Address has been deleted successfully';
	
	 
	  }
	   die;
	  }
	  
	  /*
	   * Function to download merchant full apis
	   * created by jitendra
	   * created on 12 Dec 2013
	   * task id #2697
	   */
	  function superadmin_downloadapi(){
	  	$this->autoRender = false;
		  	ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
		  	//create a file
		  	$filename = WWW_ROOT . "LatestMerchantApi/Total_apps_merchantApi_2013_10_12.zip";
	  		if(file_exists($filename)) {	
				$mimeContentType = 'application/octet-stream';
				$temMimeContentType = $this->_getMimeType($filename); 
				if(isset($temMimeContentType)  && !empty($temMimeContentType))	{ 
					$mimeContentType = $temMimeContentType;
				}			    
				if(ini_get('zlib.output_compression'))
				ini_set('zlib.output_compression', 'Off');
				header("Pragma: public"); // required
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false); // required for certain browsers 
				header("Content-Type: " . $mimeContentType );
				// change, added quotes to allow spaces in filenames, by Rajkumar Singh
				header("Content-Disposition: attachment; filename=\"Total_apps_merchantApi_2013_10_12.zip" );
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($filename));
				readfile($filename);
				exit();		
										
			}else{
				echo "File Not Exist..";die;
			}
	  }

}