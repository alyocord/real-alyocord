<?php
session_start();

if (!(isset($_SESSION['admin']))) {
  header('HTTP/1.0 403 Forbidden');
  die();
}
?>

<link href="//cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link rel="stylesheet" href="//alyocord.com/style.css">
<script src='//alyocord.com/script.js'></script>
<link rel='icon' type='image/x-icon' href='//cdn.alyocord.com/cdn-1/favicon.ico'>
<center>
  <br>
  <button class='button' onclick='window.location.href = "//alyocord.com/";'>Home</button> <br> <br>
</center>
<?php
  try {
    $db = new PDO('sqlite:../database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    $res = $db->exec(
      "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        username VARCHAR(255), 
        email VARCHAR(255),
        password VARCHAR(255),
        pfp VARCHAR(255),
        turbolast INTEGER,
        nameid INTEGER,
        timesturbo INTEGER
      )"
    );
    if (isset($_POST['delete'])) {
      $stmt = $db->prepare(
      "DELETE FROM users WHERE id=".$_POST['delete'].";"
      );
      $stmt->execute();
    }
    $users = $db->query("SELECT * FROM users ORDER BY id DESC");
    $db = null;
  } catch (PDOException $ex) {
    echo $ex->getMessage();
  }
  ?>
    <html>
  <head>
    <title>Users | Alyocord</title>
  </head>
  <body>
    <center>
      <h1>Users</h1> <br>
      <?php foreach ($users as $user) { 
        echo '<p>';
          echo '<h4>' . $user['username'] . '</h4>';
          echo "Email: ".$user['email'] . "<br>";
          echo "<br>ID: ".$user['id'] . "<br>";
          echo "<form method='post'><button type='submit' name='delete' value='".$user['id']."'>Delete</button></form><br>";
      } ?>
    <center>
  </body>
</html>