jQuery.fn.filterByText = function(textbox, selectSingleMatch) {
	return this.each(function() {
		var select = this;
		var options = [];
		$(select).find('option').each(function() {
			options.push({value: $(this).val(), text: $(this).text()});
		});
		$(select).data('options', options);
		$(textbox).bind('change keyup', function() {
			var options = $(select).empty().scrollTop(0).data('options');
			var search = $.trim($(this).val());
			var regex = new RegExp(search,'gi');

			$.each(options, function(i) {
				var option = options[i];
				if(option.text.match(regex) !== null) {
					$(select).append(
						$('<option>').text(option.text).val(option.value)
					);
				}
			});
			if (selectSingleMatch === true &&
				$(select).children().length === 1) {
				$(select).children().get(0).selected = true;
			}
		});
	});
};

$(function() {
	$('#ph_relatedposts_right option').each(function(i){
		$(this).prop('selected', true)
	});

	$('#ph_relatedposts_left').filterByText($('#related_posts_filter'), true);
	$('#ph_relatedposts_move_to_right').click(function(){
		return !$('#ph_relatedposts_left option:selected').remove().appendTo('#ph_relatedposts_right');
	})
	$('#move_to_left').click(function(){
		return !$('#ph_relatedposts_right option:selected').remove().appendTo('#ph_relatedposts_left');
	});
	$('#ph_relatedposts_left option').on('dblclick', function(){
		$(this).remove().appendTo('#ph_relatedposts_right');
	});
	$('#ph_relatedposts_right option').on('dblclick', function(){
		$(this).remove().appendTo('#ph_relatedposts_left');
	});
	$('#form').on('submit', function()
	{

		$('#ph_relatedposts_right option').each(function(i){
			$(this).prop('selected', true)
		});
	});


});