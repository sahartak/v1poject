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

jQuery.validator.addMethod("accountname", function(value, element) {
	return this.optional(element) || /^[a-z0-9 .]+$/i.test(value);
}, "Special characters not allowed");

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
	user_account_num: {
		required: true,
		lettersnumbersonly: true
	},
	user_account_name: {
		required: true,
		accountname: true
	},
	user_username: {
		required: true,
		remote: "includes/validateUserUsername.php",
		lettersnumbersonly: true
	},
	user_password: {
		required: true,
		lettersnumbersonly: true
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
		required: "WTF!?",
		remote: jQuery.format("Username {0} is already in use")
	}
	}
	});

	$("#moreDetails").hide();
	$("#showMoreDetails").click(function (){
		$("#moreDetails").toggle();
		if($(this).is(".clicked")) {
			$("#showMoreDetails").removeClass("clicked");
			$("#showMoreDetails.moreRight").html("more details &raquo;");
		}else{
			$("#showMoreDetails").addClass("clicked");
			$("#showMoreDetails").html("&laquo; less details");
		}
	});

	$("#moreBankDetails").hide();
	$("#showBankDetails").click(function (){
		$("#moreBankDetails").toggle();
		if($(this).is(".clicked")) {
			$("#showBankDetails").removeClass("clicked");
			$("#showBankDetails.moreRight").html("show bank details &raquo;");
		}else{
			$("#showBankDetails").addClass("clicked");
			$("#showBankDetails").html("&laquo; hide bank details");
		}
	});
});

function trim(str) {
	if (str.length>0) {
		while (str.substring(0,1) == ' ') {
			str = str.substring(1, str.length);
		}
		while (str.substring(str.length-1, str.length) == ' ') {
			str = str.substring(0,str.length-1);
		}
	}
	return str;
}

function capitalize(str) {
	var newVal = '';
	str = str.split(' ');
	for(var c=0; c < str.length; c++) {
		newVal += str[c].substring(0,1).toUpperCase() + str[c].substring(1,str[c].length) + ' ';
	}
	return trim(newVal);
}

function generateAccountInfos() {
	/* Generate Account Number */
	ThisForm = document.addNewUser;

	/* Generate Account Name */
	var first = capitalize(trim(ThisForm.user_firstname.value));
	var middle = capitalize(trim(ThisForm.user_middlename.value));
	var last = capitalize(trim(ThisForm.user_lastname.value));
	var name = trim(last);

	if (middle.length >1) {
		last = trim(middle.substr(0,1)) + '. ' + last;
	}
	if (first.length >1) {
		last = trim(first) + ' ' + last;
		first = first.substr(0,1);
		name = first.substr(0,1) + name;
	}

	ThisForm.user_account_name.value = trim(last);
	ThisForm.user_username.value = trim(name.toLowerCase().replace(/(\s)/,'').substr(0,8));
}