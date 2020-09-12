<?php
include('db.php');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Content-Type: application/json');
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

if (isset($_GET['check'])) {

  if ($_GET['check'] == true) {
  $url = "https://apithings.ddidev.xyz/stats";
  $ch = curl_init();
  curl_setopt_array($ch, array (
  CURLOPT_URL =>  $url,
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
      echo 0;
      exit();
    }
    $current = $stats['currentDJ']['id'];
    $time = strtotime("-1 hour");
    $stmt = $conn->prepare("SELECT * FROM likes WHERE ip = :ip AND times > :time AND dj = :dj");
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':dj', $current);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count == 0) {
      echo 0;
      exit();
    } else {
      echo 1;
      exit();
    }
  }

}

}

if (isset($_GET['count'])) {

if ($_GET['count'] == true) {
  $url = "https://apithings.ddidev.xyz/stats";
  $ch = curl_init();
curl_setopt_array($ch, array (
  CURLOPT_URL =>  $url,
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
      echo 0;
      exit();
    }
    $current = $stats['currentDJ']['id'];
    $time = strtotime("-1 hour");
    $stmt = $conn->prepare("SELECT * FROM likes WHERE times > :time AND dj = :dj");
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':dj', $current);
    $stmt->execute();
    $count = $stmt->rowCount();
    echo $count;
    exit();
  }

}

}

if (!isset($_GET['count']) || !isset($_GET['check'])) {


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
  echo 'error';
}
if ($stats['success'] == true) {
  if ($stats['currentDJ']['autoDJ'] == true) {
    echo 'auto dj';
    exit();
  }
  $current = $stats['currentDJ']['id'];
  $time = strtotime("-1 hour");
  $timer = round(microtime(true) * 1000);
  $stmt = $conn->prepare("SELECT * FROM likes WHERE ip = :ip AND times > :time AND dj = :dj");
  $stmt->bindParam(':ip', $ip);
  $stmt->bindParam(':time', $time);
  $stmt->bindParam(':dj', $current);
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count == 0) {
    $stmt = $conn->prepare("INSERT INTO likes (ip, times, dj) VALUES (:ip, :times, :dj)");
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':times', $timer);
    $stmt->bindParam(':dj', $current);
    $stmt->execute();
    echo 1;
    exit();
  } else {
    echo 0;
    exit();
  }
}

}

 ?>
