<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Register</title>
    <link rel="shortcut icon" href="assets/images/logo/logo.png" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
  </head>
  <body>
    <div class="app">
      <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('assets/images/others/login-3.png')">
        <div class="d-flex flex-column justify-content-between w-100">
          <div class="container d-flex h-100">
            <div class="row align-items-center w-100">
              <div class="col-md-7 col-lg-5 m-h-auto">
                <div class="card shadow-lg">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between m-b-30">
                      <img class="img-fluid" alt="" src="assets/images/logo/logo-h.png" />
                    </div>
                    <div class="mx-auto">
                      <h4 class="text-center">Register</h4>
                    </div>
                    <?php
                    session_start();
                    if (isset($_SESSION['error_message'])) {
                      echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
                      unset($_SESSION['error_message']);
                    }
                    ?>
                    <form method="POST" action="controller/register_controller.php">
                      <div class="form-group">
                        <label class="font-weight-semibold" for="userName">Username:</label>
                        <div class="input-affix">
                          <i class="prefix-icon anticon anticon-user"></i>
                          <input name="username" type="text" class="form-control" id="userName" placeholder="Username" required />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-semibold" for="email">Email:</label>
                        <div class="input-affix">
                          <i class="prefix-icon anticon anticon-mail"></i>
                          <input name="email" type="email" class="form-control" id="email" placeholder="Email" required />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-semibold" for="password">Password:</label>
                        <div class="input-affix m-b-10">
                          <i class="prefix-icon anticon anticon-lock"></i>
                          <input name="password" type="password" class="form-control" id="password" placeholder="Password" required />
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="font-size-13 text-muted">
                            Sudah punya akun?
                            <a class="small" href="login.php">Sign in</a>
                          </span>
                          <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/js/vendors.min.js"></script>
    <script src="assets/js/app.min.js"></script>
  </body>
</html>
