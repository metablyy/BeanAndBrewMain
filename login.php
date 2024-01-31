<?php
session_start();
include "connection.php";

// Variables
$name = '';
$email = '';
$password = '';
$fitplan = '';
$gender = '';
$errors = [];

$cookie_name = 'loggedIn';

// Registration of user
if (isset($_POST['register'])) {
    header("location: index.php");
}
elseif (isset($_POST["login"])) {
  echo "Login button is working";

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];

  $query = "SELECT $username, $password FROM users WHERE username=:username";
  header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>

</head>
<body>

<script>
    function showUser(str) {
        if (str=="") {
            document.getElementById("txtHint").innerHTML="";
            return;
        }
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
            document.getElementById("txtHint").innerHTML=this.responseText;
            }
        }
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }

    function showEcho(str) {
        if (str=="") {
            document.getElementById("txtHint").innerHTML="";
            return;
        }
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
            document.getElementById("txtHint").innerHTML=this.responseText;
            }
        }
        echo str
    }
</script>



<ul id="horizontal">
    <li><a href="login.php">Home</a></li>
    <li><a href="news.asp">Sign Up</a></li>
    <li><a href="about.asp">About</a></li>
</ul>

<div class="flex-container">
  <div>1</div>
  <div>2</div>
  <div>3</div>
</div>

<div>

    <form  class="form1" method="POST" action="">
    
    <label id="pageLabel" for="users">Login Form!</label>
    
    <input id="textInput" for="text" type="text" name="name" placeholder="Username" value="<?php echo $name; ?>">
    <input id="textInput" for="text" type="password" name="password" placeholder="Password" value="<?php echo $password; ?>">

    <label for="users"></label>
    <button type="submit" name="register">Sign Up</button>
    <button type="submit" name="login">Login</button>
  </form>
  <div>
</div>

</body>
</html>
