
function clearCanvas(canvas, context) {
     context.save();
     context.setTransform(1, 0, 0, 1, 0, 0);
     context.clearRect(0, 0, canvas.width, canvas.height);
     context.restore();
     document.getElementById('postPhoto').disabled = true;
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
    
    var test = true;
    // Trigger photo take
    document.getElementById("snap").addEventListener("click", function () {
        if (test) {
            //context.drawImage(video2, 0, 0, 640, 480);
    
            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');
            let video2 = document.getElementById('video');
            let token = document.getElementById('token');
    
            //document.getElementById('canvas').style.display = 'none';
            context.drawImage(video2, 0, 0);
            let image = new Image();
            image.src = canvas.toDataURL("image/png");
            let data = new FormData();
            data.append('imageSrc', image.src);
            data.append('imagePic', document.getElementById('pic').value);
            data.append('token', token.value);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'JS/request');
            xhr.onload = function () {
                if (this.responseText) {
                    let canvas2 = document.getElementById('canvas2');
                    let context2 = canvas2.getContext('2d');
                    let image2 = new Image();
                    let jsonObj = JSON.parse(this.responseText);
                    token.value = Object.values(jsonObj)[1];
                    image2.onload = function () {
                        clearCanvas(canvas2, context2);
                        context2.drawImage(image2, 0, 0);
                        document.getElementById('postPhoto').disabled = false;
                    };
                    image2.src = Object.values(jsonObj)[0];
                }
                test = true;
            };
            xhr.send(data);
            test = false;
        }
    });
//---------------------------------------------------------------
    document.getElementById("download").addEventListener('click', function () {
        let video2 = document.getElementById('input').files[0];
        let reader = new FileReader();
        let photo = document.getElementById('photo');
        let canvas2 = document.getElementById('canvas2');
        let context2 = canvas2.getContext('2d');
        let token = document.getElementById('token');
        clearCanvas(canvas2, context2);
        photo.innerHTML = "";
        reader.onloadend = function() {
            let data = new FormData();
            data.append('imageSrc', reader.result);
            data.append('imagePic', document.getElementById('pic').value);
            data.append('token', token.value);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'JS/request', true);
            xhr.onload = function () {
                if (this.responseText) {
                    let image2 = new Image();
                    image2.onload = function () {
                        if (image2) {
                            clearCanvas(canvas2, context2);
                            context2.drawImage(image2, 0, 0);
                            document.getElementById('postPhoto').disabled = false;
                        } else {
                            photo.innerHTML = "wrong image type";
                        }
                    };
                    let jsonObj = JSON.parse(this.responseText);
                    token.value = Object.values(jsonObj)[1];
                    if (Object.values(jsonObj)[0] === "wrong image data")
                        photo.innerHTML = "Wrong image data";
                    else
                        image2.src = Object.values(jsonObj)[0];
                }
                else {
                    photo.innerHTML = "wrong image type";
                }
            };
            xhr.send(data);
        };
        if (!video2)
        {
            clearCanvas(canvas2, context2);
            console.log(canvas2);
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

 function picLoad(id) {
     document.getElementById('pic').value = id;
     document.getElementById('snap').disabled = false;
     document.getElementById('download').disabled = false;
     
     let canvas = document.getElementById('preview');
     let token = document.getElementById('token');
     let context = canvas.getContext('2d');
     console.log(token);
     let data = new FormData();
     data.append('getPreImageById', 1);
     data.append('imagePic', document.getElementById('pic').value);
     data.append('token', token.value);
     let xhr = new XMLHttpRequest();
     xhr.open('POST', 'JS/request', true);
     xhr.onload = function () {
         let json = JSON.parse(this.responseText);
         token.value = json.token;
         let image = new Image();
         image.onload = function () {
             clearCanvas(canvas, context);
             context.drawImage(image, 0, 0);
         };
         image.src = json.image;
     };
     xhr.send(data)
     
     
 }

 document.getElementById("postPhoto").addEventListener("click", function () {
    let canvas = document.getElementById('canvas2');
    let token = document.getElementById('token');
    let img = new Image();
    img.src = canvas.toDataURL('img/png');
    let data = new FormData();
    data.append('postUserImage', img.src);
    data.append('token', token.value);
     let xhr = new XMLHttpRequest();
     xhr.open('POST', 'JS/request', true);
     xhr.onload = function () {
         location.reload();
     };
     xhr.send(data);
 });
 
 function deletePost($id) {
     let token = document.getElementById('token');
     let data = new FormData();
     data.append('deletePostByDestPOST', 1);
     data.append('token', token.value);
     data.append('id', $id);
     let xhr = new XMLHttpRequest();
     xhr.open('POST', 'JS/request', true);
     xhr.onload = function () {
         location.reload();
     };
     xhr.send(data);
     
     
 }
 


