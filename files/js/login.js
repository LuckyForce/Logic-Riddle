// Author: Adrian Stephan Schauer
// Created at: 2021-12-08
// Handles the user login.

const email_input = document.getElementById("email");
email_input.addEventListener("input", email_validation, false);
const password_input = document.getElementById("password");
password_input.addEventListener("input", password_validation, false);
const login_button = document.getElementById("login-button");
login_button.addEventListener("click", loginUser, false);

function email_validation() {
    let email = document.getElementById("email");
    const reg = /.+\@.+\..+/;
    if (email.value.match(reg)) {
        email.setCustomValidity('');
    } else {
        email.setCustomValidity('Invalid');
        console.log('Invalid email address!')
    }
}

function password_validation() {
    let password = document.getElementById("password");
    if (password.value.length >= 8 && password.value.length <= 32 && password.value.includes(" ") == false && password.value.includes("<") == false && password.value.includes(">") == false) {
        password.setCustomValidity('');
    } else {
        password.setCustomValidity('Invalid');
        console.log('Invalid password!')
    }
}

function loginUser() {
    console.log("Loging in...");
    email_validation();
    password_validation();

    document.getElementById("information-bad").textContent = "";

    if (email_input.checkValidity() && password_input.checkValidity()) {
        console.log("User inputs valid");
        fetch(site + "api/users/", { method: "POST", body: JSON.stringify({ "task": "checkPassword", "email": email_input.value, "pw": password_input.value }) })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response.success) {
                    console.log("Loggedin");
                    console.log(response.id);
                    window.localStorage.setItem('email', email_input.value);
                    window.localStorage.setItem('pw', password_input.value);
                    let list = document.getElementsByClassName('loggedout');
                    for (let item of list) {
                        item.classList.add("invisible");
                    }
                    list = document.getElementsByClassName('loggedin');
                    for (let item of list) {
                        item.classList.remove("invisible");
                    }
                    document.getElementById("loggedin").classList.add("invisible");

                    //Show that you'Re loggedin now
                    document.getElementById('login-form').classList.add('invisible');
                    document.getElementById("success").classList.remove('invisible');
                } else {
                    console.log("Password or email wrong");
                    //Show that it is wrong
                    document.getElementById("information-bad").textContent = "Password or email wrong";
                }
            })
    }
}