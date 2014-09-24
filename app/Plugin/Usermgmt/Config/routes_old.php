<?php


// Routes for standard actions

Router::connect('/superadmin/login', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'login','superadmin'=>true));
Router::connect('/superadmin/doclist', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'doclist','superadmin'=>true));
Router::connect('/superadmin/search', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'search','superadmin'=>true));
Router::connect('/superadmin/agent/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'agent','superadmin'=>true));
Router::connect('/superadmin/iso/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'iso','superadmin'=>true));
Router::connect('/superadmin/manager/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'manager','superadmin'=>true));
Router::connect('/superadmin/processor/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'processor','superadmin'=>true));
Router::connect('/superadmin/referal/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'referal','superadmin'=>true));



Router::connect('/superadmin/notes/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'notes','superadmin'=>true));
Router::connect('/superadmin/logout', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'logout','superadmin'=>true));
Router::connect('/superadmin/forgotPassword', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'forgotPassword','superadmin'=>true));
Router::connect('/superadmin/activatePassword/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'activatePassword','superadmin'=>true));
Router::connect('/superadmin/register', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'register','superadmin'=>true));
Router::connect('/superadmin/changePassword', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'changePassword','superadmin'=>true));
Router::connect('/superadmin/changeUserPassword/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'changeUserPassword','superadmin'=>true));
Router::connect('/superadmin/addUser', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'addUser','superadmin'=>true));
Router::connect('/superadmin/editUser/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'editUser','superadmin'=>true));
Router::connect('/superadmin/deleteUser/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'deleteUser','superadmin'=>true));

Router::connect('/superadmin/viewUser/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'viewUser','superadmin'=>true));

Router::connect('/superadmin/userVerification/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'userVerification','superadmin'=>true));
Router::connect('/superadmin/allUsers', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'index','superadmin'=>true));
Router::connect('/superadmin/dashboard', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'dashboard','superadmin'=>true,'superadmin'=>true));

Router::connect('/superadmin/permissions', array('plugin' => 'usermgmt', 'controller' => 'user_group_permissions', 'action' => 'index','superadmin'=>true));

Router::connect('/superadmin/update_permission', array('plugin' => 'usermgmt', 'controller' => 'user_group_permissions', 'action' => 'update','superadmin'=>true));
Router::connect('/superadmin/accessDenied', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'accessDenied','superadmin'=>true));
Router::connect('/superadmin/myprofile', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'myprofile','superadmin'=>true));

Router::connect('/superadmin/allGroups', array('plugin' => 'usermgmt', 'controller' => 'user_groups', 'action' => 'index','superadmin'=>true));

Router::connect('/superadmin/addGroup', array('plugin' => 'usermgmt', 'controller' => 'user_groups', 'action' => 'addGroup','superadmin'=>true));


Router::connect('/superadmin/editGroup/*', array('plugin' => 'usermgmt', 'controller' => 'user_groups', 'action' => 'editGroup','superadmin'=>true));
Router::connect('/superadmin/deleteGroup/*', array('plugin' => 'usermgmt', 'controller' => 'user_groups', 'action' => 'deleteGroup','superadmin'=>true));

//amit
Router::connect('/superadmin/userajax/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'userajax','superadmin'=>true));