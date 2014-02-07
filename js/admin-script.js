(function($) {
	$(function() {
		$('input[type=checkbox]').each(function(i, el) {
			var id = $(el).attr('id') + '-toggles';
			$(el).before($('<div id="' + id + '" class="toggle-container">').toggles({
				checkbox: $(el),
				on: $(el).is(':checked')
			}));
		});
		$('label').click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			console.log('#' + $(e.target).attr('for'));
			console.log($('#' + $(e.target).attr('for') + '-toggles').click());
		});
	});
})(jQuery);

