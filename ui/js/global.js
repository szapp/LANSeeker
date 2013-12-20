$( document ).ready(function() {

	$(function() {
		$(".slot").animate({opacity:1},"fast");
	});

	$(function() {
		var element = $('#box').jScrollPane(
				{
					animateScroll: true,
					animateDuration: 2,
					showArrows: true,
					arrowScrollOnHover: true,
					autoReinitialise: true,
					arrowButtonSpeed: 5,
					enableKeyboardNavigation: true
				}
			);
		var api = element.data('jsp');
		element.bind(
		     'mousewheel',
		     function (event, delta, deltaX, deltaY)
		     {
		         api.scrollByX(-delta*20);
		         return false;
		     }
		);
	});

	$(".slot").click(
	    function() {
	    	var $this = $(this);
	    	document.getElementById("loading").style.display = "block";
	    	setTimeout(function(){
	    			document.getElementById("loading").style.display = "none";
	    		},15000);
			$.ajax({
				url: "af/ajaxDistributor.php",
				success: function(data) {
					location = data + $this.find("img").attr("data-ref");
	          }
	       });
	    }
	);

	$(".slot").hover(
	  function() {
	    $(this).find(".shade").stop().animate({opacity:0},"fast");
		$(this).find("img").stop().animate({opacity:1},"fast");
	  },
	  function() {
	    $(this).find(".shade").stop().animate({opacity:1},"slow");
	    $(this).find("img").stop().animate({opacity:0.5},"slow");
	  });
});