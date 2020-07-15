function validateForm(){
    var fname = document.forms["user_details"]["first_name"].value;
    var lname = document.forms["user_details"]["last_name"].value;
    var city = document.forms["user_details"]["city_name"].value;

//user_details is the nameof our form
    if (fname == ""||lname == ""||city == ""){
        alert("all required details were not provided "+fname);
        return false;
    }
    return true;
}
