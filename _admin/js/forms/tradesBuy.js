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
	getOptionValue = $("#trade_option :selected").text();
	getCommodityFullDetails = $('#commodities_id :selected').val();
	getCommodityDetails = getCommodityFullDetails.split('_');
	getCommodityValue = getCommodityDetails[1];
	getContractSize = getCommodityDetails[2];
	getContractSize = jNum(getContractSize);
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
		$("#trade_invoiced").attr("value",jFormat(getPositionValue * getContractPriceValueClean + getFeesValue, 2));
	} else if (premium == 3){
		getDefaultPrem = getCommodityDetails[5];
		getDefaultPrem = parseFloat(getDefaultPrem);
		$("#trade_premium_price").attr("value", jFormat(getDefaultPrem, -1));
		
		newContractPriceValue = getDefaultPrem * getContractSize;
		$("#trade_price_contract").attr("value", jFormat(newContractPriceValue, 2));
		
		$("#trade_contract_size").attr("value", jFormat(getContractSize, 0));
		
		getDefaultFees = getCommodityDetails[4];
		getDefaultFees = parseFloat(getDefaultFees);
		$("#trade_fees").attr("value", jFormat(getDefaultFees, 2));
		
		$("#trade_value").attr("value",jFormat(getPositionValue * newContractPriceValue, 2));
		$("#trade_invoiced").attr("value",jFormat(getPositionValue * newContractPriceValue	+ getDefaultFees, 2));
	} else if (premium == 4){
		getDefaultPrem = $("#trade_premium_price").val();
		
		newContractPriceValue = getDefaultPrem * getContractSize;
		$("#trade_price_contract").attr("value", jFormat(newContractPriceValue, 2));
		
		$("#trade_contract_size").attr("value", jFormat(getContractSize, 0));
		
		getDefaultFees = getCommodityDetails[4];
		getDefaultFees = parseFloat(getDefaultFees);
		$("#trade_fees").attr("value", jFormat(getDefaultFees, 2));
		
		$("#trade_value").attr("value",jFormat(getPositionValue * newContractPriceValue, 2));
		$("#trade_invoiced").attr("value",jFormat(getPositionValue * newContractPriceValue	+ getDefaultFees, 2));
	} else {
		$("#trade_premium_price").attr("value", jFormat(getContractPriceValueClean / getContractSize, -1));
		$("#trade_contract_size").attr("value", jFormat(getContractSize, 0));
		$("#trade_fees").attr("value", jFormat(getFeesValue, 2));
		$("#trade_value").attr("value",jFormat(getPositionValue * getContractPriceValueClean, 2));
		$("#trade_invoiced").attr("value",jFormat(getPositionValue * getContractPriceValueClean	+ getFeesValue, 2));
	}
	$("#trade_details").attr("value","BUY " + getPositionValue + "x " + getOptionValue + " "+ getCommodityValue + getExpDateValue + "@"	+ getContractPriceValue + " SP: $" + StrikePrice);
}