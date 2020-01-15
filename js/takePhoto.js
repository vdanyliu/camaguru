 var video = document.getElementById('video');
    // Get access to the camera!
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Not adding `{ audio: true }` since we only want video now
        navigator.mediaDevices.getUserMedia({video: true}).then(function (stream) {
            //video.src = window.URL.createObjectURL(stream);
            video.srcObject = stream;
            video.play();
        });
    }
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var video2 = document.getElementById('video');

    // Trigger photo take
    document.getElementById("snap").addEventListener("click", function () {
        //context.drawImage(video2, 0, 0, 640, 480);

        let canvas = document.getElementById('canvas');
        let context = canvas.getContext('2d');
        let video2 = document.getElementById('video');

        //document.getElementById('canvas').style.display = 'none';
        context.drawImage(video2, 0, 0);
        let image = new Image();
        image.src = canvas.toDataURL("image/png");
        let data = new FormData();
        data.append('imageSrc', image.src);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request', true);
        xhr.onload = function () {
            console.log(this.responseText);
            //document.body.innerHTML = "";
            //document.write(this.responseText);
            let photo = document.getElementById('photo');
            photo.innerHTML = this.responseText;
        };
        xhr.send(data);
    });
 //
//  var video = document.getElementById('video');
//  // Get access to the camera!
//  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
//      // Not adding `{ audio: true }` since we only want video now
//      navigator.mediaDevices.getUserMedia({video: true}).then(function (stream) {
//          //video.src = window.URL.createObjectURL(stream);
//          video.srcObject = stream;
//          video.play();
//      });
//  }
//  var canvas = document.getElementById('canvas');
//  var context = canvas.getContext('2d');
//  var video2 = document.getElementById('video');
// // video.hidden = true;
// // canvas.hidden = true;
//
//  // Trigger photo take
// // document.getElementById("snap").addEventListener("click", function () {
//      //context.drawImage(video2, 0, 0, 640, 480);
//  function videoToImage() {
//      let canvas = document.getElementById('canvas');
//      let context = canvas.getContext('2d');
//      let video2 = document.getElementById('video');
//
//      //document.getElementById('canvas').style.display = 'none';
//      context.drawImage(video2, 0, 0);
//      let image = new Image();
//      image.src = canvas.toDataURL("image/png");
//      let data = new FormData();
//      data.append('imageSrc', image.src);
//      let xhr = new XMLHttpRequest();
//      xhr.open('POST', 'JS/request', true);
//      xhr.onload = function () {
//          console.log(this.responseText);
//          //document.body.innerHTML = "";
//          //document.write(this.responseText);
//          let photo = document.getElementById('photo');
//          photo.innerHTML = this.responseText;
//      };
//      xhr.send(data);
//  }
//  setInterval(videoToImage, 500);
 //});
//---------------------------------------------------------------
    document.getElementById("download").addEventListener('click', function () {
        let canvas = document.getElementById('canvas');
        let context = canvas.getContext('2d');
        let video2 = document.getElementById('input').files[0];
        let reader = new FileReader();
        let image = new Image();
        let photo = document.getElementById('photo');
        reader.onloadend = function()
        {
            let data = new FormData();
            let file = reader.result;
            data.append('imageSrc', reader.result);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'JS/request', true);
            xhr.onload = function () {
                //console.log(this.responseText);
                //document.body.innerHTML = "";
                //document.write(this.responseText);
                photo.innerHTML = this.responseText;
            };
            xhr.send(data);
        };
        if (!video2)
        {
            photo.innerHTML = "select file first!!!!!";
        }
        else if (video2.size > 5000000) {
            photo.innerHTML = "file too big (5Mb max)";
        }
        else {
            reader.readAsDataURL(video2);
        }
    });