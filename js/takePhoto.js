 function clearCanvas(canvas, context) {
     context.save();
     context.setTransform(1, 0, 0, 1, 0, 0);
     context.clearRect(0, 0, canvas.width, canvas.height);
     context.restore();
 }

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
        console.log(image);
        let data = new FormData();
        data.append('imageSrc', image.src);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request', true);
        xhr.onload = function () {
            let canvas2 = document.getElementById('canvas2');
            let context2 = canvas2.getContext('2d');
            let image2 = new Image();
            image2.onload = function()
            {
                clearCanvas(canvas2, context2);
                context2.drawImage(image2, 0, 0);
            };
            image2.src = this.responseText;
        };
        xhr.send(data);
    });
//---------------------------------------------------------------
    document.getElementById("download").addEventListener('click', function () {
        let video2 = document.getElementById('input').files[0];
        let reader = new FileReader();
        let photo = document.getElementById('photo');
        let canvas2 = document.getElementById('canvas2');
        let context2 = canvas2.getContext('2d');
        clearCanvas(canvas2, context2);
        photo.innerHTML = "";
        reader.onloadend = function()
        {
            let data = new FormData();
            data.append('imageSrc', reader.result);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'JS/request', true);
            xhr.onload = function () {
                let image2 = new Image();
                image2.onload = function()
                {
                    if (image2) {
                        context2.drawImage(image2, 0, 0);
                    }
                    else {
                        photo.innerHTML = "wrong image type";
                    }
                };
                console.log(this.responseText);
                if (this.responseText === "wrong image data") {
                    photo.innerHTML = "Wrong image data";
                }
                else {
                    image2.src = this.responseText;
                }
            };
            xhr.send(data);
        };
        if (!video2)
        {
            clearCanvas(canvas2, context2);
            photo.innerHTML = "select file first!!!!!";
        }
        else if (video2.size > 5000000) {
            clearCanvas(canvas2, context2);
            photo.innerHTML = "file too big (5Mb max)";
        }
        else {
            reader.readAsDataURL(video2);
        }
    });