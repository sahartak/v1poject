jQuery.validator.addMethod("lettersnumbersonly", function(value, element) {
    return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Special characters and spaces not allowed");

jQuery(document).ready(function($){
    $("#MainForms").validate({
	rules: {
	    commodities_groups_name: {
		required: true,
		lettersnumbersonly: true
	    }
	},
	messages: {
	    commodities_groups_name: {
		required: "Please provide a name"
	    }
	}
    });
});