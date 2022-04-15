// Author: Adrian Stephan Schauer
// Created at: 2021-12-12
// Send the expression to the server and creates a table for the give expression.

/*
¬ not
∨ or
∧ and
⊻ xor
1 True
0 False
→ implies
⟷ if and only if
↑ NAND
↓ NOR
*/

//Event Listener for the intput field of the expression
const expression_input = document.getElementById("expression");
expression_input.addEventListener("input", checkExpression, false);
//Event Listener for the buttons for the expression
const not = document.getElementById("not");
not.addEventListener("click", function () {
    placeCharacter("¬");
});
const or = document.getElementById("or");
or.addEventListener("click", function () {
    placeCharacter("∨");
})
const and = document.getElementById("and");
and.addEventListener("click", function () {
    placeCharacter("∧");
})
const xor = document.getElementById("xor");
xor.addEventListener("click", function () {
    placeCharacter("⊻");
})
const true_button = document.getElementById("true");
true_button.addEventListener("click", function () {
    placeCharacter("1");
})
const false_button = document.getElementById("false");
false_button.addEventListener("click", function () {
    placeCharacter("0");
})
const implies = document.getElementById("implies");
implies.addEventListener("click", function () {
    placeCharacter("→");
})
const if_and_only_if = document.getElementById("iff");
if_and_only_if.addEventListener("click", function () {
    placeCharacter("⟷");
})
const nand = document.getElementById("nand");
nand.addEventListener("click", function () {
    placeCharacter("↑");
})
const nor = document.getElementById("nor");
nor.addEventListener("click", function () {
    placeCharacter("↓");
})
const bracket_left = document.getElementById("bracket-left");
bracket_left.addEventListener("click", function () {
    placeCharacter("(");
})
const bracket_right = document.getElementById("bracket-right");
bracket_right.addEventListener("click", function () {
    placeCharacter(")");
})
const delete_button = document.getElementById("delete");
delete_button.addEventListener("click", function () {
    if (expression_input.value.length > 0) {
        //Get Cursor position and delete one character
        let input = expression_input;
        let start = input.selectionStart;
        let end = input.selectionEnd;
        let text = input.value;
        let before = text.substring(0, start - 1);
        let after = text.substring(end, text.length);
        input.value = before + after;
        input.focus();
        input.setSelectionRange(start - 1, start - 1);
        checkExpression();
    }
})

//Buttons for the Alphabet
const a = document.getElementById("a");
a.addEventListener("click", function () {
    placeCharacter("A");
})
const b = document.getElementById("b");
b.addEventListener("click", function () {
    placeCharacter("B");
})
const c = document.getElementById("c");
c.addEventListener("click", function () {
    placeCharacter("C");
})
const d = document.getElementById("d");
d.addEventListener("click", function () {
    placeCharacter("D");
})
const e = document.getElementById("e");
e.addEventListener("click", function () {
    placeCharacter("E");
})
const f = document.getElementById("f");
f.addEventListener("click", function () {
    placeCharacter("F");
})

function placeCharacter(char) {
    //Get Curson Position in input field
    let input = expression_input;
    let start = input.selectionStart;
    let end = input.selectionEnd;
    let text = input.value;
    let before = text.substring(0, start);
    let after = text.substring(end, text.length);
    input.value = before + char + after;
    input.focus();
    input.setSelectionRange(start + 1, start + 1);
    checkExpression();
}

function checkExpression() {
    document.getElementById("expression").focus();

    if (typeof riddle_valid !== "undefined")
        document.getElementById("feedback").textContent = "";

    let table = document.getElementById("result");
    table.innerHTML = "";
    let expression_input = document.getElementById("expression");

    if (expression_input.value.length > 0)
        fetch(site + 'api/logic/', { method: "POST", body: JSON.stringify({ "expression": expression_input.value }) })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response.error == undefined && response.success != false) {
                    expression_input.setCustomValidity('');
                    generateTable(response.result);
                } else {
                    expression_input.setCustomValidity('Invalid');
                }
            });
}

//Generates the table for the response.
function generateTable(result) {
    let table = document.getElementById("result");
    for (let i = 0; i < result.length; i++) {
        let tr = document.createElement("tr");
        for (let j = 0; j < result[i].length; j++) {
            if (i == 0) {
                let th = document.createElement("th");
                th.classList.add("purple-table-h");
                th.innerHTML = result[i][j];
                tr.appendChild(th);
            } else {
                let td = document.createElement("td");
                td.classList.add("purple-table");
                td.innerHTML = result[i][j];
                tr.appendChild(td);
            }
        }
        table.appendChild(tr);
    }
}

