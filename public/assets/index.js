

var userRating = document.querySelector('.js-user-rating');
var isAuthenticated = userRating.dataset.isAuthenticated;
let musics = userRating.dataset.music;
var musicJson = JSON.parse(musics);
let song;
let audio = document.getElementById("audio");
console.log(musicJson);



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



function recupId($id) {
    var id = $id;
    for (const music of musicJson) {
        if (id == music.id) {
            let song = music.sound;
            console.log(song);
            audio.src = '/uploads/music/' + song;
        }
    }

}













