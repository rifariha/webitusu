<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
if(false): 
__('Event Details','rhc');
__('Start time','rhc');
__('Start date','rhc');
__('End date','rhc');
__('End time','rhc');
__('Calendar','rhc');
__('Organizer','rhc');
__('Name:','rhc');
__('Name','rhc');
__('Email','rhc');
__('Phone','rhc');
__('Website','rhc');
__('Venue Details','rhc');
__('Address','rhc');
__('City','rhc');
__('Zip Code','rhc');
__('State','rhc');
__('Country','rhc');
__('Information','rhc');
__('Get directions','rhc');
endif;
               
$str = <<<EOT
{"detailbox":{"id":"detailbox","columns":"2","span":"6","data":[{"id":"","type":"label","label":"Event details:","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":false,"post_ID":"35061","date_format":false,"column":"0","span":"12","offset":0,"index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"postmeta","label":"Start date","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_start_datetime","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"postmeta","label":"End date","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_end_datetime","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"label","label":"Organizer details:","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":false,"post_ID":"35061","date_format":false,"column":"1","span":"12","offset":0,"index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Organizer","custom":"","value":"","taxonomy":"organizer","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Phone","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"organizer","taxonomymeta_field":"phone","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Email","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"organizer","taxonomymeta_field":"email","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Website","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"organizer","taxonomymeta_field":"website","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Calendar","custom":"","value":"","taxonomy":"calendar","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":false,"post_ID":"35061","date_format":false,"column":"0","span":"12","offset":0,"index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"custom","label":"Google Calendar","custom":"","value":"[btn_ical_feed]","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":false,"post_ID":"35061","date_format":false,"column":"0","span":"12","offset":0,"index":"","frontend":true,"rhc_date":false,"format":""}]},"venuebox":{"id":"venuebox","columns":"2","span":"6","data":[{"id":"","type":"label","label":"Venue Details","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"label","label":"Information","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Phone","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"phone","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Email","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"email","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Website","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"website","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Get directions","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"gaddress","render_cb":"false","post_ID":"35061","date_format":false,"column":"1","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Venue","custom":"","value":"","taxonomy":"venue","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Address","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"address","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"City","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"city","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Postal code","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"zip","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"State","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"state","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomymeta","label":"Country","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"","taxonomymeta":"venue","taxonomymeta_field":"country","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""}]},"tooltipbox":{"id":"tooltipbox","columns":"1","span":"","data":[{"id":"","type":"postmeta","label":"Start date","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_start_datetime","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"postmeta","label":"End date","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_end_datetime","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Venue","custom":"","value":"","taxonomy":"venue","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Organizer","custom":"","value":"","taxonomy":"organizer","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Calendar","custom":"","value":"","taxonomy":"calendar","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""}]},"gridviewbox":{"id":"gridviewbox","columns":"1","span":"","data":[{"id":"","type":"postmeta","label":"Start date","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_start","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"postmeta","label":"Start time","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_start_time","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Venue","custom":"","value":"","taxonomy":"venue","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"12","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""}]},"slideviewbox":{"id":"slideviewbox","columns":"1","span":"3","data":[{"id":"","type":"postmeta","label":"Start date","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_start","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"postmeta","label":"Start time","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_start_time","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"postmeta","label":"End date","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_end","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"postmeta","label":"End time","custom":"","value":"","taxonomy":"","taxonomy_links":false,"postmeta":"fc_end_time","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Venue","custom":"","value":"","taxonomy":"venue","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""},{"id":"","type":"taxonomy","label":"Organizer","custom":"","value":"","taxonomy":"organizer","taxonomy_links":false,"postmeta":"","taxonomymeta":"","taxonomymeta_field":"","render_cb":"false","post_ID":"35061","date_format":false,"column":"0","span":"6","offset":"0","index":"","frontend":true,"rhc_date":false,"format":""}]}}
EOT;

$postinfo_boxes = json_decode( trim($str) );
$postinfo_boxes = (array)$postinfo_boxes;
?>