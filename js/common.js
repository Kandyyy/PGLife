window.addEventListener("load",function(){
    var signup_form = document.getElementById("signup-form");
    signup_form.addEventListener("submit",function(event){
        var xhr = new XMLHttpRequest();
        var form_data = new FormData(signup_form);

        xhr.addEventListener("load", success)
        xhr.addEventListener("error", error)

        xhr.open("post","api/signup_submit1.php");
        xhr.send(form_data);
        event.preventDefault();
    });

    var login_form = document.getElementById("login-form");
    login_form.addEventListener("submit",function(event){
        var xhr = new XMLHttpRequest();
        var form_data = new FormData(login_form);

        xhr.addEventListener("load", login_success);
        xhr.addEventListener("error", error);

        xhr.open("post","api/login_submit.php");
        xhr.send(form_data);        
        event.preventDefault();
    });

});

var success = function(event){
    var response = JSON.parse(event.target.responseText);
    if(response.success){
        alert(response.msg);
        window.location.href = "index.php";
    }
    else{
        alert(response.msg);
    }
};

var login_success = function(event){
    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        location.reload();
    } else {
        alert(response.msg);
    }
};

var error = function(event){
    alert("Something went wrong");
};
