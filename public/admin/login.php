<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تسجيل الدخول</title>

<style>
body {
  display:flex;
  justify-content:center;
  align-items:center;
  height:100vh;
  background:#f5f5f5;
  font-family:Arial;
}

.login-box {
  background:#fff;
  padding:30px;
  border-radius:15px;
  width:300px;
  text-align:center;
}

input {
  width:100%;
  padding:10px;
  margin:10px 0;
}

button {
  width:100%;
  padding:10px;
  background:gold;
  border:none;
  cursor:pointer;
}
</style>
</head>

<body>

<div class="login-box">
  <h2>Admin Login</h2>

  <form method="POST">
    <input type="text" name="user" placeholder="Username">
    <input type="password" name="pass" placeholder="Password">
    <button>Login</button>
  </form>

  <?php
  if(isset($_POST['user'])){
    if($_POST['user']=="admin" && $_POST['pass']=="1234"){
      $_SESSION['admin'] = true;
      header("Location: index.php");
    } else {
      echo "<p style='color:red'>خطأ في المعلومات</p>";
    }
  }
  ?>
</div>

</body>
</html>