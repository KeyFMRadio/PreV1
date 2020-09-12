<?php
include('db.php');
$stmt = $conn->prepare("SELECT * FROM blocked_ips ORDER BY id");
$stmt->execute();
$allow = true;
foreach($stmt as $row) {
  if ($ip == $row['ip']) {
    $allow = false;
  }
}
if ($allow == false) {
  header("Location: ../banned.php");
  exit();
}
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Europe/London');
$date = date('m/d/Y h:i:s a');
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
if ($_GET['form'] == "application") {
  $stmt = $conn->prepare("SELECT * FROM applications WHERE ip = :ip AND status != 2 AND status != 3");
  $stmt->bindParam(':ip', $ip);
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count !== 0) {
    echo "duplicate";
    exit();
  }
  $name = $_POST['name'];
  $age = $_POST['age'];
  $discord = $_POST['disc'];
  $region = $_POST['region'];
  $roleName = $_POST['role'];
  $role = null;
  $micName = $_POST['microphone'];
  $mic = null;
  $workName = $_POST['radio'];
  $work = null;
  $why = $_POST['why'];
  if ($region !== "NA" && $region !== "EU" && $region !== "OC") {
    echo "error 1";
    exit();
  }
  if ($roleName == "Radio DJ") {
    $role = 0;
  }
  if ($roleName == "News Reporter") {
    $role = 1;
  }
  if ($roleName == "Media Producer") {
    $role = 2;
  }
    if ($roleName == "Graphics Designer") {
    $role = 3;
  }
  if ($role !== 0 && $role !== 1 && $role !== 2 && $role !== 3) {
    echo "error 2";
    exit();
  }
  if ($micName == "No") {
    $mic = 0;
  }
  if ($micName == "Yes") {
    $mic = 1;
  }
  if ($mic == null) {
    echo "error 3";
    exit();
  }
  if ($workName == "No") {
    $work = 0;
  }
  if ($workName == "Yes") {
    $work = 1;
  }
  if ($work !== 0 && $work !== 1) {
    echo "error 4";
    exit();
  }
  $stmt = $conn->prepare("INSERT INTO applications (name, age, discord, region, role, mic, work, why, ip, times) VALUES (:name, :age, :discord, :region, :role, :mic, :work, :why, :ip, :times)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':age', $age);
  $stmt->bindParam(':discord', $discord);
  $stmt->bindParam(':region', $region);
  $stmt->bindParam(':role', $role);
  $stmt->bindParam(':mic', $mic);
  $stmt->bindParam(':work', $work);
  $stmt->bindParam(':why', $why);
  $stmt->bindParam(':ip', $ip);
  $stmt->bindParam(':times', $date);
  $stmt->execute();
  $url = "https://keybot.ddidev.xyz/api/keyfm/newForm";
  $fields = [
      'api' => "q1tbDYr9M4rCDM5Nos09Wrg7UlKpSunv9WM3BG9V9N5qeVE",
      'username' => $name,
      'type'=> 0
  ];

  $fields_string = http_build_query($fields);

  $ch = curl_init();

  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
  echo "sent";
}
if ($_GET['form'] == "contact") {
  $name = $_POST['name'];
  $topic = $_POST['topic'];
  $methodName = $_POST['method'];
  $method = null;
  $details = $_POST['details'];
  $message = $_POST['message'];
  if ($methodName == "Discord") {
    $method = 0;
  }
  if ($methodName == "Email") {
    $method = 1;
  }
  if ($methodName == "Skype") {
    $method = 2;
  }
  if ($method !== 0 && $method !== 1 && $method !== 2) {
    echo "error 1";
    exit();
  }
  $stmt = $conn->prepare("INSERT INTO contact (name, topic, responseMethod, responseDetails, message, times, ip) VALUES (:name, :topic, :responseM, :responseD, :message, :times, :ip)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':topic', $topic);
  $stmt->bindParam(':responseM', $method);
  $stmt->bindParam(':responseD', $details);
  $stmt->bindParam(':message', $message);
  $stmt->bindParam(':ip', $ip);
  $stmt->bindParam(':times', $date);
  $stmt->execute();
  $url = "https://keybot.ddidev.xyz/api/keyfm/newForm";
  $fields = [
      'api' => "q1tbDYr9M4rCDM5Nos09Wrg7UlKpSunv9WM3BG9V9N5qeVE",
      'username' => $name,
      'type'=> 1
  ];

  $fields_string = http_build_query($fields);

  $ch = curl_init();

  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
  
  echo "sent";
}
if ($_GET['form'] == "request") {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  $name = $_POST['name'];
  $typeName = $_POST['type'];
  $type = null;
  $artist = $_POST['artist'];
  $song = $_POST['songName'];
  $message = $_POST['message'];
  $verifiedType = $_POST['verified'];
//  $verifiedType = $_POST['verified'];
  if ($typeName == "Song Request") {
    $type = 0;
  }
  if ($typeName == "Shoutout") {
    $type = 1;
  }
  if ($verifiedType == true) {
    $verified = 1;
  } else {
    $verified = 0;
  }

  if ($type !== 0 && $type !== 1) {
    echo "Invalid Type, Please use 'Song Request' OR 'Shoutout'";
    exit();
  }
  if ($name == null || $name == "") {
    echo "missing: name";
    exit();
  }
  if ($message == null || $message == "") {
    echo "missing: message";
    exit();
  }
  $url = "https://apithings.ddidev.xyz/stats";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  $result = curl_exec($ch);
  curl_close($ch);
  $stats = json_decode($result, true);
  if ($result == false) {
    echo "Could not grab stats";
  }
  if ($stats['success'] == true) {
    if ($stats['currentDJ']['autoDJ'] == true) {
      $dj = 0;
    } else {
      $dj = $stats['currentDJ']['id'];
    }
  } else {
    echo "Could not grab stats";
  }
  if ($type == 0) {
    $stmt = $conn->prepare("INSERT INTO requests (dj, name, type, artist, song, message, times, ip, deleted, verified) VALUES (:dj, :name, 0, :artist, :song, :message, :times, :ip, 0, :verified)");
    $stmt->bindParam(':dj', $dj);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':artist', $artist);
    $stmt->bindParam(':song', $song);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':times', $date);
    $stmt->bindParam(':verified', $verified);
    $stmt->execute();
    echo "sent";
  } else {
    $stmt = $conn->prepare("INSERT INTO requests (dj, name, artist, song, type, message, times, ip, deleted, verified) VALUES (:dj, :name, '', '', 1, :message, :times, :ip, 0, :verified)");
    $stmt->bindParam(':dj', $dj);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':times', $date);
    $stmt->bindParam(':verified', $verified);
    $stmt->execute();
    echo "sent";
  }
}
