<?php
// TIME
DEFINE('GMTDIFF', substr(date('O'),1,2)); // DO NOT EDIT
DEFINE('GMTTIME', time() - GMTDIFF*3600); // DO NOT EDIT
DEFINE('CUSTOMTIME', GMTTIME + 9*3600); // YOU CAN CHANGE THIS. Example: DEFINE('CUSTOMTIME', GMTTIME + 2*3600); 2*3600 means 2 hours ahead GMT -8 = DEFINE('CUSTOMTIME', GMTTIME -  8*3600)
DEFINE('DAY', 24*60*60);
?>