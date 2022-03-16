<div class="bg-dark-purple">
    <div class="header-title">
        <h1>Logic Calculator</h1>
    </div>
    <br>
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
                    <div class="invalid-feedback">Invalid Expression!</div>
                </div>
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