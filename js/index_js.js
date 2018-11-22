
function correctImages() {
    //correct height of images from articles
    var articleImages = document.querySelectorAll('.info-articles img');
    var screenWidth = document.documentElement.clientWidth;

    for (var i = 0; i < articleImages.length; i++) {
        var imgStyle1 = getComputedStyle(articleImages[i]);
        if ((imgStyle1.width < imgStyle1.height) && screenWidth >= 1500) {
            articleImages[i].style.height = '280px';
            articleImages[i].style.width = 'auto';
        }
        if ((imgStyle1.width < imgStyle1.height) && (screenWidth >= 992 && screenWidth < 1200)) {
            articleImages[i].style.height = '220px';
            articleImages[i].style.width = 'auto';
        }
    }
}

window.addEventListener('load', correctImages);


