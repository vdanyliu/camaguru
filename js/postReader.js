window.onload = pageController;

function pageController() {
    let userName = document.getElementById('userName');
    let likeTag = document.getElementById('like');
    let token = document.getElementById('token');
    let imageDest = new URL(location.href).searchParams.get('dest');
    let posts = document.getElementById('posts');
    initLike(function () {
        initPost();
    });
    //let commentsField = document.getElementById('comments');
    
    likeTag.addEventListener("click", userClickLike);
    //initPost();
    let addPostBottom = document.getElementById('submitComment');
    addPostBottom.addEventListener("click", addPost);




    

    function initLike(callback) {
    let data = new FormData();
        data.append('getLikes', imageDest);
        data.append('token', token.value);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request');
        xhr.onload = function () {
            let json = JSON.parse(this.response);
            token.value = json.token;
            likeTag.innerHTML = json.likeImg + json.likes;
            if (callback)
                callback();
        };
        xhr.send(data);
    }

    function userClickLike() {
        if (!userName) {
            alert("REGISTER FIRST");
            return 0;
        }
        let data = new FormData();
        data.append('userLike', imageDest);
        data.append('token', token.value);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request');
        xhr.onload = function () {
            let json = JSON.parse(this.response);
            token.value = json.token;
            initLike();
        };
        xhr.send(data);
    }

    function addPost() {
        let input = document.getElementById('userComment');
        if (!userName){
            alert("REGISTER FIRST");
            return 0;
        }
        if (input.value === '') {
            alert("Empty comment field");
            return 0;
        }
        let data = new FormData();
        data.append('addComment', input.value);
        data.append('token', token.value);
        data.append('dest', imageDest);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request');
        xhr.onload = function () {
            let json = JSON.parse(this.response);
            token.value = json.token;
            input.value = '';
            initPost();
        };
        xhr.send(data);
    }
    
    function initPost() {
        initPost.page = 0;
        initPost.Count = 5;
        let data = new FormData();
        data.append('getPostsByPage', initPost.page);
        data.append('postCount', initPost.Count);
        data.append('token', token.value);
        data.append('dest', imageDest);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request');
        xhr.onload = function () {
            let json = JSON.parse(this.response);
            console.log(json);
            token.value = json.token;
            posts.innerHTML = json.htmlText;
        };
        xhr.send(data);
    }
}
