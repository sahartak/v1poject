<?php
require_once('template.php');
require_once('sendwithus/lib/API.php');
use sendwithus\API;
if(!$_SESSION['admin']['is_logged']) {
    header('Location: index.php');
    exit();
}

$_SESSION['admin']['selected_tab'] = 5;
unset($_SESSION['admin']['uedit']);

$db = new DBConnection();
$templateModel = new App\Model\PdfTemplate($db);

if(isset($_POST['_form_submit'])) {
	if($_POST['template']['pdf_external_id']){
		//if external template provided, no need other content to be saved
		$_POST['template'] = Array('pdf_external_id' => $_POST['template']['pdf_external_id']);
	}
    $templateModel->update($_POST['id'], $_POST['template']);
    
    header('Location: pdf_templates.php');
    exit();
}

$action = array_get($_GET, 'action');
switch ($action) {
    case 'edit':
        $local_template = $templateModel->getRecord($_GET['id']);
        $pdf_external_id = $local_template['pdf_external_id'];
        
		$settings = new App\Model\Settings($db, 'pdf');
		$settings = $settings->getAll();
		
		$selectTemplateHtml = '<option value="">Empty</option>';
		
		if(array_key_exists('pdf_sendwithus_key', $settings) && isset($settings['pdf_sendwithus_key'])){
			$API_KEY = $settings['pdf_sendwithus_key'];
			$tags = explode(',', trim($settings['pdf_sendwithus_tags']));
			$options = array();
			$api = new API($API_KEY, $options);
			$response = $api->emails();
			foreach($response as $template){
				$matched = count(array_filter($tags)) == 0;
			    foreach($tags as $tag){
					if (isset($template->tags) && in_array(trim($tag), $template->tags)) {
						$matched = true;
						break;
				  	}
				}
				if($matched){
					$selected = $pdf_external_id == $template->id ? "selected='selected'" : "";
					$selectTemplateHtml .= "<option value='". $template->id ."'".$selected.">". $template->name ."</option>";
				}
			}
		}
		
		//get variables
		$vars = Array();
		switch($local_template['name']){
			case 'Account summary':
				$userModel = new App\Model\User(new DBConnection());
				
		        $vars = $userModel->getTemplateFields();
				break;
			case 'Stock trade':
				$tradeModel = new App\Model\StockTrades(new DBConnection());
        
		        $vars = $tradeModel->getTemplateFields();
				break;
			case 'Options trade':
				$tradeModel = new App\Model\Trades(new DBConnection());
        
		        $vars = $tradeModel->getTemplateFields();
				break;
			case 'Transfer (deposit)':
			case 'Transfer (withdraw)':
				$transferModel = new App\Model\Transfer(new DBConnection());
        
		        $vars = $transferModel->getTemplateFields();
				break;
			default:
				break;
		}
        
        $view = new App\View\View('pdf_templates/edit');
        $view->template = $local_template;
        $view->selectTemplateHtml = $selectTemplateHtml;
        $view->templateVariables = $vars;
        break;
    default:
        $view = new App\View\View('pdf_templates/list');
        break;
}

page_header();
echo $view->render();
page_footer();