<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>PixelCraft</title>
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-login-form.min.css" />
  <style>
.bgimg 
    {
      background-image: url('assets/images/login_request/cover.png');
      
      min-height: 100vh;
      
      background-position: center;
      background-attachment: fixed;
      background-size: cover;
    }
</style>
  <script>
    // Basic validation for password
    function validatePassword() {
      const password = document.getElementById("password").value;
      const errorMessage = document.getElementById("password_error");
      if (password.length < 6) {
        errorMessage.textContent = "Password must be at least 6 characters long.";
      } else {
        errorMessage.textContent = "";
      }
    }

    function validateUsername() {
      const username = document.getElementById("username").value;
      const usernameError = document.getElementById("username_error");
      if (username.length < 3) {
        usernameError.textContent = "Username must be at least 3 characters long.";
      } else {
        usernameError.textContent = "";
      }
    }

    function domain_nameValidator() {
      const email = document.getElementById("form2Example17").value;
      const emailError = document.getElementById("email_error");
      const domainPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
      if (!domainPattern.test(email)) {
        emailError.textContent = "Please enter a valid email address.";
      } else {
        emailError.textContent = "";
      }
    }
  </script>
</head>

<body>
<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="assets/images/login_request/signup_img.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
                  <form method="post" id="signup_form" action="signup_process.php">
                    <div class="d-flex justify-content-center">
                      <img class="mb-4" src="assets/images/login_request/small_logo.png" alt="" height="45">
                    </div>
                    <h6 style="text-transform: uppercase; color: grey;" class="mt-2 mb-1"><b>Join With Us</b></h6>
                    <?php if(isset($_GET['error_message'])){ ?>
                      <p id="error_message" class="text-center alert-danger"><?php echo $_GET['error_message'];?></p>
                    <?php }?>
                    <?php if(isset($_GET['sucess_message'])){ ?>
                      <p id="sucess_message" class="text-center alert-success"><?php echo $_GET['sucess_message'];?></p>
                    <?php }?>

                    <!-- Username Input with validation -->
                    <div class="form-outline mb-3">
                      <input type="text" id="username" class="form-control form-control-lg" name="username" onchange="validateUsername();" required />
                      <label class="form-label" for="username">Username</label>
                      <small id="username_error" class="text-danger"></small>
                    </div>

                    <!-- First Name Input -->
                    <div class="form-outline mb-3">
                      <input type="text" id="full_name" class="form-control form-control-lg" name="full_name" required />
                      <label class="form-label" for="full_name">Full Name</label>
                    </div>


                    <!-- Email Input with validation -->
                    <div class="form-outline mb-3">
                      <input type="email" id="form2Example17" class="form-control form-control-lg" name="email" onchange="domain_nameValidator();" required />
                      <label class="form-label" for="form2Example17">Email address</label>
                      <small id="email_error" class="text-danger"></small>
                    </div>

                    <!-- Password Input with validation -->
                    <div class="form-outline mb-3">
                      <input type="password" id="password" class="form-control form-control-lg" name="password" onchange="validatePassword();" required />
                      <label class="form-label" for="password">Password</label>
                      <small id="password_error" class="text-danger"></small>
                    </div>

                    <div class="pt-1 mb-4 mt-2">
                      <button class="btn btn-dark btn-lg btn-block" type="submit" name="signup_btn">SIGNUP</button>
                    </div>

                    <p class="mb-4 pb-lg-2" style="color: #19afd4;">Have an account? <a href="login.php" style="color: #2696ca;">SignIn</a></p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script type="text/javascript" src="assets/js/mdb.min.js"></script>
</body>
</html>
