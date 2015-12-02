<?php
define('PROJECT_PATH', dirname(__FILE__) . '/../../');
define('SRC_PATH', PROJECT_PATH . 'src/');

define('UPLOAD_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['REQUEST_URI'])) . '/images/uploads/');
define('UPLOAD_DIR', PROJECT_PATH . 'images/uploads/');

DEFINE('NID', round(hexdec(substr(uniqid(''), 0, 11))/100)-40505050500);
DEFINE('UID', strtoupper(md5(uniqid(''))));

$whoami = explode('/', $_SERVER['PHP_SELF']);
$pagename = $whoami[count($whoami)-1];
DEFINE('THISPAGE', $pagename);