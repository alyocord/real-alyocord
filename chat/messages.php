<?php
session_start();

$db = new PDO('sqlite:../database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
          unset($_SESSION);
          echo "<script>window.location.href = '//alyocord.com/login/';</script>";
        }
        

        if (!isset($_GET['limit'])) {
          $limit = 5;
        } else {
          $limit = $_GET['limit'];
        }

        if (!isset($_GET['channel'])) {
          $channel = "global";
        } else {
          $channel = $_GET['channel'];
        }
        
        $messa = $db->query("SELECT COUNT(*) FROM messages WHERE room = '$channel'");
        $rows = $messa->fetchColumn();
        $rws = $rows - $limit;
       
        $messages = $db->query("SELECT * FROM messages WHERE room = '$channel' LIMIT $rws, $limit");
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
                echo "<br><div id='".$msg['id']."' class='msg'><img class='pfp' src='../cdn-2/pfp/$msgpfp' height='50' width='50'>&nbsp $msguser  &nbsp  &nbsp<span style='color:color: #747678;'>#$nid</span> ".$trbo." <br><p style='display:inline;'><span class='msg'>".$msg['content']."</span></p></div>";
              } else {
               echo "<br><div id='".$msg['id']."' class='msg'><img class='pfp' src='../cdn-2/pfp/$msgpfp' height='50' width='50'>&nbsp $msguser &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp  &nbsp <button onclick='deleteB(".$msg['id'].", ".$msg['userid'].")' style='background:none;border:none;' id='delete' type='button'><img id='delete-i' class='delm' src='../cdn-1/deletecan.png' width='25' height='25'></button> <span style='color:color: #747678;'>#$nid</span> ".$trbo." <br><p style='display:inline;'><span class='msg'>".$msg['content']."</span></p></div>";
              }
            } else {
              echo "<br><div id='".$msg['id']."' class='msg'><img class='pfp' src='../cdn-2/pfp/$msgpfp' height='50' width='50'>&nbsp $msguser &nbsp  &nbsp<span style='color:color: #747678;'>#$nid</span> ".$trbo." &nbsp &nbsp &nbsp &nbsp &nbsp <button onclick='deleteA(".$msg['id'].")' style='background:none;border:none;' id='delete' type='button'><img id='delete-i' class='delm' src='../cdn-1/deletecan.png' width='25' height='25'></button> <br><span class='msg'>".$msg['content']."</span> &nbsp &nbsp</div>";
            }


          
          } else {
          $lastid = $msg['userid'];
          if (!isset($_SESSION['admin'])) {
            if ($msg['userid'] != $_SESSION['user']['userid']) {
              echo "<div id='".$msg['id']."' class='msg'><span class='msg'>".$msg['content']."</span></div>";
              } else {
                echo "<div id='".$msg['id']."' class='msg'><span class='msg'>".$msg['content']."</span>&nbsp &nbsp &nbsp &nbsp &nbsp<button onclick='deleteB(".$msg['id'].", ".$msg['userid'].")' style='background:none;border:none;' id='delete' type='button'><img id='delete-i' class='delm' src='../cdn-1/deletecan.png' width='25' height='25'></button></div>";
              }
            } else {
              echo "<div id='".$msg['id']."' class='msg'><span class='msg'>".$msg['content']."</span>&nbsp &nbsp &nbsp &nbsp &nbsp<button onclick='deleteA(".$msg['id'].")' style='background:none;border:none;' id='delete' type='button'><img id='delete-i' class='delm' src='../cdn-1/deletecan.png' width='25' height='25'></button></div>";
            }
          }
        }
      $db = null;
?>