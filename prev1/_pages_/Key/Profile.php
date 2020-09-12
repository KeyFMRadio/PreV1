<?php
include('../../_scripts_/db.php');
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $ip = $_SERVER['REMOTE_ADDR'];
}
if ($ip !== '77.97.217.142' && $ip !== '2601:647:5680:8fc0:a80b:f939:1f5b:9078' && $ip !== '1.42.89.65') {
  ?>
    <script>
      urlRoute.loadPage("Key.Home");
      newNotify('Page not found', 'This page does not exist', 'error', 'map-marker-slash', 5000);
    </script>
  <?php
  exit();
}
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$img = null;
if ($row['avatarURL'] == null || $row['avatarURL'] == '') {
  $img = 'https://keyfm.net/splash/assets/images/square.png';
} else {
  $img = "https://staff.keyfm.net/profilePictures/" . $row['avatarURL'];
}
?>
<style>
.profilePage {
    top: 40px;
    left: 50%;
    width: 1072px;
    text-align: center;
    border: none !important;
    position: absolute;
    transform: translateX(-50%);
    padding: 0 20px;
}
.pPic {
    height: 130px;
    border-radius: 100%;
    width: 130px;
}
.pName {
  color: #fff;
  font-size: 50px;
  font-family: Jaldi;
  font-weight: 600;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}
.pPicWrap {
  text-align: right;
}
.back {
  z-index: 500;
}
</style>
<div class="back">
  <a href="Key.Home" class="web-page">
    <i class="fal fa-long-arrow-left"></i><p>Back Home</p>
  </a>
</div>
<div class="profilePage contentPage">
  <div class="profile">
    <div class="row">
      <div class="col-md-6 col-sm-12 pPicWrap">
        <img class="pPic" src="<?php echo $img ?>">
      </div>
      <div class="col-md-6 col-sm-12">
        <h1 class="pName"><?php echo $row['username'] ?></h1>
      </div>
    </div>
  </div>
</div>
