jQuery(function($){
	$('#themename').keyup(function(e){
		id = $('#themename').val().toLowerCase().replace( /\s/g, '' );
		$('#themeid').val( id );
	});
	$('#form').submit(function(){
		var errors = false;
		$('.required', this).each(function(){
			if( $(this).val() == '' ) {
				errors = true;
				$(this).parents('.control-group').addClass('error');
			} else {
				$(this).parents('.control-group').removeClass('error');
			}
		});
		if( ! errors === false )
			return false;
	});
});