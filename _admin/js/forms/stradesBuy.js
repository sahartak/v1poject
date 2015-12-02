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
	var getShareValue = $("#sliderVal").val();
	
	var getStockFullDetails = $('#stocks_id :selected').val();
	var getStockDetails = getStockFullDetails.split('_');
	var getStockValue = getStockDetails[1];
	var getStockSymbol = getStockDetails[2];
    
    var customValue = $('#trade_price_share').val();

	var getFeesValue = $("#trade_fees").val();
	var getFeesValue = parseFloat(getFeesValue);
    
	if (isNaN(getFeesValue)){
        getFeesValue = 0;
    }
    
    if ((premium == 1 || premium == 0) && customValue != '') {
        getStockValue = customValue;
    }
	
	$("#trade_price_share").attr("value", jFormat(getStockValue, 2));
	$("#trade_fees").attr("value", jFormat(getFeesValue, 2));
	$("#trade_value").attr("value",jFormat(getShareValue * getStockValue, 2));
	$("#trade_invoiced").attr("value",jFormat(getShareValue * getStockValue	+ getFeesValue, 2));

	$("#trade_details").attr("value","BUY " + getShareValue + "x " + getStockSymbol + "@" + getStockValue);
}