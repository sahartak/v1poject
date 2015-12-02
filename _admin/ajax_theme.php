<?php
    require_once('template.php');
    require_once('sendwithus/lib/API.php');
    use sendwithus\API;

	$action = $_POST['action'];
	$func = $action;
	$func();

	function GetMailChimpTemplate() {


		$templatId = $_POST['templateId'];
		if ($templatId > 0)
		{
			$api = '7d37f18e2cb12e161253b465d0d46b24-us9';
			$mc = new Mailchimp($api);
			$template = $mc->templates->info($templatId);

			// Get html body
			$d = new DOMDocument;
			$mock = new DOMDocument;
			$d->loadHTML($template['preview']);
			$body = $d->getElementsByTagName('body')->item(0);
			foreach ($body->childNodes as $child){
			    $mock->appendChild($mock->importNode($child, true));
			}

			echo $mock->saveHTML();
		}else{
			echo "";
		}
	}

function GetTemplateById()
{
	$connection = new DBConnection();
	$settingsModel = new App\Model\Settings($connection, 'mail_settings');
    $settings = $settingsModel->getAll();

    $API_KEY = $settings['sendwithus_key'];
    $options = array();
    $api = new API($API_KEY, $options);

    $templateId = $_POST['templateId'];
    if ($templateId != "")
    {
        $response = $api->get_template($templateId);
        $response = $api->get_template($templateId,$response->versions[0]->id);


        // Get html body
        /*
        $d = new DOMDocument;
        $mock = new DOMDocument;
        $d->loadHTML($response->html);
        $body = $d->getElementsByTagName('body')->item(0);
        foreach ($body->childNodes as $child){
            $mock->appendChild($mock->importNode($child, true));
        }
        $response->html = $mock->saveHTML();
        */
        echo json_encode($response);
    }else{
        echo json_encode(array('text'=>'' , 'html' => '','id' => '','name' => ''));
    }
}
	
?>