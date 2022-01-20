<script src="<?= $site ?>files/js/user.js" type="module"></script>
<div class="bg-dark-purple">

    <br>

    <div class="header-title">
        <h1>Settings</h1>
    </div>

    <br>
    <br>
    <br>

    <div class="container mt-3">
        <div class="card text-center bg-dark-grey purple">

            <div class="loggedin mt-4 invisible">
                <ins>Change Password:</ins>
                <form class="was-validated p-1">
                    <div class="row justify-content-center mx-0">
                        <div class="form-group col-md-3 mb-2 mt-4">
                            <label for="opassword">Old Password:</label>
                            <input type="password" class="form-control border" id="opassword" placeholder="Old Password" />
                            <div class="invalid-feedback">Password Wrong!</div>
                        </div>
                        <div class="form-group col-md-3 mb-2 mt-4">
                            <label for="npassword">New Password:</label>
                            <input type="password" class="form-control border" id="npassword" placeholder="New Password" />
                            <div class="invalid-feedback">Password has to be atleast 8 characters long!</div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group mb-3 col-md-6">
                            <button id="cp" class="btn btn-default col-8 mt-2" type="button">
                                Change Password
                            </button>
                        </div>
                    </div>
                </form>

                <form class="was-validated p-1">
                    <div class="row justify-content-center mx-0">
                        <div class="form-group col-md-4 mb-2 mt-4">
                            <label for="nusername">New Username:</label>
                            <input type="text" class="form-control border mt-2" id="nusername" placeholder="New Username" />
                            <div class="invalid-feedback">Username has to be atleast 8 characters long with a maximum of 16 or is already in use!</div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group mb-3 col-md-6">
                            <button id="cu" class="btn btn-default col-8 mt-2" type="button">
                                Change Username
                            </button>
                        </div>
                    </div>

                    <br>

                </form>
                Delete Account:
                <form class="row was-validated justify-content-center">
                    <div class="form-group mb-3 col-md-6">
                        <button id="da" class="btn btn-default col-8 mt-2" type="button">
                            Delete Account
                        </button>
                    </div>
                </form>

                <br>

                Logout:
                <form class="row was-validated justify-content-center">
                    <div class="form-group mb-4 col-md-6">
                        <button id="lo" class="btn btn-default col-8 mt-2" type="button">
                            Logout
                        </button>
                    </div>
                </form>

                <br>
                <br>

                <div id="information-good">

                </div>

                <div id="information-bad">

                </div>
            </div>

            <div class="loggedout invisible">You need to be logedin to view this page!</div>

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

</div>