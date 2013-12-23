$( document ).ready(function() {

	$(function() {
		$("#tooltip").val("");
		$(".slot").animate({opacity:1},"fast");
		// Scrollpane
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
	    	$(".jspHorizontalBar .jspDrag").css("display", "none");
	    	$("#footer #info").css("display", "none");
	    	$("#tooltip").css("display","none");
	    	$("#help").css("display","inline-block");
	    	setTimeout(function(){
	    			$(".jspHorizontalBar .jspDrag").css("display", "block");
	    			$("#loading").css("display", "none");
	    			$("#loading p").html("Loading...");
	    		},20000);
			$.ajax({
				url: "af/ajaxDistributor.php",
				dataType: 'json',
				success: function(data) {
					if (data["installed"]) 
						location = data["protocol"] + data["path"] + $this.find("img").attr("data-ref");
					else
						$("#loading p").html("Bitte zuerst den Setup Launcher installieren...<br><span style='font-size: 22px;'>(Aktion nur einmalig nötig)</span>");
					$("#tooltip").val(data["path"] + $this.find("img").attr("data-ref"));
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
		$("#help").css("display","none");
		$("#tooltip").blur();
		$("#tooltip").css("display","inline-block");
	  },
	  function() {
	    $(this).find(".shade").stop().animate({opacity:1},"slow");
	    $(this).find("img").stop().animate({opacity:0.5},"slow");
	    if ($("#loading").css("display") === "none") {
	    	$("#tooltip").val("");
	    	$("#footer #info").css("display", "none");
	    	$("#help").css("display","none");
	    }
	  });

	$("#tooltip").click(
		function() {
			$("#tooltip").select();
		}
	);

	$("#help").click(
		function() {
			$("#footer #info").css("display", "inline-block");
			$(this).css("display","none");
			$("#tooltip").css("display","inline-block");
			$("#tooltip").select();
		}
	);
});