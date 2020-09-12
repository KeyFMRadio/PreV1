<?php
header("Access-Control-Allow-Origin: *");
 ?>
 <style>
  .modal-dialog {
    position: absolute;
    width: 430px;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
  }

  .modal-content {
    background: transparent;
    border: none;
  }

  .modal-header {
    border: none;
    background: #07789a;
  }

  .modal-body {
      transition: all 200ms ease-in-out;
      overflow: hidden;
      background: rgb(233, 233, 224)
  }

  .modal-title {
    color: #fff;
    font-family: sans-serif;
    font-size: 13px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 9px;
    text-transform: capitalize;
    font-weight: 600;
  }
  ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: #292929;
    opacity: 1; /* Firefox */
  }

  :-ms-input-placeholder { /* Internet Explorer 10-11 */
    color: #292929;
  }

  ::-ms-input-placeholder { /* Microsoft Edge */
    color: #292929;
  }
  .modal-header .close {
     position: absolute;
     padding: none !important;
     top: 9px;
     right: 20px;
     color: #fff;
     font-size: 21px;
     border-radius: 2px;
     cursor: pointer;
     height: 22px;
     width: 22px;
 }
 .form-group input {
   width: auto !important;
   position: inherit;
   left: auto;
   position: relative;
   height: 23px;
   background: rgba(255, 255, 255, 1);
   border: rgba(0, 0, 0, 1) 1px solid;
   border-radius: 6px;
   top: auto;
   /* width: 100%; */
   width: 150px !important;
   font-size: 13px;
   padding-left: 4px;
}

.form-group select {
   position: relative;
   height: 23px;
   background: rgba(255, 255, 255, 1);
   border: rgba(0, 0, 0, 1) 1px solid;
   border-radius: 6px;
   width: 150px;
   font-size: 12px;
}

 label {
    display: block;
    font-family: sans-serif;
    font-size: 11px;
    padding-bottom: 0px;
    text-align: left;
    margin-bottom: 0px;
}

 .formSection {
    /* width: 80%; */
    margin: auto;
    text-align: center;
    margin-left: 20px;
    margin-top: 9px;
}

 label {}


   .form-group {
       margin-bottom: 10px;
       width: 100%;
   }

 .cCol {
    width: 33.33%;
    display: inline-block;
    margin: 0 15px;
}

 .cRow {
    text-align: center;
    /* padding-right: 17px; */
    margin-left: -10px;
}

#message {
   width: 305px !important;
   margin-left: 32px;
}
 .modal-header .close {
     padding: 0px;
     border: none;
 }

 .modal-header .close {
     position: absolute;
     padding: none !important;
     top: 19px;
     right: 20px;
     color: #fff;
     font-size: 21px;
     border-radius: 2px;
     cursor: pointer;
 }

 #submit {
   cursor: pointer;
 }

 .modal-header .close img {
   height: 18px;
 }

 .modal-content {
    box-shadow: 0 0 10px #000;
    border: 1.5px solid #000000c7;
 }

  .modal-backdrop {
   z-index: -10;
  }

  #rqmod {
    transition: height 200ms ease-in-out;
  }

  .modal-header {
    cursor: move;
  }
 label {}
  </style>
<div class="modal-dialog animate__animated animate__fadeIn bg7" role="document" style="
     border-radius: 15px;
 ">
   <div id="rqmod" class="modal-content">
     <div class="modal-header" id="modalHeader" style="
     height: 40px;
     border-radius: 3px 3px 0 0;
 ">
       <h1 class="modal-title">Request Line</h1>
       <button type="button" class="close" aria-label="Close">
         <img src="https://retro.keyfm.net/assets/cross.png">
       </button>
     </div>
     <div class="modal-body" style="height: 60px;padding: 20px;border-radius: 0px 0px 5px 5px;">

       <form id="requestLineForm" style="
     margin-top: 0px;
     position: absolute;
     top: 1px;
 " _lpchecked="1">
           <div class="cRow">
             <div class="formSection" style="">
               <div class="cRow">
                 <div class="cCol">
                   <div class="form-group" style="
     /* margin-bottom: 10px; */
 ">
                     <label for="name" style="
     /* display: block; */
 ">Name</label>
                     <input type="text" placeholder="Parker" class="" name="name" id="name" style="background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;);">
                   </div>
                 </div>
                 <div class="cCol">
                   <div class="form-group">
                     <label for="type">Type</label>
                     <select type="text" name="type" id="type">
                       <option value="0" disabled="" selected="">Request Type</option>
                       <option>Song Request</option>
                       <option>Shoutout</option>
                     </select>
                   </div>
                 </div>
               </div>
               <div id="selection" style="height: 185px; overflow: hidden;">
                 <div class="cRow" id="songRequest" style="height: 54px;overflow: hidden;">
                   <div class="cCol">
                     <div class="form-group">
                       <label for="artist">Artist</label>
                       <input type="text" placeholder="Taylor Swift" class="form-control" name="artist" id="artist" style="

     position: inherit;
     left: auto;
     top: auto;
 ">
                     </div>
                   </div>
                   <div class="cCol">
                     <div class="form-group">
                       <label for="song">Song</label>
                       <input type="text" placeholder="Wonderland" class="form-control" name="songName" id="songName">
                     </div>
                   </div>
                 </div>
                 <div class="form-group" style="
     padding-left: 2px;
 ">
                   <label for="song" style="
     padding-left: 34px;
 ">Message</label>
                   <input type="text" placeholder="Your message here.." class="form-control" name="message" id="message" style="

     position: inherit;
     left: auto;
     top: auto;
 ">
                 </div>
                 <div class="form-group submitButton" style="
     text-align: center;
 ">
                   <button type="submit" class="btn btn-success mr-2" id="submit" style="
     text-align: center;
     margin: auto;
     margin-top: 10px;
     /* background: #fff; */
     height: 25px;
     font-family: sans-serif;
     font-size: 13px;
     line-height: 0px;
     background-color: #F3F3F3;
     border: solid 1px #000000;
     border-bottom: solid 2px #000000;
     box-shadow: inset 0 -16px 0 -5px rgba(0 ,0, 0, 0.1);
     padding: 0;
     color: #000;
     width: 200px;
 ">Submit</button>
                 </div>
               </div>
             </div>
           </div>
       </form>
     </div>
   </div>
 </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
 <script>
 $(".close").on("click", function() {
   $("#modalRequest").fadeOut();
   setTimeout(function() {
     $("#modalRequest").remove();
   }, 1000);
   $(".modal-overlay").fadeOut();
   setTimeout(function() {
     $(".modal-overlay").remove();
   }, 1000);
   $(".modal-backdrop").remove();
 });
 $("#type").change(function() {
   var type = $("#type");
   if (type.val() == "Shoutout") {
     $("#songRequest").css("height", "0px");
     $("#selection").css("height", "110px");
     $(".modal-body").css("height", "160px")
     $("#rqmod").css("height", "203px");
   } else {
     $("#selection").css("height", "185px");
     $("#songRequest").css("height", "54px");
     $(".modal-body").css("height", "220px")
     $("#rqmod").css("height", "253px");
   }
 });
 $(function() {  
    $( "#rqmod" ).draggable({
      snap: true,
      cursor: "move",
      handle: '#modalHeader'
    });  
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
       $("#name").css("border-color", "rgb(0, 0, 0)");
       $("#message").css("border-color", "rgb(0, 0, 0)");
       $("#songName").css("border-color", "rgb(0, 0, 0)");
       $("#artist").css("border-color", "rgb(0, 0, 0)");
       if (type == "Shoutout") {
         if (name == null || name == "") {
           $("#name").css("border-color", "rgb(184, 7, 7)");
         }
         if (message == null || message == "") {
           $("#message").css("border-color", "rgb(184, 7, 7)");
         }
         return true;
       } else {
         if (name == null || name == "") {
           $("#name").css("border-color", "rgb(184, 7, 7)");
         }
         if (song == null || song == "") {
           $("#songName").css("border-color", "rgb(184, 7, 7)");
         }
         if (artist == null || artist == "") {
           $("#artist").css("border-color", "rgb(184, 7, 7)");
         }
         return true;
       }

     }

     $.ajax({
         type: 'POST',
         url: 'https://keyfm.net/splash/_scripts_/forms.php?form=request',
         data: formData
     }).done(function(response) {
       console.log(response);
       if (response == 'sent') {
         $("#modalRequest").fadeOut();
         setTimeout(function() {
           $("#modalRequest").remove();
         }, 1000);
         $(".modal-overlay").fadeOut();
         setTimeout(function() {
           $(".modal-overlay").remove();
         }, 1000);
         $(".modal-backdrop").remove();
       } else {
       }
     }).fail(function (response) {
     });
   });
 </script>
