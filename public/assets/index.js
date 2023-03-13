

var userRating = document.querySelector('.js-user-rating');
var isAuthenticated = userRating.dataset.isAuthenticated;
let musics = userRating.dataset.music;
let idCokkie = userRating.dataset.cookie;
let img = document.querySelectorAll('.img-content');
var musicJson = JSON.parse(musics);
let song;
let audio = document.getElementById("audio");



/// cokiee
function recupId() {
    for (const music of musicJson) {
        if (idCokkie == music.id) {
            let song = music.sound;
            audio.src = '/uploads/music/' + song;
        }
    }
}

// click sur image 
img.forEach(element => {
    element.addEventListener('click', recupId());
});



/// swiper 
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












