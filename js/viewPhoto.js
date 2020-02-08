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

window.onload = photoController;


function photoController() {
    let page = 0;
    let countOfPhotos = 2; // Count of photos per page
    let space = document.getElementById('Photos');
    let token = document.getElementById('token');
    getPhotoByPage();

    document.getElementById("next").addEventListener("click", function () {
        page += 1;
        getPhotoByPage();
    });

    document.getElementById("pre").addEventListener("click", function () {
        if (page !== 0) {
            page -= 1;
            getPhotoByPage();
        }
    });


    function getPhotoByPage() {
        let data = new FormData();
        data.append('getImagesByNumber', page);
        data.append('token', token.value);
        data.append('countOfPhotos', countOfPhotos);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'JS/request', true);
        xhr.onload = function () {
            let json = JSON.parse(this.response);
            token.value = json.token;
            if (json.img) {
                space.innerHTML = json.img;
            }
            else {
                page = page = 0 ? 0 : page--;
            }
        };
        xhr.send(data);
    }
}