jQuery.validator.addMethod("nowhitespace", function(value, element) {
    return this.optional(element) || /^\S+$/i.test(value);
}, "No white space please"); 

jQuery.validator.addMethod("lettersnumbersonly", function(value, element) {
    return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Special characters and spaces not allowed");
	
jQuery(document).ready(function($){
    $("#MainForms").validate({
	rules: {
	    ref: {
		required: true,
		rangelength: [3,10],
		lettersnumbersonly:true,
		remote: "includes/validateRefAdvisors.php"
	    },
	    names: {
		required: true
	    },
	    firm: {
		required: true
	    },
	    contacts: {
		required: true
	    }
	},
	messages: {
	    ref: {
		required: "Please enter a REF",
		remote: jQuery.format("REF {0} is already in use")
	    },
	    names: {
		required: "Please provide a names"
	    },
	    firm: {
		required: "Please enter a firm"
	    },
	    contacts: {
		required: "Please enter some contacts"
	    }
	}
    });
});