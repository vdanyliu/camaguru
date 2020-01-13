<div>
    <video id="video" width="640" height="480" autoplay></video>
    <button id="snap">Snap Photo</button>
    <button id="download">Download photo</button>
    <canvas id="canvas" width="640" height="480"></canvas>
    <div id="photo"></div>
</div>
<script src="/js/takePhoto.js"></script>
<div class="addPhoto">
	<form action="profile/createPhoto" method="post" enctype="multipart/form-data">
		<p>Download image</p>
		<p><input type="file" id ='input' name="imageFromForm">
            <input name="submit" type="submit" value="Submit"></p>
	</form>
</div>