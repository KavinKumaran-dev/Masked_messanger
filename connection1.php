<?php
$conn = mysqli_connect("localhost", "root", "", "chatapp3");
         
// Check connection
if($conn == false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Taking all 5 values from the form data(input)
 
// Performing insert query execution
// here our table name is college
$sql = "INSERT INTO user (user_name,user_email,password) VALUES ('$name','$email','$pass')";
$sql1 = "SELECT * FROM user";
$check = true;
$id = "";
$res = $conn->query($sql1);
$res1 = $conn->query($sql1);
$users = array();
while($row = $res->fetch_assoc()){
    if($email == $row['user_email']){
       $check = false;
       break;
    }
}
if($check){
if(mysqli_query($conn, $sql)){
    while($row1 = $res1->fetch_assoc()){
        $users[$row1['user_name']] = $row1['user_id'];
     }
    echo "<h3>Successfully Logged In...</h3>";
    session_start();
    $_SESSION['username'] = $name;
    $_SESSION['user_id'] = $email;
    $_SESSION['users'] = $users;
        $query = "SELECT user_id FROM user WHERE user_email = '$email'";
        $result = mysqli_query($conn, $query);


        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
        }
    $_SESSION['id'] = $user_id;
    header("Location: landing-page.php");
    exit();
} else{
    echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
}
}
else{
    $emailErr = "Email Already Exists!";
}
?>
