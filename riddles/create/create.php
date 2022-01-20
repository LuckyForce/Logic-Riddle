<!--DONE: Fabian bitte schön machen.-->


<div class="bg-dark-purple">

    <div class="header-title">
        <h1>Create</h1>
    </div>
    <div class="container mt-5 col-md-6">
        <div class="card text-center bg-dark-grey purple">

            <script src="<?= $site ?>files/js/create.js" type="module"></script>
            <form id="create" class="loggedin was-validated p-1 col invisible">
                <div class="form-group col-md-6 mb-2 mt-4 mx-auto">
                    <label for="title">Title for the Riddle:</label>
                    <input type="text" class="form-control border" id="title" placeholder="Title" />
                    <div class="invalid-feedback">Can't be blank!</div>
                </div>
                <div class="form-group col-md-6 mb-2 mt-4 mx-auto">
                    <label for="description">Description for the Riddle:</label>
                    <input type="text" class="form-control border" id="description" placeholder="Description" />
                    <div class="invalid-feedback">Can't be blank!</div>
                </div>
                <div class="form-group col-md-6 mb-2 mt-4 mx-auto">
                    <label for="expression">Expression for the Riddle:</label>
                    <input type="text" class="form-control border" id="expression" placeholder="z.B.: ¬B∨A∧C" />
                    <div class="invalid-feedback">Invalid Expression!</div>
                </div>
                <div class="form-group col-md-3 mb-3 mt-4 mx-auto">
                    <label for="diff">Difficulty:</label>
                    <select class="form-select" id="diff">
                        <option selected value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6 mb-3">
                        <input type="checkbox" id="consent" name="consent" />
                        <label for="consent">
                            I hereby agree that my riddle and username will be shown to others and that other users can interact with my riddle.
                        </label>
                        <div class="invalid-feedback">Has to be accepted!</div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <button id="cr" class="btn btn-default col-8 mt-2" type="button">
                        Create Riddle
                    </button>
                </div>
                <div id="feedback" class="justify-content-center p-5 red-wrong">
                </div>
            </form>
            <div class="loggedout invisible">
                You need to be logedin to view this page!
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

</div>