$(document).ready(function() {
	var user_workout_id;

	var exercise_name,
		exercise_weight;

	var panel_wrapper = $('.panel-box-wrapper'),
		panel_box = $('.panel-box');

	// Rep manager
	$('.sets span').on('click', function(){
		var currentSet = $(this);
		var newRep = currentSet.text() - 1;
		
		if (newRep < 0) {
			newRep = $(currentSet).attr('data-rep');
		}
		
		currentSet.text(newRep);
		
		$('#val_' + currentSet.attr('name')).closest('input').val(newRep);
	});
	
	// Close panel when user clicks outside panel
	$('.panel-box-overlay').on('click', function() {
		panel_wrapper.hide();
	});

	// Open panel box to adjust weight
	$('.weight').on('click', function(e) {
		adjust_weight = 0;

		panel_wrapper.show();

		var panel_height = (panel_box.outerHeight() / 2),
			panel_width = (panel_box.outerWidth() / 2);

		panel_box.css({
			'margin': '-' + panel_height + 'px 0 0 -' + panel_width + 'px',
		});

		// Get id
		user_workout_id = $(this).closest('.excercise').attr('data-workout-id');
		exercise_name = $('#excercise_' + user_workout_id).find('.excercise-name').html();
		excercise_weight = $('#excercise_' + user_workout_id).find('.weight span').html();
		plates = (excercise_weight/2);
		
		// Populate name and current weight
		panel_wrapper.find('.excercise-name').html(exercise_name);
		panel_wrapper.find('.add-weight').html(plates);
		panel_wrapper.find('input[name="weight"]').val(excercise_weight);

		e.preventDefault();
	});

	// Adjust weight
	panel_box.on('click', 'button', function(e) {
		var panel_weight = panel_box.find('input[name="weight"]');

		if ($(this).attr('name') == 'subtract') {
			panel_weight.val((panel_weight.val() - .5));
		} 
		else if ($(this).attr('name') == 'add') {
			panel_weight.val((+panel_weight.val() + +.5));	
		}

		plates = (panel_weight.val()/2);

		panel_wrapper.find('.add-weight').html(plates);

		e.preventDefault();
	});

	// Update and close panel when user clicks update weight
	panel_box.on('click', '.update', function(e) {
		var new_weight = panel_box.find('input').val();
		
		$('#excercise_' + user_workout_id).find('.weight span').html(new_weight);
		$('#excercise_' + user_workout_id).find('.weight-input').val(new_weight);
		
		panel_wrapper.hide();
		
		e.preventDefault();
	});

	// Delete workout
	$('.delete a').on('click', function(e) {
		e.preventDefault();

		var id = $(this).attr('data-user-workout');

		$.ajax({
			url: '/projects/5x5/dashboard/delete',
			method: 'POST',
			data: {user_workout_id : id},
			dataType: 'json',
			error: function() {
				alert('Could not follow through with ajax call.');
			},
			success: function(data) {
				if (data.response === 'success') {
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});

		return false;
	});
	
	// Responsive menu
	responsiveMenu();
});

function responsiveMenu() 
{
	var drop = $('#drop');
	var menu = $('.userSign ul');
	var menuHeight = menu.height();
	
	$(window).resize(function()
	{
		var width = $(this).innerWidth();
		
		if ((width > 500) && menu.is(':hidden'))
		{
			$('.userSign ul').removeAttr('style');
		}
	});
	
	$(drop).on('click', function(e) 
	{
		e.preventDefault();
		menu.slideToggle(200);
	});
}