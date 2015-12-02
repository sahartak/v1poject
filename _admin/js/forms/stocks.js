jQuery.validator.addMethod("nowhitespace", function(value, element) {
    return this.optional(element) || /^\S+$/i.test(value);
}, "No white space please"); 

jQuery.validator.addMethod("lettersnumbersonly", function(value, element) {
    return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Special characters and spaces not allowed");
	
jQuery(document).ready(function($){
    $("#MainForms").validate({
	rules: {
	    symbol: {
		required: true,
		rangelength: [1,5],
		lettersnumbersonly:true,
		remote: "includes/validateStockSymbols.php"
	    },
	    names: {
		required: true
	    }, 
		value: { 
		required: true
		}
	},
	messages: {
	    symbol: {
		required: "Please enter a stock symbol",
		remote: jQuery.format("Symbol {0} is already in use")
	    },
	    names: {
		required: "Please provide a name"
	    }, 
		value: {
		required: "Please, enter today's share value"
		}
	}
    });
});
function setDetails() {
	var getStockValue = $("#value").val();
	getStockValue = parseFloat(getStockValue);
	$("#value").attr("value", jFormat(getStockValue, 2));
}