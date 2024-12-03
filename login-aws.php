   

<?php
include "db_connect.php";
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $user_type = ($_POST['user_type'] == 'employers') ? 1 : 0; // 1 for employers, 0 for candidates
  $remember_me = isset($_POST['remember_me']); // Check if the checkbox was checked

  // Prepare the query to check email, password, and role
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password AND role = :role");
  $stmt->execute([
    'email' => $email,
    'password' => md5($password), // Assuming password is stored as MD5
    'role' => $user_type
  ]);

  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['first_name'] = $user['first_name'];

    // Set cookies if "Remember Me" is checked


    
    if ($remember_me) {
      setcookie("login_email", $email, time() + (30 * 24 * 60 * 60), "/"); // 30 days
      setcookie("login_user_type", $user_type, time() + (30 * 24 * 60 * 60), "/"); // 30 days
    } else {
      // Clear cookies if "Remember Me" is not checked
      setcookie("login_email", "", time() - 3600, "/");
      setcookie("login_user_type", "", time() - 3600, "/");
    }

    // Redirect based on role (candidate or employer)
    if ($user['role'] == 1) {
      header("Location: recruiter_dashboard.php");
    } else {
      header("Location: dashboard.php");
    }
    exit();
  } else {
    echo "Invalid credentials or user type.";
  }
}
?>


</head>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function () {
      const email = getCookie("login_email");
      const userType = getCookie("login_user_type");

      if (email && userType) {
        $("#email").val(decodeURIComponent(email));  // Decode the email
        $("#user-type").val(userType == 1 ? "employers" : "customer");
        $("#remember-me").prop("checked", true);
      }

      function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
      }
    });
  </script>
</head>


<body class="d-flex justify-content-center align-items-center bg-light vh-100">
  <section class="card shadow-lg p-4" style="max-width: 600px;">
    <img src="assets/img/icon/login.png" alt="Hero Image" class="img-fluid mb-4 rounded"
      style="width: 350px; height: auto;">

    <div class="card-body">
      <h2 class="card-title text-primary text-center mb-4">Login</h2>
      <form id="login-form" action="login.php" method="post">

        <div class="mb-3">
          <label for="user-type" class="form-label">Select User Type:</label>
          <select id="user-type" name="user_type" class="form-select" required>
            <option value="customer">Candidate</option>
            <option value="employers">Employers</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label"><i class="fa fa-envelope me-2"></i>Email</label>
          <input id="email" class="form-control" type="text" placeholder="E-mail" name="email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label"><i class="fa fa-key me-2"></i>Password</label>
          <input id="password" class="form-control" type="password" placeholder="Password" name="password" required>
        </div>

 <div class="form-check mb-3">
          <input type="checkbox" id="remember-me" name="remember_me" class="form-check-input">
          <label for="remember-me" class="form-check-label">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>

        <p class="text-center">Are you new to SKILL CONNECT?</p>
        <button type="button" class="btn btn-success w-100"
          onclick="window.location.href='register.php'">Signup</button>
      </form>

      <hr>


<a href="https://github.com/login/oauth/authorize?client_id=Ov23liOnO6vm8ZU69Rh8&redirect_uri=http://skillconnect.webhop.me/github-callback.php&scope=user:email">
    <button class="btn btn-dark w-100 mt-3 d-flex justify-content-center align-items-center">
        <i class="fa fa-github me-2"></i> Login with GitHub
    </button>
</a>


    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>


</html>