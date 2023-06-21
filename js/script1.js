$(document).ready(function() {

	$("a.block").click(function() {
		event.preventDefault();
		var blocked_user = $(this).attr("id");
		var link = $(this);
		$.post("block_user.php", "blocked_user="+blocked_user, function(data) {
			if(data == "ok") {
				$(link).text("Unblock");
				$(link).removeClass("btn-danger");
				$(link).addClass("btn-success");
			}
		});
	});

	
	
	
	$(".txt_comment").hide();

	$(".btn_comment").click(function() {
		event.preventDefault();
		$(this).parent().next().children(".txt_comment").toggle();
		$(this).parent().next().children(".txt_comment").focus();
	});

	var post_id = "";

	$(document).on("click", "#btn_share", function() {
		event.preventDefault();
		var share_text = $("#share_text").val();
		
		$.post("post_share.php", "post_id=" + post_id + "&share_text=" + share_text, function(data) {
			if(data == "ok") {
				$("#mydialog").fadeOut(400, function() {
					alert("Post successfully shared!")
				});
			}
		});
		
	});

	$("a.btn_share").click(function() {
		event.preventDefault();
		post_id = $(this).attr("id");
		var post_photo = $(this).prev(".post_photo").html();
		var post_text = $(this).parent().children(".post_text").html();
		$("#mydialog").children(".modal-dialog").children(".modal-content").children(".modal-body").children("#post_content").html(post_photo + "<div class='clearfix'></div>" + post_text);
	});

	$(document).on("click", "a.less_comment", function() {
		event.preventDefault();		
		$(this).parent().children().hide();
		$(this).parent().children().first().show();
		$(this).text("View More Comment");
		$(this).attr("class", "more_comment");
		$(this).show();
	});

	
	$(document).on("click", "a.more_comment", function() {
		event.preventDefault();
		$(this).parent().children().show();
		$(this).text("View Less Comment");
		$(this).attr("class", "less_comment");
		$(this).show();
	});


	$("div.post_comment div.comment").hide();
	$("div.post_comment div.comment:first-child").show();

	$("input.txt_comment").keypress(function() {
		if(event.keyCode == 13) {
			var comment = $(this).val();
			var textbox = $(this);
			var post_id = $(this).attr("id");
			$.post("comment_add.php", "comment_text="+comment+"&post_id="+post_id, function(data) {
				if(data != "false") {
					var comments = $(textbox).next("div.post_comment").html();
					$(textbox).next("div.post_comment").html(comments + "<p style='padding:5px;'><img class='img-circle' src='" + data + "' width='30' style='float:left;margin-right:10px;'>"+comment+"</p><div class='clearfix'></div>");
					$(textbox).val("");					
				}else {
					// display error
				}
			});
		}
	});

	$(document).on("click", "a.btn_unlike", function() {
		
		event.preventDefault();
		
		var post_id = $(this).attr("id");
		var unlike = $(this);
		
		$.post("post_unlike.php", "post_id="+post_id, function(data) {
			if(data == "true") {
				$(unlike).attr("class", "btn_like");
				$(unlike).html("<span class='glyphicon glyphicon-thumbs-up'></span> Like");
				var total_like = parseInt($("span#" + post_id).text());
				total_like--;
				$("span#" + post_id).text(total_like);
			}
			else {
				alert("There is no Internet connection!");
			}
		});
	});

	$(document).on("click", "a.btn_like", function() {
		
		event.preventDefault();
		
		var post_id = $(this).attr("id");
		var like = $(this);
		
		$.post("post_like.php", "post_id="+post_id, function(data) {
			if(data == "true") {
				$(like).attr("class", "btn_unlike");
				$(like).html("<span class='glyphicon glyphicon-thumbs-up'></span> Unlike");
				var total_like = parseInt($("span#" + post_id).text());
				total_like++;
				$("span#" + post_id).text(total_like);
			}
			else {
				alert("like not done!");
			}
		});
	});

	$("a.request_accept").click(function() {
		event.preventDefault();
		var sender_id = $(this).attr("id");
		
		var accept_link = $(this);
		var reject_link = $(this).next(".request_reject");
		
		$.post("friend_request_accept.php", "sender_id=" + sender_id, function(data) {
			if(data == "ok") {
				$(accept_link).hide();
				$(reject_link).hide();
			}
		});
	});
	
	$("a.request_reject").click(function() {
		event.preventDefault();
		var sender_id = $(this).attr("id");
		
		var reject_link = $(this);
		var accept_link = $(this).prev(".request_accept");
		
		$.post("friend_request_reject.php", "sender_id=" + sender_id, function(data) {
			if(data == "ok") {
				$(accept_link).hide();
				$(reject_link).hide();
			}
		});
	});
	
	$("a.friend_request").click(function() {
		event.preventDefault();
		var link = $(this);
		var receiver_id = $(this).attr("id");
		
		$.post("friend_request_add.php", "user_id="+receiver_id, function(data) {
			if(data == "ok") {
				$(link).text("Friends");
				$(link).removeClass("btn-primary");
				$(link).addClass("btn-default");
			}
		});
		
		
	});
	
	$("a.delete").click(function() {
		var sure = window.confirm("Are you sure to delete this record?");
		if(!sure) {
			event.preventDefault();
		}
	});

	window.setTimeout(function() {
		$(".alert").slideUp(500);
	}, 5000);

	
});