

var userRating = document.querySelector('.js-user-rating');
var isAuthenticated = userRating.dataset.isAuthenticated;
let musics = userRating.dataset.music;
let aa = userRating.dataset.cookie;
let img = document.querySelectorAll('.img-content');
console.log(aa);
var musicJson = JSON.parse(musics);
let song;
let audio = document.getElementById("audio");
console.log(img);



img.forEach(element => {
    element.addEventListener('click', recupId());
});


function recupId() {
    console.log(aa);
    for (const music of musicJson) {
        if (aa == music.id) {
            let song = music.sound;
            console.log(song);
            audio.src = '/uploads/music/' + song;
        }
    }
}


var swiper = new Swiper('.swiper', {
    slidesPerView: 3,
    direction: getDirection(),
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    on: {
        resize: function () {
            swiper.changeDirection(getDirection());
        },
    },
});
function getDirection() {
    var windowWidth = window.innerWidth;
    var direction = window.innerWidth <= 760 ? 'vertical' : 'horizontal';

    return direction;
}


var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        let donnes = JSON.parse(xhr.response);
        Object.entries(donnes.results).forEach(element => {
            console.log(element[1].overview);
        })
    }
};

xhr.open('GET', "https://api.themoviedb.org/3/search/movie?api_key=8111705f6e396ba3cd2e501a17915090&query=Jack+Reacher", true);
xhr.send();












