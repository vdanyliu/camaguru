<div>
    <video id="video" width="640" height="480" autoplay></video>
    <button id="snap">Snap Photo</button>
    <canvas id="canvas" width="640" height="480"></canvas>
</div>
<script>
    var video = document.getElementById('video');
    // Get access to the camera!
    if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Not adding `{ audio: true }` since we only want video now
        navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
            //video.src = window.URL.createObjectURL(stream);
            video.srcObject = stream;
            video.play();
        });
    }
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var video2 = document.getElementById('video');

    // Trigger photo take
    document.getElementById("snap").addEventListener("click", function() {
        //context.drawImage(video2, 0, 0, 640, 480);
        context.drawImage(video2, 0, 0);
    });
</script>
<div class="addPhoto">
	<form action="profile/createPhoto" method="post" enctype="multipart/form-data">
		<p>Download image</p>
		<p><input type="file" name="imageFromForm"><input name="submit" type="submit" value="Submit"></p>

	</form>
</div>