// Main JS

$(document).ready(function() {
	var login_error = $.trim($('.login_error').text());

	if (login_error != "") {
		$('.login_error').css('display', 'block');
	} else {
		$('.login_error').css('display', 'none');
	}
});
