$(document).ready(function()
{
	$("#Registration").submit(function(evt)
	{
		evt.preventDefault();
		
		if(checkForm())
		{
			this.submit();
		}
		else
		{
			document.getElementById("PageError").innerHTML="NOT ALL FIELDS FILLED OUT CORRECTLY";
		}
	});
});

function checkEmail(email)
{
	var valid_email = false;
	if(!(/^([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4})$/i.test(email)))
	{	
		document.getElementById("EmailError").innerHTML="Invalid Email Address";
	}
	else
	{
		document.getElementById("EmailError").innerHTML="";
		valid_email = true;
	}
	return valid_email;
}

function checkPhone(phone)
{
	var valid_phone = false;
	if(!(/^(([0-9]{3}[- ]?){2}[0-9]{4})?$/.test(phone)))
	{	
		document.getElementById("PhoneError").innerHTML="Invalid Phone Number (Try removing Spaces)";
	}
	else
	{
		document.getElementById("PhoneError").innerHTML="";
		valid_phone = true;
	}
	return valid_phone;
}

function checkPasswords()
{
    var pass1 = document.getElementById('Password1');
	var pass2 = document.getElementById('Password2');
	var message = document.getElementById('PasswordError');
	//Set the colors we will be using
	var goodColor = "#66cc66";
	var badColor = "#ff6666";
	
	if(pass2.value == "")
	{
	    pass2.style.backgroundColor = "#ffffff";
	    message.innerHTML = "";
	}
	else
	{
		if(pass1.value == pass2.value)
		{
	        pass2.style.backgroundColor = goodColor;
	        message.style.color = goodColor;
	        message.innerHTML = "Passwords Match!"
	        return true;
	    }
	    else
		{
	        pass2.style.backgroundColor = badColor;
	        message.style.color = badColor;
	        message.innerHTML = "Passwords Do Not Match!"
		}
    }
	return false;
}





function checkForm()
{
	var first_name = document.getElementById("FirstName").value;
	var last_name = document.getElementById("LastName").value;
	var email = document.getElementById("Email").value;
	var phone = document.getElementById("PhoneNumber").value;
	var name_string = /[A-Z]+/i
	
	var passed_all_checks = false;
	
	/*
	var UserNameCheck = checkUserName(student_id);
	var emailCheck = checkEmail(email);
	var passwordCheck = checkPasswords();
	var phoneCheck = checkPhone(phone);
	var fnameCheck = name_string.test(first_name);
	var lnameCheck = name_string.test(last_name);
	var dateCheck = month != "no_selection" && day != "no_selection" && year != "no_selection";
	*/

	if(checkEmail(email)
	        && checkPasswords()
			)
	{
		passed_all_checks = true;
	}
	return passed_all_checks;
}

function isInArray(value, array)
{
	for(var i = 0; i < array.length; ++i)
	{
		if(array[i] == value)
		{
			return true;
		}
	}
	return false;
}