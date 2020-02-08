if (document.addEventListener) {
    window.addEventListener('pageshow', function (event) {
            if (event.persisted || window.performance &&
                window.performance.navigation.type === 2)
            {
                location.reload();
            }
        },
        false);
}

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
    
    let page = 0;
    let Count = 5;
    let nextBottom = document.getElementById("next");
    let preBottom = document.getElementById("pre");
    nextBottom.addEventListener("click", function () {
        page += 1;
        initPost();
    });
    
    preBottom.addEventListener("click", function () {
        if (page !== 0) {
            page -= 1;
            initPost();
        }
    });
    
    function initPost() {
        let data = new FormData();
        data.append('getPostsByPage', page);
        data.append('postCount', Count);
        data.append('token', token.value);
        data.append('dest', imageDest);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request');
        xhr.onload = function () {
            let json = JSON.parse(this.response);
            token.value = json.token;
            if (json.htmlText) {
                posts.innerHTML = json.htmlText;
                if (posts.innerHTML) {
                    nextBottom.hidden = false;
                    preBottom.hidden = false;
                }
            }
            else {
                page = page = 0 ? 0 : page--;
            }
        };
        xhr.send(data);
    }
}
