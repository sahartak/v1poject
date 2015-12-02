<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}

$_SESSION['admin']['selected_tab'] = 6;
unset($_SESSION['admin']['uedit']);

if(isset($_POST['_form_submit'])) {
    $connection = new DBConnection();
    $settings = new App\Model\Settings($connection, 'front_other');
    
    foreach ($_POST['options'] as $name => $value){
        $settings->update($name, $value);
    }
    
    header('Location: settings_other.php');
    exit();
}

$connection = new DBConnection();
$settings = new App\Model\Settings($connection, 'front_other');

$view = new App\View\View('settings/other');
$view->settings = $settings->getAll();

page_header();
echo $view->render();
page_footer();