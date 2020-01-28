function message(msg){
	var msg = msg.split(',');
	var result = $.confirm({
		'title'		: msg[0],
		'message'	: msg[1],
		'buttons'	: {
			'Close'	: {
				'class'	: 'close',
				'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
			}
		}
	});
	if(!result)		
	return false;
}
$(document).ready(function() {
	
	$('.confirdel').click(function(evt){
		var action = $(this).attr('href');
		var result = $.confirm({
			'title'		: '<div class="delete msg">Delete Confirmation</div>',
			'message'	: 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
			'buttons'	: {
				'Yes'	: {
					'class'	: 'blue',
					'action': function(){
						window.location = action;
					}
				},
				'No'	: {
					'class'	: 'gray',
					'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});
		if(!result)		
		return false;
	});
	
	$(".logintab").click(function () {
		$('.emailformError').remove();
		$('#email').val('');
		$('.forgotBox').slideUp('normal', function() {
			$('.loginBox').slideDown(function() {
			});
		});
	});
	
	$(".forgottab").click(function () {
		$('.usernameformError').remove();
		$('.passwordformError').remove();
		$('#username').val('');
		$('#password').val('');
		$('.loginBox').slideUp('normal', function() { 
			$('.forgotBox').slideDown(function() {
			});
		});
	});	
	
	$('#savebtn').click(function(){
		var menus = new Array();
		$(".savetxt").each(function() {
			 menus.push($(this).val());
		});
		var results = new Array();
          
          for (var j=0; j<menus.length; j++) {
              var key = menus[j].toString(); // make it an associative array
              if (!results[key]) {
                  results[key] = 1
              } else {
                  //results[key] = results[key] + 1;
				  message('<div class="error1 msg1">Invalid menu position</div>,Something wrong you are enter in the order of menu position. So please correct and then save menu order.');
					return false;
              }
          }
          
          /*var str = ""; // Display the results
          for (var j in results) {
               str += "\t" + j + ": " + "\t" + results[j] + "\n"
          }
          alert(str);*/
	});
});