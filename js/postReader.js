window.onload = pageController;

function pageController() {
    let likeTag = document.getElementById('like');
    let token = document.getElementById('token');
    let imageDest = new URL(location.href).searchParams.get('dest');
    initLike();
    //let commentsTag = document.getElementById('comments');
    let like = document.getElementById('likeBottom');
    likeTag.addEventListener("click", userClickLike);














    function initLike() {
    let data = new FormData();
        data.append('getLikes', imageDest);
        data.append('token', token.value);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request', true);
        xhr.onload = function () {
            let json = JSON.parse(this.response);
            token.value = json.token;
            likeTag.innerHTML = json.likeImg + json.likes;
        };
        xhr.send(data);
    }

    function userClickLike() {
        let data = new FormData();
        data.append('userLike', imageDest);
        data.append('token', token.value);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request', true);
        xhr.onload = function () {
            let json = JSON.parse(this.response);
            token.value = json.token;
            initLike();
        };
        xhr.send(data);
    }
}
