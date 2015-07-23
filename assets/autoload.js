
$Ready(function() {
	$('.my-ajax-link').click(function() {
		var t = $(this);

		$.ajax({
			url: t.data('url'),
			success: function(e) {
				$('#ajax-response-custom').html(e);
			}
		});

		return false;
	});
});