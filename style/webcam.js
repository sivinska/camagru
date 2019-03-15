(function() {
    var streaming = false,
        video = document.querySelector('#video'),
        canvas = document.querySelector('#canvas');

    navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 600, height: 600 } }).then(mediaStream => {
            video.srcObject = mediaStream
            video.onloadedmetadata = function(e) {
                video.play();
                var but = document.getElementById("save");
                but.style.display = "block";
            };
        },
        function(err) {
            console.log("An error occured! " + err);
        });


    var overlay_image = document.getElementById("overlay");
    var header = document.getElementById("choose_masks");
    var mask = header.getElementsByClassName("mask");

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


    video.addEventListener('canplay', function(ev) {
        if (!streaming) {
            video.setAttribute('width', 600);
            video.setAttribute('height', 600);
            canvas.setAttribute('width', 300);
            canvas.setAttribute('height', 300);

            streaming = true;
        }
    }, false);

    function takepicture() {
        var current_mask = maskSelector();
        var image = document.getElementById("copy");
        document.getElementById('mask').value = current_mask.src;
        document.getElementById("snapshot").value = image.toDataURL();
        canvas.getContext('2d').drawImage(video, 0, 0, 300, 300);
        canvas.getContext('2d').drawImage(current_mask, 0, 0, 300, 300);
        image.getContext('2d').drawImage(video, 0, 0, 300, 300);
    }

    save.addEventListener('click', function(ev) {


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
    console.log(img_data);
    ajaxSend(img_data, php_file, 'post', function(resp) {

    });
});
//});