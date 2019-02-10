// Canvas & Filters 
var video = document.getElementById('videoElement');
var canvas = document.getElementById("canvas");
var canvas_masks = document.getElementById("canvas_masks");
var canvas_copy = document.getElementById("canvas_copy");
var overlay_image = document.getElementById("overlay");
var final_image = document.getElementById("modal_result");

// Closing modal
window.onclick = function(event) {
    if (event.target == final_image) {
        final_image.style.display = "none";
    }
}

// Buttons

var snap = document.getElementById('snap');

// Hidden forms
var ctx = canvas.getContext('2d');

// Changes class of selected masks
var header = document.getElementById("div_choose_masks");
var i_masks = header.getElementsByClassName("i_masks");
for (var i = 0; i < i_masks.length; i++) {
  i_masks[i].addEventListener("click", function() {
    active_photo = document.getElementsByClassName("active");
    active_photo[0].className = active_photo[0].className.replace(" active", "");
    this.className += " active";
    overlay_image.src = this.src;
  });
}

// Return currently selected masks
function masksSelector() {
    var header = document.getElementById("div_choose_masks");
    var selected_masks = header.getElementsByClassName("active");
    return selected_masks[0];
}

// Delete Photo

/*function deletePic(clickedId) {
    
    if (confirm('Are you sure you want to delete this photo from your Camagreen ?')) {
        var id_to_delete = document.getElementById("id_photo_delete");
        id_to_delete.value = clickedId;
        document.getElementById("photo_delete").submit();
    }
}*/

function createImg() {
    var canvas = document.getElementById('canvas_copy');
    document.getElementById('inp_img').value = canvas.toDataURL();
 }

navigator.mediaDevices.getUserMedia({ audio: false, video: true })
.then(function(stream) {
    video.srcObject = stream;
    video.onloadedmetadata = function() {
        snap.disabled = false;
        video.play();
        snap.onclick = function() {
      
            upload.disabled = false;
            var current_masks = masksSelector();
            document.getElementById('masks').value = current_masks.src;
            canvas.getContext('2d').drawImage(video, -30, 0, 375, 300);
            canvas.getContext('2d').drawImage(current_masks, 0, 0, 300, 300);
            canvas_copy.getContext('2d').drawImage(video, -30, 0, 375, 300);
            final_image.style.display = "block";
        }
    };
})
.catch(function(err) {
  console.log(err.name + ": " + err.message);
});