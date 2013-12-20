$( document ).ready(function() {

	$(".slot").click(
	    function() {
	    	var $this = $(this);
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