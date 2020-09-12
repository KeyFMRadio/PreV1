<?php
session_set_cookie_params(0, '/', '.keyfm.net');
session_start();
$staff = false;
$verified = false;
if ($_SESSION['loggedIn'] !== null) {
  $staff = true;
  $verified = true;
  $username = $_SESSION['loggedIn']['username'];
}
 ?>
 <style>
 .form-control:disabled, .form-control[readonly] {
     background-color: rgba(187, 187, 187, 0.36);
     opacity: 1;
 }
 </style>
<div class="modal-dialog animate__animated animate__fadeIn bg7" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title">Request Line</h1>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-times" aria-hidden="true"></i>
      </button>
    </div>
    <div class="modal-body">

      <form id="requestLineForm">
          <div class="row">
            <div class="formSection" style="width: 100%">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="hidden" value="<?php echo $verified?>" name="verified" id="verified">
                    <?php
                      if ($staff) {
                        ?>
                          <input readonly type="text" value="<?php echo $username?>" class="form-control" name="name" id="name">
                        <?php
                      } else {
                        ?>
                          <input type="text" placeholder="Parker" class="form-control" name="name" id="name">
                        <?php
                      }
                     ?>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label for="type">Type</label>
                    <select type="text" class="form-control" name="type" id="type">
                      <option value="0" disabled selected>Request Type</option>
                      <option>Song Request</option>
                      <option>Shoutout</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="selection" style="height: 0px; overflow: hidden;">
                <div class="row" id="songRequest" style="height: 0px; overflow: hidden;">
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="artist">Artist</label>
                      <input type="text" placeholder="Taylor Swift" class="form-control" name="artist" id="artist">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="song">Song</label>
                      <input type="text" placeholder="Wonderland" class="form-control" name="songName" id="songName">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="song">Message</label>
                  <input type="text" placeholder="Your message here.." class="form-control" name="message" id="message">
                </div>
                <div class="form-group submitButton">
                  <button type="submit" class="btn btn-success mr-2" id="submit">Submit</button>
                </div>
              </div>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
<script>
$("#type").change(function() {
  var type = $("#type");
  if (type.val() == "Shoutout") {
    $("#songRequest").css("height", "0px");
    $("#selection").css("height", "110px");
  } else {
    $("#selection").css("height", "185px");
    $("#songRequest").css("height", "74px");
  }
});
var form = $('#requestLineForm');
$(form).submit(function(event) {
    var error = false;
    var errorMessage = '';
    event.preventDefault();
    console.log("Submitted");
    var formData = $(form).serialize();
    var name = $('#name').val();
    var type = $('#type').val();
    var artist = $('#artist').val();
    var song = $('#songName').val();
    var message = $('#message').val();
    if (type == "Shoutout") {
      if (name == null || name == "" || message == null || message == "") {
        error = true;
        errorMessage = 'Please fill in all fields';
      }
    } else {
      if (name == null || name == "" || artist == null || artist == "" || song == null || song == "") {
        error = true;
        errorMessage = 'Please fill in all fields';
      }
    }
    if (error) {
      newNotify('Whoops!', errorMessage, 'error', 'exclamation-triangle', 5000);
      return true;
    }

    $.ajax({
        type: 'POST',
        url: '_scripts_/forms.php?form=request',
        data: formData
    }).done(function(response) {
      console.log(response);
      if (response == 'sent') {
        if (type == "Shoutout") {
          newNotify('Success!', 'Your shoutout has been sent! Stay tuned to hear it!', 'success', 'check', 5000);
        } else {
          newNotify('Success!', 'Your request has been sent! Stay tuned to hear your request', 'success', 'check', 5000);
        }
        $("#modalrequestLine").remove();
        $(".modal-backdrop").remove();
      } else {
        newNotify('Awkward..', 'An unknown error occured..', 'error', 'exclamation-triangle', 5000);
      }
    }).fail(function (response) {
        newNotify('Awkward..', 'An unknown error occured..', 'error', 'exclamation-triangle', 5000);
    });
  });
</script>
