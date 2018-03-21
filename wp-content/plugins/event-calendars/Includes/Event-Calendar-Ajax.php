<?php
	// Admin Menu
	add_action( 'wp_ajax_TotalSoftCalEv_Del', 'TotalSoftCalEv_Del_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_Del', 'TotalSoftCalEv_Del_Callback' );

	function TotalSoftCalEv_Del_Callback()
	{
		$Ev_Cal_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name2 = $wpdb->prefix . "totalsoft_evcal_manager";
		$table_name3 = $wpdb->prefix . "totalsoft_evcal_events";

		$wpdb->query($wpdb->prepare("DELETE FROM $table_name2 WHERE id = %d", $Ev_Cal_ID));
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name3 WHERE EvCal_ID = %d", $Ev_Cal_ID));
	
		die();
	}

	add_action( 'wp_ajax_TotalSoftCalEv_Copy', 'TotalSoftCalEv_Copy_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_Copy', 'TotalSoftCalEv_Copy_Callback' );

	function TotalSoftCalEv_Copy_Callback()
	{
		$Ev_Cal_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;

		$table_name1 = $wpdb->prefix . "totalsoft_evcal_ids";
		$table_name2 = $wpdb->prefix . "totalsoft_evcal_manager";
		$table_name3 = $wpdb->prefix . "totalsoft_evcal_events";
	
		$Total_SoftCal_Ev_DatCl=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id = %d", $Ev_Cal_ID));
		$Total_SoftCal_Ev_DatEv=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE EvCal_ID = %d order by id", $Ev_Cal_ID));
		
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name2 (id, Total_Soft_Cal_Ev_Name, Total_Soft_Cal_Ev_Theme, Total_Soft_Cal_Ev_ECount) VALUES (%d, %s, %s, %s)", '', $Total_SoftCal_Ev_DatCl[0]->Total_Soft_Cal_Ev_Name, $Total_SoftCal_Ev_DatCl[0]->Total_Soft_Cal_Ev_Theme, $Total_SoftCal_Ev_DatCl[0]->Total_Soft_Cal_Ev_ECount));
		
		$TotalSoftEvCalNewID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id > %d order by id desc limit 1",0));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, EvCal_ID) VALUES (%d, %s)", '', $TotalSoftEvCalNewID[0]->id));

		for( $i=0; $i<count($Total_SoftCal_Ev_DatEv); $i++ )
		{
			$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, EvCal_ID, TS_Cal_Ev_Title, TS_Cal_Ev_Color, TS_Cal_Ev_Date, TS_Cal_Ev_Desc) VALUES (%d, %s, %s, %s, %s, %s)", '', $TotalSoftEvCalNewID[0]->id, $Total_SoftCal_Ev_DatEv[$i]->TS_Cal_Ev_Title, $Total_SoftCal_Ev_DatEv[$i]->TS_Cal_Ev_Color, $Total_SoftCal_Ev_DatEv[$i]->TS_Cal_Ev_Date, $Total_SoftCal_Ev_DatEv[$i]->TS_Cal_Ev_Desc));
		}
		die();
	}

	add_action( 'wp_ajax_TotalSoftCalEv_Edit1', 'TotalSoftCalEv_Edit1_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_Edit1', 'TotalSoftCalEv_Edit1_Callback' );

	function TotalSoftCalEv_Edit1_Callback()
	{
		$Ev_Cal_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;

		$table_name2 = $wpdb->prefix . "totalsoft_evcal_manager";
		$table_name3 = $wpdb->prefix . "totalsoft_evcal_events";
	
		$Total_SoftCal_Ev_DatCl=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id = %d", $Ev_Cal_ID));
		
		print_r($Total_SoftCal_Ev_DatCl);
		die();
	}

	add_action( 'wp_ajax_TotalSoftCalEv_Edit2', 'TotalSoftCalEv_Edit2_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_Edit2', 'TotalSoftCalEv_Edit2_Callback' );

	function TotalSoftCalEv_Edit2_Callback()
	{
		$Ev_Cal_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;

		$table_name2 = $wpdb->prefix . "totalsoft_evcal_manager";
		$table_name3 = $wpdb->prefix . "totalsoft_evcal_events";
	
		$Total_SoftCal_Ev_DatEv=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE EvCal_ID = %d order by id", $Ev_Cal_ID));
		
		for($i = 0; $i < count($Total_SoftCal_Ev_DatEv); $i++)
		{
			$Total_SoftCal_Ev_DatEv[$i]->TS_Cal_Ev_Desc = html_entity_decode($Total_SoftCal_Ev_DatEv[$i]->TS_Cal_Ev_Desc);
		}
		
		print_r($Total_SoftCal_Ev_DatEv);
		die();
	}
	// Theme Menu
	add_action( 'wp_ajax_TotalSoftCalEv_T_Del', 'TotalSoftCalEv_T_Del_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_T_Del', 'TotalSoftCalEv_T_Del_Callback' );

	function TotalSoftCalEv_T_Del_Callback()
	{
		$Theme_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name4 = $wpdb->prefix . "totalsoft_evcal_eff_data";
		$table_name5 = $wpdb->prefix . "totalsoft_evcal_eff_p1";
		$table_name6 = $wpdb->prefix . "totalsoft_evcal_eff_p2";

		$wpdb->query($wpdb->prepare("DELETE FROM $table_name4 WHERE id = %d", $Theme_ID));
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name5 WHERE TS_Cal_Ev_T_ID = %d", $Theme_ID));
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name6 WHERE TS_Cal_Ev_T_ID = %d", $Theme_ID));
	
		die();
	}

	add_action( 'wp_ajax_TotalSoftCalEv_T_Copy', 'TotalSoftCalEv_T_Copy_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_T_Copy', 'TotalSoftCalEv_T_Copy_Callback' );

	function TotalSoftCalEv_T_Copy_Callback()
	{
		$Theme_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;

		$table_name4 = $wpdb->prefix . "totalsoft_evcal_eff_data";
		$table_name5 = $wpdb->prefix . "totalsoft_evcal_eff_p1";
		$table_name6 = $wpdb->prefix . "totalsoft_evcal_eff_p2";
	
		$Total_SoftCal_Ev_DatTh=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id = %d", $Theme_ID));
		$Total_SoftCal_Ev_DatT1=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE TS_Cal_Ev_T_ID = %d", $Theme_ID));
		$Total_SoftCal_Ev_DatT2=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name6 WHERE TS_Cal_Ev_T_ID = %d", $Theme_ID));
		
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, TS_Cal_Ev_TName, TS_Cal_Ev_TType) VALUES (%d, %s, %s)", '', $Total_SoftCal_Ev_DatTh[0]->TS_Cal_Ev_TName, $Total_SoftCal_Ev_DatTh[0]->TS_Cal_Ev_TType));

		$TotalSoft_T1_ID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE TS_Cal_Ev_TName = %s order by id desc limit 1", $Total_SoftCal_Ev_DatTh[0]->TS_Cal_Ev_TName));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name5 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_TName, TS_Cal_Ev_TType, TS_Cal_Ev_T_01, TS_Cal_Ev_T_02, TS_Cal_Ev_T_03, TS_Cal_Ev_T_04, TS_Cal_Ev_T_05, TS_Cal_Ev_T_06, TS_Cal_Ev_T_07, TS_Cal_Ev_T_08, TS_Cal_Ev_T_09, TS_Cal_Ev_T_10, TS_Cal_Ev_T_11, TS_Cal_Ev_T_12, TS_Cal_Ev_T_13, TS_Cal_Ev_T_14, TS_Cal_Ev_T_15, TS_Cal_Ev_T_16, TS_Cal_Ev_T_17, TS_Cal_Ev_T_18, TS_Cal_Ev_T_19, TS_Cal_Ev_T_20, TS_Cal_Ev_T_21, TS_Cal_Ev_T_22, TS_Cal_Ev_T_23, TS_Cal_Ev_T_24, TS_Cal_Ev_T_25, TS_Cal_Ev_T_26, TS_Cal_Ev_T_27, TS_Cal_Ev_T_28, TS_Cal_Ev_T_29, TS_Cal_Ev_T_30, TS_Cal_Ev_T_31, TS_Cal_Ev_T_32, TS_Cal_Ev_T_33, TS_Cal_Ev_T_34, TS_Cal_Ev_T_35, TS_Cal_Ev_T_36, TS_Cal_Ev_T_37) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_TName, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_TType, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_01, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_02, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_03, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_04, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_05, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_06, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_07, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_08, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_09, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_10, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_11, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_12, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_13, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_14, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_15, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_16, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_17, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_18, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_19, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_20, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_21, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_22, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_23, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_24, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_25, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_26, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_27, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_28, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_29, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_30, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_31, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_32, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_33, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_34, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_35, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_36, $Total_SoftCal_Ev_DatT1[0]->TS_Cal_Ev_T_37));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name6 (id, TS_Cal_Ev_T_ID, TS_Cal_Ev_T_E_01, TS_Cal_Ev_T_E_02, TS_Cal_Ev_T_E_03, TS_Cal_Ev_T_E_04, TS_Cal_Ev_T_E_05, TS_Cal_Ev_T_E_06, TS_Cal_Ev_T_E_07, TS_Cal_Ev_T_E_08, TS_Cal_Ev_T_E_09, TS_Cal_Ev_T_E_10, TS_Cal_Ev_T_E_11, TS_Cal_Ev_T_E_12, TS_Cal_Ev_T_E_13, TS_Cal_Ev_T_E_14, TS_Cal_Ev_T_E_15, TS_Cal_Ev_T_E_16, TS_Cal_Ev_T_E_17, TS_Cal_Ev_T_E_18, TS_Cal_Ev_T_E_19, TS_Cal_Ev_T_E_20, TS_Cal_Ev_T_E_21, TS_Cal_Ev_T_E_22, TS_Cal_Ev_T_E_23, TS_Cal_Ev_T_E_24, TS_Cal_Ev_T_E_25, TS_Cal_Ev_T_E_26, TS_Cal_Ev_T_E_27, TS_Cal_Ev_T_E_28, TS_Cal_Ev_T_E_29, TS_Cal_Ev_T_E_30, TS_Cal_Ev_T_E_31, TS_Cal_Ev_T_E_32, TS_Cal_Ev_T_E_33, TS_Cal_Ev_T_E_34, TS_Cal_Ev_T_E_35, TS_Cal_Ev_T_E_36, TS_Cal_Ev_T_E_37, TS_Cal_Ev_T_E_38, TS_Cal_Ev_T_E_39) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoft_T1_ID[0]->id,  $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_01, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_02, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_03, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_04, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_05, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_06, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_07, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_08, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_09, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_10, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_11, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_12, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_13, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_14, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_15, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_16, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_17, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_18, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_19, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_20, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_21, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_22, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_23, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_24, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_25, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_26, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_27, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_28, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_29, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_30, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_31, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_32, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_32, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_33, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_35, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_36, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_37, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_38, $Total_SoftCal_Ev_DatT2[0]->TS_Cal_Ev_T_E_39));
		die();
	}

	add_action( 'wp_ajax_TotalSoftCalEv_T_Edit1', 'TotalSoftCalEv_T_Edit1_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_T_Edit1', 'TotalSoftCalEv_T_Edit1_Callback' );

	function TotalSoftCalEv_T_Edit1_Callback()
	{
		$Theme_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;

		$table_name5 = $wpdb->prefix . "totalsoft_evcal_eff_p1";
	
		$Total_SoftCal_Ev_DatT1=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE TS_Cal_Ev_T_ID = %d", $Theme_ID));
		
		print_r($Total_SoftCal_Ev_DatT1);
		die();
	}

	add_action( 'wp_ajax_TotalSoftCalEv_T_Edit2', 'TotalSoftCalEv_T_Edit2_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_T_Edit2', 'TotalSoftCalEv_T_Edit2_Callback' );

	function TotalSoftCalEv_T_Edit2_Callback()
	{
		$Theme_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;

		$table_name6 = $wpdb->prefix . "totalsoft_evcal_eff_p2";
	
		$Total_SoftCal_Ev_DatT2=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name6 WHERE TS_Cal_Ev_T_ID = %d", $Theme_ID));
		
		print_r($Total_SoftCal_Ev_DatT2);
		die();
	}
?>