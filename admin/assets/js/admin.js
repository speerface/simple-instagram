(function ( $ ) {
	"use strict";

	$(function () {

		$('.section_title').click(function(){
		  
		  $(this).siblings('.section_content').toggleClass('active');
		});
		
		
		var clip = new ZeroClipboard( document.getElementById('d_clip_button') );
		
	});

}(jQuery));