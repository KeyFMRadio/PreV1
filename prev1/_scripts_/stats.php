<?php
error_reporting(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include('db.php');
header("Access-Control-Allow-Origin: *");
if (isset($_GET['specific'])) {
  if ($_GET['specific'] == "past5") {
    $stmt = $conn->prepare("SELECT * FROM song_log WHERE title != 'KeyFM' AND artist != 'KeyFM' AND artist != 'KeyFM_' ORDER BY id DESC LIMIT 5 OFFSET 1");
    $stmt->execute();
    $songs = array();
    foreach($stmt as $row) {
      $title = $row['artist'] . ' - ' . $row['title'];
      array_push($songs, $title);
    }
    echo json_encode($songs);
  } else if ($_GET['specific'] == "nextUp") {
    date_default_timezone_set('Europe/London');
    $djs = array();
    $date = date( 'N' ) - 1;
    $today_date = $date;
    $next_date = $date;
    $later_date = $date;

    $now_hour = date( 'H' ) ;
    $next_hour = date('H') + 1;
    $later_hour = $next_hour + 1;
    if ($next_hour == "24") {
      if ($date == 6) {
        $newDay = 0;
      } else {
        $newDay = $date + 1;
      }
      $next_date = $newDay;
      $next_hour = 0;
      $later_date = $newDay;
      $later_hour = 1;
    }
    if ($later_hour == "24") {
      if ($date == 6) {
        $newDay = 0;
      } else {
        $newDay = $date + 1;
      }
      $later_date = $newDay;
      $later_hour = 0;
    }
    $stmt = $conn->prepare("SELECT * FROM timetable WHERE day = :day AND timestart = :hour ORDER BY id");
    $stmt->bindParam(':day', $today_date, PDO::PARAM_INT);
    $stmt->bindParam(':hour', $now_hour, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $bookedUser = $row['booked'];
    if ($bookedUser != '0') {
      $stmt = $conn->prepare("SELECT * FROM users WHERE id = '$bookedUser'");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $dj_now->name = $row['username'];
      $dj_now->img = "https://staff.keyfm.net/profilePictures/" . $row['avatarURL'];
      array_push($djs, $dj_now);
    } else {
      if (!isset($dj_now)) $dj_now = new stdClass();
      $dj_now->name = "Auto DJ";
      $dj_now->img = 'assets/images/square.png';
      array_push($djs, $dj_now);
    }
    $stmt = $conn->prepare("SELECT * FROM timetable WHERE day = :day AND timestart = :hour ORDER BY id");
    $stmt->bindParam(':day', $next_date, PDO::PARAM_INT);
    $stmt->bindParam(':hour', $next_hour, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $bookedUser = $row['booked'];
    if ($bookedUser != '0') {
      $stmt = $conn->prepare("SELECT * FROM users WHERE id = '$bookedUser'");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $dj_next->name = $row['username'];
      $dj_next->img = "https://staff.keyfm.net/profilePictures/" . $row['avatarURL'];
      array_push($djs, $dj_next);
    } else {
      if (!isset($dj_next)) $dj_next = new stdClass();
      $dj_next->name = "Auto DJ";
      $dj_next->img = 'assets/images/square.png';
      array_push($djs, $dj_next);
    }
    $stmt = $conn->prepare("SELECT * FROM timetable WHERE day = :day AND timestart = :hour ORDER BY id");
    $stmt->bindParam(':day', $later_date, PDO::PARAM_INT);
    $stmt->bindParam(':hour', $later_hour, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $bookedUser = $row['booked'];
    if ($bookedUser != '0') {
      $stmt = $conn->prepare("SELECT * FROM users WHERE id = '$bookedUser'");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $dj_later->name = $row['username'];
      $dj_later->img = "https://staff.keyfm.net/profilePictures/" . $row['avatarURL'];
      array_push($djs, $dj_later);
    } else {
      if (!isset($dj_later)) $dj_later = new stdClass();
      $dj_later->name = "Auto DJ";
      $dj_later->img = 'assets/images/square.png';
      array_push($djs, $dj_later);
    }
    echo json_encode($djs);
  }
} else {
  $url = "https://apithings.ddidev.xyz/stats";
  $ch = curl_init();
  curl_setopt_array($ch, array (
    CURLOPT_URL =>  $url,
    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
    CURLOPT_ENCODING => '',
    CURLOPT_TCP_FASTOPEN => 1,
    CURLOPT_RETURNTRANSFER => 1,
  ));
  $result = curl_exec($ch);
  curl_close($ch);
  $stats = json_decode($result, true);
  if ($result == false) {
    echo 0;
    exit();
  }
  if ($stats['success'] == true) {
    if ($stats['currentDJ']['autoDJ'] == true) {
      if ($stats['playing']['error'] == true) {
        $artist = "Error";
        $song = "Error";
      } else {
        $artist = $stats['playing']['artist'];
        $song = $stats['playing']['song'];
      }

      if (!isset($export)) $export = new stdClass();

      $export->autoDJ = true;
      $export->now_playing = $artist . " - " . $song;
      $stmt = $conn->prepare("SELECT * FROM global WHERE setting = 'autoDJ_says'");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row['value'] == "" || $row['value'] == null) {
        $export->djSays = "none";
      } else {
        $export->djSays = filter_var($row['value'], FILTER_SANITIZE_STRING);
      }
      $final = json_encode($export);
      echo $final;
    } else {
      if ($stats['playing']['error'] == true) {
        $artist = "Error";
        $song = "Error";
      } else {
        $artist = $stats['playing']['artist'];
        $song = $stats['playing']['song'];
      }
      $export->autoDJ = false;
      $export->now_playing = $artist . " - " . $song;
      $id = $stats['currentDJ']['id'];
      $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $icon = '<span class="cTooltip"><i class="fal fa-microphone-alt"></i><b title="Radio DJ"></b></span>';
      if ($row['permRole'] == '2') {
        $icon = '<span class="cTooltip"><i class="fal fa-eye"></i><b title="Senior Staff"></b></span>';
      }
      if ($row['permRole'] == '3') {
        $icon = '<span class="cTooltip"><i class="fal fa-cog"></i><b title="Manager"></b></span>';
      }
      if ($row['permRole'] == '4') {
        $icon = '<span class="cTooltip"><i class="fal fa-key"></i><b title="Administrator"></b></span>';
      }
      if ($row['permRole'] == '5') {
        $icon = '<span class="cTooltip"><i class="fal fa-briefcase"></i><b title="Executive"></b></span>';
      }
      if ($row['permRole'] == '6') {
        $icon = '<span class="cTooltip"><i class="fal fa-money-check"></i><b title="Owner"></b></span>';
      }
      $export->dj->name = $icon . "  " .$row['username'];
      $export->dj->id = $id;
      if ($row['djSays'] == "" || $row['djSays'] == null) {
        $export->dj->djSays = "none";
      } else {
        $export->dj->djSays = filter_var($row['djSays'], FILTER_SANITIZE_STRING);
      }
      $export->dj->avatar = "https://staff.keyfm.net/profilePictures/" . $row['avatarURL'];
      if ($stats['currentDJ']['id'] == 0) {
        $export->dj->name = "Setup Wrong";
        $export->dj->id = 0;
        $export->dj->avatar = './assets/images/square.png';
      }
      $final = json_encode($export);
      echo $final;
    }
  } else {
    echo 0;
  }
}
 ?>
