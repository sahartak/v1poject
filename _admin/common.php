<?php
require_once('includes/constants.php');

require_once('includes/ulogin/config/all.inc.php');
require_once('includes/ulogin/main.inc.php');

require_once ('../classes/db.class.php');
require_once ('../includes/timefix.php');
require_once ('../includes/global_funcs.php');
require_once ('globalvars.php');

require_once('includes/auth.php');

/**
 * Translation function
 *
 * @param $string		What to translate
 * @return mixed
 */
include ('../lang/english.php');
function getLang($string) {

	global $lang;
	
	$display_translation=$lang[$string];
    
    $admin = array_get($_SESSION, 'admin', array());
	
	/** Search if we need to replace something in the translation **/
	$search_for = array('{adminid}', '{adminnames}');
	$replace_with = array(''.array_get($admin, 'adminid').'', ''.array_get($admin, 'name').'');
	$display_translation=str_replace($search_for, $replace_with, $display_translation);
	
	return $display_translation;
}

/**
 * Common function to view arrays in good looking way
 * @param array		array to paste
 * @return mixed
 */
function pre($string) {

	echo '<pre>';
	print_r($string);
	echo '</pre>';
}

/**
 * Function to Open and Read File
 * @param string		file to read
 * @return mixed
 */
function OaRFile($file) {
	$openFile=fopen($file, "r");
	$contents=fread($openFile, filesize($file));
	fclose($openFile);
	
	return $contents;
}

/**
 * Function to Open and Write in File
 * @param 	string		file to write
 * @param 	string		what to write
 */
function OaWFile($file, $newContent) {
	$openFile=fopen($file, "w");
	fwrite($openFile, $newContent);
	fclose($openFile);
}

/**
 * Function to convert trade dates
 */
function convertTradeDates($date) {
	$m=date('n', $date);
	switch ($m) {
		case 1 :
			$d='G';
			break;
		case 2 :
			$d='H';
			break;
		case 3 :
			$d='J';
			break;
		case 4 :
			$d='K';
			break;
		case 5 :
			$d='M';
			break;
		case 6 :
			$d='N';
			break;
		case 7 :
			$d='Q';
			break;
		case 8 :
			$d='U';
			break;
		case 9 :
			$d='V';
			break;
		case 10 :
			$d='X';
			break;
		case 11 :
			$d='Z';
			break;
		case 12 :
			$d='F';
			break;
	}
	
	return $d.date('y', $date+20*DAY);
}
?>