jQuery.validator.addMethod("digitsextended", function(value, element) {
    return this.optional(element) || /^[0-9.,]+$/i.test(value);
}, "Only numbers are accepted");

$.metadata.setType("attr", "validate");
jQuery(document).ready(function($) {
	$("#MainForms").validate( {
		rules : {
			user_account_num : {
				required : true
			},
			tr_value : {
				required : true,
				digitsextended:true,
				min : 1
			},
			tr_total : {
				min : 1
			}
		},
		messages : {
			user_account_num : {
				required : "Please select a user account!"
			},
			tr_value : {
				required : "Please enter a value!",
				min : "Withdraw can't be negative or null value!"
			},
			tr_total : {
				min : "Withdraw can't be negative or null value!"
			}
		}
	});
});

function setDetails() {
	getDepositnValue = $("#tr_value").val();
	getDepositnValue = parseFloat(jNum(getDepositnValue));
	getDepositFeeValue = $("#tr_fees").val();
	getDepositFeeValue = parseFloat(jNum(getDepositFeeValue));
	$("#tr_total").attr("value", (getDepositnValue + getDepositFeeValue));
};