<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
  header("Location: //alyocord.com/login/");
}

date_default_timezone_set("UTC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="//cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  
  <link rel="stylesheet" href="//alyocord.com/style.css">
  <script src='//alyocord.com/jquery-3.6.1.js'></script>
  <script src='//alyocord.com/script.js'></script>
  <link rel='icon' type='image/x-icon' href='//alyocord.com/cdn-1/favicon.ico'>
  <title>Alyocord Turbo</title>
</head>
<body>
  <center><h1 id="AlyocordTurboFont">Alyocord <span id="pink">Turbo</span></h1> 
    <br>
    <img src='//media.discordapp.net/attachments/1028244276590686218/1030940228514480228/turbo.png' height='200' width='200'>
  <br>
  <h3>Get Alyocord Turbo and Unlock Special Perks!</h3>
  <br><br>
  <button class='button' onclick='window.location.href = "//alyocord.com/chat/";'>Chat</button> <br> <br>
  <button class='button' onclick='history.back();'>Back</button> <br> <br> <br> <br>
    <br>
    <h3>Send messages longer than 2,000 characters! (4,000)</h3>
    <h3>Change your tag! (e.g. FunWithAlbi#0001)</h3>
<br><br>

  <div id='alerting'>
    <!-- getenv('SECRET'); -->
  </div>
<?php
if ($_SESSION['turbo'] == false) {
?>
<div id="paypal-button-container-P-2EM018023U217283LMNEDWUY"></div>
<script src="https://www.paypal.com/sdk/js?client-id=ARwR-Lq8vGU6GfmPeVPWp8DENBfBz8Y2dQO-SCfnczoWPmn0kKXoTnmIVSudnUnPZWHrAkgwgKpxCMlI&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<script>
  paypal.Buttons({
      style: {
          shape: 'pill',
          color: 'blue',
          layout: 'vertical',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          plan_id: 'P-2EM018023U217283LMNEDWUY' // Do **NOT** change this, EVER, unless you are switching from Sandbox to Production. This changes where and how much people are charged, and is the difference between getting the payment or being scammed.
        });
      },
      onApprove: function(data, actions) {
        $("#alerting").append("<p class='c-g'>Successfully bought Alyocord Turbo for 1 month <br> your subscription ID is "+data.subscriptionID+"</p><form method='post'><button class='button' type='submit' name='submit'>Activate</button></form><br><br>");
      } // We should add yearly or lifetime subs, but that's for the future..
  }).render('#paypal-button-container-P-2EM018023U217283LMNEDWUY');
</script>
<?php
}
?>
  <br><br><br>
  <?php
    if ($_SESSION['turbo'] == true) {
      $db = new PDO('sqlite:../../database.sqlite');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $qr = $db->prepare("SELECT * FROM users WHERE id=:uid");
      $qr->bindValue(":uid", $_SESSION['user']['userid']);
      $qr->execute();
      $row = $qr->fetch();
      $trls = intval($row['turbolast']);
      $qr->closeCursor(); 
      // 
      echo "<h2 class='c-g'>You currently have turbo!</h2><h2 style='color:red;'>Expiring at <br><strong>".gmdate("d/m/y h:i A \U\T\C", $trls + 2630000)."</strong></h2>";
    }
  ?>
</body>
</html>