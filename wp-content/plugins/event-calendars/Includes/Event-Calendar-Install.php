<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	global $wpdb;

	$table_name  = $wpdb->prefix . "totalsoft_fonts";
	$table_name1 = $wpdb->prefix . "totalsoft_evcal_ids";
	$table_name2 = $wpdb->prefix . "totalsoft_evcal_manager";
	$table_name3 = $wpdb->prefix . "totalsoft_evcal_events";
	$table_name4 = $wpdb->prefix . "totalsoft_evcal_eff_data";
	$table_name5 = $wpdb->prefix . "totalsoft_evcal_eff_p1";
	$table_name6 = $wpdb->prefix . "totalsoft_evcal_eff_p2";

	$sql = 'CREATE TABLE IF NOT EXISTS ' .$table_name . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		Font VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';
	$sql1 = 'CREATE TABLE IF NOT EXISTS ' .$table_name1 . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		EvCal_ID VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';
	$sql2 = 'CREATE TABLE IF NOT EXISTS ' .$table_name2 . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		Total_Soft_Cal_Ev_Name VARCHAR(255) NOT NULL,
		Total_Soft_Cal_Ev_Theme VARCHAR(255) NOT NULL,
		Total_Soft_Cal_Ev_ECount VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';
	$sql3 = 'CREATE TABLE IF NOT EXISTS ' .$table_name3 . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		EvCal_ID VARCHAR(255) NOT NULL,
		TS_Cal_Ev_Title VARCHAR(255) NOT NULL,
		TS_Cal_Ev_Color VARCHAR(255) NOT NULL,
		TS_Cal_Ev_Date VARCHAR(255) NOT NULL,
		TS_Cal_Ev_Desc LONGTEXT NOT NULL,
		TS_Cal_Ev_01 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_02 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_03 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_04 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_05 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_06 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_07 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_08 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_09 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_10 VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';
	$sql4 = 'CREATE TABLE IF NOT EXISTS ' .$table_name4 . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		TS_Cal_Ev_TName VARCHAR(255) NOT NULL,
		TS_Cal_Ev_TType VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';
	$sql5 = 'CREATE TABLE IF NOT EXISTS ' .$table_name5 . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		TS_Cal_Ev_T_ID VARCHAR(255) NOT NULL,
		TS_Cal_Ev_TName VARCHAR(255) NOT NULL,
		TS_Cal_Ev_TType VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_01 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_02 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_03 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_04 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_05 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_06 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_07 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_08 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_09 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_10 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_11 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_12 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_13 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_14 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_15 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_16 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_17 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_18 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_19 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_20 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_21 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_22 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_23 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_24 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_25 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_26 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_27 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_28 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_29 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_30 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_31 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_32 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_33 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_34 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_35 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_36 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_37 VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';
	$sql6 = 'CREATE TABLE IF NOT EXISTS ' .$table_name6 . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		TS_Cal_Ev_T_ID VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_01 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_02 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_03 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_04 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_05 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_06 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_07 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_08 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_09 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_10 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_11 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_12 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_13 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_14 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_15 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_16 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_17 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_18 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_19 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_20 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_21 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_22 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_23 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_24 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_25 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_26 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_27 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_28 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_29 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_30 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_31 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_32 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_33 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_34 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_35 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_36 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_37 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_38 VARCHAR(255) NOT NULL,
		TS_Cal_Ev_T_E_39 VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	dbDelta($sql1);
	dbDelta($sql2);
	dbDelta($sql3);
	dbDelta($sql4);
	dbDelta($sql5);
	dbDelta($sql6);

	$sqla   = 'ALTER TABLE ' . $table_name . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
	$sqla1  = 'ALTER TABLE ' . $table_name1 . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
	$sqla2  = 'ALTER TABLE ' . $table_name2 . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
	$sqla3  = 'ALTER TABLE ' . $table_name3 . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
	$sqla4  = 'ALTER TABLE ' . $table_name4 . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
	$sqla5  = 'ALTER TABLE ' . $table_name5 . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
	$sqla6  = 'ALTER TABLE ' . $table_name6 . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';

	$wpdb->query($sqla);
	$wpdb->query($sqla1);
	$wpdb->query($sqla2);
	$wpdb->query($sqla3);
	$wpdb->query($sqla4);
	$wpdb->query($sqla5);
	$wpdb->query($sqla6);

	$TotalSoft_Fonts = array('Abadi MT Condensed Light','Aharoni','Aldhabi','Andalus','Angsana New','AngsanaUPC','Aparajita','Arabic Typesetting','Arial','Arial Black', 'Batang','BatangChe','Browallia New','BrowalliaUPC','Calibri','Calibri Light','Calisto MT','Cambria','Candara','Century Gothic','Comic Sans MS','Consolas', 'Constantia','Copperplate Gothic','Copperplate Gothic Light','Corbel','Cordia New','CordiaUPC','Courier New','DaunPenh','David','DFKai-SB','DilleniaUPC', 'DokChampa','Dotum','DotumChe','Ebrima','Estrangelo Edessa','EucrosiaUPC','Euphemia','FangSong','Franklin Gothic Medium','FrankRuehl','FreesiaUPC','Gabriola', 'Gadugi','Gautami','Georgia','Gisha','Gulim','GulimChe','Gungsuh','GungsuhChe','Impact','IrisUPC','Iskoola Pota','JasmineUPC','KaiTi','Kalinga','Kartika', 'Khmer UI','KodchiangUPC','Kokila','Lao UI','Latha','Leelawadee','Levenim MT','LilyUPC','Lucida Console','Lucida Handwriting Italic','Lucida Sans Unicode', 'Malgun Gothic','Mangal','Manny ITC','Marlett','Meiryo','Meiryo UI','Microsoft Himalaya','Microsoft JhengHei','Microsoft JhengHei UI','Microsoft New Tai Lue', 'Microsoft PhagsPa','Microsoft Sans Serif','Microsoft Tai Le','Microsoft Uighur','Microsoft YaHei','Microsoft YaHei UI','Microsoft Yi Baiti','MingLiU_HKSCS', 'MingLiU_HKSCS-ExtB','Miriam','Mongolian Baiti','MoolBoran','MS UI Gothic','MV Boli','Myanmar Text','Narkisim','Nirmala UI','News Gothic MT','NSimSun','Nyala', 'Palatino Linotype','Plantagenet Cherokee','Raavi','Rod','Sakkal Majalla','Segoe Print','Segoe Script','Segoe UI Symbol','Shonar Bangla','Shruti','SimHei','SimKai', 'Simplified Arabic','SimSun','SimSun-ExtB','Sylfaen','Tahoma','Times New Roman','Traditional Arabic','Trebuchet MS','Tunga','Utsaah','Vani','Vijaya');
	
	$TotalSoftFontCount=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id>%d",0));
	if(count($TotalSoftFontCount)==0)
	{
		foreach ($TotalSoft_Fonts as $Fonts) 
		{
			$wpdb->query($wpdb->prepare("INSERT INTO $table_name (id, Font) VALUES (%d, %s)", '', $Fonts));
		}
	}

	$TotalSoft_T1=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE id>%d",0));

	if(count($TotalSoft_T1)==0)
	{
		// 1
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, TS_Cal_Ev_TName, TS_Cal_Ev_TType) VALUES (%d, %s, %s)", '', 'Popover Calendar 1', 'Popover Calendar'));

		$TotalSoft_T1_ID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE TS_Cal_Ev_TName = %s", 'Popover Calendar 1'));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name5 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_TName, TS_Cal_Ev_TType, TS_Cal_Ev_T_01, TS_Cal_Ev_T_02, TS_Cal_Ev_T_03, TS_Cal_Ev_T_04, TS_Cal_Ev_T_05, TS_Cal_Ev_T_06, TS_Cal_Ev_T_07, TS_Cal_Ev_T_08, TS_Cal_Ev_T_09, TS_Cal_Ev_T_10, TS_Cal_Ev_T_11, TS_Cal_Ev_T_12, TS_Cal_Ev_T_13, TS_Cal_Ev_T_14, TS_Cal_Ev_T_15, TS_Cal_Ev_T_16, TS_Cal_Ev_T_17, TS_Cal_Ev_T_18, TS_Cal_Ev_T_19, TS_Cal_Ev_T_20, TS_Cal_Ev_T_21, TS_Cal_Ev_T_22, TS_Cal_Ev_T_23, TS_Cal_Ev_T_24, TS_Cal_Ev_T_25, TS_Cal_Ev_T_26, TS_Cal_Ev_T_27, TS_Cal_Ev_T_28, TS_Cal_Ev_T_29, TS_Cal_Ev_T_30, TS_Cal_Ev_T_31, TS_Cal_Ev_T_32, TS_Cal_Ev_T_33, TS_Cal_Ev_T_34, TS_Cal_Ev_T_35, TS_Cal_Ev_T_36, TS_Cal_Ev_T_37) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, 'Popover Calendar 1', 'Popover Calendar', '600', '1', '#ffffff', '#026077', '#026077', 'Yes', '2', '10', '#026077', '#026077', '3', '#014963', 'Abadi MT Condensed Light', '20', '#ffffff', '22', '#ffffff', '2', 'long-arrow', '#ffffff', '21', '#dbdbdb', '2', '#014963', '#014963', '#ffffff', '19', 'Abadi MT Condensed Light', '#ffffff', '#014963', '#ffffff', '#dd3333', '#e8e8e8', '#dd3333', 'Yes', '#dd3333', '#dd0000'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name6 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_T_E_01, TS_Cal_Ev_T_E_02, TS_Cal_Ev_T_E_03, TS_Cal_Ev_T_E_04, TS_Cal_Ev_T_E_05, TS_Cal_Ev_T_E_06, TS_Cal_Ev_T_E_07, TS_Cal_Ev_T_E_08, TS_Cal_Ev_T_E_09, TS_Cal_Ev_T_E_10, TS_Cal_Ev_T_E_11, TS_Cal_Ev_T_E_12, TS_Cal_Ev_T_E_13, TS_Cal_Ev_T_E_14, TS_Cal_Ev_T_E_15, TS_Cal_Ev_T_E_16, TS_Cal_Ev_T_E_17, TS_Cal_Ev_T_E_18, TS_Cal_Ev_T_E_19, TS_Cal_Ev_T_E_20, TS_Cal_Ev_T_E_21, TS_Cal_Ev_T_E_22, TS_Cal_Ev_T_E_23, TS_Cal_Ev_T_E_24, TS_Cal_Ev_T_E_25, TS_Cal_Ev_T_E_26, TS_Cal_Ev_T_E_27, TS_Cal_Ev_T_E_28, TS_Cal_Ev_T_E_29, TS_Cal_Ev_T_E_30, TS_Cal_Ev_T_E_31, TS_Cal_Ev_T_E_32, TS_Cal_Ev_T_E_33, TS_Cal_Ev_T_E_34, TS_Cal_Ev_T_E_35, TS_Cal_Ev_T_E_36, TS_Cal_Ev_T_E_37, TS_Cal_Ev_T_E_38, TS_Cal_Ev_T_E_39) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, '400', '300', '2', '#018999', '#014963', '0', '#00c48f', '3', 'MM dd, yy', '#ffffff', '#014963', 'center', '14', 'Arial', '1', '#014963', '#014963', '#ffffff', '17', 'Abadi MT Condensed Light', 'center', '70', '1', '#ffffff', '#ffffff', '#ffffff', '#e8e8e8', '400', '', '', '', '', '', '', '', '', '', '', ''));
		// 2
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, TS_Cal_Ev_TName, TS_Cal_Ev_TType) VALUES (%d, %s, %s)", '', 'Popover Calendar 2', 'Popover Calendar'));

		$TotalSoft_T1_ID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE TS_Cal_Ev_TName = %s", 'Popover Calendar 2'));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name5 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_TName, TS_Cal_Ev_TType, TS_Cal_Ev_T_01, TS_Cal_Ev_T_02, TS_Cal_Ev_T_03, TS_Cal_Ev_T_04, TS_Cal_Ev_T_05, TS_Cal_Ev_T_06, TS_Cal_Ev_T_07, TS_Cal_Ev_T_08, TS_Cal_Ev_T_09, TS_Cal_Ev_T_10, TS_Cal_Ev_T_11, TS_Cal_Ev_T_12, TS_Cal_Ev_T_13, TS_Cal_Ev_T_14, TS_Cal_Ev_T_15, TS_Cal_Ev_T_16, TS_Cal_Ev_T_17, TS_Cal_Ev_T_18, TS_Cal_Ev_T_19, TS_Cal_Ev_T_20, TS_Cal_Ev_T_21, TS_Cal_Ev_T_22, TS_Cal_Ev_T_23, TS_Cal_Ev_T_24, TS_Cal_Ev_T_25, TS_Cal_Ev_T_26, TS_Cal_Ev_T_27, TS_Cal_Ev_T_28, TS_Cal_Ev_T_29, TS_Cal_Ev_T_30, TS_Cal_Ev_T_31, TS_Cal_Ev_T_32, TS_Cal_Ev_T_33, TS_Cal_Ev_T_34, TS_Cal_Ev_T_35, TS_Cal_Ev_T_36, TS_Cal_Ev_T_37) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, 'Popover Calendar 2', 'Popover Calendar', '850', '0', '#ffffff', '#f2f2f2', '#f2f2f2', 'Yes', '2', '10', '#bcbcbc', '#ea003e', '2', '#000000', 'Calibri', '16', '#ffffff', '19', '#ffffff', '4', 'caret', '#c60035', '30', '#9e002a', '2', '#000000', '#f2f2f2', '#c60035', '18', 'Calibri', '#ffffff', '#494949', '#f2f2f2', '#ea003e', '#e5e5e5', '#ea003e', 'Yes', '#ffffff', '#ffffff'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name6 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_T_E_01, TS_Cal_Ev_T_E_02, TS_Cal_Ev_T_E_03, TS_Cal_Ev_T_E_04, TS_Cal_Ev_T_E_05, TS_Cal_Ev_T_E_06, TS_Cal_Ev_T_E_07, TS_Cal_Ev_T_E_08, TS_Cal_Ev_T_E_09, TS_Cal_Ev_T_E_10, TS_Cal_Ev_T_E_11, TS_Cal_Ev_T_E_12, TS_Cal_Ev_T_E_13, TS_Cal_Ev_T_E_14, TS_Cal_Ev_T_E_15, TS_Cal_Ev_T_E_16, TS_Cal_Ev_T_E_17, TS_Cal_Ev_T_E_18, TS_Cal_Ev_T_E_19, TS_Cal_Ev_T_E_20, TS_Cal_Ev_T_E_21, TS_Cal_Ev_T_E_22, TS_Cal_Ev_T_E_23, TS_Cal_Ev_T_E_24, TS_Cal_Ev_T_E_25, TS_Cal_Ev_T_E_26, TS_Cal_Ev_T_E_27, TS_Cal_Ev_T_E_28, TS_Cal_Ev_T_E_29, TS_Cal_Ev_T_E_30, TS_Cal_Ev_T_E_31, TS_Cal_Ev_T_E_32, TS_Cal_Ev_T_E_33, TS_Cal_Ev_T_E_34, TS_Cal_Ev_T_E_35, TS_Cal_Ev_T_E_36, TS_Cal_Ev_T_E_37, TS_Cal_Ev_T_E_38, TS_Cal_Ev_T_E_39) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, '409', '353', '1', 'rgba(255,255,255,0.92)', '#ffffff', '0', '#ffffff', '2', 'MM dd, yy', '#ffffff', '#ea003e', 'center', '22', 'Calibri', '1', '#ededed', '#ffffff', '#ea003e', '20', 'Calibri', 'left', '80', '1', '#ededed', '#ffffff', '#ea003e', '#e5e5e5', '400', '', '', '', '', '', '', '', '', '', '', ''));
		// 3
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, TS_Cal_Ev_TName, TS_Cal_Ev_TType) VALUES (%d, %s, %s)", '', 'Popover Calendar 3', 'Popover Calendar'));

		$TotalSoft_T1_ID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE TS_Cal_Ev_TName = %s", 'Popover Calendar 3'));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name5 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_TName, TS_Cal_Ev_TType, TS_Cal_Ev_T_01, TS_Cal_Ev_T_02, TS_Cal_Ev_T_03, TS_Cal_Ev_T_04, TS_Cal_Ev_T_05, TS_Cal_Ev_T_06, TS_Cal_Ev_T_07, TS_Cal_Ev_T_08, TS_Cal_Ev_T_09, TS_Cal_Ev_T_10, TS_Cal_Ev_T_11, TS_Cal_Ev_T_12, TS_Cal_Ev_T_13, TS_Cal_Ev_T_14, TS_Cal_Ev_T_15, TS_Cal_Ev_T_16, TS_Cal_Ev_T_17, TS_Cal_Ev_T_18, TS_Cal_Ev_T_19, TS_Cal_Ev_T_20, TS_Cal_Ev_T_21, TS_Cal_Ev_T_22, TS_Cal_Ev_T_23, TS_Cal_Ev_T_24, TS_Cal_Ev_T_25, TS_Cal_Ev_T_26, TS_Cal_Ev_T_27, TS_Cal_Ev_T_28, TS_Cal_Ev_T_29, TS_Cal_Ev_T_30, TS_Cal_Ev_T_31, TS_Cal_Ev_T_32, TS_Cal_Ev_T_33, TS_Cal_Ev_T_34, TS_Cal_Ev_T_35, TS_Cal_Ev_T_36, TS_Cal_Ev_T_37) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, 'Popover Calendar 3', 'Popover Calendar', '500', '1', '#ededed', '#ffffff', 'rgba(129,215,66,0)', 'Yes', '1', '4', '#d6d6d6', '#00e803', '0', '#ffffff', 'Abadi MT Condensed Light', '18', '#ffffff', '18', '#ffffff', '4', 'chevron-circle', '#ededed', '20', '#ededed', '0', '#2400a8', '#1e73be', '#ffffff', '10', 'Abadi MT Condensed Light', '#ededed', '#1e73be', '#1e73be', '#ffffff', '#1e73be', '#e0e0e0', 'No', '#077a6e', '#f40041'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name6 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_T_E_01, TS_Cal_Ev_T_E_02, TS_Cal_Ev_T_E_03, TS_Cal_Ev_T_E_04, TS_Cal_Ev_T_E_05, TS_Cal_Ev_T_E_06, TS_Cal_Ev_T_E_07, TS_Cal_Ev_T_E_08, TS_Cal_Ev_T_E_09, TS_Cal_Ev_T_E_10, TS_Cal_Ev_T_E_11, TS_Cal_Ev_T_E_12, TS_Cal_Ev_T_E_13, TS_Cal_Ev_T_E_14, TS_Cal_Ev_T_E_15, TS_Cal_Ev_T_E_16, TS_Cal_Ev_T_E_17, TS_Cal_Ev_T_E_18, TS_Cal_Ev_T_E_19, TS_Cal_Ev_T_E_20, TS_Cal_Ev_T_E_21, TS_Cal_Ev_T_E_22, TS_Cal_Ev_T_E_23, TS_Cal_Ev_T_E_24, TS_Cal_Ev_T_E_25, TS_Cal_Ev_T_E_26, TS_Cal_Ev_T_E_27, TS_Cal_Ev_T_E_28, TS_Cal_Ev_T_E_29, TS_Cal_Ev_T_E_30, TS_Cal_Ev_T_E_31, TS_Cal_Ev_T_E_32, TS_Cal_Ev_T_E_33, TS_Cal_Ev_T_E_34, TS_Cal_Ev_T_E_35, TS_Cal_Ev_T_E_36, TS_Cal_Ev_T_E_37, TS_Cal_Ev_T_E_38, TS_Cal_Ev_T_E_39) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, '371', '244', '1', '#ffffff', '#ffffff', '4', '#ffffff', '5', 'dd-mm-yy', '#1e73be', '#ffffff', 'center', '20', 'Abadi MT Condensed Light', '0', '#ffffff', '#1e73be', '#e0e0e0', '18', 'Abadi MT Condensed Light', 'center', '100', '0', '#ffffff', '#ffffff', '#ffffff', '#1e73be', '400', '', '', '', '', '', '', '', '', '', '', ''));
		// 4
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, TS_Cal_Ev_TName, TS_Cal_Ev_TType) VALUES (%d, %s, %s)", '', 'Popover Calendar 4', 'Popover Calendar'));

		$TotalSoft_T1_ID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE TS_Cal_Ev_TName = %s", 'Popover Calendar 4'));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name5 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_TName, TS_Cal_Ev_TType, TS_Cal_Ev_T_01, TS_Cal_Ev_T_02, TS_Cal_Ev_T_03, TS_Cal_Ev_T_04, TS_Cal_Ev_T_05, TS_Cal_Ev_T_06, TS_Cal_Ev_T_07, TS_Cal_Ev_T_08, TS_Cal_Ev_T_09, TS_Cal_Ev_T_10, TS_Cal_Ev_T_11, TS_Cal_Ev_T_12, TS_Cal_Ev_T_13, TS_Cal_Ev_T_14, TS_Cal_Ev_T_15, TS_Cal_Ev_T_16, TS_Cal_Ev_T_17, TS_Cal_Ev_T_18, TS_Cal_Ev_T_19, TS_Cal_Ev_T_20, TS_Cal_Ev_T_21, TS_Cal_Ev_T_22, TS_Cal_Ev_T_23, TS_Cal_Ev_T_24, TS_Cal_Ev_T_25, TS_Cal_Ev_T_26, TS_Cal_Ev_T_27, TS_Cal_Ev_T_28, TS_Cal_Ev_T_29, TS_Cal_Ev_T_30, TS_Cal_Ev_T_31, TS_Cal_Ev_T_32, TS_Cal_Ev_T_33, TS_Cal_Ev_T_34, TS_Cal_Ev_T_35, TS_Cal_Ev_T_36, TS_Cal_Ev_T_37) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, 'Popover Calendar 4', 'Popover Calendar', '600', '1', '#ffffff', '#ddaa33', '#ddaa33', 'No', '2', '4', '#d6d6d6', '#ffffff', '2', '#ddaa33', 'Vijaya', '23', '#ddaa33', '23', '#000000', '4', 'long-arrow', '#000000', '25', '#ddaa33', '0', '#2400a8', '#ddaa33', '#ffffff', '16', 'Vijaya', '#ffffff', '#6d6d6d', '#ddaa33', '#ffffff', '#dda31c', '#e0e0e0', 'Yes', '#ffffff', '#ffffff'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name6 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_T_E_01, TS_Cal_Ev_T_E_02, TS_Cal_Ev_T_E_03, TS_Cal_Ev_T_E_04, TS_Cal_Ev_T_E_05, TS_Cal_Ev_T_E_06, TS_Cal_Ev_T_E_07, TS_Cal_Ev_T_E_08, TS_Cal_Ev_T_E_09, TS_Cal_Ev_T_E_10, TS_Cal_Ev_T_E_11, TS_Cal_Ev_T_E_12, TS_Cal_Ev_T_E_13, TS_Cal_Ev_T_E_14, TS_Cal_Ev_T_E_15, TS_Cal_Ev_T_E_16, TS_Cal_Ev_T_E_17, TS_Cal_Ev_T_E_18, TS_Cal_Ev_T_E_19, TS_Cal_Ev_T_E_20, TS_Cal_Ev_T_E_21, TS_Cal_Ev_T_E_22, TS_Cal_Ev_T_E_23, TS_Cal_Ev_T_E_24, TS_Cal_Ev_T_E_25, TS_Cal_Ev_T_E_26, TS_Cal_Ev_T_E_27, TS_Cal_Ev_T_E_28, TS_Cal_Ev_T_E_29, TS_Cal_Ev_T_E_30, TS_Cal_Ev_T_E_31, TS_Cal_Ev_T_E_32, TS_Cal_Ev_T_E_33, TS_Cal_Ev_T_E_34, TS_Cal_Ev_T_E_35, TS_Cal_Ev_T_E_36, TS_Cal_Ev_T_E_37, TS_Cal_Ev_T_E_38, TS_Cal_Ev_T_E_39) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, '371', '273', '1', '#ddaa33', '#ffffff', '4', '#ffffff', '5', 'dd-mm-yy', '#000000', '#ffffff', 'center', '20', 'Abadi MT Condensed Light', '0', '#ffffff', '#dd9b00', '#ffffff', '18', 'Abadi MT Condensed Light', 'center', '100', '0', '#ffffff', '#ffffff', '#dd9933', '#ffffff', '400', '', '', '', '', '', '', '', '', '', '', ''));		
	}
?>