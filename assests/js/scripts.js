$(document).ready(function(){
	
	$(window).resize(function(){
		console.log(window.innerWidth);
	});
	
	$('header nav .show_menu').click(function(){
		$('header nav ul').slideToggle(500);
	});
});