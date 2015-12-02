jQuery.validator.addMethod("nowhitespace", function(value, element) {
    return this.optional(element) || /^\S+$/i.test(value);
}, "No white space please"); 

jQuery.validator.addMethod("lettersnumbersonly", function(value, element) {
    return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Special characters and spaces not allowed");

jQuery(document).ready(function($){
    $("#MainForms").validate({
		rules: {
			value_date: {
			required: true
			}
		},
		messages: {
			date_value: {
			required: "Please, enter the date of values"
			}
		}
    });
});
function setDetails() {
	$("[id^='value']").each(function(){
		var getStockValue = jNum($(this).val());
		getStockValue = parseFloat(getStockValue);
		if(getStockValue) {
			$(this).attr("value", jFormat(getStockValue, 2));
		}
	});
	$("[id^='volume']").each(function(){
		var getStockVolume = jNum($(this).val());
		getStockVolume = parseFloat(getStockVolume);
		if(getStockVolume) {
			$(this).attr("value", jFormat(getStockVolume, 2));
		}
	});
}