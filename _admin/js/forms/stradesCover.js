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
	getShareValue = $("#sliderVal").val();
	
	getStockFullDetails = $('#stocks_id').val();
	getStockDetails = getStockFullDetails.split(' ');
	
	var customValue = $('#trade_price_share').val();
    if (customValue != '') {
        getStockValue = customValue;
    } else {
    	getStockValue = $('#stock_price').val();
    }
    
	getStockSymbol = getStockDetails[0];
	getFeesValue = $("#trade_fees").val();
	getFeesValue = parseFloat(getFeesValue);
	if (isNaN(getFeesValue)) getFeesValue = 0;

	
	$("#trade_price_share").attr("value", jFormat(getStockValue, 2));
	$("#trade_fees").attr("value", jFormat(getFeesValue, 2));
	$("#trade_value").attr("value",jFormat(getShareValue * getStockValue, 2));
	$("#trade_invoiced").attr("value",jFormat(getShareValue * getStockValue	+ getFeesValue, 2));

	$("#trade_details").attr("value","COVER " + getShareValue + "x " + getStockSymbol + "@" + getStockValue);
}