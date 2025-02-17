<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db = 'job_portal';
$user = 'root';
$password = '';

try {
  $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phone_number = $_POST['phone_number'];
  $address = $_POST['address'];
  $gender = $_POST['gender'];
  $role = ($_POST['user_type'] == 'owner') ? 1 : 0;


  $hashed_password = md5($password);


  $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone_number, address, gender, role, about, profile_picture, website_url, testimonial) 
  VALUES (:first_name, :last_name, :email, :password, :phone_number, :address, :gender, :role, '', '', '', '')");

  $result = $stmt->execute([
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'password' => $hashed_password,
    'phone_number' => $phone_number,
    'address' => $address,
    'gender' => $gender,
    'role' => $role
  ]);


  if ($result) {
    echo "Registration successful!";

    header("Location: login.php");
  } else {
    echo "Failed to register.";
  }
}
?>
<!DOCTYPE html>
<html>

<head>


  <!-- OG Meta Tags -->
  <meta property="og:title" content="Registration Page - Skill Connect | Your Trusted Job Portal in Bangladesh." />
  <meta property="og:description" content="Registration page for our job portal. Register using correct information. Start finding
  your next career opportunity today in Bangladesh." />
  <meta property="og:image" content="/assets/img/hero/register.jpg" />

  <?php
  if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $baseUrl = "http://localhost/Skill_Connect_Project";
  } else {
    $baseUrl = "https://skillconnect.webhop.me";
  }
  ?>
  <meta property=" og:url" content="<?= htmlspecialchars($baseUrl); ?>/register.php" />
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="Skill Connect" />



  <title>Signup Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<br>
<br>


<body
  style="font-family: Arial, sans-serif; background-image: url('assets/img/icon/login.png'); background-size: cover; background-position: center; background-repeat: no-repeat; margin: 0; padding: 0;">
  <section class="hero" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="container"
      style="background: rgba(255, 255, 255, 0.8); padding: 30px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); max-width: 400px; width: 100%;">
      <div class="form-container">
        <h2 style="text-align: center; color: #333333; margin-bottom: 20px;">Registration</h2>
        <form id="signup-form" action="register.php" method="POST">

          <!-- User Type Selection -->
          <div class="form-group" style="margin-bottom: 15px;">
            <label for="user-type" style="display: block; color: #333333; margin-bottom: 5px;">Select User Type:</label>
            <select id="user-type" name="user_type" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
              <option value="customer">Candidate</option>
              <option value="owner">Employer</option>
            </select>
          </div>


          <!-- Other form fields -->
          <div class="form-group" style="margin-bottom: 15px;">
            <label><i class="fa fa-user"></i></label>
            <input class="name" type="text" placeholder="First Name" name="first_name" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </div>
          <div class="form-group" style="margin-bottom: 15px;">
            <label><i class="fa fa-user"></i></label>
            <input class="name" type="text" placeholder="Last Name" name="last_name" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </div>
          <div class="form-group" style="margin-bottom: 15px;">
            <label><i class="fa fa-envelope"></i></label>
            <input class="email" type="email" placeholder="E-mail" name="email" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </div>
          <div class="form-group" style="margin-bottom: 15px;">
            <label><i class="fa fa-phone"></i></label>
            <input class="phone" type="text" placeholder="Phone" name="phone_number" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </div>
          <div class="form-group" style="margin-bottom: 15px;">
            <label><i class="fa fa-address-card"></i></label>
            <input class="address" type="text" placeholder="Address" name="address" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </div>

          <!-- Gender Selection -->
          <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; color: #333333; margin-bottom: 5px;">Gender</label>
            <label style="margin-right: 10px;"><i class="fa fa-male"></i></label>
            <input class="gender" type="radio" name="gender" value="male" required> Male
            <label style="margin-left: 20px;"><i class="fa fa-female"></i></label>
            <input class="gender" type="radio" name="gender" value="female" required> Female
          </div>

          <!-- Password Input -->
          <div class="form-group" style="margin-bottom: 20px;">
            <label><i class="fa fa-key"></i></label>
            <input class="password" type="password" placeholder="Password" name="password" required
              style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
          </div>

          <button
            style="background: #4CAF50; color: #ffffff; padding: 10px 15px; border: none; border-radius: 5px; width: 100%; cursor: pointer;">
            <input type="submit" value="Sign Up"
              style="background: none; border: none; color: white; width: 100%; cursor: pointer; font-size: 16px;">
          </button>
          <br>
          <br>

          <p style="text-align: center"> Already Registered???</p>


          <a href="login.php"
            style="display: inline-block; background: #4CAF50; color: #ffffff; padding: 10px 15px; border-radius: 5px; text-decoration: none; text-align: center; width: 100%; box-sizing: border-box;">Sign
            In now!!</a>

          <br>

        </form>
      </div>
    </div>

    <section id="customer-data"></section>
  </section>

</body>


</html>