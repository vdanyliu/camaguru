window.onload = photoController;


function photoController() {
    let page = 0;
    let countOfPhotos = 5;
    let space = document.getElementById('Photos');
    let token = document.getElementById('token');
    getPhotoByPage(page);

    document.getElementById("next").addEventListener("click", function () {
        page += 1;
        space.innerHTML = getPhotoByPage(page);
    });

    document.getElementById("pre").addEventListener("click", function () {
        if (page !== 0) {
            page -= 1;
            space.innerHTML = getPhotoByPage(page);
        }
    });


    function getPhotoByPage(page) {
        let data = new FormData();
        data.append('getImagesByNumber', page);
        data.append('token', token.value);
        data.append('countOfPhotos', countOfPhotos);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request', true);
        xhr.onload = function () {
            space.innerHTML = this.response;
        };
        xhr.send(data);
    }
}