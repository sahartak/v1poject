$.metadata.setType("attr", "validate");
jQuery(document).ready(
	function($) {
		$("#MainForms").validate( {
			rules : {
				user_account_nusm : {
					required : true
				}
			},
			messages : {
				user_account_nusm : {
					required : "Please select a user account!"
				}
			}
		});
});

function setDetails(premium) {
	getPositionValue = $("#sliderVal").val();
	getOptionValue = $("#trade_option").text();
	getContractSize = $("#trade_contract_size").val();
	getContractSize = jNum(getContractSize);
	getCommodityValue = $("#commodities_id").val();
	getCommodityValue = getCommodityValue.split(" ");
	getCommodityValue = getCommodityValue[0];
	getContractPriceValue = $("#trade_price_contract").val();
	getContractPriceValueClean = jNum(getContractPriceValue);
	getExpDateValue = $('#trade_expiry_date :selected').text();
	getExpDateValue = getExpDateValue.split(" ");
	getExpDateValue = getExpDateValue[0];
	getFeesValue = $("#trade_fees").val();
	getFeesValue = parseFloat(getFeesValue);
	if (isNaN(getFeesValue)) getFeesValue = 0;
	StrikePrice = $("#trade_strikeprice").val();
	if (premium == 1) {
		getPremiumValue = $("#trade_premium_price").val();
		getPremiumValue = parseFloat(getPremiumValue);
		if (isNaN(getPremiumValue)) {
			getPremiumValue = 0;
			$("#trade_premium_price").attr("value", 0);
		}
		$("#trade_price_contract").attr("value",jFormat(getPremiumValue * getContractSize, 2));
		$("#trade_contract_size").attr("value", jFormat(getContractSize, 0));
		$("#trade_fees").attr("value", jFormat(getFeesValue, 2));
		getContractPriceValue = $("#trade_price_contract").val();
		getContractPriceValueClean = jNum(getContractPriceValue);
		$("#trade_value").attr("value",jFormat(getPositionValue * getContractPriceValueClean, 2));
		$("#trade_invoiced").attr("value",jFormat(getPositionValue * getContractPriceValueClean - parseFloat(getFeesValue), 2));
	} else {
		$("#trade_premium_price").attr("value", jFormat(getContractPriceValueClean / getContractSize, 4));
		$("#trade_contract_size").attr("value", jFormat(getContractSize, 0));
		$("#trade_fees").attr("value", jFormat(getFeesValue, 2));
		$("#trade_value").attr("value",jFormat(getPositionValue * getContractPriceValueClean, 2));
		$("#trade_invoiced").attr("value",jFormat(getPositionValue * getContractPriceValueClean	- parseFloat(getFeesValue), 2));
	}
	$("#trade_details").attr("value","SELL " + getPositionValue + "x " + getOptionValue + " "+ getCommodityValue + getExpDateValue + "@"	+ getContractPriceValue + " SP: $" + StrikePrice);
}