//we create a function to validate our form
//we will call the function when the form is submited

function validateForm(){
    var fname = document.forms["user_details"]["first_name"].value;
    var lname = document.forms["user_details"]["last_name"].value;
    var city = document.forms["user_details"]["city_name"].value;

//user_details is the nameof our form
    if (fname == ""||lname == ""||city == ""){
        alert("all details required "+fname);
        return false;
    }
    return true;
}