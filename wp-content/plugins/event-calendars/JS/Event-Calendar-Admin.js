// Admin Menu
function Total_Soft_Cal_Ev_AMD2_But1(Ev_Cal_ID)
{
	jQuery('.Total_Soft_Cal_Ev_AMD2').hide(500);
	jQuery('.Total_Soft_Cal_Ev_AMMTable').hide(500);
	jQuery('.Total_Soft_Cal_Ev_AMOTable').hide(500);
	jQuery('.Total_Soft_Cal_Ev_Save').show(500);
	jQuery('.Total_Soft_Cal_Ev_Update').hide(500);
	jQuery('.Total_Soft_Cal_Ev_Col').alphaColorPicker();
	jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
	jQuery('.Total_Soft_Cal_Ev_ID').html('[Event_Calendar_TS id="'+Ev_Cal_ID+'"]');
	jQuery('.Total_Soft_Cal_Ev_TID').html('&lt;?php echo do_shortcode(&#039;[Event_Calendar_TS id="'+Ev_Cal_ID+'"]&#039;);?&gt');
	Total_Soft_Cal_Ev_Editor();
	setTimeout(function(){
		jQuery('.Total_Soft_Cal_Ev_AMD3').show(500);
		jQuery('.Total_Soft_Cal_Ev_MTable').show(500);
		jQuery('.Total_Soft_Cal_Ev_MTable1').show(500);
		jQuery('.Total_Soft_Cal_Ev_MTable2').show(500);
		jQuery('.Total_Soft_Cal_Ev_AMShortTable').show(500);
	},500)
}
function TotalSoft_Cal_Ev_Reload()
{
	location.reload();
}
function TotalSoftCal_Ev_Copy(Ev_Cal_ID)
{
	var ajaxurl = object.ajaxurl;
	var data = {
	action: 'TotalSoftCalEv_Copy', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
	foobar: Ev_Cal_ID, // translates into $_POST['foobar'] in PHP
	};
	jQuery.post(ajaxurl, data, function(response) {
		location.reload();
	})
}
function TotalSoftCal_Ev_Edit(Ev_Cal_ID)
{
	var ajaxurl = object.ajaxurl;
	var data = {
	action: 'TotalSoftCalEv_Edit1', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
	foobar: Ev_Cal_ID, // translates into $_POST['foobar'] in PHP
	};
	jQuery.post(ajaxurl, data, function(response) {
		var b=Array();
		var a=response.split('=>');
		for(var i=3;i<a.length;i++)
		{ b[b.length]=a[i].split('[')[0].trim(); }
		b[b.length-1]=b[b.length-1].split(')')[0].trim();
		
		jQuery('#Total_Soft_Cal_Ev_Name').val(b[0]);
		jQuery('#Total_Soft_Cal_Ev_Theme').val(b[1]);
		jQuery('#Total_Soft_Cal_Ev_ECount').val(b[2]);
		jQuery('#Total_SoftCal_Ev_Update').val(Ev_Cal_ID);
		jQuery('.Total_Soft_Cal_Ev_AMD2').hide(500);
		jQuery('.Total_Soft_Cal_Ev_AMMTable').hide(500);
		jQuery('.Total_Soft_Cal_Ev_AMOTable').hide(500);
		jQuery('.Total_Soft_Cal_Ev_Save').hide(500);
		jQuery('.Total_Soft_Cal_Ev_Update').show(500);
		jQuery('.Total_Soft_Cal_Ev_Col').alphaColorPicker();
		jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
		jQuery('.Total_Soft_Cal_Ev_ID').html('[Event_Calendar_TS id="'+Ev_Cal_ID+'"]');
		jQuery('.Total_Soft_Cal_Ev_TID').html('&lt;?php echo do_shortcode(&#039;[Event_Calendar_TS id="'+Ev_Cal_ID+'"]&#039;);?&gt');
		Total_Soft_Cal_Ev_Editor();
	})

	var ajaxurl = object.ajaxurl;
	var data = {
	action: 'TotalSoftCalEv_Edit2', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
	foobar: Ev_Cal_ID, // translates into $_POST['foobar'] in PHP
	};
	jQuery.post(ajaxurl, data, function(response) {
		var TS_Cal_Ev_Title=Array();
		var TS_Cal_Ev_Color=Array();
		var TS_Cal_Ev_Date=Array();
		var TS_Cal_Ev_Desc=Array();

		var a=response.split('stdClass Object');
		for(i=1;i<a.length;i++)
		{
			var c=a[i].split('=>');
			TS_Cal_Ev_Title[TS_Cal_Ev_Title.length]=c[3].split('[')[0].trim();
			TS_Cal_Ev_Color[TS_Cal_Ev_Color.length]=c[4].split('[')[0].trim();
			TS_Cal_Ev_Date[TS_Cal_Ev_Date.length]=c[5].split('[')[0].trim();
			TS_Cal_Ev_Desc[TS_Cal_Ev_Desc.length]=c[6].split('[')[0].trim();
		}
		for(i=1;i<=TS_Cal_Ev_Title.length;i++)
		{	
			jQuery('.Total_Soft_Cal_Ev_MTable2').append('<tr id=Total_Soft_Cal_Ev_Tr_'+i+'><td>'+i+'</td><td>'+TS_Cal_Ev_Title[i-1]+'</td><td>'+TS_Cal_Ev_Date[i-1]+'</td><td onclick="TS_Cal_Ev_Copy_Ev('+i+')"><i class="Total_SoftEv_Cal_Copy totalsoft totalsoft-file-text"></i></td><td onclick="TS_Cal_Ev_Edit_Ev('+i+')"><i class="Total_SoftEv_Cal_Edit totalsoft totalsoft-pencil"></i></td><td><i class="Total_SoftEv_Cal_Del totalsoft totalsoft-trash" onclick="TS_Cal_Ev_Del_Ev('+i+')"></i><input type="text" style="display:none;" class="TS_Cal_Ev_Title" id="TS_Cal_Ev_Title_'+i+'" name="TS_Cal_Ev_Title_'+i+'" value="'+TS_Cal_Ev_Title[i-1]+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Color" id="TS_Cal_Ev_Color_'+i+'" name="TS_Cal_Ev_Color_'+i+'" value="'+TS_Cal_Ev_Color[i-1]+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Date" id="TS_Cal_Ev_Date_'+i+'" name="TS_Cal_Ev_Date_'+i+'" value="'+TS_Cal_Ev_Date[i-1]+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Desc" id="TS_Cal_Ev_Desc_'+i+'" name="TS_Cal_Ev_Desc_'+i+'" value=""/><span class="TS_Cal_Ev_Del_Div"><i class="Total_SoftEv_Cal_Del_Yes totalsoft totalsoft-check" onclick="TS_Cal_Ev_Del_Ev_Yes('+i+')"></i><i class="Total_SoftEv_Cal_Del_No totalsoft totalsoft-times" onclick="TS_Cal_Ev_Del_Ev_No('+i+')"></i></span></td></tr>');	
			jQuery('#TS_Cal_Ev_Desc_'+i).val(TS_Cal_Ev_Desc[i-1]);
		}
	})

	setTimeout(function(){
		jQuery('.Total_Soft_Cal_Ev_AMD3').show(500);
		jQuery('.Total_Soft_Cal_Ev_MTable').show(500);
		jQuery('.Total_Soft_Cal_Ev_MTable1').show(500);
		jQuery('.Total_Soft_Cal_Ev_MTable2').show(500);
		jQuery('.Total_Soft_Cal_Ev_AMShortTable').show(500);
	},500)
}
function TotalSoftCal_Ev_Del(Ev_Cal_ID)
{
	var ajaxurl = object.ajaxurl;
	var data = {
	action: 'TotalSoftCalEv_Del', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
	foobar: Ev_Cal_ID, // translates into $_POST['foobar'] in PHP
	};
	jQuery.post(ajaxurl, data, function(response) {
		location.reload();
	})
}
function Total_Soft_Cal_Ev_Editor()
{
	tinymce.init({
		selector: '#Total_Soft_Cal_Ev_EDesc',
		menubar: false,
		statusbar: false,
		height: 250,
		plugins: [
		    'advlist autolink lists link image charmap print preview hr',
		    'searchreplace wordcount code media ',
		    'insertdatetime save table contextmenu directionality',
		    'paste textcolor colorpicker textpattern imagetools codesample'
		],
		toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect",
		toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink image code | insertdatetime preview | forecolor backcolor",
		toolbar3: "table | hr | subscript superscript | charmap | print | codesample ",
		fontsize_formats: '8px 10px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 42px 44px 46px 48px',
		font_formats: 'Abadi MT Condensed Light = abadi mt condensed light; Aharoni = aharoni; Aldhabi = aldhabi; Andalus = andalus; Angsana New = angsana new; AngsanaUPC = angsanaupc; Aparajita = aparajita; Arabic Typesetting = arabic typesetting; Arial = arial; Arial Black = arial black; Batang = batang; BatangChe = batangche; Browallia New = browallia new; BrowalliaUPC = browalliaupc; Calibri = calibri; Calibri Light = calibri light; Calisto MT = calisto mt; Cambria = cambria; Candara = candara; Century Gothic = century gothic; Comic Sans MS = comic sans ms; Consolas = consolas; Constantia = constantia; Copperplate Gothic = copperplate gothic; Copperplate Gothic Light = copperplate gothic light; Corbel = corbel; Cordia New = cordia new; CordiaUPC = cordiaupc; Courier New = courier new; DaunPenh = daunpenh; David = david; DFKai-SB = dfkai-sb; DilleniaUPC = dilleniaupc; DokChampa = dokchampa; Dotum = dotum; DotumChe = dotumche; Ebrima = ebrima; Estrangelo Edessa = estrangelo edessa; EucrosiaUPC = eucrosiaupc; Euphemia = euphemia; FangSong = fangsong; Franklin Gothic Medium = franklin gothic medium; FrankRuehl = frankruehl; FreesiaUPC = freesiaupc; Gabriola = gabriola; Gadugi = gadugi; Gautami = gautami; Georgia = georgia; Gisha = gisha; Gulim  = gulim; GulimChe = gulimche; Gungsuh = gungsuh; GungsuhChe = gungsuhche; Impact = impact; IrisUPC = irisupc; Iskoola Pota = iskoola pota; JasmineUPC = jasmineupc; KaiTi = kaiti; Kalinga = kalinga; Kartika = kartika; Khmer UI = khmer ui; KodchiangUPC = kodchiangupc; Kokila = kokila; Lao UI = lao ui; Latha = latha; Leelawadee = leelawadee; Levenim MT = levenim mt; LilyUPC = lilyupc; Lucida Console = lucida console; Lucida Handwriting Italic = lucida handwriting italic; Lucida Sans Unicode = lucida sans unicode; Malgun Gothic = malgun gothic; Mangal = mangal; Manny ITC = manny itc; Marlett = marlett; Meiryo = meiryo; Meiryo UI = meiryo ui; Microsoft Himalaya = microsoft himalaya; Microsoft JhengHei = microsoft jhenghei; Microsoft JhengHei UI = microsoft jhenghei ui; Microsoft New Tai Lue = microsoft new tai lue; Microsoft PhagsPa = microsoft phagspa; Microsoft Sans Serif = microsoft sans serif; Microsoft Tai Le = microsoft tai le; Microsoft Uighur = microsoft uighur; Microsoft YaHei = microsoft yahei; Microsoft YaHei UI = microsoft yahei ui; Microsoft Yi Baiti = microsoft yi baiti; MingLiU_HKSCS = mingliu_hkscs; MingLiU_HKSCS-ExtB = mingliu_hkscs-extb; Miriam = miriam; Mongolian Baiti = mongolian baiti; MoolBoran = moolboran; MS UI Gothic = ms ui gothic; MV Boli = mv boli; Myanmar Text = myanmar text; Narkisim = narkisim; Nirmala UI = nirmala ui; News Gothic MT = news gothic mt; NSimSun = nsimsun; Nyala = nyala; Palatino Linotype = palatino linotype; Plantagenet Cherokee = plantagenet cherokee; Raavi = raavi; Rod = rod; Sakkal Majalla = sakkal majalla; Segoe Print = segoe print; Segoe Script = segoe script; Segoe UI Symbol = segoe ui symbol; Shonar Bangla = shonar bangla; Shruti = shruti; SimHei = simhei; SimKai = simkai; Simplified Arabic = simplified arabic; SimSun = simsun; SimSun-ExtB = simsun-extb; Sylfaen = sylfaen; Tahoma = tahoma; Times New Roman = times new roman; Traditional Arabic = traditional arabic; Trebuchet MS = trebuchet ms; Tunga = tunga; Utsaah = utsaah; Vani = vani; Vijaya = vijaya'
	});
}
function Total_Soft_Cal_Ev_ESaveCl()
{
	var Total_Soft_Cal_Ev_ECount = jQuery('#Total_Soft_Cal_Ev_ECount').val();
	var Total_Soft_Cal_Ev_ETitle = jQuery('#Total_Soft_Cal_Ev_ETitle').val();
	var Total_Soft_Cal_Ev_EColor = jQuery('#Total_Soft_Cal_Ev_EColor').val();
	var Total_Soft_Cal_Ev_EDate = jQuery('#Total_Soft_Cal_Ev_EDate').val();
	var Total_Soft_Cal_Ev_EDesc = tinyMCE.get('Total_Soft_Cal_Ev_EDesc').getContent();

	jQuery('.Total_Soft_Cal_Ev_MTable2').append('<tr id=Total_Soft_Cal_Ev_Tr_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'><td>'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'</td><td>'+Total_Soft_Cal_Ev_ETitle+'</td><td>'+Total_Soft_Cal_Ev_EDate+'</td><td onclick="TS_Cal_Ev_Copy_Ev('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"><i class="Total_SoftEv_Cal_Copy totalsoft totalsoft-file-text"></i></td><td onclick="TS_Cal_Ev_Edit_Ev('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"><i class="Total_SoftEv_Cal_Edit totalsoft totalsoft-pencil"></i></td><td><i class="Total_SoftEv_Cal_Del totalsoft totalsoft-trash" onclick="TS_Cal_Ev_Del_Ev('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"></i><input type="text" style="display:none;" class="TS_Cal_Ev_Title" id="TS_Cal_Ev_Title_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" name="TS_Cal_Ev_Title_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" value="'+Total_Soft_Cal_Ev_ETitle+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Color" id="TS_Cal_Ev_Color_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" name="TS_Cal_Ev_Color_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" value="'+Total_Soft_Cal_Ev_EColor+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Date" id="TS_Cal_Ev_Date_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" name="TS_Cal_Ev_Date_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" value="'+Total_Soft_Cal_Ev_EDate+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Desc" id="TS_Cal_Ev_Desc_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" name="TS_Cal_Ev_Desc_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" value=""/><span class="TS_Cal_Ev_Del_Div"><i class="Total_SoftEv_Cal_Del_Yes totalsoft totalsoft-check" onclick="TS_Cal_Ev_Del_Ev_Yes('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"></i><i class="Total_SoftEv_Cal_Del_No totalsoft totalsoft-times" onclick="TS_Cal_Ev_Del_Ev_No('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"></i></span></td></tr>');	

	jQuery('#TS_Cal_Ev_Desc_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)).val(Total_Soft_Cal_Ev_EDesc);
	jQuery('#Total_Soft_Cal_Ev_ECount').val(parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1));
	Total_Soft_Cal_Ev_ECalcelCl();
}
function Total_Soft_Cal_Ev_EUpdateCl()
{
	var Total_Soft_Cal_Ev_EIndex = jQuery('#Total_Soft_Cal_Ev_EIndex').val();
	var Total_Soft_Cal_Ev_ETitle = jQuery('#Total_Soft_Cal_Ev_ETitle').val();
	var Total_Soft_Cal_Ev_EColor = jQuery('#Total_Soft_Cal_Ev_EColor').val();
	var Total_Soft_Cal_Ev_EDate = jQuery('#Total_Soft_Cal_Ev_EDate').val();
	var Total_Soft_Cal_Ev_EDesc = tinyMCE.get('Total_Soft_Cal_Ev_EDesc').getContent();

	jQuery('#Total_Soft_Cal_Ev_Tr_'+Total_Soft_Cal_Ev_EIndex+' td:nth-child(2)').html(Total_Soft_Cal_Ev_ETitle);
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Total_Soft_Cal_Ev_EIndex+' td:nth-child(3)').html(Total_Soft_Cal_Ev_EDate);
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Total_Soft_Cal_Ev_EIndex).find('.TS_Cal_Ev_Title').val(Total_Soft_Cal_Ev_ETitle);	
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Total_Soft_Cal_Ev_EIndex).find('.TS_Cal_Ev_Color').val(Total_Soft_Cal_Ev_EColor);	
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Total_Soft_Cal_Ev_EIndex).find('.TS_Cal_Ev_Date').val(Total_Soft_Cal_Ev_EDate);	
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Total_Soft_Cal_Ev_EIndex).find('.TS_Cal_Ev_Desc').val(Total_Soft_Cal_Ev_EDesc);	
	Total_Soft_Cal_Ev_ECalcelCl();
}
function Total_Soft_Cal_Ev_ECalcelCl()
{
	jQuery('#Total_Soft_Cal_Ev_ETitle').val('');
	jQuery('#Total_Soft_Cal_Ev_EColor').val('');
	jQuery('#Total_Soft_Cal_Ev_EColor').parent().parent().find('a').css('background-color','');
	jQuery('#Total_Soft_Cal_Ev_EDate').val('');
	tinyMCE.get('Total_Soft_Cal_Ev_EDesc').setContent('');
	jQuery('#Total_Soft_Cal_Ev_EUpdate').hide(500);
	jQuery('#Total_Soft_Cal_Ev_ESave').show(500);
}
function Total_Soft_Cal_Ev_ESort()
{
	jQuery('.Total_Soft_Cal_Ev_MTable2 tbody').sortable({
		update: function( event, ui ){ 
			jQuery(this).find('tr').each(function(i){
				jQuery(this).find('td:nth-child(1)').html((i+1));
				jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Title').attr('id', 'TS_Cal_Ev_Title_'+(i+1));
				jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Title').attr('name', 'TS_Cal_Ev_Title_'+(i+1));
				jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Color').attr('id', 'TS_Cal_Ev_Color_'+(i+1));
				jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Color').attr('name', 'TS_Cal_Ev_Color_'+(i+1));
				jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Date').attr('id', 'TS_Cal_Ev_Date_'+(i+1));
				jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Date').attr('name', 'TS_Cal_Ev_Date_'+(i+1));
				jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Desc').attr('id', 'TS_Cal_Ev_Desc_'+(i+1));
				jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Desc').attr('name', 'TS_Cal_Ev_Desc_'+(i+1));
			});
		}
	})
}
function TS_Cal_Ev_Copy_Ev(Ev_index)
{
	var Total_Soft_Cal_Ev_ECount = jQuery('#Total_Soft_Cal_Ev_ECount').val();
	var Total_Soft_Cal_Ev_ETitle = jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Title').val();	
	var Total_Soft_Cal_Ev_EColor = jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Color').val();	
	var Total_Soft_Cal_Ev_EDate = jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Date').val();	
	var Total_Soft_Cal_Ev_EDesc = jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Desc').val();	
	
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).after('<tr id=Total_Soft_Cal_Ev_Tr_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'><td>'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'</td><td>'+Total_Soft_Cal_Ev_ETitle+'</td><td>'+Total_Soft_Cal_Ev_EDate+'</td><td onclick="TS_Cal_Ev_Copy_Ev('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"><i class="Total_SoftEv_Cal_Copy totalsoft totalsoft-file-text"></i></td><td onclick="TS_Cal_Ev_Edit_Ev('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"><i class="Total_SoftEv_Cal_Edit totalsoft totalsoft-pencil"></i></td><td><i class="Total_SoftEv_Cal_Del totalsoft totalsoft-trash" onclick="TS_Cal_Ev_Del_Ev('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"></i><input type="text" style="display:none;" class="TS_Cal_Ev_Title" id="TS_Cal_Ev_Title_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" name="TS_Cal_Ev_Title_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" value="'+Total_Soft_Cal_Ev_ETitle+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Color" id="TS_Cal_Ev_Color_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" name="TS_Cal_Ev_Color_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" value="'+Total_Soft_Cal_Ev_EColor+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Date" id="TS_Cal_Ev_Date_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" name="TS_Cal_Ev_Date_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" value="'+Total_Soft_Cal_Ev_EDate+'"/><input type="text" style="display:none;" class="TS_Cal_Ev_Desc" id="TS_Cal_Ev_Desc_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" name="TS_Cal_Ev_Desc_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+'" value=""/><span class="TS_Cal_Ev_Del_Div"><i class="Total_SoftEv_Cal_Del_Yes totalsoft totalsoft-check" onclick="TS_Cal_Ev_Del_Ev_Yes('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"></i><i class="Total_SoftEv_Cal_Del_No totalsoft totalsoft-times" onclick="TS_Cal_Ev_Del_Ev_No('+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)+')"></i></span></td></tr>');

	jQuery('#TS_Cal_Ev_Desc_'+parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1)).val(Total_Soft_Cal_Ev_EDesc);
	
	jQuery('.Total_Soft_Cal_Ev_MTable2 tbody').find('tr').each(function(i){
		jQuery(this).find('td:nth-child(1)').html((i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Title').attr('id', 'TS_Cal_Ev_Title_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Title').attr('name', 'TS_Cal_Ev_Title_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Color').attr('id', 'TS_Cal_Ev_Color_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Color').attr('name', 'TS_Cal_Ev_Color_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Date').attr('id', 'TS_Cal_Ev_Date_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Date').attr('name', 'TS_Cal_Ev_Date_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Desc').attr('id', 'TS_Cal_Ev_Desc_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Desc').attr('name', 'TS_Cal_Ev_Desc_'+(i+1));
	});

	jQuery('#Total_Soft_Cal_Ev_ECount').val(parseInt(parseInt(Total_Soft_Cal_Ev_ECount)+1));
}
function TS_Cal_Ev_Edit_Ev(Ev_index)
{
	var Total_Soft_Cal_Ev_ETitle = jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Title').val();	
	var Total_Soft_Cal_Ev_EColor = jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Color').val();	
	var Total_Soft_Cal_Ev_EDate = jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Date').val();	
	var Total_Soft_Cal_Ev_EDesc = jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Desc').val();

	jQuery('#Total_Soft_Cal_Ev_ESave').hide(500);
	jQuery('#Total_Soft_Cal_Ev_EUpdate').show(500);

	jQuery('#Total_Soft_Cal_Ev_EIndex').val(Ev_index);
	jQuery('#Total_Soft_Cal_Ev_ETitle').val(Total_Soft_Cal_Ev_ETitle);
	jQuery('#Total_Soft_Cal_Ev_EColor').val(Total_Soft_Cal_Ev_EColor);
	jQuery('#Total_Soft_Cal_Ev_EColor').parent().parent().find('a').css('background-color',Total_Soft_Cal_Ev_EColor);
	jQuery('#Total_Soft_Cal_Ev_EDate').val(Total_Soft_Cal_Ev_EDate);
	tinyMCE.get('Total_Soft_Cal_Ev_EDesc').setContent(Total_Soft_Cal_Ev_EDesc);
}
function TS_Cal_Ev_Del_Ev(Ev_index)
{
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Del_Div').addClass('TS_Cal_Ev_Del_Div1');
}
function TS_Cal_Ev_Del_Ev_No(Ev_index)
{
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Del_Div').removeClass('TS_Cal_Ev_Del_Div1');
}
function TS_Cal_Ev_Del_Ev_Yes(Ev_index)
{
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).find('.TS_Cal_Ev_Del_Div').removeClass('TS_Cal_Ev_Del_Div1');
	jQuery('#Total_Soft_Cal_Ev_Tr_'+Ev_index).remove();
	jQuery('#Total_Soft_Cal_Ev_ECount').val(parseInt(parseInt(jQuery('#Total_Soft_Cal_Ev_ECount').val())-1));
	jQuery('.Total_Soft_Cal_Ev_MTable2 tbody').find('tr').each(function(i){
		jQuery(this).find('td:nth-child(1)').html((i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Title').attr('id', 'TS_Cal_Ev_Title_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Title').attr('name', 'TS_Cal_Ev_Title_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Color').attr('id', 'TS_Cal_Ev_Color_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Color').attr('name', 'TS_Cal_Ev_Color_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Date').attr('id', 'TS_Cal_Ev_Date_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Date').attr('name', 'TS_Cal_Ev_Date_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Desc').attr('id', 'TS_Cal_Ev_Desc_'+(i+1));
		jQuery(this).find('td:nth-child(6)').find('.TS_Cal_Ev_Desc').attr('name', 'TS_Cal_Ev_Desc_'+(i+1));
	});
}
// Theme Menu
function TotalSoft_Cal_Ev_Out()
{
	jQuery('.TotalSoft_Cal_Ev_Range').each(function(){
		if(jQuery(this).hasClass('TotalSoft_Cal_Ev_Rangeper'))
		{
			jQuery('#'+jQuery(this).attr('id')+'_Output').html(jQuery(this).val()+'%');
		}
		else if(jQuery(this).hasClass('TotalSoft_Cal_Ev_Rangepx'))
		{
			
			jQuery('#'+jQuery(this).attr('id')+'_Output').html(jQuery(this).val()+'px');
		}
		else if(jQuery(this).hasClass('TotalSoft_Cal_Ev_RangeSec'))
		{
			
			jQuery('#'+jQuery(this).attr('id')+'_Output').html(jQuery(this).val()+'s');
		}
		else
		{
			jQuery('#'+jQuery(this).attr('id')+'_Output').html(jQuery(this).val());
		}
	})
}
function Total_Soft_Cal_Ev_AMD2_But2()
{
	jQuery('.Total_Soft_Cal_Ev_AMD2').hide(500);
	jQuery('.Total_Soft_Cal_Ev_TMMTable').hide(500);
	jQuery('.Total_Soft_Cal_Ev_TMOTable').hide(500);
	jQuery('.Total_Soft_Cal_Ev_T_Save').show(500);
	jQuery('.Total_Soft_Cal_Ev_T_Update').hide(500);

	jQuery('.Total_Soft_Cal_Ev_Col').alphaColorPicker();
	jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
	TotalSoft_Cal_Ev_Out();
	setTimeout(function(){
		jQuery('.Total_Soft_Cal_Ev_AMD3').show(500);
		jQuery('.Total_Soft_EC_T_Set_Main').show(500);
		jQuery('.Total_Soft_EC_T_Set_T_1').show(500);
	},500)
}
function TotalSoft_Cal_Ev_T_Reload()
{
	location.reload();
}
function TotalSoftCal_Ev_Copy_Theme(Theme_ID)
{
	var ajaxurl = object.ajaxurl;
	var data = {
	action: 'TotalSoftCalEv_T_Copy', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
	foobar: Theme_ID, // translates into $_POST['foobar'] in PHP
	};
	jQuery.post(ajaxurl, data, function(response) {
		location.reload();
	})
}
function TotalSoftCal_Ev_Edit_Theme(Theme_ID)
{

	jQuery('#Total_SoftCal_Ev_T_Update').val(Theme_ID);
	jQuery('.Total_Soft_Cal_Ev_AMD2').hide(500);
	jQuery('.Total_Soft_Cal_Ev_TMMTable').hide(500);
	jQuery('.Total_Soft_Cal_Ev_TMOTable').hide(500);
	jQuery('.Total_Soft_Cal_Ev_T_Save').hide(500);
	jQuery('.Total_Soft_Cal_Ev_T_Update').show(500);

	var ajaxurl = object.ajaxurl;
	var data = {
	action: 'TotalSoftCalEv_T_Edit1', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
	foobar: Theme_ID, // translates into $_POST['foobar'] in PHP
	};
	jQuery.post(ajaxurl, data, function(response) {
		var b=Array();
		var a=response.split('=>');
		for(var i=4;i<a.length;i++)
		{ b[b.length]=a[i].split('[')[0].trim(); }
		b[b.length-1]=b[b.length-1].split(')')[0].trim();
		if(b[b.length-1].length!=7){ b[b.length-1] = b[b.length-1]+')'; }
		jQuery('#TS_Cal_Ev_TName').val(b[0]); jQuery('#TS_Cal_Ev_TType').val(b[1]); jQuery('#TS_Cal_Ev_T1_MW').val(b[2]); jQuery('#TS_Cal_Ev_T1_WDS').val(b[3]); jQuery('#TS_Cal_Ev_T1_BgC').val(b[4]); jQuery('#TS_Cal_Ev_T1_GrC').val(b[5]); jQuery('#TS_Cal_Ev_T1_BBC').val(b[6]); jQuery('#TS_Cal_Ev_T1_BShShow').val(b[7]); jQuery('#TS_Cal_Ev_T1_BShType').val(b[8]); jQuery('#TS_Cal_Ev_T1_BSh').val(b[9]); jQuery('#TS_Cal_Ev_T1_BShC').val(b[10]); jQuery('#TS_Cal_Ev_T1_H_BgC').val(b[11]); jQuery('#TS_Cal_Ev_T1_H_BTW').val(b[12]); jQuery('#TS_Cal_Ev_T1_H_BTC').val(b[13]); jQuery('#TS_Cal_Ev_T1_H_FF').val(b[14]); jQuery('#TS_Cal_Ev_T1_H_MFS').val(b[15]); jQuery('#TS_Cal_Ev_T1_H_MC').val(b[16]); jQuery('#TS_Cal_Ev_T1_H_YFS').val(b[17]); jQuery('#TS_Cal_Ev_T1_H_YC').val(b[18]); jQuery('#TS_Cal_Ev_T1_H_Format').val(b[19]); jQuery('#TS_Cal_Ev_T1_Arr_Type').val(b[20]); jQuery('#TS_Cal_Ev_T1_Arr_C').val(b[21]); jQuery('#TS_Cal_Ev_T1_Arr_S').val(b[22]); jQuery('#TS_Cal_Ev_T1_Arr_HC').val(b[23]); jQuery('#TS_Cal_Ev_T1_LAH_W').val(b[24]); jQuery('#TS_Cal_Ev_T1_LAH_C').val(b[25]); jQuery('#TS_Cal_Ev_T1_WD_BgC').val(b[26]); jQuery('#TS_Cal_Ev_T1_WD_C').val(b[27]); jQuery('#TS_Cal_Ev_T1_WD_FS').val(b[28]); jQuery('#TS_Cal_Ev_T1_WD_FF').val(b[29]); jQuery('#TS_Cal_Ev_T1_D_BgC').val(b[30]); jQuery('#TS_Cal_Ev_T1_D_C').val(b[31]); jQuery('#TS_Cal_Ev_T1_TD_BgC').val(b[32]); jQuery('#TS_Cal_Ev_T1_TD_C').val(b[33]); jQuery('#TS_Cal_Ev_T1_HD_BgC').val(b[34]); jQuery('#TS_Cal_Ev_T1_HD_C').val(b[35]); jQuery('#TS_Cal_Ev_T1_ED_DShow').val(b[36]); jQuery('#TS_Cal_Ev_T1_ED_C').val(b[37]); jQuery('#TS_Cal_Ev_T1_ED_HC').val(b[38]);
		jQuery('.Total_Soft_Cal_Ev_Col1').alphaColorPicker();
		jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
		TotalSoft_Cal_Ev_Out();	
	})

	var ajaxurl = object.ajaxurl;
	var data = {
	action: 'TotalSoftCalEv_T_Edit2', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
	foobar: Theme_ID, // translates into $_POST['foobar'] in PHP
	};
	jQuery.post(ajaxurl, data, function(response) {
		var b=Array();
		var a=response.split('=>');
		for(var i=4;i<a.length;i++)
		{ b[b.length]=a[i].split('[')[0].trim(); }
		b[b.length-1]=b[b.length-1].split(')')[0].trim();
		// if(b[b.length-1].length!=7){ b[b.length-1] = b[b.length-1]+')'; }
		if(b[27] == ''){b[27] = '400';}
		jQuery('#TS_Cal_Ev_T1_E_MW').val(b[0]); jQuery('#TS_Cal_Ev_T1_E_MH').val(b[1]); jQuery('#TS_Cal_Ev_T1_E_BgT').val(b[2]); jQuery('#TS_Cal_Ev_T1_E_Bg1').val(b[3]); jQuery('#TS_Cal_Ev_T1_E_Bg2').val(b[4]); jQuery('#TS_Cal_Ev_T1_E_BW').val(b[5]); jQuery('#TS_Cal_Ev_T1_E_BC').val(b[6]); jQuery('#TS_Cal_Ev_T1_E_BR').val(b[7]); jQuery('#TS_Cal_Ev_T1_E_D_F').val(b[8]); jQuery('#TS_Cal_Ev_T1_E_D_BgC').val(b[9]); jQuery('#TS_Cal_Ev_T1_E_D_C').val(b[10]); jQuery('#TS_Cal_Ev_T1_E_D_TA').val(b[11]); jQuery('#TS_Cal_Ev_T1_E_D_FS').val(b[12]); jQuery('#TS_Cal_Ev_T1_E_D_FF').val(b[13]); jQuery('#TS_Cal_Ev_T1_E_D_BBW').val(b[14]); jQuery('#TS_Cal_Ev_T1_E_D_BBC').val(b[15]); jQuery('#TS_Cal_Ev_T1_E_T_BgC').val(b[16]); jQuery('#TS_Cal_Ev_T1_E_T_C').val(b[17]); jQuery('#TS_Cal_Ev_T1_E_T_FS').val(b[18]); jQuery('#TS_Cal_Ev_T1_E_T_FF').val(b[19]); jQuery('#TS_Cal_Ev_T1_E_T_TA').val(b[20]); jQuery('#TS_Cal_Ev_T1_E_LAE_W').val(b[21]); jQuery('#TS_Cal_Ev_T1_E_LAE_H').val(b[22]); jQuery('#TS_Cal_Ev_T1_E_LAE_C').val(b[23]); jQuery('#TS_Cal_Ev_T1_E_C').val(b[24]); jQuery('#TS_Cal_Ev_T1_E_HC').val(b[25]); jQuery('#TS_Cal_Ev_T1_ED_HBgC').val(b[26]); jQuery('#TS_Cal_Ev_T1_H').val(b[27]);
		jQuery('.Total_Soft_Cal_Ev_Col2').alphaColorPicker();
		jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
		TotalSoft_Cal_Ev_Out();	
	})

	setTimeout(function(){
		jQuery('.Total_Soft_Cal_Ev_AMD3').show(500);
		jQuery('.Total_Soft_EC_T_Set_Main').show(500);
		jQuery('.Total_Soft_EC_T_Set_T_1').show(500);
	},500)
}
function TotalSoftCal_Ev_Del_Theme(Theme_ID)
{
	var ajaxurl = object.ajaxurl;
	var data = {
	action: 'TotalSoftCalEv_T_Del', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
	foobar: Theme_ID, // translates into $_POST['foobar'] in PHP
	};
	jQuery.post(ajaxurl, data, function(response) {
		location.reload();
	})
}
function TS_Cal_Ev_TType_Changed()
{

}