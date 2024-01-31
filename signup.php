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
    // Retrieve user input
    $select = mysqli_query($conn, "SELECT `name` FROM `users` WHERE `name` = '".$_POST['name']."'") or exit(mysqli_error($conn));
    if(mysqli_num_rows($select)) {
        exit('This username is already being used');
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        exit('Invalid email address');
    }

    $select = mysqli_query($conn, "SELECT `email` FROM `users` WHERE `email` = '".$_POST['email']."'") or exit(mysqli_error($conn));
    if(mysqli_num_rows($select)) {
        exit('This email is already being used');
    }

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $fitplan = $_POST['fitplan'];   
    $gender = $_POST['gender'];   

    // Validate input from form
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if ($password < 8) {
        $errors[] = "8 Characters is required for the password!";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (name, email, password, fitplan, gender) VALUES ('$name', '$email', '$hashedPassword', '$fitplan', '$gender')";
        mysqli_query($conn, $query);
        
        setcookie($cookie_name, true, time() + (86400 * 30), "/"); // 1 day

        // Redirect to a success page or login page
        header("location: login.php");
        exit();
    }
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
  <title>Sign Up Page</title>

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

    function setCookie(cname, cvalue, exdays) {
      const d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      let expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function reviewCookies(option){
      if (option == "true"){
        setCookie("loggedIn", true, 350)
        alert("Cookie has been set successfully! This is only a debug message.");
        const element = document.getElementById('cookies');
        element.style.display = 'none';
        element.style.visibility = 'hidden';
      } else {
        setCookie("loggedIn", false, 350)
        alert("Cookie has been set successfully! This is only a debug message.");
        const element = document.getElementById('cookies');
        element.style.display = 'none';
        element.style.visibility = 'hidden';
      }
    }

    function getCookie(cname) {
      let name = cname + "=";
      let ca = document.cookie.split(';');
      for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    function checkCookie() {
      let savedLogin = getCookie("loggedIn");
      if (savedLogin == "true") {
        window.addEventListener('load', function(){
          alert("Cookies are enabled for this user");
          const element = document.getElementById('cookies');
          element.style.display = 'none';
          element.style.visibility = 'hidden';
        })
      } else if (savedLogin == "false") {
        window.addEventListener('load', function(){
          alert("Cookies are disabled for this user")
          const element = document.getElementById('cookies');
          element.style.display = 'none';
          element.style.visibility = 'hidden';
        })
      } else {
        alert("Cookies have not yet been set for this user")
      }
    }

    function showEcho(str) { // causing the issues, investigate issue with function later
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
        return str;
    }

checkCookie();

</script>

<div>
    <form  class="form1" method="POST" action="">
    
    <input id="textInput" for="text" type="text" name="name" placeholder="Username (ExampleIronMan)" value="<?php echo $name; ?>">
    <input id="textInput" for="text" type="password" name="password" placeholder="Password (Example!asw!1rd13!!)" value="<?php echo $password; ?>">
    <input id="textInput" for="text" type="text" name="email" placeholder="Email (example@example.com)" value="<?php echo $email; ?>">

    <label for="users"></label>

    <select name="gender" id="users">
      <option value="">Gender Selection</option>
      <option value="male">Male</option>
      <option value="female">Female</option>
      <option value="other">Other</option>
    </select>
    <select name="fitplan" id="users">
      <option value="">Plan Selection</option>
      <option value="basic">Basic</option>
      <option value="elite">Elite</option>
    </select>

    <button type="submit" name="register">Sign Up</button>
    <button type="submit" name="login">Login</button>
  </form>
  <div>

<div>
  <h1></h1>
</div>

<div id="cookies">
  <form class="form2">
  <label for="users">This website uses cookies to enhance your experience!</label>
  <button type="button" onclick="reviewCookies('true')">Accept</button>
  <button type="button" onclick="reviewCookies('false')">Decline</button>
</form>
</div>

</body>
</html>
