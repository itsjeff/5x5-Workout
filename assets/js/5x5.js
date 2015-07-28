$(document).ready(function() {
	// Rep manager
	$('.exercise span').on('click', function(){
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
	
	
	// Panel Box
	$('.weight').on('click', function() {
		var panelBox = $(this).closest('div').find('.panelBox');
		
		if (panelBox.is(':hidden')) {
			$('.panelBox').hide();
			
			panelBox.show();
			
			$('.submit').on('click', function() {
				var newWeight = $(this).parent().find('input').val();
				
				$(this).parent().parent().find('.weight').text(newWeight + ' KGS');
				$(this).parent().parent().find('.currentWeight').val(newWeight);
				
				panelBox.hide();
				
				return false;
			});
		} else {
			panelBox.hide();	
		}
		
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