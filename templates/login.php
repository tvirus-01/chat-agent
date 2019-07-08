<div class="row no-gutter">
  <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
  <div class="col-md-8 col-lg-6">
    <div class="login d-flex align-items-center py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-9 col-lg-8 mx-auto">
            <h3 class="login-heading mb-4">Welcome back!</h3>
            <form action="modules/signin.php" method="post" class="login-form">
              <div class="form-label-group">
                <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail">User Name</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>
              <button class="btn btn-lg btn-primary btn-block btn-login login-submit text-uppercase font-weight-bold mb-2" type="submit">Sign in</button>
              <div class="row mt-2 mb-3">
                <div class="col">
                  <span class="text-danger"><?php
                    if (isset($_GET['error'])) {
                      $error = $_GET['error'];
                      if ($error == 91) {
                        echo "!Incorrect username or password";
                      }else{
                        echo "don't be a kid";
                      }
                    }
                  ?></span>
                </div>
              </div>
              <div class="row text-center">
                <div class="col">
                  <a class="small float-left" href="#">Create new account</a>
                  <a class="small float-right" href="#">Forgot password?</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>