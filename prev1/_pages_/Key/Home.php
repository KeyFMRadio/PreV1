<?php
include('../../_scripts_/db.php');
$stmt = $conn->prepare("SELECT * FROM banners ORDER BY id");
$stmt->execute();
$stmt2 = $conn->prepare("SELECT * FROM banners ORDER BY id");
$stmt2->execute();
?>
	<div class="page">
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
		</div>
		<div class="row">
			<div class="col-md-8 col-xs-12">
				<div class="card">
					<div class="slides">
						<div class="carousel slide" data-ride="carousel" id="homeSlides">
							<ol class="carousel-indicators">
								<li class="active" data-slide-to="0" data-target="#homeSlides"></li>
								<li data-slide-to="1" data-target="#homeSlides"></li>
								<li data-slide-to="2" data-target="#homeSlides"></li>
								<li data-slide-to="3" data-target="#homeSlides"></li>
								<li data-slide-to="4" data-target="#homeSlides"></li>
								<li data-slide-to="5" data-target="#homeSlides"></li>
							</ol>
							<div class="carousel-inner">
								<!--<div class="carousel-item active">
                    <img draggable="false" class="d-block w-100" src="assets/images/welcome.svg">
                    </div>-->
								<div class="carousel-item active">
									<a class="web-page" href="Key.Apply"><img class="d-block w-100" draggable="false" src="assets/images/apply.svg"></a>
								</div><?php
								                        foreach($stmt as $row) {
								                        if ($row['page'] == 1) {
								                                ?>
								<div class="carousel-item">
									<a class="web-page" href="%3C?php%20echo%20$row['url']?%3E"><img class="d-block w-100" draggable="false" src="%3C?php%20echo%20$row['image']?%3E"></a>
								</div><?php
								                                } else if ($row['nolink'] == 1) {
								                                ?>
								<div class="carousel-item"><img class="d-block w-100" draggable="false" src="%3C?php%20echo%20$row['image']?%3E"></div><?php
								                                } else {
								                                ?>
								<div class="carousel-item">
									<a href="%3C?php%20echo%20$row['url']?%3E" target="_blank"><img class="d-block w-100" draggable="false" src="%3C?php%20echo%20$row['image']?%3E"></a>
								</div><?php
								                                }
								                                }
								        ?><!--          <div class="carousel-item">
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
		<div class="card bg1">
			<h1 class="card-title">Recently Played</h1>
			<div class="recentTracks" style="height: 280px; overflow: hidden;">
				<ul class="loading" id="recent">
					<li style="margin-top: 80px; font-size: 40px;"><i class="fal fa-spinner-third fa-spin"></i></li>
				</ul>
			</div>
		</div>
	</div>