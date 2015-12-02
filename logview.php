<?php

require_once('template.php');

page_header(99);



if($_SESSION['user']['is_logged']==1) {

    echo '

<div class="flat_area grid_16" style="opacity: 1;">
    <h2>'.getLang('log_head').'
        </h2>
    </div>
<div class="flat_area" id="dt1">
<table id="tradesTable" class="datatable">

	<thead>

	<tr>

		<td style="widtd: 50px;"><b>'.getLang('log_num').'</b></td>

        <td><b>'.getLang('log_area').'</b></td>

        <td><b>'.getLang('log_section').'</b></td>

        <td><b>'.getLang('log_user').'</b></td>

        <td><b>'.getLang('log_admin').'</b></td>

        <td><b>'.getLang('log_detail').'</b></td>

        <td><b>'.getLang('log_date').'</b></td>

        <td><b>'.getLang('log_ip').'</b></td>

    </tr>

    </thead>';

    

    $db=new DBConnection();

    $query='SELECT * FROM logs WHERE log_user LIKE "%'.$_SESSION['user']['user_account_num'].'%" ORDER BY logs_id DESC';

    $res=$db->rq($query);

    $count=1;

    while(($row=$db->fetch($res)) != FALSE) {

    	$trclass='odd';

    	if($count % 2 == 1) $trclass='even';

	echo '

	<tr class="'.$trclass.'">

		<td>'.$row['logs_id'].'</td>

		<td>'.$row['log_area'].'</td>

		<td>'.$row['log_section'].'</td>

		<td>'.$row['log_user'].'</td>

		<td>'.$row['log_admin'].'</td>

		<td>'.$row['log_details'].'</td>

		<td>'.$row['log_date'].'</td>

		<td>'.$row['log_ip'].'</td>

	</tr>';

	

		$count++;

    }

    

echo '</table></div>';

}



page_footer();

?>