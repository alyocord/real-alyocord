<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="//cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="//alyocord.com/style.css">
  <script src='//alyocord.com/script.js'></script>
  <link rel='icon' type='image/x-icon' href='//cdn.alyocord.com/cdn-1/favicon.ico'>
  <title>Login | Alyocord</title>
</head>
<body>
  <center>
    <br> <img src='//cdn.alyocord.com/cdn-1/favicon.ico' height='75' width='75'> <br>
    <h1>Alyocord</h1>
    <br><br>
    <button class='button' onclick='window.location.href = "//alyocord.com/app/";'>Home</button> <br> <br>
    <button class='button' onclick='history.back();'>Back</button> <br> <br> <br> <br>
    <div class='signup'>
      <form method='post'>
        <p>Email:</p>
        <input type='email' name='email' required>
        <p>Password:</p>
        <input type='password' name='password' required> <br> <br>
        <input type='submit' name='submit'>
      </form>
      <?php
        if (isset($_POST['submit'])) {
          $email = $_POST['email'];
          $password = $_POST['password'];
            if (!empty($email)) {
              if (!empty($password)) { 
                $db = new PDO('sqlite:../database.sqlite');
                $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                $sql = "SELECT * FROM users WHERE email = :email";
                include($_SERVER['DOCUMENT_ROOT'].'/site.php');
                try {
                    $statement = $db->prepare($sql);
                    $statement->bindValue(":email", $email);
                    $statement->execute();
                    $row = $statement->fetch();
                    $er = $row['email'];
                    if ($er == $email) {
                      if (password_verify($password, $row['password']) == true) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['user']['username'] = $row['username'];
                        $_SESSION['user']['userid'] = $row['id'];
                        $_SESSION['user']['email'] = $row['email'];
                        $_SESSION['user']['pfp'] = $row['pfp'];
                        $_SESSION['user']['turbolast'] = $row['turbolast'];
                        if (in_array($row['id'], $admins) == true) {
                          $_SESSION['admin'] = true;
                        } else {
                          unset($_SESSION['admin']);
                        }
                        if (!(time() - $row['turbolast'] >= 2630000)) {
                          $_SESSION['turbo'] = true;
                        } else {
                          $_SESSION['turbo'] = false;
                        }
                        echo "<p style='color: green;'>Successfully logged in as ".$row['username']."</p>";
                        echo "<p class='c-g'>Click <a href='//alyocord.com/app/'>here</a> to go to the main page.</p>";
                      } else {
                        echo "<p style='color: red;'>Invalid password</p>";
                      }
                    } else {
                      echo "<p style='color: red;'>Invalid email</p>";
                    }       
                }
                catch(PDOException $e) {
                    echo "<p style='color: red;'>".$e->getMessage()."</p>";
                }
              } else {
                echo "<p style='color: red;'>Password must not be empty!</p>";
              }
            } else {
              echo "<p style='color: red;'>Email must not be empty!</p>";
            }
          }

          if (isset($_GET['del']) == true && !(isset($_POST['submit']))) {
            echo "<p style='color: red;'>Your account was deleted or you were logged out.</p>";
          }
      ?>
    </div>
  </center>
</body>
</html>