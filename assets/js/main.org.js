/* Init */

var ppIcon = $("#control");
var playing = false;
var initial = false;
var firstLoad = true;
var allowingAutoplay = true;
var autoRefresh = null;
var radioURL = "https://radio.keyfm.net/";
var audio = $("#radio")[0];
var volume = $("#volume");
var volumeSlider = $("#volume")[0];
var notifs = [];

var hidden = $("#below");
var player = $("#player");
var like = $("#likeButton");
var likeIcon = $("#like");
var topDiv = $("#top");
var playButton = $("#playButton");
var request = $("#requestButton");

var profile = $("#profileImg");
var djField = $("#dj");
var songField = $("#song");
var saysField = $("#says");
var profileLink = $("#profileLink");

var autoDJ = null;
var dj = null;
var djPic = null;
var now_playing = null;
var djSays = null;
var loadingPlayed = false;
var firstLoadPlayed = true;
var lastPlayed = [];
var nnl = null;

var likedCurrentDJ = false;
var currentLikeCount = 0;

window.onload = function() {
  adjustVolume(0.5);
  firstPlay();
  checkLike();
  startAutoRefresh();
  fetchStats();
  setInterval(fetchStats, 2000);
  fetchLastPlayed();
  setInterval(fetchLastPlayed, 5000);
  likeCount();
  setInterval(likeCount, 5000)
  updateDiscord();
  setInterval(updateDiscord, 120000)
  nowNextLater();
  setInterval(nowNextLater, 5000)
}

/* General Functions */

function newNotify(header, text, type, icon, delay, name) {
  if (delay == false) {
    notifs[name] = new PNotify({
      title: header,
      text: text,
      icon: 'fal fa-' + icon,
      type: type,
      hide: false,
      buttons: {
          closer: false,
          sticker: false
      }
    });
  } else {
   new PNotify({
      title: header,
      text: text,
      icon: 'fal fa-' + icon,
      type: type,
      delay: delay
    });
  }
  return "sent";
}

function fetchLastPlayed() {
    $.ajax({
        type: 'GET',
        url: '_scripts_/stats.php?specific=past5'
    }).done(function(response) {
        var songs = JSON.parse(response);
        if (firstLoadPlayed && loadingPlayed == false) {
          loadingPlayed = true;
          (function() {
              var onSong = 0;

              function loadSongs() {
                  if (onSong < 5) {
                    let song = songs[onSong];
                    $.ajax({
                      type: 'GET',
                      dataType: 'jsonp',
                      headers: {
                        'Access-Control-Allow-Origin': '*'
                      },
                      url: 'https://api.deezer.com/search/track/autocomplete?limit=1&q=' + song + '&output=jsonp'
                    }).done(function(resp) {
                      console.log(resp.data[0]);
                      let img;
                      if (resp.data[0] == null) {
                        console.log("SET TO NULL");
                        img = 'assets/images/squareNB.png';
                      } else {
                        if (resp.data[0].album.cover == null) {
                          console.log("SET TO NULL 2");
                          img = 'assets/images/squareNB.png';
                        } else {
                          img = resp.data[0].album.cover;
                        }
                      }
                      if (img == null || img == undefined) {
                        console.log("SET TO NULL 3");
                        img = 'assets/images/squareNB.png';
                      }
                      lastPlayed.push({
                        img: img,
                        name: song
                      });
                      onSong += 1;
                      loadSongs();
                      img = null;
                    });
                  } else {
                    firstLoadPlayed = false;
                    loadingPlayed = false;
                    updateRecentlyPlayed();
                  }
              }
              loadSongs();

          })();
          return;
        }
        if (lastPlayed.length < 5) return;
        if (songs[0] !== lastPlayed[0].name && loadingPlayed == false) {
          lastPlayed.pop();
          $.ajax({
            type: 'GET',
            dataType: 'jsonp',
            headers: {
              'Access-Control-Allow-Origin': '*'
            },
            url: 'https://api.deezer.com/search/track/autocomplete?limit=1&q=' + songs[0] + '&output=jsonp'
          }).done(function(resp) {
            let img;
            console.log(resp.data[0]);
            if (resp.data[0] == null) {
              console.log("SET TO NULL");
              img = 'assets/images/squareNB.png';
            } else {
              if (resp.data[0].album.cover == null) {
                console.log("SET TO NULL 2");
                img = 'assets/images/squareNB.png';
              } else {
                img = resp.data[0].album.cover;
              }
            }
            if (img == null || img == undefined) {
              console.log("SET TO NULL 3");
              img = 'assets/images/squareNB.png';
            }
            lastPlayed.unshift({
              img: img,
              name: songs[0]
            });
            updateRecentlyPlayed();
            img = null;
          });
        }
    });
}

function homepageLoad() {
  let recent = $("#recent");
  updateDiscord();
  nnl = null;
  nowNextLater();
  if (recent.hasClass('loading')) {
    recent.html(`
      <li>
        <div class="track">
          <img draggable="false" src="${lastPlayed[0].img}" alt="">
          <div class="trackName">
            <h1>${lastPlayed[0].name}</h1>
          </div>
        </div>
      </li>
      <li>
        <div class="track">
          <img draggable="false" src="${lastPlayed[1].img}" alt="">
          <div class="trackName">
            <h1>${lastPlayed[1].name}</h1>
          </div>
        </div>
      </li>
      <li>
        <div class="track">
          <img draggable="false" src="${lastPlayed[2].img}" alt="">
          <div class="trackName">
            <h1>${lastPlayed[2].name}</h1>
          </div>
        </div>
      </li>
      <li>
        <div class="track">
          <img draggable="false" src="${lastPlayed[3].img}" alt="">
          <div class="trackName">
            <h1>${lastPlayed[3].name}</h1>
          </div>
        </div>
      </li>
      <li>
        <div class="track">
          <img draggable="false" src="${lastPlayed[4].img}" alt="">
          <div class="trackName">
            <h1>${lastPlayed[4].name}</h1>
          </div>
        </div>
      </li>
      `);
    recent.removeClass('loading');
  }
}

function updateRecentlyPlayed() {
  if (urlRoute.currentUrl == "https://keyfm.net/splash/_pages_/Key/Home.php?Key") {
    let recent = $("#recent");
    if (recent.hasClass('loading')) {
      recent.html(`
        <li>
          <div class="track">
            <img draggable="false" src="${lastPlayed[0].img}" alt="">
            <div class="trackName">
              <h1>${lastPlayed[0].name}</h1>
            </div>
          </div>
        </li>
        <li>
          <div class="track">
            <img draggable="false" src="${lastPlayed[1].img}" alt="">
            <div class="trackName">
              <h1>${lastPlayed[1].name}</h1>
            </div>
          </div>
        </li>
        <li>
          <div class="track">
            <img draggable="false" src="${lastPlayed[2].img}" alt="">
            <div class="trackName">
              <h1>${lastPlayed[2].name}</h1>
            </div>
          </div>
        </li>
        <li>
          <div class="track">
            <img draggable="false" src="${lastPlayed[3].img}" alt="">
            <div class="trackName">
              <h1>${lastPlayed[3].name}</h1>
            </div>
          </div>
        </li>
        <li>
          <div class="track">
            <img draggable="false" src="${lastPlayed[4].img}" alt="">
            <div class="trackName">
              <h1>${lastPlayed[4].name}</h1>
            </div>
          </div>
        </li>
        `);
      recent.removeClass('loading');
    } else {
      var li = $(`<li style="margin-top: -50px;">
        <div class="track">
          <img draggable="false" src="${lastPlayed[0].img}" alt="">
          <div class="trackName">
            <h1>${lastPlayed[0].name}</h1>
          </div>
        </div>
      </li>`);
      recent.prepend(li);
      li.animate({'margin-top': '0px'});
      $('#recent li').each(function () {
          var li = $(this);

          if (li.position().top >= 240){
            li.remove();
          }
      });
    }
  }
}

function updateDiscord() {
  if (urlRoute.currentUrl == "https://keyfm.net/splash/_pages_/Key/Home.php?Key") {
    $.ajax({
        type: 'GET',
        url: 'https://discordapp.com/api/guilds/704843392911409184/widget.json'
    }).done(function(response) {
        $("#discordCount").html(response.presence_count);
    }).fail(function (response) {
       console.log('error');
    });
  }
}

function nowNextLater() {
  if (urlRoute.currentUrl == "https://keyfm.net/splash/_pages_/Key/Home.php?Key") {
    $.ajax({
        type: 'GET',
        url: 'https://api.keyfm.net/upnext'
    }).done(function(response) {
        if (nnl == null) {
          nnl = response
          $("#upSoon").html(`
            <div class="col-4">
              <div class="time" id="now">
                <h1>Now</h1>
                <img draggable="false" src="${nnl.now.avatar}" onerror="this.src='assets/images/square.png'">
                <p>${nnl.now.name}</p>
              </div>
            </div>
            <div class="col-4">
              <div class="time" id="next">
                <h1>Next</h1>
                <img draggable="false" src="${nnl.next.avatar}" onerror="this.src='assets/images/square.png'">
                <p>${nnl.next.name}</p>
              </div>
            </div>
            <div class="col-4">
              <div class="time" id="later">
                <h1>Later</h1>
                <img draggable="false" src="${nnl.later.avatar}" onerror="this.src='assets/images/square.png'">
                <p>${nnl.later.name}</p>
              </div>
            </div>
            `);
        } else {
          var newStats = response
          if (nnl.now.name !== newStats.now.name) {
            $("#now").html(`
                  <h1>Now</h1>
                  <img draggable="false" src="${newStats.now.avatar}" onerror="this.src='assets/images/square.png'">
                  <p>${newStats.now.name}</p>`);
          }
          if (nnl.now.name !== newStats.next.name) {
            $("#next").html(`
                  <h1>Next</h1>
                  <img draggable="false" src="${newStats.next.avatar}" onerror="this.src='assets/images/square.png'">
                  <p>${newStats.next.name}</p>`);
          }
          if (nnl.now.name !== newStats.later.name) {
            $("#later").html(`
                  <h1>Later</h1>
                  <img draggable="false" src="${newStats.later.avatar}" onerror="this.src='assets/images/square.png'">
                  <p>${newStats.later.name}</p>`);
          }
          nnl = newStats;
      }
    }).fail(function (response) {
       console.log('error');
    });
  }
}

function fetchStats() {
  if (playing || firstLoad) {
    if (firstLoad) {
      firstLoad = false;
    }
    $.ajax({
        type: 'GET',
        url: '_scripts_/stats.php'
    }).done(function(response) {
      if (response == 0) {
        autoDJ = null;
        dj = null;
        djPic = "assets/images/square.png";
        now_playing = null;
        djSays = null;
        djID = null;
        profileImg.src = "assets/images/square.png";
        djField.html("<p class='error'>Reconnecting..</p>");
        songField.html("<div class='marquee error'><span>Reconnecting..</span></div>");
        saysField.html("<div class='marquee error'><span>Reconnnecting..</span></div>");
        return true;
      } else {
        var stats = JSON.parse(response);

        if (autoDJ == stats.autoDJ) {
          if (autoDJ) {
            if (now_playing !== stats.now_playing || djSays !== stats.djSays)  {
              autoDJ = stats.autoDJ;
              now_playing = stats.now_playing;
              djSays = stats.djSays;
              djPic = "assets/images/square.png";
              djID = null
              updateStats();
            }
          } else {
            if (dj !== stats.dj.name) {
              checkLike();
            }
            if (now_playing !== stats.now_playing || djSays !== stats.dj.djSays || dj !== stats.dj.name || djPic !== stats.dj.avatar)  {
              now_playing = stats.now_playing;
              dj = stats.dj.name
              djSays = stats.dj.djSays;
              djID = stats.dj.id;
              if (stats.dj.avatar == null || stats.dj.avatar == "") {
                djPic = "assets/images/square.png";
              } else {
                djPic = stats.dj.avatar;
              }
              updateStats();
            }
          }
        } else {
          checkLike();
          if (stats.autoDJ) {
            autoDJ = stats.autoDJ;
            now_playing = stats.now_playing;
            djSays = stats.djSays;
            djPic = "assets/images/square.png";
          } else {
            autoDJ = stats.autoDJ;
            now_playing = stats.now_playing;
            dj = stats.dj.name
            djSays = stats.dj.djSays;
            djPic = stats.dj.avatar;
            djID = stats.dj.id;
          }
          updateStats();
        }
      }
    });
  }
}

function updateStats() {
  fetchLastPlayed();
  if (autoDJ) {
    if (now_playing.length >= 23) {
      var playingMarquee = "moving";
    }
    if (djSays.length >= 23) {
      var djSaysMarquee = "moving";
    }
    profileImg.src = djPic;
    djField.html(`<p>Auto DJ</p>`);
    songField.html(`<div class='marquee ${playingMarquee}'><span>${now_playing}</span></div>`);
    saysField.html(``);
    profileLink.attr('href', 'Key.Home');
    if (djSays !== "none") {
      saysField.html(`
        <div class="stat">
          <div class="marquee ${djSaysMarquee}">
            <span>${djSays}</span>
          </div>
        </div>
        <div class="carrot"></div>`);
        topDiv.removeClass('noSays');
    } else {
      saysField.html(``);
      topDiv.addClass('noSays');
    }
  } else {
    if (now_playing.length >= 23) {
      var playingMarquee = "moving";
    }
    if (djSays.length >= 23) {
      var djSaysMarquee = "moving";
    }
    if (playing) {
      profileImg.src = djPic;
    }
    djField.html(`<p>${dj}</p>`);
    profileLink.attr('href', 'Key.Profile?id=' + djID);
    if (now_playing == "Error loading song") {
      songField.html(`<div class='marquee ${playingMarquee}'><span class="error">${now_playing}</span></div>`);
    } else {
      songField.html(`<div class='marquee ${playingMarquee}'><span>${now_playing}</span></div>`);
    }
    if (djSays !== "none") {
      saysField.html(`
        <div class="stat">
          <div class="marquee ${djSaysMarquee}">
            <span>${djSays}</span>
          </div>
        </div>
        <div class="carrot"></div>`);
        topDiv.removeClass('noSays');
    } else {
      saysField.html(``);
      topDiv.addClass('noSays');
    }
  }
}

function adjustVolume(volume) {
  $('#radio').prop("volume", volume);
}

function startAutoRefresh() {
  clearInterval(autoRefresh);
  autoRefresh = null;
  audio.ontimeupdate = function () {
      var date = new Date();
      currentStreamTime = date.getTime()
  };
  var warned = false;
  autoRefresh = setInterval(function () {
    if (playing) {
      var currentDate = new Date();
      var difference = currentDate.getTime() - currentStreamTime;
      if (audio.src !== radioURL || audio.paused || audio.ended || difference > 5000) {
        audio.src = "";
        pause();
        ppIcon.removeClass('fa-pause');
        ppIcon.addClass('fa-spin');
        ppIcon.addClass('fa-spinner-third');
        audio.src = radioURL;
        audio.play().then(function () {
          play();
          ppIcon.removeClass('fa-spin');
          ppIcon.removeClass('fa-spinner-third');
          ppIcon.addClass('fa-pause');
          startAutoRefresh();
          audio.volume = 0.5;
          playing = true;
          if (notifs.connectionError !== undefined) {
            notifs.connectionError.remove();
            notifs.connnectionError = null;
          }
        }).catch(function (e) {
          if (notifs.connectionError == undefined) {
            newNotify('Connection Error', 'We are currently having trouble connecting you to the radio, trying again..', 'danger', 'exclamation-triangle', false, 'connectionError');
          }
        });
      }
    }
  }, 2000);
}

function pause() {
  player.addClass('paused');
  like.addClass('paused');
  request.addClass('paused');
  hidden.addClass('paused');
  topDiv.addClass('paused');
  djField.addClass('paused');
}

function play() {
  player.removeClass('paused');
  djField.removeClass('paused');
  topDiv.removeClass('paused');
  like.removeClass('paused');
  request.removeClass('paused');
  hidden.removeClass('paused');
  if (djPic !== "assets/images/square.png") {
    profileImg.src = djPic;
  }
}

function firstPlay() {
  audio.play().then(function () {
    toggleMusic();
    initial = true;
    document.removeEventListener('click', startRadioInit);
  });
}

function toggleMusic() {
  if (playing) {
    ppIcon.removeClass('fa-pause');
    ppIcon.parent().removeClass('alt');
    ppIcon.addClass('fa-play');
    pause();
    audio.volume = 0;
    playing = false;
    profileImg.src = "assets/images/square.png";
  } else {
    if (audio.src != radioURL) {
      ppIcon.removeClass('fa-play');
      ppIcon.parent().addClass('alt');
      ppIcon.addClass('fa-spinner-third');
      ppIcon.addClass('fa-spin');
      audio.src = radioURL;
      audio.volume = volumeSlider.value;
      audio.play().then(function () {
        play();
        ppIcon.removeClass('fa-spin');
        ppIcon.removeClass('fa-spinner-third');
        ppIcon.addClass('fa-pause');
        startAutoRefresh();
        playing = true;
      });
    } else {
      ppIcon.removeClass('fa-play');
      ppIcon.parent().addClass('alt');
      ppIcon.addClass('fa-spinner-third');
      ppIcon.addClass('fa-spin');
      audio.play().then(function () {
        setTimeout(function () {
          audio.volume = volumeSlider.value;
          play();
          ppIcon.removeClass('fa-spin');
          ppIcon.removeClass('fa-spinner-third');
          ppIcon.addClass('fa-pause');
          playing = true;
        }, 1000);
      });
    }
  }
}

function checkLike() {
  $.ajax({
      type: 'GET',
      url: '_scripts_/like.php?check=true'
  }).done(function(response) {
    if (response == 1) {
      like.addClass("liked");
      likeIcon.addClass('fas');
      likeIcon.removeClass('fal');
      likedCurrentDJ = true;
    } else {
      resetLike();
    }
  });
}

function likeCount() {
  $.ajax({
      type: 'GET',
      url: '_scripts_/like.php?count=true'
  }).done(function(response) {
    if (response !== currentLikeCount) {
      currentLikeCount = response;
      $("#likeCount").html(currentLikeCount);
      if (response == 0) {
        resetLike();
      }
    }
  });
}

function likeDJ() {
  if (autoDJ) {
    newNotify('Whoops!', 'You cannot give the Auto DJ a like!', 'error', 'exclamation-triangle', 5000);
    return;
  }
  if (!likedCurrentDJ) {
    $.ajax({
        type: 'GET',
        url: '_scripts_/like.php'
    }).done(function(response) {
      if (response == 1) {
        like.addClass("liking");
        setTimeout(function() {
          likeIcon.addClass('fas');
          like.addClass("liked");
          var newLikeCount = parseInt(currentLikeCount) + 1;
          $("#likeCount").html(newLikeCount);
        }, 375);
        setTimeout(function () {
          like.removeClass("liking");
          like.removeClass("fal");
        }, 1000);
        likedCurrentDJ = true;
        newNotify('Thanks!', 'Your like has been sent!', 'success', 'heart fas', 5000);
      } else if (response == 0) {
        like.addClass("liked");
        likeIcon.addClass('fas');
        likeIcon.removeClass('fal');
        likedCurrentDJ = true;
        newNotify('Whoops!', 'You have already liked the current DJ in the past hour!', 'error', 'exclamation-triangle', 5000);
      } else {
        newNotify('Whoops!', 'An error occured, please contact an Admin+', 'error', 'exclamation-triangle', 5000);
      }
    });
  } else {
    newNotify('Whoops!', 'You have already liked the current DJ in the past hour!', 'error', 'exclamation-triangle', 5000);
  }
}

function resetLike() {
  like.removeClass("liked");
  likeIcon.removeClass('fas');
  likeIcon.addClass('fal');
  likedCurrentDJ = false;
}

/* Events */

playButton.on("click", function() {
  if (initial) {
    toggleMusic();
  }
});

like.on("click", function() {
  likeDJ();
});

$("body").on("hidden.bs.modal", ".modal", function () {
    $(this).delay(1).queue(function () {
        $(this).data("bs.modal", null).remove()
    })
});

$(document).on("click", '\[data-toggle="loadModal"\]', function (event) {
  if ($(this).attr("url") == "_modals_/request.php") {
    if (!playing) {
      return true;
    }
    if (autoDJ) {
      newNotify('Please Note', 'There is not currently a DJ live so your request or shoutout will not be seen until there is a DJ live.', 'danger', 'exclamation-triangle', 7000);
    }
  }
  event.preventDefault();
  $("#modal" + $(this).attr("id")).remove();
  var url = $(this).attr("url");
  var newModal = $('<div class="modal" id="modal' + $(this).attr("id") + '"><div class="modal-body"></div></div>');
  $("body").append(newModal);
  newModal.modal();
  newModal.load(url);
});

volumeSlider.oninput = function() {
  audio.volume = volumeSlider.value;
};

/* Auto Start */

document.addEventListener('click', startRadioInit);
function startRadioInit() {
    toggleMusic();
    initial = true;
    document.removeEventListener('click', startRadioInit);
}
