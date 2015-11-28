$(document).ready(function() {
	var user_workout_id;

	// Rep manager
	$('.sets span').on('click', function(){
		var currentSet = $(this);
		var newRep = currentSet.text() - 1;
		
		if (newRep < 0) {
			// Reset to number of reps from input
			newRep = $(currentSet).attr('data-rep');
		}
		
		// Change span value
		currentSet.text(newRep);
		
		// Change input value
		$('#val_' + currentSet.attr('name')).closest('input').val(newRep);
	});
	
	
	// Panel Box - Oopen panel when user clicks weight(class)
	$('.weight').on('click', function(e) {
		var panel_wrapper = $('.panel-box-wrapper'),
			panel_box = $('.panel-box');

		panel_wrapper.show();

		var panel_height = (panel_box.outerHeight() / 2),
			panel_width = (panel_box.outerWidth() / 2);

		panel_box.css({
			'margin': '-' + panel_height + 'px 0 0 -' + panel_width + 'px'
		});

		user_workout_id = $(this).closest('.excercise').attr('data-workout-id');
		
		$.ajax({
			type: 'POST',
			url: '/user/workout/excercise',
			data: {'workout_id' : user_workout_id},
			dataType: 'json',
			error: function() {
				console.log('could not connect.');
			},
			success: function(data) {
				console.log(data);

				if (data.response === 'success') {
					panel_wrapper.find('.excercise-name').html(data.msg.exercise_name);
					panel_wrapper.find('input[name="weight"]').val(data.msg.set_weight);
				} 
				else {
					console.log(data);
				}
			}
		});

		// Close panel when user clicks outside panel
		$('.panel-box-overlay').on('click', function() {
			panel_wrapper.hide();
		});

		// Add or subtract weight
		panel_box.on('click', 'button', function(e) {
			var panel_weight = panel_box.find('input[name="weight"]');

			if ($(this).attr('name') == 'subtract') {
				panel_weight.val((panel_weight.val() - .5));
				console.log('-');
			} 
			else if ($(this).attr('name') == 'add') {
				panel_weight.val((+panel_weight.val() + +.5));	
				console.log('+');
			}

			e.preventDefault();
		});
		
		// Update and close panel when user clicks update weight
		panel_box.on('click', '.update', function(e) {
			var new_weight = panel_box.find('input').val();

			console.log(user_workout_id);
			
			$('#excercise_' + user_workout_id).find('.weight span').html(new_weight);
			$('#excercise_' + user_workout_id).find('.weight-input').val(new_weight);
			
			panel_wrapper.hide();
			
			e.preventDefault();
		});

		e.preventDefault();
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