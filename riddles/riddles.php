<!--DONE: Frontend Riddle Explore Pane Filter and Cards
NOTE: This Panes von den einzelenn riddles werden im nachhinein reingeladen per JavaScript.
Hier muss nur das Frontend drum herum gemacht werden-->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?= $site ?>files/js/riddles.js" type="module"></script>
<div class="bg-dark-purple">

    <div class="header-title">
        <h1>Riddles</h1>
    </div>

    <div class="container ms-1">
        <button type="button" class="btn btn-default" data-bs-toggle="collapse" data-bs-target="#demo"><i class="fas fa-filter"></i></button>
    </div>

    <div class="container ms-1 mt-1">
        <button type="button" class="btn btn-default"><a href="<?= $site ?>riddles/create/" class="btn-create">Create your own riddle</a></button>
    </div>

    <div id="demo" class="collapse">
        <div class="container mt-5 mb-5">
            <div class="card bg-dark-grey">
                <form id="filter" class="p-1">
                    <div class="row mx-0 purple">
                        <div class="form-group col-md-3 mb-3 mt-1">
                            <label for="search-text">Search for Riddle-Name:</label>
                            <input type="text" class="form-control border" id="search-text" placeholder="Search" />
                        </div>
                        <div class="form-group col-md-3 mb-3 mt-1">
                            <label for="search-user">Search for sepcific Users:</label>
                            <input type="text" class="form-control border" id="search-user" placeholder="Search" />
                        </div>
                        <div class="form-group col-md-3 mb-3 mt-1">
                            <label for="diff">Difficulty:</label>
                            <select class="form-select" id="diff">
                                <option selected value="All">All</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 mb-3 mt-1">
                            <label for="order">Order by Date:</label>
                            <select class="form-select" id="order">
                                <option value="desc">desc</option>
                                <option value="asc">asc</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="p-1">
        <div id="riddle-cards" class="row mx-5 my-3 justify-content-center">

        </div>
    </div>
</div>