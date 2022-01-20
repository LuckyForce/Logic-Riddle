<script src="<?= $site ?>files/js/signup.js" type="module"></script>
<div class="bg-dark-purple">

  <br>
  <div class="header-title">
    <h1>Sign up</h1>
  </div>
  <br>
  <br>
  <br>

  <div class="row m-0">
    <div class="col-sm-3"></div>
    <div class="col-sm-6 mb-2">
      <div class="card text-center bg-dark-grey purple">
        <form id="signup-form" class="loggedout was-validated p-1 invisible">
          <div class="row justify-content-center">
            <div class="form-group col-md-6 mb-2 mt-4">
              <label for="email">E-Mail-Address:</label>
              <input type="text" class="form-control border" id="email" placeholder="E-Mail" />
              <div class="invalid-feedback">Invalid or already in use E-Mail-Address!</div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="form-group col-md-6 mb-2">
              <label for="password">Password:</label>
              <input type="password" class="form-control border" id="password" placeholder="Password" />
              <div class="invalid-feedback">Password has to be atleast 8 characters long!</div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="form-group col-md-6 mb-3">
              <label for="username">Username:</label>
              <input type="text" class="form-control border" id="username" placeholder="Username" />
              <div class="invalid-feedback">
                Username has to be atleast 8 characters long with a maximum of 16 or is already in use!
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="form-group col-md-6 mb-3">
              <input type="checkbox" id="consent" name="consent" />
              <label for="consent">
                I hereby agree that my account data will be stored exclusively for the use of this project. All data remains private, except for the username, in case you create riddles or decide to comment under one.
              </label>
              <div class="invalid-feedback">Has to be accepted!</div>
            </div>
          </div>
          <div class="form-group mb-4">
            <button id="ca" class="btn btn-default col-8 mt-2" type="button">
              Create account
            </button>
          </div>
        </form>
        <div id="verify" class="invisible p-1">
          <div class="row justify-content-center">
            <div class="form-group col-md-6 mb-3">
              <label for="code">6-Digit Verification Code:</label>
              <input type="number" class="form-control border" id="code" placeholder="Code" />
              <div class="invalid-feedback">
                Code is wrong!
              </div>
            </div>
          </div>
          <div class="form-group mb-4">
            <button id="resendCode" class="btn btn-default col-8 mt-2" type="button">
              Resend Verification Code
            </button>
          </div>
        </div>
        <div id="success" class="invisible">
          Looks like you successfully signed up! You can now proceed to our homepage and even exlore further!
        </div>
        <div class="loggedin invisible">
          You are already loged in!
        </div>
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