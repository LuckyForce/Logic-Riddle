// Author: Adrian Stephan Schauer
// Created at: 2021-12-08
// Handles the display of the riddles exploration page.

//Event Listeners
const search_text = document.getElementById("search-text").addEventListener("input", searchRiddles);
const search_user = document.getElementById("search-user").addEventListener("input", searchRiddles);
const diff_select = document.getElementById("diff").addEventListener("change", searchRiddles);
const orderby = document.getElementById("order").addEventListener("change", searchRiddles);

searchRiddles();

function searchRiddles() {
    let search_text = document.getElementById("search-text").value;
    let search_user = document.getElementById("search-user").value;
    let diff_select = document.getElementById("diff").value;
    let order = document.getElementById("order").value;

    let email = null;
    let pw = null;

    fetch(site + 'api/riddles/', { method: "POST", body: JSON.stringify({ "task": "getRiddles", "email": email, "pw": pw, "searchtext": search_text, "searchuser": search_user, "diff": diff_select, "order": order }) })
        .then(response => response.json())
        .then(response => {
            let riddle_cards = document.getElementById("riddle-cards");
            riddle_cards.innerHTML = "";
            
            if (response.error == undefined) {
                //TODO: Create Cards
                for (let i = 0; i < response.riddles.length; i++) {
                    /*
                    TODO: Create Card for each riddle
                    <div class="card text-center bg-dark-grey purple mt-3 mx-2">
            <div class="card-header">
                <h3>Riddle 1</h3>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Peter lügt und Hans sagt, das Peter lügt.
                </p>
            </div>
            <div class="card-footer">
                <small class="text-muted">Created by: Adrian Schauer</small>
            </div>
            <a href="<?= $site ?>riddles" class="stretched-link"></a>
        </div>
                    */
                    let riddle_card = document.createElement("div");
                    riddle_card.setAttribute("class", "card text-center bg-dark-grey purple mt-3 mx-2 col riddle-card");

                    let card_header = document.createElement("div");
                    card_header.setAttribute("class", "card-header");
                    let card_body = document.createElement("div");
                    card_body.setAttribute("class", "card-body");
                    let card_footer = document.createElement("div");
                    card_footer.setAttribute("class", "card-footer");

                    let riddle_title = document.createElement("h3");
                    riddle_title.textContent = response.riddles[i].l_ri_title;
                    let riddle_desc = document.createElement("p");
                    riddle_desc.textContent = response.riddles[i].l_ri_desc;
                    let riddle_creator = document.createElement("small");
                    riddle_creator.setAttribute("class", "text-muted")
                    riddle_creator.textContent = response.riddles[i].l_u_user;

                    let link = document.createElement("a");
                    link.setAttribute("href", site+"riddles/riddle/?id="+response.riddles[i].l_ri_id);
                    link.setAttribute("class", "stretched-link");

                    card_header.appendChild(riddle_title);
                    card_body.appendChild(riddle_desc);
                    card_footer.appendChild(riddle_creator);

                    riddle_card.appendChild(card_header);
                    riddle_card.appendChild(card_body);
                    riddle_card.appendChild(card_footer);
                    riddle_card.appendChild(link);

                    riddle_cards.appendChild(riddle_card);
                }
            }
            console.log(response);
        })
}