// Author: Adrian Stephan Schauer
// Created at: 2021-12-08
// Handles stuff for user settings.

//Event Listeners
document.getElementById('da').addEventListener('click', delete_user);
document.getElementById('cp').addEventListener('click', change_password);
document.getElementById('cu').addEventListener('click', change_username);
document.getElementById('lo').addEventListener('click', logout);

document.getElementById('nusername').addEventListener('input', nusername_validation, false);

function nusername_validation() {
    if (nusername.value.length >= 4 && nusername.value.length <= 32 && nusername.value.includes(" ") == false) {
        fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "checkUsername", "user": nusername.value }) })
            .then(response => response.json())
            .then(response => {
                if (response.error == undefined)
                    if (response.success == true) {
                        nusername.setCustomValidity('');
                    } else {
                        nusername.setCustomValidity('Invalid');
                    }
                console.log(response);
            })
    } else {
        nusername.setCustomValidity('Invalid');
        console.log("Invalid Username!");
    }
}


function delete_user() {
    let delete_button = document.getElementById("da");
    if (delete_button.innerText == "Delete Account") {
        delete_button.textContent = "Do you really want to delete your account";
    } else {
        console.log("Deleting User...")
        fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "deleteUser", "email": window.localStorage.getItem('email'), "pw": window.localStorage.getItem('pw') }) })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response.error == undefined) {
                    console.log("Account deleted");
                    window.localStorage.removeItem('email');
                    window.localStorage.removeItem('pw');
                    document.getElementById('information-good').textContent = "Deleted successfully!";
                } else {
                    document.getElementById('information-bad').textContent = "Error: " + response.error;
                }
            })
    }
}

function change_password() {
    let opassword = document.getElementById("opassword");
    let npassword = document.getElementById("npassword");

    if (npassword.value.length >= 8 && npassword.value.length <= 32 && npassword.value.includes(" ") == false) {
        fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "changePassword", "email": window.localStorage.getItem('email'), "pw": opassword.value, "npw": npassword.value }) })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response.error == undefined) {
                    window.localStorage.setItem('pw', npassword.value);
                    document.getElementById('information-good').textContent = "Password changed successfully!";
                } else {
                    opassword.setCustomValidity('Invalid');
                }
            })
    }else{
        npassword.setCustomValidity('Invalid');
    }
}

function change_username() {
    let nusername = document.getElementById("nusername");
    nusername_validation();
    if (nusername.checkValidity()) {
        fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "changeUsername", "email": window.localStorage.getItem('email'), "pw": window.localStorage.getItem('pw'), "user": nusername.value }) })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response.error == undefined) {
                    document.getElementById('information-good').textContent = "Username changed successfully!";
                } else {
                    nusername.setCustomValidity('Invalid');
                }
            })
    }
}

function logout() {
    window.localStorage.removeItem('email');
    window.localStorage.removeItem('pw');
    window.location.href = site;
}