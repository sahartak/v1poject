<?php
/* @var $ulogin uLogin */
require_once ('template.php');
if (!$_SESSION['admin']['is_logged']){
	header('Location: index.php');
	exit();
}

$_SESSION['admin']['selected_tab'] = 8;
unset($_SESSION['admin']['uedit']);

if (isset($_POST['_form_submit'])){
	$db = new DBConnection();
	if (isset($_POST['adid']) && $_POST['adid'] > 0){
        if (!empty($_POST['password'])) {
            $ulogin->SetPassword($_POST['adid'], $_POST['password']);
        }
        
        if ($_POST['status'] == 0) {
            $block = date_format(new DateTime('+100 years'), UL_DATETIME_FORMAT);
        }
        else {
            $block = date_format(new DateTime('-1 day'), UL_DATETIME_FORMAT);
        }
        
		$query = '
            UPDATE ul_logins
            SET
                username="'.$db->string_escape($_POST['username']).'",
                name="'.$db->string_escape($_POST['name']).'", email="'.$db->string_escape($_POST['email']).'", 
                contacts="'.$db->string_escape($_POST['contacts']).'", notes="'.$db->string_escape($_POST['notes']).'", 
                block_expires="'.$block.'", type="'.$_POST['type'].'" WHERE id='.($_POST['adid']+0).'';
		$db->rq($query);
		
		addLog('Back-end','Back-end users',''.$_POST['name'].' ('.$_POST['ref'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Admin edited');
	} else {
        if ($ulogin->CreateUser($_POST['username'], $_POST['password'])){
            $uid = $ulogin->Uid($_POST['username']);
            
            if ($_POST['status'] == 0) {
                $block = date_format(new DateTime('+100 years'), UL_DATETIME_FORMAT);
            }
            else {
                $block = date_format(new DateTime('-1 day'), UL_DATETIME_FORMAT);
            }
            
            $query = '
                UPDATE ul_logins
                SET
                    name="'.$db->string_escape($_POST['name']).'", email="'.$db->string_escape($_POST['email']).'", 
                    contacts="'.$db->string_escape($_POST['contacts']).'", notes="'.$db->string_escape($_POST['notes']).'", 
                    block_expires="'.$block.'", ref="'.$_POST['ref'].'", type="'.$_POST['type'].'"
                WHERE id = ' . $uid . '
            ';
            $db->rq($query);
        }
        
		if(!isset($_POST['ref']) || empty($_POST['ref'])) {
            $ref = "ADM" . str_pad($uid, 3, "0", STR_PAD_LEFT);
            
			$query='UPDATE ul_logins SET ref = "' . $ref . '" WHERE id=' . $uid . '';
			$db->rq($query);
		} else {
			$ref = $_POST['ref'];
		}
		
		addLog('Back-end','Back-end users',''.$_POST['name'].' ('.$ref.')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Admin added');
	}
	
	$db->close();
	header('Location: users_admins.php');
	exit();
}

/**
 * Add new admin action
 * @param int $admins_id
 * @return string
 */
function addNewAdmin($admins_id = 0) {

	if ($admins_id && !isset($_POST['_form_submit'])){
		$_SESSION['admin']['uedit'] = $admins_id;
		$db = new DBConnection();
		$query = 'SELECT * FROM ul_logins WHERE id='.($admins_id+0).'';
		$res = $db->rq($query);
		foreach ($db->fetch($res) as $RowName => $RowValue){
			$FormFieldName = str_replace('adm_', '', $RowName);
			$_POST[$FormFieldName] = $RowValue;
		}
        
        $now = new \DateTime();
        $column = new \DateTime($_POST['block_expires']);
        if ($column > $now) {
            $_POST['status'] = 0;
        }
        else {
            $_POST['status'] = 1;
        }
        
        unset($_POST['password']);
        
		$db->close();
	}
	
	$view = new App\View\View('admin/add');
    $view->admin_id = $admins_id;
    $view->data = $_POST;
        
	return $view->render();
}

/**
 * Admin list
 * @return string
 */
function listAdmins() {
    $view = new App\View\View('admin/list');    
	
	return $view->render();
}

if (isset($_GET['action'])){
	$cmd = $_GET['action'];
}else{
	$cmd = '';
}

if (isset($_POST['_back'])){
    $cmd = '';
}

$page_content='';
switch ($cmd) {
	case 'new' :
		$page_content=addNewAdmin();
		break;
	case 'edit' :
		if (isset($_GET['username']) && array_get($_GET, 'aid', 0) == 0){
			$db = new DBConnection();
			$query = 'SELECT id FROM ul_logins WHERE username="'.$db->string_escape($_GET['username']).'" LIMIT 1';
			$res = $db->rq($query);
			$row = $db->fetch($res);
            
			$_GET['aid'] = $row['id'];
		}
		$page_content = addNewAdmin($_GET['aid']+0);
		break;
	case 'delete' :
		if (isAppLoggedIn()){
            $db = new DBConnection();
			$currentData = $db->getRow('ul_logins', 'id='.($_GET['aid']+0).'');
            
            $ulogin->DeleteUser($_GET['aid']);
			
			addLog('Back-end','Back-end users',''.$currentData['name'].' ('.$currentData['ref'].')',''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Admin deleted');
			
			$db->close();
			header('Location: users_admins.php');
			exit();
		}
		break;
	default :
		$page_content = listAdmins();
		break;
}

page_header();
echo $page_content;
page_footer();