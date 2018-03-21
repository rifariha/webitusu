<?php
	
	class Event_Calendar_TS extends WP_Widget
	{
		function __construct()
 	  	{
 			$params=array('name'=>'Total Soft Event Calendar','description'=>__( 'This is the widget of Total Soft Event Calendar plugin', 'Total-Soft-Event-Calendar' ));
			parent::__construct('Event_Calendar_TS','',$params);
 	  	}
 	  	function form($instance)
 		{
 			$defaults = array('Event_Calendar_TS'=>'');
		    $instance = wp_parse_args((array)$instance, $defaults);

		   	$Calendar = $instance['Event_Calendar_TS'];
		   	?>
		   	<div>			  
			   	<p>
			   		Calendar Title:
			   		<select name="<?php echo $this->get_field_name('Event_Calendar_TS'); ?>" class="widefat">
				   		<?php
				   			global $wpdb;

							$table_name2 = $wpdb->prefix . "totalsoft_evcal_manager";
							$Event_Calendar_TS=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id > %d", 0));
				   			
				   			foreach ($Event_Calendar_TS as $Total_Soft_CalEv1)
				   			{
				   				?> <option value="<?php echo $Total_Soft_CalEv1->id; ?>"> <?php echo $Total_Soft_CalEv1->Total_Soft_Cal_Ev_Name; ?> </option> <?php 
				   			}
				   		?>
			   		</select>
			   	</p>
		   	</div>
		   	<?php
 		}
 		function widget($args,$instance)
 		{
 			extract($args);
 		 	$Event_Calendar_TS = empty($instance['Event_Calendar_TS']) ? '' : $instance['Event_Calendar_TS'];
 		 	global $wpdb;

			$table_name2 = $wpdb->prefix . "totalsoft_evcal_manager";
			$table_name3 = $wpdb->prefix . "totalsoft_evcal_events";
			$table_name4 = $wpdb->prefix . "totalsoft_evcal_eff_data";
			$table_name5 = $wpdb->prefix . "totalsoft_evcal_eff_p1";
			$table_name6 = $wpdb->prefix . "totalsoft_evcal_eff_p2";

			$TotalSoftCalEv_Data=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id = %d", $Event_Calendar_TS));
			$Total_Soft_CalEvents=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE EvCal_ID=%s order by id",$Event_Calendar_TS));
			$Total_Soft_CalThemes=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id=%d order by id",$TotalSoftCalEv_Data[0]->Total_Soft_Cal_Ev_Theme));

			$Total_Soft_CalEv_Date = array();
			$Total_Soft_CalEv_Desc = array();
			$Total_Soft_CalEv_Color = array();
			$Total_Soft_CalEv_Date_Real = array();
			$Total_Soft_CalEv_Desc_Real = array();
			$Total_Soft_CalEv_Color_Real = array();

			for($i=0;$i<count($Total_Soft_CalEvents);$i++)
			{
				$TS_Cal_Ev_Date = explode('-', $Total_Soft_CalEvents[$i]->TS_Cal_Ev_Date);
				$TS_Cal_Ev_Date1 = $TS_Cal_Ev_Date[1] . '-' . $TS_Cal_Ev_Date[2] . '-' . $TS_Cal_Ev_Date[0];
				array_push($Total_Soft_CalEv_Date, $TS_Cal_Ev_Date1);
				array_push($Total_Soft_CalEv_Desc, '<p class="TS_Cal_Ev_Title">' . $Total_Soft_CalEvents[$i]->TS_Cal_Ev_Title . '</p>' . $Total_Soft_CalEvents[$i]->TS_Cal_Ev_Desc);
				array_push($Total_Soft_CalEv_Color, $Total_Soft_CalEvents[$i]->TS_Cal_Ev_Color);
			}
			for($i=0;$i<count($Total_Soft_CalEv_Date);$i++)
			{
				if($Total_Soft_CalEv_Date[$i] != '' || $Total_Soft_CalEv_Date[$i] != null)
				{
					for($j=$i; $j<count($Total_Soft_CalEv_Date)-1;$j++)
					{
						if($Total_Soft_CalEv_Date[$i] === $Total_Soft_CalEv_Date[$j+1])
						{
							$Total_Soft_CalEv_Date[$j+1] = '';
							$Total_Soft_CalEv_Desc[$i] = $Total_Soft_CalEv_Desc[$i] . '<div class="TS_Cal_Ev_LAEE"></div>' . $Total_Soft_CalEv_Desc[$j+1];
							$Total_Soft_CalEv_Color[$i] = $Total_Soft_CalEv_Color[$j+1];
							$Total_Soft_CalEv_Desc[$j+1] = '';
							$Total_Soft_CalEv_Color[$j+1] = '';
						}
					}	
				}	
			}
			for($i=0;$i<count($Total_Soft_CalEv_Date);$i++)
			{
				if($Total_Soft_CalEv_Date[$i] != '')
				{
					array_push($Total_Soft_CalEv_Date_Real, $Total_Soft_CalEv_Date[$i]);
					array_push($Total_Soft_CalEv_Desc_Real, $Total_Soft_CalEv_Desc[$i]);
					array_push($Total_Soft_CalEv_Color_Real, $Total_Soft_CalEv_Color[$i]);
				}
			}

			if($Total_Soft_CalThemes[0]->TS_Cal_Ev_TType == 'Popover Calendar')
			{
				$Total_Soft_CalTheme=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE TS_Cal_Ev_T_ID=%d order by id",$Total_Soft_CalThemes[0]->id));
				$Total_Soft_CalTheme_1=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name6 WHERE TS_Cal_Ev_T_ID=%d order by id",$Total_Soft_CalThemes[0]->id));
			}
 		 	echo $before_widget;
 		 	?>
	 		<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../CSS/totalsoft.css',__FILE__);?>">

 		 	<?php if($Total_Soft_CalThemes[0]->TS_Cal_Ev_TType == 'Popover Calendar') { ?>
 		 		<style type="text/css">
 		 			.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?>
 		 			{
 		 				max-width: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_01;?>px;
						<?php if($Total_Soft_CalTheme[0]->TS_Cal_Ev_T_06=='Yes'){ ?>
						    <?php if($Total_Soft_CalTheme[0]->TS_Cal_Ev_T_07=='1'){ ?>
								-webkit-box-shadow: 0 30px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_08;?>px -18px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_09;?>;
								-moz-box-shadow: 0 30px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_08;?>px -18px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_09;?>;
								box-shadow: 0 30px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_08;?>px -18px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_09;?>;
						    <?php }else{ ?> <?php ?>
						    	-webkit-box-shadow: 0px 0px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_08;?>px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_09;?>;
								-moz-box-shadow: 0px 0px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_08;?>px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_09;?>;
								box-shadow: 0px 0px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_08;?>px <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_09;?>;
						    <?php }?>
						<?php }?>
 		 			}
 		 			.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> #TS_popover_calendar_<?php echo $Event_Calendar_TS;?>
 		 			{
 		 				height: <?php if($Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_28==''){ echo '400px'; }else{ echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_28 . 'px'; } ?>;
 		 			}
 		 			.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div:empty 
					{
						background: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_03;?> !important;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div:empty:hover
					{
						background: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_03;?> !important;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row 
					{
						border-bottom: 1px solid <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_04;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div 
					{
						border-right: 1px solid <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_04;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-body 
					{
						border: 1px solid <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_05;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .TS-popover-header 
					{
						background: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_10;?>;
						border-top: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_11;?>px solid <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_12;?>;
						border-bottom: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_23;?>px solid <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_24;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .TS-popover-header h3
					{
						font-family: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_13;?> !important;
						text-transform: none !important;
						<?php if($Total_Soft_CalTheme[0]->TS_Cal_Ev_T_18=='3' || $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_18=='4'){ ?>
							position: relative;
							top: 50%;
							-ms-transform: translateY(-50%);
						    -webkit-transform: translateY(-50%);
						    -moz-transform: translateY(-50%);
						    -o-transform: translateY(-50%);
						    transform: translateY(-50%);
						<?php }?>
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .TS-popover-header .TS-popover-month
					{
						font-size: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_14;?>px !important;
						color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_15;?> !important;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .TS-popover-header .TS-popover-year
					{
						font-size: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_16;?>px !important;
						color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_17;?> !important;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .TS-popover-header nav i
					{
						font-size: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_21;?>px;
						width: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_21+10;?>px;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .TS-popover-header nav i:before
					{
						color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_20;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .TS-popover-header nav i:hover:before 
					{
						color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_22;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-head {
						background: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_25;?>;
						color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_26;?>;
						font-size: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_27;?>px;
						font-family: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_28;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div 
					{
						background-color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_29;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div > span.ts-popover-date
					{
						color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_30;?>;
					}

					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div.ts-popover-today 
					{ 
						background: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_31;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div.ts-popover-today > span.ts-popover-date 
					{ 
						color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_32;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div:hover 
					{ 
						background: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_33;?> !important;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div:hover span.ts-popover-date
					{
						color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_34;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div.ts-popover-content span.ts-popover-date
					{
						color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_25;?>;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div.ts-popover-content:hover
					{
						background-color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_27;?> !important;
					}
					.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div.ts-popover-content:hover span.ts-popover-date
					{
						color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_26;?> !important;
					}
					<?php if($Total_Soft_CalTheme[0]->TS_Cal_Ev_T_35=='Yes'){ ?>
						.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div.ts-popover-content:after
						{
							content: '\00B7'; 
							text-align: center; 
							width: 20px; 
							margin-left: -10px; 
							position: absolute; 
							color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_36;?>; 
							font-size: 70px; 
							line-height: 20px; 
							left: 50%; 
							bottom: 3px;
						}
						.TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?> .ts-popover-calendar .ts-popover-row > div.ts-popover-content:hover:after
						{
							color: <?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_37;?>; 
						}
					<?php }?>
					.TSECpopover_<?php echo $Event_Calendar_TS;?>
					{
						max-width: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_01;?>px;
						max-height: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_02;?>px;
						<?php if($Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_03 == '1'){ ?>
							background: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_04;?>;
						<?php }else{ ?>
							background: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_04;?>;
						    background: -webkit-linear-gradient(<?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_04;?>, <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_05;?>);
						    background: -o-linear-gradient(<?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_04;?>, <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_05;?>);
						    background: -moz-linear-gradient(<?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_04;?>, <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_05;?>);
						    background: linear-gradient(<?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_04;?>, <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_05;?>);
						<?php } ?>
						border: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_06;?>px solid <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_07;?>;
						border-radius: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_08;?>px;
					}
					.TSECpopover_<?php echo $Event_Calendar_TS;?> .TS_Cal_Ev_Title
					{
						color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_18;?>;
						background: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_17;?>;
						font-size: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_19;?>px;
						font-family: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_20;?>;
						text-align: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_21;?>; 
					}
					.TSECpopover_<?php echo $Event_Calendar_TS;?> .TS_Cal_Ev_LAEE
					{
						width: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_22;?>%;
						height: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_23;?>px;
						background: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_24;?>;
						margin: 10px auto;
					}
					.TSECpopover_<?php echo $Event_Calendar_TS;?> .TSECpopover-content
					{
						height: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_02-$Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_13-30-2*$Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_06;?>px;
					}
					.TSECpopover_<?php echo $Event_Calendar_TS;?>.top .arrow:after
					{
						border-top-color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_07;?>;
					}
					.TSECpopover_<?php echo $Event_Calendar_TS;?>.bottom .arrow:after
					{
						border-bottom-color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_07;?>;
					}
					.TSECpopover_<?php echo $Event_Calendar_TS;?>.left .arrow:after
					{
						border-left-color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_07;?>;
					}
					.TSECpopover_<?php echo $Event_Calendar_TS;?>.right .arrow:after
					{
						border-right-color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_07;?>;
					}
					.TSECpopover_<?php echo $Event_Calendar_TS;?> .TSECpopover-title
					{
						background-color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_10;?>;
						color: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_11;?>;
						font-size: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_13;?>px;
						font-family: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_14;?>;
						text-align: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_12;?>;
						border-bottom: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_15;?>px solid <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_16;?>; 
						border-radius: <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_08-1;?>px <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_08-1;?>px 0 0;
					}
					/* Events List custom webkit scrollbar */
					.TSECpopover-content::-webkit-scrollbar {width: 9px;}
					/* Track */
					.TSECpopover-content::-webkit-scrollbar-track {background: none;}
					/* Handle */
					.TSECpopover-content::-webkit-scrollbar-thumb {
						background: transparent;
						border:1px solid <?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_18;?>;
						border-radius: 10px;
					}
					.TSECpopover-content::-webkit-scrollbar-thumb:hover {background:<?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_17;?>;}
 		 		</style>
 		 		<script src="<?php echo plugins_url('../JS/modernizr.custom.63321.js',__FILE__);?>"></script>
				<script src="<?php echo plugins_url('../JS/jquery.calendario.js',__FILE__);?>"></script>
				<script src="<?php echo plugins_url('../JS/bootstrap.js',__FILE__);?>"></script>
            	<input type="text" style="display: none" id="TS_popover_WDS_<?php echo $Event_Calendar_TS;?>" value="<?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_02;?>">
            	<input type="text" style="display: none" id="TS_popover_EPF_<?php echo $Event_Calendar_TS;?>" value="<?php echo $Total_Soft_CalTheme_1[0]->TS_Cal_Ev_T_E_09;?>">
            	<div class="TS-popover-calendar-wrap TS-popover-calendar-wrap_<?php echo $Event_Calendar_TS;?>">
                    <div id="TS_popover_inner_<?php echo $Event_Calendar_TS;?>" class="TS-popover-inner">
                        <div class="TS-popover-header clearfix">
                            <nav>
                                <i id="TS_popover_prev_<?php echo $Event_Calendar_TS;?>" class="totalsoft totalsoft-<?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_19;?>-left "></i>
								<i id="TS_popover_next_<?php echo $Event_Calendar_TS;?>" class="totalsoft totalsoft-<?php echo $Total_Soft_CalTheme[0]->TS_Cal_Ev_T_19;?>-right"></i>
                            </nav>
                            <?php if($Total_Soft_CalTheme[0]->TS_Cal_Ev_T_18=='1'){ ?>
								<h3 id="TS_popover_year_<?php echo $Event_Calendar_TS;?>" class="TS-popover-year"></h3>
								<h3 id="TS_popover_month_<?php echo $Event_Calendar_TS;?>" class="TS-popover-month"></h3>
							<?php }else if($Total_Soft_CalTheme[0]->TS_Cal_Ev_T_18=='2'){ ?>
								<h3 id="TS_popover_month_<?php echo $Event_Calendar_TS;?>" class="TS-popover-month"></h3>
								<h3 id="TS_popover_year_<?php echo $Event_Calendar_TS;?>" class="TS-popover-year"></h3>
							<?php }else if($Total_Soft_CalTheme[0]->TS_Cal_Ev_T_18=='3'){ ?>
								<h3>
									<span id="TS_popover_year_<?php echo $Event_Calendar_TS;?>" class="TS-popover-year"></span>
									<span id="TS_popover_month_<?php echo $Event_Calendar_TS;?>" class="TS-popover-month"></span>
								</h3>
							<?php }else{ ?>
								<h3>
									<span id="TS_popover_month_<?php echo $Event_Calendar_TS;?>" class="TS-popover-month"></span>
									<span id="TS_popover_year_<?php echo $Event_Calendar_TS;?>" class="TS-popover-year"></span>
								</h3>
							<?php }?>
                        </div>
                        <div id="TS_popover_calendar_<?php echo $Event_Calendar_TS;?>" class="ts-popover-calendar-container"></div>
                    </div>
                </div>
		        <script type="text/javascript"> 
		        	var codropsEvents<?php echo $Event_Calendar_TS;?> = {
						<?php for($i=0;$i<count($Total_Soft_CalEv_Date_Real);$i++){ ?>
							'<?php echo $Total_Soft_CalEv_Date_Real[$i];?>' : {content: '<?php echo html_entity_decode($Total_Soft_CalEv_Desc_Real[$i]);?>', Color: '<?php echo $Total_Soft_CalEv_Color_Real[$i];?>'},			            	
						<?php }?>
					};
					jQuery(document).ready(function(){
						var pop_title = '', pop_content = '';
						var TS_popover_WDS = parseInt(jQuery('#TS_popover_WDS_<?php echo $Event_Calendar_TS;?>').val());
					    jQuery(document).popover({
					        delay: { show: 100, hide: 200 },
					        html: true,
					        trigger: 'click',
					        selector: 'div.ts-popover-content',
					        placement: 'auto',
					        template: '<div class="TSECpopover TSECpopover_<?php echo $Event_Calendar_TS;?>" role="tooltip"><div class="arrow"></div><h3 class="TSECpopover-title"></h3><div class="TSECpopover-content"></div></div>',
					        content: function() {
					                return pop_content;
					            },
					        title: function() {
					                return pop_title;
					            },
					        container: 'body'
					    });
					    var transEndEventNames = {
					            'WebkitTransition' : 'webkitTransitionEnd',
					            'MozTransition' : 'transitionend',
					            'OTransition' : 'oTransitionEnd',
					            'msTransition' : 'MSTransitionEnd',
					            'transition' : 'transitionend'
					        },
					        transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
					        $wrapper = jQuery( '#TS_popover_inner_<?php echo $Event_Calendar_TS;?>'),
					        $calendar = jQuery( '#TS_popover_calendar_<?php echo $Event_Calendar_TS;?>'),
					        cal = $calendar.calendario({
					            onDayMouseenter : function( $el, data, dateProperties ) {
					                var TS_popover_EPF = jQuery('#TS_popover_EPF_<?php echo $Event_Calendar_TS;?>').val();
					                if( data.content.length > 0 )
					                {
					                    if(dateProperties.month < 10)
					                    {
					                        var TS_popover_EPFM = '0';
					                    }
					                    else
					                    {
					                        var TS_popover_EPFM = '';
					                    }
					                    if(TS_popover_EPF == 'yy-mm-dd')
					                    {
					                        pop_title = dateProperties.year + '-' + TS_popover_EPFM + dateProperties.month + '-' + dateProperties.day;
					                    }
					                    else if(TS_popover_EPF == 'yy MM dd')
					                    {
					                        pop_title = dateProperties.year + ' ' + dateProperties.monthname + ' ' + dateProperties.day;
					                    }
					                    else if(TS_popover_EPF == 'dd-mm-yy')
					                    {
					                        pop_title = dateProperties.day + '-' + TS_popover_EPFM + dateProperties.month + '-' + dateProperties.year;
					                    }
					                    else if(TS_popover_EPF == 'dd MM yy')
					                    {
					                        pop_title = dateProperties.day + ' ' + dateProperties.monthname + ' ' + dateProperties.year;
					                    }
					                    else if(TS_popover_EPF == 'mm-dd-yy')
					                    {
					                        pop_title = TS_popover_EPFM + dateProperties.month + '-' + dateProperties.day + '-' + dateProperties.year;
					                    }
					                    else if(TS_popover_EPF == 'MM dd, yy')
					                    {
					                        pop_title = dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year;
					                    }
					                    pop_content = data.content.join('');
					                }
					            },
					            caldata : codropsEvents<?php echo $Event_Calendar_TS;?>,
					            startIn : TS_popover_WDS,
					            events: 'mouseenter',
					            displayWeekAbbr : true,
					            fillEmpty: false
					        }),
					        $month = jQuery( '#TS_popover_month_<?php echo $Event_Calendar_TS;?>').html( cal.getMonthName() ),
					        $year = jQuery( '#TS_popover_year_<?php echo $Event_Calendar_TS;?>').html( cal.getYear() );
					    jQuery( '#TS_popover_next_<?php echo $Event_Calendar_TS;?>' ).on( 'click', function() {
					        cal.gotoNextMonth( updateMonthYear );
					    } );
					    jQuery( '#TS_popover_prev_<?php echo $Event_Calendar_TS;?>' ).on( 'click', function() {
					        cal.gotoPreviousMonth( updateMonthYear );
					    } );
					    function updateMonthYear() {                
					        $month.html( cal.getMonthName() );
					        $year.html( cal.getYear() );
					    }
					})
		        </script>
 		 	<?php }?>
			<?php
 		 	echo $after_widget;
 		}
	}
?>