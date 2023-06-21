$(document).ready(function() {

	$("#student_id").change(function() {
		var student_id = $(this).val();
		if(student_id != "0") {
			$.post("find_student_fee.php", "student_id="+student_id, function(data) {
				$("#student_fee").val(data);
				fees = data;
				
				$.post("find_student_discount.php", "student_id="+student_id, function(data) {
					if(data != "") {
						$("#discount").val(data);
					}
					else {
						$("#discount").val("0");
					}
					// discount calculation
					discount = data;
					var discount_amount = fees * discount / 100;
					$("#discount_amount").val(discount_amount);
					
					$("#payable_fee").val(fees - discount_amount);
					
				});
			});
		}
	});

	$("#quantity").blur(function() {
		var quantity = $("#quantity").val();
		var unitprice = $("#unitprice").val();
		$("#totalprice").val(quantity * unitprice);
	});
	$("#unitprice").blur(function() {
		var quantity = $("#quantity").val();
		var unitprice = $("#unitprice").val();
		$("#totalprice").val(quantity * unitprice);
	});

	// compare new password - confirm
	
	$("form#password").submit(function()  {
			if($("#new").val() != $("#confirm").val()){ 
				$("#confirm").parent().
				after("<div class='alert alert-danger alert-dismissable'>رمز جدید و تکرار آن مشابه نمیباشد, لطفا دوباره کوشش کنید.</div>");
				event.preventDefault();
			}
	});
 
 
	$("a#btn_print").click(function() {
		event.preventDefault();
		window.print();
	});

	$("#mid_exam").blur(function() {
		calculate_score(); 
	});
	$("#final_exam").blur(function() {
		calculate_score();
	});
	$("#second_chance").blur(function() {
		calculate_score();
	});
	
	function calculate_score() {
		var mid_exam = parseInt($("#mid_exam").val());
		var final_exam = parseInt($("#final_exam").val());
		var second_chance = parseInt($("#second_chance").val());
		if(second_chance != "") {
			$("#mid_exam").val("0");
			$("#final_exam").val("0");
			$("#total_mark").val(second_chance);
		}
		else {
			$("#total_mark").val(mid_exam + final_exam);
		}
	}
	

	$("#loan_amount").blur(function() {
		var loan = $(this).val();
		var payable = $("#payable_salary").val();
		var payable = payable - loan;
		$("#payable_salary").val(payable);
		var guarantee = parseFloat($("#guarantee").val());
		var net_salary = Math.round(payable - (payable * guarantee / 100));
		$("#net_salary").val(net_salary);
	});

	$("#talent_score").blur(function() {
		var talent_score = parseInt($(this).val());
		if(talent_score <= 1000 && talent_score >= 0) {
			var talent_bonus = talent_score * 8;
			$("#talent_bonus").val(talent_bonus);
		}
		else {
			alert("نمره کادری باید بین 0 تا 1000 باشد!");
			$("#talent_score").val("");
		}
	});

	$("#bonus").blur(function() {
		var payable = parseInt($("#payable_salary").val());
		var bonus = parseInt($("#bonus").val());
		var after_bonus = payable + bonus;
		$("#payable_salary").val(after_bonus);
		var guarantee = parseFloat($("#guarantee").val());
		var net_salary = Math.round(after_bonus - (after_bonus * guarantee / 100));
		$("#net_salary").val(net_salary);
	});
	
	$("#guarantee").blur(function() {
		var payable = parseInt($("#payable_salary").val());
		var guarantee = parseFloat($("#guarantee").val());
		var net_salary = Math.round(payable - (payable * guarantee / 100));
		$("#net_salary").val(net_salary);
	});

	$("#student_type").change(function() {
		var type = $(this).val();
		if(type == 1) {
			$("#reg_no").show();
		}
		else {
			$("#reg_no").hide();
		}
	});

	

}) ;