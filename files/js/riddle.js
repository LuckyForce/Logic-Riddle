// Author: Adrian Stephan Schauer
// Created at: 2021-12-02
// Handles the logic of the riddle.

//OPTIONAL: Rate Riddle.
//OPTIONAL: Comment on Riddle.

if (riddle_valid) {
  document.getElementById("title").textContent = riddle_title;
  document.getElementById("creator-name").textContent = riddle_creator;
  document.getElementById("createdat-date").textContent = riddle_createdat;
  document.getElementById("description-text").textContent = riddle_description;
  document.getElementById("diff-text").textContent = riddle_diff;

  document.getElementById("riddle-valid").classList.remove("invisible");
} else document.getElementById("riddle-invalid").classList.remove("invisible");

//Event Listeners
const submit_button = document
  .getElementById("submit")
  .addEventListener("click", checkRiddle);

function checkRiddle() {
  let expression = document.getElementById("expression");
  let email = window.localStorage.getItem("email");
  let pw = window.localStorage.getItem("password");

  if (expression.checkValidity())
    fetch(site + "api/riddles/", {
      method: "POST",
      body: JSON.stringify({
        task: "checkRiddle",
        id: riddle_id,
        expression: expression.value,
        email: email,
        pw: pw,
      }),
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.error == undefined) {
          if (response.success == true) {
            try{ document.getElementById("feedback").classList.remove("red-wrong"); }catch (e) { console.log("Red already removed!"); };
            document.getElementById("feedback").classList.add("green-solved")
            document.getElementById("feedback").textContent = "Riddle solved!";
            confetti({
              particleCount: 100,
              spread: 70,
              origin: { y: 0.6 }
            });
          } else {
            try{ document.getElementById("feedback").classList.remove("green-solved"); }catch (e) { console.log("Green already removed"); };
            document.getElementById("feedback").classList.add("red-wrong")
            document.getElementById("feedback").textContent = "Wrong expression!";
          }
          console.log(response);
        } else {
          document.getElementById("feedback").textContent =
            "Something went wrong while submitting the solution!";
        }
      });
}


