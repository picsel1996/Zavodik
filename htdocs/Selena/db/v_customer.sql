-- phpMyAdmin SQL Dump
-- version 3.4.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 02 2012 г., 04:09
-- Версия сервера: 5.0.67
-- Версия PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `Selena`
--

-- --------------------------------------------------------

--
-- Структура для представления `v_customer`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_customer` AS select `customers`.`Bill_Dog` AS `Bill_Dog`,`customers`.`Nic` AS `Nic`,`customers`.`id_Podjezd` AS `id_Podjezd`,`spr_street`.`name_street` AS `name_street`,`spr_build`.`Num_build` AS `Num_build`,`customers`.`flat` AS `flat`,`customers`.`IP` AS `IP`,`customers`.`mac` AS `mac`,`customers`.`pasp_Ser` AS `pasp_Ser`,`customers`.`pasp_Num` AS `pasp_Num`,`customers`.`pasp_Date` AS `pasp_Date`,`customers`.`pasp_Uvd` AS `pasp_Uvd`,`customers`.`phone_Home` AS `phone_Home`,`customers`.`phone_Cell` AS `phone_Cell`,`customers`.`phone_Work` AS `phone_Work`,`customers`.`Jur` AS `Jur`,`customers`.`Birthday` AS `Birthday`,`customers`.`pasp_Adr` AS `pasp_Adr`,`customers`.`Fam` AS `Fam`,`customers`.`Name` AS `Name`,`customers`.`Father` AS `Father`,`spr_tarifab`.`name_ab` AS `name_ab`,`spr_podjezd`.`Podjezd` AS `Podjezd`,`spr_build`.`Korpus` AS `Korpus`,`customers`.`id_tarifab` AS `id_tarifab`,`customers`.`TabNum` AS `TabNum`,`customers`.`DateKor` AS `DateKor`,`customers`.`tarifab_date` AS `tarifab_date`,`customers`.`From_Net` AS `From_Net`,`customers`.`Cod_flat` AS `Cod_flat`,`customers`.`Comment` AS `Comment`,`customers`.`Bill_frend` AS `Bill_frend`,`customers`.`state` AS `state`,`customers`.`conn` AS `conn`,`spr_podjezd`.`FirstFlat` AS `FirstFlat`,`spr_podjezd`.`LastFlat` AS `LastFlat`,`spr_build`.`id_street` AS `id_street`,`customers`.`Date_start_st` AS `Date_start_st`,`customers`.`Date_end_st` AS `Date_end_st`,`spr_region`.`RegionName` AS `RegionName`,`spr_tarifab`.`name_abon` AS `name_abon`,`spr_tarifab`.`con_sum` AS `con_sum`,`spr_tarifab`.`opl_period` AS `opl_period`,`spr_tarifab`.`ab_sum` AS `ab_sum`,`spr_tarifab`.`con_typ` AS `con_typ`,`personal`.`TabNum` AS `m_TabNum`,`spr_build`.`id_korp` AS `id_korp`,`customers`.`Date_pay` AS `Date_pay`,`spr_town`.`Town` AS `Town`,`customers`.`inet` AS `inet`,`customers`.`cost` AS `cost`,`customers`.`Saldo` AS `Saldo`,`customers`.`floor` AS `floor` from (((((((`customers` join `spr_street`) left join `spr_tarifab` on((`customers`.`id_tarifab` = `spr_tarifab`.`id_tarifab`))) left join `spr_podjezd` on((`customers`.`id_Podjezd` = `spr_podjezd`.`id_Podjezd`))) join `spr_build` on(((`spr_podjezd`.`id_korp` = `spr_build`.`id_korp`) and (`spr_build`.`id_street` = `spr_street`.`id_street`)))) left join `spr_region` on((`spr_build`.`id_Region` = `spr_region`.`id_Region`))) left join `personal` on((`spr_region`.`id_Region` = `personal`.`id_Region`))) join `spr_town` on((`spr_street`.`id_Town` = `spr_town`.`id_Town`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
