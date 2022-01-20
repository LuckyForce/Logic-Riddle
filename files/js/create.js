// Author: Adrian Stephan Schauer
// Created at: 2021-12-08
// Handles the creation of the riddles.

//Event Listeners
const title_input = document.getElementById("title").addEventListener("input", validateTitle);
const description_input = document.getElementById("description").addEventListener("input", validateDescription);
const expression_input = document.getElementById("expression").addEventListener("input", validateExpression);
const consent_checkmark = document.getElementById("consent").addEventListener("click", validateConsent);
const cr_button = document.getElementById("cr").addEventListener("click", createRiddle);

function validateTitle() {
    let title = document.getElementById("title");
    if (title.value.length > 0 && title.value.length < 33 && title.value.includes("<") == false && title.value.includes(">") == false) {
        title.setCustomValidity('');
    } else {
        title.setCustomValidity('Invalid');
    }
}

function validateDescription() {
    let description = document.getElementById("description");
    if (description.value.length > 0) {
        description.setCustomValidity('');
    } else {
        description.setCustomValidity('Invalid');
    }
}

function validateExpression() {
    let expression = document.getElementById("expression");
    if (expression.value.length > 0)
        fetch(site + 'api/logic/', { method: "POST", body: JSON.stringify({ "expression": expression.value }) })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response.error == undefined && response.success != false) {
                    expression.setCustomValidity('');
                } else {
                    expression.setCustomValidity('Invalid');
                }
            });
    else
        expression.setCustomValidity('Invalid');
}

function validateConsent() {
    let consent = document.getElementById("consent");
    if (!consent.checked) {
        consent.setCustomValidity('Invalid');
    } else {
        consent.setCustomValidity('')
    }
}

function createRiddle() {
    let title = document.getElementById("title");
    let description = document.getElementById("description");
    let expression = document.getElementById("expression");
    let diff = document.getElementById("diff");
    let consent = document.getElementById("consent");
    let email = window.localStorage.getItem("email");
    let pw = window.localStorage.getItem("pw");

    validateTitle();
    validateDescription();
    validateExpression();
    validateConsent();

    if (title.checkValidity() && description.checkValidity() && expression.checkValidity() && consent.checkValidity()) {
        fetch(site + 'api/riddles/', { method: "POST", body: JSON.stringify({ "task": "createRiddle", "email": email, "pw": pw, "title": title.value, "description": description.value, "expression": expression.value, "diff": diff.value }) })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response.error == undefined) {
                    window.location.href = site + "riddles/riddle/?id=" + response.id;
                } else {
                    document.getElementById("feedback").innerHTML = response.error;
                }
            });
    }
}