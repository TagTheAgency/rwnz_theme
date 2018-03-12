(function ($, root, undefined) {

	$(function () {

		'use strict';

		// DOM ready, take it away

		// Scroll to the top button function
		$('#to-top').click(function(){
			$('html,body').animate({
				scrollTop: 0
			}, 700);
		});

		$('.post-content-wrapper').hover(
			function(){
			$('.post-content-wrapper').addClass('post-hover');
			$(this).removeClass('post-hover');
		},
		function(){
			$('.post-content-wrapper').removeClass('post-hover');
		}
	);

	});

})(jQuery, this);
