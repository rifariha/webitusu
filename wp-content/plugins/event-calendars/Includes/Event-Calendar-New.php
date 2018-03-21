<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	global $wpdb;

	$table_name1 = $wpdb->prefix . "totalsoft_evcal_ids";
	$table_name2 = $wpdb->prefix . "totalsoft_evcal_manager";
	$table_name3 = $wpdb->prefix . "totalsoft_evcal_events";
	$table_name4 = $wpdb->prefix . "totalsoft_evcal_eff_data";
	$table_name5 = $wpdb->prefix . "totalsoft_evcal_eff_p1";

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if(check_admin_referer( 'edit-menu_'.$comment_id, 'TS_EvCal_Nonce' ))
		{
			$Total_Soft_Cal_Ev_Name   = str_replace("\&","&", sanitize_text_field(esc_html($_POST['Total_Soft_Cal_Ev_Name'])));
			$Total_Soft_Cal_Ev_Theme  = sanitize_text_field($_POST['Total_Soft_Cal_Ev_Theme']);
			$Total_Soft_Cal_Ev_ECount = sanitize_text_field($_POST['Total_Soft_Cal_Ev_ECount']);

			$TS_Cal_Ev_Title = array();
			$TS_Cal_Ev_Color = array();
			$TS_Cal_Ev_Date  = array();
			$TS_Cal_Ev_Desc  = array();

			for( $i=1; $i<=$Total_Soft_Cal_Ev_ECount; $i++ )
			{
				$TS_Cal_Ev_Title[$i] = str_replace("\&","&", sanitize_text_field(esc_html($_POST['TS_Cal_Ev_Title_' . $i])));
				$TS_Cal_Ev_Color[$i] = sanitize_text_field($_POST['TS_Cal_Ev_Color_' . $i]);
				$TS_Cal_Ev_Date[$i]  = sanitize_text_field($_POST['TS_Cal_Ev_Date_' . $i]);
				$TS_Cal_Ev_Desc[$i]  = str_replace("\&","&", sanitize_text_field(esc_html($_POST['TS_Cal_Ev_Desc_' . $i])));
			}

			if(isset($_POST['Total_Soft_Cal_Ev_Save']))
			{
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name2 (id, Total_Soft_Cal_Ev_Name, Total_Soft_Cal_Ev_Theme, Total_Soft_Cal_Ev_ECount) VALUES (%d, %s, %s, %s)", '', $Total_Soft_Cal_Ev_Name, $Total_Soft_Cal_Ev_Theme, $Total_Soft_Cal_Ev_ECount));
				
				$TotalSoftEvCalNewID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id>%d order by id desc limit 1",0));

				$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, EvCal_ID) VALUES (%d, %s)", '', $TotalSoftEvCalNewID[0]->id));

				for( $i=1; $i<=$Total_Soft_Cal_Ev_ECount; $i++ )
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, EvCal_ID, TS_Cal_Ev_Title, TS_Cal_Ev_Color, TS_Cal_Ev_Date, TS_Cal_Ev_Desc) VALUES (%d, %s, %s, %s, %s, %s)", '', $TotalSoftEvCalNewID[0]->id, $TS_Cal_Ev_Title[$i], $TS_Cal_Ev_Color[$i], $TS_Cal_Ev_Date[$i], $TS_Cal_Ev_Desc[$i]));
				}
			}
			else if(isset($_POST['Total_Soft_Cal_Ev_Update']))
			{
				$Total_SoftCal_Ev_Update = $_POST['Total_SoftCal_Ev_Update'];

				$wpdb->query($wpdb->prepare("UPDATE $table_name2 set Total_Soft_Cal_Ev_Name=%s, Total_Soft_Cal_Ev_Theme=%s, Total_Soft_Cal_Ev_ECount=%s WHERE id=%d", $Total_Soft_Cal_Ev_Name, $Total_Soft_Cal_Ev_Theme, $Total_Soft_Cal_Ev_ECount, $Total_SoftCal_Ev_Update));

				$wpdb->query($wpdb->prepare("DELETE FROM $table_name3 WHERE EvCal_ID=%d", $Total_SoftCal_Ev_Update));
				
				for( $i=1; $i<=$Total_Soft_Cal_Ev_ECount; $i++ )
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, EvCal_ID, TS_Cal_Ev_Title, TS_Cal_Ev_Color, TS_Cal_Ev_Date, TS_Cal_Ev_Desc) VALUES (%d, %s, %s, %s, %s, %s)", '', $Total_SoftCal_Ev_Update, $TS_Cal_Ev_Title[$i], $TS_Cal_Ev_Color[$i], $TS_Cal_Ev_Date[$i], $TS_Cal_Ev_Desc[$i]));
				}
			}
		}
	    else
	    {
	        wp_die('Security check fail'); 
	    }
	}

	$Total_SoftCal_Ev_ID =$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name1 WHERE id>%d order by id desc limit 1",0));	
	$Total_SoftCal_Ev_Dat=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id>%d",0));
	$Total_SoftCal_Ev_Themes=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id>%d",0));
?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../CSS/totalsoft.css',__FILE__);?>">
<script src='<?php echo plugins_url('../JS/tinymce.js',__FILE__);?>'></script>
<form method="POST">
	<?php wp_nonce_field( 'edit-menu_'.$comment_id, 'TS_EvCal_Nonce' );?>
	<div class="Total_Soft_Cal_Ev_AMD">
		<div class="Support_Span">
			<a href="https://wordpress.org/support/plugin/event-calendars/" target="_blank" title="Click Here to Ask">
				<i class="totalsoft totalsoft-comments-o"></i><span style="margin-left:5px;">If you have any questions click here to ask it to our support.</span>
			</a>
		</div>
		<div class="Total_Soft_Cal_Ev_AMD1"></div>
		<div class="Total_Soft_Cal_Ev_AMD2">
			<i class="Total_Soft_Help_Ev totalsoft totalsoft-question-circle-o" title="Click for Creating New Calendar"></i>
			<input type="button" name="" value="New Calendar" class="Total_Soft_Cal_Ev_AMD2_But" onclick="Total_Soft_Cal_Ev_AMD2_But1(<?php echo $Total_SoftCal_Ev_ID[0]->EvCal_ID+1;?>)">
		</div>
		<div class="Total_Soft_Cal_Ev_AMD3">
			<i class="Total_Soft_Help_Ev totalsoft totalsoft-question-circle-o" title="Click for Canceling"></i>
			<input type="button" value="Cancel" class="Total_Soft_Cal_Ev_AMD2_But" onclick='TotalSoft_Cal_Ev_Reload()'>
			<i class="Total_Soft_Cal_Ev_Save Total_Soft_Help_Ev totalsoft totalsoft-question-circle-o" title="Click for Saving Calendar"></i>
			<input type="submit" name="Total_Soft_Cal_Ev_Save" value="Save" class="Total_Soft_Cal_Ev_Save Total_Soft_Cal_Ev_AMD2_But">
			<i class="Total_Soft_Cal_Ev_Update Total_Soft_Help_Ev totalsoft totalsoft-question-circle-o" title="Click for Updating Calendar"></i>
			<input type="submit" name="Total_Soft_Cal_Ev_Update" value="Update" class="Total_Soft_Cal_Ev_Update Total_Soft_Cal_Ev_AMD2_But">
			<input type="text" style="display:none" name="Total_SoftCal_Ev_Update" id="Total_SoftCal_Ev_Update">
		</div>
	</div>

	<table class="Total_Soft_Cal_Ev_AMMTable">
		<tr class="Total_Soft_Cal_Ev_AMMTableFR">
			<td>No</td>
			<td>Calendar Name</td>
			<td>Calendar Theme</td>
			<td>Events Quantity</td>
			<td>Actions</td>
		</tr>
	</table>

	<table class="Total_Soft_Cal_Ev_AMOTable">
	 	<?php for($i=0;$i<count($Total_SoftCal_Ev_Dat);$i++){ 
			$Total_SoftCal_Ev_Theme=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id=%d",$Total_SoftCal_Ev_Dat[$i]->Total_Soft_Cal_Ev_Theme));

	 		?> 
	 		<tr>
				<td><?php echo $i+1;?></td>
				<td><?php echo html_entity_decode($Total_SoftCal_Ev_Dat[$i]->Total_Soft_Cal_Ev_Name);?></td>
				<td><?php echo html_entity_decode($Total_SoftCal_Ev_Theme[0]->TS_Cal_Ev_TName);?></td>
				<td><?php echo '( ' . $Total_SoftCal_Ev_Dat[$i]->Total_Soft_Cal_Ev_ECount . ' )';?></td>
				<td onclick="TotalSoftCal_Ev_Copy(<?php echo $Total_SoftCal_Ev_Dat[$i]->id;?>)"><i class="Total_SoftEv_Cal_Edit totalsoft totalsoft-file-text"></i></td>
				<td onclick="TotalSoftCal_Ev_Edit(<?php echo $Total_SoftCal_Ev_Dat[$i]->id;?>)"><i class="Total_SoftEv_Cal_Edit totalsoft totalsoft-pencil"></i></td>
				<td onclick="TotalSoftCal_Ev_Del(<?php echo $Total_SoftCal_Ev_Dat[$i]->id;?>)"><i class="Total_SoftEv_Cal_Del totalsoft totalsoft-trash"></i></td>
			</tr>
	 	<?php }?>
	</table>

	<table class="Total_Soft_Cal_Ev_AMShortTable">
		<tr style="text-align:center">
			<td>Shortcode</td>
			<td>Templete Include</td>
		</tr>
		<tr>
			<td>Copy &amp; paste the shortcode directly into any WordPress post or page.</td>
			<td>Copy &amp; paste this code into a template file to include the calendar within your theme.</td>
		</tr>
		<tr style="text-align:center">
			<td class="Total_Soft_Cal_Ev_ID"></td>
			<td class="Total_Soft_Cal_Ev_TID"></td>
		</tr>
	</table>

	<table class="Total_Soft_Cal_Ev_MTable">
		<tr class="Total_Soft_Cal_Ev_MTable_tr">
			<td colspan="2">
				Calendar Settings
			</td>
		</tr>
		<tr>
			<td>Name</td>
			<td>Theme</td>
		</tr>
		<tr>
			<td>
				<input type="text" class="Total_Soft_Cal_Ev_Sel" name="Total_Soft_Cal_Ev_Name" id="Total_Soft_Cal_Ev_Name" required placeholder=" *  Required">
			</td>
			<td>
				<select class="Total_Soft_Cal_Ev_Sel" id="Total_Soft_Cal_Ev_Theme" name="Total_Soft_Cal_Ev_Theme">
					<?php for($i=0;$i<count($Total_SoftCal_Ev_Themes);$i++){?>
						<option value="<?php echo $Total_SoftCal_Ev_Themes[$i]->id;?>"><?php echo html_entity_decode($Total_SoftCal_Ev_Themes[$i]->TS_Cal_Ev_TName);?></option>
					<?php }?>
				</select>
			</td>
		</tr>
		<tr class="Total_Soft_Cal_Ev_MTable_tr">
			<td colspan="2">
				Event Settings
			</td>
		</tr>
		<tr>
			<td>Event Title</td>
			<td>Event Color</td>
		</tr>
		<tr>
			<td>
				<input type="text" class="Total_Soft_Cal_Ev_Sel" name="" id="Total_Soft_Cal_Ev_ETitle">
			</td>
			<td>
				<input type="text" class="Total_Soft_Cal_Ev_Col" name="" id="Total_Soft_Cal_Ev_EColor">
			</td>
		</tr>
		<tr>
			<td>Event Date <i class="Total_Soft_Help_Ev1 totalsoft totalsoft-question-circle-o" title="If you want to add date manually, you must write it in yyyy-mm-dd format."></i></td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input type="date" class="Total_Soft_Cal_Ev_Sel" name="" id="Total_Soft_Cal_Ev_EDate" placeholder="yyyy-mm-dd">
			</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">Event Description</td>
		</tr>
		<tr>
			<td colspan="2">
				<div style="padding: 0 !important;">
					<textarea id="Total_Soft_Cal_Ev_EDesc">
					  
					</textarea>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="Total_Soft_Cal_Ev_ETD">
				<input type="button" id="Total_Soft_Cal_Ev_ESave"   value="Save"   onclick="Total_Soft_Cal_Ev_ESaveCl()">
				<input type="button" id="Total_Soft_Cal_Ev_EUpdate" value="Update" onclick="Total_Soft_Cal_Ev_EUpdateCl()">
				<input type="button" id="Total_Soft_Cal_Ev_ECalcel" value="Cancel" onclick="Total_Soft_Cal_Ev_ECalcelCl()">
				<input type="text" style="display:none;" id="Total_Soft_Cal_Ev_ECount" name="Total_Soft_Cal_Ev_ECount" value="0">
				<input type="text" style="display:none;" id="Total_Soft_Cal_Ev_EIndex" value="0">
			</td>
		</tr>
	</table>

	<table class='Total_Soft_Cal_Ev_MTable1'>
		<tr>
			<td> No </td>
			<td> Event Title </td>
			<td> Event Date </td>
			<td> Actions </td>
		</tr>
	</table>
	<table class='Total_Soft_Cal_Ev_MTable2' onmouseover="Total_Soft_Cal_Ev_ESort()">
	
	</table>
</form>