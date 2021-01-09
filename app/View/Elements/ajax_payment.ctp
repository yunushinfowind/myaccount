<script>
    $(document).ready(function() {
	$('.applyBtn').on('click', function() {
	    coupon_code = $('.coupon').val();
	    quantity = $('.quantity').val();
	    duration = $('.duration').val();
	    subject = $('.subject').val();
	    package_price = $('.pack').val();
	    if (coupon_code == "") {
		$('.subject').val('');
		$('.duration').val('');
		$('.pack').val('');
		$(".quantity").val('');
		$('.totalAmount').html('');
		$('.DiscountValue').html('');
		$('.AfterDiscountAmount').html('');
		alert('Enter Coupon Code.');
	    }
	    else {
		$.ajax({
		    type: "POST",
		    dataType: 'json',
		    url: '<?php echo BASE_URL . 'student/ajax_payment'; ?>',
		    data: {'coupon_code': coupon_code, quantity: quantity, subject: subject, package_price: package_price, duration: duration},
		    success: function(data) {
			if (data.status == 'noMatch') {
			    alert('Coupon you entered is expired.');
			} else if (data.status == 'notFound') {
			    alert('Coupon you entered does not exist.');
			     $('.totalAmount').text('');
			    $('.DiscountValue').text('');
			    $('.AfterDiscountAmount').text('');
			    $("#youpay").val('');
			} else {
			    var coupon_id = data.coupon_id;
			    var total = data.total;
			    var discount = data.discount;
			    var discounted_amount = data.discounted_amount;
			    $('#coupon_id').val(coupon_id);
			    $('.totalAmount').text('$' + total);
			    $('.DiscountValue').text('$' + discount);
			    $('.AfterDiscountAmount').text('$' + discounted_amount);
			    $("#youpay").val(discounted_amount);
			}
		    }
		});
	    }

	});

	$('.subject').on('change', function() {
	    var student_id = $('#student_id').val();
	    var subject = $(this).val();
	    $.ajax({
		type: 'post',
		url: '<?php echo BASE_URL . 'student/get_subject_pack'; ?>',
		data: {student_id: student_id, subject: subject},
		success: function(data) {
		    $('#Show_pack').html(data);
		}
	    });
	});

	$('.pack').on('change', function() {
	    var subject = $('.subject').val();
	    var pack = $(this).val();
	    var quantity = '1';
	    $('.quantity').val(quantity);
	    if (quantity >= 1) {
		make_a_payment(subject, pack, quantity);
	    } else {
		$('.quantity').val('1');
	    }
	});

	$('#quanAdded').on('keyup', function() {
	    var subject = $('.subject').val();
	    var pack = $('.pack').val();
	    var quantity = $('.quantity').val();
	    if (quantity >= 1) {
		make_a_payment(subject, pack, quantity);
	    } else if (quantity == '0') {
		$('.quantity').val('1');
		var quantity = $('.quantity').val();
		make_a_payment(subject, pack, quantity);
	    } else if (quantity == '') {
		$('.totalAmount').html('');
		$('.DiscountValue').html('');
		$('.AfterDiscountAmount').html('');
	    }
	});
	$('.cancel_btn').on('click', function() {
	    $('.totalAmount').html('');
	    $('.DiscountValue').html('');
	    $('.AfterDiscountAmount').html('');
	});
    });
</script>
<script>
    function make_a_payment(subject, pack, quantity) {
	$.ajax({
	    type: "POST",
	    dataType: 'json',
	    url: '<?php echo BASE_URL . 'student/ajax_get_price'; ?>',
	    data: {'subject': subject, 'pack': pack, 'quantity': quantity},
	    success: function(data) {
		var pck = '';
		var total = data.total;
		var discount = data.discount;
		var discounted_amount = data.discounted_amount;
		var duration = data.duration;
		$('.duration').val(duration);
		var time = duration.split(' ');
		var pack = data.pack;
		if (pack == 'Single Pack') {
		    pck = 1;
		}
		else if (pack == 'Double Pack') {
		    pck = 2;
		} else if (pack == '4 Pack') {
		    pck = 4;
		}
		else if (pack == '8 Pack') {
		    pck = 8;
		}
		var total_minutes = time[0] * pck;
		$('.totalAmount').html('$' + total);
		$('.DiscountValue').html('$' + discount);
		$('.AfterDiscountAmount').html('$' + discounted_amount);
		$("#youpay").val(discounted_amount);
		$("#total_time").val(total_minutes);
	    }
	});
    }
</script>

