/*
$.validator.setDefaults({
	submitHandler: function(form) {
		$(form).submit();
	}
});
*/
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
		remote: "includes/validateRefAdmins.php"
	    },
	    username: {
		required: true,
		rangelength: [6,32],
		lettersnumbersonly:true,
		remote: "includes/validateUserAdmins.php"
	    },
	    password: {
		//required: true,
		nowhitespace:true,
		minlength: 6
	    },
	    email: {
		required: true,
		email: true
	    }
	},
	messages: {
	    ref: {
		required: "Please enter a REF",
		remote: jQuery.format("REF {0} is already in use")
	    },
	    username: {
		required: "Please enter a username",
		rangelength: "Your username should be between 6 and 32 characters",
		remote: jQuery.format("Username {0} is already in use")
	    },
	    password: {
		required: "Please provide a password",
		minlength: "Your password must be at least 6 characters long"
	    },
	    email: "Please enter a valid email address"
	}
    });
});