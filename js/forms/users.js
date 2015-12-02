jQuery.validator.addMethod("nowhitespace", function(value, element) {
	return this.optional(element) || /^\S+$/i.test(value);
}, "No white space please"); 

jQuery.validator.addMethod("lettersnumbersonly", function(value, element) {
	return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Special characters and spaces not allowed");

jQuery.validator.addMethod("lettersnumbersspaceonly", function(value, element) {
	return this.optional(element) || /^[a-z0-9 ]+$/i.test(value);
}, "Special characters not allowed");

jQuery.validator.addMethod("phonefax", function(value, element) {
	return this.optional(element) || /^[0-9 +-]+$/i.test(value);
}, "Allowed characters are numbers, +, - and space");

jQuery(document).ready(function($){
	$("#MainForms").validate({
		rules: {
			user_firstname: {
				required: true,
				minlength: 1,
				lettersnumbersspaceonly:true
			},
			user_lastname: {
				required: true,
				minlength: 1,
				lettersnumbersspaceonly:true
			},
			user_email: {
				required: true,
				email: true,
				remote: "includes/validateEmailUsers.php"
			},
			user_phone: {
				phonefax: true
			},
			user_fax: {
				phonefax: true
			},
			user_username: {
				required: true,
				lettersnumbersonly: true,
				remote: "includes/validateUsername.php"
			},
			user_password: {
				lettersnumbersonly: true
			},
			user_password2: {
				equalTo: "#user_password"
			},
			user_secret_question: {
				required: true
			},
			user_secret_answer: {
				required: true
			}
		},
		messages: {
			user_firstname: {
				minlength: "Minimum length for first name is 1 character"
			},
			user_lastname: {
				minlength: "Minimum length for last name is 1 character"
			},
			user_email: {
				user_email: "Please enter a valid email address",
				remote: jQuery.format("Email {0} is already in use")
			},
			user_username: {
				remote: jQuery.format("Username {0} is already in use")
			},
			user_password2: {
				equalTo: "Password missmatch"
			}
		}
	});
});