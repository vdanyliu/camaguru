<body>
    <div class="postReader">
        <div class="mainImage">
            <?php echo $image.'<br>'; ?>
        </div>
        <div id="like">
        </div>
        <div id="postsView">
            <div id="posts">
            </div>
			<button hidden id = "pre">Back</button>
			<button hidden id = 'next'>Forward</button>
            <div id="addNewPost">
                <input id="userComment" size="20" maxlength="255" type="text" placeholder="Comment" >
                <button id="submitComment">Add Comment</button>
            </div>
        </div>
    </div>
</body>
<script src="/js/postReader.js"></script>