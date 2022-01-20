// Author: Adrian Stephan Schauer
// Created at: 2021-12-08
// Handles the user registration.

console.log(site);
//Eventlistener
const username_input = document.getElementById("username");
username_input.addEventListener("input", username_validation, false);
const email_input = document.getElementById("email");
email_input.addEventListener("input", email_validation, false);
const password_input = document.getElementById("password");
password_input.addEventListener("input", password_validation, false);
const consent_checkmark = document.getElementById("consent");
consent_checkmark.addEventListener("input", consent_validation, false);
const ca_button = document.getElementById("ca");
ca_button.addEventListener("click", createUser, false);
const code_input = document.getElementById("code");
code_input.addEventListener("input", verifyUser, false);
const resendCode_butten = document.getElementById("resendCode");
resendCode_butten.addEventListener("click", resendCode, false);

//Signup Validations
function username_validation() {
    let username = document.getElementById("username");
    if (username.value.length >= 4 && username.value.length <= 32 && username.value.includes(" ") == false) {
        fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "checkUsername", "user": username.value }) })
            .then(response => response.json())
            .then(response => {
                if (response.error == undefined)
                    if (response.success == true) {
                        username.setCustomValidity('');
                    } else {
                        username.setCustomValidity('Invalid');
                    }
                console.log(response);
            })
    } else {
        username.setCustomValidity('Invalid');
        console.log('Invalid username!')
    }
}

function email_validation() {
    let email = document.getElementById("email");
    const reg = /.+\@.+\..+/;
    if (email.value.match(reg)) {
        fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "checkEmail", "email": email.value }) })
            .then(response => response.json())
            .then(response => {
                if (response.error == undefined)
                    if (response.success == true) {
                        email.setCustomValidity('');
                    } else {
                        email.setCustomValidity('Invalid');
                    }
                console.log(response);
            })
    } else {
        email.setCustomValidity('Invalid');
        console.log('Invalid email address!')
    }
}

function password_validation() {
    let password = document.getElementById("password");
    if (password.value.length >= 8 && password.value.length <= 32 && password.value.includes(" ") == false) {
        password.setCustomValidity('');
    } else {
        password.setCustomValidity('Invalid');
        console.log('Invalid password!')
    }
}

function consent_validation() {
    let consent = document.getElementById("consent");
    if (consent.checked == true) {
        consent.setCustomValidity('');
    } else {
        consent.setCustomValidity('Invalid');
        console.log('Invalid consent!')
    }
}

function createUser() {
    let email = document.getElementById("email");
    let username = document.getElementById("username");
    let password = document.getElementById("password");
    let consent = document.getElementById("consent");
    let ca = document.getElementById("ca");

    email_validation();
    username_validation();
    password_validation();
    consent_validation();
    if (email.checkValidity() && username.checkValidity() && password.checkValidity() && consent.checkValidity()) {
        console.log('Creating Account');
        ca.textContent = "Creating Account...";
        ca.disabled = true;
        fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "createUser", "email": email.value, "user": username.value, "pw": password.value }) })
            .then(response => response.json())
            .then(response => {
                if (response.error == undefined) {
                    document.getElementById("signup-form").classList.add("invisible");
                    document.getElementById("verify").classList.remove("invisible");
                    document.getElementById("code").focus();
                } else
                    ca.textContent = "Something went wrong! Please try again later.";
                console.log(response);
            })
    }
}

function verifyUser() {
    let code = document.getElementById('code');
    let email = document.getElementById("email");

    if (code.value.length == 6) {
        fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "verifyUser", "email": email.value, "code": code.value }) })
            .then(response => response.json())
            .then(response => {
                if (response.error == undefined)
                    verified();
                else {
                    code.setCustomValidity('Invalid');
                }
            })
    }
}

function resendCode() {
    let email = document.getElementById("email");
    fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "resendCode", "email": email.value }) })
        .then(response => response.json())
        .then(response => {
            console.log(response);
        })
}

function verified() {
    window.localStorage.setItem("email", document.getElementById("email").value);
    window.localStorage.setItem("pw", document.getElementById("password").value);
    let list = document.getElementsByClassName('loggedin');
    for (let item of list) {
        item.classList.remove("invisible");
    }
    list = document.getElementsByClassName('loggedout');
    for (let item of list) {
        item.classList.add("invisible");
    }
    document.getElementById("verify").classList.add("invisible");
    document.getElementById("success").classList.remove("invisible");
}