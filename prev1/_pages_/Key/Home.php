<?php
include('../../_scripts_/db.php');
$stmt = $conn->prepare("SELECT * FROM banners ORDER BY id");
$stmt->execute();
$stmt2 = $conn->prepare("SELECT * FROM banners ORDER BY id");
$stmt2->execute();
?>

<div class="page">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="card bg-none">
        hello
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-5 col-xs-12">
      <div class="card bg-none">
        <div class="row upSoon" id="upSoon">
          <div style="text-align: center; margin: auto;margin: 46px auto;font-size: 40px;;">
            <i class="fal fa-spinner-third fa-spin"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-7 col-xs-12">
      <div class="card">
        <div class="slides">
          <div id="homeSlides" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#homeSlides" data-slide-to="0" class="active"></li>
            <li data-target="#homeSlides" data-slide-to="1"></li>
            <li data-target="#homeSlides" data-slide-to="2"></li>
            <li data-target="#homeSlides" data-slide-to="3"></li>
            <li data-target="#homeSlides" data-slide-to="4"></li>
            <li data-target="#homeSlides" data-slide-to="5"></li>
          </ol>
          <div class="carousel-inner">
            <!--<div class="carousel-item active">
              <img draggable="false" class="d-block w-100" src="assets/images/welcome.svg">
            </div>-->
            <div class="carousel-item active">
              <a href="Key.Apply" class="web-page"><img draggable="false" class="d-block w-100" src="assets/images/apply.svg">
            </div>
                  <?php
                foreach($stmt as $row) {
                  if ($row['page'] == 1) {
                          ?>
                <div class="carousel-item">
                  <a href="<?php echo $row['url']?>" class="web-page"><img draggable="false" class="d-block w-100" src="<?php echo $row['image']?>"></a>
                </div>

                         <?php
                         } else if ($row['nolink'] == 1) {
                          ?>
                          <div class="carousel-item">
                            <img draggable="false" class="d-block w-100" src="<?php echo $row['image']?>">
                          </div>
                      <?php
                         } else {
                          ?>   
            <div class="carousel-item">
              <a href="<?php echo $row['url']?>" target="_blank"><img class="d-block w-100" draggable="false" src="<?php echo $row['image']?>"></a>
            </div>
                          <?php
                         }
                        }
?>
  <!--          <div class="carousel-item">
              <a href="https://kfm.ooo/smokeyproductions" target="_blank"><img class="d-block w-100" draggable="false" src="https://i.imgur.com/V4c3J9Q.png"></a>
            </div>
            <div class="carousel-item">
              <a href="https://kfm.ooo/global" target="_blank"><img class="d-block w-100" draggable="false" src="https://i.imgur.com/RHYseOl.png"></a>
            </div>
            <div class="carousel-item">
              <a href="https://discord.gg/3VRH6HV" target="_blank"><img class="d-block w-100" draggable="false" src="assets/images/discord.svg"></a>
            </div>
            <div class="carousel-item">
              <a href="https://kfm.ooo/alexa-uk" target="_blank"><img class="d-block w-100" draggable="false" src="assets/images/alexa.png"></a>
            </div>
            <div class="carousel-item">
              <img draggable="false" class="d-block w-100" src="assets/images/social.svg">
            </div>
            <div class="carousel-item">
              <a href="Key.Contact" class="web-page"><img draggable="false" class="d-block w-100" src="assets/images/affiliate.svg"></a>
            </div>-->
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-5 col-xs-12">
      <div class="card bg1">
        <h1 class="card-title">Recently Played</h1>
        <div class="recentTracks" style="height: 280px; overflow: hidden;">
          <ul id="recent" class="loading">
            <li style="margin-top: 80px; font-size: 40px;">
              <i class="fal fa-spinner-third fa-spin"></i>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-7 col-xs-12">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="apply bg4">
              <h1>We want you!</h1>
              <h2>We accept everyone from the best of the best to people brand new to this community, come give it a shot! We accept everyone on their first shot!</h2>
              <a href="Key.Apply" class="web-page"><button class="btn btn-def">Apply</button></a>
            </div>
          </div>
          <div class="card">
            <div id="discord" class="bg2">
              <img draggable="false" src="assets/images/discordWords.svg">
              <div class="count"><span id="discordCount"><i class="fal fa-spinner-third fa-spin"></i></span> online</div>
              <a href="https://discord.gg/3VRH6HV" target="_blank"><button class="btn btn-def">Join Discord</button></a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card changeLog bg-none">
            <h1 class="card-title">Change Log</h1>
            <ul>
              <li><p>Splash page released!</p></li>
              <li><p>Applications</p></li>
              <li><p>Contact Forms</p></li>
              <li><p>Shoutout / Request Line</p></li>
              <li><p>Likes</p></li>
            </ul>
          </div>
          <div class="card ad">
            <div class="adSlides">
              <div id="adSlides" class="adCarousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <a href="https://kfm.ooo/contact" target="_blank"><img class="d-block w-100" draggable="false" src="assets/images/twoquid.svg"></a>
                </div>
                  
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
homepageLoad()
$('.carousel').carousel({
  interval: 10000
});
$('.adCarousel').carousel({
  interval: 15000
});
</script>
