<?php
session_set_cookie_params(0, '/', '.keyfm.net');
session_start();
$staff = false;
if ($_SESSION['loggedIn'] !== null) {
  $staff = true;
  $username = $_SESSION['loggedIn']['username'];
}
?>
<div class="back">
  <a href="Key.Home" class="web-page">
    <i class="fal fa-long-arrow-left"></i><p>Back Home</p>
  </a>
</div>
<h1 class="page-title">Join Our Team</h1>
<div class="page contentPage">
  <?php
  if ($staff) {
    ?>
    <form id="apply">
        <div class="row">


          <div class="col-12">
            <div class="card bg3 formSection">
              <h1>You can't apply if you are already staff!</h1>

            </div>
          </div>
        </div>
    </form>
    <?php
    exit();
  }
  ?>
  <form id="apply">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="card bg5 formSection">
            <h1>General Info</h1>
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="value">Name</label>
                  <input type="text" placeholder="Parker" class="form-control" name="name" id="name">
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="value">Age</label>
                  <input type="text" placeholder="18" class="form-control" name="age" id="age">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="card bg6 formSection">
            <h1>Contact Info</h1>
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="value">Discord</label>
                  <input type="text" class="form-control" placeholder="Parker#5915" name="disc" id="disc">
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="value">Region</label>
                  <select type="text" class="form-control" name="region" id="region">
                    <option>EU</option>
                    <option>NA</option>
                    <option>OC</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card bg3 formSection">
            <h1>Application Details</h1>
            <div class="row">
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="value">Which role are you applying for?</label>
                  <select type="text" class="form-control" name="role" id="role">
                    <option>Radio DJ</option>
                    <option>Media Producer</option>
                    <option>Graphics Designer</option>
                    <option disabled>News Reporter</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="value">Do you have a microphone?</label>
                  <select type="text" class="form-control" name="microphone" id="microphone">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="value">Do you currently work for a radio?</label>
                  <select type="text" class="form-control" name="radio" id="radio">
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="value">Why do you want to join KeyFM?</label>
                  <textarea style="resize: none;" rows="5" placeholder="Please be descriptive as to why you'd like to work here.." type="text" class="form-control" name="why" id="why"></textarea>
                </div>
                <div class="form-group submitButton">
                  <button type="submit" class="btn btn-success mr-2" id="submit">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </form>
</div>
<script>
var form = $('#apply');
$(form).submit(function(event) {
    var error = false;
    var errorMessage = '';
    event.preventDefault();
    console.log("Submitted");
    var formData = $(form).serialize();
    var name = $('#name').val();
    var age = $('#age').val();
    var discord = $('#disc').val();
    var region = $('#region').val();
    var role = $('#role').val();
    var mic = $('#mic').val();
    var work = $('#work').val();
    var why = $('#why').val();
    if (name == "" || name == null || age == "" || age == null || discord == "" || discord == null || why == "" || why == null) {
      error = true;
      errorMessage = 'Please fill in all fields';
    }

    if (error) {
      newNotify('Whoops!', errorMessage, 'error', 'exclamation-triangle', 5000);
      return true;
    }

    $.ajax({
        type: 'POST',
        url: '_scripts_/forms.php?form=application',
        data: formData
    }).done(function(response) {
      console.log(response);
      if (response == 'sent') {
        newNotify('Success!', 'Your application has been sent! Good luck!', 'success', 'heart', 5000);
        urlRoute.loadPage('Key.Home');
      } else if (response == 'duplicate') {
        newNotify('Whoops!', "You've already submitted an application! Please wait for that one to be proccessed before submitting another one.", 'error', 'exclamation-triangle', 5000);
      } else {
        newNotify('Awkward..', 'An unknown error occured..', 'error', 'exclamation-triangle', 5000);
      }
    }).fail(function (response) {
        newNotify('Awkward..', 'An unknown error occured..', 'error', 'exclamation-triangle', 5000);
    });
  });
</script>
