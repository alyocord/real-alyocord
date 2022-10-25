<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
  session_destroy();
  echo "<script>window.location.href = \"//alyocord.com/login/\"</script>";
}

if (isset($_POST['logout'])) {
  session_destroy();
  echo "<script>window.location.href = \"//alyocord.com/login/\"</script>";
} 

$db = new PDO('sqlite:../database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="//cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="//alyocord.com/style.css">
  <link rel='icon' type='image/x-icon' href='//alyocord.com/cdn-1/favicon.ico'>
  <script src='//alyocord.com/jquery-3.6.1.js'></script>
  <script src='./script.js'></script>
  <title>Alyocord</title>
</head>
<body>
</body>
  <style>
    body {
      background: #202221;
      color: white;
    } 
  </style>

  <div id='alert' style='display:none;'><nav style='background:#0f0645;'><center><button style='border-style:solid;border-color:white;background:none;border-radius:5%;color:white;' onclick='window.location.href = "//alyocord.com/chat/turbo/claim/";'>Claim Turbo </button>&nbsp &nbsp &nbsp<button onclick='$("#alert").empty();' style='background:none;border:none;color:red;'>X</button></center></nav></div>
  <?php
    if (isset($_SESSION['loggedin'])) {
      $uslm = $db->prepare("SELECT * FROM users WHERE id=:uid");
      $uslm->bindValue(":uid", $_SESSION['user']['userid']);
      $uslm->execute();
      $usr = $uslm->fetch();
      $uslm->closeCursor();
      $lastTurbo = null;
      $pfp = $usr['pfp'];
      $_SESSION['user']['pfp'] = $usr['pfp'];
      $_SESSION['user']['turbolast'] = $usr['turbolast'];
      $lastTurbo = $usr['turbolast'];
      if ($lastTurbo == 0 || time() - $lastTurbo >= 2630000) {
        $_SESSION['user']['turbo'] = false;
      } else {
        $_SESSION['user']['turbo'] = true;
      }
  
      if ($_SESSION['user']['userid'] == null) {
        session_destroy();
        echo "<script>window.location.href = '//alyocord.com/login/';</script>";
      }
    }

    if (isset($_SESSION['admin']) && $_SESSION['user']['turbo'] == false) {
      echo "<script>$(\"#alert\").css('display', 'block')</script>";
    }
  ?>
  <div id='channel-name' style='background:transparent;'>
    <h4 class='gc-text'><b>Global Chat</b> <l style='color:#636060;'>(messages: <?php 
    $res = $db->exec(
                "CREATE TABLE IF NOT EXISTS messages (
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  content VARCHAR(4000),
                  userid INT,
                  room VARCHAR(50),
                  time INTEGER
                )"
              );
  
    if (isset($_POST['chat'])) {
        $message = $_POST['message'];
        $message = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $message);
      
        $message = str_replace("<:skull>", '💀', $message);
        $message = str_replace("<:party>", '🥳', $message);
        $message = str_replace("<:fire>", '🔥', $message);
        $message = str_replace("<:gift>", '🎁', $message);
        $message = str_replace("<:shocked>", '😱', $message);
        $message = str_replace("<:star>", '✨', $message);
        $message = str_replace("<:cry>", '😭', $message);
        $message = str_replace("<:rich>", '🤑', $message);
        $message = str_replace("<:blush>", '😳', $message);
      
        if (preg_replace('/\s+/', '', $message) != '') {
          if ($_SESSION['user']['turbo'] == false) {
            if (!(mb_strlen($message) > 2000)) {
              try {
                if ($_SESSION['user']['userid'] == null) {
                  session_destroy();
                  echo "<script>window.location.href = '//alyocord.com/login/';</script>";
                }
                
                $stmt = $db->prepare("INSERT INTO messages (userid, content, room) VALUES(:userid, :content, :room)");
                $stmt->bindValue(":userid", $_SESSION['user']['userid']);
                $message = preg_replace('#\*{2}(.*?)\*{2}#', '<strong>$1</strong>', htmlspecialchars($message));
                
                $message = preg_replace('#\*(.*?)\*#', '<i>$1</i>', htmlspecialchars($message));
                $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i'; 
                $message = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $message);
                $stmt->bindValue(":content", $message);
                $stmt->bindValue(":room", "global");
                $stmt->execute();
                $stmt->closeCursor();
              } catch (PDOException $ex) {
                echo "<p class='c-r'>".$ex->getMessage()."</p>";
              }
          } else {
            echo "<script>alert(\"You can't send messages longer than 2000 characters!\");</script>";
          }
        } else {
            if (!(mb_strlen($message) > 4000)) {
              try {
                if ($_SESSION['user']['userid'] == null) {
                  session_destroy();
                  echo "<script>window.location.href = '//alyocord.com/login/';</script>";
                }
                
                $stmt = $db->prepare("INSERT INTO messages (userid, content, room) VALUES(:userid, :content, :room)");
                $stmt->bindValue(":userid", $_SESSION['user']['userid']);
                $message = preg_replace('#\*{2}(.*?)\*{2}#', '<strong>$1</strong>', htmlspecialchars($message));
                $message = preg_replace('#\*(.*?)\*#', '<i>$1</i>', $message);
                $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i'; 
                $message = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $message);
                $message = str_replace(htmlspecialchars("<:susface>"), "<img src='//cdn.discordapp.com/emojis/1030796433508540506.webp?size=44&amp;quality=lossless' alt='<:susface>'", $message);
                $stmt->bindValue(":content", $message);
                $stmt->bindValue(":room", "global");
                $stmt->execute();
                $stmt->closeCursor();
              } catch (PDOException $ex) {
                echo "<p class='c-r'>".$ex->getMessage()."</p>";
              }
          } else {
            echo "<script>alert(\"You can't send messages longer than 4000 characters!\");</script>";
          }
        }
      }
    }
  
    $sql = "SELECT count(*) FROM messages"; 
    $result = $db->prepare($sql); 
    $result->execute(); 
    $rows = $result->fetchColumn(); 
    $result->closeCursor();
    echo $rows;
    ?>)</l></h4></div>
  <div id='messages'>
    <?php
      try {
        $res = $db->exec(
            "CREATE TABLE IF NOT EXISTS messages (
              id INTEGER PRIMARY KEY AUTOINCREMENT,
              content VARCHAR(4000),
              userid INT,
              room VARCHAR(50)
            )"
        );
        
        if (isset($_SESSION['admin'])) {
          if (isset($_POST['delete'])) {
            $messageid = $_POST['delete'];
            $stmt = $db->prepare("DELETE FROM messages WHERE id=:msgid");
            $stmt->bindValue(":msgid", $messageid);
            $stmt->execute();
          }
        }
        
        if (isset($_POST['delown'])) {
            $messageid = $_POST['delown'];
            $msguid = $_POST['delownuid'];
            if ($msguid == $_SESSION['user']['userid']) {
              $stmt = $db->prepare("DELETE FROM messages WHERE id=:msgid");
              $stmt->bindValue(":msgid", $messageid);
              $stmt->execute();
            }
          }
      } catch (PDOException $ex) {
        echo "<p class='c-r'>".$ex->getMessage()."</p>";
      }

        if ($_SESSION['user']['userid'] == null) {
          session_destroy();
          echo "<script>window.location.href = '//alyocord.com/login/';</script>";
        }
        

        if (!isset($_POST['loadmsg'])) {
          $limit = 50;
        } else {
          $limit = $_POST['loadmsg'];
        }
        
        $messa = $db->query("SELECT COUNT(*) FROM messages WHERE room = 'global'");
        $rows = $messa->fetchColumn();
        $rws = $rows - $limit;
       
        $messages = $db->query("SELECT * FROM messages WHERE room = 'global' LIMIT $rws, $limit");
      $lastId = null;
      foreach ($messages as $msg) {
        $st = $db->query("SELECT * FROM users WHERE id='".$msg['userid']."';");
        $msguser = "Deleted User";
        $msgpfp = "default.png";
        $trbo = null;
        $namid = 0000;
        foreach ($st as $usnm) {
          include($_SERVER['DOCUMENT_ROOT'].'/site.php');
          if (in_array($usnm['id'], $owners)) {
            $msguser = "<l class='c-g'>" . $usnm['username'] . "</l>";
          } elseif(in_array($usnm['id'], $cowners)) {
            $msguser = "<l style='color:orange;'>" . $usnm['username'] . "</l>";
          } elseif (in_array($usnm['id'], $admins) == true) {
            $msguser = "<l class='c-r'>" . $usnm['username'] . "</l>";
          } else {
            $msguser = $usnm['username'];
          }
          $msgpfp = $usnm['pfp'];
          $namid = $usnm['nameid'];
          if (!(time() - intval($usnm['turbolast']) >= 2630000)) {
            $trbo = "&nbsp <img src='//media.discordapp.net/attachments/1028244276590686218/1030940228514480228/turbo.png' height='20' width='20'>";
          }
        }

        $nid = sprintf('%04d', $namid);

        if ($lastid == null || $lastid != $msg['userid']) {


          $lastid = $msg['userid'];
            if (!isset($_SESSION['admin'])) {
              if ($msg['userid'] != $_SESSION['user']['userid']) {
                echo "<br><div id='".$msg['id']."' class='msg'><img class='pfp' src='../cdn-2/pfp/$msgpfp' height='50' width='50'>&nbsp $msguser  &nbsp  &nbsp<span style='color:color: #747678;'>#$nid</span> ".$trbo." <br><p style='display:inline;'>".$msg['content']."</p></div>";
              } else {
               echo "<br><div id='".$msg['id']."' class='msg'><img class='pfp' src='../cdn-2/pfp/$msgpfp' height='50' width='50'>&nbsp $msguser  &nbsp  &nbsp<span style='color:color: #747678;'>#$nid</span> ".$trbo." <br><p style='display:inline;'>".$msg['content']."</p> &nbsp &nbsp <button onclick='deleteB".$msg['id'].", ".$msg['userid'].")' style='background:none;border:none;' id='delete' type='button'><img id='delete-i' class='delm' src='../cdn-1/deletecan.png' width='25' height='25'></button></div>";
              }
            } else {
              echo "<br><div id='".$msg['id']."' class='msg'><img class='pfp' src='../cdn-2/pfp/$msgpfp' height='50' width='50'>&nbsp $msguser &nbsp  &nbsp<span style='color:color: #747678;'>#$nid</span> ".$trbo." <br><p style='display:inline;'>".$msg['content']."</p> &nbsp &nbsp <button onclick='deleteA(".$msg['id'].")' style='background:none;border:none;' id='delete' type='button'><img id='delete-i' class='delm' src='../cdn-1/deletecan.png' width='25' height='25'></button></div>";
            }


          
          } else {
          $lastid = $msg['userid'];
          if (!isset($_SESSION['admin'])) {
            if ($msg['userid'] != $_SESSION['user']['userid']) {
              echo "<div id='".$msg['id']."' class='msg'>" . $msg['content'] . "</div>";
              } else {
                echo "<div id='".$msg['id']."' class='msg'>" . $msg['content'] . "<button onclick='deleteB(".$msg['id'].", ".$msg['userid'].")' style='background:none;border:none;' id='delete' type='button'><img id='delete-i' class='delm' src='../cdn-1/deletecan.png' width='25' height='25'></button></div>";
              }
            } else {
              echo "<div id='".$msg['id']."' class='msg'>" . $msg['content'] . "<button onclick='deleteA(".$msg['id'].")' style='background:none;border:none;' id='delete' type='button'><img id='delete-i' class='delm' src='../cdn-1/deletecan.png' width='25' height='25'></button></div>";
            }
          }
        }
      $db = null;
    ?>
<br>
  </div>
  <script>
    var objDiv = document.getElementById("messages");
    objDiv.scrollTop = objDiv.scrollHeight;
  </script>
  <input type='hidden' id='msg-ownr' value='<?php echo $_SESSION['user']['username']; ?>'>
  <input type='hidden' id='msg-ownr-pfp' value='<?php echo $_SESSION['user']['pfp']; ?>'>
  
  <input type='text' name='message' class='message-content' placeholder = 'Type something...' onkeyup="filter()" id='message' autocomplete="off">
  <button onclick="chat()" class='button send-message' id='chat'>Send</button>

  <form method='post'>
    <button type='submit' style='background:none;border:none;' name='logout'><img src='//cdn0.iconfinder.com/data/icons/thin-line-color-2/21/05_1-512.png' height='25' width='25' id='logout'></button>
  </form>

  <button style='background:transparent;border:none;' onclick='theme()' id='theme-trigger'><img src='//cdn1.iconfinder.com/data/icons/user-interface-16x16-vol-1/16/contrast-circle-512.png' height='20' width='20'></button>

  <button style='background:transparent;border:none;' onclick="location.href = '//alyocord.com/chat/settings/';"><img src='//media.discordapp.net/attachments/1027560810962235392/1029375797825380362/unknown.png' height='25' width='25' id='settings'></button>

<button style='background:transparent;border:none;' onclick="location.href = '//alyocord.com/chat/turbo/';"><img src='//media.discordapp.net/attachments/1028244276590686218/1030940228514480228/turbo.png' height='25' width='25' id='turbo-man'></button>
</body>
</html>