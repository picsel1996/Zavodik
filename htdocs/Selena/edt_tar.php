<?
require_once("for_form.php"); 
check_valid_user();
  $conn = db_connect();
  if (!$conn) return 0;

	// вот это нужно что бы браузер не кешировал страницу...
    header("ETag: PUB" . time());
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
    header("Pragma: no-cache");
    header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
    session_cache_limiter("nocache");
?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table width="700" border="0" cellpadding="2" cellspacing="1" >
<tr>
	<td bgcolor="<?php $cfg['BgcolorOne'] = "#E5E5E5"; $cfg['BgcolorTwo'] = "#D5D5D5";
		 echo $bgc = $cfg['BgcolorTwo']; ?>" align="center"> №</br>п/п</td>
	<td bgcolor="<?php echo $bgc; ?>">Наименование</br> краткое</td>
	<td bgcolor="<?php echo $bgc; ?>">Наименование</br> полное</td>
	<td bgcolor="<?php echo $bgc; ?>">Сумма</br> абонплаты</td>
	<td bgcolor="<?php echo $bgc; ?>">Коэффициент</br> к "Стандарт"</td>
	<td bgcolor="<?php echo $bgc; ?>">Доступно персоналу</td>
	<td bgcolor="<?php echo $bgc; ?>">VLan</td>
	<td bgcolor="<?php echo $bgc; ?>" align="center">тариф</td>
</tr>

<?
	$new = (isset($_REQUEST ["new"]))? $_REQUEST ["new"]:"";
	$new_p = (isset($_REQUEST ["new"]))? "new=new&":"";
	$menu_p = (isset($GLOBALS['menu']))? "menu=".$GLOBALS['menu']."&":"";
	$trg = (isset($GLOBALS["trg"]))? "trg=".$GLOBALS["trg_div"]."&":"";

	$id_tarifab = (isset($_REQUEST ["id_tarifab"]))? $_REQUEST ["id_tarifab"]:0;

	$s_qer = "SELECT * FROM `v_tarif`";
	$rslt = mysql_query($s_qer) or die(mysql_error());
	$row_rslt = mysql_fetch_assoc($rslt);
	$rows = mysql_num_rows($rslt);
	$totalRows_rslt = mysql_num_rows($rslt);

 //		if ($row_rslt['id_tarifab']!=0) {echo "<option value=0>выбор</option>";}
		$i = 1;
		do {
		$bgc = ($i++ % 3) ? $cfg['BgcolorOne'] : $cfg['BgcolorTwo'];	//; //	//document.forms.ulaForm.Menu_Item.value=\'pay\';op_f(\'pay\', \'Mform\');
			echo "<tr>";
			echo "<td bgcolor=$bgc align='center'>".$row_rslt['id_tarifab']."</td>";
			echo "<td bgcolor=$bgc>".$row_rslt['name_ab']."</td>";
			echo "<td bgcolor=$bgc>".$row_rslt['name_abon']."</td>";
			echo "<td bgcolor=$bgc>".$row_rslt['ab_sum']."</td>";
			echo "<td bgcolor=$bgc>".$row_rslt['k_tar']."</td>";
			echo "<td bgcolor=$bgc>".$row_rslt['NamePers']."</td>";//<input name='id_TypePers' type='hidden' value=''>
			echo "<td bgcolor=$bgc>".$row_rslt['VLan']."</td>";
				$s_id = $row_rslt['id_tarifab'].",\"".$row_rslt['name_ab']."\",\"".$row_rslt['name_abon']."\",\"".
						$row_rslt['ab_sum']."\",\"".$row_rslt['k_tar']."\",".($row_rslt['perstypes']-1).");}'>";
			echo "<td align='center'><a href='javascript:{sh_tar(\"cor\",".$s_id."измени</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:{sh_tar(\"del\",".$s_id."удалить</a></td>";
			echo "</tr>";//
//			$ab_tarifs[] = $row_rslt;
		} while ($row_rslt = mysql_fetch_assoc($rslt));
		/*f = document.forms.ulaForm;f.id_tarifab.value=".$row_rslt['id_tarifab'].
				";f.name_ab.value=\"".$row_rslt['name_ab']."\";f.name_abon.value=\"".$row_rslt['name_abon'].
				"\";f.ab_sum.value=\"".$row_rslt['ab_sum']."\";f.k_tar.value=\"".$row_rslt['k_tar'].
				"\";document.getElementById(\"perstypes\")[",$row_rslt['perstypes']-1,"].selected = true;
		*/
?>
<tr><td>&nbsp;</td></tr>
<tr>
<?			$bgc = ($i++ % 3) ? $cfg['BgcolorOne'] : $cfg['BgcolorTwo']; ?>
			<td bgcolor=<? echo $bgc?> align='center'><input name='id_tarifab' size=3 readonly='true' value='<? echo $rows+1 ?>' /></td>
			<td bgcolor=<? echo $bgc?>><input name='name_ab' size=10 /></td>
			<td bgcolor=<? echo $bgc?>><input name='name_abon' size=17 /></td>
			<td bgcolor=<? echo $bgc?>><input name='ab_sum' size=3 /></td>
			<td bgcolor=<? echo $bgc?>><input name='k_tar' value=1 size=3 /></td>
			<td bgcolor=<? echo $bgc?> align='center'>
		<select name="perstypes" class='headText' id="perstypes" lang="ru" onchange=''>
<?			$s_qer = "SELECT * FROM `spr_perstype`";
			$rslt = mysql_query($s_qer) or die(mysql_error());
			while ($row_rslt = mysql_fetch_assoc($rslt)) { ?>
				<option value="<? echo $row_rslt['id_TypePers'] ?>" ><? echo $row_rslt['NamePers']?></option>
<?			} ?>
		</select>
	</td>
	<td bgcolor=<? echo $bgc?>><input name='vlan' value=0 size=3 /></td>
	<td colspan="2">
		<div id="B_">
		<input type="button" onclick="ch_param('cor_ab','cmd=\'add\'&'+f_tar(),'B_');" value="Добавить тариф"/>
		</div>
	</td>
</tr>
<?
///	}op_f('edt_tar', 'Mform');
?>