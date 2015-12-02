jQuery(document).ready(function($) {

	$("#MainForms").validate( {

		rules : {

			tr_value : {

				required : true,

				number : true,

				min : 1,

				remote: "includes/validateBalance.php"

			},

			tr_total : {

				min : 1

			}

		},

		messages : {

			tr_value : {

				required : "Please enter a value!",

				number : "Only numbers are accepted",

				min: "Withdraw can't be negative or null value!",

				remote: "Sorry, not enough funds!"

			},

			tr_total : {

				min: "Withdraw can't be negative or null value!"

			}

		}

	});

});



function setDetails() {

	// console.log(1);
	getDepositnValue = $("#tr_value").val();

	getDepositnValue = parseFloat(jNum(getDepositnValue));

	getDepositFeeValue = $("#tr_fees").val();

	getDepositFeeValue = parseFloat(jNum(getDepositFeeValue));

	$("#tr_total").attr("value", (getDepositnValue + getDepositFeeValue));



};