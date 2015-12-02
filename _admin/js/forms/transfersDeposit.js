$.metadata.setType("attr", "validate");

jQuery.validator.addMethod("digitsextended", function(value, element) {
    return this.optional(element) || /^[0-9.,]+$/i.test(value);
}, "Only numbers are accepted");

jQuery(document).ready(function($){
    $("#MainForms").validate({
	rules: {
	    user_account_nusm: {
		required: true
	    },
	    tr_value: {
		required: true,
		digitsextended:true
	    },
	    tr_total: {
		min: 0
	    }
	},
	messages: {
	    user_account_nusm: {
		required: "Please select a user account!"
	    },
	    tr_value: {
		required: "Please enter a value!"
	    },
	    tr_total: {
		min: "Deposit can't be negative value!"
	    }
	}
    });
});

function setDetails() {
    getDepositnValue=$("#tr_value").val();
    getDepositnValue=parseFloat(jNum(getDepositnValue));
    getDepositFeeValue=$("#tr_fees").val();
    getDepositFeeValue=parseFloat(jNum(getDepositFeeValue));
    $("#tr_total").attr("value",(getDepositnValue - getDepositFeeValue));
};