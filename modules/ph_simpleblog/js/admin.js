$(function() {
	$('.simpleblog-post-type').hide();

	showPostType($('#id_simpleblog_post_type').val());

	function showPostType(id_simpleblog_post_type)
	{
		$('.simpleblog-post-type').hide();
		$('.simpleblog-post-type-' + id_simpleblog_post_type).show();
	}

	function handleAuthorChange()
	{
		var currentAuthor = $('#id_simpleblog_author').val();
		var customAuthor = $('.form-group.post_author');
		if (currentAuthor == 0) {
			customAuthor.show();
		} else {
			customAuthor.hide();
		}
	}

	$(document).on('change', '#id_simpleblog_post_type', function()
	{
		showPostType($(this).val());
	});

	$(document).on('change', '#id_simpleblog_author', handleAuthorChange);
	handleAuthorChange();

	function formatResult(product) {
	    if (!product.image) return product.text;
	    return "<img class='product_image' src='" + product.image + "' style='max-width: 50px; height: auto; vertical-align: middle; margin-right: 10px;' />" + product.text;
	}

	$.fn.select2.defaults.set( "theme", "bootstrap" );
	var productSelector = $('#select_product');
	productSelector.select2(
	{
	    minimumInputLength: 3,
	    width: null,
	    multiple: true,
	    // id: function(obj) {
	    //   return obj.product_name;
	   	// },
	    ajax: {
	        url: 'index.php',
	        dataType: 'json',
	        quietMillis: 100,
	        data: function (params) {
			    var queryParameters = {
			      q: params.term,
			      controller:'AdminSimpleBlogPosts',
				action:'searchProducts',
				token:token,
				ajax:1
			    }
			 
			    return queryParameters;
			  },
	        processResults: function (data) {
			    return {
			      results: data
			    };
			}
	    },
	    templateResult: formatResult,
		templateSelection: formatResult,
		escapeMarkup: function (markup) { return markup; }
	});
});
