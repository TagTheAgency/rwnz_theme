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
		});

		$('.footer li').hover(
			function(){
			$('.footer li').css('opacity','0.2');
			$(this).css('opacity','1');
		},
			function(){
			$('.footer li').css('opacity','1');
		});

		$('.archive-wrapper h2, .archive').hover(
			function(){
			$('.archive-wrapper h2').css('width','90%');
		},
			function(){
			$('.archive-wrapper h2').css('width','70%');
		});

	});

})(jQuery, this);
