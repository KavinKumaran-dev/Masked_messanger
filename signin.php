<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            display:flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
        }
        form{
            display: flex;
            flex-direction: column;
            max-width: 40vh;
        }
        .error {
            color: red;
        }
        .links{
            text-decoration: none;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>Signin-Form</title>
</head>
<body>
<?php
$name = $email = $password = "";
$nameErr = $emailErr = $passErr = $pass1Err = "";
$emailValid = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["name"])){
        $nameErr = " Name is Required";
    }
    else{
        if(!preg_match("/^[a-zA-Z-' ]*$/",test($_POST["name"]))){
            $nameErr = "Only letters and Spaces are allowed!";
        }
        else{
        $name = test($_POST["name"]);
        }
    }
    if(empty($_POST["email"])){
        $emailErr = " Email is Required";
    }
    else{
        if(!filter_var(test($_POST["email"]),FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid Email format";
        }
        else{
            $emailValid = true;
        $email = test($_POST["email"]);
        }
    }
    if(empty($_POST["password"])){
        $passErr = "Password Field Required";
    }
    else{
        $pass = trim($_POST["password"]);
        $pass = htmlspecialchars($pass);
        $conn = mysqli_connect("localhost", "root", "", "chatapp3");
         
        // Check connection
        if($conn == false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $sql1 = "SELECT * FROM user";
        $check = true;
        $res = $conn->query($sql1);
        $res1 = $conn->query($sql1);
        $mail = "";
        $users = array();
        while($row1 = $res1->fetch_assoc()){
            $users[$row1['user_name']] = $row1['user_id'];
         }
        while($row = $res->fetch_assoc()){
            if($email == $row['user_email'] && $pass == $row['password']){
              echo "Successfully Logged In..." ;
              $mail = true;
              session_start();
                $_SESSION['username'] = $row['user_name'];
                $_SESSION['user_id'] = $email;
                $_SESSION['id'] = $row['user_id'];
                $_SESSION['users'] = $users;
                header("Location: landing-page.php");
                exit();
            }
            else if($pass != $row['password'] && $email == $row['user_email']){
               $passErr = "Incorrect Password";
               $mail = true;
               break;
            }
        }
        if($mail == false){
            $emailErr = "Invalid Email Address";
        }
    }
}
function test($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<div class="container mt-3">
<h2>Welcome to ChatRockz Signin!</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="mb-3 mt-3">
  <label for="email" class="form-label">Email:</label>
  <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
  <span class="error">* <?php echo $emailErr;?></span>
  </div>


  <div class="mb-3">
  <label for="password2">Password: </label>
  <input placeholder = "Enter Password"class="form-control" id = "password2" type = "password" name = "password">
  <span class="error">* <?php echo $passErr;?></span>
  </div>
  <div class="form-check mb-3">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember"> I agree
      </label>
    </div>
    <div class="mb-3">
    <label for="show"><button class="form-control" id = "show" type = "button" onclick="showPassword()">Show Password</button></label>
    </div>
    <div class="mb-3">
  <input class = "btn btn-primary" type="submit" name="submit" value="submit">
    </div>
  <a class = "links" href="login.php">Don't Have an account?</a>
</div>
</form>
</div>
<script>
        function showPassword() {
            let passwordField = document.querySelectorAll("#password2");
            if (passwordField[0].type === "password") {
        passwordField[0].type = "text";
    } else {
        passwordField[0].type = "password";
    }
        }
    </script>
</body>
</html>