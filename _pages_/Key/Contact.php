<div class="back">
  <a href="Key.Home" class="web-page">
    <i class="fal fa-long-arrow-left"></i><p>Back Home</p>
  </a>
</div>
<h1 class="page-title">Contact Us</h1>
<div class="page contentPage">
  <form id="contact">
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
                  <label for="value">Inquiry Topic</label>
                  <input type="text" placeholder="Affiliate Inquiry" class="form-control" name="topic" id="topic">
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
                  <label for="value">Response Method</label>
                  <select type="text" class="form-control" name="method" id="method">
                    <option>Discord</option>
                    <option>Email</option>
                    <option>Skype</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="value">Response Details</label>
                  <input type="text" class="form-control" placeholder="Parker#5915" name="details" id="details">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card bg3 formSection">
            <h1>Details</h1>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="value">Message</label>
                  <textarea rows="5" placeholder="Your message here.." type="text" class="form-control" name="message" id="message"></textarea>
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
var form = $('#contact');
$(form).submit(function(event) {
    var error = false;
    var errorMessage = '';
    event.preventDefault();
    console.log("Submitted");
    var formData = $(form).serialize();
    var name = $('#name').val();
    var topic = $('#topic').val();
    var details = $('#details').val();
    var message = $('#message').val();
    if (name == "" || name == null || topic == "" || topic == null || details == "" || details == null || message == "" || message == null) {
      error = true;
      errorMessage = 'Please fill in all fields';
    }

    if (error) {
      newNotify('Whoops!', errorMessage, 'error', 'exclamation-triangle', 5000);
      return true;
    }

    $.ajax({
        type: 'POST',
        url: '_scripts_/forms.php?form=contact',
        data: formData
    }).done(function(response) {
      console.log(response);
      if (response == 'sent') {
        newNotify('Success!', 'Your inquiry has been sent, we will try to get back to you ASAP!', 'success', 'check', 5000);
        urlRoute.loadPage('Key.Home');
      } else {
        newNotify('Awkward..', 'An unknown error occured..', 'error', 'exclamation-triangle', 5000);
      }
    }).fail(function (response) {
        newNotify('Awkward..', 'An unknown error occured..', 'error', 'exclamation-triangle', 5000);
    });
  });
</script>
