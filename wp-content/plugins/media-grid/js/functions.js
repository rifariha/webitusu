jQuery(document).ready(function($) {
	
	// colorpicker
	mg_colpick = function () {
		jQuery('.lcwp_colpick input').each(function() {
			var curr_col = jQuery(this).val().replace('#', '');
			jQuery(this).colpick({
				layout:'rgbhex',
				submit:0,
				color: curr_col,
				onChange:function(hsb,hex,rgb, el, fromSetColor) {
					if(!fromSetColor){ 
						jQuery(el).val('#' + hex);
						jQuery(el).parents('.lcwp_colpick').find('.lcwp_colblock').css('background-color','#'+hex);
					}
				}
			}).keyup(function(){
				jQuery(this).colpickSetColor(this.value);
				jQuery(this).parents('.lcwp_colpick').find('.lcwp_colblock').css('background-color', this.value);
			});  
		});
	}
	mg_colpick();
	
	
	// sliders
	mg_slider_opt = function() {
		var a = 0; 
		jQuery('.lcwp_slider').each(function(idx, elm) {
			var sid = 'slider'+a;
			jQuery(this).attr('id', sid);	
		
			var svalue = parseInt(jQuery("#"+sid).next('input').val());
			var minv = parseInt(jQuery("#"+sid).attr('min'));
			var maxv = parseInt(jQuery("#"+sid).attr('max'));
			var stepv = parseInt(jQuery("#"+sid).attr('step'));
			
			jQuery('#' + sid).slider({
				range: "min",
				value: svalue,
				min: minv,
				max: maxv,
				step: stepv,
				slide: function(event, ui) {
					jQuery('#' + sid).next().val(ui.value);
				}
			});
			
			// workaround to keep user-specified value (specially if empty)
			jQuery('#'+sid).next('input').on('keyup', function() {
				var val = jQuery(this).val();
				if(!jQuery.isNumeric(val) ) {val = ''}
				
				jQuery(this).attr('user_val', val);
			});
			
			// what if slider forces a value but user wants another one?
			jQuery('#'+sid).next('input').change(function() {
				var $subj = jQuery(this);
				var val = parseInt($subj.val());
				
				var minv = parseInt(jQuery("#"+sid).attr('min'));
				var maxv = parseInt(jQuery("#"+sid).attr('max'));
				
				if($subj.attr('user_val') != 'undefined') {
					setTimeout(function() {
						var user_val = $subj.attr('user_val');
						
						if(user_val === '') {
							jQuery('#'+sid).slider("value", minv);		
						} else {
							jQuery('#'+sid).slider("value", user_val);		
						}
						 
						$subj.val(user_val);
						$subj.removeAttr('user_val'); 
					}, 1);	
				}
			});
			
			// if no value specified - set slider to have min value
			if(jQuery("#"+sid).next('input').val() === '') {
				jQuery('#'+sid).slider("value", minv);	
			}
			
			a = a + 1;
		});
	}
	mg_slider_opt();
	
	
	// custom checks
	mg_live_checks = function() {
		jQuery('.ip-checkbox').lc_switch('YES', 'NO');
	}
	mg_live_checks();
	
	
	// chosen
	mg_live_chosen = function() {
		jQuery('.lcweb-chosen').each(function() {
			var w = jQuery(this).css('width');
			jQuery(this).chosen({width: w}); 
		});
		jQuery(".lcweb-chosen-deselect").chosen({allow_single_deselect:true});
	}
	mg_live_chosen();
	
	
});