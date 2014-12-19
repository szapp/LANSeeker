// Custom functions
function log($args) {
	$.ajax({
		url: "af/logHelper.php",
		type: "POST",
		data: {args: $args}
	});
};

// Document functions
$(document).ready(function() {

	$(function() {
		$("#tooltip").val("");
		$(".slot").animate({opacity:1},"fast");
		// Scrollpane
		var element = $('#box').jScrollPane({
			animateScroll: true,
			animateDuration: 2,
			showArrows: true,
			arrowScrollOnHover: true,
			autoReinitialise: true,
			arrowButtonSpeed: 5,
			enableKeyboardNavigation: true
		});
		var api = element.data('jsp');
		element.bind(
			'mousewheel',
			function (event, delta, deltaX, deltaY) {
				api.scrollByX(-delta*40);
				return false;
			}
		);
		setTimeout(function() {
			api.scrollToPercentX(0.5);
		},500);
	});

	$(".slot").click(
		function() {
			var $this = $(this);
			$("#loading").css("display", "block");
			$(".jspHorizontalBar .jspDrag").css("display", "none");
			$("#footer #info").css("display", "none");
			$("#tooltip").css("display","none");
			$("#help").css("display","inline-block");
			setTimeout(function() {
				$(".jspHorizontalBar .jspDrag").css("display", "block");
				$("#loading").css("display", "none");
				$("#loading p").html("Loading...");
				$("#help").css("display","none");
			},20000);
			$.ajax({
				url: "af/ajaxDistributor.php",
				dataType: 'json',
				success: function(data) {
					if (data["error"]) {
						$("#loading p").html("Ein unerwarteter Fehler ist aufgetreten...<br><span style='font-size: 22px;'>(Bitte gib Bescheid)</span>");
						log([data["client"], "encountered an ERROR: '" + data["error"] + "' while installing '" + $this.find("img").attr("title") + "' from " + data["path"]]);
					} else if ((data["installed"]) && (!data["update"])) {
						log([data["client"], "installs '" + $this.find("img").attr("title") + "' from " + data["path"]]);
						location = data["protocol"] + data["path"] + $this.find("img").attr("data-ref");
					} else {
						if (data["installed"])
							$("#loading p").html("Bitte zuerst das Browser plug-in updaten...<br><span style='font-size: 22px;'>(Aktion nur einmalig nötig)</span>");
						else
							$("#loading p").html("Bitte zuerst das Browser plug-in installieren...<br><span style='font-size: 22px;'>(Aktion nur einmalig nötig)</span>");
						location = data["exec"];
					}
					$("#address").val(data["path"] + $this.find("img").attr("data-ref"));
				}
			});
		}
	);

	$(".slot").hover(
		function() {
			$(this).find(".shade").stop().animate({opacity:0},"fast");
			$(this).find("img").stop().animate({opacity:1},"fast");
			$("#address").css("display","none");
			$("#tooltip").css("display","inline-block");
			$("#tooltip").html($(this).find("img").attr("title"));
			$("#footer #info").css("display", "none");
			$("#help").css("display","none");
		}, function() {
			$(this).find(".shade").stop().animate({opacity:1},"slow");
			$(this).find("img").stop().animate({opacity:0.5},"slow");
			if ($("#loading").css("display") === "none") {
				$("#tooltip").html("");
				$("#footer #info").css("display", "none");
				$("#help").css("display","none");
			}
		}
	);

	$("#address").click(
		function() {
			$(this).select();
		}
	);

	$("#help").click(
		function() {
			$("#footer #info").css("display", "inline-block");
			$(this).css("display","none");
			$("#tooltip").css("display","none");
			$("#address").css("display","inline-block");
			$("#address").select();
		}
	);
});