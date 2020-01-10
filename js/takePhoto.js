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

        context.drawImage(video2, 0, 0);
        var image = new Image();
        image.src = canvas.toDataURL("image/png");
        var data = new FormData();
        data.append('imageSrc', image.src);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'profile/createPhoto', true);
        xhr.onload = function () {
            console.log(this.responseText);
            document.body.innerHTML = "";
            document.write(this.responseText);
        };
        xhr.send(data);
    });