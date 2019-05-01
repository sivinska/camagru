var imageLoader = document.getElementById('imageLoader');
imageLoader.addEventListener('change', handleImage);
var canvas = document.getElementById('canvas_img');
var ctx = canvas.getContext('2d');


function handleImage(e) {
    var reader = new FileReader();
    reader.onload = function(event) {
        var img = new Image();
        img.onload = function() {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);

        }
        img.src = event.target.result;
        document.getElementById("save").style.display = "block";
    }
    reader.readAsDataURL(e.target.files[0]);

}


(function() {

    var

        cover = document.querySelector('#cover'),
        canvas = document.querySelector('#canvas'),
        photo = document.querySelector('#photo'),
        startbutton = document.querySelector('#save');


    var overlay_image = document.getElementById("overlay");
    var header = document.getElementById("choose_masks");
    var mask = header.getElementsByClassName("mask");

    // Return currently selected masks
    function maskSelector() {
        var header = document.getElementById("choose_masks");
        var selected_mask = header.getElementsByClassName("active");
        return selected_mask[0];
    }


    for (var i = 0; i < mask.length; i++) {
        mask[i].addEventListener("click", function() {
            active_photo = document.getElementsByClassName("active");
            active_photo[0].className = active_photo[0].className.replace(" active", "");
            this.className += " active";
            overlay_image.src = this.src;
        });
    }


    var pic = document.getElementById('canvas_img');
    pic.onload = function() {
        var but = document.getElementById("save");
        but.style.display = "block";
    }

    function takepicture() {

        var current_mask = maskSelector();
        var uploaded_img = document.getElementById('canvas_img');
        var image = document.getElementById("copy");
        document.getElementById('mask').value = current_mask.src;
        document.getElementById("snapshot").value = image.toDataURL();
        canvas.getContext('2d').drawImage(uploaded_img, 0, 0, 305, 305);
        canvas.getContext('2d').drawImage(current_mask, 0, 0, 300, 300);
        image.getContext('2d').drawImage(uploaded_img, 0, 0, 300, 300);

    }

    startbutton.addEventListener('click', function(ev) {
        takepicture();
        ev.preventDefault();
    }, false);

})();


var php_file = 'save_image.php';
var save_image = document.getElementById('copy');

function maskSelector() {
    var header = document.getElementById("choose_masks");
    var selected_mask = header.getElementsByClassName("active");
    return selected_mask[0];
}
var save_mask = maskSelector();
var mask = document.getElementById('mask').value;


function ajaxSend(data, php, via, callback) {
    var ob_ajax = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    var str_data = '';
    for (var k in data) {
        str_data += k + '=' + data[k].replace(/\?/g, '?').replace(/=/g, '=').replace(/&/g, '&').replace(/[ ]+/g, ' ') + '&'
    }
    str_data = str_data.replace(/&$/, ''); //delete ending &

    //send data to php
    ob_ajax.open(via, php, true);
    ob_ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    ob_ajax.send(str_data);
    ob_ajax.onreadystatechange = function() {
        if (ob_ajax.readyState == 4) callback(ob_ajax.responseText);
    }
}

var btn_cnvimg = document.getElementById('save');
btn_cnvimg.addEventListener('click', function(e) {
    mask = document.getElementById('mask').value;
    var img_data = {
        'cnvimg': save_image.toDataURL('image/png', 1.0),
        'mask': mask,
    };
    ajaxSend(img_data, php_file, 'post', function(resp) {

    });
});