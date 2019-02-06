// Canvas & Filters 
var video = document.getElementById('videoElement');
var filter = 'none'; 
var canvas = document.getElementById("canvas");
var canvas_tree = document.getElementById("canvas_tree");
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
var videoWidth, videoHeight;
var form_filter = document.getElementById('filter');

// Changes class of selected tree
var header = document.getElementById("div_choose_trees");
var i_trees = header.getElementsByClassName("i_trees");
for (var i = 0; i < i_trees.length; i++) {
  i_trees[i].addEventListener("click", function() {
    active_photo = document.getElementsByClassName("active");
    active_photo[0].className = active_photo[0].className.replace(" active", "");
    this.className += " active";
    overlay_image.src = this.src;
  });
}

// Return currently selected tree
function treeSelector() {
    var header = document.getElementById("div_choose_trees");
    var selected_tree = header.getElementsByClassName("active");
    return selected_tree[0];
}

// Delete Photo

function deletePic(clickedId) {
    
    if (confirm('Are you sure you want to delete this photo from your Camagreen ?')) {
        var id_to_delete = document.getElementById("id_photo_delete");
        id_to_delete.value = clickedId;
        document.getElementById("photo_delete").submit();
    }
}

function createImg() {
    var canvas = document.getElementById('canvas_copy');
    document.getElementById('inp_img').value = canvas.toDataURL();
 }

navigator.mediaDevices.getUserMedia({ audio: false, video: true })
.then(function(stream) {
    video.srcObject = stream;
    video.onloadedmetadata = function() {
        snap.disabled = false;
        videoWidth = video.videoWidth;
        videoHeight = video.videoHeight;
        canvas.width  = videoWidth;
        canvas.height = videoHeight;
        canvas_copy.width  = videoWidth;
        canvas_copy.height = videoHeight;
        video.play();
        snap.onclick = function() {
      
            upload.disabled = false;
            var current_tree = treeSelector();
            document.getElementById('tree').value = current_tree.src;
            canvas.getContext('2d').drawImage(video, 0, 0, videoWidth, videoHeight, 0, 0, videoWidth, videoHeight);
            canvas.getContext('2d').drawImage(current_tree, 0, 0, videoWidth, videoHeight, 0, 0, videoWidth, videoHeight);
            canvas_copy.getContext('2d').drawImage(video, 0, 0, videoWidth, videoHeight, 0, 0, videoWidth, videoHeight);
            final_image.style.display = "block";
        }
    };
})
.catch(function(err) {
  console.log(err.name + ": " + err.message);
});