<?php
require_once('template.php');
if(!$_SESSION['admin']['is_logged']) {
	header('Location: index.php');
	exit();
}
$_SESSION['admin']['selected_tab']=5;
page_header();
echo '<div class="mainHolder">';
if(isset($_POST['_submit'])) {
	OaWFile('lang/english.php',$_POST['TAContent']);
	echo '
	<div class="successHolder">'.getLang('hints_trans_success').'</div>';
	addLog('Back-end','Back-end Settings, Translations',0,''.$_SESSION['admin']['name'].' ('.$_SESSION['admin']['refnum'].')','Back-end Translations edited');
}
echo '
	<div class="hintHolder ui-state-default"><b>'.getLang('hints_trans_title').':</b></div> 
	<form name="test" method="POST">
	<textarea name="TAContent">'.OaRFile('lang/english.php').'</textarea>
	<br />
	<input type="submit" name="_submit" value="'.getLang('sform_savebtn').'" class="submitBtn ui-state-default">
	</form>
</div>';

page_footer();
?>