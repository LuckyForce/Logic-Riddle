// Author: Adrian Stephan Schauer
// Created at: 2021-12-08
// Handles the user login and registration and other main stuff that is needed on every page.

if (window.localStorage.getItem('email') != null && window.localStorage.getItem('pw') != null) {
    fetch(site + 'api/users/', { method: "POST", body: JSON.stringify({ "task": "checkPassword", "email": window.localStorage.getItem('email'), "pw": window.localStorage.getItem('pw') }) })
        .then(response => response.json())
        .then(response => {
            console.log(response);
            if (response.error == undefined) {
                console.log("Login succeeded");
                let list = document.getElementsByClassName('loggedin');
                for (let item of list) {
                    item.classList.remove("invisible");
                }
            } else {
                window.localStorage.removeItem('email');
                window.localStorage.removeItem('pw');
                let list = document.getElementsByClassName('loggedout');
                for (let item of list) {
                    item.classList.remove("invisible");
                }
            }
        })
} else {
    let list = document.getElementsByClassName('loggedout');
    for (let item of list) {
        item.classList.remove("invisible");
    }
}