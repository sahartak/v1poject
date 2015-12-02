<?php
require_once('template.php');

$_SESSION['admin']['selected_tab'] = 9;

page_header();
if(array_get($_SESSION['admin'], 'is_logged') == 1) {
    echo 'work in progress...';
}

page_footer();
?>