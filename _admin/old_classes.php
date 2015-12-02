<?php
// return number of records
//******************************************************************************************
function get_nof_rec($strtable, $strcond='', $strsel='*') {

	if ($strcond){
		$strcond=' WHERE '.$strcond;
	}
	$sql='SELECT * FROM '.$strtable.$strcond;
	$rs=mysql_query($sql);
	return mysql_num_rows($rs);
}
//******************************************************************************************


// return first value
//******************************************************************************************
function get_first_value($strfield, $strtable, $strcond='', $desc='') {

	if ($strcond){
		$strcond=' WHERE '.$strcond;
	}
	$sql="SELECT $strfield FROM $strtable $strcond ORDER BY $strfield $desc";
	$rs=mysql_query($sql);
	@$row=mysql_fetch_assoc($rs);
	return $row?$row[$strfield]:0;
}
//******************************************************************************************


// check if id belongs to the table
//******************************************************************************************
function is_record($strtable, $strid) {

	$field_id=substr($strtable, 0, -1).'_id';
	$sql="SELECT $field_id FROM $strtable WHERE $field_id=$strid";
	$rs=mysql_query($sql);
	return mysql_num_rows($rs);
}
//******************************************************************************************


// check if number
//******************************************************************************************
function is_num_type($strtype, $is_float=0) {

	// 'int', 'real' are the db field type name given by php
	// 'float' & 'num' are specific
	$types=$is_float?array('float', 'real'):array('int', 'real', 'float', 'num');
	return in_array(strtolower($strtype), $types);
}
//******************************************************************************************


// format data before insertint into DB
//******************************************************************************************
function set_insql($anyval, $strtype='string') {

	// add slashes if magic quotes configuration off
	$anyval=get_magic_quotes_gpc()?$anyval:addslashes($anyval);
	$strtype=strtolower($strtype);
	
	switch ($strtype) {
		case 'int' :
			// replace non number by '' using following pattern:
			// [^0-9\-\.] => everything except 0->9,'.' and '-'
			$anyval=preg_replace("'[^0-9\-\.]'", '', $anyval);
			return ($anyval)?round($anyval):0; // round value if float is given
			break;
		case 'real' :
			$anyval=preg_replace("'[^0-9\-\.]'", '', $anyval);
			return ($anyval)?floatval($anyval):0;
			break;
		default :
			// add ' on both ends of the string, or NULL if empty
			return ($anyval)?"'$anyval'":'NULL';
	}
}
//******************************************************************************************


// get type (from the 'type' table)
//******************************************************************************************
function get_type_value($strcat, $inttype='_default_') {

	$sql='SELECT type_value, type_short FROM types WHERE type_category=\''.$strcat.'\' ORDER BY type_ref';
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	do{
		$array[$row['type_short']]=$row['type_value'];
	}while ($row=mysql_fetch_assoc($rs));
	mysql_free_result($rs);
	return ($inttype='_default_')?$array:$array[$inttype];
}
//******************************************************************************************


// get status (get array if no 2nd parameter)
//******************************************************************************************
function get_status_label($strtable, $intstatus=9999) {

	$sql='SELECT status_num, status_label FROM status WHERE status_table=\''.$strtable.'\' ORDER BY status_order';
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	do{
		$array[$row['status_num']]=$row['status_label'];
	}while ($row=mysql_fetch_assoc($rs));
	mysql_free_result($rs);
	
	return ($intstatus==9999)?$array:$array[$intstatus];
}
//******************************************************************************************


// create a full html page
//******************************************************************************************
function html_page($strtitle, $htm_body) {

	print('<html><head><title>'.$strtitle.'</title>');
	print("\r".'<style type="text/css">');
	print("\r".'body { font-family: Arial, Helvetica, sans-serif; color:#333333; font-size: 11px; }');
	print("\r".'b { color:#333333; font-size: 12px; }');
	print("\r".'input { font-family: Arial, Helvetica, sans-serif; color: #333333; width: 100px; font-size: 11px; }');
	print('</style></head><body><center><br/><br/><br/>');
	print("\r".$htm_body);
	print("\r".'<br/><br/><br/></center></body></html>');
}
//******************************************************************************************


function set_account_vis($int_account_id, $int_admin_id, $is_visible) {

	$admin=new Admin($int_admin_id);
	$string=str_replace('a'.$int_account_id, '', $admin->admin_accounts);
	if ($is_visible||($int_admin_id==1)){
		$string.='a'.$int_account_id;
	}
	$admin->add_field('admin_accounts', $string);
	$admin->sql_upd();
}

function read_file($strfile) {

	if (is_file($strfile)){
		ob_start();
		include $strfile;
		$contents=ob_get_contents();
		ob_end_clean();
		$contents=str_replace("\n", '', $contents);
		$contents=str_replace("\r", '', $contents);
		return $contents;
	}
	return $strfile.' not found';
}

function ins_log($isadmin, $intacc, $strtype, $strdetails, $intrel=0, $numval=0, $strval='') {

	global $User;
	$UpdLog=new Log();
	$UpdLog->add_field('log_account', $intacc);
	$UpdLog->add_field('log_admin', $isadmin);
	$UpdLog->add_field('log_type', $strtype);
	$UpdLog->add_field('log_details', $strdetails);
	$UpdLog->add_field('log_user', $User->admin_name);
	$UpdLog->add_field('log_relid', $intrel);
	$UpdLog->add_field('log_valnum', $numval);
	$UpdLog->add_field('log_valstr', $strval);
	$UpdLog->sql_ins(NID);
}

function get_file($strpath) {

	$path=str_replace('\\', '/', $strpath);
	$array=explode('_admin/', $path);
	return $array[1];
}

function get_path($strpath) {

	$array=explode('/', get_file($strpath));
	$file=$array[count($array)-1];
	return str_replace($file, '', get_file($strpath));
}
function get_rel($strpath) {

	$strpath=get_path($strpath);
	$rel=str_repeat('../', substr_count($strpath, '/')-1);
	return $rel.$strpath;
}

function send_mail($to, $subject, $message) {

	$headers='MIME-Version: 1.0'."\n";
	$headers.='Content-type: text/html;'."\n";
	$headers.='From: '.PRODUCT_NAME.' Trading Support<'.MAIL_SUPPORT.'>'."\n";
	$headers.='Bcc: '.MAIL_BCC;
	mail(trim($to), trim($subject), $message, $headers);
	echo $headers;
}

//******************************************************************************************
function get_trading_value($intaccount, $type=1) {

	$sql="SELECT trade_order, trade_value FROM trades WHERE trade_status>0 AND trade_order=$type AND 

trade_account=$intaccount";
	$rs=mysql_query($sql);
	$total=0;
	if ($rs){
		$row=mysql_fetch_assoc($rs);
		do{
			$total+=$row['trade_value'];
		}while ($row=mysql_fetch_assoc($rs));
		mysql_free_result($rs);
	}
	return $type*$total;
}

//******************************************************************************************
function get_trading_fees($intaccount) {

	$sql="SELECT trade_fees FROM trades WHERE trade_status>0 AND trade_account=$intaccount";
	$rs=mysql_query($sql);
	$total=0;
	if ($rs){
		$row=mysql_fetch_assoc($rs);
		do{
			$total+=$row['trade_fees'];
		}while ($row=mysql_fetch_assoc($rs));
		mysql_free_result($rs);
	}
	return $total;
}

//******************************************************************************************
function get_trading_balance($intaccount) {

	$sql='SELECT trade_order, trade_total FROM trades WHERE trade_status>0 AND trade_account='.$intaccount;
	$rs=mysql_query($sql);
	$total=0;
	if ($rs){
		$row=mysql_fetch_assoc($rs);
		do{
			$total+=$row['trade_order']*$row['trade_total'];
		}while ($row=mysql_fetch_assoc($rs));
		mysql_free_result($rs);
	}
	return $total;
}

//******************************************************************************************
function get_funding_value($intaccount, $type=1) {

	$sql="SELECT fund_type, fund_value FROM funds WHERE fund_status>0 AND fund_type=$type AND 

fund_account=$intaccount";
	$rs=mysql_query($sql);
	$total=0;
	
	if ($rs){
		$row=mysql_fetch_assoc($rs);
		do{
			$total+=$row['fund_value'];
		}while ($row=mysql_fetch_assoc($rs));
		mysql_free_result($rs);
	}
	return $type*$total;
}

// ******************************************************************************************
function get_funding_fees($intaccount) {

	$sql="SELECT fund_fees FROM funds WHERE fund_status>0 AND fund_account=$intaccount";
	$rs=mysql_query($sql);
	$total=0;
	if ($rs){
		$row=mysql_fetch_assoc($rs);
		do{
			$total+=$row['fund_fees'];
		}while ($row=mysql_fetch_assoc($rs));
		mysql_free_result($rs);
	}
	return $total;
}

//******************************************************************************************
function get_funding_balance($intaccount) {

	$sql='SELECT fund_type, fund_total FROM funds WHERE fund_status>0 AND fund_account='.$intaccount;
	$rs=mysql_query($sql);
	$total=0;
	if ($rs){
		$row=mysql_fetch_assoc($rs);
		do{
			$total+=$row['fund_type']*$row['fund_total'];
		}while ($row=mysql_fetch_assoc($rs));
		mysql_free_result($rs);
	}
	return $total;
}

// return total account balance
//******************************************************************************************
function get_balance($intaccount) {

	$balance=get_funding_value($intaccount, 1)+get_funding_value($intaccount, -1)+get_trading_value($intaccount, 1)+get_trading_value($intaccount, -1)-get_trading_fees($intaccount)-get_funding_fees($intaccount);
	return $balance;
}

//******************************************************************************************
function get_total_options($intaccount) {

	$sql='SELECT trade_pos FROM trades WHERE trade_status>0 AND trade_order=-1 AND 

trade_account='.$intaccount;
	$rs=mysql_query($sql);
	$total=0;
	if ($rs){
		$row=mysql_fetch_assoc($rs);
		do{
			$total+=$row['trade_pos'];
		}while ($row=mysql_fetch_assoc($rs));
		mysql_free_result($rs);
	}
	return $total;
}

function upd_account($intaccount=0) {

	if (empty($intaccount)){
		$intaccount=$_SESSION['clid'];
	}
	
	$sql='SELECT trade_id FROM trades WHERE trade_account='.$intaccount;
	$rs=mysql_query($sql);
	$nof_trades=mysql_num_rows($rs);
	$Acc=new Account($intaccount);
	$Adv1=new Advisor($Acc->account_adv1);
	$Acc->add_field('account_adv1_ref', $Adv1->advisor_ref);
	$Adv2=new Advisor($Acc->account_adv2);
	$Acc->add_field('account_adv2_ref', $Adv2->advisor_ref);
	$Acc->add_field('account_valdate', $Acc->account_add);
	$Acc->add_field('account_trades', $nof_trades);
	$status=(($nof_trades>2)&&($Acc->account_status>1))?9:$Acc->account_status;
	$Acc->add_field('account_status', $status);
	$Acc->add_field('account_lcsp', get_lcsp($intaccount));
	$Acc->add_field('account_hpsp', get_hpsp($intaccount));
	$Acc->add_field('account_balance', get_balance($intaccount));
	$Acc->add_field('account_trades', get_nof_rec('trades', 'trade_account='.$intaccount.' AND trade_status>0'));
	$Acc->add_field('account_lastfnd', get_first_value('fund_valdate', 'funds', 'fund_account='.$intaccount, 'DESC'));
	$Acc->add_field('account_lasttrd', get_first_value('trade_valdate', 'trades', 'trade_account='.$intaccount, 'DESC'));
	$Acc->add_field('account_options', get_total_options($intaccount));
	$Acc->sql_upd();

}

function upd_buy($intbuy) {

	$Upd=new Trade($intbuy);
	if ($Upd->trade_order<0){
		$sql='SELECT trade_pos FROM trades WHERE trade_order=1 AND trade_status>0 AND 

trade_relid='.$intbuy;
		$rs=mysql_query($sql);
		@$row=mysql_fetch_assoc($rs);
		$pos=0;
		if ($row){
			do{
				$pos+=$row['trade_pos'];
			}while ($row=mysql_fetch_assoc($rs));
		}
		$posleft=$Upd->trade_pos-$pos;
		if ($Upd->trade_status>0){
			if ($posleft==0){
				$status=2;
			}elseif ($posleft==$Upd->trade_pos){
				$status=4;
			}else{
				$status=3;
			}
			
			$sql='UPDATE trades SET trade_status='.$status.',trade_posleft='.$posleft.' WHERE trade_id='.$intbuy;
			mysql_query($sql);
		}
	}

}

// return highest PUT strike price of an account
//******************************************************************************************
function get_hpsp($intid) {

	$sql="SELECT trade_sp FROM trades WHERE trade_option=1 AND trade_account=$intid ORDER BY trade_sp DESC";
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	return $row['trade_sp'];
}

// return lowest CALL strike price of an account
//******************************************************************************************
function get_lcsp($intid) {

	$sql="SELECT trade_sp FROM trades WHERE trade_option=-1 AND trade_account=$intid ORDER BY trade_sp";
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	return $row['trade_sp'];
}

function get_transaction_type($intid) {

	$sql='SELECT trade_id, trade_order FROM trades WHERE trade_id='.$intid;
	$rs=mysql_query($sql);
	if ($rs){
		$row=mysql_fetch_assoc($rs);
		return ($row['trade_order']==1)?'Sell Contract':'Buy Contract';
	}else{
		$sql='SELECT fund_id, fund_type FROM funds WHERE trade_id='.$intid;
		$rs=mysql_query($sql);
		if ($rs){
			$row=mysql_fetch_assoc($rs);
			return ($row['fund_type']==1)?'Deposit Fund':'Withdrawal';
		}else{
			return 'Not a valid transaction';
		}
	}

}

// FORWARDING SCRIPT
function mk_jfw($url_fw) {

	return "<script>\n<!--\nlocation='$url_fw';\n//-->\n</script>";
}

// MAKE A JAVASCRIPT
function mk_js($strjs) {

	return "<script>\n<!--\n$strjs\n//-->\n</script>";
}

// MAKE JAVASCRIPT LINK
function mk_jlink($strtext, $strurl, $strfn='go', $strmsg='', $intarrow=0, $strclass='') {

	$script="function $strfn() { ";
	$script.=$strmsg?'if (confirm(\''.$strmsg.'\')) ':'';
	$script.="location='$strurl' }";
	return mk_js($script).mk_link($strtext, 'javascript:'.$strfn.'()', $intarrow, $strclass);
}

// MAKE  A JAVASCRIPT FUNCTION 
function mk_jfn($strfn, $js_body, $strarg='') {

	return mk_js("function $strfn($strarg) {\n$js_body\n}");
}

// MAKE A JAVASCRIPT FIELD CHECK
function mk_jchk($strform, $arr_fields, $strmsg='', $strfn='chkForm') {

	$code="  document.value = true; ff = document.form_$strform;\n  ";
	foreach ($arr_fields as $field){
		$code.='if ('.$field['arg'].') {'."\n".'    alert(\''.$field['msg'].'\');'."\n".'    '.$field['field'].'.focus();'."\n".'    document.value = false;'."\n".'  } else ';
	}
	if ($strmsg){
		$code.='if (!confirm(\''.$strmsg.'\') {'."\n".'    document.value = false;'."\n".'  }'."\n";
	}else{
		$code=substr($code, 0, -6);
	}
	$code.=' else if (isSubmit==1) { ff.submit(); } ;';
	
	return mk_jfn($strfn, $code, 'isSubmit');
}

// MAKE ARRAY FOR FIELD CHECK
function set_check_arr($strfield, $strmsg, $strarg='', $is_arg=0) {

	if (''==$strarg){
		$strarg="''== trim(ff.$strfield.value)";
	}else{
		$strarg=$is_arg?$strarg:"$strarg == ff.$strfield.value";
	}
	$array['arg']=$strarg;
	$array['msg']=$strmsg;
	$array['field']="ff.$strfield";
	return $array;
}

// show array pictures if needed
function shw_pic($strimg, $anyval1, $anyval2) {

	return ($anyval1==$anyval2)?'<img src="'.$strimg.'" border="0" align="absmiddle" />':'';
}

function get_num($anyval) {

	$anyval=preg_replace("'[^0-9\-\.]'", '', $anyval);
	return ($anyval)?floatval($anyval):0;
}

function get_time_approx($intsec, $strNaN='Never') {

	if ($intsec>25*365*DAY){
		return $strNaN;
	}elseif ($intsec<0){
		return 'NA';
	}elseif ($intsec<HOUR){
		$min=round($intsec/60);
		return $min.' min';
	}elseif ($intsec<10*HOUR){
		$hour=floor($intsec/HOUR);
		$min=floor(($intsec%HOUR)/60);
		if ($min<10){
			$min='0'.$min;
		}
		return $hour.'h'.$min.'m';
	}elseif ($intsec<DAY){
		$hour=round($intsec/HOUR);
		return $hour.' hrs';
	}elseif ($intsec<30*DAY){
		$day=round($intsec/DAY);
		$day.=($day==1)?' day':' days';
		return $day;
	}elseif ($intsec<90*DAY){
		return round($intsec/(7*DAY)).' weeks';
	}elseif ($intsec<365*DAY){
		return round($intsec/(30*DAY)).' months';
	}else{
		return round($intsec/(365*DAY)).' years';
	}
}

function get_trade_date($inttime=0) {

	if (empty($inttime)){
		$inttime=TIME;
	}
	$m=date('n', $inttime+20*DAY);
	switch ($m) {
		case 1 :
			$d='F';
			break;
		case 2 :
			$d='G';
			break;
		case 3 :
			$d='H';
			break;
		case 4 :
			$d='J';
			break;
		case 5 :
			$d='K';
			break;
		case 6 :
			$d='M';
			break;
		case 7 :
			$d='N';
			break;
		case 8 :
			$d='Q';
			break;
		case 9 :
			$d='U';
			break;
		case 10 :
			$d='V';
			break;
		case 11 :
			$d='X';
			break;
		case 12 :
			$d='Z';
			break;
	}
	
	return $d.date('y', $inttime+20*DAY);
}

function get_time_from($strname='') {

	if ($strname){
		$strname.='_';
	}
	$dd=$strname.'dd';
	$mm=$strname.'mm';
	$yy=$strname.'yy';
	return mktime(0, 0, 0, $_POST[$mm], $_POST[$dd], $_POST[$yy]);
}

function get_format($numval, $iscolor=0, $strcur='', $intdec=2, $isabs=0, $strsepdec='.', $strsepthsnd=',') {

	$num=($isabs&&($numval<0))?-$numval:$numval;
	if ($intdec<0){
		$array=explode('.', $numval);
		$intdec=strlen($array[1]);
	}
	
	$code=$strcur.number_format($num, $intdec, $strsepdec, $strsepthsnd);
	if ($iscolor){
		$code=($numval<0)?'<span class="red">'.$code.'</span>':'<span class="green">'.$code.'</span>';
	}
	return $code;

}

function get_group($strid, $strsep) {

	$array=explode('_', $strid);
	if (count($array)){
		foreach ($array as $val){
			if ($val){
				$name.=get_singlegroup($val).'<br />';
			}
		}
	}else{
		$name=get_singlegroup($strid);
	}
	
	return $name;
}

function get_trunc($strtxt, $intwid) {

	if (strlen($strtxt)<=$intwid){
		return $strtxt;
	}else{
		return substr($strtxt, 0, $intwid).'...';
	}
}

function mk_ref($intseed, $r1='C', $r2='D', $r3='E', $r4='F') {

	// $intseed = $intseed + 100;
	if ($intseed<1000){
		$letter=$r1;
		$refnum=str_pad($intseed, 3, '0', STR_PAD_LEFT);
	}elseif ($seed<2000){
		$letter=$r2;
		$refnum=str_pad($intseed-1000, 3, '0', STR_PAD_LEFT);
	}elseif ($seed<3000){
		$letter=$r3;
		$refnum=str_pad($intseed-2000, 3, '0', STR_PAD_LEFT);
	}else{
		$letter=$r4;
		$refnum=str_pad($intseed-3000, 3, '0', STR_PAD_LEFT);
	}
	return $letter.$refnum;
}

function mk_mail_var($strfile) {

	$lines=file('$strfile');
	foreach ($lines as $line_num=>$line){
		$line=substr("\r", "", $line);
		$line=substr("\n", "", $line);
		
		$code.=htmlspecialchars($line);
	}
	return $code;

}

// make a spacer
function mk_spacer($intwidth=1, $intheight=1) {

	return '<img src="'.IMG_SPACER.'" align="absmiddle" border="0" width="'.$intwidth.'" height="'.$intheight.'" />';
}

// make left menu
function mk_menu($label, $link, $level, $shwuid=0, $logout=0) {

	global $MENULEVEL, $SHWUID;
	$link.=($shwuid)?$SHWUID:'';
	$on=($level==$MENULEVEL); // if current page
	$class=$on?'menu_on':'menu_off';
	$img=$on?'<img src="'.IMG_ARR_RIGHT.'" />':'';
	$click=$logout?"if (confirm('Are you sure that you want to sign out? ')) {location='$link'}":"location='$link'";
	$href=$logout?'#':$link;
	$code='<tr onMouseOver="className=\'menuhover\'" onMouseOut="className=\''.$class.'\';" class="'.$class.'">';
	$code.="\n  ".'<td width="11" height="18" align="left" valign="middle">'.$img.'</td>';
	$code.="\n  ".'<td align="left" valign="middle" onClick="'.$click.'" class="'.$class.'"><a href="'.$href.'">'.$label.'</a></td>';
	$code.="\n".'</tr>';
	return $code;
}

// make line options
function mk_line_options($strlink, $moreover='', $moreout='', $class='') {

	$code="onMouseOver=\"className='hover'; $moreover\" onMouseOut=\"className='$class'; $moreout\" onClick=\"location='$strlink'\"";
	return $code;
}

// make listing options


function mk_list_options($strfile, $strdiv, $intopt, $strtxt, $strquery='') {

	$file=get_file($strfile);
	$strquery='&'.$strquery.'w='.$intopt;
	$w=$_GET['w']?$_GET['w']:0;
	$class=($w==$intopt)?'lnkb':'lnk';
	$code='<input type ="button" class="'.$class.'" value="'.$strtxt.'" onClick="ajpage(\''.$file.$strquery."', '$strdiv')\" onMouseOver=\"className='lnkh'\" onMouseOut=\"className='".$class."'\" style=\"padding: 1px 2px 1px 2px\" />";
	
	return $code;
}

//make table option
function mk_bold($strtext, $strcond='') {

	if ($strcond){
		$strtext="<b>$strtext</b>";
	}
	return $strtext;
}

//make column sort
function mk_sort($strfile, $strtxt, $strorder, $strobj='listing') {

	$file=get_file($strfile);
	$file.=$_GET['w']?'&w='.$_GET['w']:'&w=0';
	$file.=$_GET['a']?'&a='.$_GET['a']:'&a=0';
	$file.='&o='.$strorder;
	$desc=$_GET['d']?-1*$_GET['d']:-1;
	$file.='&d='.$desc;
	if ($_GET['o']==$strorder){
		$img=($_GET['d']<0)?IMG_SORT_UP:IMG_SORT_DWN;
		$img='<img src="'.$img.'" border="0" align="absbottom" />';
	}else{
		$img="";
	}
	return "<div onClick=\"ajpage('$file','$strobj')\" onMouseOver=\"className='hover'\" onMouseOut=\"className=''\">$strtxt$img</div>";
}

// SEPARATION 
function mk_sep($is_sep=0, $intspace=2) {

	$code=str_repeat('&nbsp;', $intspace);
	return $is_sep?$code.'|'.$code:$code;
}

// MAKE STRONG
function mk_strong($strtext, $is_strong) {

	return $is_strong?"<strong>$strtext</strong>":$strtext;
}

// MAKE <A> LINK
function mk_link($strtext, $strurl, $intarrow=0, $strstatus='default', $strclass='', $js_over='', $is_new=0) {

	// add arrow if needed
	if ($intarrow>0){
		$strtext.='&nbsp;&raquo;';
	}else if ($intarrow>0){
		$strtext='&laquo;&nbsp;'.$strtext;
	}
	
	if ($strclass){
		$strclass=' class="'.$strclass.'"'; // set class if needed
	}
	
	$is_new=$is_new?' target="_blank"':''; // open in new window
	

	if ($js_over||('default'!=$strstatus)){
		$onover=' onMouseOver="';
		$onover.=($js_over)?$js_over.';':'';
		$onover.=('default'==$strstatus)?'"':'window.status=\''.$strstatus.'\';return true'.'" onMouseOut="window.status=\'\'"';
	}else{
		$onover='';
	}
	
	return '<a href="'.$strurl.'"'.$strclass.$onover.$is_new.'>'.$strtext.'</a>';
}

// MAKE FORM OPTIONS
function mk_form_options($strname='xform', $strlink=0, $js_submit='chkForm(1);return document.value;') {

	global $Current;
	if (empty($strlink)){
		$strlink=$Current->post;
	}
	$onsubmit=$js_submit?' onSubmit="'.$js_submit.'"':'';
	return 'name="form_'.$strname.'" action="'.$strlink.'" method="post"'.$onsubmit;
}

// MAKE A BUTTON
function mk_button($strlabel, $js_event, $strtype='button', $intwidth=100, $inth=7, $intv=7) {

	return '<input type="'.$strtype.'" name="'.str_replace(' ', '_', strtolower($strlabel)).'"'.' value="'.$strlabel.'" onClick="'.$js_event.'" class="button"'.' style="width:'.$intwidth.'px;margin:'.$intv.'px '.$inth.'px '.$intv.'px '.$inth.'px" />';
}
function mk_submit($strlabel='Submit', $intwidth=100, $inth=7, $intv=7, $js_event='') {

	$js_event=$js_event?' onClick="'.$js_event.'"':'';
	return '<input type="submit" name="'.str_replace(' ', '_', strtolower($strlabel)).'"'.' value="'.$strlabel.'"'.$js_event.' class="button"'.' style="width:'.$intwidth.'px;margin:'.$intv.'px '.$inth.'px '.$intv.'px '.$inth.'px" />';
}
function mk_reset($strlabel='Reset', $intwidth=100, $inth=7, $intv=7, $js_event='') {

	$js_event=$js_event?' onClick="'.$js_event.'"':'';
	return '<input type="reset" name="'.str_replace(' ', '_', strtolower($strlabel)).'"'.' value="'.$strlabel.'"'.$js_event.' class="button"'.' style="width:'.$intwidth.'px;margin:'.$intv.'px '.$inth.'px '.$intv.'px '.$inth.'px" />';
}

// MAKE A INPUT FIELD
function mk_input($strname, // input name
$anyval='', //  value
$strtype='txt', // value type
$intwidth=INPUT_WIDTH, $strclass='text', $is_clear=0, $js_onfocus='', $js_onblur='', $stralign='', $strstyle='') {

	// set style & on keyup if num type
	$style=' style="width:'.$intwidth.'px;';
	if (is_num_type($strtype)){
		$style.=$stralign?'text-align:'.$stralign:'text-align:right';
		$style.=';'.$strstyle.'"';
		$onkey=' onKeyUp="';
		$onkey.=(is_int_type($strtype))?'jfIntOnly':'jfFloatOnly';
		$onkey.='(this)"';
	}
	$style.='"';
	
	// set onfocus
	$onfocus=($is_clear||$js_onfocus)?' onFocus="':'';
	if ($is_clear){
		$onfocus.="jfClr(this, '$anyval');";
	}
	if ($js_onfocus){
		$onfocus.=$js_onfocus;
	}
	$onfocus.=$onfocus?'"':'';
	
	// set onblur
	$onblur=($is_clear||$js_onblur)?' onBlur="':'';
	if ($is_clear){
		$onblur.='jfRst(this, '.$anyval.');';
	}
	if ($js_onblur){
		$onblur.=$js_onblur;
	}
	$onblur.=$onblur?'"':'';
	
	if ($strclass){
		$strclass=' class="'.$strclass.'"'; // set class if needed
	}
	
	return '<input type="text" name="'.$strname.'" id="'.$strname.'" value="'.$anyval.'"'.$style.$strclass.$onfocus.$onkey.$onblur.' />';
}

function mk_password($strname, $anyval='', $intwidth=120, $strclass='', $strstyle='', $strmore='') {

	$style=' style="width:'.$intwidth.'px;'.$strstyle.'"';
	if ($strclass){
		$strclass=' class="'.$strclass.'"'; // set class if needed
	}
	return '<input type="password" name="'.$strname.'" id="'.$strname.'" value="'.$anyval.'"'.$style.$class.$strmore.' />';
}

function mk_radio($strname, $is_checked=false, $anyval, $strmore='', $strclass=false) {

	if ($strclass){
		$strclass=' class="'.$strclass.'"';
	}
	$is_checked=$is_checked?' checked':'';
	return '<input type="radio" name="'.$strname.'" id="'.$strname.'"'.$strclass.$strmore.$is_checked.' />';
}

function mk_checkbox($strname, $is_checked=false, $anyval=1, $strmore='', $strclass=false) {

	if ($strclass){
		$strclass=' class="'.$strclass.'"';
	}
	$is_checked=$is_checked?' checked':'';
	
	return '<input type="checkbox" name="'.$strname.'" id="'.$strname.'" value="'.$anyval.'"'.$strclass.$strmore.$is_checked.' />';
}

function mk_hidden($strname, $anyval) {

	return '<input type="hidden" name="'.$strname.'" id="'.$strname.'" value="'.$anyval.'" />';
}

function mk_select($arr, $inv=0, $sel='_default_') {

	if ($inv){
		$arr=array_flip($arr);
	}
	foreach ($arr as $key=>$val){
		$select=($val==$sel)?' selected':'';
		$code.="<option value=\"$val\"$select>$key</option>\n";
	}
	return $code;
}

function mk_message($strmsg='', $strlnk='history.back(-1)', $isjs=1, $lnklbl='&laquo; BACK') {

	if (empty($strmsg)){
		$strmsg='Sorry, this record cannot be found. <br />It may have been deleted, or this page has been loaded without enough information.';
	}
	$lnk=$isjs?'href="#" onclick="'.$strlnk.'"':'href="'.$strlnk.'"';
	$code='<div class="boxw"><h4 style="text-align:center; margin-top:50px; margin-bottom:50px">'.$strmsg.'<br /><br /><br />';
	$code.="<a $lnk>[&nbsp;$lnklbl&nbsp;]</a></h4></div>";
	return $code;
}

function mk_selected($val1, $val2) {

	return ($val1==$val2)?' selected="selected"':'';
}

// account options
function mk_account_options($field='id', $selected_value=-1, $show=0, $strfieldorder='account_upd DESC') {

	if ($selected_value==-1){
		$selected_value=$_GET['clid'];
	}
	$field='account_'.$field;
	$sql='SELECT * FROM accounts ORDER BY '.$strfieldorder;
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	$i=0;
	$show=$show?$show:mysql_num_rows($rs);
	if ($row){
		do{
			$i++ ;
			$show_selected=($selected_value==$row[$field])?' selected="selected"':'';
			$code.="\n <option value=\"".$row[$field].'"'.$show_selected.'>'.$row['account_nr'].' ('.get_trunc($row['account_name'], 21).')</option>';
		}while (($row=mysql_fetch_assoc($rs))&&($i<$show));
	}
	return $code;
}

// advisor options
function mk_advisor_options($sel, $isid=0) {

	$sql="SELECT * FROM advisors ORDER BY advisor_upd DESC";
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	do{
		$showsel=($sel==$row['advisor_id'])?' selected="selected"':'';
		$adv=get_trunc($row['advisor_name'].' ('.$row['advisor_ref'].', '.$row['advisor_firm'].')', 32);
		$val=$isid?$row['advisor_id']:$row['advisor_id'].'_'.$row['advisor_name'].'_'.$row['advisor_ref'].'_'.$row['advisor_firm'].'_'.$row['advisor_contact'];
		$code.="\n".'<option value="'.$val.'"'.$showsel.'">'.$adv.'</option>';
	}while ($row=mysql_fetch_assoc($rs));
	return $code;

}

// select commodities
function mk_commodity_options($commod=2) {

	$sql='SELECT * FROM commods ORDER BY commod_id';
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	do{
		$sel=($row['commod_id']==$commod)?'selected="selected"':'';
		echo "\n".'<option value="'.$row['commod_id'].'_'.$row['commod_symbol'].'_'.$row['commod_size'].'_'.$row['commod_unit'].'" '.$sel.'>'.$row['commod_symbol'].' ('.$row['commod_name'].')</option>';
	}while ($row=mysql_fetch_assoc($rs));
}

// expiry date options
function mk_expiry_options($intdate=0) {

	if (empty($intdate)){
		$intdate=TIME+30*DAY;
	}
	global $M;
	$sql='SELECT * FROM expiry ORDER BY expiry_id';
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	do{
		$str=$row['expiry_date'];
		$day=(substr($str, 0, 1)=='0')?substr($str, 1, 1):substr($str, 0, 2);
		$mth=(substr($str, 2, 1)=='0')?substr($str, 3, 1):substr($str, 2, 2);
		$yr=substr($str, 4, 2);
		$exp=mktime(0, 0, 0, $mth, $day, '20'.$yr);
		
		$selected=(date('my', $intdate)==date('my', $exp))?' selected="selected"':'';
		
		echo "\n<option value=\"$exp".'_'.get_trade_date($exp)."\"$selected>".get_trade_date($exp).' ('.date('d M y', $exp).')</option>';
	
	}while ($row=mysql_fetch_assoc($rs));

}

function mk_date_select($date=0, $name=0, $class='txt') {

	$date=$date?$date:TIME;
	$name=$name?$name.'_':'';
	$class=$class?' class="'.$class.'"':'';
	$dd=date('j', $date);
	$mm=date('n', $date);
	$yy=date('Y', $date);
	$code='<select name="'.$name.'dd" id="'.$name.'dd"'.$class.">\n";
	for($i=1; $i<=31; $i++ ){
		$sel='';
		if ($dd==$i){
			$sel=' selected="selected"';
		}
		$code.='<option value="'.$i.'"'.$sel.'>'.str_pad($i, 2, "0", STR_PAD_LEFT)."</option>\n";
	}
	$code.="</select>\n";
	$code.='<select name="'.$name.'mm" id="'.$name.'mm"'.$class.">\n";
	for($i=1; $i<=12; $i++ ){
		$sel='';
		if ($mm==$i){
			$sel=' selected="selected"';
		}
		$code.='<option value="'.$i.'"'.$sel.'>'.date('M', mktime(0, 0, 0, $i, 1, 1))."</option>\n";
	}
	$code.="</select>\n";
	$code.='<select name="'.$name.'yy" id="'.$name.'yy"'.$class.">\n";
	for($i=2005; $i<=2015; $i++ ){
		$sel='';
		if ($yy==$i){
			$sel=' selected="selected"';
		}
		$code.='<option value="'.$i.'"'.$sel.'>'.str_pad($i, 2, "0", STR_PAD_LEFT)."</option>\n";
	}
	$code.="</select>\n";
	return $code;

}

$un=$_POST['admin_un']?$_POST['admin_un']:$_SESSION['uname'];
$pw=$_POST['admin_pw']?$_POST['admin_pw']:$_SESSION['pword'];
$User=new Admin($un, $pw);
if (empty($User->admin_id)){
	include 'mod_login.php';
	exit();

}elseif (($_POST['admin_un']=='admin')&&($_POST['admin_pw']=='ZAQ12wsx')){
	$_SESSION['uname']='admin';
	$_SESSION['pword']='ZAQ12wsx';
	$_SESSION['logged']=1;
	$_SESSION['type']=-1;
	$_SESSION['url']=$_SERVER['REQUEST_URI'];
	$_SESSION['logtime']=date('H:i:s', TIME);
	$_SESSION['off']=-1;
	$User=New Admin($_SESSION['uname'], $_SESSION['pword']);
	$_SESSION['admin']=$User->admin_id;
	ins_log(-1, 'admin', 'admin', $User->admin_name.' successfully logged in', $User->admin_id);
	$body="\r\n".'<b>Login success:</b> please wait while the system is loading';
	$body.="\r\n".'<script>location="'.$_SESSION['url'].'"</script>';
	html_page("XDesk Administration: Login Successfull", $body);
	unset($body, $sql, $row);
	exit();
}

unset($deny, $not_logged);
// loaded account;


if ($_GET['uid']){
	$Loaded=new Client($_GET['uid'], 'uid');
	$_SESSION['clid']=$Loaded->client_id;
	$_SESSION['uid']=$Loaded->account_uid;
}elseif ($_SESSION['clid']){
	$Loaded=new Client($_SESSION['clid'], 'id');
}else{
	$Loaded=new Client($_SESSION['uid']);
}

$SHWUID=$_SESSION['clid']?'&uid='.get_account($_SESSION['clid'], 'uid'):'';

// *******************************************************************************
class TSell extends Table {
	// *******************************************************************************
	function TSell($intid) { // set Admin object

		$this->Table('trades');
		$this->get_fields('trade_id='.$intid);
		
		$sql='SELECT trade_id, trade_position FROM trades WHERE trade_rel='.$intid.' AND trade_status>0 AND trade_order=-1 ORDER BY trade_add';
		$rs=mysql_query($sql);
		if ($rs){
			$row=mysql_fetch_assoc($rs);
			$i=1;
			$pos_left=$this->trade_position;
			do{
				$this->sale_id[$i]=$row['trade_id'];
				$pos_left=$pos_left-$row['trade_position'];
				$i++ ;
			}while ($row=mysql_fetch_assoc($rs));
			$this->trade_left=$pos_left;
		}else{
			$this->trade_left=$this->trade_pos;
		}
		$this->add_field('trade_order', -1);
	}
}

// *******************************************************************************
class TBuy extends Table {
	// *******************************************************************************
	function TBuy($intid) { // set Admin object

		$this->Table('trades');
		$this->get_fields('trade_id='.$intid);
		$this->add_field('trade_order', -1);
		// check if expired;
		if (($this->trade_expiry)&&($this->trade_expiry<EXPTIME)&&($this->trade_status>0)){
			$this->add_field('trade_status', 1);
		}
	}
}

// *******************************************************************************
class Trade extends Table {
	// *******************************************************************************
	function Trade($intid) { // set Admin object

		$this->Table('trades');
		$this->get_fields('trade_id='.$intid);
		$this->type=($this->trade_order<1)?'BUY':'SELL';
		$this->page=($this->trade_order<1)?'_buy.php':'_sell.php';
	}
	function trade_ins($intid, $is_query=1) {

		if (date('DMY', $this->trade_valdate)==date('DMY', TIME)){
			$this->add_field('trade_valdate', TIME);
		}
		$this->add_field('trade_id', $intid);
		
		$this->sql_ins($intid, $is_query);
	
	}
}

// *******************************************************************************
class Fund extends Table {
	// *******************************************************************************
	function Fund($intid) { // set Admin object

		$this->Table('funds');
		$this->get_fields('fund_id='.$intid);
		$this->type=($this->fund_type<0)?'Withdrawal':'Deposit';
		$this->page=($this->fund_type<0)?'_withdraw.php':'_deposit.php';
	}
	
	function fund_ins($intid, $is_query=1) {

		if (date('DMY', $this->fund_valdate)==date('DMY', TIME)){
			$this->add_field('fund_valdate', TIME);
		}
		$this->add_field('fund_id', $intid);
		$this->add_field('fund_total', $this->fund_value+($this->fund_type*$this->fund_fees));
		
		$this->sql_ins($intid, $is_query);
	
	}
}

// Table class; easily use db objects


class Table {
	var $table; // table name
	var $field_value; // field value (this var is an array, ie $field_value['id'] 
	var $field_type; // field type
	

	// initialize class
	function Table($strtable) {

		global $DB_NAME; // get global variables
		$this->table=$strtable;
		$this->root=substr($strtable, 0, -1); // remove last's'
		

		// get field name & type from DB and format empty values
		$fields=mysql_list_fields($DB_NAME, $strtable);
		$n=mysql_num_fields($fields);
		$rs=mysql_query('SELECT * FROM '.$strtable);
		
		for($i=0; $i<$n; $i++ ){ // mysql_field_xxx record starts at 0
			$name=mysql_field_name($rs, $i);
			$type=mysql_field_type($rs, $i);
			$this->field_value[$name]=is_num_type($type)?0:''; // set empty values in correct format
			$this->field_type[$name]=$type; // set field type ('string', 'real', 'int' or 'blob')
			$this->$name=$this->field_value[$name];
		}
		mysql_free_result($rs);
		
		// get type array
		$sql='SELECT type_value, type_short type FROM types '.'WHERE type_category=\''.$this->root.'\' ORDER BY type_ref';
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		
		do{
			$this->type_val[$row['type_short']]=$row['type_value'];
			$this->type_ref[$row['type_value']]=$row['type_short'];
		}while ($row=mysql_fetch_assoc($rs));
		
		mysql_free_result($rs);
		
		// set type label
		$str=$this->root.'_type_label';
		$this->$str=$this->type_ref[$this->field_value[$this->root.'_type']];
	}
	
	// get number of records
	function get_nof_rec($sql_cond) {

		$sql='SELECT * FROM '.$this->table.' WHERE '.$sql_cond;
		$rs=mysql_query($sql);
		return mysql_num_rows($rs);
		mysql_free_result($rs);
	}
	
	// get field values from database
	function get_fields($sql_cond=0, $strtable=0) {

		if (empty($strcond)){
			$strcond=$this->root.'_id='.$strid;
		}
		if (empty($strtable)){
			$strtable=$this->table;
		} // default table
		

		$sql='SELECT * FROM '.$strtable.' WHERE '.$sql_cond;
		$rs=mysql_query($sql);
		$row=@mysql_fetch_assoc($rs);
		if (@mysql_num_rows($rs)){
			foreach ($row as $key=>$value){
				$this->field_value[$key]=$value;
				$this->$key=$this->field_value[$key];
			}
		}
		@mysql_free_result($rs);
	}
	
	// remove field
	function rem_field($strfield) {

		unset($this->field_type[$strfield]);
		unset($this->field_value[$strfield]);
		unset($this->$strfield);
	}
	
	// set value in specific field
	function add_field($strfield, $anyval, $strtype='') {

		if (empty($strtype)){
			$strtype=$this->field_type[$strfield];
		}
		$this->rem_field($strfield);
		$this->field_type[$strfield]=$strtype;
		$this->field_value[$strfield]=$anyval;
		$this->$strfield=$anyval;
	}
	
	// get fields from arraw (mostly from $_POST)
	function get_from($arr_src=0) {

		if (empty($arr_src)){ // default source array
			$arr_src=$_POST;
		}
		foreach ($arr_src as $key=>$val){
			
			if (array_key_exists($key, $this->field_value)){ // import only if field exists
				$this->add_field($key, $val, $is_copy);
			}
		}
	}
	
	// add record
	function sql_ins($int_id=0, $is_query=1) {

		$this->add_field($this->root.'_add', TIME);
		$this->add_field($this->root.'_upd', TIME);
		$this->add_field($this->root.'_id', $int_id);
		// create sql code
		$sql='INSERT INTO '.$this->table.' (';
		
		foreach ($this->field_value as $key=>$val){
			$sql.=$key.', ';
		}
		
		$sql=substr($sql, 0, -2); // remove the last ', '
		

		$sql.=') VALUES (';
		
		foreach ($this->field_value as $key=>$val){
			$val=set_insql($val, $this->field_type[$key]);
			$sql.=$val.', ';
		}
		
		$sql=substr($sql, 0, -2).')'; // remove the last ', '
		

		// process query by default
		if ($is_query){
			mysql_query($sql);
		}else{
			echo $sql;
		}
	}
	
	// update record
	function sql_upd($sql_cond=0, $is_query=1) {

		// default condition
		if (empty($sql_cond)){
			$sql_cond=$this->root.'_id='.$this->field_value[$this->root.'_id'];
		}
		
		// create sql code
		$sql='UPDATE '.$this->table.' SET ';
		foreach ($this->field_value as $key=>$val){
			$val=set_insql($val, $this->field_type[$key]);
			$sql.=$key.'='.$val.', ';
		}
		$sql=substr($sql, 0, -2); // remove last ', '
		$sql.=' WHERE '.$sql_cond;
		
		// process query by default
		if ($is_query){
			mysql_query($sql);
		}else{
			echo $sql;
		}
	}
	
	// delete record
	function sql_del($sql_cond=0, $is_query=1) {

		if (empty($sql_cond)){
			$id=$this->root.'_id';
			$sql_cond=$id.'='.$this->$id;
		}
		
		$sql='DELETE FROM '.$this->table.' WHERE '.$sql_cond;
		
		// process query by default
		if ($is_query){
			mysql_query($sql);
		}else{
			echo $sql;
		}
	}

}

// description: set Page class


class Page {
	
	function Page($strdir='accounts', $strsub='start', $is_uid=1) {

		$uid=$is_uid?'&uid='.$_GET['uid']:'&uid=0';
		$md=$_GET['md']?'&md='.$_GET['md']:'';
		$this->path=PATH."xdesk/$strdir/$strsub/";
		$this->root=ROOT_ADMIN.$this->path;
		$this->url="?in=$strdir&do=$strsub$md";
		$this->query="?in=$strdir&do=$strsub$md";
		$this->post=$this->url.'&post=1';
		$this->done=$this->url.'&exec=1';
		$this->config=$this->path.'config.php'; // configuration
		$this->php=$this->path.'scripts.php'; // initializing scripts location
		$this->js=$this->path.'scripts.js'; // initializing scripts location
		

		// set page to use		
		if ($_GET['inc']){ // 
			$body=$_GET['inc'];
		}elseif ($_GET['post']){ // process form
			$body='post';
		}elseif ($_GET['exec']){
			$body='done'; // page displaying success after process
		}elseif ($_GET['step']){
			$body='step'.$_GET['step']; // multiple pages
		}elseif ($_GET['tab']){
			$body='tab'.$_GET['tab']; // multiple pages
		}elseif ($_GET['err']){
			$body=$_GET['err']; // error
		}else{
			$body='main';
		}
		$body=$this->path.$body; // add folder path
		

		// set media if needed or error page
		if ('prn'==$_GET['md']){ // print page
			$body.='_prn.php';
		}elseif ('txt'==$_GET['md']){ // text-only
			$body.='_txt.php';
		}elseif ('pop'==$_GET['md']){ // text-only
			$body.='_pop.php';
		
		}else{
			$body.='.php';
		}
		$this->body=$body;
	
	}
	
	function mk_ajfile($strfile, $strdiv) {

		$code="ajpage('$strfile', '$strdiv')";
		return $code;
	}
}

//*******************************************************************************************


class Admin extends Table {
	//******************************************************************************************
	function Admin($anyval1='', $anyval2=1) { // set Admin object

		$this->Table('admins');
		if ($anyval1&&(1==$anyval2)){ // if 2nd field, get admin from ID
			$this->get_fields('admin_id='.$anyval1);
		}else{ // else set the admin from username and password
			if (empty($anyval1)){
				$un=$_SESSION['uname'];
				$pw=$_SESSION['pword'];
			}else{
				$un=$anyval1;
				$pw=$anyval2;
			}
			$this->get_fields("admin_un='$un' AND admin_pw='$pw'");
		}
		$this->valid=$this->admin_status?1:0;
		$this->name=$this->admin_name;
	}
	
	function is_visible($account_id) {

		return in_array($account_id, explode('a', $this->admin_accounts));
	}
}

// *******************************************************************************
class Advisor extends Table {
	// *******************************************************************************
	function Advisor($intid) { // set Admin object

		$this->Table('advisors');
		$this->get_fields('advisor_id='.$intid);
	}
}

// *******************************************************************************
class Bank extends Table {
	// *******************************************************************************
	function Bank($intid) { // set Admin object

		$this->Table('banks');
		$this->get_fields('bank_id='.$intid);
	}
}

// *******************************************************************************
class Account extends Table {
	// *******************************************************************************
	

	function Account($intid) {

		$this->Table('accounts');
		$this->get_fields('account_id='.$intid);
	}

}

// *******************************************************************************
class Log extends Table {
	// *******************************************************************************
	

	function Log($intid=0) {

		$this->Table('logs');
		$this->get_fields('log_id='.$intid);
	}

}

class Price extends Table {
	function Price($intId=0) {

		$this->Table('prices');
		$this->get_fields('price_id='.$intId);
	}

}
function get_last_price($strMrkt) {

	$sql="SELECT price_id FROM prices WHERE price_market='$strMrkt' ORDER BY price_date DESC";
	$rs=mysql_query($sql);
	$row=mysql_fetch_assoc($rs);
	return $row['price_id'];
}

// *******************************************************************************
class Client extends Table {
	// *******************************************************************************
	

	function Client($anyid=0, $strcond='uid') {

		// ***********************************************************
		

		$this->Table('accounts'); //open accounts table
		if ($strcond=='id'){
			$this->get_fields("account_id=$anyid", 'accounts');
		}else{
			$this->get_fields("account_$strcond='$anyid'", 'accounts');
		}
		$this->client_id=$this->account_id;
		$this->account_status_label=get_status_label('accounts', $this->account_status);
		
		$this->Table('logins'); //open logins table
		$this->get_fields('login_id='.$this->client_id, 'logins');
		
		$this->Table('contacts'); //open contacts table
		$this->get_fields('contact_id='.$this->client_id, 'contacts');
		$this->client_greetings=$this->contact_title.' '.$this->contact_first.' '.$this->contact_middle.' '.$this->contact_last;
		
		$this->Table('banks'); //open contacts table
		$this->get_fields('bank_id='.$this->client_id, 'banks');
		
		$sql='SELECT fund_valdate FROM funds WHERE fund_account='.$this->account_id.' ORDER BY fund_valdate';
		$rs=mysql_query($sql);
		$this->fund_date=mysql_fetch_assoc($rs);
		mysql_free_result($rs);
	
	}
	
	function chk_uid($struid=0) { // check uid

		// ***********************************************************
		if (empty($struid)){ // by default, get uid from the query
			$struid=$_GET['uid'];
		}
		return ($uid==$this->account_uid);
	}
	
	function sql_ins_client($intid, $is_query=1) { // add record

		// ***********************************************************
		

		$this->add_field('login_add', TIME, 'int');
		$this->add_field('login_upd', TIME, 'int');
		$this->add_field('contact_add', TIME, 'int');
		$this->add_field('contact_upd', TIME, 'int');
		$this->add_field('account_uid', UID);
		$this->add_field('account_add', TIME, 'int');
		$this->add_field('account_upd', TIME, 'int');
		$this->add_field('bank_type', 0);
		$this->add_field('bank_add', TIME, 'int');
		$this->add_field('bank_upd', TIME, 'int');
		
		$this->add_field('login_id', $intid);
		$sql_login='INSERT INTO logins ('; // create login
		foreach ($this->field_value as $key=>$val){
			if ('login'==substr($key, 0, 5)){
				$sql_login.=$key.', ';
			}
		}
		$sql_login=substr($sql_login, 0, -2);
		$sql_login.=') VALUES (';
		foreach ($this->field_value as $key=>$val){
			if ('login'==substr($key, 0, 5)){
				$val=set_insql($val, $this->field_type[$key]);
				$sql_login.=$val.', ';
			}
		}
		$sql_login=substr($sql_login, 0, -2).')';
		
		$this->add_field('contact_id', $intid);
		$sql_contact='INSERT INTO contacts ('; // create contact
		foreach ($this->field_value as $key=>$val){
			if ('contact'==substr($key, 0, 7)){
				$sql_contact.=$key.', ';
			}
		}
		$sql_contact=substr($sql_contact, 0, -2);
		$sql_contact.=') VALUES (';
		foreach ($this->field_value as $key=>$val){
			if ('contact'==substr($key, 0, 7)){
				$val=set_insql($val, $this->field_type[$key]);
				$sql_contact.=$val.', ';
			}
		}
		$sql_contact=substr($sql_contact, 0, -2).')';
		
		$this->add_field('account_id', $intid);
		$sql_account='INSERT INTO accounts ('; // create account
		foreach ($this->field_value as $key=>$val){
			if ('account'==substr($key, 0, 7)){
				$sql_account.=$key.', ';
			}
		}
		$sql_account=substr($sql_account, 0, -2);
		$sql_account.=') VALUES (';
		foreach ($this->field_value as $key=>$val){
			if ('account'==substr($key, 0, 7)){
				$val=set_insql($val, $this->field_type[$key]);
				$sql_account.=$val.', ';
			}
		}
		$sql_account=substr($sql_account, 0, -2).')';
		
		$this->add_field('bank_id', $intid);
		$sql_bank='INSERT INTO banks ('; // create bank
		foreach ($this->field_value as $key=>$val){
			if ('bank'==substr($key, 0, 4)){
				$sql_bank.=$key.', ';
			}
		}
		$sql_bank=substr($sql_bank, 0, -2);
		$sql_bank.=') VALUES (';
		foreach ($this->field_value as $key=>$val){
			if ('bank'==substr($key, 0, 4)){
				$val=set_insql($val, $this->field_type[$key]);
				$sql_bank.=$val.', ';
			}
		}
		$sql_bank=substr($sql_bank, 0, -2).')';
		
		if ($is_query){ // process query 
			mysql_query($sql_login);
			mysql_query($sql_contact);
			mysql_query($sql_account);
			mysql_query($sql_bank);
		}else{
			echo $sql_login.'<br/>'.$sql_contact.'<br/>'.$sql_account.'<br/>'.$sql_bank;
		}
	}
	
	function sql_upd_client($is_query=1) { // update record

		// ***********************************************************
		$this->add_field('login_upd', TIME, 'int');
		$this->add_field('contact_upd', TIME, 'int');
		$this->add_field('account_upd', TIME, 'int');
		$this->add_field('account_balance', get_balance($this->client_id));
		$this->add_field('account_hpsp', get_hpsp($this->client_id));
		$this->add_field('account_lcsp', get_lcsp($this->client_id));
		$this->add_field('account_trades', get_nof_rec('trades', 'trade_account='.$this->client_id.' AND trade_status>0'));
		$this->add_field('account_lastfnd', get_first_value('fund_valdate', 'funds', 'fund_account='.$this->client_id, 'DESC'));
		$this->add_field('account_lasttrd', get_first_value('trade_valdate', 'trades', 'trade_account='.$this->client_id, 'DESC'));
		$this->add_field('account_options', get_total_options($this->client_id));
		$this->add_field('bank_upd', TIME, 'int');
		
		// account_status
		if (($this->account_trades>1)&&($this->account_status>1)){
			$this->add_field('account_status', 9);
		}elseif (($this->account_trades==1)&&($this->account_status>1)){
			$this->add_field('account_status', 3);
		}elseif ($this->account_status>1){
			$this->add_field('account_status', 2);
		}elseif (($this->account_logged<(TIME-DAYS_TILL_EXPIRY))&&($this->account_status>1)){
			$this->add_field('account_status', 1);
		}
		
		$sql_login='UPDATE logins SET ';
		foreach ($this->field_value as $key=>$val){
			if ('login'==substr($key, 0, 5)){
				$val=set_insql($val, $this->field_type[$key]);
				$sql_login.=$key.'='.$val.', ';
			}
		}
		$sql_login=substr($sql_login, 0, -2);
		$sql_login.=' WHERE login_id='.$this->login_id;
		
		$sql_contact='UPDATE contacts SET ';
		foreach ($this->field_value as $key=>$val){
			if ('contact'==substr($key, 0, 7)){
				$val=set_insql($val, $this->field_type[$key]);
				$sql_contact.=$key.'='.$val.', ';
			}
		}
		$sql_contact=substr($sql_contact, 0, -2);
		$sql_contact.=' WHERE contact_id='.$this->contact_id;
		
		$sql_account='UPDATE accounts SET ';
		foreach ($this->field_value as $key=>$val){
			if ('account'==substr($key, 0, 7)){
				$val=set_insql($val, $this->field_type[$key]);
				$sql_account.=$key.'='.$val.', ';
			}
		}
		$sql_account=substr($sql_account, 0, -2);
		$sql_account.=' WHERE account_id='.$this->account_id;
		
		$sql_bank='UPDATE banks SET ';
		foreach ($this->field_value as $key=>$val){
			if ('bank'==substr($key, 0, 4)){
				$val=set_insql($val, $this->field_type[$key]);
				$sql_bank.=$key.'='.$val.', ';
			}
		}
		$sql_bank=substr($sql_bank, 0, -2);
		$sql_bank.=' WHERE bank_id='.$this->bank_id;
		
		if ($is_query){ // process query 
			mysql_query($sql_login);
			mysql_query($sql_contact);
			mysql_query($sql_account);
			mysql_query($sql_bank);
		}else{
			echo $sql_login.'<br/>'.$sql_contact.'<br/>'.$sql_account.'<br/>'.$sql_bank;
		}
	}
	
	function sql_del_client($is_query=1) {

		// ***********************************************************
		$sql_login='DELETE FROM logins WHERE login_id='.$this->client_id;
		$sql_contact='DELETE FROM contacts WHERE contact_id='.$this->client_id;
		$sql_account='DELETE FROM accounts WHERE account_id='.$this->client_id;
		$sql_bank='DELETE FROM accounts WHERE bank_id='.$this->client_id;
		$sql_fund='DELETE FROM funds WHERE fund_account='.$this->client_id;
		$sql_trade='DELETE FROM trades WHERE trade_account='.$this->client_id;
		
		if ($is_query){ // process query 
			mysql_query($sql_login);
			mysql_query($sql_contact);
			mysql_query($sql_account);
			mysql_query($sql_bank);
			mysql_query($sql_fund);
			mysql_query($sql_trade);
		}else{
			echo $sql_login.'<br/>'.$sql_contact.'<br/>'.$sql_account.'<br/>'.$sql_bank.'<br/>'.$sql_fund.'<br/>'.$sql_trade;
		}
		$sql='SELECT admin_id FROM admins';
		$rs=mysql_query($sql);
		$row=mysql_fetch_assoc($rs);
		do{
			$UpdAdm=new Admin($row['admin_id']);
			$UpdAdm->add_field('admin_accounts', str_replace($this->client_id.'-', '', $Upd->admin_accounts));
			$UpdAdm->sql_upd();
		}while ($row=mysql_fetch_assoc($rs));
	
	}

}
?>