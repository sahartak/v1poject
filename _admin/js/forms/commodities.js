jQuery(document).ready(function($){
	$("#MainForms").validate({
		rules: {
			commodities_name: {
				required: true
			},
			commodities_symbol: {
				required: true,
				remote: "includes/validateCommoditySymbol.php"
			},
			commodities_contract_size: {
				required: true
			},
			commodities_unit: {
				required: true
			},
			commodities_order_priority: {
				number: true,
				rangelength: [1,10],
				required: true
			}
		},
		messages: {
			commodities_name: {
				required: "Please provide a name"
			},
			commodities_symbol: {
				required: "Please enter commodity symbol",
				remote: jQuery.format("Symbol {0} is already in use")
			},
			commodities_contract_size: {
				required: "Please enter contract size"
			},
			commodities_unit: {
				required: "Please enter unit value"
			},
			commodities_order_priority: {
				number: "Only numbers allowed",
				rangelength: "Order number should be between 1 and 10 numbers",
				required: "Please enter order number"
			}
		}
	});
});