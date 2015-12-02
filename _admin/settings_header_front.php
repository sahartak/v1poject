<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
	header('Location: index.php');
	exit();
}
$_SESSION['admin']['selected_tab']=6;
page_header();
echo '<div class="mainHolder">';
if(isset($_POST['_submit'])) {
	OaWFile('../includes/custom_header.php',$_POST['TAContent']);
	echo '
	<div class="successHolder">'.getLang('front_header_title_success').'</div>';
	
	addLog('Back-end','Front-end Settings',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Custom header edited');
}
echo '
	<div class="hintHolder ui-state-default"><b>'.getLang('front_header_title').':</b></div> 
	<form name="test" method="POST">
	<textarea name="TAContent">'.OaRFile('../includes/custom_header.php').'</textarea>
	<br />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default">
	</form>
</div>';

page_footer();
?>