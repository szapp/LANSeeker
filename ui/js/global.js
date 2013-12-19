$( document ).ready(function() {

	$('.slot img').click(
	    function(){
	    	var $input = $( this );
			$.ajax({
				url: "af/ajaxDistributor.php?exe=" + $input.attr("data-ref"),
				type: "GET",
				success: function(data) {
					location = data;
	          }
	       });
	    }
	)

});