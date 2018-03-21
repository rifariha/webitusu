<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	global $wpdb;

	$table_name  = $wpdb->prefix . "totalsoft_fonts";
	$table_name4 = $wpdb->prefix . "totalsoft_evcal_eff_data";
	$table_name5 = $wpdb->prefix . "totalsoft_evcal_eff_p1";
	$table_name6 = $wpdb->prefix . "totalsoft_evcal_eff_p2";

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if(check_admin_referer( 'edit-menu_'.$comment_id, 'TS_EvCal_Nonce' ))
		{
			$TS_Cal_Ev_TName = str_replace("\&","&", sanitize_text_field(esc_html($_POST['TS_Cal_Ev_TName'])));
			$TS_Cal_Ev_TType = sanitize_text_field($_POST['TS_Cal_Ev_TType']);
			// Popover Calendar P1
			$TS_Cal_Ev_T_01 = sanitize_text_field($_POST['TS_Cal_Ev_T1_MW']); $TS_Cal_Ev_T_02 = sanitize_text_field($_POST['TS_Cal_Ev_T1_WDS']); $TS_Cal_Ev_T_03 = sanitize_text_field($_POST['TS_Cal_Ev_T1_BgC']); $TS_Cal_Ev_T_04 = sanitize_text_field($_POST['TS_Cal_Ev_T1_GrC']); $TS_Cal_Ev_T_05 = sanitize_text_field($_POST['TS_Cal_Ev_T1_BBC']); $TS_Cal_Ev_T_06 = sanitize_text_field($_POST['TS_Cal_Ev_T1_BShShow']); $TS_Cal_Ev_T_07 = sanitize_text_field($_POST['TS_Cal_Ev_T1_BShType']); $TS_Cal_Ev_T_08 = sanitize_text_field($_POST['TS_Cal_Ev_T1_BSh']); $TS_Cal_Ev_T_09 = sanitize_text_field($_POST['TS_Cal_Ev_T1_BShC']); $TS_Cal_Ev_T_10 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_BgC']); $TS_Cal_Ev_T_11 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_BTW']); $TS_Cal_Ev_T_12 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_BTC']); $TS_Cal_Ev_T_13 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_FF']); $TS_Cal_Ev_T_14 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_MFS']); $TS_Cal_Ev_T_15 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_MC']); $TS_Cal_Ev_T_16 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_YFS']); $TS_Cal_Ev_T_17 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_YC']); $TS_Cal_Ev_T_18 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H_Format']); $TS_Cal_Ev_T_19 = sanitize_text_field($_POST['TS_Cal_Ev_T1_Arr_Type']); $TS_Cal_Ev_T_20 = sanitize_text_field($_POST['TS_Cal_Ev_T1_Arr_C']); $TS_Cal_Ev_T_21 = sanitize_text_field($_POST['TS_Cal_Ev_T1_Arr_S']); $TS_Cal_Ev_T_22 = sanitize_text_field($_POST['TS_Cal_Ev_T1_Arr_HC']); $TS_Cal_Ev_T_23 = sanitize_text_field($_POST['TS_Cal_Ev_T1_LAH_W']); $TS_Cal_Ev_T_24 = sanitize_text_field($_POST['TS_Cal_Ev_T1_LAH_C']); $TS_Cal_Ev_T_25 = sanitize_text_field($_POST['TS_Cal_Ev_T1_WD_BgC']); $TS_Cal_Ev_T_26 = sanitize_text_field($_POST['TS_Cal_Ev_T1_WD_C']); $TS_Cal_Ev_T_27 = sanitize_text_field($_POST['TS_Cal_Ev_T1_WD_FS']); $TS_Cal_Ev_T_28 = sanitize_text_field($_POST['TS_Cal_Ev_T1_WD_FF']); $TS_Cal_Ev_T_29 = sanitize_text_field($_POST['TS_Cal_Ev_T1_D_BgC']); $TS_Cal_Ev_T_30 = sanitize_text_field($_POST['TS_Cal_Ev_T1_D_C']); $TS_Cal_Ev_T_31 = sanitize_text_field($_POST['TS_Cal_Ev_T1_TD_BgC']); $TS_Cal_Ev_T_32 = sanitize_text_field($_POST['TS_Cal_Ev_T1_TD_C']); $TS_Cal_Ev_T_33 = sanitize_text_field($_POST['TS_Cal_Ev_T1_HD_BgC']); $TS_Cal_Ev_T_34 = sanitize_text_field($_POST['TS_Cal_Ev_T1_HD_C']); $TS_Cal_Ev_T_35 = sanitize_text_field($_POST['TS_Cal_Ev_T1_ED_DShow']); $TS_Cal_Ev_T_36 = sanitize_text_field($_POST['TS_Cal_Ev_T1_ED_C']); $TS_Cal_Ev_T_37 = sanitize_text_field($_POST['TS_Cal_Ev_T1_ED_HC']);
			// Popover Calendar P2
			$TS_Cal_Ev_T_E_01 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_MW']); $TS_Cal_Ev_T_E_02 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_MH']); $TS_Cal_Ev_T_E_03 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_BgT']); $TS_Cal_Ev_T_E_04 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_Bg1']); $TS_Cal_Ev_T_E_05 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_Bg2']); $TS_Cal_Ev_T_E_06 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_BW']); $TS_Cal_Ev_T_E_07 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_BC']); $TS_Cal_Ev_T_E_08 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_BR']); $TS_Cal_Ev_T_E_09 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_D_F']); $TS_Cal_Ev_T_E_10 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_D_BgC']); $TS_Cal_Ev_T_E_11 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_D_C']); $TS_Cal_Ev_T_E_12 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_D_TA']); $TS_Cal_Ev_T_E_13 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_D_FS']); $TS_Cal_Ev_T_E_14 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_D_FF']); $TS_Cal_Ev_T_E_15 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_D_BBW']); $TS_Cal_Ev_T_E_16 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_D_BBC']); $TS_Cal_Ev_T_E_17 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_T_BgC']); $TS_Cal_Ev_T_E_18 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_T_C']); $TS_Cal_Ev_T_E_19 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_T_FS']); $TS_Cal_Ev_T_E_20 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_T_FF']); $TS_Cal_Ev_T_E_21 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_T_TA']); $TS_Cal_Ev_T_E_22 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_LAE_W']); $TS_Cal_Ev_T_E_23 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_LAE_H']); $TS_Cal_Ev_T_E_24 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_LAE_C']); $TS_Cal_Ev_T_E_25 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_C']); $TS_Cal_Ev_T_E_26 = sanitize_text_field($_POST['TS_Cal_Ev_T1_E_HC']); $TS_Cal_Ev_T_E_27 = sanitize_text_field($_POST['TS_Cal_Ev_T1_ED_HBgC']); $TS_Cal_Ev_T_E_28 = sanitize_text_field($_POST['TS_Cal_Ev_T1_H']); $TS_Cal_Ev_T_E_29 = ''; $TS_Cal_Ev_T_E_30 = ''; $TS_Cal_Ev_T_E_31 = ''; $TS_Cal_Ev_T_E_32 = ''; $TS_Cal_Ev_T_E_33 = ''; $TS_Cal_Ev_T_E_34 = ''; $TS_Cal_Ev_T_E_35 = ''; $TS_Cal_Ev_T_E_36 = ''; $TS_Cal_Ev_T_E_37 = ''; $TS_Cal_Ev_T_E_38 = ''; $TS_Cal_Ev_T_E_39 = '';

			if(isset($_POST['Total_Soft_Cal_Ev_T_Save']))
			{
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, TS_Cal_Ev_TName, TS_Cal_Ev_TType) VALUES (%d, %s, %s)", '', $TS_Cal_Ev_TName, $TS_Cal_Ev_TType));

				$TotalSoft_T1_ID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE TS_Cal_Ev_TName = %s", $TS_Cal_Ev_TName));

				$wpdb->query($wpdb->prepare("INSERT INTO $table_name5 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_TName, TS_Cal_Ev_TType, TS_Cal_Ev_T_01, TS_Cal_Ev_T_02, TS_Cal_Ev_T_03, TS_Cal_Ev_T_04, TS_Cal_Ev_T_05, TS_Cal_Ev_T_06, TS_Cal_Ev_T_07, TS_Cal_Ev_T_08, TS_Cal_Ev_T_09, TS_Cal_Ev_T_10, TS_Cal_Ev_T_11, TS_Cal_Ev_T_12, TS_Cal_Ev_T_13, TS_Cal_Ev_T_14, TS_Cal_Ev_T_15, TS_Cal_Ev_T_16, TS_Cal_Ev_T_17, TS_Cal_Ev_T_18, TS_Cal_Ev_T_19, TS_Cal_Ev_T_20, TS_Cal_Ev_T_21, TS_Cal_Ev_T_22, TS_Cal_Ev_T_23, TS_Cal_Ev_T_24, TS_Cal_Ev_T_25, TS_Cal_Ev_T_26, TS_Cal_Ev_T_27, TS_Cal_Ev_T_28, TS_Cal_Ev_T_29, TS_Cal_Ev_T_30, TS_Cal_Ev_T_31, TS_Cal_Ev_T_32, TS_Cal_Ev_T_33, TS_Cal_Ev_T_34, TS_Cal_Ev_T_35, TS_Cal_Ev_T_36, TS_Cal_Ev_T_37) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, $TS_Cal_Ev_TName, $TS_Cal_Ev_TType, $TS_Cal_Ev_T_01, $TS_Cal_Ev_T_02, $TS_Cal_Ev_T_03, $TS_Cal_Ev_T_04, $TS_Cal_Ev_T_05, $TS_Cal_Ev_T_06, $TS_Cal_Ev_T_07, $TS_Cal_Ev_T_08, $TS_Cal_Ev_T_09, $TS_Cal_Ev_T_10, $TS_Cal_Ev_T_11, $TS_Cal_Ev_T_12, $TS_Cal_Ev_T_13, $TS_Cal_Ev_T_14, $TS_Cal_Ev_T_15, $TS_Cal_Ev_T_16, $TS_Cal_Ev_T_17, $TS_Cal_Ev_T_18, $TS_Cal_Ev_T_19, $TS_Cal_Ev_T_20, $TS_Cal_Ev_T_21, $TS_Cal_Ev_T_22, $TS_Cal_Ev_T_23, $TS_Cal_Ev_T_24, $TS_Cal_Ev_T_25, $TS_Cal_Ev_T_26, $TS_Cal_Ev_T_27, $TS_Cal_Ev_T_28, $TS_Cal_Ev_T_29, $TS_Cal_Ev_T_30, $TS_Cal_Ev_T_31, $TS_Cal_Ev_T_32, $TS_Cal_Ev_T_33, $TS_Cal_Ev_T_34, $TS_Cal_Ev_T_35, $TS_Cal_Ev_T_36, $TS_Cal_Ev_T_37));
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name6 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_T_E_01, TS_Cal_Ev_T_E_02, TS_Cal_Ev_T_E_03, TS_Cal_Ev_T_E_04, TS_Cal_Ev_T_E_05, TS_Cal_Ev_T_E_06, TS_Cal_Ev_T_E_07, TS_Cal_Ev_T_E_08, TS_Cal_Ev_T_E_09, TS_Cal_Ev_T_E_10, TS_Cal_Ev_T_E_11, TS_Cal_Ev_T_E_12, TS_Cal_Ev_T_E_13, TS_Cal_Ev_T_E_14, TS_Cal_Ev_T_E_15, TS_Cal_Ev_T_E_16, TS_Cal_Ev_T_E_17, TS_Cal_Ev_T_E_18, TS_Cal_Ev_T_E_19, TS_Cal_Ev_T_E_20, TS_Cal_Ev_T_E_21, TS_Cal_Ev_T_E_22, TS_Cal_Ev_T_E_23, TS_Cal_Ev_T_E_24, TS_Cal_Ev_T_E_25, TS_Cal_Ev_T_E_26, TS_Cal_Ev_T_E_27, TS_Cal_Ev_T_E_28, TS_Cal_Ev_T_E_29, TS_Cal_Ev_T_E_30, TS_Cal_Ev_T_E_31, TS_Cal_Ev_T_E_32, TS_Cal_Ev_T_E_33, TS_Cal_Ev_T_E_34, TS_Cal_Ev_T_E_35, TS_Cal_Ev_T_E_36, TS_Cal_Ev_T_E_37, TS_Cal_Ev_T_E_38, TS_Cal_Ev_T_E_39) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, $TS_Cal_Ev_T_E_01, $TS_Cal_Ev_T_E_02, $TS_Cal_Ev_T_E_03, $TS_Cal_Ev_T_E_04, $TS_Cal_Ev_T_E_05, $TS_Cal_Ev_T_E_06, $TS_Cal_Ev_T_E_07, $TS_Cal_Ev_T_E_08, $TS_Cal_Ev_T_E_09, $TS_Cal_Ev_T_E_10, $TS_Cal_Ev_T_E_11, $TS_Cal_Ev_T_E_12, $TS_Cal_Ev_T_E_13, $TS_Cal_Ev_T_E_14, $TS_Cal_Ev_T_E_15, $TS_Cal_Ev_T_E_16, $TS_Cal_Ev_T_E_17, $TS_Cal_Ev_T_E_18, $TS_Cal_Ev_T_E_19, $TS_Cal_Ev_T_E_20, $TS_Cal_Ev_T_E_21, $TS_Cal_Ev_T_E_22, $TS_Cal_Ev_T_E_23, $TS_Cal_Ev_T_E_24, $TS_Cal_Ev_T_E_25, $TS_Cal_Ev_T_E_26, $TS_Cal_Ev_T_E_27, $TS_Cal_Ev_T_E_28, $TS_Cal_Ev_T_E_29, $TS_Cal_Ev_T_E_30, $TS_Cal_Ev_T_E_31, $TS_Cal_Ev_T_E_32, $TS_Cal_Ev_T_E_33, $TS_Cal_Ev_T_E_34, $TS_Cal_Ev_T_E_35, $TS_Cal_Ev_T_E_36, $TS_Cal_Ev_T_E_37, $TS_Cal_Ev_T_E_38, $TS_Cal_Ev_T_E_39));
			}
			else if(isset($_POST['Total_Soft_Cal_Ev_T_Update']))
			{
				$Total_SoftCal_Ev_T_Update = $_POST['Total_SoftCal_Ev_T_Update'];

				$wpdb->query($wpdb->prepare("UPDATE $table_name4 set TS_Cal_Ev_TName = %s, TS_Cal_Ev_TType = %s WHERE id = %d", $TS_Cal_Ev_TName, $TS_Cal_Ev_TType, $Total_SoftCal_Ev_T_Update));			
				$wpdb->query($wpdb->prepare("UPDATE $table_name5 set TS_Cal_Ev_TName = %s, TS_Cal_Ev_TType = %s, TS_Cal_Ev_T_01 = %s, TS_Cal_Ev_T_02 = %s, TS_Cal_Ev_T_03 = %s, TS_Cal_Ev_T_04 = %s, TS_Cal_Ev_T_05 = %s, TS_Cal_Ev_T_06 = %s, TS_Cal_Ev_T_07 = %s, TS_Cal_Ev_T_08 = %s, TS_Cal_Ev_T_09 = %s, TS_Cal_Ev_T_10 = %s, TS_Cal_Ev_T_11 = %s, TS_Cal_Ev_T_12 = %s, TS_Cal_Ev_T_13 = %s, TS_Cal_Ev_T_14 = %s, TS_Cal_Ev_T_15 = %s, TS_Cal_Ev_T_16 = %s, TS_Cal_Ev_T_17 = %s, TS_Cal_Ev_T_18 = %s, TS_Cal_Ev_T_19 = %s, TS_Cal_Ev_T_20 = %s, TS_Cal_Ev_T_21 = %s, TS_Cal_Ev_T_22 = %s, TS_Cal_Ev_T_23 = %s, TS_Cal_Ev_T_24 = %s, TS_Cal_Ev_T_25 = %s, TS_Cal_Ev_T_26 = %s, TS_Cal_Ev_T_27 = %s, TS_Cal_Ev_T_28 = %s, TS_Cal_Ev_T_29 = %s, TS_Cal_Ev_T_30 = %s, TS_Cal_Ev_T_31 = %s, TS_Cal_Ev_T_32 = %s, TS_Cal_Ev_T_33 = %s, TS_Cal_Ev_T_34 = %s, TS_Cal_Ev_T_35 = %s, TS_Cal_Ev_T_36 = %s, TS_Cal_Ev_T_37 = %s WHERE TS_Cal_Ev_T_ID = %d", $TS_Cal_Ev_TName, $TS_Cal_Ev_TType, $TS_Cal_Ev_T_01, $TS_Cal_Ev_T_02, $TS_Cal_Ev_T_03, $TS_Cal_Ev_T_04, $TS_Cal_Ev_T_05, $TS_Cal_Ev_T_06, $TS_Cal_Ev_T_07, $TS_Cal_Ev_T_08, $TS_Cal_Ev_T_09, $TS_Cal_Ev_T_10, $TS_Cal_Ev_T_11, $TS_Cal_Ev_T_12, $TS_Cal_Ev_T_13, $TS_Cal_Ev_T_14, $TS_Cal_Ev_T_15, $TS_Cal_Ev_T_16, $TS_Cal_Ev_T_17, $TS_Cal_Ev_T_18, $TS_Cal_Ev_T_19, $TS_Cal_Ev_T_20, $TS_Cal_Ev_T_21, $TS_Cal_Ev_T_22, $TS_Cal_Ev_T_23, $TS_Cal_Ev_T_24, $TS_Cal_Ev_T_25, $TS_Cal_Ev_T_26, $TS_Cal_Ev_T_27, $TS_Cal_Ev_T_28, $TS_Cal_Ev_T_29, $TS_Cal_Ev_T_30, $TS_Cal_Ev_T_31, $TS_Cal_Ev_T_32, $TS_Cal_Ev_T_33, $TS_Cal_Ev_T_34, $TS_Cal_Ev_T_35, $TS_Cal_Ev_T_36, $TS_Cal_Ev_T_37, $Total_SoftCal_Ev_T_Update));
				$wpdb->query($wpdb->prepare("UPDATE $table_name6 set TS_Cal_Ev_T_E_01 = %s, TS_Cal_Ev_T_E_02 = %s, TS_Cal_Ev_T_E_03 = %s, TS_Cal_Ev_T_E_04 = %s, TS_Cal_Ev_T_E_05 = %s, TS_Cal_Ev_T_E_06 = %s, TS_Cal_Ev_T_E_07 = %s, TS_Cal_Ev_T_E_08 = %s, TS_Cal_Ev_T_E_09 = %s, TS_Cal_Ev_T_E_10 = %s, TS_Cal_Ev_T_E_11 = %s, TS_Cal_Ev_T_E_12 = %s, TS_Cal_Ev_T_E_13 = %s, TS_Cal_Ev_T_E_14 = %s, TS_Cal_Ev_T_E_15 = %s, TS_Cal_Ev_T_E_16 = %s, TS_Cal_Ev_T_E_17 = %s, TS_Cal_Ev_T_E_18 = %s, TS_Cal_Ev_T_E_19 = %s, TS_Cal_Ev_T_E_20 = %s, TS_Cal_Ev_T_E_21 = %s, TS_Cal_Ev_T_E_22 = %s, TS_Cal_Ev_T_E_23 = %s, TS_Cal_Ev_T_E_24 = %s, TS_Cal_Ev_T_E_25 = %s, TS_Cal_Ev_T_E_26 = %s, TS_Cal_Ev_T_E_27 = %s, TS_Cal_Ev_T_E_28 = %s, TS_Cal_Ev_T_E_29 = %s, TS_Cal_Ev_T_E_30 = %s, TS_Cal_Ev_T_E_31 = %s, TS_Cal_Ev_T_E_32 = %s, TS_Cal_Ev_T_E_33 = %s, TS_Cal_Ev_T_E_34 = %s, TS_Cal_Ev_T_E_35 = %s, TS_Cal_Ev_T_E_36 = %s, TS_Cal_Ev_T_E_37 = %s, TS_Cal_Ev_T_E_38 = %s, TS_Cal_Ev_T_E_39 = %s WHERE TS_Cal_Ev_T_ID = %d", $TS_Cal_Ev_T_E_01, $TS_Cal_Ev_T_E_02, $TS_Cal_Ev_T_E_03, $TS_Cal_Ev_T_E_04, $TS_Cal_Ev_T_E_05, $TS_Cal_Ev_T_E_06, $TS_Cal_Ev_T_E_07, $TS_Cal_Ev_T_E_08, $TS_Cal_Ev_T_E_09, $TS_Cal_Ev_T_E_10, $TS_Cal_Ev_T_E_11, $TS_Cal_Ev_T_E_12, $TS_Cal_Ev_T_E_13, $TS_Cal_Ev_T_E_14, $TS_Cal_Ev_T_E_15, $TS_Cal_Ev_T_E_16, $TS_Cal_Ev_T_E_17, $TS_Cal_Ev_T_E_18, $TS_Cal_Ev_T_E_19, $TS_Cal_Ev_T_E_20, $TS_Cal_Ev_T_E_21, $TS_Cal_Ev_T_E_22, $TS_Cal_Ev_T_E_23, $TS_Cal_Ev_T_E_24, $TS_Cal_Ev_T_E_25, $TS_Cal_Ev_T_E_26, $TS_Cal_Ev_T_E_27, $TS_Cal_Ev_T_E_28, $TS_Cal_Ev_T_E_29, $TS_Cal_Ev_T_E_30, $TS_Cal_Ev_T_E_31, $TS_Cal_Ev_T_E_32, $TS_Cal_Ev_T_E_33, $TS_Cal_Ev_T_E_34, $TS_Cal_Ev_T_E_35, $TS_Cal_Ev_T_E_36, $TS_Cal_Ev_T_E_37, $TS_Cal_Ev_T_E_38, $TS_Cal_Ev_T_E_39, $Total_SoftCal_Ev_T_Update));
			}
		}
	    else
	    {
	        wp_die('Security check fail'); 
	    }
	}

	$Total_SoftCal_Ev_Font=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id>%d",0));
	$Total_SoftCal_Ev_Themes=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id>%d",0));
	$TS_Cal_Ev_T1 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE TS_Cal_Ev_TType=%s", 'Popover Calendar'));
	$TS_Cal_Ev_T1_1 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name6 WHERE TS_Cal_Ev_T_ID=%s", $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_ID));
?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../CSS/totalsoft.css',__FILE__);?>">
<form method="POST" oninput="TotalSoft_Cal_Ev_Out()">
	<?php wp_nonce_field( 'edit-menu_'.$comment_id, 'TS_EvCal_Nonce' );?>
	<div class="Total_Soft_Cal_Ev_AMD">
		<div class="Support_Span">
			<a href="https://wordpress.org/support/plugin/event-calendars/" target="_blank" title="Click Here to Ask">
				<i class="totalsoft totalsoft-comments-o"></i><span style="margin-left:5px;">If you have any questions click here to ask it to our support.</span>
			</a>
		</div>
		<div class="Total_Soft_Cal_Ev_AMD1"></div>
		<div class="Total_Soft_Cal_Ev_AMD2">
			<i class="Total_Soft_Help_Ev totalsoft totalsoft-question-circle-o" title="Click for Creating New Theme"></i>
			<input type="button" name="" value="New Theme" class="Total_Soft_Cal_Ev_AMD2_But" onclick="Total_Soft_Cal_Ev_AMD2_But2()">
		</div>
		<div class="Total_Soft_Cal_Ev_AMD3">
			<i class="Total_Soft_Help_Ev totalsoft totalsoft-question-circle-o" title="Click for Canceling"></i>
			<input type="button" value="Cancel" class="Total_Soft_Cal_Ev_AMD2_But" onclick='TotalSoft_Cal_Ev_T_Reload()'>
			<i class="Total_Soft_Cal_Ev_T_Save Total_Soft_Help_Ev totalsoft totalsoft-question-circle-o" title="Click for Saving Settings"></i>
			<input type="submit" name="Total_Soft_Cal_Ev_T_Save" value="Save" class="Total_Soft_Cal_Ev_T_Save Total_Soft_Cal_Ev_AMD2_But">
			<i class="Total_Soft_Cal_Ev_T_Update Total_Soft_Help_Ev totalsoft totalsoft-question-circle-o" title="Click for Updating Settings"></i>
			<input type="submit" name="Total_Soft_Cal_Ev_T_Update" value="Update" class="Total_Soft_Cal_Ev_T_Update Total_Soft_Cal_Ev_AMD2_But">
			<input type="text" style="display:none" name="Total_SoftCal_Ev_T_Update" id="Total_SoftCal_Ev_T_Update">
		</div>
	</div>

	<table class="Total_Soft_Cal_Ev_TMMTable">
		<tr class="Total_Soft_Cal_Ev_TMMTableFR">
			<td>No</td>
			<td>Theme Name</td>
			<td>Calendar Type</td>
			<td>Actions</td>
		</tr>
	</table>

	<table class="Total_Soft_Cal_Ev_TMOTable">
	 	<?php for($i=0;$i<count($Total_SoftCal_Ev_Themes);$i++){ ?> 
	 		<tr>
				<td><?php echo $i+1;?></td>
				<td><?php echo html_entity_decode($Total_SoftCal_Ev_Themes[$i]->TS_Cal_Ev_TName);?></td>
				<td><?php echo $Total_SoftCal_Ev_Themes[$i]->TS_Cal_Ev_TType;?></td>
				<td onclick="TotalSoftCal_Ev_Copy_Theme(<?php echo $Total_SoftCal_Ev_Themes[$i]->id;?>)"><i class="Total_SoftEv_Cal_Edit totalsoft totalsoft-file-text"></i></td>
				<td onclick="TotalSoftCal_Ev_Edit_Theme(<?php echo $Total_SoftCal_Ev_Themes[$i]->id;?>)"><i class="Total_SoftEv_Cal_Edit totalsoft totalsoft-pencil"></i></td>
				<td onclick="TotalSoftCal_Ev_Del_Theme(<?php echo $Total_SoftCal_Ev_Themes[$i]->id;?>)"><i class="Total_SoftEv_Cal_Del totalsoft totalsoft-trash"></i></td>
			</tr>
	 	<?php }?>
	</table>


	<table class="Total_Soft_EC_T_Set Total_Soft_EC_T_Set_Main">
		<tr>
			<td>Theme Title <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Define the calendar theme name."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_TName" id="TS_Cal_Ev_TName" class="Total_Soft_Cal_Ev_Sel" required placeholder=" * Required">
			</td>
			<td>Calendar Type <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Define the calendar type in which the events should be placed."></i></td>
			<td>
				<select class="Total_Soft_Cal_Ev_Sel" name="TS_Cal_Ev_TType" id="TS_Cal_Ev_TType" onchange="TS_Cal_Ev_TType_Changed()">
					<option value="Popover Calendar" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_TType=='Popover Calendar'){echo 'selected';}?>>Popover Calendar</option>
				</select>
			</td>
		</tr>
	</table>

	<table class="Total_Soft_EC_T_Set Total_Soft_EC_T_Set_T Total_Soft_EC_T_Set_T_1">
		<tr class="Total_Soft_Titles">
			<td colspan="4">General Options</td>			
		</tr>
		<tr>
			<td>Max-Width <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Possibility define the calendar width."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_MW" id="TS_Cal_Ev_T1_MW" min="150" max="1200" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_01;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_MW_Output" for="TS_Cal_Ev_T1_MW"></output>
			</td>
			<td>WeekDay Start <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select that day in the calendar which must be the first in the week."></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_WDS" id="TS_Cal_Ev_T1_WDS">
					<option value="0" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_02=='0'){echo 'selected';}?>>Sunday</option>
					<option value="1" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_02=='1'){echo 'selected';}?>>Monday</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Can choose main background color."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_BgC" id="TS_Cal_Ev_T1_BgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_03;?>">
			</td>
			<td>Grid Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select grid color which divide the days in the calendar."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_GrC" id="TS_Cal_Ev_T1_GrC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_04;?>">
			</td>
		</tr>
		<tr>
			<td>Body Border Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the body border color."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_BBC" id="TS_Cal_Ev_T1_BBC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_05;?>">
			</td>
			<td>Box Shadow <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose to show the boxshadow or no."></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_BShShow" id="TS_Cal_Ev_T1_BShShow">
					<option value="Yes" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_06=='Yes'){echo 'selected';}?>> Yes </option>
					<option value="No"  <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_06=='No'){echo 'selected';}?>>  No  </option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Shadow Type <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the shadow type."></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_BShType" id="TS_Cal_Ev_T1_BShType">
					<option value="1" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_07=='1'){echo 'selected';}?>> Type 1 </option>
					<option value="2" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_07=='2'){echo 'selected';}?>> Type 2 </option>
				</select>
			</td>
			<td>Shadow <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose the shadow size for the calendar."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_BSh" id="TS_Cal_Ev_T1_BSh" min="0" max="50" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_08;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_BSh_Output" for="TS_Cal_Ev_T1_BSh"></output>
			</td>
		</tr>
		<tr>
			<td>Shadow Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select shadow color which allows to show the shadow color of the calendar."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_BShC" id="TS_Cal_Ev_T1_BShC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_09;?>">
			</td>
			<td>Height <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Possibility define the calendar height."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_H" id="TS_Cal_Ev_T1_H" min="150" max="1200" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_28;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_H_Output" for="TS_Cal_Ev_T1_H"></output>
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Header Options</td>			
		</tr>
		<tr>
			<td>Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select a background color where can be seen the year and month."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_H_BgC" id="TS_Cal_Ev_T1_H_BgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_10;?>">
			</td>
			<td>Border-Top Width <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the main top border width."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_H_BTW" id="TS_Cal_Ev_T1_H_BTW" min="0" max="10" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_11;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_H_BTW_Output" for="TS_Cal_Ev_T1_H_BTW"></output>
			</td>
		</tr>
		<tr>
			<td>Border-Top Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the main top border color."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_H_BTC" id="TS_Cal_Ev_T1_H_BTC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_12;?>">
			</td>
			<td>Font Family <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose the calendar font family of the year and month."></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_H_FF" id="TS_Cal_Ev_T1_H_FF">
					<?php foreach ($Total_SoftCal_Ev_Font as $Font_Family) :?>
						<?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_13==$Font_Family->Font) {?>
							<option value='<?php echo $Font_Family->Font;?>' selected="select"><?php echo $Font_Family->Font;?></option>
						<?php }else{?>
							<option value='<?php echo $Font_Family->Font;?>'><?php echo $Font_Family->Font;?></option>
					<?php } endforeach ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Month Font Size <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose the calendar font size of the month."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_H_MFS" id="TS_Cal_Ev_T1_H_MFS" min="8" max="48" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_14;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_H_MFS_Output" for="TS_Cal_Ev_T1_H_MFS"></output>
			</td>
			<td>Month Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the calendar text color for the month."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_H_MC" id="TS_Cal_Ev_T1_H_MC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_15;?>">
			</td>
		</tr>
		<tr>
			<td>Year Font Size <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose the calendar font size of the year."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_H_YFS" id="TS_Cal_Ev_T1_H_YFS" min="8" max="48" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_16;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_H_YFS_Output" for="TS_Cal_Ev_T1_H_YFS"></output>
			</td>
			<td>Year Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the calendar text color for the year."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_H_YC" id="TS_Cal_Ev_T1_H_YC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_17;?>">
			</td>
		</tr>
		<tr>
			<td>Format <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose position for the month and year."></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_H_Format" id="TS_Cal_Ev_T1_H_Format">
					<option value="1" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_18=='1'){echo 'selected';}?>> Type 1 </option>
					<option value="2" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_18=='2'){echo 'selected';}?>> Type 2 </option>
					<option value="3" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_18=='3'){echo 'selected';}?>> Type 3 </option>
					<option value="4" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_18=='4'){echo 'selected';}?>> Type 4 </option>
				</select>
			</td>		
			<td colspan="2"></td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Arrows Options</td>			
		</tr>
		<tr>
			<td>Type <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the right and the left icons for calendar which are for change the months by sequence."></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_Arr_Type" id="TS_Cal_Ev_T1_Arr_Type">
					<option value='angle-double'   <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='angle-double'){echo 'selected';}?>>   Type 1  </option>
					<option value='angle'          <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='angle'){echo 'selected';}?>>          Type 2  </option>
					<option value='arrow-circle'   <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='arrow-circle'){echo 'selected';}?>>   Type 3  </option>
					<option value='arrow-circle-o' <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='arrow-circle-o'){echo 'selected';}?>> Type 4  </option>
					<option value='arrow'          <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='arrow'){echo 'selected';}?>>          Type 5  </option>
					<option value='caret'          <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='caret'){echo 'selected';}?>>          Type 6  </option>
					<option value='caret-square-o' <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='caret-square-o'){echo 'selected';}?>> Type 7  </option>
					<option value='chevron-circle' <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='chevron-circle'){echo 'selected';}?>> Type 8  </option>
					<option value='chevron'        <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='chevron'){echo 'selected';}?>>        Type 9  </option>
					<option value='hand-o'         <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='hand-o'){echo 'selected';}?>>         Type 10 </option>
					<option value='long-arrow'     <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_19=='long-arrow'){echo 'selected';}?>>     Type 11 </option>
				</select>
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select a color of the icon."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_Arr_C" id="TS_Cal_Ev_T1_Arr_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_20;?>">
			</td>
		</tr>
		<tr>
			<td>Size <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Set the size for icon."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_Arr_S" id="TS_Cal_Ev_T1_Arr_S" min="8" max="48" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_21;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_Arr_S_Output" for="TS_Cal_Ev_T1_Arr_S"></output>
			</td>
			<td>Hover Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select a hover color of the icon."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_Arr_HC" id="TS_Cal_Ev_T1_Arr_HC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_22;?>">
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Line After Header</td>			
		</tr>
		<tr>
			<td>Width <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Determine the header line width."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_LAH_W" id="TS_Cal_Ev_T1_LAH_W" min="0" max="5" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_23;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_LAH_W_Output" for="TS_Cal_Ev_T1_LAH_W"></output>
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose the color according to your preference."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_LAH_C" id="TS_Cal_Ev_T1_LAH_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_24;?>">
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">WeekDay Options</td>			
		</tr>
		<tr>
			<td>Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose a background color for weekdays."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_WD_BgC" id="TS_Cal_Ev_T1_WD_BgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_25;?>">
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the calendar text color for the weekdays."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_WD_C" id="TS_Cal_Ev_T1_WD_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_26;?>">
			</td>
		</tr>
		<tr>
			<td>Font Size <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Set the calendar text size for the weekdays."></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_WD_FS" id="TS_Cal_Ev_T1_WD_FS" min="8" max="48" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_27;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_WD_FS_Output" for="TS_Cal_Ev_T1_WD_FS"></output>
			</td>
			<td>Font Family <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose the font family of the weekdays."></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_WD_FF" id="TS_Cal_Ev_T1_WD_FF">
					<?php foreach ($Total_SoftCal_Ev_Font as $Font_Family) :?>
						<?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_28==$Font_Family->Font) {?>
							<option value='<?php echo $Font_Family->Font;?>' selected="select"><?php echo $Font_Family->Font;?></option>
						<?php }else{?>
							<option value='<?php echo $Font_Family->Font;?>'><?php echo $Font_Family->Font;?></option>
					<?php } endforeach ?>
				</select>
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Days Options</td>			
		</tr>
		<tr>
			<td>Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the background color for days of the calendar."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_D_BgC" id="TS_Cal_Ev_T1_D_BgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_29;?>">
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the color of the numbers."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_D_C" id="TS_Cal_Ev_T1_D_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_30;?>">
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Todays Options</td>			
		</tr>
		<tr>
			<td>Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Note the background color of the current day."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_TD_BgC" id="TS_Cal_Ev_T1_TD_BgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_31;?>">
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose the current date color that will be displayed."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_TD_C" id="TS_Cal_Ev_T1_TD_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_32;?>">
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Hover Options</td>			
		</tr>
		<tr>
			<td>Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Determine the background color of the hover option without clicking you can change the background color of the day."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_HD_BgC" id="TS_Cal_Ev_T1_HD_BgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_33;?>">
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Determine the color of the hover's letters."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_HD_C" id="TS_Cal_Ev_T1_HD_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_34;?>">
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Dots in Event Days</td>			
		</tr>
		<tr>
			<td>Show <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Choose to show the dots or no."></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_ED_DShow" id="TS_Cal_Ev_T1_ED_DShow">
					<option value="Yes" <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_35=='Yes'){echo 'selected';}?>> Yes </option>
					<option value="No"  <?php if($TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_35=='No'){echo 'selected';}?>>  No  </option>
				</select>
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the event color for days."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_ED_C" id="TS_Cal_Ev_T1_ED_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_36;?>">
			</td>			
		</tr>
		<tr>
			<td>Hover Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="Select the event hover color for days."></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_ED_HC" id="TS_Cal_Ev_T1_ED_HC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col1" value="<?php echo $TS_Cal_Ev_T1[0]->TS_Cal_Ev_T_37;?>">
			</td>
			<td colspan="2"></td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Event Days Options</td>			
		</tr>
		<tr>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_C" id="TS_Cal_Ev_T1_E_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_25;?>">
			</td>
			<td>Hover Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_HC" id="TS_Cal_Ev_T1_E_HC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_26;?>">
			</td>
		</tr>
		<tr>
			<td>Hover Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_ED_HBgC" id="TS_Cal_Ev_T1_ED_HBgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_27;?>">
			</td>
			<td colspan="2"></td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Event Part</td>			
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">General Options</td>			
		</tr>
		<tr>
			<td>Max Width <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_E_MW" id="TS_Cal_Ev_T1_E_MW" min="150" max="1200" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_01;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_MW_Output" for="TS_Cal_Ev_T1_E_MW"></output>
			</td>
			<td>Max Height <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_E_MH" id="TS_Cal_Ev_T1_E_MH" min="150" max="1200" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_02;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_MH_Output" for="TS_Cal_Ev_T1_E_MH"></output>
			</td>
		</tr>
		<tr>
			<td>Background Type <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_E_BgT" id="TS_Cal_Ev_T1_E_BgT">
					<option value="1" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_03=='1'){echo 'selected';}?>> Color    </option>
					<option value="2" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_03=='2'){echo 'selected';}?>> Gradient </option>
				</select>
			</td>
			<td>Background 1 <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_Bg1" id="TS_Cal_Ev_T1_E_Bg1" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_04;?>">
			</td>
		</tr>
		<tr>
			<td>Background 2 <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_Bg2" id="TS_Cal_Ev_T1_E_Bg2" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_05;?>">
			</td>
			<td>Border Width <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_E_BW" id="TS_Cal_Ev_T1_E_BW" min="0" max="5" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_06;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_BW_Output" for="TS_Cal_Ev_T1_E_BW"></output>
			</td>
		</tr>
		<tr>
			<td>Border Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_BC" id="TS_Cal_Ev_T1_E_BC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_07;?>">
			</td>
			<td>Border Radius <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_E_BR" id="TS_Cal_Ev_T1_E_BR" min="0" max="10" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_08;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_BR_Output" for="TS_Cal_Ev_T1_E_BR"></output>
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Date Options</td>			
		</tr>
		<tr>
			<td>Format <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_E_D_F" id="TS_Cal_Ev_T1_E_D_F">
					<option value="yy-mm-dd" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_F=='yy-mm-dd'){ echo 'selected';}?>> yy-mm-dd </option>
					<option value="yy MM dd" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_F=='yy MM dd'){ echo 'selected';}?>> yy MM dd </option>
					<option value="dd-mm-yy" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_F=='dd-mm-yy'){ echo 'selected';}?>> dd-mm-yy </option>
					<option value="dd MM yy" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_F=='dd MM yy'){ echo 'selected';}?>> dd MM yy </option>
					<option value="mm-dd-yy" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_F=='mm-dd-yy'){ echo 'selected';}?>> mm-dd-yy </option>
					<option value="MM dd, yy" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_F=='MM dd, yy'){ echo 'selected';}?>> MM dd, yy </option>
				</select>
			</td>
			<td>Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_D_BgC" id="TS_Cal_Ev_T1_E_D_BgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_10;?>">
			</td>
		</tr>
		<tr>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_D_C" id="TS_Cal_Ev_T1_E_D_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_11;?>">
			</td>
			<td>Text Align <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_E_D_TA" id="TS_Cal_Ev_T1_E_D_TA">
					<option value="left"   <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_TA=='left'){echo 'selected';}?>>   Left   </option>
					<option value="right"  <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_TA=='right'){echo 'selected';}?>>  Right  </option>
					<option value="center" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T1_E_D_TA=='center'){echo 'selected';}?>> Center </option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Font Size <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_E_D_FS" id="TS_Cal_Ev_T1_E_D_FS" min="8" max="48" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_13;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_D_FS_Output" for="TS_Cal_Ev_T1_E_D_FS"></output>
			</td>
			<td>Font Family <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_E_D_FF" id="TS_Cal_Ev_T1_E_D_FF">
					<?php foreach ($Total_SoftCal_Ev_Font as $Font_Family) :?>
						<?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_14==$Font_Family->Font) {?>
							<option value='<?php echo $Font_Family->Font;?>' selected="select"><?php echo $Font_Family->Font;?></option>
						<?php }else{?>
							<option value='<?php echo $Font_Family->Font;?>'><?php echo $Font_Family->Font;?></option>
					<?php } endforeach ?>
				</select>
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Line After Date</td>			
		</tr>
		<tr>
			<td>Width <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_E_D_BBW" id="TS_Cal_Ev_T1_E_D_BBW" min="0" max="5" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_15;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_D_BBW_Output" for="TS_Cal_Ev_T1_E_D_BBW"></output>
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_D_BBC" id="TS_Cal_Ev_T1_E_D_BBC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_16;?>">
			</td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Event Title Option</td>			
		</tr>
		<tr>
			<td>Background Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_T_BgC" id="TS_Cal_Ev_T1_E_T_BgC" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_17;?>">
			</td>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_T_C" id="TS_Cal_Ev_T1_E_T_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_18;?>">
			</td>
		</tr>
		<tr>
			<td>Font Size <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_E_T_FS" id="TS_Cal_Ev_T1_E_T_FS" min="8" max="48" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_19;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_T_FS_Output" for="TS_Cal_Ev_T1_E_T_FS"></output>
			</td>
			<td>Font Family <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_E_T_FF" id="TS_Cal_Ev_T1_E_T_FF">
					<?php foreach ($Total_SoftCal_Ev_Font as $Font_Family) :?>
						<?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_20==$Font_Family->Font) {?>
							<option value='<?php echo $Font_Family->Font;?>' selected="select"><?php echo $Font_Family->Font;?></option>
						<?php }else{?>
							<option value='<?php echo $Font_Family->Font;?>'><?php echo $Font_Family->Font;?></option>
					<?php } endforeach ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Text Align <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<select class="Total_Soft_Select" name="TS_Cal_Ev_T1_E_T_TA" id="TS_Cal_Ev_T1_E_T_TA">
					<option value="left"   <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_21=='left'){echo 'selected';}?>>   Left   </option>
					<option value="right"  <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_21=='right'){echo 'selected';}?>>  Right  </option>
					<option value="center" <?php if($TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_21=='center'){echo 'selected';}?>> Center </option>
				</select>
			</td>
			<td colspan="2"></td>
		</tr>
		<tr class="Total_Soft_Titles">
			<td colspan="4">Line After Each Event</td>			
		</tr>
		<tr>
			<td>Width <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangeper" name="TS_Cal_Ev_T1_E_LAE_W" id="TS_Cal_Ev_T1_E_LAE_W" min="0" max="100" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_22;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_LAE_W_Output" for="TS_Cal_Ev_T1_E_LAE_W"></output>
			</td>
			<td>Height <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="range" class="TotalSoft_Cal_Ev_Range TotalSoft_Cal_Ev_Rangepx" name="TS_Cal_Ev_T1_E_LAE_H" id="TS_Cal_Ev_T1_E_LAE_H" min="0" max="5" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_23;?>">
				<output class="TotalSoft_Out" name="" id="TS_Cal_Ev_T1_E_LAE_H_Output" for="TS_Cal_Ev_T1_E_LAE_H"></output>
			</td>
		</tr>
		<tr>
			<td>Color <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title=""></i></td>
			<td>
				<input type="text" name="TS_Cal_Ev_T1_E_LAE_C" id="TS_Cal_Ev_T1_E_LAE_C" class="Total_Soft_Cal_Ev_Col Total_Soft_Cal_Ev_Col2" value="<?php echo $TS_Cal_Ev_T1_1[0]->TS_Cal_Ev_T_E_24;?>">
			</td>
			<td colspan="2"></td>
		</tr>
	</table>
</form>