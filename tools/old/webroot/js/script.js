$(document).ready(function(){
	
	/**
	 * Gets the cinema menu item that was clicked ID and attaches it to the date input and calls it
	 */
	$('[id^="show_days_"]').click(function(){
		var cinema_id = $(this).attr("id");
		$('.film_content').empty();
		$('.get_started').hide();
		$('#days_menu').show();
		$('.cinema_date').attr("id",cinema_id);
		get_cinema_info();
	});

	/**
	 * change event that calls the get_cinema_info method
	 */
	$(".cinema_date").change(function() {
		get_cinema_info();
	});
	
	/**
	 * Sets up the date input
	 */
	$('.input-group.date').datepicker({
		format: "yyyy-mm-dd",
		startDate: "today",
		endDate: "+7d",
		startView: 0,
		minViewMode: 0,
		maxViewMode: 0,
		autoclose: true,
		todayHighlight: true,
		toggleActive: true
	});
	
	/**
	 * Shows and hides film information
	 */
	$('[id^="movie_times_"]').click(function(){
		$('.film_content').hide();
		$('.film_content').show();
	});

	/**
	 * gets the cinema ID and date from the date input and calls the ajax method
	 * @return {[type]} [description]
	 */
	function get_cinema_info() {
		var date = $(".cinema_date").val();
		var cinema_id = $(".cinema_date").attr("id");
		cinema_id = cinema_id.split(/_/).pop();
		ajaxCall('film', 'getFilms', cinema_id, date);
	}

	/**
	 * Makes an AJAX call to the specified class and function
	 * @param  {[type]} class_name    [description]
	 * @param  {[type]} function_name [description]
	 * @param  {[type]} id            [description]
	 * @param  {[type]} date          [description]
	 * @return {[type]}               [description]
	 */
	function ajaxCall(class_name, function_name, id, date) {
		$.post({
		  url: location.pathname+'controller/ajaxController.php',
		  data: {'class': class_name, 'function': function_name, 'var1': id, 'var2': date},
		  success: function(data) {
		  	console.log(data);
		  	$('.film_content').html(data);
		  	$('.film_content').show();
		  },
		  error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		  }
		}); // end ajax call
	}
}); 