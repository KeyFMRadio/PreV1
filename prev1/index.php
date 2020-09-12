<?php
include('_scripts_/db.php');
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $ip = $_SERVER['REMOTE_ADDR'];
}
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>KeyFM - Pre V1</title>
  <link rel="shortcut icon" href="assets/images/favicon.svg" />

  <!-- Meta Things -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="application-name" content="KeyFM" />
  <meta name="description" content="KeyFM is an online radio station which brings together friends and family to listen to some of the hottest tunes happening now.">

  <meta name="og:title" content="KeyFM">
  <meta property="og:image" content="https://keyfm.net/comingsoon/assets/images/default.png">
  <meta property="og:type" content="website">
  <meta property="og:author" content="KeyFM">
  <meta property="og:description" content="KeyFM is an online radio station which brings together friends and family to listen to some of the hottest tunes happening now.">

  <meta name="twitter:title" content="KeyFM">
  <meta name="twitter:image" content="https://keyfm.net/comingsoon/assets/images/default.png">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:description" content="KeyFM is an online radio station which brings together friends and family to listen to some of the hottest tunes happening now.">

  <meta name="msapplication-TileColor" content="#0085FF" />
  <meta name="msapplication-TileImage" content="https://keyfm.net/comingsoon/assets/images/default.png">
  <meta name="theme-color" content="#0085FF">

  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-177851353-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-177851353-1');
 </script>

  <!-- Vendor CSS -->
  <link href="assets/css/all.css" rel="stylesheet">
  <link href="assets/css/pnotify.custom.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Jaldi:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/styles.css?<?php echo round(microtime(true) * 1000) ?>">
  <link rel="stylesheet" title="dev" href="assets/css/working.css">
</head>

<body>
  <div class="row body">
    <div class="col-md-3 col-sm-12 playerContainer">
      <div style="margin-top: 250px" class="navbuttons">
        <div style="color: orange; font-size: 34px;" class="meettheteam">
          <i class="fas fa-users"></i>
        </div>
      </div>
      <div style="margin-top: 50px" id="player" class="paused">
        <div id="top" class="paused">
          <div id="says">
            <div class="stat">
              <div class="marquee moving">
                <span></span>
              </div>
            </div>
            <div class="carrot"></div>
          </div>
        </div>
        <a href="Key.Home" class="web-page"  id="profileLink"><div class="profilePicture">
          <img draggable="false" id="profileImg" src="assets/images/square.png" onerror="this.src='assets/images/square.png'"></img>
          <div class="paused" id="dj">
            <p></p>
          </div>
        </div></a>
        <div class="buttons">
          <div id="likeButton" class="paused">
            <i id="like" class="fal fa-heart"></i>
            <p id="likeCount" style="font-size: 14px; margin-top: -8px;">0</p>
          </div>
          <div id="playButton">
            <i id="control" class="fal fa-play"></i>
          </div>
          <div id="requestButton" class="paused">
            <span url="_modals_/request.php" id="requestLine" data-toggle="loadModal"><i id="request" class="fal fa-comment-dots"></i></span>
          </div>
        </div>
        <div id="below" class="paused">
          <div class="slider">
            <input id="volume" min="0.01" max="1.0" step="0.01" type="range" ondrag="" value="0.5">
          </div>
          <div class="stats">
            <div class="songStat">
              <i class="far fa-music"></i>
              <div class="stat" id="song">
                  <div class="marquee">
                    <span></span>
                  </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 col-sm-12 pageCol">
      <div class="contentArea">
        <div class="content-wrapper" id="content">

        </div>
        <div id="loader">
          <i class="fal fa-spinner-third fa-spin"></i>
        </div>
      </div>
    </div>
  </div>

  <audio id="radio" src="https://radio.keyfm.net" autoplay>Your browser does not support HTML5 audio</audio>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/urlRouting.js"></script>
  <script src="assets/js/pnotify.js"></script>
  <script>
    urlRoute
      .folderUrl('/prev1')
      .setPreviousCode('Key.Home')
      .setBaseUrl('https://didyouknow.ivanisafuckingnonce.gq/prev1')
      .checkCurrent('https://didyouknow.ivanisafuckingnonce.gq/prev1');
  </script>
  <i id="tempHeart" style="display: none;" class="fas fa-heart"></i>
</body>

</html>
