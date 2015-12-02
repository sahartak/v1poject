<?php
require_once ('template.php');

if (!$_SESSION['admin']['is_logged']){
	header('Location: index.php');
	exit();
}

$_SESSION['admin']['selected_tab'] = 4;
unset($_SESSION['admin']['uedit']);

$connection = new DBConnection();
$stockModel = new App\Model\Stocks($connection);

$action = array_get($_GET, 'action');
switch($action) {
    case 'ajax_details':
        $details = $stockModel->getDetails($_GET['id']);
        echo json_encode($details);
        break;
    case 'ajax_create':
        $result = $stockModel->createDetail($_POST['stock'], $_POST);
        
        if ($result) {
            $array = array('result' => true, 'detail' => $stockModel->getDetail($result));
        }
        else {
            $array = array('result' => false);
        }
        
        echo json_encode($array);
        break;
    case 'ajax_edit':
        $result = $stockModel->editDetailField($_POST['id'], $_POST['type'], $_POST['value']);
        
        if ($result) {
            $detail = $stockModel->getDetail($_POST['id']);
            $array = array('result' => true, 'value' => $detail[$_POST['type']]);
        }
        else {
            $array = array('result' => false);
        }
        
        echo json_encode($array);
        break;
    default:
        $page = new App\View\View('stocks/edit');
        $page->stocks = $stockModel->getList();
        break;
}

if (substr($action, 0, 4) == 'ajax') {
    die();
}

page_header();
echo $page->render();
page_footer();