$(document).ready(function(){
	
	$('[id^="show_days_"]').click(function(){
		$('#days_menu').show();
		$('.get_started').hide();
	});

	$('[id^="movie_times_"]').click(function(){
		$('.film_content').hide();
		$('.film_content').show();
	});
}); 