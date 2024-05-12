<?php
  if (isset($_POST["submit"])) {
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $password = htmlentities(strip_tags(trim($_POST["password"])));

    $error_message = "";

    if (empty($username)) {
      $error_message .= "- Username belum diisi <br>";
    }

    if (empty($password)) {
      $error_message .= "- Password belum diisi <br>";
    }

    include("connection.php");

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $password_sha1 = sha1($password);

    $query = "
      SELECT * FROM admin 
      WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) == 0 )  {
      $error_message .= "- Username dan/atau Password tidak sesuai";
    }

    mysqli_free_result($result);
    mysqli_close($connection);

    if ($error_message === "") {
      session_start();
      $_SESSION["username"] = $username;
      header("Location: student_view.php");
    }
  }
  else {
    $error_message = "";
    $username = "";
    $password = "";
  }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Mahasiswa</title>
  <link rel="stylesheet" href="assets/login.css">

  <style>
    *{
      padding: 0;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      box-sizing: border-box;
      background-color: #4566a1;
    }

    h1{
      font-size: -webkit-xxx-large;
      display: inline-flex;
      justify-content: center;
      width: 100%;
      color: aliceblue;
      padding: 10px;
    }

    h2{
      display: flex;
      color: aliceblue;
      margin-bottom: 20px;
    }

    fieldset{
      padding: 60px 90px;
    }
    
    fieldset label{
      color: aliceblue;
      display: flex;
      font-size: 15px;
    }

    form .input{
      margin-top: 20px;
      color: aliceblue;
    }
    


  </style>



</head>
<body>
  <div class="container">
    <h1>Data Mahasiswa</h1>
    <?php
      if ($error_message !== "")
        echo "<div class='error'>$error_message</div>";
    ?>
    <form action="login.php" method="post">
      <fieldset>
        <h2>Login Form</h2>
        <p style="margin-bottom: 9px">
          <label for="username">Username : </label>
          <input type="text" name="username" id="username" value="<?php echo $username ?>" style="width: 25%;">
        </p>
        <p>
          <label for="password">Password  : </label>
          <input type="password" name="password" id="password" value="<?php echo $username ?>" style="width: 25%;">
        </p>
        <p class="input">
        <input type="submit" name="submit" value="Log In" style="padding: 5px 20px; background-color: aliceblue; color: #4566a1; font-weight: 900;">

        </p>
      </fieldset>
    </form>
  </div>
</body>
</html>