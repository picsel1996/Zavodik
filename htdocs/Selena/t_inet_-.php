﻿<? /*
header("ETag: PUB" . time());
header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
header("Pragma: no-cache");
header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
session_cache_limiter("nocache");
*/
// Проверка на ИП адрес, дополнительная защита, ИП адреса лучше лишний раз уточнить у Бибгаева, они могли поменяться
$ip = getenv("REMOTE_ADDR");
$ok='1';
$deb = 0;

if ($ip=='81.176.214.110'){$ok ='1';}
if ($ip=='81.176.214.107'){$ok ='1';}
if ($ip=='10.1.90.26'){$ok ='1'; $deb = 1; }
if ($ip=='10.1.253.6'){$ok ='1'; $deb = 1; }
if ($ip=='10.1.253.22'){$ok ='1'; $deb = 1; }
if ($ip=='127.0.0.1'){$ok ='1'; $deb = 1; }
//$deb = 0;

	fdebug("IP - Ok!<br>");
//

if ($ok=='1'){

	require_once("db_fns.php");
	require_once("user_auth_fns.php");
	$conn = db_connect();
	if (!$conn)			// Нет связи с базой	//##     В Ы Х О Д    ##//
			Go_Out($txn_id, 1); // return 0;
/*
	$account =  $_REQUEST ["account"];
//	$account =  preg_match("^\d{1,20}$", $account)?$account:0;
//	if ($account == 0) {}
	$txn_id =  $_REQUEST ["txn_id"];
	$trm_id =  isset($_REQUEST ["trm_id"])?$_REQUEST ["trm_id"]:"";
	$prv_id =  isset($_REQUEST ["prv_id"])?$_REQUEST ["prv_id"]:0;
	$sum =  $_REQUEST ["sum"];
	$command =  $_REQUEST ["command"];
	$now = "'".date("Y-m-d H:i:s")."'";
	$fp = "";
	$account=HACK($account); // Очистка переменной от опасных символов

//***********************	есть ли запись с номером $txn_id
	$prv_txn = get_new_prv_txn();
	$r_txn = get_prv_txn($txn_id);		//	print_r($r_txn);

	fdebug("запись с номером $txn_id ".(($cr = is_txn_id($txn_id))?"есть":"отсутствует")."<br>");
	if ($cr) { // уже есть запись с таким номером txn_id
		fdebug("повторный запрос по txn_id=$txn_id<br>");
		$q_upd = "update `t_inet` set coun = ".$r_txn["coun"]."+1 where txn_id=$txn_id";
		$r_upd =  mysql_query($q_upd) or die(mysql_error());
		if (($r_txn["result"] == 90 || $r_txn["result"] == 1) && $r_txn["error"] == 0) { // Проведение платежа не окончено
			fdebug("платёж небыл завершён")."<br>";
			$to_resp = out_resp($txn_id, 0);
		} else {
			fdebug("платёж ".($r_txn["error"] > 0?"закончился ошибкой":"был завершён")."<br>");
			//##     В Ы Х О Д    ##//
			Go_Out($txn_id, 0);
		}
	} else {
		//***********************	Ошибка ! в номере счёта есть не цифры! error = 2
		//	fdebug( "цифры, длина от 1 до 20:". preg_match("/\d{1,20}/", $account). "<br>");
		if ($err_acc = preg_match("/\D/", $account)) { // счёт имеет другие символы
			fdebug( "Ошибка ! в номере счёта есть не цифры!<br>");
			//	command=check&txn_id=9715351212001&account=xobet35&sum=104.50&prv_id=29145&sum_from=110.00
			fdebug("создаём запись с txn_id=$txn_id ...<br>");
			$q_ins = "insert into `t_inet` (d_time, account, txn_id, prv_txn, sum, result, prv_id, coun, error) ".
							"values ($now,'{$account}', $txn_id, ".$prv_txn.", $sum, 0, $prv_id, 1, 2)"	;//echo,'</br>'   '".$res."'
			$s_ins_inet =  mysql_query($q_ins) or die(mysql_error());
			fdebug("готово<br>");
			//##     В Ы Х О Д    ##//
			Go_Out($txn_id, 0);
		}
		//***********************	создаём запись с txn_id=$txn_id ...
		fdebug("создаём запись с txn_id=$txn_id ...");
		$q_ins = "insert into `t_inet` (d_time, account, txn_id, prv_txn, sum, result, prv_id, coun) ".
						"values ($now, $account, $txn_id, ".$prv_txn.", $sum, 90, $prv_id, 1)"	;//echo,'</br>'         '".$res."'
		$s_ins_inet =  mysql_query($q_ins) or die(mysql_error());
		fdebug("готово<br>");
	}
*/
///########    Соединяемся с сервером      ###############################################################
	error_reporting(E_ALL); 
	set_time_limit(30); 
	ob_implicit_flush(); 
	if (($GLOBALS['fp'] = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === False) {
		echo "Ошибка соединения с сервером биллинга: " . socket_strerror(socket_last_error()) . "<br>";
		//***********************	ошибка соединения с сокетом error = 3
		}
	$result    = socket_connect($fp, $IPb, 49160); 
	
	if (!get_wellcome($fp)) {	//***********************	ошибка чтения с сокета error = 4
		echo date("Y-m-d H:i:s")," Ошибка при прочитении данных приветствия<br> ";
	}
	//***********************
	fdebug("Есть соединение!<br>");
/************************************************************************************************************************************
	$n = getNic(get_000($fp, "look $account"));		$wNic = ($n==""?getNic(get_000($fp, "look $account")):$n);
	fdebug("Пользователь: ". (($errNic = $wNic == "")?"<b>ОТСУТСТВУЕТ!</b>":$wNic). "<br>");
	if ($errNic) { 	//***********************	ошибка! пользователь отсутствует! error = 1
		fdebug("Счёт ".$_REQUEST ["account"]." не существует!<br>");
		fdebug("в базе уже есть запись с txn_id=$txn_id<br>");
		$q_upd = "update `t_inet` set error = 1 where txn_id=$txn_id";
		$r_upd =  mysql_query($q_upd) or die(mysql_error());
		//##     В Ы Х О Д    ##//
		Go_Out($txn_id, 0);
	}
	//***********************
	$acc_1 = getSum($acc = send_command($fp, "acc $account"));
	fdebug("Начальный баланс: ". $acc_1. "<br>");
//	fdebug("acc: ". $acc. "<br>");
	//*************************************************************
	//*********************** первый запрос "check"
	$r_txn = get_prv_txn($txn_id);	//*****
	if ($r_txn["result"] == 90 || $r_txn["result"] == 1) { // Проведение платежа не окончено
	/*	$acc_1 = getSum($acc = send_command($fp, "acc $account"));
		fdebug("Начальный баланс: ". $acc_1. "<br>");	*!/
		fdebug("... обнаружен не оконченный платеж<br>");
		//*********************	
//		fdebug( substr(ltrim(strstr($acc, "-"), " "), 5, 1) );
		$fros = isFrosen($acc);
		$off = isOFF($acc);
		fdebug("Абонент ".($fros?"<b>":"<b>Не </b>")."заморожен"."</b><br>");
		fdebug("Абонент ".($off ?"<b>":"<b>Не </b>")."отключен"."</b><br>");
		if ($fros) {
			fdebug("... РАЗморозка<br>");
			$res = get_000($fp, "unfreeze $account");
			fdebug("Абонент: ". (isFrosen(send_command($fp, "acc $account"))?"<b>НЕ</b>":"успешно<b>"). " разморожен</b><br>");
		}
//		if ($off) fdebug("Абонент: <b>". (substr(get_000($fp, "on $account"), 6, 7)=="Success"?"успешно":"НЕ")." включен</b><br>");
		//*********************	
		$res = get_000($fp, "add $account $sum");				fdebug("Операция: ". $res."<br>");//getSum()
		$res = 'err_'.str_ireplace ('"', ' ', str_ireplace ("'", " ", $res));
		$acc_2 = getSum(send_command($fp, "acc $account"));			fdebug("Конечный баланс: ". $acc_2."<br>");
		//*********************	
		if ($fros) {
			fdebug("... ЗАморозка<br>");
			$res = get_000($fp, "freeze $account");
			fdebug("Абонент: ". (isFrosen(send_command($fp, "acc $account"))?"успешно<b>":"<b>НЕ</b>"). " заморожен</b><br>");
		}
		if (round(floatval($acc_2)) != round(floatval($acc_1))/*, 2) == round(floatval($sum), 2)*!/) {
			$q_upd = "update `t_inet` set d_time = $now, account=$account, sum=$sum, result=0 where txn_id=$txn_id";
			$r_upd =  mysql_query($q_upd) or die(mysql_error());
			fdebug("получение данных пользователя<br>");
			//*********************	
*/
$q1 = "SELECT * FROM `t_inet` WHERE `d_time` > '2011-05-21 22:10:00' AND `d_time` < '2011-05-23 01:20:00' AND `error` =0";
$res_q1 = mysql_query($q1) or die(mysql_error());
while ($row = mysql_fetch_assoc($res_q1))  {   
	$account =	$row["account"];
	$txn_id =	$row["txn_id"];
	$sum =  	$row["sum"];
	$now =	"'".$row["d_time"]."'";
	$n = getNic(get_000($fp, "look $account"));		$wNic = ($n==""?getNic(get_000($fp, "look $account")):$n);
	fdebug("Пользователь: ". (($errNic = $wNic == "")?"<b>ОТСУТСТВУЕТ!</b>":$wNic). "<br>");
	if (!$errNic) { 	//***********************	НЕ	ошибка! пользователь отсутствует! error = 1
		$acc_2 = getSum($acc = send_command($fp, "acc $account"));
		$acc_1 = $acc_2*1 -$sum*1;
			
			$B_inf = get_inf_acc($account);	// получение данных пользователя
			//*********************	date("Y-m-d",)
			fdebug($B_inf['Bill_Dog']."<br>");
			$s_off = "";
			if ($B_inf['Bill_Dog']>0) {
				$dp = strtotime(get_date2off($account)); $D_pay = mktime(0,0,0,date("m",$dp),date("d",$dp)+31,date("Y",$dp));
				if ( $D_pay < mktime()) {
					fdebug("Должник более месяца, ОТКЛЮЧИТЬ интернет!<br>");
					//********** Должник более месяца, ОТКЛЮЧИТЬ интернет!
					$res = get_000($fp, "off $account");
					$off = isOFF(send_command($fp, "acc $account"));
					$s_off = ($off)?" OFF":"";
					fdebug(($off?"ОТ":"В")."КЛ</b>ючен</br>");
				}
			} else {
				$s_off = " !";
			}
			//*********************	
			$q_ins_inet = "insert into `actions` (TabNum,Bill_Dog,Nic,Login,InputDate,Date_start,Date_end,Summa,id_ActionType,Comment) ".
				"values (11,".($B_inf['Bill_Dog']>0?($B_inf['Bill_Dog'].",'".$B_inf['Nic']."','".$B_inf['Login']):"0,'','".$wNic).
							"',$now,'".date("Y-m-d")."','".date("Y-m-d")."',".
							"$sum,2,'".($wNic !=$B_inf['Login']?$wNic." ":"").($B_inf['Bill_Dog']>0?"":"($account) ")."$txn_id $acc_1 +$s_off')";//echo 	,'</br>'
			fdebug($q_ins_inet."<br>");
			$s_ins_inet =  mysql_query($q_ins_inet) or die(mysql_error());
			//*********************	
			$s_c = "update `logins` set saldo=$acc_2 where Login='".$B_inf['Login']."'";//echo 	,'</br>'
			fdebug($s_c."<br>");
			$s_cor_inet =  mysql_query($s_c) or die(mysql_error());
			fdebug("Добавлена.</br>");
		}
	fdebug("---------------------<br>");
	}
	//##     В Ы Х О Д    ##//
//	Go_Out($txn_id, 0);
	if ($fp) { socket_close($fp); }
}

//====================================================================================================
//====================================================================================================
function HACK($varforsql){ // ФУНКЦИЯ ДЛЯ ФИЛЬТРОВКИ ТОГО, ЧТО ПИШУТ ЛЮДИ В ТЕРМИНАЛЕ, В ОСНОВНОМ ЗАЩИТА ОТ ИНЬЕКЦИЙ SQL
$varforsql=str_replace('`',"&#96;",$varforsql);
$varforsql=str_replace("'","&#39;",$varforsql);
$varforsql=str_replace('"',"&#34;",$varforsql);
$varforsql=str_replace('\\',"&#92;",$varforsql);
$varforsql=str_replace('/',"&#47;",$varforsql);
$varforsql=str_replace("<","&#60;",$varforsql);
$varforsql=str_replace(">","&#62;",$varforsql);
$varforsql=str_replace("*","&#42;",$varforsql);
$varforsql=str_replace('­',"&#45;",$varforsql);
return $varforsql;
}

function Go_Out($txn_id, $resp) {
	$to_resp = "<?xml version=\"1.0\"?>\n<response>\n<osmp_txn_id>$txn_id</osmp_txn_id>\n<result>0</result>\n</response>";
	fdebug("возвращаем :".HACK($to_resp)."<br>");
	print "<?xml version=\"1.0\"?>\n"; 	print "<response>\n<osmp_txn_id>$txn_id</osmp_txn_id>\n<result>0</result>\n</response>";
/*	print $to_resp;	*/
	if ($GLOBALS['fp']) { socket_close($GLOBALS['fp']); }
	exit;
}

function fdebug($sdeb) {
	if ($GLOBALS['deb']==1) { echo date("Y-m-d H:i:s")." ".$sdeb; }
}

function out_resp($txn_id, $resp) {
//			$to_resp = "<osmp_txn_id>$txn_id</osmp_txn_id><prv_txn>".$r_txn["prv_txn"]."</prv_txn><sum>$sum</sum><result>0</result><comment>OK</comment>";
			return "<response>\n<osmp_txn_id>$txn_id</osmp_txn_id>\n<result>0</result>\n</response>";
}

function is_txn_id ($txn_id) {
	$qs = "select txn_id from `t_inet` where txn_id=$txn_id";
	$res =  mysql_query($qs) or die(mysql_error());
	return mysql_num_rows($res);
}

function get_new_prv_txn()
{
	$q = "SELECT max(`prv_txn`) AS `MAX_prv_txn` FROM t_inet";
  	$rq = mysql_query($q) or die(mysql_error());
	$r_txn = mysql_fetch_assoc($rq);
	return $r_txn["MAX_prv_txn"]+1;
}

function get_prv_txn($txn_id)
{
	$q = "SELECT * FROM t_inet where  txn_id=$txn_id";
  	$rq = mysql_query($q) or die(mysql_error());
	$r_txn = mysql_fetch_assoc($rq);
	return $r_txn;
}

function get_date2off($acc)
{
	if(($bd = get_Bill_acc($acc))==0) return 0;
	$q = "SELECT Date_pay FROM customers where Bill_Dog = $bd" ;
  	$rq = mysql_query($q) or die(mysql_error());
	$r_ = mysql_fetch_assoc($rq);
	return $r_["Date_pay"];
}
/*
function get_acc($account) {
	return $account;
	$r_acc =  mysql_query("select account from acc_bill where Bill_Dog=$account") or die(mysql_error());
	$acc = mysql_fetch_array($r_acc, MYSQL_ASSOC);
	return /*mysql_num_rows($acc)>0?* / $acc["account"];
}

function fcmd($fp, $cmd) {
	fputs ($fp, "$cmd\n");	$s = '';
	while (false !== ($char = fgetc($fp))) { $s .= "$char"; }
	return $s;
}

function getNic($s) {
	$n_ = explode(chr(9), strstr($s, "adder"));
	$nic = explode(chr(10), $n_[2]);	
	return $nic[0];
}
function getSum($s) {
	$s2 = ltrim(strstr(strstr($s, ")"), " "));
	$s3 = explode(" ", $s2);
	return $s3[0];
}
*/
function show_chr($s) {
	$i=0; 
	while ($i < strlen($s)) { 
		echo " ", $s{$i}==" "?"_":ord($s{$i}); 
		$i += 1; 
	}
}
?>