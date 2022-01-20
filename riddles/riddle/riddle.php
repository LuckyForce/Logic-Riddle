<?php
//Get the Riddle Data.
ini_set('display_errors', 1);
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    $id = null;
}else
    $id = $_GET['id'];
$description = "";
$diff = 0;
$title = "";
$creator = "";
$createdat = "";

if ($id != null) {
    require '../../api/dbconnect.php';

    $stmt = $conn->prepare("SELECT l_ri_title, l_ri_desc, l_ri_diff, l_ri_createdat, l_u_user FROM l_ri_riddles INNER JOIN l_u_users ON l_ri_riddles.l_ri_u_creator = l_u_users.l_u_id WHERE l_ri_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $riddle = $stmt->fetch(PDO::FETCH_ASSOC);
}
//check if Riddle is available
if ($id != null && $riddle != false) {
    $valid = "true";

    $description = $riddle['l_ri_desc'];
    $diff = $riddle['l_ri_diff'];
    $title = $riddle['l_ri_title'];
    $creator = $riddle['l_u_user'];
    $createdat = $riddle['l_ri_createdat'];
} else {
    $id = -1;
    $valid = "false";
}
if ($description == null) $description = "No description available.";
if ($diff == null) $diff = 0;
if ($title == null) $title = "No title available.";
if ($creator == null) $creator = "No creator available.";
if ($createdat == null) $createdat = "No creation date available.";
?>
<script>
    //Variablen werden dann von Adrian hier noch über php eingespeichert damit wir sie sicherer über .content einbinden können.
    const riddle_id = <?= $id ?>;
    const riddle_valid = <?= $valid ?>;
    const riddle_title = "<?= $title ?>";
    const riddle_description = "<?= $description ?>";
    const riddle_diff = <?= $diff ?>;
    const riddle_creator = "<?= $creator ?>";
    const riddle_createdat = "<?= $createdat ?>";
</script>
<script src="<?= $site ?>files/js/riddle.js" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>

<!--DONE: Fabian irgendwie noch wo nen link platzieren mit: Wanna create your own Riddle clicke <a href="<?= $site ?>riddles/create/">here</a>-->
<div id="riddle-valid" class="invisible">
    <div class="bg-dark-purple">
        <div class="header-title">
            <h1 id="title"></h1>
        </div>


        <div class="row text-center purple mt-5 mx-1 justify-content-center">
            <div class="col bg-dark-grey col-md-2">
                <div id="creator" class="mt-3">
                    <p>Created by: <span id="creator-name"></span></p>
                </div>
            </div>
            <div class="col bg-dark-krey col-md-2">
                <div id="createdat" class="mt-3">
                    <p>Created at: <span id="createdat-date"></span></p>
                </div>
            </div>
            <div class="col bg-dark-grey col-md-2">
                <div id="diff" class="mt-3">
                    <p>Difficulty: <span id="diff-text"></span></p>
                </div>
            </div>
        </div>
        <div class="row row-cols-2 justify-content-center text-center purple mt-5 mx-0">
            <div id="description">
                <p id="description-text"></p>
            </div>
        </div>

        <br>
        <div class="card bg-dark-grey text-center col-sm-6 m-auto">
            <br>
            <br>
            <br>
            <script src="<?= $site ?>files/js/logictable.js" type="module"></script>
            <form id="expression-form" class="was-validated" onsubmit="return false">
                <div class="row justify-content-center pink">
                    <div class="form-group col-md-6">
                        <label for="expression">
                            <h3>Expression:</h3>
                        </label>
                        <input type="text" class="form-control border mt-2 mb-3" id="expression" placeholder="z.B.: ¬B∨A∧C" />
                        <button type="button" class="btn btn-red" id="delete"><i class="fas fa-backspace"></i></button>
                        <button type="button" class="btn btn-submit" id="submit">Submit Solution</button>
                        <div class="invalid-feedback mt-3">Invalid Expression!</div>
                    </div>
                </div>
                <div id="feedback" class="justify-content-center p-5">
                </div>
                <div class="row">
                    <div class="col">
                        <!--
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
            -->
                        <button type="button" class="btn btn-default" id="not">¬ NOT</button>
                        <button type="button" class="btn btn-default" id="or">∨ OR</button>
                        <button type="button" class="btn btn-default" id="and">∧ AND</button>
                        <button type="button" class="btn btn-default" id="implies">→ IMPLIES</button>
                        <button type="button" class="btn btn-default" id="true">1 TRUE</button>
                        <button type="button" class="btn btn-default" id="bracket-left"> ( </button>

                        <div class="row mt-2">
                            <div class="col">
                                <button type="button" class="btn btn-default" id="xor">⊻ XOR</button>
                                <button type="button" class="btn btn-default" id="nor">↓ NOR</button>
                                <button type="button" class="btn btn-default" id="nand">↑ NAND</button>
                                <button type="button" class="btn btn-default" id="iff">⟷ IFF</button>
                                <button type="button" class="btn btn-default" id="false">0 FALSE</button>
                                <button type="button" class="btn btn-default" id="bracket-right"> ) </button>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-default" id="a">A</button>
                        <button type="button" class="btn btn-default" id="b">B</button>
                        <button type="button" class="btn btn-default" id="c">C</button>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="button" class="btn btn-default" id="d">D</button>
                                <button type="button" class="btn btn-default" id="e">E</button>
                                <button type="button" class="btn btn-default" id="f">F</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div id="table" class="justify-content-center p-5">
                <table id="result" class="table table-success table-bordered">
                </table>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>

</div>
<div id="riddle-invalid" class="invisible">
    <!--DONE: Feedback das das Riddle nicht existiert-->
    <div class="bg-dark-purple">
        <div class="text-center red-wrong">
            <h1 class="mb-0">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                ERROR
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </h1>
        </div>
    </div>
</div>