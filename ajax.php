<?php
require 'vendor/autoload.php';

require_once('common.php');

if (isset($_REQUEST['ajax']) && isset($_REQUEST['action'])) {
    
    $connection = new DBConnection();
    
    require_once 'includes/ajax_actions.php';
    $ajax = new AjaxActions($connection);
    
    call_user_func(array($ajax, $_REQUEST['action']));
    
}