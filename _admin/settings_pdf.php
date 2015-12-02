<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}

$_SESSION['admin']['selected_tab'] = 5;
unset($_SESSION['admin']['uedit']);

if(isset($_POST['_form_submit'])) {
    $uploadConfig = array(
        'path' => UPLOAD_DIR,
        'ext_whitelist' => array('jpg', 'jpeg', 'gif', 'png'),
        'auto_process' => true
    );
    
    $connection = new DBConnection();
    $settings = new App\Model\Settings($connection, 'pdf');
    
    $upload = new Fuel\Upload\Upload($uploadConfig);
    
    if (count($upload->getValidFiles()) > 0) {
        foreach(new DirectoryIterator(UPLOAD_DIR) as $file) {
            if (!$file->isDot()) {
                unlink($file->getRealPath());
            }
        }
        
        $upload->save();
        
        $_POST['options']['pdf_logo'] = $upload->current()->filename;
    }
    
    foreach ($_POST['options'] as $name => $value){
        $settings->update($name, $value);
    }
    
    header('Location: settings_pdf.php');
    exit();
}

$connection = new DBConnection();
$settings = new App\Model\Settings($connection, 'pdf');

$view = new App\View\View('settings/pdf');
$view->settings = $settings->getAll();
$view->uploadUrl = UPLOAD_URL;

page_header();
echo $view->render();
page_footer();