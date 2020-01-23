<div>
    <video id="video" width="640" height="480" autoplay></video>
    <canvas id="canvas" width="640" height="480" hidden="true"></canvas>
    <canvas id="canvas2" width="640" height="480"></canvas>
    <div id="photo"></div>
</div>
<div class="addPhoto">
    <div class="PhotoDownload">
        <input type="file" id ='input' name="imageFromForm">
		<input id="pic">
        <button disabled id="snap">Snap Photo</button>
        <button disabled id="download">Download photo</button>
    </div>
	<div class="selectPhoto">
		<?php echo $photos ?>
	</div>
</div>
<script src="/js/takePhoto.js"></script>