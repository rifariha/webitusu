/*
**	Spiffy Calendar utility scripts on front end
**
**  Version 1.0
*/

jQuery(document).ready(function($){
	// Maintain scroll position
	if (sessionStorage.scrollTop != "undefined") {
		$(window).scrollTop(sessionStorage.scrollTop);
		sessionStorage.scrollTop = 0;
	}
});
