<?php
session_start();

if (isset($_SESSION['loggedin'])) {
  header("Location: //alyocord.com/app/");
} 
?>

<!--

============
CHAT
============
Albi: 
============
Yokiro:
============
Alex: 
============
Matan: 
============
Xav: hi aimee
============
Trickz: 
============
Aimee: hi
============

-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="xavsanims.css">
  <link rel='icon' type='image/x-icon' href='//cdn.alyocord.com/cdn-1/favicon.ico'>
  <script src='//alyocord.com/script.js'></script>
  <title>Alyocord</title>
  <script src="/node_modules/intersection-observer/intersection-observer.js"></script>
  <script defer src="anims.js"></script>
</head>
<body>
  <center>
    <br> <img src='//cdn.alyocord.com/cdn-1/favicon.ico' height='75' width='75'> <br>
    <h1>Alyocord</h1>
    <button class='button' onclick='window.location.href = "//alyocord.com/app/"'>I'm sold! Give me the app already!</button> <br>
    <br>
    <section class="hidden">
      <h1>Great community</h1>
      <p>Our community is super kind and helpful!</p>
    </section>
    <section class="hidden">
      <h1>Helpful staff</h1>
      <p>Feel free to contact our staff if you have any issues.</p>
    </section>
    <section class="hidden">
      <h1>Little to no lag</h1>
      <p>Read your messages the second they are sent!</p>
    </section>
    <section class="hidden">
      <h1>Clean UI</h1>
      <p>Super clean and responsive UI.</p>
    </section>
  </center>
</body>
</html>