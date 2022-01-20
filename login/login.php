<!--DONE: Login Formular, Successfully logedin, bereits logedin (Link auf /user).
Per JavaScript wird dann entschieden was angezeigt wird.-->

<div class="bg-dark-purple">
    <div class="header-title">
        <h1>Login</h1>
    </div>

    <br>
    <br>
    <br>

    <div class="container col-md-5">
    <div class="card text-center bg-dark-grey purple">

        <script src="<?= $site ?>files/js/login.js" type="module"></script>
        <form id="login-form" class="loggedout was-validated invisible">
            <div class="row justify-content-center">
                <div class="form-group col-md-4 mt-5">
                    <label for="email">E-Mail-Address:</label>
                    <input type="text" class="form-control border" id="email" placeholder="E-Mail" />
                    <div class="invalid-feedback">Invalid or Account does not exist!</div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-md-4 mt-2">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control border" id="password" placeholder="Password" />
                    <div class="invalid-feedback">Password has to be atleast 8 characters long!</div>
                </div>
            </div>
            <div class="form-group">
                <button id="login-button" class="btn col-4 mt-4 mb-5 btn-default" type="button">
                    Login
                </button>
                <div id="information-bad">

                </div>
            </div>
        </form>
        <div id="success" class="invisible my-5">
            Looks like you successfully logedin!
        </div>
        <div id="loggedin" class="loggedin invisible my-5">
            You are already logged in!
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
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>


</div>