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
	    	$("#loading").css("display", "block");
	    	$("#footer #info").css("display", "block");
	    	setTimeout(function(){
	    			$("#loading").css("display", "none");
	    		},20000);
			$.ajax({
				url: "af/ajaxDistributor.php",
				dataType: 'json',
				success: function(data) {
					$("#tooltip").val(data["path"] + $this.find("img").attr("data-ref"));
					location = data["protocol"] + data["path"] + $this.find("img").attr("data-ref");
	          }
	       });
	    }
	);

	$(".slot").hover(
	  function() {
	    $(this).find(".shade").stop().animate({opacity:0},"fast");
		$(this).find("img").stop().animate({opacity:1},"fast");
		$("#tooltip").val($(this).find("img").attr("title"));
		$("#footer #info").css("display", "none");
	  },
	  function() {
	    $(this).find(".shade").stop().animate({opacity:1},"slow");
	    $(this).find("img").stop().animate({opacity:0.5},"slow");
	    if ($("#loading").css("display") === "none") {
	    	$("#tooltip").val("");
	    	$("#footer #info").css("display", "none");
	    }
	  });

	$("#tooltip").click(
		function() {
			$("#tooltip").select();
		}
	);
});