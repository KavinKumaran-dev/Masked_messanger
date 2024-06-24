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
    <title>SignUp-Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
$name = $email = $password = "";
$nameErr = $emailErr = $passErr = $pass1Err = "";
$namevalid = $emailValid = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["name"])){
        $nameErr = " Name is Required";
    }
    else{
        if(!preg_match("/^[a-zA-Z-' ]*$/",test($_POST["name"]))){
            $nameErr = "Only letters and Spaces are allowed!";
        }
        else{
            $namevalid = true;
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
        if(empty($_POST["password1"])){
            $pass1Err = "Password Field Required";
        }
        else{
            if($_POST["password"] != $_POST["password1"]){
                $pass1Err = "Above Password does'nt Match";
            }
            else{
                if($namevalid && $emailValid){
                $pass = trim($_POST["password1"]);
                $pass = htmlspecialchars($pass);
                include 'connection1.php';
                }
            }
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
<h2>PHP Form Validation Example</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="mb-3 mt-3">
  <label for="name">Username: </label> <input class="form-control" placeholder = "Enter Username" id = "name" type="text" name="name">
  <span class="error">* <?php echo $nameErr;?></span>
  </div>
  <div class="mb-3">
  <label for="email" class="form-label">Email:</label>
  <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
  <span class="error">* <?php echo $emailErr;?></span>
  </div>


  <div class="mb-3">
  <label for="password2">Password: </label>
  <input placeholder = "Enter Password"class="form-control" id = "password2" type = "password" name = "password">
  <span class="error">* <?php echo $passErr;?></span>
  </div>


  <div class="mb-3">
  <label for="password2">Confirm Password:</label>
  <input placeholder = "Confirm password" class="form-control" id = "password2" type = "password" name = "password1">
  <span class="error">* <?php echo $pass1Err;?></span>
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
  <a class = "links" href="signin.php">Already Have an account?</a>
</div>
</form>
</div>
<script>
        function showPassword() {
            let passwordField = document.querySelectorAll("#password2");
            if (passwordField[0].type === "password" && passwordField[1].type === "password") {
        passwordField[0].type = "text";
        passwordField[1].type = "text";
    } else {
        passwordField[0].type = "password";
        passwordField[1].type = "password";
    }
        }
    </script>
</body>
</html>
