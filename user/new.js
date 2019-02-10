(function() {

var cnv = document.getElementById('canvas');  //Replace 'cnv1' with your canvas ID
var php_file ='save_image.php';  //address of php file that get and save image on server

/* Ajax Function
 Send "data" to "php", using the method added to "via", and pass response to "callback" function
 data - object with data to send, name:value; ex.: {"name1":"val1", "name2":"2"}
 php - address of the php file where data is send
 via - request method, a string: 'post', or 'get'
 callback - function called to proccess the server response
*/
function ajaxSend(data, php, via, callback) {
  var ob_ajax =  (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');  //XMLHttpRequest object

  //put data from 'data' into a string to be send to 'php'
  var str_data ='';
  for(var k in data) {
    str_data += k +'='+ data[k].replace(/\?/g, '?').replace(/=/g, '=').replace(/&/g, '&').replace(/[ ]+/g, ' ') +'&'
  }
  str_data = str_data.replace(/&$/, '');  //delete ending &

  //send data to php
  ob_ajax.open(via, php, true);
  if(via =='post') ob_ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  ob_ajax.send(str_data);

  //check the state request, if completed, pass the response to callback function
  ob_ajax.onreadystatechange = function(){
    if (ob_ajax.readyState == 4) callback(ob_ajax.responseText);
  }
}

//register click on #btn_cnvimg to get and save image
var btn_cnvimg = document.getElementById('startbutton');
if(btn_cnvimg) btn_cnvimg.addEventListener('click', function(e){
  var imgname = window.prompt('Set a name for the image.\n- If you set a name that already exists,\n the image will be replaced with current canvas-image\n\nLeave empty to let the script set an unique name.', '');

  if(imgname !== null){
    //set data that will be send with ajaxSend() to php (base64 PNG image-data of the canvas, and image-name)
    var img_data = {'cnvimg':cnv.toDataURL('image/png', 1.0), 'imgname':imgname};

    //send image-data to php file
    ajaxSend(img_data, php_file, 'post', function(resp){
      //show server response in #ajaxresp, if not exist, alert response
      if(document.getElementById('ajaxresp')) document.getElementById('ajaxresp').innerHTML = resp;
      else alert(resp);
    });
  }
});




    var streaming = false,
        video        = document.querySelector('#video'),
        cover        = document.querySelector('#cover'),
        canvas       = document.querySelector('#canvas'),
        photo        = document.querySelector('#photo'),
        startbutton  = document.querySelector('#startbutton');
        
 
        navigator.mediaDevices.getUserMedia({ audio:false, video: {width: 600, height: 600}   }).then(mediaStream => {
          video.srcObject = mediaStream
           video.onloadedmetadata = function(e) {
           video.play();
         };
      },
      function(err) {
        console.log("An error occured! " + err);
      }
    );
  
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
  

    video.addEventListener('canplay', function(ev){
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
      document.getElementsByClassName('mask').value = current_mask.src;
      canvas.getContext('2d').drawImage(video, 0, 0, 300, 300);
      canvas.getContext('2d').drawImage(current_mask, 0, 0, 300, 300);
      var data = canvas.toDataURL('image/png');
      
     }
  
    startbutton.addEventListener('click', function(ev){
        takepicture();
      ev.preventDefault();
    }, false);
  
  })();